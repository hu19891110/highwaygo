@extends('layouts.bootstrap')

@section('ext_styles')
	<link rel="stylesheet" href="http://fonts.useso.com/css?family=Roboto:300,400,500,700" type="text/css">
	<link rel="stylesheet" href="http://fonts.useso.com/icon?family=Material+Icons" type="text/css">
	{!!Html::style('/css/material.min.css')!!}
	{!!Html::style('/css/ripples.min.css')!!}
	{!!Html::style('/css/roboto.min.css')!!}
@stop

@section('ext_scripts')
	{!!Html::script('/js/material.min.js')!!}
	{!!Html::script('/js/ripples.min.js')!!}
	<script>
		$(function() {
			$.material.init()
		})
	</script>
@stop
