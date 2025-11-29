<?php
/**
 * Chịu trách nhiệm cho các thiết lập cơ bản của theme.
 * Bao gồm:
 * 1. Hỗ trợ theme (Theme Support)
 * 2. Đăng ký Menus
 * 3. Đăng ký Post Formats
 * 4. Tải text domain (ngôn ngữ)
 * 5. Các điều chỉnh nhỏ về quyền và trình soạn thảo.
 */

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if ( ! function_exists( 'master_theme_setup' ) ) {
	/**
	 * Thiết lập các hỗ trợ cơ bản của theme.
	 */
	function master_theme_setup() {
		// Kích hoạt hỗ trợ Menus.
		add_theme_support( 'menus' );

		// Kích hoạt hỗ trợ Post Thumbnails (Ảnh đại diện).
		add_theme_support( 'post-thumbnails' );

		// Kích hoạt hỗ trợ Automatic Feed Links.
		add_theme_support( 'automatic-feed-links' );

		// Tải Text Domain (Ngôn ngữ)
		load_theme_textdomain( 'master-gf', get_template_directory() . '/languages' );

		// Đăng ký Menus
		register_nav_menus( array(
			'header-menu'  => __( 'Header Menu', 'html5blank' ), // Main Navigation
			'sidebar-menu' => __( 'Sidebar Menu', 'html5blank' ),
			'phongthuy'    => __( 'Phong Thủy', 'html5blank' ),
		) );

		// Kích hoạt Post Formats
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'chat' ) );
	}
}
add_action( 'after_setup_theme', 'master_theme_setup' );


/*------------------------------------*\
	Điều chỉnh chức năng WordPress
\*------------------------------------*/

// Cho phép Contributors tải Media
if ( current_user_can( 'contributor' ) && ! current_user_can( 'upload_files' ) ) {
	add_action( 'admin_init', 'allow_contributor_uploads' );
}
function allow_contributor_uploads() {
	$contributor = get_role( 'contributor' );
	$contributor->add_cap( 'upload_files' );
}

// Tắt Block Editor (Gutenberg)
add_filter( 'use_block_editor_for_post', '__return_false', 10 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );


/*------------------------------------*\
	Tùy chỉnh Post Formats
\*------------------------------------*/

// Đổi tên Post Formats
function rename_post_formats( $safe_text ) {
	if ( $safe_text == 'Đứng riêng' ) {
		return 'Teamplate 4';
	}
	if ( $safe_text == 'Thư viện ảnh' ) {
		return 'Bài tiện ích';
	}
	if ( $safe_text == 'Chat' ) {
		return 'Bài dự án mới';
	}
	return $safe_text;
}
add_filter( 'esc_html', 'rename_post_formats' );

// Tải template tùy chỉnh cho Post Format (ví dụ: single-chat.php)
function custom_single_template_by_post_format( $template ) {
	if ( is_single() ) {
		$post_format = get_post_format();
		if ( $post_format ) {
			$new_template = locate_template( "single-{$post_format}.php" );
			if ( $new_template ) {
				return $new_template;
			}
		}
	}
	return $template;
}
add_filter( 'template_include', 'custom_single_template_by_post_format' );

?>