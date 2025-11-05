<?php
/**
 * Chịu trách nhiệm cho việc đăng ký và tải (enqueue)
 * tất cả các file CSS và JavaScript của theme.
 */

if ( ! function_exists( 'master_theme_styles_scripts' ) ) {
	/**
	 * Đăng ký và tải CSS/JS cho theme.
	 */
	function master_theme_styles_scripts() {
		
		// Kiểm tra nếu là trang AMP
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			
			// Tải AMP styles
			wp_register_style( 'style-amp', get_template_directory_uri() . '/css/style-amp.css', array(), '1.3', 'all' );
			wp_enqueue_style( 'style-amp' );
			
			// Tải Font Awesome cho AMP (giữ nguyên từ code gốc)
			echo "<link rel='stylesheet' id='font-awesome-css'  href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?ver=5.0.4' type='text/css' media='all' />";

		} else {
			
			// --- TẢI CSS CHO BẢN DESKTOP/MOBILE THÔNG THƯỜNG ---
			
			// Tải style.css (file chính của theme)
			wp_register_style( 'style-css', get_template_directory_uri() . '/css/style.css', array(), '1.3', 'all' );
			wp_enqueue_style( 'style-css' );

			// Tải mmenu.css (cho menu mobile)
			wp_register_style( 'mmenu-css', get_template_directory_uri() . '/css/jquery.mmenu.css', array(), '1.1', 'all' );
			wp_enqueue_style( 'mmenu-css' );

			// (Lưu ý: Các file CSS khác như owl.carousel, fancybox, chat.css đang được tải thủ công trong header.php.
			// Chúng ta sẽ tối ưu chúng sau, nhưng bước này vẫn giữ nguyên)


			// --- TẢI JAVASCRIPT ---
			
			// Đảm bảo jQuery gốc của WordPress được tải.
			// Chúng ta chỉ cần khai báo 'jquery' là phụ thuộc (dependency) ở bên dưới.

			// Tải popup.js (đã chuyển từ hàm html5blank_header_scripts cũ)
			// Đăng ký script và chỉ tải khi có điều kiện (tải ở footer)
			wp_register_script( 'popup-js', get_template_directory_uri() . '/js/popup.js', array( 'jquery' ), '1.0.3', true );
			if ( get_field( 'popup', 'option' ) ) {
				wp_enqueue_script( 'popup-js' );
			}

			// (Bạn nên thêm các file JS khác như custom.js, jquery.mmenu.js... vào đây theo cách tương tự)
			// Ví dụ:
			// wp_enqueue_script( 'mmenu-js', get_template_directory_uri() . '/js/jquery.mmenu.js', array( 'jquery' ), '1.0', true );
			// wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array( 'jquery', 'mmenu-js' ), '1.0', true );
		}
	}
}
// Hook hàm tải script vào WordPress
add_action( 'wp_enqueue_scripts', 'master_theme_styles_scripts' );


/**
 * PHẦN QUAN TRỌNG:
 *
 * Toàn bộ code ghi đè jQuery (các hàm isa_remove_jquery_migrate và replace_core_jquery_version)
 * từ file functions.php gốc đã bị XÓA BỎ.
 *
 * Việc này sẽ sửa lỗi xung đột JavaScript lớn nhất của theme và cho phép các plugin khác
 * hoạt động bình thường bằng cách sử dụng jQuery chuẩn của WordPress.
 */

?>