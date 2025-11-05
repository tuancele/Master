<?php //Template Name: Tìm kiếm
get_header(); $a=get_query_var('cat' );
?>

<?php get_header(); ?>
<div id="maincontent">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php
                if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb('
                <p id="breadcrumbs">','</p>
                ');
                }
                ?>
                <form class="formSearchLabor" role="search" method="get" action="<?php echo home_url( 'tim-kiem' ); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="sp">
                                <option disable selected value="0"> -- Sản phẩm -- </option>
                                <?php $categories = get_categories( array( 'hide_empty' => 0,'parent'=>0,'taxonomy'=>'san-pham' ) );foreach ( $categories as $category ) {?>
                                <option value="<?php echo $category->slug;?>" <?php if($_POST['sp']==$category->slug){echo 'selected';}?>><?php echo $category->name ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select disable selected name="lh">
                                <option value="0"> -- Loại hình -- </option>
                                <?php $categories = get_categories( array( 'hide_empty' => 0,'parent'=>0,'taxonomy'=>'danh-muc-loai-hinh' ) );foreach ( $categories as $category ) {?>
                                <option value="<?php echo $category->slug;?>" <?php if($_POST['lh']==$category->slug){echo 'selected';}?>><?php echo $category->name ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select disable selected name="th">
                                <option value="0"> -- Tỉnh thành -- </option>
                                <?php $categories = get_categories( array( 'hide_empty' => 0,'parent'=>0,'taxonomy'=>'tinh-thanh' ) );foreach ( $categories as $category ) {?>
                                <option value="<?php echo $category->slug;?>" <?php if($_POST['th']==$category->slug){echo 'selected';}?>><?php echo $category->name ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="boxButton">
                                <button type="submit">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="list-job clearfix">
                    <?php
                    $sp = $_POST['sp'];
                    $lh = $_POST['lh'];
                    $th = $_POST['th'];
                    
                    if($sp) {
                    $taxquery[]=array(
                    'taxonomy' => 'san-pham','field'    => 'slug',
                    'field'    => 'id',
                    'terms'    => $sp
                    );
                    }
                    if($lh) {
                    $taxquery[]=array(
                    'taxonomy' => 'danh-muc-loai-hinh','field'    => 'slug',
                    'field'    => 'id',
                    'terms'    => $lh
                    );
                    }
                    if($th) {
                    $taxquery[]=array(
                    'taxonomy' => 'tinh-thanh','field'    => 'slug',
                    'field'    => 'id',
                    'terms'    => $th
                    );
                    }
                    
                    if(sizeof($taxquery)>1){
                    $taxquery['relation']='AND';
                    }
                    $array = array(
                    'tax_query'=>$taxquery
                    );
  
                    $new=new WP_Query($array); if($new->have_posts()){
                    while($new->have_posts()):$new->the_post(); $format=get_post_format(); ?>
                    <div class="item-news-list clearfix">
                        <div class="img-item-news-list img-item-news-slider">
                            <a href="<?php the_permalink();?>"><?php the_post_thumbnail('medium')?></a>
                        </div>
                        <div class="info-item-news-list">
                            <div class="box-info-item-news-list">
                                <h2 class="title-item-news-slider"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                <h3 class="text-item-news">
                                    <?php echo get_excerpt(); ?>
                                </h3>
                                <span class="address-item-news-slider"><?php the_terms( $post->ID, 'tinh-thanh' ) ?></span>
                            </div>
                            <div class="box-info-item-news-list">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="price-item-news-list"><?php the_field('gia')?></span>
                                        <span class="acreage-item-news-list"><?php the_field('dien_tich')?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-information clearfix">
                                            <div class="img-information">
                                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 300 ) ); ?>
                                            </div>
                                            <div class="name-information">
                                                <span><?php the_author();?> | <a href="tel:<?php the_author_meta( 'ext_phone' , $author_id ); ?>"><?php the_author_meta( 'ext_phone' , $author_id ); ?></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile;wp_reset_postdata(); get_template_part('pagination');?>
                    <?php }else{echo 'Không có bài';};?>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>