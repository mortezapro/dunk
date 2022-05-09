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
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap">
                        <form action="{{route("updateOrderRoute",["id"=>$order->order_id])}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="panel panel-primary">
      <div class="panel-heading">مشخصات کتاب</div>
      <div class="panel-body">

          <table id="tbl_car" class="table table-striped">
              <tr>
                  <th>ردیف</th>
                  <th>نام کتاب</th>
                  <th>تعداد</th>
                  <th>نویسنده</th>
                  <th>مترجم</th>
                  <th>ناشر</th>
                  <th>تعداد سکه</th>
              </tr>
              @php $i=0; @endphp
              @foreach($books as $book)
                  @php $i++ @endphp
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$book->book_name}}</td>
                      <td>{{$book->quantity}}</td>
                      <td>{{$book->nevisande}}</td>
                      <td>{{$book->motarjem}}</td>
                      <td>{{$book->nasher}}</td>
                      <td>{{$book->coin}}</td>
                  </tr>
              @endforeach
          </table>
                            
    </div>
    </div>
    
                  <div class="panel panel-primary">
      <div class="panel-heading"> مشخصات خریدار</div>
      <div class="panel-body"> 
                          
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="user_name">نام و نام خانوادگی خریدار<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="user_name" >{{$user->user_flname}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="nevisande">کدپستی خریدار<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="nevisande" for="nevisande">{{$user->user_postalcode}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="motarjem">تلفن خریدار<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" for="motarjem">{{$user->user_mobile}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="motarjem2">ایمیل<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="motarjem2">{{$user->user_email}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="coin">استان<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="coin">{{$user->user_city}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-9">
                                <label class="control-label mb-10 text-left" for="coin">آدرس<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="coin">{{$user->user_address}}<span class="help"></span></label>
                            </div>
                            
                            
    </div>
    </div>
    <div class="panel panel-primary">
      <div class="panel-heading"> مشخصات گیرنده</div>
      <div class="panel-body"> 
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="user_name">نام و نام خانوادگی گیرنده :<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="user_name" >{{$order->receiver_name}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="nevisande">کدپستی گیرنده :<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="nevisande" for="nevisande">{{$order->postal_code}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="motarjem">تلفن گیرنده :<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" for="motarjem">{{$order->mobile}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label class="control-label mb-10 text-left" for="coin">استان گیرنده :<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="coin">{{$order->city}}<span class="help"></span></label>
                            </div>
                            <div class="form-group col-lg-9">
                                <label class="control-label mb-10 text-left" for="coin">آدرس گیرنده :<span class="help"></span></label>
                                <label class="control-label mb-10 text-left" id="coin">{{$order->address}}<span class="help"></span></label>
                            </div>
                            
                            
      </div>
    </div>
                            
                    <div class="panel panel-primary">
      <div class="panel-heading"> مشخصات سفارش</div>
      <div class="panel-body">

                    <div class="form-group col-lg-3">
                        <label class="control-label mb-10 text-left" for="book_name">مبلغ سفارش:<span class="help"></span></label>
                        <label class="control-label mb-10 text-left" id="book_name" >{{number_format($order->total_price)}} توم<span class="help"></span></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label class="control-label mb-10 text-left" for="nevisande">کد پیگیری :<span class="help"></span></label>
                        <label class="control-label mb-10 text-left" id="nevisande" >{{$order->tracking_code}}<span class="help"></span></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label class="control-label mb-10 text-left" for="ref_if">کد پرداخت :<span class="help"></span></label>
                        <label class="control-label mb-10 text-left" id="ref_if" >{{$order->ref_id}}<span class="help"></span></label>
                    </div>
                    <div class="form-group col-lg-3">
                        <label class="control-label mb-10 text-left" for="motarjem">وضعیت خرید :<span class="help"></span></label>
                        <label class="control-label mb-10 text-left" id="motarjem">@if($order->order_state==0) پرداخت نشده@endif @if($order->order_state==1) پرداخت شده @endif @if($order->order_state==2) ارسال شده @endif<span class="help"></span></label>
                    </div>
                    <div class="form-group col-lg-9">
                        <label class="control-label mb-10 text-left" for="desc">توضیحات سفارش :<span class="help"></span></label>
                        <label class="control-label mb-10 text-left" id="desc">{{$order->description}}<span class="help"></span></label>
                    </div>
                    
       </div>
       </div>
                            <div class="form-group col-lg-12">
                                <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                <button class="btn btn-info hid"  onclick="printdiv()" target="_blank" >پرینت </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="printpage">
<table  class="tg" id="printtable">
  <tr>
    <td class="tg-nrix" colspan="2">فاکتور فروش</td>
  </tr>
  <tr>
	<td class="tg-baqh">نام کتاب</td>
    {{--<td class="tg-baqh">{{$book->book_name}}</td>--}}
  </tr>
  <tr>
    <td class="tg-baqh">خریدار</td>
	<td class="tg-baqh">{{$user->user_flname}}</td>
  </tr>
  <tr>
    <td class="tg-baqh">گیرنده</td>
	<td class="tg-baqh">{{$order->receiver_name}}</td>
  </tr>
  <tr>
	<td class="tg-baqh">کد پستی گیرنده</td>
    <td class="tg-baqh">{{$order->postal_code}}</td>
  </tr>
  <tr>
    <td class="tg-baqh">تلفن گیرنده</td>
	<td class="tg-baqh">{{$order->mobile}}</td>
  </tr>
  <tr>
    <td class="tg-baqh" colspan="2"> توضیحات :{{$order->description}}</td>
  </tr>
  <tr>
    <td class="tg-baqh" colspan="2"> آدرس :{{$order->address}}</td>
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
