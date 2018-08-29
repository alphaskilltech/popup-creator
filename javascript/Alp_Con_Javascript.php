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

		// wp_enqueue_media();
		wp_register_script('javascript', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Backend.js', array('jquery', 'wp-color-picker'));
		wp_register_script('Alp_Con_Custom_script', ALP_CON_POPUP_URL . '/javascript/admin/Alp_Con_Custom_script.js',array('jquery', 'wp-color-picker'));
	    wp_enqueue_script('Alp_Con_Custom_script');
		wp_enqueue_script('jquery');
		wp_enqueue_script('javascript');
	
		$localizedData = array(
		    'ajax_Nonce' => wp_create_nonce('popup-creator-ajax', 'alp_con_ajax_Nonce')
		);
		wp_localize_script('javascript', 'backendLocalData', $localizedData);	
		
    }
	else if('toplevel_page_popupcreator' == $hook  || $hook == 'toplevel_page_popup-settings'){
		wp_register_script('javascript', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Backend.js', array('jquery'));
		wp_enqueue_script('jquery');
		wp_enqueue_script('javascript');
	}	
	if('popupcreator_page_popup-edit' == $hook) {
		wp_register_script('Alp_Con_Range_Slider', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Range_Slider.js', array('jquery'));
		wp_enqueue_script('Alp_Con_Range_Slider');	
		wp_enqueue_script('jquery');
	}

wp_register_script('Alp_Con_Date', ALP_CON_POPUP_URL . '/javascript/admin/Alp_Con_Date.js', array(), '2.15.1');
wp_enqueue_script('Alp_Con_Date');

wp_register_script('Alp_Con_Date_Script', ALP_CON_POPUP_URL . '/javascript/admin/Alp_Con_Date_Script.js',  array(), '4.7.14');
wp_enqueue_script('Alp_Con_Date_Script');

wp_register_script('Alp_Con_Date_Style', ALP_CON_POPUP_URL . '/javascript/admin/Alp_Con_Date_Style.js', array(), '3.3.7');
wp_enqueue_script('Alp_Con_Date_Style');

wp_register_script('Alp_Con_MultiSelectjs', ALP_CON_POPUP_URL . '/javascript/admin/Alp_Con_Multiselectjs.js', array());
wp_enqueue_script('Alp_Con_MultiSelectjs');
}

add_action('admin_enqueue_scripts', 'alp_set_admin_url');
add_action('admin_enqueue_scripts', 'alp_popup_admin_scripts');


function AlpFrontendScripts() {
	wp_enqueue_script('alp_popup_core', plugins_url('/Alp_Con_Core.js', __FILE__), '1.0.0', true);
	echo "<script type='text/javascript'>ALP_CON_POPUP_DATA = [];ALP_CON_POPUP_URL = '".ALP_CON_POPUP_URL."';ALP_CON_POPUP_VERSION='".ALP_CON_POPUP_VERSION."_".ALP_CON_POPUP_PRO."'</script>";
}
add_action('wp_enqueue_scripts', 'AlpFrontendScripts');

// function media_uploader() {
//     global $post_type;
//     if( 'custom-post-type' == $post_type) {
//         if(function_exists('wp_enqueue_media')) {
//             wp_enqueue_media();
//         }
//         else {
//             wp_enqueue_script('media-upload');
//             wp_enqueue_script('thickbox');
//             wp_enqueue_style('thickbox');
//         }
//     }
// }
// add_action('admin_enqueue_scripts', 'media_uploader');
