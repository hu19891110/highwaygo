@extends('layouts.home')

@section('content')
    <div class="container">
        <div class="row">
            <h2 class="color-grey "> <i class="glyphicon glyphicon-list"></i> 所有商品分类</h2>
            <hr>
            @foreach($classifications as $classification)
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$classification['name']}}</h3>
                    </div>
                    <div class="panel-body">
                        @foreach($classification['children'] as $child)
                            <a href="/list/{{$child->id}}" class="col-xs-4 text-center col-sm-2 col-md-2">
                                {{$child->name}}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop