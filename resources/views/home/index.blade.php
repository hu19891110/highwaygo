@extends('layouts.home')

@section('content')
    @parent
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        @if(isset($banners))
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @for($i = 0; $i < count($banners); $i++)
                    <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" class="{{ !$i ? 'active' : '' }}"></li>
                @endfor
            </ol>
        @endif
        <div class="carousel-inner" role="listbox">
        @forelse($banners as $i => $banner)
            <div class="item {{!$i ? 'active' : ''}}" style="{{isset($banner->bgcolor)?'background: ' . $banner->bgcolor:''}}" >
                {!! $banner->url ? '<a href="' . $banner->url . '">':'' !!}
                    <img src="{{$banner->img}}" >
                {!! $banner->url ? '</a>':'' !!}
            </div>
        @empty
        @endforelse
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="container main-section">
        <div class="row">
            <div class="col-md-9">
                <div class="container-fluid">
                    <div class="row">
                        <h4 class="main-title"><i class="glyphicon glyphicon-flash"></i> 新品上架</h4>
                        <section class="item-lists fire-item">
                            @foreach($newest_items as $newest_item)
                                <div class="col-sm-4 col-md-4 col-xs-6">
                                    <div class="thumbnail text-center">
                                        <div class="item-img"><img class="img-responsive" src="{{$newest_item->thumb_img}}#" alt="{{$newest_item->name}}" onerror="javascript:this.src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTkyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDE5MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUzNDEwN2I3MTMgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTM0MTA3YjcxMyI+PHJlY3Qgd2lkdGg9IjE5MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI2OS4wNDE2NjYwMzA4ODM3OSIgeT0iMTA0LjgiPjE5MngyMDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=';"></div>
                                        <div class="caption">
                                            <p><a href="/item/{{$newest_item->id}}">{{$newest_item->name}}</a> <span class="badge bggreen">￥{{$newest_item->price}}</span></p>
                                            <p class="color-grey">{{$newest_item->brief}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </section>
                    </div>
                    <div class="row">
                        <h4 class="main-title"><i class="glyphicon glyphicon-fire"></i> 热卖商品</h4>
                        <section class="item-lists fire-item">
                            @foreach($hot_items as $hot_item)
                                <div class="col-sm-4 col-md-4 col-xs-6">
                                    <div class="thumbnail text-center">
                                        <div class="item-img"><img class="img-responsive" src="{{$hot_item->thumb_img}}#" alt="{{$hot_item->name}}" onerror="javascript:this.src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTkyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDE5MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUzNDEwN2I3MTMgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTM0MTA3YjcxMyI+PHJlY3Qgd2lkdGg9IjE5MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI2OS4wNDE2NjYwMzA4ODM3OSIgeT0iMTA0LjgiPjE5MngyMDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=';"></div>
                                        <div class="caption">
                                            <p><a href="/item/{{$hot_item->id}}">{{$hot_item->name}}</a> <span class="badge bggreen">￥{{$hot_item->price}}</span></p>
                                            <p class="color-grey">最新成交: 10笔</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </section>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="container-fluid">
                    <div class="row">
                        <h4 class="main-title"><i class="glyphicon glyphicon-thumbs-up"></i> 推荐产品</h4>
                        <section class="item-lists fire-item">
                            @foreach($recommend_items as $recommend_item)
                                <div class="col-sm-4 col-md-12 col-xs-6">
                                    <div class="thumbnail text-center">
                                        <div class="item-img"><img class="img-responsive" src="{{$recommend_item->thumb_img}}#" alt="{{$recommend_item->name}}" onerror="javascript:this.src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTkyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDE5MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUzNDEwN2I3MTMgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTM0MTA3YjcxMyI+PHJlY3Qgd2lkdGg9IjE5MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI2OS4wNDE2NjYwMzA4ODM3OSIgeT0iMTA0LjgiPjE5MngyMDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=';"></div>
                                        <div class="caption">
                                            <p><a href="/item/{{$recommend_item->id}}">{{$recommend_item->name}}</a> <span class="badge bggreen">￥{{$recommend_item->price}}</span></p>
                                            <p><span class="badge bgred">好评率99%</span></p>
                                            <p class="color-grey">被20个人收藏</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('ext_styles')
    @parent
    {!! Html::style('/css/home/index.css') !!}
@stop