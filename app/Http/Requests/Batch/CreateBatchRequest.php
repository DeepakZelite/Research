<?php

namespace Vanguard\Http\Requests\Batch;

use Vanguard\Http\Requests\Request;
use Vanguard\Batch;

class CreateBatchRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:vendors,name',
        	'Target_Date'=>'required|date',
        	//'upload'=>'required'
               ];
    }
}
