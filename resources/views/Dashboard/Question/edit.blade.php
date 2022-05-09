@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/dist/css/select2.min.css")}}" rel="stylesheet" type="text/css"/>

    <title>پنل مدیریت جایزه دون</title>

@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">جایزه دون</h5>
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
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            <form action="{{route("updateQuestionRoute",["id"=>$questions->question_id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group col-lg-4">
                                    <label class="control-label mb-10 text-left" for="quiz_id">نام آزمون<span class="help"></span></label>
                                    <select class="js-example-basic-multiple" name="quiz_id" id="quiz_id">
                                        @foreach( $quizs as $quiz)
                                            <option @if($quiz->quiz_id==$questions->quiz_id) selected="selected" @endif value="{{$quiz->quiz_id}}">{{$quiz->quiz_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                        <div class="form-group col-lg-8">
                            <label class="control-label mb-10 text-left" for="question_text">متن سوال<span class="help"></span></label>
                            <textarea rows="4" cols="50" id="question_text" name="question_text" class="form-control" placeholder="">{{$questions->question_text}}</textarea>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label mb-10 text-left" for="date">گزینه ی یک<span class="help"></span></label>
                            <input value="{{$questions->gozineh1}}" type="text" id="gozineh1" name="gozineh1" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label mb-10 text-left" for="price">گزینه ی دو<span class="help"></span></label>
                            <input value="{{$questions->gozineh2}}" type="text" id="gozineh2" name="gozineh2" class="form-control" placeholder="">

                        </div>

                        <div class="form-group col-lg-6">
                            <label class="control-label mb-10 text-left" for="gozineh3">گزینه ی سه<span class="help"></span></label>
                            <input value="{{$questions->gozineh3}}" type="text" id="gozineh3" name="gozineh3" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label mb-10 text-left" for="gozineh4">گزینه ی چهار<span class="help"></span></label>
                            <input value="{{$questions->gozineh4}}" type="text" id="gozineh4" name="gozineh4" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="control-label mb-10 text-left" for="question_answer">پاسخ سوال<span class="help"></span></label>
                            <input value="{{$questions->question_answer}}" type="text" id="question_answer" name="question_answer" class="form-control" placeholder="">
                        </div>
                                <div class="form-group col-lg-12">
                                    <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@stop
