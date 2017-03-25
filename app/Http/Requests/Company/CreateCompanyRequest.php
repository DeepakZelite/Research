<?php

namespace Vanguard\Http\Requests\Company;

use Vanguard\Http\Requests\Request;
use Vanguard\Company;

class CreateCompanyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            	'company_name' => 'required|unique:name',
        		'address1'=>'required',
        		'city'=>'required',
        		'state'=>'required',
        		'zipcode'=>'required',
        		'country'=>'required|exists:countries,id'
        		//'email'=>'required|email',
        		//'mobile'=>'digits:10'
               ];
    }
}
