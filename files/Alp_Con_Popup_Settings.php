<?php
$defaultVaules = AlpConPopupGetData::getDefaultValues();
$tableDeleteValue = AlpConPopupGetData::getValue('tables-delete-status','settings');
$usrsSelectedRoles = AlpConPopupGetData::getValue('plugin_users_role', 'settings');
$alpSelectedTimeZone = AlpConPopupGetData::getValue('alp-popup-time-zone','settings');
$tableDeleteSatatus =  AlpConPopupGetData::alpSetChecked($tableDeleteValue);

if (isset($_GET['saved']) && $_GET['saved']==1) {
	echo '<div id="default-message" class="updated notice notice-success is-dismissible" ><p>Popup updated.</p></div>';
}
?>
<div class="crud-wrapper">
<div class="alp-settings-wrapper">
	<div id="special-options">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<div class="postbox popup-builder-special-postbox">
						<div class="handlediv js-special-title" title="Click to toggle"><br></div>
						<h3 class="hndle ui-sortable-handle js-special-title">
							<span>General Settings</span>
						</h3>
						<div class="special-options-content">
							<form method="POST" action="<?php echo ALP_CON_POPUP_ADMIN_URL;?>admin-post.php?action=save_settings" id="alp-settings-form">
								<?php
									if(function_exists('wp_nonce_field')) {
										wp_nonce_field('alpPopupCreatorSettings');
									}
								?>
								<span class="liquid-width">Delete popup data:</span>
								<input type="checkbox" name="tables-delete-status" <?php echo $tableDeleteSatatus;?>>
								<br><span class="liquid-width alp-aligin-with-multiselect">User role who can use plugin:</span>
								<?php echo ALPFunctions::createSelectBox($defaultVaules['usersRoleList'], @$usrsSelectedRoles, array("name"=>"plugin_users_role[]","multiple"=>"multiple","class"=>"alp-selectbox","size"=>count($defaultVaules['usersRoleList']))); ?><br>

								<!-- <input type="text" value="<?php //echo ALP_CON_POPUP_PKG; ?>"> -->

								<?php if(ALP_CON_POPUP_PKG != ALP_CON_POPUP_PKG_FREE) {
									 require_once(ALP_CON_POPUP_FILES ."/alp_params_arrays.php");
								}
								 ?>
									<span class="liquid-width">Popup time zone:</span><?php echo ALPFunctions::createSelectBox($alpTimeZones,@$alpSelectedTimeZone, array('name'=>'alp-popup-time-zone','class'=>'alp-selectbox'))?>
								<?php //}?>
								<div class="setting-submit-wrraper">
									<input type="submit" class="button-primary" value="<?php echo 'Save Changes'; ?>">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
