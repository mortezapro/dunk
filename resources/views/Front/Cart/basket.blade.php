@extends('Front.Layouts')
@section('main')
    <!--cart--------------------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('indexRoute')}}" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link active-breadcrumb">سبد خرید</a>
                    </li>
                </ul>
            </div>

        </div>


        <div class="page-content">
   
            @if(\Cart::getTotalQuantity()>0)
                <div class="cart-title-top"> سبد خرید(<span id="total_count_top">{{ \Cart::getTotalQuantity()}}</span>)</div>
            @else
                <div class="cart-title-top">سبد خرید</div>
            @endif

            <div class="cart-main">
                         @if(\Cart::getTotalQuantity()==0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        محصولی در سبد خرید وجود ندارد
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @else
                @if(session()->has('success_msg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success_msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                @if(session()->has('alert_msg'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session()->get('alert_msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                <div class="col-lg-9 col-md-9 col-xs-12 pull-right">
                    <div class="title-content">
                        <ul class="title-ul">
                            <li class="title-item product-name">
                                نام کالا
                            </li>
                            <li class="title-item required-number">
                                تعداد مورد نیاز
                            </li>
                            <li class="title-item unit-price">
                                قیمت واحد
                            </li>
                            <li class="title-item total">
                                مجموع
                            </li>
                        </ul>
                    </div>
                    @foreach($cartCollection as $item)
                    <div class="page-content-cart">
                        <div class="checkout-body">
                            <div class="product-name before">
                                <form action="{{ route('removeCartRoute') }}" method="POST" style="display: contents;">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <button class="remove-from-cart">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <a href="#" class="col-thumb">
                                    <img src="{{asset("dashboard/uploaded/images/product/")}}/{{$item->attributes->image}}">
                                </a>
                                <div class="checkout-col-desc">
                                    <a href="{{route('singleBookRoute',['id'=>$item->id])}}">
                                        <h1>{{ $item->name }}</h1>
                                    </a>
                                </div>
                            </div>
                            <div class="required-number before">
                                <div class="quantity-new" style="display: inline-flex;">
                                    <button onclick="chevronNumber('up',{{ $item->id }})"><i class="fa fa-chevron-up"></i> </button>
                                    <input id="numberBasket{{ $item->id }}" type="number" min="1" max="10" step="1" value="{{ $item->quantity }}" onkeyup="changeNumberBasket({{ $item->id }}); return false">
                                    <button  onclick="chevronNumber('down',{{ $item->id }})"><i class="fa fa-chevron-down"></i> </button>
                                </div>
                            </div>
                            <div class="unit-price before">
                                <div class="product-price">
                                    {{$item->price}}
                                    <span>
                                            تومان
                                        </span>
                                </div>
                            </div>
                            <div class="total before">
                                <div class="product-price">
                                    <span  id="totalSingleProduct{{ $item->id }}">{{ \Cart::get($item->id)->getPriceSum() }}</span>
                                    <span>
                                        تومان
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12 pull-left">
                    <div class="page-aside">
                        <div class="checkout-summary">
                            <div class="comment-summary mb-3">
                            </div>

                            <div class="discount-box" @if(\Illuminate\Support\Facades\Session::has('message_discount')) style="" @else style="display: none" @endif  >
                                <span class="payable-discount">
                                @if(\Illuminate\Support\Facades\Session::has('message_discount')) @php echo  \Illuminate\Support\Facades\Session::get('message_discount') @endphp @endif
                                </span>
                                <span class="amount-of-discount" style="float: left;color: #f82727;font-size: 14px;">
                                    <span id="total_amount_discount">
                                    {{ \Cart::getSubTotal() - \Cart::getTotal()}}
                                    </span>
                                    <span>تومان</span>
                                </span>
                            </div>
                            <div class="amount-of-payable mt-4">
                                <span class="payable">مبلغ قابل پرداخت</span>
                                <span class="amount-of">
                                    <span id="total_amount">
                                        {{ \Cart::getTotal() }}
                                    </span>
                                        <span>تومان</span>
                                </span>

                                    @if($user_state !=null)
                                        <a href="{{route('shippingRoute')}}"><button class="setlement-account">ادامه فرآیند</button></a>
                                    @else
                                        <a href="{{route('userLoginRoute',['access'=>'basket'])}}"><button class="setlement-account">ادامه فرآیند</button></a>
                                    @endif

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
     
    </div>
    <!--cart--------------------------------------->
@endsection
@section('js')
    <script type="application/javascript">


        function changeNumberBasket(rowId)
        {
            var quantity = $('#numberBasket'+rowId).val();
            var row = rowId;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{route("ajaxUpdateCartRoute")}}", // Name of the php files
                data: {'quantity':quantity,'id':row},
                success: function(html)
                {
                    console.log(html);
                    var total = html[0][row]['quantity'] * html[0][row]['price'];
                    $("#totalSingleProduct"+row).text(total);
                    $("#total_amount").text(html[1]);
                    $("#count_basket").text(html[2]);
                    $("#total_count_top").text(html[2]);
                    $("#total_amount_discount").text(html[3]);

                },
                error: function(reject){

                }
            });
        }
        function chevronNumber(type,num_basket)
        {
            var number = $("#numberBasket"+num_basket).val();
            if (type==="down" && number>1)
            {
                var num_minus = number - 1;
                $("#numberBasket"+num_basket).val(num_minus);
                changeNumberBasket(num_basket)
            }
            if (type==="up" && number<10)
            {
                var num_positive = parseInt(number )+ 1;
                $("#numberBasket"+num_basket).val(num_positive);
                changeNumberBasket(num_basket)
            }
        }
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
