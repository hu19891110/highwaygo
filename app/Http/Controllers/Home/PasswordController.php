<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Password Reset Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller is responsible for handling password reset requests
		    | and uses a simple trait to include this behavior. You're free to
		    | explore this trait and override any methods you wish to tweak.
		    |
	*/

	use ResetsPasswords;

	protected $redirectTo = 'auth/login';

	/**
	 * Create a new password controller instance.
	 *
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	protected $subject = '重置密码链接';

	public function getEmail() {
		return view('home.auth.password');
	}

	public function postEmail(Request $request) {
		$this->validate($request, ['email' => 'required|email']);

		$response = Password::sendResetLink($request->only('email'), function (Message $message) {
			$message->subject($this->getEmailSubject());
		});
		switch ($response) {
		case Password::RESET_LINK_SENT:
			return redirect('password/email')
				->withInput($request->only('email'))
				->withErrors(['success' => trans($response)]);
//				->with('status', trans($response));

		case Password::INVALID_USER:
			return redirect('password/email')
				->withInput($request->only('email'))
				->withErrors(['email' => trans($response)]);
		}
	}

	public function getReset($token = null) {
		if (is_null($token)) {
			throw new NotFoundHttpException;
		}

		return view('home.auth.reset')->with('token', $token);
	}
}
