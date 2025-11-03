<?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <div class="list-item col-md-12 no-padding">
            <div class="col-xs-3 col-md-3 no-padding">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_post_thumbnail('thumbnail'); // Declare pixel size you need inside the array ?>
                </a>
            </div>
            <div class="col-xs-9 col-md-9">
                <h2>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                  </h2>
                  <div class="div-date-time">
                                            <ul class="list-date-time">
                                              <li class="date-time"><?php _e('Published','master-gf') ?>: <?php the_time('j/m/Y'); ?> </li>
                                            </ul>
                  </div>
                  <?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
            </div>

    </div>
<?php endwhile; ?>
<?php endif; ?>
