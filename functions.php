<?php
/**
 * Functions.php (Bản đã dọn dẹp)
 *
 * File này không còn chứa logic.
 * Nó chỉ hoạt động như một bộ tải (loader) cho các thư viện
 * và các file chức năng của theme.
 */

// Chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Tải file include cũ (Vẫn cần dọn dẹp các plugin bên trong file này)
include_once( get_stylesheet_directory() . '/inc/include.php' );

// 2. Tải file AMP (Giữ nguyên)
include_once( get_stylesheet_directory() . '/inc/amp.php' );

// 3. Tải thư viện Logic nghiệp vụ (CPTs, Shortcodes, AJAX, Forms...)
include_once( get_stylesheet_directory() . '/plugin/nhadat86-core.php' );

/*------------------------------------*\
	Tải các file cấu hình giao diện (Phần B)
\*------------------------------------*/

// Tải Theme Setup (Menus, Theme Support, Post Formats)
include_once( get_stylesheet_directory() . '/inc/theme-setup.php' );

// Tải Scripts và Styles (CSS/JS)
include_once( get_stylesheet_directory() . '/inc/scripts-styles.php' );

// Tải các hàm dọn dẹp WordPress (Cleanup Head, Filters)
include_once( get_stylesheet_directory() . '/inc/wordpress-cleanup.php' );

// Tải các hàm trợ giúp giao diện (Navs, Pagination, Excerpt)
include_once( get_stylesheet_directory() . '/inc/template-helpers.php' );

// Tải các hàm trợ giúp AMP
include_once( get_stylesheet_directory() . '/inc/amp-helpers.php' );

// (Kết thúc file)
?>