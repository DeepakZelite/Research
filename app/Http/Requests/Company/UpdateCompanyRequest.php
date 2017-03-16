<?php

namespace Vanguard\Http\Requests\Company;

use Vanguard\Http\Requests\Request;

class UpdateCompanyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    	$company = $this->route('company');
    	return [
//     			'name' => 'required|unique:name',
//     			'phone'=>'required|digits:10',
//     			'email'=>'required|email',
//     			'mobile'=>'digits:10'
    	];
    }
}
