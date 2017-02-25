<?php

namespace Vanguard\Repositories\Session;

use Vanguard\Repositories\User\UserRepository;
use DB;

class DbSession implements SessionRepository
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * DbSession constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserSessions($userId)
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->get(['id', 'ip_address', 'user_agent', 'last_activity']);
    }

    /**
     * {@inheritdoc}
     */
    public function invalidateUserSession($userId, $sessionId)
    {
        DB::table('sessions')
            ->where('user_id', $userId)
            ->where('id', $sessionId)
            ->delete();

        $this->users->update($userId, ['remember_token' => null]);
    }
}