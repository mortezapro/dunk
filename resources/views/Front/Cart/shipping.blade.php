@extends('Front.Layouts')
@section('main')
    <style>
        .t-header-light .c-checkout-steps {
            position: absolute;
            top: 100px;
            left: 50%;
            margin: 0;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            z-index: 10001;
        }
        .c-checkout-steps {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin: 30px auto 18px;
            list-style: none;
            padding: 0;
            color: #a0a0a0;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            width: 783px;
            font-size: 13px;
            font-size: .929rem;
            line-height: 1.692;
        }
        .c-checkout-steps li:before {
            content: "";
            position: absolute;
            width: 372px;
            height: 3px;
            border-radius: 3.5px;
            background-color: #d0d0d0;
            top: 50%;
            left: 10px;
            z-index: 0;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }
        .unsetbefore:before
        {
            content: unset !important;
            position: unset !important;
            width: unset !important;
            height: unset !important;
            border-radius: unset !important;
            background-color: unset !important;
            top: unset !important;
            left: unset !important;
            z-index: unset !important;
            -webkit-transform: unset !important;
            transform: unset !important;
        }
        .c-checkout-steps li:first-of-type {
            margin-left: 0;
        }

        .c-checkout-steps li.is-active {
            color: #00bfd6;
        }
        .c-checkout-steps li.is-completed {
            color: #00bfd6;
        }
        .c-checkout-steps li {
            position: relative;
            z-index: 1;
        }
        .c-checkout-steps__item-link {
            color: inherit;
        }
        .c-checkout-steps__item {
            position: relative;
            text-align: center;
            border-radius: 100%;
            width: 20px;
            height: 20px;
            background-color: #d0d0d0;
            z-index: 1;
        }
        .c-checkout-steps li {
            position: relative;
            z-index: 1;
        }






        .parent-store ul li{
            display: flow-root;
            margin: 14px 0px;
        }
        .label-payment
        {
            color: gray;
            font-size: 14px;
        }
        .result-payment
        {
            color: gray;
            font-size: 14px;
        }
        .result-payment-red
        {
            color: red;
        }
        .result-payment-blue
        {
            color: blue;
        }
        .final-price-payment
        {
            margin-top: 27px !important;
            padding-top: 10px;
            border-top: 1px solid gainsboro;
        }
        .dk-btn:before
        {
            transition: unset;
            width: unset;
            height: unset;
            position: absolute;
            right: unset;
            top: unset;
            background: unset;
            content: unset;
            border-radius: unset;
        }
        .page-content-cart
        {
            margin: 0 0 5px;
        }
        .page-content .title-content
        {
            background: #dbdbdb;
            margin: 0 0 5px;
        }
    </style>



    <!--cart--------------------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link active-breadcrumb">سبد خرید</a>
                    </li>
                </ul>
            </div>



        </div>

        <div class="page-content">

                        <ul class="c-checkout-steps">
                            <li class="is-active is-completed unsetbefore"><a class="c-checkout-steps__item-link">
                                    <div class="c-checkout-steps__item c-checkout-steps__item--summary" data-title="اطلاعات ارسال"></div>
                                </a></li>
                            <li class=" "><a class="c-checkout-steps__item-link js-shipping-timeline">
                                    <div class="c-checkout-steps__item c-checkout-steps__item--delivery" data-title="پرداخت"></div>
                                </a></li>
                            <li class="">
                                <div class="c-checkout-steps__item c-checkout-steps__item--payment" data-title="اتمام خرید و ارسال"></div>
                            </li>
                        </ul>
            @include("Dashboard.Partials.notifications")
            @include("Dashboard.Partials.errors")
            <form method="post" action="{{route("submitOrderRoute")}}" enctype="multipart/form-data">
                {{csrf_field()}}

            <div class="col-lg-9 col-md-9 col-xs-12 pull-right">
                <section class="page-contents">
                    <div class="profile-content">
                        <div class="profile-navbar">
                            <div class="profile-navbar-back-alignment">
                                <a href="{{route('cartRoute')}}" class="profile-navbar-btn-back">بازگشت</a>
                                <h4 class="edit-personal">ویرایش اطلاعات</h4>
                            </div>
                        </div>
                        <div class="profile-stats">
                            <div class="title-content">
                                <ul class="title-ul">
                                    <li class="title-item product-name">
                                        نام کالا
                                    </li>
                                    <li class="title-item required-number">
                                        تعداد
                                    </li>
                                    <li class="title-item unit-price">
                                        قیمت واحد
                                    </li>
                                    <li class="title-item total">
                                        مجموع
                                    </li>
                                </ul>
                            </div>
                            @foreach($cartCollection as $item)
                                <div class="page-content-cart">
                                    <div class="checkout-body">
                                        <div class="product-name before">
                                            <div class="checkout-col-desc">
                                                <a href="{{route('singleBookRoute',['id'=>$item->id])}}">
                                                    <h1>{{ $item->name }}</h1>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="required-number before">
                                            <div class="quantity-new" style="margin-top: unset">
                                                {{ $item->quantity }}
                                            </div>
                                        </div>
                                        <div class="unit-price before">
                                            <div class="product-price" style="margin: unset">
                                                {{$item->price}}
                                                <span>
                                            تومان
                                        </span>
                                            </div>
                                        </div>
                                        <div class="total before">
                                            <div class="product-price" style="margin: unset">
                                                <span  id="totalSingleProduct{{ $item->id }}">{{ \Cart::get($item->id)->getPriceSum() }}</span>
                                                <span>
                                        تومان
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <section class="page-contents">
                    <div class="profile-content">
                        <div class="profile-navbar">
                            <div class="profile-navbar-back-alignment">
                                <a href="{{route('cartRoute')}}" class="profile-navbar-btn-back">بازگشت</a>
                                <h4 class="edit-personal">اطلاعات ارسالی</h4>
                            </div>
                        </div>
                        <div class="profile-stats">

                                <div class="profile-stats-row">
                                    <fieldset class="form-legal-fieldset">

                                        <div class="form-legal-center">
                                            <div class="profile-stats-col">
                                                <div class="profile-stats-content">
                                                    <span class="profile-first-title"> نام نام خانوادگی :</span>
                                                    <input class="ui-input-field" type="text" name="name" value="{{$user->user_flname}}" placeholder="نام نام خانوادگی خود را وارد کنید">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-legal-center">
                                            <div class="profile-stats-col">
                                                <div class="profile-stats-content">
                                                    <span class="profile-first-title"> کد پستی :</span>
                                                    <input class="ui-input-field" type="text" name="postal_code" value="{{$user->user_postalcode}}" placeholder="کد پستی  خود را وارد کنید">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-legal-center">
                                            <div class="profile-stats-col">
                                                <div class="profile-stats-content">
                                                    <span class="profile-first-title"> شماره موبایل</span>
                                                    <input class="ui-input-field" type="text" name="tell" value="{{$user->user_mobile}}" placeholder="شماره موبایل خود را وارد کنید">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-legal-center">
                                            <div class="profile-stats-col">
                                                <div class="profile-stats-content">
                                                    <span class="profile-first-title">شهر</span>
                                                    <select name="city" id="city_id" class=" form-control" onchange="ajaxGetPriceCity()">
                                                        <option disabled selected value="">انتخاب استان</option>
                                                        <option selected value="{{$user->user_city}}">{{$user->city}}</option>
                                                        @foreach($citys as $city)
                                                            <option value={{$city->id}}>{{$city->city}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-legal-center">
                                            <div class="profile-stats-col">
                                                <div class="profile-stats-content">
                                                    <span class="profile-first-title">آدرس</span>
                                                    <input class="ui-input-field" type="text" name="address" value="{{$user->user_address}}" placeholder="آدرس خود را وارد کنید">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 pull-left">
                <div class="page-aside">
                    <div class="checkout-summary">
                        <div class="comment-summary mb-3">
                        </div>
                        <div class="discount-code mb-2">
                            <form action="#" class="discount-form">
                                <label for="discount">کد هدیه</label>
                                <input type="text" id="discount" class="input-discount" placeholder="کد هدیه خود را وارد کنید">
                                <button type="button" class="btn-discount" onclick="discountCode()">اعمال</button>
                            </form>
                        </div>
                    </div>
                </div>
                <section class="page-aside">
                    <div class="sidebar-wrapper" style="margin-top: 15px">
                        <div class="box-sidebar" style="padding: 7px 9px;">
                            <span class="box-header-sidebar">تایید نهایی</span>
                            <div class="col-lg-12" style="padding:0;">
                                <div class="profile-stats-row form-legal-row-submit">
                                    <div class="parent-btn parent-store">
                                        <ul>
                                            <li>
                                                <span class="label-payment pull-right"> قیمت کالاها ({{ \Cart::getTotalQuantity()}})</span>
                                                <span class="result-payment pull-left">{{ number_format(\Cart::getSubTotal()) }} تومان </span>
                                            </li>
                                            <li>
                                                <span class="label-payment pull-right">کد هدیه <i id="discount-label" style="color: red"></i></span>
                                                <span class="result-payment-red pull-left">{{ number_format(\Cart::getSubTotal() - \Cart::getTotal())}} تومان </span>
                                            </li>
                                            <li>
                                                <span class="label-payment pull-right">هزینه ارسال</span>
                                                <span id="priceSend" class="result-payment pull-left">@php if($user->price == null) echo 0 @endphp {{ $user->price }} تومان </span>
                                            </li>
                                            <li class="final-price-payment">
                                                <span class="label-payment pull-right">مبلغ قابل پرداخت</span>
                                                <span class="pull-left" id="totalPrice">{{ number_format($cartTotal)}} تومان </span>
                                            </li>
                                        </ul>
                                        <button type="submit" class="dk-btn dk-btn-info btn-store" style="padding: 13px 40px">
                                            پرداخت و ثبت نهایی سفارش
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
            </form>


        </div>
    </div>
    <!--cart--------------------------------------->


    {{--<div class="container" style="margin-top: 80px">--}}
    {{--<nav aria-label="breadcrumb">--}}
    {{--<ol class="breadcrumb">--}}
    {{--<li class="breadcrumb-item"><a href="/">Shop</a></li>--}}
    {{--<li class="breadcrumb-item active" aria-current="page">Cart</li>--}}
    {{--</ol>--}}
    {{--</nav>--}}
    {{--@if(session()->has('success_msg'))--}}
    {{--<div class="alert alert-success alert-dismissible fade show" role="alert">--}}
    {{--{{ session()->get('success_msg') }}--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
    {{--<span aria-hidden="true">×</span>--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--@if(session()->has('alert_msg'))--}}
    {{--<div class="alert alert-warning alert-dismissible fade show" role="alert">--}}
    {{--{{ session()->get('alert_msg') }}--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
    {{--<span aria-hidden="true">×</span>--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--@if(count($errors) > 0)--}}
    {{--@foreach($errors0>all() as $error)--}}
    {{--<div class="alert alert-success alert-dismissible fade show" role="alert">--}}
    {{--{{ $error }}--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
    {{--<span aria-hidden="true">×</span>--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--@endforeach--}}
    {{--@endif--}}
    {{--<div class="row justify-content-center">--}}
    {{--<div class="col-lg-7">--}}
    {{--<br>--}}
    {{--@if(\Cart::getTotalQuantity()>0)--}}
    {{--<h4>{{ \Cart::getTotalQuantity()}} Product(s) In Your Cart</h4><br>--}}
    {{--@else--}}
    {{--<h4>No Product(s) In Your Cart</h4><br>--}}
    {{--<a href="/" class="btn btn-dark">Continue Shopping</a>--}}
    {{--@endif--}}

    {{--@foreach($cartCollection as $item)--}}
    {{--<div class="row">--}}
    {{--<div class="col-lg-3">--}}
    {{--<img src="/images/{{ $item->attributes->image }}" class="img-thumbnail" width="200" height="200">--}}
    {{--</div>--}}
    {{--<div class="col-lg-5">--}}
    {{--<p>--}}
    {{--<b><a href="/shop/{{ $item->attributes->slug }}">{{ $item->name }}</a></b><br>--}}
    {{--<b>Price: </b>${{ $item->price }}<br>--}}
    {{--<b>Sub Total: </b>${{ \Cart::get($item->id)->getPriceSum() }}<br>--}}
    {{--<b>With Discount: </b>${{ \Cart::get($item->id)->getPriceSumWithConditions() }}--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--<div class="col-lg-4">--}}
    {{--<div class="row">--}}
    {{--<form action="{{ route('updateCartRoute') }}" method="POST">--}}
    {{--{{ csrf_field() }}--}}
    {{--<div class="form-group row">--}}
    {{--<input type="hidden" value="{{ $item->id}}" id="id" name="id">--}}
    {{--<input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}"--}}
    {{--id="quantity" name="quantity" style="width: 70px; margin-right: 10px;">--}}
    {{--<button class="btn btn-secondary btn-sm" style="margin-right: 25px;"><i class="fa fa-edit"></i></button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--<form action="{{ route('removeCartRoute') }}" method="POST">--}}
    {{--{{ csrf_field() }}--}}
    {{--<input type="hidden" value="{{ $item->id }}" id="id" name="id">--}}
    {{--<button class="btn btn-dark btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<hr>--}}
    {{--@endforeach--}}
    {{--@if(count($cartCollection)>0)--}}
    {{--<form action="{{ route('clearCartRoute') }}" method="POST">--}}
    {{--{{ csrf_field() }}--}}
    {{--<button class="btn btn-secondary btn-md">Clear Cart</button>--}}
    {{--</form>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--@if(count($cartCollection)>0)--}}
    {{--<div class="col-lg-5">--}}
    {{--<div class="card">--}}
    {{--<ul class="list-group list-group-flush">--}}
    {{--<li class="list-group-item"><b>Total: </b>${{ \Cart::getTotal() }}</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--<br><a href="/shop" class="btn btn-dark">Continue Shopping</a>--}}
    {{--<a href="/checkout" class="btn btn-success">Proceed To Checkout</a>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--<br><br>--}}
    {{--</div>--}}




@endsection
@section('js')
    <script type="application/javascript">
        var i = 1;
        function discountCode(){
            var discount = $('#discount').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route("ajaxUpdateDiscountPriceRoute")}}", // Name of the php files
                data: {'discount':discount},
                success: function(html)
                {
                    console.log(html);
                    $("#totalPrice").text(separate(html['total_amount'])+'تومان');
                    $("#discount-label").text(html['message_discount']);
                    $(".result-payment-red").text(separate(html['cartTotal'])+'تومان');
                    $(".discount-box").show();
                    if(i<=4)
                    {
                        i++;
                        discountCode();
                    }
                },
                error: function(reject){

                }
            });
        }
        function changeNumberBasket(rowId)
        {
            var quantity = $('#numberBasket'+rowId).val();
            var row = rowId;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route("ajaxUpdateCartRoute")}}", // Name of the php files
                data: {'quantity':quantity,'id':row},
                success: function(html)
                {
                    console.log(html);
                    var total = html[0][row]['quantity'] * html[0][row]['price'];
                    $("#totalSingleProduct"+row).text(total);
                    $("#total_amount").text(html[1]);
                    $("#count_basket").text(html[2]);
                    $("#total_count_top").text(html[2]);

                },
                error: function(reject){

                }
            });
        }
        function chevronNumber(type,num_basket)
        {
            var number = $("#numberBasket"+num_basket).val();
            if (type==="down" && number>1)
            {
                var num_minus = number - 1;
                $("#numberBasket"+num_basket).val(num_minus);
                changeNumberBasket(num_basket)
            }
            if (type==="up" && number<10)
            {
                var num_positive = parseInt(number )+ 1;
                $("#numberBasket"+num_basket).val(num_positive);
                changeNumberBasket(num_basket)
            }
        }

        function ajaxGetPriceCity() {
            var city_id = $('#city_id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route("ajaxGetPriceCity")}}", // Name of the php files
                data: {'city_id':city_id},
                success: function(html)
                {
                    $("#priceSend").text(separate(html['citys']['price'])+' تومان ');
                    $("#totalPrice").text(separate(html['cart']+html['citys']['price'])+' تومان ');
                },
                error: function(reject){

                }
            });
        }

        function separate(Number)
        {
            Number+= '';
            Number= Number.replace(',', '');
            x = Number.split('.');
            y = x[0];
            z= x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(y))
                y= y.replace(rgx, '$1' + ',' + '$2');
            return y+ z;
        }
    </script>
@endsection
