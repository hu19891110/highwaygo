@extends('layouts.home')

@section('content')
    <div class="container">
        <br>
        <div class="row">
            <div class="col-sm-6 col-md-offset-1 col-md-5" id="brief">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        @forelse($imgs as $index => $img)
                            <div class="item {{$index == 0 ? 'active': ''}}">
                                <img src="{{$img->url}}">
                            </div>
                        @empty
                            <div class="item active">
                                <img src="{{$item->thumb_img}}">
                            </div>
                        @endforelse
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">上一张</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">下一张</span>
                    </a>
                </div>
                <hr>
            </div>
            <div class="col-sm-6 col-md-5">
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">{{$item->name}}</div>
                    <div class="panel-body">
                        <p>{{$item->brief}}</p>
                    </div>
                    <table class="table table-responsive">
                        <tr>
                            <th class="col-md-3 text-right">商品名称 </th>
                            <th class="col-md-9">{{$item->name}}</th>
                        </tr>
                        <tr>
                            <th class="col-md-3 text-right">商品价格 </th>
                            <th class="col-md-9">￥{{$item->price}}</th>
                        </tr>
                        <tr>
                            <th class="col-md-3 text-right">商品分类 </th>
                            <th class="col-md-9">{{$item->classification->path()}}</th>
                        </tr>
                        <tr>
                            <th class="col-md-3 text-right">库存 </th>
                            <th class="col-md-9">{{$item->stock}}</th>
                        </tr>
                    </table>
                    <div class="panel-footer">
                        <div class="container-fluid well-sm">
                            <div class="col-xs-6 text-center">
                                <a {!! $favorite ? ' ': 'href="/item/favorite/'. $item->id . '"'!!} class="btn btn-info"><i {!! $favorite?' style="color: OrangeRed;"':'' !!} class="glyphicon glyphicon-heart{{$favorite ? '':'-empty'}} " ></i> 收藏</a>
                            </div>
                            <div class="col-xs-6 text-center">
                                <a {!! $item->stock == 0 ? '': 'href="/car/add/' . $item->id . '"' !!} class="btn btn-disabled btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> 加入购物车</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-7 col-md-offset-1">
                <section>
                    <h3 class="main-title"><i class="glyphicon glyphicon-align-left"></i> 商品详情</h3>
                    {{$detail}}
                </section>
                <section>
                    <h3 class="main-title"><i class="glyphicon glyphicon-comment"></i> 商品评论</h3>
                    评论
                </section>
            </div>
            <div class="col-md-3">
                <section>
                    <h3 class="main-title"><i class="glyphicon glyphicon-thumbs-up"></i> 推荐商品</h3>
                    @foreach($recommend_items as $recommend_item)
                        <div class="col-sm-3 col-md-12 col-xs-6">
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
        <br>
        <br>
    </div>
@stop

@section('ext_styles')
    @parent
    {!! Html::style('css/home/item.css') !!}
@stop

@section('ext_scripts')
    @parent
    <script>

    </script>
@stop