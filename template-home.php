<?php /* Template Name: TRANG CHỦ COUNDOWS */ get_header(); ?>

                
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="setion1">
    <div class="container">
        
        <div class="row">
            <div class="col-md-4  section1-left">
                <div class="section1-left-inner">
                    <div class="infor">
                        <span><?php _e('Price about:','master-gf') ?></span>
                        <span class="price"><?php the_field('cele_price') ?></span>
                    </div>
                    <div class="infor">
                        <span><?php _e('Location:','master-gf') ?></span>
                        <span class="content"><?php the_field('cele_diachi') ?></span>
                    </div>
                    <div class="infor">
                        <span class=""><?php _e('House area:','master-gf') ?></span>
                        <span class=""><?php the_field('cele_dientich') ?></span>
                    </div>
                    <div class="box_countdown">
                        <div class="title">
                            <?php _e('Handing-over time','master-gf') ?>: <?php the_field('cele_bangiao') ?>
                        </div>
                        <div class="content">
                            <?php echo tinhngay(); ?>
                        </div>
                    </div>
                    <a href="tel:<?php the_field('cele_hotline','option')?>" class="info_link">
                        <svg><use xlink:href="#contactcall"></use></svg>
                        <?php _e('Buy a flat:','master-gf') ?> <span><?php the_field('cele_hotline','option')?></span></a>
                    <div class="info_time">
                        <?php _e('Update:','master-gf') ?> <span><?php the_date('d-m-Y') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-8  section1-right">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="banner">
                        <?php
                        $images = get_field('cele_banner');
                        if( $images ): $i=0;?>
                        <?php foreach( $images as $image ): $i++; ?>
                        <div class="item <?php if($i==1) {echo 'active';} ?>">
                            <img <?php awesome_acf_responsive_image($image['ID'],'full','780px'); ?> alt="<?php echo $image['alt']; ?>" class="img-responsive">
                           
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section2">
    <div class="container">
        <div class="row">
            <div class="col-md-9 section2-left">
                <div class="section2-left-inner clearfix">
                    <?php the_content(); ?>
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
                    <?php get_template_part('laisuat'); ?>
                    <?php comments_template(); ?>                
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php endwhile; ?>
<?php endif; ?>

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