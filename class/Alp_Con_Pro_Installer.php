<?php
    // class Alp_Con_Pro_Installer
    // {
    
    //     public static function createTables($blogsId)
    //     {
    //         global $wpdb;
            // update_option('ALP_CON_POPUP_VERSION', ALP_CON_POPUP_VERSION);
            // $alpPopupBaseProPopup = "CREATE TABLE IF NOT EXISTS ". $wpdb->prefix.$blogsId."alp_con_popup_pro (
            //     `id` int(11) NOT NULL AUTO_INCREMENT,
            //     `type` varchar(255) NOT NULL,
            //     `title` varchar(255) NOT NULL,
            //     `options` text NOT NULL,
            //     PRIMARY KEY (id)
            // ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

            //$wpdb->query($alpPopupBaseProPopup);

    //     }
    //     public static function install()
    //     {
    //             $obj = new self();
    //             $obj->createTables("");

    //             if(is_multisite()) {
    //                 $sites = wp_get_sites();
    //                 foreach($sites as $site) {
    //                     $blogsId = $site['blog_id']."_";
    //                     global $wpdb;
    //                     $obj->createTables($blogsId);
    //                 }
    //             }
    //     }
    //      public static function uninstallTables($blogsId)
    //      {
    //          global $wpdb;
    //          $delete = "DELETE FROM ".$wpdb->prefix.$blogsId."postmeta WHERE meta_key = 'alp_promotional_popup' ";
    //          $wpdb->query($delete);
        
    //          $popupTable = $wpdb->prefix.$blogsId."alp_con_popup_pro";
    //          $popupSqlPro = "DROP TABLE ". $popupTable;

    //          $wpdb->query($popupSqlPro);

    //      }

    //       public static function uninstall() 
    //       {
    //          global $wpdb;
    //         $obj = new self();
    //         $obj->uninstallTables("");
    
    //         if(is_multisite()) {
    //          $stites = wp_get_sites();
    //          foreach($stites as $site) {
    //             $blogsId = $site['blog_id']."_";
    //             global $wpdb;
    //             $obj->uninstallTables($blogsId);
    //                 }
    //            }
    //       }
    // }    