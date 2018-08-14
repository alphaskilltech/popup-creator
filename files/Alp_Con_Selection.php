<?php
function alpPopupMeta()
{
	$screens = array('post', 'page');
	foreach ( $screens as $screen ) {
		add_meta_box( 'prfx_meta', __('Select popup on page load', 'prfx-textdomain'), 'alpPopupCallback', $screen, 'normal');
	}
}
add_action('add_meta_boxes', 'alpPopupMeta');

function alpPopupCallback($post)
{
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>
<p class="preview-paragaraph">
<?php
		global $wpdb;
		$proposedTypes = array();
		$orderBy = 'id DESC';
		$proposedTypes = ALPCONPopup::findAll($orderBy);
		function alpCreateSelect($options,$name,$selecteOption) {
			$selected ='';
			$str = "";
			$str .= "<select class=\"choose-popup-type\" name=\"$name\">";
			$str .= "<option value=''>Not selected</potion>";
			foreach($options as $option)
			{
				if ($option) {
					$title = $option->getTitle();
					$type = $option->getType();
					$id = $option->getId();
					if ($selecteOption == $id) {
						$selected = "selected";
					}
					else {
						$selected ='';
					}
					$str .= "<option value='".$id."' disable='".$id."' ".$selected." >$title - $type</potion>";
				}
			}
			$str .="</select>" ;
			return $str;
		}
		global $post;
		$page = (int)$post->ID;
		$popup = "alp_promotional_popup";
		$popupId = ALPCONPopup::getPagePopupId($page,$popup);
		echo alpCreateSelect($proposedTypes,'alp_promotional_popup',$popupId);
		$ALP_CON_POPUP_URL = ALP_CON_POPUP_URL;
?>
	</p>
	<input type="hidden" value="<?php echo $ALP_CON_POPUP_URL;?>" id="ALP_CON_POPUP_URL">
<?php
}

function alpSelectPopupSaved($post_id)
{
	if(empty($_POST['alp_promotional_popup'])) {
		delete_post_meta($post_id, 'alp_promotional_popup');
		return false;
	}
	else {
		update_post_meta($post_id, 'alp_promotional_popup' , $_POST['alp_promotional_popup']);
	}
}
add_action('save_post','alpSelectPopupSaved');