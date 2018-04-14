<?php

class Overview_Category_M extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCTION_OVERVIEW_CATEGORY_M;
		$this->idCol = POC_PRODUCTION_SUMMARY_CODE;
		 
	}

	
	public function search($data , $start_index = NULL,$number = NULL,$by  =NULL ,$type = NULL)
	{
		$this->db->select('s.'.POC_PRODUCTION_SUMMARY_CODE .' as id, s.'. POC_CATEGORY_NAME . ' as name,s.'.POC_DISPLAY_ORDER .' as display_order , g.'.POG_NAME . ' as name_group_m');
		$this->db->from(PRODUCTION_OVERVIEW_CATEGORY_M .' as s');
		$this->db->join(PRODUCTION_OVERVIEW_GROUP_M . ' as g','s.'.POC_PRODUCTION_OVERVIEW_GROUP_CODE. ' = g.'.POG_CODE,'left');

		if(!empty($data['cat_id'])) $this->db->where(POC_PRODUCTION_SUMMARY_CODE,$data['cat_id']);
		if(!empty($data['cat_name'])) $this->db->like(POC_CATEGORY_NAME,$data['cat_name'], 'both');
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