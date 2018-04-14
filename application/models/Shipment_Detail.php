<?php

class Shipment_Detail extends VV_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table_name = ORDER_SHIPMENT_DETAIL;
	}

	/**
    * Function: getDetailByOrder
    * @access public
    */ 
	public function getDetailByOrder($id){
		$query = '
		SELECT 
		SD.*, 
		C.`'.CSHIPMENT_NAME.'` AS customer_name, 
		D.`'.DSL_DEPARTMENT_NAME.'` AS department_name, 
		P.`'.PL_PRODUCT_CODE_SALE.'` AS product_code,
		P.`'.PL_PRODUCT_NAME.'` AS product_name,
		P.`'.PL_STANDARD.'` AS product_format, 
		P.`'.PL_COLOR_TONE.'` AS product_color, 
		P.`'.PL_NUMBER_PACKAGE.'` as product_value_unit, 
		P.`'.PL_ORGANIZATION_WEIGHT.'` AS product_weight, 
		P.`'.PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT.'` AS product_container   
		FROM `'.ORDER_SHIPMENT_DETAIL.'` SD 
		LEFT JOIN `'.CUSTOMER_SHIPMENT.'` C ON C.`'.CSHIPMENT_ID.'` = SD.`'.OSHD_CUSTOMER_ID.'` 
		LEFT JOIN `'.DEPARTMENT_SHIPMENT_LEDGER.'` D ON D.`'.DSL_DEPARTMENT_CODE.'` = SD.`'.OSHD_DEPARTMENT_ID.'` 
		LEFT JOIN `'.PRODUCT_LEDGER.'` P ON P.`'.PL_PRODUCT_ID.'` = SD.`'.OSHD_PRODUCT_CODE.'` 
		WHERE SD.`'.OSHD_ORDER_ID.'` = '.$id . ' ORDER BY SD.id ASC';

		return $this->getQuery($query);
	}

	public function setWhereClause($condition){
		if(isset($condition['date_from']) && $condition['date_from'] != NULL && $condition['date_from'] != ""){
			$this->db->where(OS_ORDER_DATE." >=",$condition['date_from']);
		}
		if(isset($condition['date_to']) && $condition['date_to'] != NULL && $condition['date_to'] != ""){
			$this->db->where(OS_ORDER_DATE." <=",$condition['date_to']);
		}
		if(isset($condition['customer']) && $condition['customer'] != NULL && $condition['customer'] != ""){
			$this->db->where(OSHD_CUSTOMER_ID,$condition['customer']);
		}
	}

	public function getPdfByDate($date_from,$date_to){
		$this->db->select(OS_ORDER_DATE.",".OSHD_PRODUCT_CODE.",".PL_PRODUCT_NAME.",SUM(".OSHD_QUANTITY."+".OSHD_QUANTITY_CHANGE.") AS quantity,".
			"SUM((".OSHD_QUANTITY."+".OSHD_QUANTITY_CHANGE.")*`".PL_ORGANIZATION_WEIGHT."`) AS weight");
		$this->db->join(ORDER_SHIPMENT,"`".ORDER_SHIPMENT."`.`".OS_ID."`=".ORDER_SHIPMENT_DETAIL.".".OSHD_ORDER_ID);
		$this->db->join(PRODUCT_LEDGER,"`".PRODUCT_LEDGER."`.`".PL_PRODUCT_ID."`=".ORDER_SHIPMENT_DETAIL.".".OD_PRODUCT_CODE);
		if($this->level == 'P'){
			$this->db->where(OS_ORDERER." IN (SELECT ".U_ID." FROM ".USER_MASTER." WHERE ".U_BASE_CODE." = '".$this->LOGIN_INFO[U_BASE_CODE]."')");
		}
		$this->db->group_by(OS_ORDER_DATE.",".OSHD_PRODUCT_CODE.",".PL_PRODUCT_NAME);
		return $this->db->get(ORDER_SHIPMENT_DETAIL)->result_array();
	}

	public function getPdfByCustomer($date_from,$date_to,$cus_id){
		$query = "
		SELECT 
		`".OSHD_CUSTOMER_ID."`, 
		`".CSHIPMENT_NAME."`, 
		`".OSHD_PRODUCT_CODE."`, 
		`".PL_PRODUCT_NAME."`, 
		`".PL_STANDARD."`, 
		`".PL_COLOR_TONE."`, 
		`".PL_ORGANIZATION_WEIGHT."`, 
		SUM(".OSHD_QUANTITY."+".OSHD_QUANTITY_CHANGE.") AS quantity FROM `".ORDER_SHIPMENT_DETAIL."` 
		JOIN `".ORDER_SHIPMENT."` ON `".ORDER_SHIPMENT."`.`".OS_ID."`=".ORDER_SHIPMENT_DETAIL.".".OSHD_ORDER_ID." 
		JOIN `".PRODUCT_LEDGER."` ON `".PRODUCT_LEDGER."`.`".PL_PRODUCT_ID."`=".ORDER_SHIPMENT_DETAIL.".".OD_PRODUCT_CODE." 
		JOIN `".CUSTOMER_SHIPMENT."` ON `".CUSTOMER_SHIPMENT."`.`".CSHIPMENT_ID."`=".ORDER_SHIPMENT_DETAIL.".".OSHD_CUSTOMER_ID;
		$subQuery = "";
		if($date_from != NULL && $date_from != ""){
			$subQuery = " WHERE ".OS_ORDER_DATE." >= '$date_from'";
		}
		if($date_to != NULL && $date_to != ""){
			if($subQuery != ""){
				$subQuery .= " AND ".OS_ORDER_DATE." <= '$date_to'";
			}else{
				$subQuery = " WHERE ".OS_ORDER_DATE." <= '$date_to'";
			}
		}
		if($customer != NULL && $customer != ""){
			if($subQuery != ""){
				$subQuery .= " AND ".OSHD_CUSTOMER_ID." = '$cus_id'";
			}else{
				$subQuery = " WHERE ".OSHD_CUSTOMER_ID." = '$cus_id'";
			}
		}
		if($this->level == 'P'){
			if($subQuery != ""){
				$subQuery .= " AND ".OS_ORDERER." IN (SELECT ".U_ID." FROM ".USER_MASTER." WHERE ".U_BASE_CODE." = '".$this->LOGIN_INFO[U_BASE_CODE]."')";
			}else{
				$subQuery = " WHERE ".OS_ORDERER." IN (SELECT ".U_ID." FROM ".USER_MASTER." WHERE ".U_BASE_CODE." = '".$this->LOGIN_INFO[U_BASE_CODE]."')";
			}
			
		}
		$query .= $subQuery." GROUP BY `".OSHD_CUSTOMER_ID."`, `".CSHIPMENT_NAME."`, `".OSHD_PRODUCT_CODE."`, `".PL_PRODUCT_NAME."`, `".PL_STANDARD."`, `".PL_COLOR_TONE."`, `".PL_ORGANIZATION_WEIGHT."`";
		return $this->getQuery($query);
	}
}