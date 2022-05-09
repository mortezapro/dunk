@extends('Front.LayoutsLoginRegister')
@section('main')
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
                            @if(session()->get("wrong_code"))
                                <div class="alert alert-danger">
                                    <p>رمز عبور جدید اشتباه است.</p>
                                </div>
                            @endif
                            <div class="account-box-content">
                                <form action="{{route("postConfirmPasswordRoute")}}" method="post" class="form-account">
                                    {{csrf_field()}}
                                    <div class="form-account-title">
                                        <div class="form-account-title">
                                            <label for="password">رمز عبور پیامک شده را وارد نمایید</label>
                                            <input type="password" name="code" class="password-input" placeholder="رمز عبور">
                                            <span class="mdi mdi-lock"></span>
                                        </div>
                                    </div>
                                    <div class="parent-btn">
                                        <button class="dk-btn dk-btn-info">
                                            ارسال
                                            <i class="fa fa-refresh"></i>
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
