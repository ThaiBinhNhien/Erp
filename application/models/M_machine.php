<?php
//category bán
class M_machine extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = EQUIPMENT_M;
		$this->idCol = EQ_CODE;
	}

	public function search($data , $start_index = NULL,$number = NULL,$category_by =NULL ,$category_type = NULL)
	{
		$this->db->select('c.'.EQ_CODE .' as category_id, c.'. EQ_NAME . ' as category_name');
		$this->db->from(EQUIPMENT_M .' as c');
		if(!empty($data['cat_name'])) $this->db->like(EQ_NAME,$data['cat_name'], 'both');
		
		if($category_by != NULL && $category_type != NULL){
			$this->db->order_by($category_by, $category_type);
		}
		$this->db->limit($number,$start_index);
		$category = $this->db->get();
		return $category->result();
	}
}