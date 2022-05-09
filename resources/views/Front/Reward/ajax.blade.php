<li style="display:block;">
    @foreach($rewards as $item)
        <div class="col-lg-3 col-md-4 col-xs-12 pull-right mb-3">
            <div class="product-vertical">
                <div class="vertical-product-thumb">
                    <a href="{{route('singleRewardRoute',['id'=>$item->reward_id])}}">
                        <div class="stars-plp">
                            <span class="mdi mdi-star active"></span>
                            <span class="mdi mdi-star active"></span>
                            <span class="mdi mdi-star active"></span>
                            <span class="mdi mdi-star active"></span>
                            <span class="mdi mdi-star"></span>
                        </div>
                        <img
                            src="{{asset("dashboard/uploaded/images/reward_image/$item->reward_image")}}">
                    </a>
                </div>
                <div class="card-vertical-product-content">
                    <div class="card-vertical-product-title">
                        <a href="{{route('singleRewardRoute',['id'=>$item->reward_id])}}">
                            {{$item->reward_title}}
                        </a>
                    </div>
                    <div class="card-vertical-product-price">
                        @if($item->anbar == "موجود")
                        {{$item->reward_coin}}
                        <span class="price-currency">سکه</span>
                        @else
                            <span class="price-currency">ناموجود</span>
                        @endif
                    </div>
                    <div class="product-actions-secondary">
                        <div class="heart" title="افزودن به لیست علاقه مندی">
                            <span class="mdi mdi-heart"></span>
                        </div>
                        <a href="{{route('singleRewardRoute',['id'=>$item->reward_id])}}"
                            class="product-introduction-cart" title="خرید جایزه">
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
