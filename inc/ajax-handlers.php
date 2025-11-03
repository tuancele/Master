<?php
/**
 * File: /inc/ajax-handlers.php
 *
 * Xử lý tất cả các cuộc gọi AJAX.
 * ĐÃ VÁ LỖ HỔNG BẢO MẬT (CSRF) VÀ TỐI ƯU API.
 */

// Chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =========================================================================
// HÀM AJAX CHÍNH
// =========================================================================

/**
 * AJAX: Lấy đơn hàng giả (fake)
 */
function list_order() {
    // BẢO MẬT: Kiểm tra Nonce.
    // Giả sử nonce được gửi qua POST với tên là 'nonce'.
    check_ajax_referer('ajax-nonce', 'nonce');

    $rows = get_field('cele_fake', 'option');
    if ($rows) {
        shuffle($rows);
        $row = $rows[0];
        echo '<li class="content_order"><div class="content"><div class="name">' . esc_html($row['content']) . '</div></div></li>';
    }
    wp_die();
}
add_action('wp_ajax_nopriv_list_order', 'list_order');
add_action('wp_ajax_list_order', 'list_order');

/**
 * AJAX: Xử lý Form chính (Modal/Sidebar)
 */
function cele_ajax_form() {
    // BẢO MẬT: Kiểm tra Nonce từ formvar
    check_ajax_referer('ajax-nonce', 'nonce');

    $arg['email'] = isset($_POST['order_email']) ? sanitize_email($_POST['order_email']) : '';
    $arg['name']  = isset($_POST['order_name']) ? sanitize_text_field($_POST['order_name']) : '';
    $arg['phone'] = isset($_POST['order_phone']) ? sanitize_text_field($_POST['order_phone']) : '';
    $arg['link']  = isset($_POST['order_link']) ? esc_url_raw($_POST['order_link']) : '';

    cele_zoho($arg);
    cele_sendy($arg);
    cele_mail($arg);
    
    wp_send_json_success($arg['email']);
    wp_die();
}
add_action('wp_ajax_cele_ajax', 'cele_ajax_form');
add_action('wp_ajax_nopriv_cele_ajax', 'cele_ajax_form');

/**
 * AJAX: Xử lý Form trong nội dung (Shortcode [sdt])
 */
function cele_content_ajax() {
    // BẢO MẬT: Kiểm tra Nonce từ formvar
    check_ajax_referer('ajax-nonce', 'nonce');

    $arg['phone'] = isset($_POST['order_phone']) ? sanitize_text_field($_POST['order_phone']) : '';
    $arg['link']  = isset($_POST['order_link']) ? esc_url_raw($_POST['order_link']) : '';
    
    // Đặt tên mặc định nếu không có
    $arg['name'] = 'Guest'; 
    $arg['email'] = ''; // Đảm bảo các hàm API không bị lỗi
    
    cele_zoho($arg);
    cele_sendy($arg); // Sẽ không chạy vì không có email
    cele_mail($arg);
    
    wp_send_json_success($arg['phone']);
    wp_die();
}
add_action('wp_ajax_cele_content_ajax', 'cele_content_ajax');
add_action('wp_ajax_nopriv_cele_content_ajax', 'cele_content_ajax');

/**
 * AJAX: Xử lý Form AMP [sdt]
 */
function namespace_handle_amp_form_submit() {
    $redirect_url = get_field('cele_returnurl', 'option');
    
    // ... (Headers CORS cho AMP) ...
    header("Content-Type: application/json");
    header("access-control-allow-credentials: true");
    header("access-control-allow-origin: https://" . str_replace('.', '-', $_SERVER['HTTP_HOST']) . ".cdn.ampproject.org");
    header("AMP-Access-Control-Allow-Source-Origin: https://" . $_SERVER['HTTP_HOST']);
    header("access-control-expose-headers: AMP-Access-Control-Allow-Source-Origin, AMP-Redirect-To");

    $mobile = isset($_POST['Mobile']) ? sanitize_text_field($_POST['Mobile']) : '';
    $data = '';

    if (!preg_match('/^(08|09|03|07|05)[0-9]{8}$/', $mobile)) {
        header('X-PHP-Response-Code: 400', true, 400);
        $data = 'Số điện thoại sai định dạng';
    } else {
        usleep(1);
        $arg['phone'] = $mobile;
        $arg['link']  = isset($_POST['link']) ? esc_url_raw($_POST['link']) : '';
        $arg['name']  = 'Guest AMP';
        $arg['email'] = '';
        
        header("AMP-Redirect-To: " . esc_url_raw($redirect_url));
        cele_zoho($arg);
        cele_mail($arg);
    }
    
    $output = ['data' => $data];
    wp_send_json($output);
    wp_die();
}
add_action("wp_ajax_amp_form_submit", "namespace_handle_amp_form_submit");
add_action("wp_ajax_nopriv_amp_form_submit", "namespace_handle_amp_form_submit");

/**
 * AJAX: Xử lý Form AMP (Footer)
 */
function namespace_handle_amp_formfooter_submit() {
    $redirect_url = get_field('cele_returnurl', 'option');

    // ... (Headers CORS cho AMP) ...
    header("Content-Type: application/json");
    header("access-control-allow-credentials: true");
    header("access-control-allow-origin: https://" . str_replace('.', '-', $_SERVER['HTTP_HOST']) . ".cdn.ampproject.org");
    header("AMP-Access-Control-Allow-Source-Origin: https://" . $_SERVER['HTTP_HOST']);
    header("access-control-expose-headers: AMP-Access-Control-Allow-Source-Origin, AMP-Redirect-To");

    $mobile = isset($_POST['Mobile']) ? sanitize_text_field($_POST['Mobile']) : '';
    $email  = isset($_POST['Email']) ? sanitize_email(strtolower($_POST['Email'])) : '';
    $name   = isset($_POST['Name']) ? sanitize_text_field($_POST['Name']) : 'Noname';
    
    $data = '';
    $output = ['data' => $data];

    if (!preg_match('/^(08|09|03|07|05)[0-9]{8}$/', $mobile)) {
        header('X-PHP-Response-Code: 400', true, 400);
        $data = 'Số điện thoại không chính xác';
        $output = ['data' => $data];
        wp_send_json($output);
        wp_die();
    }
    if (empty($email) || !is_email($email)) {
        header('X-PHP-Response-Code: 400', true, 400);
        $data = 'Email không chính xác';
        $output = ['data' => $data];
        wp_send_json($output);
        wp_die();
    }
    
    usleep(1);
    $arg['name']  = $name;
    $arg['email'] = $email;
    $arg['phone'] = $mobile;
    $arg['link']  = isset($_POST['link']) ? esc_url_raw($_POST['link']) : '';
    
    header("AMP-Redirect-To: " . esc_url_raw($redirect_url));
    cele_zoho($arg);
    cele_sendy($arg);
    cele_mail($arg);
    
    wp_send_json($output);
    wp_die();
}
add_action("wp_ajax_amp_formfooter_submit", "namespace_handle_amp_formfooter_submit");
add_action("wp_ajax_nopriv_amp_formfooter_submit", "namespace_handle_amp_formfooter_submit");

/**
 * AJAX: Tìm kiếm (cho template 'category' loại 2)
 */
function Post_filters() {
    // BẢO MẬT: Kiểm tra Nonce.
    // Giả sử nonce được gửi qua POST với tên là 'nonce'.
    check_ajax_referer('ajax-nonce', 'nonce');

    if (isset($_POST['data'])) {
        $data = sanitize_text_field($_POST['data']);
        echo '<ul>';
        $getposts = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 5,
            's' => $data
        ));

        if ($getposts->have_posts()) {
            while ($getposts->have_posts()) : $getposts->the_post();
                echo '<li><a target="_blank" href="' . esc_url(get_the_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
            endwhile;
        } else {
            echo '<li>Không tìm thấy kết quả.</li>';
        }
        wp_reset_postdata();
        echo '</ul>';
        wp_die();
    }
    wp_die();
}
add_action('wp_ajax_Post_filters', 'Post_filters');
add_action('wp_ajax_nopriv_Post_filters', 'Post_filters');


// =========================================================================
// HÀM GỬI API & EMAIL (Helpers cho AJAX)
// (Đã di chuyển từ functions.php (file 45) vào đây)
// =========================================================================

/**
 * Gửi API đến ZOHO
 */
function cele_zoho($arg) {
    // Khởi tạo giá trị mặc định
    $arg['name'] = isset($arg['name']) ? $arg['name'] : 'Noname';
    $arg['email'] = isset($arg['email']) ? $arg['email'] : '';
    $arg['phone'] = isset($arg['phone']) ? $arg['phone'] : '';
    $arg['link'] = isset($arg['link']) ? $arg['link'] : '';

    $url = "https://crm.zoho.com/crm/WebToLeadForm";
    wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 5, // Giảm timeout
        'blocking' => false, // TỐI ƯU: Không chờ phản hồi
        'httpversion' => '1.0',
        'body' => array(
            'Last Name' => $arg['name'],
            'Mobile' => $arg['phone'],
            'Email' => $arg['email'],
            'Website' => $arg['link'],
            'xnQsjsdp' => '0869bfcdc841d22b11056a01a5da5637e4e8db2bc08f85c424203d0cef452600',
            'xmIwtLD' => '3aa5421eef8a37948d2901c21c5e182f3605e34f37664b817c432e5d864d7d6a',
            'actionType' => 'TGVhZHM=',
        ),
    ));
}

/**
 * Gửi API đến SENDY
 */
function cele_sendy($arg) {
    // Khởi tạo giá trị mặc định
    $arg['name'] = isset($arg['name']) ? $arg['name'] : 'Noname';
    $arg['email'] = isset($arg['email']) ? $arg['email'] : '';
    $arg['phone'] = isset($arg['phone']) ? $arg['phone'] : '';
    
    $list = get_field('cele_list_sendy', 'option');
    if ($list && !empty($arg['email'])) { // Chỉ chạy nếu có Email
        $url = "https://svmail.nhadat86.vn/subscribe";
        wp_remote_post($url, array(
            'method' => 'POST',
            'timeout' => 5, // Giảm timeout
            'blocking' => false, // TỐI ƯU: Không chờ phản hồi
            'httpversion' => '1.0',
            'body' => array(
                'name' => $arg['name'],
                'email' => $arg['email'],
                'list' => $list,
                'Phone' => $arg['phone']
            ),
        ));
    }
}

/**
 * Gửi Email thông báo
 */
function cele_mail($arg) {
    // Khởi tạo giá trị mặc định
    $arg['name'] = isset($arg['name']) ? $arg['name'] : 'Noname';
    $arg['email'] = isset($arg['email']) ? $arg['email'] : 'no-reply@example.com';
    $arg['phone'] = isset($arg['phone']) ? $arg['phone'] : '';
    $arg['link'] = isset($arg['link']) ? $arg['link'] : '';
    
    $to = get_field('cele_email_form', 'option');
    if ($to) {
        $subject = "Đăng ký mới từ " . $arg['name'] . " " . $arg['phone'];
        $headers = 'MIME-Version: 1.0' . "\r\n" .
                   'Content-type:text/html;charset=UTF-8' . "\r\n" .
                   'From: ' . $arg['email'] . "\r\n" .
                   'Reply-To: ' . $arg['email'] . "\r\n";
        $message = '
            <html>
            <head><title>Thông tin khách đăng ký mới</title></head>
            <body>
                <h1>Bạn đã có 1 khách hàng mới!</h1>
                <table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
                    <tr><th>Tên:</th><td>' . esc_html($arg['name']) . '</td></tr>
                    <tr style="background-color: #e0e0e0;"><th>Email:</th><td>' . esc_html($arg['email']) . '</td></tr>
                    <tr><th>Website:</th><td><a href="' . esc_url($arg['link']) . '">' . esc_html($arg['link']) . '</a></td></tr>
                    <tr style="background-color: #e0e0e0;"><th>Mobile:</th><td>' . esc_html($arg['phone']) . '</td></tr>
                </table>
            </body>
            </html>';
        wp_mail($to, $subject, $message, $headers);
    }
}
?>