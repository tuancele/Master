<?php
/**
 * AMP Support Functions
 * Định nghĩa hàm cele_is_amp() và các hỗ trợ AMP khác.
 */
function cele_is_amp() {
    // Kiểm tra plugin AMP for WP hoặc AMP chính thức
    if (function_exists('is_amp_endpoint')) {
        return is_amp_endpoint();
    }
    // Fallback cho URL query (?amp) hoặc /amp/
    return isset($_GET['amp']) || (strpos($_SERVER['REQUEST_URI'], '/amp/') !== false);
}

// Thêm hỗ trợ AMP cho theme
add_theme_support('amp');

// Thêm script AMP cần thiết nếu ở chế độ AMP
add_action('wp_head', 'add_amp_components');
function add_amp_components() {
    if (cele_is_amp()) {
        ?>
        <script async src="https://cdn.ampproject.org/v0.js"></script>
        <script async custom-element="amp-img" src="https://cdn.ampproject.org/v0/amp-img-0.1.js"></script>
        <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
        <script async custom-element="amp-list" src="https://cdn.ampproject.org/v0/amp-list-0.1.js"></script>
        <script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>
        <?php
    }
}
?>