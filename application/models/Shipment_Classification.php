<?php

class Shipment_Classification extends VV_Model
{ 
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DELIVERY_CLASSIFICATION;
		$this->idCol = DC_ID;
	} 

	/**
	* Function: getClassificationByBase
	* get delivery classification by base
	* @access public
	* @param $base_id : base id
	*/
	public function getClassificationByBase($base_id){
		$query = 'SELECT C.*
		FROM `'.DELIVERY_CLASSIFICATION.'` C 
		LEFT JOIN `'.ORDER_SHIPMENT.'` OS ON C.'.DC_ID.' = OS.`'.OS_DELIVERY_CLASSIFICATION.'` AND OS.`'.OS_UPDATE_DATE.'` >= DATE_SUB(CURDATE(),INTERVAL '.EXP_USABILITY.' MONTH)
		LEFT JOIN `'.DELIVERY_BASE.'` D ON D.`'.DB_DELIVERY_CLASSIFICATION.'` = C.'.DC_ID.' 
		WHERE D.`'.DB_BASE_CODE.'` = '.$base_id.' 
		GROUP BY C.'.DC_ID.'
		ORDER BY COUNT(OS.'.DC_ID.') DESC
		';

		return $this->getQuery($query);
	}

	/**
	* Function: getCustomerByClassification
	* get customer by classification
	* @access public
	* @param $classification : classification 
	*/
	public function getCustomerByClassification($classification, $transale = false,$search_name,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		if($transale == true) {
			$query = '
			SELECT 
			C.`'.CSHIPMENT_ID.'` AS customer_id, 
			C.`'.CSHIPMENT_ID.'` AS customer_shipment_id, 
			C.`'.CSHIPMENT_NAME.'` AS customer_shipment_name ';
		}
		else {
			$query = 'SELECT C.* '; 
		}
		
		$query .= 'FROM `'.CUSTOMER_SHIPMENT.'` C 
		INNER JOIN `'.CUSTOMER_CUSTOMERSHIPMENT.'` M ON C.`'.CSHIPMENT_ID.'` = M.`'.CCS_CUSTOMER_SHIPMENT.'` 
		INNER JOIN `'.DELIVERYCLASSIFICATION_CUSTOMER.'` D ON C.`'.CSHIPMENT_ID.'` = D.`'.DCC_CUSTOMER_ID.'` 
		LEFT JOIN (SELECT LD.id AS id, LD.`得意先ID` as customer_id FROM `注文発送詳細` LD 
INNER JOIN `注文発送` MT ON LD.`注文ID` = MT.id
WHERE MT.`発注日` >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH) LIMIT 0,5000) OS ON M.`得意先` = OS.customer_id  
		';
		if($classification != null && $classification != '') {
			$query .= 'WHERE D.`'.DCC_DELIVERY_CLASSIFICATION.'` = '.$classification .' ';
		}
		
		if($classification != null && $classification != '') {
			if($search_name != '' && $search_name != null) {
				$query .= " AND C.`".CSHIPMENT_NAME."` LIKE '%".$search_name."%'";
			}
		} else {
			if($search_name != '' && $search_name != null) {
				$query .= "WHERE C.`".CSHIPMENT_NAME."` LIKE '%".$search_name."%'";
			}
		}

		$query .= 'GROUP BY C.`'.CSHIPMENT_ID.'` ORDER BY COUNT(OS.'.OSHD_ID.') DESC';

		return $this->getQuery($query,$start_index,$number);
	}

	/**
	* search user using OR condition.
	*/
	public function searchClassification($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            C.`".DC_ID."` AS id,
            C.`".DC_NAME."` AS name,
            C.`".DC_NUMBER_CONTAINER."` AS number_container,
            C.`".DC_NUMBER_TRUCK."` AS number_truck,
            C.`".DC_NUMBER_MAX_TRUCK."` AS number_max_truck 
            FROM `".DELIVERY_CLASSIFICATION."` C 
        ";

        $whereClause = "WHERE ";

        if($keyword["id"] != NULL && $keyword["id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "C.`".DC_ID."`"." = '".$keyword["id"]."' ";
		}
		
		if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "C.`".DC_NAME."`"." LIKE '%".$keyword["name"]."%' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY C.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY C.`".DC_ID."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }

}