<header>
    <div class="container-main">
        <div class="col-lg-8 col-md-8 col-xs-12 pull-right">
            <div class="header-right">
                <div class="logo">
                    <a href="{{route('indexRoute')}}"><img src={{asset("dashboard/dist/img/headerpic.png")}}></a>
                </div>
                <div class="col-lg-9 col-md-9 col-xs-12 pull-right">
                    <div class="search-header">
                        <form action="#">
                            <input type="text" class="search-input" placeholder="نام کالا، برند و یا دسته مورد نظر خود را جستجو کنید…">
                            <button type="submit" class="button-search">
                                <img src={{asset("img/search.png")}}>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 pull-left">
            <div class="header-left">
                <ul class="nav-lr">
                    <li class="nav-item-account">
                        @if($user_state=="logined")
                        <a href="{{route('userDashboardRoute')}}">
                            {{ Session::get('user_flname') }}
                            <img src={{asset("img/user.png")}} alt="user">
                            <div class="dropdown-menu">
                                <ul>
                                    <li class="dropdown-menu-item">
                                        <a href="{{route('userDashboardRoute')}}" class="dropdown-item">
                                            <i class="mdi mdi-account-card-details-outline"></i>
                                            حساب کاربری من
                                        </a>
                                    </li>
                                    <li class="dropdown-menu-item">
                                        <a href="{{route('userLogoutRoute')}}" class="dropdown-item">
                                            <i class="mdi mdi-logout-variant"></i>
                                            خروج از حساب
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </a>
                        @else
                            <a href="{{route('userLoginRoute')}}">
                                ورود به حساب کاربری
                                <img src={{asset("img/user.png")}} alt="user">
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--        menu------------------------------->
    <nav class="main-menu">
        <div class="container-main">
            <div>
                <ul class="list-menu">
                      <li class="item-list-menu megamenu">
                        <a href="{{route('indexRoute')}}" class="list-category">صفحه اصلی</a>
                    </li>
                    <li class="item-list-menu megamenu">
                        <a href="{{route('shopRoute')}}" class="list-category">کتاب فروشی</a>
                    </li>
                  <!--  <li class="item-list-menu">
                        <a href="#" class="list-category">کتاب ها <i class="fa fa-angle-down"></i></a>
                        <ul class="sub-menu">
                        
                                    @foreach($cats as $item)
                                        <div class="level-three-menu">
                                            <li class="megamenu-list-item">
                                                <a href="{{route('showCatShopRoute',['id'=>$item->category_id])}}" class="megamenu-category">{{$item->category_name}}</a>
                                            </li>
                                        </div>
                                    @endforeach
                        </ul>
                    </li>-->
                           <li class="item-list-menu">
                        <a href="#" class="list-category">جایزه ها<i class="fa fa-angle-down"></i></a>
                        <ul class="sub-menu" style="right: 225px;">

                            @foreach($catRewards as $item)
                                <div class="level-three-menu">
                                  
                                    <li class="megamenu-list-item">
                                        <a href="{{route('catRewardRoute',['id'=>$item->cat_id])}}"  class="megamenu-category">{{$item->cat_name}}</a>

                                    </li>
                                </div>
                            @endforeach
                        </ul>
                    </li>
                    <li class="item-list-menu megamenu">
                        <a href="{{route('frontAboutRoute')}}" class="list-category">درباره ما</a>
                    </li>
                    <li class="item-list-menu megamenu blink_me">
                        <a style="color:red"  onMouseOver="this.style.color='#fff'" onMouseOut="this.style.color='#ff0000'" href="{{route('QuizCodeRoute')}}" class="list-category">شروع مسابقه</a>
                    </li>
                  
                    <li class="item-list-menu megamenu">
                        <a href="{{route('blogRoute')}}" class="list-category">مقالات</a>
                    </li>
                    <li class="nav-item-account nav-item-cart">
                        <a href="{{route('cartRoute')}}">
                            <span class="mdi mdi-cart"></span>
                            سبد خرید
                            <span class="count" id="count_basket">{{ \Cart::getTotalQuantity()}}</span>
                        </a>
                      
                    </li>
                </ul>
            </div>
        </div>
        <div class="nav-btn nav-slider">
            <span class="linee1"></span>
            <span class="linee2"></span>
            <span class="linee3"></span>
        </div>
    </nav>
    <!--        menu------------------------------->

    <!--    menu-responsiver----------------------->
    <nav class="sidebar">
        <div class="nav-header">
            <!--              <img class="pic-header" src="images/header-pic.png")}} alt="">-->
            <div class="header-cover"></div>
            <div class="logo-wrap">
                <a class="logo-icon" href="{{route('indexRoute')}}"><img alt="logo-icon" src={{asset("dashboard/dist/img/headerpic.png")}} width="40"></a>
            </div>
        </div>
        <ul class="nav-categories ul-base">
            <li><a href="{{route('indexRoute')}}">صفحه اصلی</a></li>
            <li><a href="{{route('shopRoute')}}">کتاب فروشی</a></li>
     <!--       <li><a href="#" class="collapsed" type="button" data-toggle="collapse" data-target="#collapseBook" aria-expanded="false" aria-controls="collapseOne"><i class="mdi mdi-chevron-down"></i>کتاب ها</a>
                <div id="collapseBook" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
                    <ul>
                        @foreach($cats as $item)
                            <li><a href="{{route('showCatShopRoute',['id'=>$item->category_id])}}" class="category-level-3">{{$item->category_name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>-->
            <li><a href="#" class="collapsed" type="button" data-toggle="collapse" data-target="#collapseReward" aria-expanded="false" aria-controls="collapseOne"><i class="mdi mdi-chevron-down"></i> جایزه ها</a>
                <div id="collapseReward" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
                    <ul>
                        @foreach($catRewards as $item)
                            <li><a href="{{route('catRewardRoute',['id'=>$item->cat_id])}}" class="category-level-3">{{$item->cat_name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li><a href="{{route('frontAboutRoute')}}">درباره ما</a></li>
            <li class="blink_me"><a style="color:red" href="{{route('QuizCodeRoute')}}">شروع مسابقه</a></li>

            <li><a href="{{route('blogRoute')}}">مقالات</a></li>
        </ul>
    </nav>
    <div class="overlay"></div>
    <!--    menu-responsiver----------------------->

</header>
