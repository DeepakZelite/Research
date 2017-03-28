<?php

namespace Vanguard\Http\Requests\Contact;

use Vanguard\Http\Requests\Request;

class UpdateContactRequest extends Request
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
//    			'first_name' => 'required|unique:companies,first_name,'.$company->id,
    	];
    }
}
