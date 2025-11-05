<?php
/*
 Template Name: support
 */
 ?>
<?php get_header(); ?>
<div class="sp_sec1">
	<div class="container">
		<div class="promo_search" style="background-image: url(<?php bloginfo('template_url' ); ?>/images/youtube.svg);">
			<h2 class="title">How can we help you?</h2>
			<form action="">
				<input type="text" placeholder="Describe your issue" class="input-form">
				<button class="button-form"><svg class="promoted-search__search-icon" viewBox="0 0 24 24"><path d="M20.49 19l-5.73-5.73C15.53 12.2 16 10.91 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.41 0 2.7-.47 3.77-1.24L19 20.49 20.49 19zM5 9.5C5 7.01 7.01 5 9.5 5S14 7.01 14 9.5 11.99 14 9.5 14 5 11.99 5 9.5z"></path><path d="M0 0h24v24H0V0z" fill="none"></path></svg></button>
			</form>
		</div>
	</div>
</div>
<div class="sp_sec2">
	<div class="container">
		<div class="panel-group" id="accordion">
			<?php    $rows = get_field('tabs');if($rows){ ?>
   			<?php $x=1; foreach($rows as $row) { ?>
		    <div class="panel panel-default">
		        <div class="panel-heading">
		            <h4 class="panel-title">
		                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $x; ?>"><?php echo  $row['name'] ?></a>
		            </h4>
		        </div>
		        <div id="collapse<?php echo $x; ?>" class="panel-collapse collapse <?php if ($x==1) { ?>in <?php } ?>">
		            <div class="panel-body">
		            	<?php echo  $row['content'] ?>
		            </div>
		        </div>
		    </div>
		    <?php $x++; } ?>
    		<?php } ?>
		</div>
	</div>
</div>
<div class="sp_sec3">
	<div class="container">
		<div class="slider_sp owl-theme owl-carousel">
			<?php $chas = get_field('slide');
			if($chas) { ?>
			<?php foreach ($chas as $cha) { ?>
			<div class="item">
				<h3 class="title"><?php echo $cha['title'];  ?></h3>
				<ul class="clearfix">
					<?php
				    if($cha['list']) {
				    foreach ($cha['list'] as $con) { ?>
					<li class="child" style="background-image:url(<?php echo $con['img']; ?>)">
						<a href="<?php echo $con['link']; ?>"><?php echo $con['capt']; ?></a>
						<p><?php echo $con['text']; ?></p>
					</li>
					<?php } } ?>
				</ul>
			</div>
			<?php } } ?>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css">
<?php get_footer(); ?>