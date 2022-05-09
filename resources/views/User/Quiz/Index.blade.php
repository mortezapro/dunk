@extends('Front.Layouts')
@section('main')
    <!--contact-us--------------------------------->
    <div class="container-main">
        <div class="col-12">
            <section class="contact-us">
                <div class="page-content-contact-us">
                    <h1 class="page-content-contact-us-title">شروع مسابقه</h1>
                    <div class="page-content-contact-us-row">
                        <div class="col-lg-8 col-md-8 col-xs-12 pull-right">
                            <div class="page-content-contact-us-col-big">
                                <br>
                                <br>
                                <p class="page-content-contact-us-full-paragraph">لطفا برای ورود به مسابقه کُد کتاب را در کادر زیر وارد کنید.</p>
                                <hr class="info-page-separator">
                                @include("Dashboard.Partials.notifications")
                                @include("Dashboard.Partials.errors")
                                @if(session('mistakeCode'))
                                    <div class="massege-light" style="width: 100%; margin: 0 0 35px 0;padding: 20px 10px">
                                        <p style="color: #a37731;text-align: right;font-size: 14px">* کد وارد شده صحیح نمی باشد</p>
                                    </div>
                                @endif
                                @if(session('usedCode'))
                                    <div class="massege-light" style="width: 100%; margin: 0 0 35px 0;padding: 20px 10px">
                                        <p style="color: #a37731;text-align: right;font-size: 14px">* این کد قبلا استفاده شده است</p>
                                    </div>
                                @endif
                                <div class="page-content-contact-us-row-col">
                                    <form method="post" action="{{route('checkQuizCodeRoute')}}" enctype="multipart/form-data" class="contact-us-form">
                                        {{csrf_field()}}
                                        <div class="contact-us-form-body">
                                            <div class="form-legal-item">
                                                <label for="#" class="form-legal-label">
                                                    کد کتاب
                                                    <span class="required-star" style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="book_code" class="ui-input-field form-control" placeholder="کد کتاب را وارد کنید">
                                            </div>
                                            <div class="upload-drag-uploaded-and-submit">
                                                <button class="contact-us-form-submit">بررسی کد</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12 pull-left">
                            <div class="page-content-contact-us-image-container text-left">
                                <img src="{{asset('img/books1.png')}}" style="width: 200px; height: 186px">
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!--contact-us--------------------------------->
    <style>
        .captcha-place img{
            display: block;
            margin: 0 auto 20px auto;
        }
    </style>
@endsection
