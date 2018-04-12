<?php

class User_Stock_Export extends VV_Model
{
	
	function __construct() 
	{
		parent::__construct();
		$this->table_name = USER_STOCK_EXPORT;
		$this->idCol = UX_ID;
	}

	
	public function search($data , $start_index = NULL,$number = NULL,$by =NULL ,$type = NULL)
	{

		$this->db->select('i.'.UX_ID .' as id, i.'. UX_NAME . ' as ux_name, i.'. UX_NAME1 . ' as ux_name1, b.'.BM_BASE_NAME . ' as ux_base, i.'.UX_REGENCY . ' as ux_regency,
			i.'.UX_ADDRESS . ' as ux_address, i.'.UX_NUMBER . ' as ux_number');
		$this->db->from(USER_STOCK_EXPORT .' as i');
		$this->db->join(BASE_MASTER . ' as b','i.'.UX_BASE_CODE. ' = b.'.BM_BASE_CODE,'left');
		
		if(!empty($data['ux_id'])) $this->db->where('i.'. UX_ID,$data['ux_id']);
		if(!empty($data['ux_name'])) $this->db->where('i.'. UX_NAME,$data['ux_name']);
		if(!empty($data['ux_base'])) $this->db->where('i.'.UX_BASE_CODE,$data['ux_base']);
		if(!empty($data['ux_address'])) $this->db->where('i.'.UX_ADDRESS,$data['ux_address']);
		if(!empty($data['ux_number'])) $this->db->where('i.'.UX_NUMBER,$data['ux_number']);
		
		
		if($by != NULL && $type != NULL){
			$this->db->order_by($by, $type);
		}
		
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index );
		}
		
		$supplier = $this->db->get();
		
		return $supplier->result();
	}

	public function get_all()
	{
		$list_user = $this->db->get(USER_STOCK_EXPORT);
		return $list_user->result();
	}

	public function get_by_id($id)
	{
		$this->db->where(UX_ID,$id);
		$user = $this->db->get(USER_STOCK_EXPORT);
		if(empty($user->result())) return NULL;
		else return $user->result()[0];
	}
}