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
            	'batch_id' => 'required|exists:batches,id',
        		'user_id'=>'required|exists:users,id',
        		'company_count'=>'required|integer|min:1'
               ];
    }
}
