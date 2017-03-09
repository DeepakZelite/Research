<?php

namespace Vanguard\Http\Requests\SubBatch;

use Vanguard\Http\Requests\Request;

class UpdateSubBatchRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    	$subBatch = $this->route('subBatch');
    	return [
    			'name' => 'unique:subBatches,name,' . $subBatch->id,
    	];
    }
}
