<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Item;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller {

	public function __construct() {

	}

	public function getIndex() {
		$banners = Cache::rememberForever('index.banners', function () {
			return Banner::get();
		});
		$newest_items = Cache::rememberForever('item.newest_items', function () {
			return Item::where('stock', '>', '0')->orderBy('created_at', 'desc')->take(8)->get();
		});
		$hot_items = Cache::rememberForever('item . hot_items', function () {
			return Item::where('stock', '>', '0')->take(8)->get();
		});
		$recommend_items = Cache::rememberForever('item . recommend_items', function () {
			return Item::where('stock', '>', '0')->take(4)->get();
		});
		return view('home.index')
			->with('banners', $banners)
			->with('newest_items', $newest_items)
			->with('hot_items', $hot_items)
			->with('recommend_items', $recommend_items)
			->with('title', 'HighwayGo');
	}
}