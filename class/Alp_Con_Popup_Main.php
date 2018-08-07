<?php
class AlpConPopupCreatorMain {

	public function init() {

		$this->filters();
		$this->alpconActions();
	}

	public function alpconActions() {
		
		add_action("admin_menu",array($this, "alp_con_AddMenu"));
    }

    public function alp_con_AddMenu() {
	add_menu_page("Popup Creator", "Popup UP Creator", "manage_options","popupcreator",array($this,"alp_con_MainMenu"),"dashicons-screenoptions");
	add_submenu_page("popupcreator", "All Popups", "All Popups", 'manage_options', "popupcreator", array($this,"alp_con_MainMenu"));
	add_submenu_page("popupcreator", "Add New", "Add New", 'manage_options', "popup_create", array($this,"alp_con_CreatePopup"));
	add_submenu_page("popupcreator", "Edit Popup", "Edit Popup", 'manage_options', "popup-edit", array($this,"alp_con_EditPopup"));
	// add_submenu_page("popupcreator", "Edit Popup", "Settings", 'manage_options', "settings-popup", array($this,"alp_con_PopupSettings"));
        // if (ALP_CON_POPUP_PRO) {
        //     add_submenu_page("popupcreator", "Subscribers", "Subscribers", 'manage_options', "subscribers", array($this,"alp_con_Subscribers"));
        // }
   } 
    public function alp_con_MainMenu()
	{
		require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Main.php');
	}

	public function alp_con_CreatePopup()
	{
		require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Create.php'); // here is inculde file in the first sub menu
	}

	public function alp_con_EditPopup()
	{
		require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Create_New.php');
	}

	public function alp_con_Subscribers()
	{
		require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Subscribers.php');
	}

	// public function alp_con_PopupSettings() {

	// 	require_once( ALP_CON_POPUP_FILES . '/Alp_Con_Popup_Settings.php');
	// }
    
    public function filters() {
      
        add_filter('plugin_action_links_'. POPUP_CREATOR_BASENAME, array($this, 'popupPluginActionLink'));
    }

    public function popupPluginActionLink($links) {

        $popupActionLink = array(
            '<a href="' . ALP_CON_POPUP_PRO_URL . '" target="_blank">Pro</a>'
        );
       //if(ALP_CON_POPUP_PKG == ALP_CON_POPUP_PKG_FREE) {
          //  array_push($popupActionLink, '<a href="' . ALP_CON_POPUP_PRO_URL . '" target="_blank">Pro</a>');
       //}        
        return array_merge( $links, $popupActionLink );
    }
}