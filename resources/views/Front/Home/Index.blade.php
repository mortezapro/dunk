@extends('Front.Layouts')
@section('main')
    <article class="container-main">
        <div class="page-row-main-top">
        @if(($setting->s1)==1)
            <!--    slider--------------------------------->
                <div @if(($setting->s2)==0)class="col-lg-12 col-md-12 col-xs-12 pull-right" @else class="col-lg-8 col-md-8 col-xs-12 pull-right" @endif >
                    <div class="main-slider-container">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($sliders as $key => $item)
                                    @if($key == 0)
                                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="active"></li>
                                    @else
                                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}"></li>
                                    @endif
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach($sliders as $key => $item)
                                    @if($key == 0)
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" src="{{asset("dashboard/uploaded/images/shop_sliders/$item->slider_img")}}">
                                        </div>
                                    @else
                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="{{asset("dashboard/uploaded/images/shop_sliders/$item->slider_img")}}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!--    slider--------------------------------->
        @endif
        @if(($setting->s2)==1)
            <!--adplacement-------------------------------->
                <div class="col-lg-4 col-md-4 col-xs-12 pull-left">
                    <aside class="adplacement-container-column">
                        <a href="{{$setting->link_1}}" class="adplacement-item adplacement-item-column">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_1)}}">
                            </div>
                        </a>
                        <a href="{{$setting->link_2}}" class="adplacement-item adplacement-item-column">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_2)}}">
                            </div>
                        </a>
                    </aside>
                </div>
        </div>
        <!--adplacement-------------------------------->
    @endif
    @if(($setting->s3)==1)
        <!--    product-slider------------------------->
            <div class="col-lg-9 col-md-9 col-xs-12 pull-right">
                <div class="section-slider-product mb-4 mt-3">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <span class="title-one">جدیدترین کتاب ها</span>
                            <a href="{{route('shopRoute')}}" title ="جدیدترین کتاب ها"><h3 class="card-title">مشاهده همه</h3></a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme owl-rtl owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2234px;">
                                    @foreach($products as $product)
                                        <div class="owl-item active" style="width: 309.083px; margin-left: 10px;">
                                            <div class="item">
                                                <a href="{{route('singleBookRoute',['id'=>$product->book_id])}}">
                                                    <div class="stars-plp">
                                                        <span class="mdi mdi-star active"></span>
                                                        <span class="mdi mdi-star active"></span>
                                                        <span class="mdi mdi-star active"></span>
                                                        <span class="mdi mdi-star active"></span>
                                                        <span class="mdi mdi-star active"></span>
                                                    </div>
                                                    <img src="{{asset("dashboard/uploaded/images/product/$product->book_image")}}"
                                                         class="img-fluid" alt="">
                                                </a>
                                                <h2 class="post-title">
                                                    <a href="{{route('singleBookRoute',['id'=>$product->book_id])}}">
                                                        {{$product->book_name}}
                                                    </a>
                                                </h2>
                                                <div class="price">
                                                    <ins>
                                                        <span>{{number_format($product->price)}}<span>تومان</span></span>
                                                    </ins>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="fa fa-angle-right"></i></button><button type="button" role="presentation" class="owl-next"><i class="fa fa-angle-left"></i></button></div><div class="owl-dots disabled">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--    product-slider------------------------->
    @endif
    @if(($setting->s4)==1)
        <!--slider-sidebar----------------------------->
            <div class="col-lg-3 col-md-3 col-xs-12 pull-left">
                <div class="promo-single mb-4 mt-3">
                    <div class="widget-suggestion widget card">
                        <header class="card-header cart-sidebar">
                            <h3 class="card-title ts-3">پیشنهادهای لحظه‌ای</h3>
                        </header>
                        <div id="progressBar">
                            <div class="slide-progress" style="width: 100%; transition: width 5000ms ease 0s;"></div>
                        </div>
                        <div id="suggestion-slider" class="owl-carousel owl-theme owl-rtl owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage" style="transform: translate3d(1369px, 0px, 0px); transition: all 0.25s ease 0s; width: 2190px;">
                                    @foreach($random as $key => $item)
                                    <div class="owl-item cloned" style="width: 273.75px;">
                                        <div class="item">
                                            <a href="{{route('singleBookRoute',['id'=>$item->book_id])}}">
                                                <img src="{{asset("dashboard/uploaded/images/product/$item->book_image")}}" class="w-100" alt="{{$item->book_name}}">
                                            </a>
                                            <h3 class="product-title">
                                                <a href="{{route('singleBookRoute',['id'=>$item->book_id])}}"> {{$item->book_name}}</a>
                                            </h3>
                                            <div class="price">
                                                <span class="new-price-discount">%10</span>
                                                <span class="amount">{{number_format($item->price)}}<span>تومان</span></span>
                                                <div class="stars-plp">
                                                    <span class="mdi mdi-star active"></span>
                                                    <span class="mdi mdi-star active"></span>
                                                    <span class="mdi mdi-star active"></span>
                                                    <span class="mdi mdi-star active"></span>
                                                    <span class="mdi mdi-star active"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
                            </div>
                            <div class="owl-dots disabled"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--slider-sidebar----------------------------->
    @endif
    @if(($setting->s5)==1)
        <!--        category--------------------------->
            <div class="col-12">
                <div class="promotion-categories-container mb-4">
                    <span class="promotion-categories-title">بیش از ۱،۵۰۰،۰۰۰ کالا در دسته‌بندی‌های مختلف</span>
                    <div class="category-container">
                        <div class="promotion-categories">
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/macbook.png" )}}">
                                <div class="promotion-category-name">کالای دیجیتال</div>
                                <div class="promotion-category-quantity">۲۰۳۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/heart-shape-outline-with-lifeline.png" )}}">
                                <div class="promotion-category-name">لوازم آرایشی</div>
                                <div class="promotion-category-quantity">۶۰۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/support.png" )}}">
                                <div class="promotion-category-name">خودرو، ابزار و اداری</div>
                                <div class="promotion-category-quantity">۷۲۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/dress.png" )}}">
                                <div class="promotion-category-name">مد و پوشاک</div>
                                <div class="promotion-category-quantity">۲۶۱۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/sofa.png" )}}">
                                <div class="promotion-category-name">خانه و آشپزخانه</div>
                                <div class="promotion-category-quantity">۲۷۷۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/pen.png" )}}">
                                <div class="promotion-category-name">کتاب، لوازم تحریر و هنر</div>
                                <div class="promotion-category-quantity">۱۰۴۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/baby.png" )}}">
                                <div class="promotion-category-name">اسباب بازی، کودک و نوزاد</div>
                                <div class="promotion-category-quantity">۳۷۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/sports-and-competition.png" )}}">
                                <div class="promotion-category-name">ورزش و سفر</div>
                                <div class="promotion-category-quantity">۱۹۰۰۰ کالا</div>
                            </a>
                            <a href="#" class="promotion-category">
                                <img src="{{asset("img/category/birthday-and-party.png" )}}">
                                <div class="promotion-category-name">خوردنی و آشامیدنی</div>
                                <div class="promotion-category-quantity">۲۷۰۰۰ کالا</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--        category--------------------------->
    @endif


        <!--    adplacemen-container----------------------------->
            <div class="col-12">
                <div class="adplacement-container-row mb-4">
                    @if(($setting->s6)==1)
                    <div class="col-6 col-lg-3 pull-right" style="padding-left:0;">
                        <a href="{{$setting->link_3}}" class="adplacement-item mb-4">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_3)}}">
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3 pull-right" style="padding-left:0;">
                        <a href="{{$setting->link_4}}" class="adplacement-item mb-4">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_4)}}">
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3 pull-right" style="padding-left:0;">
                        <a href="{{$setting->link_5}}" class="adplacement-item mb-4">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_5)}}">
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-3 pull-right" style="padding-left:0;">
                        <a href="{{$setting->link_6}}" class="adplacement-item mb-4">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_6)}}">
                            </div>
                        </a>
                    </div>
                    @endif
                    @if(($setting->s7)==1)
                    <!--    product-slider----------------------------------->
                    <div class="col-lg-12 col-md-12 col-xs-12 pull-right">
                        <div class="section-slider-product mb-4">
                            <div class="widget widget-product card">
                                <header class="card-header">
                                    <span class="title-one">تخفیف خورده ها</span>
                                    <a href="{{route('shopRoute')}}" title ="تخفیف خورده ها"><h3 class="card-title">مشاهده همه</h3></a>
                                </header>
                                <div class="product-carousel owl-carousel owl-theme owl-rtl owl-loaded owl-drag">
                                    <div class="owl-stage-outer">
                                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2234px;">
                                            @foreach($products as $product)
                                                <div class="owl-item active" style="width: 309.083px; margin-left: 10px;">
                                                    <div class="item">
                                                        <a href="{{route('singleBookRoute',['id'=>$product->book_id])}}">
                                                            <img src="{{asset("dashboard/uploaded/images/product/$product->book_image")}}"
                                                                 class="img-fluid" alt="">
                                                        </a>
                                                        <h2 class="post-title">
                                                            <a href="{{route('singleBookRoute',['id'=>$product->book_id])}}">
                                                                {{$product->book_name}}
                                                            </a>
                                                        </h2>
                                                        <div class="price">
                                                            <ins>
                                                                <span>{{number_format($product->price)}}<span>تومان</span></span>
                                                                <div class="stars-plp">
                                                                    <span class="mdi mdi-star active"></span>
                                                                    <span class="mdi mdi-star active"></span>
                                                                    <span class="mdi mdi-star active"></span>
                                                                    <span class="mdi mdi-star active"></span>
                                                                    <span class="mdi mdi-star active"></span>
                                                                </div>
                                                            </ins>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="fa fa-angle-right"></i></button><button type="button" role="presentation" class="owl-next"><i class="fa fa-angle-left"></i></button></div><div class="owl-dots disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                {{--        @dd($products)--}}
                <!--    product-slider------------------------->
                        @if(($setting->s8)==1)
                    <div class="col-6 col-lg-6 pull-right" style="padding-left:0;">
                        <a href="{{$setting->link_7}}" class="adplacement-item">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_7)}}">
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-lg-6 pull-right" style="padding-left:0;">
                        <a href="{{$setting->link_8}}" class="adplacement-item">
                            <div class="adplacement-sponsored-box">
                                <img src="{{asset('dashboard/uploaded/images/sliders/'.$setting->image_8)}}">
                            </div>
                        </a>
                    </div>
                </div>
                @endif
            @if(($setting->s9)==1)
                <!--    reward-slider----------------------------------->
                <div class="col-lg-12 col-md-12 col-xs-12 pull-right">
                    <div class="section-slider-product mb-4">
                        <div class="widget widget-product card">
                            <header class="card-header">
                                <span class="title-one">جدیدترین جایزه ها</span>
                                <a href="{{route('rewardRoute')}}" title ="جدیدترین جایزه ها"><h3 class="card-title">مشاهده همه</h3></a>
                            </header>
                            <div class="product-carousel owl-carousel owl-theme owl-rtl owl-loaded owl-drag">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2234px;">
                                        @foreach($rewards as $item)
                                            <div class="owl-item active" style="width: 309.083px; margin-left: 10px;">
                                                <div class="item">
                                                    <a href="{{route('singleRewardRoute',['id'=>$item->reward_id])}}">
                                                        <img src="{{asset("dashboard/uploaded/images/reward_image/$item->reward_image")}}"
                                                             class="img-fluid" alt="">
                                                    </a>
                                                    <h2 class="post-title">
                                                        <a href="{{route('singleRewardRoute',['id'=>$item->reward_id])}}">
                                                            {{$item->reward_title}}
                                                        </a>
                                                    </h2>
                                                    <div class="price">
                                                        <ins>
                                                            <span>{{$item->reward_coin}}<span>سکه</span></span>
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                            </div>
                                                        </ins>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="owl-nav"><button type="button" role="presentation" class="owl-prev disabled"><i class="fa fa-angle-right"></i></button><button type="button" role="presentation" class="owl-next"><i class="fa fa-angle-left"></i></button></div><div class="owl-dots disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--    reward-slider------------------------->
                @endif
            </div>

            <!--    adplacemen-container----------------------------->

    @if(($setting->s10)==1)
        <!--   arrivals-product------------------------>
            <div class="col-12">
                <div class="arrivals-product">
                    <div class="main-product-tab-area">
                        <div class="tab-menu mb-5">
                            <ul class="nav tabs-area">
                                <li class="nav-item nav-active">
                                    <a href="#" class="nav-link" data-toggle="tab">همه</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-toggle="tab">ویژه</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-toggle="tab">جدید ترین ها</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-toggle="tab">پیشنهاد شده</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <section class="main-content">
                                <ul class="content-area">
                                    <li class="item-content" style="display:block;">
                                        <a href="#" class="link-content">
                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                         </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/2.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/3.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/4.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/2.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/3.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/4.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/2.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="item-content">
                                        <a href="#" class="link-content">
                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/2.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/3.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/4.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/2.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/3.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/4.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="item-content">
                                        <a href="#" class="link-content">
                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/2.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/3.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/4.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="item-content">
                                        <a href="#" class="link-content">
                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/1.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/2.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-xs-12 pull-right mb-3">
                                                <div class="product-vertical">
                                                    <div class="vertical-product-thumb">
                                                        <a href="#">
                                                            <div class="stars-plp">
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star active"></span>
                                                                <span class="mdi mdi-star"></span>
                                                            </div>
                                                            <img src="{{asset("img/content-product/3.jpg" )}}">
                                                        </a>
                                                    </div>
                                                    <div class="card-vertical-product-content">
                                                        <div class="card-vertical-product-title">
                                                            <a href="#">
                                                                ساعت هوشمند جی-تب مدل W101 Hero
                                                            </a>
                                                        </div>
                                                        <div class="card-vertical-product-price">
                                                            ۱۲۷,۰۰۰
                                                            <span class="price-currency">تومان</span>
                                                        </div>
                                                        <div class="product-actions-secondary">
                                                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                                                <span class="mdi mdi-heart"></span>
                                                            </div>
                                                            <div class="product-introduction-cart" title="افزودن به سبد خرید">
                                                            <span class="c-introduction">
                                                                 +
                                                            </span>

                                                            </div>
                                                            <div class="comparison" title="افزودن برای مقایسه">
                                                                <i class="fa fa-random" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
    @endif
    <!--   arrivals-product------------------------>


    </article>
    {{--    @include("Front.Partials.Header")--}}
@endsection
