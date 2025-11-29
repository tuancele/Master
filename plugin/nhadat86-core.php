<?php
/**
 * File tải chính cho Logic nghiệp vụ cốt lõi của Nhadat86
 *
 * File này được gọi từ functions.php của theme
 * và chịu trách nhiệm tải tất cả các chức năng nghiệp vụ.
 */

// Chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Định nghĩa đường dẫn cho thư viện
define( 'NHADAT86_CORE_PATH', dirname( __FILE__ ) . '/' );
define( 'NHADAT86_CORE_INCLUDES_PATH', NHADAT86_CORE_PATH . 'includes/' );

/**
 * Tải các thành phần logic
 * (Chúng ta sẽ tạo các file này ở các bước tiếp theo)
 */

// 1. Tải Custom Post Types và Taxonomies
include_once( NHADAT86_CORE_INCLUDES_PATH . 'post-types.php' );

// 2. Tải tất cả Shortcodes
include_once( NHADAT86_CORE_INCLUDES_PATH . 'shortcodes.php' );

// 3. Tải hệ thống Rating/Comment
include_once( NHADAT86_CORE_INCLUDES_PATH . 'rating-system.php' );

// 4. Tải các hàm xử lý Form, AJAX, CRM
include_once( NHADAT86_CORE_INCLUDES_PATH . 'ajax-forms.php' );

// 5. Tải logic Phong Thủy (Đã di dời vào thư mục /plugin/)
include_once( NHADAT86_CORE_PATH . 'wp-phongthuy/index.php' );

// 6. Tải logic Tử Vi (Đã di dời vào thư mục /plugin/)
//include_once( NHADAT86_CORE_PATH . 'tuvi/tuvi.php' );
?>