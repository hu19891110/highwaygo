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
                <div class="form-group captcha-field">
                    @if($needCaptcha)
                    <label for="captcha" class="col-sm-2 col-xs-12 control-label">验证码</label>
                    <div class="col-sm-4 col-xs-6">
                        <input type="text" maxlength="5" value="{{old('captcha')}}" class="form-control" id="captcha" name="captcha" placeholder="验证码">
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        {!! captcha_img() !!}
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{old('remember')? 'checked':''}} > 记住我
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                        <button type="submit" id="submit" class="btn btn-default">登陆</button>  <a class="btn" href="/auth/mobile-login">短信登陆</a>  <a class="btn" href="/password/email">忘记密码?</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('ext_scripts')
    @parent
    {!! Html::script('/js/dismiss-alert.js') !!}
    <script>
        $(function() {
            $('.captcha-field').on('click', 'img[alt=captcha]', function() {
                $(this).attr('src', '/captcha/default?' + (new Date()).valueOf())
            })

            $("#password").blur(function() {
                $.get('/auth/need-captcha', function(needCaptcha) {
                    if(needCaptcha == 0) {
                        $('.captcha-field').children().remove()
                    } else if ($('img[alt=captcha]').length > 0) {
                        return false
                    } else {
                        $('.captcha-field')
                                .append('<label for="captcha" class="col-sm-2 col-xs-12 control-label">验证码</label>')
                                .append('<div class="col-sm-4 col-xs-6"><input type="captcha" maxlength="5" class="form-control" id="captcha" name="captcha" placeholder="验证码"> </div>')
                                .append($('<div class="col-sm-6 col-xs-6">').append($('<img alt="captcha">').attr('src', '/captcha/default?' + (new Date()).valueOf())))
                    }
                })
            })
        })
    </script>
@stop