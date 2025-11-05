<?php
/**
 * Chịu trách nhiệm xử lý tất cả các Form, AJAX,
 * và tích hợp CRM (Zoho, Sendy, Mail).
 */

// Chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * AJAX: Lấy danh sách order (hiển thị popup)
 * (Code gốc từ dòng 754)
 */
function list_order() {
    $rows = get_field('cele_fake','option');
    if($rows)
    {
        shuffle( $rows );
     
        $row = $rows[0];
       
    echo '<li class="content_order">
    <div class="content">
        <div class="name">'.$row['content'].'</div>
    </div>
</li>';
    
    }
	die();
}
add_action( 'wp_ajax_nopriv_list_order', 'list_order' );
add_action( 'wp_ajax_list_order', 'list_order' );


/*
 * AJAX: Xử lý form chung
 * (Code gốc từ dòng 1076)
 */
function cele_ajax_form() {
	// (Chúng ta sẽ thêm nonce check ở bước bảo mật sau)
    $arg['email'] = (isset($_POST['order_email'])) ? sanitize_email($_POST['order_email']) : '';
    $arg['name'] = (isset($_POST['order_name'])) ? sanitize_text_field($_POST['order_name']) : '';
    $arg['phone'] = (isset($_POST['order_phone'])) ? sanitize_text_field($_POST['order_phone']) : '';
    $arg['link'] = (isset($_POST['order_link'])) ? esc_url_raw($_POST['order_link']) : '';
    
	if ( function_exists('cele_zoho') ) cele_zoho ($arg);
    if ( function_exists('cele_sendy') ) cele_sendy ($arg);
    if ( function_exists('cele_mail') ) cele_mail ($arg);
    
	wp_send_json_success($arg['email']); // Gửi email về thay vì biến $email không xác định
    die();
}
add_action( 'wp_ajax_cele_ajax', 'cele_ajax_form' );
add_action( 'wp_ajax_nopriv_cele_ajax', 'cele_ajax_form' );

/*
 * AJAX: Xử lý form content
 * (Code gốc từ dòng 1089)
 */
function cele_content_ajax() {
	// (Chúng ta sẽ thêm nonce check ở bước bảo mật sau)
    $arg['phone'] = (isset($_POST['order_phone'])) ? sanitize_text_field($_POST['order_phone']) : '';
    $arg['link'] = (isset($_POST['order_link'])) ? esc_url_raw($_POST['order_link']) : '';

	if ( function_exists('cele_zoho') ) cele_zoho ($arg);
    if ( function_exists('cele_sendy') ) cele_sendy ($arg);
    if ( function_exists('cele_mail') ) cele_mail ($arg);
    
	wp_send_json_success(); // Không có biến $email ở đây
    die();
}
add_action( 'wp_ajax_cele_content_ajax', 'cele_content_ajax' );
add_action( 'wp_ajax_nopriv_cele_content_ajax', 'cele_content_ajax' );


/*
 * AJAX: Xử lý form AMP [sdt]
 * (Code gốc từ dòng 1102)
 */
function namespace_handle_amp_form_submit() {   
     $redirect_url = get_field('cele_returnurl','option');
      header( "Content-Type: application/json" );
      header( "access-control-allow-credentials: true" );
      header( "access-control-allow-headers: Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token" );
      header( "access-control-allow-methods: POST, GET, OPTIONS" );
      header( "access-control-allow-origin: https://" . str_replace('.', '-',$_SERVER['HTTP_HOST']) .".cdn.ampproject.org" );
      header( "access-control-expose-headers: AMP-Access-Control-Allow-Source-Origin" );
      header( "AMP-Access-Control-Allow-Source-Origin: https://".$_SERVER['HTTP_HOST'] );
    
	$mobile = isset($_POST['Mobile']) ? sanitize_text_field($_POST['Mobile']) : '';
	$data = ''; // Khởi tạo biến data

    if (!preg_match('/^(08|09|03|07|05)[0-9]{8}$/', $mobile)) {
        header('X-PHP-Response-Code: 400', true, 400);
        $data = 'Số điện thoại sai định dạng';
    } else {      
        usleep(1);
        header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");
        $arg['phone'] = $mobile;
        $arg['link'] = isset($_POST['link']) ? esc_url_raw($_POST['link']) : '';
        header("AMP-Redirect-To: ".$redirect_url);
        
		if ( function_exists('cele_zoho') ) cele_zoho ($arg);
        if ( function_exists('cele_mail') ) cele_mail ($arg);
    }
    $output = ['data' => $data];  
    wp_send_json($output);
    die();
}
add_action("wp_ajax_amp_form_submit", "namespace_handle_amp_form_submit");
add_action("wp_ajax_nopriv_amp_form_submit", "namespace_handle_amp_form_submit");

/*
 * AJAX: Xử lý form AMP footer
 * (Code gốc từ dòng 1141)
 */
function namespace_handle_amp_formfooter_submit() {
    
    $redirect_url = get_field('cele_returnurl','option');
     header( "Content-Type: application/json" );
     header( "access-control-allow-credentials: true" );
     header( "access-control-allow-headers: Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token" );
     header( "access-control-allow-methods: POST, GET, OPTIONS" );
     header( "access-control-allow-origin: https://" . str_replace('.', '-',$_SERVER['HTTP_HOST']) .".cdn.ampproject.org" );
     header( "access-control-expose-headers: AMP-Access-Control-Allow-Source-Origin" );
     header( "AMP-Access-Control-Allow-Source-Origin: https://".$_SERVER['HTTP_HOST'] );
    
   $data = ''; // Khởi tạo biến data
   $mobile = isset($_POST['Mobile']) ? sanitize_text_field($_POST['Mobile']) : '';
   $email = isset($_POST['Email']) ? sanitize_email($_POST['Email']) : '';
   $email = strtolower($email);
   $name = isset($_POST['Name']) ? sanitize_text_field($_POST['Name']) : 'Noname';

   
   if (!preg_match('/^(08|09|03|07|05)[0-9]{8}$/', $mobile)) {
       header('X-PHP-Response-Code: 400', true, 400);
       $data = 'Số điện thoại không chính xác';
        $output = ['data' => $data];
       wp_send_json($output);
       die();
   } 

   if (!preg_match('/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/', $email)) {
		header('X-PHP-Response-Code: 400', true, 400);
		$data = 'Email không chính xác';
		$output = ['data' => $data];
		wp_send_json($output);
		die();
    }  
       usleep(1);
       header("Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin");
       $arg['name'] = $name;
       $arg['email'] = $email;
       $arg['phone'] = $mobile;
       $arg['link'] = isset($_POST['link']) ? esc_url_raw($_POST['link']) : '';
       header("AMP-Redirect-To: ".$redirect_url);
       
	   if ( function_exists('cele_zoho') ) cele_zoho ($arg);
       if ( function_exists('cele_sendy') ) cele_sendy ($arg);
       if ( function_exists('cele_mail') ) cele_mail ($arg);
   
   wp_send_json(array('data' => $data)); // Gửi JSON hợp lệ
   die();
 }
add_action("wp_ajax_amp_formfooter_submit", "namespace_handle_amp_formfooter_submit");
add_action("wp_ajax_nopriv_amp_formfooter_submit", "namespace_handle_amp_formfooter_submit");


/*
 * Gửi dữ liệu CRM: Zoho
 * (Code gốc từ dòng 1182)
 */
function cele_zoho ($arg) {
	  // Khởi tạo các biến để tránh lỗi
	  $arg = wp_parse_args($arg, array(
		'name'  => 'Noname',
		'phone' => '',
		'email' => '',
		'link'  => ''
	  ));

      $url = "https://crm.zoho.com/crm/WebToLeadForm";
      wp_remote_post( $url, array(
        'method' => 'POST',
        'timeout' => 45,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => array( 'Last Name' => $arg['name'],
                         'Mobile' => $arg['phone'],
                         'Email' => $arg['email'],
                         'Website' => $arg['link'],
                         'xnQsjsdp' => '0869bfcdc841d22b11056a01a5da5637e4e8db2bc08f85c424203d0cef452600',
                         'xmIwtLD' => '3aa5421eef8a37948d2901c21c5e182f3605e34f37664b817c432e5d864d7d6a',
                         'actionType' => 'TGVhZHM=',
                        ),
        'cookies' => array()
          )
      );
}

/*
 * Gửi dữ liệu CRM: Sendy
 * (Code gốc từ dòng 1199)
 */
function cele_sendy($arg) {
	// Khởi tạo các biến để tránh lỗi
	$arg = wp_parse_args($arg, array(
		'name'  => 'Noname',
		'phone' => '',
		'email' => '',
		'link'  => ''
	));
	
    $list = get_field('cele_list_sendy','option');
     if ($list && !empty($arg['email'])) { // Chỉ chạy nếu có email

            $url = "https://svmail.nhadat86.vn/subscribe";

        wp_remote_post( $url, array(
          'method' => 'POST',
          'timeout' => 45,
          'httpversion' => '1.0',
          'blocking' => true,
          'headers' => array(),
          'body' => array( 'name' => $arg['name'],     
                           'email' => $arg['email'],
                           'list'   =>  $list,
                          'Phone' => $arg['phone']
                          ),
          'cookies' => array()
            )
        );
    
       } 
}

/*
 * Gửi dữ liệu CRM: Mail
 * (Code gốc từ dòng 1220)
 */
function cele_mail($arg) {
	// Khởi tạo các biến để tránh lỗi
	$arg = wp_parse_args($arg, array(
		'name'  => 'Noname',
		'phone' => '',
		'email' => '',
		'link'  => ''
	));
	
    $to = get_field('cele_email_form','option');
    if ($to) {
        $subject = "Đăng ký mới từ ".$arg['name']." ".$arg['phone'];
        $headers =  'MIME-Version: 1.0' . "\r\n" .
                    'Content-type:text/html;charset=UTF-8' . "\r\n" .
                    'From: '. $arg['email'] . "\r\n" .
                    'Reply-To: ' . $arg['email'] . "\r\n";
        $message = '
                <html>
                <head>
                    <title>Thông tin khách đăng ký mới</title>
                </head>
                <body>
                    <h1>Bạn đã có 1 khách hàng mới!</h1>
                    <table cellspacing="0" style="border: 2px dashed #FB4314; width: 300px; height: 200px;">
                        <tr>
                            <th>Tên:</th><td>'.$arg['name'].'</td>
                        </tr>
                        <tr style="background-color: #e0e0e0;">
                            <th>Email:</th><td>'.$arg['email'].'</td>
                        </tr>
                        <tr>
                            <th>Website:</th><td><a href="'.$arg['link'].'">'.$arg['link'].'</a></td>
                        </tr>
                         <tr style="background-color: #e0e0e0;">
                            <th>Mobile :</th><td>'.$arg['phone'].'</td>
                        </tr>
                    </table>
                </body>
                </html>';

        wp_mail($to, $subject, $message, $headers);
    }
}

/*
 * AJAX: Lọc bài viết (Tìm kiếm)
 * (Code gốc từ dòng 1251)
 */
function Post_filters() {
    if(isset($_POST['data'])){
        $data = sanitize_text_field($_POST['data']); // Bảo mật
        echo '<ul>';
        $getposts = new WP_query(); $getposts->query('post_type=post&post_status=publish&showposts=5&s='.$data);
        global $wp_query; $wp_query->in_the_loop = true;
        while ($getposts->have_posts()) : $getposts->the_post();
            echo '<li><a target="_blank" href="'.get_the_permalink().'">'.get_the_title().'</a></li>'; 
        endwhile; wp_reset_postdata();
        echo '</ul>';
        die(); 
    }
};
add_action('wp_ajax_Post_filters', 'Post_filters');
add_action('wp_ajax_nopriv_Post_filters', 'Post_filters');

/*
 * Filter: Chỉ tìm kiếm theo Tiêu đề
 * (Code gốc từ dòng 1272)
 */
function wpse_11826_search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode( ' AND ', $search );
    }

    return $search;
}
add_filter( 'posts_search', 'wpse_11826_search_by_title', 10, 2 );

?>