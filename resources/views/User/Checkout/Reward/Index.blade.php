@extends('Front.Layouts')
@section('main')
    <!--single-product----------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('indexRoute')}}" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('rewardRoute')}}" class="breadcrumb-link">خرید جایزه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="breadcrumb-link active-breadcrumb">{{$reward->reward_title}}</a>
                    </li>
                </ul>
            </div>
            <article class="product">
                <div class="col-lg-4 col-xs-12 pb-5 pull-right">
                    <!-- Product Options-->
                    <ul class="gallery-options">
                        <li>
                            <button class="add-favorites"><i class="fa fa-heart"></i></button>
                            <span class="tooltip-option">افزودن به علاقمندی</span>
                        </li>
                    </ul>
                    <div class="product-gallery">
                        <div class="product-gallery-carousel owl-carousel">
                            <div class="item">
                                <a class="gallery-item" href="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}"
                                   data-fancybox="gallery1" data-hash="one">
                                    <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
                                </a>
                            </div>
                        </div>
                        <ul class="product-thumbnails">
                            <li class="active">
                                <a href="#one">
                                    <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-xs-12 pull-right">
                    <section class="product-info">
                        <div class="product-headline">
                            <h1 class="product-title">
                                {{$reward->reward_title}}
                                <span class="product-title-en">{{$reward->reward_desc}}</span>
                            </h1>
                        </div>
                        <div class="product-attributes">
                            <div class="col-lg-6 col-xs-12 pull-right">
                                <div class="product-config">
                                    <div class="product-config-wrapper">
                                        <div class="product-directory" hidden>
                                            <ul>
                                                <li>
                                                    <span>ناشر</span>
                                                    :
                                                    <a href="#" class="product-brand-title"></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-variants">
                                            <span>تعداد سکه: </span>
                                            <ul class="js-product-variants">
                                                <li class="ui-variant">
                                                    <label for="#" class="ui-variant-color">
                                                        <span class="ui-variant-shape" style="background-color: #fcd411; border-radius: 50%"></span>
                                                        <input type="radio" value="4" name="color" id="variant" class="js-variant-selector" checked="">
                                                        <span class="ui-variant-check">{{$reward->reward_coin}} عدد</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-12 pull-left">
                                @if(session()->get("cashError"))
                                    <div class="alert alert-danger">
                                        <p>موجودی سکه شما برای خرید این جایزه کافی نمی باشد.</p>
                                    </div>
                                @endif
                                @if(session()->get("successBuy"))
                                    <div class="alert alert-success">
                                        <p>خرید با موفقیت انجام شد. تعداد {{$reward->reward_coin}} سکه از حساب شما کسر شد. کد پیگیری شما :{{session()->get("tracking_code")}}</p>
                                    </div>
                                @endif
                                @include("Dashboard.Partials.notifications")
                                @include("Dashboard.Partials.errors")
                                <div class="product-summary">
                                    <div class="product-seller-info">
                                        <div class="seller-info-changable">
                                    <form class="text-right" method="post" action="{{route("buyRewardRoute",["id"=>$reward->reward_id])}}">
                                @csrf
                            <div class="col-lg-4" style="margin-top: 16px;">
                                <div class="form-group">
                                    <label for="" style="margin-bottom: 8px;color: #5a6268">نام تحویل گیرنده</label>
                                    <input placeholder="" name="name" type="text" class="form-control" value="{{old('name')}}"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" style="margin-bottom: 8px;color: #5a6268">موبایل</label>
                                    <input placeholder="" name="mobile" type="text" class="form-control" value="{{old('mobile')}}"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="margin-bottom: 8px;color: #5a6268">شهر</label>
                                    <input placeholder="" name="city" type="text" class="form-control" value="{{old('city')}}"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label style="margin-bottom: 8px;color: #5a6268">کد پستی</label>
                                    <input placeholder="" name="postal_code" type="text" class="form-control" value="{{old('postal_code')}}"/>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label style="margin-bottom: 8px;color: #5a6268">آدرس پستی</label>
                                    <input placeholder="" name="address" type="text" class="form-control" value="{{old('address')}}"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="parent-btn">
                                    <button class="dk-btn dk-btn-info at-c as-c">
                                        ثبت درخواست
                                        <i class="mdi mdi-cart"></i>
                                    </button>
                                </div>
                            </div>
                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </div>
    <!--single-product----------------------------->
@endsection
