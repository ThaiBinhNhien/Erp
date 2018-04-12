<?php

class WashingPowder extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DETERGENT_LEDGER;
		$this->idCol = DEL_CODE;
	}

	function getWashingPowderView($name){ 
		$this->db->select("*,".DEL_NAME." AS name,".DEL_CODE." AS id,".DEL_UNIT_PRICE." AS price");
		if($id != NULL && $id != ""){
			$this->db->where(DEL_CODE,$id);
		}
		if($name != NULL && $name != ""){
			$this->db->like(DEL_NAME,$name,'after');
		}
		
		return $this->db->get($this->table_name)->result_array();
	}

	public function SearchData($id = NULL, $name = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		if($id != NULL && $id != "") {
			$this->db->where(DEL_CODE,$id);
		}
		if($name != NULL && $name != "") {
			$this->db->like(DEL_NAME, $name);
		}
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		} else {
			// Default
			if($this->idCol !== NULL)
				$this->db->order_by($this->idCol, SORT_MASTER);
		}
		
		return $this->db->get($this->table_name)->result_array();
	}
}