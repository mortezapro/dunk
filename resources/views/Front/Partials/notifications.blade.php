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
@if(session('successLogin'))
    <div class="alert alert-success">
        <p>خوش آمدید </p>
    </div>
@endif
@if(session('successOrder'))
    <div class="alert alert-success">
        <p>اطلاعات با موفقیت ثبت شد. کد پیگیری شما: {{session('code')}}</p>
    </div>
@endif
