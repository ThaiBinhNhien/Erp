<?php

class Order extends VV_Model 
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = "vieworder";
		$this->idCol = SL_ID;
		$this->valueDateUpdate = SL_UPDATE_DATE;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info'); 
		//$this->colAuth = SL_USER_ID;
		$this->valAuth = $this->LOGIN_INFO[U_ID];
	}

	
	public function getByCustomerId($customer_id,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		$data = array(SL_CUSTOMER_ID => $customer_id);
		return $this->getWhere($data,$start_index,$number,$order_by,$order_type);
	}

	public function getByCreatedId($created_id,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		$data = array(SL_USER_ID => $created_id);
		return $this->getWhere($data,$start_index,$number,$order_by,$order_type);
	}

	public function getByCreatedAndCustomer($created_id,$customer_id,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		$data = array(
					SL_CUSTOMER_ID => $customer_id,
					SL_USER_ID => $created_id
				);
		return $this->getWhere($data,$start_index,$number,$order_by,$order_type);
	}

	public function getOrderView($created_id,$customer_id,$status,$claim_check,$department,$order_from,$order_to,$delivery_from,$delivery_to
		,$order_no,$is_customer = 0,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		$query = "SELECt T.".SL_ID." AS id,T.".SL_CUSTOMER_ID." AS customer_id,T.".SL_DEPARTMENT_CODE." AS department_code,
					T.".SL_USER_ID." AS user_id,T.".SL_SALES_DATE." AS order_date,T.".SL_DELIVERY_DATE." AS delivery_expected,
					T.".SL_BASE_CODE." AS base_code,T.".SL_SUMMARY." AS summary,T.".SL_TAX." AS tax,T.".SL_ORDER_AMOUNT." AS order_amount,
					T.".SL_DELIVERY_AMOUNT." AS delivery_amount,T.".SL_ORDER_CLASSIFICATION." AS order_classification,
					T.".SL_CLAIM_CHECK." AS claim_check,T.".DL_DEPARTMENT_NAME." AS department,T.order_number,T.add_number,T.delivery_number,
					T.".SL_STATUS." AS status,`売上台帳`.注文区分とる AS type,T.customer_name,T.user_name AS created_name 
				FROM `".SALES_LEDGER."` INNER JOIN(";
		$query .= "SELECt o.*,SUM(od.".OD_QUANTITY.") AS order_number,SUM(od.".OD_ADD.") AS add_number,IFNULL(SUM(dd.".DD_QUANTITY."),0) AS delivery_number,
					 dl.".DL_DEPARTMENT_NAME.",cus.".CUS_CUSTOMER_NAME." AS customer_name,
					 user.".U_NAME." AS user_name  
					FROM `".SALES_LEDGER."` o INNER JOIN `".ORDER_DETAIL."` od ON o.".SL_ID."=od.".OD_ORDER_ID." 
					LEFT JOIN `".DELIVERY_DETAIL."` dd ON dd.".DD_ORDER_ID."=od.".SL_ID."  
					LEFT JOIN `".DEPARTMENT_LEDGER."` dl ON o.".SL_DEPARTMENT_CODE."=dl.".DL_DEPARTMENT_CODE." 
					LEFT JOIN `".CUSTOMER."` cus ON o.".SL_CUSTOMER_ID."=cus.".CUS_ID." 
					LEFT JOIN `".USER_MASTER."` user ON o.".SL_USER_ID."=user.".U_ID;
		$whereClause = " WHERE (`".SL_STATUS."`=1 OR (`".SL_STATUS."` != 1 AND `".SL_USER_ID."`='".$this->valAuth."')) ";
		if($created_id != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= SL_USER_ID."='$created_id' ";
		}
		if($status != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= SL_STATUS."=$status ";
		}
		if($order_no != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "o.`".SL_ID."`=$order_no ";
		}
		if($claim_check != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= SL_CLAIM_CHECK."=$claim_check ";
		}
		if($department != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "o.`".SL_DEPARTMENT_CODE."`=$department ";
		}
		if($customer_id != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "o.`".SL_CUSTOMER_ID."`=$customer_id ";
		}
		if($order_from != NULL ){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= SL_SALES_DATE." >= '$order_from 00:00:00' ";
		}
		if( $order_to != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= SL_SALES_DATE." <= '$order_to 23:59:59' ";
		}
		if($delivery_from != NULL ){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= SL_DELIVERY_DATE." >= '$delivery_from 00:00:00'";
		}
		if( $delivery_to != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= SL_DELIVERY_DATE."  <= '$delivery_to 23:59:59' ";
		}
		if($this->level == "P" && $is_customer == 0){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "o.`".SL_DEPARTMENT_CODE."` IN ( SELECT `".CUSTOMER_DEPARTMENT."`.`".CD_DEPARTMENT_CODE."` FROM `".CUSTOMER_DEPARTMENT."` WHERE `".CD_CUSTOMER_ID."`=`".SL_CUSTOMER_ID."` AND `".CD_USER_ID."`='".$this->LOGIN_INFO[U_ID]."')";
		}
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause." GROUP BY o.".SL_ID." ) T WHERE `".SALES_LEDGER."`.".SL_ID."=T.".SL_ID;

		if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY `".SALES_LEDGER."`.$order_by $order_type";
		}

		return $this->getQuery($query,$start_index,$number);
	}

	public function checkOwner($order_id,$customer_id){
		$query = "sELECT * FROM `".SALES_LEDGER."` WHERE `".SL_ID."`=".$order_id." AND ";
		if($customer_id != null){
			$query .= "`".SL_CUSTOMER_ID."`=$customer_id ";
		}else{
			$query .= "`".SL_DEPARTMENT_CODE."` IN ( SELECT `".CUSTOMER_DEPARTMENT."`.`".CD_DEPARTMENT_CODE."` FROM `".CUSTOMER_DEPARTMENT."` WHERE `".CD_CUSTOMER_ID."`=`".SL_CUSTOMER_ID."` AND `".CD_USER_ID."`='".$this->LOGIN_INFO[U_ID]."')";
		}
		return $this->getQuery($query);
	}

	function pdfFloor($id){
		$this->db->select(FLOOR.".*");
		$this->db->join(ORDER_DETAIL, OD_ID."=".FLOOR.".".F_DETAIL_ID);
		$this->db->where(
			array(
				ORDER_DETAIL.".".OD_ORDER_ID => $id
			)
		);
		$this->db->order_by(F_FLOOR_NAME,"DESC");
		$dataFloor = $this->db->get(FLOOR)->result_array();
		$this->db->flush_cache();
		$this->db->where(
			array(
				OD_ORDER_ID => $id
			)
		);
		$dataOrder = $this->db->get("vieworderdetail")->result_array();
		$result = array();
		if($dataFloor != NULL && count($dataFloor) != 0){
			foreach ($dataFloor as $key => $value) {
				if(!isset($result[$value[F_FLOOR_NAME]])){
					$result[$value[F_FLOOR_NAME]] = array();
					foreach ($dataOrder as $item) {
						$result[$value[F_FLOOR_NAME]][$item[OD_ID]] = array("name"=>PL_PRODUCT_NAME,"quantity"=>"");
					}
				}
				$result[$value[F_FLOOR_NAME]][$value[F_DETAIL_ID]]["quantity"] = $value[F_QUANTITY];
			}

		}else{
			return null;
		}
		return $result;
	}
}