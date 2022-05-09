    @extends("Dashboard.Layouts")
    @section("HeaderTitle")
        <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
        <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
        <title>پنل مدیریت جایزه دون</title>
        <style>
            .mr-1{margin-right: 0.6em}
            td .btn-outline-secondary:hover{color: white}
            .content-message
            {
                text-align: justify;
                line-height: 0.7cm;
            }
            .card .header{border-bottom: 1px solid #eee;padding-bottom:20px}
            .card .body
            {
            	padding:10px;
            	background:#fff;
            	margin-bottom:20px;
            }
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
                <h5 class="txt-dark">تماس با ما</h5>
            </div>
                <div class="col-lg-9">
                	<a href="{{route("contactRoute")}}" class="btn btn-primary" style="float:left">بازگشت</a>
        	</div>
        </div>
    @stop
    @section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h5>جزئیات پیام</h5>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-3">
                                    نام : {{$message->message_name}}
                                </div>
                                <div class="col-lg-3">
                                    موضوع: {{$message->message_subject}}
                                </div>
                                <div class="col-lg-3">
                                    تاریخ پیام: {{\Morilog\Jalali\Jalalian::forge($message->message_date)->format('%d %B %Y')}}
                                </div>
                                <div class="col-lg-3">
                                    تلفن تماس: {{$message->message_tell}}
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            	<p>{{$message->message_text}}</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
