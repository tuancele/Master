<div class="section5">
        <div class="container">
            <div class="clearfix">
                <p class="title-section5"><?php _e('See quickly others','master-gf') ?></p>
                <?php
if(!cele_is_amp()) { ?>
                <div class="box-content owl-project owl-carousel">
                    <?php if( have_rows('cele_duan',pll_current_language('slug')) ): ?>
                    <?php while( have_rows('cele_duan',pll_current_language('slug')) ): the_row();
                    // vars
                    $image = get_sub_field('img');
                    ?>
                    <div class="item">
                        <div class="item">
                            <div class="img-item">
                                <a href="<?php the_sub_field('link'); ?>">
                                <img <?php awesome_acf_responsive_image($image,'full','270px'); ?> alt="Banner dự án" class="img-responsive">
                            </a>
                                <div class="address">
                                    <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                    <svg><use xlink:href="#filled-point"></use></svg><?php the_sub_field('diachi'); ?></a>
                                </div>
                            </div>
                            <div class="text-item">
                                <div class="name">
                                    <a class="a_title" href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>"><?php the_sub_field('title'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
        
                <?php endif; ?>
            </div>

            <?php } else {?>
            <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.2.js"></script>


    <amp-carousel class="box-content" height="205"
  layout="fixed-height"
  type="slides">
                    <?php if( have_rows('cele_duan',pll_current_language('slug')) ): ?>
                    <?php while( have_rows('cele_duan',pll_current_language('slug')) ): the_row();
                    // vars
                    $image = get_sub_field('img');
                    ?>
                    <div class="item">
                        <div class="item">
                            <div class="img-item">
                                <a href="<?php the_sub_field('link'); ?>">
                                <img <?php awesome_acf_responsive_image($image,'full','270px'); ?> alt="Banner dự án" class="img-responsive">
                            </a>
                                <div class="address">
                                    <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>">
                                    <svg><use xlink:href="#filled-point"></use></svg><?php the_sub_field('diachi'); ?></a>
                                </div>
                            </div>
                            <div class="text-item">
                                <div class="name">
                                    <a class="a_title" href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>"><?php the_sub_field('title'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
        
                <?php endif; ?>
            </amp-carousel>
             <?php } ?>



        </div>
    </div>
</div>