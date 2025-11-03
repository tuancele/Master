<?php
function create_posttype_cauhoi() {
    register_post_type('cauhoi', array(
        'labels' => array(
            'name' => __('Câu hỏi'),
            'singular_name' => __('Câu hỏi')
        ),
        'public' => true,
        'has_archive' => false,
        'show_ui' => true,
        'rewrite' => array('slug' => 'cauhoi'),
        'supports' => array('title', 'editor', 'comments'),
    ));
}
add_action('init', 'create_posttype_cauhoi');

function rao_vat() {
    $labels = array(
        'name' => __('Rao Vặt', 'text-domain'),
        'singular_name' => __('Rao Vặt', 'text-domain'),
        'add_new' => _x('Add New Rao Vặt', 'text-domain', 'text-domain'),
        'add_new_item' => __('Add New Rao Vặt', 'text-domain'),
        'edit_item' => __('Edit Rao Vặt', 'text-domain'),
        'new_item' => __('New Rao Vặt', 'text-domain'),
        'view_item' => __('View Rao Vặt', 'text-domain'),
        'search_items' => __('Search Rao Vặt', 'text-domain'),
        'not_found' => __('No Rao Vặt found', 'text-domain'),
        'not_found_in_trash' => __('No Rao Vặt found in Trash', 'text-domain'),
        'parent_item_colon' => __('Parent Rao Vặt:', 'text-domain'),
        'menu_name' => __('Rao Vặt', 'text-domain'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'description',
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_position' => null,
        'menu_icon' => null,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'supports' => array(
            'title', 'editor', 'author', 'thumbnail',
            'excerpt', 'custom-fields', 'trackbacks', 'comments',
            'revisions', 'page-attributes', 'post-formats'
        )
    );
    register_post_type('rao-vat', $args);
}
add_action('init', 'rao_vat');

function san_pham() {
    $labels = array(
        'name' => _x('Sản phẩm', 'Taxonomy Sản phẩm', 'text-domain'),
        'singular_name' => _x('Sản phẩm', 'Taxonomy Sản phẩm', 'text-domain'),
        'search_items' => __('Search Sản phẩm', 'text-domain'),
        'popular_items' => __('Popular Sản phẩm', 'text-domain'),
        'all_items' => __('All Sản phẩm', 'text-domain'),
        'parent_item' => __('Parent Sản phẩm', 'text-domain'),
        'parent_item_colon' => __('Parent Sản phẩm', 'text-domain'),
        'edit_item' => __('Edit Sản phẩm', 'text-domain'),
        'update_item' => __('Update Sản phẩm', 'text-domain'),
        'add_new_item' => __('Add New Sản phẩm', 'text-domain'),
        'new_item_name' => __('New Sản phẩm Name', 'text-domain'),
        'add_or_remove_items' => __('Add or remove Sản phẩm', 'text-domain'),
        'choose_from_most_used' => __('Choose from most used text-domain', 'text-domain'),
        'menu_name' => __('Sản phẩm', 'text-domain'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'show_tagcloud' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capabilities' => array(),
    );
    register_taxonomy('san-pham', array('rao-vat'), $args);
}
add_action('init', 'san_pham');

function danh_muc_loai_hinh() {
    $labels = array(
        'name' => _x('Loại Hình', 'Taxonomy Loại Hình', 'text-domain'),
        'singular_name' => _x('Loại Hình', 'Taxonomy Loại Hình', 'text-domain'),
        'search_items' => __('Search Loại Hình', 'text-domain'),
        'popular_items' => __('Popular Loại Hình', 'text-domain'),
        'all_items' => __('All Loại Hình', 'text-domain'),
        'parent_item' => __('Parent Loại Hình', 'text-domain'),
        'parent_item_colon' => __('Parent Loại Hình', 'text-domain'),
        'edit_item' => __('Edit Loại Hình', 'text-domain'),
        'update_item' => __('Update Loại Hình', 'text-domain'),
        'add_new_item' => __('Add New Loại Hình', 'text-domain'),
        'new_item_name' => __('New Loại Hình Name', 'text-domain'),
        'add_or_remove_items' => __('Add or remove Loại Hình', 'text-domain'),
        'choose_from_most_used' => __('Choose from most used text-domain', 'text-domain'),
        'menu_name' => __('Loại Hình', 'text-domain'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'show_tagcloud' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'loai-hinh'),
        'capabilities' => array(),
    );
    register_taxonomy('danh-muc-loai-hinh', array('rao-vat'), $args);
}
add_action('init', 'danh_muc_loai_hinh');

function tinh_thanh() {
    $labels = array(
        'name' => _x('Tình thành', 'Taxonomy Tình thành', 'text-domain'),
        'singular_name' => _x('Tình thành', 'Taxonomy Tình thành', 'text-domain'),
        'search_items' => __('Search Tình thành', 'text-domain'),
        'popular_items' => __('Popular Tình thành', 'text-domain'),
        'all_items' => __('All Tình thành', 'text-domain'),
        'parent_item' => __('Parent Tình thành', 'text-domain'),
        'parent_item_colon' => __('Parent Tình thành', 'text-domain'),
        'edit_item' => __('Edit Tình thành', 'text-domain'),
        'update_item' => __('Update Tình thành', 'text-domain'),
        'add_new_item' => __('Add New Tình thành', 'text-domain'),
        'new_item_name' => __('New Tình thành Name', 'text-domain'),
        'add_or_remove_items' => __('Add or remove Tình thành', 'text-domain'),
        'choose_from_most_used' => __('Choose from most used text-domain', 'text-domain'),
        'menu_name' => __('Tình thành', 'text-domain'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'show_tagcloud' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capabilities' => array(),
    );
    register_taxonomy('tinh-thanh', array('rao-vat'), $args);
}
add_action('init', 'tinh_thanh');

function chu_dau_tu() {
    $labels = array(
        'name' => _x('Chủ Đầu Tư', 'Taxonomy Chủ Đầu Tư', 'text-domain'),
        'singular_name' => _x('Chủ Đầu Tư', 'Taxonomy Chủ Đầu Tư', 'text-domain'),
        'search_items' => __('Search Chủ Đầu Tư', 'text-domain'),
        'popular_items' => __('Popular Chủ Đầu Tư', 'text-domain'),
        'all_items' => __('All Chủ Đầu Tư', 'text-domain'),
        'parent_item' => __('Parent Chủ Đầu Tư', 'text-domain'),
        'parent_item_colon' => __('Parent Chủ Đầu Tư', 'text-domain'),
        'edit_item' => __('Edit Chủ Đầu Tư', 'text-domain'),
        'update_item' => __('Update Chủ Đầu Tư', 'text-domain'),
        'add_new_item' => __('Add New Chủ Đầu Tư', 'text-domain'),
        'new_item_name' => __('New Chủ Đầu Tư Name', 'text-domain'),
        'add_or_remove_items' => __('Add or remove Chủ Đầu Tư', 'text-domain'),
        'choose_from_most_used' => __('Choose from most used text-domain', 'text-domain'),
        'menu_name' => __('Chủ Đầu Tư', 'text-domain'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'show_tagcloud' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capabilities' => array(),
    );
    register_taxonomy('chu-dau-tu', array('post'), $args);
}
add_action('init', 'chu_dau_tu');

function my_taxonomies_vitri() {
    $labels = array(
        'name' => _x('Danh mục vị trí', 'Taxonomy', 'text-domain'),
        'singular_name' => _x('Danh mục vị trí', 'Taxonomy', 'text-domain'),
        'search_items' => __('Tìm kiếm', 'text-domain'),
        'popular_items' => __('Phổ biến', 'text-domain'),
        'all_items' => __('Tất cả', 'text-domain'),
        'parent_item' => __('Gốc', 'text-domain'),
        'parent_item_colon' => __('Gốc', 'text-domain'),
        'edit_item' => __('Chỉnh sửa', 'text-domain'),
        'update_item' => __('Cập nhật', 'text-domain'),
        'add_new_item' => __('Thêm mới', 'text-domain'),
        'new_item_name' => __('Mới nhất', 'text-domain'),
        'add_or_remove_items' => __('Thêm hoặc xoá', 'text-domain'),
        'choose_from_most_used' => __('Chọn từ được sử dụng nhiều nhất', 'text-domain'),
        'menu_name' => __('Danh mục vị trí', 'text-domain'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'show_tagcloud' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capabilities' => array(),
    );
    register_taxonomy('danh-muc-vi-tri', array('post'), $args);
}
add_action('init', 'my_taxonomies_vitri');

function my_taxonomies_tienich() {
    $labels = array(
        'name' => _x('Danh mục tiện ích', 'Taxonomy', 'text-domain'),
        'singular_name' => _x('Danh mục tiện ích', 'Taxonomy', 'text-domain'),
        'search_items' => __('Tìm kiếm', 'text-domain'),
        'popular_items' => __('Phổ biến', 'text-domain'),
        'all_items' => __('Tất cả', 'text-domain'),
        'parent_item' => __('Gốc', 'text-domain'),
        'parent_item_colon' => __('Gốc', 'text-domain'),
        'edit_item' => __('Chỉnh sửa', 'text-domain'),
        'update_item' => __('Cập nhật', 'text-domain'),
        'add_new_item' => __('Thêm mới', 'text-domain'),
        'new_item_name' => __('Mới nhất', 'text-domain'),
        'add_or_remove_items' => __('Thêm hoặc xoá', 'text-domain'),
        'choose_from_most_used' => __('Chọn từ được sử dụng nhiều nhất', 'text-domain'),
        'menu_name' => __('Danh mục tiện ích', 'text-domain'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'show_tagcloud' => false,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capabilities' => array(),
    );
    register_taxonomy('danh-muc-tien-ich', array('post'), $args);
}
add_action('init', 'my_taxonomies_tienich');
?>