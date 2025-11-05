<?php 
if(!wp_is_mobile() && !cele_is_amp()) 
    get_template_part('template-part/section3'); 
    get_template_part('template-part/section4'); ?>

<?php get_template_part('template-part/section5');?>

<?php
if(!cele_is_amp()) { ?>


<?php } else {?>
    <?php get_template_part('template-part/section6');?>


<?php } ?>

    </div>
</div>
<div class="footer">
    <div class="new_footer_top">
        <div class="container">
            <div class="row">

                <div class="col-md-3">
                    <div class="textwidget">
                        <?php the_field('thong_tin_ft1',pll_current_language('slug')); ?>
                    </div>
                </div>
                <?php $rows=get_field( 'menu_ft1', pll_current_language('slug')); if($rows) ?>       
                <?php { ?>
                <?php foreach($rows as $row) { ?>
                <div class="col-md-3 pl_70">
                    <div class="title_footer h3"><?php echo  $row['title'] ?></div>
                    <div class="menu-footer">
                        <?php echo  $row['content'] ?>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </div>
        <div class="footer_bg">
            <div class="footer_bg_one"></div>
            <div class="footer_bg_two"></div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-7">
                    <p>© <?php bloginfo('title'); ?> <?php echo date("Y"); ?> Mọi quyền được bảo lưu.</p>
                </div>
                <div class="col-lg-6 col-sm-5 text-right">
                    <p>Copyright © 2001–<?php echo date("Y"); ?> F10, Inc.&nbsp; <svg class="svg-icon" viewBox="0 0 20 20">
                            <path d="M9.719,17.073l-6.562-6.51c-0.27-0.268-0.504-0.567-0.696-0.888C1.385,7.89,1.67,5.613,3.155,4.14c0.864-0.856,2.012-1.329,3.233-1.329c1.924,0,3.115,1.12,3.612,1.752c0.499-0.634,1.689-1.752,3.612-1.752c1.221,0,2.369,0.472,3.233,1.329c1.484,1.473,1.771,3.75,0.693,5.537c-0.19,0.32-0.425,0.618-0.695,0.887l-6.562,6.51C10.125,17.229,9.875,17.229,9.719,17.073 M6.388,3.61C5.379,3.61,4.431,4,3.717,4.707C2.495,5.92,2.259,7.794,3.145,9.265c0.158,0.265,0.351,0.51,0.574,0.731L10,16.228l6.281-6.232c0.224-0.221,0.416-0.466,0.573-0.729c0.887-1.472,0.651-3.346-0.571-4.56C15.57,4,14.621,3.61,13.612,3.61c-1.43,0-2.639,0.786-3.268,1.863c-0.154,0.264-0.536,0.264-0.69,0C9.029,4.397,7.82,3.61,6.388,3.61"></path>
                        </svg></i>&nbsp;&nbsp; <a href="<?php bloginfo('home'); ?>"><?php bloginfo('title'); ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php if(!cele_is_amp()) { ?>
<div class="support-online">
    <div class="support-content">
        <a href="tel:<?php the_field('cele_hotline','option')?>" class="call-now" rel="nofollow">
            <svg><use xlink:href="#phone-receiver"></use></svg>
            <div class="animated infinite zoomIn kenit-alo-circle"></div>
            <div class="animated infinite pulse kenit-alo-circle-fill"></div>
            <span>Hotline: <?php the_field('cele_hotline','option')?></span>
        </a>
        <a class="dowload-now" data-toggle="modal" data-target="#myModal2">
            <svg><use xlink:href="#cloud-download"></use></svg>
            <span><?php _e('Download latest price','master-gf') ?></span>
        </a>
        <a class="mes" href="<?php the_field('cele_hoidap',pll_current_language('slug'))?>">
            <svg><use xlink:href="#chat"></use></svg>
            <span><?php _e('Q&A','master-gf') ?></span>
        </a>
    </div>
</div>

<div class="tai-bang-gia"><a href="#section4-id"><?php _e('Get quotation','master-gf') ?></a></div>
<div class="hotline-footer">
    <a href="tel:<?php if ( get_field( 'hotline_rv' ) ): ?><?php the_field('hotline_rv')?><?php else: ?><?php the_field('cele_hotline','option')?><?php endif; ?>" class="call-now">
        <svg><use xlink:href="#phone-receiver"></use></svg>
        <?php if ( get_field( 'hotline_rv' ) ): ?><?php the_field('hotline_rv')?><?php else: ?><?php the_field('cele_hotline','option')?><?php endif; ?>
    </a>
</div>
<?php } ?>

<div class="adv-bottom" style="z-index: 999">
    <ul>
        <li><a href="tel:<?php if ( get_field( 'hotline_rv' ) ): ?><?php the_field('hotline_rv')?><?php else: ?><?php the_field('cele_hotline','option')?><?php endif; ?>"><?php _e('call now','master-gf') ?></a></li>
        <li><a  <?php if(cele_is_amp()) { echo 'on="tap:my-lightbox"'; } else { echo 'href="#"';} ?> class="btn-res2" data-toggle="modal" data-target="#myModal2"><?php _e('Get quotation','master-gf') ?></a></li>
    </ul>
</div>

<?php
if(!cele_is_amp()) { 
    get_template_part('template-part/modal');     
} else { ?>
    <amp-lightbox id="my-lightbox"
  layout="nodisplay">
  <div class="overlay active modal-adv">

    <div class="modal-dialog">
        <button type="button" class="close" on="tap:my-lightbox.close"><svg><use xlink:href="#close"></use></svg></button>
    <div class="modal-content">
            <div class="dowload-last">
                <form class="form-download2 cele-form-modal" method="POST" action-xhr='<?php echo admin_url('admin-ajax.php?action=amp_formfooter_submit'); ?>'>
                    <input name="Human" value="7ba90e90ed" type="hidden">
                    <input name="Cele" value="mastergf-modal-right" type="hidden">
                    <input name="link" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" type="hidden">
                    <div class="box-heading">
                        <p class="title-dowload-last"><?php _e('House quotation','master-gf') ?> <br> <?php bloginfo('name'); ?>
                    </div>
                    <p><?php _e('Please fill in full and correct information. All information shall be absolutely protected','master-gf') ?></p>
                    <div class="dowload-last-input1-modal celename"><input class="form-control" id="name-downow-modal" aria-label="Name" name="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>" ></div>
                    <div class="dowload-last-input2-modal celeemail"><input class="form-control" id="email-downow-modal" aria-label="Email" name="Email" type="text" placeholder="<?php _e('Email','master-gf') ?>" ></div>
                    <div class="dowload-last-input3-modal celephone"><input class="form-control" id="phone-downow-modal" aria-label="Mobile" name="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" ></div>
                    <input id="link-dow-now-modal" class="dow-now" name="dangky" type="submit" aria-label="Submit" value="<?php _e('Register','master-gf') ?>">
                    <div submitting>
            
                    <div id="quote-lb" class="overlay1">
                        <div class="loading_ajax">
                        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                        </div>
                    </div>
    
                    </div>
                    <div submit-error>
          <template type="amp-mustache">
                        {{data}}
                    </template></div>
                </form>
            </div>
        </div>
  </div>
    </div>
</amp-lightbox>
<?php }
?>

<?php
if(!cele_is_amp()) { ?>
<div id="menu1">
    <?php html5blank_nav(); ?> 
</div>
<?php } else {?>

<?php }?>
<?php the_field('cele_footer','option'); ?>

<?php wp_footer(); ?>

<?php // --- CÁC SCRIPT THỦ CÔNG ĐÃ BỊ XÓA --- ?>
<?php // <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/product-project-detail.min.js"></script> ?>
<?php // <script type="text/javascript" src="<?php bloginfo('template_url' ); ?>/js/jquery.mmenu.js"></script> ?>

<?php if(!cele_is_amp()) { ?>
<?php if( get_field('khpp','option') ): ?>
<div class="modal-adv ">
    <div id="myModal3" class="modal fade" role="dialog">
        <div class="modal-dialog" <?php if( get_field('crf','option') ): ?> style="width: <?php the_field('crf','option')?><?php endif; ?>">
        <button type="button" class="close" data-dismiss="modal"><svg><use xlink:href="#close"></svg></button>
        <div class="modal-content">
            <div class="dowload-last">
    <form class="form-lichmoban-while cele-form-while">
        <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
        <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
        <div id="sc6-while">
            
            <?php if( get_field('banner','option') ): ?>
                <div class="banner">
                    <img src="<?php the_field('banner','option')?>" alt="banner">
                </div>
            <?php endif; ?>
            
            <div class="mg">
                <div class="box-heading">
                    <p class="title-dowload-last"><?php the_field('tdf','option')?></p>
                </div>

                
                <div class="input-vag1 celename" style="margin-bottom: 17px;">
                    <input
                        class="form-control"
                        id="name-modal-while"
                        name="Name"
                        aria-label="Name"
                        type="text"
                        placeholder="<?php _e('Full name','master-gf') ?>"
                    >
                </div>

                
                <div class="input-vag2 celeemail" style="margin-bottom: 17px;">
                    <input
                        class="form-control"
                        id="email-modal-while"
                        name="Email"
                        aria-label="Email"
                        type="email"
                        placeholder="<?php _e('Email','master-gf') ?>"
                    >
                </div>

                
                <div class="input-vag3 celephone" style="margin-bottom: 17px;">
                    <input
                        class="form-control"
                        id="phone-modal-while"
                        name="Mobile"
                        aria-label="Mobile"
                        type="number"
                        placeholder="<?php _e('Phone number','master-gf') ?>"
                        required=""
                    >
                </div>

                
                <input
                    id="link-modal-while"
                    class="dow-now"
                    name="dangky"
                    type="button"
                    aria-label="Submit"
                    onclick="Submit_Form('while','noname')"
                    value="<?php _e('Register','master-gf') ?>"
                >
            </div>
        </div>
    </form>
</div>

            </div>
        </div>
    </div>
</div>
<?php // --- SCRIPT THỦ CÔNG ĐÃ BỊ XÓA --- ?>
<?php // <script type='text/javascript' src='<?php bloginfo('template_url' ); ?>/js/js.cookie.min.js'></script> ?>
<?php endif; ?>

<?php }?>
<?php if( get_field('login_of','option') ): ?>
<?php if(wp_is_mobile()){?>
<div class="login-pc mobile-login clearfix">
    <ul>
        <li class="post"><a target="_blank" href="<?php bloginfo('home')?>/wp-login.php"><img src="<?php bloginfo('template_url'); ?>/images/plus.png" alt=""> Đăng tin rao</a></li>
        <li class="acc"><a target="_blank" href="<?php bloginfo('home')?>/wp-login.php?action=register"><img src="<?php bloginfo('template_url'); ?>/images/register.png" alt=""> Đăng ký</a></li>
        <li class="acc"><a target="_blank" href="<?php bloginfo('home')?>/wp-login.php"><img src="<?php bloginfo('template_url'); ?>/images/login.png" alt=""> Đăng nhập</a></li>
    </ul>
</div>
<?php }?>
<?php endif; ?>
<?php if( get_field('id_uc_chat','option') ): ?>
    
<?php endif; ?>
<?php if(!wp_is_mobile() ) { ?>
    <?php if(get_field('cele_page_id','option')) { ?>
        <div class="fb-customerchat"
          attribution="setup_tool"
          minimized="true"
          size="standard"
          page_id="<?php the_field('cele_page_id','option') ?>">
        </div>
    <?php } ?>
<?php if(get_field('cele_fake','option')) { ?>
<script type="text/javascript">
    /////////
    jQuery(document).ready(function(){
        setInterval(function(){
            jQuery.ajax({
             type: "POST",
             data: {
                      action : 'list_order',
                      },
             url: '<?php echo admin_url('admin-ajax.php'); ?>',
             success: function(message, status, xhr) {
               jQuery('.list_order').html(message).closest('.odder_dich_vu').fadeIn(200).delay(3500).fadeOut();
             },              
            });
        }, 30000);
    });
</script>
<?php } ?>
<?php } else { ?>
<div class="box_zalo"> <a href="http://zalo.me/<?php the_field('cele_zalo_id','option')?>" target="_blank" rel="noreferrer"> <img src="<?php bloginfo('template_url'); ?>/images/zalo-sms.png" alt="zalo-chat"> </a></div>
        <style>
        </style>
<?php } ?>
<div class="overlay">
    <div class="loading_ajax">
        <svg class="icon">
            <use xlink:href="#loading"></use>
        </svg>
    </div>
</div>
<?php if(get_field('cele_page_id','option')) { ?>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div id="fb-root"></div>
<?php } ?>

<style>
    .mm-slideout{z-index: initial;}
</style>
</body>
</html>