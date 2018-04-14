<?php

class Shipment_Classification_Base extends VV_Model
{ 
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DELIVERY_BASE;
		$this->idCol = DC_ID;
    }

     public function getAvaiable(){
		$this->db->select(DELIVERY_BASE.".*");
		$this->db->join(DELIVERY_CLASSIFICATION,"`".DELIVERY_CLASSIFICATION."`.`".DC_ID."`=".DELIVERY_BASE.".".DB_DELIVERY_CLASSIFICATION);
		return $this->db->get(DELIVERY_BASE)->result_array();
	}
}