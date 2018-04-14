<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Manage base master
*/
class Base_master extends VV_Model
{
	function __construct()
	{
		parent::__construct(); 
		$this->table_name = BASE_MASTER;
		$this->idCol = BM_BASE_CODE;
	}

	public function get_all()
	{
		$base_list = $this->db->get(BASE_MASTER);
		return $base_list->result();
	} 


	public function get_by_id($id)
	{
		// $this->db->where(BM_BASE_CODE,$id);
		// $base = $this->db->get(BASE_MASTER);
		$sql = "select * from `".BASE_MASTER."` where `".BM_BASE_CODE."` = '".$id."' ;";
		$base = $this->db->query($sql);
		if(count($base->result())>0) return $base->result()[0];
		return null;
	}

	//nếu là admin thì load hết danh sách chứ điểm bằng ko thì chỉ hiện cứ điểm của mình nó
	public function get_by_role($isAdmin)
	{
		$query = "select * from `".BASE_MASTER."` ";
		if(!$isAdmin) $query .= " where `".BM_BASE_CODE."` = ".$_SESSION['login-info'][U_BASE_CODE];
		$base_list = $this->db->query($query);
		return $base_list->result();
	}

	/**
	* search base
	*/
	public function searchByKey($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			G.`".BM_BASE_CODE."` AS id,
			G.`".BM_BASE_NAME."` AS name,
			G.`".BM_COMPANY_NAME."` AS company,
			G.`".BM_POSTAL_CODE."` AS post_office,
			G.`".BM_PHONE_NUMBER."` AS phone,
			G.`".BM_FAX_NUMBER."` AS fax,
			G.`".BM_PREFECTURES."` AS province,
			G.`".BM_ADDRESS_1."` AS address1,
			G.`".BM_ADDRESS_2."` AS address2 
			FROM `".BASE_MASTER."` G 
        ";

        $whereClause = "WHERE ";

		if($keyword["form_id"] != NULL && $keyword["form_id"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_BASE_CODE."`"." = '".$keyword["form_id"]."' ";
		}

        if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_BASE_NAME."`"." LIKE '%".$keyword["name"]."%' ";
		}

		if($keyword["company"] != NULL && $keyword["company"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_COMPANY_NAME."`"." LIKE '%".$keyword["company"]."%' ";
		}

		if($keyword["province"] != NULL && $keyword["province"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_PREFECTURES."`"." LIKE '%".$keyword["province"]."%' ";
		}

		if($keyword["post_office"] != NULL && $keyword["post_office"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_POSTAL_CODE."`"." LIKE '%".$keyword["post_office"]."%' ";
		}

		if($keyword["phone"] != NULL && $keyword["phone"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_PHONE_NUMBER."`"." LIKE '%".$keyword["phone"]."%' ";
		}
		
		if($keyword["fax"] != NULL && $keyword["fax"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_FAX_NUMBER."`"." LIKE '%".$keyword["fax"]."%' ";
		}

		if(isset($keyword["BM_MASTER_CHECK"]) && $keyword["BM_MASTER_CHECK"] != NULL && $keyword["BM_MASTER_CHECK"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_MASTER_CHECK."`"." = '".$keyword["BM_MASTER_CHECK"]."' ";
		}

		if($keyword["address"] != NULL && $keyword["address"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "(G.`".BM_ADDRESS_1."`"." LIKE '%".$keyword["address"]."%' ";
			$whereClause .= "OR G.`".BM_ADDRESS_2."`"." LIKE '%".$keyword["address"]."%') ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY G.`".BM_BASE_CODE."` ".SORT_MASTER;
		}

		return $this->getQuery($query,$start_index,$number); 
         
	}
	
	/**
	* search base
	*/
	public function getAll($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			G.*
			FROM `".BASE_MASTER."` G 
        ";

        $whereClause = "WHERE ";
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}

		return $this->getQuery($query,$start_index,$number); 
         
	}
	
	/**
	* search base
	*/
	public function getWhereGaichyu($keyword,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			G.*
			FROM `".BASE_MASTER."` G 
        ";

		$whereClause = "WHERE ";
		
		if(isset($keyword[BM_MASTER_CHECK]) && $keyword[BM_MASTER_CHECK] != NULL && $keyword[BM_MASTER_CHECK] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "G.`".BM_MASTER_CHECK."`"." = '".$keyword[BM_MASTER_CHECK]."' ";
		}
		
        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY G.`".$order_by."` ". $order_type;
		}

		return $this->getQuery($query,$start_index,$number); 
         
    }
}