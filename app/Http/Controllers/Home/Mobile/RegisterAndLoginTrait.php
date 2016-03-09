<?php

namespace App\Http\Controllers\Home\Mobile;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait RegisterAndLoginTrait {
	use SendAndVerify;

	/**
	 * @param Request $request
	 * @return array
	 */
	public function postRegisterSend(Request $request) {
		$result = $this->resolveResult(
			$this->send($request, [$request->only('mobile'), ['mobile' => 'unique:users']])
		);
		if ($result === true) {
			return ['code' => 0];
		} else if ($result === false) {
			return ['code' => -1, 'message' => '服务器繁忙,请稍后再试'];
		} else {
			return ['code' => 1, 'message' => $result];
		}
	}

	/**
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postMobileRegister(Request $request) {
		$result = $this->resolveResult($this->verify($request, [
			$request->only('password', 'password_confirmation', 'name'),
			['password' => 'required|confirmed', 'name' => 'required|max:20'],
			['name.required' => '昵称不能留空', 'name.max' => '昵称最大长度为20'],
		]));
		if ($result === true) {
			$this->clearVerifyAttempts($request);
			Auth::login(
				User::create(array_merge($request->only('mobile', 'name'), ['password' => bcrypt($request->input('password'))]))
			);
			return redirect()->intended($this->redirectPath());
		} else if ($result === false) {
			$errors = ['error' => '请输入正确的验证码'];
		} else {
			$errors = $result;
		}
		return redirect($this->getMobileRegisterPath())
			->with('availableSendIn', $this->getAvailableSendIn($request))
			->withInput($request->only('mobile', 'token'))
			->withErrors($errors);
	}

	/**
	 * @param Request $request
	 * @return array
	 */
	public function postLoginSend(Request $request) {
		$mobile = $request->input('mobile');
		if (!User::where('mobile', '=', $mobile)->get()->first()) {
			return ['code' => -1, 'message' => '手机还未注册,请注册后在登陆'];
		}
		$result = $this->resolveResult($this->send($request));
		if ($result === true) {
			return ['code' => 0];
		} else if ($result === false) {
			return ['code' => -1, 'message' => '服务器繁忙,请稍后再试'];
		} else {
			return ['code' => 1, 'message' => $result];
		}
	}

	/**
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postMobileLogin(Request $request) {
		$result = $this->resolveResult($this->verify($request));
		if ($result === true) {
			if (($user = User::where('mobile', '=', $request->input('mobile'))->get()->first())) {
				Auth::login($user, $request->has('remember'));
				$this->clearSendAttempts($request);
				$this->clearVerifyAttempts($request);
				return redirect()->intended($this->redirectPath());
			} else {
				$errors = ['mobile' => '手机号不存在'];
			}
		} else if ($result === false) {
			$errors = ['error' => '请输入正确的验证码'];
		} else {
			$errors = $result;
		}
		return redirect($this->getMobileLoginPath())
			->with('availableSendIn', $this->getAvailableSendIn($request))
			->withInput($request->only('mobile', 'token'))
			->withErrors($errors);
	}

	/**
	 * @return string
	 */
	protected function getMobileLoginPath() {
		return property_exists($this, 'mobileLoginPath') ? $this->mobileLoginPath : 'auth/mobile-login';
	}

	/**
	 * @return string
	 */
	protected function getMobileRegisterPath() {
		return property_exists($this, 'mobileRegisterPath') ? $this->mobileRegisterPath : 'auth/mobile-register';
	}
}