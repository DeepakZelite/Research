<?php

use Vanguard\Events\User\RequestedPasswordResetEmail;
use Vanguard\User;
use Mockery as m;

class PasswordControllerTest extends FunctionalTestCase
{
    use MailTrap;

    public function test_send_password_reminder()
    {
        $user = factory(User::class)->create(['email' => 'test@test.com']);

        $this->expectsEvents(RequestedPasswordResetEmail::class);

        $this->visit('password/remind')
            ->type('test@test.com', 'email')
            ->press('Reset Password')
            ->seePageIs('password/remind')
            ->see('Password reset email sent. Check your inbox (and spam) folder.');

        $message = $this->fetchInbox()[0];

        $token = DB::table('password_resets')
            ->where('email', $user->email)
            ->first()->token;

        $this->assertEquals('test@test.com', $message['to_email']);
        $this->assertEquals(config('mail.from.address'), $message['from_email']);
        $this->assertEquals(config('mail.from.name'), $message['from_name']);
        $this->assertEquals(
            view('emails.password.remind', compact('token'))->render(),
            trim($message['html_body'])
        );

        $this->emptyInbox();
    }

    public function test_password_reminder_with_wrong_email()
    {
        $this->visit('password/remind')
            ->type('test@test.com', 'email')
            ->press('Reset Password')
            ->seePageIs('password/remind')
            ->see('The selected email is invalid.');
    }

    public function test_password_reset()
    {
        $user = factory(User::class)->create(['email' => 'test@test.com']);

        $token = str_random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now()
        ]);

        $this->resetPassword($token, $user->email);

        $this->seePageIs('login')
            ->see('Your password has been reset!');

        $user = $user->fresh();

        $this->assertTrue(Hash::check('123123', $user->password));
    }

    public function test_password_reset_with_expired_token()
    {
        $user = factory(User::class)->create(['email' => 'test@test.com']);

        $token = str_random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now()->subHours(2)
        ]);

        $this->resetPassword($token, $user->email);

        $this->seePageIs("password/reset/{$token}")
            ->see("This password reset token is invalid.");
    }

    public function test_password_reset_with_invalid_email()
    {
        $user = factory(User::class)->create(['email' => 'test@test.com']);

        $token = str_random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now()
        ]);

        $this->resetPassword($token, 'foo@bar.com');

        $this->seePageIs("password/reset/{$token}")
            ->see("We can't find a user with that e-mail address.");
    }

    /**
     * @param $token
     * @param $email
     */
    private function resetPassword($token, $email)
    {
        $this->visit("password/reset/{$token}")
            ->type($email, 'email')
            ->type('123123', 'password')
            ->type('123123', 'password_confirmation')
            ->press('Update Password');
    }
}
