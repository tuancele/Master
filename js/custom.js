(function($){
function validateEmail(e) {

    var r = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    return !!r.test(e)

}



function validatePhone(e) {

    var r = /^(016([0-9]{1})|012([0-9]{1})|09[0-9]|08[0-9]|03[0-9]|07[0-9]|05[0-9])(\d{7})$/i;

    return !!r.test(e)

}







function ErrForm(e,r) {

    var b = r + ' #err_note';

   // console.log(b);

    0 == jQuery(b).length ? jQuery(r).append('<div class="c"></div><div style="text-align:left ;color: #f00;  font-size: 12px; margin-top: 5px; margin-bottom: 10px;" id="err_note">' + e + "</div>") : jQuery(b).html(e), jQuery(r).focus()

}









function Submit_Form1(x,y) {

    var r = '.cele-form-' + x;

    var p = r + ' .celephone';

    var e = r + ' .celeemail';

    var n = r + ' .celename';

    var formAction = (r).attr("action");



    var name1 = jQuery(n + ' input').val(),

        phone1 = jQuery(p + ' input').val();

        email1 =    jQuery(e + ' input').val();

    console.log(name1);

    console.log(phone1);

    console.log(email1);

    switch (y) {



        case 'noname':

             return "" == phone1 ? (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error3,e)) : "" == email1 || validateEmail(email1) ? "" == phone1 ? (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error2,p)) : "" == phone1 || validatePhone(phone1) ? void(request_form || (request_form = !0, jQuery(r).submit())) : (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error5,p)): (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error4,e))

   

        break;

        case 'all':







            return "" == name1 ? (jQuery("#err_note").css({

                display: "block"

            }),void ErrForm(error1,n)) : "" == phone1 ? (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error3,e)) : "" == email1 || validateEmail(email1) ? "" == phone1 ? (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error2,p)) : "" == phone1 || validatePhone(phone1) ? void(request_form || (request_form = !0, jQuery(r).submit())) : (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error5,p)): (jQuery("#err_note").css({

                display: "block"

            }), void ErrForm(error4,e))

        break;

    }



}

var request_form = !1;





function Submit_Form(x,y) {

    var r = '.cele-form-' + x;

    var p = r + ' .celephone';

    var e = r + ' .celeemail';

    var n = r + ' .celename';

    var name = phone = email = !1;

    var name1 = jQuery(n + ' input').val(),

        phone1 = jQuery(p + ' input').val();

        email1 =    jQuery(e + ' input').val();

    console.log(name1);

    console.log(phone1);

    console.log(email1);

    switch (y) {



        case 'noname':



        if (phone1 == "") {

            var phone = !1;

            jQuery(p + " #err_note").css({

                display: "block"

            }),void ErrForm(error2,p)

        } else {

            if (validatePhone(phone1)) {

                var phone = !0;

                jQuery(p + " #err_note").css({

                    display: "none"

                })



            } else {

                var phone = !1;

                jQuery(p + " #err_note").css({

                    display: "block"

                }),void ErrForm(error5,p)

            }   

        }



        if (email1 == "") {

            var email = !1;

            jQuery(e + " #err_note").css({

                display: "block"

            }),void ErrForm(error3,e)

        } else {

            if (validateEmail(email1)) {

                var email = !0;

                jQuery(e + " #err_note").css({

                    display: "none"

                })



            } else {

                var email = !1;

                jQuery(e + " #err_note").css({

                    display: "block"

                }),void ErrForm(error4,e)

            }   

        }



        if (email == !0 && phone ==  !0) {

            jQuery.ajax({

                        type: 'POST',

                        dataType: 'json',

                        url: ajaxurl,

                        data: {

                            'action': 'cele_ajax',

                            'order_name': 'Noname',

                            'order_phone': phone1,

                            'order_email': email1,

                            'order_link': window.location.href

                        },

                        beforeSend: function() {

                            jQuery('.overlay').addClass('active');

                        },

                        success: function (data) {

                            if(data.success == true) {

                                //Order_ResetAll();

                                window.location.href = returnurl + '?ids=' + data.data;

                            } else {

                                jQuery('.note_success_wrapper').html('<p class="error_success">Xin Quý khách vui lòng điền đủ thông các ô thông tin.</p>');

                                jQuery('.order_btn').attr('disabled', false);

                            }



                            jQuery('.overlay').removeClass('active');

                        },

                        error: function (errorThrown) {

                            console.log(errorThrown);

                        }

                    });

        }











            

        break;

        case 'all':



            if (name1 == "") {

                var name = !1;

                jQuery(n + " #err_note").css({

                    display: "block"

                }),void ErrForm(error1,n)

            } else {

                var name = !0;

                jQuery(n + " #err_note").css({

                    display: "none"

                })

            }



            if (phone1 == "") {

                var phone = !1;

                jQuery(p + " #err_note").css({

                    display: "block"

                }),void ErrForm(error2,p)

            } else {

                if (validatePhone(phone1)) {

                    var phone = !0;

                    jQuery(p + " #err_note").css({

                        display: "none"

                    })



                } else {

                    var phone = !1;

                    jQuery(p + " #err_note").css({

                        display: "block"

                    }),void ErrForm(error5,p)

                }   

            }



            if (email1 == "") {

                var email = !1;

                jQuery(e + " #err_note").css({

                    display: "block"

                }),void ErrForm(error3,e)

            } else {

                if (validateEmail(email1)) {

                    var email = !0;

                    jQuery(e + " #err_note").css({

                        display: "none"

                    })



                } else {

                    var email = !1;

                    jQuery(e + " #err_note").css({

                        display: "block"

                    }),void ErrForm(error4,e)

                }   

            }



            if (email == !0 && phone ==  !0 && name == !0) {

                jQuery.ajax({

                            type: 'POST',

                            dataType: 'json',

                            url: ajaxurl,

                            data: {

                                'action': 'cele_ajax',

                                'order_name': name1,

                                'order_phone': phone1,

                                'order_email': email1,

                                'order_link': window.location.href

                            },

                            beforeSend: function() {

                                jQuery('.overlay').addClass('active');

                            },

                            success: function (data) {

                                if(data.success == true) {

                                    //Order_ResetAll();

                                    window.location.href = returnurl + '?ids=' + data.data;

                                } else {

                                    jQuery('.note_success_wrapper').html('<p class="error_success">Xin Quý khách vui lòng điền đủ thông các ô thông tin.</p>');

                                    jQuery('.order_btn').attr('disabled', false);

                                }



                                jQuery('.overlay').removeClass('active');

                            },

                            error: function (errorThrown) {

                                console.log(errorThrown);

                            }

                        });

            }



        break;

    }



}





function form_content(x) {

    var r = '.form-content-' + x;

    var e = r + ' #phone_project' + x;

    var phone1 = jQuery(e).val();



            if (phone1 == "") {

                var phone = !1;

                jQuery(r + " #err_note").css({

                    display: "block"

                }),void ErrForm(error2,r)

            } else {

                if (validatePhone(phone1)) {

                    var phone = !0;

                    jQuery(r + " #err_note").css({

                        display: "none"

                    })

                    jQuery.ajax({

                                type: 'POST',

                                dataType: 'json',

                                url: ajaxurl,

                                data: {

                                    'action': 'cele_content_ajax',

                                    'order_phone': phone1,

                                    'order_link': window.location.href

                                },

                                beforeSend: function() {

                                    jQuery('.overlay').addClass('active');

                                },

                                success: function (data) {

                                    if(data.success == true) {

                                        //Order_ResetAll();

                                        window.location.href = returnurl + '?sdt=' + data.data;

                                    } else {

                                        jQuery('.note_success_wrapper').html('<p class="error_success">Xin Quý khách vui lòng điền đủ thông các ô thông tin.</p>');

                                        jQuery('.order_btn').attr('disabled', false);

                                    }

                                    jQuery('.overlay').removeClass('active');

                                },

                                error: function (errorThrown) {

                                    console.log(errorThrown);

                                }

                            });

                } else {

                    var phone = !1;

                    jQuery(r + " #err_note").css({

                        display: "block"

                    }),void ErrForm(error5,r)

                }   

            }

}







var requestSent_eproject2 = !1,

    requestSent_eproject = !1,

    requestSent_fthl1 = !1,

    requestSent_email = !1,

    requestSent_sdt = !1,

    request_downow = !1,

    request_red = !1,

    request_blue = !1,

    request_yellow = !1;

    request_content = !1,

jQuery.noConflict(),

    function(e) {

        e(document).ready(function() {

            e(".nav-header").affix({

                offset: {

                    top: e(".banner").outerHeight(!0)

                }

            })

            e(".section2-left").height() >= e(".section2-right").height() && e("#dowload-last-link").affix({

              

                    offset: {

                        top: e(".section2-right").outerHeight(!0),

                        bottom: e(".section3").outerHeight(!0) + 900

                    }

                

                })



            e(".header-top").headroom({

                              "tolerance": 5,

                              "offset": 0,

                              "classes": {

                                "initial": "animated",

                                "pinned": "slideDown",

                                "unpinned": "slideUp",

                                "top": "headroom--top",

                                "notTop": "headroom--not-top"

                              }

                            });





            e("#menu").mmenu({

                                    extensions: [

                                        "position-front",

                                        "pagedim-black",

                                        "position-right",

                                        "fx-listitems-slide",

                                        "theme-dark"

                                    ],

                                   

                                    navbar: {

                                        title: "MOBILE MENU"

                                    },

                                    navbars: [{

                                        position: "bottom",

                                        content: ['<a href="https://tuancele.net" target="_blank">Designed by Tuancele</a>']

                                    }],

                                    

                                    

                                },

                                {

                                     // configuration

                                     offCanvas: {

                                        pageSelector: ".wrappers"

                                     }

                                

                                })













            e("#dowload-last-link").width(e("#dowload-last-link").parent().width());

        }), e("document").ready(function() {

            e("#btn_startdownloadtailieu").click(function() {

                return e(".step_down0").removeClass("active"), e(".step_down1").addClass("active"), !1

            }), 

           

            e(".tai-bang-gia a").on("click", function(r) {

                var t = e(r.target);

                e(t.attr("href")).length > 0  && (e("html, body").stop().animate({

                    scrollTop: e(t.attr("href")).offset().top - 50

                }, 1500), r.preventDefault())

            })

            e(".v2_danhgia_nsb_link a").on("click", function(r) {

                var t = e(r.target);

                e(t.attr("href")).length > 0  && (e("html, body").stop().animate({

                    scrollTop: e(t.attr("href")).offset().top - 100

                }, 1500), r.preventDefault())

            })

        }), e(document).ready(function() {

            var r = 220,

                t = 500;

            e(window).scroll(function() {

                e(this).scrollTop() > r ? e(".back-to-top").fadeIn(t) : e(".back-to-top").fadeOut(t)

            }), e(".back-to-top").click(function(r) {

                return r.preventDefault(), e("html, body").animate({

                    scrollTop: 0

                }, t), !1

            })

        })





    }(jQuery);

var requestSent_eprojectttt = !1;


(function($) {
<?php if( get_field('khpp','option') ): ?>
function openmodal() {
setTimeout(function() {
$('#myModal3').modal();
}, <?php the_field('sgxh','option')?>);
}
var visited =  Cookies.set('visited');
if (visited == 'yes') {
return false;
} else {
openmodal();
}
Cookies.set('visited', 'yes', {
expires: 1
});
<?php endif; ?>
$(".menu-item a").click(function(a) {
var i = this.getAttribute("href");
if ("" != i) {
var t = $(i).offset().top - 67;
$(window).width() <= 1190 && (t += 7), $("html, body").animate({
scrollTop: t
}, 500)
}
});
})(jQuery);

const thumbEl = document.querySelector(".slider-project-primary-thumbs");
if (thumbEl) {
this.sliderProjectPrimaryThumbs = new Swiper(".slider-project-primary-thumbs", {
slidesPerView: "auto",
slidesPerGroupAuto: true,
freeMode: true,
watchSlidesProgress: true,
navigation: {
nextEl: ".slider-project-primary-thumbs .swiper-button-next",
prevEl: ".slider-project-primary-thumbs .swiper-button-prev",
},
});
}
const bannerEl = document.querySelector(".slider-project-primary");
if (bannerEl) {
this.sliderBanner = new Swiper(".slider-project-primary", {
effect: "slide",
slidesPerView: 1,
slideToClickedSlide: true,
loop: true,
navigation: {
nextEl: ".slider-project-primary .swiper-button-next",
prevEl: ".slider-project-primary .swiper-button-prev",
},
...(this.sliderProjectPrimaryThumbs
? {
thumbs: {
swiper: this.sliderProjectPrimaryThumbs,
},
}
: {}),
breakpoints: {
768: {
slidesOffsetBefore: 32,
slidesPerView: "auto",
slidesPerGroupAuto: true,
},
},
});
}
const utilitiesEl = document.querySelector(".slider-utilities");
if (utilitiesEl) {
new Swiper(".slider-utilities", {
slidesPerView: "auto",
slidesPerGroupAuto: true,
navigation: {
nextEl: ".slider-utilities .swiper-button-next",
prevEl: ".slider-utilities .swiper-button-prev",
},
});
}
const subdivisionEl = document.querySelector(".slider-subdivision");
if (subdivisionEl) {
new Swiper(".slider-subdivision", {
slidesPerView: "auto",
slidesPerGroupAuto: true,
navigation: {
nextEl: ".slider-subdivision .swiper-button-next",
prevEl: ".slider-subdivision .swiper-button-prev",
},
});
}
(function($) {
$('[data-fancybox="images"]').fancybox({
thumbs : {
autoStart : true,
axis      : 'x'
}
});
$('[data-fancybox="images2"]').fancybox({
thumbs : {
autoStart : true,
axis      : 'x'
}
});
$('.accordion-view-more').on('click', function() {
$('.accordion-item.is-invisible').each(function() {
$(this).removeClass('is-invisible').removeAttr('style');
});

$(this).closest('.block-cta').hide();
});
$('.accordion-default .accordion-close').on('click', function () {
var $accordionItem = $(this).closest('.accordion-item');
var $icon = $(this).find('.accordion-icon');
$accordionItem.toggleClass('is-active');
if ($icon.hasClass('ti-chevron-up')) {
$icon.removeClass('ti-chevron-up').addClass('ti-chevron-down');
} else {
$icon.removeClass('ti-chevron-down').addClass('ti-chevron-up');
}
});
var defaultMapSrc = $('#default-map').attr('src');
$('.location-type-item').on('click', function(e) {
e.preventDefault();
$('.location-type-item').removeClass('is-active');
$('.location-type-lists-group').removeClass('is-active');
$(this).addClass('is-active');
var termId = $(this).data('term-id');
$('.location-type-lists-group[data-term-id="' + termId + '"]').addClass('is-active');

$('#default-map').attr('src', defaultMapSrc);
});
$('.location-type-lists').on('click', '.location-type-lists-item', function(e) {
e.preventDefault();
var mapSrc = $(this).data('map-src');
if (mapSrc) {
$('#default-map').attr('src', mapSrc);
} else {
$('#default-map').attr('src', defaultMapSrc);
}
});
$('.accordion-faq .accordion-header').on('click', function (e) {
e.preventDefault();
var $item = $(this).closest('.accordion-item');
var isActive = $item.hasClass('is-active');
$('.accordion-faq .accordion-item').removeClass('is-active');
$('.accordion-faq .accordion-icon').removeClass('ti-minus').addClass('ti-plus');
if (!isActive) {
$item.addClass('is-active');
$(this).find('.accordion-icon').removeClass('ti-plus').addClass('ti-minus');
}
});

jQuery(document).ready(function($) {
    var nav = $(".head2");
    var tabLinks = $('.tab-link');

    // Sticky navbar
    $(window).on('scroll', function () {
        var scrollPos = $(this).scrollTop();

        if (scrollPos > 250) {
            nav.addClass("navbar-fixed-top");
        } else {
            nav.removeClass("navbar-fixed-top");
        }

        // Active tab theo scroll
        tabLinks.each(function () {
            var target = $(this).attr('href');
            if ($(target).length) {
                var sectionTop = $(target).offset().top - 120;
                var sectionBottom = sectionTop + $(target).outerHeight();

                if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                    $('.tab-item').removeClass('active');
                    $(this).closest('.tab-item').addClass('active');
                }
            }
        });
    });

    // Click: cuộn mượt + active
    tabLinks.on('click', function (e) {
        e.preventDefault();

        if ($(this).attr('disabled') || $(this).closest('.tab-item').hasClass('disabled')) {
            return;
        }

        var target = $(this).attr('href');

        if ($(target).length) {
            $('.tab-item').removeClass('active');
            $(this).closest('.tab-item').addClass('active');

            $('html, body').animate({
                scrollTop: $(target).offset().top - 100
            }, 600);
        }
    });

    // Mở menu khi bấm vào nút
    $('.button__nav-menu').on('click', function (e) {
        e.stopPropagation(); // Ngăn sự kiện lan ra document
        var $menu = $(this).next('ul');
        $('.button__nav-menu').not(this).next('ul').slideUp(); // Đóng menu khác nếu có
        $menu.slideToggle();
    });

    // Ngăn việc đóng khi click vào menu
    $('.button__nav-menu').next('ul').on('click', function (e) {
        e.stopPropagation();
    });

    // Đóng menu khi click ra ngoài
    $(document).on('click', function () {
        $('.button__nav-menu').next('ul').slideUp();
    });
});

})(jQuery);

})(jQuery);
