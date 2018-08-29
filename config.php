<?php
 if(!class_exists('AlpPopupCreatorConfig')) {
	class AlpPopupCreatorConfig
	{

		public function __construct()
		{
			$this->init();			
		}

		private function init()
		{

			if (!defined('ABSPATH')) {
				exit();
			}
			     	//create some difine Pats
					define("ALP_CON_POPUP_PATH", dirname(__FILE__));
					define('ALP_CON_POPUP_URL', plugins_url('', __FILE__));
					define('ALP_CON_POPUP_ADMIN_URL', admin_url());
					define('ALP_CON_POPUP_FILE', plugin_basename(__FILE__));
					define('ALP_CON_POPUP_FILES', ALP_CON_POPUP_PATH . '/files');
					define('ALP_CON_POPUP_CLASS', ALP_CON_POPUP_PATH . '/class');
					define('ALP_CON_POPUP_STYLE', ALP_CON_POPUP_PATH . '/style');
					define('ALP_CON_POPUP_IMG', ALP_CON_POPUP_PATH . '/img');
					define('ALP_CON_POPUP_JS', ALP_CON_POPUP_PATH . '/javascript');
					define('ALP_CON_POPUP_TABLE_LIMIT', 20 );
					define('ALP_CON_POPUP_PRO', 1);
					define("ALP_CON_SHOW_POPUP_REVIEW", get_option("ALP_CON_COLOSE_REVIEW_BLOCK"));
					define('ALP_CON_POPUP_VERSION', 1.00);
					define('ALP_CON_POPUP_PRO_VERSION', 1.00);
					define('ALP_CON_POPUP_PRO_URL', 'http://alphaskilltech.com/');

					// define('ALP_CON_FILTER_REPEAT_INTERVAL', 1);
					define('ALP_CON_POST_TYPE_PAGE', 'allPages');
					define('ALP_CON_POST_TYPE_POST', 'allPosts');

					define('ALP_CON_POPUP_PKG_FREE', 2);
					define('ALP_CON_POPUP_PKG_SILVER', 2);
					define('ALP_CON_POPUP_PKG_GOLD', 3);
					define('ALP_CON_POPUP_PKG_PLATINUM', 4);

					global $POPUP_TITLES;
					global $SGPB_INSIDE_POPUPS;
	
					$ALPCON_INSIDE_POPUPS = array();

			$POPUP_TITLES = array(
				'image' => 'Image',
				'html' => 'HTML',
				'contactForm' => 'Contact Form'
			);

			require_once(dirname(__FILE__).'/config-main.php');
		}

		
		public static function popupJsDataInitValues()
		{

			$popupCreatorVersion = ALP_CON_POPUP_VERSION;
			if (ALP_CON_POPUP_PKG > ALP_CON_POPUP_PKG_FREE) {
				$popupCreatorVersion = ALP_CON_POPUP_PRO_VERSION;
			}

			$Stringdata = "<script type='text/javascript'>
							ALP_CON_POPUPS_QUEUE = [];
							ALP_CON_POPUP_DATA = [];
							ALP_CON_POPUP_URL = '" . ALP_CON_POPUP_URL . "';
							ALP_CON_POPUP_VERSION='" . $popupCreatorVersion . "_" . ALP_CON_POPUP_PKG . ";';
							function alpAddEvent(element, eventName, fn) {
								if (element.addEventListener)
									element.addEventListener(eventName, fn, false);
								else if (element.attachEvent)
									element.attachEvent('on' + eventName, fn);
							}
						</script>";

			return $Stringdata;
		}
		public static function getPopupCreatorFrontendScriptLocalizedStoredData()
		{
			$localizedStoredData = array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'ajax_Nonce' => wp_create_nonce('alpPbNonce')
			);

			return $localizedStoredData;
		}
	}
	$popupConf = new AlpPopupCreatorConfig();
 }