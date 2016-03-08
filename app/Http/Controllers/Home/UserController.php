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
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function getIndex(Request $request) {
		$user = Auth::user();
		return view('home.user.layout')
			->with('page', 'index')
			->with('title', '个人中心');
	}

	public function getInfo() {
		return view('home.user.layout')
			->with('page', 'info')
			->with('title', '个人信息');
	}

	public function getAddress() {
		return view('home.user.layout')
			->with('page', 'address')
			->with('title', '收获地址');
	}

	public function getFavorite() {
		$perpage   = 12;
		$favorites = Auth::user()->favorites()->paginate($perpage);
		return view('home.user.layout')
			->with('favorites', $favorites)
			->with('page', 'favorite')
			->with('title', '我的收藏');
	}

	public function getOrder() {
		$perpage = 12;
		$orders  = Auth::user()->orders()->paginate($perpage);
		return view('home.user.layout')
			->with('orders', $orders)
			->with('page', 'order')
			->with('title', '我的订单');
	}

	public function getPassword() {
		return view('home.user.layout')
			->with('page', 'password')
			->with('title', '修改密码');
	}
}