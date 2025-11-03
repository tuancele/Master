<?php
define('WP_USE_THEMES', false);
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$args = array(
    'cat' => get_query_var('cat'),
    'posts_per_page' => 10,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
);
$query = new WP_Query($args);
$posts = array();

while ($query->have_posts()) {
    $query->the_post();
    $posts[] = array(
        'permalink' => get_permalink(),
        'title' => get_the_title(),
        'thumbnail' => get_the_post_thumbnail_url(null, 'thumbnail'),
        'date' => get_the_time('j/m/Y'),
        'excerpt' => wp_trim_words(get_the_excerpt(), 20, '[...]'),
    );
}
wp_reset_postdata();

echo json_encode($posts);
exit;
?>