@extends('Front.Layouts')
@section('main')

    <!--blog------------------------------------->
    <div class="container-main">
        <div class="col-12">
            <div class="breadcrumb-container">
                <ul class="js-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('blogRoute')}}" class="breadcrumb-link">خانه</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="breadcrumb-link active-breadcrumb">مقالات</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-xs-12 pull-right">
            <form id="filter_table" action="{{route("blogFilterRoute")}}" method="get">
            <section class="page-aside">
                <div class="sidebar-wrapper">
                    <div class="listing-sidebar mb-4">
                        <div class="box-header-product-feature mb-3">
                            <span class="title-product">فیلتر</span>
                        </div>
                        <div class="box">
                            <div class="box-header">
                                <span class="title-header">جستجو</span>
                            </div>
                            <div class="box-content">
                                <div class="ui-input-quick-search">
                                    <input
                                        @if(isset($searchText))
                                        @if($searchText!=null)
                                        value="{{$searchText}}"
                                        @endif
                                        @endif
                                        type="text" name="searchText" class="input-field-cleanable" placeholder="جستجو...">
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
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
                                    @foreach($catBlogs as $item)
                                        <div class="form-auth-row">
                                            <label for="#" class="ui-checkbox">
                                                <input
                                                    @if(isset($categoryIds))
                                                    @if(in_array($item->category_id,$categoryIds))
                                                    checked
                                                    @endif
                                                    @endif
                                                    id="{{$item->category_id}}" type="checkbox" value="{{$item->category_id}}" name="cats_blog[]">
                                                <span class="ui-checkbox-check"></span>
                                            </label>
                                            <label for="remember" class="remember-me">{{$item->category_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
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
                    <div class="listing mb-4" style="margin-top: 0">
                        <ul class="listing-items">
                            @include('Front.Blog.ajax')
                        </ul>
                    </div>
                </article>
            </div>
        </div>
        @if($blogs->hasPages())
            <div class="col-12">
                <div class="breadcrumb-container-pagination">
                    {{$blogs->appends(request()->query())->links()}}
                </div>
            </div>
        @endif
    </div>
    <!--blog------------------------------------->
@endsection
