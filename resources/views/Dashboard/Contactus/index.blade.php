@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
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
        .bg-read
        {
         	background-color: #D2D2FF!important;
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
            <h5 class="txt-dark">ارتباط با ما</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>Contact us</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <table id="tbl_question" class="table table-hover">
            <tr>
                <th>ردیف</th>
                <th>نام و نام خانوادگی</th>
                <th>تلفن تماس</th>
                <th>موضوع</th>
                <th>تاریخ درخواست</th>
                <th>عملیات</th>
            </tr>
            @php $i=0; @endphp
            @foreach($messages as $message)
                @php $i++ @endphp
                <tr class="@if($message->message_state==0)bg-read @else bg-no-read @endif">
                    <td>{{$i}}</td>
                    <td>{{$message->message_name}}</td>
                    <td>{{$message->message_tell}}</td>
                    <td>{{$message->message_subject}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($message->message_date)->format('%d %B %Y')}}</td>
                    <td>
                        <a href="{{route("contactDetailsRoute",["id"=>$message->message_id])}}" class="btn btn-primary">مشاهده</a>
                        <a data-toggle="modal" data-target="#deleteModal{{$i}}" class="btn btn-danger mr-1">حذف</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <div id="pagination">
            {{ $messages->links() }}
        </div>
        @php $i=0; @endphp
        @foreach($messages as $message)
            @php $i++ @endphp
            <div id="deleteModal{{$i}}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">هشدار!</h4>
                        </div>
                        <div class="modal-body">
                            <p>آیا از حذف  مطمئن هستید؟</p>
                        </div>
                        <div class="modal-footer2">
                            <a href="{{route("contactDeleteRoute",["id"=>$message->message_id])}}"><button class="btn btn-danger"><i class="fa fa-edit"></i> بله</button></a>
                            <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-edit"></i> خیر</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@stop
