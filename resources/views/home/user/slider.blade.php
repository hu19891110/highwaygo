<?php
    $menus = [
        [
                'index' => '<i class="glyphicon glyphicon-home"></i> 首页',
//                'info' => '<i class="glyphicon glyphicon-user"></i> 个人信息',
                'address' => '<i class="glyphicon glyphicon-map-marker"></i> 收获地址',
                'password' => '<i class="glyphicon glyphicon-lock"></i> 修改密码',
        ],
        [
                'favorite' => '<i class="glyphicon glyphicon-heart"></i> 我的收藏',
                'order' => '<i class="glyphicon glyphicon-list-alt"></i> 我的订单',
        ]
    ];
?>

<div class="col-sm-3 col-md-2 sidebar">
    @foreach($menus as $menu)
        <ul class="nav nav-sidebar">
            @foreach($menu as $key => $value)
                <li {!! $key == $page ? ' class="active"': '' !!}>
                    <a href="/user/{!! $key !!}">
                        {!! $value !!}
                        {!! $key == $page ? ' <span class="sr-only">(current)</span>': '' !!}
                    </a>
                </li>
            @endforeach
        </ul>
    @endforeach
</div>

<div class="hidden-md hidden-lg hidden-sm xs-side">
    <div class="menu">
        <button class="toggle"><i id="icon-toggle" class="glyphicon glyphicon-align-justify"></i>️</button>
        @foreach($menus as $menu)
            <ul class="nav nav-sidebar">
                @foreach($menu as $key => $value)
                    <li {!! $key == $page ? ' class="active"': '' !!}>
                        <a href="/user/{!! $key !!}">
                            {!! $value !!}
                            {!! $key == $page ? ' <span class="sr-only">(current)</span>': '' !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </div>
</div>
