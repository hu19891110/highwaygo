<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classification extends Model {
	use SoftDeletes;

	public function classifications() {
		return $this->hasMany('App\Models\Classification', 'parent_id');
	}

	public function items() {
		return $this->hasMany('App\Models\Item');
	}

	public function classification() {
		return $this->belongsTo('App\Models\Classification');
	}
}