@extends('Front.Layouts')
@section('main')
    <!--contact-us--------------------------------->
    <div class="container-main">
        <div class="col-12">
            <section class="contact-us">
                <div class="page-content-contact-us">
                    <h1 class="page-content-contact-us-title">تماس با جایزه دون</h1>
                    <div class="page-content-contact-us-row">
                        <div class="col-lg-8 col-md-8 col-xs-12 pull-right">
                            <div class="page-content-contact-us-col-big">
                                <p class="page-content-contact-us-full-paragraph">
                                    کاربر گرامی، لطفاً در صورت وجود هرگونه سوال یا ابهامی،
                                    پیش از ارسال ایمیل یا تماس تلفنی با جایزه دون، بخش
                                    <a href="#" class="btn-link-spoiler">پرسش‏های متداول</a>
                                    را ملاحظه فرمایید و در
                                    صورتی که پاسخ خود را نیافتید، با ما تماس بگیرید.
                                </p>
                                <br>
                                <br>
                                <p class="page-content-contact-us-full-paragraph">برای پیگیری یا سوال درباره سفارش  و ارسال پیام بهتر است از فرم زیر استفاده کنید.</p>
                                <hr class="info-page-separator">
                                @include("Dashboard.Partials.notifications")
                                @include("Dashboard.Partials.errors")
                                <div class="page-content-contact-us-row-col">
                                    <form method="post" action="{{route('postContactRoute')}}" class="contact-us-form">
                                        {{csrf_field()}}
                                        <div class="contact-us-form-body">
                                            <div class="form-legal-item">
                                                <label for="#" class="form-legal-label">
                                                    نام و نام‌خانوادگی
                                                    <span class="required-star" style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="flname" class="ui-input-field form-control" value="@if(!empty(session()->get("username"))) @php echo session()->get("user_flname") @endphp @else{{old("flname")}}@endif" placeholder="نام و نام‌خانوادگی">
                                            </div>
                                            <div class="form-legal-item">
                                                <label for="#" class="form-legal-label">
                                                    موضوع
                                                    <span class="required-star" style="color:red;">*</span>
                                                </label>
                                                <select name="subject" id="province" class="ui-select-field form-control">
                                                    <option value="0" selected="selected">انتخاب کنید</option>
                                                    <option value="پیشنهاد">پیشنهاد</option>
                                                    <option value="انتقاد یا شکایت">انتقاد یا شکایت</option>
                                                    <option value="پیگیری سفارش">پیگیری سفارش</option>
                                                    <option value="خدمات پس از فروش">خدمات پس از فروش</option>
                                                </select>
                                            </div>
                                            <div class="form-legal-item">
                                                <label for="#" class="form-legal-label">
                                                    تلفن تماس
                                                    <span class="required-star" style="color:red;">*</span>
                                                </label>
                                                <input type="text" name="tell" class="ui-input-field form-control" value="@if(!empty(session()->get("username"))) @php echo session()->get("user_mobile") @endphp @else{{old("tell")}}@endif" placeholder="تلفن تماس">
                                            </div>
                                            <div class="form-legal-item">
                                                <label for="#" class="form-legal-label">
                                                    متن پیام
                                                    <span class="required-star" style="color:red;">*</span>
                                                </label>
                                                <textarea name="message" id="" cols="30" rows="10" class="ui-textarea-field form-control" placeholder="متن پیام">{{old("message")}}</textarea>
                                            </div>
                                            <div class="form-group captcha-place">
                                                <?php echo captcha_img('flat') ?>
                                                <input type="number" id="captcha" placeholder="کد امنیتی" class="form-control" name="captcha" >
                                            </div>
                                            <div class="upload-drag-uploaded-and-submit">
                                                <button class="contact-us-form-submit">ثبت اطلاعات</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr class="info-page-separator">
                                <div class="message-light-success">
                                        <span class="info-page-bold">
                                            <a href="tel:02122707088" style="font-size: 18px !important;">شماره تماس : 22707088 - 021</a>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12 pull-left">
                            <div class="page-content-contact-us-image-container text-left">
                                <img src="{{asset('img/footer/page-contact-us.svg')}}">
                            </div>
                        </div>
                        <br>
                        <h2 class="page-content-contact-us-title-smaller">آدرس:
                            <p class="page-content-contact-us-full-paragraph">میدان بهارستان، خیابان صفی علیشاه، خیابان صفی، بن بست سپیده، پلاک 2، واحد 2</p>
                        </h2>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!--contact-us--------------------------------->
    <style>
        .captcha-place img{
            display: block;
            margin: 0 auto 20px auto;
        }
    </style>
@endsection
