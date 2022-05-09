@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/dist/css/select2.min.css")}}" rel="stylesheet" type="text/css"/>

    <script>
        function exportTableToExcel(tableID, filename){
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

            // Specify file name
            filename = 'jayezedoon'+'.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if(navigator.msSaveOrOpenBlob){
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob( blob, filename);
            }{
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }
        }
    </script>
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
        .form-control {padding: 8px!important;}

    </style>
 
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">کد های کتاب</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>quiz</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <form action="{{route("insertCodeRoute")}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group col-lg-12">
                <div class="col-lg-4"><input value="" type="text" id="code_counter" name="code_counter" class="form-control col-lg-4" placeholder="تعداد مد نظر را وارد نمایید"></div>
                <div class="col-lg-4"><input value="" type="text" id="code_text" name="code_text" class="form-control col-lg-4" placeholder="پیشوند را وارد نمایید"></div>
                <div class="col-lg-4">
                    <select class="js-example-basic-multiple" name="quiz_id" id="quiz_id">
                        @foreach( $quizs as $quiz)
                            <option value="{{$quiz->quiz_id}}">{{$quiz->quiz_name}}</option>
                        @endforeach
                    </select>
                </div>



            </div>
            <button style="margin-bottom: 15px" class="btn btn-primary btn-icon-anim" type="submit">افزودن</button>
        </form>
    </div>
    <div class="row">
        <form action="{{route("printCodeRoute")}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group col-lg-10">
                <div class="col-lg-4"><input value="" type="text" id="start_print" name="start_print" class="form-control col-lg-4" placeholder="ایدی چاپ شروع"></div>
                <div class="col-lg-4"><input value="" type="text" id="end_print" name="end_print" class="form-control col-lg-4" placeholder="آیدی چاپ پایان"></div>
                 <div class="col-lg-4"><button style="margin-bottom: 15px;padding: 12px 24px;" class="btn btn-primary btn-icon-anim" type="submit">چاپ</button>
</div></div>
            
        </form>
    </div>

    <div class="row">
        <div class="col-lg-10">
             <!--<button onclick="exportTableToExcel('tbl_codes', 'members-data')" class="btn btn-warning">گزارش خروجی به صورت اکسل</button>-->

             <div class="row">
        <table id="data-table" class="table table-striped table-bordered data-table" >
            <thead>
            <tr id="">
                  <!--//  <th>ردیف</th>-->
                    <th>آیدی چاپ</th>
                    <th>نام آزمون</th>
                    <th>کد کتاب</th>
                    <th>نام کاربر</th>
                    <th>وضعیت کد</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
        </div>
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
            ajax: "{{ route('codeNewRoute') }}",
            columns: [
           //    {data: 'code_number', name: 'code_number'},
                {data: 'code_id', name: 'tbl_codes.code_id'},
                {data: 'quiz_name', name: 'tbl_quiz.quiz_name'},
                {data: 'code_number', name: 'tbl_codes.code_text'},
                {data: 'user_name', name: 'tbl_users.user_name'},
                {data: 'quiz_state', name: 'tbl_codes.quiz_state'},
            ]
        });
        
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();

        });
    </script>
@stop
