<?php

namespace App\Http\Controllers\User;

class AuthController extends \App\Http\Controllers\Controller {
	use \App\Http\Controllers\User\Mobile\SendAndVerify;

	public function __construct() {
		$this->middleware('mobile.access', ['only' => [
			'postRegisterSend',
			'postRegisterVerify',
			'postLoginSend',
			'postLoginVerify',
		]]);
	}

	public function getIndex() {
		echo "ok";
	}
}
