<li style="display:block;">
    @foreach($blogs as $item)
        <div class="col-lg-4 col-md-4 col-xs-12 pull-right mb-3">
            <div class="product-vertical">
                <div class="vertical-product-thumb">
                    <a href="{{route('singleBlogRoute',['slug'=>$item->slug])}}">
                        <img
                            src="{{asset("dashboard/uploaded/images/post/$item->media")}}">
                    </a>
                </div>
                <div class="card-vertical-product-content">
                    <div class="card-vertical-product-title">
                        <a>
                            {{$item->category}}
                        </a>
                    </div>
                    <div class="card-vertical-product-price">
                        <a href="{{route('singleBlogRoute',['slug'=>$item->slug])}}">
                            {{$item->title}}
                        </a>
                    </div>
                    <div class="product-actions-secondary">
                        <a href="{{route('singleBlogRoute',['slug'=>$item->slug])}}"
                            class="btn btn-info">مشاهده مقاله</a>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</li>
