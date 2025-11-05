<?php
/**
 * Chịu trách nhiệm cho tất cả các hàm trợ giúp (helpers)
 * liên quan đến AMP (Accelerated Mobile Pages).
 */

/**
 * Kiểm tra xem có phải là trang AMP hay không.
 *
 * @return bool
 */
function cele_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Hiển thị logo (phiên bản AMP hoặc thường).
 */
function cele_logo() {
	$logo = ( wp_is_mobile() ) ? get_option( 'options_cele_logo_mobile' ) : get_option( 'options_cele_logo' );
	if ( ! $logo ) {
		return;
	}
	$src     = wp_get_attachment_image_src( $logo, 'full', false );
	$content = get_bloginfo( 'description' );

	if ( ! cele_is_amp() ) {
		echo '<img src="' . $src[0] . '" class="img-responsive" width="' . $src[1] . '" height="' . $src[2] . '" title="' . $content . '" alt="' . $content . '">';
	} else {
		echo '<amp-img src="' . $src[0] . '" layout="fixed" width="' . $src[1] . '" height="' . $src[2] . '" title="' . $content . '" alt="' . $content . '"><div fallback>offline</div></amp-img>';
	}
}

/**
 * Hiển thị logo footer (phiên bản AMP hoặc thường).
 */
function cele_logo_footer() {
	$logo = get_option( 'options_cele_logo_footer' );
	if ( ! $logo ) {
		return;
	}
	$src     = wp_get_attachment_image_src( $logo, 'full', false );
	$content = get_bloginfo( 'description' );

	if ( ! cele_is_amp() ) {
		echo '<img src="' . $src[0] . '" class="img-responsive" width="' . $src[1] . '" height="' . $src[2] . '" title="' . $content . '" alt="' . $content . '">';
	} else {
		echo '<amp-img src="' . $src[0] . '" layout="fixed" width="' . $src[1] . '" height="' . $src[2] . '" title="' . $content . '" alt="' . $content . '"><div fallback>offline</div></amp-img>';
	}
}

/**
 * In các biến JavaScript (cho form) vào <head> nếu không phải AMP.
 */
function cele_form_var() {
	if ( ! cele_is_amp() ) {
		// (Chúng ta đã di chuyển phần kiểm tra Polylang vào đây ở bước sửa lỗi)
		$current_lang_slug = function_exists('pll_current_language') ? pll_current_language('slug') : '';
		
		echo '<script type="text/javascript">
            var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";
            var returnurl = "' . get_field( 'cele_returnurl', 'option' ) . '";
            var error1 = "' . get_field( 'cele_error1', $current_lang_slug ) . '"
            var error2 = "' . get_field( 'cele_error2', $current_lang_slug ) . '"
            var error3 = "' . get_field( 'cele_error3', $current_lang_slug ) . '"
            var error4 = "' . get_field( 'cele_error4', $current_lang_slug ) . '"
            var error5 = "' . get_field( 'cele_error5', $current_lang_slug ) . '"
        </script>';
	}
}
add_action( 'wp_head', 'cele_form_var' );

/**
 * Hiển thị nút "Back to Top".
 */
function back_to_top() {
	$action = ( cele_is_amp() ) ? 'on="tap:top.scrollTo(duration=600)"' : '';
	echo '<a class="back-to-top" ' . $action . '  title="back to top" role="button"><svg class="icon"><use xlink:href="#up-arrow-key"></use></svg></a>';
}
add_action( 'cele_before_header', 'back_to_top' );

/**
 * Hiển thị menu sidebar cho AMP.
 */
function menu_amp() {
	if ( cele_is_amp() ) {
		echo '<amp-sidebar id="sidebar" class="amp-menu" layout="nodisplay" side="right">';
		html5blank_nav_amp();
		echo '</amp-sidebar>';
	}
}
add_action( 'cele_before_wrapper', 'menu_amp' );

/**
 * Hàm gọi WP Nav Menu cho AMP (sử dụng Walker tùy chỉnh).
 */
function html5blank_nav_amp() {
	wp_nav_menu(
		array(
			'theme_location'  => 'header-menu',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => 'menu-{menu slug}-container',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '%3$s',
			'depth'           => 2,
			'walker'          => new Better_AMP_Menu_Walker() // Class này được định nghĩa trong /inc/amp.php
		)
	);
}

?>