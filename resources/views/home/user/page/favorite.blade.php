<table class="table table-responsive">
    <thead>
    <tr>
        <th class="col-md-3 text-center">缩略图</th>
        <th class="col-md-3 text-center">商品名称</th>
        <th class="col-md-3 text-center hidden-xs">收藏时间</th>
        <th class="col-md-3 text-center">操作</th>
    </tr>
    </thead>
    <tbody>
@forelse($favorites as $favorite)
    <tr>
        <td class="col-md-1 text-center">
            <img width="100" src="{{$favorite->item->thumb_img}}" alt="{{$favorite->item->name}}">
        </td>
        <td class="col-md-1 text-center" style="vertical-align: middle">
            <a href="/item/{{$favorite->item->id}}">{{$favorite->item->name}}</a>
        </td>
        <td class="col-md-2 text-center hidden-xs" style="vertical-align: middle">
            <span class="well well-sm">{{$favorite->created_at}}</span>
        </td>
        <td class="col-md-4 text-center" style="vertical-align: middle">
            <a href="/item/favorite/{{$favorite->item->id}}" class="btn btn-warning">取消收藏 </a>
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
    {!! $favorites->render() !!}
</div>