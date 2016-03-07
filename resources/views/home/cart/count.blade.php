@extends('layouts.home')

@section('content')
    <div class="container">

        <br>
        <div class="row well">
            <h3 class="main-title"><i class="glyphicon glyphicon-credit-card"></i> 购物车结算</h3>
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th class="col-md-1 text-center hidden-sm hidden-xs">缩略图</th>
                    <th class="col-md-2 text-center">商品名称</th>
                    <th class="col-md-2 text-center hidden-xs">单价</th>
                    <th class="col-md-3 text-center hidden-xs">数量</th>
                    <th class="col-md-2 text-center hidden-xs">总价</th>

                    <th class="col-md-7 text-center visible-xs">价格</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="col-md-1 text-center hidden-sm hidden-xs">
                            <img width="100" src="{{$item[0]->thumb_img}}" alt="{{$item[0]->name}}">
                        </td>
                        <td class="col-md-1 text-center" style="vertical-align: middle">
                            {{$item[0]->name}}
                        </td>
                        <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                            <span class="">￥{{$item[0]->price}}</span>
                        </td>
                        <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                            <span class="" style="position: relative; top: 2px;">{{$item[1]}}</span>
                        </td>
                        <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                            <span class="">￥{{$item[1] * $item[0]->price}}</span>
                        </td>
                        <td class="col-md-7 text-center visible-xs" style="vertical-align: middle">
                            <span>
                                ￥{{$item[0]->price}} *
                                {{$item[1]}}
                                 =￥{{$item[1] * $item[0]->price}}
                            </span>
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
            {!! Form::open(['url' => '/cart/order']) !!}
                <table class="table table-responsive">
                    <tr>
                        <td class="col-md-2 text-right" style="vertical-align: middle">
                            <label for="addresses">送货地址:</label>
                        </td>
                        <td class="col-md-10" style="vertical-align: middle">

                            @if(count($addresses))
                                <select id="addresses" name="address" class="form-control">
                                    @foreach($addresses as $address)
                                        <option value="{{$address->id}}">{{$address->name}} - {{$address->mobile}} - {{$address->address}}</option>
                                    @endforeach
                                </select>
                            @else
                                <a href="/user">没有收获地址? 去个人中心添加</a>
                            @endif
                        </td>
                    </tr>
                    {{--<tr>--}}
                        {{--<td class="col-md-2 text-right" style="vertical-align: middle">--}}
                            {{--<label for="pay_type">支付方式:</label>--}}
                        {{--</td>--}}
                        {{--<td class="col-md-10" style="vertical-align: middle">--}}
                            {{--<select id="pay_type" name="pay_type" class="form-control">--}}
                                {{--<option value="alipay">支付宝</option>--}}
                            {{--</select>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    <tr>
                        <td class="col-md-2 text-right" style="vertical-align: middle">
                            <label for="mark">备注:</label>
                        </td>
                        <td class="col-md-10" style="vertical-align: middle">
                            <input id="mark" name="mark" type="text" class="form-control" placeholder="备注">
                        </td>
                    </tr>
                </table>
                <hr>
                <div class="text-right">
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-success btn-lg {{count($addresses)?'':'disabled'}}" {{count($addresses)?'':'disabled'}}><i class="glyphicon glyphicon-list-alt"></i> 确认订单</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop