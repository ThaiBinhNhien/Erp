<?php

class Product extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCT_LEDGER;
		 
		$this->idCol = PL_PRODUCT_ID;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}
	
	public function get_all(){
		//__Get base code
		$base = $this->LOGIN_INFO[U_BASE_CODE];
		$this->db->select('*');
		$this->db->from(PRODUCT_BASE);
		$this->db->join(PRODUCT_LEDGER,PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`='.PRODUCT_BASE.'.`'.BB_PRODUCT_CODE.'`');
		$this->db->where(BB_BASE_CODE.'='.$base);
		$this->db->where(BB_CUSTOMER_NUMBER,1000);
		$query = $this->db->get();
		return $query->result();	
	}

	public function get_by_id($id)
	{
		$this->db->where(PL_PRODUCT_ID,$id);
		$query = $this->db->get(PRODUCT_LEDGER);
		if(count($query->result()) != 0) return $query->result()[0];
		else return null ;
	}

	/**
	* Function: get_by_set
	* @access public
	* @param $set_id
	*/
	public function get_by_set($set_id) {
		$query = '
		SELECT P.`'.PL_PRODUCT_ID.'` as product_id, 
		P.`'.PL_PRODUCT_NAME.'` as product_name, 
		P.`'.PL_STANDARD.'` as product_format, 
		P.`'.PL_COLOR_TONE.'` as product_color, 
		P.`'.PL_STANDARD.'` as product_unit, P.`'.PL_ORGANIZATION_WEIGHT.'` as product_weight 
		FROM `'.PRODUCT_LEDGER.'` P  
		LEFT JOIN `'.PRODUCT_SET_PRODUCT.'` S ON S.`'.PSP_PRODUCT_CODE.'` = P.`'.PL_PRODUCT_ID.'` 
		WHERE S.`'.PSP_PRODUCT_SET_CODE.'` = '.$set_id.' 
		ORDER BY S.`'.PSP_SERIAL_NUMBER.'` ASC ';

		return $this->getQuery($query);
	}

	/**
	* Function: get_by_set_shipment
	* @access public
	* @param $set_id_shipment
	*/
	public function get_by_set_shipment($set_id_shipment,$customer_shipment) {
		$query = '
		SELECT P.`'.PL_PRODUCT_ID.'` as product_id, 
		P.`'.PL_PRODUCT_NAME.'` as product_name, 
		P.`'.PL_STANDARD.'` as product_format, 
		P.`'.PL_COLOR_TONE.'` as product_color, 
		P.`'.PL_STANDARD.'` as product_unit, 
		P.`'.PL_NUMBER_PACKAGE.'` as product_value_unit,
		P.`'.PL_ORGANIZATION_WEIGHT.'` as product_weight 
		FROM `'.PRODUCT_LEDGER.'` P  
		INNER JOIN `'.PRODUCT_SET_PRODUCT_SHIPMENT.'` S ON S.`'.PSPS_PRODUCT_CODE.'` = P.`'.PL_PRODUCT_ID.'` 
		INNER JOIN `'.PRODUCT_BASE.'` PR ON PR.`'.BB_PRODUCT_CODE.'` = P.`'.PL_PRODUCT_ID.'` 
		INNER JOIN `'.CUSTOMER_CUSTOMERSHIPMENT.'` CM ON PR.`'.BB_CUSTOMER_NUMBER.'` = CM.`'.CCS_CUSTOMER.'` 
		WHERE S.`'.PSPS_PRODUCT_SET_CODE.'` = '.$set_id_shipment.'  
		AND CM.`'.CCS_CUSTOMER_SHIPMENT.'` = '.$customer_shipment.'  
		AND PR.`'.BB_BASE_CODE.'` = '.$this->LOGIN_INFO[U_BASE_CODE].'  
		GROUP BY S.`'.PSPS_PRODUCT_ID.'`   
		ORDER BY S.`'.PSPS_SERIAL_NUMBER.'` ASC ';

		return $this->getQuery($query);
	}

	/**
	* Function: get_by_one_touch
	* @access public
	* @param $one_touch 
	*/
	public function get_by_one_touch($one_touch, $customer, $department,$username) {
		$query = '
		SELECT P.`'.PL_PRODUCT_ID.'` as product_id, 
		P.`'.PL_PRODUCT_NAME.'` as product_name,  
		P.`'.PL_STANDARD.'` as product_format, 
		P.`'.PL_COLOR_TONE.'` as product_color, 
		P.`'.PL_STANDARD.'` as product_unit, 
		P.`'.PL_ORGANIZATION_WEIGHT.'` as product_weight,
		P.`'.PL_NUMBER_PACKAGE.'` as product_value_unit,
		MO.`'.MOTD_QUANTITY.'` as product_quantity, 
		MO.`'.MOTD_CONTAINER1.'` as container1, 
		MO.`'.MOTD_CONTAINER2.'` as container2,  
		MO.`'.MOTD_COMMENT.'` as comment 
		FROM `'.PRODUCT_LEDGER.'` P 
		INNER JOIN `'.MY_ONE_TOUCH_DETAIL.'` MO ON MO.`'.MOTD_PRODUCT_CODE.'` = P.`'.PL_PRODUCT_ID.'` 
		INNER JOIN `'.PRODUCT_BASE.'` PR ON PR.`'.BB_PRODUCT_CODE.'` = P.`'.PL_PRODUCT_ID.'` 
		INNER JOIN `'.CUSTOMER_CUSTOMERSHIPMENT.'` CM ON PR.`'.BB_CUSTOMER_NUMBER.'` = CM.`'.CCS_CUSTOMER.'` 
		WHERE MO.`'.MOTD_MOT_ID.'` = '.$one_touch.' 
		AND MO.`'.MOTD_CUSTOMER_ID.'` = '.$customer.' 
		AND MO.`'.MOTD_USER_ID.'` = "'.$username.'" 
		AND MO.`'.MOTD_DEPARTMENT_ID.'` = '.$department.'
		AND CM.`'.CCS_CUSTOMER_SHIPMENT.'` = '.$customer.'  
		AND PR.`'.BB_BASE_CODE.'` = '.$this->LOGIN_INFO[U_BASE_CODE].'  

		GROUP BY MO.`'.MOTD_ID.'`   
		 ';

		return $this->getQuery($query);
	}

	/**
	* Function: get_by_set
	* @access public
	* @param $set_id
	type : 
	1 : nhập, xuất, chuyển, bán từ kho
	2 : xuất hàng
	3 : bán cho khách sạn
	*/
	public function get_product_by_id($id, $type = null) {
		$query = "
		SELECT 
		P.`".PL_PRODUCT_ID."` as product_id, 
		P.`".PL_PRODUCT_NAME."` as product_name, 
		P.`".PL_STANDARD."` as product_format, 
		P.`".PL_COLOR_TONE."` as product_color, 
		P.`".PL_STANDARD."` as product_unit, 
		P.`".PL_ORGANIZATION_WEIGHT."` as product_weight, 
		P.`".PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT."` as product_container,
		P.`".PL_NUMBER_PACKAGE."` as product_value_unit 
		FROM `".PRODUCT_LEDGER."` P 
		WHERE P.`".PL_PRODUCT_ID."` = '".$id."' ";
		if($type != NULL && $type != ""){
			if($type == 1 || $type == "1") {
				$query .= " AND p.`".PL_CATEGORIES."` IN(1,2) ";
			} else if($type == 2 || $type == "2"){
				$query .= " AND p.`".PL_CATEGORIES."` IN(1) ";
			} else {
				$query .= " AND p.`".PL_CATEGORIES."` <> 2 ";
			}
		}

		$returnQuery = array();
		$getQuery = $this->getQuery($query);
		if($getQuery != null) {
			$returnQuery = $getQuery[0];
		}
		return $returnQuery;
	}


	public function get_not_special_product($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		$this->db->where(
			array(
				PL_SPECIAL."<>" => 1,
				PL_CATEGORIES."<>" => 2
			)
		);
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}
		$data = $this->db->get($this->table_name)->result_array();
		return ($data);
	}

	public function get_with_special_product($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		
		$this->db->where(PL_CATEGORIES."<> 2 OR ".PL_SPECIAL."=1");
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}
		$data = $this->db->get($this->table_name)->result_array();
		return ($data);
	}

	/*
	$type
	1 : nhập, xuất, chuyển, bán từ kho
	2 : xuất hàng
	3 : bán cho khách sạn 
	 */
	public function getProductView($product_id,$product_name,$type = null,
	$special,$start_index = NULL,$number = NULL,$product_by =NULL ,$product_type = NULL)
	{
		
		$query = "SELECt p.`".PL_PRODUCT_ID."` AS id,  p.`".PL_PRODUCT_NAME_BUY."` AS buy_product_name ,
						p.`".PL_PRODUCT_NAME."` AS sell_product_name , p.`".PL_PRODUCT_CODE_SALE."` AS sell_product_id,  p.`".PL_PRODUCT_CODE_BUY."` AS buy_product_id,p.`".PL_STANDARD."` AS product_standard , p.`".PL_COLOR_TONE."` AS color

					FROM `".PRODUCT_LEDGER."` p 
					
				";

				
				
		$whereClause = "WHERE ";
		if($product_id != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			//$whereClause .= "p.".PL_PRODUCT_ID."='$product_id'";
			$whereClause .= "(p.`".PL_PRODUCT_CODE_SALE."` = '$product_id' or p.`".PL_PRODUCT_CODE_BUY."` = '$product_id')";
			//$whereClause .= "p.".PL_PRODUCT_CODE_BUY." or like '%$product_id%'";
		}
		if($product_name != NULL){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "(p.`".PL_PRODUCT_NAME."` like '%$product_name%' or p.`".PL_PRODUCT_NAME_BUY."` like '%$product_name%') ";
		}
		if($type != NULL && $type != ""){
			if($type == 1 || $type == "1") {
				$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
				$whereClause .= "p.`".PL_CATEGORIES."` IN(1,2) ";
				$whereClause .= "AND p.`".PL_PRODUCT_CODE_BUY . "` IS  NOT NULL ";
			} else if($type == 2 || $type == "2"){
				$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
				$whereClause .= "p.`".PL_CATEGORIES."` IN(1) ";
				$whereClause .= "AND p.`".PL_PRODUCT_CODE_SALE . "` IS  NOT NULL ";
			} else {
				$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
				$whereClause .= "p.`".PL_CATEGORIES."` <> 2 ";
				$whereClause .= "AND p.`".PL_PRODUCT_CODE_SALE . "` IS  NOT NULL ";
			}
		}
 
		if($special != NULL && $special != ""){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "p.`".PL_SPECIAL."` <> 1 ";
		}

		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
		if($product_by != NULL && $product_type != NULL){
			$query .= " ORDER BY p.$product_by $product_type";
		} 
		return $this->getQuery($query,$start_index,$number);
	}


	/* 
	$type
	1 : nhập, xuất, chuyển, bán từ kho
	2 : xuất hàng
	3 : bán cho khách sạn  
	 */
	public function getProductSelectBox($product_code_sell,$product_code_buy,$type = null,$customer_shipment = null,$count = false,
		$start_index = NULL,$number = NULL,$product_by =NULL ,$product_type = NULL)
	{
		$this->db->select('*');
		$this->db->from(PRODUCT_LEDGER);
		if($customer_shipment != NULL && $customer_shipment != "") { 
			$this->db->join(PRODUCT_BASE, PRODUCT_BASE.'.'.BB_PRODUCT_CODE.' = '.PRODUCT_LEDGER.'.'.PL_PRODUCT_ID,'inner');
			$this->db->join(CUSTOMER_CUSTOMERSHIPMENT, PRODUCT_BASE.'.'.BB_CUSTOMER_NUMBER.' = '.CUSTOMER_CUSTOMERSHIPMENT.'.'.CCS_CUSTOMER,'inner');
		}

		if($product_code_sell != NULL && $product_code_sell != ""){
			$this->db->like(PL_PRODUCT_CODE_SALE,$product_code_sell, 'both');
		}
		if($product_code_buy != NULL && $product_code_buy != ""){
			$this->db->like(PL_PRODUCT_CODE_BUY,$product_code_buy, 'both');
		}

		$this->db->where(PL_SPECIAL . " <> ",1);

		if($type != NULL && $type != ""){
			if($type == 1 || $type == "1") {
				$arr_type = array("1", "2");
				$this->db->where_in(PL_CATEGORIES, $arr_type);
				$this->db->where(PL_PRODUCT_CODE_BUY . " is  NOT NULL");
			} else if($type == 2 || $type == "2"){
				$arr_type = array("1");
				$this->db->where_in(PL_CATEGORIES, $arr_type);
				$this->db->where(PL_TYPE_SHOW_ORDER . " <> ",1);
				$this->db->where(PL_PRODUCT_CODE_SALE . " is  NOT NULL");
			} else {
				$where_cate = "(`".PL_CATEGORIES."` = 1 OR `".PL_CATEGORIES."` IS NULL)";
				$this->db->where($where_cate);
				$this->db->where(PL_TYPE_SHOW_ORDER . " <> ",1);
				$this->db->where(PL_PRODUCT_CODE_SALE . " is  NOT NULL");
			}
		}

		if($customer_shipment != NULL && $customer_shipment != "") {
			$this->db->where(CUSTOMER_CUSTOMERSHIPMENT.'.'.CCS_CUSTOMER_SHIPMENT,$customer_shipment); 
			$this->db->where(PRODUCT_BASE.'.'.BB_BASE_CODE."=".$this->LOGIN_INFO[U_BASE_CODE]); 
		}

		$this->db->group_by(PRODUCT_LEDGER.'.'.PL_PRODUCT_ID);

		if($count == true) {
			$num_results = $this->db->count_all_results();
			return $num_results;
		} else {
			$this->db->limit($number,$start_index);
			$result = $this->db->get()->result_array();
			return $result;
		}
	}


	public function search_by_sale_code_not_special($code){
		$query = "SELECT `".PL_PRODUCT_ID."` AS `id`, `".PL_PRODUCT_NAME."` AS `name`, `".PL_COLOR_TONE."` AS `color`, `".PL_STANDARD."` AS `standard`, `".PL_NUMBER_PACKAGE."` AS `package_size`, `".PL_PRODUCT_CODE_SALE."` AS `sale_code` FROM `".PRODUCT_LEDGER."` WHERE `".PL_SPECIAL."` <> 1 AND `".PL_PRODUCT_CODE_SALE."` LIKE '$code%' ESCAPE '!' AND `".PL_CATEGORIES."`<>2 LIMIT 10";
		return $this->getQuery($query);
	}

	public function search_by_sale_code_with_special($code,$customer_id,$base_id){
		$product_search = '';
		if($code != NULL && $code != ''){
			$product_search = "AND `".PL_PRODUCT_CODE_SALE."` LIKE '$code%' ESCAPE '!'";
		}
		$query = "sELECT `".PL_PRODUCT_ID."` AS `id`, IF(`".BB_PRODUCT_NAME."` IS NULL OR `".BB_PRODUCT_NAME."`='', `".PL_PRODUCT_NAME."`,`".BB_PRODUCT_NAME."`) AS `name`, `".PL_COLOR_TONE."` AS `color`, `".PL_STANDARD."` AS `standard`, `".PL_NUMBER_PACKAGE."` AS `package_size`, `".PL_PRODUCT_CODE_SALE."` AS `sale_code`,`".PL_SPECIAL."` AS special FROM `".PRODUCT_LEDGER."` JOIN `".PRODUCT_BASE."` ON `".PRODUCT_LEDGER."`.".PL_PRODUCT_ID."=`".PRODUCT_BASE."`.".BB_PRODUCT_CODE." WHERE ".BB_BASE_CODE."='$base_id' AND ".BB_CUSTOMER_NUMBER."='$customer_id' $product_search AND `".PL_CATEGORIES."`<>2 AND `".PL_TYPE_SHOW_ORDER."`<>1 LIMIT 10";
		return $this->getQuery($query);
	}
	public function getArrValueOfColumn($type){
		if($type == 1){
			$sql = "sELECT `".PL_PRODUCT_CODE_BUY."` AS `key` FROM `".PRODUCT_LEDGER."` ";
		}else{
			$sql = "sELECT `".PL_PRODUCT_CODE_SALE."` AS `key` FROM `".PRODUCT_LEDGER."` ";
		}

		return  $this->getQuery($sql);
	}
}