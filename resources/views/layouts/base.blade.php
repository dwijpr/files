<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    {!! Html::style('thirdparty/fonts/Lato/latofonts.css') !!}
    {!! Html::style('thirdparty/fonts/Lato/latostyle.css') !!}
    {!! Html::style('thirdparty/font-awesome/4.6.1/css/font-awesome.css') !!}
    {!! Html::style('thirdparty/bootstrap/3.3.6/css/bootstrap.css') !!}
    {!! Html::style('thirdparty/jquery-jsonview/1.2.3/dist/jquery.jsonview.css') !!}
    {!! Html::style('thirdparty/viewerjs/0.4.0/dist/viewer.css') !!}

    <style>
        body {
            font-family: 'LatoWeb';
        }
    </style>

    @yield ('styles')
    
    {!! Html::script('thirdparty/js/jquery-1.12.3.js') !!}
    {!! Html::script('thirdparty/bootstrap/3.3.6/js/bootstrap.js') !!}
    {!! Html::script('thirdparty/jquery-jsonview/1.2.3/dist/jquery.jsonview.js') !!}
    {!! Html::script('thirdparty/ace-builds/1.2.3/src-noconflict/ace.js') !!}
    {!! Html::script('thirdparty/viewerjs/0.4.0/dist/viewer.js') !!}
</head>
<body id="app-layout">

    @yield('content')

    @yield('scripts')

</body>
</html>
