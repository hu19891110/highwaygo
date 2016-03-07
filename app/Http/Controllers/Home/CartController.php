<?php
/**
 * Created by PhpStorm.
 * User: zhuangjianjia
 * Date: 16/3/4
 * Time: 下午6:57
 */

namespace app\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getIndex() {
		$items = Cart::getLists();
		return view('home.cart.index')
			->with('title', '购物车')
			->with('items', $items);
	}

	public function getAdd(Request $request, Item $item, $count = 1) {
		$count = intval($count);
		if ($count > 0) {
			Cart::add($item, $count);
		}

		return redirect('cart');
	}

	public function getRemove(Request $request, Item $item, $count = 1) {
		$count = intval($count);
		if ($count > 0) {
			Cart::remove($item, $count);
		}

		return redirect('cart');
	}

	public function getClear() {
		Cart::clear();
		return redirect('cart');
	}

	public function getCount() {
		if (Cart::count() <= 0) {
			return redirect('cart');
		}
		$items     = Cart::getLists();
		$addresses = Auth::user()->addresses()->where('active', '=', '1')->get();
		return view('home.cart.count')
			->with('title', '购物车结算')
			->with('addresses', $addresses)
			->with('items', $items);
	}

	public function postOrder(Request $request) {
		if (Cart::count() <= 0) {
			return redirect('cart/index');
		}
		$address = Auth::user()->addresses()->where('id', '=', $request->input('address'))->first();
		if ($address === null) {
			return redirect('cart/count');
		}
		$mark       = trim($request->input('mark'));
		$address_id = $address->id;
		try {
			$order = DB::transaction(function () use ($address_id, $mark) {
				$order             = new Order;
				$order->address_id = $address_id;
				$order->mark       = $mark;
				$order->number     = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
				$order->save();
				$items = Cart::getLists();
				foreach ($items as $item) {
					$item[0]->stock -= $item[1];
					$item[0]->save();
					$order_item           = new OrderItem;
					$order_item->item_id  = $item[0]->id;
					$order_item->order_id = $order->id;
					$order_item->count    = $item[1];
					$order_item->save();
				}
				Cart::clear();
				return $order;
			});
		} catch (\Exception $e) {
			abort(501, '服务器发生故障');
		}
		// 用户订单详情页面
		return redirect('index');
//		dd($order);
	}
}