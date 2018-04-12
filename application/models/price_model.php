<?php

class Price_model extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		 
        $this->table_name = PRODUCT_BASE;
	} 
	
	/**
	* search user using OR condition.
	*/
	public function searchPriceSale($input_search_base = NULL,$input_search_product = NULL,$input_search_customer = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            P.`".BB_ID."` AS id,
            P.`".BB_PRODUCT_CODE."` AS product_id,
            S.`".PL_PRODUCT_CODE_SALE."` AS product_code, 
            P.`".BB_PRODUCT_NAME."` AS product_name,
            P.`".BB_BASE_CODE."` AS basecode_code,
            B.`".BM_BASE_NAME."` AS basecode_name,
            P.`".BB_CUSTOMER_NUMBER."` AS customer_code,
            C.`".CUS_CUSTOMER_NAME."` AS customer_name,
            P.`".BB_UNIT_SELLING_PRICE."` AS price,
            P.`".BB_GAICHYU_PRICE."` AS price_gaichyu,
            B.`".BM_MASTER_CHECK."` AS gaichyu_flag,
            (SELECT GROUP_CONCAT(DISTINCT CD.`".CD_USER_ID."`)
            FROM `".CUSTOMER_DEPARTMENT."` CD 
            INNER JOIN `".USER_MASTER."` US ON CD.`".CD_USER_ID."` = US.`".U_ID."` 
            INNER JOIN `".BASE_MASTER."` BA ON US.`".U_BASE_CODE."` = BA.`".BM_BASE_CODE."`
            WHERE CD.`".CD_CUSTOMER_ID."` = P.`".BB_CUSTOMER_NUMBER."` AND BA.`".BM_BASE_CODE."` = P.`".BB_BASE_CODE."`) AS username  
            FROM `".PRODUCT_BASE."` AS P 
            INNER JOIN `".PRODUCT_LEDGER."` S ON P.`".BB_PRODUCT_CODE."` = S.`".PL_PRODUCT_ID."`
            INNER JOIN `".BASE_MASTER."` B ON P.`".BB_BASE_CODE."` = B.`".BM_BASE_CODE."`
            INNER JOIN `".CUSTOMER."` C ON P.`".BB_CUSTOMER_NUMBER."` = C.`".CUS_ID."`
        ";

        $whereClause = "WHERE ";

        if($input_search_product != NULL && $input_search_product != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "P.`".BB_PRODUCT_CODE."`"." LIKE '".$input_search_product."' ";
        }
        
        if($input_search_base != NULL && $input_search_base != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "P.`".BB_BASE_CODE."`"." = '".$input_search_base."' ";
        }
        
        if($input_search_customer != NULL && $input_search_customer != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "C.`".CUS_ID."`"." = '".$input_search_customer."' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
        $query .= $whereClause;
        
        $query .= " GROUP BY P.`".BB_ID."`";
        
        if($order_by !== NULL && $order_type !== NULL){
			$query .= " ORDER BY P.`".$order_by."` ". $order_type;
        } else {
            $query .= " ORDER BY P.`".BB_ID."` ".SORT_MASTER;
        }

		return $this->getQuery($query,$start_index,$number); 
         
    }
    
    /**
	* search user using OR condition.
	*/
	public function searchPriceImport($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT
            P.`".TPNS_ID."` AS id,
            P.`".TPNS_VENDOR_ID."` AS place_buy_id,
            B.`".SUP_SUPPLIER_COMPANY_NAME."` AS place_buy_name,
            P.`".TPNS_ID_PRODUCT."` AS product_id,
            S.`".PL_PRODUCT_CODE_BUY."` AS product_code,
            S.`".PL_PRODUCT_NAME_BUY."` AS product_name,
            P.`".TPNS_PURCHASE_PRICE."` AS price,
            P.`".TPNS_REMARKS."` AS note  
            FROM `".T_PRODUCT_NUMBER_FOR_SUPPLIER."` P
            INNER JOIN `".PRODUCT_LEDGER."` S ON P.`".TPNS_ID_PRODUCT."` = S.`".PL_PRODUCT_ID."`
            INNER JOIN `".T_SUPPLIER."` B ON P.`".TPNS_VENDOR_ID."` = B.`".SUP_ID."`
        ";

        $whereClause = "WHERE ";

        if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "S.`".PL_PRODUCT_CODE_BUY."`"." LIKE '%".$keyword."%' ";
        }

        if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "S.`".PL_PRODUCT_NAME_BUY."`"." LIKE '%".$keyword."%' ";
        }
        
        if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "B.`".SUP_SUPPLIER_COMPANY_NAME."`"." LIKE '%".$keyword."%' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        $query .= " GROUP BY P.`".TPNS_ID."`";

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY P.`".$order_by."` ". $order_type;
        } else {
            $query .= " ORDER BY P.`".TPNS_ID."` ".SORT_MASTER;
        }

		return $this->getQuery($query,$start_index,$number); 
         
    }
    
    /**
	* search user using OR condition.
	*/
	public function searchPriceExport($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT
            P.`".TPCT_ID."` AS id,
            P.`".TPCT_SALEROOM."` AS place_sale_id,
            B.`".TSD_DISTRIBUTOR_NAME."` AS place_sale_name,
            P.`".TPCT_PRODUCT_ID."` AS product_id,
            S.`".PL_PRODUCT_CODE_BUY."` AS product_code,
            S.`".PL_PRODUCT_NAME_BUY."` AS product_name,
            P.`".TPCT_UNIT_SELLING_PRICE."` AS price,
            P.`".TPCT_REMARKS."` AS note  
            FROM `".T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY."` P
            INNER JOIN `".PRODUCT_LEDGER."` S ON P.`".TPCT_PRODUCT_ID."` = S.`".PL_PRODUCT_ID."`
            INNER JOIN `".T_SALES_DESTINATION."` B ON P.`".TPCT_SALEROOM."` = B.`id` 
        ";

        $whereClause = "WHERE ";

        if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "S.`".PL_PRODUCT_CODE_BUY."`"." LIKE '%".$keyword."%' ";
        }

        if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "S.`".PL_PRODUCT_NAME_BUY."`"." LIKE '%".$keyword."%' ";
        }
        
        if($keyword != NULL && $keyword != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"OR ");
			$whereClause .= "B.`".TSD_DISTRIBUTOR_NAME."`"." LIKE '%".$keyword."%' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
        $query .= $whereClause;
        
        $query .= " GROUP BY P.`".TPCT_ID."`";
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY P.`".$order_by."` ". $order_type;
        } else {
            $query .= " ORDER BY P.`".TPCT_ID."` ".SORT_MASTER;
        }

		return $this->getQuery($query,$start_index,$number); 
         
	}

}