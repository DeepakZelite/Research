<?php

namespace Vanguard;

use Vanguard\Presenters\UserPresenter;
use Vanguard\Support\Enum\UserStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laracasts\Presenter\PresentableTrait;

class UserSocialNetworks extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_social_networks';

    public $timestamps = false;

    protected $fillable = ['facebook', 'twitter', 'google_plus', 'dribbble', 'linked_in', 'skype'];
}
