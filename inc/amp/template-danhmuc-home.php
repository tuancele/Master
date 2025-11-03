<?php /* Template Name: Danh Mục Home */ get_header(); ?>
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
    <div class="product-bg project clearfix">
        <div class="container">
            <?php $rows=get_field( 'question1'); if($rows) ?>
                        <?php { ?>
                   
              <amp-accordion class="sample accordion__list" animate>
                <?php foreach($rows as $row) { ?>
                <section class="accordion__item">
                  
                    <h4 class="accordion__itemTitle"><?php echo  $row['name'] ?> <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div></h4>
                    
                 
                 <?php echo  $row['content'] ?>
                </section>
                <?php } ?>
              </amp-accordion>
            
            <?php } ?>

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
            <?php endwhile; ?>
            <?php endif; ?>


            <?php
              $term = get_field('tin_tuc');
              if(( $term )): ?>
                <amp-carousel class="newsrooms clearfix" height="300"
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
             </amp-carousel>
            <?php endif; ?>

            
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<?php $rows=get_field( 'question1'); if($rows) ?>
<?php { ?>
<?php foreach($rows as $row) { ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": {

    "@type": "Question",
    "name": "<?php echo  $row['name'] ?>",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "<?php echo  $row['content'] ?>"
    }
    
  }
}
</script>
<?php } ?>
<?php } ?>
<?php get_footer(); ?>