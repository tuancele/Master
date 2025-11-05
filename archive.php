<?php get_header(); $a =get_query_var('cat' );?>
<?php $term = get_queried_object(); ?>
<div class="section2">
    <div class="container">
        <?php if(get_field( 'loai', 'category_'.$a)!=2){ ?>
        <div class="row">
            <div class="col-md-9 section2-left">
                <div class="list-news no-padding">
                    <?php
                    if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb('
                    <p id="breadcrumbs">','</p>
                    ');
                    }
                    ?>
                    <?php if (category_description( $category )) : ?>
                    <div class="svb_note"><?php echo category_description( $category ); ?></div>
                    <?php endif ?>
                    <div class="box-heading col-md-12 no-padding">
                        <h1 class="title-list-news"><?php single_cat_title(); ?></h1>
                    </div>
                    <?php get_template_part('loop'); ?>
                    <?php get_template_part('pagination'); ?>
                </div>
                <?php $rows=get_field( 'question1',$term); if($rows) ?>
                <?php { ?>
                <?php
                if(!cele_is_amp()) { ?>
                <div class="accordion" style="clear: both;">
                    <ul class="accordion__list">
                        <?php foreach($rows as $row) { ?>
                        <li class="accordion__item">
                            <div class="accordion__itemTitleWrap">
                                <h3 class="accordion__itemTitle"><?php echo  $row['name'] ?></h3>
                                <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div>
                            </div>
                            <div class="accordion__itemContent">
                                <?php echo  $row['content'] ?>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } else {?>
                <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
                
                <?php $rows=get_field( 'question1',$term); if($rows) ?>
                <?php { ?>
                
                <amp-accordion class="sample amp-list-faq accordion__list" animate>
                    <?php foreach($rows as $row) { ?>
                    <section class="accordion__item">
                        
                        <h4 class="accordion__itemTitle"><?php echo  $row['name'] ?> <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#000" stroke-miterlimit="10" stroke-width="2"/></svg></div></h4>
                        
                        
                        <?php echo  $row['content'] ?>
                    </section>
                    <?php } ?>
                </amp-accordion>
                
                <?php } ?>
                
                <?php } ?>
                <?php } ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
        <?php }else{ ?>
        <?php $term = get_queried_object(); ?>
        <div class="sp_sec1">
            <div class="container">
                <div class="promo_search" style="background-image: url(<?php bloginfo('template_url' ); ?>/images/youtube.svg);">
                    <h2 class="title">Làm thế nào chúng tôi có thể giúp bạn?</h2>
                    <form action="<?php bloginfo('url'); ?>/" method="GET" role="form" id="searchform">
                        <input type="text" autocomplete="off" placeholder="Mô tả vấn đề của bạn" class="search-ajax input-form">
                    <button type="submit" class="button-form"><svg class="promoted-search__search-icon" viewBox="0 0 24 24"><path d="M20.49 19l-5.73-5.73C15.53 12.2 16 10.91 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.41 0 2.7-.47 3.77-1.24L19 20.49 20.49 19zM5 9.5C5 7.01 7.01 5 9.5 5S14 7.01 14 9.5 11.99 14 9.5 14 5 11.99 5 9.5z"></path><path d="M0 0h24v24H0V0z" fill="none"></path></svg></button>
                    <span class="click-close"><svg class="promoted-search__clear-icon" viewBox="0 0 48 48"><path d="M38 12.83L35.17 10 24 21.17 12.83 10 10 12.83 21.17 24 10 35.17 12.83 38 24 26.83 35.17 38 38 35.17 26.83 24z"></path></svg></span>
                </form>
                <div id="load-data"></div>
            </div>
        </div>
    </div>
    <div class="sp_sec2">
        <div class="container">
            <div class="accordion tab_archive">
                      <ul class="accordion__list">
                <?php $categories =
                get_categories( array(
                'orderby' => 'name','parent'=>$a,'hide_empty'=>0,
                'order'   => 'ASC',
                ) ) ; $x=1; foreach( $categories as $category ) {$x++;?>

                <li class="accordion__item">
                          <div class="accordion__itemTitleWrap">
                            <h3 class="accordion__itemTitle"><?php echo $category->name;?></h3>
                            <div class="accordion__itemIconWrap"><svg viewBox="0 0 24 24"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="#1a73e8" stroke-miterlimit="10" stroke-width="2"/></svg></div>
                          </div>
                          <div class="accordion__itemContent">
                            <?php $new=new WP_Query('showposts=5&cat='.$category->term_id);while($new->have_posts()) : $new->the_post();?>
                            <div class="panel-body">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                            <?php endwhile;?>
                          </div>
                        </li>


                
                <?php } ?>
            </ul>
            </div>
        </div>
    </div>
    <div class="sp_sec3">
        <div class="container">
            <div class="slider_sp owl-theme owl-carousel">
                <?php $chas = get_field('slide',$term);
                if($chas) { ?>
                <?php foreach ($chas as $cha) { ?>
                <div class="item">
                    <h3 class="title"><?php echo $cha['title'];  ?></h3>
                    <ul class="clearfix">
                        <?php
                        if($cha['list']) {
                        foreach ($cha['list'] as $con) { ?>
                        <li class="child" style="background-image:url(<?php echo $con['img']; ?>)">
                            <a href="<?php echo $con['link']; ?>"><?php echo $con['capt']; ?></a>
                            <p><?php echo $con['text']; ?></p>
                        </li>
                        <?php } } ?>
                    </ul>
                </div>
                <?php } } ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
</div>
<div class="section3"></div>
<?php $rows=get_field( 'question1',$term); if($rows) ?>
<?php { ?>
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "FAQPage",
"mainEntity": [
<?php foreach($rows as $row) { ?>
{
"@type": "Question",
"name": "<?php echo  $row['name'] ?>",
"acceptedAnswer": {
"@type": "Answer",
"text": "<?php echo  $row['content'] ?>"
}
}<?php echo  $row['s'] ?>
<?php } ?>
]
}
</script>
<?php } ?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    var timeout = null; // khai báo biến timeout
    $(".search-ajax").keyup(function(){ // bắt sự kiện khi gõ từ khóa tìm kiếm
        clearTimeout(timeout); // clear time out
        timeout = setTimeout(function (){
           call_ajax(); // gọi hàm ajax
        }, 500);
    });
    function call_ajax() { // khởi tạo hàm ajax
        var data = $('.search-ajax').val(); // get dữ liệu khi đang nhập từ khóa vào ô
        $.ajax({
            type: 'POST',
            async: true,
            url: '<?php echo admin_url('admin-ajax.php');?>',
            data: {
                'action' : 'Post_filters', 
                'data': data
            },
            beforeSend: function () {
            },
            success: function (data) {
                $('#load-data').html(data); // show dữ liệu khi trả về
            }
        });
    }
</script>

<?php get_footer(); ?>