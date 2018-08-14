<?php

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

require_once(dirname(__FILE__)."/config.php");
require_once(ALP_CON_POPUP_CLASS .'/Alp_Con_Installer.php'); //cretae tables
require_once(ALP_CON_POPUP_FILES .'/Alp_Con_Functions.php');


// if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
// 	require_once( ALP_CON_POPUP_CLASS .'/PopupProInstaller.php'); //uninstall tables
// }

$deleteStatus = ALPFunctions::popupTablesDeleteSatus();

if($deleteStatus) {
	Alp_Con_Installer::uninstall();
	if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
		Alp_Con_Installer::uninstall();
	}
}