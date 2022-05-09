@if(session('successInsert'))
    <div class="alert alert-success">
        <p>اطلاعات با موفقیت درج شد.</p>
    </div>
@endif
@if(session('successDelete'))
    <div class="alert alert-success">
        <p>حذف با موفقیت انجام شد.</p>
    </div>
@endif
@if(session('successEdit'))
    <div class="alert alert-success">
        <p>ویرایش با موفقیت انجام شد.</p>
    </div>
@endif
@if(session('notLogin'))
    <div class="alert alert-danger">
        <p>* لطفا برای ورود به مسابقه وارد حساب کاربری خود شوید یا ثبت نام کنید.</p>
    </div>
@endif
