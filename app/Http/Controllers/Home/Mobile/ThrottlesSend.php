<?php

namespace App\Http\Controllers\Home\Mobile;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

trait ThrottlesSend {
	protected function hasTooManySendAttempts(Request $request) {
		return app(RateLimiter::class)->tooManyAttempts(
			$request->ip() . '|send',
			$this->getMaxSendAttempts(),
			$this->getSendLockTime()
		);
	}

	protected function sendAttempts(Request $request) {
		app(RateLimiter::class)->hit($request->ip() . '|send');
		$this->hasTooManySendAttempts($request);
	}

	protected function clearSendAttempts(Request $request) {
		app(RateLimiter::class)->clear($request->ip() . '|send');
	}

	public function getAvailableSendIn(Request $request) {
		return app(RateLimiter::class)->availableIn($request->ip() . '|send');
	}

	protected function getMaxSendAttempts() {
		return property_exists($this, 'maxSendAttempts') ? $this->maxSendAttempts : 1; // 发送短信的次数限制
	}

	protected function getSendLockTime() {
		return property_exists($this, 'sendLockTime') ? $this->sendLockTime : 1; // 发送短信的时间间隔
	}
}