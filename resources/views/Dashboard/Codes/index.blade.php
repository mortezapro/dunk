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
        table tr td,table tr th
        {
            text-align: center;
        }
        table th
        {
            background-color: #177ec1;
            color: #f7f7f7;
        }
        #tbl_car
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
        #add_car_btn
        {
            margin-bottom: 20px;
        }
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
        <div class="col-lg-6">
            <button onclick="exportTableToExcel('tbl_codes', 'members-data')" class="btn btn-warning">گزارش خروجی به صورت اکسل</button>

            <table id="tbl_codes" class="table table-striped">
                <tr>
                    <th>ردیف</th>
                    <th>نام آزمون</th>
                    <th>کد کتاب</th>
                    <th>نام کاربر</th>
                    <th>وضعیت کد</th>
                </tr>
                @php $i=0; @endphp
                @foreach($codes as $code)
                    @php $i++ @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$code->quiz_name}}</td>
                        <td>{{$code->code_text}}{{$code->code_number}}</td>
                        <td>{{$code->user_name}}</td>
                        <td>{{$code->quiz_state}}</td>

                    </tr>
                @endforeach
            </table>
            <div id="pagination">
                {{ $codes->links() }}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@stop
