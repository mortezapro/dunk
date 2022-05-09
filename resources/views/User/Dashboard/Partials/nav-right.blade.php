<div class="col-lg-3 col-md-3 col-xs-12 pull-right">
    <section class="page-aside">
        <div class="sidebar-wrapper">
            <div class="box-sidebar">
                <div class="profile-box">
                    <div class="profile-box-avator">
                        <form action="{{route('postProfileUserDashboardRoute')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <label for="fileToUpload">
                                <div class="profile-pic" style="background-image: url('{{asset('dashboard/uploaded/images/user/'.$user->user_image)}}')">
                                    <span>ویرایش عکس</span>
                                </div>
                            </label>
                            <input type="File" accept=".png, .jpg, .jpeg" name="file" id="fileToUpload">
                        </form>
                    </div>
                    <div class="profile-box-content">
                        <span id="loading" class="profile-box-nameuser text-info" hidden>در حال ارسال...</span>
                        <span id="loading-success" class="profile-box-nameuser text-success" hidden>با موفقیت ویرایش شد</span>
                        <span class="profile-box-nameuser">{{$user->user_flname}}</span>
                        <span class="profile-box-phone">شماره همراه : {{$user->user_mobile}}</span>
                        <span class="profile-box-phone">نام کاربری : {{$user->user_name}}</span>
                        <a ><span class="profile-box-row-arrow">سکه های من : {{$user->user_coin}} </span></a>
                        <a ><span class="profile-box-row-arrow">کد معرف من : {{$user->identifier_code}}</span></a>
                    </div>
                    <div class="profile-box-tabs">
                        <a href="{{route('userLogoutRoute')}}" class="profile-box-tab text-danger">خروج از حساب</a>
                    </div>
                </div>
            </div>
            <div class="box-sidebar">
                <span class="box-header-sidebar">حساب کاربری شما</span>
                <ul class="profile-menu-items">
                    <li>
                        <a href="{{route('userDashboardRoute')}}" class="profile-menu-url">
                            <span class="mdi mdi-account-outline"></span>
                            پروفایل</a>
                    </li>
                    <li>
                        <a href="{{route('matcUserDashboardRoute')}}" class="profile-menu-url">
                            <span class="fa fa-star-o"></span>
                            مسابقه های من</a>
                    </li>
                    <li>
                        <a href="{{route('awardUserDashboardRoute')}}" class="profile-menu-url">
                            <span class="fa fa-file-text-o"></span>
                            جایزه های من</a>
                    </li>
                    <li>
                        <a href="{{route('orderUserDashboardRoute')}}" class="profile-menu-url">
                            <span class="fa fa-shopping-basket"></span>
                            سفارشات من</a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</div>
