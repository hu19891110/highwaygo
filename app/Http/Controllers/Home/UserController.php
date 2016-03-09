<?php
/**
 * Created by PhpStorm.
 * User: zhuangjianjia
 * Date: 16/3/4
 * Time: 下午6:57
 */

namespace app\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\Mobile\SendAndVerify;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

	use SendAndVerify;

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
		$perpage   = 12;
		$addresses = Auth::user()->addresses()->paginate($perpage);
		return view('home.user.layout')
			->with('addresses', $addresses)
			->with('page', 'address')
			->with('title', '收获地址');
	}

	public function getAddAddress(Request $request) {
		return view('home.user.layout')
			->with('availableSendIn', $this->getAvailableSendIn($request))
			->with('page', 'add-address')
			->with('title', '增加收获地址');
	}

	public function postAddAddress(Request $request) {
		$result = $this->resolveResult($this->verify($request, [
			$request->only('name', 'address'),
			[
				'name'    => 'required|max:20',
				'address' => 'required|max:200',
				'pc'      => 'required|digit:6',
			],
			[
				'name.required'    => '名字不能留空', 'name.max'    => '名字最大长度是20',
				'address.required' => '地址不能留空', 'address.max' => '地址最大长度是200',
				'pc.required'      => '邮编不能留空', 'pc.digit'    => '请输入正确的邮编',
			],
		]));

		if ($result === true) {
			$this->clearVerifyAttempts($request);
			$address          = new Address;
			$address->user_id = Auth::user()->id;
			$address->mobile  = $request->input('mobile');
			$address->name    = $request->input('name');
			$address->address = $request->input('address');
			$address->pc      = $request->input('pc');
			$address->active  = 1;
			$address->save();
			return redirect()->intended('/user/address');
		} else if ($result === false) {
			$errors = ['error' => '请输入正确的验证码'];
		} else {
			$errors = $result;
		}
		return redirect()
			->back()
			->with('availableSendIn', $this->getAvailableSendIn($request))
			->withInput($request->only('mobile', 'token'))
			->withErrors($errors);
	}

	public function postAddAddressSend(Request $request) {
		$result = $this->resolveResult($this->send($request));
		if ($result === true) {
			return ['code' => 0];
		} else if ($result === false) {
			return ['code' => -1, 'message' => '服务器繁忙,请稍后再试'];
		} else {
			return ['code' => 1, 'message' => $result];
		}
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

	public function postPassword(Request $request) {
		$validator = Validator::make($request->all(), [
			'password'     => 'required',
			'new_password' => 'required|min:6|confirmed',
		]);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->errors());
		}
		$email = Auth::user()->email;
		if (Auth::once(['email' => $email, 'password' => $request->input('password')])) {
			$user           = Auth::user();
			$user->password = bcrypt($request->input('new_password'));
			$user->save();
			Auth::logout();
			return redirect()->back();
		} else {
			return redirect()->back()->withErrors(['errors' => '原密码错误']);
		}

	}
}