<?php
//category bán
class M_washing extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = LAUNDRY_M;
		$this->idCol = LM_CODE;
	}

	public function search($data , $start_index = NULL,$number = NULL,$by =NULL ,$type = NULL)
	{
		$this->db->select('c.'.LM_CODE .' as id, c.'. LM_ITEM_NAME_1 . ' as item_name_1, c.'. LM_ITEM_NAME_2 . ' as item_name_2,  c.'. LM_WEIGHT . ' as weight,c.'. LM_WASHING_TEMPERATURE . ' as temperature ');
		$this->db->from(LAUNDRY_M .' as c');
		if(!empty($data['item_name'])) {
			$this->db->like(LM_ITEM_NAME_1,$data['item_name'], 'both');
			$this->db->or_like(LM_ITEM_NAME_2,$data['item_name'], 'both');
		}
		if(!empty($data['id'])) $this->db->where(LM_CODE,$data['id']);
		if($by != NULL && $type != NULL){
			$this->db->order_by($by, $type);
		}
		$this->db->limit($number,$start_index);
		$category = $this->db->get();
		return $category->result();
	}
}