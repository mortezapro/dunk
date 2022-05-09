@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/dist/css/select2.min.css")}}" rel="stylesheet" type="text/css"/>
    <title>پنل مدیریت جایزه دون</title>

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            vertical-align: baseline;
            white-space: nowrap;
            line-height: 30px;
            color: black;
            }
    </style>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">کتاب ها</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>books</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route("insertBookRoute")}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="category_id">انتخاب دسته بندی کتاب <span class="help"></span></label>
                                    <select class="js-example-basic-multiple" name="cat_ids[]" id="category_id" multiple="multiple">
                                        @foreach( $book_cats as $book_cat)
                                            <option value="{{$book_cat->category_id}}">{{$book_cat->category_name}}</option>
                                                @endforeach
                                            </select>

                                </div>



                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="book_name">نام کتاب<span class="help"></span></label>
                                    <input value="{{old("book_name")}}" type="text" id="book_name" name="book_name" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="nevisande">نویسنده<span class="help"></span></label>
                                    <input value="{{old("nevisande")}}" type="text" id="nevisande" name="nevisande" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="nasher">ناشر<span class="help"></span></label>
                                    <input value="{{old("nasher")}}" type="text" id="nasher" name="nasher" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="nobate_chap">نوبت چاپ<span class="help"></span></label>
                                    <input value="{{old("nobate_chap")}}" type="text" id="nobate_chap" name="nobate_chap" class="form-control" placeholder="">

                                </div>

                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="motarjem">مترجم<span class="help"></span></label>
                                    <input value="{{old("motarjem")}}" type="text" id="motarjem" name="motarjem" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="anbar">وضعیت انبار<span class="help"></span></label>
                                    <select class="form-control" id="anbar" name="anbar">
                                    	<option value='موجود'>موجود</option>
                                    	<option value='ناموجود'>ناموجود</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="tasvirgar">تصویرگر<span class="help"></span></label>
                                    <input value="{{old("tasvirgar")}}" type="text" id="tasvirgar" name="tasvirgar" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="price">قیمت<span class="help"></span></label>
                                    <input value="{{old("price")}}" type="text" id="price" name="price" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="tarikh_enteshar">تاریخ انتشار<span class="help"></span></label>
                                    <input value="{{old("tarikh_enteshar")}}" type="text" id="tarikh_enteshar" name="tarikh_enteshar" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="coin">تعداد سکه<span class="help"></span></label>
                                    <input value="{{old("coin")}}" type="text" id="coin" name="coin" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="matne_ketab">قسمتی از متن کتاب<span class="help"></span></label>
                                    <input value="{{old("matne_ketab")}}" type="text" id="matne_ketab" name="matne_ketab" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-8">
                                    <label class="control-label mb-10 text-left" for="about_book">درباره ی کتاب<span class="help"></span></label>
                                    <textarea rows="4" cols="50" id="about_book" name="about_book" class="form-control" placeholder="">{{old("about_book")}}</textarea>
                                </div>
                                <div class="container">
                                    <div class="form-group col-lg-6">
                                       <!-- <label class="control-label mb-10 text-left">تصویر صفحه ی کتاب</label>
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                            <span class="input-group-addon fileupload btn btn-primary btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">انتخاب فایل</span> <span class="fileinput-exists btn-text">تغییر</span>
														<input type="file" name="book_page_image" id="book_page_image">
														</span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text">حذف</span></a>
                                        </div> -->
                                        <div class="panel">
                                    <div class="panel-body">
                                        <div class="yes">
                                        <span class="btn_upload row">
                                          <input  type="file" name="book_page_image" id="image" title="" class="input-img"/>
                                         انتخاب تصویر صفحه ی کتاب
                                        </span>

                                            <img style="width:150px!important" id="ImgPreview" src="" class="preview1 row mrgt45"/>
                                            <input style="position: absolute;color: red;display:none" type="button" id="removeImage1" value="x" class="btn-rmv1 mrgt45"/>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                <!--          <label class="control-label mb-10 text-left">تصویر جلد کتاب</label>
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                            <span class="input-group-addon fileupload btn btn-primary btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">انتخاب فایل</span> <span class="fileinput-exists btn-text">تغییر</span>
														<input type="file" name="book_image" id="book_image">
														</span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text">حذف</span></a>
                                        </div>-->
                                        <div class="panel">
                                    <div class="panel-body">
                                        <div class="yes">
                                        <span class="btn_upload row">
                                          <input  type="file" name="book_page_image" id="image1" title="" class="input-img"/>
                                         انتخاب تصویر جلد کتاب
                                        </span>

                                            <img style="width:150px!important" id="ImgPreview1" src="" class="preview1 row mrgt45"/>
                                            <input style="position: absolute;color: red;display:none" type="button" id="removeImage2" value="x" class="btn-rmv1 mrgt45"/>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group col-lg-12">
                                    <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        function readURL(input, imgControlName) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $(imgControlName).attr("src", e.target.result);
                            };
                            reader.readAsDataURL(input.files[0]);
                            $("#removeImage1").css("display", "initial");
                        }
                    }

         $("#image").change(function () {
                        // add your logic to decide which image control you'll use
                        var imgControlName = "#ImgPreview";
                        readURL(this, imgControlName);
                        $(".preview1").addClass("it");
                        $(".btn-rmv1").addClass("rmv");
                    });

                    $("#removeImage1").click(function (e) {
                        e.preventDefault();
                        $("#image").val("");
                        $("#ImgPreview").attr("src", "");
                        $(".preview1").removeClass("it");
                        $(".btn-rmv1").removeClass("rmv");
                         $("#removeImage1").css("display", "none");
                    });
                    function readURLl(input, imgControlName) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $(imgControlName).attr("src", e.target.result);
                            };
                            reader.readAsDataURL(input.files[0]);
                            $("#removeImage2").css("display", "initial");
                        }
                    }

         $("#image1").change(function () {
                        // add your logic to decide which image control you'll use
                        var imgControlName = "#ImgPreview1";
                        readURLl(this, imgControlName);
                        $(".preview1").addClass("it");
                        $(".btn-rmv1").addClass("rmv");
                    });

                    $("#removeImage2").click(function (e) {
                        e.preventDefault();
                        $("#image1").val("");
                        $("#ImgPreview1").attr("src", "");
                        $(".preview1").removeClass("it");
                        $(".btn-rmv1").removeClass("rmv");
                         $("#removeImage2").css("display", "none");
                    });
    </script>
@stop
