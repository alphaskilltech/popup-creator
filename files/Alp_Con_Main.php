<?php
require_once(ALP_CON_POPUP_CLASS.'/AlpDataTable/Alp_Con_Table.php');
	$pagenum = isset($_GET['pn']) ? (int) $_GET['pn'] : 1;
	$limit = ALP_CON_POPUP_TABLE_LIMIT;
	$offset = ($pagenum - 1) * $limit;
	$total = ALPCONPopup::getTotalRowCount();
	$num_of_pages = ceil(esc_html($total) / $limit);
	if ($pagenum>$num_of_pages || $pagenum < 1) {
		$offset = 0;
		$pagenum = 1;
	}
	$orderBy = 'id DESC';
	$entries = ALPCONPopup::findAll($orderBy,$limit,$offset);
<<<<<<< HEAD
=======

	// if(!ALP_CON_SHOW_POPUP_REVIEW) {
	// 	echo ALPFunctions::addReview();
	// }
	// echo ALPFunctions::showReviewPopup();
	// $ajaxNonce = wp_create_nonce("sgPopupBuilderImportNonce");
>>>>>>> done deleted
?>
<div class="wrap">
	<div class="headers-wrapper">
	<h2>Popup List <a href="<?php echo admin_url();?>admin.php?page=popup_create" class="btn btn-primary">Add New</a></h2>
	<?php if(!ALP_CON_POPUP_PRO): ?>
				<input type="button" class="main-update-to-pro btn btn-danger" value="Upgrade to PRO version" onclick="window.open('<?php echo ALP_CON_POPUP_PRO_URL;?>')">
		<?php endif; ?>
	</div>
	<br>
	<?php
	
		$table = new Alp_Con_Popups();
		echo $table;

	$pageLinks = paginate_links(array(
		'base' => add_query_arg('pn', '%#%'),
		'format' => '',
		'prev_text' => __('&laquo;', 'aag'),
		'next_text' => __('&raquo;', 'aag'),
		'total' => $num_of_pages,
		'current' => $pagenum

	));
	if ($pageLinks) {
		echo '<div class="tablenav"><div class="tablenav-pages">' . $pageLinks . '</div></div>';
	}