<?php get_header(); ?>

<div class="section2">

  <div class="container">

    <div class="row">

      <div class="col-md-9 section2-left">

        <div class="detail-date">

          <div class="section1-left-inner">

            <div class="box_countdown">

              <div class="title">

                <p><?php _e('COUNTDOWN HANDING-OVER TIME:','master-gf') ?></p>

              </div>

              <div class="content">

                <?php echo tinhngay(); ?>

              </div>

            </div>

          </div>

        </div>

        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

        <div class="section2-left-inner">

          <?php

          if ( function_exists('yoast_breadcrumb') ) {

          yoast_breadcrumb('

          <p id="breadcrumbs">','</p>

          ');

          }

          ?>

          <h1><span style="font-size: 18pt;"><strong><span><?php the_title(); ?></span></strong></span></h1>

          <?php the_content();?>

          <?php $rows=get_field( 'question1'); if($rows) ?>

          <?php { ?>

          <div class="accordion">

            <ul class="accordion__list">

              <?php foreach($rows as $row) { ?>

              <li class="accordion__item">

                <div class="accordion__itemTitleWrap">

                  <h3 class="accordion__itemTitle"><?php echo  $row['name'] ?></h3>

                  <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div>

                </div>

                <div class="accordion__itemContent">

                  <?php echo  $row['content'] ?>

                </div>

              </li>

              <?php } ?>

            </ul>

          </div>

          <?php } ?>

          <p class="dangxem">Bạn đang xem: <a href="<?php the_permalink();?>"><?php the_title();?></a> trong <?php the_category(' ')?></p>

          <?php the_tags( __( '<div class="entry-tags"><span>Tags:</span>', 'cele' ), '', '</div>'); ?>

          <?php get_template_part('laisuat'); ?>

          <?php comments_template(); ?>

        </div>

        <?php endwhile; ?>

        <?php endif; ?>

        <?php // social ?>

        <?php // comment ?>

        <div class="post-lq clearfix">

          <div class="widget-lq"><div class="h3"><?php _e('News latest','master-gf') ?></div></div>

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

<?php if( have_rows('question1') ): ?>

<script type="application/ld+json">

{

"@context": "https://schema.org",

"@type": "FAQPage",

"mainEntity": [

<?php while ( have_rows('question1') ) : the_row(); ?>

{

"@type": "Question",

"name": "<?php the_sub_field('name'); ?>",

"acceptedAnswer": {

"@type": "Answer",

"text": "<?php the_sub_field('content'); ?>"

}

}<?php the_sub_field('s'); ?>

<?php endwhile; ?>

]

}

</script>

<?php endif; ?>

<?php get_footer(); ?>