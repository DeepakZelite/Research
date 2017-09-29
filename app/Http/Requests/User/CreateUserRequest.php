<?php

namespace Vanguard\Http\Requests\User;

use Vanguard\Http\Requests\Request;
use Vanguard\User;

class CreateUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
        	'first_name'=> 'required|alpha',
        	'last_name'=>'required|alpha',
            'birthday' => 'date',
            'role' => 'required|exists:roles,id',
        	//'vendor_id'=>'required|exists:vendors,id',
        	'phone'=>'digits:10'
        ];
    }
}
