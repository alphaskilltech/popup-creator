<?php
require_once(dirname(__FILE__).'/Alp_Con_Popup.php');

class Alp_Con_Image_Popup extends ALPCONPopup {
	private $url;

	public function setUrl($url) {
		$this->url = $url;
	}
	public function getUrl() {
		return $this->url;
	}
	public static function create($data, $obj = null) {
		$obj = new self();
		
		$obj->setUrl($data['image']);

		parent::create($data, $obj);
	}

	public function save($data = array()) {
		
		$editMode = $this->getId()?true:false;

		$res = parent::save($data);
		if ($res===false) return false;
		
		global $wpdb;
		if ($editMode) {
			$sql = $wpdb->prepare("UPDATE ". $wpdb->prefix ."alp_con_image_popup SET url=%s WHERE id=%d",$this->getUrl(),$this->getId());
			$res = $wpdb->query($sql);
		}
		else {

			$sql = $wpdb->prepare( "INSERT INTO ". $wpdb->prefix ."alp_con_image_popup (id, url) VALUES (%d,%s)",$this->getId(),$this->getUrl());	
			$res = $wpdb->query($sql);
		}
		return $res;
	}

	protected function alp_setCustomOptions($id) {
		global $wpdb;
		$st = $wpdb->prepare("SELECT * FROM ". $wpdb->prefix ."alp_con_image_popup WHERE id = %d",$id);
		$arr = $wpdb->get_row($st,ARRAY_A);
		$this->setUrl($arr['url']);
	}
	protected function alp_getExtraRenderOptions() {
		return array('image'=>$this->getUrl());
	}

	public  function render() {
		return parent::render();
	}
}