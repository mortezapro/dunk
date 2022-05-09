<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--    font------------------------------------>
    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/materialdesignicons.css")}}">
    <link rel="stylesheet" href="{{asset("css/materialdesignicons.css.map")}}">
    <!--    bootstrap------------------------------->
    <link rel="stylesheet" href="{{asset("css/font-awesome.min.css")}}">
{{--    <script src={{asset("js/jquery-3.2.1.min.js")}}></script>--}}
    <link rel="stylesheet" href="{{asset("css/bootstrap.css")}}">
    <!--    owl.carousel---------------------------->
    <link rel="stylesheet" href="{{asset("css/owl.carousel.min.css")}}">
    <!--    responsive------------------------------>
    <link rel="stylesheet" href="{{asset("css/responsive.css")}}">
    <!--    main style------------------------------>
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
    <!--    fancybox-------------------------------->
    <link rel="stylesheet" href="{{asset('css/fancybox.min.css')}}">
</head>
<body>
<title>جایزه دون</title>
<!--header------------------------------------->
@include("Front.Partials.Header")

@yield('main')
@include("Front.Partials.Footer")
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<!--    bootstrap-------------------------------->
<script src="{{asset('js/bootstrap.js')}}"></script>
<!--    owl.carousel----------------------------->
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<!--main----------------------------------------->
<script src="{{asset('js/main.js')}}"></script>
<!--fancybox------------------------------------->
<script src="{{asset('js/jquery.fancybox.min.js')}}"></script>
<!--countdown------------------------------------>
<script src="{{asset('js/jquery.countdown.min.js')}}"></script>
@yield('js')

</body>
</html>
