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
    	$project = $this->route('project');
    	return [
    			
    	];
    }
}
