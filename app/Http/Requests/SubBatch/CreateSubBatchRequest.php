<?php

namespace Vanguard\Http\Requests\SubBatch;

use Vanguard\Http\Requests\Request;
use Vanguard\SubBatch;

class CreateSubBatchRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'name' => 'required|unique:batches,name',
        	///'Target_Date'=>'required|date',
        	//'upload'=>'required'
               ];
    }
}
