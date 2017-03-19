<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';


    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = ['id', 'company_id' , 'user_id','first_name', 'last_name','middle_name','email','phone','alternate_phone','staff_note', 'isd_code', 'area_code', 'designation', 'created_dt', 'updated_dt'];

}