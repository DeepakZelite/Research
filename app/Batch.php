<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'batches';

    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = ['id', 'name', 'description', 'project_id', 'vendor_id','Target_Date'];
     
}