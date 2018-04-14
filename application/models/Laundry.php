<?php

class Laundry extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = LAUNDRY_M;
		$this->idCol = LM_CODE;
	}

	function getLaundryView($name){
		$this->db->select("*,".LM_ITEM_NAME_1." AS name,".LM_CODE." AS id");
		if($name != NULL && $name != ""){
			$this->db->like(LM_ITEM_NAME_1,$name,'after');
		}
		
		return $this->db->get($this->table_name)->result_array();
	}
}