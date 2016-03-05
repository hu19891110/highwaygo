<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
        	{{$title or ''}}
        </title>
        {!!Html::style('/css/bootstrap.min.css')!!}
        {!!Html::style('/css/bootstrap-modal.css')!!}
        {!!Html::style('/css/bootstrap-modal-bs3patch.css')!!}
        {{-- {!!Html::style('/css/animate.min.css')!!} --}}
        @yield('ext_styles')
        <!--[if lt IE 9]>
            {!!Html::script('/js/ie9/html5shiv.min.js')!!}
            {!!Html::script('/js/ie9/respond.min.js')!!}
        <![endif]-->
    </head>
    <body>
    	@yield('container')
		{!!Html::script('/js/jquery.min.js')!!}
		{!!Html::script('/js/bootstrap.min.js')!!}
        {!!Html::script('/js/jquery.form.min.js')!!}
        <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
        </script>
        {!!Html::script('/js/bootstrap-modalmanager.js')!!}
        {!!Html::script('/js/bootstrap-modal.js')!!}
        {!!Html::script('/js/modal.js')!!}
		@yield('ext_scripts')
    </body>
</html>
