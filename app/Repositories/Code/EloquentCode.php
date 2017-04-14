<?php
namespace Vanguard\Repositories\Code;

use Vanguard\Code;

class EloquentCode implements CodeRepository
{
	/**
	 * {@inheritdoc}
	 */
	public function lists($column = 'description', $key = 'code')
	{
		return Code::where('code_type','=','EMP_SIZE')->orderBy('id')->lists($column, $key);
	}
	public function lists1($column = 'description', $key = 'code')
	{
		return Code::where('code_type','=','EMP_SPEC')->orderBy('code')->lists($column, $key);
	}
}