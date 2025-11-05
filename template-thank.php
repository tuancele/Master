<?php /* Template Name: Thanks Template */ get_header(); ?>
<?php the_field('cele_thanks','option'); ?>
<div class="section2">
    <div class="container">
        <div class="row">
            <p style="text-align: center;"><strong><span style="font-size: 18pt;"><?php _e('Thank you for registering','master-gf') ?></span></strong></p>
            <p style="text-align: center;">~~~*&#8212;*&#8212;*~~~</p>
            <p style="text-align: center;"><span style="font-size: 14pt;"><strong><?php _e('We will contact you for the most accurate information','master-gf') ?></strong></span></p>
            <p style="text-align: center;">*&#8212;*&#8212;*</p>
            <p style="text-align: center;"><a href="<?php echo home_url(); ?>"><strong><?php _e('Back to homepage','master-gf') ?></strong></a></p>
        </div>
    </div>
</div>


 <div class=" thanks" style="position: fixed;top: 0;left: 0;bottom: 0;right: 0;margin-top: 60px;z-index: 99999;">
        <div class="container">
    <p style="text-align: center;"><img src="/wp-content/themes/mastergf/images/thank.png"></p>
    <p style="text-align: center;"><span style="font-size: 30pt;color: #ff5100;"><?php _e('Registration process completed','master-gf') ?></span></p>
    <p style="text-align: center;"><span style="font-size: 14pt;color: #ff5100;"><?php _e('An email has been sent to your address','master-gf') ?><i><?php echo $email; ?></i>
      <br>
      <?php _e('Please check email in incoming or outgoing spam and follow the instructions to receive project information','master-gf') ?></span>
    </p>
  
    <p style="text-align: center;"><a class="btn" href="javascript:history.go(-1)" style="background-color: #ff5100;
height: 50px;
width: 200px;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
-moz-background-clip: padding;
-webkit-background-clip: padding-box;
color: #FFF;
font-size: 18px;
line-height: 30px;
text-align: center;"><?php _e('Back to homepage','master-gf') ?></a></p>

      </div>
</div>

<div class="thanks-back">
</div>
<?php get_footer(); ?>