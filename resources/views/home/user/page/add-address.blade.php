<h3 class="main-title">增加收货地址</h3>
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
        <label for="mobile" class="col-sm-3 col-xs-12 control-label">手机号</label>
        <div class="col-sm-7 col-xs-8">
            <input type="text" value="{{old('mobile')}}" maxlength="11" value="{{old('captcha')}}" class="form-control" id="mobile" name="mobile" placeholder="手机号">
        </div>
        <div class="col-sm-2 col-xs-4">
            <button disabled id="send-btn" class="btn btn-info" >发送</button>
        </div>
    </div>
        <div class="form-group">
            <label for="token" class="col-sm-3 control-label">验证码</label>
            <div class="col-sm-9">
                <input type="text" value="{{old('token')}}" maxlength="{{config('mobile.token_length', 6)}}" class="form-control" id="token" name="token" placeholder="验证码">
            </div>
        </div>
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">名字</label>
        <div class="col-sm-9">
            <input name="name" type="text" class="form-control" id="name" placeholder="名字">
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-sm-3 control-label">收货地址</label>
        <div class="col-sm-9">
            <input name="address" type="text" class="form-control" id="address" placeholder="收货地址">
        </div>
    </div>
        <div class="form-group">
            <label for="pc" class="col-sm-3 control-label">邮编</label>
            <div class="col-sm-9">
                <input name="pc" type="text" class="form-control" id="pc" placeholder="邮编">
            </div>
        </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button id="add-btn" type="submit" class="btn btn-default" disabled>确定</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>



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
            var send_btn = $('#send-btn')
            $("#add-btn").removeAttr('disabled')
            openClock(send_btn,  availableSendIn > 0 ? availableSendIn : 0 )
            send_btn.click(function() {
                $.post('/user/add-address-send', {
                    mobile: $("#mobile").val()
                }, function(json) {
                    if(json.code == 0) {
                        openClock(send_btn, 60)
//                        $("#mobile").attr('disabled', 'disabled')
                        $("#token").removeAttr('disabled')
                        $("#add-btn").removeAttr('disabled')
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