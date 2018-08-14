function ALPCONPopup() {
	this.positionLeft = '';
	this.positionTop = '';
	this.positionBottom = '';
	this.positionRight = '';
	this.initialPositionTop = '';
	this.initialPositionLeft = '';
	// this.isOnLoad = '';
	this.openOnce = '';
	this.popupData = new Array();
	this.popupEscKey = true;
	this.popupOverlayClose = true;
	this.popupContentClick = false;
	this.popupCloseButton = true;
	this.popupAutoClosePopup = true;
	this.alpconTrapFocus = true;
	this.popupInactivity = true;
	this.alpColorboxContentTypeReset();
}
ALPCONPopup.prototype.alpColorboxContentTypeReset = function () {

	this.alpColorboxHtml = false;
	this.alpColorboxInline = false;
		
};

ALPCONPopup.prototype.popupOpenById = function (popupId) {

	 alpOnScrolling = (ALP_POPUP_DATA [popupId]['onScrolling']) ? ALP_POPUP_DATA [popupId]['onScrolling'] : '';
	//  Inactivity = (ALP_POPUP_DATA [popupId]['Inactivity']) ? ALP_POPUP_DATA [popupId]['Inactivity'] : '';
	 AutoClosePopup = (ALP_POPUP_DATA [popupId]['AutoClosePopup']) ? ALP_POPUP_DATA [popupId]['AutoClosePopup'] : '';
	 alpconPoupFrontendObj = new ALPCONPopup();

	if (alpOnScrolling) {
		alpconPoupFrontendObj.onScrolling(popupId);
	}
	// else if (Inactivity) {
		
	// 	alpconPoupFrontendObj.showPopupAfterInactivity(popupId);
	// }
	else {
		alpconPoupFrontendObj.showPopup(popupId, true);
	}
};

ALPCONPopup.getCookie = function (cName) {

	var name = cName + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
};

ALPCONPopup.deleteCookie = function (name) {

	document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
};

ALPCONPopup.setCookie = function (cName, cValue, exDays, cPageLevel) {

	var expirationDate = new Date();
	var cookiePageLevel = '';
	var cookieExpirationData = 1;
	if (!exDays || isNaN(exDays)) {
		exDays = 365 * 50;
	}
	if (typeof cPageLevel == 'undefined') {
		cPageLevel = false;
	}
	expirationDate.setDate(expirationDate.getDate() + exDays);
	cookieExpirationData = expirationDate.toString();
	var expires = 'expires='+cookieExpirationData;

	if (exDays == -1) {
		expires = '';
	}

	if (cPageLevel) {
		cookiePageLevel = 'path=/;';
	}

	var value = cValue + ((exDays == null) ? ";" : "; " + expires + ";" + cookiePageLevel);
	document.cookie = cName + "=" + value;
};


ALPCONPopup.prototype.init = function() {
	var that = this;

	this.onCompleate();
	this.attacheConfirmEvent();


	jQuery('[id=alp_colorbox_theme2-css]').remove();
	jQuery('[id=alp_colorbox_theme3-css]').remove();
	jQuery('[id=alp_colorbox_theme4-css]').remove();
	jQuery('[id=alp_colorbox_theme5-css]').remove();

	jQuery(".alp-show-popup").bind('click',function() {
		var alpPopupID = jQuery(this).attr("data-alppopupid");
		that.showPopup(alpPopupID,false);
	});
}

ALPCONPopup.prototype.attacheConfirmEvent = function () {

	var that = this;

	jQuery("[class*='alp-confirm-popup-']").each(function () {
		jQuery(this).bind("click", function (e) {
			e.preventDefault();
			var currentLink = jQuery(this);
			var className = jQuery(this).attr("class");

			var alpPopupId = that.findPopupIdFromClassNames(className, "alp-confirm-popup-");

			jQuery('#alpcolorbox').bind("alpPopupClose", function () {
				var target = currentLink.attr("target");

				if (typeof target == 'undefined') {
					target = "self";
				}
				var href = currentLink.attr("href");

				if (target == "_blank") {
					window.open(href);
				}
				else {
					window.location.href = href;
				}
			});
			that.showPopup(alpPopupId, false);
		})
	});
};

ALPCONPopup.prototype.onCompleate = function() {

	jQuery("#alpcolorbox").bind("alpColorboxOnCompleate", function() {
		
		/* Scroll only inside popup */
		jQuery('#alpcboxLoadedContent').isolatedScroll();
	});
	this.isolatedScroll();
}

ALPCONPopup.prototype.isolatedScroll = function () {

	jQuery.fn.isolatedScroll = function () {
		this.bind('mousewheel DOMMouseScroll', function (e) {
			var delta = e.wheelDelta || (e.originalEvent && e.originalEvent.wheelDelta) || -e.detail,
				bottomOverflow = this.scrollTop + jQuery(this).outerHeight() - this.scrollHeight >= 0,
				topOverflow = this.scrollTop <= 0;

			if ((delta < 0 && bottomOverflow) || (delta > 0 && topOverflow)) {
				e.preventDefault();
			}
		});
		return this;
	};
};

ALPCONPopup.prototype.alpPopupScalingDimensions = function () {

	var popupWrapper = jQuery("#alpcboxWrapper").outerWidth();
	var screenWidth = jQuery(window).width();
	/*popupWrapper != 9999  for resizing case when colorbox is calculated popup dimensions*/
	if (popupWrapper > screenWidth && popupWrapper != 9999) {
		var scaleDegree = screenWidth / popupWrapper;
		jQuery("#alpcboxWrapper").css({
			"transform-origin": "0 0",
			'transform': "scale(" + scaleDegree + ", 1)"
		});
		popupWrapper = 0;
	}
	else {
		jQuery("#alpcboxWrapper").css({
			"transform-origin": "0 0",
			'transform': "scale(1, 1)"
		})
	}
};

// Popup scaling
ALPCONPopup.prototype.alpPopupScaling = function () {

	var that = this;
	jQuery("#alpcolorbox").bind("alpColorboxOnCompleate", function () {
		that.alpPopupScalingDimensions();
	});
	jQuery(window).resize(function () {
		setTimeout(function () {
			that.alpPopupScalingDimensions();
		}, 1000);
	});
};

ALPCONPopup.prototype.varToBool = function(optionName) {
	returnValue = (optionName) ? true : false;
	return returnValue;
}

ALPCONPopup.prototype.canOpenPopup = function(id, openOnce, isOnLoad) {
	// if (!isOnLoad) {
	// 	return true;
	// }

	var currentCookies = ALPCONPopup.getCookie('alpPopupCookieList');
	if (currentCookies) {
		currentCookies = JSON.parse(currentCookies);

		for (var cookieIndex in currentCookies) {
			var cookieName = currentCookies[cookieIndex];
			var cookieData = ALPCONPopup.getCookie(cookieName + id);

			if (cookieData) {
				return false;
			}
		}
	}

	var popupCookie = ALPCONPopup.getCookie('alpPopupDetails' + id);
	var popupType = this.popupType;

	/*for popup this often case */
	if (openOnce && popupCookie != '') {
		return this.canOpenOnce(id);
	}

	var dontShow = ALPCONPopup.getCookie('alpPopupDontShow' + id);

	if (dontShow) {
		return false;
	}

	return true;
}

ALPCONPopup.prototype.canOpenOnce = function(id) {

	var cookieData = ALPCONPopup.getCookie('alpPopupDetails'+id);
	if(!cookieData) {
		return true;
	}
	var cookieData = JSON.parse(cookieData);

	if(cookieData.popupId == id && cookieData.openCounter >= this.numberLimit) {
		return false;
	}
	else {
		return true
	}

};

ALPCONPopup.prototype.setFixedPosition = function(alpPositionLeft, alpPositionTop, alpPositionBottom, alpPositionRight, alpFixedPositionTop, alpFixedPositionLeft) {
	this.positionLeft = alpPositionLeft;
	this.positionTop = alpPositionTop;
	this.positionBottom = alpPositionBottom;
	this.positionRight = alpPositionRight;
	this.initialPositionTop = alpFixedPositionTop;
	this.initialPositionLeft = alpFixedPositionLeft;
}

ALPCONPopup.prototype.percentToPx = function(percentDimention, screenDimension) {
	var dimension = parseInt(percentDimention)*screenDimension/100;
	return dimension;
}

ALPCONPopup.prototype.getPositionPercent = function(needPercent, screenDimension, dimension) {
	var alpPosition = (((this.percentToPx(needPercent,screenDimension)-dimension/2)/screenDimension)*100)+"%";
	return alpPosition;
}

ALPCONPopup.prototype.getPreviewPopupId = function(popupId)
{
	var currentUrl = window.location.href;

	var classSplitArray = currentUrl.split('alp_popup_preview_id=');
	var classIdString = classSplitArray['1'];

	if (typeof classIdString == 'undefined') {
		return false;
	}
	/*Get first all number from string*/
	var urlId = classIdString.match(/^\d+/);

	return urlId;
};

ALPCONPopup.prototype.currentPopupId = false;

ALPCONPopup.prototype.restrictIfThereIsPreviewPopup = function(popupId)
{
	var previewPopupId = this.getPreviewPopupId();
	if (previewPopupId) {
		if (popupId != previewPopupId) {
			return false;
		}

		if (this.currentPopupId) {
			return false;
		}
	}

	return true;
};

ALPCONPopup.prototype.showPopup = function(id, isOnLoad) {

	var that = this;

	if (!id) {
		return;
	}

	if (typeof ALP_POPUP_DATA[id] == "undefined") {
		return;
	}
	if (!this.restrictIfThereIsPreviewPopup(id)) {
		return false;
	}

	this.popupData = ALP_POPUP_DATA[id];
	this.popupType = this.popupData['type'];
	// this.isOnLoad = isOnLoad;
	this.openOnce = this.varToBool(this.popupData['repeatPopup']);
	this.numberLimit = this.popupData['popup-appear-number-limit'];


	if (this.openOnce === false) {
		jQuery.removeCookie("alpPopupNumbers");
	}
	if (!this.canOpenPopup(this.popupData['id'], this.openOnce, isOnLoad)) {
		return;
	}

	popupColorboxUrl = ALP_CON_POPUP_URL+'/style/alpcolorbox/'+this.popupData['theme'];
	jQuery('[id=alp_colorbox_theme-css]').remove();
	head = document.getElementsByTagName('head')[0];
	link = document.createElement('link')
	link.type = "text/css";
	link.id = "alp_colorbox_theme-css";
	link.rel = "stylesheet"
	link.href = popupColorboxUrl;
	document.getElementsByTagName('head')[0].appendChild(link);
	var img = document.createElement('img');

	alpAddEvent(img, "error", function() {
        that.alpShowColorboxWithOptions();
    });
    setTimeout(function() {
        img.src = popupColorboxUrl;
    }, 0);

};

ALPCONPopup.prototype.popupThemeDefaultMeasure = function () {

	var themeName = this.popupData['theme'];
	var defaults = ALPCONPopup.alpColorBoxDeafults;
	/*return theme id*/
	var themeId = themeName.replace( /(^.+\D)(\d+)(\D.+$)/i,'$2');

	return defaults[themeId];
};

ALPCONPopup.prototype.changePopupSettings = function () {

	var popupData = this.popupData;
	var popupDimensionMode = popupData['popup_dimension_mode'];
	var maxWidth = popupData['maxWidth'];
	var screenWidth = jQuery(window).width();
	var popupResponsiveDimensionMeasure = popupData['popup_responsive_dimension_measure'];
	var isMaxWidthInPercent = maxWidth.indexOf("%") != -1 ? true: false;

	if(popupDimensionMode == 'responsiveMode') {

		if(popupResponsiveDimensionMeasure == 'auto') {
			this.popupMaxWidth = '100%';

			/*When max with in px*/
			if(maxWidth && !isMaxWidthInPercent && parseInt(maxWidth) < screenWidth) {
				this.popupMaxWidth = parseInt(maxWidth);
			}
			else if(isMaxWidthInPercent && parseInt(maxWidth) < 100) { /*For example when max width is 800% */
				this.popupMaxWidth = maxWidth;
			}

		}
	}
};

ALPCONPopup.prototype.resizePopup = function (settings) {

	var that = this;
	/*Initial window dimensions*/
	window.alpconInitialWindowWith = window.innerWidth;
	window.alpconInitialWindowHeight = window.innerHeight;

	function resizeColorBox () {
		var currentWindow = jQuery(this);
		var windowWidth = currentWindow.width();
		var windowHeight = currentWindow.height();

		var maxWidth = that.popupData['maxWidth'];
		var maxHeight = that.popupData['maxHeight'];

		if(!maxWidth) {
			maxWidth = '100%';
		}

		if(!maxHeight) {
			maxHeight = '100%';
		}

		if (that.resizeTimer) clearTimeout(that.resizeTimer);
		that.resizeTimer = setTimeout(function() {
			if (jQuery('#alpcboxOverlay').is(':visible')) {
				if (window.alpconFullScreen === true) {
					window.alpconShouldResize = false;
					window.alpconFullScreen = false;
				}
				else {
					window.alpconShouldResize = true;
				}

				if ((window.innerHeight == screen.height) || (!window.screenTop && !window.screenY)) {
					window.alpconShouldResize = false;
				}

				if (maxWidth.indexOf("%") != -1) {
					maxWidth = that.percentToPx(maxWidth, windowWidth);
				}
				else {
					maxWidth = parseInt(maxWidth);
				}

				if (maxHeight.indexOf("%") != -1) {
					maxHeight = that.percentToPx(maxHeight, windowHeight);
				}
				else {
					maxHeight = parseInt(maxHeight);
				}

				if(maxWidth > windowWidth) {
					maxWidth = windowWidth;
				}

				if(maxHeight > windowHeight) {
					maxHeight = windowHeight;
				}

				settings.maxWidth = maxWidth;
				settings.maxHeight = maxHeight;
				var hasFocusedInput = false;
				jQuery('#alpcboxLoadedContent input,#alpcboxLoadedContent textarea').each(function() {

					if(jQuery(this).is(':focus')) {
						hasFocusedInput = true;
					}
				});
				/*For mobile when has some focused input popup does not resize*/
				if( /Android|webOS|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && hasFocusedInput ) {
					window.alpconShouldResize = false;
				}
				/*For just call resize*/
				if (currentWindow.width() == window.alpconInitialWindowWith && currentWindow.height() == window.alpconInitialWindowHeight) {
					window.alpconShouldResize = false;
				}

				if(window.alpconShouldResize) {
					jQuery.alpcolorbox(settings);
					jQuery('#alpcboxLoadingGraphic').css({'display': 'none'});
				}
			}
		}, 500);
	}

	jQuery(window).resize(resizeColorBox);
	window.addEventListener("orientationchange", resizeColorBox, false);

	document.addEventListener("fullscreenchange", function() {
		window.alpconFullScreen = true;
	}, false);

	document.addEventListener("msfullscreenchange", function() {
		window.alpconFullScreen = true;
	}, false);

	document.addEventListener("mozfullscreenchange", function() {
		window.alpconFullScreen = true;
	}, false);

	document.addEventListener("webkitfullscreenchange", function() {
		window.alpconFullScreen = true;
	}, false);
};

ALPCONPopup.prototype.resizeAfterContentResizing = function () {
	var visibilityClasses = [".js-validate-required", ".js-alp-visibility"];
	var maxHeight = this.popupData['maxHeight'];
	var diffContentHight = jQuery("#alpcboxWrapper").height() - jQuery("#alpcboxLoadedContent").height();
	for(var index in visibilityClasses) {
		jQuery(visibilityClasses[index]).visibilityChanged({
			callback: function(element, visible) {
				if(maxHeight !== '' && parseInt(maxHeight) < (jQuery("#alpcboxLoadedContent").prop('scrollHeight') + diffContentHight)) {
					return false;
				}
				jQuery.alpcolorbox.resize();
			},
			// runOnLoad: false,
			frequency: 2000
		});
	}

	new ResizeSensor(jQuery('#alpcboxLoadedContent'), function(){
		if(maxHeight !== '' && parseInt(maxHeight) < (jQuery("#alpcboxLoadedContent").prop('scrollHeight') + diffContentHight)) {
			return false;
		}
		jQuery.alpcolorbox.resize();
	});

};

ALPCONPopup.prototype.alpColorboxContentMode = function() {

	var that = this;

	this.alpColorboxContentTypeReset();
	var popupType = this.popupData['type'];
	var popupHtml = (this.popupData['html'] == '') ? '&nbsp;' : this.popupData['html'];
	var popupContact = (this.popupData['contact'] == '') ? '&nbsp;' : this.popupData['contact'];
	var popupId = this.popupData['id'];

    /*this condition jQuery('#alp-popup-content-wrapper-'+popupId).length != 0 for backward compatibility*/
	if(popupHtml && jQuery('#alp-popup-content-wrapper-'+popupId).length != 0) {
		this.alpColorboxInline = true;
		this.alpColorboxHref = '#alp-popup-content-wrapper-'+popupId;
	}
	else {
		this.alpColorboxHtml = popupHtml;
	}
};

ALPCONPopup.prototype.addToCounter = function (popupId) {

	var params = {};
	params.popupId = popupId;

	var data = {
		action: 'send_to_open_counter',
		ajax_Nonce: ALPBParams.ajax_Nonce,
		params: params
	};

	jQuery.post(ALPBParams.ajaxUrl, data, function(response,d) {

	});
};
ALPCONPopup.soundValue = 1;

// contant click redirect
ALPCONPopup.prototype.contentClickRedirect = function () {
	var popupData = this.popupData;
	var contentClickBehavior = popupData['content-click-behavior'];
	var clickRedirectToUrl = popupData['click-redirect-to-url'];
	var redirectToNewTab = popupData['redirect-to-new-tab'];
	/* If has url for redirect */
	if ((contentClickBehavior !== 'close' || clickRedirectToUrl !== '') && typeof contentClickBehavior !== 'undefined') {
		jQuery('#alpcolorbox').css({
			"cursor": 'pointer'
		});
	}
	jQuery(".alp-current-popup-" + popupData['id']).bind('click', function () {
		if (contentClickBehavior == 'close' || clickRedirectToUrl == '' || typeof contentClickBehavior == 'undefined') {
			jQuery.alpcolorbox.close();
		}
		else {
			if (!redirectToNewTab) {
				window.location = clickRedirectToUrl;
			}
			else {
				window.open(clickRedirectToUrl);
			}
		}

	});
};

// Delay close button
ALPCONPopup.prototype.closeButtonDelay = function (buttonDelayValue) {
	setTimeout(function(){
		jQuery('#alpcboxClose').attr('style', 'display: block !important;');
	},
	buttonDelayValue * 1000 /* received values covert to seconds */
	);
}

ALPCONPopup.prototype.replaceWithCustomShortcode = function(popupId){
	var currentHtmlContent = jQuery('#alp-popup-content-wrapper-'+popupId).html();
	var searchData = this.getSearchDataFromContent(currentHtmlContent);
	var that = this;

	if (!searchData.length) {
		return false;
	}

	for (var index in searchData) {
		var currentSearchData = searchData[index];
		var searchAttributes = currentSearchData['searchData'];

		if (typeof searchAttributes['selector'] == 'undefined' || typeof searchAttributes['attribute'] == 'undefined') {
			that.replaceShortCode(currentSearchData['replaceString'], '');
			continue;
		}

		try {
			if (!jQuery(searchAttributes['selector']).length) {
				that.replaceShortCode(currentSearchData['replaceString'], '');
				continue;
			}
		}
		catch (e) {
			that.replaceShortCode(currentSearchData['replaceString'], '');
			continue;
		}

		var replaceName = jQuery(searchAttributes['selector']).attr(searchAttributes['attribute']);

		if (typeof replaceName == 'undefined') {
			that.replaceShortCode(currentSearchData['replaceString'], '');
			continue;
		}

		that.replaceShortCode(currentSearchData['replaceString'], replaceName);
	}
};

ALPCONPopup.prototype.replaceShortCode = function(shortCode, replaceText){
	var popupId = parseInt(this.popupData['id']);
	var popupContentWrapper = jQuery('#alp-popup-content-wrapper-'+popupId);

	if (!popupContentWrapper.length) {
		return false;
	}

	var currentHtmlContent = popupContentWrapper.contents();

	if (!currentHtmlContent.length) {
		return false;
	}

	for (var index in currentHtmlContent) {
		var currentChild = currentHtmlContent[index];
		var currentChildNodeValue = currentChild.nodeValue;
		var currentChildNodeType = currentChild.nodeType;

		if (currentChildNodeType != Node.TEXT_NODE) {
			continue;
		}

		if (currentChildNodeValue.indexOf(shortCode) != -1) {
			currentChild.nodeValue =  currentChildNodeValue.replace(shortCode, replaceText);
		}
	}
	return true;
};

// Popup close based on automatically closed
ALPCONPopup.prototype.PopupCloseAutomaticaly = function (PopupClosingTimer){	
	setTimeout(function(){
		jQuery.alpcolorbox.close();
	},
	PopupClosingTimer * 1000
	);	
};

 // Popup close based on login user or logout users
ALPCONPopup.prototype.alpPopupLoginUsers = function () {
	 
	jQuery('#alpcolorbox').load("alpPopupClose", function () {
	   jQuery('#alpcolorbox').attr('style', 'visibility: hidden !important;');
	   jQuery("#alpcboxOverlay").css("display", "none");
	});
	
	 var that = this;	 	
	 var Popuploggedinuser = that.popupData['loggedin-user'];
	 var Logged_id = jQuery('body').hasClass('logged-in');

	  if(Logged_id == true && Popuploggedinuser == "true") {				
			// Login Users
			jQuery('#alpcolorbox').load("alpPopupClose", function () {
				jQuery('#alpcolorbox').attr('style', 'visibility: visible !important;');			
				jQuery("#alpcboxOverlay").css("display", "block");
			});	
		} 
		if(Logged_id == false && Popuploggedinuser == "false"){
			// Logout Users
			jQuery('#alpcolorbox').load("alpPopupClose", function () {
				jQuery('#alpcolorbox').attr('style', 'visibility: visible !important;');			
				jQuery("#alpcboxOverlay").css("display", "block");
			});		
		}		
};
// Select Page to show popup
ALPCONPopup.prototype.alppopupSelectePages = function () {
	var OptionsPages = this.popupData['OptionsPages'];
	var ShowAllPageID = this.popupData['ShowAllPageID'];
	var ShowCustomPageID = this.popupData['ShowCustomPageID'];
	if(OptionsPages == "selected"){
		for (i = 0; i < ShowCustomPageID.length; i++) {
		var Pageid = "PageId_"+my_script_vars.postID;
		if(ShowCustomPageID[i] == Pageid){
				jQuery('#alpcolorbox').removeClass("property_values");			
				jQuery("#alpcboxOverlay").removeClass("property_values");
		    }
	     }	 
	 }else{
		if(ShowAllPageID){
			for (i = 0; i < ShowAllPageID.length; i++) {
				jQuery('#alpcolorbox').removeClass("property_values");			
				jQuery("#alpcboxOverlay").removeClass("property_values");
		    }
	    }
    }
};
// Select Post to show popup
ALPCONPopup.prototype.alppopupSelectePosts = function () {
	var OptionsPosts = this.popupData['OptionsPosts'];
	var ShowAllPostID = this.popupData['ShowAllPostID'];
	var ShowCustomPostID = this.popupData['ShowCustomPostID'];	
	if(OptionsPosts == "selected"){
	  for (a = 0; a < ShowCustomPostID.length; a++) { 
		var Pageid = "PostId_"+my_script_vars.postID;
		if(ShowCustomPostID[a] == Pageid){
			jQuery('#alpcolorbox').removeClass("property_values");			
			jQuery("#alpcboxOverlay").removeClass("property_values");
	     }
	  }
	}else{
		if(ShowAllPostID){
			for (a = 0; a < ShowAllPostID.length; a++) {
				jQuery('#alpcolorbox').removeClass("property_values");			
				jQuery("#alpcboxOverlay").removeClass("property_values");
		   }
	   }
    }
 };

// Popup date range show
ALPCONPopup.prototype.alpopuppopupDateRange = function () {
	// DateRangepopup
	var DaterangeFromDate = this.popupData['DaterangeFromDate'];
	var DaterangeToDate = this.popupData['DaterangeToDate'];

	// startDate
	var strdate = DaterangeFromDate.match(/\d+/g),
	year = strdate[0], 
	month = strdate[1], day = strdate[2];	  
	var sdate = day+'/'+month+'/'+year;

	// EndDate
	var enddate = DaterangeToDate.match(/\d+/g),
	year = enddate[0], 
	month = enddate[1], day = enddate[2];	  
	var edate = day+'/'+month+'/'+year;

	//   Current Date
	var d = new Date();
    var month = d.getMonth()+1;
	var day = d.getDate();	
	var output = ((''+day).length<2 ? '0' : '') + day + '/' +((''+month).length<2 ? '0' : '') + month + '/' +d.getFullYear();

	var startDate = new Date(DaterangeFromDate); //YYYY-MM-DD
	var endDate = new Date(DaterangeToDate); //YYYY-MM-DD

	var getDateArray = function(start, end) {
		var arr = new Array();
		var dt = new Date(start);
		while (dt <= end) {
			arr.push(new Date(dt).toLocaleDateString());
			dt.setDate(dt.getDate() + 1);
		}
		return arr;
	}
	var dateArr = getDateArray(startDate, endDate);

	for (var i = 0; i < dateArr.length; i++) {	
		if(dateArr[i] == output){
			dateArr[i];
			jQuery('#alpcolorbox').load("alpPopupClose", function () {
			  jQuery('#alpcolorbox').css('style', 'visibility: visible !important;');			
			  jQuery("#alpcboxOverlay").css("display", "block");
			});
			break;			
		}
		else{
		    jQuery('#alpcolorbox').load("alpPopupClose", function () {
		      jQuery('#alpcolorbox').css('style', 'visibility: hidden !important;');
			 jQuery("#alpcboxOverlay").css("display", "none");
		     });	
		   }		  
    	}
	};

// Popup Schedule time to show
ALPCONPopup.prototype.alpopupSchedulePopUp = function (){
	//  Current Date Time
	// var dtime = new Date();
	// var time = dtime.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
    // var month = dtime.getMonth()+1;
	// var day = dtime.getDate();	
	// var year =dtime.getFullYear();
	// var output = ((''+year).length<2 ? '0' : '') + year + '/' +((''+month).length<2 ? '0' : '') + month + '/' +((''+day).length<2 ? '0' : '') + day + ' ' + ((''+time).length<2 ? '0' : '')+ time;
	
	var SchedulePopUpDate = this.popupData['SchedulePopUpDate'];
	//  Current Date
	var dtime = new Date();
    var month = dtime.getMonth()+1;
	var day = dtime.getDate();	
	var year =dtime.getFullYear();
	var systemdate = ((''+year).length<2 ? '0' : '') + year + '/' +((''+month).length<2 ? '0' : '') + month + '/' +((''+day).length<2 ? '0' : '') + day;


	if( systemdate == SchedulePopUpDate ){			
		jQuery('#alpcolorbox').load("alpPopupClose", function () {
			jQuery('#alpcolorbox').attr('style', 'visibility: visible !important;');			
			jQuery("#alpcboxOverlay").css("display", "block");
		  });
	}else{
		jQuery('#alpcolorbox').load("alpPopupClose", function () {
			jQuery('#alpcolorbox').attr('style', 'visibility: hidden !important;');
		  jQuery("#alpcboxOverlay").css("display", "none");
	    });
	}
};
//   Disable Popup on mobile device
ALPCONPopup.prototype.popupMobileDisable = function (){
	userDevice =false;
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
		|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
			userDevice = true;			  
	if( userDevice = "true"){		
		jQuery('#alpcolorbox').load("alpPopupClose", function () {
		   jQuery('#alpcolorbox').attr('style', 'visibility: hidden !important;');
		 jQuery("#alpcboxOverlay").css("display", "none");
	   });
	}else{
		jQuery('#alpcolorbox').load("alpPopupClose", function () {
			jQuery('#alpcolorbox').attr('style', 'visibility: visible !important;');
		  jQuery("#alpcboxOverlay").css("display", "block");
	    });
	  }
   }
};

// Enable for mobile Device Only
ALPCONPopup.prototype.alpforMobile = function (){
	jQuery('#alpcolorbox').load("alpPopupClose", function () {
		jQuery('#alpcolorbox').attr('style', 'visibility: hidden !important;');
	  jQuery("#alpcboxOverlay").css("display", "none");
	});
	userDevice =false;
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
		|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
			userDevice = true;			  
	if( userDevice = "true"){
		jQuery('#alpcolorbox').load("alpPopupClose", function () {
		   jQuery('#alpcolorbox').attr('style', 'visibility: visible !important;');
		 jQuery("#alpcboxOverlay").css("display", "block");
	   });
	}else{
		jQuery('#alpcolorbox').load("alpPopupClose", function () {
			jQuery('#alpcolorbox').attr('style', 'visibility: hidden !important;');
		  jQuery("#alpcboxOverlay").css("display", "none");
	    });
	  }
    }
  };
//   Inactivity Popup hasbeen Close
ALPCONPopup.prototype.PopupCloseInactivity = function (Inactivitytime){
		var timedelay = Inactivitytime * 1000;
		var t;
		window.onload = resetTimer;
		document.onmousemove = resetTimer;
		document.onkeypress = resetTimer;	
		function Popupinctivitydelay() {
			window.location.reload();
		}	
		// alert(timedelay);
		function resetTimer() {
			clearTimeout(t);
			t = setTimeout(Popupinctivitydelay, timedelay)
			// 1000 milisec = 1 sec
	  }	
  };
// While Scrolling
ALPCONPopup.prototype.alpWhileScrolling = function (){
	jQuery('#alpcolorbox').load("alpPopupClose", function () {
	  jQuery('#alpcolorbox').css("display", "none");
	  jQuery("#alpcboxOverlay").css("display", "none");
	});		
	var position = jQuery(window).scrollTop(); 
	jQuery(window).scroll(function() {
    var scroll = jQuery(window).scrollTop();
    if(scroll > position) {
		jQuery('#alpcolorbox').load("alpPopupClose", function () {
			jQuery('#alpcolorbox').css('display', 'block');
		  jQuery('#alpcboxOverlay').css('display', 'block');
		});
    } else {
		 jQuery('#alpcolorbox').load("alpPopupClose", function () {
			jQuery('#alpcolorbox').css('display', 'block');
		  jQuery('#alpcboxOverlay').css('display', 'block');
		});
    }
    position = scroll;
	});
};

ALPCONPopup.prototype.colorboxEventsListener = function (){
	var that = this;
	var disablePageScrolling = this.varToBool(this.popupData['disable-page-scrolling']);
	var repetitivePopup = this.popupData['repetitivePopup'];
	var repetitivePopupPeriod = this.popupData['repetitivePopupPeriod'];
	var buttonDelayValue = this.popupData['buttonDelayValue'];
	var PopupClosingTimer = that.popupData['PopupClosingTimer'];
	var Inactivitytime = that.popupData['Inactivitytime'];
	var popupSelectePages = that.popupData['SelectePages'];
	var popupSelectePosts = that.popupData['SelectePosts'];




	repetitivePopupPeriod = parseInt(repetitivePopupPeriod)*1000;
	var repetitiveTimeout = null;

	jQuery('#alpcolorbox').on("alpColorboxOnOpen", function () {
		if(disablePageScrolling) {
			jQuery('html, body').css({ overflow: 'hidden' });
		}
	});
	   
	
			
			if(popupSelectePages){
				jQuery('#alpcolorbox').on("alpPopupClose", function () {
					jQuery('#alpcolorbox').addClass("property_values");
					jQuery("#alpcboxOverlay").addClass("property_values");
			that.alppopupSelectePages();
				});
			}	
			if(popupSelectePosts){	
				jQuery('#alpcolorbox').on("alpPopupClose", function () {
					jQuery('#alpcolorbox').addClass("property_values");
					jQuery("#alpcboxOverlay").addClass("property_values");
				that.alppopupSelectePosts();
			});
		}
	
	// if(popupSelectePosts){	
	// 	jQuery('#alpcolorbox').on("alpPopupClose", function () {
	// 		jQuery('#alpcolorbox').addClass("property_values");
	// 		jQuery("#alpcboxOverlay").addClass("property_values");
	// 	 });	   
	//  that.alppopupSelectePosts();
	// }
	jQuery('#alpcolorbox').on("alpColorboxOnCompleate", function () {

		if (that.popupCloseButton && buttonDelayValue) {
		   that.closeButtonDelay(buttonDelayValue);
		}
		if(that.popupContentClick) {
			that.contentClickRedirect();
		}
		if (that.popupAutoClosePopup && PopupClosingTimer ) {			
			that.PopupCloseAutomaticaly(PopupClosingTimer);		
		}
		if (that.popupInactivity && Inactivitytime ) {			
			that.PopupCloseInactivity(Inactivitytime);		
		}
		clearInterval(repetitiveTimeout);
	});

	jQuery('#alpcolorbox').on("alpPopupCleanup", function () {
		if(repetitivePopup) {
			repetitiveTimeout = setTimeout(function() {
			var alpPoupFrontendObj = new ALPCONPopup();
			alpPoupFrontendObj.popupOpenById(that.popupData['id']);
			}, repetitivePopupPeriod);
		}
		
	});

	jQuery('#alpcolorbox').on("alpPopupClose", function () {
		if(disablePageScrolling) {
			jQuery('html, body').css({ overflow: '' });
		}
	});
};

ALPCONPopup.prototype.alpShowColorboxWithOptions = function() {

	var that = this;
	setTimeout(function() {
		
		that.colorboxEventsListener();
		var popupId = that.popupData['id'];
		alpPopupFixed = that.varToBool(that.popupData['popupFixed']);
		that.popupOverlayClose = that.varToBool(that.popupData['overlayClose']);
		that.popupContentClick = that.varToBool(that.popupData['contentClick']);
		var popupReposition = that.varToBool(that.popupData['reposition']);
		var popupScrolling = that.varToBool(that.popupData['scrolling']);
		var popupscaling = that.varToBool(that.popupData['scaling']);
		that.popupEscKey = that.varToBool(that.popupData['escKey']);
		that.popupCloseButton = that.varToBool(that.popupData['closeButton']);
		var popupMobileDisable = that.varToBool(that.popupData['MobileDisable']);
		var popupForMobile = that.varToBool(that.popupData['MobileOnly']);
		var popupWhileScrolling = that.varToBool(that.popupData['WhileScrolling']);
		that.popupInactivity =that.varToBool(that.popupData['Inactivity']);
		var popupDisableOverlay = that.varToBool(that.popupData['DisableOverlay']);
		that.popupAutoClosePopup = that.varToBool(that.popupData['AutoClosePopup']);
		var popupUserStatus = that.varToBool(that.popupData['UserStatus']);	
		var popupDateRange = that.varToBool(that.popupData['DateRange']);
		var popupSchedulePopUp = that.varToBool(that.popupData['SchedulePopUp']);	
	


			// if (popupCantClose) {
			// 	that.cantPopupClose();
			// }
		var popupPosition = that.popupData['fixedPostion'];
		var popupHtml = (that.popupData['html'] == '') ? '&nbsp;' : that.popupData['html'];
		var popupContact= (that.popupData['contact'] == '') ? '&nbsp;' : that.popupData['contact'];

		var popupImage = that.popupData['image'];
		var popupShortCode = that.popupData['shortcode'];
		var popupOverlayColor = that.popupData['alpOverlayColor'];
		var contentBackgroundColor = that.popupData['alp-content-background-color'];
		var popupDimensionMode = that.popupData['popup_dimension_mode'];
		var popupResponsiveDimensionMeasure = that.popupData['popup_responsive_dimension_measure'];
		var popupWidth = that.popupData['width'];
		var popupHeight = that.popupData['height'];
		var popupOpacity = that.popupData['opacity'];
		var popupMaxWidth = that.popupData['maxWidth'];
		var popupMaxHeight = that.popupData['maxHeight'];
		var popupEffectDuration = that.popupData['duration'];
		var popupEffect = that.popupData['effect'];
		var pushToBottom = that.popupData['pushToBottom'];


		that.alpColorboxContentMode();

		if(popupDimensionMode == 'responsiveMode') {

			popupWidth = '';
			if(popupResponsiveDimensionMeasure != 'auto') {
				popupWidth = parseInt(popupResponsiveDimensionMeasure)+'%';
			}
			if(that.popupData['type'] != 'iframe' && that.popupData['type'] != 'video') {
				popupHeight = '';
			}
		}


		var alpScreenWidth = jQuery(window).width();
		var alpScreenHeight = jQuery(window).height();

		var alpIsWidthInPercent = popupWidth.indexOf("%");
		var alpIsHeightInPercent = popupHeight.indexOf("%");
		var alpPopupHeightPx = popupHeight;
		var alpPopupWidthPx = popupWidth;
		if (alpIsWidthInPercent != -1) {
			alpPopupWidthPx = that.percentToPx(popupWidth, alpScreenWidth);
		}
		if (alpIsHeightInPercent != -1) {
			alpPopupHeightPx = that.percentToPx(popupHeight, alpScreenHeight);
		}


		alpPopupWidthPx = parseInt(alpPopupWidthPx);
		alpPopupHeightPx = parseInt(alpPopupHeightPx);

		var staticPositionWidth = alpPopupWidthPx;
		if(staticPositionWidth > alpScreenWidth) {
			staticPositionWidth = alpScreenWidth;
		}

		popupPositionTop = that.getPositionPercent("50%", alpScreenHeight, alpPopupHeightPx);
		popupPositionLeft = that.getPositionPercent("50%", alpScreenWidth, alpPopupWidthPx);

		if(popupPosition == 1) { // Left Top
			that.setFixedPosition('0%','3%', false, false, 0, 0);
		}
		else if(popupPosition == 2) { // Left Top
			that.setFixedPosition(popupPositionLeft,'3%', false, false, 0, 50);
		}
		else if(popupPosition == 3) { //Right Top
			that.setFixedPosition(false,'3%', false, '0%', 0, 90);
		}
		else if(popupPosition == 4) { // Left Center
			that.setFixedPosition('0%', popupPositionTop, false, false, popupPositionTop, 0);
		}
		else if(popupPosition == 5) { // center Center
			alpPopupFixed = true;
			that.setFixedPosition(false, false, false, false, 50, 50);
		}
		else if(popupPosition == 6) { // Right Center
			that.setFixedPosition('0%', popupPositionTop, false,'0%', 50, 90);
		}
		else if(popupPosition == 7) { // Left Bottom
			that.setFixedPosition('0%', false, '0%', false, 90, 0);
		}
		else if(popupPosition == 8) { // Center Bottom
			that.setFixedPosition(popupPositionLeft, false, '0%', false, 90, 50);
		}
		else if(popupPosition == 9) { // Right Bottom
			that.setFixedPosition(false, false, '0%', '0%', 90, 90);
		}
		else {
			that.setFixedPosition(false, false, false, false, 50, 50);
		}
		if (popupMobileDisable) {
			userDevice = that.popupMobileDisable();
		}

		if (popupUserStatus) {
			 that.alpPopupLoginUsers();
		}		
	    if(popupDateRange){	
		 that.alpopuppopupDateRange();
		}

		if(popupSchedulePopUp){	
		  that.alpopupSchedulePopUp();
		}
 
	   if (popupscaling) {
		   that.alpPopupScaling();
	   }
	   
	   if (popupForMobile) {
		   openOnlyMobile = that.alpforMobile();
	   }
	   if (popupWhileScrolling) {
			 
		   	// jQuery('#alpcolorbox').load("alpPopupClose", function () {
			// jQuery('#alpcolorbox').attr('style', 'visibility: hidden !important;');
	  		// jQuery("#alpcboxOverlay").css("display", "none");
			// });
		 	that.alpWhileScrolling();
	    }

		that.changePopupSettings();
		ALP_POPUP_SETTINGS = {
			popupId: popupId,
			html: that.alpColorboxHtml,
			width: popupWidth,
			height: popupHeight,
			onOpen:function() {
				that.currentPopupId = popupId;
				jQuery('#alpcolorbox').removeAttr('style');
				jQuery('#alpcolorbox').removeAttr('left');
				jQuery('#alpcolorbox').css('top',''+that.initialPositionTop+'%');
				jQuery('#alpcolorbox').css('left',''+that.initialPositionLeft+'%');
				jQuery('#alpcolorbox').css('animation-duration', popupEffectDuration+"s");
				jQuery('#alpcolorbox').css('-webkit-animation-duration', popupEffectDuration+"s");
				jQuery("#alpcolorbox").removeAttr("class");
				jQuery("#alpcolorbox").addClass('animated '+popupEffect+'');
				// jQuery("#alpcboxOverlay").addClass("alpcboxOverlayBg");
				// jQuery("#alpcboxOverlay").removeAttr('style');

				if (popupOverlayColor) {
					jQuery("#alpcboxOverlay").css({'background' : 'none', 'background-color' : popupOverlayColor});
				}
				if(popupDisableOverlay){
					jQuery("#alpcboxOverlay").css({'background' : 'none', 'background-color' :' none!important'});
				}
				var openArgs = {
					popupId: popupId
				};

			   jQuery('#alpcolorbox').trigger("alpColorboxOnOpen",[]);
			   jQuery('#alpcolorbox').trigger("alpPopupClose",[]);


			},
			// onLoad: function(){
			// },
			onScroll: function(){
			},
			onComplete: function(){
				if(contentBackgroundColor) {
					jQuery("#alpcboxLoadedContent").css({'background-color' : contentBackgroundColor})
				}
				jQuery("#alpcboxLoadedContent").addClass("alp-current-popup-"+that.popupData['id'])
				jQuery('#alpcolorbox').trigger("alpColorboxOnCompleate", [pushToBottom]);
				if(popupWidth == '' && popupHeight == '') {
					jQuery.alpcolorbox.resize();
				}
				
				var alppopupInit = new AplPopupInit(that.popupData);
				alppopupInit.overallInit();
				/* For specific popup Like Countdown AgeRestcion popups */
				alppopupInit.initByPopupType();
				if(popupDimensionMode == 'responsiveMode') {
					 that.calculateContentDimensions();
					 that.resizeDimension();				
				}
				
			},
			onCleanup: function () {
				jQuery('#alpcolorbox').trigger("alpPopupCleanup", []);
			},			
			onClosed: function() {
				that.currentPopupId = false;
				jQuery("#alpcboxLoadedContent").removeClass("alp-current-popup-"+that.popupData['id'])
				jQuery('#alpcolorbox').trigger("alpPopupClose", []);
			},
			trapFocus: that.alpconTrapFocus,
			html: popupHtml,
			// photo: popupPhoto,
			contact:popupContact,
			href: popupImage,
			opacity: popupOpacity,
			escKey: that.popupEscKey,
			closeButton: that.popupCloseButton,
			fixed: alpPopupFixed,
			top: that.positionTop,
			bottom: that.positionBottom,
			left: that.positionLeft,
			right: that.positionRight,
			scrolling: popupScrolling,
			reposition: popupReposition,
			overlayClose: that.popupOverlayClose,
			maxWidth: popupMaxWidth,
			maxHeight: popupMaxHeight,
		
		};

		if(popupDimensionMode == 'responsiveMode') {

			ALP_POPUP_SETTINGS.speed = 10;
		}

		if (!that.currentPopupId) {
		jQuery.alpcolorbox(ALP_POPUP_SETTINGS);
		}

		if (that.popupData['id'] && that.isOnLoad==false && that.openOnce != '') {
			jQuery.cookie("alpPopupNumbers",that.popupData['id'], { expires: 7});
		}

		jQuery('#alpcolorbox').bind('alpPopupClose', function (e) {
			/* reset event execute count for popup open */
			that.alpEventExecuteCount = 0;
			that.eventExecuteCountByClass = 0;
			jQuery('#alpdummy').removeClass(customClassName);


			jQuery('#alpcolorbox').removeClass(customClassName);
			/* Remove custom class for another popup */
			jQuery('#alpcboxOverlay').removeClass(customClassName);
			jQuery('#alpcolorbox').removeClass(popupEffect);
			/* Remove animated effect for another popup */
		});

	},this.popupData['interveltime']*1000);
}

jQuery(document).ready(function($) {
	var popupObj = new ALPCONPopup();
	popupObj.init();
});
