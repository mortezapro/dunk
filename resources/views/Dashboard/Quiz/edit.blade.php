@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>پنل مدیریت جایزه دون</title>

@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">آزمون ها</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>quiz</span></li>
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
                            <form action="{{route("updateQuizRoute",['id'=>$quiz->quiz_id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="brand">نام آزمون<span class="help"></span></label>
                                    <input value="{{$quiz->quiz_name}}" type="text" id="quiz_name" name="quiz_name" class="form-control" placeholder="نام آزمون">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="brand">مدت زمان آزمون<span class="help"></span></label>
                                    <input value="{{$quiz->quiz_time}}" type="text" id="quiz_time" name="quiz_time" class="form-control" placeholder="امتیاز آزمون">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="brand">امتیاز آزمون<span class="help"></span></label>
                                    <input value="{{$quiz->quiz_score}}"  type="text" id="quiz_score" name="quiz_score" class="form-control" placeholder="امتیاز آزمون">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="brand">تعداد سوالات<span class="help"></span></label>
                                    <input value="{{$quiz->quiz_count}}"  type="text" id="quiz_count" name="quiz_count" class="form-control" placeholder="تعداد سوالات">
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
