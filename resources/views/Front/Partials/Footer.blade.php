<!--footer------------------------------------->
<footer class="footer mt-3">
    <div class="row">
        <div class="footer-jumpup">
            <div class="container">
                <a href="#">
                    <span href="#" class="footer-jumpup-container"><i class="fa fa-angle-up"></i></span>
                </a>
            </div>
        </div>
    </div>

    <article class="container-main">
        <div class="footer-middlebar">
            <div class="col-lg-8 col-md-8 col-xs-12 pull-right">
                <div class="footer-links">
                    <div class="col-lg-4 col-md-4 col-xs-12 pull-right">
                        <nav class="footer-links-col">
                            <div class="headline-links mb-3">
                                <a href="">
                                    دسترسی سریع 
                                </a>
                            </div>
                            <ul class="footer-links-ul">
                                <li>
                                    <a href="{{route('registerRoute')}}">
                                        ثبت نام  
                                    </a>
                                </li>
                                <li class=" blink_me">
                                    <a style="color:red"  onMouseOver="this.style.color='#fff'" onMouseOut="this.style.color='#ff0000'"  href="{{route('QuizCodeRoute')}}">
                                          شروع مسابقه
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('frontAboutRoute')}}">
                                        درباره ما  
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12 pull-right">
                        <nav class="footer-links-col">
                            <div class="headline-links mb-3">
                                <a href="">
                                    خدمات مشتریان
                                </a>
                            </div>
                            <ul class="footer-links-ul">
                                <li>
                                    <a href="{{route('frontContactRoute')}}">
                                        ارتباط با ما
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('frontContactRoute')}}">
                                        ثبت شکایات
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('frontAboutRoute')}}">
                                        قوانین و مقررات
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12 pull-right">
                        <nav class="footer-links-col">
                            <div class="headline-links mb-3">
                                <a href="">
                                    جایزه دونی ها
                                </a>
                            </div>
                            <ul class="footer-links-ul">
                                <li>
                                    <a href="#">
                                        ناشران
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                       کتاب فروشی ها
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                       دیگران 
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12 pull-left">
                <div class="footer-form">
                
                    <div class="footer-community">
                        <div class="footer-social mb-4 mt-4">
                            <span>جایزه دون را در شبکه‌های اجتماعی دنبال کنید:</span>
                            <div class="footer-social">
                                <ul class="footer-ul-social">
                                    <li class="footer-social-item">
                                        <a href="https://www.instagram.com/jayezedoon/" target="_blank" class="footer-social-link">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="footer-copyright-text">
                    <p style="font-size: 14px !important;">آدرس: {{$setting->address}} </p>
                    <a href="tel:{{$setting->mobile}}" style="font-size: 14px !important;">شماره تماس -  {{$setting->mobile}} </a>
                </div>
            </div>
        </div>
        <div class="footer-more-info">
            <div class="footer-description-content">
                <div class="col-xs-8 col-md-8 col-xs-12 pull-right">
                    <div class="footer-content">
                        <article class="footer-seo mt-3">
                            <h1>فروشگاه اینترنتی جایزه دون</h1>
                            <p>هدف جایزه دون تشویق کودکان به کتاب و کتابخوانی با شیوه ای نوین است. در این سایت در مورد هر کتاب به صورت رندوم از مخاطب چند سوال پرسیده می شود و در صورتی که مخاطب جواب سوالات را درست بدهد می تواند 2 تا 4 برابر قیمت کتاب جایزه دریافت کند این جایزه بنا به در خواست کتاب خوان به صورت نقدی و یا از صفحه جایزه ها که شامل اسباب بازی، بازی فکری یا لوازم التحریر است اهداء می شود.</p>
                        </article>
                    </div>
                </div>
                <div class="">
                    <div class="col-lg-4 col-md-4 col-xs-12 pull-left">
                        <aside>
                            <ul class="footer-safety-partner mt-4 pull-left">
                                <li class="footer-safety-partner-1">
                                    <a rel="origin" target="_blank" href="https://trustseal.enamad.ir/?id=173917&amp;Code=lrQMcV6vU9H7CdIlJ9kF"><img src="https://Trustseal.eNamad.ir/logo.aspx?id=173917&amp;Code=lrQMcV6vU9H7CdIlJ9kF" alt="" style="cursor:pointer" id="lrQMcV6vU9H7CdIlJ9kF"></a>
                                </li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="footer-copyright-text">
                تمامی حقوق مادی و معنوی وب سایت متعلق به انتشارات<a href="{{route('indexRoute')}}"> پاورقی </a>می باشد.<br>
                <a href="https://laravelweb.ir/" target="_blank">طراحی سایت </a> و <a href="https://laravelweb.ir/" target="_blank">دیجیتال مارکتینگ </a> توسط لاراول وب

            </div>
        </div>
    </article>
</footer>
<!--footer------------------------------------->
