<?php
/**
* 
*/
class Product_Base extends VV_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCT_BASE;
		$this->idCol = BB_ID;
	}

	public function get_by_base_and_customer($data)
	{
		$this->db->select('*');
		$this->db->from(PRODUCT_BASE);
		$this->db->join(PRODUCT_LEDGER,PRODUCT_BASE.'.`'.BB_PRODUCT_CODE.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`','left');
		$this->db->where(PRODUCT_BASE.'.`'.BB_BASE_CODE.'`',$data['base_id']);
		$this->db->where(PRODUCT_BASE.'.`'.BB_CUSTOMER_NUMBER.'`',$data['customer_id']);
		$product_list = $this->db->get();
		return $product_list->result();
	}

}