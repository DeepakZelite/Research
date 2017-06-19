<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table = 'report_details';
	
	protected $fillable = ['user_id','start_time', 'stop_time','records', 'time'];
}
