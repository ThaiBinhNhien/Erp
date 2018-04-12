<?php

class Report_Sale extends VV_Model
{
	
	function __construct()
	{
        parent::__construct();
        $this->LEVEL = $this->session->userdata('request-level');
        $this->LOGIN_INFO = $this->session->userdata('login-info');
    }

    /**
    * Function: getRevenueSale
    *  Lấy những doanh thu đã giao hàng (delivery)
    * Điều kiện ngày giao hàng
    * @access public 
    * @param
    $schedule : 
    2: 日計表Ａ
    1: 日計表Ｂ
    $delivery_from : date from
    $delivery_to : date to
	*/
	public function getRevenueSale($delivery_from,$delivery_to, $schedule)
    {
        $query = "
        SELECT 
        O.`".SL_REVENUE_DATE."` as date_delivery, 
        T.`".DD_DELIVERY_AMOUNT."` as amout_delivery,  
        N.`".GR_GROUP_CODE."` as group_id, 
        N.`".GR_GROUP_NAME."` as group_name,
        N.`".GR_GROUP_TYPE."` as group_type
        FROM `".DELIVERY_DETAIL."` T
        INNER JOIN `".SALES_LEDGER."` O ON T.`".OD_ORDER_ID."` = O.`".SL_ID."` 
        INNER JOIN `".DEPARTMENT_LEDGER."` P ON O.`".SL_DEPARTMENT_CODE."` = P.`".DL_DEPARTMENT_CODE."` 
        INNER JOIN `".GROUP_REPORT."` N ON P.`".DL_AGGREGATION_CODE."` = N.`".GR_GROUP_CODE."`"; 

        $whereClause = "WHERE "; 
        
        if($delivery_from != NULL && $delivery_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".SL_REVENUE_DATE."`"." >= '$delivery_from' "; 
		}
		if($delivery_to != NULL && $delivery_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".SL_REVENUE_DATE."`"."  <= '$delivery_to 23:59:59' ";
        }
        if($schedule != NULL && $schedule != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "N.`".GR_GROUP_SCHEDULE."`"."  <> '$schedule' ";
        }
        if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".SL_BASE_CODE."`"."  = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
        $query .= $whereClause." GROUP BY T.".OD_ID." ";

        $query .= " ORDER BY O.`".SL_REVENUE_DATE."` asc";

        return $this->getQuery($query,$start_index,$number);
    }

    /**
	* Function: getRevenueByProduct
    * @access public 
    * @param
    $schedule : 
    2: 日計表Ａ
    1: 日計表Ｂ
    $delivery_from : date from
    $delivery_to : date to
    $customer : customer
    $product : product
    $group_by_type : 
    1 : product, price, group
    2 : product, price, group, department
	*/
	public function getRevenueByProduct($delivery_from,$delivery_to,$customer,$product, $schedule, $group_by_type)
    {
        $query = "
        SELECT 
        D.`".DD_PRODUCT_CODE."` AS product_id, 
        D.`".DD_UNIT_PRICE."` AS product_price, 
        sum(D.`".DD_QUANTITY."`) AS product_quantity, 
        sum(D.`".DD_DELIVERY_AMOUNT."`) AS product_amount, 
        P.`".PL_PRODUCT_CODE_SALE."` AS product_code, 
        P.`".PL_PRODUCT_NAME."` AS product_name, 
        P.`".PL_STANDARD."` AS product_format,
        P.`".PL_COLOR_TONE."` AS product_color, 
        O.`".SL_REVENUE_DATE."` as date_delivery,
        GR.`".GR_GROUP_CODE."` AS group_code, 
        GR.`".GR_GROUP_NAME."` AS group_name, 
        DP.`".DL_DEPARTMENT_CODE."` AS department_code, 
        DP.`".DL_DEPARTMENT_NAME."` AS department_name 
        FROM `".DELIVERY_DETAIL."` D
        LEFT JOIN `".PRODUCT_LEDGER."` P ON P.`".PL_PRODUCT_ID."` = D.`".DD_PRODUCT_CODE."`
        INNER JOIN `".SALES_LEDGER."` O ON O.`".SL_ID."` = D.`".DD_ORDER_ID."`
        LEFT JOIN `".DEPARTMENT_LEDGER."` DP ON DP.`".DL_DEPARTMENT_CODE."` = O.`".SL_DEPARTMENT_CODE."`
        LEFT JOIN `".GROUP_REPORT."` GR ON GR.`".GR_GROUP_CODE."` = DP.`".DL_AGGREGATION_CODE."`"; 

        $whereClause = "WHERE "; 
        
        if($delivery_from != NULL && $delivery_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".SL_REVENUE_DATE."`"." >= '$delivery_from' ";
		}
		if($delivery_to != NULL && $delivery_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".SL_REVENUE_DATE."`"."  <= '$delivery_to 23:59:59' ";
        }
        if($customer != NULL && $customer != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".SL_CUSTOMER_ID."`"."  = '$customer' ";
        }
        if($product != NULL && $product != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`".DD_PRODUCT_CODE."`"."  = '$product' ";
        }
        if($schedule != NULL && $schedule != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "GR.`".GR_GROUP_SCHEDULE."`"."  <> '$schedule' ";
        }
        if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`".SL_BASE_CODE."`"."  = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }

        if($group_by_type == 2) { 
            $whereClause = $whereClause=="WHERE "?"":$whereClause;
            $query .= $whereClause." GROUP BY D.".DD_PRODUCT_CODE.",D.".DD_UNIT_PRICE.",GR.".GR_GROUP_CODE.",DP.`".DL_DEPARTMENT_CODE."` ";
        } else {
            $whereClause = $whereClause=="WHERE "?"":$whereClause;
            $query .= $whereClause." GROUP BY D.".DD_PRODUCT_CODE.",D.".DD_UNIT_PRICE.",GR.".GR_GROUP_CODE." ";
        }

        $query .= " ORDER BY D.`".DD_PRODUCT_CODE."` asc";

        return $this->getQuery($query,$start_index,$number);
    }
}