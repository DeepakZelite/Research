<?php


use Vanguard\Events\User\LoggedIn;
use Vanguard\Events\User\Registered;
use Vanguard\Role;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;
use Mockery as m;

class AuthControllerTest extends FunctionalTestCase
{
    use MailTrap;

    public function test_login()
    {
        factory(User::class)->create(['username' => 'foo', 'password' => 'bar']);

        $this->loginUser('foo', 'bar')
            ->seePageIs('/');
    }

    public function test_login_with_wrong_credentials()
    {
        $this->loginUser('foo', 'bar')
            ->seePageIs('login')
            ->see("These credentials do not match our records.");
    }

    public function test_throttling()
    {
        Settings::set('throttle_enabled', true);
        Settings::set('throttle_attempts', 3);
        Settings::set('throttle_lockout_time', 2); // 2 minutes

        for ($i = 0; $i < 3; $i++) {
            $this->loginUser('foo', 'bar');
        }

        $this->loginUser('foo', 'bar')
            ->seePageIs('login')
            ->see("Too many login attempts. Please try again in 120 seconds.");
    }

    public function test_login_with_remember()
    {
        $user = factory(User::class)->create([
            'username' => 'foo',
            'password' => 'bar',
            'last_login' => null,
            'remember_token' => null
        ]);

        Settings::set('remember_me', false);

        $this->visit('login')
            ->dontSeeElement('#remember');

        Settings::set('remember_me', true);

        $this->visit('login')
            ->seeElement('#remember')
            ->loginUser('foo', 'bar', true)
            ->seePageIs('/');

        $user = $user->fresh();

        $this->assertNotNull($user->remember_token);
        $this->assertNotNull($user->last_login);
    }

    public function test_banned_user_cannot_log_in()
    {
        factory(User::class)->create([
            'username' => 'foo',
            'password' => 'bar',
            'status' => UserStatus::BANNED
        ]);

        $this->loginUser('foo', 'bar');

        $this->seePageIs('login')
            ->see("Your account is banned by administrator.");
    }

    public function test_unconfirmed_user_cannot_login()
    {
        factory(User::class)->create([
            'username' => 'foo',
            'password' => 'bar',
            'status' => UserStatus::UNCONFIRMED
        ]);

        $this->loginUser('foo', 'bar');

        $this->seePageIs('login')
            ->see("Please confirm your email address first.");
    }

    /**
     * @expectedException Illuminate\Foundation\Testing\HttpException
     */
    public function test_registration_view()
    {
        Settings::set('reg_enabled', false);

        $this->visit('login')
            ->dontSee('You don\'t have an account?');

        // This should fire HttpException since registration is disabled.
        $this->visit('register');
    }

    public function test_registration_with_email_confirmation()
    {
        $this->expectsEvents(Registered::class);

        Settings::set('reg_enabled', true);
        Settings::set('reg_email_confirmation', true);

        $data = $this->getRegistrationFormStubData();

        $this->registerUser($data);

        $expected = array_except($data, ['password', 'password_confirmation', 'tos']);
        $expected += ['status' => UserStatus::UNCONFIRMED];

        $this->seePageIs('login')
            ->see('You account is created successfully! Please confirm your email in order to log in.')
            ->seeInDatabase('users', $expected);

        $token = User::where('email', $data['email'])->first()->confirmation_token;

        $message = $this->fetchInbox()[0];

        $this->assertEquals('test@test.com', $message['to_email']);
        $this->assertEquals(config('mail.from.address'), $message['from_email']);
        $this->assertEquals(config('mail.from.name'), $message['from_name']);
        $this->assertEquals(
            view('emails.registration.confirmation', compact('token'))->render(),
            trim($message['html_body'])
        );

        $this->emptyInbox();
    }

    public function test_registration_without_email_confirmation()
    {
        $this->expectsEvents(Registered::class);

        Settings::set('reg_enabled', true);
        Settings::set('reg_email_confirmation', false);
        Settings::set('notifications_signup_email', false);

        $data = $this->getRegistrationFormStubData();
        $this->registerUser($data);

        $expected = array_except($data, ['password', 'password_confirmation', 'tos']);
        $expected += ['status' => UserStatus::ACTIVE];

        $this->seePageIs('login')
            ->see('You account is created successfully! You can log in now.')
            ->seeInDatabase('users', $expected);

        $this->assertEmpty($this->fetchInbox());
    }

    public function test_email_notification_when_new_user_was_registered()
    {
        $admin1 = factory(User::class)->create(['email' => 'john.doe@test.com']);
        $admin2 = factory(User::class)->create(['email' => 'jane.doe@test.com']);
        $user = factory(User::class)->create(['email' => 'user.doe@test.com']);

        $role = Role::where('name', 'Admin')->first();
        $role->users()->attach([$admin1->id, $admin2->id]);

        $role = Role::where('name', 'User')->first();
        $role->users()->attach($user->id);

        Settings::set('reg_enabled', true);
        Settings::set('reg_email_confirmation', false);
        Settings::set('notifications_signup_email', true);

        $data = $this->getRegistrationFormStubData();
        $this->registerUser($data);

        $newUser = User::where('email', $data['email'])->first();

        $inbox = $this->fetchInbox();

        $this->assertEquals(2, count($inbox));

        $this->assertEquals('New User Registration', $inbox[0]['subject']);
        $this->assertEquals('jane.doe@test.com', $inbox[0]['to_email']);
        $this->assertEquals(
            view('emails.notifications.new-registration', ['user' => $admin2, 'newUser' => $newUser])->render(),
            trim($inbox[0]['html_body'])
        );

        $this->assertEquals('New User Registration', $inbox[1]['subject']);
        $this->assertEquals('john.doe@test.com', $inbox[1]['to_email']);
        $this->assertEquals(
            view('emails.notifications.new-registration', ['user' => $admin1, 'newUser' => $newUser])->render(),
            trim($inbox[1]['html_body'])
        );

        $this->emptyInbox();
    }

    public function test_redirect_to_custom_page_after_login()
    {
        $to = '?to=http://www.google.com';

        factory(User::class)->create(['username' => 'foo', 'password' => 'bar']);

        $this->visit('login' . $to)
            ->seeElement('input[type=hidden][name=to]')
            ->type('foo', 'username')
            ->type('bar', 'password')
            ->press('Log In');

        $this->seePageIs('http://www.google.com');
    }

    public function test_custom_redirect_page_is_available_after_failed_login_attempt()
    {
        $to = 'http://www.google.com';
        $element = 'input[type=hidden][name=to]';

        $this->visit('login?to=' . $to)
            ->seeElement($element)
            ->type('foo', 'username')
            ->type('bar', 'password')
            ->press('Log In');

        $this->seePageIs('login?to=' . urlencode($to))
            ->seeElement($element);
    }

    public function test_access_to_auth_pages_is_not_allowed_after_authentication()
    {
        factory(User::class)->create(['username' => 'foo', 'password' => 'bar']);
        $this->loginUser('foo', 'bar');

        $forbiddenGetRoutes = [
            'login', 'register', 'register/confirmation/123', 'password/remind', 'password/reset/123',
            'auth/two-factor-authentication', 'auth/facebook/login', 'auth/facebook/callback',
            'auth/twitter/email'
        ];

        foreach ($forbiddenGetRoutes as $route) {
            $this->visit($route)
                ->seePageIs('/');
        }
    }

    private function getRegistrationFormStubData()
    {
        return [
            'email' => 'test@test.com',
            'username' => 'johndoe',
            'password' => '123123',
            'password_confirmation' => '123123',
            'tos' => 1
        ];
    }

    private function registerUser($data)
    {
        return $this->visit('login')
            ->click("Don't have an account?")
            ->seePageIs('register')
            ->submitForm('Register', $data);
    }

    /**
     * @param $username
     * @param $password
     * @param bool $remember
     * @return $this
     */
    private function loginUser($username, $password, $remember = false)
    {
        $this->visit('login')
            ->type($username, 'username')
            ->type($password, 'password');

        if ($remember) {
            $this->check('remember');
        }

        $this->press('Log In');

        return $this;
    }

    public function test_login_with_2fa_enabled()
    {
        $currentSetting = Settings::get('2fa.enabled');
        Settings::set('2fa.enabled', true);
        Settings::save();

        $this->refreshAppAndExecuteCallbacks();

        $this->expectsEvents(LoggedIn::class);

        $user = factory(User::class)->create(['username' => 'foo', 'password' => 'bar']);

        Authy::shouldReceive('isEnabled')->andReturn(true);
        Authy::shouldReceive('tokenIsValid')->with(m::any(), '123')->andReturn(true);

        $this->loginUser('foo', 'bar')
            ->seePageIs('auth/two-factor-authentication')
            ->seeInSession('auth.2fa.id', $user->id);

        $this->type('123', 'token')
            ->press('Validate')
            ->seePageIs('/');

        Settings::set('2fa.enabled', $currentSetting);
        Settings::save();
    }

    public function test_login_with_wrong_2fa_token()
    {
        $currentSetting = Settings::get('2fa.enabled');
        Settings::set('2fa.enabled', true);
        Settings::save();

        $this->refreshAppAndExecuteCallbacks();

        $user = factory(User::class)->create(['username' => 'foo', 'password' => 'bar']);

        Authy::shouldReceive('isEnabled')->andReturn(true);
        Authy::shouldReceive('tokenIsValid')->with(m::any(), '123')->andReturn(false);

        $this->loginUser('foo', 'bar')
            ->seePageIs('auth/two-factor-authentication')
            ->seeInSession('auth.2fa.id', $user->id);

        $this->type('123', 'token')
            ->press('Validate')
            ->seePageIs('login')
            ->see('2FA Token is invalid!');

        Settings::set('2fa.enabled', $currentSetting);
        Settings::save();
    }


}
