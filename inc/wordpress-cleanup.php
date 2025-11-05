<?php
/**
 * Chịu trách nhiệm dọn dẹp các hook, filter và tính năng mặc định của WordPress
 * để làm sạch đầu ra (output) của theme.
 */

/*------------------------------------*\
	Các hàm dọn dẹp
\*------------------------------------*/

/**
 * Xóa <div> bao quanh menu.
 */
function my_wp_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
}

/**
 * Xóa các class CSS không cần thiết từ <li> của menu.
 * (Hiện đang bị vô hiệu hóa, nhưng giữ lại hàm để có thể dùng sau).
 */
function my_css_attributes_filter( $var ) {
	return is_array( $var ) ? array() : '';
}

/**
 * Xóa thuộc tính rel="category tag" không hợp lệ.
 */
function remove_category_rel_from_category_list( $thelist ) {
	return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
}

/**
 * Thêm slug của trang vào class của thẻ <body>.
 */
function add_slug_to_body_class( $classes ) {
	global $post;
	if ( is_home() ) {
		$key = array_search( 'blog', $classes );
		if ( $key > -1 ) {
			unset( $classes[ $key ] );
		}
	} elseif ( is_page() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	} elseif ( is_singular() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	}
	return $classes;
}

/**
 * Xóa CSS inline của widget Recent Comments.
 */
function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array(
		$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
		'recent_comments_style'
	) );
}

/**
 * Xóa thuộc tính width/height khỏi thumbnails.
 */
function remove_thumbnail_dimensions( $html ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}

/**
 * Xóa 'text/css' khỏi các thẻ <style> được enqueue.
 */
function html5_style_remove( $tag ) {
	return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}

/**
 * Tắt Admin Bar.
 */
function remove_admin_bar() {
	return false;
}

/**
 * Thay thế [...] ở cuối excerpt.
 */
function html5_blank_view_article( $more ) {
	global $post;
	return '...';
}

/**
 * Thêm Gravatar tùy chỉnh.
 */
function html5blankgravatar( $avatar_defaults ) {
	$myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
	$avatar_defaults[ $myavatar ] = "Custom Gravatar";
	return $avatar_defaults;
}

/**
 * Kích hoạt threaded comments (bình luận lồng nhau).
 */
function enable_threaded_comments() {
	if ( ! is_admin() ) {
		if ( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1 ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}


/*------------------------------------*\
	Kích hoạt Actions & Filters
\*------------------------------------*/

// Kích hoạt Threaded Comments
add_action( 'get_header', 'enable_threaded_comments' );

// Xóa inline Recent Comment Styles
add_action( 'widgets_init', 'my_remove_recent_comments_style' );

// Xóa các <link> không cần thiết trong <head>
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

// Thêm các bộ lọc (Filters)
add_filter( 'avatar_defaults', 'html5blankgravatar' );
add_filter( 'body_class', 'add_slug_to_body_class' );
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
add_filter( 'the_category', 'remove_category_rel_from_category_list' );
add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );
add_filter( 'excerpt_more', 'html5_blank_view_article' );
add_filter( 'show_admin_bar', 'remove_admin_bar' );
add_filter( 'style_loader_tag', 'html5_style_remove' );
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

// Xóa Filters
remove_filter( 'the_excerpt', 'wpautop' );

?>