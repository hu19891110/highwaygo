<h3 class="main-title">修改密码</h3>
<hr>
<div class="col-md-6 col-md-offset-3">
    @if(count($errors))
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible text-right" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{$error}}</strong>
            </div>
        @endforeach
    @endif
    {!! Form::open(['class' => 'form-horizontal', 'method' => 'post']) !!}
        <div class="form-group">
            <label class="col-sm-3 control-label">邮箱</label>
            <div class="col-sm-9">
                <input name="email" type="email" class="form-control disabled" value="{{$user->email}}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">原密码</label>
            <div class="col-sm-9">
                <input name="password" type="password" class="form-control" id="password" placeholder="原密码">
            </div>
        </div>
        <div class="form-group">
            <label for="new_password" class="col-sm-3 control-label">新密码</label>
            <div class="col-sm-9">
                <input name="new_password" type="password" class="form-control" id="new_password" placeholder="新密码">
            </div>
        </div>
        <div class="form-group">
            <label for="new_password_confirmation" class="col-sm-3 control-label">确认密码</label>
            <div class="col-sm-9">
                <input name="new_password_confirmation" type="password" class="form-control" id="new_password_confirmation" placeholder="新密码">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">确定</button>
            </div>
        </div>
    {!! Form::close() !!}
</div>