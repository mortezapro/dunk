@extends("Front.Layouts")
@section("head")
    <style>
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            height: 240px!important;
        }

        .swiper-slide img
        {
            width: auto;
            height: 100%;
        }
        .item-slider
        {
            width: 100%;
            height: 160px;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;

        }

        .swiper-slide img
        {
            width: auto;
            height: 100%;
            margin-bottom: 15px;
        }
        .item-slider
        {
            width: 100%;
            height: 220px;
        }
        .item-slider p
        {
            font-size: 15px;
        }
        .item-slider:first-child
        {
            display: inline-block;
        }
        .item-slider span
        {
            font-size: 14px;
            display: block;
        }
        .product-item
        {
            padding: 20px;
            width: 250px;
            height: 250px;
            margin-bottom: 140px;
        }
        .product-item img
        {
            width: auto;
            margin-bottom: 15px;
            height: 100%;

        }
        .min-h-100
        {
            min-height: 50px;
        }
        .pagination-place
        {

            display: block;
            margin: 0 auto;
        }
        .pagination
        {
            margin-top: 50px;
        }
        .list-group
        {
            display:table;
            width: 100%;
        }
        .list-group-horizontal li
        {
            display: inline-block;
        }
        .list-group-item
        {
            background: red;
            color: #f7f7f7;
            padding: 35px 10px 10px 10px;
            min-width: 100px;
            min-height: 100px;
            margin: 20px;
            border-radius: 10px;
        }
    </style>
@endsection
@section("content")
    <div class="container nav-place">
        <div class="row">
            <ul class="list-group list-group-horizontal">
            @foreach($cats as $cat)
                    <a href="{{route("showCatShopRoute",["id"=>$cat->category_id])}}"><li class="list-group-item">{{$cat->category_name}}</li></a>
            @endforeach
            </ul>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>محصولات</h2>
                </div>
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="product-item">
                            <img src="{{asset("images/product/1.jpg")}}" alt="">
                            <p class="min-h-100 mr-2">{{$product->book_name}}</p>
                            <span class="price d-inline-block"> قیمت:&nbsp;</span><span class="d-inline-block"> {{$product->price}} تومان </span>
                            <a href="{{route("singleBookRoute",["id"=>$product->book_id])}}" class="btn btn-danger mt-3 d-block center-block btn-product">مشاهده</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12 pagination-place">
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </section>
    <link rel="stylesheet" href="{{asset("css/swiper.min.css")}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            freeMode: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            speed: 500,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            slidesPerView: 4,
            spaceBetween: 40,
            breakpointsInverse: true,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                960: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        })
    </script>

@endsection
