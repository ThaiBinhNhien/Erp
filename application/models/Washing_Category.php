<?php

class Washing_Category extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_LAUNDRY_SEGMENT;
		 
		$this->idCol = TLG_ID;
	}

	function getWashingCategoryView($id, $name){
		$this->db->select("*,".TLG_NAME." AS name,".TLG_ID." AS id");
		if($id != NULL && $id != ""){
			$this->db->where(TLG_ID,$id);
		}
		if($name != NULL && $name != ""){
			$this->db->like(TLG_NAME,$name,'after');
		}
		$this->db->order_by($this->idCol, SORT_MASTER);
		return $this->db->get($this->table_name)->result_array();
	}
}