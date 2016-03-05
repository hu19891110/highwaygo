<?php

namespace App\Http\Controllers\Home\Mobile;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

trait ThrottlesSend {
	/**
	 * @param Request $request
	 * @return mixed
	 */
	protected function hasTooManySendAttempts(Request $request) {
		return app(RateLimiter::class)->tooManyAttempts(
			$request->ip() . '|send',
			$this->getMaxSendAttempts(),
			$this->getSendLockTime()
		);
	}

	/**
	 * @param Request $request
	 */
	protected function sendAttempts(Request $request) {
		app(RateLimiter::class)->hit($request->ip() . '|send');
		$this->hasTooManySendAttempts($request);
	}

	/**
	 * @param Request $request
	 */
	protected function clearSendAttempts(Request $request) {
		app(RateLimiter::class)->clear($request->ip() . '|send');
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function getAvailableSendIn(Request $request) {
		return app(RateLimiter::class)->availableIn($request->ip() . '|send');
	}

	/**
	 * @return int
	 */
	protected function getMaxSendAttempts() {
		return property_exists($this, 'maxSendAttempts') ? $this->maxSendAttempts : 1; // 发送短信的次数限制
	}

	/**
	 * @return int
	 */
	protected function getSendLockTime() {
		return property_exists($this, 'sendLockTime') ? $this->sendLockTime : 1; // 发送短信的时间间隔
	}
}