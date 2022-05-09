@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>پنل مدیریت جایزه دون</title>
    <style>
        #add_project_btn
        {
            margin-bottom: 20px;
        }
        .hidden
        {
            display: none;
        }
        .modal-footer2
        {
            padding: 10px;
            border-top: 1px solid #e5e5e5;
        }
        .img-responsive2
        {
            width: 100%;
            height: 150px;
        }
        #pagination ul
        {
            margin-right: auto;
            margin-left: auto;
            display: table;
        }
    </style>
    <script>
        $(document).ready(function () {
            $(".btn-copy-to-clipboard").click(function () {
                var element = $(this).attr("data-src");
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                alert("Copied");
            });
        });
    </script>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">رسانه ها</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>media</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <a href="{{route("addMediaRoute")}}"><button id="add_project_btn" class="btn btn-primary">افزودن</button></a>
    </div>
    <div class="row">
        @php $i=0; @endphp
        @foreach($media as $item)
            @php $i++ @endphp
            <div class="col-lg-3">
                <div class="panel panel-default card-view">
                    <div  class="panel-wrapper collapse in">
                        <div  class="panel-heading">
                            <img class="img-responsive2" src="{{asset("dashboard/uploaded/media/$item->media_img")}}" alt="">
                        </div>
                        <div class="panel-body row">
                            <div class="col-lg-6">
                                <a data-toggle="modal" href="#delete_modal{{$i}}"><button class="btn btn-danger center-block"><i class="fa fa-edit"></i> حذف</button></a>
                            </div>
                            <div class="col-lg-6">
                                <p class="hidden copy{{$i}}">{{url("dashboard/uploaded/media")."/".$item->media_img}}</p>
                                <button data-src=".copy{{$i}}"  class="btn btn-primary center-block btn-copy-to-clipboard"><i class="fa fa-edit"></i> رونوشت</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="delete_modal{{$i}}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">هشدار!</h4>
                        </div>
                        <div class="modal-body">
                            <p>آیا از حذف رسانه مطمئن هستید؟</p>
                        </div>
                        <div class="modal-footer2">
                            <a href="{{route("deleteMediaRoute",['id'=>$item->media_id])}}"><button class="btn btn-danger"><i class="fa fa-edit"></i> بله</button></a>
                            <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-edit"></i> خیر</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div id="pagination">
            {{$media->links()}}
        </div>
    </div>
@stop

