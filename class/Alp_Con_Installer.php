<?php
class Alp_Con_Installer
{
	public static $mainTableName = "alp_con_popup";

	public static function createTables($blogId)
	{
		global $wpdb;
		update_option('ALP_CON_POPUP_VERSION', ALP_CON_POPUP_VERSION);
		
		$alpPopupBase = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix.$blogId."alp_con_popup (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`type` varchar(255) NOT NULL,
			`title` varchar(255) NOT NULL,
			`options` text NOT NULL,
			PRIMARY KEY (id)
		)";
		$alpPopupSettingsBase = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix.$blogId."alp_popup_settings (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`options` LONGTEXT NOT NULL,
			PRIMARY KEY (id)
		)";
		
	  	$optionsDefault = AlpConPopupGetData::getDefaultValues();
		$alpPopupInsertSettingsSql = $wpdb->prepare("INSERT IGNORE ". $wpdb->prefix.$blogId."alp_popup_settings (id, options) VALUES(%d,%s) ", 1, json_encode($optionsDefault['settingsParameters']));
		
		$alpPopupShortcodeBase =  "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix.$blogId."alp_con_shortCode_popup (
			`id` int(12) NOT NULL,
			`url` text NOT NULL
	     )";

		$alpPopupHtmlBase = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix.$blogId."alp_con_html_popup (
				`id` int(11) NOT NULL,
				`content` text NOT NULL
		)";
		$alpPopupContactBase = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix.$blogId."alp_con_contact_popup (
			`id` int(11) NOT NULL,
			`title` text NOT NULL,
			`options`  text NOT NULL,
			PRIMARY KEY (id)
		)";
		


		$wpdb->query($alpPopupBase);
		$wpdb->query($alpPopupShortcodeBase);
		$wpdb->query($alpPopupSettingsBase);
		$wpdb->query($alpPopupInsertSettingsSql);
		$wpdb->query($alpPopupHtmlBase);
		$wpdb->query($alpPopupContactBase);
	}

	public static function install()
	{
		$obj = new self();
		$obj->createTables("");

		if(is_multisite() && get_current_blog_id() == 1 ) {
			global $wp_version;

			if($wp_version >= '1.0.0') {
				$sites = get_sites();
			}else{
				$sites = wp_get_sites();
			}
			
			foreach($sites as $site) {

				if($wp_version > '4.6.0') {
					$blogId = $site->blog_id."_";
				}
				else {
					$blogId = $site['blog_id']."_";
				}
				if($blogId != 1) {
					self::createTables($blogId);
				}			
			}
		}
	}

	public static function uninstallTables($blogId)
	{
		global $wpdb;
		$delete = "DELETE	FROM ".$wpdb->prefix.$blogId."postmeta WHERE meta_key = 'alp_promotional_popup' ";
		$wpdb->query($delete);

		$popupTable = $wpdb->prefix.$blogId."alp_con_popup";
		$popupSql = "DROP TABLE ". $popupTable;

		$popupShortcodeTable = $wpdb->prefix.$blogId."alp_con_shortCode_popup";
		$popupShortcodeSql = "DROP TABLE ". $popupShortcodeTable;

		$popupHtmlTable = $wpdb->prefix.$blogId."alp_con_html_popup";
		$popupHtmlSql = "DROP TABLE ". $popupHtmlTable;

		$popupSettingsDrop = $wpdb->prefix.$blogId."alp_popup_settings";
		$popupSettingsSql = "DROP TABLE ". $popupSettingsDrop;

		$popupContactTable = $wpdb->prefix.$blogId."alp_con_contact_popup";
		$popupContactSql = "DROP TABLE ". $popupContactTable;


		$wpdb->query($popupSql);
		$wpdb->query($popupShortcodeSql);
		$wpdb->query($popupSettingsSql);
		$wpdb->query($popupHtmlSql);
		$wpdb->query($popupContactSql);

	}

	public static function deleteAlpPopupOptions($blogId = '') {

		global $wpdb;
		$deleteALP = "DELETE FROM ".$wpdb->prefix.$blogId."options WHERE option_name LIKE '%ALP_CON_POPUP%'";
		$wpdb->query($deleteALP);
	}


	public static function uninstall() {
		global $wpdb;
		$obj = new self();
		$obj->uninstallTables("");

		if(is_multisite()) {
			$stites = wp_get_sites();
			foreach($stites as $site) {
				$blogsId = $site['blog_id']."_";
				global $wpdb;
				$obj->uninstallTables($blogsId);
			}
		}
	}

	// public static function uninstall() {
	
	// 	$obj = new self();
	// 	self::uninstallTables();
	// 	$obj->deleteAlpPopupOptions();

	// 	if(is_multisite()) {

	// 		global $wp_version;
	// 		if($wp_version >= '1.0.0') {
	// 			$sites = get_sites();
	// 		}
	// 		else {
	// 			$stites = wp_get_sites();
	// 		}

	// 		foreach($sites as $site) {

	// 			if($wp_version >= '1.0.0') {
	// 				$blogId = $site->blog_id."_";
	// 			}
	// 			else {
	// 				$blogId = $site['blog_id']."_";
	// 			}

	// 			self::uninstallTables($blogId);
	// 			$obj->deleteALpPopupOptions($blogId);
	// 		}
	// 	}
	// }
}
