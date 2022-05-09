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
            <h5 class="txt-dark"> دسته بندی کتاب ها </h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{url("/adminDashboard/index")}}">dashboard</a></li>
                <li class="active"><span>category</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
@stop
@section("content")
    @include("Dashboard.Partials.notifications")
    @include("Dashboard.Partials.errors")
    <div class="row">
        <a href="{{route("addpostCategoryRoute")}}"><button id="add_car_btn" class="btn btn-primary">افزودن</button></a>
    </div>
    <div class="row">
        <div class="col-lg-10">
            <table id="tbl_car" class="table table-striped">
                <tr>
                    <th>کد</th>
                    <th>نام دسته</th>
                    <th>آدرس دسته</th>
                    <th>تصویر دسته</th>
                    <th>عملیات</th>
                </tr>
                @php $i=0; @endphp
                @foreach($categories as $category)
                    @php $i++ @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$category->category_name}}</td>
                        <td>{{$category->category_slug}}</td>
                        <td>
                            <img  class="img-thumbnail img-dashboard center-block" @if( $category->category_media==null ) src="{{asset("images/default.jpg")}}" @else src="{{asset("dashboard/uploaded/images/post_category/".$category->category_media)}}" @endif alt="{{$category->category_title}}">
                        </td>
                        <td>
                            <a href="{{route("editpostCategoryRoute",['id'=>$category->category_id])}}"><button class="btn btn-primary"><i class="fa fa-edit"></i> ویرایش</button></a>
                            <a data-toggle="modal" href="#deleteModal{{$i}}"><button class="btn btn-danger"><i class="fa fa-trash"></i> حذف</button></a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div id="pagination">
                {{ $categories->links() }}
            </div>
            @php $i=0; @endphp
            @foreach($categories as $category)
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
                                <a href="{{route("deletepostCategoryRoute",["id"=>$category->category_id])}}"><button class="btn btn-danger"><i class="fa fa-edit"></i> بله</button></a>
                                <button type="button" data-dismiss="modal" class="btn btn-default"><i class="fa fa-edit"></i> خیر</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
