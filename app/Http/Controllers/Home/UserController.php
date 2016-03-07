<?php
/**
 * Created by PhpStorm.
 * User: zhuangjianjia
 * Date: 16/3/4
 * Time: 下午6:57
 */

namespace app\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex(Request $request) {
		return view('home.user.index');
	}
}