<h3 class="main-title">修改密码</h3>
<hr>
<div class="col-md-6 col-md-offset-3">
    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-3 control-label">邮箱</label>
            <div class="col-sm-9">
                <input type="email" class="form-control disabled" value="{{$user->email}}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">原密码</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="password" placeholder="原密码">
            </div>
        </div>
        <div class="form-group">
            <label for="new_password" class="col-sm-3 control-label">新密码</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="new_password" placeholder="新密码">
            </div>
        </div>
        <div class="form-group">
            <label for="new_password_confirmation" class="col-sm-3 control-label">确认密码</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="new_password_confirmation" placeholder="新密码">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">确定</button>
            </div>
        </div>
    </form>
</div>