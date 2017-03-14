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
    			'name' => 'required|unique:vendors,name,' . $vendor->id,
    			'vendor_code'=>'required',
    			'location'=>'required',
    			'contactPerson'=>'required',
    			'phone'=>'required|digits:10',
    			'email'=>'required|email',
    			'mobile'=>'digits:10'
    	];
    }
}
