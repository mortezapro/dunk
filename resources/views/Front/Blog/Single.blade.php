@extends('Front.Layouts')
@section('main')
    <style>
        .captcha-place img{
            margin: 20px auto 20px auto;
        }
    </style>
    <!--single_blog------------------------------------->
    <div class="container-main">
        <div class="col-lg-3 col-md-4 col-xs-12 pull-right" style="margin-top: 35px;">
            <section class="page-aside">
                <div class="sidebar-wrapper">
                    <div class="listing-sidebar mb-4">
                        <div class="box-header-product-feature mb-3">
                            <span id="title" class="title-product">{{\Morilog\Jalali\Jalalian::forge($blog->created_at)->format('%d %B %Y')}}</span>
                        </div>
                        <div class="box">
                            <div class="box-header" style="text-align: center;">
                                <img
                                    style="max-width: 80%;max-height: 80%"
                                    src="{{asset("dashboard/uploaded/images/post/$blog->media")}}">
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        دسته بندی
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseExample" class="collapse show">
                                <div class="card-main mb-3">
                                    <div class="form-auth-row-custom">
                                        <label for="#" class="ui-checkbox"></label>
                                        <label for="remember" class="remember-me">{{$blog->category}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-9 col-md-8 col-xs-12 pull-left" style="margin-top: 35px;">
            <div class="page-contents">
                <article class="listing-wrapper-tab">
                    <div class="listing mb-4" style="margin-top: 0">
                        <div class="page-content-about-paragraph"
                             style="margin-right: 16px;
                             margin-bottom: 32px;
                             font-size: 16px;
                             color: #a9302a;
                             margin-left: 16px;">
                            {{$blog->title}}
                        </div>
                        <div class="page-content-about-paragraph"
                             style="margin-right: 32px;
                             font-size: 14px;
                             color: #1b1e21;
                             margin-left: 16px;">
                            {!! $blog->description !!}
                        </div>
                    </div>
                </article>
            </div>
        </div>
<div class="tabs mt-4 pt-3 mb-5">
                <div class="tabs-product">
                    <div class="tab-wrapper">
                        <ul class="box-tabs">
                            <li class="box-tabs-tab tabs-active">
                                <a class="box-tab-item" style="cursor: pointer;">
                                    <i class="mdi mdi-comment-text-multiple-outline"></i>
                                    نظرات کاربران</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tabs-content">
                        <div class="content-expert">
                         
                            
                            <section class="tab-content-wrapper" style="display: block;">
                        <div class="comments">
                            <h2 class="comments-headline">نظرات کاربران:
                                <span>
                                    {{$blog->title}}
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
                            @if($comments->hasPages())
                                <section class="comment-body col-lg-12" style="margin-top: 32px;">
                                    {{$comments->links()}}
                                </section>
                            @endif
                        @endforeach
                        <div class="faq-headline">
                            نظر جدید
                            <span>دیدگاه خود را در مورد مقاله مطرح نمایید</span>
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
                                            <textarea title="متن نظر" name="blog_id" class="ui-textarea-field" hidden>{{$blog->id}}</textarea>
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
    <!--single_blog------------------------------------->
@endsection
@section('js')
    {{--    <script>--}}
    {{--        var str = $("#title").text();--}}
    {{--        var res = str.substring(0,16);--}}
    {{--        document.getElementById("title").innerHTML = res;--}}
    {{--    </script>--}}
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
                    url: '{{route("insertCommentBlogRoute")}}',
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
