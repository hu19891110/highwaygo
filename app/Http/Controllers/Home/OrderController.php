<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {

	public function getCancle(Request $request, Order $order) {
		// 取消订单
		if ($order->user->id == Auth::user()->id && $order->status == '尚未付款') {
			$order->status = '已取消';
			$order->save();
		}
		return redirect('/user/order');
	}

	public function getDetail(Request $request, Order $order) {
		if ($order->user->id == Auth::user()->id) {
			return view('home.user.layout')
				->with('order', $order)
				->with('page', 'order-detail')
				->with('title', '订单详情');
		}
		return redirect('/user/order');
	}
}