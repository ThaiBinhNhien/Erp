<?php

class My_one_touch_detail extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = MY_ONE_TOUCH_DETAIL;
		$this->idCol = MOTD_ID;
	}

	// getWhereDetail
	public function getWhereDetail($id_my_one_touch = false,$user_my_one_touch = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		$query = "
            SELECT 
			M.*,
			C.`".CSHIPMENT_NAME."` AS customer_name, 
			D.`".DSL_DEPARTMENT_NAME."` AS department_name,  
			P.`".PL_PRODUCT_NAME."` AS product_name 
            FROM `".MY_ONE_TOUCH_DETAIL."` AS M
			LEFT JOIN `".CUSTOMER_SHIPMENT."` C ON M.`".MOTD_CUSTOMER_ID."` = C.`".CSHIPMENT_ID."` 
			LEFT JOIN `".DEPARTMENT_SHIPMENT_LEDGER."` D ON M.`".MOTD_DEPARTMENT_ID."` = D.`".DSL_DEPARTMENT_CODE."` 
			LEFT JOIN `".PRODUCT_LEDGER."` P ON M.`".MOTD_PRODUCT_CODE."` = P.`".PL_PRODUCT_ID."` 
		";
		
		$whereClause = "WHERE ";

        if($id_my_one_touch != NULL && $id_my_one_touch != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "M.`".MOTD_MOT_ID."`"." = '".$id_my_one_touch."' ";
		}

		if($user_my_one_touch != NULL && $user_my_one_touch != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "M.`".MOTD_USER_ID."`"." = '".$user_my_one_touch."' ";
		}
		
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by !== NULL && $order_type !== NULL){
			$query .= " ORDER BY S.`".$order_by."` ". $order_type;
        }

		return $this->getQuery($query,$start_index,$number);
	}

	public function getAvaiable(){
		$this->db->select(MY_ONE_TOUCH_DETAIL.".*");
		$this->db->join(MY_ONE_TOUCH,"`".MY_ONE_TOUCH."`.`".MOT_ID."`=".MY_ONE_TOUCH_DETAIL.".".MOTD_MOT_ID);
		return $this->db->get(MY_ONE_TOUCH_DETAIL)->result_array();
	}
	
} 