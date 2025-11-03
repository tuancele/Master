<?php
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-formats', array('aside', 'gallery', 'chat'));
}

if (current_user_can('contributor') && !current_user_can('upload_files')) {
    add_action('admin_init', 'allow_contributor_uploads');
}
function allow_contributor_uploads() {
    $contributor = get_role('contributor');
    $contributor->add_cap('upload_files');
}

add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup() {
    load_theme_textdomain('master-gf', get_template_directory() . '/languages');
}

function rename_post_formats($safe_text) {
    if ($safe_text == 'Đăng riêng') return 'Teamplate 4';
    if ($safe_text == 'Thư viện ảnh') return 'Bài tiện ích';
    if ($safe_text == 'Chat') return 'Bài dự án mới';
    return $safe_text;
}
add_filter('esc_html', 'rename_post_formats');

function custom_single_template_by_post_format($template) {
    if (is_single()) {
        $post_format = get_post_format();
        if ($post_format) {
            $new_template = locate_template("single-{$post_format}.php");
            if ($new_template) {
                return $new_template;
            }
        }
    }
    return $template;
}
add_filter('template_include', 'custom_single_template_by_post_format');
?>