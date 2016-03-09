<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {
	use SoftDeletes;

	public function address() {
		return $this->belongsTo('App\Models\Address');
	}

	public function comments() {
		return $this->hasMany('App\Models\ItemComment');
	}

	public function delivery() {
		return $this->hasOne('App\Models\Delivery');
	}

	public function items() {
		return $this->hasMany('App\Models\OrderItem');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
}