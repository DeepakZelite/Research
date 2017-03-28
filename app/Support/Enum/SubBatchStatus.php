<?php

namespace Vanguard\Support\Enum;

class SubBatchStatus
{
    const ASSIGNED = 'Assigned';
    const INPROCESS = 'In-Process';
    const COMPLETE='Complete';
    const SUBMITTED='Submitted';

    public static function lists()
    {
        return [
            self::ASSIGNED => trans('app.'.self::ASSIGNED),
            self::INPROCESS => trans('app.'. self::INPROCESS),
            self::COMPLETE => trans('app.' . self::COMPLETE)
        ];
    }
    
    
    public static function lists1()
    {
    	return [
    			self::ASSIGNED => trans('app.'.self::ASSIGNED),
    			self::INPROCESS => trans('app.'. self::INPROCESS),
    			self::SUBMITTED => trans('app.' . self::SUBMITTED)
    	];
    }
}