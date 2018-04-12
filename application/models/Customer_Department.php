<?php

class Customer_Department extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = CUSTOMER_DEPARTMENT;
		$this->idCol = CUS_DE_ID;
		$this->customer_account = $this->session->userdata('customer-info');
	}

	function getByCustomer($customer_id,$translate=false){
		$this->db->distinct();
		$this->db->select(CUSTOMER_DEPARTMENT.".*,".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_NAME.",".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_NAME." AS department,".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE." AS department_code,".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE." AS department_id,".CUSTOMER_DEPARTMENT.".".CUS_DE_ID." AS id,".CD_CUSTOMER_ID." AS customer_id");
		
		$this->db->join(DEPARTMENT_LEDGER,DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE."=".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE);
		
		if($customer_id != null && $customer_id != "") {
			$this->db->where( 
							array(
								CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID => $customer_id
							)
			);
		} else {
			//$this->db->limit(200);
		}
		return $this->db->get($this->table_name)->result_array();
	}

	function getDepartment($customer_id = NULL){
		$this->db->select(DEPARTMENT_LEDGER.".".DL_DEPARTMENT_NAME.",".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE.",".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_NAME." AS department,".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE." AS department_code,".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE." AS department_id");
		$this->db->distinct();
		$this->db->join(DEPARTMENT_LEDGER,DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE."=".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE);
		if($customer_id != null && $customer_id != "") {
			$this->db->where( 
							array(
								CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID => $customer_id
							)
			);
		}
		if($this->level == "P"){
			if($this->customer_account == NULL){
				$this->db->where(CUSTOMER_DEPARTMENT.".".CD_USER_ID,$this->LOGIN_INFO[U_ID]);
			}else{
				$this->db->where(CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID , $this->customer_account[CUS_ID]);
			}
			
		}
		return $this->db->get($this->table_name)->result_array();
	}

	function getCustomerByDepartment($department_id = NULL){
		$this->db->select(CUSTOMER.".".CUS_CUSTOMER_NAME." AS customer_name,".CUSTOMER.".".CUS_ID." AS customer_id");
		$this->db->distinct();
		$this->db->join(CUSTOMER,CUSTOMER.".".CUS_ID."=".CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID);
		if($department_id != null && $department_id != "") {
			$this->db->where( 
							array(
								CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE => $department_id
							)
			);
		}
		if($this->level == "P"){
			if($this->customer_account == NULL){
				$this->db->where(CUSTOMER_DEPARTMENT.".".CD_USER_ID,$this->LOGIN_INFO[U_ID]);
			}else{
				$this->db->where(CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID , $this->customer_account[CUS_ID]);
			}
			
		}
		return $this->db->get($this->table_name)->result_array();
	}

	function removeByCustomer($customer_id){
		$this->db->where(
			array(CD_CUSTOMER_ID => $customer_id)
		);
		$this->db->delete($this->table_name);
	}

	public function getByCusAndDepart($cus_id,$depart_id){
		$this->db->where(array(
			CD_CUSTOMER_ID => $cus_id,
			CD_DEPARTMENT_CODE => $depart_id
		));

		$result = $this->db->get(CUSTOMER_DEPARTMENT)->result_array();
		if($result != null)
			$result = $result[0];
		return $result;
	}

	public function getAvaiable(){
		$this->db->select(CUSTOMER_DEPARTMENT.".*");
		$this->db->join(CUSTOMER,"`".CUSTOMER."`.`".CUS_ID."`=".CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID);
		return $this->db->get(CUSTOMER_DEPARTMENT)->result_array();
	}
}