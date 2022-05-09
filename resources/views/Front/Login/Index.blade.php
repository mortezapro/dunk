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
                            <a href="{{route('indexRoute')}}" class="account-box-logo">jayezedoon</a>
                            <div class="account-box-headline">
                                <a href="{{route('userLoginRoute')}}" class="login-ds active-account">ورود</a>
                                <a href="{{route('registerRoute',['type'=>'basket'])}}" class="register-ds">ثبت نام</a>
                            </div>
                            <div class="account-box-content">
                                @include("Front.Partials.errors")
                                @include("Dashboard.Partials.notifications")
                                @if(session()->get("noUserFound"))
                                    <div class="alert alert-danger">
                                        <p>کاربری با این مشخصات یافت نشد</p>
                                    </div>
                                @endif
                                <form action="{{route("userDoLoginRoute")}}" class="form-account" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="access" class="number-email-input" value="@php if(isset($_GET['type'])) echo $_GET['type'];  @endphp">
                                    <input type="hidden" name="id_reward" class="number-email-input" value="@php if(isset($_GET['id'])) echo $_GET['id'];  @endphp">
                                    <div class="form-account-title">
                                        <label for="email-phone">نام کاربری</label>
                                        <input type="text" name="username" class="number-email-input" id="email-phone" placeholder="نام کاربری خود را وارد نمایید">
                                        <span class="mdi mdi-account"></span>
                                    </div>
                                    <div class="form-account-title">
                                        <label for="password">رمز عبور</label>
                                        <input type="password" name="password" class="password-input" placeholder="رمز عبور خود را وارد نمایید">
                                        <span class="mdi mdi-textbox-password"></span>
                                    </div>
                                    <div class="form-group captcha-place">
                                        <?php echo captcha_img('flat') ?>
                                        <input type="number" id="captcha" placeholder="کد امنیتی" class="form-control" name="captcha" >
                                    </div>
                                    <div class="form-auth-row">
                                        <label for="#" class="ui-checkbox">
                                            <input type="checkbox" value="1" name="login" checked="" id="remember">
                                            <span class="ui-checkbox-check"></span>
                                        </label>
                                        <label for="remember" class="remember-me">مرا به خاطر داشته باش</label>
                                    </div>
                                    <div class="parent-btn lr-ds">
                                        <button class="dk-btn dk-btn-info">
                                            ورود به جایزه دون
                                            <i class="fa fa-sign-in sign-in"></i>
                                        </button>
                                    </div>
                                    <div class="forget-password">
                                        <a href="{{route('retrievePasswordRoute')}}" class="account-link-password">رمز خود را فراموش کرده ام</a>
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

