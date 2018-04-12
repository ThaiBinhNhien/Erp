<?php

class Fee_Of_Gaichyu extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = FEE_OF_GAICHYU;
		$this->idCol = FG_ID;
		 
	}

	
	public function search($data , $start_index = NULL,$number = NULL,$by =NULL ,$type = NULL)
	{

		$this->db->select('s.'.FG_ID .' as id, c.'. CUS_CUSTOMER_NAME . ' as gaichyu_customer_name,b.'.BM_BASE_NAME .' as gaichyu_base_name , u.'.U_NAME . ' as contact_user_name, s.'.FG_TONINEN_FEE. ' as tolinen_fee, s.'.FG_ENVIROMENT_FEE . ' enviroment_fee, s.'. FG_LAUNDRY_FEE. ' as laundry_fee, d.'. DL_DEPARTMENT_NAME. ' as department_name' );
		$this->db->from(FEE_OF_GAICHYU .' as s');
		$this->db->join(CUSTOMER . ' as c','s.'.FG_CUSTOMER_ID. ' = c.'.CUS_ID,'left');
		$this->db->join(USER_MASTER . ' as u','s.'.FG_CONTACT_USER_ID. ' = u.'.U_ID,'left');
		$this->db->join(DEPARTMENT_LEDGER . ' as d','s.'.FG_DEPARTMENT_ID. ' = d.'.DL_DEPARTMENT_CODE,'left');
		$this->db->join(BASE_MASTER . ' as b','s.'.FG_GAICHYU_BASE_ID. ' = b.'.BM_BASE_CODE,'left');


		if(!empty($data['gaichyu_customer'])) $this->db->where(FG_CUSTOMER_ID,$data['gaichyu_customer']);
		if(!empty($data['gaichyu_base'])) $this->db->where(FG_GAICHYU_BASE_ID,$data['gaichyu_base']);
		if(!empty($data['gaichyu_user'])) $this->db->where('s.'.FG_CONTACT_USER_ID,$data['gaichyu_user']);
		if(!empty($data['deparment'])) $this->db->where(FG_DEPARTMENT_ID,$data['deparment']);
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