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
            'name' => 'unique:projects,name'
               ];
    }
}
