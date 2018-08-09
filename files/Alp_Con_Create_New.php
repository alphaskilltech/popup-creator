<?php
	$popupType = @sanitize_text_field($_GET['type']);
	if (!$popupType) {
		$popupType = 'html';
	}
	
	if (isset($_GET['id'])) {
		$id = (int)$_GET['id'];
		$popupName = "Alp_Con_".ucfirst(strtolower($popupType));
		$popupClassName = $popupName."_Popup";
		require_once(ALP_CON_POPUP_PATH ."/class/".$popupClassName.".php");
		 $result = call_user_func(array($popupClassName, 'findById'), $id);
		 $obj = new $popupClassName();

	 	if (!$result) {
	 		wp_redirect(ALP_CON_POPUP_ADMIN_URL."page=popup-edit&type=".$popupType."");
	 	}

		switch ($popupType) {	

			case 'image':
				$alpPopupDataImage = $result->getUrl();
				break;
			case 'html':
				$alpPopupDataHtml = $result->getContent();
				break;
			case 'contact':
				$alpPopupDataFblike = $result->getContent();
				$alpContactForms = $result->getContactForm();
				break;	
			case 'shortcode':
				$alpPopupDataShortcode = $result->getShortcode();
				break;				
		}
		$title = $result->getTitle();
		$jsonData = json_decode($result->getOptions(), true);
		$alpEscKey = @$jsonData['escKey'];
		$alpScrolling = @$jsonData['scrolling'];
		$alpDisablePageScrolling = @$jsonData['disable-page-scrolling'];
		$alpScaling = @$jsonData['scaling'];
		$alpCloseButton = @$jsonData['closeButton'];
		$alpReposition = @$jsonData['reposition'];
		$alpOverlayClose = @$jsonData['overlayClose'];
		$alpReopenAfterSubmission = @$jsonData['reopenAfterSubmission'];
		$alpRepetitivePopup = @$jsonData['repetitivePopup'];		
		$alpRepetitivePopupPeriod = @$jsonData['repetitivePopupPeriod'];		
		$alpIntervelPopup = @$jsonData['intervel'];		
		$alpIntervelPopupTime = @$jsonData['interveltime'];
		$alpContentClickBehavior = @$jsonData['content-click-behavior'];

		$alpClickRedirectToUrl = @$jsonData['click-redirect-to-url'];
		$alpCloseButtonDelay = @$jsonData['buttonDelayValue'];
		$alpRedirectToNewTab = @$jsonData['redirect-to-new-tab'];
		$alpPushToBottom = @alpSafeStr($jsonData['pushToBottom']);
		$alpOverlayColor = @$jsonData['alpOverlayColor'];
		$alpContentBackgroundColor = @$jsonData['alp-content-background-color'];
		$alpContentClick = @$jsonData['contentClick'];
		$alpOpacity = @$jsonData['opacity'];		
		$alpPopupFixed = @$jsonData['popupFixed'];
		$alpFixedPostion = @$jsonData['fixedPostion'];
		$alpOnScrolling = @$jsonData['onScrolling'];
		$beforeScrolingPrsent = @$jsonData['beforeScrolingPrsent'];
		$duration = @$jsonData['duration'];
		$delay = @$jsonData['delay'];
		$alpWidth = @$jsonData['width'];
		$alpHeight = @$jsonData['height'];
		$alpPopupDimensionMode = @$jsonData['popup_dimension_mode'];
		$alpPopupResponsiveDimensionMeasure = @$jsonData['popup_responsive_dimension_measure'];
		$alpMaxWidth = @$jsonData['maxWidth'];
		$alpMaxHeight = @$jsonData['maxHeight'];
		$alpForMobile = @$jsonData['forMobile'];
		$alpRepeatPopup = @$jsonData['repeatPopup'];
		$alpDisablePopup = @$jsonData['disablePopup'];
		$alpColorboxTheme = @$jsonData['theme'];
		$alpRestrictionAction = @$jsonData['restrictionAction'];
		
		// provirsion
		$alpDateRange = @$jsonData['DateRange'];
		$alpDateRangeFromDate =@$jsonData['DaterangeFromDate'];
		$alpDateRangeToDate =@$jsonData['DaterangeToDate'];
		$alpSchedulePopUp = @$jsonData['SchedulePopUp'];
		$alpSchedulePopUpDate =@$jsonData['SchedulePopUpDate'];
		$alpMobileOnly = @$jsonData['MobileOnly'];
		$alpMobileDisable = @$jsonData['MobileDisable'];
		$alpInactivity = @$jsonData['Inactivity'];
		$alpInactivitytime = @$jsonData['Inactivitytime'];

		$alpWhileScrolling = @$jsonData['WhileScrolling'];

		$alpSelectePages = @$jsonData['SelectePages'];
		$alpOptionsPages = @$jsonData['OptionsPages'];
		$alpShowAllPageID = @$jsonData['ShowAllPageID'];
		$alpShowCustomPageID = @$jsonData['ShowCustomPageID'];

		$alpSelectePosts = @$jsonData['SelectePosts'];
		$alpOptionsPosts = @$jsonData['OptionsPosts'];
		$alpShowAllPostID = @$jsonData['ShowAllPostID'];
		$alpShowCustomPostID = @$jsonData['ShowCustomPostID'];

		$alpUserStatus = @$jsonData['UserStatus'];
		$alpLogedUser = @$jsonData['loggedin-user'];

		$alpRandomPopUp = @$jsonData['RandomPopUp'];
		$alpautoClosePopup = @$jsonData['AutoClosePopup'];
		$alpPopupClosingTimer = @$jsonData['PopupClosingTimer'];

		$alpDisablePopup = @$jsonData['DisablePopup'];
		$alpDisableOverlay = @$jsonData['DisableOverlay'];
		$alpHideMobile = @$jsonData['HideMobile'];

		// contact form
		$alpContactForm = json_decode(@$alpContactForms, true);
		$alpFirstName = alpBoolToChecked(@$alpContactForm['firstname']);	
		$alpMiddleName = alpBoolToChecked(@$alpContactForm['middlename']);
		$alpLastName = alpBoolToChecked(@$alpContactForm['lastname']);
		$alpAge = alpBoolToChecked(@$alpContactForm['age']);
		$alpMobile = alpBoolToChecked(@$alpContactForm['mobile']);
		$alpGender = alpBoolToChecked(@$alpContactForm['gender']);
		$alpEmail = alpBoolToChecked(@$alpContactForm['e_mail']);
		$alpSubject = alpBoolToChecked(@$alpContactForm['subject']);
		$alpMessage = alpBoolToChecked(@$alpContactForm['message']);
		$alpAddress = alpBoolToChecked(@$alpContactForm['address']);
		$alpCity = alpBoolToChecked(@$alpContactForm['city']);
		$alpPincode = alpBoolToChecked(@$alpContactForm['pincode']);
	}

	$dataPopupId = @$id;
	/* For layze loading get selected data */
	if(!isset($id)) {
		$dataPopupId = "-1";
	}

	$colorboxDeafultValues = array(
		'escKey'=> true,
		'closeButton' => false,
		'scrolling'=> true,
		'disable-page-scrolling'=> true,
		'reopenAfterSubmission' => false,
		'repetitivePopup' => false,
		'repetitivePopupPeriod' => false,
		'intervel' => false,
		'interveltime' =>false,
		'content-click-behavior' => 'close',
		'pushToBottom' => true,
		'redirect-to-new-tab' => true,
		'buttonDelayValue' => false,
		'reposition' => true,
		'overlayClose' => true,	
		'contentClick'=>false,
		'scaling'=> false,
		'onScrolling' => false,	
		'repetPopup' => false,
		'opacity'=>0.7,					
		'width' => '600px',
		'height' => '440px',
		'popup_dimension_mode' => 'customMode',
		'popup_responsive_dimension_measure' => 60,		
		'maxWidth' => false,						
		'maxHeight' => false,									
		'fixed' => false,
		'top' => false,
		'right' => false,
		'bottom' => false,
		'left' => false,
		'duration' => 1,						
	);

	$popupProDefaultValues = array(				
		'DateRange' => false,
		'DaterangeFromDate' => false,
		'DaterangeToDate' => false,
		'SchedulePopUp' => false,
		'SchedulePopUpDate' => false,
		'MobileOnly' => false,
		'MobileDisable' => false,
		'Inactivity' => false,
		'Inactivitytime' => false,
		'WhileScrolling' => false,
		'SelectePages' => false,
		'OptionsPages' => 'all',
		'ShowAllPageID' => "all",
		'ShowCustomPageID'=>"Page_0",
		'SelectePosts' => false,
		'OptionsPosts' => 'all',
		'ShowAllPostID' => "all",
		'ShowCustomPostID'=>"Post_0",
		'UserStatus' => false,
		'loggedin-user' => 'true',
		'RandomPopUp' => false,
		'AutoClosePopup' => false,
		// 'PopupClosingTimer' => false,
		'DisablePopup' => false,
		'DisableOverlay' => false,
		'HideMobile' => false,
		);

	$alpContactForm = array(
		'firstname' => 1,
		'middlename' => false,
		'lastname' => false,
		'age' => false,
		'mobile' => true,
		'gender' => false,
		'e_mail' => true,
		'subject' => false,
		'message' => false,
		'address' => false,
		'city' => false,
		'pincode' => false,
	);

	$escKey = alpBoolToChecked($colorboxDeafultValues['escKey']);
	$closeButton = alpBoolToChecked($colorboxDeafultValues['closeButton']);
	$scrolling = alpBoolToChecked($colorboxDeafultValues['scrolling']);
	$disablePageScrolling = alpBoolToChecked($colorboxDeafultValues['disable-page-scrolling']);
	$reopenAfterSubmission = alpBoolToChecked($colorboxDeafultValues['reopenAfterSubmission']);
	$repetitivePopup = alpBoolToChecked($colorboxDeafultValues['repetitivePopup']);
	$repetitivePopupPeriod = alpBoolToChecked($colorboxDeafultValues['repetitivePopupPeriod']);
	$intervel = alpBoolToChecked($colorboxDeafultValues['intervel']);
	$intervelTime = alpBoolToChecked($colorboxDeafultValues['interveltime']);	
	$pushToBottom = alpBoolToChecked($colorboxDeafultValues['pushToBottom']);
	$redirectToNewTab = alpBoolToChecked($colorboxDeafultValues['redirect-to-new-tab']);
	$buttonDelayValue = alpBoolToChecked($colorboxDeafultValues['buttonDelayValue']);
	$reposition	= alpBoolToChecked($colorboxDeafultValues['reposition']);
	$overlayClose = alpBoolToChecked($colorboxDeafultValues['overlayClose']);
	$contentClick = alpBoolToChecked($colorboxDeafultValues['contentClick']);
	$scaling = alpBoolToChecked($colorboxDeafultValues['scaling']);
	$onScrolling = alpBoolToChecked($colorboxDeafultValues['onScrolling']);
	$repetPopup = alpBoolToChecked($colorboxDeafultValues['repetPopup']);
	

	// provirsion
	$DateRange = alpBoolToChecked($popupProDefaultValues['DateRange']);	
	$DateRangeFromDate = alpBoolToChecked($popupProDefaultValues['DaterangeFromDate']);	
	$DateRangeToDate = alpBoolToChecked($popupProDefaultValues['DaterangeToDate']);	
	$SchedulePopUp = alpBoolToChecked($popupProDefaultValues['SchedulePopUp']);
	$SchedulePopUpDate = alpBoolToChecked($popupProDefaultValues['SchedulePopUpDate']);
	$MobileOnly = alpBoolToChecked($popupProDefaultValues['MobileOnly']);
	$MobileDisable = alpBoolToChecked($popupProDefaultValues['MobileDisable']);

	$Inactivity = alpBoolToChecked($popupProDefaultValues['Inactivity']);
	$Inactivitytime = alpBoolToChecked($popupProDefaultValues['Inactivitytime']);

	$WhileScrolling = alpBoolToChecked($popupProDefaultValues['WhileScrolling']);
	$SelectePages = alpBoolToChecked($popupProDefaultValues['SelectePages']);
	$OptionsPages = $popupProDefaultValues['OptionsPages'];
	$ShowAllPageID = alpBoolToChecked($popupProDefaultValues['ShowAllPageID']);
	$ShowCustomPageID = $popupProDefaultValues['ShowCustomPageID'];
	$SelectePosts = alpBoolToChecked($popupProDefaultValues['SelectePosts']);
	$OptionsPosts = $popupProDefaultValues['OptionsPosts'];
	$ShowAllPostID = alpBoolToChecked($popupProDefaultValues['ShowAllPostID']);
	$ShowCustomPostID = $popupProDefaultValues['ShowCustomPostID'];
	$UserStatus = alpBoolToChecked($popupProDefaultValues['UserStatus']);
	$logedUser = $popupProDefaultValues['loggedin-user'];

	$RandomPopUp = alpBoolToChecked($popupProDefaultValues['RandomPopUp']);
	$AutoClosePopup = alpBoolToChecked($popupProDefaultValues['AutoClosePopup']);
	// $PopupClosingTimer = alpBoolToChecked($popupProDefaultValues['PopupClosingTimer']);

	$DisablePopup = alpBoolToChecked($popupProDefaultValues['DisablePopup']);
	$DisableOverlay = alpBoolToChecked($popupProDefaultValues['DisableOverlay']);
	$HideMobile = alpBoolToChecked($popupProDefaultValues['HideMobile']);


	
	function alpBoolToChecked($var)
	{
		return ($var?'checked':'');
	}

	function alpRemoveOption($option) {
	global $removeOptions;
	return isset($removeOptions[$option]);
    }

	$width = $colorboxDeafultValues['width'];
	$height = $colorboxDeafultValues['height'];
	$popupDimensionMode = $colorboxDeafultValues['popup_dimension_mode'];
	$popupResponsiveDimensionMeasure = $colorboxDeafultValues['popup_responsive_dimension_measure'];
	$opacityValue = $colorboxDeafultValues['opacity'];
	$top = $colorboxDeafultValues['top'];
	$right = $colorboxDeafultValues['right'];
	$bottom = $colorboxDeafultValues['bottom'];
	$left = $colorboxDeafultValues['left'];
	$maxWidth = $colorboxDeafultValues['maxWidth'];
	$maxHeight = $colorboxDeafultValues['maxHeight'];
	$deafultFixed = $colorboxDeafultValues['fixed'];
	$defaultDuration = $colorboxDeafultValues['duration'];
	//$defaultDelay = $colorboxDeafultValues['delay'];
	$contentClickBehavior = $colorboxDeafultValues['content-click-behavior'];

	$defaultButtonDelayValue = $colorboxDeafultValues['buttonDelayValue'];

	$alpEscKey = @alpSetChecked($alpEscKey, $escKey);
	$alpCloseButton = @alpSetChecked($alpCloseButton, $closeButton);
	$alpScrolling = @alpSetChecked($alpScrolling, $scrolling);
	$alpDisablePageScrolling = @alpSetChecked($alpDisablePageScrolling, $disablePageScrolling);
	$alpReopenAfterSubmission = @alpSetChecked($alpReopenAfterSubmission, $reopenAfterSubmission);
	$alpIntervelPopup = @alpSetChecked($alpIntervelPopup, $intervel);
	$alpPushToBottom = @alpSetChecked($alpPushToBottom, $pushToBottom);
	$alpReposition = @alpSetChecked($alpReposition, $reposition);
	$alpOverlayClose = @alpSetChecked($alpOverlayClose, $overlayClose);
	$alpContentClick = @alpSetChecked($alpContentClick, $contentClick);
	$alpScaling = @alpSetChecked($alpScaling, $scaling);
	$alpOnScrolling = @alpSetChecked($alpOnScrolling, $onScrolling);
	$alpRepetitivePopup = @alpSetChecked($alpRepetitivePopup, $repetitivePopup);
	$alpRepeatPopup = @alpSetChecked($alpRepeatPopup, $repetPopup);
	$alpRedirectToNewTab = @alpSetChecked($alpRedirectToNewTab, $redirectToNewTab);


	// provirsion
	$alpDateRange = @alpSetChecked($alpDateRange, $DateRange);
	$alpSchedulePopUp  = @alpSetChecked($alpSchedulePopUp , $SchedulePopUp);
	$alpMobileOnly = @alpSetChecked($alpMobileOnly, $MobileOnly);
	$alpMobileDisable = @alpSetChecked($alpMobileDisable, $MobileDisable);

	$alpInactivity = @alpSetChecked($alpInactivity, $Inactivity);
	$alpWhileScrolling = @alpSetChecked($alpWhileScrolling, $WhileScrolling);
	$alpSelectePages = @alpSetChecked($alpSelectePages, $SelectePages);
	$alpShowAllPageID = @alpSetChecked($alpShowAllPageID, $ShowAllPageID);
	$alpSelectePosts = @alpSetChecked($alpSelectePosts, $SelectePosts);
	$alpShowAllPostID = @alpSetChecked($alpShowAllPostID, $ShowAllPostID);

	$alpUserStatus = @alpSetChecked($alpUserStatus, $UserStatus);
	$alpRandomPopUp = @alpSetChecked($alpRandomPopUp, $RandomPopUp);
	$alpautoClosePopup = @alpSetChecked($alpautoClosePopup, $AutoClosePopup);
	// $PopupClosingTimer = $popupProDefaultValues['PopupClosingTimer'];


	$alpDisablePopup = @alpSetChecked($alpDisablePopup, $DisablePopup);
	$alpDisableOverlay = @alpSetChecked($alpDisableOverlay, $DisableOverlay);
	$alpHideMobile = @alpSetChecked($alpHideMobile, $HideMobile);


	function alpSetChecked($optionsParam,$defaultOption)
	{
		if (isset($optionsParam)) {
			if ($optionsParam == '') {
				return '';
			}
			else {
				return 'checked';
			}
		}
		else {
			return $defaultOption;
		}
	}


	// pro features get value
	$alpFromDate = @alpGetValue($alpDateRangeFromDate, $DateRangeFromDate);
	$alpToDate = @alpGetValue($alpDateRangeToDate, $DateRangeToDate);
	$alpScheduleDate = @alpGetValue($alpSchedulePopUpDate, $SchedulePopUpDate);
	$alpInactivitytime = @alpGetValue($alpInactivitytime, $Inactivitytime);
	// $alpPopupClosingTimer = @alpGetValue($alpPopupClosingTimer, $PopupClosingTimer);



	$alpRepetitivePopupPeriod = @alpGetValue($alpRepetitivePopupPeriod, $repetitivePopupPeriod);
	$alpIntervelPopupTime = @alpGetValue($alpIntervelPopupTime, $intervelTime);
	$alpCloseButtonDelay = @alpGetValue($alpCloseButtonDelay, $buttonDelayValue);
	$alpOpacity = @alpGetValue($alpOpacity, $opacityValue);
	$alpWidth = @alpGetValue($alpWidth, $width);
	$alpHeight = @alpGetValue($alpHeight, $height);
	$alpPopupDimensionMode = @alpGetValue($alpPopupDimensionMode, $popupDimensionMode);
	$alpPopupResponsiveDimensionMeasure = @alpGetValue($alpPopupResponsiveDimensionMeasure, $popupResponsiveDimensionMeasure);

	$alpMaxWidth = @alpGetValue($alpMaxWidth, $maxWidth);
	$alpMaxHeight = @alpGetValue($alpMaxHeight, $maxHeight);
	$duration = @alpGetValue($duration, $defaultDuration);
	$delay = @alpGetValue($delay, $defaultDelay);
	$alpContentClickBehavior = @alpGetValue($alpContentClickBehavior, $contentClickBehavior);
	$alpPopupDataHtml = @alpGetValue($alpPopupDataHtml, '');
	$alpPopupDataImage = @alpGetValue($alpPopupDataImage, '');
	$alpLogedUser = @alpGetValue($alpLogedUser, $logedUser);
	$alpOptionsPages = @alpGetValue($alpOptionsPages,$OptionsPages);
	$alpOptionsPosts = @alpGetValue($alpOptionsPosts,$OptionsPosts);

	if(!empty($alpShowCustomPageID)){
	$alpShowPageId = implode(",",@alpGetValue($alpShowCustomPageID,$ShowCustomPageID));
	}else{
	$alpShowPageId = '';
	}
	if(!empty($alpShowCustomPostID)){
		$alpShowPostID = implode(",",@alpGetValue($alpShowCustomPostID,$ShowCustomPostID));
		}else{
		$alpShowPostId = '';
		}


		function alpGetValue($getedVal,$defValue)
		{
			if (!isset($getedVal)) {
				return $defValue;
			}
			else {
				return $getedVal;
			}
		}
		
	$radioElements = array(
		array(
			'name'=>'shareUrlType',
			'value'=>'activeUrl',
			'additionalHtml'=>''.'<span>'.'Use active URL'.'</span></span>
								<span class="span-width-static"></span><span class="dashicons dashicons-info scrollingImg sameImageStyle sg-active-url"></span><span class="info-active-url samefontStyle">If this option is active Share URL will be current page URL.</span>'
		),
		array(
			'name'=>'shareUrlType',
			'value'=>'shareUrl',
			'additionalHtml'=>''.'<span>'.'Share url'.'</span></span>'.' <input class="input-width-static sg-active-url" type="text" name="sgShareUrl" value="'.@$sgShareUrl.'">'
		)
	);
	$usersGroup = array(
		array(
			'name'=>'loggedin-user',
			'value'=>'true',
			'additionalHtml'=>'<span class="countries-radio-text allow-countries leftalignment">Logged In</span>',
			//'newline' => false
		),
		array(
			'name'=>'loggedin-user',
			'value'=>'false',
			'additionalHtml'=>'<span class="countries-radio-text">Not Logged In</span>',
			//'newline' => true
			)
		);

	function alpCreateRadioElements($radioElements,$checkedValue)
	{
		$content = '';
		for ($i = 0; $i < count($radioElements); $i++) {
			$checked = '';
			$radioElement = @$radioElements[$i];
			$name = @$radioElement['name'];
			$label = @$radioElement['label'];
			$value = @$radioElement['value'];
			$additionalHtml = @$radioElement['additionalHtml'];
			if ($checkedValue == $value) {
				$checked = 'checked';
			}
			$content .= '<span  class="liquid-width"><input class="radio-btn-fix" type="radio" name="'.esc_attr($name).'" value="'.esc_attr($value).'" '.esc_attr($checked).'>';
			$content .= $additionalHtml."<br>";
		}
		return $content;
	}

	$contentClickOptions = array(
		array(
			"title" => "Close Popup :",
			"value" => "close",
			"info" => "",
		
		),
		array(
			"title" => "Redirect :",
			"value" => "redirect",
			"info" => ""
		)
	);

	$ajaxNonce = wp_create_nonce("alpPopupCreatorPageNonce");
	$ajaxNoncePages = wp_create_nonce("alpPopupCreatorPagesNonce");
	$pagesRadio = array(		
		array(
			"title" => "Show On All Pages :",
			"value" => "all",
			"id" => "select_all_page",
			"class" => "input_group",
			"checked" => "checked",
			"info" => ""
		),
		array(
			"title" => "Show On Selected Pages:",
			"value" => "selected",
			"id" => "select_custom_page",
			"class" => "input_group",
			"info" => ""
		)	
	);
	$postsRadio = array(				
		array(
			"title" => "Show On All Posts:",
			"value" => "all",
			"id" => "select_all_post",
			"class" => "input_group",
			// "checked" => "checked",
			"info" => ""
		),
		array(
			"title" => "Show On Selected Post:",
			"value" => "selected",
			"id" => "select_custom_post",
			"class" => "input_group",
			"info" => "",
		)
	);
	$customPostsRadio = array(
		array(
			"title" => "show on all custom posts:",
			"value" => "all",
			"info" => ""
		),
		array(
			"title" => "show on selected custom post:",
			"value" => "selected",
			"info" => "",
			"data-attributes" => array(
				"data-name" => 'allCustomPosts',
				"data-popupid" => $dataPopupId,
				"data-loading-number" => 0,
				"data-selectbox-role" => "js-all-custom-posts"
			)
		)
	);
	$responsiveMode = array(
		array(
			"title" => "Responsive Mode :",
			"value" => "responsiveMode",
			"info" => "",
			"data-attributes" => array(
				"class" => "js-responsive-mode"
			)
		),
		array(
			"title" => "Custom Mode :",
			"value" => "customMode",
			"info" => "",
			"data-attributes" => array(
				"class" => "js-custom-mode"
			)
	
		)
	);
	function createRadiobuttons($elements, $name, $newLine, $selectedInput, $class)
{
	$str = "";

	foreach ($elements as $key => $element) {
		$breakLine = "";
		$infoIcon = "";
		$title = "";
		$value = "";
		$infoIcon = "";
		$checked = "";
		$id ="";
		$radioclass ="";

		if(isset($element["title"])) {
			$title = $element["title"];
		}
		if(isset($element["value"])) {
			$value = $element["value"];
		}
		if(isset($element["id"])) {
			$id = $element["id"];
		}
		if(isset($element["class"])) {
			$radioclass = $element["class"];
		}
		if($newLine) {
			$breakLine = "<br>";
		}
		if(isset($element["info"])) {
			$infoIcon = $element['info'];
		}
		if($element["value"] == $selectedInput) {
			$checked = "checked";
		}
		$attrStr = '';
		if(isset($element['data-attributes'])) {
			foreach ($element['data-attributes'] as $key => $dataValue) {
				$attrStr .= $key.'="'.$dataValue.'" ';
			}
		}

		$str .= "<span class=".$class.">".$element['title']."</span>
				<input type=\"radio\" name=".$name." ".$attrStr."  id=".$id." class=".$radioclass." value=".$value." $checked>".$infoIcon.$breakLine;
	}

	echo $str;
}

	$alpPopupTheme = array(
		'theme1.css',
		'theme2.css',
		'theme3.css',
		'theme4.css',
		'theme5.css'
	);
	$alpResponsiveMeasure = array(
		'10' => '10%',
		'20' => '20%',
		'30' => '30%',
		'40' => '40%',
		'50' => '50%',
		'60' => '60%',
		'70' => '70%',
		'80' => '80%',
		'90' => '90%',
		'100' => '100%'
	);
	
	function alpCreateSelect($options,$name,$selecteOption)
	{
		$selected ='';
		$str = "";
		$checked = "";
		if ($name == 'theme' || $name == 'restrictionAction') {

				$popup_style_name = 'popup_theme_name';
				$firstOption = array_shift($options);
				$i = 1;
				foreach ($options as $key) {
					$checked ='';

					if ($key == $selecteOption) {
						$checked = "checked";
					}
					$i++;
					$str .= "<input type='radio' name=\"$name\" value=\"$key\" $checked class='popup_theme_name' alpPoupNumber=".$i.">";

				}
				if ($checked == ''){
					$checked = "checked";
				}
				$str = "<input type='radio' name=\"$name\" value=\"".$firstOption."\" $checked class='popup_theme_name' alpPoupNumber='1'>".$str;
				return $str;
		}
		else {
			@$popup_style_name = ($popup_style_name) ? $popup_style_name : '';
			$str .= "<select name=$name class=$popup_style_name input-width-static >";
			foreach ($options as $key=>$option) {
				if ($key == $selecteOption) {
					$selected = "selected";
				}
				else {
					$selected ='';
				}
				$str .= "<option value='".$key."' ".$selected."  >$option</potion>";
			}

			$str .="</select>" ;
			return $str;
		}
	}

	if (isset($_GET['saved']) && $_GET['saved']==1) {
		echo '<div id="default-message" class="updated notice notice-success is-dismissible" ><p>Popup updated successfull.</p></div>';
	}
	if (isset($_GET["titleError"])): ?>
		<div class="error notice" id="title-error-message">
			<p>Invalid Title</p>
		</div>
	<?php endif; ?>

<form method="POST" action="<?php echo ALP_CON_POPUP_ADMIN_URL;?>admin-post.php" id="formdata">
<?php
	        if(function_exists('wp_nonce_field')) {
	        	wp_nonce_field('alpPopupCreatorSave');
	        }
	    ?>
<input type="hidden" name="action" value="popup_save">
	<div class="crud-wrapper">
		<div class="cereate-title-wrapper">
			<div class="alp-title-crud">
				<?php if (isset($id)): ?>
					<h2>Edit popup</h2>
				<?php else: ?>
					<h2>Create new popup</h2>
				<?php endif; ?>
				<?php $pageUrl = AlpConPopupGetData::getPopupPageUrl(); ?>
			</div>
			<div class="button-wrapper">
				<p class="submit">				
					<input type="submit" id="alp-save-button" class="btn button-primary" value="<?php echo 'Save Changes'; ?>"><span></span>
						<?php if( !empty($pageUrl)): ?> 
							<input type="button" id="alp-preview"  class="btn button-primary alp-popup-preview button-primary alp-popup-general-option" data-page-url="<?php echo $pageUrl; ?>" value="Preview">
						<?php endif; ?>
					<?php if (!ALP_CON_POPUP_PRO): ?>
						<input class="crud-to-pro" type="button" value="Upgrade to PRO version" onclick="window.open('<?php echo ALP_CON_POPUP_PRO_URL;?>')"><div class="clear"></div>
					<?php endif; ?>
				</p>
			</div>
		</div>
		<div class="clear"></div>
		<div class="general-wrapper">
		<div id="titlediv">
			<div id="titlewrap">
				<input  id="title" class="alp-js-popup-title" type="text" name="title" size="30" value="<?php echo esc_attr(@$title)?>" spellcheck="true" autocomplete="off" required = "required"  placeholder='Enter title here'>
			</div>
		</div>


			<div id="left-main-div">
				<div id="alp-general">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="postbox-container-2" class="postbox-container">
							<div id="normal-sortables" class="meta-box-sortables ui-sortable">
								<div class="postbox popupCreator_general_postbox alpSameWidthPostBox" style="display: block;">
									<div class="handlediv generalTitle" title="Click to toggle"><br></div>
									<h3 class="hndle ui-sortable-handle generalTitle" style="cursor: pointer"><span><b>General</b></span></h3>
									<div class="generalContent alpSameWidthPostBox">
										<?php require_once("main_section/".$popupType.".php");?>
										<input type="hidden" name="type" value="<?php echo $popupType;?>">
										<span class="liquid-width" id="theme-span">Popup Style Options:</span>
										<?php echo alpCreateSelect($alpPopupTheme,'theme',esc_html(@$alpColorboxTheme));?>
										<div class="theme1 alp-hide"></div> 
										<div class="theme2 alp-hide"></div>
										<div class="theme3 alp-hide"></div>
										<div class="theme4 alp-hide"></div>
										<div class="theme5 alp-hide"></div> 
									</div>
								</div>

							</div>
						</div>
					</div>
				  </div>
				 <?php if (ALP_CON_POPUP_PRO) : require_once("main_section/pro.php"); ?>
					<?php else: ?>
						<div class="pro-options" onclick="window.open('http://alphaskilltech.com/')"></div>
					<?php endif; ?>	  
			</div>			
			<div id="right-main-div">
			 <div id="right-main">
					<div id="dimentions">
						<div id="post-body" class="metabox-holder columns-2">
							<div id="postbox-container-2" class="postbox-container">
								<div id="normal-sortables" class="meta-box-sortables ui-sortable">
									<div class="postbox popupCreator_dimention_postbox alpSameWidthPostBox" style="display: block;">
										<div class="handlediv dimentionsTitle" title="Click to toggle"><br></div>
										<h3 class="hndle ui-sortable-handle dimentionsTitle" style="cursor: pointer"><span><b>Dimensions</b></span></h3>
										 <div class="dimensionsContent">
										   <?php createRadiobuttons($responsiveMode, "popup_dimension_mode", true, esc_html($alpPopupDimensionMode), "liquid-width");?>
	                                        <div class="js-accordion-responsiveMode js-radio-accordion alp-accordion-content">
		                                     <span class="liquid-width">Responsive Size :</span>
		                                      <?php echo  alpCreateSelect($alpResponsiveMeasure,"popup_responsive_dimension_measure",esc_html(@$alpPopupResponsiveDimensionMeasure));?>
	                                         </div>
										   <div class="js-accordion-customMode js-radio-accordion alp-accordion-content">
											<span class="liquid-width">Width :</span>
											<input class="" type="text" name="width" value="<?php echo esc_attr($alpWidth); ?>"  title="It must be number  + px or %" /><br>
											<span class="liquid-width">Height :</span>
											<input class="" type="text" name="height" value="<?php echo esc_attr($alpHeight);?>"  title="It must be number  + px or %" /><br>
											</div>
											<span class="liquid-width">Max Width :</span>
											<input class="" type="text" name="maxWidth" value="<?php echo esc_attr($alpMaxWidth);?>"  title="It must be number  + px or %" /><br>
											<span class="liquid-width">Max Height :</span>
											<input class="" type="text" name="maxHeight" value="<?php echo esc_attr(@$alpMaxHeight);?>"   title="It must be number  + px or %" /><br>											
										 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="options">
						<div id="post-body" class="metabox-holder columns-2">
							<div id="postbox-container-2" class="postbox-container">
								<div id="normal-sortables" class="meta-box-sortables ui-sortable">
									<div class="postbox popupCreator_options_postbox alpSameWidthPostBox" style="display: block;">
										<div class="handlediv optionsTitle" title="Click to toggle"><br></div>
										<h3 class="hndle ui-sortable-handle optionsTitle" style="cursor: pointer"><span><b>Options</b></span></h3>
										<div class="optionsContent">										
										    <span class="liquid-width">Show &quot;Close&quot; Button :</span><label class="switch"><input class="input-width-static" id="close_button_delay" type="checkbox" name="closeButton" <?php echo $alpCloseButton;?> /><span class="slider round"></span></label><br><br>
    									    <!-- <span class="liquid-width">Close button delay :</span><label class="switch"><input class="input-width-static" type="checkbox" name=""  <?php ?>/><span class="slider round"></span></label><br><br>-->
											   <div class="acordion-main-div-content" id="close_button_dealy_value">
													<span class="liquid-width">Close Button Delay Time :</span>
													<input class="popup-delay delay_button_value" type="number" min="0" name="buttonDelayValue" value="<?php echo esc_attr($alpCloseButtonDelay);?>" title="It must be number"/>
													<span class="span-percent">after X seconds</span><br><br>																										
												</div>

											<span class="liquid-width">Show PopUp Interval :</span><label class="switch"><input class="input-width-static " id="js-popup-delay" type="checkbox" name="intervel" <?php echo $alpIntervelPopup; ?> /><span class="slider round"></span></label><br><br>												
											 <div class="acordion-main-div-content" id="popup-delay-content">
												<span class="liquid-width">Popup Interval Time :</span>
												<input type="number" class="popup-delay-value popup-delay" name="interveltime" min="10" value="<?php echo esc_attr($alpIntervelPopupTime); ?>">
												 <span class="span-percent">after X seconds</span><br><br>																										 
											  </div>	
																							
											  <span class="liquid-width">Show Repetition :</span><label class="switch"><input class="input-width-static " id="js-popup-only-once" type="checkbox" name="repetitivePopup" <?php echo $alpRepetitivePopup;?> /><span class="slider round"></span></label><br><br>		                                       
		                                        <div class="acordion-main-div-content" id="js-popup-only-once-content">
			                                        <span class="liquid-width">Show Popup :</span>
			                                        <input type="number" class="before-scroling-percent" name="repetitivePopupPeriod" min="10" value="<?php echo esc_attr($alpRepetitivePopupPeriod); ?>">
			                                         <span class="span-percent">after X seconds</span><br><br>																										   
		                                        </div> 

											<span class="liquid-width">Enable Reposition :</span><label class="switch"><input class="input-width-static" type="checkbox" name="reposition" <?php echo $alpReposition;?> /><span class="slider round"></span></label><br><br>

											<span class="liquid-width">Enable Contant Scrolling :</span><label class="switch"><input class="input-width-static" type="checkbox" name="scrolling" <?php echo $alpScrolling;?> /><span class="slider round"></span></label><br><br>

											<span class="liquid-width">Disable Page Scrolling :</span><label class="switch"><input class="input-width-static" id="DisableScrolling" type="checkbox" name="disable-page-scrolling" <?php echo $alpDisablePageScrolling;?> /><span class="slider round"></span></label><br><br>											
																				
											<span class="liquid-width">Enable Window Scaling :</span><label class="switch"><input class="input-width-static" type="checkbox" name="scaling" <?php echo $alpScaling;?> /><span class="slider round"></span></label><br><br>

											<span class="liquid-width">PopUp Overlay Colour :</span><span><input  class="alpOverlayColor" id="alpOverlayColor" type="color" name="alpOverlayColor" value="<?php echo esc_attr(@$alpOverlayColor); ?>" placeholder="#fff"/></span><br><br>
											<!-- <span class="liquid-width" id="createDescribeOpacitcy">Background overlay opacity:</span> -->
											<!-- <input type="text" class="js-decimal" value="<?php// echo esc_attr($alpOpacity);?>" rel="<?php //echo esc_attr($alpOpacity);?>" name="opacity"/> -->
											<input type="hidden" class="js-decimal" value="0.7" rel="<?php //echo esc_attr($alpOpacity);?>" name="opacity"/>

											<span class="liquid-width" >PopUp Background Colour :</span><span id="alpBackgroundColorSet"><input  class="alpBackgroundColor" type="color" name="alp-content-background-color" value="<?php echo esc_attr(@$alpContentBackgroundColor); ?>" /></span><br><br>
											
											<span class="liquid-width">Close PopUp on Overlay Click :</span><label class="switch"><input class="input-width-static" type="checkbox" name="overlayClose" <?php echo $alpOverlayClose;?>><span class="slider round"></span></label><br><br>

											<span class="liquid-width">Close PopUp on Content Click :</span><label class="switch"><input class="input-width-static js-checkbox-contnet-click" type="checkbox" name="contentClick" <?php echo $alpContentClick;?> /><span class="slider round"></span></label><br>

											 <!-- <div class="alp-hide alp-full-width js-content-click-wrraper">
		                                            <?php //echo createRadiobuttons($contentClickOptions, "content-click-behavior", true, esc_html($alpContentClickBehavior), "liquid-width"); ?>
		                                            <div class="alp-hide js-readio-buttons-acordion-content alp-full-width">
			                                            <span class="liquid-width">Url:</span><input class="input-width-static" type="text" name='click-redirect-to-url' value="<?php //echo esc_attr(@$alpClickRedirectToUrl); ?>">
			                                            <span class="liquid-width">Redirect to new tab:</span><input type="checkbox" name="redirect-to-new-tab" <?php// echo $alpRedirectToNewTab; ?> >
		                                            </div>
	                                            </div> -->

												<div class="alp-hide alp-full-width js-content-click-wrraper liquid-width">
													<?php echo createRadiobuttons($contentClickOptions, "content-click-behavior", true, esc_html($alpContentClickBehavior), "liquid-width"); ?>
													<div class="alp-hide js-readio-buttons-acordion-content alp-full-width acordion-main-div-content">
													<span>URL :</span>
														<input class="urlvalue" type="text" name="click-redirect-to-url" value="<?php echo esc_attr(@$alpClickRedirectToUrl);?>" title="It must be number"/><br><br>
														<span >Redirect to New Tab : </span> &nbsp;&nbsp;&nbsp;<label class="switch"><input type="checkbox" name="redirect-to-new-tab" <?php echo $alpRedirectToNewTab; ?> ><span class="slider round"></span></label>
											     	</div>
												</div><br>												
											<span class="liquid-width">Dismiss on &quot;esc&quot; Key :</span><label class="switch"><input class="input-width-static" type="checkbox" name="escKey"  <?php echo $alpEscKey;?>/><span class="slider round"></span></label><br><br>

											<span class="liquid-width">Reopen After Form Submission :</span><label class="switch"><input class="input-width-static" type="checkbox" name="reopenAfterSubmission" <?php  echo $alpReopenAfterSubmission;?> /><span class="slider round"></span></label><br><br>											

											</div><br>
										</div>
									</div>
								</div>
							</div>
						</div>							
					</div>
				</div>				
				<div class="clear"></div>
				<?php
				$isActivePopup = AlpConPopupGetData::isActivePopup(@$id);
				if(!@$id) $isActivePopup = 'checked';
				?>
                <input class="hide-element" name="isActiveStatus" data-switch-id="'. $id . '" type="checkbox" <?php echo $isActivePopup; ?> >
				<input type="hidden" class="button-primary" value="<?php echo esc_attr(@$id);?>" name="hidden_popup_number" />
			</div>
		</div>
		<?php require_once("Alp_Con_Customjs.php"); ?>
	</form>