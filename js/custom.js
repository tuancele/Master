/* ==========================================================================
   FILE: js/custom.js - FINAL VERSION (Fix Popup + Restore Sliders)
   ========================================================================== */

(function($) {
    "use strict";

    /* --- 1. CÁC HÀM HỖ TRỢ (HELPER FUNCTIONS) --- */
    function validateEmail(e) {
        var r = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return !!r.test(e);
    }

    function validatePhone(e) {
        var r = /^(016([0-9]{1})|012([0-9]{1})|09[0-9]|08[0-9]|03[0-9]|07[0-9]|05[0-9])(\d{7})$/i;
        return !!r.test(e);
    }

    function ErrForm(e, r) {
        var b = r + ' #err_note';
        if (jQuery(b).length === 0) {
            jQuery(r).append('<div class="c"></div><div style="text-align:left; color:#f00; font-size:12px; margin-top:5px; margin-bottom:10px;" id="err_note">' + e + "</div>");
        } else {
            jQuery(b).html(e);
        }
        jQuery(r).focus();
    }

    /* --- 2. LOGIC XỬ LÝ FORM --- */
    window.Submit_Form = function(x, y) {
        var r = '.cele-form-' + x;
        var p = r + ' .celephone';
        var e = r + ' .celeemail';
        var n = r + ' .celename';
        var name1 = jQuery(n + ' input').val();
        var phone1 = jQuery(p + ' input').val();
        var email1 = jQuery(e + ' input').val();
        
        var msgErr = (typeof error1 !== 'undefined') ? error1 : "Vui lòng điền đầy đủ thông tin!"; 

        var isValidPhone = (phone1 !== "" && validatePhone(phone1));
        var isValidEmail = (email1 !== "" && validateEmail(email1));
        var isValidName = (name1 !== "");

        if(y === 'noname') {
            if (!isValidPhone) {
                jQuery(p + " #err_note").css({ display: "block" });
                ErrForm(msgErr, p);
                return;
            }
            if (!isValidEmail) {
                jQuery(e + " #err_note").css({ display: "block" });
                ErrForm(msgErr, e);
                return;
            }
        } else if (y === 'all') {
            if (!isValidName) {
                jQuery(n + " #err_note").css({ display: "block" });
                ErrForm(msgErr, n);
                return;
            }
            if (!isValidPhone) {
                jQuery(p + " #err_note").css({ display: "block" });
                ErrForm(msgErr, p);
                return;
            }
            if (!isValidEmail) {
                jQuery(e + " #err_note").css({ display: "block" });
                ErrForm(msgErr, e);
                return;
            }
        }

        // Gửi Ajax
        if (typeof ajaxurl !== 'undefined') {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action': 'cele_ajax',
                    'order_name': name1 || 'Noname',
                    'order_phone': phone1,
                    'order_email': email1,
                    'order_link': window.location.href
                },
                beforeSend: function() {
                    jQuery('.overlay').addClass('active');
                },
                success: function(data) {
                    if (data.success === true) {
                        if(typeof returnurl !== 'undefined') {
                            window.location.href = returnurl + '?ids=' + data.data;
                        } else {
                            alert("Gửi thành công!");
                            jQuery('.modal').modal('hide');
                        }
                    } else {
                        alert("Có lỗi xảy ra hoặc thiếu thông tin.");
                    }
                    jQuery('.overlay').removeClass('active');
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                    jQuery('.overlay').removeClass('active');
                }
            });
        }
    };

    /* --- 3. MAIN READY --- */
    $(document).ready(function() {

        // FIX 1: Nút NHẬN TƯ VẤN RIÊNG (#nhantuvanrieng)
        $(document).off('click', '.btn-nhantuvanrieng').on('click', '.btn-nhantuvanrieng', function(e) {
            e.preventDefault(); 
            $('#nhantuvanrieng').modal('show'); 
            return false;
        });

        // FIX 2: Nút TẢI BẢNG GIÁ MỚI NHẤT (#myModal2)
        $(document).off('click', '.dowload-now').on('click', '.dowload-now', function(e) {
            e.preventDefault(); 
            $('#myModal2').modal('show'); 
            return false;
        });

        // Sticky Header & Other UI Logic
        if ($(".nav-header").length) {
            $(".nav-header").affix({
                offset: { top: $(".banner").outerHeight(true) || 100 }
            });
        }

        $(".tai-bang-gia a, .v2_danhgia_nsb_link a").on("click", function(r) {
            var t = $(r.target);
            var offset = $(this).parent().hasClass('v2_danhgia_nsb_link') ? 100 : 50;
            if ($(t.attr("href")).length > 0) {
                $("html, body").stop().animate({
                    scrollTop: $(t.attr("href")).offset().top - offset
                }, 1500);
                r.preventDefault();
            }
        });

        var scrollTrigger = 220;
        $(window).scroll(function() {
            if ($(this).scrollTop() > scrollTrigger) {
                $(".back-to-top").fadeIn(500);
            } else {
                $(".back-to-top").fadeOut(500);
            }
        });
        $(".back-to-top").click(function(r) {
            r.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 500);
        });

    }); // End Ready

})(jQuery);

/* ==========================================================================
   4. KHÔI PHỤC TÍNH NĂNG SLIDER (SWIPER JS)
   ========================================================================== */
document.addEventListener('DOMContentLoaded', function() {
    
    // Slider: Thumbs (Ảnh nhỏ dự án)
    const thumbEl = document.querySelector(".slider-project-primary-thumbs");
    let sliderProjectPrimaryThumbs = null;

    if (thumbEl && typeof Swiper !== 'undefined') {
        sliderProjectPrimaryThumbs = new Swiper(".slider-project-primary-thumbs", {
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

    // Slider: Banner chính
    const bannerEl = document.querySelector(".slider-project-primary");
    if (bannerEl && typeof Swiper !== 'undefined') {
        const swiperOptions = {
            effect: "slide",
            slidesPerView: 1,
            slideToClickedSlide: true,
            loop: true,
            navigation: {
                nextEl: ".slider-project-primary .swiper-button-next",
                prevEl: ".slider-project-primary .swiper-button-prev",
            },
            breakpoints: {
                768: {
                    slidesOffsetBefore: 32,
                    slidesPerView: "auto",
                    slidesPerGroupAuto: true,
                },
            },
        };

        if (sliderProjectPrimaryThumbs) {
            swiperOptions.thumbs = { swiper: sliderProjectPrimaryThumbs };
        }

        new Swiper(".slider-project-primary", swiperOptions);
    }

    // Slider: Tiện ích (Utilities)
    const utilitiesEl = document.querySelector(".slider-utilities");
    if (utilitiesEl && typeof Swiper !== 'undefined') {
        new Swiper(".slider-utilities", {
            slidesPerView: "auto",
            slidesPerGroupAuto: true,
            navigation: {
                nextEl: ".slider-utilities .swiper-button-next",
                prevEl: ".slider-utilities .swiper-button-prev",
            },
        });
    }

    // Slider: Phân khu (Subdivision) - ĐÂY LÀ PHẦN BẠN ĐANG LỖI
    const subdivisionEl = document.querySelector(".slider-subdivision");
    if (subdivisionEl && typeof Swiper !== 'undefined') {
        new Swiper(".slider-subdivision", {
            slidesPerView: "auto",
            slidesPerGroupAuto: true,
            navigation: {
                nextEl: ".slider-subdivision .swiper-button-next",
                prevEl: ".slider-subdivision .swiper-button-prev",
            },
        });
    }
});