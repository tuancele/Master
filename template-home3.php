<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
        <link href="//www.google-analytics.com" rel="dns-prefetch">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!-- wrapper -->
        <div class="wrapper">
        
            <div class="odder_dich_vu">
                <ul class="list_order"></ul>
            </div>
            <!-- popuptest -->
            <!-- header -->
            <?php 
    do_action('cele_before_header');
    the_field('cele_body','option'); ?>

    
            <header>
                <?php if(wp_is_mobile()){?>
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
                <?php }?>
                
                <div class="nav-header hidden-xs hidden-sm affix  affixs">
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
<?php /* Template Name: Homepage Template 3 */ ?>


<?php $rows=get_field( 'sliders'); if($rows) ?>        
<?php { ?>
<div class="slider-home-3 owl-carousel">
	<?php foreach($rows as $row) { ?>
  	<div class="item clearfix">
    	<a href="<?php echo  $row['link'] ?>"><img src="<?php echo  $row['img'] ?>"></a>
	    <div class="text">
	    	<div class="inner-text">
				<h3><?php echo  $row['text'] ?></h3>
				<a href="#" class="viewmore-link">
					<span class="viewmore-line"></span>
					<span class="viewmore-text">Xem thêm</span>
				</a>
			</div>
	    </div> 
  	</div>
  	<?php } ?>  
</div>
<?php } ?>    

<section class="home-intro">
	<?php $chas = get_field('gioi_thieus');
	if($chas) { ?>
	<?php foreach ($chas as $cha) { ?>
    <div class="container">
        <div class="section-header">
            <h3><?php echo $cha['title'];  ?></h3>
            <p class="desc"><?php echo $cha['text'];  ?></p>
        </div>
        <div class="section-content">
            <div class="image">
                <div class="swiper-container " id="home-intro-slider">
                    <div class="swiper-wrapper slider_intro owl-carousel">
                    	 <?php
					    if($cha['list']) {
					    foreach ($cha['list'] as $con) { ?>
                        <div class="swiper-slide ">
                            <a href="<?php echo $con['link'];  ?>" title=""><img src="<?php echo $con['img'];  ?>" alt="">
                            </a>
                        </div>
                        <?php }} ?>
                    </div>
                    <div class="swiper-pagination">&nbsp;</div>
                </div>
            </div>
            <div class="text">
                <?php echo $cha['content'];  ?>
                <a class="viewmore-link colored-viewmore" href="<?php echo $cha['link'];  ?>" style="transition-duration: .5s">
                	<i class="viewmore-line" style="transition-duration: .5s"></i>
                	<span class="viewmore-text">Tìm hiểu thêm</span> 
                </a>
            </div>
        </div>
    </div>
	<?php }} ?>
</section>
<section class="home-awards">
	
    <div class="container">
        <div class="section-header">
            <h3>Giải thưởng</h3>
        </div>
    </div>
    <?php
  $term = get_field('giai_thuongs');
  if(( $term )): ?>
    <div class="section-content">
        <div class="container">
            <div class="swiper-container" id="home-awards-slider">
                <div class="swiper-wrapper slider_awards owl-carousel">
                	<?php       $args=array(
      'cat' => $term,
      'posts_per_page'=> 5, 
     'orderby' => 'ID',
          'order' => 'DESC'
      );
      $postnew = new wp_query( $args );
      if( $postnew->have_posts() ) {
      while( $postnew->have_posts() ) {
      $postnew->the_post(); ?>
                    <div class="swiper-slide">
                        <div class="item">
                            <p class="year"><span><?php the_time('Y') ?>    </span>
                            </p>
                            <div class="image" style="">
                                <a href="<?php the_permalink()?>" class="border-wrap-container" style="transition-duration: .5s;"><?php the_post_thumbnail();?>
                                    <div class="hover-block"><i class="fa fa-search" aria-hidden="true"></i>
                                    </div>
                                    <div class="border-wrap">
                                        <div class="border top">
                                            <div></div>
                                        </div>
                                        <div class="border right">
                                            <div></div>
                                        </div>
                                        <div class="border bottom">
                                            <div></div>
                                        </div>
                                        <div class="border left">
                                            <div></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="text">
                                <h3 class="title"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>
                                <p class="time"> <i class="fa fa-clock-o" aria-hidden="true"></i><?php the_time('m/Y') ?>    </p>
                            </div>
                        </div>
                    </div>
                    <?php }  }wp_reset_postdata() ;?>
                </div>
            </div>
        </div>
    </div>
     <?php endif; ?>
</section>
 <section class="home-projects">
 	<?php $chas = get_field('dsdas');
	if($chas) { ?>
	<?php foreach ($chas as $cha) { ?>
    <div class="container">
        <div class="section-header">
            <h3><?php echo $cha['title'];  ?></h3>
        </div>
        <div class="section-content">
        	<?php
            if($cha['list']) {
            foreach ($cha['list'] as $con) { ?>
            <div class="item video" style="background-image: url('<?php echo $con['background']; ?>');">
                <video class="thevideo" loop="" preload="none">
                    <source src="<?php echo $con['link_video']; ?>" type="video/mp4">
                </video>
                <div class="video-btn video-pause-btn"><i class="fa fa-pause-circle-o video-pause-btn"></i>
                </div>
                <div class="video-btn video-play-btn"><i class="fa fa-play-circle-o video-play-btn"></i>
                </div>
                <div class="text" style="transition-duration: .5s;">
                    <div class="title"><span><?php echo $con['title']; ?></span>
                    </div><a href="<?php echo $con['link']; ?>" class="view-more viewmore-line"><span>Xem thêm</span></a>
                </div>
            </div>
        <?php }  }wp_reset_postdata() ;?>
        </div>
    </div>
     <?php }  }wp_reset_postdata() ;?>
</section>
<section class="home-story">
	<?php $rows=get_field( 'tam_nhins'); if($rows) ?>        
	<?php { ?>
		<?php foreach($rows as $row) { ?>
    <div class="container">
        <div class="section-header">
            <h3 class="bordered-title"><?php echo  $row['title'] ?>P</h3>
            <p><?php echo  $row['text'] ?></p>
        </div>
    </div>
    <?php }  }wp_reset_postdata() ;?> 
</section>
<section class="home-news">
    <div class="container">
          <?php
          $term = get_field('su_kiens');
          if(( $term )): ?>
        <div class="home-events-block">
            <h3 class="block-title">SỰ KIỆN NỔI BẬT</h3>
            <div class="home-events-block-inner">
                <div class="swiper-container" id="home-events-slider">
                    <div class="swiper-wrapper slider_events owl-carousel">
                   <?php       $args=array(
                  'cat' => $term,
                  'posts_per_page'=> 2, 
                 'orderby' => 'ID',
                      'order' => 'DESC'
                  );
                  $postnew = new wp_query( $args );
                  if( $postnew->have_posts() ) {
                  while( $postnew->have_posts() ) {
                  $postnew->the_post(); ?>
                        <div class="swiper-slide">
                            <div class="item">
                                <div class="image">
                                    <a href="<?php the_permalink()?>" class="border-wrap-container" style="transition-duration: .5s;">
                                        <div class="hover-block"><i class="fa fa-search"></i>
                                            <p>Xem thêm</p>
                                        </div>
                                        <?php the_post_thumbnail();?>
                                        <div class="border-wrap">
                                            <div class="border top">
                                                <div></div>
                                            </div>
                                            <div class="border right">
                                                <div></div>
                                            </div>
                                            <div class="border bottom">
                                                <div></div>
                                            </div>
                                            <div class="border left">
                                                <div></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="text">
                                    <h3 class="title">
                                    	<a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h3>
                                    <p class="time"><i class="fa fa-clock-o"></i>
                                        <time class="time-ago" data-format="date" datetime=""><?php the_time('d/m/Y') ?>  </time>
                                    </p>
                                    <p><?php echo wp_trim_words( get_the_content(), 50, '...' ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="viewmore-link colored-viewmore" style="transition-duration: .5s">
	                                    <span class="viewmore-line" style="transition-duration: .5s">
	                                    </span><span class="viewmore-text">Xem thêm</span>
	                                </a>
                                </div>
                            </div>
                        </div>
                       <?php }  }wp_reset_postdata() ;?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
  <?php endif; ?>
    		<?php
          $term = get_field('tts');
          if(( $term )): ?>
	        <div class="home-news-block">
	            <h3 class="block-title">TIN TỨC & BÀI VIẾT</h3>
	             <?php       $args=array(
                  'cat' => $term,
                  'posts_per_page'=> 3, 
                 'orderby' => 'ID',
                      'order' => 'DESC'
                  );
                  $postnew = new wp_query( $args );
                  if( $postnew->have_posts() ) {
                  while( $postnew->have_posts() ) {
                  $postnew->the_post(); ?>
	            <div class="item">
	                <div class="image" style="background-image: url('');">
	                    <a href="<?php the_permalink()?>" class="border-wrap-container" style="transition-duration: .5s;"><?php the_post_thumbnail();?>
	                        <div class="hover-block"><i class="fa fa-search"></i>
	                        </div>
	                        <div class="border-wrap">
	                            <div class="border top">
	                                <div></div>
	                            </div>
	                            <div class="border right">
	                                <div></div>
	                            </div>
	                            <div class="border bottom">
	                                <div></div>
	                            </div>
	                            <div class="border left">
	                                <div></div>
	                            </div>
	                        </div>
	                    </a>
	                </div>
	                <div class="text">
	                    <h4 class="title except-1"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h4>
	                    <p class="time"><i class="fa fa-clock-o"></i>
	                        <time class="time-ago" data-format="date" datetime=""><?php the_time('d/m/Y') ?>  </time>
	                    </p>
	                    <p><?php echo wp_trim_words( get_the_content(), 30, '...' ); ?></p>
	                    <a href="<?php the_permalink(); ?>" class="viewmore-link colored-viewmore" style="transition-duration: .5s"><span class="viewmore-line" style="transition-duration: .5s"></span><span class="viewmore-text">Xem thêm</span></a>
	                </div>
	            </div>
	            <?php }  }wp_reset_postdata() ;?>
	        </div>
	        <?php endif; ?>

    </div>
</section>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/owl.carousel.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/stylehome3.css">
<?php $rows=get_field( 'question1'); if($rows) ?>
<?php { ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
  <?php foreach($rows as $row) { ?>
  {
    "@type": "Question",
    "name": "<?php echo  $row['name'] ?>",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "<?php echo  $row['content'] ?>"
    }
  }<?php echo  $row['s'] ?>
  <?php } ?>
  ]
}
</script>
<?php } ?>

<?php get_footer(); ?>