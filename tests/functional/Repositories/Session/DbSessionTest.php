<?php

use Carbon\Carbon;
use Mockery as m;
use Vanguard\Repositories\Session\DbSession;
use Vanguard\User;

class DbSessionTest extends FunctionalTestCase
{
    /**
     * @var DbSession
     */
    protected $repo;

    protected $seed = false;

    public function setUp()
    {
        parent::setUp();
        $this->repo = app(DbSession::class);
    }

    public function test_getUserSessions()
    {
        $user = factory(User::class)->create();

        Carbon::setTestNow(Carbon::now());

        $data1 = $this->getSessionStubData($user);
        $data2 = $this->getSessionStubData($user);

        DB::table('sessions')->insert($data1);
        DB::table('sessions')->insert($data2);

        $expected = [
            (object) array_except($data1, ['payload', 'user_id']),
            (object) array_except($data2, ['payload', 'user_id']),
        ];

        $this->assertEquals($expected, $this->repo->getUserSessions($user->id));
    }

    public function test_invalidateUserSession()
    {
        $user = factory(User::class)->create([
            'remember_token' => str_random(60)
        ]);

        $data = $this->getSessionStubData($user);
        DB::table('sessions')->insert($data);

        $this->repo->invalidateUserSession($user->id, $data['id']);

        $this->dontSeeInDatabase('sessions', $data)
            ->seeInDatabase('users', ['remember_token' => null]);
    }

    private function getSessionStubData($user)
    {
        $faker = app(Faker\Generator::class);

        return [
            'id' => str_random(),
            'user_id' => $user->id,
            'ip_address' => $faker->ipv4,
            'user_agent' => $faker->userAgent,
            'payload' => 'foo',
            'last_activity' => Carbon::now()->toDateTimeString()
        ];
    }
}
