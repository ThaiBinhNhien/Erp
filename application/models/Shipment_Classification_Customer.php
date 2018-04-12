<?php

class Shipment_Classification_Customer extends VV_Model
{ 
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DELIVERYCLASSIFICATION_CUSTOMER;
    }
    public function getAvaiable(){
		$this->db->select(DELIVERYCLASSIFICATION_CUSTOMER.".*");
		$this->db->join(DELIVERY_CLASSIFICATION,"`".DELIVERY_CLASSIFICATION."`.`".DC_ID."`=".DELIVERYCLASSIFICATION_CUSTOMER.".".DCC_DELIVERY_CLASSIFICATION);
		return $this->db->get(DELIVERYCLASSIFICATION_CUSTOMER)->result_array();
	}
}