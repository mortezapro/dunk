@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>پنل مدیریت جایزه دون</title>

@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">دسته بندی مقالات</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>category</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <form action="{{route("insertpostCategoryRoute")}}" method="post" enctype="multipart/form-data">

        <div class="col-lg-6">
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                                {{csrf_field()}}
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="category">نام دسته<span class="help"></span></label>
                                    <input value="" type="text" id="title" name="title" class="form-control" placeholder="نام دسته">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="slug">آدرس دسته<span class="help"></span></label>
                                    <input value="" type="text" id="slug" name="slug" class="form-control" placeholder="آدرس دسته">
                                </div>

                                <div class="form-group col-lg-12">
                                    <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel">
                <div class="panel-body">
                    <div class="yes">
                                        <span class="btn_upload row">
                                          <input type="file" name="image" id="image" title="" class="input-img"/>
                                          انتخاب تصویر شاخص
                                        </span>

                        <img id="ImgPreview" src="" class="preview1 row mrgt45"/>
                        <input type="button" id="removeImage1" value="x" class="btn-rmv1 mrgt45"/>
                    </div>
                </div>
            </div>
        </div>
        </form>

    </div>
@stop
<script type="text/javascript">
    function readURL(input, imgControlName) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(imgControlName).attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
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
    });
</script>