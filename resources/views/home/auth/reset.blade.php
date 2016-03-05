@extends('layouts.home')

@section('content')
    @parent
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <br>
                <h3 class="text-center">帐号登陆</h3>
                <hr>
                @if(count($errors))
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible text-right" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>{{$error}}</strong>
                        </div>
                    @endforeach
                @endif


                {!! Form::open(['method' => 'post', 'class' => 'form-horizontal', 'id' => 'login-form']) !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="email" value="{{old('email')}}" class="form-control" id="email" name="email" placeholder="邮箱">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" placeholder="密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" placeholder="确认密码">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" id="submit" class="btn btn-default">重置密码</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}


            </div>
        </div>

@stop