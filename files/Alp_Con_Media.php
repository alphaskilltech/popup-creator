<?php
function AlpConPopupMediaButton()
{
	global $pagenow, $typenow;

	$showCurrentUser = ALPFunctions::ShowMenuForCurrentUser();
	if(!$showCurrentUser) {return;}
	$buttonTitle = 'Insert popup';
	$output = '';

	$pages = array(
		'post.php',
		'page.php',
		'post-new.php',
		'post-edit.php',
		'widgets.php'
	);


	/* For show in plugins page when package is pro */
    if (ALP_CON_POPUP_PKG !== ALP_CON_POPUP_PKG_FREE) {
		array_push($pages, "admin.php");
	}

	$checkPage = in_array(
		$pagenow,
		$pages
	);

	if ($checkPage && $typenow != 'download') {

		wp_enqueue_script('jquery-ui-dialog');
		wp_register_style('alp_jQuery_ui', ALP_CON_POPUP_URL . "/style/Alp_Con_Jqurey_Ui.css");
		wp_enqueue_style('alp_jQuery_ui');
		$img = '<span class="dashicons dashicons-welcome-widgets-menus" id="alp-popup-media-button" style="padding: 3px 2px 0px 0px"></span>';
		$output = '<a href="javascript:void(0);" onclick="jQuery(\'#alpcon-thickbox\').dialog({ width: 450, modal: true, title: \'Insert the shortcode\', dialogClass: \'alp-popup-builder\' });"  class="button" title="'.$buttonTitle.'" style="padding-left: .4em;">'. $img.$buttonTitle.'</a>';
	}
	echo $output;
}

add_action('media_button', 'AlpConPopupMediaButton', 11);

function alpconPopupVariable()
{
	$showCurrentUser = ALPFunctions::ShowMenuForCurrentUser();
	if (!$showCurrentUser) {
		return;
	}

	$buttonTitle = 'Insert custom JS variable';
	$output = '';

	require_once(ABSPATH .'wp-admin/includes/screen.php');
	$currentScreen = get_current_screen();
	$currentPageParams = @get_object_vars($currentScreen);

	if ($currentPageParams['id'] != 'popup-up-creator_page_popup-edit') {
		return '';
	}
	wp_enqueue_script('jquery-ui-dialog-box');
	wp_register_style('alp_jQuery_ui', ALP_CON_POPUP_URL . "/style/Alp_Con_Jqurey_Ui.css");
	wp_enqueue_style('alp_jQuery_ui');

	$img = '<span class="dashicons dashicons-welcome-widgets-menus" id="alp-popup-js-variable" style="padding: 3px 2px 0px 0px"></span>';
	$output = '<a href="javascript:void(0);" onclick="jQuery(\'#alpcon-js-variable-thickbox\').dialog({ width: 500, modal: true, title: \'Insert JS variable\', dialogClass: \'alp-popup-builder\' });"  class="button" title="'.$buttonTitle.'" style="padding-left: .4em;">'. $img.$buttonTitle.'</a>';

	echo $output;
	return '';
}

add_action('media_button', 'alpconPopupVariable', 11);

function alpJsVariableThickbox() {

	require_once(ABSPATH .'wp-admin/includes/screen.php');
	$currentScreen = get_current_screen();
	$currentPageParams = get_object_vars($currentScreen);

	if($currentPageParams['id'] != 'popup-up-creator_page_popup-edit') {
		return '';
	}
	?>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('#alpcon-insert-variable').on('click', function (e) {
				var jsVariableSelector = jQuery('.alpcon-js-variable-selector').val();
				var jsVariableAttribute = jQuery('.alpcon-js-variable-attribute').val();

				if (jsVariableSelector == '' || jsVariableAttribute == '') {
					alert('Please, fill in all the fields.');
					return;
				}
				window.send_to_editor('[pbvariable selector="' + jsVariableSelector + '" attribute="'+jsVariableAttribute+'"]');
				jQuery('#alpcon-js-variable-thickbox').dialog('close')
			});
		});
	</script>
	<div id="alpcon-js-variable-thickbox" style="display: none;">
		<div class="wrap">
			<p>Insert JS variable inside the popup.</p>
			<div>
				<div style="margin-bottom: 5px;">
					<span>Selector</span>
					<input type="text" class="alpcon-js-variable-selector">
					<span>Ex. #myselector or .myselector</span>
				</div>
				<div>
					<span>Attribute</span>
					<input type="text" class="alpcon-js-variable-attribute">
					<span>Ex. value or data-name</span>
				</div>
			</div>
			<p class="submit">
				<input type="button" id="alpcon-insert-variable" class="button-primary dashicons-welcome-widgets-menus" value="Insert"/>
				<a id="alpcon-cancel" class="button-secondary" onclick="jQuery('#alpcon-js-variable-thickbox').dialog( 'close' )" title="Cancel">Cancel</a>
			</p>
		</div>
	</div>
	<?php
}

function AlpConPopupMediaButtonThickboxs()
{
	global $pagenow, $typenow;
	require_once(ABSPATH .'wp-admin/includes/screen.php');
	$currentScreen = get_current_screen();
	$currentPageParams = get_object_vars($currentScreen);

	$showCurrentUser = ALPFunctions::ShowMenuForCurrentUser();
	if(!$showCurrentUser) {return;}

	$pages = array(
		'post.php',
		'page.php',
		'post-new.php',
		'post-edit.php',
		'widgets.php'
	);

    if (ALP_CON_POPUP_PKG !== ALP_CON_POPUP_PKG_FREE) {
		array_push($pages, "admin.php");
	}

	$checkPage = in_array(
		$pagenow,
		$pages
	);


	if ($checkPage && $typenow != 'download') :
		$orderBy = 'id DESC';
		$allPopups = ALPCONPopup::findAll($orderBy);
		$popupPreviewId = get_option('popupPreviewId');
		?>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {

				$('#alp-ptp-popup-insert').on('click', function () {
					var id = $('#alp-insert-popup-id').val();
					if ('' === id) {
						alert('Select your popup');
						return;
					}
					var appearEvent = jQuery("#openEvent").val();

					var selectionText = '';
					if (typeof(tinyMCE.editors.content) != "undefined") {
						selectionText = (tinyMCE.activeEditor.selection.getContent()) ? tinyMCE.activeEditor.selection.getContent() : '';
					}
					/* For plugin editor selected text */
					else if(typeof(tinyMCE.editors[0]) != "undefined") {
						var pluginEditorId = tinyMCE.editors[0]['id'];
						selectionText = (tinyMCE['editors'][pluginEditorId].selection.getContent()) ? tinyMCE['editors'][pluginEditorId].selection.getContent() : '';
					}
					if(appearEvent == 'onload') {
						selectionText = '';
					}
					<?php if( $currentPageParams['id'] == 'popup-up-creator_page_popup-edit'){ ?>
					window.send_to_editor('[alp_popup id="' + id + '" insidePopup="on"]'+selectionText+"[/alp_popup]");
					<?php }
					else { ?>
						window.send_to_editor('[alp_popup id="' + id + '" event="'+appearEvent+'"]'+selectionText+"[/alp_popup]");
					<?php } ?>
					jQuery('#alpcon-thickbox').dialog( "close" );
				});
			});
		</script>

		<div id="alpcon-thickbox" style="display: none;">
			<div class="wrap">
				<p>Insert the shortcode for showing a Popup.</p>
				<div>
					<div class="alp-select-popup">
						<span>Select Popup</span>
						<select id="alp-insert-popup-id" style="margin-bottom: 5px;">
							<option value="">Please select...</option>
							<?php
								foreach ($allPopups as $popup) :

									if(empty($popup)) {
										continue;
									}
									$popupId = (int)$popup->getId();
									$popupType = $popup->getType();
									$popupTitle = $popup->getTitle();

									if(empty($popupId) || empty($popupType) || $popupId == $popupPreviewId) {
										continue;
									}

									/*Inside popup*/
									if((isset($_GET['id']) && $popupId == (int)@$_GET['id'] || $popupType == 'exitIntent') && $currentPageParams['id'] == 'popup-up-creator_page_popup-edit') {
										continue;
									}
								?>
									<option value="<?php echo $popupId; ?>"><?php echo $popupTitle;?><?php echo " - ".$popupType;?></option>;
								<?php endforeach; ?>
						</select>
					</div>
					<?php /* Becouse in popup content must be have only click */
					   		if($pagenow !== 'admin.php'): ?>
					<div class="alp-select-popup">
						<span>Select Event</span>
						<select id="openEvent">
							<option value="onload">On load</option>
							<option value="click">Click</option>
							<option value="hover">Hover</option>
						</select>
					</div>
				<?php endif;?>
				</div>
				<p class="submit">
					<input type="button" id="alp-ptp-popup-insert" class="button-primary dashicons-welcome-widgets-menus" value="Insert"/>
					<a id="alp_popup_cancel" class="button-secondary" onclick="jQuery('#alpcon-thickbox').dialog( 'close' )" title="Cancel">Cancel</a>
				</p>
			</div>
		</div>
	<?php endif;
}

add_action('admin_footer', 'AlpConPopupMediaButtonThickboxs');
add_action('admin_footer', 'alpJsVariableThickbox');