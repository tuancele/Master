<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
        <link href="//www.google-analytics.com" rel="dns-prefetch">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="<?php bloginfo('description'); ?>">
        <link rel="preconnect" href="https://facebook.com">

        <?php wp_head(); ?>

        <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
        <meta name="msvalidate.01" content="EB735DEE34576326AE7FE693E23DB329" />
    <meta name='dmca-site-verification' content='R3NDbWlYSFZqbHJXWjVJZUZia2cyYVlRbHcrd21aaDFNYVBzczhSTUVPaz01' />

    </head>
    <?php get_template_part('template-part/svg'); ?>
    <body <?php body_class(); ?>>
        
    <?php do_action('cele_before_wrapper'); ?>
        <div class="wrapper">
        
            <div class="odder_dich_vu">
                <ul class="list_order"></ul>
            </div>
            <?php 
    do_action('cele_before_header');
    echo get_field('cele_body','option'); ?>

    
            <header>
                <div class="header-top" id="top">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 menumb visible-sm visible-xs">
                                <?php if(!cele_is_amp()) { ?>
                                <a href="#menu1" title="Mobile menu"><span></span></a>
                                <?php } else { ?>
                                    <a on="tap:sidebar.toggle" title="Mobile menu"><span></span></a>
                                <?php } ?>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6 logo">          
                                <a href="<?php echo home_url(); ?>">
                                    <?php cele_logo();  ?>
                                </a>
                            </div>
                            <div class="col-md-4 ul-header hidden-sm hidden-xs">
                                <div class="pro-po clearfix">
                                <ul>
                                    <li>
                                        <a href="/">#KHU ĐÔ THỊ</a>
                                    </li>
                                    <li>
                                        <a href="/">#FLC QUẢNG NGÃI</a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-4 ">
                                <div class="header-right">
                                    <div class="modal-ntvr">
                                        <button type="button" class="form-control hidden-xs btn-nhantuvanrieng" data-toggle="modal" data-target="#nhantuvanrieng"><?php _e('PRIVATE COUNSELING','master-gf') ?></button>
                                        <?php echo changeLang(); ?>
                                        
                                    </div>
                                </div>
                                <?php if( get_field('login_of','option') ): ?>
                                <div class="login-pc clearfix">
                                    <ul>
                                        <li class="post"><a target="_blank" href="<?php bloginfo('home')?>/wp-login.php"><img src="<?php bloginfo('template_url'); ?>/images/plus.png" alt=""> Đăng tin rao</a></li>
                                        <li class="acc"><a target="_blank" href="<?php bloginfo('home')?>/wp-login.php?action=register"><img src="<?php bloginfo('template_url'); ?>/images/register.png" alt=""> Đăng ký</a></li>
                                        <li class="acc"><a target="_blank" href="<?php bloginfo('home')?>/wp-login.php"><img src="<?php bloginfo('template_url'); ?>/images/login.png" alt=""> Đăng nhập</a></li>
                                    </ul>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="banner hidden-xs">
                    <div class="container">
                        <div class="clearfix">
                            <a href="<?php the_field('cele_link_banner',pll_current_language('slug')); ?>">
                                <?php if(!cele_is_amp()) { ?>
                                    <img <?php echo awesome_acf_responsive_image(get_field( 'cele_banner', pll_current_language('slug') ),'full','1170px'); ?> title="<?php bloginfo('description'); ?>" alt="<?php bloginfo('description'); ?>" class="img-responsive">
                                <?php } else { ?>
                                    <amp-img <?php echo awesome_acf_responsive_image(get_field( 'cele_banner', pll_current_language('slug') ),'full','1170px'); ?> title="<?php bloginfo('description'); ?>" alt="<?php bloginfo('description'); ?>" layout="fill">
                                <?php } ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nav-header hidden-xs hidden-sm">
                    <div class="container">
                        <div class="clearfix">
                            <div class="navbar" role="navigation">
                                <div class="navbar-collapse collapse" id="navbar-collapse-1">
                                    <div class="menu-menu_header-container">
                                            <?php html5blank_nav(); ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <amp-position-observer on="enter:hideAnim.start; exit:showAnim.start"
                    layout="nodisplay">
                </amp-position-observer>
            </header>
            <div class="zone-content full-section">
                <div class="content-bb">
                
                <amp-animation id="showAnim"
  layout="nodisplay">
  <script type="application/json">
    {
      "duration": "200ms",
      "fill": "both",
      "iterations": "1",
      "direction": "alternate",
      "animations": [{
        "selector": ".back-to-top",
        "keyframes": [{
          "opacity": "1",
          "visibility": "visible"
        }]
      }]
    }
  </script>
</amp-animation>
<amp-animation id="hideAnim"
  layout="nodisplay">
  <script type="application/json">
    {
      "duration": "200ms",
      "fill": "both",
      "iterations": "1",
      "direction": "alternate",
      "animations": [{
        "selector": ".back-to-top",
        "keyframes": [{
          "opacity": "0",
          "visibility": "hidden"
        }]
      }]
    }
  </script>
</amp-animation>