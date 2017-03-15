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
            	//'name' => 'required|unique:name',
        		//'phone'=>'required|digits:10',
        		//'email'=>'required|email',
        		//'mobile'=>'digits:10'
               ];
    }
}
