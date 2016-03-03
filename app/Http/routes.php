<?php

Route::group(['middleware' => ['auth.admin'], 'namespace' => 'Admin'], function () {
	Route::controller('admin', 'IndexController');
});