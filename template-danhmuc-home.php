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
  <div class="container">
    <div class="example content-post-pro term-description"  data-mrc="">
      <?php the_content();?>
    </div>
    
    <script type="text/javascript" src="<?php bloginfo('template_url' ); ?>/js/jquery.morecontent.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url' ); ?>/js/demo.js"></script>
  </div>
  <div class="product-bg project clearfix">
    <div class="container">
      <?php if(!wp_is_mobile()){?>
      <?php if( have_rows('danh_sach_bds') ): ?>
      <?php  while( have_rows('danh_sach_bds') ): the_row(); $cat = get_sub_field('muc_luc_1'); $cat2 = get_sub_field('muc_luc_2')?>
      <div class="section-homepage"><h2><?php echo get_cat_name($cat); ?></h2></div>
      <div class="row project-carousel list-post">
        <div class="col-md-8 new-list list_pro">
           <div class="owl-3 owl-carousel">
             <?php
        $args = array(
        'post_status' => 'publish',
        'post_type' => 'post',
        'showposts' => 9,
        'cat' => $cat,
        );
        ?>
        <?php $getposts = new WP_query($args); ?>
        <?php global $wp_query; $wp_query->in_the_loop = true; ?>
        <?php $counter = 0; while ($getposts->have_posts()) : $getposts->the_post();$counter++ ; ?>
        <?php if( $counter % 3 == 1 ) {
         echo '<div class="item">';
         }; ?>
          <div class="box_pro item color-red clearfix">
            <div class="img_project thumb-image">
              <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                <img src="<?php the_post_thumbnail_url('medium')?>">
                <div class="bg-opacity"></div>
              </a>
              <div class="status dangban">
                <span class="icon"></span>
                <span><?php the_field('tt'); ?></span>
              </div>
            </div>
            <div class="content_project">
              <div class="title clearfix">
                <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                <div class="price_pro"><?php the_field('gia'); ?></div>
              </div>
              <div class="address"><?php the_field('dc'); ?></div>
              <ul class="info_pro clearfix">
                <li class="info-investor"><a href=""><?php the_terms( $post->ID, 'chu-dau-tu') ?></a></li>
                <li class="info-acreage">Đang cập nhật</li>
                <li class="info-finish">Bàn giao: <?php the_field('tg'); ?></li>
                <li class="info-constructor"><?php the_field('tt'); ?></li>
              </ul>
              <div class="info-category clearfix">
                <div class="info-category-box">
                  <?php the_category(' ')?>
                </div>
                <div class="compare-box">
                  <a href=""><span>So sánh</span></a>
                </div>
              </div>
            </div>
          </div>
        <?php if( $counter % 3 == 0 ) { 
         echo '</div>';
         }; ?>
        
        <?php endwhile; wp_reset_postdata() ;?>
           </div>
        </div>

        <div class="col-md-4 banner_pro">
          <?php while ( have_rows('banners') ) : the_row(); ?>
          <div class="img">
             <a href="<?php the_sub_field('link'); ?>"><img src="<?php the_sub_field('img'); ?>" alt=""></a>
          </div>
          <?php endwhile; ?>
        </div>
        <div class="col-md-8">
          <div class="more_pro">
            <a href="<?php echo get_category_link($cat )?>">Xem thêm</a>
          </div>
        </div>
      </div>
      <div class="row choise-project">
        <div class="col-md-4">
          <div class="capt"><?php echo get_cat_name($cat2); ?></div>
          <div class="box">
            Mua bán <a href="">Bất động sản</a> tại <a href="">Toàn quốc </a>
          </div>
        </div>
        <div class="col-md-8">
          <ul class="list">
            <?php $tab= get_sub_field('category_select'); $terms=get_terms( 'category',array( 'hide_empty'=> 0,'include'=> $tab) );$x=0; foreach ($terms as $term) { $x++;?>
            <li><a href="<?php echo get_term_link( $term ); ?>"><?php echo $term->name; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="row project-carousel list-post">
        <?php
        $args = array(
        'post_status' => 'publish',
        'post_type' => 'post',
        'showposts' => 4,
        'cat' => $cat2,
        );
        ?>
        <?php $getposts = new WP_query($args); ?>
        <?php global $wp_query; $wp_query->in_the_loop = true; ?>
        <?php while ($getposts->have_posts()) : $getposts->the_post(); ?>
        <div class="col-md-3 new-list">
          <div class="item color-red">
            <div class="thumb-image">
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <img class="lazy" src="<?php the_post_thumbnail_url('medium') ?>">
                <div class="bg-opacity"></div>
              </a>
              <div class="status dangban">
                <span class="icon"></span>
                <span><?php the_field('tt'); ?></span>
              </div>
            </div>
            <div class="info">
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <h2 class="name"><?php the_title(); ?> </h2>
              </a>
              <div class="address"><?php the_field('dc'); ?></div>
            </div>
            <div class="project-price">
              <div class="price">
                <span><?php the_field('gia'); ?></span>
              </div>
            </div>
          </div>
        </div>
        <?php endwhile;wp_reset_postdata() ; ?>
      </div>
      
      <?php endwhile; ?>
      <?php endif; ?>
      <?php
      }
      else
      { ?>
      <?php if( have_rows('danh_sach_bds') ): ?>
      <?php  while( have_rows('danh_sach_bds') ): the_row(); $cat = get_sub_field('muc_luc_1'); $cat2 = get_sub_field('muc_luc_2')?>
      <div class="section-homepage"><h2><?php the_sub_field('title'); ?></h2></div>
      <div class="row project-carousel list-post">
        <div class="col-md-8 new-list list_pro">
           <div class="owl-3 owl-carousel">
             <?php
        $args = array(
        'post_status' => 'publish',
        'post_type' => 'post',
        'showposts' => 6,
        'cat' => $cat,
        );
        ?>
        <?php $getposts = new WP_query($args); ?>
        <?php global $wp_query; $wp_query->in_the_loop = true; ?>
        <?php $counter = 0; while ($getposts->have_posts()) : $getposts->the_post();$counter++ ; ?>
        <?php if( $counter % 3 == 1 ) {
         echo '<div class="item">';
         }; ?>
          <div class="box_pro item color-red clearfix">
            <div class="img_project thumb-image">
              <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                <img src="<?php the_post_thumbnail_url('medium')?>">
                <div class="bg-opacity"></div>
              </a>
              <div class="status dangban">
                <span class="icon"></span>
                <span><?php the_field('tt'); ?></span>
              </div>
            </div>
            <div class="content_project">
              <div class="title clearfix">
                <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
              </div>
              <div class="address"><?php the_field('dc'); ?></div>
              <ul class="info_pro clearfix">
                <li class="price_pro"><?php the_field('gia'); ?></li>
                <li class="info-finish">Bàn giao: <?php the_field('tg'); ?></li>
                <div class="compare-box">
                  <a href=""><span>So sánh</span></a>
                </div>
              </ul>
            </div>
          </div>
        <?php if( $counter % 3 == 0 ) { 
         echo '</div>';
         }; ?>
        
        <?php endwhile; wp_reset_postdata() ;?>
           </div>
        </div>
        
        <div class="col-md-8">
          <div class="more_pro">
            <a href="<?php echo get_category_link($cat )?>">Xem thêm</a>
          </div>
        </div>
      </div>
        <div class="project-carousel owl-carousel mobiles list-post">
          <?php  while( have_rows('cac_du_an_2') ): the_row(); ?>
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
        
        <?php endwhile; ?>
        <?php endif; ?>
        <?php } ?>
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
    
  </div>
</div>
<div class="container">
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