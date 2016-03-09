<h3 class="main-title">我的订单</h3>
<hr>
<table class="table table-responsive">
    <thead>
    <tr>
        <th class="col-md-2 text-center">订单号</th>
        <th class="col-md-2 text-center hidden-xs">下单时间</th>
        <th class="col-md-1 text-center hidden-xs">支付类型</th>
        <th class="col-md-3 text-center">订单状态</th>
        <th class="col-md-1 text-center">物流状态</th>
        <th class="col-md-3 text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    @forelse($orders as $order)
        <tr>
            <td class="col-md-2 text-center" style="vertical-align: middle">
                {{$order->number}}
            </td>
            <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                {{$order->created_at->diffForHumans()}}
            </td>
            <td class="col-md-1 text-center hidden-xs" style="vertical-align: middle">
                {{$order->pay_type}}
            </td>
            <td class="col-md-3 text-center" style="vertical-align: middle">
                {{$order->status}}
            </td>
            <td class="col-md-1 text-center" style="vertical-align: middle">
                {{$order->delivery ? '已发货' : '待发货'}}
            </td>
            <td class="col-md-3 text-center" style="vertical-align: middle">
                @if($order->status == '已取消')
                    <a class="btn btn-info disabled">已取消</a>
                @else
                    @if($order->status == '尚未付款')
                        <a href="/order/cancle/{{$order->id}}" class="btn btn-warning">取消订单</a>
                    @endif
                        <a href="/order/{{$order->id}}" class="btn">查看订单详情</a>
                @endif
            </td>
        </tr>
    @empty
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6">
            <h1 class="text-center color-grey"><i class="glyphicon glyphicon-heart-empty"></i> 你还没有订单哟</h1>
        </th>
    </tr>
    </tfoot>
    @endforelse
</table>
<div class="text-center">
{!! $orders->render() !!}
</div>