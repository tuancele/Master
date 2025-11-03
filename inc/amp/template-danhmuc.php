<?php /* Template Name: Danh Mục BDS Template */ get_header(); ?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="section2">
    <div class="container">
        <div class="row">
            <?php
            if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb('
            <p id="breadcrumbs">','</p>
            ');
            }
            ?>

        <div class="example content-post-pro term-description"  data-mrc="">
          <?php the_content();?>
        </div>
   
            <?php if( have_rows('danh_sach_bds') ): ?>
            <?php  while( have_rows('danh_sach_bds') ): the_row(); ?>
            <div class="section-homepage"><h2><?php the_sub_field('title'); ?></h2></div>
            <?php   if( have_rows('cac_du_an') ): ?>
            <amp-carousel class="list-post" height="300"
  layout="fixed-height"
  type="slides">
                <?php  while( have_rows('cac_du_an') ): the_row(); ?>
                <div class="col-md-4 new-list">
                    <div class="item">
                        <a class="news-thumbnail" href="<?php the_sub_field('link'); ?>" rel="bookmark">
                            <img src="<?php the_sub_field('img'); ?>">
                        </a>
                        <div class="news-info">
                            <h3 class="title">
                            <a href="<?php the_sub_field('link'); ?>" rel="bookmark"><?php the_sub_field('title'); ?></a>
                            </h3>
                        </div>
                        <div class="post-price"><?php the_sub_field('gia'); ?></div>
                    </div>
                    <div class="post-status"><?php the_sub_field('bangiao'); ?></div>
                </div>
                <?php endwhile; ?>
            </amp-carousel>
            <?php endif; ?>
            <?php endwhile; ?>
            <?php endif; ?>


            
            
        </div>
        
        <?php comments_template(); ?>     
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>