@extends("Dashboard.Layouts")
@section("HeaderTitle")

    <title>پنل مدیریت جایزه دون</title>
    <style>
        .dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select {
            border: 1px solid rgba(33, 33, 33, 0.12);
            border-radius: 0;
            background-color: #fff;
            box-shadow: none;
            color: #212121;
            height: 34px;
            display: inline-block;
            width: auto;
        }
        .form-control {padding: 0px!important;}
        table tr td,table tr th
        {
            text-align: center;
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
        #pagination ul
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
            <h5 class="txt-dark">سفارشات</h5>
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

    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<a href="{{route("indexidRoute",['id'=>'0'])}}"><button id="order_state0" class="btn btn-primary">بررسی برای ارسال</button></a>--}}
            {{--  <a href="{{route("indexidRoute",['id'=>'1'])}}"><button id="order_state1" class="btn btn-primary">سفارشات تایید شده</button></a>--}}
            {{--<a href="{{route("indexidRoute",['id'=>'1'])}}"><button id="order_state2" class="btn btn-primary">سفارشات ارسال شده</button></a>--}}
        {{--</div>--}}
    {{--</div>--}}


    <div class="row">

        <table id="data-table" class="table table-striped table-bordered data-table" >
            <thead>
            <tr id="">
                <th>ردیف</th>
                <th>کد پیگیری</th>
                <th>نام کاربر</th>
                <th>تلفن کاربر</th>
                <th>وضعیت خرید</th>
                <th>وضعیت سفارش</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


    </div>
    {{--data table--}}
    <script src="{{ url("dashboard/vendors/dataTable/jquery.dataTables.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.responsive.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.fixedHeader.min.js")}}"></script>
    <script>

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orderRoute') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tracking_code', name: 'tracking_code'},
                {data: 'user_name', name: 'user_name'},
                {data: 'user_mobile', name: 'user_mobile'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'order_state', name: 'order_state'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    </script>
@stop
