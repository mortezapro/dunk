<!-- Left Sidebar Menu -->
<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        <li>
            <a href="{{route("adminDashboardRoute")}}"><div class="pull-left"><i class="zmdi zmdi-home mr-20"></i><span class="right-nav-text">داشبورد</span></div><div class="clearfix"></div></a>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#maps_dr" class="collapsed" aria-expanded="false"><div class="pull-left"><i class="zmdi zmdi-map mr-20"></i><span class="right-nav-text">گزارشات فروش</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="maps_dr" class="collapse-level-1 collapse" aria-expanded="false" style="height: 0px;">
                <li>
                    <a href="{{route("adminReportRoute")}}"><div class="pull-left"><span class="right-nav-text">گزارش بر اساس تاریخ</span></div><div class="clearfix"></div></a>
                </li>
            </ul>
        </li>
    <!--    <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#shop" class="collapsed" aria-expanded="false"><div class="pull-left"><i class="zmdi zmdi-photo-size-select-large mr-20"></i><span class="right-nav-text">اسلایدرها</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="shop" class="collapse-level-1 collapse" aria-expanded="false" style="height: 0px;">
                <li>
                    <a href="{{route("sliderRoute")}}"><div class="pull-left"><span class="right-nav-text">اسلایدر</span></div><div class="clearfix"></div></a>
                </li>
                <li>
                    <a href="{{route("ShopSliderRoute")}}"><div class="pull-left"><span class="right-nav-text">اسلایدر فروشگاه</span></div><div class="clearfix"></div></a>
                </li>
            </ul>
        </li>
        -->
        <li>
            <a href="{{route("ShopSliderRoute")}}"><div class="pull-left"><i class="zmdi zmdi-file-text mr-20"></i><span class="right-nav-text">اسلایدر</span></div><div class="clearfix"></div></a>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#reward" class="collapsed" aria-expanded="false"><div class="pull-left"><i class="zmdi zmdi-equalizer mr-20"></i><span class="right-nav-text">جایزه ها</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="reward" class="collapse-level-1 collapse" aria-expanded="false" style="height: 0px;">
                <li>
                    <a href="{{route("adminRewardRoute")}}"><div class="pull-left"><i class="zmdi zmdi-equalizer mr-20"></i><span class="right-nav-text"> جایزه ها</span></div><div class="clearfix"></div></a>
                </li>
                <li>
                    <a href="{{route("rewardCategoryRoute")}}"><div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span class="right-nav-text">دسته بندی جایزه ها</span></div><div class="clearfix"></div></a>
                </li>
                
            </ul>
        </li>
        <li>
                    <a href="{{route("adminRequestReward2Route",['id'=>'1'])}}"><div class="pull-left"><i class="zmdi zmdi-money mr-20"></i><span class="right-nav-text">درخواست های جایزه</span></div> @if($request_reward1!=0) <div class="pull-right"><span style="font-size:15px;background: red;font-weight:bold;" class="label label-danger">{{$request_reward1}}  </span></div>  @endif    <div class="clearfix"></div></a>
                </li>
        <li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#posts" class="collapsed" aria-expanded="false"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">مقالات</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="posts" class="collapse-level-1 collapse" aria-expanded="false" style="height: 0px;">
                <li>
                    <a href="{{route("dashboardListPosts")}}"><div class="pull-left"><span class="right-nav-text">لیست مقالات</span></div><div class="clearfix"></div></a>
                </li>
                <li>
                    <a href="{{route("postCategoryRoute")}}"><div class="pull-left"><span class="right-nav-text">دسته بندی</span></div><div class="clearfix"></div></a>
                </li>
            </ul>
        </li>
         <li>
            <a href="{{route("usersListRoute")}}"><div class="pull-left"><i class="zmdi zmdi-accounts mr-20"></i><span class="right-nav-text">کاربران</span></div><div class="clearfix"></div></a>
        </li>
        <li>
            <a href="{{route("dashboardListCommentsBooks")}}"><div class="pull-left"><i class="zmdi zmdi-accounts mr-20"></i><span class="right-nav-text">نظرات کتاب ها</span></div>  @if($book_alert!=0)  <div class="pull-right"><span style="font-size:15px;background: red;font-weight:bold;" class="label label-danger">{{$book_alert}}  </span></div> @endif     <div class="clearfix"></div></a>
        </li>
         <li>
            <a href="{{route("dashboardListCommentsRewards")}}"><div class="pull-left"><i class="zmdi zmdi-accounts mr-20"></i><span class="right-nav-text">نظرات جوایز</span></div> @if($reward_alert!=0)  <div class="pull-right"><span style="font-size:15px;background: red;font-weight:bold;" class="label label-danger">{{$reward_alert}}  </span></div> @endif     <div class="clearfix"></div></a>
        </li>
         <li>
            <a href="{{route("dashboardListCommentsPosts")}}"><div class="pull-left"><i class="zmdi zmdi-accounts mr-20"></i><span class="right-nav-text">نظرات مقالات</span></div>  @if($post_alert!=0)  <div class="pull-right"><span style="font-size:15px;background: red;font-weight:bold;" class="label label-danger">{{$post_alert}}  </span></div> @endif  <div class="clearfix"></div></a>
        </li>
        <!--<li>-->
        <!--    <a href="{{route("codeRoute")}}"><div class="pull-left"><i class="zmdi zmdi-file-text mr-20"></i><span class="right-nav-text">کد های کتاب</span></div><div class="clearfix"></div></a>-->
        <!--</li>-->
        <li>
            <a href="{{route("codeNewRoute")}}"><div class="pull-left"><i class="zmdi zmdi-file-text mr-20"></i><span class="right-nav-text">کد های کتاب</span></div><div class="clearfix"></div></a>
        </li>
        <li>
            <a href="{{route("bookRoute")}}"><div class="pull-left"><i class="zmdi zmdi-file mr-20"></i><span class="right-nav-text"> کتاب ها</span></div><div class="clearfix"></div></a>

        </li>
        <li>
            <a href="{{route("categoryRoute")}}"><div class="pull-left"><i class="zmdi zmdi-view-dashboard mr-20"></i><span class="right-nav-text">دسته بندی کتاب ها</span></div><div class="clearfix"></div></a>
        </li>

        <li>
            <a href="{{route("quizRoute")}}"><div class="pull-left"><i class="zmdi zmdi-check-square mr-20"></i><span class="right-nav-text">آزمون ها</span></div><div class="clearfix"></div></a>
        </li>
        <li>
            <a href="{{route("questionRoute")}}"><div class="pull-left"><i class="zmdi zmdi-check-circle mr-20"></i><span class="right-nav-text">سوالات</span></div><div class="clearfix"></div></a>
        </li>
       <li>
            <a href="{{route("orderRoute")}}"><div class="pull-left"><i class="zmdi zmdi-file mr-20"></i><span class="right-nav-text"> سفارشات</span></div> @if($request_order1!=0)  <div class="pull-right"><span style="font-size:15px;background: red;font-weight:bold;" class="label label-danger">{{$request_order1}}  </span></div> @endif <div class="clearfix"></div></a>

        </li>
          <li>
            <a href="{{route("discountRoute")}}"><div class="pull-left"><i class="zmdi zmdi-file mr-20"></i><span class="right-nav-text"> کد های تخفیف</span></div><div class="clearfix"></div></a>

        </li>
  <!--      <li>
            <a href="{{route("adminRequestMoneyRoute")}}"><div class="pull-left"><i class="zmdi zmdi-money mr-20"></i><span class="right-nav-text">درخواست پول</span></div><div class="clearfix"></div></a>
        </li>
-->
         <li>
            <a href="{{route("contactRoute")}}"><div class="pull-left"><i class="zmdi zmdi-phone mr-20"></i><span class="right-nav-text">ارتباط با ما</span></div><div class="clearfix"></div></a>
        </li>

        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#setting" class="collapsed" aria-expanded="false"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">تنظیمات</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="setting" class="collapse-level-1 collapse" aria-expanded="false" style="height: 0px;">
                <li>
                    <a href="{{route("adminSettingRoute")}}"><div class="pull-left"><span class="right-nav-text">تنظیمات</span></div><div class="clearfix"></div></a>
                </li>
                <li>
                    <a href="{{route("adminHomeSettingRoute")}}"><div class="pull-left"><span class="right-nav-text">تنظیمات صفحه اصلی</span></div><div class="clearfix"></div></a>
                </li>
            </ul>
        </li>


    </ul>
</div>
<!-- /Left Sidebar Menu -->

