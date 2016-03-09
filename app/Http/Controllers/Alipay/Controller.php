<?php

namespace App\Http\Controllers\Alipay;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends \App\Http\Controllers\Controller {

	public function getReturn(Request $request) {
		$alipay_config = config('alipay');
		$alipayNotify  = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if ($verify_result) {
			$order_number = $request->input('out_trade_no');
			$trade_no     = $request->input('trade_no');
			$trade_status = $request->input('trade_status');
			if ($trade_status == 'WAIT_SELLER_SEND_GOODS') {
				// 建议将更改记录放在异步通知里面,
				$order           = Order::where('number', '=', $order_number)->first();
				$order->trade_no = $trade_no;
				$order->status   = '已付款';
				$order->save();
			} else {
				echo "trade_status = " . $trade_status;
			}
			echo "验证成功 <br/>";
			echo "交易号" . $trade_no;
		} else {
			echo "验证失败 <br/>";
		}

	}

	public function postNotify(Request $request) {
		$alipay_config = config('alipay');
		$alipayNotify  = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if ($verify_result) {
			$order_number = $request->input('out_trade_no');
			$trade_no     = $request->input('trade_no');
			$trade_status = $request->input('trade_status');

			if ($trade_status == 'WAIT_BUYER_PAY') {
				// 还没有付款
				echo "success";
			} else if ($trade_status == 'WAIT_SELLER_SEND_GOODS') {
				// 等待发货
				echo 'success';
//				echo "trade_status = " . $trade_status;
			} else if ($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
				// 卖家已发货,买家未确认收获
				echo "success";
			} else if ($trade_status == 'TRADE_FINISHED') {
				// 确认收获,交易完成
				echo "success";
			} else {
				// 其他状态
				echo "success";
			}
		} else {
			echo "fail";
		}
	}

	public function getTrade(Request $request, Order $order) {

		if ($order->user->id == Auth::user()->id) {
			//支付类型
			$payment_type = "1";
			//服务器异步通知页面路径
			$notify_url = "http://highwaygo.localhost.com/alipay/notify";
			//页面跳转同步通知页面路径
			$return_url = "http://highwaygo.localhost.com/alipay/return";
			//商户订单号
			$out_trade_no = $order->number;
			//订单名称
			$subject = '订单号' . $order->number;
			//付款金额
			$price = $order->price;
			//商品数量
			$quantity = 1;
			//物流费用
			$logistics_fee = "0.00";
			//物流类型
			$logistics_type = "EXPRESS";
			//必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
			$logistics_payment = "SELLER_PAY";
			//必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
			$body = "海外购支付订单,来自用户" . $order->user->name;
			//商品展示地址
			$show_url = "http://highwaygo.localhost.com/order/" . $order->id;
			//收货人姓名
			$receive_name = $order->address->name;
			//收货人地址
			$receive_address = $order->address->address;
			//收货人邮编
			$receive_zip = $order->address->pc;
			//收货人电话号码
			$receive_phone = '0595-22588870';
			//收货人手机号码
			$receive_mobile = $order->address->mobile;
			/************************************************************/
			$alipay_config = config('alipay');
//			dd($alipay_config['cacert']);
			//构造要请求的参数数组，无需改动
			$parameter = array(
				"service"           => "create_partner_trade_by_buyer",
				"partner"           => trim($alipay_config['partner']),
				"seller_email"      => trim($alipay_config['seller_email']),
				"payment_type"      => $payment_type,
				"notify_url"        => $notify_url,
				"return_url"        => $return_url,
				"out_trade_no"      => $out_trade_no,
				"subject"           => $subject,
				"price"             => $price,
				"quantity"          => $quantity,
				"logistics_fee"     => $logistics_fee,
				"logistics_type"    => $logistics_type,
				"logistics_payment" => $logistics_payment,
				"body"              => $body,
				"show_url"          => $show_url,
				"receive_name"      => $receive_name,
				"receive_address"   => $receive_address,
				"receive_zip"       => $receive_zip,
				"receive_phone"     => $receive_phone,
				"receive_mobile"    => $receive_mobile,
				"_input_charset"    => trim(strtolower($alipay_config['input_charset'])),
			);

			//建立请求
			$alipaySubmit = new \AlipaySubmit($alipay_config);
			$html_text    = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
			return $html_text;
		} else {
			return redirect('/user/order');
		}

	}

}