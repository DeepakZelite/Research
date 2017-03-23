<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $table = 'Employees';

	public $timestamps = false;
}