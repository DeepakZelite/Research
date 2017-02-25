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

    protected $fillable = ['name', 'description'];
}