@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>پنل مدیریت جایزه دون</title>
    <style>
    textarea
    {
    	resize:none;
    	height:200px !important;
    }
    .checkbox
    {
    	float:right;
    	display:inline-block;
    }
    label
    {
	    display:inline-block;
	    margin-right:10px;
	    margin-top:5px;
    }
    .mt-20
    {
    	margin-top:20px;
    }
    .profile-pic_1, .profile-pic_2,.profile-pic_3,.profile-pic_4,.profile-pic_5,.profile-pic_6 {
        border-radius: 15%;
        height: 150px;
        width: 150px;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        vertical-align: middle;
        text-align: center;
        color: transparent;
        transition: all .3s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .profile-pic_7, .profile-pic_8 {
        border-radius: 15%;
        height: 150px;
        width: 150px;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        vertical-align: middle;
        text-align: center;
        color: transparent;
        transition: all .3s ease;
        text-decoration: none;
        cursor: pointer;
    }
    </style>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">صفحه اصلی تنظیمات</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>صفحه اصلی تنظیمات</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route("adminHomePostSettingRoute")}}" method="post">
                                @csrf
                                <div class="form-group col-lg-12" style="border-bottom: 2px solid">
                                    <label class="control-label mb-10 text-left" for="s1">اسلایدر اصلی</label>
					                <input class="checkbox " @if($setting->s1==1) checked @endif @if($setting->s1==0) @endif type="checkbox" id="s1" name="s1"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="s2">اسلایدر فرعی</label>
                                    <input class="checkbox " @if($setting->s2==1) checked @endif @if($setting->s2==0) @endif type="checkbox" id="s2" name="s2"/>
                                </div>
                                <div class="form-group col-lg-12">
                                        <label for="fileToUpload_1">
                                            <div class="profile-pic_1" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_1)}}')">
                                                <span>ویرایش عکس</span>
                                            </div>
                                        </label>
                                        <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_1" id="fileToUpload_1">
                                    <span id="loading_1" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_1" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                     <input value="{{$setting->link_1}}" type="text" id="link_1" name="link_1" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12" style="border-bottom: 2px solid">
                                    <label for="fileToUpload_2">
                                        <div class="profile-pic_2" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_2)}}')">
                                            <span>ویرایش عکس</span>
                                        </div>
                                    </label>
                                    <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_2" id="fileToUpload_2">
                                    <span id="loading_2" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_2" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                    <input value="{{$setting->link_2}}" type="text" id="link_2" name="link_2" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="s3">جدیدترین محصولات</label>
                                    <input class="checkbox " @if($setting->s3==1) checked @endif @if($setting->s3==0) @endif type="checkbox" id="s3" name="s3"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="s4">محصولات پیشنهاد لحظه ای</label>
                                    <input class="checkbox " @if($setting->s4==1) checked @endif @if($setting->s4==0) @endif type="checkbox" id="s4" name="s4"/>
                                </div>
                                <div class="form-group col-lg-12" style="border-bottom: 2px solid">
                                    <label class="control-label mb-10 text-left" for="s5">سکشن دسته بندی محصولات</label>
                                    <input class="checkbox " @if($setting->s5==1) checked @endif @if($setting->s5==0) @endif type="checkbox" id="s5" name="s5"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="s6">سکشن چهار عکس ثابت</label>
                                    <input class="checkbox " @if($setting->s6==1) checked @endif @if($setting->s6==0) @endif type="checkbox" id="s6" name="s6"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="fileToUpload_3">
                                        <div class="profile-pic_3" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_3)}}')">
                                            <span>ویرایش عکس</span>
                                        </div>
                                    </label>
                                    <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_3" id="fileToUpload_3">
                                    <span id="loading_3" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_3" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                    <input value="{{$setting->link_3}}" type="text" id="link_3" name="link_3" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="fileToUpload_4">
                                        <div class="profile-pic_4" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_4)}}')">
                                            <span>ویرایش عکس</span>
                                        </div>
                                    </label>
                                    <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_4" id="fileToUpload_4">
                                    <span id="loading_4" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_4" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                    <input value="{{$setting->link_4}}" type="text" id="link_4" name="link_4" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="fileToUpload_5">
                                        <div class="profile-pic_5" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_5)}}')">
                                            <span>ویرایش عکس</span>
                                        </div>
                                    </label>
                                    <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_5" id="fileToUpload_5">
                                    <span id="loading_5" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_5" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                    <input value="{{$setting->link_5}}" type="text" id="link_5" name="link_5" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12" style="border-bottom: 2px solid">
                                    <label for="fileToUpload_6">
                                        <div class="profile-pic_6" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_6)}}')">
                                            <span>ویرایش عکس</span>
                                        </div>
                                    </label>
                                    <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_6" id="fileToUpload_6">
                                    <span id="loading_6" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_6" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                    <input value="{{$setting->link_6}}" type="text" id="link_6" name="link_6" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12" style="border-bottom: 2px solid">
                                    <label class="control-label mb-10 text-left" for="s7">اسلایدر محصول</label>
                                    <input class="checkbox " @if($setting->s7==1) checked @endif @if($setting->s7==0) @endif type="checkbox" id="s7" name="s7"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="s8">سکشن دو عکس ثابت</label>
                                    <input class="checkbox " @if($setting->s8==1) checked @endif @if($setting->s8==0) @endif type="checkbox" id="s8" name="s8"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="fileToUpload_7">
                                        <div class="profile-pic_7" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_7)}}')">
                                            <span>ویرایش عکس</span>
                                        </div>
                                    </label>
                                    <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_7" id="fileToUpload_7">
                                    <span id="loading_7" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_7" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                    <input value="{{$setting->link_7}}" type="text" id="link_7" name="link_7" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12" style="border-bottom: 2px solid">
                                    <label for="fileToUpload_8">
                                        <div class="profile-pic_8" style="background-image: url('{{asset('dashboard/uploaded/images/sliders/'.$setting->image_8)}}')">
                                            <span>ویرایش عکس</span>
                                        </div>
                                    </label>
                                    <input style="margin-top: 16px;margin-bottom: 16px;" type="File" accept=".png, .jpg, .jpeg" name="image_8" id="fileToUpload_8">
                                    <span id="loading_8" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                                    <span id="loading-success_8" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                                    <input value="{{$setting->link_8}}" type="text" id="link_8" name="link_8" class="form-control" placeholder="لینک ">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="s9">اسلایدر جوایز</label>
                                    <input class="checkbox " @if($setting->s9==1) checked @endif @if($setting->s9==0) @endif type="checkbox" id="s9" name="s9"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="s10">اسلایدر کلی محصولات(غیرفعال)</label>
                                    <input class="checkbox " @if($setting->s10==1) checked @endif @if($setting->s10==0) @endif type="checkbox" id="s10" name="s10"/>
                                </div>
                                <div class="form-group col-lg-12">
                                    <button class="btn btn-primary btn-icon-anim mt-20" type="submit">ثبت</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $("#fileToUpload_1").change(function(){
            document.getElementById("loading_1").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_1').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_1', $('input[name=image_1]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_1").hidden = true;
                    document.getElementById("loading-success_1").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_1").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
        $("#fileToUpload_2").change(function(){
            document.getElementById("loading_2").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_2').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_2', $('input[name=image_2]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_2").hidden = true;
                    document.getElementById("loading-success_2").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_2").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
        $("#fileToUpload_3").change(function(){
            document.getElementById("loading_3").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_3').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_3', $('input[name=image_3]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_3").hidden = true;
                    document.getElementById("loading-success_3").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_3").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
        $("#fileToUpload_4").change(function(){
            document.getElementById("loading_4").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_4').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_4', $('input[name=image_4]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_4").hidden = true;
                    document.getElementById("loading-success_4").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_4").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
        $("#fileToUpload_5").change(function(){
            document.getElementById("loading_5").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_5').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_5', $('input[name=image_5]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_5").hidden = true;
                    document.getElementById("loading-success_5").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_5").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
        $("#fileToUpload_6").change(function(){
            document.getElementById("loading_6").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_6').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_6', $('input[name=image_6]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_6").hidden = true;
                    document.getElementById("loading-success_6").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_6").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
        $("#fileToUpload_7").change(function(){
            document.getElementById("loading_7").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_7').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_7', $('input[name=image_7]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_7").hidden = true;
                    document.getElementById("loading-success_7").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_7").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
        $("#fileToUpload_8").change(function(){
            document.getElementById("loading_8").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic_8').css('background-image', "url('" + e.target.result + "')");
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
            formData.append('image_8', $('input[name=image_8]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("changeCoverImageDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading_8").hidden = true;
                    document.getElementById("loading-success_8").hidden = false;
                },
                error: function () {
                    document.getElementById("loading_8").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
    </script>
@endsection
