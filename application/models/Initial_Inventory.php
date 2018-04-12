<?php

class Initial_Inventory extends VV_Model
{
	
	function __construct() 
	{
		parent::__construct();
		$this->table_name = INITIAL_INVENTORY;
		$this->idCol = IN_ID;
		 
	}

	
	public function search($data , $start_index = NULL,$number = NULL,$by =NULL ,$type = NULL)
	{

		$this->db->select('i.'.IN_ID .' as id, i.'. IN_DATE . ' as in_date, p.'.PL_PRODUCT_NAME .' as in_product , i.'.IN_INITIAL_AMOUNT . ' as in_initial_amount, b.'.BM_BASE_NAME . ' as in_base');
		$this->db->from(INITIAL_INVENTORY .' as i');
		$this->db->join(PRODUCT_LEDGER . ' as p','i.`'.IN_PRODUCT. '` = p.'.PL_PRODUCT_ID,'left');
		$this->db->join(BASE_MASTER . ' as b','i.'.IN_BASE_CODE. ' = b.'.BM_BASE_CODE,'left');
		

		if(!empty($data['in_product'])) $this->db->where('i.'. IN_PRODUCT,$data['in_product']);
		if(!empty($data['in_base'])) $this->db->where('i.'.IN_BASE_CODE,$data['in_base']);
		if(!empty($data['in_from_date'])) $this->db->where(IN_DATE. ' >=',$data['in_from_date']);
		if(!empty($data['in_to_date'])) $this->db->where(IN_DATE. ' <=',$data['in_to_date']);
		
		
		if($by != NULL && $type != NULL){
			$this->db->order_by($by, $type);
		}
		
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index );
		}
		
		$supplier = $this->db->get();
		
		return $supplier->result();
	}


	/**
	* Function: getListNumberInitial
	* Danh sách số kỳ đầu
	* @access public 
	*/
	public function getListNumberInitial($date_to = NULL,$date_exp = NULL, $base_code = NULL,$type  = NULL,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		$query = "
		SELECT 
		V.product_id,
		V.product_code_sell,
		V.product_name_sell,
		V.product_format,
		V.product_color,
		(
			SELECT MAX(V2.date_initial) FROM view_initial_inventory V2 
			WHERE V2.product_id = V.product_id AND V2.number_initial <> 0 ";
				if($base_code != null && $base_code != "") {
					$query .= "AND V2.base_code = ".$base_code."";
				}
				$query .= "
		) AS date_initial, 
		(	
			SELECT SUM(V3.number_initial) FROM view_initial_inventory V3 
			WHERE V3.product_id = V.product_id AND V3.date_initial = (
				SELECT MAX(V4.date_initial) FROM view_initial_inventory V4 
				WHERE V4.product_id = V.product_id AND V4.number_initial <> 0 ";
				if($base_code != null && $base_code != "") {
					$query .= "AND V4.base_code = ".$base_code."";
				}
				$query .= "
			) ";
			if($base_code != null && $base_code != ""){
				$query .= "AND V3.base_code = ".$base_code."";
			}
			$query .= "
		) AS number_initial 
			
		FROM view_initial_inventory V 
		";

		$whereClause = "WHERE "; 

		if($base_code != NULL && $base_code != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_code = '$base_code' ";
		}

		if($type != NULL && $type != ''){ 
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.product_id IN (SELECT 
			OD.`商品コード`
			FROM `注文伝票明細` OD
			
			GROUP BY OD.`商品コード`) ";
		}

		if($date_to != NULL && $date_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_initial <= '$date_to 23:59:59' ";
		}

		if($date_exp != NULL && $date_exp != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.date_initial >= '$date_exp 00:00:00' ";
		}
		
		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "V.base_code = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }
		
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
		
		$query .= " GROUP BY V.product_id ";

        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY V.`".$order_by."` ". $order_type; 
		} else {
			$query .= " ORDER BY V.product_id ASC"; 
		}

		return $this->getQuery($query,$start_index,$number);
	}

	/**
	* Function: getNumberDelivery
	* Số lượng giao hàng
	* @access public 
	*/
	public function getNumberDelivery($product_id = NULL,$date_from = NULL,$date_to = NULL, $base_code = NULL){
		$query = "
			SELECT SUM(D.`数量`) AS numer_delivery 
			FROM `納品詳細` D 
			INNER JOIN `売上台帳` O ON D.`伝票番号` = O.`伝票番号` 
		";

		$whereClause = "WHERE "; 

		if($base_code != NULL && $base_code != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`拠点コード` = '$base_code' ";
		}

		if($product_id != NULL && $product_id != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`商品コード` = '$product_id' ";
		}

		if($date_to != NULL && $date_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`納品日` <= '$date_to 23:59:59' ";
		}

		if($date_from != NULL && $date_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`納品日` >= '$date_from 00:00:00' ";
		}
		
		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "O.`拠点コード` = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }
		
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

		$result = $this->getQuery($query);
		$number_delivery = 0;
		if($result != null && count($result) > 0) {
			$number_delivery = (int)$result[0]['numer_delivery'];
		}
		return $number_delivery;
	}

	/**
	* Function: getNumberDisposal
	* Số lượng hỏng, vứt bỏ
	* @access public 
	*/
	public function getNumberDisposal($product_id = NULL,$date_from = NULL,$date_to = NULL, $base_code = NULL){
		$query = "
			SELECT SUM(D.`廃棄`) AS numer_disposal 
			FROM `期首の棚卸_廃棄` D 
		";

		$whereClause = "WHERE "; 

		if($base_code != NULL && $base_code != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`拠点コード` = '$base_code' ";
		}

		if($product_id != NULL && $product_id != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`商品ID` = '$product_id' ";
		}

		if($date_to != NULL && $date_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`日付` <= '$date_to 23:59:59' ";
		}

		if($date_from != NULL && $date_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`日付` >= '$date_from 00:00:00' ";
		}
		
		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.`拠点コード` = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }
		
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

		$result = $this->getQuery($query);
		$numer_disposal = 0;
		if($result != null && count($result) > 0) {
			$numer_disposal = (int)$result[0]['numer_disposal'];
		}
		return $numer_disposal;
	}

	/**
	* Function: getNumberExport
	* Số lượng xuất kho
	* @access public 
	*/
	public function getNumberExport($product_id = NULL,$date_from = NULL,$date_to = NULL, $base_code = NULL){
		$query = "
			SELECT SUM(D.number_export) AS number_export 
			FROM view_infor_export D 
			INNER JOIN `".PRODUCT_LEDGER."` P ON P.`".PL_PRODUCT_ID."` = D.product_id 
		";

		$whereClause = "WHERE "; 

		if($base_code != NULL && $base_code != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.factory_id = '$base_code' ";
		}

		if($product_id != NULL && $product_id != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "P.`".PL_PRODUCT_CODE_SALE."` IN (SELECT PD.`".PL_PRODUCT_CODE_SALE."` FROM `".PRODUCT_LEDGER."` PD WHERE PD.`".PL_PRODUCT_ID."` = '$product_id') ";
		}

		if($date_to != NULL && $date_to != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.date_export <= '$date_to 23:59:59' ";
		}

		if($date_from != NULL && $date_from != ''){
			$whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.date_export >= '$date_from 00:00:00' ";
		}
		
		if($this->LEVEL == "P") {
            $whereClause .= ($whereClause == "WHERE "?"":"AND ");
			$whereClause .= "D.factory_id = '".$this->LOGIN_INFO[U_BASE_CODE]."' ";
        }
		
		$whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;

		$result = $this->getQuery($query);
		$number_export = 0;
		if($result != null && count($result) > 0) {
			$number_export = (int)$result[0]['number_export'];
		}
		return $number_export;
	}
}