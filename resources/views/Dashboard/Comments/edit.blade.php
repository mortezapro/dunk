@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <script src="{{ url("dashboard/vendors/ckeditor/ckeditor.js")}}"></script>

    <title>پنل مدیریت جایزه دون</title>

@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">کامنت</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>books</span></li>
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
            <div class="panel panel-default panel-view">
                <div class="panel-wrapper collapse in">
                    <form action="{{route("updateComment")}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="panel">
                                    <input style="display: none" value="{{$data->id}}" type="text" id="post_id" name="comment_id"  class="form-control">
                                    <!--<input style="display: none" value="2" type="text" id="read_state" name="read_state"  class="form-control">-->

                                    <div class="panel-body">
                                        <input class="form-control @error('title') is-invalid @enderror" type="text" value="{{$data->text}}" name="text" id="title" placeholder="متن کامنت"/>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="category-post">
                                            <label>وضعیت انتشار</label>
                                            <select class="custom-select custom-select-sm @error('status') is-invalid @enderror" name="status">
                                                <option @if ($data->status==1 )selected @endif  value="1">فعال</option>
                                                <option @if ($data->status==2 )selected @endif value="2">غیرفعال</option>
                                            </select>
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <script type="text/javascript">
                    CKEDITOR.replace('description', {
                        language: 'fa',
                        content: 'fa',
                        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
                        filebrowserUploadMethod: 'form'
                    });

                </script>
                {{-- Ck editor --}}
                <script src="{{ url("dashboard/vendors/ckeditor/")}}"></script>

                <script type="text/javascript">
                    function readURL(input, imgControlName) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $(imgControlName).attr("src", e.target.result);
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $("#image").change(function () {
                        // add your logic to decide which image control you'll use
                        var imgControlName = "#ImgPreview";
                        readURL(this, imgControlName);
                        $(".preview1").addClass("it");
                        $(".btn-rmv1").addClass("rmv");
                    });

                    $("#removeImage1").click(function (e) {
                        e.preventDefault();
                        $("#image").val("");
                        $("#ImgPreview").attr("src", "");
                        $(".preview1").removeClass("it");
                        $(".btn-rmv1").removeClass("rmv");
                    });
                </script>
            </div>
        </div>
    </div>
    </div>
@stop
