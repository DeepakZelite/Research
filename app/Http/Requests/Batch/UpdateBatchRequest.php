<?php

namespace Vanguard\Http\Requests\Batch;

use Vanguard\Http\Requests\Request;

class UpdateBatchRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    	$batch = $this->route('batch');
    	return [
    			'name' => 'unique:batches,name,' . $batch->id
    	];
    }
}
