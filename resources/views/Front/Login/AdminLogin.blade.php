<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset("dashboard/favicon.ico")}}">
    <link rel="icon" href="{{asset("dashboard/favicon.ico")}}" type="image/x-icon">
    <!-- Jasny-bootstrap CSS -->
    <link href="{{asset("dashboard/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css")}}" rel="stylesheet" type="text/css"/>
    <!-- Custom CSS -->
    <link href="{{asset("dashboard/dist/css/style.css")}}" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="{{asset("dashboard/vendors/bower_components/jquery/dist/jquery.min.js")}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset("dashboard/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>

    <link href="{{asset("dashboard/dist/css/font-awesome.min.css")}}">
    <!-- Slimscroll JavaScript -->
    <script src="{{asset("dashboard/dist/js/jquery.slimscroll.js")}}"></script>

    <title>ورود به پنل مدیریت جایزه دون</title>
    <style>
        .captcha-place img
        {
            display: block;
            margin:0 auto 15px auto;
        }
    </style>
</head>
<body>
<!--Preloader-->
<div class="preloader-it">
    <div class="la-anim-1"></div>
</div>
<!--/Preloader-->

<div class="wrapper pa-0">
    <header class="sp-header">
        <div class="sp-logo-wrap pull-left">
            <a href="index.html">
                <img class="brand-img mr-10" src="https://jayezedoon.ir/dashboard/dist/img/logo.png" alt="brand"/>
                <span class="brand-text">ورود به پنل مدیریت</span>
            </a>
        </div>
        <div class="clearfix"></div>
    </header>

    <!-- Main Content -->
    <div class="page-wrapper pa-0 ma-0 auth-page">
        <div class="container-fluid">
            <!-- Row -->
            <div class="page-wrapper pa-0 ma-0 auth-page">
                <div class="container-fluid">
                    <div class="table-struct full-width full-height">
                        <div class="table-cell vertical-align-middle auth-form-wrap">
                            <div class="auth-form  ml-auto mr-auto no-float">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="mb-30">
                                            <h3 class="text-center txt-dark mb-10">ورود به پنل جایزه دون</h3>
                                            <h6 class="text-center nonecase-font txt-grey">اطلاعات خود را در کادر زیر وارد کنید</h6>
                                        </div>
                                        <div class="form-wrap">
                                            @include("Dashboard.Partials.errors")
                                            <form method="post" action="{{route("PostAdminLoginRoute")}}" aria-label="Register">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <label class="control-label mb-10" for="exampleInputEmail_2">نام کاربری</label>
                                                    <input id="username" type="text" placeholder="نام کاربری" class="form-control" name="username" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="pull-left control-label mb-10" for="exampleInputpwd_2">رمز عبور</label>
                                                    <input id="password" type="password" placeholder="رمز عبور" class="form-control" name="password" required>
                                                </div>
                                                <div class="form-group captcha-place">
                                                    <?php echo captcha_img('flat') ?>
                                                    <input type="number" id="captcha"  placeholder="کد امنیتی" class="form-control" name="captcha"  autocomplete="off" >
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-info btn-rounded">ورود</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Row -->
                </div>
            </div>
            <!-- /Row -->
        </div>

    </div>
    <!-- /Main Content -->

</div>
<script src="{{asset("dashboard/dist/js/init.js")}}"></script>
</body>
</html>
