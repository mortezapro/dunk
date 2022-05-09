@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>پنل مدیریت کارشناسی خودرو</title>

@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">جایزه دون</h5>
        </div>
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
                            <form action="{{route("updateRewardRoute",["id"=>$reward->reward_id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group col-lg-4">
                                    <label class="control-label mb-10 text-left" for="cat_id">دسته جایزه<span class="help"></span></label>
                                    <select class="form-control" name="cat_id" id="cat_id">
                                        @foreach( $reward_cats as $reward_cat)
                                            <option @if($reward_cat->cat_id==$reward->cat_id) selected @endif value="{{$reward_cat->cat_id}}">{{$reward_cat->cat_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-8">
                                    <label class="control-label mb-10 text-left" for="reward_title">نام جایزه<span class="help"></span></label>
                                    <input value="{{$reward->reward_title}}" rows="4" cols="50" id="reward_title" name="reward_title" class="form-control" placeholder="">
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="reward_coin">تعداد سکه<span class="help"></span></label>
                                    <input value="{{$reward->reward_coin}}" type="text" id="reward_coin" name="reward_coin" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="reward_coin">وضعیت انبار<span class="help"></span></label>
                                   <select class="form-control" id="anbar" name="anbar">
                                    	<option @if($reward->anbar == 'موجود') selected @endif value='موجود'>موجود</option>
                                    	<option @if($reward->anbar == 'ناموجود') selected @endif value='ناموجود'>ناموجود</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="reward_coin">لینک جایزه<span class="help"></span></label>
                                    <input value="{{$reward->reward_link}}" type="text" id="reward_link" name="reward_link" class="form-control" placeholder="">
                                   @if($reward->reward_link) <a href="{{$reward->reward_link}}" style=" display: block; background: blanchedalmond; padding: 4px 8px; width: fit-content; " target="_blank">مشاهده</a>@endif
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="reward_desc">توضیحات<span class="help"></span></label>
                                    <textarea type="text" id="reward_desc" name="reward_desc" class="form-control" placeholder="">"{{$reward->reward_desc}}"</textarea>
                                </div>
                                <div class="form-group col-lg-12 ">
                                    <label class="control-label text-left">تصویر جایزه</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon fileupload btn btn-primary btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">انتخاب فایل</span> <span class="fileinput-exists btn-text">تغییر</span>
														<input type="file" name="reward_image" id="reward_image">
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
