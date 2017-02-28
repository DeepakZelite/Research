<?php

namespace Vanguard\Http\Requests\Vendor;

use Vanguard\Http\Requests\Request;

class UpdateVendorRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    	$vendor = $this->route('vendor');
    	return [
    			'name' => 'unique:vendors,name,' . $vendor->id
    	];
    }
}
