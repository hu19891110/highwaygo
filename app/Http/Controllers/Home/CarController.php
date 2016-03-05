<?php
/**
 * Created by PhpStorm.
 * User: zhuangjianjia
 * Date: 16/3/4
 * Time: 下午6:57
 */

namespace app\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class CarController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	public function getIndex() {
		return '';
	}
}