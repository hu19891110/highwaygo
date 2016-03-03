<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {
	use SoftDeletes;
	protected $table = 'addresses';
	public function user() {
		return $this->belongsTo('App\Models\User');
	}

	public function orders() {
		return $this->hasMany('App\Models\Order');
	}
}