<?php
/**
 * Chịu trách nhiệm cho hệ thống đánh giá (rating) qua bình luận
 * và tùy chỉnh các trường (fields) của form bình luận.
 */

// Chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*------------------------------------*\
	Hệ thống Rating & Tùy chỉnh Form Comment
\*------------------------------------*/

/**
 * Lưu meta data tùy chỉnh (SĐT và rating) khi bình luận được post.
 * (Code gốc từ dòng 941)
 */
function ci_comment_rating_save_comment_rating( $comment_id ) {
	
	if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') )
    		  $phone = wp_filter_nohtml_kses($_POST['phone']);
    		  add_comment_meta( $comment_id, 'phone', $phone );
	
    if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
            $rating = intval( $_POST['rating'] );
            add_comment_meta( $comment_id, 'rating', $rating );
}
add_action( 'comment_post', 'ci_comment_rating_save_comment_rating' );

/**
 * Lấy điểm rating trung bình.
 * (Code gốc từ dòng 950)
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
 * Lấy tổng số lượt rating.
 * (Code gốc từ dòng 970)
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
 * Tùy chỉnh các trường (fields) của form bình luận.
 * (Code gốc từ dòng 989)
 */
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
add_filter( 'comment_form_default_fields', 'wpsites_comment_form_fields' );

/**
 * (Code gốc từ dòng 1005)
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
 * Thêm meta box SĐT vào admin comment.
 * (Code gốc từ dòng 1220)
 */
function comment_add_meta_box()
{
 add_meta_box( 'my-comment-title', __( 'Số điện thoại' ), 'comment_meta_box_age',     'comment', 'normal', 'high' );
}
add_action( 'add_meta_boxes_comment', 'comment_add_meta_box' );

/**
 * Hiển thị SĐT trong admin comment.
 * (Code gốc từ dòng 1225)
 */
function comment_meta_box_age( $comment )
{
    $title = get_comment_meta( $comment->comment_ID, 'phone', true );
   ?>
 <p>
     <label for="phone"><?php echo esc_attr( $title ); ?></label>
 </p>
 <?php
}

?>