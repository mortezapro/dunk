@extends('Front.Layouts')
@section('main')
    <style>
        .label-primary
        {
            background: #2b669a;
            color: #f7f7f7;
            padding: 7px;
            border-radius: 5px;
            margin: 0 auto;
            display: inline-block;
        }
        .success-box
        {
            background: #c0ddc0;
            margin-right: auto;
            margin-left: auto;
            margin-bottom: 40px;
        }
        .alert-danger
        {
            color: #bc0b1b;
            background-color: #f8d7da;
            border-color: #7a1924;
            font-size: 20px;
            padding: 20px !important;
            margin-top: 70px;
        }
        .container
        {
            padding:none !important;
        }
        .alert-success
        {
            color: #eeeeee;
            background-color: #35ae10 !important;
            border-color: #c3e6cb;
        }
    </style>

    <!--cart--------------------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link active-breadcrumb">وضعیت تراکنش</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    @if(isset($state) && $state==1)
                        <div class="col-lg-6 success-box">
                            <div class="alert alert-success">
                                <p>پرداخت با موفقیت انجام شد.</p>
                            </div>

                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <td>نام و نام خانوادگی:</td>
                                    <td>{{$user->user_flname}}</td>
                                    <input placeholder="" name="book_id" type="hidden" class="form-control" value="{{$book->book_id}}"/>
                                </tr>
                                <tr>
                                    <td>کد پیگیری:</td>
                                    <td>{{$order->tracking_code}}</td>
                                </tr>
                                <tr>
                                    <td>شماره ارجاع:</td>
                                    <td>{{$order->ref_id}}</td>
                                </tr>
                                <!--   <tr>-->
                                <!--  <td>نوع خرید:</td>-->
                                <!--  <td>
                                <!--</tr>-->
                                <tr>
                                    <td>تاریخ:</td>
                                    <td>{{\Morilog\Jalali\Jalalian::forge($order->updated_at)->format('%d %B %Y')}}</td>
                                </tr>
                                <tr>تلفن واحد پیگیری و پشتیبانی : 02122707088</tr>
                                </tbody>
                            </table>
                        </div>
                    @elseif(isset($state) && $state==0)
                        <div class="alert alert-danger container">
                            <p>سفارش توسط کاربر لغو شده است</p>
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <td>کد پیگیری:</td>
                                    <td>{{$order->tracking_code}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @elseif(isset($state) && $state==2)
                        <div class="alert alert-danger container">
                            <p>پرداخت انجام نشده است</p>
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <td>کد پیگیری:</td>
                                    <td>{{$order->tracking_code}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <!--cart--------------------------------------->
@endsection

