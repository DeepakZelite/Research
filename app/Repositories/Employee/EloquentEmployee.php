<?php
namespace Vanguard\Repositories\Employee;

use Vanguard\Employee;

class EloquentEmployee implements EmployeeRepository
{
	/**
	 * {@inheritdoc}
	 */
	public function lists($column = 'size', $key = 'id')
	{
		return Country::orderBy('id')->lists($column, $key);
	}

}