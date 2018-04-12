<?php

class Disposal_Inventory extends VV_Model
{
	
	function __construct() 
	{
		parent::__construct();
		$this->table_name = DISPOSAL_INVENTORY;
		$this->idCol = DI_ID;
		 
	}

	
	public function search($data , $start_index = NULL,$number = NULL,$by =NULL ,$type = NULL)
	{

		$this->db->select('i.'.DI_ID .' as id, i.'. DI_DATE . ' as di_date,p.'.PL_PRODUCT_CODE_SALE .' as idproduct, p.'.PL_PRODUCT_NAME .' as di_product , i.'.DI_DISPOSAL_NUMBER . ' as di_disposal_amount, b.'.BM_BASE_NAME . ' as di_base');
		$this->db->from(DISPOSAL_INVENTORY .' as i');
		$this->db->join(PRODUCT_LEDGER . ' as p','i.`'.DI_PRODUCT. '` = p.'.PL_PRODUCT_ID,'left');
		$this->db->join(BASE_MASTER . ' as b','i.'.DI_BASE_CODE. ' = b.'.BM_BASE_CODE,'left');
		
		if(!empty($data['di_product'])) $this->db->where('i.'. DI_PRODUCT,$data['di_product']);
		if(!empty($data['di_base'])) $this->db->where('i.'.DI_BASE_CODE,$data['di_base']);
		if(!empty($data['di_from_date'])) $this->db->where(DI_DATE. ' >=',$data['di_from_date']);
		if(!empty($data['di_to_date'])) $this->db->where(DI_DATE. ' <=',$data['di_to_date']);
		
		
		if($by != NULL && $type != NULL){
			$this->db->order_by($by, $type);
		}
		
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index );
		}
		
		$supplier = $this->db->get();
 		
		return $supplier->result();
	}


}