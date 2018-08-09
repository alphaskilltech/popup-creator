<?php
function alpSanitizeAjaxField($optionValue,  $isTextField = false) {
	/*TODO: Extend function for other sanitization and validation actions*/
	if(!$isTextField) {
	//	return sanitize_text_field($optionValue);
	}
}
function alpPopupDelete()
{
	// check_ajax_referer('AlpConPopupBuilderDeleteNonce', 'ajax_Nonce');
	$id = (int)@$_POST['popup_id'];

	if($id == 0 || !$id) {
		return;
	}
	require_once(ALP_CON_POPUP_CLASS.'/Alp_Con_Popup.php');
	ALPCONPopup::delete($id);
	// ALPCONPopup::removePopupFromPages($id);
	$args = array('popupId'=> $id);
	do_action('alpPopupDelete', $args);
}

add_action('wp_ajax_delete_popup_creator', 'alpPopupDelete');


function alpCloseReviewPanel()
{
	check_ajax_referer('alpPopupCreatorReview', 'ajax_Nonce');
    update_option('ALP_CON_COLOSE_REVIEW_BLOCK', true);
}
add_action('wp_ajax_close_review_panel', 'alpCloseReviewPanel');

function alpChangePopupStatus() {
	check_ajax_referer('AlpConPopupCreatoreDeactivateNonce', 'ajax_Nonce');
	$popupId = (int)$_POST['popupId'];
	
	$obj = ALPCONPopup::findById($popupId);
	$options = json_decode($obj->getOptions(), true);
	$options['isActiveStatus'] = alpSanitizeAjaxField($_POST['popupStatus']);
	
	$obj->setOptions(json_encode($options));
	$obj->save();
}	
add_action('wp_ajax_change_popup_status', 'alpChangePopupStatus');
// Postid 
if(!function_exists('load_my_script')){
    function load_my_script() {
        global $post;
        $deps = array('jquery');
        $version= '1.0'; 
        $in_footer = true;
        wp_enqueue_script('my-script', get_stylesheet_directory_uri() . '/js/my-script.js', $deps, $version, $in_footer);
        wp_localize_script('my-script', 'my_script_vars', array(
                'postID' => $post->ID
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'load_my_script');


function PopupPreview() {
	check_ajax_referer('popup-creator-ajax', 'ajax_Nonce');
// alert("dfdfdf");
	$formSerializedData = $_POST['popupDta'];
	if(get_option('popupPreviewId')) {
		$id = (int)get_option('popupPreviewId');

		if($id == 0 || !$id) {
			return;
		}

		require_once(ALP_CON_POPUP_CLASS.'/Alp_Con_Popup.php');
		$delete = ALPCONPopup::delete($id);
		if(!$delete) {
			delete_option('popupPreviewId');
		}

		$args = array('popupId'=> $id);
		do_action('alpPopupDelete', $args);
	}

	parse_str($formSerializedData, $popupPreviewPostData);
	$popupPreviewPostData['allPagesStatus'] = '';
	$popupPreviewPostData['allPostsStatus'] = '';
	$popupPreviewPostData['allCustomPostsStatus'] = '';
	$popupPreviewPostData['onScrolling'] = '';
	$popupPreviewPostData['inActivityStatus'] = '';
	$popupPreviewPostData['popup-timer-status'] = '';
	$popupPreviewPostData['popup-schedule-status'] = '';
	$popupPreviewPostData['alp-user-status'] = '';
	$popupPreviewPostData['countryStatus'] = '';
	$popupPreviewPostData['forMobile'] = '';
	$popupPreviewPostData['openMobile'] = '';
	$popupPreviewPostData['hidden_popup_number'] = '';
	$popupPreviewPostData['repeatPopup'] = '';
	$_POST += $popupPreviewPostData;

	$showAllPages = alpSanitize('allPages');
	$showAllPosts = alpSanitize('allPosts');
	$showAllCustomPosts = alpSanitize('allCustomPosts');
	$allSelectedPages = "";
	$allSelectedPosts = "";
	$allSelectedCustomPosts = "";
	$allSelectedCategories = alpSanitize("posts-all-categories", true);

	$selectedPages = alpSanitize('all-selected-page');
	$selectedPosts = alpSanitize('all-selected-posts');
	$selectedCustomPosts = alpSanitize('all-selected-custom-posts');

	/* if popup check for all pages it is not needed for save all pages all posts */
	if($showAllPages !== "all" && !empty($selectedPages)) {
		$allSelectedPages = explode(",", $selectedPages);
	}

	if($showAllPosts !== "all" && !empty($selectedPosts)) {
		$allSelectedPosts = explode(",", $selectedPosts);
	}
	if($showAllCustomPosts !== "all" && !empty($selectedCustomPosts)) {
		$allSelectedCustomPosts = explode(",", $selectedCustomPosts);
	}

	$addToGeneralOptions = array(
		'showAllPages' => array(),
		'showAllPosts' => array(),
		'showAllCustomPosts' => array(),
		'allSelectedPages' => array(),
		'allSelectedPosts' => array(),
		'allSelectedCustomPosts' => array(),
		'allSelectedCategories'=> array(),
		'fblikeOptions'=> $fblikeOptions,
		'videoOptions'=>$videoOptions,
		'exitIntentOptions'=> $exitIntentOptions,
		'countdownOptions'=> $countdownOptions,
		'socialOptions'=> $socialOptions,
		'socialButtons'=> $socialButtons
	);

	$options = IntegrateExternalSettings::getPopupGeneralOptions($addToGeneralOptions);

	$html = stripslashes(alpSanitize("sg_popup_html"));
	// $fblike = stripslashes(alpSanitize("sg_popup_fblike"));
	// $ageRestriction = stripslashes(alpSanitize('sg_ageRestriction'));
	// $social = stripslashes(alpSanitize('sg_social'));
	// $image = alpSanitize('ad_image');
	// $countdown = stripslashes(alpSanitize('sg_countdown'));
	// $subscription = stripslashes(alpSanitize('sg_subscription'));
	// $sgContactForm = stripslashes(alpSanitize('sg_contactForm'));
	// $iframe = alpSanitize('iframe');
	// $video = alpSanitize('video');
	// $shortCode = stripslashes(alpSanitize('shortcode'));
	// $mailchimp = stripslashes(alpSanitize('sg_popup_mailchimp'));
	// $aweber = stripslashes(alpSanitize('sg_popup_aweber'));
	// $exitIntent = stripslashes(alpSanitize('sg-exit-intent'));
	$type = alpSanitize('type');


	$title = stripslashes(alpSanitize('title'));
	$id = alpSanitize('hidden_popup_number');
	$jsonDataArray = json_encode($options);

	$data = array(
		'id' => $id,
		'title' => $title,
		'type' => $type,
		'html' => $html,
		'shortcode' => $shortCode,
		'alp_subscription' => $subscription,
		'aweber' => $aweber,
		'options' => $jsonDataArray,
		'subscriptionOptions' => json_encode($subscriptionOptions),
		'contactFormOptions' => json_encode($contactFormOptions)
	);

	function setPopupForAllPages($id, $data, $type) {
		//-1 is the home page key
		if(is_array($data) && $data[0] == -1 && defined('ICL_LANGUAGE_CODE')) {
			$data[0] .='_'.ICL_LANGUAGE_CODE;
		}
		ALPCONPopup::addPopupForAllPages($id, $data, $type);
	}

	function setOptionPopupType($id, $type) {
		update_option("ALP_CON_POPUP_".strtoupper($type)."_".$id,$id);
	}

	$popupName = "ALP".sanitize_text_field(ucfirst(strtolower($popupPreviewPostData['type'])));
	$popupClassName = $popupName."Popup";
	$classPath = ALP_CON_APP_POPUP_PATH;

	if($type == 'mailchimp' || $type == 'aweber') {

		$currentActionName1 = IntegrateExternalSettings::getCurrentPopupAppPaths($type);
		$classPath = $currentActionName1['app-path'];
	}

	require_once($classPath ."/class/".$popupClassName.".php");

	if ($id == "") {
		global $wpdb;

		call_user_func(array($popupClassName, 'create'), $data);

		$lastId = $wpdb->get_var("SELECT LAST_INSERT_ID() FROM ".  $wpdb->prefix."alp_con_popup");
		$postData['saveMod'] = '';
		$postData['popupId'] = $lastId;
		// $extensionManagerObj = new SGPBExtensionManager();
		$extensionManagerObj->setPostData($postData);
		$extensionManagerObj->save();
		update_option('popupPreviewId', $lastId);
		setOptionPopupType($lastId, $type);
		echo $lastId;
		die();
	}

	die();
}

add_action('wp_ajax_save_popup_preview_data', 'PopupPreview');
