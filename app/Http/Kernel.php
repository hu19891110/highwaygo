<?php

namespace App\Http;

use App;
use Illuminate;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Zizaco;

class Kernel extends HttpKernel {
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		App\Http\Middleware\EncryptCookies::class,
		Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
		Illuminate\Session\Middleware\StartSession::class,
		Illuminate\View\Middleware\ShareErrorsFromSession::class,
		App\Http\Middleware\VerifyCsrfToken::class,
		App\Http\Middleware\CheckBanIp::class,
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth'          => App\Http\Middleware\Authenticate::class,
		'auth.basic'    => Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'auth.admin'    => App\Http\Middleware\AdminAuthenticate::class,
		// 只有游客能访问的页面
		'guest'         => App\Http\Middleware\RedirectIfAuthenticated::class,
		'role'          => Zizaco\Entrust\Middleware\EntrustRole::class,
		'permission'    => Zizaco\Entrust\Middleware\EntrustPermission::class,
		'ability'       => Zizaco\Entrust\Middleware\EntrustAbility::class,
		'mobile.access' => App\Http\Middleware\MobileAccess::class,
		'auth.view'     => App\Http\Middleware\Auth2View::class,
	];
}
