<?php

namespace Vanguard\Http\Requests\Project;

use Vanguard\Http\Requests\Request;
use Vanguard\Project;

class UpdateProjectRequest extends Request
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
    			//'name' => 'required|unique:projects,name,' . $project->id,
    			'required|unique:projects,code,' . $project->id,
    			'Start_Date' => 'required|date',
        		'Expected_date' => 'required|date|after:Start_Date',
        		'No_Companies'=>'required|integer|min:1',
        		'Expected_Staff'=>'required|integer|min:1',
    			//'attachement'=>'required|file',
    	];
    }
}
