<?php

class ProductSetProduct extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = PRODUCT_SET_PRODUCT;
	}
	 

	// Get list
	public function getByIdSetProduct($id_set_product = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			P.`".PSP_PRODUCT_SET_CODE."` AS id,
			P.`".PSP_PRODUCT_CODE."` AS product_id,
            S.`".PL_PRODUCT_CODE_BUY."` AS buy_product_id,
            S.`".PL_PRODUCT_CODE_SALE."` AS sell_product_id,
            S.`".PL_PRODUCT_NAME_BUY."` AS buy_product_name,
            S.`".PL_PRODUCT_NAME."` AS sell_product_name,
            P.`".PSP_SERIAL_NUMBER."` AS stt 
            FROM `".PRODUCT_SET_PRODUCT."` AS P
            INNER JOIN `".PRODUCT_LEDGER."` S ON P.`".PSP_PRODUCT_CODE."` = S.`".PL_PRODUCT_ID."` 
        ";

        $whereClause = "WHERE ";

        if($id_set_product != NULL && $id_set_product != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "P.`".PSP_PRODUCT_SET_CODE."`"." = '".$id_set_product."' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by !== NULL && $order_type !== NULL){
			$query .= " ORDER BY P.`".$order_by."` ". $order_type;
        } else {
            $query .= " ORDER BY P.`".PSP_SERIAL_NUMBER."` ASC";
        }

		return $this->getQuery($query,$start_index,$number); 
         
    }

    public function getAvaiable(){
        $this->db->select(PRODUCT_SET_PRODUCT.".*");
        $this->db->join(PRODUCT_SET,"`".PRODUCT_SET."`.`".PS_PRODUCT_SET_CODE."`=".PRODUCT_SET_PRODUCT.".".PSP_PRODUCT_SET_CODE);
        return $this->db->get(PRODUCT_SET_PRODUCT)->result_array();
    }
} 