<?php
/**
* 
*/
class Invoice_Group extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		 
		$this->table_name = INVOICE_GROUP;
		$this->idCol = IG_ID;
	}

	public function get_by_id($id)
	{
		$this->db->where(IG_ID,$id);
		$invoice_group = $this->db->get(INVOICE_GROUP);
		return $invoice_group->result()[0];
	}
	function getInvoiceGroupView($id,$name,$display_name,$address){
		$this->db->select("*,".IG_INVOICE_NAME." AS name,".IG_ID." AS id,".IG_DISPLAY_NAME." AS display_name,".IG_STREET_ADDRESS." AS address,".IG_DISCOUNT." AS discount,".IG_ENVIRONMENTAL_LOAD." AS environment_fee,".IG_FIXED_AMOUNT." AS fixed_amount");
		if($id != NULL && $id != ""){
			$this->db->where(IG_ID,$id);
		}
		if($name != NULL && $name != ""){
			$this->db->like(IG_INVOICE_NAME,$name,'right');
		}
		if($display_name != NULL && $display_name != ""){
			$this->db->like(IG_DISPLAY_NAME,$display_name,'right');
		}
		if($address != NULL && $address != ""){
			$this->db->like(IG_STREET_ADDRESS,$address,'address');
		}
		$this->db->order_by($this->idCol, "DESC");
		return $this->db->get($this->table_name)->result_array();
	}
}