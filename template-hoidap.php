<?php /* Template Name: Hỏi đáp */ get_header(); ?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="section2">
    <div class="container project">
        <div class="clearfix">
            <?php
            if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb('
            <p id="breadcrumbs">','</p>
            ');
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="example content-post-pro term-description"  data-mrc="">
          <?php the_content();?>
        </div>
        
        <script type="text/javascript" src="<?php bloginfo('template_url' ); ?>/js/jquery.morecontent.js"></script>
        <script type="text/javascript" src="<?php bloginfo('template_url' ); ?>/js/demo.js"></script>
    </div>
    
    <div class="product-bg project clearfix">
        <div class="container">

            <?php
if(!cele_is_amp()) { ?>



            <?php if(!wp_is_mobile()){?>

            <?php if( have_rows('danh_sach_bds') ): ?>
            <?php  while( have_rows('danh_sach_bds') ): the_row(); ?>
            <div class="section-homepage"><h2><?php the_sub_field('title'); ?></h2></div>
            <?php   if( have_rows('cac_du_an') ): ?>
            <div class="row project-carousel list-post">
                <?php  while( have_rows('cac_du_an') ): the_row(); ?>
                <div class="col-md-3 new-list">
                    <div class="item color-red">
                        <div class="thumb-image">
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                <img class="lazy" src="<?php the_sub_field('img'); ?>">
                                <div class="bg-opacity"></div>
                            </a>
                            <div class="status dangban">
                                <span class="icon"></span>
                                <span><?php the_sub_field('bangiao'); ?></span>
                            </div>
                        </div>
                        <div class="info">
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                <h2 class="name"><?php the_sub_field('title'); ?> </h2>
                            </a>
                            <div class="address"><?php the_sub_field('diachi'); ?></div>
                        </div>
                        <div class="project-price">
                            <div class="price">
                                <span><?php the_sub_field('gia'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>

            <?php   if( have_rows('cac_cau_hoi') ): ?>
            <div class="accordion">
                  <ul class="accordion__list">
                    <?php  while( have_rows('cac_cau_hoi') ): the_row(); ?>
                    <li class="accordion__item">
                      <div class="accordion__itemTitleWrap">
                        <h3 class="accordion__itemTitle"><?php the_sub_field('name'); ?></h3>
                        <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div>
                      </div>
                      <div class="accordion__itemContent">
                            <?php the_sub_field('content'); ?>
                      </div>
                    </li>
                    <?php endwhile; ?>
                  </ul>
                </div>
             <?php endif; ?>
            <?php endwhile; ?>
            <?php endif; ?>

            <?php
            }
            else
            { ?>

            <?php if( have_rows('danh_sach_bds') ): ?>

            <?php  while( have_rows('danh_sach_bds') ): the_row(); ?>
            <div class="section-homepage"><h2><?php the_sub_field('title'); ?></h2></div>
            <?php   if( have_rows('cac_du_an') ): ?>
            <div class="project-carousel owl-carousel mobiles list-post">
                <?php  while( have_rows('cac_du_an') ): the_row(); ?>
                <div class="new-list item-pro">
                    <div class="item color-red">
                        <div class="thumb-image">
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                <img class="lazy" src="<?php the_sub_field('img'); ?>">
                                <div class="bg-opacity"></div>
                            </a>
                            <div class="distance"><span class="ic-distance"></span> <span class="number"><?php the_sub_field('km'); ?></span></div>
                            <div class="status dangban">
                                <span class="icon"></span>
                                <span><?php the_sub_field('bangiao'); ?></span>
                            </div>
                        </div>
                        <div class="info">
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                <h2 class="name"><?php the_sub_field('title'); ?> </h2>
                            </a>
                            <div class="address"><?php the_sub_field('diachi'); ?></div>
                        </div>
                        <div class="project-price">
                            <div class="price">
                                <span><?php the_sub_field('gia'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            <?php   if( have_rows('cac_cau_hoi') ): ?>
            <div class="accordion">
                  <ul class="accordion__list">
                    <?php  while( have_rows('cac_cau_hoi') ): the_row(); ?>
                    <li class="accordion__item">
                      <div class="accordion__itemTitleWrap">
                        <h3 class="accordion__itemTitle"><?php the_sub_field('name'); ?></h3>
                        <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div>
                      </div>
                      <div class="accordion__itemContent">
                            <?php the_sub_field('content'); ?>
                      </div>
                    </li>
                    <?php endwhile; ?>
                  </ul>
                </div>
             <?php endif; ?>

            <?php endwhile; ?>
            <?php endif; ?>
            <?php } ?>

            <?php } else {?>

            
                

            <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.2.js"></script>
            <?php if( have_rows('danh_sach_bds') ): ?>

            <?php  while( have_rows('danh_sach_bds') ): the_row(); ?>
            <div class="section-homepage"><h2><?php the_sub_field('title'); ?></h2></div>
            <?php   if( have_rows('cac_du_an') ): ?>
            <amp-carousel class="list-post project-carousel" height="300"
  layout="fixed-height"
  type="slides">
                <?php  while( have_rows('cac_du_an') ): the_row(); ?>
                <div class="new-list item-pro">
                    <div class="item color-red">
                        <div class="thumb-image">
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                <img class="lazy" src="<?php the_sub_field('img'); ?>">
                                <div class="bg-opacity"></div>
                            </a>
                            <div class="distance"><span class="ic-distance"></span> <span class="number"><?php the_sub_field('km'); ?></span></div>
                            <div class="status dangban">
                                <span class="icon"></span>
                                <span><?php the_sub_field('bangiao'); ?></span>
                            </div>
                        </div>
                        <div class="info">
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                <h2 class="name"><?php the_sub_field('title'); ?> </h2>
                            </a>
                            <div class="address"><?php the_sub_field('diachi'); ?></div>
                        </div>
                        <div class="project-price">
                            <div class="price">
                                <span><?php the_sub_field('gia'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </amp-carousel>
            <?php endif; ?>

            <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>

            <?php   if( have_rows('cac_cau_hoi') ): ?>
            <amp-accordion class="sample amp-list-faq accordion__list" animate>
                    <?php  while( have_rows('cac_cau_hoi') ): the_row(); ?>
                     <section class="accordion__item">
                      <h4 class="accordion__itemTitle"><?php the_sub_field('name'); ?> <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div></h4>
                    
                    <?php the_sub_field('content'); ?>
                 
                 
                    </section>
                    <?php endwhile; ?>
                  </amp-accordion>
             <?php endif; ?>

            <?php endwhile; ?>
            <?php endif; ?>


            <?php } ?>



   <?php
if(!cele_is_amp()) { ?>
            <?php if(!wp_is_mobile()){?>
              <?php
              $term = get_field('tin_tuc');
              if(( $term )): ?>
                          <div class="newsrooms clearfix">
                              <?php       $args=array(
                'cat' => $term,
                'posts_per_page'=> 6, 
               'orderby' => 'ID',
                    'order' => 'DESC'
                );
                $postnew = new wp_query( $args );
                if( $postnew->have_posts() ) {
                while( $postnew->have_posts() ) {
                $postnew->the_post(); ?>
                <article class="newsroom-w33 clearfix">
                  <div class="wrap-newsroom">
                    <div class="img">
                      <a href="<?php the_permalink();?>" class="link-hidden"></a>                      
                      <figure style="background-image: url('<?php the_post_thumbnail_url();?>')"></figure>
                    </div>
                    <div class="copy">
                      <div class="copy-header">
                          <span class="date"><?php the_time('d/m/Y')?></span>
                      </div>
                      <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                    </div>
                  </div>
                </article>
                <?php }  } wp_reset_postdata() ;?>
            </div>
            <?php endif; ?>

            <?php
            }
            else
            { ?>

              <?php
              $term = get_field('tin_tuc');
              if(( $term )): ?>

               
                          <div class="newsrooms newsrooms-mobile owl-carousel clearfix">
                              <?php       $args=array(
                'cat' => $term,
                'posts_per_page'=> 6, 
               'orderby' => 'ID',
                    'order' => 'DESC'
                );
                $postnew = new wp_query( $args );
                if( $postnew->have_posts() ) {
                while( $postnew->have_posts() ) {
                $postnew->the_post(); ?>
                <article class="newsroom-w33 clearfix">
                  <div class="wrap-newsroom">
                    <div class="img">
                      <a href="<?php the_permalink();?>" class="link-hidden"></a>                      
                      <figure style="background-image: url('<?php the_post_thumbnail_url();?>')"></figure>
                    </div>
                    <div class="copy">
                      <div class="copy-header">
                          <span class="date"><?php the_time('d/m/Y')?></span>
                      </div>
                      <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                    </div>
                  </div>
                </article>
                <?php }  } wp_reset_postdata() ;?>
            </div>
            <?php endif; ?>
            <?php } ?>


             <?php } else {?>

<?php
              $term = get_field('tin_tuc');
              if(( $term )): ?>

               
                          <amp-carousel class="newsrooms" height="300"
  layout="fixed-height"
  type="slides">
                              <?php       $args=array(
                'cat' => $term,
                'posts_per_page'=> 6, 
               'orderby' => 'ID',
                    'order' => 'DESC'
                );
                $postnew = new wp_query( $args );
                if( $postnew->have_posts() ) {
                while( $postnew->have_posts() ) {
                $postnew->the_post(); ?>
                <div class="newsroom-w33 clearfix">
                  <div class="wrap-newsroom">
                    <div class="img">
                      <a href="<?php the_permalink();?>" class="link-hidden"><img src="<?php the_post_thumbnail_url();?>" alt=""></a>                      
                      <figure style="background-image: url('')"></figure>
                    </div>
                    <div class="copy">
                      <div class="copy-header">
                          <span class="date"><?php the_time('d/m/Y')?></span>
                      </div>
                      <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                    </div>
                  </div>
                </div>
                <?php }  } wp_reset_postdata() ;?>
            </amp-carousel>
            <?php endif; ?>
            
            <?php }?>


        </div>
    </div>
    <?php
if(!cele_is_amp()) { ?>
    <div class="container">
      <?php get_template_part('laisuat'); ?>
      <?php comments_template(); ?>     
    </div>
    <?php } else {?>

    <?php }?>
</div>
<?php endwhile; ?>
<?php endif; ?>



<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
  <?php $chas = get_field('danh_sach_bds');
if($chas) { ?>
<?php foreach ($chas as $cha) { ?>
  <?php
    if($cha['cac_cau_hoi']) {
    foreach ($cha['cac_cau_hoi'] as $con) { ?>
  {
    "@type": "Question",
    "name": "<?php echo  $con['name'] ?>",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "<?php echo  $con['content'] ?>"
    }
  }<?php echo  $con['s'] ?>
  <?php }} ?>
  <?php } } ?> 
  ]
}
</script>
<?php get_footer(); ?>