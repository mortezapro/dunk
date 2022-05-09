 <li style="display:block;">
        @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-xs-12 pull-right mb-3">
                <div class="product-vertical" style="height:410px">
                    <div class="vertical-product-thumb">
                        <a href="{{route('singleBookRoute',['id'=>$product->book_id])}}">
                            <div class="stars-plp">
                                <span class="mdi mdi-star active"></span>
                                <span class="mdi mdi-star active"></span>
                                <span class="mdi mdi-star active"></span>
                                <span class="mdi mdi-star active"></span>
                                <span class="mdi mdi-star"></span>
                            </div>
                            <img src="{{asset("dashboard/uploaded/images/product/$product->book_image")}}">
                        </a>
                    </div>
                    <div class="card-vertical-product-content">
                        <div class="card-vertical-product-title">
                            <a href="{{route('singleBookRoute',['id'=>$product->book_id])}}">
                                {{$product->book_name}}
                            </a>
                        </div>
                        <div class="card-vertical-product-price">
                            @if($product->anbar == "موجود")
                            {{number_format($product->price)}}
                            <span class="price-currency">تومان</span>
                            @else
                                <span class="price-currency">ناموجود</span>
                            @endif
                        </div>
                        <div class="product-actions-secondary">
                            <div class="heart" title="افزودن به لیست علاقه مندی">
                                <span class="mdi mdi-heart"></span>
                            </div>
                            <a href="{{route('singleBookRoute',['id'=>$product->book_id])}}"
                               class="product-introduction-cart" title="خرید کتاب">
                                                        <span class="c-introduction">
                                                            +
                                                        </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
 </li>
