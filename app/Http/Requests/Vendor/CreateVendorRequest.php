<?php

namespace Vanguard\Http\Requests\Vendor;

use Vanguard\Http\Requests\Request;
use Vanguard\Vendor;

class CreateVendorRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            	'name' => 'required|alpha',
        		'vendor_code'=>'required|regex:/^[\w-]*$/|unique:vendors,vendor_code',
        		'location'=>'required',	
        		'contactPerson'=>'required|alpha',
        		'phone'=>'required|digits:10',
        		'email'=>'required|email',
        		'mobile'=>'digits:10'
               ];
    }
}
