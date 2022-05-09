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
            <h5 class="txt-dark"> نظرات جوایز</h5>
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
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">


                    <div class="card">

                        <div class="card-body">


                            <div class="row ">
                                <div class="col-lg-6">
                                </div>

                            </div>
                            <table id="data-table" class="table table-striped table-bordered data-table" >
                                <thead>
                                <tr id="">
                                    <th>ردیف</th>
                                    <th>نام کاربر</th>
                                    <th>نام جایزه</th>
                                    <th>وضعیت</th>
                                    <th>متن</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{--data table--}}
    <script src="{{ url("dashboard/vendors/dataTable/jquery.dataTables.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.responsive.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.fixedHeader.min.js")}}"></script>
    <script>

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboardListCommentsRewards') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'user_flname', name: 'user_flname'},
                {data: 'reward_name', name: 'reward_name'},
                {data: 'status', name: 'status'},
                {data: 'text', name: 'text'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    </script>
@stop

