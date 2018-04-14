<?php

class Order_Detail_Floor extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = FLOOR;
	}

	public function getFloorNameByOrderId($order_id){
		$this->db->distinct();
		$this->db->select("odf.".F_FLOOR_NAME.",odf.".F_FLOOR_NAME." AS floor");
		$this->db->from(SALES_LEDGER.' AS o');
		$this->db->join(ORDER_DETAIL.' AS od','o.'.SL_ID.'=od.'.OD_ORDER_ID,'left outer');
		$this->db->join(FLOOR.' AS odf','od.'.OD_ID.'=odf.'.F_DETAIL_ID,'right outer');
		$this->db->where(array(
			'o.'.SL_ID => $order_id
		));
		$this->db->order_by("CAST(SUBSTR(odf.`".F_FLOOR_NAME."`,1,LENGTH(odf.`".F_FLOOR_NAME."`)-1) AS SIGNED) ASC");
		
		return $this->db->get()->result_array();
	}

	public function getByOrderId($order_id){
		$this->db->select("odf.*");
		$this->db->from(SALES_LEDGER.' AS o');
		$this->db->join(ORDER_DETAIL.' AS od','o.'.SL_ID.'=od.'.OD_ORDER_ID,'left outer');
		$this->db->join(FLOOR.' AS odf','od.'.OD_ID.'=odf.'.F_DETAIL_ID,'right outer');
		$this->db->where(array(
			'o.'.SL_ID => $order_id
		));
		return $this->db->get()->result_array();
	}
}