<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ItemController extends Controller {

	public function __construct() {
		$this->middleware('auth', ['only' => ['anySearch']]);
	}

	public function getId(Request $request, $id) {
		return $id;
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
//
	//	public function getGe() {
	//		$items = [
	//			[
	//				'name'              => '洗面奶1',
	//				'brief'             => '这是洗面奶1的简介',
	//				'detail'            => '这是洗面奶1的详情',
	//				'classification_id' => 2,
	//				'stock'             => 1,
	//				'price'             => 1.1,
	//			],
	//			[
	//				'name'              => '洗面奶2',
	//				'brief'             => '这是洗面奶2的简介',
	//				'detail'            => '这是洗面奶2的详情',
	//				'classification_id' => 2,
	//				'stock'             => 2,
	//				'price'             => 2.2,
	//			],
	//			[
	//				'name'              => '洗发露1',
	//				'brief'             => '这是洗发露1的简介',
	//				'detail'            => '这是洗发露1的详情',
	//				'classification_id' => 4,
	//				'stock'             => 40,
	//				'price'             => 4.4,
	//			],
	//			[
	//				'name'              => '眼影1',
	//				'brief'             => '这是眼影1的简介',
	//				'detail'            => '这是眼影1的详情',
	//				'classification_id' => 6,
	//				'stock'             => 6,
	//				'price'             => 6.66,
	//			],
	//			[
	//				'name'              => '饮料',
	//				'brief'             => '这是饮料1的简介',
	//				'detail'            => '这是饮料1的详情',
	//				'classification_id' => 11,
	//				'stock'             => 111,
	//				'price'             => 11.11,
	//			],
	//		];
	//		foreach ($items as $item) {
	//			$itemModel                    = new Item;
	//			$itemModel->name              = $item['name'];
	//			$itemModel->brief             = $item['brief'];
	//			$itemModel->detail            = $item['detail'];
	//			$itemModel->classification_id = $item['classification_id'];
	//			$itemModel->stock             = $item['stock'];
	//			$itemModel->price             = $item['price'];
	//			$itemModel->thumb_img         = '/img/tests/thumb.jpg';
	//			$itemModel->save();
	//		}
	//	}

}