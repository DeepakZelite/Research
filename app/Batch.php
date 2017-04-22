<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Batch extends Model
{
	use Sortable;
	
    /**
     * The database table used by the model.
     * @var string
     */
	protected $table = 'batches';
	
	/**
	 * for sorting a column of grid.
	 * @var array
	 */
	protected $sortable = ['id', 'name', 'project_id', 'vendor_id','Target_Date'];	
    
	/**
	 * 
	 * @var array
	 */
    protected $casts = [
        'removable' => 'boolean'
    ];

	/**
	 * for updation purpose
	 * @var array
	 */
    protected $fillable = ['id', 'name', 'project_id', 'vendor_id','Target_Date','status'];
   
}