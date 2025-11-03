<?php get_header(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section section-banner">
    <div class="container">
        <div class="columns is-align-items-center">
            <div class="column is-5-desktop section-content">
                <p class="section-subtitle">Vinhomes Grand Park</p>
                <h1 class="section-title"><?php the_title();?></h1>
                <div class="section-text">
                    <?php the_content();?>
                </div>
                <button class="btn button is-primary" role="button" aria-label="Create">
                    Đăng ký trải nghiệm
                </button>
            </div>
            <div class="column is-7-desktop section-slider">
                <?php 
$images = get_field('gallery');
if( $images ): ?>
                <div class="swiper-custom-container">
                    <div class="swiper slider-utilities-banner swiper-initialized swiper-horizontal swiper-backface-hidden">
                        <div class="swiper-wrapper">
<?php foreach( $images as $image ): ?>
                            <div class="swiper-slide">
                      <img src="<?php echo esc_url($image['url']); ?>" alt="" title="" class="lazyload">
                    </div>
                      <?php endforeach; ?>
                        </div>
                         <div class="swiper-pagination"></div>
                <button type="button" role="button" class="swiper-button-disabled swiper-button-prev nav-button-prev is-dark" aria-label="Previous slide"></button>
                <button type="button" role="button" class="swiper-button-disabled swiper-button-next nav-button-next is-dark" aria-label="Next slide"></button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<section id="section-location-around" data-scrollnav-id="section-location-around" class="section section-location-utilities">
    <div class="container">
        <h2 class="section-title">Vị trí <?php the_title();?></h2>
        <div class="location-utilities-content">
            <div class="location-map">
                
                <?php echo get_field('ban_dos')?>
            </div>
        </div>
    </div>
</section>


<section class="section section-media">
    <div class="container">
        <div class="tabs">
            <h2><ul><li class="tab-item is-active"><a href="#galery-photo" class="tab-link">Thư viện hình ảnh</a></li></ul></h2>
        </div>
        <?php 
$images = get_field('gallery');
if( $images ):
    $total_images = count($images);
    $first_images = array_slice($images, 0, 5);
    $remaining_images = array_slice($images, 5);
    $remaining_count = count($remaining_images);
?>
<div id="galery-photo" class="tab-content is-photo is-active">
    <div class="is-grid is-2-column is-3-column-tablet">
        
       
        <?php foreach( $first_images as $image ): ?>
            <a class="grid-item" href="<?php echo esc_url($image['url']); ?>" target="_blank" data-fancybox="images">
                <img src="<?php echo esc_url($image['url']); ?>" alt="">
            </a>
        <?php endforeach; ?>

       
        <?php if( $remaining_count > 0 ): 
            $sixth_image = $remaining_images[0];
        ?>
        <a class="grid-item is-total-text" href="<?php echo esc_url($sixth_image['url']); ?>" target="_blank" data-fancybox="images">
            <img src="<?php echo esc_url($sixth_image['url']); ?>" alt="">
            <p class="total-text">
                <i class="ti ti-plus"></i> 
                <span class="is-hidden-mobile">Xem thêm <?php echo $remaining_count; ?> ảnh khác</span>
                <span class="is-hidden-tablet"><?php echo $remaining_count; ?> ảnh khác</span>
            </p>
        </a>
        <?php endif; ?>

        
        <?php 
        if ( $remaining_count > 1 ):
            for ( $i = 1; $i < count($remaining_images); $i++ ):
                $image = $remaining_images[$i];
        ?>
            <a href="<?php echo esc_url($image['url']); ?>" data-fancybox="images" style="display:none;"></a>
        <?php 
            endfor;
        endif;
        ?>

    </div>
</div>
<?php endif; ?>


    </div>
</section>

<style>
    @media all and (min-width: 800px) {
  .fancybox-thumbs {
    top: auto;
    width: auto;
    bottom: 0;
    left: 0;
    right : 0;
    height: 95px;
    padding: 10px 10px 5px 10px;
    box-sizing: border-box;
    background: rgba(0, 0, 0, 0.3);
  }
  
  .fancybox-show-thumbs .fancybox-inner {
    right: 0;
    bottom: 95px;
  }
}
</style>



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
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/gallery.css?v=<?php echo time();?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.css" integrity="sha512-Y1c7KsgMNtf7pIhrj/Ul2LhutImFYr+TsCmjB8mGAk+cgG1Vm8U1g7tvfmRr6yD5nds03Qgc6Mcb86MBKu1Llg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.js" integrity="sha512-+z66PuMP/eeemN2MgRhPvI3G15FOBbsp5NcCJBojg6dZBEFL0Zoi0PEGkhjubEcQF7N1EpTX15LZvfuw+Ej95Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  var sliderEl = document.querySelector(".slider-utilities-banner");

  if (sliderEl) {
    new Swiper(".slider-utilities-banner", {
      effect: "slide",
      navigation: {
        nextEl: ".slider-utilities-banner .swiper-button-next",
        prevEl: ".slider-utilities-banner .swiper-button-prev",
      },
      pagination: {
        el: ".slider-utilities-banner .swiper-pagination",
        clickable: true,
        dynamicBullets: true,
      },
      breakpoints: {
        992: {
          pagination: false,
        },
      },
    });
  }
});
(function($) {
$('[data-fancybox="images"]').fancybox({
  thumbs : {
    autoStart : true,
    axis      : 'x'
  }
});


})(jQuery);
</script>

<?php get_footer(); ?>