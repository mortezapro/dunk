@extends("User.Layouts")
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
            <h5 class="txt-dark">گزارش فروش</h5>
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
    </div>
    <script src="{{ url("dashboard/vendors/dataTable/jquery.dataTables.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.responsive.min.js")}}"></script>
    <script src="{{ url("dashboard/vendors/dataTable/dataTables.fixedHeader.min.js")}}"></script>
   <script>
 /*
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('discountRoute') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'book_name', name: 'book_name'},
                {data: 'price', name: 'price'},
                {data: 'user_name', name: 'user_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'discount_code', name: 'discount_code'},

            ]
        });*/
    </script>

@stop
