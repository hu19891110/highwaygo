@extends('layouts.home')

@section('content')
    @parent
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <br>
                <h3 class="text-center">手机登陆</h3>
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
                    <label for="captcha" class="col-sm-2 col-xs-12 control-label">手机号</label>
                    <div class="col-sm-8 col-xs-6">
                        <input type="text" value="{{old('mobile')}}" maxlength="11" value="{{old('captcha')}}" class="form-control" id="mobile" name="mobile" placeholder="手机号">
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <button id="send-btn" class="btn btn-info" >发送</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-sm-2 control-label">验证码</label>
                    <div class="col-sm-10">
                        <input type="text" disabled value="{{old('token')}}" maxlength="{{config('mobile.token_length', 6)}}" class="form-control" id="token" name="token" placeholder="验证码">
                    </div>
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
                        <button type="submit" class="login-btn btn btn-default" disabled>登陆</button>  <a class="btn" href="/auth/login">邮箱登陆</a>
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
            function openClock(obj, time) {
                obj.attr('disabled', 'disabled').html('还剩下' + time + '秒')
                if(time <= 0) {
                    obj.removeAttr('disabled').html('发送')
                    return
                }
                setTimeout(function() {
                    openClock(obj, --time)
                }, 1000)
            }
            var availableSendIn = {{$availableSendIn}}
            var send_btn = $("#send-btn")
            if(availableSendIn > 0) {
                openClock(send_btn, availableSendIn)
            }
            $("#mobile").removeAttr('disabled')
            $("#token").attr('disabled', 'disabled')
            openClock(send_btn, 0)
            send_btn.click(function() {
                $.post('/auth/login-send', $('#login-form').serialize(), function(json) {
                    if(json.code == 0) {
                        openClock(send_btn, 60)
                        $("#mobile").attr('disabled', 'disabled')
                        $("#token").removeAttr('disabled')
                        $("#login-btn").removeAttr('disabled')
                        modal({
                            title: '发送成功',
                            message: '短信验证码已经发送到你的手机上,有效时间5分钟',
                            btns: ['close']
                        })
                    } else if (json.code > 0) {
                        var message = ''
                        for(var i in json.message) {
                            message += "<p>" + json.message[i] + "</p>"
                        }
                        modal({
                            title: '失败了',
                            message: message,
                            btns: ['close']
                        })
                    } else {
                        modal({
                            title: '失败了',
                            message: json.message,
                            btns: ['close']
                        })
                    }
                }, 'json')
                return false
            })
        })
    </script>
@stop