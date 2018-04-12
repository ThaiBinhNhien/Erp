<?php

class DepartmentShipment extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DEPARTMENT_SHIPMENT_LEDGER;
		 
		$this->idCol = DSL_DEPARTMENT_CODE;
	} 

	/**
	* Function: getDepartmentByCustomer
	* get department by customer
	* @access public
	* @param $customer_id : customer
	*/
	public function getDepartmentByCustomer($customer_id){
		$query = 'SELECT P.*
		FROM `'.DEPARTMENT_SHIPMENT_LEDGER.'` P 
		LEFT JOIN `'.CUSTOMER_DEPARTMENT_SHIPMENT.'` K ON K.`'.CDS_DEPARTMENT_CODE.'` = P.`'.DSL_DEPARTMENT_CODE.'` 
		WHERE K.`'.CDS_CUSTOMER_ID.'` = '.$customer_id;

		return $this->getQuery($query);
	}

	//lấy phòng bang từ mã phòng bang
	public function get_by_id($id)
	{
		$this->db->where(DSL_DEPARTMENT_CODE,$id);
		$department = $this->db->get(DEPARTMENT_SHIPMENT_LEDGER);
		if(count($department->result())==0) return null;
		return $department->result()[0];
	}

	public function get_all(){
		$department = $this->db->get(DEPARTMENT_SHIPMENT_LEDGER);
		return $department->result();
	}


	public function getDepartmentView($id, $name,$code){
		$this->db->select("*,".DEPARTMENT_SHIPMENT_LEDGER.".".DSL_DEPARTMENT_NAME." AS name,".DEPARTMENT_SHIPMENT_LEDGER.".".DSL_DEPARTMENT_CODE." AS id");

		if($id != NULL && $id != ""){
			$this->db->where(DSL_DEPARTMENT_CODE, $id);
		}
		if($name != NULL && $name != ""){
			$this->db->like(DSL_DEPARTMENT_NAME,$name,'both');
		}
		$this->db->order_by($this->idCol, SORT_MASTER);
		return $this->db->get($this->table_name)->result_array();
	}
}