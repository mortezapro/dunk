@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>جایزه دون</title>
<style>
        table tr td,table tr th
        {
            text-align: center;
        }
        table th
        {
            background-color: #177ec1;
            color: #f7f7f7;
        }
        #tbl_question
        {
            border: 3px solid #177ec1;!important;
        }
        .modal-footer2
        {
            padding: 10px;
            border-top: 1px solid #e5e5e5;
        }
        .pagination ul
        {
            margin-right: auto;
            margin-left: auto;
            display: table;
        }
        #add_question_btn
        {
            margin-bottom: 20px;
        }
        .persian_number
        {
            direction: ltr;
        }
        .order_month
        {
        	padding:50px;
        	background:linear-gradient(#646CFF,#5ACCFF);
        	color:white;
        	text-align:center;
        }
        .order_week
        {
	        padding:50px;
        	background:linear-gradient(#FF8269,#FFB553);
        	color:white;
        	text-align:center;
        }
         .order_week h4,.order_month h4
         {
         color:white;
         }
    </style>
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
                            <form action="{{route("usersUpdateRoute",["id"=>$user->user_id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="user_flname">نام و نام خانوادگی<span class="help"></span></label>
                                    <input value="{{$user->user_flname}}" type="text" id="user_flname" name="user_flname" class="form-control" placeholder="">
                                    <input value="{{$user->user_id}}"style="display:none" type="hiden" id="user_id" name="user_id" class="form-control" placeholder="">
                                    
                                </div>

                                  <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="user_name">نام کاربری<span class="help"></span></label>
                                    <input  value="{{$user->user_name}}" rows="4" cols="50" id="user_name" name="user_name" class="form-control" placeholder="">
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="user_mobile">تلفن<span class="help"></span></label>
                                    <input  value="{{$user->user_mobile}}" rows="4" cols="50" id="user_mobile" name="user_mobile" class="form-control" placeholder="">
                                </div>
                              
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="user_address">آدرس<span class="help"></span></label>
                                    <input  value="{{$user->user_address}}"  rows="4" cols="50" id="user_address" name="user_address" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="user_type">نقش کاربر<span class="help"></span></label>
                                   <select class="form-control" id="user_type" name="user_type">
                                    	 <option @if($user->user_type == '1') selected @endif value="1">مشتری</option>
                                     	 <option @if($user->user_type == '3') selected @endif value="3">بازاریاب</option>
                                    </select>
                                </div>
                                @if($user->user_type == '3' )
                                  <div class="form-group col-lg-12">
                                    <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                </div>
                            </form>
                                @endif
                                @if($user->user_type == '1' )
                                <div class="form-group col-lg-6">
                                    <label class="control-label mb-10 text-left" for="user_coin">تعداد سکه<span class="help"></span></label>
                                    <input value="{{$user->user_coin}}" type="text" id="user_coin" name="user_coin" class="form-control" placeholder="">
                                </div>

                                <div class="form-group col-lg-12">
                                    <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                </div>
                            </form>
							 <table id="" class="table table-hover borderd mt-20">
                    <tr>
                        <th style="background:#555!important" colspan="9">لیست جوایز</th>
                    </tr>
                                        <tr>
                                            <th >#</th>
                                            <th >نام جایزه</th>
                                            <th >امتیاز</th>
                                            <th >کد پیگیری</th>
                                            <th >وضعیت جایزه</th>
                                            <th>تاریخ</th>
                                            <th >تصویر</th>
                                        </tr>
                                        <tbody>
                                        @php $i=0; @endphp
                                        @foreach($awards as $award)
                                            @php $i++; @endphp
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$award->reward_title}}</td>
                                                <td>{{$award->reward_coin}}</td>
                                                <td>{{$award->request_tracking_code}}</td>
                                                <td>@php if ($award->request_state==1)echo  "هماهنگی برای ارسال"; if ($award->request_state==2) echo "ارسال شده";  @endphp</td>
                                                <td>{{\Morilog\Jalali\Jalalian::forge($award->request_date)->format('%d %B %Y ساعت H:i')}}</td>
                                                <td style="text-align:center;width: 320px;"><a href="{{$award->reward_link}}" target="_blank"><img style=" width: 25%; " class="img-circle img-reward" src={{asset("dashboard/uploaded/images/reward_image/$award->reward_image")}}/><a/></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $awards->links() }}
                                        </div>
                    <table id="" class="table table-hover borderd mt-20">
                    <tr>
                        <th style="background:#555!important" colspan="9">لیست مسابقه های کاربر</th>
                    </tr>
                                        <tr>
                                            <th >#</th>
                                            <th >نام مسابقه</th>
                                            <th >تعداد سکه دریافتی</th>
                                            <th >تاریخ انجام مسابقه</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=0; @endphp
                                        @foreach($matchs as $match)
                                            @php $i++; @endphp
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$match->quiz_name}}</td>
                                            <td>{{$match->user_coin}}</td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($match->quiz_date)->format('%d %B %Y ساعت H:i')}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $matchs->links() }}
                                    </div>
                                    
                                         <table id="" class="table table-hover borderd mt-20">
                    <tr>
                        <th style="background:#555!important" colspan="9">لیست سفارشات کاربر</th>
                    </tr>
                                        <tr>
                                            <th >#</th>
                                            <th >نام کتاب</th>
                                            <th >قیمت</th>
                                            <th >نوع خرید</th>
                                            <th >کد پیگیری</th>
                                            <th >کد ارجاع</th>
                                            <th >تاریخ</th>
                                            <th >وضعیت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=0; @endphp
                                        @if($orders)
                                            @foreach($orders as $order)
                                                @php $i++; @endphp
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$order->book_name}}</td>
                                                    <td>{{number_format($order->price)." تومان"}}</td>
                                                    <td>@if($order->buy_type==1) پرداخت اینترنتی @endif</td>
                                                    <td>{{$order->tracking_code}}</td>
                                                    <td>{{$order->ref_id}}</td>
                                                    <td>{{\Morilog\Jalali\Jalalian::forge($order->date)->format('%d %B %Y ساعت H:i')}}</td>
                                                    <td>@if($order->order_state==1) هماهنگی برای ارسال @elseif($order->order_state==2) ارسال شده @endif</td>
                                                </tr>

                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $orders->links() }}
                                    </div>
                                    @endif
                                    @if($user->user_type == '3' )
                                    @if(isset($datas))
                                     <table id="data-table" class="table table-striped table-bordered data-table" >
            <thead>
            <tr id="">
                <th>ردیف</th>
                <th>نام کتاب </th>
                <th>قیمت</th>
                <th>نام کاربر </th>
                <th>تاریخ خرید </th>
                <th>کد تخفیف </th>
            </tr>
            </thead>
            <tbody>
                 @php $i=0; @endphp
                                        @if($datas)
                                            @foreach($datas as $data)
                                                @php $i++; @endphp
                                                <tr>        
                                                    <td>{{$i}}</td>
                                                    <td>{{$data->book_name}}</td>
                                                    <td>{{number_format($data->price)." تومان"}}</td>
                                                    <td>{{$data->user_name}}</td>
                                                    <td>{{\Morilog\Jalali\Jalalian::forge($data->created_at)->format('%d %B %Y ساعت H:i')}}</td>
                                                    <td>{{$data->discount_code}}</td>
                                                </tr>

                                            @endforeach
                                        @endif
            </tbody>
        </table>
         <div class="pagination">
                                        {{ $datas->links() }}
                                        </div>
                                        @endif
                                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
