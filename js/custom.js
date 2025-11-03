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



