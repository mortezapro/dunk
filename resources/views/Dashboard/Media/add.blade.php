@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset('/dashboard/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('/dashboard/ckeditor/contents.css')}}"></script>
    <script src="{{asset('/dashboard/ckeditor/adapters/jquery.js')}}"></script>
    <title>پنل مدیریت جایزه دون</title>
    <style>
        #article_text
        {
            resize: none;
            height: 600px;
        }
    </style>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">رسانه ها</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>media</span></li>
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
                            <form action="{{route("insertMediaRoute")}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group mb-30 col-lg-12">
                                    <label class="control-label mb-10 text-left">تصویر مقاله</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon fileupload btn btn-primary btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">انتخاب فایل</span> <span class="fileinput-exists btn-text">تغییر</span>
                                        <input type="file" name="img_media">
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
@stop

