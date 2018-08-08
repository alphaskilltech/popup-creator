function AplPopupInit(popupData) {
	this.popupData = popupData;
	this.cloneToHtmlPopup();
	this.reopenPopupAfterSubmission();
}

AplPopupInit.prototype.cloneToHtmlPopup = function() {
	var currentPopupId = this.popupData['id'];

	/*When content does not have shortcode*/
	if(jQuery("#alppb-all-content-"+currentPopupId).length == 0) {
		return;
	}
	
	jQuery("#alppb-all-content-"+currentPopupId).appendTo(jQuery('.alp-current-popup-'+currentPopupId));

	this.popupResizing(currentPopupId);
	jQuery('#alpcolorbox').bind('alpPopupCleanup', function() {
		jQuery('#alppb-all-content-'+currentPopupId).appendTo(jQuery("#alp-popup-content-"+currentPopupId));
	});

	this.shortcodeInPopupContent();
}

AplPopupInit.prototype.reopenPopupAfterSubmission = function() {

	var reopenSubmission = this.popupData['reopenAfterSubmission'];
	var currentPopupId = this.popupData['id'];
	ALPCONPopup.setCookie('alpSubmitReloadingForm', currentPopupId, -10);
	var that = this;

	if(reopenSubmission) {
		jQuery("#alpcboxLoadedContent form").submit(function() {
			ALPCONPopup.setCookie('alpSubmitReloadingForm', currentPopupId);
		});
	}
}

AplPopupInit.prototype.popupResizing = function(currentPopupId) {

	var width = this.popupData['width'];
	var height = this.popupData['height'];
	var maxWidth = this.popupData['maxWidth'];
	var maxHeight = this.popupData['maxHeight'];

	if(maxWidth == '' && maxHeight == '') {
		jQuery.alpcolorbox.resize({'width': width, 'height': height});
	}
}

AplPopupInit.prototype.shortcodeInPopupContent = function() {

	jQuery(".alp-show-popup").bind('click',function() {
		var alpPopupID = jQuery(this).attr("data-alppopupid");
		var alpInsidePopup = jQuery(this).attr("insidepopup");

		if(typeof alpInsidePopup == 'undefined' || alpInsidePopup != 'on') {
			return false;
		}
		
		jQuery.alpcolorbox.close();
		
		jQuery('#alpcolorbox').bind("alpPopupClose", function() {
			if(alpPopupID == '') {
				return;
			}
			alpPoupFrontendObj = new ALPCONPopup();
			alpPoupFrontendObj.showPopup(alpPopupID,false);
			alpPopupID = '';
		});
	});
}

AplPopupInit.prototype.overallInit = function() {
	jQuery('.alp-popup-close').bind('click', function() {
		jQuery.alpcolorbox.close();
	});

	
}

AplPopupInit.prototype.initByPopupType = function() {
	var data = this.popupData;
	var popupObj = {};
	var popupType = data['type'];
	var popupId = data['id'];

	switch(popupType) {
	
		case 'contactForm':
			popupObj = new AlpContactForm();
			popupObj.buildStyle();
			break;
	}

	return popupObj;
}