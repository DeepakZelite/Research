<?php

namespace Vanguard\Http\Requests\Vendor;

use Vanguard\Http\Requests\Request;
use Vanguard\Vendor;

class CreateVendorRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'unique:vendors,name'
               ];
    }
}
