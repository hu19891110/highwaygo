<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use App\Models\Favorite;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ItemController extends Controller {

	public function __construct() {
		$this->middleware('auth', ['only' => ['anySearch', 'getFavorite']]);
	}

	public function getId(Request $request, Item $item) {

		$page    = intval($request->input('page', 1));
		$perpage = 10;
//		$item    = Item::find($id, ['id', 'name', 'brief', 'classification_id', 'stock', 'price', 'number', 'thumb_img']);
		//		if ($item == null) {
		//			return redirect('/');
		//		}
		$id     = $item->id;
		$detail = Cache::rememberForever("item.detail.{$item->id}", function () use ($id) {
			return Item::find($id, ['detail']);
		});
		$imgs = Cache::rememberForever("item.imgs.{$item->id}", function () use ($item) {
			return $item->imgs;
		});
		$comments = Cache::rememberForever("item.comments.{$id}.{$page}", function () use ($item, $page, $perpage) {
			/** 有问题 */
			return $item->comments()->paginate($perpage);
		});
		$recommend_items = Cache::rememberForever('item.recommend_items', function () {
			return Item::take(4)->get();
		});
		$favorite = Auth::check() ? $item->favorites()->where('user_id', '=', Auth::user()->id)->first() : null;

		return view('home.item.detail')
			->with('title', $item->name)
			->with('item', $item)
			->with('recommend_items', $recommend_items)
			->with('detail', $detail->detail)
			->with('favorite', $favorite)
			->with('imgs', $imgs);
	}

	public function anySearch(Request $request) {
		$perpage      = 12;
		$keywords     = $request->input('keywords');
		$raw_keywords = $keywords;
		$keywords     = explode(' ', $keywords);
		$result       = Item::where(function ($query) use ($keywords) {
			foreach ($keywords as $keyword) {
				if (is_numeric($keyword)) {
					$query->orWhereRaw('number like ?', ["%{$keyword}%"]);
				} else {
					$query->orWhereRaw('name like ?', ["%{$keyword}%"])
						->orWhereRaw('brief like ?', ["%{$keyword}%"]);
				}

			}
		})->paginate($perpage);
		return view('home.item.search')
			->with('title', $raw_keywords)
			->with('result', $result);
	}

	public function getList($id = null) {
		$perpage = 12;
		if ($id && $id > 0) {
			$classification = Classification::find($id);
			if ($classification) {
				$result = $classification->items()->paginate($perpage);
				return view('home.item.search')
					->with('title', $classification->name)
					->with('result', $result);
			}
		}
		$classifications = Cache::rememberForever('item.classifications', function () {
			$roots = Classification::whereRaw('parent_id is null')->get();
			return $roots->map(function ($classification) {
				return ['id' => $classification->id, 'name' => $classification->name, 'children' => $classification->classifications()->get()];
			});
		});
		return view('home.item.classifications')
			->with('classifications', $classifications)
			->with('title', '所有商品分类');
	}

	public function getFavorite(Request $request, Item $item) {
		if (Auth::user()->favorites()->where('item_id', '=', $item->id)->first() === null) {
			$favorite          = new Favorite;
			$favorite->user_id = Auth::user()->id;
			$favorite->item_id = $item->id;
			$favorite->save();
		}
		return redirect()->back();
	}

}
