<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{$title or "E-Shop"}}</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/prettyPhoto.css" rel="stylesheet">
    <link href="/css/price-range.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/responsive.css" rel="stylesheet">
    {{--<link href="/css/summernote.css" rel="stylesheet" type="text/css">--}}
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    {{--js--}}
    <script src="/js/jquery-2.2.0.min.js"></script>
    <link rel="stylesheet" href="/css/dataTables.bootstrap.min.css">
    {{--style--}}
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.scrollUp.min.js"></script>
    <script src="/js/price-range.js"></script>
    <script src="/js/jquery.prettyPhoto.js"></script>
    <script src="/js/main.js"></script>

    {{--<script src="/js/summernote.js"></script>--}}
    {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.js"></script>--}}

    {{--<![endif]-->--}}
    <link rel="shortcut icon" href="/images/home/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
@include('layout.header')<!--/header-->
@yield("content") <!--content-->
@include("layout.footer")<!--/Footer-->
@include('layout.script')
</body>
</html>