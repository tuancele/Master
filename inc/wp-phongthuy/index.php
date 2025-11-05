<?php
/*
Plugin Name: WP Phong Thủy
Description: Xem phong thủy cho WordPress.
Version: 1.3
Author: willgroup
Author URI: https://willgroup.net
*/
define( 'WPPT_URI', plugin_dir_url( __FILE__ ) );
define( 'WPPT_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPPT_VERSION', '1.0' );
add_action( 'init', 'wppt_init' );
add_action( 'wp_enqueue_scripts', 'wppt_enqueue_scripts' );
add_action( 'wp_ajax_wppt_ajax_huongnha', 'wppt_process_ajax_huongnha' );
add_action( 'wp_ajax_nopriv_wppt_ajax_huongnha', 'wppt_process_ajax_huongnha' );
add_action( 'wp_ajax_wppt_ajax_tuoixaydung', 'wppt_process_ajax_tuoixaydung' );
add_action( 'wp_ajax_nopriv_wppt_ajax_tuoixaydung', 'wppt_process_ajax_tuoixaydung' );
function wppt_enqueue_scripts() {
	// featherlight
	wp_enqueue_style( 'featherlight', WPPT_URI . 'libs/featherlight/featherlight.css' );
	wp_enqueue_script( 'featherlight', WPPT_URI . 'libs/featherlight/featherlight.js', array( 'jquery' ), WPPT_VERSION, true );
	// main
	wp_enqueue_style( 'wppt', WPPT_URI . 'assets/css/frontend.css' );
	wp_enqueue_script( 'wppt', WPPT_URI . 'assets/js/frontend.js', array( 'jquery' ), WPPT_VERSION, true );
	wp_localize_script( 'wppt', 'wppt_vars', array(
		'ajax_url'   => admin_url( 'admin-ajax.php' ),
		'wppt_nonce' => wp_create_nonce( 'wppt-nonce' )
	) );
}

function wppt_init() {
	// xem huong nha
	register_post_type( 'wphn-xem-huong-nha', array(
			'labels'             => array(
				'name' => esc_html__( 'Xem hướng nhà', 'wppt' )
			),
			'public'             => false,
			'menu_position'      => 8,
			'has_archive'        => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'hierarchical'       => false,
			'query_var'          => true,
		)
	);
	register_taxonomy(
		'wphn-nam-sinh', 'wphn-xem-huong-nha', array(
			'label'        => esc_html__( 'Năm sinh', 'wppt' ),
			'hierarchical' => true,
			'query_var'    => true
		)
	);
	register_taxonomy(
		'wphn-gioi-tinh', 'wphn-xem-huong-nha', array(
			'label'        => esc_html__( 'Giới tính', 'wppt' ),
			'hierarchical' => true,
			'query_var'    => true
		)
	);
	register_taxonomy(
		'wphn-huong-nha', 'wphn-xem-huong-nha', array(
			'label'        => esc_html__( 'Hướng nhà', 'wppt' ),
			'hierarchical' => true,
			'query_var'    => true
		)
	);
	// tuoi xay dung
	register_post_type( 'wpxd-tuoi-xay-dung', array(
			'labels'             => array(
				'name' => esc_html__( 'Tuổi xây dựng', 'wppt' )
			),
			'public'             => false,
			'menu_position'      => 9,
			'has_archive'        => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'hierarchical'       => false,
			'query_var'          => true,
		)
	);
	register_taxonomy(
		'wpxd-nam-sinh', 'wpxd-tuoi-xay-dung', array(
			'label'        => esc_html__( 'Năm sinh', 'wppt' ),
			'hierarchical' => true,
			'query_var'    => true
		)
	);
	register_taxonomy(
		'wpxd-nam-xay', 'wpxd-tuoi-xay-dung', array(
			'label'        => esc_html__( 'Năm xây', 'wppt' ),
			'hierarchical' => true,
			'query_var'    => true
		)
	);
	// shortcode
	add_shortcode( 'wp_xemhuongnha', 'wppt_shortcode_xemhuongnha' );
	add_shortcode( 'wp_tuoixaydung', 'wppt_shortcode_tuoixaydung' );
}

function wppt_shortcode_xemhuongnha() {
	$namsinh  = get_terms( array(
		'taxonomy'   => 'wphn-nam-sinh',
		'orderby'    => 'term_id',
		'hide_empty' => false,
	) );
	$goitinh  = get_terms( array(
		'taxonomy'   => 'wphn-gioi-tinh',
		'orderby'    => 'term_id',
		'hide_empty' => false,
	) );
	$huongnha = get_terms( array(
		'taxonomy'   => 'wphn-huong-nha',
		'orderby'    => 'term_id',
		'hide_empty' => false,
	) );
	$output   = '<div class="wp_phongthuy_form wp_xemhuongnha wp-xemhuongnha wp-xhn">';
	$output .= '<div class="form-title"><span>Xem hướng nhà</span></div>';
	$output .= '<div class="form-line"><span class="label">Năm sinh gia chủ</span><div class="select"><table><tr><td><select class="ns">';
	if ( ! empty( $namsinh ) && ! is_wp_error( $namsinh ) ) {
		foreach ( $namsinh as $ns ) {
			$output .= '<option value="' . esc_attr( $ns->slug ) . '">' . esc_html( $ns->name ) . '</option>';
		}
	}
	$output .= '</select></td><td><select class="gt">';
	if ( ! empty( $goitinh ) && ! is_wp_error( $goitinh ) ) {
		foreach ( $goitinh as $gt ) {
			$output .= '<option value="' . esc_attr( $gt->slug ) . '">' . esc_html( $gt->name ) . '</option>';
		}
	}
	$output .= '</select></td></tr></table></div></div>';
	$output .= '<div class="form-line"><span class="label">Hướng nhà</span><div class="select"><select class="hn">';
	if ( ! empty( $huongnha ) && ! is_wp_error( $huongnha ) ) {
		foreach ( $huongnha as $hn ) {
			$output .= '<option value="' . esc_attr( $hn->slug ) . '">' . esc_html( $hn->name ) . '</option>';
		}
	}
	$output .= '</select></div></div>';
	$output .= '<div class="form-line"><input type="button" class="xem" value="Xem ngay"></div>';
	$output .= '</div>';

	return $output;
}

function wppt_shortcode_tuoixaydung() {
	$namnay  = date( 'Y' );
	$namsinh = get_terms( array(
		'taxonomy'   => 'wpxd-nam-sinh',
		'orderby'    => 'term_id',
		'hide_empty' => false,
	) );
	$namxay  = get_terms( array(
		'taxonomy'   => 'wpxd-nam-xay',
		'orderby'    => 'term_id',
		'hide_empty' => false,
	) );
	$output  = '<div class="wp_phongthuy_form wp_tuoixaydung wp-tuoixaydung wp-txd">';
	$output .= '<div class="form-title"><span>Xem tuổi xây dựng</span></div>';
	$output .= '<div class="form-line"><span class="label">Năm sinh gia chủ</span><div class="select"><select class="ns">';
	if ( ! empty( $namsinh ) && ! is_wp_error( $namsinh ) ) {
		foreach ( $namsinh as $ns ) {
			$output .= '<option value="' . esc_attr( $ns->slug ) . '">' . esc_html( $ns->name ) . '</option>';
		}
	}
	$output .= '</select></div></div>';
	$output .= '<div class="form-line"><span class="label">Năm xây dựng</span><div class="select"><select class="nx">';
	if ( ! empty( $namxay ) && ! is_wp_error( $namxay ) ) {
		foreach ( $namxay as $nx ) {
			$output .= '<option value="' . esc_attr( $nx->slug ) . '" ' . ( $namnay == $nx->name ? 'selected' : '' ) . '>' . esc_html( $nx->name ) . '</option>';
		}
	}
	$output .= '</select></div></div>';
	$output .= '<div class="form-line"><input type="button" class="xem" value="Xem ngay"></div>';
	$output .= '</div>';

	return $output;
}

function wppt_process_ajax_huongnha() {
	if ( ! isset( $_POST['wppt_nonce'] ) || ! wp_verify_nonce( $_POST['wppt_nonce'], 'wppt-nonce' ) ) {
		die( 'Permissions check failed!' );
	}
	$namsinh  = isset( $_POST['namsinh'] ) ? (string) $_POST['namsinh'] : '1900';
	$gioitinh = isset( $_POST['gioitinh'] ) ? $_POST['gioitinh'] : 'nam';
	$huongnha = isset( $_POST['huongnha'] ) ? $_POST['huongnha'] : 'huong-dong';
	query_posts( array(
			'post_type'      => 'wphn-xem-huong-nha',
			'posts_per_page' => 1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'wphn-nam-sinh',
					'terms'    => $namsinh,
					'field'    => 'slug',
				),
				array(
					'taxonomy' => 'wphn-gioi-tinh',
					'terms'    => $gioitinh,
					'field'    => 'slug',
				),
				array(
					'taxonomy' => 'wphn-huong-nha',
					'terms'    => $huongnha,
					'field'    => 'slug',
				)
			),
		)
	);
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			echo '<div class="wp_phongthuy_popup">' . str_replace( '{batquai}', '<img src="' . WPPT_URI . 'assets/images/batquai.jpg"/>', get_the_content() ) . '</div>';
		}
	} elseif ( file_exists( WPPT_PATH . '/data/huongnha/' . $namsinh . '_' . $gioitinh . '_' . $huongnha . '.txt' ) ) {
		$txt_content = file_get_contents( WPPT_PATH . '/data/huongnha/' . $namsinh . '_' . $gioitinh . '_' . $huongnha . '.txt' );
		echo '<div class="wp_phongthuy_popup">' . $txt_content . '</div>';
	} else {
		echo '<div class="wp_phongthuy_popup">Dữ liệu đang được cập nhật, xin vui lòng thử lại sau!</div>';
	}
	wp_reset_query();
	die();
}

function wppt_process_ajax_tuoixaydung() {
	if ( ! isset( $_POST['wppt_nonce'] ) || ! wp_verify_nonce( $_POST['wppt_nonce'], 'wppt-nonce' ) ) {
		die( 'Permissions check failed!' );
	}
	$namsinh = isset( $_POST['namsinh'] ) ? (string) $_POST['namsinh'] : '1900';
	$namxay  = isset( $_POST['namxay'] ) ? (string) $_POST['namxay'] : '2015';
	query_posts( array(
			'post_type'      => 'wpxd-tuoi-xay-dung',
			'posts_per_page' => 1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'wpxd-nam-sinh',
					'terms'    => $namsinh,
					'field'    => 'slug',
				),
				array(
					'taxonomy' => 'wpxd-nam-xay',
					'terms'    => $namxay,
					'field'    => 'slug',
				)
			),
		)
	);
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			echo '<div class="wp_phongthuy_popup">' . get_the_content() . '</div>';
		}
	} elseif ( file_exists( WPPT_PATH . '/data/xaydung/' . $namsinh . '_' . $namxay . '.txt' ) ) {
		$txt_content = file_get_contents( WPPT_PATH . '/data/xaydung/' . $namsinh . '_' . $namxay . '.txt' );
		echo '<div class="wp_phongthuy_popup">' . $txt_content . '</div>';
	} else {
		echo '<div class="wp_phongthuy_popup">Dữ liệu đang cập nhât, vui lòng thử lại sau !</div>';
	}
	wp_reset_query();
	die();
}

