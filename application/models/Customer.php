<?php

class Customer extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = CUSTOMER;
		$this->idCol = CUS_ID;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}

	function getAll($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}else{
			$this->db->order_by($this->idCol, SORT_MASTER);
		}
		if($this->level == "P"){
			return $this->getByUser($this->LOGIN_INFO[U_ID]);
		}

		$data = $this->db->get($this->table_name)->result_array();
		return ($data);
	}

	function getByType($cus_type,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}


		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}else{
			$this->db->order_by($this->idCol, SORT_MASTER);
		}
		if($this->level == "P"){
			return $this->getByUser($this->LOGIN_INFO[U_ID],$cus_type);
		}
		if($cus_type !== NULL){
			$this->db->where(CUS_TYPE_CUSTOMER,$cus_type);
		}
		$data = $this->db->get($this->table_name)->result_array();
		return ($data);
	}
	function getCustomerInDepartment(){
		$query = "sELECT DISTINCT * FROM `".CUSTOMER."` WHERE `".CUS_ID."` IN (SELECT `".CD_CUSTOMER_ID."` FROM `".CUSTOMER_DEPARTMENT."`)";
		return $this->getQuery($query);
	}


	function getCustomerByAccountID($user_id){
		$this->db->where(CUS_ACCOUNT_ID,$user_id);
		$result = $this->db->get($this->table_name)->result_array();
		if($result != null){
			$result = $result[0];
		}
		return $result;
	}

	function getGaichyuCustomerAll($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){

		$this->db->select(CUSTOMER.".*,".USER_MASTER.".".U_BASE_CODE." AS base_code,".BASE_MASTER.".".BM_MASTER_CHECK." AS gaichyu_flg,`".CUSTOMER_DEPARTMENT."`.`".CD_USER_ID."` AS username");
		$this->db->join(CUSTOMER_DEPARTMENT,"`".CUSTOMER."`.`".CUS_ID."`=".CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID,"left outer");
		$this->db->join(USER_MASTER,"`".CUSTOMER_DEPARTMENT."`.`".CD_USER_ID."`=".USER_MASTER.".".U_ID,"left outer");
		$this->db->join(BASE_MASTER,"`".USER_MASTER."`.`".U_BASE_CODE."`=".BASE_MASTER.".".BM_BASE_CODE,"left outer");
		
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}else{
			$this->db->order_by($this->idCol, SORT_MASTER);
		}
		if($this->level == "P"){
			return $this->getByUser($this->LOGIN_INFO[U_ID]);
		}
		//flag =1 ->  gaichyu
		$this->db->where(BM_MASTER_CHECK,1);

		$data = $this->db->get($this->table_name)->result_array();
		return ($data);
	}
	function getCustomerAll($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){

		$this->db->select(CUSTOMER.".*,".USER_MASTER.".".U_BASE_CODE." AS base_code,".BASE_MASTER.".".BM_MASTER_CHECK." AS gaichyu_flg");
		$this->db->join(USER_MASTER,"`".CUSTOMER."`.`".CUS_USER_ID."`=".USER_MASTER.".".U_ID,"left outer");
		$this->db->join(BASE_MASTER,"`".USER_MASTER."`.`".U_BASE_CODE."`=".BASE_MASTER.".".BM_BASE_CODE,"left outer");
		
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}else{
			$this->db->order_by($this->idCol, SORT_MASTER);
		}
		if($this->level == "P"){
			return $this->getByUser($this->LOGIN_INFO[U_ID]);
		}

		$data = $this->db->get($this->table_name)->result_array();
		return ($data);
	}

	function getProductByCustomer($customer){
		$query = "
		SELECT 
		P.`".BB_PRODUCT_CODE."` AS product_id,
		S.`".PL_PRODUCT_CODE_SALE."` AS product_sale_code,
		S.`".PL_PRODUCT_NAME."` AS product_sale_name
		FROM `".PRODUCT_BASE."` P
		INNER JOIN `".PRODUCT_LEDGER."` S ON P.`".BB_PRODUCT_CODE."` = S.`".PL_PRODUCT_ID."`
		WHERE P.`".BB_CUSTOMER_NUMBER."` = ".$customer." 
		GROUP BY P.`".BB_PRODUCT_CODE."`
		";
		return $this->getQuery($query);
	}

	function getCustomerView($id,$name,$fax,$user,$address,$phoneNumber,$start_index,$page_size){
		$this->db->distinct();
		$this->db->select(CUS_CUSTOMER_NAME.",".CUSTOMER.".".CUS_ID.",".CUS_FACSIMILE.",".CUS_ADDRESS_1.",".CUS_ADDRESS_2.",".CUS_READING.",".CUS_PHONE_NUMBER.",".CUS_CUSTOMER_NAME." AS name,".CUSTOMER.".".CUS_ID." AS id,".CUS_FACSIMILE." AS fax,".CUS_ADDRESS_1." AS address1,".CUS_ADDRESS_2." AS address2,".CUS_READING." AS reading,".CUS_PHONE_NUMBER." AS phone");
		$this->db->join(CUSTOMER_DEPARTMENT,CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID."=".CUSTOMER.".".CUS_ID,"left outer");
		if($id != NULL && $id != ""){
			$this->db->where(CUSTOMER.".".CUS_ID,$id);
		}
		if($name != NULL && $name != ""){
			$this->db->like(CUSTOMER.".".CUS_CUSTOMER_NAME,$name,'both');
		}
		if($fax != NULL && $fax != ""){
			$this->db->where(array(CUSTOMER.".".CUS_FACSIMILE => $fax));
		}
		if($user != NULL && $user != ""){
			$this->db->where(array(CUSTOMER_DEPARTMENT.".".CD_USER_ID => $user));
		}
		if($address != NULL && $address != ""){
			$this->db->where("(".CUS_ADDRESS_1." LIKE '$address%' OR ".CUS_ADDRESS_2." LIKE '$address%')");
		}
		if($phoneNumber != NULL && $phoneNumber != ""){
			$this->db->where(array(CUS_PHONE_NUMBER => $phoneNumber));
		}
		$this->db->limit($page_size, $start_index);
		return $this->db->get($this->table_name)->result_array();
	}

	function getProductSetByCus($cus_id){
		$this->db->select(PRODUCT_SET.".*,".PRODUCT_SET.".".PS_PRODUCT_SET_CODE." AS id,".PRODUCT_SET.".".PS_PRODUCT_SET_NAME." AS name");
		$this->db->join(PRODUCT_SET,PRODUCT_SET.".".PS_PRODUCT_SET_CODE."=".PRODUCT_SET_CUSTOMER.".".PSC_PRODUCT_SET_CODE);
		$this->db->where(
			array(
				PSC_CUSTOMER_ID => $cus_id
			)
		);
		return $this->db->get(PRODUCT_SET_CUSTOMER)->result_array();
	}

	public function get_by_id($id)
	{
		$this->db->where(CUS_ID,$id);
		$customer = $this->db->get(CUSTOMER);
		if($customer->num_rows() == 0) return null;
		return $customer->result()[0];
	}
	
	function getByUser($user_id,$cus_type=NULL){
		$this->db->distinct();
		$this->db->select(CUSTOMER.".*");
		$this->db->join(CUSTOMER_DEPARTMENT,CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID."=".CUSTOMER.".".CUS_ID);
		$this->db->where(CUSTOMER_DEPARTMENT.".".CD_USER_ID,$user_id);
		if($cus_type != 0 && $cus_type != NULL){
			$this->db->where(CUSTOMER.".".CUS_TYPE_CUSTOMER,$cus_type);
		}
		return $this->db->get(CUSTOMER)->result_array();
	}

	public function get_all()
	{
		$customer = $this->db->get(CUSTOMER);
		return $customer->result();
	}
	
	public function add($data,$table = NULL){
		$query = "iNSERT INTO `得意先` (";
		$index = 0;
		foreach ($data as $key => $value) {
			$query .= "`".$key."`";
			if($index != (count($data) - 1)){
				$query .= ",";
			}
			$index += 1;
		}
		$query .= ") VALUES (";
		$index = 0;
		foreach ($data as $key => $value) {
			$query .= "'".html_escape($value)."'";
			if($index != (count($data) - 1)){
				$query .= ",";
			}
			$index += 1;
		}
		$query .=")";
		$this->db->query($query);
		return $this->db->affected_rows() !== false;
	}

	public function edit($id,$data, $table = NULL){
		$query = "uPDATE `".CUSTOMER."` SET ";
		$index = 0;
		foreach ($data as $key => $value) {
			$query .= " `".$key."`='".html_escape($value)."'";
			
			if($index != (count($data) - 1)){
				$query .= ",";
			}
			$index += 1;
		}
		$query .= " WHERE `".CUS_ID."` = '$id'";
		$this->db->query($query);
		return $this->db->affected_rows() !== false;
	}

	public function getCustomerSelectBox($customer_code,$count = false,
		$start_index = NULL,$number = NULL,$product_by =NULL ,$product_type = NULL)
	{
		$this->db->select('*');
		$this->db->from(CUSTOMER);

		if($customer_code != NULL && $customer_code != ""){
			$this->db->like(CUS_ID,$customer_code, 'both');
		}

		if($count == true) {
			$num_results = $this->db->count_all_results();
			return $num_results;
		} else {
			$this->db->limit($number,$start_index);
			$result = $this->db->get()->result_array();
			return $result;
		}
	}


	/**
	* Function getById
	* Get an object information by its ID
	* @param int $id the object ID
	* @return array of object information
	* @access public
	*/
	public function getInforByCustomer($customer_id)
	{
		$query = "
			SELECT 
			US.`".U_BASE_CODE."` AS basecode,
			BA.`".BM_BASE_NAME."` AS basename,
			BA.`".BM_MASTER_CHECK."` AS flg_gaichyu,
			GROUP_CONCAT(DISTINCT CD.`".CD_USER_ID."`) AS username
			FROM `".CUSTOMER_DEPARTMENT."` CD 
			INNER JOIN `".USER_MASTER."` US ON CD.`".CD_USER_ID."` = US.`".U_ID."` 
			INNER JOIN `".BASE_MASTER."` BA ON US.`".U_BASE_CODE."` = BA.`".BM_BASE_CODE."`
			WHERE CD.`".CD_CUSTOMER_ID."` = ".$customer_id."
			
			GROUP BY US.`".U_BASE_CODE."`
		";
		return $this->getQuery($query);
	}

	public function search_by_name($keyword,$cus_type,$start_index,$number) 
	{
        $name = $this->input->get('name');
        $start_index = $this->input->get('start_index');
        $number = $this->input->get('number');
        $this->db->select(CUSTOMER.".".CUS_ID." AS id,".CUS_CUSTOMER_NAME." AS name");
        $this->db->like(CUS_CUSTOMER_NAME, $name, 'both'); 
        $this->db->join(CUSTOMER_DEPARTMENT,CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID."=".CUSTOMER.".".CUS_ID);  
        if($this->level == "P"){
			 $this->db->where(CUSTOMER_DEPARTMENT.".".CD_USER_ID,$this->LOGIN_INFO[U_ID]);
		}
		if($cus_type != 0 && $cus_type != NULL){
			$this->db->where(CUSTOMER.".".CUS_TYPE_CUSTOMER,$cus_type);
		}
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}
		$this->db->order_by(CUSTOMER.".".$this->idCol, SORT_MASTER);
        $result = $this->db->get($this->table_name)->result_array();
        return $result;
	}
}