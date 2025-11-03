<?php

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

function shortcode_khungbac($atts, $content = null) {
    return '<div class="khung-bac">' . shortcode_unautop(do_shortcode(trim($content))) . '</div>';
}
add_shortcode('khungbac', 'shortcode_khungbac');

function shortcode_khungvang($atts, $content = null) {
    return '<div class="khung-vang">' . shortcode_unautop(do_shortcode(trim($content))) . '</div>';
}
add_shortcode('khungvang', 'shortcode_khungvang');




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

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/
include_once( get_stylesheet_directory() . '/inc/include.php' );
include_once( get_stylesheet_directory() . '/inc/amp.php' );
/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (function_exists('add_theme_support'))
{
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
}

//Allow Contributors to Add Media
if ( current_user_can('contributor') && !current_user_can('upload_files') )
add_action('admin_init', 'allow_contributor_uploads');

function allow_contributor_uploads() {
$contributor = get_role('contributor');
$contributor->add_cap('upload_files');
}
// disable for posts
add_filter('use_block_editor_for_post', '__return_false', 10);

// disable for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

add_action( 'after_setup_theme', 'my_theme_setup' );
function my_theme_setup(){
    load_theme_textdomain( 'master-gf', get_template_directory() . '/languages' );
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

function rename_post_formats( $safe_text ) {
    if ( $safe_text == 'Đứng riêng' )
    return 'Teamplate 4';

    if ( $safe_text == 'Thư viện ảnh' )
    return 'Bài tiện ích';

    if ( $safe_text == 'Chat' )
    return 'Bài dự án mới';


    return $safe_text;
    }
    add_filter( 'esc_html', 'rename_post_formats' );
    add_theme_support( 'post-formats', array( 'aside','gallery','chat') );

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

// HTML5 Blank navigation
function html5blank_nav()
{
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

function html5blank_nav_mobile()
{
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
function html5blank_nav1()
{
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
// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
           
            echo '';


        } else {

        wp_register_script('popup', get_template_directory_uri() . '/js/popup.js', array(), '1.0.3'); // Custom scripts
        if (get_field('popup','option')) {
        wp_enqueue_script('popup'); // Enqueue it!
        }
        
        }
		
    }
}
// Load HTML5 Blank conditional scripts
// Load HTML5 Blank styles
function html5blank_styles()
{
    if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
        wp_register_style('style-amp', get_template_directory_uri() . '/css/style-amp.css', array(), '1.3', 'all');
        wp_enqueue_style('style-amp'); // Enqueue it!
       echo  "<link rel='stylesheet' id='font-awesome-css'  href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?ver=5.0.4' type='text/css' media='all' />";
    } else {
    wp_register_style('style-css', get_template_directory_uri() . '/css/style.css', array(), '1.3', 'all');
    wp_enqueue_style('style-css'); // Enqueue it!

    wp_register_style('mmenu.css', get_template_directory_uri() . '/css/jquery.mmenu.css', array(), '1.1', 'all');
    wp_enqueue_style('mmenu.css'); // Enqueue it!
    }
  //  wp_register_style('animate-css', get_template_directory_uri() . '/css/animate.css', array(), '1.0', 'all');
  //  wp_enqueue_style('animate-css'); // Enqueue it!
}
// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'),  // Main Navigation
         'sidebar-menu' => __('Sidebar Menu', 'html5blank'), 
         'phongthuy' => __('Phong Thủy', 'html5blank'), 
       // 'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}
// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}
// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}
// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}
// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}
// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}
// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}
// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}
// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '...';
}
// Remove Admin bar
function remove_admin_bar()
{
    return false;
}
// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}
// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}
// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}
// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}

    //var_dump($comment);
?>
    <div <?php comment_class(empty( $args['has_children'] ) ? 'item_comment' : 'parent item_comment') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment_left"><svg><use xlink:href="#avatar"></use></svg></div>

    <div class="comment_right">
    <div class="comment-name">
	<?php printf(__('<span class="fn">%s</span>'), get_comment_author_link());
   

    ?>
	<?php if ( is_super_admin($comment->user_id) ) { ?>

	<b class="qtv"><?php _e('Moderator','master-gf') ?></b> 
	<?php } ?>
    </div>
    
	
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>
	<?php comment_text() ?>

    <div class="info_feeback">
        <?php
            printf( __('<span style="color:#000;font-size: 13px;">%1$s</span>'), get_comment_date()) ?>

         <?php   if ( $rating = get_comment_meta(  $comment->comment_ID, 'rating', true ) ) { ?>
            <div class="pull-right"><i class="celeicon icon-star star<?php echo $rating; ?>"></i></div>
         <?php } ?>
    </div>

	
    </div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }
/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('wp_footer', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

//add_filter('acf/settings/path', 'my_acf_settings_path');
function tinhngay() {
        global $post;
        $ngay_bat_dau = date('Y-m-d');
        if( get_field('cele_demnguoc', $post->ID) ){
          $ngay_ket_thuc = get_field('cele_demnguoc',$post->ID);
        } else {
        $ngay_ket_thuc = get_field('cele_demnguoc','option');
        }
        $hieu_so = strtotime($ngay_ket_thuc) - strtotime($ngay_bat_dau);
        //var_dump($hieu_so);
        if ($hieu_so < 0) {
            $return = '<div class="bangiao text-center">Đang bàn giao</div>';
        } else {

        $hieu_so = abs(strtotime($ngay_ket_thuc) - strtotime($ngay_bat_dau));
        $nam = floor($hieu_so / (365*60*60*24));
       
        $nam1 = floor($nam / (10));
        $nam2 = $nam - $nam1*10;
        $thang = floor(($hieu_so - $nam * 365*60*60*24) / (30*60*60*24));
        $thang1 = floor($thang / (10));
        $thang2 = $thang - $thang1*10;
        $ngay = floor(($hieu_so - $nam * 365*60*60*24 - $thang*30*60*60*24)/ (60*60*24));
        $ngay1 = floor($ngay /10);
        $ngay2 = $ngay - $ngay1*10;
        $return .= '<div id="year_month">';
		if ($nam1 > 0 || $nam2 > 0) {
            $return .= '<div class="year"><div class="numbers">';
            $return .= '<div class="number"><span id="year_chuc">'.$nam1.'</span></div>';
            $return .= '<div class="number"><span id="year_donvi">'.$nam2.'</span></div>';
			$return .= '</div><div class="text">'.__('Year','master-gf').'</div></div>';
            $return .= '<div class="month"><div class="numbers">';
            $return .= '<div class="number"><span>'.$thang1.'</span></div>';
            $return .= '<div class="number"><span>'.$thang2.'</span></div>';
			$return .= '</div><div class="text">'.__('Month','master-gf').'</div></div>';
            $return .= '<div class="day"><div class="numbers">';
            $return .= '<div class="number"><span>'.$ngay1.'</span></div>';
            $return .= '<div class="number"><span>'.$ngay2.'</span></div>';
			$return .= '</div><div class="text">'.__('Day','master-gf').'</div></div>';
        }
        else if ($nam1 ==  0 && $nam2 == 0) {
            $return .=	'<div class="month">
                    <div class="text">
						'.__('Only','master-gf').'
					</div>
					<div class="numbers">
						<div class="number"><span>'.$thang1.'</span></div>
						<div class="number"><span>'.$thang2.'</span></div>
					</div>
					<div class="text">
						'.__('Month','master-gf').'
					</div>
                </div>
                <div class="day">
					<div class="numbers">
						<div class="number"><span>'.$ngay1.'</span></div>
						<div class="number"><span>'.$ngay2.'</span></div>
					</div>
					<div class="text">
						'.__('Day','master-gf').'
					</div>
				</div>'
                ;
            }

        elseif ($nam1 ==  0 && $nam2 == 0 && $thang1 == 0 && $thang2 == 0) {
            $return .=	'<div class="day">
                    <div class="text">
						'.__('Only','master-gf').'
					</div>
					<div class="numbers">
						<div class="number"><span>'.$ngay1.'</span></div>
						<div class="number"><span>'.$ngay2.'</span></div>
					</div>
					<div class="text">
						'.__('day to handover','master-gf').'
					</div>
				</div>';
            }
			$return .= '</div>';
        }
        return $return;
}
/**
add_filter( 'the_content', 'trogiup_insert_post_ads' );
function trogiup_insert_post_ads( $content ) {
    $ad_code = baivietmoi();
    if ( is_singular( 'post' )) {
        return trogiup_insert_after_paragraph( $ad_code, 1, $content ); // Thay số 2 bằng số bạn muốn
    }
    return $content;
}

**/
function trogiup_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
$closing_p = '</h2>'; // bạn có thể thay thế thẻ p thành thẻ h1 hoặc h2
$paragraphs = explode( $closing_p, $content );
foreach ($paragraphs as $index => $paragraph) {
if ( trim( $paragraph ) ) {
$paragraphs[$index] .= $closing_p;
}

if ( $paragraph_id == $index + 1 ) {
$paragraphs[$index] .= $insertion;
}
}
return implode( '', $paragraphs );
}
/**
function baivietmoi() {
    global $post; 
    $categories = get_the_category($post->ID);
    if ($categories) {
        $category_ids = array();
        foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
    
   $args = array(
        'category__in' => $category_ids,
        'post_type'   => 'post',
        'numberposts' => '5',
        'orderby'     => 'rand',
        'post__not_in' => array($post->ID),
    );
   $related_posts = get_posts($args);
   $post_list = '';
   foreach($related_posts as $related) {
        $post_list .= '<li><a href="' . get_permalink($related->ID) . '" title="'.$related->post_title.'">' . $related->post_title . '</a></li>';
    }
    return sprintf('
        <div style="clear: both; height: 10px;"></div>
        <ul class="relatedpost">
            %s
        </ul> <!-- .related-posts -->
    ', $post_list );
    }
}
**/
function wp_bootstrap_pagination( $args = array() ) {

    $defaults = array(
        'range'           => 4,
        'custom_query'    => FALSE,
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
    if ( !$args['custom_query'] )
        $args['custom_query'] = @$GLOBALS['wp_query'];
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range'] / 2 );

    if ( $count <= 1 )
        return FALSE;

    if ( !$page )
        $page = 1;

    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }

    $echo = '';
    $previous = intval($page) - 1;
    $previous = esc_attr( get_pagenum_link($previous) );

    $firstpage = esc_attr( get_pagenum_link(1) );
    if ( $firstpage && (1 != $page) )
        $echo .= '<li class="previous"><a href="' . $firstpage . '">' . __( 'First', 'master-gf' ) . '</a></li>';
    if ( $previous && (1 != $page) )
        $echo .= '<li><a href="' . $previous . '" title="' . __( 'previous', 'master-gf') . '">' . $args['previous_string'] . '</a></li>';

    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ($page == $i) {
                $echo .= '<li class="active"><span class="active">' . str_pad( (int)$i, 2, '0', STR_PAD_LEFT ) . '</span></li>';
            } else {
                $echo .= sprintf( '<li><a href="%s">%002d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
            }
        }
    }

    $next = intval($page) + 1;
    $next = esc_attr( get_pagenum_link($next) );
    if ($next && ($count != $page) )
        $echo .= '<li><a href="' . $next . '" title="' . __( 'next', 'master-gf') . '">' . $args['next_string'] . '</a></li>';

    $lastpage = esc_attr( get_pagenum_link($count) );
    if ( $lastpage ) {
        $echo .= '<li class="next"><a href="' . $lastpage . '">' . __( 'Last', 'master-gf' ) . '</a></li>';
    }
    if ( isset($echo) )
        echo $args['before_output'] . $echo . $args['after_output'];
}
function create_shortcode_popup() {
        return '<p style="text-align: center;"><span style="font-family: helvetica, arial, sans-serif;"><a class="btn-res1" href="#section4-id">'. __('Get quotation','master-gf').'</a></span></p>';
}
//Tạo shortcode tên là [test_shortcode] và sẽ thực thi code từ function create_shortcode
add_shortcode( 'popup', 'create_shortcode_popup' );
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
        
        if (cele_is_amp()) {

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


add_filter('nav_menu_item_title', 'my_nav_menu_item_title', 10, 4);
function my_nav_menu_item_title( $title, $item, $args, $depth ) {

    if (get_field('image',$item)) {
        // first level
        $title = '<strong><img src="'.get_field('image',$item).'"></strong><span style="margin-left: 5px;">' . $title . '</span>';
    }

    return $title;

}
///////////////////// RATING SYSTEM ////////////////
//add_action( 'comment_form_logged_in_after', 'ci_comment_rating_rating_field' );
//add_action( 'comment_form_before_fields', 'ci_comment_rating_rating_field' );
function ci_comment_rating_rating_field () {
    ?>
    <label for="rating">Đánh giá cho dự án:</label>
    <fieldset class="comments-rating">
        <span class="rating-container">
            <?php for ( $i = 10; $i >= 1; $i-- ) : ?>
                <input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" /><label for="rating-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
            <?php endfor; ?>
            <input type="radio" id="rating-0" class="star-cb-clear" name="rating" value="0" /><label for="rating-0">0</label>
        </span>
    </fieldset>
    <?php
}
add_action( 'comment_post', 'ci_comment_rating_save_comment_rating' );
function ci_comment_rating_save_comment_rating( $comment_id ) {
	
	if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') )
    		  $phone = wp_filter_nohtml_kses($_POST['phone']);
    		  add_comment_meta( $comment_id, 'phone', $phone );
	
    if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
            $rating = intval( $_POST['rating'] );
            add_comment_meta( $comment_id, 'rating', $rating );
}
function ci_comment_rating_get_average_ratings( $id ) {
    $comments = get_approved_comments( $id );

    if ( $comments ) {
        $i = 0;
        $total = 0;
        foreach( $comments as $comment ){
            $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
            if( isset( $rate ) && '' !== $rate ) {
                $i++;
                $total += $rate;
            }
        }

        if ( 0 === $i ) {
            return false;
        } else {
            return round( $total / $i, 1 );
        }
    } else {
        return false;
    }
}
function ci_comment_rating_get_total_ratings( $id ) {
    $comments = get_approved_comments( $id );

    if ( $comments ) {
        $i = 0;
     //   $total = 0;
        foreach( $comments as $comment ){
            $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
            if( isset( $rate ) && '' !== $rate ) {
                $i++;
               // $total += $rate;
            }
        }

        if ( 0 === $i ) {
            return false;
        } else {
            return $i;
        }
    } else {
        return false;
    }
}
add_filter( 'comment_form_default_fields', 'wpsites_comment_form_fields' );
function wpsites_comment_form_fields( $fields ) {
    unset($fields['author']);
    unset($fields['email']);
    unset($fields['url']);
    unset($fields['cookies']);
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields['author'] = '<p class="comment-author"><input aria-label="Comment" placeholder="'.__('Your name (*)','master-gf').'" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />';
        $fields['phone'] = '<input aria-label="Your phone" placeholder="'.__('Your phone (*)','master-gf').'" id="phone" name="phone"  type="number"  size="11"' . $aria_req . ' />';           
        $fields['email']  = '<input id="email" aria-label="Your Name" placeholder="'.__('Your email (*)','master-gf').'" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
    return $fields;
}
//add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
function verify_comment_meta_data( $commentdata ) {
    if ( ! isset( $_POST['phone'] ) )
        wp_die( __( 'Error: please fill the required field (phone).' ) );
    return $commentdata;
}
function attach_city_to_author( $author ) {
    $cities = get_comment_meta( get_comment_ID(), 'phone', false );
    if ( $cities ) {
        $author .= ' ( ';
        foreach ( $cities as $city )
            $author .= $city . ' ';
        $author .= ')';
    }
    return $author;
}
add_action( 'wp_ajax_nopriv_list_order', 'list_order' );
add_action( 'wp_ajax_list_order', 'list_order' );
function list_order() {
    $rows = get_field('cele_fake','option');
    if($rows)
    {
        shuffle( $rows );
     
        $row = $rows[0];
       
    echo '<li class="content_order">
    <div class="content">
        <div class="name">'.$row['content'].'</div>
    </div>
</li>';
    
    }

die();
}
function stars($all){
    $whole = floor($all);
    $fraction = $all - $whole;
    
    if($fraction < .25){
        $dec=0;
    }elseif($fraction >= .25 && $fraction < .75){
        $dec=.50;
    }elseif($fraction >= .75){
        $dec=1;
    }
    $r = $whole + $dec;
    
    //As we sometimes round up, we split again  
    $stars = "";
    $newwhole = floor($r);
    $upwhole = ceil($r);
    $thieu = 5 - $upwhole;
    $fraction = $r - $newwhole;
    for($s=1;$s<=$newwhole;$s++){
            $stars .= '<li><span class="celeicon star-100">&nbsp;</span></li>';   
        }
    if($fraction==.5){
        $stars .= '<li><span class="celeicon star-50">&nbsp;</span></li>';   
    }
    for($s=1;$s<=$thieu;$s++){
            $stars .= '<li><span class="celeicon star-00">&nbsp;</span></li>';   
        }

        echo $stars;
}
function isa_remove_jquery_migrate( &$scripts) {
    if(!is_admin()) {
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
    }
}
add_filter( 'wp_default_scripts', 'isa_remove_jquery_migrate' );


function my_deregister_scripts(){
  // wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );
add_action( 'wp_ajax_cele_ajax', 'cele_ajax_form' );
add_action( 'wp_ajax_nopriv_cele_ajax', 'cele_ajax_form' );
function cele_ajax_form() {
    $arg['email'] = (isset($_POST['order_email']))?esc_attr($_POST['order_email']) : '';
    $arg['name'] = (isset($_POST['order_name']))?esc_attr($_POST['order_name']) : '';
    $arg['phone'] = (isset($_POST['order_phone']))?esc_attr($_POST['order_phone']) : '';
    $arg['link'] = (isset($_POST['order_link']))?esc_attr($_POST['order_link']) : '';
    cele_zoho ($arg);
    cele_sendy ($arg);
    cele_mail ($arg);
    wp_send_json_success($email);
    die();//bắt buộc phải có khi kết thúc
}
add_action( 'wp_ajax_cele_content_ajax', 'cele_content_ajax' );
add_action( 'wp_ajax_nopriv_cele_content_ajax', 'cele_content_ajax' );
function cele_content_ajax() {
    $arg['phone'] = (isset($_POST['order_phone']))?esc_attr($_POST['order_phone']) : '';
    $arg['link'] = (isset($_POST['order_link']))?esc_attr($_POST['order_link']) : '';
    cele_zoho ($arg);
    cele_sendy ($arg);
    cele_mail ($arg);
    wp_send_json_success($email);
    die();//bắt buộc phải có khi kết thúc
}
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
function namespace_handle_amp_form_submit() {   
     $redirect_url = get_field('cele_returnurl','option');
      header( "Content-Type: application/json" );
      header( "access-control-allow-credentials: true" );
      header( "access-control-allow-headers: Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token" );
      header( "access-control-allow-methods: POST, GET, OPTIONS" );
      header( "access-control-allow-origin: https://" . str_replace('.', '-',$_SERVER['HTTP_HOST']) .".cdn.ampproject.org" );
      header( "access-control-expose-headers: AMP-Access-Control-Allow-Source-Origin" );
      header( "AMP-Access-Control-Allow-Source-Origin: https://".$_SERVER['HTTP_HOST'] );
    $mobile = isset($_POST['Mobile']) ? $_POST['Mobile'] : '';
    if (!preg_match('/^(08|09|03|07|05)[0-9]{8}$/', $mobile)) {
        header('X-PHP-Response-Code: 400', true, 400);
        $data = 'Số điện thoại sai định dạng';
    } else {      
        usleep(1);
        header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");
        $arg['phone'] = $mobile;
        $arg['link'] = isset($_POST['link']) ? $_POST['link'] : '';
        header("AMP-Redirect-To: ".$redirect_url);
        cele_zoho ($arg);
      //  cele_sendy ($arg);
        cele_mail ($arg);
    }
    $output = ['data' => $data];  
    wp_send_json($output);
    die();
   // handle_form_submission();
  }
  add_action("wp_ajax_amp_form_submit", "namespace_handle_amp_form_submit");
  add_action("wp_ajax_nopriv_amp_form_submit", "namespace_handle_amp_form_submit");

  add_action("wp_ajax_amp_formfooter_submit", "namespace_handle_amp_formfooter_submit");
  add_action("wp_ajax_nopriv_amp_formfooter_submit", "namespace_handle_amp_formfooter_submit");



  function namespace_handle_amp_formfooter_submit() {
    
    $redirect_url = get_field('cele_returnurl','option');
     header( "Content-Type: application/json" );
     header( "access-control-allow-credentials: true" );
     header( "access-control-allow-headers: Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token" );
     header( "access-control-allow-methods: POST, GET, OPTIONS" );
     header( "access-control-allow-origin: https://" . str_replace('.', '-',$_SERVER['HTTP_HOST']) .".cdn.ampproject.org" );
     header( "access-control-expose-headers: AMP-Access-Control-Allow-Source-Origin" );
     header( "AMP-Access-Control-Allow-Source-Origin: https://".$_SERVER['HTTP_HOST'] );
    

   $mobile = isset($_POST['Mobile']) ? $_POST['Mobile'] : '';
   $email = isset($_POST['Email']) ? $_POST['Email'] : '';
   $email = strtolower($email);
   $name = isset($_POST['Name']) ? $_POST['Name'] : 'Noname';

   
   if (!preg_match('/^(08|09|03|07|05)[0-9]{8}$/', $mobile)) {
       header('X-PHP-Response-Code: 400', true, 400);
       $data = 'Số điện thoại không chính xác';
        $output = ['data' => $data];
       wp_send_json($output);
       die();
   } 

   if (!preg_match('/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/', $email)) {
    header('X-PHP-Response-Code: 400', true, 400);
    $data = 'Email không chính xác';
    $output = ['data' => $data];
    wp_send_json($output);
    die();
    }  
       usleep(1);
       header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");
       $arg['name'] = $name;
       $arg['email'] = $email;
       $arg['phone'] = $mobile;
       $arg['link'] = isset($_POST['link']) ? $_POST['link'] : '';
       header("AMP-Redirect-To: ".$redirect_url);
       cele_zoho ($arg);
       cele_sendy ($arg);
       cele_mail ($arg);
   wp_send_json($output);
   die();

  // handle_form_submission();
 }
function cele_zoho ($arg) {

      $url = "https://crm.zoho.com/crm/WebToLeadForm";
      wp_remote_post( $url, array(
        'method' => 'POST',
        'timeout' => 45,
        //'redirection' => none,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => array( 'Last Name' => $arg['name'],
                         'Mobile' => $arg['phone'],
                         'Email' => $arg['email'],
                         'Website' => $arg['link'],
                        // 'Designation' => $vitri,
                         'xnQsjsdp' => '0869bfcdc841d22b11056a01a5da5637e4e8db2bc08f85c424203d0cef452600',
                         'xmIwtLD' => '3aa5421eef8a37948d2901c21c5e182f3605e34f37664b817c432e5d864d7d6a',
                         'actionType' => 'TGVhZHM=',
                        ),
        'cookies' => array()
          )
      );
}
function cele_sendy($arg) {
    $list = get_field('cele_list_sendy','option');
     if ($list) {

            $url = "https://svmail.nhadat86.vn/subscribe";

        wp_remote_post( $url, array(
          'method' => 'POST',
          'timeout' => 45,
          //'redirection' => none,
          'httpversion' => '1.0',
          'blocking' => true,
          'headers' => array(),
          'body' => array( 'name' => $arg['name'],     
                           'email' => $arg['email'],
                           'list'   =>  $list,
                          'Phone' => $arg['phone']
                          ),
          'cookies' => array()
            )
        );
    

       } 
}

function cele_mail($arg) {
             $to = get_field('cele_email_form','option');
        if ($to) {
            $subject = "Đăng ký mới từ ".$arg['name']." ".$arg['phone'];
            $headers =  'MIME-Version: 1.0' . "\r\n" .
                        'Content-type:text/html;charset=UTF-8' . "\r\n" .
                        'From: '. $arg['email'] . "\r\n" .
                        'Reply-To: ' . $arg['email'] . "\r\n";
            $message = '
                    <html>
                    <head>
                        <title>Thông tin khách đăng ký mới</title>
                    </head>
                    <body>
                        <h1>Bạn đã có 1 khách hàng mới!</h1>
                        <table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
                            <tr>
                                <th>Tên:</th><td>'.$arg['name'].'</td>
                            </tr>
                            <tr style="background-color: #e0e0e0;">
                                <th>Email:</th><td>'.$arg['email'].'</td>
                            </tr>
                            <tr>
                                <th>Website:</th><td><a href="'.$arg['link'].'">'.$arg['link'].'</a></td>
                            </tr>
                             <tr style="background-color: #e0e0e0;">
                                <th>Mobile :</th><td>'.$arg['phone'].'</td>
                            </tr>
                        </table>
                    </body>
                    </html>';

            wp_mail($to, $subject, $message, $headers);

          }
      }
add_action( 'add_meta_boxes_comment', 'comment_add_meta_box' );
function comment_add_meta_box()
{
 add_meta_box( 'my-comment-title', __( 'Số điện thoại' ), 'comment_meta_box_age',     'comment', 'normal', 'high' );
}

function comment_meta_box_age( $comment )
{
    $title = get_comment_meta( $comment->comment_ID, 'phone', true );

   ?>
 <p>
     <label for="phone"><?php echo esc_attr( $title ); ?></label>
 </p>
 <?php
}

add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

function sdt_remove_ver_css_js( $src, $handle ) 
{
    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;
}

function replace_core_jquery_version() {
    wp_deregister_script( 'jquery-core' );

    wp_register_script( 'jquery-core', get_template_directory_uri() . '/js/jquery.js', array(), '3.1.1' );
    wp_deregister_script( 'jquery-migrate' );
    wp_register_script( 'jquery-migrate',get_template_directory_uri() . 'jquery-migrate.js' , array(), '3.0.0' );
}

if(!class_exists( 'DrawAttention' ) ) {
	add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );
}



/**
 * Disable the emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
   }
   add_action( 'init', 'disable_emojis' );
   
   /**
    * Filter function used to remove the tinymce emoji plugin.
    * 
    * @param array $plugins 
    * @return array Difference betwen the two arrays
    */
   function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
    return array();
    }
   }
   
   /**
    * Remove emoji CDN hostname from DNS prefetching hints.
    *
    * @param array $urls URLs to print for resource hints.
    * @param string $relation_type The relation type the URLs are printed for.
    * @return array Difference betwen the two arrays.
    */
   function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
   
   $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
   
   return $urls;
   }


function cele_is_amp() {
    return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}


function cele_logo(){
    $logo = (wp_is_mobile()) ? get_option( 'options_cele_logo_mobile' ) : get_option( 'options_cele_logo' );
    if (!$logo) {return;} 
    $src = wp_get_attachment_image_src($logo,'full',false);
    $content = get_bloginfo('description');
    
    if ( !cele_is_amp() ) {
        echo '<img src="'.$src[0].'" class="img-responsive" width="'.$src[1].'" height="'.$src[2].'" title="'.$content.'" alt="'.$content.'">';
    } else {
        echo '<amp-img src="'.$src[0].'" layout="fixed" width="'.$src[1].'" height="'.$src[2].'" title="'.$content.'" alt="'.$content.'"><div fallback>offline</div></amp-img>';
    }
}
function cele_logo_footer(){
    $logo =  get_option( 'options_cele_logo_footer' );
    if (!$logo) {return;} 
    $src = wp_get_attachment_image_src($logo,'full',false);
    $content = get_bloginfo('description');
    
    if ( !cele_is_amp() ) {
        echo '<img src="'.$src[0].'" class="img-responsive" width="'.$src[1].'" height="'.$src[2].'" title="'.$content.'" alt="'.$content.'">';
    } else {
        echo '<amp-img src="'.$src[0].'" layout="fixed" width="'.$src[1].'" height="'.$src[2].'" title="'.$content.'" alt="'.$content.'"><div fallback>offline</div></amp-img>';
    }
}



function cele_form_var(){
    if (!cele_is_amp()) {
    echo '<script type="text/javascript">
            var ajaxurl = "'.admin_url('admin-ajax.php').'";
            var returnurl = "'.get_field('cele_returnurl','option').'";
            var error1 = "'.get_field('cele_error1',pll_current_language('slug')).'"
            var error2 = "'.get_field('cele_error2',pll_current_language('slug')).'"
            var error3 = "'.get_field('cele_error3',pll_current_language('slug')).'"
            var error4 = "'.get_field('cele_error4',pll_current_language('slug')).'"
            var error5 = "'.get_field('cele_error5',pll_current_language('slug')).'"
        </script>';
    }
}

add_action('wp_head', 'cele_form_var');

function back_to_top(){
    $action = (cele_is_amp()) ? 'on="tap:top.scrollTo(duration=600)"' : '';

    echo '<a class="back-to-top" '.$action.'  title="back to top" role="button"><svg class="icon"><use xlink:href="#up-arrow-key"></use></svg></a>';
}

function menu_amp(){
    if(cele_is_amp()) {

        echo '<amp-sidebar id="sidebar" class="amp-menu" layout="nodisplay" side="right">';
        html5blank_nav_amp();
        echo '</amp-sidebar>';
    }
    
}
function html5blank_nav_amp()
{
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
        'walker'          => new Better_AMP_Menu_Walker
        )
    );
}
add_action('cele_before_header','back_to_top');
add_action('cele_before_wrapper','menu_amp');

function create_posttype_cauhoi() {
 
    register_post_type( 'cauhoi',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Câu hỏi' ),
                'singular_name' => __( 'Câu hỏi' )
            ),
            'public' => true,
            'has_archive' => false,
   
            'show_ui' => true,
            'rewrite' => array('slug' => 'cauhoi'),
            'supports' => array( 'title', 'editor', 'comments'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_cauhoi' );


add_filter('user_contactmethods', 'custom_user_contactmethods');
function custom_user_contactmethods($user_contact){ 
  $user_contact['ext_phone'] = 'Số điện thoại';
  
  return $user_contact;
}


function mu_hide_plugins_network( $plugins ) {
// let's hide akismet
if( in_array( 'remove-taxonomy-base-slug/remove-taxonomy-base-slug.php', array_keys( $plugins ) ) ) {
unset( $plugins['remove-taxonomy-base-slug/remove-taxonomy-base-slug.php'] );
}

return $plugins;
}
add_filter( 'all_plugins', 'mu_hide_plugins_network' );

add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
  echo '<style>
    #menu-plugins ul li:nth-child(5){display:none}

  </style>';
}

function get_excerpt(){
$excerpt = get_the_content();
$excerpt = preg_replace(" ([.*?])",'',$excerpt);
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$excerpt = substr($excerpt, 0, 180);
$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
return $excerpt;
}

function rao_vat() {
            $labels = array(
                'name'                => __( 'Rao Vặt', 'text-domain' ),
                'singular_name'       => __( 'Rao Vặt', 'text-domain' ),
                'add_new'             => _x( 'Add New Rao Vặt', 'text-domain', 'text-domain' ),
                'add_new_item'        => __( 'Add New Rao Vặt', 'text-domain' ),
                'edit_item'           => __( 'Edit Rao Vặt', 'text-domain' ),
                'new_item'            => __( 'New Rao Vặt', 'text-domain' ),
                'view_item'           => __( 'View Rao Vặt', 'text-domain' ),
                'search_items'        => __( 'Search Rao Vặt', 'text-domain' ),
                'not_found'           => __( 'No Rao Vặt found', 'text-domain' ),
                'not_found_in_trash'  => __( 'No Rao Vặt found in Trash', 'text-domain' ),
                'parent_item_colon'   => __( 'Parent Rao Vặt:', 'text-domain' ),
                'menu_name'           => __( 'Rao Vặt', 'text-domain' ),
            );
            $args = array(
                'labels'                   => $labels,
                'hierarchical'        => false,
                'description'         => 'description',
                'taxonomies'          => array(),
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => null,
                'menu_icon'           => null,
                'show_in_nav_menus'   => true,
                'publicly_queryable'  => true,
                'exclude_from_search' => false,
                'has_archive'         => true,
                'query_var'           => true,
                'can_export'          => true,
                'rewrite'             => true,
                'capability_type'     => 'post',
                'supports'            => array(
                    'title', 'editor', 'author', 'thumbnail',
                    'excerpt','custom-fields', 'trackbacks', 'comments',
                    'revisions', 'page-attributes', 'post-formats'
                    )
            );
            register_post_type( 'rao-vat', $args );
        }
        add_action( 'init', 'rao_vat' );


        function san_pham() {
    
        $labels = array(
            'name'                  => _x( 'Sản phẩm', 'Taxonomy Sản phẩm', 'text-domain' ),
            'singular_name'         => _x( 'Sản phẩm', 'Taxonomy Sản phẩm', 'text-domain' ),
            'search_items'          => __( 'Search Sản phẩm', 'text-domain' ),
            'popular_items'         => __( 'Popular Sản phẩm', 'text-domain' ),
            'all_items'             => __( 'All Sản phẩm', 'text-domain' ),
            'parent_item'           => __( 'Parent Sản phẩm', 'text-domain' ),
            'parent_item_colon'     => __( 'Parent Sản phẩm', 'text-domain' ),
            'edit_item'             => __( 'Edit Sản phẩm', 'text-domain' ),
            'update_item'           => __( 'Update Sản phẩm', 'text-domain' ),
            'add_new_item'          => __( 'Add New Sản phẩm', 'text-domain' ),
            'new_item_name'         => __( 'New Sản phẩm Name', 'text-domain' ),
            'add_or_remove_items'   => __( 'Add or remove Sản phẩm', 'text-domain' ),
            'choose_from_most_used' => __( 'Choose from most used text-domain', 'text-domain' ),
            'menu_name'             => __( 'Sản phẩm', 'text-domain' ),
        );
    
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => false,
            'show_ui'           => true,
            'query_var'         => true,
            'rewrite'           => true,
            'query_var'         => true,
            'capabilities'      => array(),
        );
    
        register_taxonomy( 'san-pham', array( 'rao-vat' ), $args );
    }
    
    add_action( 'init', 'san_pham' );


    function danh_muc_loai_hinh() {
            $labels = array(
                                    'name'                  => _x( 'Loại Hình', 'Taxonomy Loại Hình', 'text-domain' ),
                            'singular_name'         => _x( 'Loại Hình', 'Taxonomy Loại Hình', 'text-domain' ),
                            'search_items'          => __( 'Search Loại Hình', 'text-domain' ),
                            'popular_items'         => __( 'Popular Loại Hình', 'text-domain' ),
                                'all_items'             => __( 'All Loại Hình', 'text-domain' ),
                            'parent_item'           => __( 'Parent Loại Hình', 'text-domain' ),
                        'parent_item_colon'     => __( 'Parent Loại Hình', 'text-domain' ),
                                'edit_item'             => __( 'Edit Loại Hình', 'text-domain' ),
                            'update_item'           => __( 'Update Loại Hình', 'text-domain' ),
                            'add_new_item'          => __( 'Add New Loại Hình', 'text-domain' ),
                            'new_item_name'         => __( 'New Loại Hình Name', 'text-domain' ),
                    'add_or_remove_items'   => __( 'Add or remove Loại Hình', 'text-domain' ),
                    'choose_from_most_used' => __( 'Choose from most used text-domain', 'text-domain' ),
                                'menu_name'             => __( 'Loại Hình', 'text-domain' ),
            );
            $args = array(
                'labels'            => $labels,
                'public'            => true,
                'show_in_nav_menus' => true,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'show_tagcloud'     => false,
                'show_ui'           => true,
                'query_var'         => true,
                'rewrite'           => true,
                'query_var'         => true,
                'capabilities'      => array(),
                'rewrite' => array( 'slug' => 'loai-hinh' ),
            );
            register_taxonomy( 'danh-muc-loai-hinh', array( 'rao-vat' ), $args );
        }
        add_action( 'init', 'danh_muc_loai_hinh' );

        function tinh_thanh() {
    
        $labels = array(
            'name'                  => _x( 'Tình thành', 'Taxonomy Tình thành', 'text-domain' ),
            'singular_name'         => _x( 'Tình thành', 'Taxonomy Tình thành', 'text-domain' ),
            'search_items'          => __( 'Search Tình thành', 'text-domain' ),
            'popular_items'         => __( 'Popular Tình thành', 'text-domain' ),
            'all_items'             => __( 'All Tình thành', 'text-domain' ),
            'parent_item'           => __( 'Parent Tình thành', 'text-domain' ),
            'parent_item_colon'     => __( 'Parent Tình thành', 'text-domain' ),
            'edit_item'             => __( 'Edit Tình thành', 'text-domain' ),
            'update_item'           => __( 'Update Tình thành', 'text-domain' ),
            'add_new_item'          => __( 'Add New Tình thành', 'text-domain' ),
            'new_item_name'         => __( 'New Tình thành Name', 'text-domain' ),
            'add_or_remove_items'   => __( 'Add or remove Tình thành', 'text-domain' ),
            'choose_from_most_used' => __( 'Choose from most used text-domain', 'text-domain' ),
            'menu_name'             => __( 'Tình thành', 'text-domain' ),
        );
    
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => false,
            'show_ui'           => true,
            'query_var'         => true,
            'rewrite'           => true,
            'query_var'         => true,
            'capabilities'      => array(),
        );
    
        register_taxonomy( 'tinh-thanh', array( 'rao-vat' ), $args );
    }
    
    add_action( 'init', 'tinh_thanh' );


    function chu_dau_tu() {
    
        $labels = array(
            'name'                  => _x( 'Chủ Đầu Tư', 'Taxonomy Chủ Đầu Tư', 'text-domain' ),
            'singular_name'         => _x( 'Chủ Đầu Tư', 'Taxonomy Chủ Đầu Tư', 'text-domain' ),
            'search_items'          => __( 'Search Chủ Đầu Tư', 'text-domain' ),
            'popular_items'         => __( 'Popular Chủ Đầu Tư', 'text-domain' ),
            'all_items'             => __( 'All Chủ Đầu Tư', 'text-domain' ),
            'parent_item'           => __( 'Parent Chủ Đầu Tư', 'text-domain' ),
            'parent_item_colon'     => __( 'Parent Chủ Đầu Tư', 'text-domain' ),
            'edit_item'             => __( 'Edit Chủ Đầu Tư', 'text-domain' ),
            'update_item'           => __( 'Update Chủ Đầu Tư', 'text-domain' ),
            'add_new_item'          => __( 'Add New Chủ Đầu Tư', 'text-domain' ),
            'new_item_name'         => __( 'New Chủ Đầu Tư Name', 'text-domain' ),
            'add_or_remove_items'   => __( 'Add or remove Chủ Đầu Tư', 'text-domain' ),
            'choose_from_most_used' => __( 'Choose from most used text-domain', 'text-domain' ),
            'menu_name'             => __( 'Chủ Đầu Tư', 'text-domain' ),
        );
    
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => false,
            'show_ui'           => true,
            'query_var'         => true,
            'rewrite'           => true,
            'query_var'         => true,
            'capabilities'      => array(),
        );
    
        register_taxonomy( 'chu-dau-tu', array( 'post' ), $args );
    }
    
    add_action( 'init', 'chu_dau_tu' );

    add_action('wp_ajax_Post_filters', 'Post_filters');
    add_action('wp_ajax_nopriv_Post_filters', 'Post_filters');
    function Post_filters() {
        if(isset($_POST['data'])){
            $data = $_POST['data'];
            echo '<ul>';
            $getposts = new WP_query(); $getposts->query('post_type=post&post_status=publish&showposts=5&s='.$data);
            global $wp_query; $wp_query->in_the_loop = true;
            while ($getposts->have_posts()) : $getposts->the_post();
                echo '<li><a target="_blank" href="'.get_the_permalink().'">'.get_the_title().'</a></li>'; 
            endwhile; wp_reset_postdata();
            echo '</ul>';
            die(); 
        }
    };

/* check if user is administrator - only show downloads menu if is admin */
add_action( 'admin_init', 'nh_remove_menu_pages' );
function nh_remove_menu_pages() {
    global $user_ID;
    //if the user is NOT an administrator remove the menu for downloads
    if ( !current_user_can( 'administrator' ) ) { //change role or capability here
         remove_menu_page( 'index.php' ); //change menu item here
        remove_menu_page( 'edit.php?post_type=cauhoi' ); //change menu item here
        remove_menu_page( 'admin.php?page=theme-general-settings' ); //change menu item here
        remove_menu_page( 'edit.php' );                   //Posts
        remove_menu_page( 'edit-comments.php' );          //Comments
    }
}

function wpse_11826_search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode( ' AND ', $search );
    }

    return $search;
}

add_filter( 'posts_search', 'wpse_11826_search_by_title', 10, 2 );

function my_taxonomies_vitri() {
$labels = array(
'name'                  => _x( 'Danh mục vị trí', 'Taxonomy', 'text-domain' ),
'singular_name'         => _x( 'Danh mục vị trí', 'Taxonomy', 'text-domain' ),
'search_items'          => __( 'Tìm kiếm', 'text-domain' ),
'popular_items'         => __( 'Phổ biến', 'text-domain' ),
'all_items'             => __( 'Tất cả', 'text-domain' ),
'parent_item'           => __( 'Gốc', 'text-domain' ),
'parent_item_colon'     => __( 'Gốc', 'text-domain' ),
'edit_item'             => __( 'Chỉnh sửa', 'text-domain' ),
'update_item'           => __( 'Cập nhật', 'text-domain' ),
'add_new_item'          => __( 'Thêm mới', 'text-domain' ),
'new_item_name'         => __( 'Mới nhất', 'text-domain' ),
'add_or_remove_items'   => __( 'Thêm hoặc xoá', 'text-domain' ),
'choose_from_most_used' => __( 'Chọn từ được sử dụng nhiều nhất', 'text-domain' ),
'menu_name'             => __( 'Danh mục vị trí', 'text-domain' ),
);
$args = array(
'labels'            => $labels,
'public'            => true,
'show_in_nav_menus' => true,
'show_admin_column' => false,
'hierarchical'      => true,
'show_tagcloud'     => false,
'show_ui'           => true,
'query_var'         => true,
'rewrite'           => true,
'query_var'         => true,
'capabilities'      => array(),
);
register_taxonomy( 'danh-muc-vi-tri', array( 'post' ), $args );
}
add_action( 'init', 'my_taxonomies_vitri' );

function my_taxonomies_tienich() {
$labels = array(
'name'                  => _x( 'Danh mục tiện ích', 'Taxonomy', 'text-domain' ),
'singular_name'         => _x( 'Danh mục tiện ích', 'Taxonomy', 'text-domain' ),
'search_items'          => __( 'Tìm kiếm', 'text-domain' ),
'popular_items'         => __( 'Phổ biến', 'text-domain' ),
'all_items'             => __( 'Tất cả', 'text-domain' ),
'parent_item'           => __( 'Gốc', 'text-domain' ),
'parent_item_colon'     => __( 'Gốc', 'text-domain' ),
'edit_item'             => __( 'Chỉnh sửa', 'text-domain' ),
'update_item'           => __( 'Cập nhật', 'text-domain' ),
'add_new_item'          => __( 'Thêm mới', 'text-domain' ),
'new_item_name'         => __( 'Mới nhất', 'text-domain' ),
'add_or_remove_items'   => __( 'Thêm hoặc xoá', 'text-domain' ),
'choose_from_most_used' => __( 'Chọn từ được sử dụng nhiều nhất', 'text-domain' ),
'menu_name'             => __( 'Danh mục tiện ích', 'text-domain' ),
);
$args = array(
'labels'            => $labels,
'public'            => true,
'show_in_nav_menus' => true,
'show_admin_column' => false,
'hierarchical'      => true,
'show_tagcloud'     => false,
'show_ui'           => true,
'query_var'         => true,
'rewrite'           => true,
'query_var'         => true,
'capabilities'      => array(),
);
register_taxonomy( 'danh-muc-tien-ich', array( 'post' ), $args );
}
add_action( 'init', 'my_taxonomies_tienich' );
?>
<?php if(!wp_is_mobile()) : ?>
<?php
if ( ! class_exists( 'LazyLoad_Images' ) ) :
class LazyLoad_Images {

    const version = '0.6.1';
    protected static $enabled = true;

    static function init() {
        if ( is_admin() )
            return;

        if ( ! apply_filters( 'lazyload_is_enabled', true ) ) {
            self::$enabled = false;
            return;
        }

        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_scripts' ) );
        add_action( 'wp_head', array( __CLASS__, 'setup_filters' ), 9999 ); // we don't really want to modify anything in <head> since it's mostly all metadata, e.g. OG tags
    }

    static function setup_filters() {
        add_filter( 'the_content', array( __CLASS__, 'add_image_placeholders' ), 99 ); // run this later, so other content filters have run, including image_add_wh on WP.com
        add_filter( 'post_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 11 );
        add_filter( 'get_avatar', array( __CLASS__, 'add_image_placeholders' ), 11 );
    }

    static function add_image_placeholders( $content ) {
        if ( ! self::is_enabled() )
            return $content;

        // Don't lazyload for feeds, previews, mobile
        if( is_feed() || is_preview() )
            return $content;

        // Don't lazy-load if the content has already been run through previously
        if ( false !== strpos( $content, 'data-lazy-src' ) )
            return $content;

        // This is a pretty simple regex, but it works
        $content = preg_replace_callback( '#<(img)([^>]+?)(>(.*?)</\\1>|[\/]?>)#si', array( __CLASS__, 'process_image' ), $content );

        return $content;
    }

    static function process_image( $matches ) {
        // In case you want to change the placeholder image
        $placeholder_image = apply_filters( 'lazyload_images_placeholder_image', self::get_url( '1x1.trans.gif' ) );

        $old_attributes_str = $matches[2];
        $old_attributes = wp_kses_hair( $old_attributes_str, wp_allowed_protocols() );

        if ( empty( $old_attributes['src'] ) ) {
            return $matches[0];
        }

        $image_src = $old_attributes['src']['value'];

        // Remove src and lazy-src since we manually add them
        $new_attributes = $old_attributes;
        unset( $new_attributes['src'], $new_attributes['data-lazy-src'] );

        $new_attributes_str = self::build_attributes_string( $new_attributes );

        return sprintf( '<img src="%1$s" data-lazy-src="%2$s" %3$s><noscript>%4$s</noscript>', esc_url( $placeholder_image ), esc_url( $image_src ), $new_attributes_str, $matches[0] );
    }

    private static function build_attributes_string( $attributes ) {
        $string = array();
        foreach ( $attributes as $name => $attribute ) {
            $value = $attribute['value'];
            if ( '' === $value ) {
                $string[] = sprintf( '%s', $name );
            } else {
                $string[] = sprintf( '%s="%s"', $name, esc_attr( $value ) );
            }
        }
        return implode( ' ', $string );
    }

    static function is_enabled() {
        return self::$enabled;
    }

    static function get_url( $path = '' ) {
        return plugins_url( ltrim( $path, '/' ), __FILE__ );
    }
}
function lazyload_images_add_placeholders( $content ) {
    return LazyLoad_Images::add_image_placeholders( $content );
}
add_action( 'init', array( 'LazyLoad_Images', 'init' ) );
endif;
?>
<?php endif; ?>
