<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Car {

	protected static $ins = null;

	protected static function getInstance() {
		return self::$ins ?: Session::get('car', function () {
			Session::put('car', self::$ins = new self);
			return self::$ins;
		});
	}

	public static function __callStatic($name, $args) {
		return call_user_func_array([self::getInstance(), "_{$name}"], $args);
	}

	protected function __construct() {
		echo "购物车实例化";
	}

	protected function _get($i) {
		return $i;
	}
}