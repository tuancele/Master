<?php
/**
 * File: /inc/comment-rating.php
 *
 * Chứa các hàm tùy chỉnh cho hệ thống bình luận và đánh giá (rating).
 * (Đã được tách ra từ functions.php)
 */

// Chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Custom Comments Callback
 * Hàm tùy chỉnh cách hiển thị comment
 */
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <div <?php comment_class(empty( $args['has_children'] ) ? 'item_comment' : 'parent item_comment') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment_left"><svg><use xlink:href="#avatar"></use></svg></div>

    <div class="comment_right">
    <div class="comment-name">
	<?php printf(__('<span class="fn">%s</span>'), get_comment_author_link()); ?>
	<?php if ( is_super_admin($comment->user_id) ) { ?>
	    <b class="qtv"><?php _e('Moderator','master-gf') ?></b> 
	<?php } ?>
    </div>
    
	
    <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
        <br />
    <?php endif; ?>
	
    <?php comment_text() ?>

    <div class="info_feeback">
        <?php printf( __('<span style="color:#000;font-size: 13px;">%1$s</span>'), get_comment_date()) ?>
         <?php   if ( $rating = get_comment_meta(  $comment->comment_ID, 'rating', true ) ) { ?>
            <div class="pull-right"><i class="celeicon icon-star star<?php echo esc_attr($rating); ?>"></i></div>
         <?php } ?>
    </div>

	
    </div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php 
} // Kết thúc html5blankcomments


// =========================================================================
// HỆ THỐNG RATING
// =========================================================================

/**
 * Lưu Rating vào Comment Meta
 */
add_action( 'comment_post', 'ci_comment_rating_save_comment_rating' );
function ci_comment_rating_save_comment_rating( $comment_id ) {
	
	if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') ) {
    	$phone = wp_filter_nohtml_kses($_POST['phone']);
    	add_comment_meta( $comment_id, 'phone', $phone );
    }
	
    if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) ) {
        $rating = intval( $_POST['rating'] );
        add_comment_meta( $comment_id, 'rating', $rating );
    }
}

/**
 * Lấy Rating trung bình
 */
function ci_comment_rating_get_average_ratings( $id ) {
    $comments = get_approved_comments( $id );

    if ( $comments ) {
        $i = 0;
        $total = 0;
        foreach( $comments as $comment ){
            $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
            if( isset( $rate ) && '' !== $rate ) {
                $i++;
                $total += $rate;
            }
        }

        if ( 0 === $i ) {
            return false;
        } else {
            return round( $total / $i, 1 );
        }
    } else {
        return false;
    }
}

/**
 * Lấy tổng số Rating
 */
function ci_comment_rating_get_total_ratings( $id ) {
    $comments = get_approved_comments( $id );

    if ( $comments ) {
        $i = 0;
        foreach( $comments as $comment ){
            $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
            if( isset( $rate ) && '' !== $rate ) {
                $i++;
            }
        }

        if ( 0 === $i ) {
            return false;
        } else {
            return $i;
        }
    } else {
        return false;
    }
}

/**
 * Thêm trường SĐT vào Form Comment
 */
add_filter( 'comment_form_default_fields', 'wpsites_comment_form_fields' );
function wpsites_comment_form_fields( $fields ) {
    unset($fields['author']);
    unset($fields['email']);
    unset($fields['url']);
    unset($fields['cookies']);
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields['author'] = '<p class="comment-author"><input aria-label="Comment" placeholder="'.__('Your name (*)','master-gf').'" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />';
    $fields['phone'] = '<input aria-label="Your phone" placeholder="'.__('Your phone (*)','master-gf').'" id="phone" name="phone"  type="number"  size="11"' . $aria_req . ' />';           
    $fields['email']  = '<input id="email" aria-label="Your Name" placeholder="'.__('Your email (*)','master-gf').'" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    return $fields;
}

/**
 * Thêm SĐT vào admin comment
 */
add_action( 'add_meta_boxes_comment', 'comment_add_meta_box' );
function comment_add_meta_box() {
    add_meta_box( 'my-comment-title', __( 'Số điện thoại' ), 'comment_meta_box_age', 'comment', 'normal', 'high' );
}

function comment_meta_box_age( $comment ) {
    $title = get_comment_meta( $comment->comment_ID, 'phone', true );
    echo '<p><label for="phone">' . esc_attr( $title ) . '</label></p>';
}

/**
 * Gắn SĐT vào tên tác giả (Không thấy được sử dụng?)
 */
function attach_city_to_author( $author ) {
    $cities = get_comment_meta( get_comment_ID(), 'phone', false );
    if ( $cities ) {
        $author .= ' ( ';
        foreach ( $cities as $city )
            $author .= $city . ' ';
        $author .= ')';
    }
    return $author;
}

/**
 * Hàm hiển thị sao (Rating)
 */
function stars($all){
    $whole = floor($all);
    $fraction = $all - $whole;
    
    if($fraction < .25){
        $dec=0;
    }elseif($fraction >= .25 && $fraction < .75){
        $dec=.50;
    }elseif($fraction >= .75){
        $dec=1;
    }
    $r = $whole + $dec;
    
    //As we sometimes round up, we split again  
    $stars = "";
    $newwhole = floor($r);
    $upwhole = ceil($r);
    $thieu = 5 - $upwhole;
    $fraction = $r - $newwhole;
    for($s=1;$s<=$newwhole;$s++){
            $stars .= '<li><span class="celeicon star-100">&nbsp;</span></li>';   
        }
    if($fraction==.5){
        $stars .= '<li><span class="celeicon star-50">&nbsp;</span></li>';   
    }
    for($s=1;$s<=$thieu;$s++){
            $stars .= '<li><span class="celeicon star-00">&nbsp;</span></li>';   
        }

    echo $stars;
}

?>