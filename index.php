<?php get_header(); ?>
<div class="section2">
    <div class="container">
        <div class="row">
            <div class="col-md-9 no-padding section2-left">
                <div class="list-news no-padding">
                    <div class="box-heading col-md-12 no-padding">
                        <h1 class="title-list-news"><?php single_cat_title(); ?></h1>
                    </div>
                    <?php get_template_part('loop'); ?>
                    <?php get_template_part('pagination'); ?>
                </div>
                
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<div class="section3"></div>
<?php get_footer(); ?>