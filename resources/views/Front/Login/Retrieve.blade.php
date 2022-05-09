@extends('Front.LayoutsLoginRegister')
@section('main')
    <style>
        .captcha-place img{
            display: block;
            margin: 0 auto 20px auto;
        }
    </style>
    <!--page-login-------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="semi-modal-layout">
                <section class="page-account-box">
                    <div class="col-lg-7 col-md-7 col-xs-12 mx-auto">
                        <div class="account-box">
                            <a href="{{route('indexRoute')}}" class="account-box-logo">digistore</a>
                            <div class="account-box-headline remembers-passwords">
                                بازگردانی رمز عبور
                            </div>
                            <br>
                            @include("Dashboard.Partials.errors")
                            <div class="account-box-content">
                                <form action="{{route("postRetrievePasswordRoute")}}" method="post" class="form-account">
                                    {{csrf_field()}}
                                    <div class="form-account-title">
                                        <label for="email-phone">تلفن همراه</label>
                                        <input type="text" name="mobile" class="number-email-input" id="email-phone" value="{{old("mobile")}}" placeholder="تلفن همراه">
                                        <span class="mdi mdi-phone"></span>
                                    </div>
                                    <div class="form-group captcha-place">
                                        <?php echo captcha_img('flat') ?>
                                        <input type="number" id="captcha" placeholder="کد امنیتی" class="form-control" name="captcha" >
                                    </div>
                                    <div class="parent-btn">
                                        <button class="dk-btn dk-btn-info">
                                            ارسال رمز عبور جدید
                                            <i class="mdi mdi-lock"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!--page-login-------------------------->
@endsection
