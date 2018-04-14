<?php

class CatalogueSale extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = ITEM_CLASSIFICATION_REGISTER;
		 
		$this->idCol = ICR_EVENT_CATEGORY;
	}
	
	/**
	* search user using OR condition.
	*/
	public function searchByKey($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			G.`".ICR_EVENT_CATEGORY."` AS id,
			G.`".ICR_ITEM_CATEGORY_NAME."` AS name 
			FROM `".ITEM_CLASSIFICATION_REGISTER."` G 
        ";

        $whereClause = "WHERE ";

		if($keyword["id"] != NULL && $keyword["id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".ICR_EVENT_CATEGORY."`"." = '".$keyword["id"]."' ";
		}

        if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".ICR_ITEM_CATEGORY_NAME."`"." LIKE '%".$keyword["name"]."%' ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY G.`".ICR_EVENT_CATEGORY."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }
}