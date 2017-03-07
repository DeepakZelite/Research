<?php

namespace Vanguard\Http\Requests\Project;

use Vanguard\Http\Requests\Request;
use Vanguard\Project;

class CreateProjectRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            	'name' => 'required|unique:projects,name',
        		'code'=>'required|regex:/^[\w-]*$/|unique:projects,code',
        		'Start_Date' => 'required|date',
        		'Expected_date' => 'required|date',
        		'No_Companies'=>'required|digits_between:1,4',
        		'Expected_staff'=>'required|digits_between:1,4',
               ];
    }
}
