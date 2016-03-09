<?php

namespace App\Http\Controllers\Home\Mobile;

use App\Http\Controllers\Home\Mobile\Message;
use App\Http\Controllers\Home\Mobile\ThrottlesSend;
use App\Http\Controllers\Home\Mobile\ThrottlesVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait SendAndVerify {
	use ThrottlesSend, ThrottlesVerify;

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
			return '每' . $this->getVerifyLockTime() . '分钟才可以验证一次短信验证码, 剩[' . $this->getAvailableVerifyIn($request) . ']秒';
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
}