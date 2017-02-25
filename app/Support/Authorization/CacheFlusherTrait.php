<?php

namespace Vanguard\Support\Authorization;


use Vanguard\Role;
use Vanguard\User;
use Cache;

/**
 * Class CacheFlusherTrait
 * @package Vanguard\Support\Authorization
 */
trait CacheFlusherTrait
{
    /**
     * Clear permissions cache for specified role.
     *
     * @param Role $role
     */
    protected function flushRolePermissionsCache(Role $role)
    {
        Cache::forget("entrust_permissions_for_role_{$role->id}");
    }

    /**
     * Clear roles cache for specified user.
     *
     * @param User $user
     */
    protected function flushUserRolesCache(User $user)
    {
        Cache::forget("entrust_roles_for_user_{$user->id}");
    }
}