<?php

namespace Vanguard\Support\Enum;

class SubBatchStatus
{
    const ASSIGNED = 'Assigned';
    const INPROCESS = 'In-Process';
    const COMPLETE='Complete';

    public static function lists()
    {
        return [
            self::ASSIGNED => trans('app.'.self::ASSIGNED),
            self::INPROCESS => trans('app.'. self::INPROCESS),
            self::COMPLETE => trans('app.' . self::COMPLETE)
        ];
    }
}