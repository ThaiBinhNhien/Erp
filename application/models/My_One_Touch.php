<?php

class My_one_touch extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = MY_ONE_TOUCH;
		$this->idCol = MOT_ID;
	}
	
	// Get Set product By Customer and classifition
	public function getProductByUserClassifition($user, $delivery_classifition,$customer = null,$department = null)
	{
		$query = "SELECT M.`".MOT_ID."` AS mot_id, M.`".MOT_NAME."` AS mot_name 
		FROM `".MY_ONE_TOUCH."` M 
		INNER JOIN `".MY_ONE_TOUCH_DETAIL."` D ON M.`".MOT_ID."` = D.`".MOTD_MOT_ID."` 
		WHERE M.`".MOT_USER_ID."` = '".$user."'
		AND M.`".MOT_DELIVERY_CLASSIFICATION."` = ".$delivery_classifition;

		if($customer != null && $customer != "") {
			$query .= " AND D.`".MOTD_CUSTOMER_ID."` = ".$customer;
		}

		if($department != null && $department != "") {
			$query .= " AND D.`".MOTD_DEPARTMENT_ID."` = ".$department;
		}

		$query .= " GROUP BY M.`".MOT_ID."`";

		return $this->getQuery($query);
	}

	// Get list
	public function getListSearch($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = " 
            SELECT 
			M.`".MOT_ID."` AS id,
			M.`".MOT_NAME."` AS name,
			M.`".MOT_USER_ID."` AS username,
			M.`".MOT_DELIVERY_CLASSIFICATION."` AS classification_id,
			C.`".DC_NAME."` AS classification_name  
            FROM `".MY_ONE_TOUCH."` AS M
            LEFT JOIN `".DELIVERY_CLASSIFICATION."` C ON M.`".MOT_DELIVERY_CLASSIFICATION."` = C.`".DC_ID."` 
        ";

        $whereClause = "WHERE ";

        if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "M.`".MOT_ID."`"." LIKE '%".$keyword."%' ";
		}

		if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "M.`".MOT_NAME."`"." LIKE '%".$keyword."%' ";
		}

		if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "M.`".MOT_USER_ID."`"." LIKE '%".$keyword."%' ";
		}

		if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "C.`".DC_NAME."`"." LIKE '%".$keyword."%' ";
		}

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by !== NULL && $order_type !== NULL){
			$query .= " ORDER BY M.`".$order_by."` ". $order_type;
        } else {
            $query .= " ORDER BY M.`".MOT_ID."` ".SORT_MASTER;
        }

		return $this->getQuery($query,$start_index,$number); 
         
    }
} 