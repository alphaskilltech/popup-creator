function beckend() {

}

beckend.prototype.alpInit =  function() {

	this.imageUpload(); /* It's Image Upload function */
	this.deletePopup(); /* Delete popup */
 	this.titleNotEmpty(); /* Check title is Empty */
 	this.showThemePicture(); /* Show themes pictures */
 	this.showEffects(); /* Show effect type */
 	this.pageAcordion(); /* For page acordion divs */
 	this.fixedPostionSelection(); /* Fuctionality for selected postion */
 	this.showInfo(); /* Show description options */
 	this.opasictyRange(); /* Opcity range */
 	this.subOptionContents();
 	this.addCountris();
 	this.showCloseTextFieldForTheme();
 	this.popupReview();
	this.popupTimer();
	this.switchPopupActive();
	this.initAccordions();
	this.popupPreview();

 	
}
beckend.prototype.switchPopupActive = function() {
	var that = this;

	jQuery(".switch-checkbox").bind('change', function() {
		var dataOptions = {};
		var popupId = jQuery(this).attr('data-switch-id');
		var ajaxNonce = jQuery(this).attr('data-checkbox-ajaxNonce');
		dataOptions.ajaxNonce = ajaxNonce;	

		if(jQuery(this).is(":checked")) {
			that.popupStatusChenge('on', popupId, dataOptions);	
		}
		else {
			that.popupStatusChenge('off', popupId, dataOptions);	
		}
	});
};

	beckend.prototype.popupStatusChenge = function(status, popupId, dataOptions) {
		var data = {
			action: 'change_popup_status',
			ajaxNonce: dataOptions.ajaxNonce,
			popupId: popupId,
			popupStatus: status
		};

			jQuery.post(ajaxurl, data, function(response,d) {
		
			});
		};

	beckend.prototype.reviewPopup = function () {

		jQuery('#alpcolorbox').ready(function () {
			jQuery('#alpcolorbox').on('alpPopupCleanup', function () {
				var ajaxNonce = jQuery(this).attr('data-ajaxnonce');
	
				var data = {
					action: 'change_review_popup_show_period',
					ajaxNonce: ALPCON_AJAX_NONCE
				};
				jQuery.post(ajaxurl, data, function(response,d) {
					jQuery.alpcolorbox.close();
				});
			});
		});
	
	};
	
	
	beckend.prototype.popupReview = function() {
		jQuery(".alp-dont-show-agin").on("click", function() {
	
			var ajaxNonce = jQuery(this).attr('data-ajaxnonce');
			var data = {
				action: 'close_review_panel',
				ajaxNonce: ajaxNonce
			};
			jQuery.post(ajaxurl, data, function(response,d) {
	
			});
			jQuery( ".alp-info-panel-wrapper" ).hide(300);
		});
	
		jQuery('.alp-info-close').on('click', function() {
			jQuery( ".alp-info-panel-wrapper" ).hide(300);
		});
	};

beckend.prototype.checkboxAcordion = function(element) {
	if(!element.is(':checked')) {
		element.nextAll("div").first().css({'display': 'none'});
	}
	else {
		element.nextAll("div").first().css({'display':'inline-block'});
	}
}

beckend.prototype.imageUpload = function() {
	if(jQuery("#js-upload-image").val()) {
		jQuery(".show-image-contenier").html("");
		jQuery(".show-image-contenier").css({'background-image': 'url("' + jQuery("#js-upload-image").val() + '")'});
	}
	var custom_uploader;
	jQuery('#js-upload-image-button').click(function(e) {
		e.preventDefault();

		/* If the uploader object has already been created, reopen the dialog */
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}
		/* Extend the wp.media object */
		custom_uploader = wp.media.frames.file_frame = wp.media({
			titleFF: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
		/* When a file is selected, grab the URL and set it as the text field's value */
		custom_uploader.on('select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();
			jQuery(".show-image-contenier").css({'background-image': 'url("' + attachment.url + '")'});
			jQuery(".show-image-contenier").html("");
			jQuery('#js-upload-image').val(attachment.url);
		});
		/* Open the uploader dialog */
		custom_uploader.open();
	});

	/* its finish image uploader */
}

beckend.prototype.deletePopup = function() {
	jQuery(".alp-js-delete-link").bind('click',function() {
		
		var request = confirm("Are you sure delete this popup?");
		if(!request) {
			return false;
		}
		var popup_id = jQuery(this).attr("data-alp-popup-id");
		var ajaxNonce = jQuery(this).attr('data-ajaxNonce');
		var datas = {
			action: 'delete_popup',
			ajaxNonce: ajaxNonce,
			popup_id: popup_id
		}
		// console.log(data);
		jQuery.post(ajaxurl, datas, function(response,d) {
			location.reload();
		});
	});
}

beckend.prototype.titleNotEmpty = function() {
	jQuery("#add-form").submit(function() {
		var popupTitle = jQuery(".alp-js-popup-title").val();
		if(popupTitle == '' || popupTitle == ' ') {
			alert('Please fill in title field');
			return false;
		}
	});

}

beckend.prototype.showThemePicture = function() {
	jQuery(".popup_theme_name").bind("mouseover",function(e) {
		jQuery('.theme'+jQuery(this).attr("alppoupnumber")+'').css('display', 'block');
	});
}

beckend.prototype.showEffects = function() {
	effectTimer = '';

	jQuery('select[name="effect"]').bind('change', function() {
		if (effectTimer!='') {
			clearTimeout(effectTimer);
		}
		effectTimer = setTimeout(function() {
			jQuery("#effectShow").hide();
			effectTimer = '';
		},1400);
		jQuery("#effectShow").removeClass();
		jQuery("#effectShow").show();
		jQuery("#effectShow").addClass('alp-animated '+jQuery(this).val()+'');
	});
	jQuery('.js-preview-effect').click(function() {
		if (effectTimer!='') {
			clearTimeout(effectTimer);
		}
		effectTimer = setTimeout(function() {
			jQuery("#effectShow").hide();
			effectTimer = '';
		},1400);
		jQuery("#effectShow").removeClass();
		jQuery("#effectShow").show();
		jQuery("#effectShow").addClass('alp-animated '+jQuery('select[name="effect"] option:selected').val()+'');
	});
}

beckend.prototype.pageAcordion = function() {
	jQuery("#specialoptionsTitle").toggle(function(){
		jQuery('.specialOptionsContent').fadeOut();
		jQuery("#specialoptionsTitle > img").css("transform", 'rotate(0deg)');
	},function(){
		jQuery('.specialOptionsContent').fadeIn();
		jQuery("#specialoptionsTitle > img").css("transform", 'rotate(180deg)');
	});

	function acardionDivs(prama1,param2,param3) {
		jQuery(prama1).toggle(function() {
			jQuery(param2).addClass('closed');
			jQuery(param3).fadeOut();

		},function() {
			jQuery(param3).fadeIn();
			jQuery(param2).removeClass('closed');
		});
	}

	acardionDivs(".generalTitle",'popupCreator_general_postbox','.generalContent');
	acardionDivs(".effectTitle",'popupCreator_effect_postbox','.effectsContent');
	acardionDivs(".optionsTitle",'popupCreator_options_postbox','.optionsContent');
	acardionDivs(".featuresTitle",'.popupCreator_features_postbox','.featuresContent');
	acardionDivs(".dimentionsTitle",'popupCreator_dimention_postbox','.dimensionsContent');
	acardionDivs(".js-advanced-title",'.js-advanced-postbox','.advanced-options-content');
	acardionDivs(".js-special-title",'.popup-builder-special-postbox','.special-options-content');
}

beckend.prototype.fixedPostionSelection = function() {
	jQuery(".js-fixed-position-style").bind("click",function() {
		var alpelement = jQuery(this);
		var alppos = alpelement.attr('data-alpvalue');
		jQuery(".js-fixed-position-style").css("backgroundColor","#FFFFFF");
		jQuery(this).css("backgroundColor","rgba(70,173,208,0.5)");
		jQuery(".js-fixed-postion").val(alppos);
	});

	jQuery(".js-fixed-position-style").bind("mouseover",function() {
		jQuery(".js-fixed-position-style").css("backgroundColor","#FFFFFF");
		jQuery(this).css("backgroundColor","rgb(70,173,208)");
		jQuery(".js-fixed-position-style").each(function() {
			if (jQuery(this).attr("data-alpvalue") == jQuery('.js-fixed-postion').val())
				jQuery(this).css("backgroundColor","rgba(70,173,208,0.5)");
		});
	});

	jQuery(".js-fixed-position-style").bind("mouseout",function() {
		if(jQuery(".js-fixed-position-style").attr("data-alpvalue") !== jQuery(".js-fixed-postion").val() || jQuery(".js-fixed-postion").val() == 1) {
			jQuery(this).css("backgroundColor","#FFFFFF");
		}
		jQuery(".js-fixed-position-style").each(function() {
			if (jQuery(this).attr("data-alpvalue") == jQuery('.js-fixed-postion').val()) {
				jQuery(this).css("backgroundColor","rgba(70,173,208,0.5)");
			}
		});
	});

	if(jQuery('.js-fixed-postion').val()!='') {
		jQuery(".js-fixed-position-style").each(function(){
			if (jQuery(this).attr("data-alpvalue") == jQuery('.js-fixed-postion').val()) {
				jQuery(this).css("backgroundColor","rgba(70,173,208,0.5)");
			}
		});
	}
}

beckend.prototype.showInfo = function() {
		jQuery(".dashicons.dashicons-info").hover(
			function() {
				jQuery(this).next('span').css({"display": 'inline-block'});
			}, function() {
				jQuery(this).next('span').css({"display": 'none'});
			}
		);
}

beckend.prototype.opasictyRange = function() {
	if (typeof Powerange != "undefined") {
		var dec = document.querySelector('.js-decimal');
		function displayDecimalValue() {
			var dec = document.querySelector('.js-decimal');
			document.getElementById('js-display-decimal').innerHTML = jQuery(".js-decimal").attr("value");
		}
		var initDec = new Powerange(dec, { decimal: true, callback: displayDecimalValue, max: 1, start: jQuery(".js-decimal").attr("value") });
	}
}

beckend.prototype.showOptionsInfo = function(cehckboxSelector, param2) {
	if(jQuery(""+cehckboxSelector+":checked").length == 0) {
		jQuery("."+param2+"").css({'display': 'none'});
	}
	else
	{
		jQuery("."+param2+"").css({'display':'inline-block'});
	}

	jQuery(""+cehckboxSelector+"").bind("click",function() {
		if(jQuery(""+cehckboxSelector+":checked").length == 0) {
			jQuery("."+param2+"").css({'display':'none'});
		}
		else {
			jQuery("."+param2+"").css({'display':'inline-block'});
		}
	});
	jQuery('input.popup_theme_name').bind('mouseout',function() {
		jQuery('.theme1').css('display', 'none');
		jQuery('.theme2').css('display', 'none');
		jQuery('.theme3').css('display', 'none');
		jQuery('.theme4').css('display', 'none');
		jQuery('.theme5').css('display', 'none');
	});

}

beckend.prototype.subOptionContents = function() {
	this.showOptionsInfo("#js-auto-close", "js-auto-close-content");
	this.showOptionsInfo("#js-scrolling-event-inp", "js-scrolling-content");
	this.showOptionsInfo("#js-inactivity-event-inp", "js-inactivity-content");
	this.showOptionsInfo("#js-countris", "js-countri-content");
	this.showOptionsInfo("#js-popup-only-once", "js-popup-only-once-content");
	this.showOptionsInfo(".js-on-all-pages", "js-all-pages-content");
	this.showOptionsInfo(".js-on-all-posts", "js-all-posts-content");
	this.showOptionsInfo("Date_Range_Change", "popup_date_filed_date");
	this.showOptionsInfo(".js-on-all-custom-posts", "js-all-custom-posts-content");
	this.showOptionsInfo(".js-user-seperator", "js-user-seperator-content");
	this.showOptionsInfo(".js-checkbox-contnet-click", "js-content-click-wrraper");
	this.showOptionsInfo(".js-checkbox-contact-success-frequency-click", "js-checkbox-contact-success-frequency-wrraper");

	// var that = this;
	// var element = jQuery(".js-checkbox-acordion");
	// element.each(function() {
	// 	that.checkboxAcordion(jQuery(this));
	// });

	// element.click(function() {
	// 	var elements = jQuery(this);
	// 	that.checkboxAcordion(jQuery(this));
	// });

	this.radioButtonAcordion(jQuery("[name='allPages']"),jQuery("[name='allPages']:checked"),"selected", jQuery('.js-pages-selectbox-content'));
	this.radioButtonAcordion(jQuery("[name='allPosts']"),jQuery("[name='allPosts']:checked"),"selected",jQuery('.js-posts-selectbox-content'));
	this.radioButtonAcordion(jQuery("[name='allPosts']"),jQuery("[name='allPosts']:checked"),"allCategories", jQuery(".js-all-categories-content"));
	this.radioButtonAcordion(jQuery("[name='allCustomPosts']"),jQuery("[name='allCustomPosts']:checked"),"selected", jQuery(".js-all-custompost-content"));
	this.radioButtonAcordion(jQuery("[name='content-click-behavior']"),jQuery("[name='content-click-behavior']:checked"),"redirect",jQuery(".js-readio-buttons-acordion-content"));

    this.radioButtonAcordion(jQuery("[name='subs-success-behavior']"),jQuery("[name='subs-success-behavior']:checked"),"showMessage", jQuery('.js-subs-success-message-content'));
    this.radioButtonAcordion(jQuery("[name='subs-success-behavior']"),jQuery("[name='subs-success-behavior']:checked"),"redirectToUrl", jQuery('.js-subs-success-redirect-content'));
    this.radioButtonAcordion(jQuery("[name='subs-success-behavior']"),jQuery("[name='subs-success-behavior']:checked"),"openPopup", jQuery('.js-subs-success-popups-list-content'));
};

beckend.prototype.radioButtonAcordion = function(element, checkedElement,value, toggleContnet) {
	element.on("change", function() {

		if(jQuery(this).is(":checked") && jQuery(this).val() == value) {
			jQuery(this).after(toggleContnet.css({'display':'inline-block'}));
		
		}
		else {
			toggleContnet.css({'display': 'none'});
		}
	});
	if(checkedElement.val() == value) {
        checkedElement.after(toggleContnet.css({'display':'inline-block'}));
	}
	else {
		toggleContnet.css({'display': 'none'});
	}
};

beckend.prototype.initAccordions = function() {

	var radioButtonsList = [
		jQuery("[name='contact-success-behavior']"),
		jQuery("[name='popup_dimension_mode']"),
	];

	for(var radioButtonIndex in radioButtonsList) {

		var radioButton = radioButtonsList[radioButtonIndex];

		var that = this;
		radioButton.each(function () {
			that.buildAccordionActions(jQuery(this));
		});
		radioButton.on("change", function () {
			that.buildAccordionActions(jQuery(this), 'change');
		});
	}
};

beckend.prototype.buildAccordionActions = function (currentRadioButton, event) {

	if(event == 'change') {
		jQuery('.js-radio-accordion').css({'display': 'none'});
	}

	var value = currentRadioButton.val();
	var toggleContent = jQuery('.js-accordion-'+value);

	if(currentRadioButton.is(':checked')) {
		currentRadioButton.after(toggleContent.css({'display':'inline-block'}));
	}
	else {
		toggleContent.css({'display': 'none'});
	}
};

beckend.prototype.addCountris = function() {
	var countyNames = [];
	var countryIsos = [];
	function addCountry(name,iso) {
		countyNames.push(name);
		countryIsos.push(iso);
		jQuery("#countryIso").val(countryIsos.join(','));
		jQuery('#countryName').tagsinput('add', countyNames.join(','));
	}
	jQuery(".addCountry").bind('click',function(){
		optionCountryName = jQuery(".optionsCountry option:selected").text();
		optionCountryIso = jQuery(".optionsCountry option:selected").val();
		addCountry(optionCountryName,optionCountryIso);
	});
	jQuery('input').on('itemRemoved', function(event) {
		var removeCountryName = event.item;
		countryNameIso = countyNames.indexOf(removeCountryName);
		countryIsos.splice(countryNameIso,1);
		countyNames.splice(countryNameIso,1);
		jQuery("#countryIso").val(countryIsos.join(','));
	});

	if(typeof popupCountries != "undefined" && typeof popupCountries != "undefined"){
		alpCountryNameArray = popupCountries.alpCountryName.split(",");
		alpCountryIsoArray = popupCountries.alpCountryIso.split(",");
		for(i=0; i <= alpCountryIsoArray.length; i++) {
			addCountry(alpCountryNameArray[i],alpCountryIsoArray[i]);
		}
	};
}

beckend.prototype.showCloseTextFieldForTheme = function() {	
	var that = this;
	jQuery("[name='theme']").each(function() {
		if(jQuery(this).prop("checked")) {
			that.alpAllowCustomizedThemes(jQuery(this));
		}
	});
	
	jQuery("[name='theme']").bind("change", function() {
		that.alpAllowCustomizedThemes(jQuery(this))
	});

};

beckend.prototype.alpAllowCustomizedThemes = function(cureentRadioButton) {
	var customizedThemes = ['2','3','4'];
	var themeNumber = cureentRadioButton.attr("alppoupnumber");
	var isInCustomThemes = customizedThemes.indexOf(themeNumber);
	jQuery(".themes-suboptions").addClass("alp-hide");
	if(isInCustomThemes != -1) {

		if(cureentRadioButton.prop( "checked" )) {
			jQuery(".alp-popup-theme-"+themeNumber).removeClass("alp-hide");
		}
		else {
			jQuery(".alp-popup-theme-"+themeNumber).addClass("alp-hide");
		}
	}
};

// beckend.prototype.showCloseTextFieldForTheme = function() {
	
// 	var that = this;
// 	this.alpAllowChangeButtonText();
// 	jQuery("[name='theme']").bind("change", function() {
// 		that.alpAllowChangeButtonText()
// 	});
// }
// beckend.prototype.alpAllowChangeButtonText = function() {

// 	if(jQuery("[alppoupnumber='4'][name='theme']").prop( "checked" )) {
// 		jQuery(".theme-colse-text").removeClass("alp-hide");
// 	}
// 	else {
// 		jQuery(".theme-colse-text").addClass("alp-hide");
// 	}
// }

beckend.prototype.popupTimer = function() {

	var startTimerOptions = {
		dateFormat : 'M dd yy',
		minDate: 0
	}
	var finishTimerOptions = {
		dateFormat : 'M dd yy',
		minDate: 1
	}

	if(jQuery('.popup-start-timer').length == 0) return; /*  for escape javascript erros if element does not exist */

	var startCalendar = jQuery('.popup-start-timer').datepicker(startTimerOptions);
	var finishCalendar = jQuery('.popup-finish-timer').datepicker(finishTimerOptions);

	startCalendar.change(function() {

		finishCalendar.datepicker( "destroy" ); /* for possibility change datapicker date */
		var startDate = jQuery(this).datepicker( 'getDate' );
		var startTimerDay = startDate.getUTCDate()+1;
		var finish = new Date(startDate);
		var finishData = startDate.setDate(startDate.getDate()+1);
		finishData = new Date(finishData);

		var finishChangedOptions = {
			dateFormat : 'M dd yy',
			minDate: finishData
		}
		
		jQuery('.popup-finish-timer').datepicker(finishChangedOptions);
	});
}


beckend.prototype.updateQueryStringParameterpopup = function (uri, key, value) {
	var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
	var separator = uri.indexOf('?') !== -1 ? "&" : "?";
	if (uri.match(re)) {
		return uri.replace(re, '$1' + key + "=" + value + '$2');
	}
	else {
		return uri + separator + key + "=" + value;
	}
};

beckend.prototype.popupPreview = function () {
	var that = this;
	jQuery('.alp-popup-preview').bind('click', function (e) {
		e.preventDefault();
		var previewButton = jQuery(this);
		/*checking if it's not null*/
		if(typeof tinymce != 'undefined' && !!tinymce.activeEditor) {
			jQuery("[name='"+tinymce.activeEditor.id+"']").html(tinymce.activeEditor.getContent());
		}

		var data = {
			action: 'save_popup_preview_data',
			ajaxNonce: backendLocalizedData.ajaxNonce,
			beforeSend: function () {
				previewButton.prop('disabled', true);
				previewButton.val('loading');
			},
			popupDta: jQuery("#add-form").serialize()
		};
		var newWindow = window.open('');
		jQuery.post(ajaxurl, data, function(response,d) {
			var popupId = parseInt(response);
			if(isNaN(popupId)) {
				console.log("it's not number");
				return;
			}
			previewButton.prop('disabled', false);
			previewButton.val('Preview');
			var pageUrl  = previewButton.attr('data-page-url');
			var redirectUrl = that.updateQueryStringParameterpopup(pageUrl, 'alp_popup_preview_id', popupId);
			newWindow.location = redirectUrl;
		});
	})
};

jQuery(document).ready(function($){
   var alpBeckeendObj = new  beckend();
	alpBeckeendObj.alpInit();
});