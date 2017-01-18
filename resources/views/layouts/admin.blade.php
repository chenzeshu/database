<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('/img/logo.png')}}" type="image/x-icon">
    <title>数据库平台</title>
    <link rel="stylesheet" href="{{asset('/css/ch-ui.admin.css')}}">
    {{--<link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('/font/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/local.css')}}">
    <script type="text/javascript" src="{{asset('js/jquery3.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('org/layer-v2.4/layer/layer.js')}}"></script>
    <script src="{{asset('org/laydate/laydate.js')}}"></script>
</head>
<body>
@yield('content')
</body>
</html>