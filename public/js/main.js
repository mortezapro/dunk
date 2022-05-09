$(document).ready(function(l){
    
    //    resposive-megamenu-mobile------------------
        $('.dropdown-toggle').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();

            var self = $(this);
            if (self.is('.disabled, :disabled')) {
              return false;
            }
            self.parent().toggleClass("open");
          });

          $(document).on('click', function(e) {
            if ($('.dropdown').hasClass('open')) {
              $('.dropdown').removeClass('open');
            }
          });

          $('.nav-btn.nav-slider').on('click', function() {
            $('.overlay').show();
            $('nav').toggleClass("open");
          });

          $('.overlay').on('click', function() {
            if ($('nav').hasClass('open')) {
              $('nav').removeClass('open');
            }
            $(this).hide();
          });
    
    
            $('li.active').addClass('open').children('ul').show();
            $("li.has-sub > a").on('click', function () {
                $(this).removeAttr('href');
                var e = $(this).parent('li');
                if (e.hasClass('open')) {
                    e.removeClass('open');
                    e.find('li').removeClass('opne');
                    e.find('ul').slideUp(200);
                }
                else {
                    e.addClass('open');
                    e.children('ul').slideDown(200);
                    e.siblings('li').children('ul').slideUp(200);
                    e.siblings('li').removeClass('open');
                    e.siblings('li').find('li').removeClass('open');
                    e.siblings('li').find('ul').slideUp(200);
                }
            });
//    resposive-megamenu-mobile------------------

//   start  Menu Fixed---------------------------

$(document).scroll(function () {
    var scroll = $(document).scrollTop();
    if (scroll > 200) {
        $('nav.main-menu,.sidebar,nav-slider').addClass("fixed-menu");
    } else if (scroll < 150) {
        $('nav.main-menu,.sidebar,nav-slider').removeClass("fixed-menu");
    }
});
    
//    tab----------------------------------------------
    $("ul.sort-options li").click(function(){
    var index = $(this).index();
    $("ul.sort-options li").removeClass("listing-active");
    $(this).addClass("listing-active");
    $("ul.listing-items li").slideUp(0);
    $("ul.listing-items li").eq(index).slideDown(0);
    });
    
    $("ul.nav li").click(function(){
    var index = $(this).index();
    $("ul.nav li").removeClass("nav-active");
    $(this).addClass("nav-active");
    $("ul.content-area li").slideUp(0);
    $("ul.content-area li").eq(index).slideDown(0);
    });
    
    $("ul.box-tabs li").click(function(){
    var index = $(this).index();
    $("ul.box-tabs li").removeClass("tabs-active");
    $(this).addClass("tabs-active");
    $(".tabs-content .tab-content-wrapper").slideUp(0);
    $(".tabs-content .tab-content-wrapper").eq(index).slideDown(0);
    });
//    tab----------------------------------------------
    
    $(".product-actions-secondary .heart").on("click",function () {
        $(this).toggleClass("heart-active");
    });
    
    /* ************** favorites product */
    $("ul.gallery-options button.add-favorites").on("click", function () {
        $(this).toggleClass("favorites");
    });
    
//    Scroll---------------------------
    $(document).on("scroll", function () {
        var st = $(this).scrollTop();
        if (st > 10) {
            $(".footer-jumpup-container").fadeIn(0, "swing");
        }
        else if (st < 300) {
            $(".footer-jumpup-container").fadeOut(0, "swing");
        }
    });
    $(".footer-jumpup-container").on("click", function () {
        $("html,body").animate({scrollTop: "0px"}, 3000, "swing");
    });
//    Scroll-------------------------------------- 
    
    $(".product-params-more-handler a").on('click',function(e){
        e.preventDefault();
        $(".product-params-more").slideToggle(0);
        $(this).find('.show-more').fadeToggle(0);
        $(this).find('.show-less').fadeToggle(0);
    });
    
    $(".mask-handler").click(function (e) {
        e.preventDefault();
        var sumaryBox = $(this).parents('.content-expert-summary');
        sumaryBox.find('.mask-text').toggleClass('active');
        sumaryBox.find('.shadow-box').fadeToggle();
        $(this).find('.show-more').fadeToggle(0);
        $(this).find('.show-less').fadeToggle(0);
    });
    
    $(".content-expert-button").click(function (e) {
        e.preventDefault();
        var sumaryBox = $(this).parents('.content-expert-article');
        sumaryBox.find('.content-expert-article').toggleClass('active');
        sumaryBox.find('.content-expert-text').slideToggle();
        $(this).find('.show-more').fadeToggle(0);
        $(this).find('.show-less').fadeToggle(0);
    });
    
//    quantity-selector---------------------------
    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });
//    quantity-selector---------------------------
    
//    price-range--------------------------------
            var nonLinearStepSlider = document.getElementById('slider-non-linear-step');

            if($('#slider-non-linear-step').length) {
                noUiSlider.create(nonLinearStepSlider, {
                    start: [0, 5000000],
                    connect: true,
                    direction: 'rtl',
                    format: wNumb({
                        decimals: 0,
                        thousand: ','
                    }),
                    range: {
                        'min': [0],
                        '10%': [500, 500],
                        '50%': [40000, 1000],
                        'max': [10000000]
                    }
                });
                var nonLinearStepSliderValueElement = document.getElementById('slider-non-linear-step-value');
    
                nonLinearStepSlider.noUiSlider.on('update', function (values) {
                    nonLinearStepSliderValueElement.innerHTML = values.join(' - ');
                });
            }
//    price-range--------------------------------
    
//    verify-phone-number------------------------
        if($("#countdown-verify-end").length) {
        var $countdownOptionEnd = $("#countdown-verify-end");

        $countdownOptionEnd.countdown({
        date: (new Date()).getTime() + 180 * 1000, // 1 minute later
        text: '<span class="day">%s</span><span class="hour">%s</span><span>: %s</span><span>%s</span>',
        end: function() {
            $countdownOptionEnd.html("<a href='' class='link-border-verify form-account-link'>ارسال مجدد</a>");
        }
        });
        }
        $(".line-number-account").keyup(function(){
            $(this).next().focus();
        });
//    verify-phone-number-----------------------
    
    //    countdown----------------------------
    ! function (l) {
    var t = {
            init: function () { t.countDown()
            },
            countDown: function (t, i) {
                l(".countdown").each(function () {
                    var t = l(this),
                        a = l(this).data("date-time"),
                        e = l(this).data("labels");
                    (i || t).countdown(a, function (t) {
                        l(this).html(t.strftime('<div class="countdown-item"><div class="countdown-value">%D</div><div class="countdown-label">' + e["label-day"] + '</div></div><div class="countdown-item"><div class="countdown-value">%H</div><div class="countdown-label">' + e["label-hour"] + '</div></div><div class="countdown-item"><div class="countdown-value">%M</div><div class="countdown-label">' + e["label-minute"] + '</div></div><div class="countdown-item"><div class="countdown-value">%S</div><div class="countdown-label">' + e["label-second"] + "</div></div>"))
                    })
                })
            },
        };
    l(function () {
        t.init()
    })
}(jQuery);
//    countdown----------------------------
    
//    product-gallery---------------------------
        var e = document;
        $(".product-gallery-carousel").owlCarousel({
            rtl: true,
            items: 1,
            loop: false,
            dots: false,
            nav: true,
            navText: ['<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>'],
            URLhashListener: true,
            startPosition: "URLHash",
            onTranslate: function (t) {
                var a = t.item.index,
                    e = l(".owl-item").eq(a).find("[data-hash]").attr("data-hash");
                l(".product-thumbnails li").removeClass("active"), l('[href="#' + e + '"]').parent().addClass("active"), l('[data-hash="' + e + '"]').parent().addClass("active")
            }
        });
//    product-gallery---------------------------
    
//    slider-product-------------------
    $(".product-carousel").owlCarousel({
        rtl: true,
        margin: 10,
        nav: true,
        navText: ['<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>'],
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                slideBy: 1
            },
            576: {
                items: 2,
                slideBy: 1
            },
            768: {
                items: 3,
                slideBy: 2
            },
            992: {
                items: 4,
                slideBy: 2
            },
            1400: {
                items: 4,
                slideBy: 3
            }
        }
    });
//    slider-product------------------- 
    
//    start slider sidebar-------------
    $("#suggestion-slider").owlCarousel({
        rtl: true,
        items: 1,
        autoplay: true,
        autoplayTimeout: 5000,
        loop: true,
        dots: false,
        onInitialized: startProgressBar,
        onTranslate: resetProgressBar,
        onTranslated: startProgressBar
    });
    
    function startProgressBar() {
      $(".slide-progress").css({
        width: "100%",
        transition: "width 5000ms"
      });
    }

    function resetProgressBar() {
      $(".slide-progress").css({
        width: 0,
        transition: "width 0s"
      });
    }
//    End slider sidebar-------------
    
//    main_slider--------------------
    if($('.swiper-container').length) {
        var swiper = new Swiper('.swiper-container', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
              delay: 2500,
              disableOnInteraction: false,
            },
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
          });
    }
//    main_slider----------------------
});