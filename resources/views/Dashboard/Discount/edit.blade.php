@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/dist/css/select2.min.css")}}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

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
            <h5 class="txt-dark"> تخفیفات</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>discount</span></li>
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
                            <form action="{{route("updateDiscountRoute",["id"=>$discount->id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                       
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="book_name">کد تخفیف <span class="help"></span></label>
                                    <input value="{{$discount->discount_code}}" type="text" id="discount_code" name="discount_code" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="nevisande">درصد<span class="help"></span></label>
                                    <input value="{{$discount->percent}}" type="number" id="percent" name="percent" class="form-control" placeholder="">
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="user_id">انتخاب کاربر <span class="help"></span></label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        @foreach($users as $user)
                                    	<option @if($user->user_id==$discount->user_id)) selected="selected" @endif value='{{$user->user_id}}'>{{$user->user_name}}</option>
                                    	@endforeach
                                    
                                    </select>
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="status">وضعیت <span class="help"></span></label>
                                    <select class="form-control" id="status" name="status">
                                    	<option @if($discount->status == 1) selected @endif value='1'>فعال</option>
                                    	<option @if($discount->status == 2) selected @endif value='2'>غیرفعال</option>
                                    </select>
                                </div>
                    
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="tarikh_enteshar">از تاریخ <span class="help"></span></label>
                                    <input value="{{$discount->from_date}}" class="form-control fromDate" type="text" name="from_date"/>
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="tarikh_enteshar">تا تاریخ<span class="help"></span></label>
                                    <input value="{{$discount->to_date}}" class="form-control fromDate" type="text" name="to_date"/>
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
   <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>    
<script>
    $('.fromDate').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt',
        autoClose: true
    });
        $('.toDate').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt',
        autoClose: true
    });
</script>
@stop
