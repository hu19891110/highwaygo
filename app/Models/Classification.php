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

	// 取得子分类的所有物品 远程一对多
	public function allItems() {
		return $this->hasManyThrough('App\Models\Item', 'App\Models\Classification', 'parent_id', 'item_id');
	}
}