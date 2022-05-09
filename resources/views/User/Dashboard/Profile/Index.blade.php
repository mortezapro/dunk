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
                        <a href="#" class="breadcrumb-link">پروفایل</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link active-breadcrumb">ویرایش اطلاعات شخصی</a>
                    </li>
                </ul>
            </div>
        </div>
        @include('User.Dashboard.Partials.nav-right')
        <div class="col-lg-9 col-md-9 col-xs-12 pull-left">
            <section class="page-contents">
                <div class="profile-content">
                    <div class="profile-navbar">
                        <div class="profile-navbar-back-alignment">
                            <a href="{{route('userDashboardRoute')}}" class="profile-navbar-btn-back">بازگشت</a>
                            <h4 class="edit-personal">ویرایش اطلاعات</h4>
                        </div>
                    </div>
                    <div class="profile-stats">
                        <form method="post" action="{{route("postProfileUserDashboardRoute")}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="profile-stats-row">
                                <fieldset class="form-legal-fieldset">
                                    @include("Dashboard.Partials.notifications")
                                    @include("Dashboard.Partials.errors")
                                    <h4 class="form-legal-headline">ویرایش اطلاعات</h4>
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
                                                <select name="city" id="city_id" class=" form-control">
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
                                <div class="col-12" style="padding:0;">
                                    <div class="profile-stats-row form-legal-row-submit">
                                        <div class="parent-btn parent-store">
                                            <button type="submit" class="dk-btn dk-btn-info btn-store">
                                                ویرایش اطلاعات کاربری
                                                <i class="fa fa-sign-in"></i>
                                            </button>
                                        </div>
                                        <a href="{{route('userDashboardRoute')}}" class="btn btn-default-gray">انصراف</a>
                                    </div>
                                </div>
                            </div>
                        </form>
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