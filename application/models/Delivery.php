<?php

class Delivery extends VV_Model
{
	
	function __construct()
	{
		parent::__construct(); 
		$this->table_name = DELIVERY_DETAIL;
		$this->table_order = SALES_LEDGER; 
		$this->idCol = DD_ID;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}

	public function getByOrderId($order_id){
		$this->db->select(DELIVERY_DETAIL.".*,".PRODUCT_LEDGER.".".PL_PRODUCT_NAME.",".PRODUCT_LEDGER.".".PL_COLOR_TONE.",".PRODUCT_LEDGER.".".PL_STANDARD." ,".PRODUCT_LEDGER.".".PL_STANDARD.",".PRODUCT_LEDGER.".".PL_NUMBER_PACKAGE);
		$this->db->join(PRODUCT_LEDGER,"`".PRODUCT_LEDGER."`.`".PL_PRODUCT_ID."`=".DELIVERY_DETAIL.".".DD_PRODUCT_CODE,"left outer");
		$data = array(DD_ORDER_ID => $order_id);
		$result = $this->getWhere($data);
		return $result;
	}

	public function editOrder($id, $information)
	{
		$this->db->where(SL_ID, $id);
		$this->db->update($this->table_order, $information);
		return $this->db->affected_rows() !== false;
	}

	// Danh sách checklist của giao hàng
	public function getChecklistDelivery($user,$customer,$order_from,$order_to,$delivery_from,$delivery_to,$department,$order_no,$data_group = false,$listChecklist = NULL,$order_by = NULL,$order_type = NULL,$start_index = NULL,$number=NULL){ 
		$query = "
			SELECT 
			D.`".DD_ID."` AS id,
			D.`".DD_ORDER_ID."` AS order_id,
			P.`".PL_PRODUCT_ID."` AS product_id,
			P.`".PL_PRODUCT_CODE_SALE."` AS product_code_sale, 
			D.`".DD_PRODUCT_NAME."` AS product_name_sale,
			P.`".PL_STANDARD."` AS product_format,
			P.`".PL_COLOR_TONE."` AS product_color,
			P.`".PL_SPECIAL."` AS product_special,
			D.`".DD_UNIT_PRICE."` AS price,
			D.`".DD_DELIVERY_AMOUNT."` AS amount,
			O.`".OD_QUANTITY."` AS quantity_order,
			O.`".OD_ADD."` AS quantity_order_change,
			D.`".DD_QUANTITY."` AS quantity_delivery,
			D.`".DD_CHECK."` AS checklist,
			S.`".SL_SALES_DATE."` AS date_order,
			S.`".SL_REVENUE_DATE."` AS date_delivery,
			S.`".SL_UPDATE_DATE."` AS date_update,
			CUS.`".CUS_ID."` AS customer_id, 
			CUS.`".CUS_CUSTOMER_NAME."` AS customer_name,
			DEP.`".DL_DEPARTMENT_CODE."` AS department_id,
			DEP.`".DL_DEPARTMENT_NAME."` AS department_name 
			
			FROM `".DELIVERY_DETAIL."` D
			INNER JOIN `".SALES_LEDGER."` S ON D.`".DD_ORDER_ID."` = S.`".SL_ID."` 
			LEFT JOIN `".PRODUCT_LEDGER."` P ON D.`".DD_PRODUCT_CODE."` = P.`".PL_PRODUCT_ID."`
			INNER JOIN `".ORDER_DETAIL."` O ON D.`".DD_ORDER_DETAIL_ID."` = O.".OD_ID."
			INNER JOIN `".CUSTOMER."` CUS ON S.`".SL_CUSTOMER_ID."` = CUS.`".CUS_ID."`
			INNER JOIN `".DEPARTMENT_LEDGER."` DEP ON S.`".SL_DEPARTMENT_CODE."` = DEP.`".DL_DEPARTMENT_CODE."`  
			INNER JOIN `".CUSTOMER_DEPARTMENT."` KB ON S.`".SL_CUSTOMER_ID."` = KB.`".CD_CUSTOMER_ID."` AND S.`".SL_DEPARTMENT_CODE."` = KB.`".CD_DEPARTMENT_CODE."`
		";

		$whereClause = "WHERE "; 

		if($order_from != NULL && $order_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_SALES_DATE."` >= '$order_from 00:00:00' ";
        }

		if($order_to != NULL && $order_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_SALES_DATE."` <= '$order_to 23:59:59' ";
		}

		if($delivery_from != NULL && $delivery_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_REVENUE_DATE."` >= '$delivery_from 00:00:00' ";
        }

		if($delivery_to != NULL && $delivery_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_REVENUE_DATE."` <= '$delivery_to 23:59:59' ";
		}

		if($user != NULL && $user != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_USER_ID."` = '$user' ";
		}

		if($customer != NULL && $customer != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_CUSTOMER_ID."` = '$customer' ";
		}

		if($department != NULL && $department != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_DEPARTMENT_CODE."` = '$department' ";
		}

		if($order_no != NULL && $order_no != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`".DD_ORDER_ID."` = '$order_no' ";
		}

		if($this->level == "P"){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "S.`".SL_DEPARTMENT_CODE."` IN ( SELECT `".CUSTOMER_DEPARTMENT."`.`".CD_DEPARTMENT_CODE."` FROM `".CUSTOMER_DEPARTMENT."` WHERE `".CD_CUSTOMER_ID."`=S.`".SL_CUSTOMER_ID."` AND `".CD_USER_ID."`='".$this->LOGIN_INFO[U_ID]."')";
			//$whereClause .= "S.`".SL_CUSTOMER_ID."` IN ( SELECT `".CUSTOMER_DEPARTMENT."`.`".CD_CUSTOMER_ID."` FROM `".CUSTOMER_DEPARTMENT."` WHERE `".CD_USER_ID."`='".$this->LOGIN_INFO[U_ID]."')";
			//$whereClause .= "KB.`".CD_USER_ID."` = '".$this->LOGIN_INFO[U_ID]."' ";
		}

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

		if($data_group == true) {
			$query .= " GROUP BY D.`".DD_ORDER_ID."` 
			HAVING sum(D.`".DD_CHECK."`) <> count(D.`".DD_CHECK."`) ";
		}
		else {
			$query .= ($query == "WHERE "?"":"AND ");
			$query .= "D.`".DD_ORDER_ID."` IN (".$listChecklist.")";
		}

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY S.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY S.`".SL_ID."` ASC";  
		}

		if($start_index == null || $start_index == "") {
			$start_index = 0;
		}

		if($number == null || $number == "") {
			$number = 1000;
		}

		return $this->getQuery($query,$start_index,$number);
	}

	public function checkList($id, $information)
	{
		$this->db->where(DD_ID, $id);
		$this->db->update($this->table_name, $information);
		return $this->db->affected_rows() !== false;
	}

	/* CHECK khách hàng đó có hiển thị nút copy hay không */
	public function checkCopyOrderShipment($order_id,$department_id){
		$query = "
		SELECT SUM(D.`".DD_QUANTITY."`) AS count FROM `".DELIVERY_DETAIL."` D
		INNER JOIN `".SALES_LEDGER."` O ON D.`".DD_ORDER_ID."` = O.`".SL_ID."`
		LEFT JOIN `".CUSTOMER_DEPARTMENT."` P ON O.`".SL_DEPARTMENT_CODE."` = P.`".CD_DEPARTMENT_CODE."`
		WHERE O.`".SL_ID."` = ".$order_id." AND O.`".SL_DEPARTMENT_CODE."` = ".$department_id." AND P.`".CD_FL_COPY_SHIPMENT."` = true AND O.`".SL_FLG_COPY_SHIPMENT."` = false
		";

		$return = $this->getQuery($query);
		$number_record = 0;
		if($return != null) {
			$number_record = $return[0]['count'];
		}

		return $number_record;
	}

	/* CHECK khách hàng đó có department 99 hay không */
	public function checkCopyOrderShipmentDepartment($customer_id){
		$query = "
			SELECT COUNT(*) AS count FROM `".CUSTOMER_DEPARTMENT."` D 
			INNER JOIN `".CUSTOMER_CUSTOMERSHIPMENT."` MS ON D.`".CD_CUSTOMER_ID."` = MS.`".CCS_CUSTOMER."`
			INNER JOIN `".CUSTOMER_DEPARTMENT_SHIPMENT."` MD ON MS.`".CCS_CUSTOMER_SHIPMENT."` = MD.`".CDS_CUSTOMER_ID."` 
			WHERE D.`".CD_CUSTOMER_ID."` = ".$customer_id." AND D.`".CD_FL_COPY_SHIPMENT."` = true AND MD.`".CDS_DEPARTMENT_CODE."` = ".DEPARTMENT_SHIPMENT_COPY_ORDER."
		";

		$return = $this->getQuery($query);
		$number_record = 0;
		if($return != null) {
			$number_record = $return[0]['count'];
		}

		return $number_record;
	}


}