<?php get_header(); $a=get_query_var('cat' ); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
<?php $term = get_queried_object(); ?>
<div id="maincontent" class="info-company">


<?php $rows=get_field( 'thong_tin',$term); if($rows) ?>        
                        <?php { ?>
                        <?php foreach($rows as $row) { ?>   
    <div class="header-tops" style="background: url(<?php the_field('banner_cdt','option')?>) no-repeat center;background-size: cover;">
        <div class="container">
            <div class="box-company">
                <div class="log-company" style="background: url(<?php echo  $row['logo'] ?>)">
                </div>
                <h1 class="name-title">
                    <?php echo single_term_title();?>
                </h1>
            </div>
        </div>
    </div>
    <?php }} ?>


    <div class="content-info">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 info-detail">
                    <div class="menu-title">
                        <p class="title-main" style="text-align: center;
    text-transform: uppercase;
    border-bottom: 1px solid #ddd;
    width: 100%;">Chủ đầu tư khác</p>
                        <?php $curent = get_queried_object();
        $child= get_terms( 'chu-dau-tu', array( 'parent' => $curent->term_id, 'orderby' => 'slug', 'hide_empty' => false ) );
        if($child){
          $list = $child;
        } else {
          $list = get_terms( 'chu-dau-tu', array( 'parent' => $curent->parent, 'orderby' => 'slug', 'hide_empty' => false ) );
        }
        if($list){
      
        echo '<ul class="clearfix">';
          foreach ( $list as $child ) {
            $class = ($child->term_id == $curent->term_id) ? ' active': '';
          echo '<li class="cat-item'.$class.'"><a class="introduce title-main'.$class.'" href="' . get_term_link( $child). '">' . $child->name . '</a></li>';
          }
        echo '</ul>';
          
        }
        ?>
                    </div>
                </div>
                <div class="col-sm-8 info-detail-right">
                    <div class="info-detail-right-content">
                        <p class="title-main"><?php echo single_term_title();?></p>

                        <?php $rows=get_field( 'thong_tin',$term); if($rows) ?>        
                        <?php { ?>
                        <?php foreach($rows as $row) { ?>                     
                        <div class="item-detail">
                            <label class="text-label">Địa chỉ:</label>
                            <p class="text-right"><?php echo  $row['dia_chi'] ?></p>
                        </div>
                        <div class="item-detail">
                            <label class="text-label">Website:</label>
                            <p class="text-right"><?php echo  $row['website'] ?></p>
                        </div>
                        <div class="item-detail">
                            <label class="text-label">Số điện thoại:</label>
                            <p class="text-right"><?php echo  $row['phone'] ?></p>
                        </div>
                        <div class="item-detail">
                            <label class="text-label">Lĩnh vực:</label>
                            <p class="text-right"><?php echo  $row['linh_vuc'] ?></p>
                        </div>
                        <div class="item-detail">
                            <label class="text-label">Thành lập:</label>
                            <p class="text-right"><?php echo  $row['thanh_lap'] ?></p>
                        </div>
                        <div class="item-detail">
                            <label class="text-label">Vốn điều lệ:</label>
                            <p class="text-right"><?php echo  $row['von'] ?></p>
                        </div>
                        <?php }} ?>
                        <div class="item-detail">
                            <label class="text-label" style="width: 100%;">Giới thiệu:</label>
                                <?php if (category_description( $category )) : ?>
                                    <p> <?php echo category_description( $category ); ?></p>
                                <?php endif ?>
                            <div id="readmore" class="text-right" style="max-height: none;">
                                
                            </div>
                        </div>
                    </div>


                    
                    <div class="project">
                        <div class="box-filter-top desktop-hidden ">
                            <div class="left">
                                <h2 class="title-main">Danh sách</h2>
                            </div>
                            <div class="right ">
                                <ul class="filter-parent">
                                    <li>
                                        <a href="javascript:void(0)" class="titile-filter" data-status="0">Đang mở bán</a>
                                        <ul class="sub-menu-filter">
                                            <li>
                                                <a class="title-sub project-statusid-1" href="#">Sắp mở bán</a>
                                            </li>
                                            <li>
                                                <a class="title-sub project-statusid-2" href="#">Đang mở bán</a>
                                            </li>
                                            <li>
                                                <a class="title-sub project-progress-1" href="#">Đang xây dựng</a>
                                            </li>
                                            <li>
                                                <a class="title-sub project-progress-2" href="#">Đã hoàn thiện</a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="box-content">
                            <div class="content">
                                <div class="tab">
                                    <a class="btn-tab" href="#">Bán </a>
                                    <a class="btn-tab" href="#">Cho thuê </a>
                                    <a class="btn-tab active" href="#">
                                        <span> Dự án</span>
                                    </a>
                                </div>
                                <div class="tab-content project ">
                                    <div class="left mobile-none">
                                        <h2 class="title-main">Danh sách Dự án</h2>
                                    </div>
                               
                                    <div class="project-carousel list-post">
                                        <div class="new-list list_pro">



                                            <?php if(!wp_is_mobile()){?>
                                            <?php if(have_posts()){ while(have_posts()):the_post();$format=get_post_format(); ?>
                                            <div class="item">
                                                <div class="box_pro item color-red clearfix">
                                                    <div class="img_project thumb-image">
                                                        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                                            <img src="<?php the_post_thumbnail_url('medium')?>">
                                                            <div class="bg-opacity"></div>
                                                        </a>
                                                        <div class="status dangban">
                                                            <span class="icon"></span>
                                                            <span><?php the_field('tt'); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="content_project">
                                                        <div class="title clearfix">
                                                            <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                                            <div class="price_pro"><?php the_field('gia'); ?></div>
                                                        </div>
                                                        <div class="address"><?php the_field('dc'); ?></div>
                                                        <ul class="info_pro clearfix">
                                                            <li class="info-investor"><?php the_terms( $post->ID, 'chu-dau-tu') ?></li>
                                                            <li class="info-acreage">Đang cập nhật</li>
                                                            <li class="info-finish">Bàn giao: <?php the_field('tg'); ?></li>
                                                            <li class="info-constructor"><?php the_field('tt'); ?></li>
                                                        </ul>
                                                        <div class="info-category clearfix">
                                                            <div class="info-category-box">
                                                                <?php the_category(' ')?>
                                                            </div>
                                                            <div class="compare-box">
                                                                <a href=""><span>So sánh</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endwhile;wp_reset_postdata(); ?>
                                            <?php }?>   

                                            <?php
                                            }
                                            else
                                            { ?>
                                                <?php if(have_posts()){ while(have_posts()):the_post();$format=get_post_format(); ?>
                                                    <div class="box_pro item color-red clearfix">
                                                        <div class="img_project thumb-image">
                                                            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                                                <img src="<?php the_post_thumbnail_url('medium')?>">
                                                                <div class="bg-opacity"></div>
                                                            </a>
                                                            <div class="status dangban">
                                                                <span class="icon"></span>
                                                                <span><?php the_field('tt'); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="content_project">
                                                            <div class="title clearfix">
                                                                <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                                            </div>
                                                            <div class="address"><?php the_field('dc'); ?></div>
                                                            <ul class="info_pro clearfix">
                                                                <li class="price_pro"><?php the_field('gia'); ?></li>
                                                                <li class="info-finish">Bàn giao: <?php the_field('tg'); ?></li>
                                                                <div class="compare-box">
                                                                    <a href=""><span>So sánh</span></a>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                <?php endwhile;wp_reset_postdata(); ?>
                                                <?php }?>
                                            <?php } ?>

                                  
                                        </div>
                                    </div>
                                </div>          
                            </div>
                        </div>
                    </div> 
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>