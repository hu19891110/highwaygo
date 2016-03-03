<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model {
	use SoftDeletes;

	public function classification() {
		return $this->belongsTo('App\Models\Classification');
	}

	public function comments() {
		return $this->hasMany('App\Models\ItemComment');
	}
	public function favorites() {
		return $this->hasMany('App\Models\Favorite');
	}
}