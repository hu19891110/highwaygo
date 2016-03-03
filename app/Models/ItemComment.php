<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemComment extends Model {
	use SoftDeletes;

	public function item() {
		return $this->belongsTo('App\Models\Item');
	}

	public function order() {
		return $this->belongsTo('App\Models\Order');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
}