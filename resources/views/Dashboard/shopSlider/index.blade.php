@extends("Dashboard.Layouts")
@section("HeaderTitle")
    <link href="{{url("dashboard/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css")}}" rel="stylesheet" type="text/css"/>
    <script src="{{url("dashboard/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js")}}"></script>
    <title>پنل مدیریت جایزه دون</title>
    <style>
        .img-responsive2
        {
            width: 100%;
            height: 220px;
        }
    </style>
@stop
@section("breadcrumb")
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">اسلایدر </h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>slider</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <a href="{{route("addShopSliderRoute")}}"><button id="add_slider_btn" class="btn btn-primary">افزودن</button></a>
    </div>
    <div class="row">
        @php $i=0; @endphp
        @foreach($slider as $item)
            @php $i++ @endphp
        <div class="col-lg-4">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">
                            {{'اسلایدر شماره: '.$i}}
                        </h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                    <div  class="panel-heading">
                        <img class="img-responsive2" src="{{asset("dashboard/uploaded/images/shop_sliders/$item->slider_img")}}" alt="">
                    </div>
                    <div class="panel-body">
                        <a data-toggle="modal" href="#deleteModal{{$i}}"><button class="col-lg-4 btn btn-danger"><i class="fa fa-trash"></i> حذف</button></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div id="pagination">
            {{ $slider->links() }}
        </div>
        @php $i=0; @endphp
        @foreach($slider as $item)
            @php $i++ @endphp
            <div id="deleteModal{{$i}}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">هشدار!</h4>
                        </div>
                        <div class="modal-body">
                            <p>آیا از حذف خود مطمئن هستید؟</p>
                        </div>
                        <div class="modal-footer2">
                            <a href="{{route("deleteShopSliderRoute",["id"=>$item->slider_id])}}"><button class="btn btn-danger"><i class="fa fa-edit"></i> بله</button></a>
                            <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-edit"></i> خیر</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
