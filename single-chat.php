<?php get_header(); ?>

<style>
.banner, .nav-header, .relatedpost{display: none;}
</style>
<section class="section section-slider">
    <?php
    $images = get_field('gallery_da');
    if( $images ): ?>
    <div class="swiper-custom-container section-slider-container">
        <div class="swiper slider-project-primary">
            <div class="swiper-wrapper">
                <?php foreach( $images as $image ): ?>
                <div class="swiper-slide">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="slider">
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="block-wrap is-bottom">
                <div class="container-fluid">
                    <h1 class="section-title"><?php the_title();?></h1>
                    <p class="section-subtitle"><?php the_field('slogan')?></p>
                </div>
            </div>
        </div>
        <div class="section-slider-bar">
            <div class="swiper-custom-container section-slider-thumbnail">
                <div class="swiper slider-project-primary-thumbs">
                    <div class="swiper-wrapper">
                        <?php foreach( $images as $image ): ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="slider" class="lazyload lazyload-blur">
                        </div>
                        <?php endforeach; ?>
                        
                    </div>
                    <button type="button" role="button" class="swiper-button-prev nav-button-prev is-large-desktop is-dark" aria-label="Previous"></button>
                    <button type="button" role="button" class="swiper-button-next nav-button-next is-large-desktop is-dark" aria-label="Next"></button>
                </div>
            </div>
            <div class="section-slider-gallery">
                <a href="<?php echo esc_url($images[0]['url']); ?>" data-fancybox="images" class="tab-item">
                    <i class="ti ti-photo"></i>
                    <span>Tất cả ảnh</span>
                </a>
                <?php
                $images2 = get_field('gallery_da_mb');
                if( $images2 ): ?>
                <a href="<?php echo esc_url($images2[0]['url']); ?>" data-fancybox="images2" class="tab-item">
                    <i class="ti ti-3D-text"></i>
                    <span>Tổng mặt bằng</span>
                </a>
                <div style="display:none;">
                    <?php foreach( $images2 as $image2 ): ?>
                    <a href="<?php echo esc_url($image2['url']); ?>"
                        data-fancybox="images2"
                        data-thumb="<?php echo esc_url($image2['sizes']['thumbnail']); ?>">
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div style="display:none;">
                    <?php foreach( $images as $image ): ?>
                    <a href="<?php echo esc_url($image['url']); ?>"
                        data-fancybox="images"
                        data-thumb="<?php echo esc_url($image['sizes']['thumbnail']); ?>">
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>
<div class="page-header head2">
    <div class="container">
        <div class="tabs">
            <ul id="tab-page-header-pc" class="tab-header-pc">
                <li class="tab-item">
                    <a  href="#section-overview" class="tab-link" data-scrollnav-target="section-overview">
                        <i class="ti ti-eye-check"></i> Tổng quan
                    </a>
                </li>
                <li class="tab-item" >
                    <a href="#section-subdivision" class="tab-link" data-scrollnav-target="section-subdivision">
                        <i class="ti ti-building-community"></i>
                        <span class="is-flex is-align-items-center gap-1">
                            Phân khu 
                        </span>
                    </a>
                </li>
                <li class="tab-item">
                    <a  href="#section-location-around" class="tab-link" data-scrollnav-target="section-location-around">
                        <i class="ti ti-map-pin"></i> Vị trí
                    </a>
                </li>
                <li class="tab-item">
                    <a  href="#section-facilities" class="tab-link" data-scrollnav-target="section-facilities">
                        <i class="ti ti-c-park"></i> Tiện ích cảnh quan
                    </a>
                </li>
                <li class="tab-item tab-item-slide">
                    <a  href="#section-policy" class="tab-link" data-scrollnav-target="section-policy">
                        <i class="ti ti-file-text"></i> Tài liệu
                    </a>
                </li>
                <li class="tab-item tab-item-slide">
                    <a  href="#section-floor-plan" class="tab-link" data-scrollnav-target="section-floor-plan">
                        <i class="ti ti-map-2"></i> Tổng mặt bằng
                    </a>
                </li>
                <li class="tab-item tab-item-slide">
                    <a  href="#section-property-highlight" class="tab-link" data-scrollnav-target="section-property-highlight">
                        <i class="ti ti-home-search"></i> Giá và Quỹ căn
                    </a>
                </li>
            </ul>

            <ul id="tab-page-header-mobile" class="tab-header-mobile">
                <li class="tab-item">
                    <a  href="#section-overview" class="tab-link" data-scrollnav-target="section-overview">
                        <i class="ti ti-eye-check"></i> Tổng quan
                    </a>
                </li>
                <li class="tab-item" disabled="true">
                    <a href="#section-subdivision" class="tab-link"  data-scrollnav-target="section-subdivision">
                        <i class="ti ti-building-community"></i>
                        <span class="is-flex is-align-items-center gap-1">
                            Phân khu
                        </span>
                    </a>
                </li>
                <li class="tab-item">
                    <a  href="#section-location-around" class="tab-link" data-scrollnav-target="section-location-around">
                        <i class="ti ti-map-pin"></i> Vị trí
                    </a>
                </li>

                <li class="custommbile-hide">
                    <button class="button is-small is-icon button__nav-menu"><i class="ti ti-dots"></i></button>
                    <ul style="display: none;">
                        <li class="tab-item">
                            <a  href="#section-facilities" class="tab-link" data-scrollnav-target="section-facilities">
                                <i class="ti ti-c-park"></i> Tiện ích cảnh quan
                            </a>
                        </li>
                        <li class="tab-item tab-item-slide">
                            <a  href="#section-policy" class="tab-link" data-scrollnav-target="section-policy">
                                <i class="ti ti-file-text"></i> Tài liệu
                            </a>
                        </li>
                        <li class="tab-item tab-item-slide">
                            <a  href="#section-floor-plan" class="tab-link" data-scrollnav-target="section-floor-plan">
                                <i class="ti ti-map-2"></i> Tổng mặt bằng
                            </a>
                        </li>
                        <li class="tab-item tab-item-slide">
                            <a  href="#section-property-highlight" class="tab-link" data-scrollnav-target="section-property-highlight">
                                <i class="ti ti-home-search"></i> Giá và Quỹ căn
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            
        </div>
        
    </div>
</div>
<main class="page-content">


    <div class="page-body">
        <div class="container page-body-container">
            <div class="page-body-content">
                <?php the_content();?>
                
                
                
            </div>
            <div class="sidebar">
                <div class="sidebar-content">
                    <div class="form-container is-project-detail">
                        
                        <div class="dowload-last form-content" id="dowload-last-link">
                            <form id="cele-form-sidebar" class="cele-form-sidebar form-download " action="<?php the_field('cele_returnurl','option') ?>" method="POST">
                                <p class="section-subtitle has-text-centered">Tư vấn mua nhà chuyên sâu</p>
                                <ul class="list-style__type">
                                    <li>Phân tích <strong>quỹ căn, chính sách, tiện ích</strong> giúp Khách hàng lựa chọn
                                        <strong>căn tốt nhất.</strong>
                                    </li>
                                    <li><strong>Giải đáp mọi thắc mắc</strong> của khách hàng.</li>
                                    <li>Tuyệt đối <strong>bảo mật</strong> thông tin cá nhân.</li>
                                </ul>
                                <?php wp_nonce_field('celeform','human',false); ?>
                                <input name="Cele" value="mastergf-float" type="hidden">
                                <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
                                
                                
                                <div class="celename">
                                    <input
                                    id="name-downow"
                                    class="form-control"
                                    name="Name"
                                    aria-label="Name"
                                    type="text"
                                    placeholder="<?php _e('Full name','master-gf') ?>"
                                    >
                                </div>
                                <div class="celeemail" style="display: none;">
                                    <input
                                    id="email-downow"
                                    class="form-control"
                                    name="Email"
                                    aria-label="Email"
                                    type="text"
                                    placeholder="<?php _e('Email','master-gf') ?>"
                                    >
                                </div>
                                
                                <div class="celephone">
                                    <input
                                    id="phone-downow"
                                    class="form-control"
                                    name="Mobile"
                                    type="number"
                                    aria-label="Mobile"
                                    placeholder="<?php _e('Phone number','master-gf') ?>"
                                    required=""
                                    >
                                </div>
                                <div class="field is-checkbox chcckek">
                                    <p class="fs-2 text-consent">
                                        Bằng việc tiếp tục, bạn đã đồng ý với chúng tôi về các
                                        <a :href="termLink" target="_blank">Điều khoản dịch vụ</a> và
                                        <a :href="policyLink" target="_blank">Chính sách bảo mật.</a>
                                    </p>
                                </div>
                                
                                <input
                                id="link-dow-now"
                                class="dow-now"
                                aria-label="Submit"
                                name="dangky"
                                onclick="Submit_Form('sidebar','noname')"
                                type="button"
                                value="<?php _e('Nhận tư vấn ngay','master-gf') ?>"
                                >
                            </form>
                            
                            <div class="divider">
                                <span class="divider-text has-text-weight-normal">Hoặc</span>
                            </div>
                            <div class="buttons block-buttons">
                                <a @click="trackClickHotline" href="tel:<?php the_field('hotline')?>" class="button is-secondary" role="link" aria-label="Gọi điện">
                                    <i class="ti ti-phone"></i>
                                    <span>
                                        Gọi trực tiếp
                                        <br>
                                        <span class="has-text-weight-normal"><?php the_field('hotline')?></span>
                                    </span>
                                </a>
                                <a @click="trackClickChatZalo" href="https://zalo.me/<?php the_field('zalo')?>" target="_blank" class="button is-secondary" aria-label="Chat qua Zalo">
                                    <i class="ti ti-zalo-chat"></i>
                                    <span>Chat qua Zalo</span>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    


                <?php
$current_post_id = get_the_ID(); 


$args = [
    'post_type'      => 'rao-vat',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'meta_query'     => [
        [
            'key'     => 'thuoc_du_an_nao',
            'value'   => $current_post_id,
            'compare' => '='
        ]
    ]
];

$query = new WP_Query($args);
?>

<section id="section-property-highlight" data-scrollnav-id="section-property-highlight" class="section section-table-opening">
    <div class="container">
        <h3 class="section-title">Mua bán - Chuyển nhượng</h3>

        <div class="section-table-opening__content" data-impression-section="property_primary">
            <div class="table-container table-price">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã căn</th>
                            <th>DT đất <i class="ti ti-info-circle"></i></th>
                            <th>Giá bán <i class="ti ti-info-circle"></i></th>
                            <th>Loại hình</th>
                            <th>Hướng cửa</th>
                            <th style="width: 125px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query->have_posts()):
                            $x = 0;
                            while ($query->have_posts()): $query->the_post(); $x++;

                                $dien_tich = get_field('dien_tich');
                                $gia       = get_field('gia');
                                $loai_hinh = get_field('loai_hinhs');
                                $huong_cua = get_field('hcuas');
                                $link      = get_permalink();
                        ?>
                        <tr class="top-<?php echo $x;?>">
                            <td data-label="Top <?php echo $x;?>">
                                <a href="<?php echo esc_url($link); ?>" class="table-title" target="_blank">
                                   <?php the_title(); ?>
                                </a>
                            </td>
                            <td><?php echo esc_html($dien_tich); ?></td>
                            <td><?php echo esc_html($gia); ?></td>
                            <td><?php echo esc_html($loai_hinh); ?></td>
                            <td><?php echo esc_html($huong_cua); ?></td>
                            <td style="width: 125px;">
                                <button data-toggle="modal" data-target="#myModal4" class="btn button is-small is-secondary" type="button">Liên hệ</button>
                            </td>
                        </tr>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                        ?>
                        <tr><td colspan="6">Không có bài rao vặt nào thuộc bài viết này.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<div id="myModal4" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <button type="button" class="close" data-dismiss="modal"><svg><use xlink:href="#close"></use></svg></button>
            <div class="modal-content">
                <div class="form-container is-project-detail">
                        
                        <div class="dowload-last form-content" id="dowload-last-link">
                            <form id="cele-form-modal" class="cele-form-modal form-download" action="<?php the_field('cele_returnurl','option') ?>" method="POST">
    <p class="section-subtitle has-text-centered">Tư vấn mua nhà chuyên sâu</p>
    <ul class="list-style__type">
        <li>Phân tích <strong>quỹ căn, chính sách, tiện ích</strong> giúp Khách hàng lựa chọn <strong>căn tốt nhất.</strong></li>
        <li><strong>Giải đáp mọi thắc mắc</strong> của khách hàng.</li>
        <li>Tuyệt đối <strong>bảo mật</strong> thông tin cá nhân.</li>
    </ul>
    <?php wp_nonce_field('celeform','human',false); ?>
    <input name="Cele" value="mastergf-float" type="hidden">
    <input name="Website" value="<?php the_permalink(); ?>" type="hidden">

    <div class="celename">
        <input
        id="name-modal"
        class="form-control"
        name="Name"
        aria-label="Name"
        type="text"
        placeholder="<?php _e('Full name','master-gf') ?>"
        >
    </div>
    <div class="celeemail" style="display: none;">
        <input
        id="email-modal"
        class="form-control"
        name="Email"
        aria-label="Email"
        type="text"
        placeholder="<?php _e('Email','master-gf') ?>"
        >
    </div>
    
    <div class="celephone">
        <input
        id="phone-modal"
        class="form-control"
        name="Mobile"
        type="number"
        aria-label="Mobile"
        placeholder="<?php _e('Phone number','master-gf') ?>"
        required=""
        >
    </div>
    <div class="field is-checkbox chcckek">
        <p class="fs-2 text-consent">
            Bằng việc tiếp tục, bạn đã đồng ý với chúng tôi về các
            <a :href="termLink" target="_blank">Điều khoản dịch vụ</a> và
            <a :href="policyLink" target="_blank">Chính sách bảo mật.</a>
        </p>
    </div>
    
    <input
    id="submit-modal"
    class="dow-now"
    aria-label="Submit"
    name="dangky"
    onclick="Submit_Form('modal','noname')"
    type="button"
    value="<?php _e('Nhận tư vấn ngay','master-gf') ?>"
    >
</form>

                            
                            <div class="divider">
                                <span class="divider-text has-text-weight-normal">Hoặc</span>
                            </div>
                            <div class="buttons block-buttons">
                                <a @click="trackClickHotline" href="tel:<?php the_field('hotline')?>" class="button is-secondary" role="link" aria-label="Gọi điện">
                                    <i class="ti ti-phone"></i>
                                    <span>
                                        Gọi trực tiếp
                                        <br>
                                        <span class="has-text-weight-normal"><?php the_field('hotline')?></span>
                                    </span>
                                </a>
                                <a @click="trackClickChatZalo" href="https://zalo.me/<?php the_field('zalo')?>" target="_blank" class="button is-secondary" aria-label="Chat qua Zalo">
                                    <i class="ti ti-zalo-chat"></i>
                                    <span>Chat qua Zalo</span>
                                </a>
                            </div>
                        </div>


                    </div>
            </div>
        </div>
    </div>



<div id="section-faq" class="section section-faq">
                    <div class="container">
                        <div class="section-content">
                            <h2 class="section-title">
                            Câu hỏi thường gặp về <?php the_title();?>
                            </h2>
                            <div class="section-body">
                                <div class="accordion accordion-faq">
                                    <?php
                                    $chas = get_field('question1');
                                    if ($chas && is_array($chas)) {
                                    $i = 0;
                                    foreach ($chas as $cha) {
                                    $is_active = ($i === 0) ? 'is-active' : '';
                                    $icon_class = ($i === 0) ? 'ti ti-minus' : 'ti ti-plus';
                                    ?>
                                    <div class="accordion-item <?php echo $is_active; ?>">
                                        <a href="#" class="accordion-header">
                                            <p class="accordion-title"><?php echo $cha['name']; ?></p>
                                            <i class="accordion-icon <?php echo $icon_class; ?>"></i>
                                        </a>
                                        <div class="accordion-content">
                                            <?php echo $cha['content']; ?>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                    }
                                    }
                                    ?>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
</main>
<?php if( have_rows('question1') ): ?>
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "FAQPage",
"mainEntity": [
<?php while ( have_rows('question1') ) : the_row(); ?>
{
"@type": "Question",
"name": "<?php the_sub_field('name'); ?>",
"acceptedAnswer": {
"@type": "Answer",
"text": "<?php the_sub_field('content'); ?>"
}
}<?php the_sub_field('s'); ?>
<?php endwhile; ?>
]
}
</script>
<?php endif; ?>

<?php get_footer(); ?>