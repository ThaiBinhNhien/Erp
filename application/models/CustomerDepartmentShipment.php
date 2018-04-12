<?php

class CustomerDepartmentShipment extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = CUSTOMER_DEPARTMENT_SHIPMENT;
	}
	 
	function getByCustomer($customer_id){ 
		$this->db->distinct();
		$this->db->select(
			"`".CUSTOMER_DEPARTMENT_SHIPMENT."`.*,
			`".DEPARTMENT_SHIPMENT_LEDGER."`.`".DSL_DEPARTMENT_NAME."`,
			`".DEPARTMENT_SHIPMENT_LEDGER."`.`".DSL_DEPARTMENT_NAME."` AS department,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DEPARTMENT_CODE."` AS department_code,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DEPARTMENT_CODE."` AS department_id,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DE_ID."` AS id,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_CUSTOMER_ID."` AS customer_id");
		
		$this->db->join(
			"`".DEPARTMENT_SHIPMENT_LEDGER."`",
			"`".DEPARTMENT_SHIPMENT_LEDGER."`.`".DSL_DEPARTMENT_CODE."`=`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DEPARTMENT_CODE."`");
		if($customer_id != null && $customer_id != "") {
			$this->db->where( 
							array(
								"`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_CUSTOMER_ID."`" => $customer_id
							)
			);
		}
		$this->db->group_by("`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DEPARTMENT_CODE."`");
		return $this->db->get($this->table_name)->result_array();
	}

	function getByDepartment($department_id){ 
		$this->db->distinct();
		$this->db->select(
			"`".CUSTOMER_DEPARTMENT_SHIPMENT."`.*,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DEPARTMENT_CODE."` AS department_code,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DEPARTMENT_CODE."` AS department_id,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DE_ID."` AS id,
			`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_CUSTOMER_ID."` AS customer_id,
			`".CUSTOMER_SHIPMENT."`.`".CSHIPMENT_NAME."`,
			`".CUSTOMER_SHIPMENT."`.`".CSHIPMENT_NAME."` AS customer_name");
		
		$this->db->join(
			"`".CUSTOMER_SHIPMENT."`",
			"`".CUSTOMER_SHIPMENT."`.`".CSHIPMENT_ID."`=`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_CUSTOMER_ID."`");
		if($department_id != null && $department_id != "") {
			$this->db->where( 
							array(
								"`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_DEPARTMENT_CODE."`" => $department_id
							)
			);
		}
		$this->db->group_by("`".CUSTOMER_DEPARTMENT_SHIPMENT."`.`".CDS_CUSTOMER_ID."`");
		return $this->db->get($this->table_name)->result_array();
	}
}