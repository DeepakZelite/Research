<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';


    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = ['name', 'code','No_Companies','Expected_Staff','brief_file','Start_Date','Expected_date'];
//  	protected $fillable = ['brief_file'];

}