<div class="user-index">
    <table class="table">
        <tr>
            <td class="col-md-2">
                <img src="{!! $user->portrait !!}#" alt="{!! $user->portrait !!}" class="portrait" >
            </td>
            <td class="col-md-10 text-left" style="vertical-align: middle;">
                您好, {{$user->name}} !
            </td>
        </tr>
    </table>
    <hr>
    <div>
        <div class="col-sm-6">
            <div class="well text-center">
                <a href="/user/password" class="btn"><i class="glyphicon glyphicon-lock"></i> 修改密码</a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well text-center">
                <a href="/user/address" class="btn"><i class="glyphicon glyphicon-map-marker"></i> 收获地址</a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well text-center">
                <a href="/user/favorite" class="btn"><i class="glyphicon glyphicon-heart"></i> 我的收藏</a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well text-center">
                <a href="/user/order" class="btn"><i class="glyphicon glyphicon-list-alt"></i> 我的订单</a>
            </div>
        </div>
    </div>
</div>

<h1>


</h1>