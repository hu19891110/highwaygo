@extends('layouts.bootstrap')

@section('container')
    @include('global.header')
    @yield('content')
    @include('global.footer')
@stop

@section('ext_styles')
    @parent
    {!! Html::style('favicon.ico?20160304', ['type' => 'image/x-icon', 'rel' => 'shortcut icon']) !!}
    {!! Html::style('icon114.png?20160304', ['type' => '', 'rel' => 'Bookmark']) !!}
    {!! Html::style('icon57.png?20160304', ['type' => '', 'rel' => 'apple-touch-icon', 'size' => '57x57']) !!}
    {!! Html::style('icon72.png?20160304', ['type' => '', 'rel' => 'apple-touch-icon', 'size' => '72x72']) !!}
    {!! Html::style('icon114.png?20160304', ['type' => '', 'rel' => 'apple-touch-icon', 'size' => '114x114']) !!}
    {!! Html::style('icon144.png?20160304', ['type' => '', 'rel' => 'apple-touch-icon', 'size' => '144x144']) !!}
    {!! Html::style('css/home/font.css') !!}
    {!! Html::style('css/home/my-theme.css') !!}
@stop

@section('ext_scripts')
    @parent
    {!! Html::script('js/img-load-default-on-error.js') !!}
@stop