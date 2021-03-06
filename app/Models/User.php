<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract {
	use Authenticatable, Authorizable, CanResetPassword;
	use EntrustUserTrait {
		EntrustUserTrait::can as may;
		Authorizable::can insteadof EntrustUserTrait;
	}
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'mobile', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function addresses() {
		return $this->hasMany('App\Models\Address');
	}

	public function comments() {
		return $this->hasMany('App\Models\ItemComment');
	}
	public function favorites() {
		return $this->hasMany('App\Models\Favorite');
	}

	public function orders() {
		return $this->hasMany('App\Models\Order');
	}
}
