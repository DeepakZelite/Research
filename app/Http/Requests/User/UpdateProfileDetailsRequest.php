<?php

namespace Vanguard\Http\Requests\User;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class UpdateProfileDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birthday' => 'date',
        		//'username' => 'required|unique:users,username',
        		'password' => 'min:6|confirmed',
        		'first_name'=> 'required',
        		'last_name'=>'required',
        		'birthday' => 'date',
        		'phone'=>'digits:10'
        ];
    }
}
