<?php

class Processing_Content extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		 
	}

	public function get_all(){
		$product = $this->db->get(T_PROCESSING_CONTENT);
		return $product->result();
	}

	public function get_with_warehouse()
	{
		$this->db->where(PC_SHIPMENT_CATEGORY.">",0);
		$this->db->where(PC_ID.' !=',6);
		$processing = $this->db->get(T_PROCESSING_CONTENT);
		return $processing->result();
	}

	public function get_with_order_purchase()
	{
		$this->db->where(PC_ORDER_CLASSIFICATION.'>',0);
		$processing = $this->db->get(T_PROCESSING_CONTENT);
		return $processing->result();
	}

	public function get_by_id($id)
	{
		$this->db->where(PC_ID,$id);
		$processing = $this->db->get(T_PROCESSING_CONTENT);
		if(empty($processing->result())) return null;
		return $processing->result()[0];
	}
}