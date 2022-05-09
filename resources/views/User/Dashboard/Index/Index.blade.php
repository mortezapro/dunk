@extends('Front.Layouts')
@section('main')
    <!--profile------------------------------------>
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">حساب کاربری من</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link active-breadcrumb">پروفایل</a>
                    </li>
                </ul>
            </div>
        </div>
        @include('User.Dashboard.Partials.nav-right')
        <div class="col-lg-9 col-md-9 col-xs-12 pull-left">
            <section class="page-contents">
                <div class="profile-content">
                    <div class="headline-profile">
                        <span>اطلاعات شخصی</span>
                    </div>
                    <div class="profile-stats">
                        <div class="profile-stats-row">
                            <div class="col-lg-6 col-md-6 col-xs-12 pull-right">
                                <div class="profile-stats-col">
                                    <div class="profile-stats-content">
                                        <span class="profile-first-title"> نام و نام خانوادگی :</span>
                                        <span class="profile-second-title">{{$user->user_flname}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 pull-right">
                                <div class="profile-stats-col">
                                    <div class="profile-stats-content">
                                        <span class="profile-first-title"> نام کاربری :</span>
                                        <span class="profile-second-title">{{$user->user_name}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 pull-right">
                                <div class="profile-stats-col">
                                    <div class="profile-stats-content">
                                        <span class="profile-first-title"> شماره تلفن همراه :</span>
                                        <span class="profile-second-title">{{$user->user_mobile}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 pull-right">
                                <div class="profile-stats-col">
                                    <div class="profile-stats-content">
                                        <span class="profile-first-title"> کد پستی :</span>
                                        <span class="profile-second-title">
                                            {{$user->user_postalcode}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 pull-right">
                                <div class="profile-stats-col">
                                    <div class="profile-stats-content">
                                        <span class="profile-first-title"> شهر :</span>
                                        <span class="profile-second-title">{{$user->city}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 pull-right">
                                <div class="profile-stats-col">
                                    <div class="profile-stats-content">
                                        <span class="profile-first-title"> کد معرف من :</span>
                                        <span class="profile-second-title">{{$user->identifier_code}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-xs-12 pull-right">
                                <div class="profile-stats-col">
                                    <div class="profile-stats-content">
                                        <span class="profile-first-title"> آدرس :</span>
                                        <span class="profile-second-title">{{$user->user_address}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-stats-action">
                            <a href="{{route('profileUserDashboardRoute')}}" class="link-spoiler-edit"><i class="fa fa-pencil"></i>ویرایش اطلاعات</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!--profile------------------------------------>
@endsection

@section('js')
    <script>
        $("#fileToUpload").change(function(){
            document.getElementById("loading").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic').css('background-image', "url('" + e.target.result + "')");
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            readURL(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData();
            formData.append('file', $('input[type=file]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("postProfileAjaxUserDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading").hidden = true;
                    document.getElementById("loading-success").hidden = false;
                },
                error: function () {
                    document.getElementById("loading").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
    </script>
@endsection
