<?php
abstract class ALPCONPopup {
	protected $id;
	protected $type;
	protected $title;
	protected $width;
	protected $height;
	protected $delay;
	protected $options;
	public static $registeredScripts = false;

	public function setType($type){
		$this->type = $type;
	}
	public function getType() {
		return $this->type;
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function getTitle() {
		return $this->title;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setWidth($width){
		$this->width = $width;
	}
	public function getWidth() {
		return $this->width;
	}
	public function setHeight($height){
		$this->height = $height;
	}
	public function getHeight() {
		return $this->height;
	}
	public function setDelay($delay){
		$this->delay = $delay;
	}
	public function getDelay() {
		return $this->delay;
	}
	public function setOptions($options) {
		$this->options = $options;
	}
	public function getOptions() {
		return $this->options;
	}
	public static function findById($id) {

		global $wpdb;
		$st = $wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."alp_con_popup WHERE id = %d",$id);
		$arr = $wpdb->get_row($st,ARRAY_A);
		if(!$arr) return false;
		return self::alp_popupObjectFromArray($arr);

	}

	abstract protected function alp_setCustomOptions($id);

	abstract protected function alp_getExtraRenderOptions();

	private static function alp_popupObjectFromArray($arr, $obj = null) {

		$jsonData = json_decode($arr['options'], true);

		$type = alpSafeStr($arr['type']);

		if ($obj===null) {
			$className = "Alp_Con_".ucfirst(strtolower($type)).'_Popup';
			require_once(dirname(__FILE__).'/'.$className.'.php');
			$obj = new $className();
		}

		

		$obj->setType(alpSafeStr($type));
		$obj->setTitle(alpSafeStr($arr['title']));
		if (@$arr['id']) $obj->setId($arr['id']);
		$obj->setWidth(alpSafeStr(@$jsonData['width']));
		$obj->setHeight(alpSafeStr(@$jsonData['height']));
		$obj->setDelay(alpSafeStr(@$jsonData['delay']));
		$obj->setOptions(alpSafeStr($arr['options']));

		if (@$arr['id']) $obj->alp_setCustomOptions($arr['id']);

		return $obj;
	}

	public static function create($data, $obj)
	{
		self::alp_popupObjectFromArray($data, $obj);
		return $obj->save();
	}
	public function save($data = array()) {

		$id = $this->getId();
		$type = $this->getType();
		$title = $this->getTitle();
		$options = $this->getOptions();

		global $wpdb;

		if($id  == '') {
				$sql = $wpdb->prepare( "INSERT INTO ". $wpdb->prefix ."alp_con_popup(type,title,options) VALUES (%s,%s,%s)",$type,$title,$options);
				$res = $wpdb->query($sql);


			if ($res) {
				$id = $wpdb->insert_id;
				$this->setId($id);
			}
			return $res;

		}
		else {
			$sql = $wpdb->prepare("UPDATE ". $wpdb->prefix ."alp_con_popup SET type=%s,title=%s,options=%s WHERE id=%d",$type,$title,$options,$id);
			$res = $wpdb->query($sql);
			if(!$wpdb->show_errors()) {
				$res = 1;
			}

			return $res;
		}
	}
	public static function findAll($orderBy = null, $limit = null, $offset = null) {

		global $wpdb;

		$query = "SELECT * FROM ". $wpdb->prefix ."alp_con_popup";

		if ($orderBy) {
			$query .= " ORDER BY ".$orderBy;
		}

		if ($limit) {
			$query .= " LIMIT ".intval($offset).','.intval($limit);
		}

		//$st = $wpdb->prepare($query, array());
		$popups = $wpdb->get_results($query, ARRAY_A);

		$arr = array();
		foreach ($popups as $popup) {
			$arr[] = self::alp_popupObjectFromArray($popup);
		}

		return $arr;
	}
	public static function delete($id) {
			$pop = self::findById($id);
			$type =  $pop->getType();
			$table = 'alp_con_'.$type.'_popup';
			

			global $wpdb;
			$wpdb->query(
				$wpdb->prepare(
					"DELETE FROM ". $wpdb->prefix ."$table WHERE id = %d"
					,$id
				)
			);
			$wpdb->query(
				$wpdb->prepare(
					"DELETE FROM ". $wpdb->prefix ."alp_con_popup WHERE id = %d"
					,$id
				)
			);

			$wpdb->query(
				$wpdb->prepare(
					"DELETE FROM ". $wpdb->prefix ."postmeta WHERE meta_value = %d and meta_key = 'wp_alp_con_popup'"
					,$id
				)
			);
	}

	public static function setPopupForPost($post_id, $popupId) {
		update_post_meta($post_id, 'wp_alp_con_popup' , $popupId);
	}

	public function getRemoveOptions() {
		return array();
	}

	public function improveContent($content) {
		if(ALP_CON_POPUP_PRO) {
			require_once(ALP_CON_POPUP_FILES ."/Alp_Con_Popup_Pro.php");
			return ALPCONPopupPro::alpPopupExtraSanitize($content);
		}
		return $content;
	}



	private function addPopupStyles() {
		$styles = '';
		$popupId = $this->getId();
		$options = $this->getOptions();
		$options = json_decode($options, true);
		$contentPadding = 0;
		if(empty($options)) {
			return '';
		}

		/*When popup z index does not exist we give to z - index max value*/
		if(empty($options['popup-z-index'])) {
			$popupZIndex = '2147483647';
		}
		else {
			$popupZIndex = $options['popup-z-index'];
		}
		
		if(!empty($options['popup-content-padding'])) {
			$contentPadding = $options['popup-content-padding'];
		}

		$styles .= '<style type="text/css">';

		$styles .= '.alp-popup-overlay-'.$popupId.',
					.alp-popup-content-'.$popupId.'
					 {
						z-index: '.$popupZIndex.' !important;
					 }
				   #alp-popup-content-wrapper-'.$popupId.'
				     {
			       padding: '.$contentPadding.'px !important;
		              }';

		/* if popup close button has delay,hide it */
		if (@$options['closeButton'] && @$options['buttonDelayValue']) {
			$styles .= '#alpcboxClose {
				display: none !important;
			}';
		}

		$styles .= '</style>';

		echo $styles;
	}



	public function render() {
		$popupId = $this->getId();
		$this->addPopupStyles();
		$parentOption = array('id'=>$this->getId(),'title'=>$this->getTitle(),'type'=>$this->getType(),'width',$this->getWidth(),'height'=>$this->getHeight(),'delay'=>$this->getDelay());
		$getexrArray = $this->alp_getExtraRenderOptions();
		$options = json_decode($this->getOptions(),true);
		if(empty($options)) $options = array();
		$alpPopupVars = 'ALP_POPUP_DATA['.$this->getId().'] ='.json_encode(array_merge($parentOption, $options, $getexrArray)).';';

		return $alpPopupVars;
	}
	public static function getTotalRowCount() {
		global $wpdb;
		$res =  $wpdb->get_var( "SELECT COUNT(id) FROM ". $wpdb->prefix ."alp_con_popup" );
		return $res;
	}
	public static function getPagePopupId($page,$popup) {
		global $wpdb;
		$sql = $wpdb->prepare("SELECT meta_value FROM ". $wpdb->prefix ."postmeta WHERE post_id = %d AND meta_key = %s",$page,$popup);
		$row = $wpdb->get_row($sql);
		$id = 0;
		if($row) {
			$id =  (int)@$row->meta_value;
		}
		return $id;
	}



	public static function addPopupForAllPages($id = '', $selectedData = '', $type) {

		global $wpdb;

		$insertPreapre = array();
		$insertQuery = "INSERT INTO ". $wpdb->prefix ."alp_popup_in_pages(popupId, pageId, type) VALUES ";

		foreach ($selectedData as $value) {
			$insertPreapre[] .= $wpdb->prepare( "(%d,%d,%s)", $id, $value, $type);
		}
		$insertQuery .= implode( ",\n", $insertPreapre );
		$wpdb->query($insertQuery);
	}

	public static function removePopupFromPages($popupId, $type)
	{
		global $wpdb;
		/*Remove all pages and posts from the array*/
		self::removeFromAllPages($popupId);
		$query = $wpdb->prepare('DELETE FROM '.$wpdb->prefix.'alp_popup_in_pages WHERE popupId = %d and type=%s', $popupId, $type);
		$wpdb->query($query);
	}

	public static function removeFromAllPages($id) {
		$allPages = get_option("ALP_CON_ALL_PAGES");
		$allPosts = get_option("ALP_CON_ALL_POSTS");

		if(is_array($allPages)) {
			$key = array_search($id, $allPages);
		
			if ($key !== false) {
				unset($allPages[$key]);
			}
			update_option("ALP_CON_ALL_PAGES", $allPages);
		}
		if(is_array($allPosts)) {
			$key = array_search($id, $allPosts);
		
			if ($key !== false) {
				unset($allPosts[$key]);
			}
			update_option("ALP_CON_ALL_POSTS", $allPosts);
		}

	}

	public static function deleteAllPagesPopup($selectedPages) {
		global $wpdb;

		$deletePrepare = array();
		$deleteQuery = "DELETE FROM ". $wpdb->prefix ."alp_popup_in_pages WHERE pageId IN (";

		foreach ($selectedPages as $value) {
			$deletePrepare[] .= $wpdb->prepare("%d", $value );
		}

		$deleteQuery .= implode( ",\n", $deletePrepare ).")";

		$deleteRes = $wpdb->query($deleteQuery);
	}

	public static function findInAllSelectedPages($pageId, $type) {
		global $wpdb;

		$st = $wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."alp_popup_in_pages WHERE pageId = %d and type=%s", $pageId, $type);
		$arr = $wpdb->get_results($st, ARRAY_A);
		if(!$arr) return false;
		return $arr;
	}


	public function alpAddPopupContentToFooter($content, $popupId) {

		add_action('wp_footer', function() use ($content, $popupId){
			$content = apply_filters('alp_popup_content', $content, $popupId);
			if(empty($content)) {
				$content = '';
			}
			$popupContent = "<div style=\"display:none\"><div id=\"alp-popup-content-wrapper-$popupId\">$content</div></div>";
			echo $popupContent;
		}, 1);
	}

}

function alpSafeStr ($param) {
	return ($param===null?'':$param);
}