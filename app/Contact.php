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

    protected $fillable = ['id', 'company_id' , 'user_id','first_name', 'last_name','middle_name','job_title','specialization','staff_source','staff_email','direct_phoneno','email_source','qualification','staff_disposition','deparment_number','alternate_phone','alternate_email','email_type','shift_timing','working_tenure','paternership','age','staff_remarks','additional_info1','additional_info2','additional_info3','additional_info4','salutation','additional_info5','additional_info6','additional_info7','additional_info8','created_at','updated_at'];
	//'staff_note', 'isd_code', 'area_code', 'designation',
}