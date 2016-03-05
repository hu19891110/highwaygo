<?php
/**
 * Created by PhpStorm.
 * User: zhuangjianjia
 * Date: 16/3/5
 * Time: 下午4:46
 */

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ItemImg extends Model {
	public function item() {
		return $this->belongsTo('App\Models\Item');
	}
}