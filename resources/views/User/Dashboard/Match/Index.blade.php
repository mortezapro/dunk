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
                        <a href="#" class="breadcrumb-link active-breadcrumb">مسابقه های من</a>
                    </li>
                </ul>
            </div>
        </div>
        @include('User.Dashboard.Partials.nav-right')
        <div class="col-lg-9 col-md-9 col-xs-12 pull-left">
            <section class="page-contents">
                <div class="profile-content">
                    <div class="headline-profile">
                        <span>مسابقه های من</span>
                    </div>
                    <div class="profile-stats">
                        <div class="profile-stats-row">
                            <div class="profile-stats page-profile-order">
                                <div class="table-orders">
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام مسابقه</th>
                                            <th scope="col">تعداد سکه دریافتی</th>
                                            <th scope="col">تاریخ انجام مسابقه</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i=0; @endphp
                                        @foreach($matchs as $match)
                                            @php $i++; @endphp
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$match->quiz_name}}</td>
                                            <td>{{$match->user_coin}}</td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($match->quiz_date)->format('%d %B %Y ساعت H:i')}}</td>
                                        </tr>
                                        @endforeach
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