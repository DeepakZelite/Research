<?php

namespace Vanguard\Support\Enum;

class SubBatchStatus
{
    const ASSIGNED = 'Assigned';
    const INPROGRESS = 'Inprogress';
    const COMPLETE='Complete';

    public static function lists()
    {
        return [
            self::ASSIGNED => trans('app.'.self::ACTIVE),
            self::INPROGRESS => trans('app.'. self::BANNED),
            self::COMPLETE => trans('app.' . self::UNCONFIRMED)
        ];
    }
  
}