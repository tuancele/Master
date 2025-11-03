<?php
function html5blank_styles() {
    if (cele_is_amp()) {
        wp_register_style('style-amp', get_template_directory_uri() . '/css/style-amp.css', array(), '1.3', 'all');
        wp_enqueue_style('style-amp');
    } else {
        wp_register_style('style-css', get_template_directory_uri() . '/css/style.css', array(), '1.3', 'all');
        wp_enqueue_style('style-css');
        wp_register_style('mmenu.css', get_template_directory_uri() . '/css/jquery.mmenu.css', array(), '1.1', 'all');
        wp_enqueue_style('mmenu.css');
        wp_register_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '2.3.4', 'all');
        wp_enqueue_style('owl-carousel');
    }
}

function html5blank_header_scripts() {
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        if (!cele_is_amp()) {
            wp_register_script('popup', get_template_directory_uri() . '/js/popup.js', array('jquery'), '1.0.3', true);
            wp_register_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '2.3.4', true);
            wp_register_script('morecontent', get_template_directory_uri() . '/js/jquery.morecontent.js', array('jquery'), '1.0', true);
            wp_register_script('demo', get_template_directory_uri() . '/js/demo.js', array('jquery'), '1.0', true);
            wp_enqueue_script('owl-carousel');
            wp_enqueue_script('morecontent');
            wp_enqueue_script('demo');
            if (get_field('popup', 'option')) {
                wp_enqueue_script('popup');
            }
            wp_enqueue_script('fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array('jquery'), '3.5.7', true);
            wp_enqueue_script('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.min.js', array('jquery'), '9.3.2', true);
        }
    }
}

add_action('wp_enqueue_scripts', 'html5blank_styles');
add_action('wp_enqueue_scripts', 'html5blank_header_scripts');
?>