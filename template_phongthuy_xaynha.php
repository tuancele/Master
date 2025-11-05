<?php

/*

 Template Name: Phong Thuy - Xây nhà Teamplate

 */

 ?>

<?php get_header(); ?>

<main id="main">
    <div id="content" class="nb">
        <div class="container">
            <?php
            if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb('
            <p id="breadcrumbs">','</p>
            ');
            }
            ?>
            <h1><span style="font-size: 18pt;"><strong><span style="font-family: 'times new roman', times, serif;"><?php the_title(); ?></span></strong></span></h1>
            <div class="title">
                
                <?php wp_nav_menu( array( 'container' => '','theme_location' => 'phongthuy','menu_class' => 'phongthuy-menu clearfix' ) ); ?>
                <div class="infomation-refer">
                    <p> Lưu ý: Thông tin chỉ mang tính chất tham khảo</p>
                </div>
            </div>
            <div class="row">
                <div class="content col-md-12">
                    <div class="direction">
                        <div class="title">
                            <div class="content-title">
                                <p class="text-title"><?php the_title(); ?></p>
                            </div>
                        </div>
                        <div class="content-direction">
                            <div class="icon-direction">
                                <img src="<?php bloginfo('template_url'); ?>/phongthuy/xem-xay-nha-02.png">
                            </div>
                            <div class="info-see">
                                <div class="info-personal">
                                    <div class="content-info">
                                        <div class="year">
                                            <p>Năm sinh (âm lịch)</p>
                                            <div class="slect-year">
                                                <select name="year" id="year">
                                                    <?php
                                                        for ($x = 1945; $x <= 2030; $x++) {
                                                            echo '<option>'.$x.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="gender inteneded-year">
                                            <p>Năm dự định làm</p>
                                            <div class="slect-gender">
                                                <select name="gender" class="select-year">
                                                    <?php
                                                                                            for ($x = 2019; $x <= 2050; $x++) {
                                                                                                echo '<option>'.$x.'</option>';
                                                                                            }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="result">
                                            <button class="btn-result">XEM KẾT QUẢ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="default">
                        <div class="content-default">
                            <div class="you-know">
                                <p>Bạn có biết?</p>
                            </div>
                            <?php while (have_posts()) : the_post(); ?>
                            <div class="content-post clearfix">
                                <?php the_content(); ?>
                            </div>
                            <?php endwhile; ?>
                            
                        </div>
                        <div class="result">
                            <div class="title-result">
                                <p>Kết quả</p>
                            </div>
                            <div class="info">
                                <p class="info-homeowners title-info">THÔNG TIN GIA CHỦ</p>
                                <div class="homeowners">
                                    <div class="homeowners-content">
                                        <div class="info-detail">
                                            <div class="item-info">
                                                <span class="txt-circle"></span>
                                                <p class="txt-left">
                                                    Năm sinh âm lịch
                                                </p>
                                                <p class="txt-right txt-year-birth">1989</p>
                                            </div>
                                            <div class="item-info">
                                                <span class="txt-circle"></span>
                                                <p class="txt-left">
                                                    Mệnh ngũ hành
                                                </p>
                                                <p class="txt-right txt-fate">Đại lâm mộc</p>
                                            </div>
                                            <div class="item-info">
                                                <span class="txt-circle"></span>
                                                <p class="txt-left">
                                                    Thiên can
                                                </p>
                                                <p class="txt-right txt-can">Kỷ</p>
                                            </div>
                                            <div class="item-info">
                                                <span class="txt-circle"></span>
                                                <p class="txt-left">
                                                    Địa chi
                                                </p>
                                                <p class="txt-right txt-chi">Tỵ</p>
                                            </div>
                                            <div class="item-info">
                                                <span class="txt-circle"></span>
                                                <p class="txt-left">
                                                    Cung mệnh
                                                </p>
                                                <p class="txt-right txt-supply-destiny"></p>
                                            </div>
                                        </div>
                                        <div class="log-supply">
                                            <img src="<?php bloginfo('template_url'); ?>/phongthuy/giap/01-ty.png" class="mascot">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="directions">
                                <p class="title-info">
                                    TUỔI <span class="par-age"></span> XÂY NHÀ NĂM <span class="down-line"></span> <span class="year_buy_build"></span> - <span class="par-age-year"></span>
                                </p>
                                <div class="direction-par ">
                                    <div class="content-par ">
                                        <div class="info-direction content-par-buy-house">
                                            <div class="type-direction">
                                                <div class="item">
                                                    <p class="title-supply">XÉT 3 YẾU TỐ</p>
                                                    <div class="direction-supply">
                                                        <div class="supply-item">
                                                            <span class="txt-cricle"></span>
                                                            <p>Hoang Ốc</p>
                                                            <p>Năm <span class="year_buy_build"></span>, bạn <span class="old"></span> <span class="violate"></span> </p>
                                                        </div>
                                                        <div class="supply-item">
                                                            <span class="txt-cricle"></span>
                                                            <p>Tam Tai</p>
                                                            <p>Tuổi <span class="par-age"></span> cần tránh các năm Tam Tai: <span class="three-ears"></span>. Năm dự kiến xây nhà là năm <span class="year_buy_build"></span> tức năm <span class="par-age-year"></span>, <span class="txt-result"></span> </p>
                                                        </div>
                                                        <div class="supply-item">
                                                            <span class="txt-cricle"></span>
                                                            <p>Kim Lâu</p>
                                                            <p>Năm <span class="year_buy_build"></span>, bạn <span class="old"></span>  nếu năm đó tiến hành mua nhà sẽ <span class="text-brown">không phạm kim lâu.</span> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <p class="title-supply">Kết Luận</p>
                                                    <div class="direction-supply">
                                                        <div class="supply-item conclusion-buy">
                                                            <p class="text-build-house"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="more-feng-shui">
                                <div class="more-content">
                                    <p>Xem thêm</p>
                                    <div class="see-feng-shui">
                                        <span class="txt-cricle"></span>
                                        <a href="<?php bloginfo('home')?>/xem-tuoi-mua-nha" title="Xem tuổi mua nhà">Xem tuổi mua nhà</a>
                                    </div>
                                    <div class="see-feng-shui">
                                        <span class="txt-cricle"></span>
                                        <a href="<?php bloginfo('home')?>/xem-huong-nha" title="Xem hướng nhà">Xem hướng nhà</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/phongthuy/nb.css">
<script>
	var dataurl ="<?php bloginfo('template_url'); ?>/phongthuy";
</script>
<script src="<?php bloginfo('template_url'); ?>/phongthuy/nb.js"></script>
<script>
	(function($) {
        
         
                
                    $(".btn-result").click(function () {

                        $(".content-default").css("display", "none");
                        $(".result").css("display", "block");
                        var _year = $("#year option:selected").text();
                        var _grendId = $("#gender option:selected").val();
                        var _name_grend = $("#gender option:selected").text();
                        var _year_build_buy = $(".select-year option:selected").text();

                        Calculate(_year, _grendId, _year_build_buy);

                        var _year_buy = $(".select-year option:selected").text();

                        $(".year_buy_build").html(_year_buy);

                        // Để ảnh mặc định ban đầu
                        //$(".bagua").rotate({
                        //    angle: 0,
                        //    animateTo: 180,
                        //});
                    })

                    // Xoay ảnh hình bát quái

                   // UrlParam();

                    $(".bagua").rotate({
                        angle: 180
                    });

                   // OwlCarousel();
                    var value = 180;
                    $(".bagua").rotate({
                        bind:
                        {
                            click: function () {
                                value += 45;
                                $(this).rotate({ animateTo: value })
                            }
                        }
                    });
          
          
       

        function UrlParam() {
            var url = window.location.href;
            var urlPath = url.substring(url.lastIndexOf("/") + 1);
            var _grendId = 1;
            var _nameGrend = "Nam";
            if (urlPath.includes("-nu")) {
                _grendId = 2;
                _nameGrend = "Nữ";
            }
            // lấy số cuối cùng trong chuỗi
            var urlParam = urlPath.split("-");

            var checkNumber = /\d/;

            if (checkNumber.test(urlParam)) {

                var _year_buy_build = urlParam[urlParam.length - 1];

                if (url.indexOf("nu") >= 0 || url.indexOf("nam") >= 0) {

                    $(".content-default").css("display", "none");

                    $(".result").css("display", "block");

                    $("#year option:selected").text(_year_buy_build);

                    $("#gender option[value=" + _grendId + "]").prop('selected', true);

                    Calculate(_year_buy_build, _grendId, "");
                }
                else {

                    var _year_birth = urlParam[urlParam.length - 2];

                    $("#year option:selected").text(_year_birth);

                    $(".content-default").css("display", "none");

                    $(".result").css("display", "block");

                    $(".select-year option:selected").text(_year_buy_build);

                    Calculate(_year_birth, _grendId, _year_buy_build);
                }
            }
        }

        function OwlCarousel() {
            $('.specialist-carousel').owlCarousel({
                margin: 32,
                loop: false,
                items: 4,
                dots: false,
                autoplay: true,
                autoplayTimeout: 30000,
                lazyLoad: true,
                responsive: {
                    0: {
                        items: 1,
                        //loop: true
                    },
                    480: {
                        items: 2
                    },
                    920: {
                        items: 3,
                        autoWidth: false,
                        margin: 10
                    },
                    1025: {
                        items: 4,
                        autoWidth: false,
                    }
                }
            });
        }
		})(jQuery);
    </script>

<?php get_footer(); ?>