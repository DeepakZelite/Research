<?php

namespace Vanguard\Http\Requests\Contact;

use Vanguard\Http\Requests\Request;
use Vanguard\Contact;

class CreateContactRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            	//'first_name' => 'required|unique:projects,name',
               ];
    }
}
