<?php

class Supplier_Category extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_SUPPLIER_CLASSIFICATION;
		$this->idCol = TSC_ID;
		 
	}

	
	public function search_category($data , $start_index = NULL,$number = NULL,$supplier_by =NULL ,$supplier_type = NULL)
	{
		$this->db->select('s.'.TSC_ID .' as id, s.'. TSC_NAME . ' as name');
		$this->db->from(T_SUPPLIER_CLASSIFICATION .' as s');
		
		if(!empty($data['cat_id'])) $this->db->where(TSC_ID,$data['cat_id']);
		if(!empty($data['cat_name'])) $this->db->like(TSC_NAME,$data['cat_name'], 'both');
		if($supplier_by != NULL && $supplier_type != NULL){
			$this->db->order_by($supplier_by, $supplier_type);
		}

		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index );
		}
		
		$supplier = $this->db->get();
		return $supplier->result();
	}

}