<?php
function html5blankgravatar($avatar_defaults) {
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = 'Custom Gravatar';
    return $avatar_defaults;
}
add_filter('avatar_defaults', 'html5blankgravatar');

function disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
}

function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' == $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}

function remove_category_rel_from_category_list($output) {
    return str_replace(' rel="category tag"', '', $output);
}
add_filter('wp_list_categories', 'remove_category_rel_from_category_list');
add_filter('the_category', 'remove_category_rel_from_category_list');

function add_slug_to_body_class($classes) {
    global $post;
    if (is_singular()) {
        $classes[] = $post->post_name;
    } elseif (is_tax()) {
        $classes[] = single_term_title('', false);
    }
    return $classes;
}
add_filter('body_class', 'add_slug_to_body_class');

function remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);

function html5wp_excerpt($hook_name) {
    return function($text) use ($hook_name) {
        if ($hook_name == 'html5wp_index') {
            return $text . '[...]<p><a class="btn btn-default btn-sm" href="' . get_permalink() . '">' . __('Continue reading', 'master-gf') . '</a></p>';
        }
        return $text . '[...]';
    };
}
add_filter('excerpt_more', html5wp_excerpt('html5wp_index'), 10);
add_filter('wp_trim_excerpt', html5wp_excerpt('html5wp_custom_post'), 10);

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');

function nh_remove_menu_pages() {
    if (!current_user_can('administrator')) {
        remove_menu_page('edit.php');
        remove_menu_page('edit.php?post_type=cauhoi');
        remove_menu_page('edit.php?post_type=rao-vat');
        remove_menu_page('edit-comments.php');
        remove_menu_page('tools.php');
    }
}
add_action('admin_menu', 'nh_remove_menu_pages');

function wpse_11826_search_by_title($search, $wp_query) {
    if (!empty($search) && !empty($wp_query->query_vars['search_terms'])) {
        global $wpdb;
        $q = $wp_query->query_vars;
        $n = !empty($q['exact']) ? '' : '%';
        $search = array();
        foreach ((array)$q['search_terms'] as $term) {
            $search[] = $wpdb->prepare("$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like($term) . $n);
        }
        if (!is_user_logged_in()) {
            $search[] = "$wpdb->posts.post_password = ''";
        }
        $search = ' AND (' . implode(' AND ', $search) . ')';
    }
    return $search;
}
add_filter('posts_search', 'wpse_11826_search_by_title', 10, 2);

function custom_user_contactmethods($contactmethods) {
    $contactmethods['phone'] = 'Phone Number';
    return $contactmethods;
}
add_filter('user_contactmethods', 'custom_user_contactmethods', 10, 1);

function mu_hide_plugins_network($plugins) {
    $plugins_to_hide = array('remove-taxonomy-base-slug/remove-taxonomy-base-slug.php');
    foreach ($plugins_to_hide as $plugin_file) {
        unset($plugins[$plugin_file]);
    }
    return $plugins;
}
add_filter('all_plugins', 'mu_hide_plugins_network');

function my_custom_fonts() {
    if (!current_user_can('administrator')) {
        echo '<style>#toplevel_page_my-custom-fonts { display: none; }</style>';
    }
}
add_action('admin_head', 'my_custom_fonts');

function html5_style_remove($tag) {
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}
add_filter('style_loader_tag', 'html5_style_remove');

add_filter('widget_text', 'do_shortcode');

remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
?>