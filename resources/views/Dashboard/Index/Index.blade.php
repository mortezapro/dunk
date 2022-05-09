@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("css/datepicker.css")}}" rel="stylesheet"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    
    <title>پنل مدیریت جایزه دون</title>
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
    <script>
        $(document).ready(function () {
            var arabicNumbers = ['۰', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            $('.persian_number').text(function(i, v) {
                var chars = v.split('');
                for (var i = 0; i < chars.length; i++) {
                    if (/\d/.test(chars[i])) {
                        chars[i] = arabicNumbers[chars[i]];
                    }
                }
                return chars.join('');
            });
        });

    </script>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">داشبورد</h5>
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
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
       	       <div class="order_week">
           		    <p>فروش هفتگی</p>
           		    <h4>{{number_format($weekPrice)." تومان"}}</h4>
                </div>
            </div>
            <div class="col-lg-4">
	            <div class="order_month">
               		<p>فروش ماهانه</p>
               		<h4>{{number_format($monthPrice)." تومان"}}</h4>
                </div>
            </div>
            <div class="col-lg-4">
	            <div class="order_month">
               		<p>فروش سالانه</p>
               		<h4>{{number_format($yearPrice)." تومان"}}</h4>
                </div>
            </div>  
               
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table id="" class="table table-hover mt-20">
                    <tr>
                        <th style="background:#555!important" colspan="9">گزارش فروش هفتگی</th>
                    </tr>
            <tr>
                <th>ردیف</th>
                <th>نام و نام خانوادگی</th>
                <th>تلفن تماس</th>
                <th>آدرس</th>
                <th>نام کتاب</th>
                <th>قیمت</th>
                <th>کد پیگیری</th>
                <th>کد ارجاع</th>
                <th>تاریخ خرید</th>
            </tr>
            @php $i=0; @endphp
            @foreach($weekRecordSuccess as $item)
                @php $i++ @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>@if($item->users!=null) {{$item->users->user_flname}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->users!=null) {{$item->users->user_mobile}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->users!=null) {{$item->users->user_address}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->book!=null) {{$item->book->book_name}} @else کتاب مورد نظر حذف شده است @endif</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->tracking_code}}</td>
                    <td>{{$item->ref_id}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($item->updated_at)->format('%d %B %Y')}}</td>
                </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{ $weekRecordSuccess->links() }}
        </div>
            </div>
            
            
            <div class="col-lg-12">
                <table id="" class="table table-hover mt-20">
                    <tr>
                        <th style="background:#555!important" colspan="9">گزارش فروش ماهانه</th>
                    </tr>
            <tr>
                <th>ردیف</th>
                <th>نام و نام خانوادگی</th>
                <th>تلفن تماس</th>
                <th>آدرس</th>
                <th>نام کتاب</th>
                <th>قیمت</th>
                <th>کد پیگیری</th>
                <th>کد ارجاع</th>
                <th>تاریخ خرید</th>
            </tr>
            @php $i=0; @endphp
            @foreach($monthRecordSuccess as $item)
                @php $i++ @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>@if($item->users!=null) {{$item->users->user_flname}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->users!=null) {{$item->users->user_mobile}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->users!=null) {{$item->users->user_address}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->book!=null) {{$item->book->book_name}} @else کتاب مورد نظر حذف شده است @endif</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->tracking_code}}</td>
                    <td>{{$item->ref_id}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($item->updated_at)->format('%d %B %Y')}}</td>
                </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{ $monthRecordSuccess->links() }}
        </div>
            </div>
            
            
            <div class="col-lg-12">
                <table id="" class="table table-hover mt-20">
                    <tr>
                        <th style="background:#555!important" colspan="9">گزارش فروش سالانه</th>
                    </tr>
            <tr>
                <th>ردیف</th>
                <th>نام و نام خانوادگی</th>
                <th>تلفن تماس</th>
                <th>آدرس</th>
                <th>نام کتاب</th>
                <th>قیمت</th>
                <th>کد پیگیری</th>
                <th>کد ارجاع</th>
                <th>تاریخ خرید</th>
            </tr>
            @php $i=0; @endphp
            @foreach($yearRecordSuccess as $item)
                @php $i++ @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>@if($item->users!=null) {{$item->users->user_flname}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->users!=null) {{$item->users->user_mobile}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->users!=null) {{$item->users->user_address}} @else کاربر مورد نظر حذف شده است @endif</td>
                    <td>@if($item->book!=null) {{$item->book->book_name}} @else کتاب مورد نظر حذف شده است @endif</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->tracking_code}}</td>
                    <td>{{$item->ref_id}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($item->updated_at)->format('%d %B %Y')}}</td>
                </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{ $yearRecordSuccess->links() }}
        </div>
    </div>
</div>       


@stop
