<?php
//category bán
class Category extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = CATEGORIES;
		$this->idCol = CATE_CATEGORY_CODE;
	}

	public function search_category($data , $start_index = NULL,$number = NULL,$category_by =NULL ,$category_type = NULL)
	{
		$this->db->select('c.'.CATE_CATEGORY_CODE .' as category_id, c.'. CATE_CATEGORY_NAME . ' as category_name');
		$this->db->from(CATEGORIES .' as c');
		if(!empty($data['cat_id'])) $this->db->where(CATE_CATEGORY_CODE,$data['cat_id']);
		
		if(!empty($data['cat_name'])) $this->db->like(CATE_CATEGORY_NAME,$data['cat_name'], 'both');
		
		if($category_by != NULL && $category_type != NULL){
			$this->db->order_by($category_by, $category_type);
		}
		$this->db->limit($number,$start_index);
		$category = $this->db->get();
		return $category->result();
	}
}