<?php
/**
* 
*/
class Sale extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		 
		$this->table_name = SALES_LEDGER;
		$this->idCol = SL_ID;
	}

	//lấy tất cả khách hàng có trong bảng sổ cái doanh thu
	public function get_all_customer()
	{
		$sql = "SELECT DISTINCT ".SL_CUSTOMER_ID." FROM ".SALES_LEDGER.";";
		$customer = $this->db->query($sql);
		return $customer->result();
	}

	//lấy danh sách theo mã khách hàng
	public function get_by_customer($customer_id)
	{
		$this->db->select('*');
		$this->db->from(SALES_LEDGER);
		$this->db->join(CUSTOMER,SALES_LEDGER.'.'.SL_CUSTOMER_ID.'='.CUSTOMER.'.'.CUS_ID,'left');
		$this->db->join(DEPARTMENT_LEDGER,SALES_LEDGER.'.'.SL_DEPARTMENT_CODE.'='.DEPARTMENT_LEDGER.'.'.DL_DEPARTMENT_CODE,'left');
		$this->db->where(SALES_LEDGER.'.'.SL_CUSTOMER_ID,$customer_id);
		$this->db->where(SALES_LEDGER.'.'.SL_DELIVERY_NOTE.'>',0);
		$this->db->where(SALES_LEDGER.'.'.SL_CLAIM_CHECK,0);
		$order = $this->db->get();
		return $order->result();
	}

	// lấy khoảng thời gian giao hàng của khách hàng
	public function get_space_time_ship($order_id_list)
	{
		$date;
		for($i=0;$i<count($order_id_list);$i++){
			if($i==0) $this->db->where(SL_ID,$order_id_list[$i]);
			else $this->db->or_where(SL_ID,$order_id_list[$i]);
		}
		$this->db->order_by(SL_REVENUE_DATE,'ESC');
		$order = $this->db->get(SALES_LEDGER);
		$length = count($order->result());
		if($length == 0) return null;
		$dt_start = new DateTime($order->result()[0]->{SL_REVENUE_DATE});
		$date['start'] = $dt_start->format('Y/m/d');//ngày bắt đầu giao hàng
		$dt_end = new DateTime($order->result()[$length-1]->{SL_REVENUE_DATE});
		$date['end'] = $dt_end->format('Y/m/d');//ngày cuối cùng giao hàng
		return $date;
	}

	public function get_by_id($id)
	{
		$this->db->where(SL_ID,$id);
		$order = $this->db->get(SALES_LEDGER);
		return $order->result()[0];
	}

	/**cập nhật tình trạng tạo giấy đòi tiền với trạng thái là status
	*với $order_id_list là chuỗi order id ngăng cách na bởi dấu ','
	*/
	public function update_status_create_invoice($order_id_list,$status)
	{
		$arr_order_id = explode('|', $order_id_list);
		$data = array(SL_CLAIM_CHECK => $status);
		foreach ($arr_order_id as $order_id) {
			$this->db->where(SL_ID,$order_id);
			$this->db->update(SALES_LEDGER,$data);
		}
	}

	public function update_status_create_invoice_gaichyu($order_id_list,$status)
	{
		$arr_order_id = explode('|', $order_id_list);
		$data = array(SL_CLAIM_CHECK_GAICHYU => $status);
		foreach ($arr_order_id as $order_id) {
			$this->db->where(SL_ID,$order_id);
			$this->db->update(SALES_LEDGER,$data);
		}
	}

	// tìm các khách hàng có trong bảng sale thỏa điều kiện data đưa vào
	public function search_customer($data)
	{
		$this->db->distinct();
		$this->db->select(SL_CUSTOMER_ID);
		$this->db->from(SALES_LEDGER);
		if(!empty($data['order_no'])) $this->db->where(SL_ID,$data['order_no']);
		if(!empty($data['user_id'])) $this->db->where(SL_USER_ID,$data['user_id']);
		if(!empty($data['customer_id'])) $this->db->where(SL_CUSTOMER_ID,$data['customer_id']);
		if(!empty($data['department_id'])) $this->db->where(SL_DEPARTMENT_CODE,$data['department_id']);
		if(!empty($data['ship_date_start'])) $this->db->where(SL_REVENUE_DATE.'>=',$data['ship_date_start']);
		if(!empty($data['ship_date_end'])) $this->db->where(SL_REVENUE_DATE.'<=',$data['ship_date_end']);
		if(!empty($data['order_date_start'])) $this->db->where(SL_SALES_DATE.'>=',$data['order_date_start']);
		if(!empty($data['order_date_end'])) $this->db->where(SL_SALES_DATE.'<=',$data['order_date_end']);
		$this->db->where(SALES_LEDGER.'.'.SL_DELIVERY_NOTE.'>',0);
		$this->db->where(SALES_LEDGER.'.'.SL_CLAIM_CHECK,0);
		$customer = $this->db->get();
		return $customer->result();
	}

	//tìm các order thỏa điều kiện data đưa vào theo customer
	public function search_order($data)
	{
		$this->db->select(SALES_LEDGER.'.'.SL_ID.','.SALES_LEDGER.'.'.SL_REVENUE_DATE.','.
			SALES_LEDGER.'.'.SL_USER_ID.','.DEPARTMENT_LEDGER.'.'.DL_DEPARTMENT_NAME);
		$this->db->from(SALES_LEDGER);
		$this->db->join(CUSTOMER,SALES_LEDGER.'.'.SL_CUSTOMER_ID.'='.CUSTOMER.'.'.CUS_ID,'left');
		$this->db->join(DEPARTMENT_LEDGER,SALES_LEDGER.'.'.SL_DEPARTMENT_CODE.'='.DEPARTMENT_LEDGER.'.'.DL_DEPARTMENT_CODE,'left');

		if(!empty($data['order_no'])) $this->db->where(SALES_LEDGER.'.'.SL_ID,$data['order_no']);
		if(!empty($data['user_id'])) $this->db->where(SALES_LEDGER.'.'.SL_USER_ID,$data['user_id']);
		if(!empty($data['customer_id'])) $this->db->where(SALES_LEDGER.'.'.SL_CUSTOMER_ID,$data['customer_id']);
		if(!empty($data['department_id'])) $this->db->where(SALES_LEDGER.'.'.SL_DEPARTMENT_CODE,$data['department_id']);
		if(!empty($data['ship_date_start'])) $this->db->where(SALES_LEDGER.'.'.SL_REVENUE_DATE.'>=',$data['ship_date_start']);
		if(!empty($data['ship_date_end'])) $this->db->where(SALES_LEDGER.'.'.SL_REVENUE_DATE.'<=',$data['ship_date_end']);
		if(!empty($data['order_date_start'])) $this->db->where(SALES_LEDGER.'.'.SL_SALES_DATE.'>=',$data['order_date_start']);
		if(!empty($data['order_date_end'])) $this->db->where(SALES_LEDGER.'.'.SL_SALES_DATE.'<=',$data['order_date_end']);
		$this->db->where(SALES_LEDGER.'.'.SL_DELIVERY_NOTE.'>',0);
		$this->db->where(SALES_LEDGER.'.'.SL_CLAIM_CHECK,0);
		$customer = $this->db->get();
		return $customer->result();
	}

	public function pdf_produce_business_ask_money($date_now,$date_from,$date_to,$type){
		$this->db->select(CUSTOMER.".".CUS_ID.",".CUSTOMER.".".CUS_CUSTOMER_NAME.",".DEPARTMENT_LEDGER.".".DL_AGGREGATION_CODE.",".GROUP_REPORT.".".GR_GROUP_NAME.",SUM(IF(DATE_FORMAT(".SL_SALES_DATE.",'yyyy-MM-dd') = ".$date_now.", ".SL_DELIVERY_AMOUNT.",0 )) AS amount_today,SUM(IF(".SL_DELIVERY_AMOUNT." IS NULL,0,".SL_DELIVERY_AMOUNT.")) AS amount");
		$this->db->join(CUSTOMER,CUSTOMER.".".CUS_ID."=".SALES_LEDGER.".".SL_CUSTOMER_ID);
		$this->db->join(DEPARTMENT_LEDGER,DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE."=".SALES_LEDGER.".".SL_DEPARTMENT_CODE);
		$this->db->join(CUSTOMER_DEPARTMENT,CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID."=".CUSTOMER.".".CUS_ID." AND ".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE."=".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE);
		$this->db->join(GROUP_REPORT,GROUP_REPORT.'.'.GR_GROUP_CODE.'='.DEPARTMENT_LEDGER.'.'.DL_AGGREGATION_CODE,'left');
		$this->db->where(array(
				CUSTOMER_DEPARTMENT.".".CD_NOT_ASK_MONEY => 0
				)
		);
		if($date_from != NULL && $date_from != ""){
			$this->db->where(array(
				SL_SALES_DATE." >=" => $date_from
				)
			);	
		}

		if($date_to != NULL && $date_to != ""){
			$this->db->where(array(
				SL_SALES_DATE." <=" => $date_to." 23:59:59"
				)
			);	
		}
		if($type != null){
			$this->db->where(array( CUS_TYPE_CUSTOMER => $type));
		}
		if($this->level == 'P'){
			$this->db->where(SL_USER_ID." IN (SELECT ".U_ID." FROM ".USER_MASTER." WHERE ".U_BASE_CODE." = '".$this->LOGIN_INFO[U_BASE_CODE]."')");
		}
		$this->db->group_by(CUSTOMER.".".CUS_ID.",".CUSTOMER.".".CUS_CUSTOMER_NAME.",".GROUP_REPORT.'.'.GR_GROUP_CODE.",".GROUP_REPORT.'.'.GR_GROUP_NAME);
		return $this->db->get($this->table_name)->result_array();
		
	}

	public function pdf_produce_business_not_ask_money($date_now,$date_from,$date_to,$type){
		$this->db->select(DEPARTMENT_LEDGER.".".DL_AGGREGATION_CODE.",".GROUP_REPORT.".".GR_GROUP_NAME.",SUM(IF(DATE_FORMAT(".SL_SALES_DATE.",'yyyy-MM-dd') = ".$date_now.", ".SL_DELIVERY_AMOUNT.",0 )) AS amount_today,SUM(IF(".SL_DELIVERY_AMOUNT." IS NULL,0,".SL_DELIVERY_AMOUNT.")) AS amount");
		$this->db->join(CUSTOMER,CUSTOMER.".".CUS_ID."=".SALES_LEDGER.".".SL_CUSTOMER_ID);
		$this->db->join(DEPARTMENT_LEDGER,DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE."=".SALES_LEDGER.".".SL_DEPARTMENT_CODE);
		$this->db->join(CUSTOMER_DEPARTMENT,CUSTOMER_DEPARTMENT.".".CD_CUSTOMER_ID."=".CUSTOMER.".".CUS_ID." AND ".CUSTOMER_DEPARTMENT.".".CD_DEPARTMENT_CODE."=".DEPARTMENT_LEDGER.".".DL_DEPARTMENT_CODE);
		$this->db->join(GROUP_REPORT,GROUP_REPORT.'.'.GR_GROUP_CODE.'='.DEPARTMENT_LEDGER.'.'.DL_AGGREGATION_CODE,'left');
		$this->db->where(array(
				CUSTOMER_DEPARTMENT.".".CD_NOT_ASK_MONEY => 1
				)
		);
		if($date_from != NULL && $date_from != ""){
			$this->db->where(array(
				SL_SALES_DATE." >=" => $date_from
				)
			);	
		}

		if($date_to != NULL && $date_to != ""){
			$this->db->where(array(
				SL_SALES_DATE." <=" => $date_to." 23:59:59"
				)
			);	
		}
		if($type != null){
			$this->db->where(array( CUS_TYPE_CUSTOMER => $type));
		}
		if($this->level == 'P'){
			$this->db->where(SL_USER_ID." IN (SELECT ".U_ID." FROM ".USER_MASTER." WHERE ".U_BASE_CODE." = '".$this->LOGIN_INFO[U_BASE_CODE]."')");
		}
		$this->db->group_by(DEPARTMENT_LEDGER.'.'.DL_AGGREGATION_CODE.",".GROUP_REPORT.'.'.GR_GROUP_NAME);
		return $this->db->get($this->table_name)->result_array();
		
	}

	public function get_order_group_by_customer_invoice_group($data = null)
	{
		$this->load->model("User");
		$user = $this->User->get_by_id($_SESSION['login-info'][U_ID]);
		$check_gaichyu = $user->{BM_MASTER_CHECK};
		$query = "select *,".SALES_LEDGER.".`".SL_CUSTOMER_ID."` as customer_id, ";
		$query .= "(select count(*) from ".DELIVERY_DETAIL." where ".DD_ORDER_ID."=".SALES_LEDGER.".`".SL_ID."`) as amount_delivery, ";
		$query .= "(select count(*) from ".DELIVERY_DETAIL." where ".DD_ORDER_ID."=".SALES_LEDGER.".`".SL_ID."` and ".DD_CHECK." = 1) as amount_check ";
		$query .= " from ".SALES_LEDGER." left join ";
		$query .= "( select ".CUSTOMER_DEPARTMENT.".`".CUS_DE_ID."`,".CUSTOMER_DEPARTMENT.".`".CD_CUSTOMER_ID."`,".CUSTOMER_DEPARTMENT.".`".CD_DEPARTMENT_CODE."`,".CUSTOMER_DEPARTMENT.".`".CD_NOT_ASK_MONEY."`,"
		.INVOICE_GROUP_DETAIL.".*,".INVOICE_GROUP.".`".TG_USER_ID."` from ".INVOICE_GROUP_DETAIL
		." left join ".CUSTOMER_DEPARTMENT." on ".INVOICE_GROUP_DETAIL.".`".IGD_ID_DEPARTMENT_CUSTOMER."` = ".CUSTOMER_DEPARTMENT.".`".CUS_DE_ID."`"
		." left join ".INVOICE_GROUP." on ".INVOICE_GROUP_DETAIL.".`".IGD_ID_INVOICE_GROUP."` = ".INVOICE_GROUP.".`".IG_ID."`"
		.") invoice_detail";
		$query .= " on ".SALES_LEDGER.".`".SL_CUSTOMER_ID."` = invoice_detail.`".CD_CUSTOMER_ID."` and ".SALES_LEDGER.".`".SL_DEPARTMENT_CODE."` = invoice_detail.`".CD_DEPARTMENT_CODE."` ";
		$query .= " left join ".CUSTOMER." on ".SALES_LEDGER.".`".SL_CUSTOMER_ID."`=".CUSTOMER.".`".CUS_ID."`";
		$query .= " left join ".DEPARTMENT_LEDGER." on ".SALES_LEDGER.".`".SL_DEPARTMENT_CODE."`=".DEPARTMENT_LEDGER.".`".DL_DEPARTMENT_CODE."`";
		$query .= "where (select count(*) from ".DELIVERY_DETAIL." where ".DD_ORDER_ID."=".SALES_LEDGER.".`".SL_ID."`) = ";
		$query .= "(select count(*) from ".DELIVERY_DETAIL." where ".DD_ORDER_ID."=".SALES_LEDGER.".`".SL_ID."` and ".DD_CHECK." = 1) ";
		$query .= " and (select count(*) from ".DELIVERY_DETAIL." where ".DD_ORDER_ID."=".SALES_LEDGER.".`".SL_ID."`) > 0 ";
		$query .= " and ".SALES_LEDGER.'.`'.SL_STATUS.'` = 1 ';

		$query .= " and invoice_detail.`".CD_NOT_ASK_MONEY."`= 0 ";
		if($check_gaichyu == 1){
			$query .= " and  invoice_detail.`".TG_USER_ID."` = '".$user->{U_ID}."' ";
			$query .= " and ".SALES_LEDGER.'.`'.SL_CLAIM_CHECK_GAICHYU."` = 0 ";
		}else{
			if($_SESSION['request-level'] == 'P') $query .= " and invoice_detail.`".TG_USER_ID."` = '".$user->{U_ID}."' ";
			$query .= " and ".SALES_LEDGER.".`".SL_CLAIM_CHECK."` = 0 ";
		}
		if(isset($data['order_no'])) $query .= " and ".SALES_LEDGER.".`".SL_ID."`='".$data['order_no']."' ";
		if(isset($data['user_id'])) $query .= " and ".SALES_LEDGER.".`".SL_USER_ID."`='".$data['user_id']."' ";
		if(isset($data['customer_id'])) $query .= " and ".SALES_LEDGER.'.`'.SL_CUSTOMER_ID.'`='.$data['customer_id'].' ';
		if(isset($data['department_id'])) $query .= " and ".SALES_LEDGER.'.`'.SL_DEPARTMENT_CODE.'`='.$data['department_id'].' ';
		if(isset($data['ship_date_start'])) $query .= " and ".SALES_LEDGER.'.`'.SL_REVENUE_DATE."`>= '".$data['ship_date_start']."' ";
		if(isset($data['ship_date_end'])) $query .= " and ".SALES_LEDGER.'.`'.SL_REVENUE_DATE."`<='".$data['ship_date_end']."' ";
		if(isset($data['order_date_start'])) $query .= " and ".SALES_LEDGER.'.`'.SL_SALES_DATE."`>='".$data['order_date_start']."' ";
		if(isset($data['order_date_end'])) $query .= " and ".SALES_LEDGER.'.`'.SL_SALES_DATE."`<='".$data['order_date_end']."' ";
		$query .= " order by ".SALES_LEDGER.".`".SL_CUSTOMER_ID."` ASC, invoice_detail.`".IGD_ID_INVOICE_GROUP."` ASC";
		$list_order = $this->db->query($query);
		$data = array();
		return $list_order->result();
	}
}