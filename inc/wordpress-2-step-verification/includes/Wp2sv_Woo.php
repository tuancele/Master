<?php


class Wp2sv_Woo extends Wp2sv_Base
{
	function _construct()
	{
		add_action('woocommerce_edit_account_form',[$this,'wp2svStatus']);
		$this->enableAdminAccessForWp2sv();
	}
	function wp2svStatus(){
		echo Wp2sv_View::make('woo.status',[
			'enabled'=>$this->isEnabled(),
			'enabled_at'=>$this->model->enabled_at,
			'setup_url'=>$this->url([],true),
			'user_display_name'=>$this->user->display_name
		]);
	}
	protected function enableAdminAccessForWp2sv(){
		add_filter('woocommerce_prevent_admin_access',function($accesss){
			if(defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE && isset($_REQUEST['page']) && $_REQUEST['page']==='wp2sv'){
				return false;
			}
			return $accesss;
		});
	}
}