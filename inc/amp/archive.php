<?php get_header(); $term=get_query_var('cat' );?>
<?php $term = get_queried_object(); ?>
<div class="section2">
    <div class="container">
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
                <?php
if(!cele_is_amp()) { ?>

                

                <?php $rows=get_field( 'question1',$term); if($rows) ?>
                        <?php { ?>
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


                    <?php } ?>
 <?php } else {?>
  AMP Ninh
                    <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>

                    <?php $rows=get_field( 'question1',$term); if($rows) ?>
                        <?php { ?>
                    <amp-accordion class="sample"
  expand-single-section>
                        <?php foreach($rows as $row) { ?>
                        <section>
                          <h4><?php echo  $row['name'] ?></h4>
                          <p><?php echo  $row['content'] ?></p>
                        </section>
                        <?php } ?>
                      </ul>
                    </amp-accordion>
                    <?php } ?>


                    <?php } ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
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
<script src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/TweenMax.min.js"></script>
<script type="text/javascript">
    var Accordion = function() {
  
  var
    toggleItems,
    items;
  
  var _init = function() {
    toggleItems     = document.querySelectorAll('.accordion__itemTitleWrap');
    toggleItems     = Array.prototype.slice.call(toggleItems);
    items           = document.querySelectorAll('.accordion__item');
    items           = Array.prototype.slice.call(items);
    
    _addEventHandlers();
    TweenLite.set(items, {visibility:'visible'});
    TweenMax.staggerFrom(items, 0.9,{opacity:0, x:-100, ease:Power2.easeOut}, 0.3)
  }
  
  var _addEventHandlers = function() {
    toggleItems.forEach(function(element, index) {
      element.addEventListener('click', _toggleItem, false);
    });
  }
  
  var _toggleItem = function() {
    var parent = this.parentNode;
    var content = parent.children[1];
    if(!parent.classList.contains('is-active')) {
      parent.classList.add('is-active');
      TweenLite.set(content, {height:'auto'})
      TweenLite.from(content, 0.6, {height: 0, immediateRender:false, ease: Back.easeOut})
      
    } else {
      parent.classList.remove('is-active');
      TweenLite.to(content, 0.3, {height: 0, immediateRender:false, ease: Power1.easeOut})
    }
  }
  
  return {
    init: _init
  }
  
}();

Accordion.init();   </script>
<?php get_footer(); ?>
