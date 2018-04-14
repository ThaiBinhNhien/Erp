<?php

class TowelModel extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCT_TOWEL;
		 
		$this->idCol = PT_PRODUCT_CODE;
	}
	
	/**
	* search user using OR condition. PRODUCTION_OVERVIEW_GROUP_M
	*/
	public function searchByKey($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            G.`".PT_PRODUCT_CODE."` AS id,
            G.`".PT_PRODUCT_WEIGHT."` AS weight,
			G.`".PT_PRODUCT_TYPE."` AS type,
			T.`".POC_CATEGORY_NAME."` AS type_name,
			G.`".PT_PRODUCT_NAME."` AS name 
			FROM `".PRODUCT_TOWEL."` G 
			LEFT JOIN `".PRODUCTION_OVERVIEW_CATEGORY_M."` T ON G.`".PT_PRODUCT_TYPE."` = T.`".POC_PRODUCTION_SUMMARY_CODE."` 
        ";

        $whereClause = "WHERE ";

		if($keyword["id"] != NULL && $keyword["id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".PT_PRODUCT_CODE."`"." = '".$keyword["id"]."' ";
		}

        if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".PT_PRODUCT_NAME."`"." LIKE '%".$keyword["name"]."%' ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY G.`".PT_PRODUCT_CODE."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }
}