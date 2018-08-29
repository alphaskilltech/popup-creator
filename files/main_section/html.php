<div class="alp-wp-editor-container">
<?php
	 $contents = @$alpPopupDataHtml;
	 $editor_id = 'alp_popup_html';
	 $settingsdata = array(
		'wpautop' => false,
		'tinymce' => array(
			'width' => '100%'
		),
		'textarea_rows' => '6',
		'media_buttons' => true
	);

	wp_editor($contents, $editor_id, $settingsdata);
?>
</div>