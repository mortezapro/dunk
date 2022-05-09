@extends('Front.Layouts')
@section('main')
    <style>
        .captcha-place img{
            margin: 20px auto 20px auto;
        }
    </style>
    <!--single-product----------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('indexRoute')}}" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('rewardRoute')}}" class="breadcrumb-link">جایزه</a>
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
    {{--
    <div class="item">
        <a class="gallery-item" href="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}"
           data-fancybox="gallery1" data-hash="two">
            <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
        </a>
    </div>
    <div class="item">
        <a class="gallery-item" href="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}"
           data-fancybox="gallery1" data-hash="three">
            <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
        </a>
    </div>
    <div class="item">
        <a class="gallery-item" href="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}"
           data-fancybox="gallery1" data-hash="four">
            <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
        </a>
    </div>
    --}}
</div>
                        {{--
<ul class="product-thumbnails">
    <li class="active">
        <a href="#one">
            <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
        </a>
    </li>
    <li>
        <a href="#two">
            <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
        </a>
    </li>
    <li>
        <a href="#three">
            <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
        </a>
    </li>
    <li>
        <a href="#four">
            <img src="{{asset("dashboard/uploaded/images/reward_image/$reward->reward_image")}}" alt="Product">
        </a>
    </li>
</ul>
                        --}}
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
                <div class="product-directory">
                    <ul>
                        <li>
                            <span>دسته بندی</span>
                            :
                            <a href="{{route('catRewardRoute',['id'=>$cat_reward_name->cat_id])}}" class="product-brand-title">{{$cat_reward_name->cat_name}}</a>
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
    <div class="col-lg-5 col-xs-12 pull-left">
        <div class="product-summary">
            <div class="product-seller-info">
                <div class="seller-info-changable">
                    @if($reward->anbar == "موجود")
                    <div class="product-seller-row vendor">
                        <span class="title"> فروشنده:</span>
                        <a class="product-name">جایزه دون</a>
                    </div>
                    <div class="product-seller-row guarantee">
                        <span class="title"> گارانتی:</span>
                        <a class="product-name">گارانتی اصالت و سلامت فیزیکی کالا</a>
                    </div>
                    <div class="product-seller-row guarantee">
                        <span class="title"> وضعیت انبار:</span>
                        <a class="product-name">{{$reward->anbar}}</a>
                    </div>
                    <div class="product-seller-row price">
                        <div class="product-seller-price-info price-value mb-3">
                            <span class="title"> تعداد سکه:</span>
                            <span class="amount text-danger">
                                    {{$reward->reward_coin}}
                                    <span>عدد</span>
                                </span>
                        </div>
                    </div>
                    @else
                        <div class="c-product-stock__body">
                            متاسفانه این جایزه در حال حاضر موجود نیست. می‌توانید از طریق لیست پایین صفحه، از محصولات مشابه این جایزه دیدن نمایید
                        </div>
                    @endif
                    @if(session()->get("user_id")!=null)
                        <div class="parent-btn">
                            @if($reward->anbar == "موجود")
                            <button class="dk-btn dk-btn-info at-c as-c" data-toggle="modal" data-target="#confirm_buy">
                                خرید جایزه
                                <i class="mdi mdi-cart"></i>
                            </button>
                            @else
                                <button class="btn-unavailable" disabled>
                                    ناموجود
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="parent-btn">
                            @if($reward->anbar == "موجود")
                            <button class="dk-btn dk-btn-info at-c as-c" data-toggle="modal" data-target="#confirm_login">
                                خرید جایزه
                                <i class="mdi mdi-lock"></i>
                            </button>
                            @else
                                <button class="btn-unavailable" disabled>
                                    ناموجود
                                </button>
                            @endif
                        </div>
                    @endif
                    <div id="confirm_buy" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="text-right"> آیا واقعا قصد خرید {{$reward->reward_title}} را دارید؟ </p>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <a href="" class="btn btn-primary" data-dismiss="modal">خیر</a>
                                    <a onclick="Function_confirm_buy()" href="{{route("rewardCheckoutRoute",["reward_id"=>$reward->reward_id])}}" class="btn btn-danger">بله</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="confirm_login" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="text-right" style="margin-left: 16px;">برای دریافت جایزه ابتدا ثبت نام کنید یا وارد حساب کاربری خود شوید.</p>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <a onclick="Function_confirm_login()" href="{{route('registerRoute')}}" class="btn btn-primary">ثبت نام</a>
                                    <a onclick="Function_confirm_login()" href="{{route('userLoginRoute',['type'=>'reward','id'=>$reward->reward_id])}}" class="btn btn-danger">ورود به حساب کاربری</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
</article>
</div>
<!--    product-slider----------------------------------->
<div class="col-lg-12 col-md-12 col-xs-12 pull-right">
<div class="section-slider-product mb-4">
<div class="widget widget-product card">
<header class="card-header">
<span class="title-one">محصولات مرتبط</span>
<h3 class="card-title">مشاهده همه</h3>
</header>
<div class="product-carousel owl-carousel owl-theme owl-rtl owl-loaded owl-drag">
<div class="owl-stage-outer">
    <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2234px;">
        @foreach($reward_related as $item)
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
<div class="owl-nav">
    <button type="button" role="presentation" class="owl-prev disabled">
        <i class="fa fa-angle-right"></i>
    </button><button type="button" role="presentation" class="owl-next">
        <i class="fa fa-angle-left"></i>
    </button></div>
<div class="owl-dots disabled">
</div>
</div>
</div>
</div>
</div>
<!--    product-slider------------------------->
<div class="col-12">
<div class="tabs mt-4 pt-3 mb-5">
<div class="tabs-product">
<div class="tab-wrapper">
<ul class="box-tabs">
    <li class="box-tabs-tab tabs-active">
        <a class="box-tab-item" style="cursor: pointer;">
            <i class="mdi mdi-glasses"></i>
            نقد و بررسی</a>
    </li>
    <li class="box-tabs-tab">
        <a class="box-tab-item" style="cursor: pointer;">
            <i class="mdi mdi-format-list-checks"></i>
            مشخصات</a>
    </li>
    <li class="box-tabs-tab">
        <a class="box-tab-item" style="cursor: pointer;">
            <i class="mdi mdi-comment-text-multiple-outline"></i>
            نظرات کاربران</a>
    </li>
</ul>
</div>
<div class="tabs-content">
<div class="content-expert">
    <section class="tab-content-wrapper" style="display:block;">
        <article>
            <h2 class="params-headline">نقد و بررسی
                <span>{{$reward->reward_title}}</span>
            </h2>
            <section class="content-expert-summary">
                <div class="mask pm-3">
                    <div class="mask-text">
                        <p></p>
                    </div>
                    <a href="#" class="mask-handler">
                        <span class="show-more">+ ادامه مطلب</span>
                        <span class="show-less">- بستن</span>
                    </a>
                    <div class="shadow-box"></div>
                </div>
            </section>
        </article>
    </section>
    <section class="tab-content-wrapper">
        <article>
            <h2 class="params-headline">مشخصات فنی
                <span>{{$reward->reward_title}}</span>
            </h2>
            <section>
                <h3 class="params-title">مشخصات کلی</h3>
                <ul class="params-list">
                    <li class="params-list-item">
                        <div class="params-list-key">
                            <span class="block">نام محصول</span>
                        </div>
                        <div class="params-list-value">
                            <span class="block">
                                {{$reward->reward_title}}
                                @php echo ' '; @endphp
                                {{$reward->reward_desc}}
                            </span>
                        </div>
                    </li>
                    <li class="params-list-item">
                        <div class="params-list-key">
                            <span class="block">تعداد سکه</span>
                        </div>
                        <div class="params-list-value">
                            <span class="block">
                                {{$reward->reward_coin}} عدد
                            </span>
                        </div>
                    </li>
                    <li class="params-list-item">
                        <div class="params-list-key">
                            <span class="block">وضعیت انبار</span>
                        </div>
                        <div class="params-list-value">
                            <span class="block">
                                {{$reward->anbar}}
                            </span>
                        </div>
                    </li>
                </ul>
            </section>
        </article>
    </section>
    <section class="tab-content-wrapper">
        <div class="comments">
            <h2 class="comments-headline">نظرات کاربران:
                <span>
                    {{$reward->reward_title}}
                </span>
            </h2>
        </div>
        @foreach($comments as $item)
            <section class="comment-body col-lg-12" style="margin-top: 32px;">
                <div class="col-lg-4 col-md-4 col-xs-12 pull-right">
                    <div class="aside">
                        <ul class="comments-user-shopping pt-1">
                            <li class="mb-3">
                                @if($item->user_flname != null)
                                    <div class="cell cell-name">{{$item->user_flname}}</div>
                                @else
                                    <div class="cell cell-name">کاربر مهمان</div>
                                @endif
                            </li>
                            <li>
                                <div class="cell">
                                    {{\Morilog\Jalali\Jalalian::forge($item->created_at)->format('%d %B %Y')}}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-xs-12 pull-left">
                    <div class="article">
                        <div class="header">
                            @if($item->user_flname != null)
                                <div>{{$item->user_flname}}</div>
                            @else
                                <div>کاربر مهمان</div>
                            @endif
                        </div>
                        <p>{{$item->text}}</p>
                    </div>
                </div>
            </section>
        @endforeach
        @if($comments->hasPages())
            <section class="comment-body col-lg-12" style="margin-top: 32px;">
                {{$comments->links()}}
            </section>
        @endif
        <div class="faq-headline">
            نظر جدید
            <span>دیدگاه خود را در مورد محصول مطرح نمایید</span>
        </div>
        <div class="alert alert-success" id="alert-success" hidden>
            <p>اطلاعات با موفقیت درج شد.</p>
        </div>
        <div class="alert alert-danger" id="alert-danger" hidden>
            <p>مشکلی پیش آمده است.</p>
        </div>
        <form method="post" class="contact-us-form" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-faq">
                <div class="form-faq-row mt-3">
                    <div class="form-faq-col">
                        <div class="ui-textarea">
                            <textarea title="متن نظر" name="text" class="ui-textarea-field" required></textarea>
                            <textarea title="متن نظر" name="reward_id" class="ui-textarea-field" hidden>{{$reward->reward_id}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group captcha-place">
                    <div class="captcha">
                        <span>{!! captcha_img('flat') !!}</span>
                        <button type="button" class="btn btn-primary" style="padding: 5px !important;background-color: #02b4e4;border: none !important;" id="refresh"><i class="fa fa-refresh"></i></button>
                    </div>
                    <input type="number" id="captcha" placeholder="کد امنیتی" class="form-control" name="captcha" >
                </div>
                <div class="form-faq-row mt-3">
                    <div class="form-faq-col form-faq-col-submit">
                        <button class="btn-tertiary" type="submit">ثبت نظر</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
</div>
</div>
</div>
</div>
</div>
<!--single-product----------------------------->
<script>
function Function_confirm_buy() {
$('#confirm_buy').modal('hide');
}
function Function_confirm_login() {
$('#confirm_login').modal('hide');
}
</script>
@endsection
@section('js')
<script>
$(document).ready(function () {
$('form').on('submit', function (e) {
document.getElementById("alert-success").hidden = true;
document.getElementById("alert-danger").hidden = true;
e.preventDefault();
var formData = new FormData($(this)[0]);
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
type: 'POST',
url: '{{route("insertCommentRewardRoute")}}',
data: formData,
contentType: false, // The content type used when sending data to the server.
cache: false, // To unable request pages to be cached
processData: false,
success: function (msg)
{
if(msg['state'] == "successInsert")
{
    refreshCaptcha();
    document.getElementById("alert-success").hidden = false;
}
},
error: function () {
refreshCaptcha();
document.getElementById("alert-danger").hidden = false;
}
});
});
});

function refreshCaptcha()
{
$.ajax({
type:'GET',
url:'{{route('refreshcaptcha')}}',
success:function(data){
$(".captcha span").html(data.captcha);
}
});
}
$('#refresh').click(function(){
$.ajax({
type:'GET',
url:'{{route('refreshcaptcha')}}',
success:function(data){
$(".captcha span").html(data.captcha);
}
});
});
</script>

@endsection
