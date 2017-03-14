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
        		'username' => 'required|unique:users,username',
        		'password' => 'required|min:6|confirmed',
        		'birthday' => 'date',
        		'role' => 'required|exists:roles,id',
        		'phone'=>'digits:10'
        ];
    }
}
