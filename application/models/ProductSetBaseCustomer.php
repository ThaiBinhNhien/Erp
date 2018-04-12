<?php

class ProductSetBaseCustomer extends VV_Model
{
	 
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCT_SET_CUSTOMER;
	} 
	 
    // get
    public function getSetProductBaseCustomer($base_code = NULL,$set_product = NULL,$customer_code = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            S.`".PSC_PRODUCT_SET_CODE."` AS set_product,
            S.`".PSC_BASE_CODE."` AS base_code,
            S.`".PSC_CUSTOMER_ID."` AS customer_code 
            FROM `".PRODUCT_SET_CUSTOMER."` S 
        ";

        $whereClause = "WHERE ";

        if($base_code != NULL && $base_code != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "S.`".PSC_BASE_CODE."`"." = '".$base_code."' ";
        }

        if($set_product != NULL && $set_product != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "S.`".PSC_PRODUCT_SET_CODE."`"." = '".$set_product."' ";
        }

        if($customer_code != NULL && $customer_code != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "S.`".PSC_CUSTOMER_ID."`"." = '".$customer_code."' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by !== NULL && $order_type !== NULL){
			$query .= " ORDER BY S.`".$order_by."` ". $order_type;
        }

		return $this->getQuery($query,$start_index,$number); 
         
    }

    public function deleteSetProductBase(){
        $query = "
            DELETE FROM `".PRODUCT_SET_CUSTOMER."`
            WHERE `".PRODUCT_SET_CUSTOMER."`.`".PSC_CUSTOMER_ID."` IS NULL
        ";

		return $this->db->query($query); 
         
    }

    public function deleteSetProductCustomer(){
        $query = "
            DELETE FROM `".PRODUCT_SET_CUSTOMER."`
            WHERE `".PRODUCT_SET_CUSTOMER."`.`".PSC_BASE_CODE."` IS NULL
        ";

		return $this->db->query($query); 
         
    }
} 