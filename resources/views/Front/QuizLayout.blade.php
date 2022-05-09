<!doctype html>
<html lang="en">
<head>
     <title>بررسی کد ورود به مسابقه</title>
    <meta name="description" content="">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="UTF-8">
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui" />

    <link rel="stylesheet" href={{asset("css/bootstrap.min.css")}}>
    <link rel="stylesheet" href={{asset("css/owl.carousel.min.css")}}>
    <link rel="stylesheet" href={{asset("css/owl.theme.default.min.css")}}>
    <link rel="stylesheet" href={{asset("css/font-awesome.min.css")}}>
    <link rel="stylesheet" href={{asset("css/style.css")}}>
    <link rel="stylesheet" href="{{asset("css/product-slider.css")}}">
    <script src={{asset("js/jquery-3.2.1.min.js")}}></script>
    <script src={{asset("js/bootstrap-4.0.0.js")}}></script>
    <script src={{asset("js/owl.carousel.min.js")}}></script>
    <script src={{asset("js/main.js")}}></script>
    <style>
        .award-bg {
    background: url(../images/bg-award.jpg) #ffffce no-repeat;
    height: 350px;
    padding: 20px 0 0 0;
}
    </style>
    @yield("head")
</head>
<body>
<header>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="headeritem"> <a href="{{route("indexRoute")}}"> <img src={{asset("img/headerpic.png")}} > </a> </h1>
            </div>
        </div>
    </div>
</header>
<main>
    @include("Front.Partials.Header2")
    <div class="clearfix"></div>
   @yield("content")
</main>
@include("Front.Partials.Footer")
</body>

</html>
