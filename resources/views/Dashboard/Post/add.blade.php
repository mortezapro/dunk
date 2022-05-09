@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <script src="{{ url("dashboard/vendors/ckeditor/ckeditor.js")}}"></script>

    <title>پنل مدیریت جایزه دون</title>

@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">پست ها</h5>
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
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <form action="{{route("insertPost")}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">

                                    <div class="card-body">
                                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{old('title')}}"  onkeyup = changeSlug(event) id="title" placeholder="عنوان پست"/>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <input class="form-control @error('slug') is-invalid @enderror" type="text" name="slug" value="{{old('slug')}}" id="slug" placeholder="آدرس پست"/>
                                        @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <textarea name="description" id="description">{{old('description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-icon-anim" type="submit">ثبت</button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="category-post">
                                            <label>وضعیت انتشار</label>
                                            <select class="custom-select custom-select-sm @error('status') is-invalid @enderror" name="status">
                                                <option selected value="2024">انتشار</option>
                                                <option value="2023">پیشنویس</option>
                                            </select>
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="category-post">
                                            <label>دسته بندی</label>
                                            <select class="custom-select custom-select-sm @error('category') is-invalid @enderror" name="category">
                                                <option selected disabled hidden>انتخاب کنید</option>
                                                @foreach($category as $item)
                                                    <option value="{{$item->category_id}}">{{$item->category_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="yes">
                                        <span class="btn_upload row">
                                          <input type="file" name="image" id="image" title="" class="input-img"/>
                                          انتخاب تصویر شاخص
                                        </span>

                                            <img id="ImgPreview" src="" class="preview1 row mrgt45"/>
                                            <input type="button" id="removeImage1" value="x" class="btn-rmv1 mrgt45"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <script>
                    function changeSlug(evt) {
                        str = evt.target.value.replace(/\s+/g, '-').toLowerCase();
                        $("#slug").val(str);
                    }
            
                </script>
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
