<?php

require_once(dirname(__FILE__).'/Table.php');

class Alp_Con_Popups extends  Alp_Con_Table
{
	public function __construct()
	{
		global $wpdb;
		parent::__construct('');

		$this->setRowsPerPage(ALP_CON_POPUP_TABLE_LIMIT);
		$this->setTablename($wpdb->prefix.'alp_con_popup');
		$this->setColumns(array(
			'id',			
			'title',
			'type'
			
		));
		$this->setDisplayColumns(array(
			'id' => 'ID',
			//'onOff' => 'Activate',
			'title' => 'Title',
			'type' => 'Type',
			'shortcode' => 'Shortcode',
			'options' => 'Options'
		));
		$this->setSortableColumns(array(
			'id' => array('id', false),
			'title' => array('title', true),
			$this->setInitialSort(array(
	           'id' => 'DESC'
	       ))
		));
	}
 
	public function customizeRow(&$row)
	{
        $id = $row[0];
		$ajax_Nonce = wp_create_nonce("AlpConPopupCreatoreDeactivateNonce");
		$isActivePopupCreator = AlpConPopupGetData::isActivePopupCreator($id);
		//$switchButton = '<label class="switch">
	//	<input class="switch-checkbox" data-switch-id="'. $id .'" data-checkbox-ajax_Nonce ="'. $ajax_Nonce .'"  type="checkbox" '.$isActivePopupCreator.' /><span class="slider round"></span></label>';
        $type = $row[2];
       	$editUrl = admin_url()."admin.php?page=popup-edit&id=".$id."&type=".$type."";
		$row[3] = "<input type='text' onfocus='this.select();' readonly value='[alp_con_popup id=".$id."]' class='large-text-code'>";		
		$ajax_Nonce = wp_create_nonce("AlpConPopupBuilderDeleteNonce");
		$row[4] = '<span><a href="'.@$editUrl.'" class="Edit_Color">'.__('Edit', 'alppc').'&nbsp;<i class="far fa-edit fa-1x"></i></a>&nbsp;&nbsp;<a href="#" data-alp-popup-id="'.$id.'" data-ajax_Nonce="'.$ajax_Nonce.'" class="alp-js-delete-link Delete_Color">'.__('Delete', 'alppc').'&nbsp;<i class="far fa-trash-alt fa-1x" aria-hidden="true"></i></a>';
		
		//array_splice( $row, 1, 0, $switchButton); 
	}
 }