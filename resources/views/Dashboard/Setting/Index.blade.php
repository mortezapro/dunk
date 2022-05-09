@extends("Dashboard.Layouts")
@section("HeaderTitle")
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
    </style>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">تنظیمات</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>تنظیمات</span></li>
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
                            <form action="{{route("adminPostSettingRoute")}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="category">تلفن همراه<span class="help"></span></label>
                                    <input value="{{$setting->mobile}}" type="text" id="mobile" name="mobile" class="form-control" placeholder="تلفن همراه">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="category">ایمیل<span class="help"></span></label>
                                    <input value="{{$setting->email}}" type="text" id="email" name="email" class="form-control" placeholder="ایمیل">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="category">آدرس<span class="help"></span></label>
                                    <input value="{{$setting->address}}" type="text" id="address" name="address" class="form-control" placeholder="آدرس">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="category">متن درباره ما<span class="help"></span></label>
                                    <textarea  id="about" name="about" class="form-control" placeholder="متن درباره ما">{{$setting->about_text}}</textarea>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="category">پول هر سکه<span class="help"></span></label>
                                    <input value="{{$setting->price_coin}}" type="text" id="price_coin" name="price_coin" class="form-control" placeholder="پول هر عدد سکه به تومان">
                                </div>
                                 <div class="form-group col-lg-12">
                                    <label class="control-label mb-10 text-left" for="category">تعداد سکه معرف<span class="help"></span></label>
                                    <input value="{{$setting->coin_identifier}}" type="text" id="coin_identifier" name="coin_identifier" class="form-control" placeholder="تعداد سکه به معرف">
                                </div>
                                					<label for="convert_state">وضعیت تبدیل سکه</label>
					<input class="checkbox " @if($setting->convert_coin_state==1) checked @endif @if($setting->convert_coin_state==0) @endif type="checkbox" id="convert_state" name="convert_state"/>

                                
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
