@extends('layouts.home')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('home.user.slider')
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                @include('home.user.page.' . $page)
            </div>
        </div>
    </div>
@stop

@section('ext_styles')
    @parent
    {!! Html::style('css/home/user.css') !!}
    <style>
        .navbar {
            left: 0;
            position: fixed;
            right: 0;
            z-index: 1030;
            top: 0;
        }
    </style>
@stop


@section('ext_scripts')
    @parent
    <script>
        $(function() {
            $(".xs-side .toggle").click(function() {
                $(".xs-side").toggleClass('active')
                if($(".xs-side").hasClass('active')) {
                    $("#icon-toggle").attr('class', 'glyphicon glyphicon-arrow-left')
                } else {
                    $("#icon-toggle").attr('class', 'glyphicon glyphicon-align-justify')
                }
            })
        })
    </script>
@stop