@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
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
            <div class="col-lg-3">
                <form action="{{route("adminPostReportRoute")}}" method="post">
                    @csrf
           	       <input class="fromDate" type="text" name="fromDate"/>
           	       <input class="toDate mt-10" name="toDate" type="text"/>
           	       <button class="btn btn-primary btn-icon-anim mt-10" type="submit">نمایش اطلاعات</button>
       	       </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
               <table id="" class="table table-hover mt-20">
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
            @if(isset($orders))
            @foreach($orders as $item)
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
            @endif
        </table>
            </div>
        </div>
    </div>
    
<script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>    
<script>
    $('.fromDate').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt'
    });
        $('.toDate').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt'
    });
</script>
@stop
