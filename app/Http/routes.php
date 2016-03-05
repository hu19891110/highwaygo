<?php

/*
/search?keywords=
/[index] or /[home]
/list
/user/[index]
/auth/logout
/auth/login
/auth/register
/car/[index]
/admin/[index]
 */
// 后台接口
Route::group(['middleware' => ['auth.admin'], 'namespace' => 'Admin'], function () {
	Route::controller('admin', 'IndexController');
});
// 前台接口
Route::group(['namespace' => 'Home', 'middleware' => ['auth.view']], function () {
	Route::get('home', 'IndexController@getIndex');
	Route::any('search', 'ItemController@anySearch');
	Route::get('list/{id?}', 'ItemController@getList')->where('id', '[0-9]+');
	Route::get('item/{id}', 'ItemController@getId')->where('id', '[0-9]+');
	Route::controller('item', 'ItemController');
	Route::controller('auth', 'AuthController');
	Route::controller('password', 'PasswordController');
	Route::group(['middleware' => ['auth']], function () {
		Route::controller('car', 'CarController');
		Route::controller('user', 'UserController');
	});
	Route::get('captcha/{config?}', '\Mews\Captcha\CaptchaController@getCaptcha');
	Route::controller('/', 'IndexController');
});
