<?php get_header(); ?>
<div class="section2">
    <div class="container">
        <div class="row">

            <div class="col-md-9 section2-left no-padding cauhoi">
                <?php if (have_posts()): while (have_posts()) : the_post(); ?>

                <div class="section2-left-inner">
                        <?php the_content();?>	
				    <?php //get_template_part('social'); ?>
                    <?php comments_template('/comments-cauhoi.php'); ?>
                    <p class="dangxem">Bạn đang xem: <a href="<?php the_permalink();?>"><?php the_title();?></a> trong <?php the_category(' ')?></p>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
                 <?php // social ?>
              <?php // comment ?>
                <div class="post-lq clearfix">
                    <div class="widget-lq"><h3><?php _e('News latest','master-gf') ?></h3></div>
                    <?php $bvlq=new WP_Query(array( 'showposts'=>5,'category__in'=>$term_list,'post__not_in'=>array($a))); while($bvlq->have_posts()) :$bvlq->the_post();?>
                    <div class="post-item clearfix">
                        <a href="<?php the_permalink()?>">
                            <span class="post-image thumb-info"><?php the_post_thumbnail();?></span>
                        </a>
                        <h5><a href="<?php the_permalink()?>"><?php the_title();?></a></h5>
                        <p class="post-excerpt"><?php echo wp_trim_words( get_the_content(), 25, '...' ); ?></p>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>