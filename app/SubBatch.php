<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class SubBatch extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sub_batches';

    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = ['name', 'batch_id','project_id', 'user_id','vendor_id', 'status', 'company_count', 'seq_no'];
     
}