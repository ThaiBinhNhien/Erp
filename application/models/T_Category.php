<?php
//category mua
class T_Category extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_PRODUCT_CATEGORY;
		$this->idCol = ID;
	}
	public function search_category($data , $start_index = NULL,$number = NULL,$category_by =NULL ,$category_type = NULL)
	{
		$this->db->select('c.'.ID .' as category_id, c.'. TPC_NAME . ' as category_name');
		$this->db->from(T_PRODUCT_CATEGORY .' as c');
		if(!empty($data['cat_id'])) $this->db->where(ID,$data['cat_id']);
		if(!empty($data['cat_name'])) $this->db->like(TPC_NAME,$data['cat_name'], 'both');
		
		if($category_by != NULL && $category_type != NULL){
			$this->db->order_by($category_by, $category_type);
		}
		$this->db->limit($number,$start_index);
		$category = $this->db->get();
		return $category->result();
	}
	
}