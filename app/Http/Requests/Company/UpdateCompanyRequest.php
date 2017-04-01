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
    	//$company = $this->route('company');
    	return [
    			/*'company_name' => 'required,company_name,' . $company->id,
    			'address1'=>'required',
    			'city'=>'required',
    			'state'=>'required',
    			'zipcode'=>'required|digits:6',
    			'country'=>'required|exists:countries,id'
     			//'phone'=>'required|digits:10',
     			//'email'=>'required|email',
     			//'mobile'=>'digits:10'*/
    	];
    }
}
