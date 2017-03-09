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

    protected $fillable = ['name', 'sub_batch_id','batch_id','user_id'];
  
}