<?php
/**
 * Created by PhpStorm.
 * User: zhuangjianjia
 * Date: 16/3/4
 * Time: 下午7:02
 */

namespace app\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\Home\Mobile\SendAndVerify;
use App\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
	use AuthenticatesAndRegistersUsers, ThrottlesLogins;
	use SendAndVerify;

	protected $redirectPath     = '/';
	protected $loginPath        = 'auth/login';
	protected $mobileLoginPath  = 'auth/mobile-login';
	protected $lockoutTime      = 0;
	protected $maxLoginAttempts = 5;

	public function __construct() {
		$this->middleware('mobile.access', ['only' => [
			'postRegisterSend',
			'postRegisterVerify',
			'postLoginSend',
			'postLoginVerify',
		]]);
		$this->middleware('guest', [
			'except' => 'getLogout',
		]);
	}

	public function getLogout() {
		Auth::logout();
		return redirect('/');
	}

	public function getLogin(Request $request) {
		return view('home.auth.login')
			->with('title', '登陆')
			->with('needCaptcha', $this->getNeedCaptcha($request));
	}

	public function postLogin(Request $request) {
		if ($this->getNeedCaptcha($request) == 1) {
			$v = Validator::make($request->only('captcha'), [
				'captcha' => 'required|captcha',
			], [
				'captcha.required' => '请输入验证码',
				'captcha.captcha'  => '请输入正确的验证码',
			]);
			if ($v->fails()) {
				return redirect($this->loginPath())
					->withInput($request->only($this->loginUsername(), 'remember', 'captcha', 'password'))
					->withErrors($v->errors());
			}
		}
		return $this->post_login($request);
	}

	public function getRegister(Request $request) {
		return view('home.auth.register')->with('title', '注册邮箱帐号');
	}

	public function getNeedCaptcha(Request $request) {
		return $this->hasTooManyLoginAttempts($request) ? 1 : 0;
	}

	public function getMobileLogin(Request $request) {
		return view('home.auth.mobile.login')->with('title', '手机号登陆')->with('availableSendIn', $this->getAvailableSendIn($request));
	}

	public function getMobileRegister(Request $request) {
		return view('home.auth.mobile.register')->with('title', '手机号注册')->with('availableSendIn', $this->getAvailableSendIn($request));
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name'     => 'required|max:255',
			'email'    => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data) {
		return User::create([
			'name'     => $data['name'],
			'email'    => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}
}