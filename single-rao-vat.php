<?php get_header();wp_reset_query(); ?>
<?php $author_id=$post->post_author; ?>

<div id="slider">
	<div class="container product">
		<div class="image-view">
			<div class="clearfix">
				<div class="image-carousel owl-carousel owl-theme">
					
					

					<?php
if(!cele_is_amp()) { ?>
					<?php
					$images = get_field('gallery');
					if( $images ): ?>
					<div class="o-item image-default">
						<a href="<?php the_post_thumbnail_url('full')?>" data-fancybox="images" class="image-popup fh5co-board-img" title="<?php the_title();?>">
							<?php the_post_thumbnail('full')?>
						</a>
					</div>
					
					<?php $counter = 0; foreach( $images as $image ):$counter++ ; ?>
					<?php if( $counter % 4 == 1 ) {
					echo '<div class="o-item image-item">';
						}; ?>
						
						<div class="item">
							<div class="animate-box">
								<a href="<?php echo $image['url']; ?>" data-fancybox="images" class="image-popup fh5co-board-img" title="">
									<img src="<?php echo $image['sizes']['large']; ?>">
								</a>
							</div>
						</div>
						
						<?php if( $counter % 4 == 0 ) {
					echo '</div>';
					}; ?>
					<?php endforeach; ?>
					<?php endif; ?>
					
					<?php if(wp_is_mobile()){?>
					<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/jquery.fancybox.min.css">
					<script src="<?php bloginfo('template_url' ); ?>/js/jquery.fancybox.min.js"></script>
					<?php }?>
					     
					<?php } else {?>
					

					<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.2.js"></script>
					<?php
					$images = get_field('gallery');
					if( $images ): ?>
						<amp-carousel width="450" height="300" layout="responsive" type="slides">
							<amp-img
    src="<?php the_post_thumbnail_url('full')?>"
    width="450"
    height="300"
  ></amp-img>
					<?php  foreach( $images as $image ):?>
					
						<amp-img
    src="<?php echo $image['url']; ?>"
    width="450"
    height="300"
  ></amp-img>
						
						
						
					<?php endforeach; ?>
					<?php endif; ?>
                    </amp-carousel>
					<?php } ?>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div id="heading-post">
	<div class="container clearfix">
		<div class="left-heading">
			<h1 class="title-post"><?php the_title();?></h1>
			<ul class="clearfix">
				<li>Loại tin: <span><?php the_terms( $post->ID, 'danh-muc-loai-hinh' ) ?></span></li>
				<li>Hình thức: <span><?php the_terms( $post->ID, 'san-pham' ) ?></span></li>
				<li>Ngày đăng: <strong><?php the_time('d/m/Y') ?></strong></li>
			</ul>
			<p class="hashtag"><strong><span style="color:#000">Tại:</span> <?php the_terms( $post->ID, 'tinh-thanh' ) ?></strong></p>
			<div class="option-bar clearfix">
				<div class="row">
					<ul class="utilities col-md-6">
	                    <li><span class="bed-room"></span><text><?php the_field('ss_phong_ngu')?></text></li>
	                    <li><span class="bath-room"></span><text><?php the_field('so_phong_tam')?></text></li>
	                </ul>
					<div class="button-report col-md-6">
						<ul class="clearfix">
							<li><a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Thích <span>0</span></a></li>
							<li><a href="#">Chia sẻ</a></li>
							<li><a href="#">Báo xấu</a></li>
							<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i> Yêu thích</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="right-heading">
			<table class="table">
				<tr>
					<td><strong>Giá:</strong></td>
					<td><span><?php the_field('gia')?></span></td>
				</tr>
				<tr>
					<td><strong>Diện tích:</strong></td>
					<td><span><?php the_field('dien_tich')?></span></td>
				</tr>
			</table>
			<?php the_tags( '<p lclass="hashtag"><i class="fa fa-tags" aria-hidden="true"></i> Tags: </p>', ' '); ?>

			<div class="box-sidebar">
				<div style="text-align: center;" class="login-rv">
                    <div class="not-logged-in">
                        <a class="login-button" href="<?php bloginfo('home')?>/wp-login.php?action=register" rel="nofollow" title="Đăng nhập">Đăng ký</a>
                     
                    </div>
                    <a href="<?php bloginfo('home')?>/wp-login.php" rel="nofollow" title="Đăng tin mới" class="btn-white">Đăng tin</a>
                </div>
			</div>
		</div>
	</div>
</div>
<div id="content-post">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div id="content">
					<div class="box-text-content content-post">
						<?php the_content();?>
					</div>
					<div class="information">
						<h3 class="box-title">Thông tin liên hệ</h3>
						<div class="content-information">
							<div class="row">
								<div class="col-md-6">
									<div class="info-information clearfix">
										<a href="">
											<div class="img-information">
												<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 300 ) ); ?>
											</div>
											<div class="name-information">
												<span><?php the_author();?> </span>
											</div>
										</a>
									</div>
								</div>
								<div class="col-md-6">
									<div class="contact-information">
										<div><a href="tel:<?php the_author_meta( 'ext_phone' , $author_id ); ?>"><?php the_author_meta( 'ext_phone' , $author_id ); ?></a></div>
										<div><a href="#">Chát với người đăng tin</a></div>
									</div>
								</div>
							</div>
						</div>

						<?php comments_template(); ?>
						<?php if(!wp_is_mobile()){?>
<?php get_template_part('laisuat'); ?>
<?php
}
else
{ ?>

<?php }?>
						
					
					</div>
					
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="stickys">
					<!--
					<div class="box-sidebar ">
						<h3 class="title-box-sidebar">Thông tin liên hệ</h3>
						<div class="content-box-sidebar">
							<div class="info-information clearfix">
								<div class="img-information">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 300 ) ); ?>
								</div>
								<div class="name-information">
									<span><?php the_author();?></span>
									<div class="contact-information">
										<div><a href="tel:<?php the_author_meta( 'ext_phone' , $author_id ); ?>"><?php the_author_meta( 'ext_phone' , $author_id ); ?></a></div>
										<div><a href="#">Chát với người đăng tin</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					-->
				
				<div class="box-sidebar ">
					<h3 class="title-box-sidebar">Đăng ký nhận tư vấn</h3>
					<p>Đăng ký ngay để được hỗ trợ bởi chuyên viên tư vấn trực tiếp dự án</p>
					<div class="content-box-sidebar">
						<div class="tab-content">
							<div class="tab-pane  active" id="list1">
								<form id="dkct-form cele-form-sidebar" class="dkct-form form-footer cele-form-sidebar" action='<?php the_field(' cele_returnurl ','option ') ?>' method="POST">
					                <?php wp_nonce_field( 'celeform', 'human',false); ?>
					                <input name="Cele" value="mastergf-float" type="hidden">
					                <input name="Website" value="<?php the_permalink(); ?>" required="" type="hidden">
					                <div class="dkct-item celename clearfix">
					                    <i class="fa fa-user"></i><input id="name-downow" class="form" name="Name" aria-label="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>" required="">
					                </div>
					                <div class="dkct-item celeemail clearfix">
					                    <i class="fa fa-envelope"></i><input id="email-downow" class="form" name="Email" aria-label="Email" type="text" placeholder="<?php _e('Email','master-gf') ?>" required="">
					                </div>
					                <div class="dkct-item celephone clearfix">
					                    <i class="fa fa-phone"></i><input id="phone-downow" class="form" name="Mobile" type="number" aria-label="Mobile" placeholder="<?php _e('Phone number','master-gf') ?>" required="">
					                </div>
					                <div class="dkct-item ss clearfix"><button id="link-dow-now" class="dow-now" aria-label="Submit" name="dangky" onclick="Submit_Form('sidebar','all')" type="button" value="<?php _e('Send','master-gf') ?>">Đăng ký</button></div>
					            </form>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="relate-news-slider">
	<div class="container">
		<h3 class="box-title">CÓ THỂ BẠN QUAN TÂM</h3>

		<?php if(!wp_is_mobile()){?>




		<?php
		$custom_taxterms = wp_get_object_terms( $post->ID, 'san-pham', array('fields' => 'ids') );
		$args = array(
		'post_type' => 'rao-vat','author' =>  $custom_taxterms->ID,
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'orderby' => 'rand',
		'tax_query' => array(
		array(
		'taxonomy' => 'san-pham',
		'field' => 'id',
		'terms' => $custom_taxterms
		)
		),
		'post__not_in' => array ($post->ID),
		);
		$related_items = new WP_Query( $args );
		
		if ($related_items->have_posts()) :
		echo '<div class="slider-news row">'; while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
			<div class="col-md-3">
				<div class="item-news-slider">
					<div class="img-item-news-slider">
						<a href="<?php the_permalink();?>"><?php the_post_thumbnail('large')?></a>
					</div>
					<div class="info-item-news-slider">
						<div class="box-info-item-news-slider">
							<h4 class="title-item-news-slider"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
							<span class="address-item-news-slider"><?php the_terms( $post->ID, 'tinh-thanh' ) ?></span>
						</div>
						<div class="box-info-item-news-slider clearfix">
							<span class="price-item-news-slider"><?php the_field('gia')?></span>
							<span class="acreage-item-news-slider"><?php the_field('dien_tich')?></span>
						</div>
						<div class="box-info-item-news-slider clearfix">
							<div class="row">
								<div class="col-md-7">
									<div class="info-information clearfix">
										<a href="">
											<div class="img-information">
												<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 300 ) ); ?>
											</div>
											<div class="name-information">
												<span><?php the_author();?></span>
											</div>
										</a>
									</div>
								</div>
								<div class="col-md-5">
									<div class="contact-information">
										<a href="tel:<?php the_author_meta( 'ext_phone' , $author_id ); ?>"><?php the_author_meta( 'ext_phone' , $author_id ); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; echo '</div>'; endif; wp_reset_postdata();?>


		<?php
		}
		else
		{ ?>

		<?php
		$custom_taxterms = wp_get_object_terms( $post->ID, 'san-pham', array('fields' => 'ids') );
		$args = array(
		'post_type' => 'rao-vat','author' =>  $custom_taxterms->ID,
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'orderby' => 'rand',
		'tax_query' => array(
		array(
		'taxonomy' => 'san-pham',
		'field' => 'id',
		'terms' => $custom_taxterms
		)
		),
		'post__not_in' => array ($post->ID),
		);
		$related_items = new WP_Query( $args );
		
		if ($related_items->have_posts()) :
		echo '<div class="list-job clearfix">'; while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
			<div class="item-news-list clearfix">
                        <div class="img-item-news-list img-item-news-slider">
                            <a href="<?php the_permalink();?>"><?php the_post_thumbnail('medium')?></a>
                        </div>
                        <div class="info-item-news-list">
                            <div class="box-info-item-news-list">
                                <h2 class="title-item-news-slider"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                <h3 class="text-item-news">
                                    <?php echo get_excerpt(); ?>
                                </h3>
                                <span class="address-item-news-slider"><?php the_terms( $post->ID, 'tinh-thanh' ) ?></span>
                            </div>
                            <div class="box-info-item-news-list">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="price-item-news-list"><?php the_field('gia')?></span>
                                        <span class="acreage-item-news-list"><?php the_field('dien_tich')?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-information clearfix">
                                            <div class="img-information">
                                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 300 ) ); ?>
                                            </div>
                                            <div class="name-information">
                                                <span><?php the_author();?> | <a href="tel:<?php the_author_meta( 'ext_phone' , $author_id ); ?>"><?php the_author_meta( 'ext_phone' , $author_id ); ?></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
		<?php endwhile; echo '</div>'; endif; wp_reset_postdata();?>

		<?php }?>
	</div>
</div>



<div id="relate-news-list">
	<div class="container">
		<h3 class="box-title">BĐS THUỘC KHU VỰC</h3>
		<div class="row">
			<div class="col-md-8">
				<?php
				$custom_taxterms = wp_get_object_terms( $post->ID, 'tinh-thanh', array('fields' => 'ids') );
				$args = array(
				'post_type' => 'rao-vat',
				'post_status' => 'publish',
				'posts_per_page' => 3,
				'orderby' => 'rand',
				'tax_query' => array(
				array(
				'taxonomy' => 'tinh-thanh',
				'field' => 'id',
				'terms' => $custom_taxterms
				)
				),
				'post__not_in' => array ($post->ID),
				);
				$related_items = new WP_Query( $args );
				
				if ($related_items->have_posts()) :
				echo '<div class="list-job clearfix">'; while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
					<div class="item-news-list clearfix">
						<div class="img-item-news-list img-item-news-slider">
							<a href="<?php the_permalink();?>"><?php the_post_thumbnail('large')?></a>
						</div>
						<div class="info-item-news-list">
							<div class="box-info-item-news-list">
								<h4 class="title-item-news-slider"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
								<p class="text-item-news"><?php echo wp_trim_words( get_the_content(), 30, '...' ); ?></p>
								<span class="address-item-news-slider"><?php the_terms( $post->ID, 'tinh-thanh' ) ?></span>
							</div>
							<div class="box-info-item-news-list">
								<div class="row">
									<div class="col-md-6">
										<span class="price-item-news-list"><?php the_field('gia')?></span>
										<span class="acreage-item-news-list"><?php the_field('dien_tich')?></span>
									</div>
									<div class="col-md-6">
										<div class="info-information clearfix">
											<div class="img-information">
												<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 300 ) ); ?>
											</div>
											<div class="name-information">
												<span><?php the_author();?> | <a href="tel:<?php the_author_meta( 'ext_phone' , $author_id ); ?>"><?php the_author_meta( 'ext_phone' , $author_id ); ?></a></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; echo '</div>'; endif; wp_reset_postdata();?>
			</div>
			<div class="col-md-4">
				<div class="banner-rv banner-rv-1 clearfix">
					<a href="<?php the_field('link_banner','option')?>"><img src="<?php the_field('banner_rao_vat','option')?>" alt=""></a>
				</div>
				<div class="banner-rv banner-rv-2 clearfix">
					<a href="<?php the_field('link_banner_2','option')?>"><img src="<?php the_field('banner_rao_vat_2','option')?>" alt=""></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
  $term = get_field('tin','option');
  if(( $term )): ?>
<div id="news">
	<div class="container">
		<h3 class="box-title"><?php echo get_cat_name($term); ?></h3>
		<div class="slider-news2 row">
			<?php       $args=array(
      'cat' => $term,
      'posts_per_page'=> 4, 
     'orderby' => 'ID',
          'order' => 'DESC'
      );
      $postnew = new wp_query( $args );
      if( $postnew->have_posts() ) {
      while( $postnew->have_posts() ) {
      $postnew->the_post(); ?>
			<div class="col-md-3">
				<div class="item-news-slider">
					<div class="img-item-news-slider">
						<a href="<?php the_permalink();?>"><?php the_post_thumbnail('medium')?></a>
					</div>
					<div class="info-item-news-slider">
						<div class="box-info-item-news-slider">
							<span class="address-item-news-slider">8/29/2019 8:38:00 AM</span>
							<h4 class="title-item-news-slider"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
							<p class="text-item-news-slider"><?php echo wp_trim_words( get_the_content(), 30, '...' ); ?></p>
							<a class="click-more" href="<?php the_permalink();?>">Chi tiết</a>
						</div>
					</div>
				</div>
			</div>
			<?php }  }?>
		</div>
	</div>
</div>
<?php endif; ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/owl.carousel.css">
<?php if(!wp_is_mobile()){?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url' ); ?>/js/stickyMojo.js"></script>
<script type="text/javascript">
(function($) {
$('#footer').ready(function(){
        $.lockfixed(".stickys",{offset: {top: 0, bottom: $('#footer').height() + 3170, }});
});
})(jQuery);
</script>
<?php
}
else
{ ?>

<?php }?>
<?php get_footer(); ?>