<?php
function tinhngay() {
    $time = get_field('cele_demnguoc', 'option');
    if ($time) {
        $target = strtotime($time);
        $today = time();
        $diff = $target - $today;
        if ($diff > 0) {
            $years = floor($diff / (365 * 24 * 60 * 60));
            $diff -= $years * 365 * 24 * 60 * 60;
            $months = floor($diff / (30 * 24 * 60 * 60));
            $diff -= $months * 30 * 24 * 60 * 60;
            $days = floor($diff / (24 * 60 * 60));
            $diff -= $days * 24 * 60 * 60;
            $hours = floor($diff / (60 * 60));
            $diff -= $hours * 60 * 60;
            $minutes = floor($diff / 60);
            $output = '';
            if ($years > 0) $output .= "$years năm ";
            if ($months > 0) $output .= "$months tháng ";
            if ($days > 0) $output .= "$days ngày ";
            if ($hours > 0) $output .= "$hours giờ ";
            if ($minutes > 0) $output .= "$minutes phút";
            return trim($output);
        }
    }
    return '';
}

function cele_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    $mobile_logo = get_field('logo_mobile', 'option') ?: $logo[0];
    $desktop_logo = get_field('logo_desktop', 'option') ?: $logo[0];
    if (cele_is_amp()) {
        echo '<amp-img src="' . esc_url(wp_is_mobile() ? $mobile_logo : $desktop_logo) . '" width="150" height="50" layout="fixed" alt="Logo"></amp-img>';
    } else {
        echo '<img src="' . esc_url(wp_is_mobile() ? $mobile_logo : $desktop_logo) . '" alt="Logo">';
    }
}

function cele_logo_footer() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    $footer_logo = get_field('logo_footer', 'option') ?: $logo[0];
    if (cele_is_amp()) {
        echo '<amp-img src="' . esc_url($footer_logo) . '" width="150" height="50" layout="fixed" alt="Footer Logo"></amp-img>';
    } else {
        echo '<img src="' . esc_url($footer_logo) . '" alt="Footer Logo">';
    }
}

function cele_form_var() {
    if (!cele_is_amp()) {
        wp_localize_script('popup', 'formvar', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'cele_form_var');

function back_to_top() {
    if (cele_is_amp()) {
        echo '<div class="back-to-top" on="tap:page.scrollTo(duration=300)" role="button" tabindex="0"><i class="ti ti-chevron-up"></i></div>';
    } else {
        echo '<div class="back-to-top"><i class="ti ti-chevron-up"></i></div>';
    }
}
add_action('wp_footer', 'back_to_top');

function get_excerpt($limit = 180) {
    $excerpt = get_the_excerpt();
    $excerpt = preg_replace(" (\[.*?\])", '', $excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
    $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
    return $excerpt . '...';
}

function stars($rate, $max = 5) {
    $output = '<div class="stars">';
    for ($i = 1; $i <= $max; $i++) {
        $output .= '<i class="ti ti-star' . ($i <= $rate ? '-filled' : '') . '"></i>';
    }
    $output .= '</div>';
    return $output;
}

function trogiup_insert_after_paragraph($insertion, $paragraph_id, $content) {
    $closing_p = '</p>';
    $paragraphs = explode($closing_p, $content);
    $new_content = '';
    foreach ($paragraphs as $index => $paragraph) {
        if (trim($paragraph)) {
            $new_content .= $paragraph . $closing_p;
        }
        if ($index == $paragraph_id - 1) {
            $new_content .= $insertion;
        }
    }
    return $new_content;
}
// add_filter('the_content', function($content) {
//     return trogiup_insert_after_paragraph('<div class="trogiup">Hỗ trợ: 090xxxxxxx</div>', 2, $content);
// });

function wp_bootstrap_pagination($args = array()) {
    global $wp_query;
    $defaults = array(
        'range' => 4,
        'custom_query' => $wp_query,
        'previous_string' => __('Previous', 'master-gf'),
        'next_string' => __('Next', 'master-gf'),
        'before_output' => '<nav aria-label="Page navigation"><ul class="pagination">',
        'after_output' => '</ul></nav>'
    );
    $args = wp_parse_args($args, apply_filters('wp_bootstrap_pagination_defaults', $defaults));
    $args['range'] = (int)$args['range'] - 1;
    if (!$args['custom_query']) $args['custom_query'] = $wp_query;
    $count = (int)$args['custom_query']->max_num_pages;
    $page = get_query_var('paged') ? get_query_var('paged') : 1;
    $ceil = ceil($args['range'] / 2);
    if ($count <= 1) return;
    $min = max(1, $page - $ceil);
    $max = min($count, $page + $ceil);
    $links = array();
    if ($page != 1) {
        $links[] = sprintf('<li><a href="%s" aria-label="Previous">%s</a></li>', get_pagenum_link($page - 1), $args['previous_string']);
    }
    if ($min > 1) {
        $links[] = sprintf('<li><a href="%s">1</a></li>', get_pagenum_link(1));
        if ($min > 2) $links[] = '<li><span>...</span></li>';
    }
    for ($i = $min; $i <= $max; $i++) {
        $links[] = ($i == $page) ? sprintf('<li class="active"><span>%s</span></li>', $i) : sprintf('<li><a href="%s">%s</a></li>', get_pagenum_link($i), $i);
    }
    if ($max < $count) {
        if ($max < $count - 1) $links[] = '<li><span>...</span></li>';
        $links[] = sprintf('<li><a href="%s">%s</a></li>', get_pagenum_link($count), $count);
    }
    if ($page != $count) {
        $links[] = sprintf('<li><a href="%s" aria-label="Next">%s</a></li>', get_pagenum_link($page + 1), $args['next_string']);
    }
    echo $args['before_output'] . implode('', $links) . $args['after_output'];
}
?>