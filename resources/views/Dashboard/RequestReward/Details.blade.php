@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>پنل مدیریت جایزه دون</title>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:iran, sans-serif;font-size:20px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:iran, sans-serif;font-size:20px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-baqh{text-align:center;vertical-align:top}
.tg .tg-nrix{text-align:center;vertical-align:middle}
#printpage{ display: none;}
</style>
	<style type="text/css" media="print">
	.label{
		
		text-align: center;
		margin-top: 0 px;
	}
	header, footer, aside, nav, iframe, .menu, .hero, .btn, .adslot, .hid , form {
		display: none;
	}
	#printpage{ display: normal;}
	#printtable{ width:148mm; height:210mm;}
	
	</style>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">جزئیات سفارش </h5>
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
    <div class="col-lg-12">
    @if(session()->get("successChangeState"))
                                    <div class="col-lg-12">
                                        <div class="alert alert-success">
                                            <p>درخواست با موفقیت تایید شد.</p>
                                        </div>
                                    </div>
                                @endif
    </div>
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form  method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                
                                 <div class="panel panel-primary">
      <div class="panel-heading">مشخصات جایزه</div>
      <div class="panel-body">
        <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>نام : </b>{{$request->reward->reward_title}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>قیمت: </b>{{$request->reward->reward_coin." سکه"}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>وضعیت: </b>{{$request->reward->anbar}}
                                    </div>
                                </div>
      </div>
    </div>
                                
                               
     <div class="panel panel-primary">
      <div class="panel-heading">مشخصات خریدار</div>
      <div class="panel-body">                          
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b> نام: </b>{{$request->users->user_flname}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b> کد پستی: </b>{{$request->users->user_postalcode}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b> تلفن: </b>{{$request->users->user_mobile}}
                                    </div>
                                </div>            
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>شهر : </b>{{$request->users->user_city}}
                                    </div>
                                </div>         
                                 <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>ایمیل: </b>{{$request->users->user_email}}
                                    </div>
                                </div>                                            
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b> آدرس: </b>{{$request->users->user_address}}
                                    </div>
                                </div>
                                
   </div>
   </div>
   
     <div class="panel panel-primary">
      <div class="panel-heading">مشخصات گیرنده</div>
      <div class="panel-body"> 
                                
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b> نام: </b>{{$request->receiver_name}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>کد پستی: </b>{{$request->postal_code}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>تلفن : </b>{{$request->mobile}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>شهر: </b>{{$request->city}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>وضعیت درخواست: </b>@if($request->request_state==1)عدم تایید@elseارسال
                                        شده@endif
                                    </div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <div class="item-request">
                                        <b>تاریخ: </b>{{\Morilog\Jalali\Jalalian::forge($request->request_date)->format('%d %B %Y')}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="item-request">
                                        <b>آدرس: </b>{{$request->city}} {{$request->address}}
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="item-request">
                                        <b>توضیحات: </b>{{$request->request_desc}}
                                    </div>
                                </div>
        </div>
        </div>
                                <div class="form-group col-lg-12">
                                    <a href="{{route("adminRequestRewardChangeStateRoute",["id"=>$request->request_id])}}" class="btn btn-primary btn-icon-anim" type="submit">ثبت</a>
                                      <button class="btn btn-info hid"  onclick="printdiv()" target="_blank" >پرینت </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="printpage">
<table  class="tg" id="printtable" style="font-family:Tahoma" >
  <tr>
    <td class="tg-nrix" colspan="2">فاکتور فروش</td>
  </tr>
  <tr>
	<td class="tg-baqh">نام محصول</td>
    <td class="tg-baqh">{{$request->reward->reward_title}}</td>
  </tr>
  <tr>
    <td class="tg-baqh">خریدار</td>
	<td class="tg-baqh">{{$request->users->user_flname}}</td>
  </tr>
  <tr>
    <td class="tg-baqh">گیرنده</td>
	<td class="tg-baqh">{{$request->receiver_name}}</td>
  </tr>
  <tr>
	<td class="tg-baqh">کد پستی گیرنده</td>
    <td class="tg-baqh">{{$request->postal_code}}</td>
  </tr>
  <tr>
    <td class="tg-baqh">تلفن گیرنده</td>
	<td class="tg-baqh">{{$request->mobile}}</td>
  </tr>
  <tr>
    <td class="tg-baqh" colspan="2"> توضیحات : {{$request->description}}</td>
  </tr>
  <tr>
    <td class="tg-baqh" colspan="2"> آدرس : {{$request->address}}</td>
  </tr>
</table>
</div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function printdiv()
    {
        var printContents = document.getElementById('printpage').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@stop