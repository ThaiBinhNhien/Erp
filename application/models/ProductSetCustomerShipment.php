<?php

class ProductSetCustomerShipment extends VV_Model
{
	 
	function __construct()
	{
		parent::__construct();
		$this->table_name = CUSTOMER_PRODUCTSET;
	} 
	 
    // get
    public function getSetProductCustomer($set_product = NULL,$customer_code = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            S.`".CP_PRODUCT_SET."` AS set_product,
            S.`".CP_CUSTOMER."` AS customer_code 
            FROM `".CUSTOMER_PRODUCTSET."` S 
        ";

        $whereClause = "WHERE ";

        if($set_product != NULL && $set_product != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "S.`".CP_PRODUCT_SET."`"." = '".$set_product."' ";
        }

        if($customer_code != NULL && $customer_code != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "S.`".CP_CUSTOMER."`"." = '".$customer_code."' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by !== NULL && $order_type !== NULL){
			$query .= " ORDER BY S.`".$order_by."` ". $order_type;
        }

		return $this->getQuery($query,$start_index,$number); 
         
    }
    
} 