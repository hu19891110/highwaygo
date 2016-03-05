<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller {

	public function __construct() {
		$this->middleware('auth.view');
	}

	public function getIndex() {
		$banners = Cache::rememberForever('index.banners', function () {
			return Banner::get();
		});
//		dd($banners);
		return view('home.index')
			->with('banners', $banners)
			->with('title', 'HighwayGo');
	}

	public function anySearch(Request $request) {
		dd($request->all());
	}

	public function getList() {
		return '';
	}
}