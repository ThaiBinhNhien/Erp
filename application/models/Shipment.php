<?php

class Shipment extends VV_Model
{
	
	function __construct() 
	{
		parent::__construct();
		$this->table_name = ORDER_SHIPMENT;
		$this->idCol = OS_ID;
		$this->valueDateUpdate = OS_UPDATE_DATE;
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}

	/**
	* Function: getShipmentView
	* Model search in shipment
	* shipment_status : 
	* 1:一時保存 (lưu tạm), 
	* 2: 出荷未確定 (chưa xác định xuất hàng), 
	* 3: 再依頼 (yêu cầu lại),  
	* 4: 出荷確定(不足) (xác định xuất hàng không đủ),
	* 5: 出荷確定 (xác định xuất hàng)
	* 2: 出荷未確定 include(1:一時保存, 3: 再依頼,  4: 出荷確定(不足))
	* @access public 
	*/
	public function getShipmentView($ticket_no,$voter,$shipping_category,$shipment_status,$delivery_from,$delivery_to,$customer,$department_name,$text_note
		,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		$query = "
		SELECT S.".OS_ID." as ticket_no, 
		S.`".OS_ORDER_DATE."` as creater_date, 
		S.`".OS_DELIVERY_DATE."` as delivery_date, 
		S.`".OS_NUMBER_REQUEST."` AS number_request, 
		S.`".OS_STATUS."` AS status, 
		DC.`".DC_NAME."` as delivery_classification,
		GROUP_CONCAT(DISTINCT C.`".CSHIPMENT_ID."`) AS customer_id,
		GROUP_CONCAT(DISTINCT C.`".CSHIPMENT_NAME."`) AS customer_name,
		GROUP_CONCAT(DISTINCT P.`".DSL_DEPARTMENT_CODE."`) AS department_id,
		GROUP_CONCAT(DISTINCT P.`".DSL_DEPARTMENT_NAME."`) AS department_name
		FROM `".ORDER_SHIPMENT."` S
		INNER JOIN `".ORDER_SHIPMENT_DETAIL."` D ON S.".OS_ID." = D.`".OSHD_ORDER_ID."` 
		LEFT JOIN `".CUSTOMER_SHIPMENT."` C ON D.`".OSHD_CUSTOMER_ID."` = C.`".CSHIPMENT_ID."` 
		LEFT JOIN `".DEPARTMENT_SHIPMENT_LEDGER."` P ON D.`".OSHD_DEPARTMENT_ID."` = P.`".DSL_DEPARTMENT_CODE."` 
		LEFT JOIN `".DELIVERY_CLASSIFICATION."` DC ON S.`".OS_DELIVERY_CLASSIFICATION."` = DC.".DC_ID ." "; 

		$whereClause = "WHERE ";
		if($ticket_no != NULL && $ticket_no != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND "); 
			$whereClause .= "S.`".OS_ID."`"."='$ticket_no' ";
		}
		if($voter != NULL && $voter != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".OS_ORDERER."`"."='".$voter."' ";
		}
		if($shipping_category != NULL && $shipping_category != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".OS_DELIVERY_CLASSIFICATION."`"."='$shipping_category' ";
		}
		if($shipment_status != NULL && $shipment_status != ''){

			$whereClause .= ($whereClause == "WHERE "?"":"AND ");

			if($shipment_status == 2 || $shipment_status == '2') {
				$whereClause .= "(S.`".OS_STATUS."`"." IN (2,3,4) ";
				// Hiển thị hóa đơn tạm do người đó tạo
				$whereClause .= "OR (S.`".OS_STATUS."`"." IN (1) AND S.`".OS_ORDERER."` = '".$this->LOGIN_INFO[U_ID]."')) ";
			}
			else{
				if($shipment_status == 1 || $shipment_status == '1') {
					// Hiển thị hóa đơn tạm do người đó tạo
					$whereClause .= "(S.`".OS_STATUS."`"." IN ($shipment_status) AND S.`".OS_ORDERER."` = '".$this->LOGIN_INFO[U_ID]."') ";
				} else {
					$whereClause .= "S.`".OS_STATUS."`"."=$shipment_status ";
				}
			}
		}
		if($delivery_from != NULL && $delivery_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".OS_DELIVERY_DATE."`"." >= '$delivery_from 00:00:00' ";
		}
		if($delivery_to != NULL && $delivery_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".OS_DELIVERY_DATE."`"."  <= '$delivery_to 23:59:59' ";
		}
		if($customer != NULL && $customer != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`".OSHD_CUSTOMER_ID."`"."='$customer' ";
		}
		if($department_name != NULL && $department_name != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`".OSHD_DEPARTMENT_ID."`"."='$department_name' ";
		}
		if($text_note != NULL && $text_note != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".OS_NOTE."`"." LIKE '%".$text_note."%' ";
		}

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause." GROUP BY S.".OS_ID." ";

		if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY S.`".$order_by."` ". $order_type;
		} else {
			$query .= " ORDER BY S.`".OS_ID."` DESC";
		}

		return $this->getQuery($query,$start_index,$number); 
	}


	/**
    * Function: getMaxIdShipment
    * @access public
    */
	public function getMaxIdShipment(){
		$query = '
		SELECT '.OS_ID.' 
		FROM `'.ORDER_SHIPMENT.'` 
		ORDER BY '.OS_ID.' 
		DESC LIMIT 0, 1';
		$getQuery = $this->getQuery($query);
		return ($getQuery[0][OS_ID]+1);
	}

	/**
    * Function: getMasterById
    * @access public
    */
	public function getMasterById($id){
		$query = "
		SELECT 
		OS.*, 
		C.`".DC_NAME."` AS delivery_classifition, 
		C.`".DC_NUMBER_CONTAINER."` AS number_container, 
		C.`".DC_NUMBER_TRUCK."` AS number_truck, 
		C.`".DC_NUMBER_MAX_TRUCK."` AS number_max_truck, 
		U.`".U_NAME."` AS user_order, 
		S.`".U_NAME."` AS user_shipper, 
		DATEDIFF(OS.`".OS_DELIVERY_DATE."`, 
		OS.`".OS_ORDER_DATE."`) AS check_time,
		OS.`".OS_UPDATE_DATE."` AS date_update  
		FROM `".ORDER_SHIPMENT."` OS 
		LEFT JOIN `".DELIVERY_CLASSIFICATION."` C ON C.".DC_ID." = OS.`".OS_DELIVERY_CLASSIFICATION."` 
		LEFT JOIN `".USER_MASTER."` U ON U.".U_ID." = OS.`".OS_ORDERER."` 
		LEFT JOIN `".USER_MASTER."` S ON S.".U_ID." = OS.`".OS_SHIPPER."` 
		WHERE CAST(OS.".OS_ID." AS  CHAR(512))='".$id."'";

		$getQuery = $this->getQuery($query);
		$return = '';
		if($getQuery != null)
			$return = $getQuery[0];
		return $return;
	}

	/**
    * Function: getFieldShipment
    * @access public
    */
	public function getFieldShipment($field,$id){
		$query = '
		SELECT '.$field.' 
		FROM `'.ORDER_SHIPMENT.'` 
		WHERE id='.$id;
		$getQuery = $this->getQuery($query);
		$return = '';
		if($getQuery != null)
			$return = $getQuery[0][$field];
		return $return;
	}


	/**
    * Function: getNoReportSetContainer
    * @access public
    */
	public function getNoReportSetContainer($delivery_classifition,$number_of_delivery){
		$query = '
		SELECT `'.CD_NAME.'` 
		FROM `'.CATEGORY_DELIVERYCLASSIFICATION.'`
		WHERE `'.CD_CLASSIFICATION.'`='.$delivery_classifition.' 
		AND `'.CD_NUMBER_OF_DELIVERY.'`='.$number_of_delivery;
		$getQuery = $this->getQuery($query);
		$return = '';
		if($getQuery != null)
			$return = $getQuery[0][CD_NAME];
		return $return;
	}

	/**
    * Function: getOrderToShipment
    * @access public
    */
	public function getOrderToShipment($order_id){
		$query = "
			SELECT 
			MS.`".CCS_CUSTOMER_SHIPMENT."` AS customer_id,
			D.`".DD_PRODUCT_CODE."` AS product_id,
			SUM(D.`".DD_QUANTITY."`) AS quantity 
			FROM `".DELIVERY_DETAIL."` D
			LEFT JOIN `".SALES_LEDGER."` M ON D.`".DD_ORDER_ID."`=M.`".SL_ID."`
			LEFT JOIN `".CUSTOMER_CUSTOMERSHIPMENT."` MS ON M.`".SL_CUSTOMER_ID."`=MS.`".CCS_CUSTOMER."` 
			
			WHERE D.`".DD_ORDER_ID."` = ".$order_id."
			GROUP BY D.`".DD_PRODUCT_CODE."` 
			HAVING SUM(D.`".DD_QUANTITY."`) > 0
		";

		return $this->getQuery($query);
	}

	
}