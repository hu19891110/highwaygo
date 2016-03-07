<nav class="navbar navbar-default navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {!! Html::image('logo.png', 'logo', ['class' => 'navbar-brand']) !!}
            <a href="/" class="navbar-brand" style="font-family: swistblnk;letter-spacing: 4px;font-size: 25px;">
                &nbsp;HighwayGo
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <li><a href="/"><i class="glyphicon glyphicon-home"></i> 首页</a></li>
                <li><a href="/list"><i class="glyphicon glyphicon-list"></i> 所有分类</a></li>
            </ul>
            <form action="/search" class="navbar-form navbar-right" role="search">
                <div class="input-group">
                    <input type="text" autocomplete="off" value="{{old('keywords')}}" name="keywords" class="form-control search-input" placeholder="商品名称或编码">
                    <span class="input-group-btn search-fields">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                @if(isset($user))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {!! $user->portrait?'<img src="' . $user->portrait . '" class="portrait">': '<i class="glyphicon glyphicon-user"></i>' !!} {{$user->name}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/user/index"><i class="glyphicon glyphicon-user"></i> 个人中心</a></li>
                            @if($user->hasRole(['admin', 'courier']))
                                <li><a href="/admin/index"><i class="glyphicon glyphicon-cog"></i> 后台中心</a></li>
                            @endif
                            <li><a href="/auth/logout"><i class="glyphicon glyphicon-log-out"></i> 注销</a></li>
                        </ul>
                    </li>
                    <li><a href="/cart/index"><i class="glyphicon glyphicon-shopping-cart"></i> 购物车</a></li>
                @else
                    <li><a href="/auth/login"><i class="glyphicon glyphicon-user"></i> 登陆</a></li>
                    <li><a href="/auth/register"><i class="glyphicon glyphicon-registration-mark"></i> 注册</a></li>
                @endif

            </ul>
        </div>
    </div>
</nav>

@section('ext_styles')
    @parent
    {!! Html::style('css/home/header.css') !!}
@stop
