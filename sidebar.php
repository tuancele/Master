<div class="col-md-3 section2-right hidden-xs hidden-sm">

    <p class="bground_phone"> <a class="phone_line" href="tel:<?php the_field('cele_hotline','option') ?>"> <?php _e('CALL NOW :','master-gf') ?><?php the_field('cele_hotline','option') ?></a></p>

<?php if(get_field('banner_sidebar',pll_current_language('slug'))): ?>

    <div class="cele-banner clearfix">

        <?php while(has_sub_field('banner_sidebar',pll_current_language('slug'))): ?>

       <a href="<?php the_sub_field('link1'); ?>"><img src="<?php the_sub_field('img1'); ?>" alt=""></a>

       <?php endwhile; ?>

    </div>

<?php endif; ?>

    <div class="deal_content_right kobo deal_ct_sp_v2">

    <div class="menu-sidebar clearfix">

         <?php wp_nav_menu(array( 'theme_location'=> 'sidebar-menu','menu_class' => 'menu')); ?>

    </div>

    </div>

    <?php $a = get_field('cele_sidebar_post',pll_current_language('slug')); 

    if ($a) {

     ?>

    





    <div class="list-new-index">

        <div class="title-list-new-index h3"><?php _e('Blog','master-gf') ?></div>

        <div class="box-content">

            <?php   $args = array (

            'cat'               => $a,

            'paged'                  => '1',

            'posts_per_page'         => '5',

            );

            // The Query

            $query = new WP_Query( $args );

            // The Loop

            if ( $query->have_posts() ) {

            while ( $query->have_posts() ) {

            $query->the_post();

            ?>

            <div class="media">

                <a class="media-left" href="<?php the_permalink(); ?>" target="_blank" >

                    <?php the_post_thumbnail('thumbnail', array('class' => 'attachment-img_sidebar size-img_sidebar','title' => get_the_title(),'alt'   => get_the_title())); ?>

                </a>

                <div class="media-body">

                    <a class="media-heading" href="<?php the_permalink(); ?>" target="_blank">

                    <?php the_title(); ?></a>

                </div>

            </div>

            <?php

            } }  wp_reset_postdata();       ?>

        </div>

    </div>

<?php } ?>

    <div class="dowload-last " id="dowload-last-link">
  <form id="cele-form-sidebar" class="cele-form-sidebar form-download1" action="<?php the_field('cele_returnurl','option') ?>" method="POST">
    <?php wp_nonce_field('celeform','human',false); ?>
    <input name="Cele" value="mastergf-float" type="hidden">
    <input name="Website" value="<?php the_permalink(); ?>" type="hidden">

    <div class="box-heading">
      <p class="title-dowload-last">
        <?php _e('Detailed consultation','master-gf') ?> <br> <?php bloginfo('name'); ?>
      </p>
    </div>

    <p><?php _e("Commit not to reveal the Customer's information...",'master-gf') ?></p>

    
    <div class="celename">
      <input
        id="name-downow"
        class="form-control"
        name="Name"
        aria-label="Name"
        type="text"
        placeholder="<?php _e('Full name','master-gf') ?>"
      >
    </div>

    <div class="celeemail">
      <input
        id="email-downow"
        class="form-control"
        name="Email"
        aria-label="Email"
        type="text"
        placeholder="<?php _e('Email','master-gf') ?>"
      >
    </div>

    
    <div class="celephone">
      <input
        id="phone-downow"
        class="form-control"
        name="Mobile"
        type="number"
        aria-label="Mobile"
        placeholder="<?php _e('Phone number','master-gf') ?>"
        required=""
      >
    </div>

   
    <input
      id="link-dow-now"
      class="dow-now"
      aria-label="Submit"
      name="dangky"
      onclick="Submit_Form('sidebar','noname')"
      type="button"
      value="<?php _e('Send','master-gf') ?>"
    >
  </form>
</div>


</div>