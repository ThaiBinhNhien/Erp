<?php

class CatalogueBuy extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_EVENT;
		 
		$this->idCol = TE_ID;
	}
	
	/**
	* search user using OR condition.
	*/
	public function searchByKey($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			G.`".TE_ID."` AS id,
			G.`".TE_ITEM_CATEGORY_NAME."` AS name,
			G.`".TE_TYPE_EVENT."` AS type,
			G.`".TE_FLG_OUTSOURCE."` AS flg_outsource  
			FROM `".T_EVENT."` G 
        ";

        $whereClause = "WHERE ";

		if($keyword["id"] != NULL && $keyword["id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".TE_ID."`"." = '".$keyword["id"]."' ";
		}

        if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".TE_ITEM_CATEGORY_NAME."`"." LIKE '%".$keyword["name"]."%' ";
		}

		if($keyword["type"] != NULL && $keyword["type"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".TE_TYPE_EVENT."`"." = '".$keyword["type"]."' ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY G.`".TE_ID."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }
}