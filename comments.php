



<?php 



$a = get_the_ID();

$abc = ci_comment_rating_get_average_ratings($a);

 ?>

 <?php if ($abc) : ?>

<div class="v2_danhgia_new_show clearfix">

   <div class="v2_danhgia_ns_box">

       

       <div class="v2_danhgia_nsb_point" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">

       		<div class="v2_danhgia_ns_title"><?php _e('Reviews','master-gf') ?></div>

       		<div class="v2_danhgia_nsb">

           <div class="v2_danhgia_nsb_point_cus">

               <meta itemprop="name" content="<?php _e('Project reviews','master-gf') ?>">

               <span itemprop="ratingValue"><?php echo $abc; ?></span>/5



               

           </div>

           <meta itemprop="bestRating" content="5">

           <meta itemprop="worstRating" content="1">

           

           <div class="v2_danhgia_nsb_point_start">

           		<ul class="bigstar">

							 <i class="celeicon icon-star star5"></i>

           			<?php 

           		//	stars($abc);

           			?>

           		</ul>

               <span class="v2_danhgia_nsb_point_start_total">(<span itemprop="ratingCount"><?php echo ci_comment_rating_get_total_ratings($a); ?></span> <?php _e('reviews','master-gf') ?>)</span>

               <div itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/CreativeWork">  </div>

               

               <div class="c"></div>

           </div>

       </div>

           

       </div>

       <div class="v2_danhgia_nsb_link">

		   <?php if(cele_is_amp()) { ?> 

		   

			<a href="https://nhadat86.vn/#comment" rel="nofollow"><?php _e('Send Review','master-gf') ?></a>

		 <?php } else { ?>

		   <a  href="https://nhadat86.vn/#comment" rel="nofollow"><?php _e('Send Review','master-gf') ?></a>

		 <?php } ?>

       </div>

       <div class="c"></div>

       

   </div>

</div>

<?php endif; ?>

 <div class="v2_danhgia_new_show clearfix">

       

       





	



	

<?php if (have_comments()) : ?>





<div class="v2_danhgia_ns_box clearfix no-padding" id="comments">

           <div class="v2_danhgia_ns_title"><span style="background:#e00;color:#fff;font-size:12px;padding: 2px 10px;border-radius: 3px;-moz-border-radius: 3px;margin-top: 2px;display: inline-block;"><?php _e('Have','master-gf') ?> <?php comments_number('%','%','%'); ?> <?php _e('reviews','master-gf') ?></span>

           </div>













<div style="margin-left: 10px;">

	<?php wp_list_comments('type=all&callback=html5blankcomments&style=div'); // Custom callback in functions.php ?>

</div>







<div class="paginate-com" style="border-top: solid 1px #ddd;padding: 10px;">



		<div class="pull-left">



	<?php 

		//Create pagination links for the comments on the current post, with single arrow heads for previous/next

	

			previous_comments_link($label=""); ?> 

		</div><div class="pull-right">

	<?php

			next_comments_link($label="", $max_page = 0);



		?>

			

			</div>

		</div>



</div>

























<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

<p><?php _e( 'Comments are closed here.', 'master-gf' ); ?></p>







<?php endif; ?>







<?php if (comments_open()&& !cele_is_amp() ) : ?>

	<div class="comments">

<?php comment_form( array(

			'title_reply_before' => '',

			'title_reply_after'  => '',

			'title_reply' => '',

			'logged_in_as'		=> '',

			'comment_notes_before'	=> '',

			'comment_field' => '<div class="comment-form-rating"><label for="rating">'. __('Your project review ','master-gf').'</label><div class="rating" style="float:left" id="select-rate-pro">

			<input type="radio" id="five" value="5" name="rating" checked=""><label for="five"><svg class="star"><use xlink:href="#stars"/></svg></label>

			<input type="radio" id="four" value="4" name="rating"><label for="four"><svg class="star"><use xlink:href="#stars"/></svg></label>

			<input type="radio" id="three" value="3" name="rating"><label for="three"><svg class="star"><use xlink:href="#stars"/></svg></label>

			<input type="radio" id="two" value="2" name="rating"><label for="two"><svg class="star"><use xlink:href="#stars"/></svg></label>

			<input type="radio" id="one" value="1" name="rating"><label for="one"><svg class="star"><use xlink:href="#stars"/></svg></label>	                 

				                </div></div><p class="comment-form-comment"><textarea id="comment" aria-label="Comment" placeholder="'. __('Comment about project','master-gf').'" name="comment" aria-required="true"></textarea></p>',

		) ); ?>



</div>

<?php endif; ?>













		

</div>