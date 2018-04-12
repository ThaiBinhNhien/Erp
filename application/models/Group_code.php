<?php

class Group_code extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = GROUP_REPORT;
		 
		$this->idCol = GR_GROUP_CODE;
	}
	
	/**
	* search user using OR condition.
	*/
	public function searchGroupCode($id, $name = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			G.`".GR_GROUP_CODE."` AS group_code,
			G.`".GR_GROUP_NAME."` AS group_name,
			G.`".GR_GROUP_TYPE."` AS group_type, 
			G.`".GR_GROUP_SCHEDULE."` AS group_report 
			FROM `".GROUP_REPORT."` G 
        ";

        $whereClause = "WHERE ";
		
		if($id != NULL && $id != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".GR_GROUP_CODE."`"." = '".$id."' ";
		}
		
		if($name != NULL && $name != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".GR_GROUP_NAME."`"." LIKE '%".$name."%' ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY G.`".GR_GROUP_CODE."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }
}