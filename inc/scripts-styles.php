<?php
/**
 * Chịu trách nhiệm cho việc đăng ký và tải (enqueue)
 * tất cả các file CSS và JavaScript của theme.
 */

if ( ! function_exists( 'master_theme_styles_scripts' ) ) {
	/**
	 * Đăng ký và tải CSS/JS cho theme.
	 * * Đã tối ưu hóa để tuân thủ chuẩn WordPress,
	 * loại bỏ jQuery cũ và khai báo phụ thuộc chính xác.
	 */
	function master_theme_styles_scripts() {
		
		// Kiểm tra nếu là trang AMP
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			
			// Tải AMP styles
			wp_register_style( 'style-amp', get_template_directory_uri() . '/css/style-amp.css', array(), '1.3', 'all' );
			wp_enqueue_style( 'style-amp' );
			
			// Tải Font Awesome cho AMP
			echo "<link rel='stylesheet' id='font-awesome-css'  href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?ver=5.0.4' type='text/css' media='all' />";

		} else {
			
			// --- TẢI CSS CHO BẢN DESKTOP/MOBILE THÔNG THƯỜNG ---
			
			wp_enqueue_style( 'master-style', get_template_directory_uri() . '/css/style.css', array(), '1.3', 'all' );
			wp_enqueue_style( 'mmenu-css', get_template_directory_uri() . '/css/jquery.mmenu.css', array(), '1.1', 'all' );
			wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri() . '/css/owl.carousel.css', array(), '1.0', 'all' );
			wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/css/jquery.fancybox.css', array(), '1.0', 'all' );
			
			// SỬA LỖI 404: Tải Font Awesome từ CDN
			wp_enqueue_style( 'font-awesome-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0', 'all' );
			
			wp_enqueue_style( 'chat-css', get_template_directory_uri() . '/chat.css', array(), '1.0', 'all' );
			wp_enqueue_style( 'swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.css', array(), null, 'all' );

			// --- TẢI JAVASCRIPT ---
			
			// Mảng phụ thuộc. WordPress sẽ tự động tải 'jquery'
			$custom_deps = array( 'jquery' );
			
			// 1. TẢI CÁC THƯ VIỆN ĐỘC LẬP
			
			// Tải lib.js (CHỨA MODAL BOOTSTRAP)
			wp_enqueue_script( 'master-lib-js', get_template_directory_uri() . '/js/lib.js', array( 'jquery' ), '1.0', true );
			$custom_deps[] = 'master-lib-js';
            
            // *** MỚI: Tải jQuery Validate ***
            wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array( 'jquery' ), '1.19.5', true );
            $custom_deps[] = 'jquery-validate';

			// Tải Swiper JS (CDN)
			wp_enqueue_script( 'swiper-js', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.js', array(), null, true );
			$custom_deps[] = 'swiper-js';

			// Tải Fancybox JS (local)
			wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array( 'jquery' ), '1.0', true );
			$custom_deps[] = 'fancybox-js';
			
			// Tải Sonar (cho menu trượt)
			wp_enqueue_script( 'sonar-js', get_template_directory_uri() . '/js/jquery.sonar.min.js', array( 'jquery' ), '1.0', true );
			$custom_deps[] = 'sonar-js';

			// Tải Readmore
			wp_enqueue_script( 'readmore-js', get_template_directory_uri() . '/js/readmore.min.js', array( 'jquery' ), '1.0', true );
			$custom_deps[] = 'readmore-js';

			// 2. TẢI CÁC BUNDLE (GÓI) THEO ĐÚNG THỨ TỰ PHỤ THUỘC

			// Tải Bundle (chứa rangeslider, cookie, chart, inputmask)
			// Phụ thuộc vào 'jquery' và 'jquery-validate'
			wp_enqueue_script( 'product-project-detail-js', get_template_directory_uri() . '/js/product-project-detail.min.js', array( 'jquery', 'jquery-validate' ), '1.0', true );
			$custom_deps[] = 'product-project-detail-js';

			// Tải Bundle (chứa mmenu, bootstrap, owl, headroom)
			// Phụ thuộc vào bundle ở trên (vì cần rangeslider) và validate
			wp_enqueue_script( 'mmenu-js', get_template_directory_uri() . '/js/jquery.mmenu.js', array( 'jquery', 'product-project-detail-js', 'jquery-validate' ), '1.0', true );
			$custom_deps[] = 'mmenu-js';

			// 3. CÁC SCRIPT BỊ LOẠI BỎ VÌ ĐÃ CÓ TRONG BUNDLE
			//
			// wp_enqueue_script( 'owl-carousel-js', ... ); // Đã có trong jquery.mmenu.js
			// wp_enqueue_script( 'headroom-js', ... );     // Đã có trong jquery.mmenu.js
			// wp_enqueue_script( 'js-cookie-js', ... );    // Đã có trong product-project-detail.min.js

			
			// 4. Tải các script có điều kiện
			
			// Tải Popup JS (nếu có)
			wp_register_script( 'popup-js', get_template_directory_uri() . '/js/popup.js', array( 'jquery' ), '1.0.3', true );
			if ( get_field( 'popup', 'option' ) ) {
				wp_enqueue_script( 'popup-js' );
				$custom_deps[] = 'popup-js';
			}

			// 5. Tải file custom.js (luôn tải cuối cùng)
            // Nó sẽ phụ thuộc vào tất cả các script đã được tải trước đó.
			wp_enqueue_script( 'master-custom-js', get_template_directory_uri() . '/js/custom.js', array_unique($custom_deps), '1.0', true );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'master_theme_styles_scripts' );

/**
 * PHẦN QUAN TRỌNG:
 *
 * Toàn bộ code ghi đè jQuery (các hàm isa_remove_jquery_migrate và replace_core_jquery_version)
 * từ file functions.php gốc đã bị XÓA BỎ.
 */
?>