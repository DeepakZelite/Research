<?php

namespace Vanguard\Support\Enum;

class UserStatus
{
    const UNCONFIRMED = 'Unconfirmed';
    const ACTIVE = 'Active';
    const BANNED = 'Banned';
    const INACTIVE='In-Active';

    public static function lists()
    {
        return [
            self::ACTIVE => trans('app.'.self::ACTIVE),
            self::BANNED => trans('app.'. self::BANNED),
            self::UNCONFIRMED => trans('app.' . self::UNCONFIRMED)
        ];
    }
    public static function lists1()
    {
    	return [
    			self::ACTIVE => trans('app.'.self::ACTIVE),
    			self::INACTIVE => trans('app.'. self::INACTIVE)
    	];
    }
}