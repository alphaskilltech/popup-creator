<?php
function alpPopupDelete()
{
	$id = (int)@$_POST['popup_id'];
	if (!$id) {
		return;
	}
	require_once(ALP_CON_POPUP_CLASS.'/Alp_Con_Popup.php');
	ALPCONPopup::delete($id);
	ALPCONPopup::removePopupFromPages($id);
}

add_action('wp_ajax_delete_popup', 'alpPopupDelete');

function savePopupPreviewData() {
	check_ajax_referer('popup-creator-ajax', 'ajaxNonce');

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



	$subscriptionOptions = array(
		'subs-first-name-status' => alpSanitize('subs-first-name-status'),
		'subs-last-name-status' => alpSanitize('subs-last-name-status'),
		// email input placeholder text
		'subscription-email' => alpSanitize('subscription-email'),
		'subs-first-name' => alpSanitize('subs-first-name'),
		'subs-last-name' => alpSanitize('subs-last-name'),
		'subs-text-width' => alpSanitize('subs-text-width'),
		'subs-button-bgColor' => alpSanitize('subs-button-bgColor'),
		'subs-btn-width' => alpSanitize('subs-btn-width'),
		'subs-btn-title' => alpSanitize('subs-btn-title'),
		'subs-text-input-bgColor' => alpSanitize('subs-text-input-bgColor'),
		'subs-text-borderColor' => alpSanitize('subs-text-borderColor'),
		'subs-button-color' => alpSanitize('subs-button-color'),
		'subs-inputs-color' => alpSanitize('subs-inputs-color'),
		'subs-btn-height' => alpSanitize('subs-btn-height'),
		'subs-text-height' => alpSanitize('subs-text-height'),
		'subs-placeholder-color' => alpSanitize('subs-placeholder-color'),
		'subs-validation-message' => alpSanitize('subs-validation-message'),
		'subs-success-message' => alpSanitize('subs-success-message'),
		'subs-btn-progress-title' => alpSanitize('subs-btn-progress-title'),
		'subs-text-border-width' => alpSanitize('subs-text-border-width'),
		'subs-success-behavior' => alpSanitize('subs-success-behavior'),
		'subs-success-redirect-url' => esc_url_raw(@$_POST['subs-success-redirect-url']),
		'subs-success-popups-list' => alpSanitize('subs-success-popups-list'),
		'subs-first-name-required' => alpSanitize('subs-first-name-required'),
		'subs-last-name-required' => alpSanitize('subs-last-name-required'),
		'subs-success-redirect-new-tab' => alpSanitize('subs-success-redirect-new-tab')
	);

	$contactFormOptions = array(
		'contact-name' => alpSanitize('contact-name'),
		'contact-name-status' => alpSanitize('contact-name-status'),
		'contact-name-required' => alpSanitize('contact-name-required'),
		'contact-subject' => alpSanitize('contact-subject'),
		'contact-subject-status' => alpSanitize('contact-subject-status'),
		'contact-subject-required' => alpSanitize('contact-subject-required'),
		// email input placeholder text(string)
		'contact-email' => alpSanitize('contact-email'),
		'contact-message' => alpSanitize('contact-message'),
		'contact-validation-message' => alpSanitize('contact-validation-message'),
		'contact-success-message' => alpSanitize('contact-success-message'),
		'contact-inputs-width' => alpSanitize('contact-inputs-width'),
		'contact-inputs-height' => alpSanitize('contact-inputs-height'),
		'contact-inputs-border-width' => alpSanitize('contact-inputs-border-width'),
		'contact-text-input-bgcolor' => alpSanitize('contact-text-input-bgcolor'),
		'contact-text-bordercolor' => alpSanitize('contact-text-bordercolor'),
		'contact-inputs-color' => alpSanitize('contact-inputs-color'),
		'contact-placeholder-color' => alpSanitize('contact-placeholder-color'),
		'contact-btn-width' => alpSanitize('contact-btn-width'),
		'contact-btn-height' => alpSanitize('contact-btn-height'),
		'contact-btn-title' => alpSanitize('contact-btn-title'),
		'contact-btn-progress-title' => alpSanitize('contact-btn-progress-title'),
		'contact-button-bgcolor' => alpSanitize('contact-button-bgcolor'),
		'contact-button-color' => alpSanitize('contact-button-color'),
		'contact-area-width' => alpSanitize('contact-area-width'),
		'contact-area-height' => alpSanitize('contact-area-height'),
		'sg-contact-resize' => alpSanitize('sg-contact-resize'),
		'contact-validate-email' => alpSanitize('contact-validate-email'),
		'contact-receive-email' => sanitize_email(@$_POST['contact-receive-email']),
		'contact-fail-message' => alpSanitize('contact-fail-message'),
		'show-form-to-top' => alpSanitize('show-form-to-top'),
		'contact-success-behavior' => alpSanitize('contact-success-behavior'),
		'contact-success-redirect-url' => alpSanitize('contact-success-redirect-url'),
		'contact-success-popups-list' => alpSanitize('contact-success-popups-list'),
		'dont-show-content-to-contacted-user' => alpSanitize('dont-show-content-to-contacted-user'),
		'contact-success-frequency-days' => alpSanitize('contact-success-frequency-days'),
		'contact-success-redirect-new-tab' => alpSanitize('contact-success-redirect-new-tab')
	);

	$fblikeOptions = array(
		'fblike-like-url' => esc_url_raw(@$_POST['fblike-like-url']),
		'fblike-layout' => alpSanitize('fblike-layout'),
		'fblike-dont-show-share-button' => alpSanitize('fblike-dont-show-share-button'),
		'fblike-close-popup-after-like' => alpSanitize('fblike-close-popup-after-like')
	);

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

	// $html = stripslashes(alpSanitize("sg_popup_html"));
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

	if($type == 'mailchimp') {

		// $mailchimpOptions = array(
		// 	'mailchimp-disable-double-optin' => alpSanitize('mailchimp-disable-double-optin'),
		// 	'mailchimp-list-id' => alpSanitize('mailchimp-list-id'),
		// 	'sg-mailchimp-form' => stripslashes(alpSanitize('sg-mailchimp-form')),
		// 	'mailchimp-required-error-message' => alpSanitize('mailchimp-required-error-message'),
		// 	'mailchimp-email-validate-message' => alpSanitize('mailchimp-email-validate-message'),
		// 	'mailchimp-error-message' => alpSanitize('mailchimp-error-message'),
		// 	'mailchimp-submit-button-bgcolor' => alpSanitize('mailchimp-submit-button-bgcolor'),
		// 	'mailchimp-form-aligment' => alpSanitize('mailchimp-form-aligment'),
		// 	'mailchimp-label-aligment' => alpSanitize('mailchimp-label-aligment'),
		// 	'mailchimp-success-message' => alpSanitize('mailchimp-success-message'),
		// 	'mailchimp-only-required' => alpSanitize('mailchimp-only-required'),
		// 	'mailchimp-show-form-to-top' => alpSanitize('mailchimp-show-form-to-top'),
		// 	'mailchimp-label-color' => alpSanitize('mailchimp-label-color'),
		// 	'mailchimp-input-width' => alpSanitize('mailchimp-input-width'),
		// 	'mailchimp-input-height' => alpSanitize('mailchimp-input-height'),
		// 	'mailchimp-input-border-radius' => alpSanitize('mailchimp-input-border-radius'),
		// 	'mailchimp-input-border-width' => alpSanitize('mailchimp-input-border-width'),
		// 	'mailchimp-input-border-color' => alpSanitize('mailchimp-input-border-color'),
		// 	'mailchimp-input-bg-color' => alpSanitize('mailchimp-input-bg-color'),
		// 	'mailchimp-input-text-color' => alpSanitize('mailchimp-input-text-color'),
		// 	'mailchimp-submit-width' => alpSanitize('mailchimp-submit-width'),
		// 	'mailchimp-submit-height' => alpSanitize('mailchimp-submit-height'),
		// 	'mailchimp-submit-border-width' => alpSanitize('mailchimp-submit-border-width'),
		// 	'mailchimp-submit-border-radius' => alpSanitize('mailchimp-submit-border-radius'),
		// 	'mailchimp-submit-border-color' => alpSanitize('mailchimp-submit-border-color'),
		// 	'mailchimp-submit-color' => alpSanitize('mailchimp-submit-color'),
		// 	'mailchimp-submit-title' => alpSanitize('mailchimp-submit-title'),
		// 	'mailchimp-email-label' => alpSanitize('mailchimp-email-label'),
		// 	'mailchimp-indicates-required-fields' => alpSanitize('mailchimp-indicates-required-fields'),
		// 	'mailchimp-asterisk-label' => alpSanitize('mailchimp-asterisk-label'),
		// 	'mailchimp-success-behavior' => alpSanitize('mailchimp-success-behavior'),
		// 	'mailchimp-success-redirect-url' => alpSanitize('mailchimp-success-redirect-url'),
		// 	'mailchimp-success-popups-list' => alpSanitize('mailchimp-success-popups-list'),
		// 	'mailchimp-success-redirect-new-tab' => alpSanitize('mailchimp-success-redirect-new-tab'),
		// 	'mailchimp-close-popup-already-subscribed' => alpSanitize('mailchimp-close-popup-already-subscribed')
		// );

		$options['mailchimpOptions'] = json_encode($mailchimpOptions);
	}

	if($type == 'aweber') {
		$aweberOptions = array(
			'sg-aweber-webform' => alpSanitize('sg-aweber-webform'),
			'sg-aweber-list' => alpSanitize('sg-aweber-list'),
			'aweber-custom-success-message' => alpSanitize('aweber-custom-success-message'),
			'aweber-success-message' => alpSanitize('aweber-success-message'),
			'aweber-custom-invalid-email-message' => alpSanitize('aweber-custom-invalid-email-message'),
			'aweber-invalid-email' => alpSanitize('aweber-invalid-email'),
			'aweber-custom-error-message' => alpSanitize('aweber-custom-error-message'),
			'aweber-error-message' => alpSanitize('aweber-error-message'),
			'aweber-custom-subscribed-message' => alpSanitize('aweber-custom-subscribed-message'),
			'aweber-already-subscribed-message' => alpSanitize('aweber-already-subscribed-message'),
			'aweber-validate-email-message' => alpSanitize('aweber-validate-email-message'),
			'aweber-required-message' => alpSanitize('aweber-required-message'),
			'aweber-success-behavior' => alpSanitize('aweber-success-behavior'),
			'aweber-success-redirect-url' => alpSanitize('aweber-success-redirect-url'),
			'aweber-success-popups-list' => alpSanitize('aweber-success-popups-list'),
			'aweber-success-redirect-new-tab' => alpSanitize('aweber-success-redirect-new-tab')
		);
		$options['aweberOptions'] = json_encode($aweberOptions);
	}


	$title = stripslashes(alpSanitize('title'));
	$id = alpSanitize('hidden_popup_number');
	$jsonDataArray = json_encode($options);

	$data = array(
		'id' => $id,
		'title' => $title,
		'type' => $type,
		'image' => $image,
		'html' => $html,
		'fblike' => $fblike,
		'iframe' => $iframe,
		'video' => $video,
		'shortcode' => $shortCode,
		'ageRestriction' => $ageRestriction,
		'countdown' => $countdown,
		'exitIntent' => $exitIntent,
		'alp_subscription' => $subscription,
		// 'sg_contactForm' => $sgContactForm,
		'social' => $social,
		'mailchimp' => $mailchimp,
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

add_action('wp_ajax_save_popup_preview_data', 'savePopupPreviewData');




