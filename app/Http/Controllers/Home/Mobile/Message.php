<?php

namespace App\Http\Controllers\Home\Mobile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Message {

	/**
	 * @param Request $request
	 * @return bool
	 */
	public static function send(Request $request) {
		$modelName = config('mobile.model', 'App\Models\Message');
		$mobile    = $request->input('mobile');
		$token     = self::rand(config('mobile.token_length', 6));
		if ($model = self::getModel($modelName, $mobile)) {
			$token = $model->token;
		} else {
			$model         = new $modelName;
			$model->ip     = $request->ip();
			$model->token  = $token;
			$model->mobile = $request->input('mobile');
			$model->save();
		}
		$token; // 发送的token
		$mobile; // 发送的手机号
		return true;
	}

	/**
	 * @param Request $request
	 * @return bool
	 */
	public static function verify(Request $request) {
		$model = self::getModel(
			config('mobile.model', 'App\Models\Message'),
			$request->input('mobile', '')
		);
		if ($model && $model->token === $request->input('token', '')) {
			$model->active = 1;
			$model->save();
			return true;
		}
		return false;
	}

	/**
	 * @param $modelName
	 * @param $mobile
	 * @return mixed
	 */
	protected static function getModel($modelName, $mobile) {
		return $modelName::where('mobile', '=', $mobile)
//			->where('token', '=', $token)
			->where('active', '=', 0)
			->whereRaw('unix_timestamp(created_at) > ?', [Carbon::now()->timestamp - config('mobile.time', 5) * 60])->get()->first();
	}

	/**
	 * @param $length
	 * @return string
	 */
	protected static function rand($length) {
		$length = intval($length);
		$token  = '';
		for ($i = 0; $i <= $length % 4; ++$i) {
			$token .= mt_rand(1000, 9999);
		}
		return substr($token, 0, $length);
	}
}
