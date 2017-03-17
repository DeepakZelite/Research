<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';


    protected $casts = [
        'removable' => 'boolean'
    ];
    protected $fillable = ['batch_id','company_instructions','company_id','parent_company','company_name','address1','address2','city','zipcode','country','international_code','switchboardnumber','branchNumber','addresscode','website','comapny_email','products_services',
    		'industry_classfication','employee_size','physician_size','annual_revenue','number_of_beds','foundation_year','company_remark','additional_info1','additional_info2','additional_info3','additional_info4','staff_id','salutation','firstname',
    		'middlename','lastname','job_title','specification','qualification','staff_source','staff_email1','staff_email2','direct_emailsource','direct_phoneno','deparment_number','shift_timing','paternership','email_type','age','working_tenure',
    		'staff_remarks','contact_info1','contact_info2','contact_info3','contact_info4'];
    //protected $fillable = ['name', 'phone', 'mobile', 'email', 'sub_batch_id','batch_id','user_id'];
  
}