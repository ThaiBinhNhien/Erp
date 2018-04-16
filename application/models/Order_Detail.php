<?php

class Order_Detail extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = "vieworderdetail";
		$this->idCol = OD_ID;
		$this->table_delivary_detail = DELIVERY_DETAIL;
		$this->load->model('Order_Detail_Floor','order_detail_floor_model');
		 
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
		$this->customer_account = $this->session->userdata('customer-info');
	} 

	public function getByOrderId($order_id){
		$data = array( OD_ORDER_ID => $order_id );  
		return $this->getWhere($data);
	}

	// Get information for order
	public function getInforOrderById($order_id){
		//$customer = $this->customer_account == null? null:$this->customer_account[CUS_ID];
		//$is_customer = $this->customer_account == null? 2:1;
		$query = "
			SELECT 
			SL.*,
			CS.`".CUS_CUSTOMER_NAME."`,
			PB.`".DL_DEPARTMENT_NAME."`, 
			SL.`".SL_REVENUE_DATE."` , 
			CD.`".BM_MASTER_CHECK."` AS is_gaichyu, 
			US.`".U_BASE_CODE."` AS base_code  
			FROM `".SALES_LEDGER."` SL
			INNER JOIN `".CUSTOMER."` CS ON CS.`".CUS_ID."` = SL.`".SL_CUSTOMER_ID."`
			INNER JOIN `".DEPARTMENT_LEDGER."` PB ON PB.`".DL_DEPARTMENT_CODE."` = SL.`".SL_DEPARTMENT_CODE."`
			INNER JOIN `".CUSTOMER_DEPARTMENT."` KB ON KB.`".CD_CUSTOMER_ID."` = SL.`".SL_CUSTOMER_ID."` 
			AND KB.`".CD_DEPARTMENT_CODE."` = SL.`".SL_DEPARTMENT_CODE."` 
			LEFT JOIN `".USER_MASTER."` US ON KB.`".CD_USER_ID."` = US.`".U_ID."`
			LEFT JOIN `".BASE_MASTER."` CD ON US.`".U_BASE_CODE."` = CD.`".BM_BASE_CODE."`
			
			WHERE CAST(SL.`".SL_ID."` AS  CHAR(512))='".$order_id."'";

			//if($this->level == "P" && $is_customer == 0){
				//$query .= " AND SL.`".SL_CUSTOMER_ID."` IN ( SELECT `".CUSTOMER_DEPARTMENT."`.`".CD_CUSTOMER_ID."` FROM `".CUSTOMER_DEPARTMENT."` WHERE `".CD_USER_ID."`='".$this->LOGIN_INFO[U_ID]."')";
			//}

		$query .= "	
			GROUP BY SL.`".SL_ID."`
		";

		/*$query = "
			SELECT `".SALES_LEDGER."`.*,`".CUSTOMER."`.`".CUS_CUSTOMER_NAME."` ,`".DEPARTMENT_LEDGER."`.`".DL_DEPARTMENT_NAME."`, `".SALES_LEDGER."`.*,`".SL_REVENUE_DATE."` , `".BASE_MASTER."`.`".BM_MASTER_CHECK."` AS is_gaichyu, `".USER_MASTER."`.`".U_BASE_CODE."` AS base_code  
			FROM `".SALES_LEDGER."`
			LEFT JOIN `".CUSTOMER."` ON `".CUSTOMER."`.`".CUS_ID."` = `".SALES_LEDGER."`.`".CUS_ID."`
			LEFT JOIN `".DEPARTMENT_LEDGER."` ON `".DEPARTMENT_LEDGER."`.`".DL_DEPARTMENT_CODE."` = `".SALES_LEDGER."`.`".DL_DEPARTMENT_CODE."`
			LEFT JOIN `".USER_MASTER."` ON `".SALES_LEDGER."`.`".SL_USER_ID."` = `".USER_MASTER."`.`".U_ID."`
			LEFT JOIN `".BASE_MASTER."` ON `".USER_MASTER."`.`".U_BASE_CODE."` = `".BASE_MASTER."`.`".BM_BASE_CODE."`
			WHERE CAST(`".SALES_LEDGER."`.`".SL_ID."` AS  CHAR(512))='".$order_id."'";*/

		//$result = $this->getQuery($query);
		/*if($this->level == "P"){
			if(count($result) > 0) {
				$check_role = "
					SELECT * FROM `".CUSTOMER_DEPARTMENT."` KB
					WHERE KB.`".CD_USER_ID."` = '".$this->LOGIN_INFO[U_ID]."' 
					AND KB.`".CD_CUSTOMER_ID."`= '".$result[0][CUS_ID]."' 
					AND KB.`".CD_DEPARTMENT_CODE."` = '".$result[0][DL_DEPARTMENT_CODE]."' 
				";
				$result_check_role = $this->getQuery($check_role);
				if(count($result_check_role) <= 0) {
					$result = array();
				}
			}
		}*/

		return $this->getQuery($query);
	}

	public function getByOrderDetailId($order_detail_id){
		$data = array( OD_ID => $order_detail_id );

		return $this->getWhere($data);
	}
 
	public function getByOrderIdWithFloor($order_id){
		$data = array( OD_ORDER_ID => $order_id );
		$result = $this->getWhere($data);
		if($result != NULL){
			$lstFloorName = $this->order_detail_floor_model->getFloorNameByOrderId($order_id);
			$lstFloor = $this->order_detail_floor_model->getByOrderId($order_id);
			if($lstFloor != NULL){
				foreach ($result as $indexM => $value) {
					foreach ($lstFloorName as $index => $item) {
						$result[$indexM][$item[F_FLOOR_NAME]] = '';
					}
				}

				foreach ($result as $indexM => $value) {
					foreach ($lstFloor as $index => $item) {
						if($value[OD_ID] == $item[F_DETAIL_ID]){
							$result[$indexM][$item[F_FLOOR_NAME]] = $item[F_QUANTITY];
						}
						
					}
				}
			}
		}
		return $result;
	}

   	// Chi tiết giao hàng 
	public function getByOrderDelivery($order_id, $location_id = "null", $customer_id = "null"){
		$query = "
			SELECT T_ORDER.*,
			T_PRO.`".PL_PRODUCT_NAME."`, 
			T_PRO.`".PL_STANDARD."`,
			T_PRO.`".PL_COLOR_TONE."`,
			T_PRO.`".PL_STANDARD."`,
			T_PRO.`".PL_NUMBER_PACKAGE."`,
			T_PRO.`".PL_SPECIAL."`,
			T_PRO.`".PL_PRODUCT_CODE_SALE."`,
			T_DELI.`".DD_UNIT_PRICE."` AS price_delivery, 
			T_DELI.`".DD_QUANTITY."` AS quantity_delivery, 
			T_DELI.`".DD_GAICHYU_PRICE."` AS price_delivery_gaichyu, 
			T_DELI.`".DD_CHECK."`, 
			T_DELI.`".DD_DELIVERY_AMOUNT."`, 
			T_PR.`".BB_UNIT_SELLING_PRICE."` AS price, 
			T_PR.`".BB_GAICHYU_PRICE."` AS price_gaichyu,
			T_DELI.`".DD_PRODUCT_NAME."` AS product_name_delivery,
			T_ORDER.`".OD_PRODUCT_NAME."` AS product_name_price 
			FROM `".ORDER_DETAIL."` T_ORDER 
			LEFT JOIN `".PRODUCT_LEDGER."` T_PRO ON T_ORDER.`".OD_PRODUCT_CODE."` = T_PRO.`".PL_PRODUCT_ID."`
			LEFT JOIN `".DELIVERY_DETAIL."` T_DELI ON T_ORDER.`".OD_ID."` = T_DELI.`".DD_ORDER_DETAIL_ID."`
			LEFT JOIN `".PRODUCT_BASE."` T_PR ON T_ORDER.`".OD_PRODUCT_CODE."` = T_PR.`".BB_PRODUCT_CODE."`
			AND T_PR.`".BB_BASE_CODE."` = ? 
			AND T_PR.`".BB_CUSTOMER_NUMBER."` = ? 
			WHERE T_ORDER.`".OD_ORDER_ID."` = ? 

			GROUP BY T_ORDER.`".OD_ID."`
		";

		return $this->getQuery($query,null,null,array($location_id,$customer_id,$order_id)); 
	}

	public function getDeliveryByDetail($order_detail_id){


		$query = "SELECT `".ORDER_DETAIL."`.*,
			`".PRODUCT_LEDGER."`.`".PL_PRODUCT_NAME."`,`".PRODUCT_LEDGER."`.`".PL_STANDARD."`,`".PRODUCT_LEDGER."`.`".PL_COLOR_TONE."`, `".PRODUCT_LEDGER."`.`".PL_STANDARD."`, `".PRODUCT_LEDGER."`.`".PL_NUMBER_PACKAGE."`,`".DELIVERY_DETAIL."`.`".DD_UNIT_PRICE."` AS 'price_delivery', `".DELIVERY_DETAIL."`.`".DD_QUANTITY."` AS 'quantity_delivery', `".DELIVERY_DETAIL."`.`".DD_CHECK."`  FROM `".ORDER_DETAIL."`
			JOIN `".PRODUCT_LEDGER."` ON `".PRODUCT_LEDGER."`.`".PRODUCT_LEDGER."ID` = `".ORDER_DETAIL."`.`".OD_PRODUCT_CODE."`
			INNER JOIN `".DELIVERY_DETAIL."` ON `".ORDER_DETAIL."`.`".OD_ORDER_ID."` = `".DELIVERY_DETAIL."`.`".DD_ORDER_ID."` AND  `".ORDER_DETAIL."`.`".OD_PRODUCT_CODE."` = `".DELIVERY_DETAIL."`.`".DD_PRODUCT_CODE."` 
			WHERE `".ORDER_DETAIL."`.`".OD_ID."` = " . $order_detail_id;

		return $this->getQuery($query);
	}

	//lấy tổng số lượng các sản phẩm được order
	public function get_amount_product_in_order($order_id)
	{
		$amount = 0;
		$this->db->where(OD_ORDER_ID,$order_id);
		$orders = $this->db->get(ORDER_DETAIL);
		if(count($orders->result())==0) return 0;
		foreach ($orders->result() as $order) {
			$amount += $order->{OD_QUANTITY} + $order->{OD_ADD};
		}
		return $amount;
	}


}