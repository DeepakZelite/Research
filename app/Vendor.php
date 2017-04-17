<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;
use Vanguard\Presenters\UserPresenter;
use Laracasts\Presenter\PresentableTrait;
use Kyslik\ColumnSortable\Sortable;

class Vendor extends Model
{
	use Sortable;
	use PresentableTrait;
	protected $presenter = UserPresenter::class;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    protected $casts = [
        'removable' => 'boolean'
    ];

    protected $fillable = ['name','vendor_code','location','contactPerson','email','phone','mobile', 'status'];
    
    public $sortable = ['name','vendor_code','location','contactPerson','email','phone','mobile'];
    
  /*  public function isInActive()
    {
    	return $this->status == UserStatus::INACTIVE;
    }
    public function isActive()
    {
    	return $this->status == UserStatus::ACTIVE;
    }*/
    
}