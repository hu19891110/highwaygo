<div class="text-right">
    <a href="/user/add-address" class="btn btn-success">增加</a>
</div>
<hr>
<table class="table table-responsive">
    <thead>
    <tr>
        <th class="col-md-2 text-center">手机号</th>
        <th class="col-md-2 text-center hidden-xs">名字</th>
        <th class="col-md-4 text-center">收获地址</th>
        <th class="col-md-1 text-center">激活</th>
        <th class="col-md-3 text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    @forelse($addresses as $address)
        <tr>
            <td class="col-md-2 text-center">
                {{$address->mobile}}
            </td>
            <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
                {{$address->name}}
            </td>
            <td class="col-md-4 text-center" style="vertical-align: middle">
                <span class="well well-sm">{{$address->address}}</span>
            </td>
            <td class="col-md-1 text-center" style="vertical-align: middle">
                {{$address->active ? '是': '否'}}
            </td>
            <td class="col-md-3 text-center">
                <a href="/user/address/delete/{{$address->id}}" class="btn btn-danger">删除</a>
            </td>
        </tr>
    @empty
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6">
            <h1 class="text-center color-grey"><i class="glyphicon glyphicon-heart-empty"></i> 你还没有收藏东西哟</h1>
        </th>
    </tr>
    </tfoot>
    @endforelse
</table>
<div class="text-center">
    {!! $addresses->render() !!}
</div>