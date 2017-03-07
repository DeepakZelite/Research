<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;
use Vanguard\Presenters\UserPresenter;
use Laracasts\Presenter\PresentableTrait;

class Vendor extends Model
{
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
    
  /*  public function isInActive()
    {
    	return $this->status == UserStatus::INACTIVE;
    }
    public function isActive()
    {
    	return $this->status == UserStatus::ACTIVE;
    }*/
    
}