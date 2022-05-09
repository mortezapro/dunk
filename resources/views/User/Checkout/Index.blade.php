@extends("Front.Layouts")
@section("head")
    <title>تایید خرید کتاب {{$book->book_name}} - جایزه دون  </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .form-group {
            padding: 0 20px;
        }

        .btn-center {
            display: block;
            margin: 10px auto;
        }

        .img-order {
            max-width: 100%;
            display: block;
            height: auto;
            margin: 0 auto 20px auto;
        }

        .label-primary {
            background: #2b669a;
            color: #f7f7f7;
            padding: 7px;
            font-size: 14px;
            border-radius: 10px;
        }
        table tbody tr td{
            background-color: #fefefe;
        }
           table tbody tr th{
            background-color: #636465;
            color: #fcfcfc;
        }
    </style>
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @include("Front.Partials.notifications")
                @include("Front.Partials.errors")
            </div>
        </div>
        <form class="text-right" method="post" action="{{route("submitOrderRoute")}}">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <h2>تایید خرید</h2>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-3">
                    <img class="img-order" src="{{asset("dashboard/uploaded/images/product/$book->book_image")}}"
                         alt="">
                </div>
                <div class="col-md-7">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>نام کتاب:</td>
                            <td>{{$book->book_name}}</td>
                            <input placeholder="" name="book_id" type="hidden" class="form-control"
                                   value="{{$book->book_id}}"/>
                        </tr>
                        <tr>
                            <td>قیمت:</td>
                            <td>{{number_format($book->price)." تومان"}}</td>
                        </tr>
                        <tr>
                            <td>نویسنده:</td>
                            <td>{{$book->nevisande}}</td>
                        </tr>
                        <tr>
                            <td>مترجم:</td>
                            <td>{{$book->motarjem}}</td>
                        </tr>
                        <tr>
                            <td>تصویرگر:</td>
                            <td>{{$book->tasvirgar}}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-lg-1"></div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">نام و نام خانوادگی گیرنده </label>
                                <input placeholder="" name="name" type="text" class="form-control"
                                       value="{{old('name')}}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">نام کاربری خریدار</label>
                                <input readonly placeholder="" name="username" type="text" class="form-control"
                                       value="{{$user["username"]}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">روش خرید</label>
                                <select readonly name="buy_type" type="text" class="form-control">
                                    <option value="1">پرداخت اینترنتی</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">موبایل گیرنده</label>
                                <input placeholder="" name="mobile" type="text" class="form-control"
                                       value="{{old('mobile')}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>استان</label>
                                <!--<input placeholder="" name="city" type="text" class="form-control" />-->
                                <select name="city" id="city_id" class=" form-control">
                                    <option disabled selected value="">انتخاب استان</option>

                                    @foreach($citys as $city)
                                        <option value={{$city->id}}>{{$city->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>کد پستی گیرنده</label>
                                <input placeholder="" name="postal_code" type="text" class="form-control"
                                       value="{{old('postal_code')}}"/>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>آدرس پستی گیرنده</label>
                                <input placeholder="" name="address" type="text" class="form-control"
                                       value="{{old('address')}}"/>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-lg-12">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>توضیحات</label>-->
                    <!--        <input placeholder="ساعت تحویل و ..." name="desc" type="text" class="form-control"/>-->
                    <!--    </div>-->
                    <!--<div class="col-lg-12">-->
                    <button class="btn btn-primary btn-center">ثبت درخواست</button>
                </div>
                <div class="col-md-3">
                    <table class="table" style="margin-top:35px">
                     
                        <tbody>
                        <tr>
                            <th scope="row">قیمت کتاب: </th>
                            <td>{{number_format($book["price"])." تومان"}}</td>

                        </tr>
                        <tr>
                            <th scope="row">هزینه ارسال: </th>
                            <td id="peyk"></td>

                        </tr>
                        <tr>
                            <th scope="row">جمع کل: </th>
                            <td id="total"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </form>
    </div>
    </div>
@endsection
@section("js")
<script>
     $('#city_id').on('change',function () {
            var city_id = $(this).find("option:selected").val();
            var dataString = "city_id="+city_id;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route("ajaxGetPriceCity")}}", // Name of the php files
                data: dataString,
                success: function(html)
                {
                    console.log(html);
                     $("#peyk").html(separate(html[0]['price'])+" تومان ");
                     var price = {{$book["price"]}};
                     $('#total').html(separate(price + html[0]['price'])+" تومان ");
                    // $(".preloader").hide();
                    // var i;
                    // $("#restaurant_id").empty();
                    // $("#restaurant_id").append("<option value='all'>همه رستوران ها</option>");
                    // for (i = 0; i < html.length; i++) {
                    //     $("#restaurant_id").append("<option value="+html[i]['NID']+" >"+html[i]['StrRestaurantName']+"</option>");
                    // }
                    // $('#restaurant_id').trigger('change');

                }
            });
        });
            function separate(Number)
        {
            Number+= '';
            Number= Number.replace(',', '');
            x = Number.split('.');
            y = x[0];
            z= x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(y))
                y= y.replace(rgx, '$1' + ',' + '$2');
            return y+ z;
        }
</script>
@endsection
