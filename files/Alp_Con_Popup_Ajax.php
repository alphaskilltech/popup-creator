<?php
function alpSanitizeAjaxField($optionValue,  $isTextField = false) {
	/*TODO: Extend function for other sanitization and validation actions*/
	if(!$isTextField) {
	//	return sanitize_text_field($optionValue);
	}
}
function alpPopupDelete()
{
	check_ajax_referer('AlpConPopupBuilderDeleteNonce', 'ajaxNonce');
	$id = (int)@$_POST['popup_id'];
	if (!$id) {
		return;
	}
	require_once(ALP_CON_POPUP_CLASS.'/Alp_Con_Popup.php');
	ALPCONPopup::deletes($id);
	//ALPCONPopup::removePopupFromPages($id);

	$args = array('popupId'=> $id);
	do_action('alpPopupDelete', $args);
}

add_action('wp_ajax_delete_popup', 'alpPopupDelete');


function alpCloseReviewPanel()
{
	check_ajax_referer('alpPopupCreatorReview', 'ajaxNonce');
    update_option('ALP_CON_COLOSE_REVIEW_BLOCK', true);
}
add_action('wp_ajax_close_review_panel', 'alpCloseReviewPanel');

function alpChangePopupStatus() {
	check_ajax_referer('AlpConPopupCreatoreDeactivateNonce', 'ajaxNonce');
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