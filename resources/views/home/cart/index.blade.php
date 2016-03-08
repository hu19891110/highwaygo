@extends('layouts.home')
@section('content')
    <div class="container">
        <br>
        <div class="row well">
            <h3 class="main-title"><i class="glyphicon glyphicon-shopping-cart"></i> 购物车清单</h3>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th class="col-md-1 text-center hidden-sm hidden-xs">缩略图</th>
                        <th class="col-md-2 text-center">商品名称</th>
                        <th class="col-md-2 text-center hidden-xs">单价</th>
                        <th class="col-md-3 text-center hidden-xs">数量</th>
                        <th class="col-md-2 text-center hidden-xs">总价</th>
                        <th class="col-md-7 text-center visible-xs">价格</th>
                        <th class="col-md-2 text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="col-md-1 text-center hidden-sm hidden-xs">
                            <img width="100" src="{{$item[0]->thumb_img}}" alt="{{$item[0]->name}}">
                        </td>
                        <td class="col-md-1 text-center" style="vertical-align: middle">
                            <a href="/item/{{$item[0]->id}}">{{$item[0]->name}}</a>
                        </td>
                        <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                            <span class="well well-sm">￥{{$item[0]->price}}</span>
                        </td>
                        <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                            <a href="/cart/remove/{{$item[0]->id}}/1" class="btn btn-success"><i class="glyphicon glyphicon-minus"></i></a>
                            <span class="well well-sm" style="position: relative; top: 2px;">{{$item[1]}}</span>
                            <a href="{!!$item[1] >= $item[0]->stock ? '#': '/cart/add/' . $item[0]->id . '/1'!!}" class=" btn btn-success {{$item[1] >= $item[0]->stock ? 'disabled': ''}}"><i class="glyphicon glyphicon-plus"></i></a>
                        </td>
                        <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                            <span class="well well-sm">￥{{$item[1] * $item[0]->price}}</span>
                        </td>
                        <td class="col-md-7 text-center visible-xs" style="vertical-align: middle">
                            <span class="well well-sm">
                                ￥{{$item[0]->price}} *
                                (<a style="position: relative; top: -2px;" href="/cart/remove/{{$item[0]->id}}/1" class="btn btn-success"><i class="glyphicon glyphicon-minus"></i></a>
                                {{$item[1]}}
                                <a style="position: relative; top: -2px;" href="{!!$item[1] >= $item[0]->stock ? '#': '/cart/add/' . $item[0]->id . '/1'!!}" class=" btn btn-success {{$item[1] >= $item[0]->stock ? 'disabled': ''}}"><i class="glyphicon glyphicon-plus"></i></a>
                                ) =￥{{$item[1] * $item[0]->price}}
                            </span>
                        </td>
                        <td class="col-md-4 text-center" style="vertical-align: middle">
                            <a href="/cart/remove/{{$item[0]->id}}/{{$item[1]}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                        </td>
                    </tr>
                @empty
                </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">
                                <h1 class="text-center color-grey"><i class="glyphicon glyphicon-info-sign"></i> 还没有东西哟</h1>
                            </th>
                        </tr>
                    </tfoot>
                @endforelse
            </table>
            <hr>
            <div class="text-right">
                <div class="btn-group" role="group" aria-label="...">
                    <a href="/" type="button" class="btn btn-info btn-lg"><i class="glyphicon glyphicon-home"></i> 继续购物</a>
                    <a href="/cart/clear" type="button" class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-trash"></i> 清空购物车</a>
                    <a href="/cart/count" type="button" class="btn btn-success btn-lg {{count($items) == 0 ? 'disabled': ''}}"><i class="glyphicon glyphicon-credit-card"></i> 去结算</a>
                </div>
            </div>
        </div>
        <hr>
    </div>
@stop