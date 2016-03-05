<?php

namespace App\Http\Controllers\Home;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;

trait AuthenticatesAndRegistersUsers {
	use AuthenticatesUsers {
		AuthenticatesUsers::postLogin as post_login;
	}

	use RegistersUsers {
		AuthenticatesUsers::redirectPath insteadof RegistersUsers;
	}
}
