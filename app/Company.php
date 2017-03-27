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
    protected $fillable = ['id','batch_id','company_instructions','company_id','parent_company','company_name','address1','address2','city','state','zipcode','country','international_code','isd_code','switchboardnumber','branchNumber','addresscode','website','company_email','products_services',
    		'industry_classfication','employee_size','physician_size','annual_revenue','number_of_beds','foundation_year','company_remark','additional_info1','additional_info2','additional_info3','additional_info4','status'];
    //protected $fillable = ['name', 'phone', 'mobile', 'email', 'sub_batch_id','batch_id','user_id'];

    //protected $fillable = ['name', 'website', 'phone', 'mobile', 'email', 'sub_batch_id','batch_id','user_id', 'id']
}