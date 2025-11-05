<?php
/**
 * @var boolean $enabled
 * @var string $enabled_at
 * @var string $setup_url
 * @var string $user_display_name
 */

?>
<p class="woocommerce-form-row-wp2sv woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
	<label for="account_email">2-step verification</span></label>
	<?php if($enabled){
		printf(__('2-step verification is <strong>ON</strong> since %s', 'wordpress-2-step-verification'),$enabled_at);
	}else{
		printf(__('2-step verification is <strong>OFF</strong>', 'wordpress-2-step-verification'), $user_display_name);
	}?>
	<a href="<?php echo $setup_url;?>" class="wp2sv_setup_link">Change setting</a>
</p>