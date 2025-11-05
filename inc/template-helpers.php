<?php
/**
 * Chịu trách nhiệm cho các hàm trợ giúp (helper functions)
 * được sử dụng trong các file template (như page.php, single.php)
 * để hiển thị nội dung.
 */

/*------------------------------------*\
	Hàm trợ giúp Menu (Navigation)
\*------------------------------------*/

// Menu chính
function html5blank_nav() {
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
		'items_wrap'      => '<ul id="menu-menu-header" class="nav navbar-nav">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Menu mobile (Sử dụng bởi mmenu)
function html5blank_nav_mobile() {
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
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Menu tùy chỉnh 1
function html5blank_nav1() {
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
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Thêm ảnh vào tiêu đề menu item (nếu có ACF)
function my_nav_menu_item_title( $title, $item, $args, $depth ) {
	if ( function_exists( 'get_field' ) && get_field( 'image', $item ) ) {
		// first level
		$title = '<strong><img src="' . get_field( 'image', $item ) . '"></strong><span style="margin-left: 5px;">' . $title . '</span>';
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'my_nav_menu_item_title', 10, 4 );


/*------------------------------------*\
	Hàm trợ giúp Excerpt (Đoạn trích)
\*------------------------------------*/

// Độ dài excerpt cho trang index
function html5wp_index( $length ) {
	return 20;
}

// Độ dài excerpt tùy chỉnh
function html5wp_custom_post( $length ) {
	return 40;
}

// Hàm tạo excerpt tùy chỉnh
function html5wp_excerpt( $length_callback = '', $more_callback = '' ) {
	global $post;
	if ( function_exists( $length_callback ) ) {
		add_filter( 'excerpt_length', $length_callback );
	}
	if ( function_exists( $more_callback ) ) {
		add_filter( 'excerpt_more', $more_callback );
	}
	$output = get_the_excerpt();
	$output = apply_filters( 'wptexturize', $output );
	$output = apply_filters( 'convert_chars', $output );
	$output = '<p>' . $output . '</p>';
	echo $output;
}

// Hàm tùy chỉnh get_excerpt (được sử dụng bởi theme)
function get_excerpt() {
	$excerpt = get_the_content();
	$excerpt = preg_replace( " ([.*?])", '', $excerpt );
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );
	$excerpt = substr( $excerpt, 0, 180 );
	$excerpt = substr( $excerpt, 0, strripos( $excerpt, " " ) );
	$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
	return $excerpt;
}


/*------------------------------------*\
	Hàm trợ giúp Template (Chung)
\*------------------------------------*/

// Hàm hiển thị bình luận tùy chỉnh
function html5blankcomments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );

	if ( 'div' == $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
    <div <?php comment_class( empty( $args['has_children'] ) ? 'item_comment' : 'parent item_comment' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment_left"><svg><use xlink:href="#avatar"></use></svg></div>

    <div class="comment_right">
    <div class="comment-name">
	<?php printf( __( '<span class="fn">%s</span>' ), get_comment_author_link() ); ?>
	<?php if ( is_super_admin( $comment->user_id ) ) { ?>
	<b class="qtv"><?php _e( 'Moderator', 'master-gf' ) ?></b> 
	<?php } ?>
    </div>
    
	
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
		<br />
	<?php endif; ?>
	<?php comment_text() ?>

    <div class="info_feeback">
        <?php
		printf( __( '<span style="color:#000;font-size: 13px;">%1$s</span>' ), get_comment_date() ) ?>

         <?php if ( $rating = get_comment_meta( $comment->comment_ID, 'rating', true ) ) { ?>
            <div class="pull-right"><i class="celeicon icon-star star<?php echo $rating; ?>"></i></div>
         <?php } ?>
    </div>

	
    </div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

// Hàm đếm ngược (tinhngay)
function tinhngay() {
	global $post;
	$ngay_bat_dau = date( 'Y-m-d' );
	if ( get_field( 'cele_demnguoc', $post->ID ) ) {
		$ngay_ket_thuc = get_field( 'cele_demnguoc', $post->ID );
	} else {
		$ngay_ket_thuc = get_field( 'cele_demnguoc', 'option' );
	}
	$hieu_so = strtotime( $ngay_ket_thuc ) - strtotime( $ngay_bat_dau );
	//var_dump($hieu_so);
	if ( $hieu_so < 0 ) {
		$return = '<div class="bangiao text-center">Đang bàn giao</div>';
	} else {

		$hieu_so = abs( strtotime( $ngay_ket_thuc ) - strtotime( $ngay_bat_dau ) );
		$nam     = floor( $hieu_so / ( 365 * 60 * 60 * 24 ) );

		$nam1   = floor( $nam / ( 10 ) );
		$nam2   = $nam - $nam1 * 10;
		$thang  = floor( ( $hieu_so - $nam * 365 * 60 * 60 * 24 ) / ( 30 * 60 * 60 * 24 ) );
		$thang1 = floor( $thang / ( 10 ) );
		$thang2 = $thang - $thang1 * 10;
		$ngay   = floor( ( $hieu_so - $nam * 365 * 60 * 60 * 24 - $thang * 30 * 60 * 60 * 24 ) / ( 60 * 60 * 24 ) );
		$ngay1  = floor( $ngay / 10 );
		$ngay2  = $ngay - $ngay1 * 10;
		$return .= '<div id="year_month">';
		if ( $nam1 > 0 || $nam2 > 0 ) {
			$return .= '<div class="year"><div class="numbers">';
			$return .= '<div class="number"><span id="year_chuc">' . $nam1 . '</span></div>';
			$return .= '<div class="number"><span id="year_donvi">' . $nam2 . '</span></div>';
			$return .= '</div><div class="text">' . __( 'Year', 'master-gf' ) . '</div></div>';
			$return .= '<div class="month"><div class="numbers">';
			$return .= '<div class="number"><span>' . $thang1 . '</span></div>';
			$return .= '<div class="number"><span>' . $thang2 . '</span></div>';
			$return .= '</div><div class="text">' . __( 'Month', 'master-gf' ) . '</div></div>';
			$return .= '<div class="day"><div class="numbers">';
			$return .= '<div class="number"><span>' . $ngay1 . '</span></div>';
			$return .= '<div class="number"><span>' . $ngay2 . '</span></div>';
			$return .= '</div><div class="text">' . __( 'Day', 'master-gf' ) . '</div></div>';
		} elseif ( $nam1 == 0 && $nam2 == 0 ) {
			$return .= '<div class="month">
                    <div class="text">
						' . __( 'Only', 'master-gf' ) . '
					</div>
					<div class="numbers">
						<div class="number"><span>' . $thang1 . '</span></div>
						<div class="number"><span>' . $thang2 . '</span></div>
					</div>
					<div class="text">
						' . __( 'Month', 'master-gf' ) . '
					</div>
                </div>
                <div class="day">
					<div class="numbers">
						<div class="number"><span>' . $ngay1 . '</span></div>
						<div class="number"><span>' . $ngay2 . '</span></div>
					</div>
					<div class="text">
						' . __( 'Day', 'master-gf' ) . '
					</div>
				</div>';
		} elseif ( $nam1 == 0 && $nam2 == 0 && $thang1 == 0 && $thang2 == 0 ) {
			$return .= '<div class="day">
                    <div class="text">
						' . __( 'Only', 'master-gf' ) . '
					</div>
					<div class="numbers">
						<div class="number"><span>' . $ngay1 . '</span></div>
						<div class="number"><span>' . $ngay2 . '</span></div>
					</div>
					<div class="text">
						' . __( 'day to handover', 'master-gf' ) . '
					</div>
				</div>';
		}
		$return .= '</div>';
	}
	return $return;
}

// Chèn nội dung vào sau thẻ H2
function trogiup_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p  = '</h2>'; // bạn có thể thay thế thẻ p thành thẻ h1 hoặc h2
	$paragraphs = explode( $closing_p, $content );
	foreach ( $paragraphs as $index => $paragraph ) {
		if ( trim( $paragraph ) ) {
			$paragraphs[ $index ] .= $closing_p;
		}

		if ( $paragraph_id == $index + 1 ) {
			$paragraphs[ $index ] .= $insertion;
		}
	}
	return implode( '', $paragraphs );
}

// Hàm phân trang tùy chỉnh
function wp_bootstrap_pagination( $args = array() ) {

	$defaults = array(
		'range'           => 4,
		'custom_query'    => false,
		'previous_string' => __( 'Previous', 'master-gf' ),
		'next_string'     => __( 'Next', 'master-gf' ),
		'before_output'   => '<div class="pt col-md-12 no-padding"><ul class="pager">',
		'after_output'    => '</ul></div>'
	);

	$args = wp_parse_args(
		$args,
		apply_filters( 'wp_bootstrap_pagination_defaults', $defaults )
	);

	$args['range'] = (int) $args['range'] - 1;
	if ( ! $args['custom_query'] ) {
		$args['custom_query'] = @$GLOBALS['wp_query'];
	}
	$count = (int) $args['custom_query']->max_num_pages;
	$page  = intval( get_query_var( 'paged' ) );
	$ceil  = ceil( $args['range'] / 2 );

	if ( $count <= 1 ) {
		return false;
	}

	if ( ! $page ) {
		$page = 1;
	}

	if ( $count > $args['range'] ) {
		if ( $page <= $args['range'] ) {
			$min = 1;
			$max = $args['range'] + 1;
		} elseif ( $page >= ( $count - $ceil ) ) {
			$min = $count - $args['range'];
			$max = $count;
		} elseif ( $page >= $args['range'] && $page < ( $count - $ceil ) ) {
			$min = $page - $ceil;
			$max = $page + $ceil;
		}
	} else {
		$min = 1;
		$max = $count;
	}

	$echo     = '';
	$previous = intval( $page ) - 1;
	$previous = esc_attr( get_pagenum_link( $previous ) );

	$firstpage = esc_attr( get_pagenum_link( 1 ) );
	if ( $firstpage && ( 1 != $page ) ) {
		$echo .= '<li class="previous"><a href="' . $firstpage . '">' . __( 'First', 'master-gf' ) . '</a></li>';
	}
	if ( $previous && ( 1 != $page ) ) {
		$echo .= '<li><a href="' . $previous . '" title="' . __( 'previous', 'master-gf' ) . '">' . $args['previous_string'] . '</a></li>';
	}

	if ( ! empty( $min ) && ! empty( $max ) ) {
		for ( $i = $min; $i <= $max; $i ++ ) {
			if ( $page == $i ) {
				$echo .= '<li class="active"><span class="active">' . str_pad( (int) $i, 2, '0', STR_PAD_LEFT ) . '</span></li>';
			} else {
				$echo .= sprintf( '<li><a href="%s">%002d</a></li>', esc_attr( get_pagenum_link( $i ) ), $i );
			}
		}
	}

	$next = intval( $page ) + 1;
	$next = esc_attr( get_pagenum_link( $next ) );
	if ( $next && ( $count != $page ) ) {
		$echo .= '<li><a href="' . $next . '" title="' . __( 'next', 'master-gf' ) . '">' . $args['next_string'] . '</a></li>';
	}

	$lastpage = esc_attr( get_pagenum_link( $count ) );
	if ( $lastpage ) {
		$echo .= '<li class="next"><a href="' . $lastpage . '">' . __( 'Last', 'master-gf' ) . '</a></li>';
	}
	if ( isset( $echo ) ) {
		echo $args['before_output'] . $echo . $args['after_output'];
	}
}

// Hàm hiển thị sao (rating)
function stars( $all ) {
	$whole = floor( $all );
	$fraction = $all - $whole;

	if ( $fraction < .25 ) {
		$dec = 0;
	} elseif ( $fraction >= .25 && $fraction < .75 ) {
		$dec = .50;
	} elseif ( $fraction >= .75 ) {
		$dec = 1;
	}
	$r = $whole + $dec;

	//As we sometimes round up, we split again  
	$stars    = "";
	$newwhole = floor( $r );
	$upwhole  = ceil( $r );
	$thieu    = 5 - $upwhole;
	$fraction = $r - $newwhole;
	for ( $s = 1; $s <= $newwhole; $s ++ ) {
		$stars .= '<li><span class="celeicon star-100">&nbsp;</span></li>';
	}
	if ( $fraction == .5 ) {
		$stars .= '<li><span class="celeicon star-50">&nbsp;</span></li>';
	}
	for ( $s = 1; $s <= $thieu; $s ++ ) {
		$stars .= '<li><span class="celeicon star-00">&nbsp;</span></li>';
	}

	echo $stars;
}

?>