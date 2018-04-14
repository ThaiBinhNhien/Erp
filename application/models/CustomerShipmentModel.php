<?php

class CustomerShipmentModel extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = CUSTOMER_SHIPMENT;
		 
		$this->idCol = CSHIPMENT_ID;
	}
	
	/**
	* search user using OR condition. PRODUCTION_OVERVIEW_GROUP_M
	*/
	public function searchByKey($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            G.`".CSHIPMENT_ID."` AS id,
			G.`".CSHIPMENT_NAME."` AS name,  
			GROUP_CONCAT(DISTINCT M.`".CUS_CUSTOMER_NAME."`,'<br>') as customer_name 
			FROM `".CUSTOMER_SHIPMENT."` G 
			INNER JOIN `".CUSTOMER_CUSTOMERSHIPMENT."` D ON G.`".CSHIPMENT_ID."` = D.`".CCS_CUSTOMER_SHIPMENT."` 
			LEFT JOIN `".CUSTOMER."` M ON D.`".CCS_CUSTOMER."` = M.`".CUS_ID."` 
        ";

        $whereClause = "WHERE ";

		if($keyword["id"] != NULL && $keyword["id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".CSHIPMENT_ID."`"." = '".$keyword["id"]."' ";
		}

        if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".CSHIPMENT_NAME."`"." LIKE '%".$keyword["name"]."%' ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

		$query .= " GROUP BY G.`".CSHIPMENT_ID."` ";
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY G.`".CSHIPMENT_ID."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
	}
	
	public function getByIdCustomer($id)
	{
		
		$this->db->where($this->idCol, $id);
		if(isset($this->colAuth) && !empty($this->colAuth) && isset($this->valAuth) && !empty($this->valAuth) && $this->level == "P"){
			$this->db->where(array($this->colAuth => $this->valAuth));
		}
		
		$data = $this->db->get($this->table_name)->result_array();
		return end($data);
	}

	public function getCustomerByCustomerM($id_customer_shipment){
		$query_string = "
		SELECT 
		`".CUSTOMER."`.`".CUS_ID."`
		FROM `".CUSTOMER_CUSTOMERSHIPMENT."`
		LEFT JOIN `".CUSTOMER."` ON `".CUSTOMER_CUSTOMERSHIPMENT."`.`".CCS_CUSTOMER."` = `".CUSTOMER."`.`".CUS_ID."`
		WHERE `".CUSTOMER_CUSTOMERSHIPMENT."`.`".CCS_CUSTOMER_SHIPMENT."` = ".$id_customer_shipment."
		";

		$query = $this->getQuery($query_string);

		return $query;

	}
}