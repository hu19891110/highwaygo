<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Cart {

	protected static $ins = null;

	protected static function getInstance() {
		return self::$ins ?: Session::get('cart', function () {
			Session::put('cart', self::$ins = new self);
			return self::$ins;
		});
	}

	public static function __callStatic($name, $args) {
		return call_user_func_array([self::getInstance(), "_{$name}"], $args);
	}

	/**
	 * @var array
	 */
	protected $items;

	protected function __construct() {
		$this->items = [];
	}

	private function _fresh() {
		$this->items = array_filter($this->items, function ($item) {
			return $item[1] > 0 && $item[0]->stock;
		});
	}

	protected function _getLists() {
		$this->_fresh();
		return $this->items;
	}

	protected function _add(Item $item, $count = 1) {
		if (!key_exists($item->id, $this->items)) {
			$this->items[$item->id] = [$item, 0];
		}
		if ($this->items[$item->id][1] + $count <= $item->stock) {
			$this->items[$item->id][1] += $count;
		} else {
			$this->items[$item->id][1] = $item->stock;
		}
	}

	protected function _remove(Item $item, $count = 0) {
		if (key_exists($item->id, $this->items)) {
			if ($this->items[$item->id][1] <= $count) {
				unset($this->items[$item->id]);
			} else {
				$this->items[$item->id][1] -= $count;
			}
		}
	}

	protected function _clear() {
		unset($this->items);
		$this->items = [];
//		$this->_fresh();
		//		Session::forget('cart');
	}

	protected function _count() {
		$this->_fresh();
		return count($this->items);
	}
}