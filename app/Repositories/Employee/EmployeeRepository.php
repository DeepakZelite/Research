<?php
namespace Vanguard\Repositories\Employee;

interface EmployeeRepository
{
	/**
	 * Create $key => $value array for all available countries.
	 *
	 * @param string $column
	 * @param string $key
	 * @return mixed
	 */
	public function lists($column = 'size', $key = 'id');
}