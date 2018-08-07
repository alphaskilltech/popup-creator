<?php
function alp_set_admin_url($hook) {
	if ('popupcreator_page_popup_create' == $hook) {
		echo '<script type="text/javascript">ALP_ADMIN_URL = "'.admin_url()."admin.php?page=create_popup".'";</script>';
	}
}
function alp_popup_admin_scripts($hook) {
	
	   if ( 'popup-up-creator_page_popup-edit' == $hook
    	|| 'popup-up-creator_page_popup_create' == $hook
    	|| 'popup-up-creator_page_subscribers' == $hook) {

		wp_enqueue_media();
		wp_register_script('javascript', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Backend.js', array('jquery', 'wp-color-picker'));
		wp_enqueue_script('jquery');
		wp_enqueue_script('javascript');	
    }
	else if('toplevel_page_popupcreator' == $hook  || $hook == 'toplevel_page_popup-settings'){
		wp_register_script('javascript', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Backend.js', array('jquery'));
		wp_enqueue_script('jquery');
		wp_enqueue_script('javascript');
	}	
	if('popupcreator_page_popup-edit' == $hook) {
		wp_register_script('Alp_Con_Range_Slider', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Range_Slider.js', array('jquery'));
		wp_enqueue_script('Alp_Con_Range_Slider');
		// wp_register_script('Alp_Con_Bootstrap_Input', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Bootstrap_Input.js', array('jquery'));		
		// wp_enqueue_script('Alp_Con_Bootstrap_Input');
		wp_enqueue_script('jquery');
	}
}
function jquerydatepickerscript($hook) {
	// wp_enqueue_script('jquerydatepick','https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js');
	wp_enqueue_script('jquerydatepicker','https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js');		
	wp_enqueue_script('jquerydatepickertime','https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js');
	wp_enqueue_script('jquerydatetimepicker','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js');
	wp_enqueue_script('jquerymultiselect','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js');
}
add_action('admin_enqueue_scripts', 'jquerydatepickerscript');
add_action('admin_enqueue_scripts', 'alp_set_admin_url');
add_action('admin_enqueue_scripts', 'alp_popup_admin_scripts');

function AlpFrontendScripts() {
	wp_enqueue_script('alp_popup_core', plugins_url('/Alp_Con_Core.js', __FILE__), '1.0.0', true);
	echo "<script type='text/javascript'>ALP_CON_POPUP_DATA = [];ALP_CON_POPUP_URL = '".ALP_CON_POPUP_URL."';ALP_CON_POPUP_VERSION='".ALP_CON_POPUP_VERSION."_".ALP_CON_POPUP_PRO."'</script>";
}
add_action('wp_enqueue_scripts', 'AlpFrontendScripts');