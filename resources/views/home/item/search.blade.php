@extends('layouts.home')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="color-grey "> <i class="glyphicon glyphicon-search"></i> {{$title}}</h2>
            <hr>
        </div>
        <div class="row">
            @if($result->count() == 0)
                <h1 class="text-center"><i class="glyphicon glyphicon-info-sign"></i> 没有物品</h1>
            @endif
            @foreach($result as $item)
                <div class="col-sm-4 col-md-3 col-xs-6">
                    <div class="thumbnail text-center">
                        <div class="item-img"><img class="img-responsive" src="{{$item->thumb_img}}#" alt="{{$item->name}}" onerror="javascript:this.src='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTkyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDE5MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTUzNDEwN2I3MTMgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMHB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNTM0MTA3YjcxMyI+PHJlY3Qgd2lkdGg9IjE5MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI2OS4wNDE2NjYwMzA4ODM3OSIgeT0iMTA0LjgiPjE5MngyMDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=';"></div>
                        <div class="caption">
                            <p><a href="/item/{{$item->id}}">{{$item->name}}</a> <span class="badge bggreen">￥{{$item->price}}</span></p>
                            <p class="color-grey">{{$item->brief}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row text-center">
            {!! $result->render() !!}
        </div>
    </div>
@stop
