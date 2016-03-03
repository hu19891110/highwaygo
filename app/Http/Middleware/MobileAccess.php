<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Session;

class MobileAccess {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$last_access_time = Session::get('mobile.last_access_time', 0);
		Session::put('mobile.last_access_time', Carbon::now()->timestamp);
		if (Carbon::now()->timestamp - $last_access_time <= 1) {
			return response('服务器繁忙', 400);
		}

		return $next($request);
	}
}
