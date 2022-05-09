@extends('Front.Layouts')
@section('main')
    <!--profile------------------------------------>
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">حساب کاربری من</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link active-breadcrumb">سفارشات من</a>
                    </li>
                </ul>
            </div>
        </div>
        @include('User.Dashboard.Partials.nav-right')
        <div class="col-lg-9 col-md-9 col-xs-12 pull-left">
            <section class="page-contents">
                <div class="profile-content">
                    <div class="headline-profile">
                        <span>سفارشات من</span>
                    </div>
                    <div class="profile-stats">
                        <div class="profile-stats-row">
                            <div class="profile-stats page-profile-order">
                                <div class="table-orders">
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام کتاب</th>
                                            <th scope="col">قیمت</th>
                                            <th scope="col">نوع خرید</th>
                                            <th scope="col">کد پیگیری</th>
                                            <th scope="col">کد ارجاع</th>
                                            <th scope="col">تاریخ</th>
                                            <th scope="col">وضعیت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=0; @endphp
                                        @if($orders)
                                            @foreach($orders as $order)
                                                @php $i++; @endphp
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$order->book_name}}</td>
                                                    <td>{{number_format($order->price)." تومان"}}</td>
                                                    <td>@if($order->buy_type==1) پرداخت اینترنتی @endif</td>
                                                    <td>{{$order->tracking_code}}</td>
                                                    <td>{{$order->ref_id}}</td>
                                                    <td>{{\Morilog\Jalali\Jalalian::forge($order->date)->format('%d %B %Y ساعت H:i')}}</td>
                                                    <td>@if($order->order_state==1) هماهنگی برای ارسال @elseif($order->order_state==2) ارسال شده @endif</td>
                                                </tr>

                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!--profile------------------------------------>
    <style>
        .img-reward
        {
            width:80px;
        }
    </style>
@endsection
@section('js')
    <script>
        $("#fileToUpload").change(function(){
            document.getElementById("loading").hidden = false;
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic').css('background-image', "url('" + e.target.result + "')");
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            readURL(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData();
            formData.append('file', $('input[type=file]')[0].files[0]);
            $.ajax({
                type: 'POST',
                url: '{{route("postProfileAjaxUserDashboardRoute")}}',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (){
                    document.getElementById("loading").hidden = true;
                    document.getElementById("loading-success").hidden = false;
                },
                error: function () {
                    document.getElementById("loading").hidden = true;
                    alert('لطفا ارتباط خود را با اینترنت بررسی نمایید.');
                }
            });
        });
    </script>
@endsection