<?php

namespace App\Http\Middleware;

use App\Models\BanIp;
use Cache;
use Carbon\Carbon;
use Closure;

class CheckBanIp {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$ips = Cache::rememberForever('ban.ips', function () {
			return BanIp::whereRaw('unix_timestamp(expired) > ? ', [Carbon::now()->timestamp])->get(['ip']);
		});
		if (in_array(['ip' => $request->ip()], $ips->toArray())) {
			return response('ban! fuck you!.', 401);
		}
		return $next($request);
	}
}
