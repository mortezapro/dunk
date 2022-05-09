@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/dist/css/select2.min.css")}}" rel="stylesheet" type="text/css"/>
    <title>پنل مدیریت جایزه دون</title>

@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">جایزه دون</h5>
        </div>
        <style>
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                vertical-align: baseline;
                white-space: nowrap;
                line-height: 30px;
                color: black;
            }
        </style>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>question</span></li>
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
                            <form action="{{route("updateBookRoute",["id"=>$book->book_id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group col-lg-4">
                                    <label class="control-label mb-10 text-left" for="book_cat_id">دسته بندی<span class="help"></span></label>
                                    <select class="js-example-basic-multiple" name="cat_ids[]" id="category_id" multiple="multiple">
                                        @foreach( $cats as $cat)
                                            <option @if(in_array($cat->category_id,$arr_cat)) selected="selected" @endif value="{{$cat->category_id}}">{{$cat->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{csrf_field()}}
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="book_name">نام کتاب<span class="help"></span></label>
                                    <input value="{{$book->book_name}}" type="text" id="book_name" name="book_name" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="nevisande">نویسنده<span class="help"></span></label>
                                    <input value="{{$book->nevisande}}" type="text" id="nevisande" name="nevisande" class="form-control" placeholder="">
                                </div>
                                 <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="nasher">ناشر<span class="help"></span></label>
                                    <input value="{{$book->nasher}}" type="text" id="nasher" name="nasher" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="nobate_chap">نوبت چاپ<span class="help"></span></label>
                                    <input value="{{$book->nobate_chap}}" type="text" id="nobate_chap" name="nobate_chap" class="form-control" placeholder="">

                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="motarjem">مترجم<span class="help"></span></label>
                                    <input value="{{$book->motarjem}}" type="text" id="motarjem" name="motarjem" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="anbar">وضعیت انبار<span class="help"></span></label>
                                    <select class="form-control" id="anbar" name="anbar">
                                    	<option @if($book->anbar == 'موجود') selected @endif value='موجود'>موجود</option>
                                    	<option @if($book->anbar == 'ناموجود') selected @endif value='ناموجود'>ناموجود</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="tasvirgar">تصویرگر<span class="help"></span></label>
                                    <input value="{{$book->tasvirgar}}" type="text" id="tasvirgar" name="tasvirgar" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="price">قیمت<span class="help"></span></label>
                                    <input value="{{$book->price}}" type="text" id="price" name="price" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="tarikh_enteshar">تاریخ انتشار<span class="help"></span></label>
                                    <input value="{{$book->tarikh_enteshar}}" type="text" id="tarikh_enteshar" name="tarikh_enteshar" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="coin">تعداد سکه<span class="help"></span></label>
                                    <input value="{{$book->coin}}" type="text" id="coin" name="coin" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="matne_ketab">قسمتی از متن کتاب<span class="help"></span></label>
                                    <input value="{{$book->coin}}" type="text" id="matne_ketab" name="matne_ketab" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-8">
                                    <label class="control-label mb-10 text-left" for="about_book">درباره ی کتاب<span class="help"></span></label>
                                    <textarea rows="4" cols="50" id="about_book" name="about_book" class="form-control" placeholder="">{{$book->about_book}}</textarea>
                                </div>

                                    <div class="form-group col-lg-6 ">
                                        <label class="control-label mb-10 text-left">تصویر صفحه ی کتاب</label>
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                            <span class="input-group-addon fileupload btn btn-primary btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">انتخاب فایل</span> <span class="fileinput-exists btn-text">تغییر</span>
														<input type="file" name="book_page_image" id="book_page_image">
														</span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text">حذف</span></a>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label mb-10 text-left">تصویر جلد کتاب</label>
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                            <span class="input-group-addon fileupload btn btn-primary btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">انتخاب فایل</span> <span class="fileinput-exists btn-text">تغییر</span>
														<input type="file" name="book_image" id="book_image">
														</span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text">حذف</span></a>
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
        // $(".js-example-basic-multiple").select2({
        //     tags: true,
        // })
    </script>
@stop
