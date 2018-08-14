<div class="alp-wp-editor-container">
<?php
	$content = @$alpPopupDataHtml;
	$editorId = 'alp_popup_html';
	$settings = array(
		'teeny' => true,
		'tinymce' => array(
			'width' => '100%',
		),
		'textarea_rows' => '6',
		'media_buttons' => true
	);
	wp_editor($content, $editorId, $settings);
?>
</div>