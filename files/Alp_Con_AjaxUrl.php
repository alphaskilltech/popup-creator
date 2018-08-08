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


