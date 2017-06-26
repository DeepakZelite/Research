<?php

namespace Vanguard\Repositories\Session;

interface SessionRepository
{
    /**
     * Get all active sessions for specified user.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserSessions($userId);

    /**
     * Invalidate specified session for provided user
     *
     * @param $userId
     * @param $sessionId
     * @return mixed
     */
    public function invalidateUserSession($userId, $sessionId);
    
    /**
     * for restricting the same user multiple login
     * @param unknown $userId
     */
    public function getUserSessionCount($userId);
    
    /**
     * for checking the last activity of perticular user with perticular session
     * @param unknown $userId
     */
    public function getLastActivity($userId);
}