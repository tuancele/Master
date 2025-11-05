<?php
/**
 * Chịu trách nhiệm đăng ký tất cả các Shortcodes
 * được sử dụng trong nội dung bài viết và trang.
 */

// Chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Shortcode: [phan_khu]
 * (Code gốc từ dòng 4)
 */
function shortcode_phan_khu_subdivision($atts) {
    ob_start();

    $atts = shortcode_atts(array(
        'id' => null
    ), $atts);

    $post_id = $atts['id'] ? intval($atts['id']) : get_the_ID();

    if (!$post_id) return '';
    $my_posts = get_field('phan_khu', $post_id);
    if (!$my_posts) return '';

    $args = array(
        'post_type' => 'post',
        'post__in' => $my_posts,
        'orderby' => 'post__in',
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);
    ?>
    
    <section id="section-subdivision" data-scrollnav-id="section-subdivision" class="section section-subdivision">
        <div class="containers">
            <div class="swiper-custom-container">
                <div class="swiper slider-subdivision">
                    <div class="swiper-wrapper">

                    <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="swiper-slide">
                            <div class="card card-subdivision">
                                <div class="card-block is-header">
                                    <p class="card-text">Phân khu</p>
                                    <h3 class="card-value">
                                        <a class="card-value" href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?> <i class="ti ti-arrow-up-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="card-image">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        $post_title = get_the_title();
                                        the_post_thumbnail('full', array('alt' => esc_attr($post_title)));
                                    }
                                    ?>
                                    <div class="badges"></div>
                                </a>
                                <div class="card-block">
                                    <p class="card-text">Giá bán</p>
                                    <p class="card-value">
                                        <?php echo get_field('gbdam') ?: 'Đang cập nhật'; ?>
                                    </p>
                                </div>
                                <div class="card-block">
                                    <p class="card-text">Diện tích</p>
                                    <p class="card-value">
                                        <?php echo get_field('tidam') ?: 'Đang cập nhật'; ?>
                                    </p>
                                </div>
                                <div class="card-block is-price">
                                    <p class="card-text">Tình trạng</p>
                                    <p class="card-value">
                                        <?php echo get_field('ttdam') ?: 'Đang cập nhật'; ?>
                                    </p>
                                </div>
                                <div class="card-block is-buttons">
                                    <a href="<?php the_permalink(); ?>" class="button is-small is-secondary is-fullwidth" role="link" aria-label="Xem chi tiết">
                                        Xem chi tiết
                                    </a>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="card-link-pseudo"></a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); endif; ?>

                    </div>
                    <button type="button" role="button" class="swiper-button-prev nav-button-prev" aria-label="Previous"></button>
                    <button type="button" role="button" class="swiper-button-next nav-button-next" aria-label="Next"></button>
                </div>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('phan_khu', 'shortcode_phan_khu_subdivision');


/*
 * Shortcode: [vi_tri]
 * (Code gốc từ dòng 72)
 */
function shortcode_vi_tri_location($atts) {
    ob_start();

    $atts = shortcode_atts(array(
        'id' => null
    ), $atts);
    $post_id = $atts['id'] ? intval($atts['id']) : get_the_ID();

    if (!$post_id) return '';

    $bdmd = get_field('bdmd', $post_id);
    $map_iframe = $bdmd ? preg_replace('/<iframe/', '<iframe id="default-map"', $bdmd, 1) : '';

    $my_posts = get_field('vi_tri', $post_id);
    if (!$my_posts) return '';

    $post_ids = array_map(function($p) {
        return is_object($p) ? $p->ID : $p;
    }, $my_posts);

    $used_term_ids = [];
    foreach ($post_ids as $pid) {
        $terms_for_post = wp_get_post_terms($pid, 'danh-muc-vi-tri', ['fields' => 'ids']);
        $used_term_ids = array_merge($used_term_ids, $terms_for_post);
    }
    $used_term_ids = array_unique($used_term_ids);

    if (empty($used_term_ids)) return '';

    $terms = get_terms([
        'taxonomy' => 'danh-muc-vi-tri',
        'include' => $used_term_ids,
        'hide_empty' => false,
    ]);
    ?>

    <section id="section-location-around" data-scrollnav-id="section-location-around" class="section section-location-utilities">
        <div class="location-utilities-content">
            <div class="location-map nearby-map-container location-map">
                <?php echo $map_iframe; ?>
            </div>
            <div class="location-body">
                <div class="location-types">
                    <?php
                    $first = true;
                    foreach ($terms as $term) {
                        $term_id = $term->term_id;
                        $icon_html = get_field('icon_vi_tri', 'danh-muc-vi-tri_' . $term_id) ?: '<i class="ti ti-star-on ti-24"></i>';

                        $args = [
                            'post_type' => 'post',
                            'post__in' => $post_ids,
                            'tax_query' => [[
                                'taxonomy' => 'danh-muc-vi-tri',
                                'field' => 'term_id',
                                'terms' => $term_id
                            ]],
                            'orderby' => 'post__in',
                            'posts_per_page' => -1
                        ];
                        $query = new WP_Query($args);
                        if ($query->have_posts()) :
                            ?>
                            <a href="#" class="location-type-item<?php echo $first ? ' is-active' : ''; ?>" data-term-id="<?php echo esc_attr($term_id); ?>">
                                <?php echo $icon_html; ?>
                                <span class="location-type-item-text"><?php echo esc_html($term->name); ?></span>
                            </a>
                            <?php
                            $first = false;
                        endif;
                        wp_reset_postdata();
                    }
                    ?>
                </div>
                <div class="location-type-lists">
                    <?php
                    $first = true;
                    foreach ($terms as $term) {
                        $term_id = $term->term_id;
                        $args = [
                            'post_type' => 'post',
                            'post__in' => $post_ids,
                            'tax_query' => [[
                                'taxonomy' => 'danh-muc-vi-tri',
                                'field' => 'term_id',
                                'terms' => $term_id
                            ]],
                            'orderby' => 'post__in',
                            'posts_per_page' => -1
                        ];
                        $query = new WP_Query($args);
                        if ($query->have_posts()) :
                            ?>
                            <div class="location-type-lists-group<?php echo $first ? ' is-active' : ''; ?>" data-term-id="<?php echo esc_attr($term_id); ?>">
                                <?php
                                while ($query->have_posts()) : $query->the_post();
                                    $ban_do_iframe = get_field('ban_do');
                                    preg_match('/src="([^"]+)"/', $ban_do_iframe, $matches);
                                    $ban_do_src = $matches[1] ?? '';
                                    ?>
                                    <a href="#" class="location-type-lists-item" data-map-src="<?php echo esc_attr($ban_do_src); ?>">
                                        <div class="location-type-start">
                                            <p class="is-subtitle1"><?php the_title(); ?></p>
                                            <p class="is-body3"><?php echo get_field('dia_chi') ?: 'Đang cập nhật'; ?></p>
                                        </div>
                                        <div class="location-type-end is-flex is-align-items-center is-justify-content-flex-end">
                                            <i class="ti ti-car-vinfast ti-32 has-text-grey-light"></i>
                                            <div class="ml-2 location-text">
                                                <p class="is-subtitle1"><?php echo get_field('khoang_cach') ?: 'Đang cập nhật'; ?></p>
                                                <p class="is-body3"><?php echo get_field('số_phut') ?: 'Đang cập nhật'; ?></p>
                                            </div>
                                        </div>
                                    </a>
                                <?php endwhile; ?>
                            </div>
                            <?php
                            $first = false;
                        endif;
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();
}
add_shortcode('vi_tri', 'shortcode_vi_tri_location');


/*
 * Shortcode: [tien_ich_canh_quan]
 * (Code gốc từ dòng 190)
 */
function tien_ich_canh_quan_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => get_the_ID(),
    ), $atts);

    $post_id = intval($atts['id']);
    ob_start();
    ?>
    <section id="section-facilities" data-scrollnav-id="section-facilities" class="section section-facilities">
        
        <div class="block-utilities">
            <div class="swiper-custom-container">
                <div class="swiper slider-utilities">
                    <div class="swiper-wrapper">
                        <?php
                        $my_posts = get_field('tien_ich', $post_id);
                        if ($my_posts) {
                            $post_ids = array();
                            foreach ($my_posts as $post) {
                                $post_ids[] = is_object($post) ? $post->ID : $post;
                            }
                            $args = array(
                                'post_type' => 'post',
                                'post__in' => $post_ids,
                                'orderby' => 'post__in',
                                'posts_per_page' => -1
                            );
                            $query = new WP_Query($args);
                            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                        ?>
                        <div class="swiper-slide">
                            <div class="card-utility">
                                <div class="card-image">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        $post_title = get_the_title();
                                        the_post_thumbnail('full', array('alt' => esc_attr($post_title)));
                                    }
                                    ?>
                                </div>
                                <div class="card-content">
                                    <div class="card-title">
                                        <span><?php the_title(); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; wp_reset_postdata(); endif; } ?>
                    </div>
                    <button type="button" role="button" class="swiper-button-prev nav-button-prev" aria-label="Previous"></button>
                    <button type="button" role="button" class="swiper-button-next nav-button-next" aria-label="Next"></button>
                </div>
            </div>
        </div>
        <div class="block-ecosystem">
            <div class="container">
                <p class="section-subtitle"></p>
                <p class="section-text"></p>
            </div>
        </div>
        <div class="block-list-utilities">
            <h3 class="section-subtitle">Danh sách tiện ích</h3>
            <div class="accordion accordion-default">
                <?php
                if ($my_posts) {
                    $post_ids = array_map(function($p) {
                        return is_object($p) ? $p->ID : $p;
                    }, $my_posts);

                    $used_term_ids = array();
                    foreach ($post_ids as $pid) {
                        $term_ids = wp_get_post_terms($pid, 'danh-muc-tien-ich', array('fields' => 'ids'));
                        $used_term_ids = array_merge($used_term_ids, $term_ids);
                    }
                    $used_term_ids = array_unique($used_term_ids);

                    if (!empty($used_term_ids)) {
                        $terms = get_terms(array(
                            'taxonomy' => 'danh-muc-tien-ich',
                            'include' => $used_term_ids,
                            'hide_empty' => false,
                        ));
                        $i = 0;
                        foreach ($terms as $term) {
                            $args = array(
                                'post_type' => 'post',
                                'post__in' => $post_ids,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'danh-muc-tien-ich',
                                        'field' => 'term_id',
                                        'terms' => $term->term_id,
                                    )
                                ),
                                'orderby' => 'post__in',
                                'posts_per_page' => -1,
                            );
                            $query = new WP_Query($args);
                            if ($query->have_posts()) :
                                $i++;
                                $classes = 'accordion-item';
                                $style = '';
                                $icon_class = 'ti-chevron-down';
                                if ($i <= 2) {
                                    $classes .= ' is-active';
                                    $icon_class = 'ti-chevron-up';
                                } elseif ($i >= 4) {
                                    $classes .= ' is-invisible';
                                    $style = 'display: none;';
                                }
                ?>
                <div class="<?php echo esc_attr($classes); ?>" style="<?php echo esc_attr($style); ?>">
                    <div class="accordion-title">
                        <i class="ti ti-building-carousel"></i>
                        <?php echo esc_html($term->name); ?> (<?php echo $query->found_posts; ?>)
                    </div>
                    <div class="accordion-content">
                        <ul>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <li>
                                <p class="image">
                                    <a data-fancybox="amenity-places" data-caption="<?php the_title(); ?>"
                                        href="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            $post_title = get_the_title();
                                            the_post_thumbnail('full', array('alt' => esc_attr($post_title)));
                                        }
                                        ?>
                                    </a>
                                </p>
                                <div class="summary">
                                    <p class="block-text"><?php the_title(); ?></p>
                                    <div class="block-desc"><?php the_content(); ?></div>
                                </div>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <button class="button is-x-small accordion-close" role="button" aria-label="Button">
                        <i class="accordion-icon ti <?php echo esc_attr($icon_class); ?>"></i>
                    </button>
                </div>
                <?php
                            wp_reset_postdata();
                            endif;
                        }
                    }
                }
                ?>
            </div>
            <div class="block-cta">
                <button class="accordion-view-more button is-link-underline">
                    <span>Xem thêm tiện ích khác</span>
                    <i class="ti ti-chevron-down"></i>
                </button>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('tien_ich_canh_quan', 'tien_ich_canh_quan_shortcode');

/*
 * Shortcode: [khungbac]
 * (Code gốc từ dòng 313)
 */
function shortcode_khungbac($atts, $content = null) {
    return '<div class="khung-bac">' . shortcode_unautop(do_shortcode(trim($content))) . '</div>';
}
add_shortcode('khungbac', 'shortcode_khungbac');

/*
 * Shortcode: [khungvang]
 * (Code gốc từ dòng 318)
 */
function shortcode_khungvang($atts, $content = null) {
    return '<div class="khung-vang">' . shortcode_unautop(do_shortcode(trim($content))) . '</div>';
}
add_shortcode('khungvang', 'shortcode_khungvang');


/*
 * Shortcode: [faq]
 * (Code gốc từ dòng 325)
 */
function create_shortcode_faq($args, $content) {
        $id = $args["id"];
        $rows = get_field('cele_faq');
        if (array_key_exists($id, $rows)) {
        $rowhienthi = $rows[$id];
        $row1 = $rowhienthi['tab'];
        
        $faq = '
        
        <div class="accordion"> <ul class="accordion__list">';
        
        if($row1)
            {
                $i=1;
                foreach($row1 as $row) {
                $faq .= '<li class="accordion__item';
                    if($i==1){ $faq .=' active';}
                $faq .= '"><div class="accordion__itemTitleWrap"> <h3 class="accordion__itemTitle"><a  href="#'.$id.$i.'a" ><span>'.$row['name'].'</span></a></h3><div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div></div> <div class="accordion__itemContent"> '.$row['content'].'</div></li>';         
                $i++; }
                $faq .= '</ul></div>';
                
            }
        return $faq;
    }
}
add_shortcode( 'faq', 'create_shortcode_faq' );


/*
 * Shortcode: [popup]
 * (Code gốc từ dòng 882)
 */
function create_shortcode_popup() {
        return '<p style="text-align: center;"><span style="font-family: helvetica, arial, sans-serif;"><a class="btn-res1" href="#section4-id">'. __('Get quotation','master-gf').'</a></span></p>';
}
add_shortcode( 'popup', 'create_shortcode_popup' );

/*
 * Shortcode: [tab]
 * (Code gốc từ dòng 887)
 */
function create_shortcode_tab($args, $content) {
		$id = $args["id"];
		$rows = get_field('cele_tab');
        if (array_key_exists($id, $rows)) {
		$rowhienthi = $rows[$id];
		$row1 = $rowhienthi['tab'];
        
		$tabs = '
		
		<div class="tab-shortcode clearfix panel with-nav-tabs"> <div class="panel-heading"><ul class="nav nav-tabs">';
		
		if($row1)
            {
				$i=1;
				foreach($row1 as $row) {
				$tabs .= '<li class="nav-item';
					if($i==1){ $tabs .=' active';}
				$tabs .= '"><a  href="#'.$id.$i.'a" data-toggle="tab"><span>'.$row['title'].'</span></a></li>';         
				$i++; }
				$tabs .= '</ul></div><div class="panel-body"><div class="tab-content">';
				$i=1;
				foreach($row1 as $row) {
				$tabs .= '<div class="tab-pane';
					if($i==1){ $tabs .=' active';}
				$tabs .= '" id="'.$id.$i.'a">
				<img src="'.$row['img'].'" class="img-responsive" alt="banner"/>
				<div class="content">'.$row['content'].'</div>
				
				</div>';      
				$i++; 

            }
				$tabs .= '</div></div>';
			}
        $tabs .= '</div>';
        
        if ( function_exists('cele_is_amp') && cele_is_amp() ) {

            $tabs = '<div class="tab-shortcode">
            
            <amp-selector class="tabs-with-selector"
            id="carouselSelector'.$id.'"
            role="tablist"
            on="select:carousel'.$id.'.goToSlide(index=event.targetOption)">
            <amp-carousel id="carouselPreview'.$id.'"
                class="carousel-preview"
                height="40"
                layout="fixed-height"
                type="carousel">';


            if($row1)
            {
				$i=0;
				foreach($row1 as $row) {
				    if($i==0){ $select ='selected';} else { $select =''; }
				$tabs .= '<div id="a'.$id.'-tab'.$i.'"  class="item-tab" aria-controls="'.$id.$i.'a" option="'.$i.'" '.$select.'><span>'.$row['title'].'</span></div>';         
                $i++; 
                }
                $tabs .= '</amp-carousel></amp-selector>
                <amp-carousel width="400" height="300" 
                layout="responsive" type="slides" 
                on="slideChange:carouselSelector'.$id.'.toggle(index=event.index, value=true),
                                carouselPreview'.$id.'.goToSlide(index=event.index)"
                 id="carousel'.$id.'" >';
				$i=1;
				foreach($row1 as $row) {
                    if($i==0){ $select ='selected';} else { $select =''; }
                //$tabs .= '<div  aria-labelledby="a'.$id.'-tab'.$i.'" option="'.$i.'" '.$select.' id="'.$id.$i.'a">'.$i.'';
                $tabs .= '<div class="slide">';
                $tabs .= '<amp-img src="'.$row['img'].'"  layout="fill" class="img-responsive" alt="banner"/></amp-img>';
                $tabs .= '<div class="caption">'.$row['content'].'</div></div>';      
				$i++; 
                }
				$tabs .= '</amp-carousel>';
			}
        $tabs .= '</amp-selector></div>';
        }
		
        return $tabs;
    }
}
add_shortcode( 'tab', 'create_shortcode_tab' );

/*
 * Shortcode: [sdt]
 * (Code gốc từ dòng 1099)
 */
function create_shortcode_sdt($args, $content) {
    if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {

        $post_url = admin_url('admin-ajax.php?action=amp_form_submit');
        return '<div class="deail_reg_canhomau">
                    <form method="POST" target="_top" action-xhr='.$post_url.' class="form-download1 form-content-'.$args["id"].'" on="submit-error:quote-lb.hide">
                        <div class="deail_reg_canhomau-inner">
                            <div class="deail_reg_canhomau_right">
                                <div class="deail_reg_canhomau_right_title">'.$args["title"].'</div>
                                <div class="deail_reg_canhomau_right_form">
                                    <div class="deail_reg_canhomau_right_form1">
                                        <input type="hidden" name="link" value="'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">
                                        <input aria-label="Mobile" required id="phone_project'.$args["id"].'" class="form-control" name="Mobile"  placeholder="'.__('Your Phone Number','master-gf').'" type="number">
                                        <input class="btn_dkcanhomau_duan_input" value="'.$args["button"].'"  type="submit" name="dangky">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div submitting>
             
                        <div id="quote-lb" class="overlay1">
                            <div class="loading_ajax">
                            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                            </div>
                        </div>
       
                        </div>
                        <div submit-error>
                <template type="amp-mustache">
                            {{data}}
                        </template></div>
                        
                    </form>
                </div>
                ';
    }else {
        return '<div class="deail_reg_canhomau">
                    <form class="form-download1 form-content-'.$args["id"].'">
                        <div class="deail_reg_canhomau-inner">
                            <div class="deail_reg_canhomau_right">
                                <div class="deail_reg_canhomau_right_title">'.$args["title"].'</div>
                                <div class="deail_reg_canhomau_right_form">
                                    <div class="deail_reg_canhomau_right_form1">
                                        <input aria-label="Mobile" id="phone_project'.$args["id"].'" class="form-control" name="Mobile" required="" placeholder="'.__('Your Phone Number','master-gf').'" type="number">
                                        <input class="btn_dkcanhomau_duan_input" onclick="form_content('.$args["id"].')" name="dangky" value="'.$args["button"].'" type="button">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>';
    }
}
add_shortcode( 'sdt', 'create_shortcode_sdt' );

?>