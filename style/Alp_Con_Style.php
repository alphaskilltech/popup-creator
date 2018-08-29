<?php

	function load_alp_con_wp_admin_style($hook) {
		// Load only on ?page=mypluginname
		if ('toplevel_page_popupcreator' != $hook && 'popup-up-creator_page_popup_create' != $hook  && 'popup-up-creator_page_popup-edit' !=$hook ){
			return;
		}
		wp_register_style('Alp_Con_Popup_Style', ALP_CON_POPUP_URL . '/style/Alp_Con_Popup_Style.css', false, '1.0.0');
		wp_enqueue_style('Alp_Con_Popup_Style');
		
		wp_register_style('Alp_Con_Animate', ALP_CON_POPUP_URL . '/style/Alp_Con_Animate.css',  false, '3.5.2' );
		wp_enqueue_style('Alp_Con_Animate');

		wp_register_style('Alp_Con_Font_Awesome', ALP_CON_POPUP_URL . '/style/admin/Alp_Con_Font_Awesome.css',  array(), '5.0.13' );
		wp_enqueue_style('Alp_Con_Font_Awesome');

		wp_register_style('Alp_Con_Bootstrap_min', ALP_CON_POPUP_URL . '/style/admin/Alp_Con_Bootstrap_min.css',  array(), '3.3.7' );
		wp_enqueue_style('Alp_Con_Bootstrap_min');

		wp_register_style('Alp_Con_Datetimepicker', ALP_CON_POPUP_URL . '/style/admin/Alp_Con_Datetimepicker.css',  array(), '4.7.14' );
		wp_enqueue_style('Alp_Con_Datetimepicker');

		wp_register_style('Alp_Con_Multiselect', ALP_CON_POPUP_URL . '/style/admin/Alp_Con_Multiselect.css' );
		wp_enqueue_style('Alp_Con_Multiselect');
	
		// wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css', '', '5.0.13', 'all'); 
		// wp_enqueue_style('datetimepicker', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'); 
		// wp_enqueue_style('datetimepickercss', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css'); 
		// wp_enqueue_style('multiselect', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css'); 
	}
	add_action( 'admin_enqueue_scripts', 'load_alp_con_wp_admin_style' );
function alp_con_popup_style($hook) {
	// && 'post.php' != $hook
	if ('admin.php' != $hook) {
		return;
	}
	wp_register_style('Alp_Con_Animate', ALP_CON_POPUP_URL . '/style/Alp_Con_Animate.css', false, '3.5.2');
	wp_enqueue_style('Alp_Con_Animate');

	wp_register_style('Alp_Con_Popup_Style', ALP_CON_POPUP_URL . '/style/Alp_Con_Popup_Style.css', false, '1.0.0');
	wp_enqueue_style('Alp_Con_Popup_Style');
}
add_action('admin_enqueue_scripts', 'alp_con_popup_style');
add_action( 'admin_enqueue_scripts', 'alp_mw_enqueue_color_picker' );
function alp_mw_enqueue_color_picker( $hook_suffix ) {
	if('popupcreator_page_popup-edit' != $hook_suffix)  {
		return;
	}
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('javascript/Alp_Con_Colorpicker.js',dirname(__FILE__)), array( 'wp-color-picker' ) );
}