<?php
if (!wp_is_mobile()) {
    if (!class_exists('LazyLoad_Images')) {
        class LazyLoad_Images {
            const version = '0.6.1';
            protected static $enabled = true;

            static function init() {
                if (is_admin()) return;
                if (!apply_filters('lazyload_is_enabled', true)) {
                    self::$enabled = false;
                    return;
                }
                add_action('wp_enqueue_scripts', array(__CLASS__, 'add_scripts'));
                add_filter('the_content', array(__CLASS__, 'add_image_placeholders'), 9999);
                add_filter('post_thumbnail_html', array(__CLASS__, 'add_image_placeholders'), 11);
                add_filter('get_avatar', array(__CLASS__, 'add_image_placeholders'), 11);
            }

            static function add_scripts() {
                if (cele_is_amp()) return;
                wp_enqueue_script('lazyload', get_template_directory_uri() . '/js/lazyload.min.js', array(), self::version, true);
            }

            static function add_image_placeholders($content) {
                if (!self::$enabled || is_feed() || is_preview() || cele_is_amp()) {
                    return $content;
                }
                $content = preg_replace('/<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>/i', '<img$1src="' . get_template_directory_uri() . '/img/blank.gif" data-lazy-src="$2"$3><noscript><img$1src="$2"$3></noscript>', $content);
                return $content;
            }
        }
        add_action('wp', array('LazyLoad_Images', 'init'));
    }
}
?>