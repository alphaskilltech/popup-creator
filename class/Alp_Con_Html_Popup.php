<?php
require_once(dirname(__FILE__).'/Alp_Con_Popup.php');

class Alp_Con_Html_Popup extends ALPCONPopup {
	public $content;

	public function setContent($content) {
		$this->content = $content;
	}
	public function getContent() {
		return $this->content;
	}
	public static function create($data, $obj = null) {
		$obj = new self();
		
		$obj->setContent($data['html']);

		return parent::create($data, $obj);
	}
	public function save($data = array()) {

		$editMode = $this->getId()?true:false;
		
		$res = parent::save($data);
		if ($res===false) return false;
	
	 $alpHtmlPopup = $this->getContent();

		global $wpdb;
		if ($editMode) {
			$alpHtmlPopup = stripslashes($alpHtmlPopup);
			$sql = $wpdb->prepare("UPDATE ". $wpdb->prefix ."alp_con_html_popup SET content=%s WHERE id=%d",$alpHtmlPopup,$this->getId());	
			$res = $wpdb->query($sql);
		}
		else {

			$sql = $wpdb->prepare( "INSERT INTO ". $wpdb->prefix ."alp_con_html_popup (id, content) VALUES (%d,%s)",$this->getId(),$alpHtmlPopup);	
			$res = $wpdb->query($sql);
		}
		return $res;
	}
	
	protected function alp_setCustomOptions($id) {
		global $wpdb;
		$st = $wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."alp_con_html_popup WHERE id = %d",$id);
		$arr = $wpdb->get_row($st,ARRAY_A);
		$this->setContent($arr['content']);
	}

	protected function alp_getExtraRenderOptions() {
		$content = trim($this->getContent());
		$popupId = (int)$this->getId();
		$this->alpAddPopupContentToFooter($content, $popupId);
		return array('html'=>$this->getContent());
	}

	public  function render() {
		return parent::render();
	}
}