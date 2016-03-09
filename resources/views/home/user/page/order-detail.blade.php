<h3 class="main-title">订单详情</h3>
<br>


<h4>基础信息</h4>
<table class="table table-responsive">
    
    <tr>
        <td class="col-xs-4 col-sm-3 text-right">订单号 </td>
        <td class="col-xs-8 col-sm-9">{{$order->number}}</td>
    </tr>
    <tr>
        <td class="col-xs-4 col-sm-3 text-right">下单时间 </td>
        <td class="col-xs-8 col-sm-9">
            {{$order->created_at->diffForHumans()}}
        </td>
    </tr>
    <tr>
        <td class="col-xs-4 col-sm-3 text-right">订单收获地址 </td>
        <td class="col-xs-8 col-sm-9">
            {{$order->address->name}} - {{$order->address->mobile}} - {{$order->address->address}}
        </td>
    </tr>
    <tr>
        <td class="col-xs-4 col-sm-3 text-right">支付信息 </td>
        <td class="col-xs-8 col-sm-9">
            @if($order->status == '尚未付款')
                <a href="/alipay/pay/{{$order->id}}">去支付</a>
            @elseif ($order->status == '已退款')
                已退款
            @elseif ($order->status == '退款中')
                退款中
            @elseif($order->status == '已取消')
                已取消
            @elseif($order->status == '已付款' or $order->status == '已发货')
                流水号{{$order->trade_no}}
            @endif
        </td>
    </tr>

</table>

<hr>
<h4>商品信息</h4>

<table class="table table-responsive">
    <tr>
        <th class="col-md-3 text-center  hidden-xs">缩略图</th>
        <th class="col-md-3 text-center col-xs-4">商品名称</th>
        <th class="col-md-3 text-center col-xs-4">数量</th>
        <th class="col-md-3 text-center col-xs-4">总价</th>
    </tr>
    @forelse($order->items as $order_item)
        <tr>
            <td class="text-center hidden-xs">
                <img width="100" src="{{$order_item->item->thumb_url}}" alt="{{$order_item->item->name}}">
            </td>
            <td class="text-center" style="vertical-align: middle">
                <a href="/item/{{$order_item->item->id}}">{{$order_item->item->name}}</a>
            </td>
            <td class="text-center" style="vertical-align: middle">
                <span class="well well-sm">{{$order_item->count}}</span>
            </td>
            <td class="text-center" style="vertical-align: middle">
                @if($order_item->price)
                    ￥{{$order_item->price}} * {{ $order_item->count}}
                @else
                    ￥{{$order_item->item->price * $order_item->count}}
                @endif
            </td>
        </tr>
    @empty
    <tr>
        <th colspan="4">
            <h1 class="text-center color-grey"><i class="glyphicon glyphicon-heart-empty"></i> 该订单没有任何商品? (ps: 不科学啊)</h1>
        </th>
    </tr>
    @endforelse
    <tr>
        <td colspan="2"></td>
        <td class="hidden-xs"></td>
        <td class="text-center">
            ￥{{$order->price}}
        </td>
    </tr>
</table>

@if($order->delivery)
    <hr>
    <h4>快递信息</h4>
@else
    <hr>
    <h4>还没有物流信息</h4>
@endif