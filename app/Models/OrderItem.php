<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

	public function item() {
		return $this->belongsTo('App\Models\Item');
	}

	public function order() {
		return $this->belongsTo('App\Models\Order');
	}

}