<?php
function html5blank_nav() {
    wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu' => '',
        'container' => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id' => '',
        'menu_class' => 'menu',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul id="menu-menu-header" class="nav navbar-nav">%3$s</ul>',
        'depth' => 0,
        'walker' => ''
    ));
}

function html5blank_nav_mobile() {
    wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu' => '',
        'container' => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id' => '',
        'menu_class' => 'menu',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul>%3$s</ul>',
        'depth' => 0,
        'walker' => ''
    ));
}

function html5blank_nav1() {
    wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu' => '',
        'container' => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id' => '',
        'menu_class' => 'menu',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '%3$s',
        'depth' => 0,
        'walker' => ''
    ));
}

function html5blank_nav_amp() {
    wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu' => '',
        'container' => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id' => '',
        'menu_class' => 'menu',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '%3$s',
        'depth' => 2,
        'walker' => new Better_AMP_Menu_Walker
    ));
}

function register_html5_menu() {
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'html5blank'),
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'),
        'phongthuy' => __('Phong Thủy', 'html5blank'),
    ));
}
add_action('init', 'register_html5_menu');

function my_nav_menu_item_title($title, $item, $args, $depth) {
    if (get_field('image', $item)) {
        $title = '<strong><img src="' . esc_url(get_field('image', $item)) . '"></strong><span style="margin-left: 5px;">' . $title . '</span>';
    }
    return $title;
}
add_filter('nav_menu_item_title', 'my_nav_menu_item_title', 10, 4);

function menu_amp() {
    if (cele_is_amp()) {
        echo '<amp-sidebar id="sidebar" class="amp-menu" layout="nodisplay" side="right">';
        html5blank_nav_amp();
        echo '</amp-sidebar>';
    }
}
add_action('cele_before_wrapper', 'menu_amp');
?>