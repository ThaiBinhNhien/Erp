<?php

class Inventory extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = "inventory";
		$this->LEVEL = $this->session->userdata('request-level');
        $this->LOGIN_INFO = $this->session->userdata('login-info');
	}

	/**
	* Function: getListInventory
	* Danh sách tồn kho
	* @access public 
	*/
	public function getListInventory($stock = NULL,$type = NULL,$date = NULL,$order = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
        $query = "
		SELECT 
		*,
		SUM(V.number_import - V.number_repay - V.number_export) AS zaikosu
		FROM view_infor_receipt V
		";

		$whereClause = "WHERE "; 

		if($stock != NULL && $stock != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_code = '$stock' ";
		}

		if($type != NULL && $type != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_type_buy = '$type' ";
		}

		if($date != NULL && $date != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_creater <= '$date 23:59:59' ";
		}
		
		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_code = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
		}
		
		if($order != NULL && $order != '') {
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_id IN (SELECT 
			OD.`商品コード`
			FROM `注文伝票明細` OD
			
			GROUP BY OD.`商品コード`) ";
		}
		
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
		
		$query .= " GROUP BY V.product_id,V.price_buy, V.place_buy_id, V.product_category_buy_id, V.base_code, V.event_id ";
		$query .= " HAVING SUM(V.number_import) > 0 AND SUM(V.number_export) > 0 AND SUM(V.number_import - V.number_repay - V.number_export) <> 0";

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY V.`".$order_by."` ". $order_type; 
		}

		return $this->getQuery($query,$start_index,$number);
	}
	

	/**
	* Function: getListInventoryOrder
	* Danh sách đặt order nhập
	* @access public 
	*/
	public function getListInventoryOrder($stock = NULL,$type = NULL,$date = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
        $query = "
		SELECT 
		*,
		SUM(V.number_order) as quantity_order
		FROM view_infor_receipt V
		";

		$whereClause = "WHERE "; 

		if($stock != NULL && $stock != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_code = '$stock' ";
		}

		if($type != NULL && $type != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_type_buy = '$type' ";
		}

		if($date != NULL && $date != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_creater <= '$date 23:59:59' ";
		}
		
		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_code = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }
		
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
		
		$query .= " GROUP BY V.product_id,V.price_buy, V.place_buy_id, V.product_category_buy_id, V.base_code, V.event_id ";
		$query .= " HAVING SUM(V.number_order) > 0 ";

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY V.`".$order_by."` ". $order_type; 
		}

		return $this->getQuery($query,$start_index,$number);
	}	
	
	/**
	* Function: getListInventoryWashingPowder
	* @access public 
	*/
	public function getListInventoryWashingPowder($date_from = NULL,$date_to = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
        $query = "SELECT 
		N.`".TGRI_PRODUCT_ID."` AS product_code,
		S.`".PL_PRODUCT_NAME."` AS product_name,
		S.`".PL_REMARKS."` AS product_note,
		S.`".PL_COLOR_TONE."` AS product_color, 
		S.`".PL_STANDARD."` AS product_format,
		S.`".PL_STANDARD."` AS product_unit,
		N.`".TGRI_UNIT_PRICE."` AS price,
		S.`".PL_T_CATALOGUE."` AS product_event_id,
		H.`".TE_ITEM_CATEGORY_NAME."` AS product_event_name,
		N.`".TGRI_BASE_CODE."` AS stock_id,
		B.`".BM_BASE_NAME."` AS stock_name,
		PB.`".SUP_ID."` AS company_id,
		PB.`".SUP_SUPPLIER_COMPANY_NAME."` AS company_name,
		S.`".PL_STANDARD_STOCK_NUMBER."` AS product_inventory_standard,
		(SUM(N.`".TGRI_GOODS_RECEIPT."` - N.`".TGRI_NUMBER_OF_GOODS_ISSUED."` - N.`".TGRI_NUMBER_OF_RETURNS."`)+SUM(N.`".TGRI_NUMBER_OF_GOODS_ISSUED."`)-SUM((N.`".TGRI_GOODS_RECEIPT."`-N.`".TGRI_NUMBER_OF_RETURNS."`))) as number_last_inventory,
		SUM((N.`".TGRI_GOODS_RECEIPT."`-N.`".TGRI_NUMBER_OF_RETURNS."`)) as number_import,
		SUM(N.`".TGRI_UNIT_PRICE."` * (N.`".TGRI_GOODS_RECEIPT."`-N.`".TGRI_NUMBER_OF_RETURNS."`)) as amount_import,
		SUM(N.`".TGRI_NUMBER_OF_GOODS_ISSUED."`) as number_export,
		SUM(N.`".TGRI_UNIT_PRICE."` * N.`".TGRI_NUMBER_OF_GOODS_ISSUED."`) as amount_export,
		SUM(N.`".TGRI_GOODS_RECEIPT."` - N.`".TGRI_NUMBER_OF_GOODS_ISSUED."` - N.`".TGRI_NUMBER_OF_RETURNS."`) as number_inventory,
		N.`".TGRI_CUMULATIVE_GOODS_RECEIPT."` AS accumulative_import,
		B.`".BM_BASE_NAME."` AS base_name  
		FROM `".T_GOODS_RECEIPT_INFORMATION."` N
		LEFT JOIN `".PRODUCT_LEDGER."` S ON N.`".TGRI_PRODUCT_ID."` = S.`".PL_PRODUCT_ID."` 
		LEFT JOIN `".BASE_MASTER."` B ON N.`".TGRI_BASE_CODE."` = B.`".BM_BASE_CODE."` 
		LEFT JOIN `".T_EVENT."` H ON S.`".PL_T_CATALOGUE."` = H.`".TE_ID."` 
		LEFT JOIN `".T_GOODS_RECEIPT."` IM ON N.`".TGRI_GOODS_RECEIPT_SLIP_ID."` = IM.`".GR_ID."`
		LEFT JOIN `".T_SUPPLIER."` PB ON IM.`".GR_VENDOR_ID."` = PB.`".SUP_ID."` 
		";

		$whereClause = "WHERE S.`".PL_CATEGORIES."`=2 "; 

		if($date_from != NULL && $date_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "N.`".TGRI_ACCRUAL_DATE."` >= '$date_from 00:00:00' ";
        }

		if($date_to != NULL && $date_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "N.`".TGRI_ACCRUAL_DATE."` <= '$date_to 23:59:59' ";
		}

		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "N.`".TGRI_BASE_CODE."` = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
		
		$query .= " GROUP BY N.`".TGRI_PRODUCT_ID."`,N.`".TGRI_UNIT_PRICE."`,N.`".TGRI_BASE_CODE."`,PB.`".SUP_ID."`,S.`".PL_T_CATALOGUE."`,N.`".TGRI_INVENTORY_LOCATION_ID."`";
		$query .= " HAVING SUM(N.`".TGRI_GOODS_RECEIPT."` + N.`".TGRI_NUMBER_OF_GOODS_ISSUED."` + N.`".TGRI_NUMBER_OF_RETURNS."`) <> 0";

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY N.`".$order_by."` ". $order_type;
		}
		return $this->getQuery($query,$start_index,$number);
	}

	/**
	* Function: getListShipmentStatus
	* @access public 
	*/ 
	public function getListShipmentStatus($date_from = NULL,$date_to = NULL,$product = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
        $query = "
			SELECT
			O.`".OS_SHIPMENT_DECISION_DATETIME."` AS date_update,
			D.`".OSHD_PRODUCT_CODE."` AS product_id,
			S.`".PL_PRODUCT_CODE_SALE."` AS product_code_sell,
			S.`".PL_PRODUCT_NAME."` AS product_name_sell,
			S.`".PL_COLOR_TONE."` AS product_color,
			S.`".PL_STANDARD."` AS product_format,
			D.`".OSHD_DEPARTMENT_ID."` AS department_id,
			P.`".DL_DEPARTMENT_NAME."` AS department_name,
			D.`".OSHD_CUSTOMER_ID."` AS customer_id,
			C.`".CUS_CUSTOMER_NAME."` AS customer_name,
			(SUM(D.`".OSHD_QUANTITY."`)+SUM(D.`".OSHD_QUANTITY_CHANGE."`)) AS number_order,
			SUM(D.`".OSHD_DELIVERY."`) AS number_delivery 
			FROM `".ORDER_SHIPMENT_DETAIL."` D
			LEFT JOIN `".PRODUCT_LEDGER."` S ON D.`".OSHD_PRODUCT_CODE."` = S.`".PL_PRODUCT_ID."`
			LEFT JOIN `".ORDER_SHIPMENT."` O ON D.`".OSHD_ORDER_ID."` = O.`".OS_ID."` 
			LEFT JOIN `".CUSTOMER."` C ON D.`".OSHD_CUSTOMER_ID."` = C.`".CUS_ID."` 
			LEFT JOIN `".DEPARTMENT_LEDGER."` P ON D.`".OSHD_DEPARTMENT_ID."` = P.`".DL_DEPARTMENT_CODE."` 
		";

		$whereClause = "WHERE "; 

		if($date_from != NULL && $date_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".OS_SHIPMENT_DECISION_DATETIME."` >= '$date_from 00:00:00' ";
        }

		if($date_to != NULL && $date_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".OS_SHIPMENT_DECISION_DATETIME."` <= '$date_to 23:59:59' ";
		}

		if($product != NULL && $product != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`".OSHD_PRODUCT_CODE."` = '$product' ";
		}

		$whereClause .= ($whereClause=="WHERE "?"":"AND ");
		$whereClause .= "O.`".OS_STATUS."` IN (4,5) ";

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

		if($product != NULL && $product != ''){
			$query .= " GROUP BY D.`".OSHD_PRODUCT_CODE."`,O.`".OS_SHIPMENT_DECISION_DATETIME."`,D.`".OSHD_DEPARTMENT_ID."`,D.`".OSHD_CUSTOMER_ID."` ";
		} else {
			$query .= " GROUP BY D.`".OSHD_PRODUCT_CODE."`";
		}
		
		$query .= " HAVING SUM(D.`".OSHD_DELIVERY."`) > 0";

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY N.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY O.`".OS_SHIPMENT_DECISION_DATETIME."` ASC"; 
		}

		return $this->getQuery($query,$start_index,$number);
	}

	/**
	* Function: getListCheckedPrice
	* Danh sách đã check đơn giá
	* @access public 
	* @return string
	*/ 
	public function getListCheckedPrice($keyword = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		$query = 
		"
		SELECT GROUP_CONCAT(DISTINCT V.id_import) AS listchecked FROM view_infor_import V 
		";

		$whereClause = $this->funcSearchImport($keyword);

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

		$query .= " GROUP BY V.id_import";
		$query .= " HAVING (SUM(V.check_price) = COUNT(V.check_price))";

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY V.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY V.detail_date ASC";
		}

		$array = $this->getQuery($query,$start_index,$number);

		$string = '';

		foreach ($array as $key => $value) {
			$string .= ",".$value['listchecked']."";
		}
		if($string != '') {
			$string = substr($string, 1); // remove leading ","
		}

		return $string;
	}

	/**
	* Function: funcSearchImport
	* Hàm Tìm kiếm
	* @access public 
	*/ 
	public function funcSearchImport($keyword = NULL)
	{
		$whereClause = "WHERE "; 

		// Nơi bán ra
		if($keyword["place_sale"] != NULL && $keyword["place_sale"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_sale_id = '".$keyword["place_sale"]."' ";
		}

		// Nơi mua vào
		if($keyword["place_buy"] != NULL && $keyword["place_buy"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_buy_id = '".$keyword["place_buy"]."' ";
		}

		// Ngày nhập kho
		if($keyword["date_import_from"] != NULL && $keyword["date_import_from"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.detail_date >= '".$keyword["date_import_from"]." 00:00:00' ";
        }

		if($keyword["date_import_to"] != NULL && $keyword["date_import_to"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.detail_date <= '".$keyword["date_import_to"]." 23:59:59' ";
		}

		// Ngày giao hàng
		if($keyword["date_delivery_from"] != NULL && $keyword["date_delivery_from"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.order_date_delivery >= '".$keyword["date_delivery_from"]." 00:00:00' ";
        }

		if($keyword["date_delivery_to"] != NULL && $keyword["date_delivery_to"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.order_date_delivery <= '".$keyword["date_delivery_to"]." 23:59:59' ";
		}

		// hàng mua vào : Công ty đó hoặc order ngoài [ 0, 1]
		if($keyword["type_report"] != NULL && $keyword["type_report"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_sale_type_order = '".$keyword["type_report"]."' ";
		}

		// check đơn giá [ 0, 1]
		if(isset($keyword["check_price"]) && $keyword["check_price"] != NULL && $keyword["check_price"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.check_price = '".$keyword["check_price"]."' ";
		}

		// Loại sản phẩm mua vào [1] hoac bột giặt [2]
		if(isset($keyword["product_type_buy"]) && $keyword["product_type_buy"] != NULL && $keyword["product_type_buy"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_type_buy = '".$keyword["product_type_buy"]."' ";
		}

		// Where in những hóa đơn xuất nào
		if(isset($keyword["where_in_import"]) && $keyword["where_in_import"] != NULL && $keyword["where_in_import"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.id_import IN (".$keyword["where_in_import"].") ";
		}

		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_id = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }
		
		return $whereClause;
	}
	/**
	* Function: getListInforImport
	* Danh Sách chi tiết nhập kho [mua vào] 
	* @access public 
	*/ 
	public function getListInforImport($keyword = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		$query = 
		"
			SELECT * FROM view_infor_import V 
		";

		$whereClause = $this->funcSearchImport($keyword);

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY V.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY V.detail_date ASC";
		}

		return $this->getQuery($query,$start_index,$number);
	}

	/**
	* Function: getListInforExport
	* Danh Sách chi tiết xuất kho [bán ra]
	* @access public 
	*/ 
	public function getListInforExport($keyword = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		$query = 
		"
			SELECT * FROM view_infor_export V 
		";

		$whereClause = "WHERE "; 

		// Nơi bán ra
		if($keyword["place_sale"] != NULL && $keyword["place_sale"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_sale_id = '".$keyword["place_sale"]."' ";
		}

		// Nơi mua vào
		if($keyword["place_buy"] != NULL && $keyword["place_buy"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_buy_id = '".$keyword["place_buy"]."' ";
		}

		// Ngày xuất kho
		if($keyword["date_export_from"] != NULL && $keyword["date_export_from"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_export >= '".$keyword["date_export_from"]." 00:00:00' ";
        }

		if($keyword["date_export_to"] != NULL && $keyword["date_export_to"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_export <= '".$keyword["date_export_to"]." 23:59:59' ";
		}

		// nơi bán ra : Công ty đó hoặc order ngoài [ 0, 1]
		if($keyword["type_report"] != NULL && $keyword["type_report"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_sale_type_order = '".$keyword["type_report"]."' ";
		}

		// Loại sản phẩm mua vào [1] hoac bột giặt [2]
		if($keyword["product_type_buy"] != NULL && $keyword["product_type_buy"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_type_buy = '".$keyword["product_type_buy"]."' ";
		}

		// Phân loại rửa
		if(isset($keyword["product_use_wash"]) && $keyword["product_use_wash"] != NULL && $keyword["product_use_wash"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_use_wash = '".$keyword["product_use_wash"]."' ";
		}

		// Phân loại dùng để bán
		if(isset($keyword["product_use_sell"]) && $keyword["product_use_sell"] != NULL && $keyword["product_use_sell"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_use_sell = '".$keyword["product_use_sell"]."' ";
		}

		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.factory_id = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY V.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY V.date_export ASC";
		}

		return $this->getQuery($query,$start_index,$number);
	}

	/**
	* Function: getListInforReceipt
	* Danh Sách chi tiết order - xuất - nhập kho
	* @access public 
	*/ 
	public function getListInforReceipt($keyword = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		$query = 
		"
			SELECT * FROM view_infor_receipt V 
		";

		$whereClause = "WHERE "; 

		// Nơi bán ra
		if($keyword["product_id"] != NULL && $keyword["product_id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_id = '".$keyword["product_id"]."' ";
		}

		// Nơi bán ra
		if($keyword["place_sale"] != NULL && $keyword["place_sale"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_sale_id = '".$keyword["place_sale"]."' ";
		}

		// Nơi mua vào
		if($keyword["place_buy"] != NULL && $keyword["place_buy"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_buy_id = '".$keyword["place_buy"]."' ";
		}

		// Ngày xuất kho
		if($keyword["date_from"] != NULL && $keyword["date_from"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_creater >= '".$keyword["date_from"]." 00:00:00' ";
        }

		if($keyword["date_to"] != NULL && $keyword["date_to"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_creater <= '".$keyword["date_to"]." 23:59:59' ";
		}

		// nơi bán ra : Công ty đó hoặc order ngoài [ 0, 1]
		if($keyword["type_report"] != NULL && $keyword["type_report"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.place_sale_type_order = '".$keyword["type_report"]."' ";
		}

		// Loại sản phẩm mua vào [1] hoac bột giặt [2]
		if($keyword["product_type_buy"] != NULL && $keyword["product_type_buy"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_type_buy = '".$keyword["product_type_buy"]."' ";
		}

		// Phân loại rửa
		if(isset($keyword["product_use_wash"]) && $keyword["product_use_wash"] != NULL && $keyword["product_use_wash"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_use_wash = '".$keyword["product_use_wash"]."' ";
		}

		// Phân loại dùng để bán
		if(isset($keyword["product_use_sell"]) && $keyword["product_use_sell"] != NULL && $keyword["product_use_sell"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_use_sell = '".$keyword["product_use_sell"]."' ";
		}

		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_code = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY V.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY V.date_creater ASC";
		}

		return $this->getQuery($query,$start_index,$number);
	}

}