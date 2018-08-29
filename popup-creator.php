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

$mainPopupObjects = new AlpConPopupCreatorMain();
$mainPopupObjects->init();

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


function AlpConMyScript() {

		// ALPCONPopup::$ScriptsRegistered = true;		

		wp_register_style('alp_con_animate', ALP_CON_POPUP_URL . '/style/Alp_Con_Animate.css');
		wp_enqueue_style('alp_con_animate');
		wp_register_script('alp_popup_frontend', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Frontend.js',array('jquery', 'Alp_Con_Resize'),ALP_CON_POPUP_VERSION);
		wp_enqueue_script('alp_popup_frontend');
		wp_localize_script('alp_popup_frontend', 'ALPBParams',AlpPopupCreatorConfig::getPopupCreatorFrontendScriptLocalizedStoredData());
		wp_enqueue_script('jquery');
		wp_register_script('alp_popup_init', ALP_CON_POPUP_URL . '/javascript/Alp_Con_init.js', array('jquery'), ALP_CON_POPUP_VERSION);
		wp_enqueue_script('alp_popup_init');
		wp_register_script('Alp_Con_Resize', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Resize.js', array('jquery'), ALP_CON_POPUP_VERSION);
		wp_enqueue_script('Alp_Con_Resize');
		wp_register_script('alp_cookie', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Jquery_Cookie.js', array('jquery'));
		wp_enqueue_script('alp_cookie');
		wp_register_script('alp_colorbox', ALP_CON_POPUP_URL . '/javascript/Alp_Con_Jquery_Colorbox_min.js', array('jquery'), '5.0');
		wp_enqueue_script('alp_colorbox');
		
		//echo "<script type='text/javascript'>ALP_CON_POPUP_DATA = [];ALP_CON_POPUP_URL = '".ALP_CON_POPUP_URL."';</script>";

		/* For ajax case */
		if (defined('DOING_AJAX') && DOING_AJAX && !is_admin()) {
			wp_print_scripts('alp_popup_frontend');
			wp_print_scripts('alp_colorbox');
			wp_print_scripts('AlpPopupPro');
			wp_print_scripts('alp_cookie');
			wp_print_scripts('alp_con_animate');
			wp_print_scripts('alp_popup_init');
		}
	}
	add_action('wp_enqueue_scripts', 'AlpConMyScript');
	function alpRenderPopupScript($id)
	{
		// if (ALPCONPopup::$ScriptsRegistered == false) {
		// 	AlpConMyScript();
		// }
		wp_register_style('alp_colorbox_theme', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme1.css");
		wp_register_style('alp_colorbox_theme2', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme2.css");
		wp_register_style('alp_colorbox_theme3', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme3.css");
		wp_register_style('alp_colorbox_theme4', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme4.css");
		wp_register_style('alp_colorbox_theme5', ALP_CON_POPUP_URL . "/style/alpcolorbox/theme5.css");
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

	if (ALP_CON_POPUP_PKG == ALP_CON_POPUP_PKG_PLATINUM) {
		$userCountryIso = ALPFunctions::getUserLocation($id);
		if (!is_bool($userCountryIso)) {
			echo "<script type='text/javascript'>alpUserData = {
			'countryIsoName': '$userCountryIso'
		}</script>";
		}
	}

	echo "<script type='text/javascript'>";
	echo @$content;
	echo "</script>";
}

function alpShowShortCode($args, $content)
{
	ob_start();
	$obj = ALPCONPopup::findById($args['id']);
	if (!$obj) {
		return $content;
	}
	/*When inside popup short code content is empty*/
	if (isset($args['insideaddpopup']) && empty($content)) {
		return;
	}
	if (!empty($content)) {
		$attr = '';
		$eventName = @$args['event'];

		if (isset($args['insideaddpopup'])) {
			$attr .= 'insideaddpopup="on"';
			global $ALPCON_INSIDE_POPUPS;
			if (!in_array($args['id'], $ALPCON_INSIDE_POPUPS)) {
				$ALPCON_INSIDE_POPUPS[] = $args['id'];
				alpRenderPopupScript($args['id']);
			}
		}
		else {
			alpRenderPopupScript($args['id']);
		}
		if (@$args['event'] == 'onload') {
			$content = '';
		}
		if (!isset($args['event'])) {
			$eventName = 'click';
		}
		if (isset($args["wrap"])) {
			echo "<" . $args["wrap"] . " class='alp-show-popup' data-alpPopupID=" . @$args['id'] . " $attr data-popup-event=" . $eventName . ">" . $content . "</" . $args["wrap"] . " >";
		} else {
			echo "<a href='javascript:void(0)' class='alp-show-popup' data-alpPopupID=" . @$args['id'] . " $attr data-popup-event=" . $eventName . ">" . $content . "</a>";
		}
	} else {
		/* Free user does not have QUEUE possibility */
		if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
			$page = get_queried_object_id();
			$popupsId = ALPCONPopup::allowPopupInAllPages($page, 'page');

			/* Add shordcode popup id in the QUEUE for php side */
			array_push($popupsId, $args['id']);
			/* Add shordcode popup id at the first in the QUEUE for javascript side */
			echo "<script type=\"text/javascript\">ALP_CON_POPUPS_QUEUE.splice(0, 0, " . $args['id'] . ");</script>";
			update_option("ALP_CON_MULTIPLE_POPUP", $popupsId);
			showPopupInallpages($args['id']);
		} else {
			echo showPopupInallpages($args['id']);
		}

	}
	$shortcodeContent = ob_get_contents();
	ob_end_clean();
	return do_shortcode($shortcodeContent);
}

add_shortcode('alp_popup', 'alpShowShortCode');

function alpAutoloadPopup($args) {
	$PopupID = ALPCONPopup::findById($args['id']);
	if(!$PopupID) {
		return;
	}
	alpRenderPopupOpen($args['id']);
}
add_shortCode('alp_con_popup', 'alpAutoloadPopup');

function alpRenderPopupOpen($PopupID)
{
	alpRenderPopupScript($PopupID);

	echo "<script type=\"text/javascript\">

		alpAddEvent(window, 'load',function() {
			var alpPoupFrontendObj = new ALPCONPopup();
			alpPoupFrontendObj.popupOpenById($PopupID)
		});
	</script>";
}

function showPopupInallpages($PopupID)
{

	$isActivePopup = AlpConPopupGetData::isActivePopupCreator($PopupID);

	if (!$isActivePopup) {
		return false;
	}

	if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {

		$popupInTimeRange = ALPCONPopup::popupInTimeRange($PopupID);

		if (!$popupInTimeRange) {
			return false;
		}

		$isInSchedule = ALPCONPopup::popupInSchedule($PopupID);

		if (!$isInSchedule) {
			return;
		}

		$showUser = ALPCONPopup::showUserResolution($PopupID);
		if (!$showUser) return false;

		if (!ALPCONPopup::showPopupForCounrty($PopupID)) { /* Sended PopupID and function return true or false */
			return;
		}
	}
	redenderScriptModes($PopupID);
}

function redenderScriptModes($PopupID)
{
	/* If user delete popup */
	$obj = ALPCONPopup::findById($PopupID);

	if (empty($obj)) {
		return;
	}

	$multiplePopup = get_option('ALP_CON_MULTIPLE_POPUP');

	if ($hasEvent != 0) {
		alpRenderPopupScript($PopupID);
		return;
	}
	if ($multiplePopup && @in_array($PopupID, $multiplePopup)) {
		alpRenderPopupScript($PopupID);
		return;
	}


	alpRenderPopupOpen($PopupID);
}

function getPopupIDFromContet($content)
{
	$popupsID = array();
	$popupClasses = array(
		'alp-popup-id-',
		'alp-iframe-popup-',
		'alp-confirm-popup-',
		'alp-popup-hover-'
	);

	foreach ($popupClasses as $popupClassName) {

		preg_match_all("/" . $popupClassName . "+[0-9]+/i", $content, $matchers);

		foreach ($matchers['0'] as $value) {
			$ids = explode($popupClassName, $value);
			$id = @$ids[1];

			if (!empty($id)) {
				array_push($popupsID, $id);
			}
		}
	}

	return $popupsID;
}

function getPopupIDInPage($pageId)
{

	$postContentObj = get_post($pageId);

	if (isset($postContentObj)) {
		$content = $postContentObj->post_content;

		/*this will return template for the current page*/
		$templatePath = get_page_template();

		if (!empty($templatePath)) {
			$content .= file_get_contents($templatePath);
		}

		if (isset($postContentObj->post_excerpt)) {
			$content .= $postContentObj->post_excerpt;
		}
		return getPopupIDFromContet($content);
	}

	return 0;
}


/**
 * Get popup id from url
 *
 * @since 3.1.5
 *
 * @return  int if popup not found->0 otherwise->PopupID
 *
 */

function getFromUrlPopupID()
{

	$PopupID = 0;
	if (!isset($_SERVER['REQUEST_URI'])) {
		return $PopupID;
	}

	$pageUrl = @$_SERVER['REQUEST_URI'];
	$byUrlkeys = array('alp_popup_id', 'alp_popup_preview_id');

	foreach ($byUrlkeys as $urlkey) {
		preg_match("/".$urlkey."=+[0-9]+/i", $pageUrl, $match);

		if (!empty($match)) {
			$matchingNumber = explode("=", $match[0]);
			if (!empty($matchingNumber[1])) {
				$PopupID = (int)$matchingNumber[1];
				return $PopupID;
			}
			return 0;
		}
	}

	return 0;
}

function alpOnloadPopup()
{
	$page = get_queried_object_id();
	$postType = get_post_type();
	echo AlpPopupCreatorConfig::popupJsDataInitValues();
	$popup = "alp_promotional_popup";
	/* If popup is set on page load */
	$PopupID = ALPCONPopup::getPagePopupID($page,$popup);
	/* get all popups id which set in current page by class */
	$popupsIdByClass = getPopupIDInPage($page);
	/* get popup id in page url */
	$PopupIDInPageUrl = getFromUrlPopupID();

	if(ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
		delete_option("ALP_CON_MULTIPLE_POPUP");

		/* Retrun all popups id width selected On All Pages */
		$popupsId = ALPCONPopup::allowPopupInAllPages($page, 'page');
		$categories = ALPCONPopup::allowPopupInAllCategories($page);

		$popupsId = array_merge($popupsId, $categories);

		$alpbAllPosts = get_option("ALP_CON_ALL_POSTS");

		$popupsInAllPosts = ALPCONPopup::popupsIdInAllCategories($postType);
		$popupsId = array_merge($popupsInAllPosts, $popupsId);

		/* $popupsId[0] its last selected popup id */
		if (isset($popupsId[0])) {
			if (count($popupsId) > 0) {
				update_option("ALP_CON_MULTIPLE_POPUP", $popupsId);
			}
			foreach ($popupsId as $queuePupupId) {

				showPopupInallpages($queuePupupId);
			}
			$popupsId = json_encode($popupsId);
		} else {
			$popupsId = json_encode(array());
		}
		$popupsId = ALPCONPopup::filterForRandomIds($popupsId);

		echo '<script type="text/javascript">ALP_CON_POPUPS_QUEUE = '.$popupsId.';</script>';
	}

	//If popup is set for all pages
	if ($PopupID != 0) {
		showPopupInallpages($PopupID);
	}

	if (!empty($popupsIdByClass)) {
		foreach ($popupsIdByClass as $PopupID) {
			alpRenderPopupScript($PopupID);
		}
	}
	if ($PopupIDInPageUrl) {
		showPopupInallpages($PopupIDInPageUrl);
	}
	return false;
}

add_filter('wp_nav_menu_items', 'getPopupIDByClass');
function getPopupIDByClass($items)
{
	$popupsID = getPopupIDFromContet($items);
	if (!empty($popupsID)) {
		foreach ($popupsID as $popupsID) {
			alpRenderPopupScript($popupsID);
		}
	}
	return $items;
}

add_action('wp_head', 'alpOnloadPopup');
// require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Media.php'); 
require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Popup_GetData.php'); 
require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Popup_Save.php'); // saving form data
require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Popup_Ajax.php');
