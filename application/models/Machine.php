<?php

class Machine extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = EQUIPMENT_M;
		$this->idCol = EQ_CODE;
	}

	function getMachineView($id, $name){
		$this->db->select("*,".EQ_NAME." AS name,".EQ_CODE." AS id");
		if($id != NULL && $id != ""){
			$this->db->where(EQ_CODE,$id);
		}
		if($name != NULL && $name != ""){
			$this->db->like(EQ_NAME,$name,'after');
		}
		$this->db->order_by($this->idCol, SORT_MASTER);
		return $this->db->get($this->table_name)->result_array();
	}
}