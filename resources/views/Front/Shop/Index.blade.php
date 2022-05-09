@extends('Front.Layouts')
@section('main')

    <!--search------------------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('indexRoute')}}" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="breadcrumb-link active-breadcrumb">کتاب ها</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-xs-12 pull-right">
            <form id="filter_table" action="{{route("shopFilterRoute")}}" method="get">
                <input type="hidden" name="filterType" id="filterType" value="">
                <section class="page-aside">
                    <div class="sidebar-wrapper">
                        <div class="listing-sidebar mb-4">
                            <div class="box-header-product-feature mb-3">
                                <span class="title-product">فیلتر محصولات</span>
                            </div>
                            <div class="box">
                                <div class="box-header">
                                    <span class="title-header">جستجو</span>
                                </div>
                                <div class="box-content">
                                    <div class="ui-input-quick-search">
                                        {{--                                            <form method="get" action="{{route('searchBookFrontRoute')}}" class="contact-us-form">--}}
                                        <input
                                            @if(isset($bookName))
                                            @if($bookName!=null)
                                            value="{{$bookName}}"
                                            @endif
                                            @endif
                                            type="text" name="search_book" class="input-field-cleanable" placeholder="نام کتاب مورد نظر را بنویسید…">
                                       
                                        {{--                                            </form>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-block text-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            دسته بندی
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseExample" class="collapse show">
                                    <div class="card-main mb-3">
                                        <div class="form-auth-row">
                                            <label for="#" class="ui-checkbox">
                                                <input type="checkbox" id="all" value="all" name="allCat">
                                                <span class="ui-checkbox-check"></span>
                                            </label>
                                            <label for="remember" class="remember-me">همه</label>
                                        </div>
                                        @foreach($cats as $item)
                                            <div class="form-auth-row">
                                                <label for="#" class="ui-checkbox">
                                                    <input
                                                        @if(isset($categoryIds))
                                                        @if(in_array($item->category_id,$categoryIds))
                                                        checked
                                                        @endif
                                                        @endif
                                                        id="{{$item->category_id}}" type="checkbox" value="{{$item->category_id}}" name="cats_book[]">
                                                    <span class="ui-checkbox-check"></span>
                                                </label>
                                                <label for="remember" class="remember-me">{{$item->category_name}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="statusswitcher">
                                    <a href="#">
                                        <label for="switch1">
                                            <input @if(isset($exist))
                                                   @if($exist)
                                                   checked
                                                   @endif
                                                   @endif type="checkbox" id="switch1" name="exist"><span class="switch"><h1 class="switch-title">فقط کالای موجود</h1></span>
                                            <span class="toggle"></span>
                                        </label>
                                    </a>
                                </div>
                            </div>
                            <div class="box px-3">
                                <button class="btn btn-info d-block w-100" type="submit">فیلتر</button>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
        <div class="col-lg-9 col-md-8 col-xs-12 pull-left">
            <div class="page-contents">
                <article class="listing-wrapper-tab">
                    <div class="listing mb-4">
                        <div class="listing-header">
                            <div class="listing-sort-option-header">
                                <ul class="sort-options">
                                    {{--<li class="listing-active">
                                        <a href="#" class="listing-tab-item">پرفروش‌ترین‌</a>
                                    </li>
                                    <li>
                                        <a href="#" class="listing-tab-item">مرتبط‌ترین</a>
                                    </li>
                                    <li>
                                        <a href="#" class="listing-tab-item">پربازدیدترین</a>
                                    </li>--}}
                                    <li  @if(isset($filterType)) @if($filterType=="new") class="listing-active" @endif @endif>
                                        <a href="#" onclick="document.getElementById('filterType').value='new';document.getElementById('filter_table').submit();"  class="listing-tab-item">جدیدترین</a>
                                    </li>
                                    <li @if(isset($filterType)) @if($filterType=="expensive") class="listing-active" @endif @endif>
                                        <a href="#" onclick="document.getElementById('filterType').value='expensive';document.getElementById('filter_table').submit();"  class="listing-tab-item">گران ترین</a>
                                    </li>
                                    <li  @if(isset($filterType)) @if($filterType=="cheap") class="listing-active" @endif @endif>
                                        <a href="#"  onclick="document.getElementById('filterType').value='cheap';document.getElementById('filter_table').submit();"  class="listing-tab-item">ارزان ترین</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <ul class="listing-items">
                            @include('Front.Shop.ajax')
                        </ul>
                    </div>
                </article>
            </div>
        </div>


        @if($products->hasPages())
            <div class="col-12">
                <div class="breadcrumb-container-pagination">
                    {{$products->appends(request()->query())->links()}}
                </div>
            </div>
        @endif
    </div>
    <!--search------------------------------------->

@endsection
