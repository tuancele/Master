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
                                <?php  tinhngay(); ?>
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
                    
                        <h1><span style="font-size: 18pt;"><strong><span style="font-family: 'times new roman', times, serif;"><?php the_title(); ?></span></strong></span></h1>
                        <?php the_content(); // Dynamic Content ?>
                        <?php $rows=get_field( 'question'); if($rows) ?>
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
                        <?php //get_template_part('social'); ?>
                        <?php comments_template(); ?>
                   
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
                 <?php // social ?>
              <?php // comment ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_template_part( 'section3' ); ?>

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