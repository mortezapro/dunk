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
            <h5 class="txt-dark">کتاب های خریداری شده با کد معرف</h5>
            </br>
            <h6 class="" style="color: #177ec1;">نام مستعار معرف : {{$user->user_name}}</h6>
            <h6 class="" style="color: #177ec1;">تعداد کتاب خریداری شده از طریق معرف : {{count($books)}}</h6>
            <h6 class="" style="color: #177ec1;">مجموع خرید کتاب از طریق معرف : {{$sum_price}}</h6>
            </br>
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
        
    </div>

    <div class="row">
        <table id="tbl_question" class="table table-striped">
            <tr>
                <th>ردیف</th>
                <th>نام کتاب</th>
                <th>نویسنده</th>
                <th>قیمت</th>
                <th>تاریخ خرید</th>
            </tr>
            @php $i=0; @endphp
            @foreach($books as $book)
                @php $i++ @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$book->book_name}}</td>
                    <td>{{$book->nevisande}}</td>
                    <td>{{$book->price}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($book->updated_at)->format('%d %B %Y ساعت H:i')}}</td>
                    
                </tr>
            @endforeach
        </table>
        <div id="pagination">
            {{ $books->links() }}
        </div>
        @php $i=0; @endphp
        @foreach($books as $book)
            @php $i++ @endphp
            <div id="deleteModal{{$i}}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">هشدار!</h4>
                        </div>
                        <div class="modal-body">
                            <p>آیا از حذف خودرو مطمئن هستید؟</p>
                        </div>
                        <div class="modal-footer2">
                            <a href="{{route("deleteBookRoute",["id"=>$book->book_id])}}"><button class="btn btn-danger"><i class="fa fa-edit"></i> بله</button></a>
                            <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-edit"></i> خیر</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@stop
