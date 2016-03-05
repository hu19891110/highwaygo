<?php

namespace App\Http\Controllers\Home\Mobile;

use App\Http\Controllers\Home\Mobile\Message;
use App\Http\Controllers\Home\Mobile\ThrottlesSend;
use App\Http\Controllers\Home\Mobile\ThrottlesVerify;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

trait SendAndVerify {
	use ThrottlesSend, ThrottlesVerify;

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
	 * @param $result
	 * @return array|bool
	 */
	private function resolveResult($result) {
		if ($result === true) {
			return true;
		} else if ($result === false) {
			return false;
		} else if (is_string($result)) {
			return ['error' => $result];
		} else if (is_array($result)) {
			return $result;
		} else if ($result instanceof MessageBag) {
			return $result->all();
		} else {
			return ['error' => '服务器发生故障'];
		}

	}

	/**
	 * @param Request $request
	 * @param null $v
	 * @return bool|string
	 */
	protected function send(Request $request, $v = null) {
		if ($this->hasTooManySendAttempts($request)) {
			return '每' . $this->getSendLockTime() . '分钟才可以发一次短信验证码, 剩[' . $this->getAvailableSendIn($request) . ']秒';
		}

		$cols     = $request->only('mobile');
		$rules    = $this->mobileRule();
		$messages = [
			'mobile.required' => '请填写手机号',
			'mobile.regex'    => '请填写正确的手机号',
			'mobile.unique'   => '手机号已经被注册了',
		];
		if ($v) {
			$cols     = isset($v[0]) ? array_merge($cols, $v[0]) : $cols;
			$rules    = isset($v[1]) ? array_merge_recursive($rules, $v[1]) : $rules;
			$messages = isset($v[2]) ? array_merge($messages, $v[2]) : $messages;

		}
		$validator = Validator::make(
			$cols,
			$rules,
			$messages
		);
		if ($validator->fails()) {
			return $validator->errors();
		}
		$this->sendAttempts($request);
		try {
			return Message::send($request);
		} catch (\Exception $e) {
			return '服务器发生错误[' . $e->getMessage() . ']';
		}
	}

	/**
	 * @param Request $request
	 * @param null $v
	 * @return bool|string
	 */
	protected function verify(Request $request, $v = null) {
		if ($this->hasTooManyVerifyAttempts($request)) {
			return '每' . $this->getVerifyLockTime() . '分钟才可以验证一次短信验证码, 剩[' . $this->availableVerifyIn($request) . ']秒';
		}
		$cols     = $request->only('mobile', 'token');
		$rules    = array_merge($this->mobileRule(), ['token' => 'required']);
		$messages = [
			'token.required'  => '请填写验证码',
			'mobile.required' => '请填写手机号',
			'mobile.regex'    => '请填写正确的手机号',
		];
		if ($v) {
			$cols     = isset($v[0]) ? array_merge($cols, $v[0]) : $cols;
			$rules    = isset($v[1]) ? array_merge_recursive($rules, $v[1]) : $rules;
			$messages = isset($v[2]) ? array_merge($messages, $v[2]) : $messages;

		}
		$validator = Validator::make(
			$cols,
			$rules,
			$messages
		);
		if ($validator->fails()) {
			return $validator->errors();
		}

		try {
			$this->verifyAttempts($request);
			return Message::verify($request);
		} catch (\Exception $e) {
			return '服务器发生错误[' . $e->getMessage() . ']';
		}

	}

	/**
	 * @return array
	 */
	protected function mobileRule() {
		return [
			'mobile' => ['required', 'regex:/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/'], //注意: 当使用regex模式时，您必须使用数组来取代"|"作为分隔，尤其是当正规表示式中含有"|"字串。
		];
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