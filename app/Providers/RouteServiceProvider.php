<?php

namespace App\Providers;

use App\Models\Item;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteServiceProvider extends ServiceProvider {
	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router) {
		//

		parent::boot($router);

		$router->bind('item', function ($id) {
			$item = Item::find($id, ['id', 'name', 'brief', 'classification_id', 'stock', 'price', 'number', 'thumb_img']);
			if ($item) {
				return $item;
			}
			throw new NotFoundHttpException;
		});
		$router->model('order', 'App\Models\Order');
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router) {
		$router->group(['namespace' => $this->namespace], function ($router) {
			require app_path('Http/routes.php');
		});
	}
}
