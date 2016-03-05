<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ItemController extends Controller {
	public function getId(Request $request, $id) {
		return $id;
	}
}