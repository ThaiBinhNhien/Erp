<?php

class Department extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DEPARTMENT_LEDGER;
		 
		$this->idCol = DL_DEPARTMENT_CODE;
	} 

	/**
	* Function: getDepartmentByCustomer
	* get department by customer
	* @access public
	* @param $customer_id : customer
	*/
	public function getDepartmentByCustomer($customer_id){
		$query = 'SELECT P.*
		FROM `'.DEPARTMENT_LEDGER.'` P 
		LEFT JOIN `'.CUSTOMER_DEPARTMENT.'` K ON K.`'.CD_DEPARTMENT_CODE.'` = P.`'.DL_DEPARTMENT_CODE.'` 
		WHERE K.`'.CD_CUSTOMER_ID.'` = '.$customer_id;

		return $this->getQuery($query);
	}

	//lấy phòng bang từ mã phòng bang
	public function get_by_id($id)
	{
		$this->db->where(DL_DEPARTMENT_CODE,$id);
		$department = $this->db->get(DEPARTMENT_LEDGER);
		if(count($department->result())==0) return null;
		return $department->result()[0];
	}

	public function get_all(){
		$department = $this->db->get(DEPARTMENT_LEDGER);
		return $department->result();
	}


	public function getDepartmentView($id, $name,$code){
		$this->db->select("*,".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_NAME." AS name,".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE." AS id,".DEPARTMENT_LEDGER.".".DL_AGGREGATION_CODE." AS code,".GROUP_REPORT.".".GR_GROUP_NAME." AS name_code");
		$this->db->join(GROUP_REPORT,"`".DEPARTMENT_LEDGER."`.`".DL_AGGREGATION_CODE."`=".GROUP_REPORT.".".GR_GROUP_CODE,"left outer");

		if($id != NULL && $id != ""){
			$this->db->where(DL_DEPARTMENT_CODE, $id);
		}
		if($name != NULL && $name != ""){
			$this->db->like(DL_DEPARTMENT_NAME,$name,'both');
		}
		if($code != NULL && $code != ""){
			$this->db->like(DL_AGGREGATION_CODE,$code,'both');
		}
		$this->db->order_by($this->idCol, SORT_MASTER);
		return $this->db->get($this->table_name)->result_array();
	}
}