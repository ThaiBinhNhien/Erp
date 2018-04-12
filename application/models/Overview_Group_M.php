<?php
//category bán
class Overview_Group_M extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCTION_OVERVIEW_GROUP_M;
		$this->idCol = POG_CODE; 
	}

	/**
	* search user using OR condition. PRODUCTION_OVERVIEW_GROUP_M
	*/
	public function searchByKey($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            G.`".POG_CODE."` AS id,
			G.`".POG_NAME."` AS name 
			FROM `".PRODUCTION_OVERVIEW_GROUP_M."` G 
        ";

        $whereClause = "WHERE ";

		if($keyword["id"] != NULL && $keyword["id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".POG_CODE."`"." = '".$keyword["id"]."' ";
		}

        if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".POG_NAME."`"." LIKE '%".$keyword["name"]."%' ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY G.`".POG_CODE."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }
}