<?php
add_action('admin_post_popup_save', 'alpPopupSave');

function alpSanitize($optionsKey, $isTextField = false)
{
	if (isset($_POST[$optionsKey])) {
		if ($optionsKey == "alp_popup_html"||
			$optionsKey == "alp_contactForm" ||
			$optionsKey == "all-selected-page" ||
			$optionsKey == "all-selected-posts" ||
			$isTextField == true )
			{		
				//if(POPUP_BUILDER_PKG > POPUP_BUILDER_PKG_FREE) {
				// 	$alpPopupData = $_POST[$optionsKey];
				// 	require_once(ALP_CON_POPUP_FILES ."/Alp_Con_Pro.php");
				// 	return ALPCONPopupPro::alpPopupDataSanitize($alpPopupData);
				// }	
			return wp_kses_post($_POST[$optionsKey]);
		}
		return sanitize_text_field($_POST[$optionsKey]);
	}
	else {
		return "";
	}
}

function alpPopupSave()
{
	global $wpdb;

	if(isset($_POST)) {
		check_admin_referer('alpPopupCreatorSave');
	}
	$_POST = stripslashes_deep($_POST);
	$postData = $_POST;
	$socialButtons = array();
	$socialOptions = array();
	$contactForm = array();
	$options = array();
	$OptionsPages = alpSanitize('OptionsPages');
	$SelectePages = alpSanitize('SelectePages');
	$OptionsPosts = alpSanitize('OptionsPosts');
	$SelectePosts = alpSanitize('SelectePosts');

	$SelectedPages = null;
	$AllPages = null;
	$SelectedPost = null;
	$AllPost = null;
	// $allSelectedPosts = "";
	// $allSelectedCustomPosts = "";
	$allSelectedCategories = alpSanitize("posts-all-categories", true);

	if($OptionsPages == 'all' && $SelectePages == 'on' ) {
		$AllPages = explode(",", alpSanitize('ShowAllPageID'));
	}
	if($OptionsPages == 'selected' && $SelectePages == 'on' ) {
		$SelectedPages =  explode(",",alpSanitize('ShowCustomPageID'));
	}

	if($OptionsPosts == 'all' && $SelectePosts == 'on' ) {
		$AllPost = explode(",", alpSanitize('ShowAllPostID'));
	}
	if($OptionsPosts == 'selected' && $SelectePosts == 'on' ) {
		$SelectedPost =  explode(",",alpSanitize('ShowCustomPostID'));
	}

	$contactForm = array( 

		'firstname' => alpSanitize('firstname'),
		'middlename' => alpSanitize('middlename'),
		'lastname' => alpSanitize('lastname'),
		'age' => alpSanitize('age'),
		'mobile' => alpSanitize('mobile'),
		'gender' => alpSanitize('gender'),
		'e_mail' => alpSanitize('e_mail'),
		'subject' => alpSanitize('subject'),
		'message' => alpSanitize('message'),
		'address' => alpSanitize('address'),
		'city' => alpSanitize('city'),
		'pincode' => alpSanitize('pincode')
	);


	$options = array(
		'width' => alpSanitize('width'),
		'height' => alpSanitize('height'),
		'popup_dimension_mode' => alpSanitize('popup_dimension_mode'),
		'popup_responsive_dimension_measure' => alpSanitize('popup_responsive_dimension_measure'),
		'maxWidth' => alpSanitize('maxWidth'),
		'maxHeight' => alpSanitize('maxHeight'),
		'intervel' => alpSanitize('intervel'),
		'interveltime' => alpSanitize('interveltime'),
		'content-click-behavior' => alpSanitize('content-click-behavior'),
		'click-redirect-to-url' => alpSanitize('click-redirect-to-url'),
		'redirect-to-new-tab' => alpSanitize('redirect-to-new-tab'),
		'buttonDelayValue' =>alpSanitize('buttonDelayValue'),
		'isActiveStatus' => alpSanitize('isActiveStatus'),

		'duration' => (int)alpSanitize('duration'),
		'escKey' => alpSanitize('escKey'),
		'scrolling' => alpSanitize('scrolling'),
		'disable-page-scrolling' => alpSanitize('disable-page-scrolling'),
		'scaling' => alpSanitize('scaling'),
		'reposition' => alpSanitize('reposition'),
		'reopenAfterSubmission' => alpSanitize('reopenAfterSubmission'),
		'overlayClose' => alpSanitize('overlayClose'),
		'contentClick' => alpSanitize('contentClick'),
		'opacity' => alpSanitize('opacity'),
		'alpOverlayColor' => alpSanitize('alpOverlayColor'),
		'alp-content-background-color' => alpSanitize('alp-content-background-color'),
		'closeButton' => alpSanitize('closeButton'),
		'theme' => alpSanitize('theme'),
		'onScrolling' => alpSanitize('onScrolling'),
		'repeatPopup' => alpSanitize('repeatPopup'),
		'restrictionUrl' => alpSanitize('restrictionUrl'),
		'repetitivePopup' => alpSanitize('repetitivePopup'),
		'repetitivePopupPeriod' => alpSanitize('repetitivePopupPeriod'),

		// provirsion
		'DateRange' =>alpSanitize('DateRange'),
		'DaterangeFromDate' =>alpSanitize('DaterangeFromDate'),
		'DaterangeToDate' =>alpSanitize('DaterangeToDate'),
		'SchedulePopUp' =>alpSanitize('SchedulePopUp'),
		'SchedulePopUpDate' =>alpSanitize('SchedulePopUpDate'),
		'MobileOnly' =>alpSanitize('MobileOnly'),
		'MobileDisable' =>alpSanitize('MobileDisable'),
		'Inactivity' =>alpSanitize('Inactivity'),
		'Inactivitytime' =>alpSanitize('Inactivitytime'),

		'WhileScrolling' =>alpSanitize('WhileScrolling'),
		'SelectePages' =>alpSanitize('SelectePages'),
		'OptionsPages' =>alpSanitize('OptionsPages'),		
		'ShowAllPageID' => $AllPages,
		'ShowCustomPageID' => $SelectedPages,
		'SelectePosts' => alpSanitize('SelectePosts'),
		'OptionsPosts' => alpSanitize('OptionsPosts'),
		'ShowAllPostID' => $AllPost,
		'ShowCustomPostID' => $SelectedPost,
		'UserStatus' =>alpSanitize('UserStatus'),
		'loggedin-user' => alpSanitize('loggedin-user'),

		'RandomPopUp' =>alpSanitize('RandomPopUp'),
		'AutoClosePopup' =>alpSanitize('AutoClosePopup'),
		'PopupClosingTimer' =>alpSanitize('PopupClosingTimer'),

		'DisablePopup' =>alpSanitize('DisablePopup'),
		'DisableOverlay' =>alpSanitize('DisableOverlay'),
		
		'HideMobile' =>alpSanitize('HideMobile'),
		'contactForm' => json_encode($contactForm)
		
	);

	$html = stripslashes(alpSanitize("alp_popup_html"));
	$contact = stripslashes(alpSanitize("alp_contactForm"));
	$shortCode = stripslashes(alpSanitize('shortcode'));
	$type = alpSanitize('type');
	$title = alpSanitize('title');
	$id = alpSanitize('hidden_popup_number');
	$jsonDataArray = json_encode($options);


	$data = array(
		'id' => $id,
		'title' => $title,
		'type' => $type,	
		'html' => $html,		
		'shortcode' => $shortCode,
		'contact' => $contact,
		'options' => $jsonDataArray,
	);
	if (empty($title)) {
		wp_redirect(ALP_CON_POPUP_ADMIN_URL."admin.php?page=popup-edit&type=$type&titleError=1");
		exit();
	}
	$popupName = "Alp_Con_".sanitize_text_field(ucfirst(strtolower($_POST['type'])));
	$popupClassName = $popupName."_Popup";

	require_once(ALP_CON_POPUP_PATH ."/class/".$popupClassName.".php");

	if ($id == "") {
		global $wpdb;
		call_user_func(array($popupClassName, 'create'), $data);
		$lastId = $wpdb->get_var("SELECT LAST_INSERT_ID() FROM ".  $wpdb->prefix."alp_con_popup");
		$postData['saveMod'] = '';
		$postData['popupId'] = $lastId;

		if(ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
			ALPCONPopup::removePopupFromPages($lastId,'page');
			ALPCONPopup::removePopupFromPages($lastId,'categories');
			if($options['allPagesStatus']) {
				if(!empty($ShowAllPageID) && $ShowAllPageID != 'all') {
					setPopupForAllPages($lastId, $allSelectedPages, 'page');
				}
				else {

					updatePopupOptions($lastId, array('page'), true);
				}
			}
			
			if($options['allPostsStatus']) {
				if(!empty($showAllPosts) && $showAllPosts == "selected") {

					setPopupForAllPages($lastId, $allSelectedPosts, 'page');
				}
				else if($showAllPosts == "all") {
					updatePopupOptions($lastId, array('post'), true);
				}
				if($showAllPosts == "allCategories") {
					setPopupForAllPages($lastId, $allSelectedCategories, 'categories');
				}
			}

			if($options['allCustomPostsStatus']) {
				if(!empty($showAllCustomPosts) && $showAllCustomPosts == "selected") {
					setPopupForAllPages($lastId, $allSelectedCustomPosts, 'page');
				}
				else if($showAllCustomPosts == "all") {
					updatePopupOptions($lastId, $options['all-custom-posts'], true);
				}
			}
			
		}

		wp_redirect(ALP_CON_POPUP_ADMIN_URL."admin.php?page=popup-edit&id=".$lastId."&type=$type&saved=1");
		exit();
	}
	else {
		$popup = ALPCONPopup::findById($id);
		$popup->setTitle($title);
		$popup->setId($id);
		$popup->setType($type);
		$popup->setOptions($jsonDataArray);

		switch ($popupName) {
			case 'Alp_Con_Image':
				$popup->setUrl($image);
				break;			
			case 'Alp_Con_Html':
				$popup->setContent($html);
				break;
			case 'Alp_Con_Contact':
				$popup->setContent($contact);
				$popup->setContactForm(json_encode($contactForm));
				break;	
			case 'Alp_Con_Shortcode':
				$popup->setShortcode($shortCode);
				break;	
		}
		if(ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
			ALPCONPopup::removePopupFromPages($id, 'page');
			ALPCONPopup::removePopupFromPages($id, 'categories');
			if(!empty($options['allPagesStatus'])) {
				if($ShowAllPageID && $ShowAllPageID != 'all') {
					updatePopupOptions($id, array('page'), false);
					setPopupForAllPages($id, $allSelectedPages, 'page');
				}
				else {
					updatePopupOptions($id, array('page'), true);
				}
			}
			else  {
				updatePopupOptions($id, array('page'), false);
			}

			if(!empty($options['allPostsStatus'])) {
				if(!empty($showAllPosts) && $showAllPosts == "selected") {
					updatePopupOptions($id, array('post'), false);
					setPopupForAllPages($id, $allSelectedPosts, 'page');
				}
				else if($showAllPosts == "all"){
					updatePopupOptions($id, array('post'), true);
				}
				if($showAllPosts == "allCategories") {
					setPopupForAllPages($id, $allSelectedCategories, 'categories');
				}
			}
			else {
				updatePopupOptions($id, array('post'), false);
			}

			if(!empty($options['allCustomPostsStatus'])) {
				if(!empty($showAllCustomPosts) && $showAllCustomPosts == "selected") {
					updatePopupOptions($id, $options['all-custom-posts'], false);
					setPopupForAllPages($id, $allSelectedCustomPosts, 'page');
				}
				else if($showAllCustomPosts == "all") {
					updatePopupOptions($id, $options['all-custom-posts'], true);
				}
			}
			else {
				updatePopupOptions($id, $options['all-custom-posts'], false);
			}
		}

		$popup->save();
		wp_redirect(ALP_CON_POPUP_ADMIN_URL."admin.php?page=popup-edit&id=$id&type=$type&saved=1");
		exit();
	}
}