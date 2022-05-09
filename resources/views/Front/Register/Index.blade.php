@extends("Front.LayoutsLoginRegister")
@section("main")
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
                        <div class="account-box" style="padding-bottom:40px;">
                            <a href="{{route('indexRoute')}}" class="account-box-logo">digistore</a>
                            <div class="account-box-headline">
                                <a href="{{route('userLoginRoute')}}" class="login-ds">ورود</a>
                                <a href="{{route('registerRoute')}}" class="register-ds active-account">ثبت نام</a>
                            </div>
                            <div class="massege-light">ثبت نام تنها با شماره تلفن همراه امکان پذیر است.</div>
                            <div class="account-box-content">
                                @include("Front.Partials.errors")
                                <form action="{{route('doRegisterRoute')}}" class="form-account" method="post">
                                    {{csrf_field()}}
                                    <div class="form-account-title">
                                        <label for="email-phone">نام و نام خانوادگی</label>
                                        <input type="text" class="number-email-input" name="name" value="{{old('name')}}" id="email-phone" placeholder=" نام و نام خانوادگی خود را وارد نمایید">
                                        <span class="mdi mdi-ab-testing"></span>
                                    </div>
                                    <div class="form-account-title">
                                        <label for="password">نام کاربری</label>
                                        <input type="text" class="password-input" name="username" value="{{old('username')}}" placeholder="نام کاربری خود را وارد نمایید">
                                        <span class="mdi mdi-account"></span>
                                    </div>
                                    <div class="form-account-title">
                                        <label for="password">تلفن تماس</label>
                                        <input type="tel" class="password-input" name="tell" value="{{old('tell')}}" placeholder="تلفن تماس خود را وارد نمایید">
                                        <span class="mdi mdi-phone"></span>
                                    </div>
                                    <div class="form-account-title">
                                        <label for="password">نام کاربری معرف</label>
                                        <input type="text" class="password-input" name="introduced" value="{{old('introduced')}}" placeholder="نام کاربری معرف خود را وارد نمایید">
                                        <span class="mdi mdi-account-badge"></span>
                                    </div>
                                    <div class="form-account-title">
                                        <label for="password">رمز عبور</label>
                                        <input type="password" class="password-input" name="password" value="{{old('password')}}" placeholder="کلمه عبور خود را وارد نمایید">
                                        <span class="mdi mdi-textbox-password"></span>
                                    </div>
                                    <div class="form-account-title">
                                        <label for="password">تکرار رمز عبور</label>
                                        <input type="password" class="password-input" value="{{old('password_confirmation')}}" name="password_confirmation" placeholder="کلمه عبور خود را مجدد وارد نمایید">
                                        <span class="mdi mdi-repeat"></span>
                                    </div>
                                    <div class="form-group captcha-place">
                                        <?php echo captcha_img('flat') ?>
                                        <input type="number" id="captcha" placeholder="کد امنیتی" class="form-control" name="captcha" >
                                    </div>
                                    <div class="form-auth-row">
                                        <label for="#" class="ui-checkbox">
                                            <input type="checkbox" value="1" name="confirmation" id="remember">
                                            <span class="ui-checkbox-check"></span>
                                        </label>
                                        <label for="remember" class="remember-me"><a target="_blank" href="{{route('frontAboutRoute')}}">حریم خصوصی</a> و <a target="_blank" href="{{route('frontAboutRoute')}}">شرایط قوانین</a>استفاده از سرویس های سایت دیجی‌اسمارت را مطالعه نموده و با کلیه موارد آن موافقم.</label>
                                    </div>
                                    <div class="parent-btn lr-ds">
                                        <button class="dk-btn dk-btn-info">
                                            ثبت نام
                                            <i class="fa fa-sign-in sign-in"></i>
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
