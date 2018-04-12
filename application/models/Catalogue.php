<?php
//category bán
class Catalogue extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = ITEM_CLASSIFICATION_REGISTER;
		$this->idCol = ICR_EVENT_CATEGORY;
	}
}