<?php

class ProductSet extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCT_SET; 
		$this->idCol = PS_PRODUCT_SET_CODE;
	}
	

	public function getDetail($id)
	{
		$this->db->select(PRODUCT_LEDGER.".*,".PRODUCT_LEDGER.".".PL_PRODUCT_ID." AS product_id,".PRODUCT_LEDGER.".".PL_PRODUCT_NAME." AS product_name,".PL_COLOR_TONE." AS product_color,".PL_STANDARD." AS product_standard,".PL_STANDARD." AS product_unit,".PL_NUMBER_PACKAGE." AS product_package_size,".PL_PRODUCT_CODE_SALE." AS sale_code,".PL_SPECIAL." AS special,".PL_CATEGORIES." AS category"
					);
		$this->db->join(PRODUCT_LEDGER,PRODUCT_SET_PRODUCT.".".PSP_PRODUCT_CODE."=".PRODUCT_LEDGER.".".PL_PRODUCT_ID);
		$this->db->where(
				array(
					PRODUCT_SET_PRODUCT.".".PSP_PRODUCT_SET_CODE => $id
				)
		);
		return $this->db->get(PRODUCT_SET_PRODUCT)->result_array();
	}

	// Get Set product By Customer and base
	public function getSetProductByCustomerBase($customer, $base_id = NULL)
	{
		$query = 'SELECT SP.`'.PS_PRODUCT_SET_CODE.'` AS set_id ,SP.`'.PS_PRODUCT_SET_NAME.'` AS set_name 
		FROM `'.PRODUCT_SET.'` SP 
		LEFT JOIN `'.PRODUCT_SET_CUSTOMER.'` PD ON PD.`'.PSC_PRODUCT_SET_CODE.'` = SP.`'.PS_PRODUCT_SET_CODE.'` 

		WHERE PD.`'.PSC_CUSTOMER_ID.'` = '.$customer;

		if($base_id != NULL && $base_id != '') {
			$query = ' AND PD.`'.PSC_BASE_CODE.'` = '.$base_id;
		}

		return $this->getQuery($query);
	} 

	// getSetProductByCustomerForShipment
	public function getSetProductByCustomerForShipment($customer)
	{
		$query = '
		SELECT 
		SP.`'.PS_PRODUCT_SET_CODE.'` AS set_id ,
		SP.`'.PS_PRODUCT_SET_NAME.'` AS set_name 
		FROM `'.PRODUCT_SET.'` SP 
		LEFT JOIN `'.CUSTOMER_PRODUCTSET.'` PD ON SP.`'.PS_PRODUCT_SET_CODE.'` = PD.`'.CP_PRODUCT_SET.'` 

		WHERE PD.`'.CP_CUSTOMER.'` = '.$customer;

		return $this->getQuery($query);
	} 

	/**
	* search user using OR condition.
	*/
	public function searchSetProduct($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
            C.`".PS_PRODUCT_SET_CODE."` AS id,
            C.`".PS_PRODUCT_SET_NAME."` AS name 
            FROM `".PRODUCT_SET."` C  
        ";

        $whereClause = "WHERE ";
		
		if($keyword['id'] != NULL && $keyword['id'] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "C.`".PS_PRODUCT_SET_CODE."`"." = '".$keyword['id']."' ";
		}
		
		if($keyword['name'] != NULL && $keyword['name']!= ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "C.`".PS_PRODUCT_SET_NAME."`"." LIKE '%".$keyword['name']."%' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY C.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY C.`".PS_PRODUCT_SET_CODE."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }
} 