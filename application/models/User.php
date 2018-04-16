<?php

class User extends VV_Model
{
	
	function __construct()
	{ 
		parent::__construct();
		$this->table_name = USER_MASTER;
		 
		$this->idCol = U_ID;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}
	
	public function get_user_group($id){
		$this->db->where(U_USER_GROUP,$id);
		$user = $this->db->get(USER_MASTER);
		return $user->result();
	}
	public function getGaichyuUser(){
		$this->db->distinct('u.'.U_ID);
		$this->db->select('u.*');
		$this->db->from(USER_MASTER .' as u');
		$this->db->join(BASE_MASTER . ' as b','u.'.U_BASE_CODE. ' = b.'.BM_BASE_CODE,'left');

		$this->db->where(BM_MASTER_CHECK, 1);
		
		return $this->db->get($this->table_name)->result_array();
		
		// $query = $this->db->get($this->table_name);

		// $data = array();
		// if($query !== FALSE && $query->num_rows() > 0){
		// 	$data = $query->result_array();
		// }

		// return $data;
	}
	

	function getAll($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
		
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}
		if($this->level == "P"){
			$where = array(
				U_ID => $this->LOGIN_INFO[U_ID]
			);
			return $this->getWhere($where);
		}
		$data = $this->db->get($this->table_name)->result_array();
		return ($data);
	}


	public function get_all()
	{
		if($_SESSION['request-level'] == 'P') $this->db->where("`".U_ID."`='".$_SESSION['login-info'][U_ID]."'");
		return $this->db->get(USER_MASTER)->result();
	}

	public function get_all_user_by_warehouse()
	{
		$query = "SELECT ".USER_MASTER.".*, (SELECT COUNT(distinct ".SHIP_ID.") FROM "
		.T_ISSUE." "
		." where ".USER_MASTER.".`".U_ID."`=".T_ISSUE.".`".SHIP_EMPLOYEE_ID."` "
		."and ".T_ISSUE.".`".SHIP_SHIP_DATE."`>DATE_FORMAT(LAST_DAY(NOW() - INTERVAL ".EXP_USABILITY." MONTH), '%Y-%m-%d 23:59:59')) "
		."as count_use "
		." from ".USER_MASTER." "
		." order by count_use DESC ";
		$list_user = $this->db->query($query)->result();
		return $list_user;
	}

	public function getUserForOrderManager($login_id)
	{
		$query1 = "
			SELECT * FROM `ユーザマスタ` U
			INNER JOIN (SELECT DISTINCT `担当者` FROM `得意先部署` D 
			WHERE D.`得意先コード` IN (SELECT DISTINCT `得意先コード` FROM `得意先部署`
			WHERE `部署コード` = D.`部署コード` AND `担当者` = '".$login_id."')) T ON U.`ユーザID`=T.`担当者`   
		";
		return $this->db->query($query1)->result_array();
	}

	public function getUserByCustomer($login_id){
		$query3 = "
			SELECT * FROM `ユーザマスタ` U
			INNER JOIN (SELECT DISTINCT `担当者` FROM `得意先部署` D 
			WHERE D.`得意先コード` = '".$login_id."') T ON U.`ユーザID`=T.`担当者`   
		";
		return $this->db->query($query3)->result_array();
	}

	public function getUserByCustomer2($login_id){
		$query4 = "
		SELECT * FROM `ユーザマスタ` U
		INNER JOIN (SELECT `外注` FROM `得意先` A
		WHERE A.`得意先コード` = '".$login_id."') T2 ON U.`ユーザID`=T2.`外注` 
		";
		return $this->db->query($query4)->result_array();
	}

	public function getUserForCustomer($login_id)
	{
		$query2 = "
			SELECT * FROM `ユーザマスタ` U
			INNER JOIN (SELECT `外注` FROM `得意先` A
			INNER JOIN `得意先部署` B ON A.`得意先コード` = B.`得意先コード`
			WHERE B.`担当者` = '".$login_id."') T2 ON U.`ユーザID`=T2.`外注` 
		";
		return $this->db->query($query2)->result_array();
	}

	public function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->from(USER_MASTER);
		$this->db->join(BASE_MASTER,USER_MASTER.'.`'.U_BASE_CODE.'`='.BASE_MASTER.'.`'.BM_BASE_CODE.'`','left');
		$this->db->where(USER_MASTER.'.`'.U_ID.'`',$id);
		$user = $this->db->get();
		if (count($user->result())==1) return $user->result()[0];
		return null;
	}

	public function getUserById($id)
	{
		$this->db->select(USER_MASTER.".*,".CUSTOMER.".".CUS_ID." AS customer_id");
		$this->db->join(CUSTOMER,"`".USER_MASTER."`.`".U_ID."`=".CUSTOMER.".".CUS_ACCOUNT_ID,"left outer");
		$arrWhere[U_ID] = $id;
		$data = $this->getWhere($arrWhere);
		return end($data);
	}

	/**
	* search user using OR condition.
	*/
	public function search($keyword){
		if($keyword){
			$this->db->like(U_ID, $keyword);
			$this->db->or_like(U_NAME, $keyword);
			$this->db->or_like(U_POSITION, $keyword);
			$this->db->or_like(U_SHIMEI, $keyword);
			$this->db->or_like(U_EXTENSION_NUMBER, $keyword);
			$this->db->or_like(U_COMPANY_DIRECT_LINE_TEL, $keyword);
		}
		$this->db->select(U_ID . ", " . U_UPDATE_DATE . ", " . U_NAME . ", " . U_SHIMEI . ", " . U_BASE_CODE . ", " . U_POSITION . ", " . U_EXTENSION_NUMBER . ", " . U_COMPANY_DIRECT_LINE_TEL . ", " . U_USER_GROUP . ", GROUP_CONCAT(DISTINCT " . CUS_CUSTOMER_NAME . " SEPARATOR ', ') as " . CUSTOMER);
		$this->db->group_by(U_ID);
		return $this->db->get($this->table_name)->result_array();
	}

	//lấy thông tin cứ điểm của user
	public function get_base_master($user_id)
	{
		$this->db->select('*');
		$this->db->from(USER_MASTER);
		$this->db->join(BASE_MASTER,USER_MASTER.'.`'.U_BASE_CODE.'`='.BASE_MASTER.'.`'.BM_BASE_CODE.'`','left');
		$this->db->where(USER_MASTER.'.`'.U_ID.'`',$user_id);
		$base_master = $this->db->get();
		if(count($base_master->result()) == 0) return null;
		return $base_master->result()[0];
	}

	/**
	* search user using OR condition.
	*/
	public function searchUser($keyword = NULL, $start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL){
        $query = "
            SELECT 
			U.`".U_ID."` AS id,
			U.`".U_UPDATE_DATE."` AS date,
			U.`".U_NAME."` AS name,
			U.`".U_SHIMEI."` AS shimei,
			U.`".U_BASE_CODE."` AS base_code,
			S.`".BM_BASE_NAME."` AS base_name,
            U.`".U_POSITION."` AS address 
			FROM `".USER_MASTER."` U  
			LEFT JOIN `".BASE_MASTER."` S ON U.`".U_BASE_CODE."` = S.`".BM_BASE_CODE."` 
        ";

        $whereClause = "WHERE ";

        if($keyword["username"] != NULL && $keyword["username"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "U.`".U_ID."`"." = '".$keyword["username"]."' ";
		}
		
		if($keyword["name"] != NULL && $keyword["name"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "U.`".U_NAME."`"." LIKE '%".$keyword["name"]."%' ";
		}
		
		// if($keyword != NULL && $keyword != ''){
		// 	$whereClause .= ($whereClause == "WHERE "?"":"OR ");
		// 	$whereClause .= "U.`".U_UPDATE_DATE."`"." LIKE '%".$keyword."%' ";
		// }
		
		// if($keyword != NULL && $keyword != ''){
		// 	$whereClause .= ($whereClause == "WHERE "?"":"OR ");
		// 	$whereClause .= "U.`".U_SHIMEI."`"." LIKE '%".$keyword."%' ";
		// }
		
		// if($keyword != NULL && $keyword != ''){
		// 	$whereClause .= ($whereClause == "WHERE "?"":"OR ");
		// 	$whereClause .= "U.`".U_POSITION."`"." LIKE '%".$keyword."%' ";
		// }
		
		if($keyword["base"] != NULL && $keyword["base"] != ''){
			$whereClause .= ($whereClause == "WHERE "?"":SEARCH_MASTER);
			$whereClause .= "U.`".U_BASE_CODE."`"." = '".$keyword["base"]."' ";
        }

        $whereClause = $whereClause=="WHERE "?"":$whereClause;
		$query .= $whereClause;
        
        if($order_by != NULL && $order_type != NULL){
			$query .= " ORDER BY U.`".$order_by."` ". $order_type;
		}
		else {
			$query .= " ORDER BY U.`".U_UPDATE_DATE."` DESC";
		}

		return $this->getQuery($query,$start_index,$number); 
         
	}
	
	/**
	* getWhereUser
	*/
	public function getWhereUser($username){

		$query = "
			SELECT `".USER_MASTER."`.*,`".BASE_MASTER."`.`".BM_BASE_NAME."`,`".BASE_MASTER."`.`".BM_COMPANY_NAME."` 
			FROM `".USER_MASTER."`
			LEFT JOIN `".BASE_MASTER."` ON `".BASE_MASTER."`.`".BM_BASE_CODE."` = `".USER_MASTER."`.`".U_BASE_CODE."`
			WHERE `".U_ID."` = '".$username."'
		";

		return $this->getQuery($query); 
	}

	public function getListUser($ids){
		$query = "sELECT * FROM `".USER_MASTER."` WHERE `".U_ID."` IN (".$ids.")";
		return $this->getQuery($query);
	}

	public function getUserType($username){
		$this->db->select("`".BASE_MASTER."`.`".BM_MASTER_CHECK."`");
		$this->db->join("`".BASE_MASTER."`","`".USER_MASTER."`.`".U_BASE_CODE."`=`".BASE_MASTER."`.`".BM_BASE_CODE."`");
		$this->db->where(array(
				U_ID => $username
			));
		$result = $this->db->get(USER_MASTER)->result_array();
		if($result != NULL){
			$result = $result[0];
		}else{
			return null;
		}
		return $result;
	}
	public function getUserNotCustomer(){
		$query = "sELECT * FROM `".USER_MASTER."` WHERE `".U_ID."` NOT IN (SELECT `".CUS_ACCOUNT_ID."` FROM `".CUSTOMER."` WHERE `".CUS_ACCOUNT_ID."` IS NOT NULL)";
		return $this->getQuery($query);
	}
}