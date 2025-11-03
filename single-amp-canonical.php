<?php
/* Template: AMP canonical for a single post */
the_post();
header('Content-Type: text/html; charset=' . get_bloginfo('charset'));
?><!doctype html>
<html amp lang="<?php bloginfo('language'); ?>">
<head>
  <meta charset="utf-8">
  <title><?php echo esc_html( wp_get_document_title() ); ?></title>
  <link rel="canonical" href="<?php the_permalink(); ?>">
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
  <style amp-boilerplate>
    body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;
         -moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;
         -ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;
         animation:-amp-start 8s steps(1,end) 0s 1 normal both}
    @-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
    @-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
    @-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
    @-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
    @keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
  </style><noscript><style amp-boilerplate>
    body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}
  </style></noscript>
  <script async src="https://cdn.ampproject.org/v0.js"></script>

  <!-- CSS của bạn (<= 75KB) -->
  <style amp-custom>
    body { font-family: system-ui, sans-serif; line-height:1.6; }
    .container { max-width: 800px; margin: 0 auto; padding: 16px; }
    img,amp-img{max-width:100%;height:auto}
  </style>
</head>
<body>
  <header class="container"><?php bloginfo('name'); ?></header>
  <main class="container">
    <h1><?php the_title(); ?></h1>
    <article>
      <?php
        // Lấy nội dung và chuyển <img> -> <amp-img>
        $html = apply_filters('the_content', get_the_content());
        // chuyển đổi đơn giản: <img ...> => <amp-img layout="responsive">
        $html = preg_replace_callback(
          '#<img\s+([^>]+?)\/?>#i',
          function($m){
            $attrs = $m[1];
            // cố gắng lấy width/height nếu có
            preg_match('#width=["\']?(\d+)#i', $attrs, $w);
            preg_match('#height=["\']?(\d+)#i', $attrs, $h);
            if (empty($w[1]) || empty($h[1])) {
              // fallback: layout=intrinsic (AMP vẫn khuyến nghị có w/h)
              return '<amp-img '.$attrs.' layout="intrinsic"></amp-img>';
            }
            return '<amp-img '.$attrs.' width="'.$w[1].'" height="'.$h[1].'" layout="responsive"></amp-img>';
          },
          $html
        );
        // loại bỏ các tag script không hợp lệ
        $html = preg_replace('#<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>#i', '', $html);
        echo $html;
      ?>
    </article>
  </main>
  <footer class="container"><?php bloginfo('description'); ?></footer>
</body>
</html>
