<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{$title or "E-Shop"}}</title>

    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('/css/responsive.css')}}" rel="stylesheet">
    {{--<link href="{{asset('')}}/css/summernote.css" rel="stylesheet" type="text/css">--}}
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.css" rel="stylesheet">
    <link href="{{asset('/css/style.css')}}" rel="stylesheet">

    {{--js--}}
    <script src="{{asset('/js/jquery-2.2.0.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/css/dataTables.bootstrap.min.css')}}">
    <script src="{{asset('/js/summernote.js')}}"></script>

    {{--style--}}
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('/js/price-range.js')}}"></script>
    <script src="{{asset('/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('/js/main.js')}}"></script>

    {{--<script src="{{asset('')}}/js/summernote.js"></script>--}}
    {{--<script src="{{asset('')}}http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.0/summernote.js"></script>--}}

</head><!--/head-->

<body>
@include('layout.header')<!--/header-->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '488056531319009',
            xfbml      : true,
            version    : 'v2.5'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
@yield("content") <!--content-->
@include("layout.footer")<!--/Footer-->
@include('layout.script')
</body>
</html>