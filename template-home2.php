<?php /* Template Name: Homepage Template 2 */ get_header(); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/stylehome2.css">
<style>
	.content p{line-height: 1.6}
	.contten ul li{list-style: disc;margin: 0 0 10px 20px;}
	.sec2_home2:after {background: url(<?php the_field('bg_sec2')?>) no-repeat center bottom / 100% 100%;}
	.sec2_home2:before{background: url(<?php the_field('bg_line_sec2')?>) no-repeat center bottom / 100% 100%;}
</style>
<?php $rows=get_field( 'banner'); if($rows) ?>
<?php { ?>
<div class="banner_home2">
	<?php foreach($rows as $row) { ?>
	<div class="bg_banner" style="background-image: url(<?php echo  $row['bg'] ?>);">

	</div>
	<div class="layer_banner container">
		<div class="inner">
			<div class="form_banner">
				<p class="capt"><?php echo  $row['capt_form'] ?></p>
				<p class="tit"><?php echo  $row['title_form'] ?></p>
				<form class="form-tlduan-brown form cele-form-brown">
				    <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
				    <input name="Cele" value="mastergf-modal-brown" type="hidden">
				    <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
				    
				    <span class="input-brown celename" style="margin-bottom: 17px;">
				        <input class="input" id="name-modal-brown" name="Name" aria-label="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>" required="">
				    </span>
				    <span class="input-brown celeemail" style="margin-bottom: 17px;">
				        <input class="input" id="email-modal-brown" name="Email" aria-label="Email" type="email" placeholder="<?php _e('Email','master-gf') ?>" required="">
				    </span>
				    <span class="input-brown celephone" style="margin-bottom: 17px;">
				        <input class="input" id="phone-modal-brown" name="Mobile" aria-label="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" required="">
				    </span>
				    <input id="link-modal-brown" class="dow-now button" name="dangky" aria-label="Submit" type="button" onclick="Submit_Form('brown','all')" value="<?php _e('Register','master-gf') ?>"> 
				</form>
				<div class="hotline_form hidden-xs">Hotline 24/7<br><strong><?php echo  $row['hotline_form'] ?></strong></div>
			</div>
		</div>
	</div>
	<div class="text_focus hidden-xs">
		<a href="#tongquan">Tìm hiểu thêm <i class="fa fa-angle-down"></i></a>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php $rows=get_field( 'sec1'); if($rows) ?>
<?php { ?>
<div class="sec1_home2" id="tongquan">
	<?php foreach($rows as $row) { ?>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="inner">
					<div class="box_title">
						<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
						<h2 class="title"><?php echo  $row['title'] ?></h2>
					</div>
					<div class="content">
						<?php echo  $row['content'] ?>
					</div>
					<div class="btn_home2">
						<a href=""><?php echo  $row['text_button'] ?> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="video">
					<iframe width="100%" height="550" src="https://www.youtube.com/embed/<?php echo  $row['id_video'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php $chas = get_field('sec2');
if($chas) { ?>
<?php foreach ($chas as $cha) { ?>
<div class="sec2_home2" id="">
	<div class="container">
		<div class="content">
			<div class="box_title">
				<h3 class="sub_bold"><?php echo $cha['sub'];  ?></h3>
				<h2 class="title"><?php echo $cha['title'];  ?></h2>
			</div>
			<div class="row">
				<?php
			    if($cha['list']) {
			    foreach ($cha['list'] as $con) { ?>
				<div class="col-md-6">
					<div class="inner clearfix">
						<div class="img">
							<img src="<?php echo $con['img']; ?>">
						</div>
						<div class="info">
							<h4 class="capt"><?php echo $con['capt']; ?></h4>
							<p><?php echo $con['text']; ?></p>
						</div>
					</div>
				</div>
				<?php } } ?>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="video">
						<iframe width="600" height="350" src="https://www.youtube.com/embed/<?php echo $cha['id_video'];  ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } } ?>
<?php $rows=get_field( 'sec3'); if($rows) ?>
<?php { ?>
<div class="sec3_home2 banner_home2" id="">
	<?php foreach($rows as $row) { ?>
	<div class="bg_banner" style="background-image: url(<?php echo  $row['bg'] ?>);"></div>
	<div class="layer_banner container">
		<div class="inner_left">
			<div class="box_title">
				<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
				<h2 class="title"><?php echo  $row['title'] ?></h2>
			</div>
			<div class="content">
				<?php echo  $row['content'] ?>
			</div>
		</div>
		<div class="inner clearfix">
			<div class="form_banner">
				<p class="tit"><?php echo  $row['title_form'] ?></p>

				<form class="form-tlduan-pink form cele-form-pink">
				    <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
				    <input name="Cele" value="mastergf-modal-pink" type="hidden">
				    <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
				    
				    <span class="input-pink celename" style="margin-bottom: 17px;">
				        <input class="input" id="name-modal-pink" name="Name" aria-label="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>" required="">
				    </span>
				    <span class="input-pink celeemail" style="margin-bottom: 17px;">
				        <input class="input" id="email-modal-pink" name="Email" aria-label="Email" type="email" placeholder="<?php _e('Email','master-gf') ?>" required="">
				    </span>
				    <span class="input-pink celephone" style="margin-bottom: 17px;">
				        <input class="input" id="phone-modal-pink" name="Mobile" aria-label="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" required="">
				    </span>
				    <input id="link-modal-pink" class="dow-now button" name="dangky" aria-label="Submit" type="button" onclick="Submit_Form('pink','all')" value="<?php _e('Register','master-gf') ?>"> 
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php $chas = get_field('sec4');
if($chas) { ?>
<?php foreach ($chas as $cha) { ?>
<div class="sec4_home2" id="">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="content">
					<?php echo $cha['content'];  ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="inner">
					<div class="box">
						<h3 class="capt"><?php echo $cha['title'];  ?></h3>
						<ul class="tailieu">
							<?php
						    if($cha['list']) {
						    foreach ($cha['list'] as $con) { ?>
							<li><?php echo $con['text']; ?></li>
							<?php } } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="btn_home2">
			<a href=""><?php echo $cha['text_button'];  ?> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
		</div>
	</div>
</div>
<?php } } ?>
<?php $rows=get_field( 'sec5'); if($rows) ?>
<?php { ?>
<div class="sec5_home2 banner_home2" id="">
	<?php foreach($rows as $row) { ?>
	<div class="bg_banner" style="background-image: url(<?php echo  $row['bg'] ?>);"></div>
	<div class="layer_banner container">
		<div class="inner clearfix">
			<div class="box_title">
				<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
				<h2 class="title"><?php echo  $row['title'] ?></h2>
			</div>
			<div class="content">
				<?php echo  $row['content'] ?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php $rows=get_field( 'sec6'); if($rows) ?>
<?php { ?>
<div class="sec6_home2" id="">
	<?php foreach($rows as $row) { ?>
	<div class="container">
		<div class="box_title">
			<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
			<h2 class="title"><?php echo  $row['title'] ?></h2>
		</div>
		<div class="content">
			<?php $images = $row['gallery']; if( $images ):?>
			<div class="row">
				<?php foreach( $images as $image ): ?>
				<div class="col-md-6">
					<div class="img">
						<a data-fancybox="images" href="<?php echo $image['url']; ?>">
						    <img class="" src="<?php echo $image['url']; ?>">
						</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif;?>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>

<div class="sec7_home2">
	<div class="container">
		<?php $rows=get_field( 'sec7'); if($rows) ?>
		<?php { ?>
		<?php foreach($rows as $row) { ?>
		<div class="box_title">
			<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
			<h2 class="title"><?php echo  $row['title'] ?></h2>
		</div>
		<div class="content">
			<?php echo  $row['content'] ?>
		</div>
		<?php } ?>
		<?php } ?>
		<div class="tab">
			<?php if( have_rows('tab_sec7') ): ?>
			<ul class="tab_name">
				<?php $i=0; while ( have_rows('tab_sec7') ) : the_row(); ?>
				<?php 
					$string = sanitize_title( get_sub_field('tab_title') ); 
				?>
				<li <?php if ($i==0) { ?>class="active"<?php } ?> >
					<a href="#<?php echo $string ?>" data-toggle="tab"><?php the_sub_field('tab_title'); ?></a>
				</li>
				<?php $i++; endwhile; ?>
			</ul>
			<div class="tab-content">
				<?php $i=0; while ( have_rows('tab_sec7') ) : the_row(); ?>
				<?php 
					$string = sanitize_title( get_sub_field('tab_title') ); 
				?>
				<div class="tab-pane fade <?php if ($i==0) { ?>in active<?php } ?>" id="<?php echo $string; ?>">
					<div class="img">
						<a data-fancybox="images" href="<?php the_sub_field('tab_img'); ?>">
						    <img class="" src="<?php the_sub_field('tab_img'); ?>">
						</a>
					</div>
				</div>
				<?php $i++; endwhile; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="sec8_home2 sec2_home2" id="">
	<div class="container">
		<div class="box_title">
			<h2 class="title">ĐĂNG KÝ NHẬN ƯU ĐÃI TỪ CHỦ ĐẦU TƯ</h2>
		</div>
		<form class="form-tlduan-violet form cele-form-violet">
		    <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
		    <input name="Cele" value="mastergf-modal-pink" type="hidden">
		    <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
		    <div class="row">
		    	<div class="col-md-6">
		    		<span class="input-violet celename" style="margin-bottom: 17px;">
				        <input class="input" id="name-modal-violet" name="Name" aria-label="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>" required="">
				    </span>
		    	</div>
		    	<div class="col-md-6">
                     <span class="input-violet celeemail" style="margin-bottom: 17px;">
				        <input class="input" id="email-modal-violet" name="Email" aria-label="Email" type="email" placeholder="<?php _e('Email','master-gf') ?>" required="">
				    </span>
		    	</div>
		    	<div class="col-md-6">
                    <span class="input-violet celephone" style="margin-bottom: 17px;">
				        <input class="input" id="phone-modal-violet" name="Mobile" aria-label="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" required="">
				    </span>
		    	</div>
		    	<div class="col-md-6">
                   <input id="link-modal-violet" class="dow-now button" name="dangky" aria-label="Submit" type="button" onclick="Submit_Form('violet','all')" value="<?php _e('Register','master-gf') ?>"> 
		    	</div>
		    </div>	    
		</form>
	</div>
</div>
<?php $rows=get_field( 'sec9'); if($rows) ?>
<?php { ?>
<div class="sec9_home2" id="">
	<?php foreach($rows as $row) { ?>
	<div class="box_title">
		<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
		<h2 class="title"><?php echo  $row['title'] ?></h2>
	</div>
	<div class="img">
		<a data-fancybox="images" href="<?php echo  $row['img'] ?>">
		    <img class="" src="<?php echo  $row['img'] ?>">
		</a>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php $rows=get_field( 'sec10'); if($rows) ?>
<?php { ?>
<?php foreach($rows as $row) { ?>
<div class="sec10_home2" id="" style="background-image: url(<?php echo  $row['bg'] ?>);">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="inner_left">
					<div class="box_title">
						<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
						<h2 class="title"><?php echo  $row['title'] ?></h2>
					</div>
					<div class="content">
						<?php echo  $row['content'] ?>
					</div>
					<div class="button_down">
						<div class="lineNgang"></div>
						<p><?php echo  $row['text'] ?></p>
						<div class="btn_home2">
							<a href=""><?php echo  $row['text_button'] ?> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="video">
					<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?php echo  $row['id_video'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php } ?>
<?php $rows=get_field( 'sec11'); if($rows) ?>
<?php { ?>
<div class="sec11_home2" id="">
	<?php foreach($rows as $row) { ?>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="inner_left">
					<div class="box_title">
						<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
						<h2 class="title"><?php echo  $row['title'] ?></h2>
					</div>
					<div class="content">
						<?php echo  $row['content'] ?>
					</div>
					<div class="button_down">
						<div class="lineNgang"></div>
						<p><?php echo  $row['text'] ?></p>
						<div class="btn_home2">
							<a href=""><?php echo  $row['text_button'] ?> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<?php $images = $row['gallery']; if( $images ):?>
				<div class="inner_right">
					<?php foreach( $images as $image ): ?>
					<div class="img">
						<img src="<?php echo $image['url']; ?>">
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php $rows=get_field( 'sec12'); if($rows) ?>
<?php { ?>
<div class="sec12_home2 sec2_home2" id="">
	<?php foreach($rows as $row) { ?>
	<div class="container">
		<div class="content">
			<div class="box_title">
				<h3 class="sub_bold"><?php echo  $row['sub'] ?></h3>
				<h2 class="title"><?php echo  $row['title'] ?></h2>
			</div>
			<div class="albums_img">
				<?php $images = $row['gallery']; if( $images ):?>
				<div class="row">
					<?php foreach( $images as $image ): ?>
					<div class="col-md-3 col-xs-6">
						<div class="img">
							<a data-fancybox="images" href="<?php echo $image['url']; ?>">
							    <img class="" src="<?php echo $image['url']; ?>">
							</a>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif;?>
			</div>
			<div class="button_down">
				<p><?php echo  $row['text'] ?></p>
				<div class="btn_home2">
					<a href=""><?php echo  $row['text_button'] ?> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php
$term = get_field('tin_tuc');
if(( $term )): ?>
<div class="sec13_home2" id="">
	<div class="container">
		<div class="box_title">
			<h2 class="title"><?php echo get_cat_name($term); ?></h2>
		</div>
		<div class="list_news">
			<div class="row">
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
					<div class="item">
						<a href="<?php the_permalink(); ?>">
							<div class="img"><?php the_post_thumbnail('medium'); ?></div>
							<h4 class="capt"><?php the_title(); ?></h4>
						</a>
					</div>
				</div>
				<?php }  }?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>


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