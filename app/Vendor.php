<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = ['name', 'description'];
}