@extends("Dashboard.Layouts")
@section("HeaderTitle")

    <title>پنل مدیریت </title>
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
    <style>
        .form-control {padding: 0px!important;}

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
            <h5 class="txt-dark">جایزه ها</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>Rewards</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <a href="{{route("addRewardRoute")}}"><button id="add_reward_btn" class="btn btn-primary">افزودن</button></a>
    </div>

    <div class="row">
        <table id="data-table" class="table table-bordered data-table" >
            <thead>
            <tr id="">
                <th>ردیف</th>
                <th>نام جایزه</th>
                <th>دسته بندی</th>
                <th>تعداد سکه</th>
                <th>وضعیت</th>
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
            ajax: "{{ route('adminRewardRoute') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'reward_title', name: 'reward_title'},
                {data: 'cat_name', name: 'cat_name'},
                {data: 'reward_coin', name: 'reward_coin'},
                {data: 'anbar', name: 'anbar'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    </script>
@stop
