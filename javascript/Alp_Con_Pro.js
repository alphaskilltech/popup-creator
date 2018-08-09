function alpPopup() {
	
}
alpPopup.canOpenOnce = function(id) {
	if (jQuery.cookie('alpPopupNumbers') != 'undefined' && jQuery.cookie('alpPopupNumbers') == id) {
		return false;
	}
	else {
		return true
	}
}
alpPopup.cantPopupClose = function() {
	alp_popup_escKey = false;
	alp_popup_closeButton = false;
	alp_popup_overlayClose = false;
	alp_popup_contentClick = false;
}
alpPopup.forMobile = function() {
	return jQuery.browser.device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
}
alpPopup.onScrolling = function(popupId) {
	var scrollStatus = false;
		jQuery(window).on('scroll', function(){
			var scrollTop = jQuery(window).scrollTop();
			var docHeight = jQuery(document).height();
			var winHeight = jQuery(window).height();
			var scrollPercent = (scrollTop) / (docHeight - winHeight);
			var scrollPercentRounded = Math.round(scrollPercent*100);
			if(beforeScrolingPrsent < scrollPercentRounded) {
				if(scrollStatus == false) {
					showPopup(popupId,true);
					scrollStatus = true;
				}
			}
		});
}
alpPopup.AutoClosePopup = function(popupId,alp_promotional_popupClosingTimer) {
	showPopup(popupId,true);
	
}