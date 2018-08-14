<?php
/**
 * @package Pop Up Creator Plugin
 */
/*
Plugin Name: Pop Up Creator
Plugin URI: http://alphaskilltech.com/projects
Description: The beautiful popup plugin. Html,Contact many other popup types. create your own popup dimensions, effects, themes and more.
Version: 1.0.0
Author: Manikandan
Author URI: http://alphaskilltech.com/
License: Gplv2 or later 
Text Domain: popup-creator plugin
*/

require_once(dirname(__FILE__)."/config.php");
require_once(ALP_CON_POPUP_CLASS .'/Alp_Con_Popup_Main.php');

$mainPopupObj = new AlpConPopupCreatorMain();
$mainPopupObj->init();

require_once( ALP_CON_POPUP_CLASS .'/Alp_Con_Popup.php');
require_once(ALP_CON_POPUP_FILES .'/Alp_Con_Functions.php');
require_once(ALP_CON_POPUP_FILES .'/Alp_Con_Popup_GetData.php');
require_once( ALP_CON_POPUP_CLASS .'/Alp_Con_Installer.php'); //cretae tables

require_once( ALP_CON_POPUP_STYLE .'/Alp_Con_Style.php' ); //include our css file
require_once( ALP_CON_POPUP_JS .'/Alp_Con_Javascript.php' ); //include our js file
require_once( ALP_CON_POPUP_FILES .'/Alp_Con_Selection.php' ); //include our js file

register_activation_hook(__FILE__, 'alp_con_Activate');
// register_uninstall_hook(__FILE__, 'alp_con_Deactivate');

add_action('wpmu_new_blog', 'alp_con_BlogPopup', 10, 6);

function alp_con_BlogPopup()
{
	Alp_Con_Installer::install();
	if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
		Alp_Con_Installer::install();
	}
}

function alp_con_Activate()
{
	update_option('ALP_CON_POPUP_VERSION', ALP_CON_POPUP_VERSION);
	Alp_Con_Installer::install();
	if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
		Alp_Con_Installer::install();
	}
}

	// function alp_con_Deactivate()
	// {
	// 	Alp_Con_Installer::uninstall();
	// 	if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
	// 		Alp_Con_Installer::uninstall();
	// 	}
	//  }

	function alpRegisterScripts()
	{
		ALPCONPopup::$registeredScripts = true;
		wp_register_style('alp_animate', ALP_CON_POPUP_URL . '/style/Alp_Con_Animate.css');
		wp_enqueue_style('alp_animate');
		wp_register_script('alp_popup_frontend', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Frontend.js',array('jquery', 'Alp_Con_Resize'),ALP_CON_POPUP_VERSION);
		wp_enqueue_script('alp_popup_frontend');
		wp_localize_script('alp_popup_frontend', 'ALPBParams',AlpPopupCreatorConfig::getPopupCreatorFrontendScriptLocalizedData());
		wp_register_script('Alp_Con_Resize', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Resize.js', array('jquery'), ALP_CON_POPUP_VERSION);
		wp_enqueue_script('Alp_Con_Resize');
		wp_enqueue_script('jquery');
		wp_register_script('alp_cookie', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Jquery_Cookie.js', array('jquery'));
		wp_enqueue_script('alp_cookie');
		wp_register_script('alp_colorbox', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Jquery_Colorbox-min.js', array('jquery'), '5.0');
		wp_enqueue_script('alp_colorbox');

		if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) { 
			wp_register_script('AlpConPopupPro', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Pro.js?ver=4.2.3');
			wp_enqueue_script('AlpConPopupPro');
			
				wp_register_script('AlpPopupPro', ALP_CON_POPUP_URL . '/javascript/Alp_Popup_Pro.js', array(), ALP_CON_POPUP_VERSION);
				wp_enqueue_script('AlpPopupPro');
				wp_register_script('Alp_cookie', ALP_CON_POPUP_URL . '/javascript/jquery_cookie.js', array('jquery'), ALP_CON_POPUP_VERSION);
				wp_enqueue_script('Alp_cookie');
				wp_register_script('Alp_Con_Popup_Queue', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Popup_Queue.js', array(), ALP_CON_POPUP_VERSION);
				wp_enqueue_script('Alp_Con_Popup_Queue');
		}
		echo "<script type='text/javascript'>ALP_POPUP_DATA = [];ALP_CON_POPUP_URL = '".ALP_CON_POPUP_URL."';</script>";
	}

	function alpRenderPopupScript($id)
	{
		if (ALPCONPopup::$registeredScripts==false) {
			alpRegisterScripts();
		}
		wp_register_style('alp_colorbox_theme', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme1.css");
		wp_register_style('alp_colorbox_theme2', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme2.css");
		wp_register_style('alp_colorbox_theme3', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme3.css");
		wp_register_style('alp_colorbox_theme4', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme4.css");
		wp_register_style('alp_colorbox_theme5', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme5.css", array(), '5.0');
		wp_enqueue_style('alp_colorbox_theme');
		wp_enqueue_style('alp_colorbox_theme2');
		wp_enqueue_style('alp_colorbox_theme3');
		wp_enqueue_style('alp_colorbox_theme4');
		wp_enqueue_style('alp_colorbox_theme5');
		alpFindPopupData($id);
	}

	function alpFindPopupData($id)
	{
		$obj = ALPCONPopup::findById($id);
		if (!empty($obj)) {
			$content = $obj->render();
		}
		echo "<script type='text/javascript'>";
		echo $content;
		echo "</script>";
	}

	function alpShowShortCode($args, $content)
	{
		ob_start();
		$obj = ALPCONPopup::findById($args['id']);
		if (!$obj) {
			return $content;
		}
		if(!empty($content)) {
			alpRenderPopupScript($args['id']);
			return "<a href='javascript:void(0)' class='alp-show-popup' data-alppopupid=".$args['id'].">".$content."</a>";
		}
		else {
			//alpRenderPopupOpen($args['id']);
			echo redenderScriptModes($args['id']);
		}
		$shortcodeContent = ob_get_contents();
		ob_end_clean();
		return $shortcodeContent;
	}
	add_shortCode('alp_popup', 'alpShowShortCode');

	function alpAutoloadPopup($args) {
		$popupId = ALPCONPopup::findById($args['id']);
		if(!$popupId) {
			return;
		}
		alpRenderPopupOpen($args['id']);
	}
	add_shortCode('alp_con_popup', 'alpAutoloadPopup');

	function alpRenderPopupOpen($popupId)
	{
		alpRenderPopupScript($popupId);
		
		echo "<script type=\"text/javascript\">

		alpAddEvent(window, 'load',function() {
			var alpPoupFrontendObj = new ALPCONPopup();
			alpPoupFrontendObj.popupOpenById($popupId)
		});
	</script>";
	}

	function showPopupInPages($popupId) {
		
		$isActivePopup = AlpConPopupGetData::isActivePopup($popupId);

			if(!$isActivePopup) {
				return false;
			}

			if(ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {

				$popupInTimeRange = ALPCONPopupPro::popupInTimeRange($popupId);
		
				if(!$popupInTimeRange) {
					return false;
				}
		
				$isInSchedule = ALPCONPopupPro::popupInSchedule($popupId);
		
				if(!$isInSchedule) {
					return;
				}
		
				$showUser = ALPCONPopupPro::showUserResolution($popupId);
				if(!$showUser) return false;
		
				if(!ALPCONPopup::showPopupForCounrty($popupId)) { /* Sended popupId and function return true or false */
					return;
				}
			}
		redenderScriptModes($popupId);
	}

	function redenderScriptModes($popupId)
	{

		/* If user delete popup */
	$obj = ALPCONPopup::findById($popupId);

	if(empty($obj)) {
		return;
	}

	$multiplePopup = get_option('ALP_CON_MULTIPLE_POPUP');
	// $hasEvent = ALPCONExtension::hasPopupEvent($popupId);

	if($hasEvent != 0) {
		alpRenderPopupScript($popupId);
		return;
	}
	if($multiplePopup && @in_array($popupId, $multiplePopup)) {
		alpRenderPopupScript($popupId);
		return;
	}
		alpRenderPopupOpen($popupId);
	}



	function alpOnloadPopup()
	{
		$page = get_queried_object_id ();
		$popup = "alp_promotional_popup";
		$popupId = ALPCONPopup::getPagePopupId($page,$popup);



		if (!$popupId) {
			return;
		}
		alpRenderPopupOpen($popupId);
		if($popupId != 0) {
			showPopupInPages($popupId);
		}
		elseif(ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
			require_once(ALP_CON_POPUP_FILES ."/Alp_Con_Pro.php");
			$popupId = ALPCONPopupPro::allowPopupInAllPages($page);
			if($popupId) {
				showPopupInPages($popupId);
			}
		}
		return false;
	}

	add_action('wp_head','alpOnloadPopup');
	require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Popup_Save.php'); // saving form data
	require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Popup_Ajax.php');


	function alpPopupPluginLoaded()
	{
		$versionPopup = get_option('ALP_CON_POPUP_VERSION');
		if (!$versionPopup || $versionPopup < ALP_CON_POPUP_VERSION ) {
			update_option('ALP_CON_POPUP_VERSION', ALP_CON_POPUP_VERSION);
			Alp_Con_Installer::install();
			Alp_Con_Installer::convert();
		}
	}