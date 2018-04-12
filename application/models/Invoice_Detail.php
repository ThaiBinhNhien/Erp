<?php
/**
* 
*/
class Invoice_Detail extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		 
	}

	//thêm chi tiết giấy đòi tiền
	public function add_detail($data)
	{
		$order_id_list = explode('|', $data['order_id_list']);
		$discount_cate1 = explode('|', $data['discount_cate1']);
		$discount_cate2 = explode('|', $data['discount_cate2']);
		$arr = array();
		for($i=0 ; $i<count($order_id_list); $i++){
			if(empty($discount_cate1[$i])) $discount_cate1[$i] = 0;
			if(empty($discount_cate2[$i])) $discount_cate2[$i] = 0;
			$arr[] = array(
				ID_INVOICE_ID => $data['invoice_id'],
				ID_ORDER_ID => $order_id_list[$i],
				ID_DISCOUNT_SUPPLIER => $discount_cate1[$i],
				ID_DISCOUNT_ORTHER => $discount_cate2[$i]
			);
		}
		$this->db->insert_batch(INVOICE_DETAIL,$arr);
	}

	public function add_list_detail($arr_inv_detail)
	{
		foreach ($arr_inv_detail as $inv_detail) {
			$this->db->insert_batch(INVOICE_DETAIL,$inv_detail);
		}
	}

	//lấy danh sách order theo giấy đòi tiền
	public function get_detail($invoice_id)
	{
		$this->db->select('*');
		$this->db->from(INVOICE_DETAIL);
		$this->db->join(SALES_LEDGER,INVOICE_DETAIL.'.`'.ID_ORDER_ID.'`='.SALES_LEDGER.'.'.SL_ID,'left');
		$this->db->where(INVOICE_DETAIL.'.'.ID_INVOICE_ID,$invoice_id);
		$invoice_detail = $this->db->get();
		return $invoice_detail->result();
	}

	//tìm danh sách giấy đòi tiền
	public function search_invoice($data = null)
	{
		$query = "SELECT DISTINCT ".INVOICE.".* FROM ".INVOICE_DETAIL." ";
		$query .= " RIGHT JOIN ".INVOICE." ON ".INVOICE_DETAIL.".`".ID_INVOICE_ID."`=".INVOICE.'.`'.I_ID.'` ';
		$query .= " LEFT JOIN ".SALES_LEDGER." ON ".INVOICE_DETAIL.".`".ID_ORDER_ID."`=".SALES_LEDGER.".`".SL_ID."` ";
		if($_SESSION['request-level']=='P') $query .= " where ".INVOICE.'.`'.I_USER_ID."`='".$_SESSION['login-info'][U_ID]."' ";// phân quyền
		else $query .= " where ".INVOICE.'.`'.I_ID."`<> 'abc'";
		if(!empty($data['invoice_id'])) $query .= " AND ".INVOICE.'.`'.I_ID."`='".$data['invoice_id']."' ";
		if(!empty($data['order_id'])) $query .= " AND ".INVOICE_DETAIL.'.`'.ID_ORDER_ID."`='".$data['order_id']."' ";
		if(!empty($data['user_id'])) $query .= " AND ".INVOICE.'.`'.I_USER_ID."`='".$data['user_id']."' ";
		if(!empty($data['ship_date_start'])) $query .= " AND ".SALES_LEDGER.'.`'.SL_DELIVERY_DATE."`>='".$data['ship_date_start']."' ";
		if(!empty($data['ship_date_end'])) $query .= " AND ".SALES_LEDGER.'.`'.SL_DELIVERY_DATE."`<='".$data['ship_date_end']."' ";
		if(isset($data['customer_id'])) if($data['customer_id']!='none') $query .= " AND (".SALES_LEDGER.'.`'.SL_CUSTOMER_ID."`='".$data['customer_id']."' OR ".INVOICE.".`".I_CUSTOMER_ID."`='".$data['customer_id']."') ";
		if(!empty($data['department_id'])) $query .= " AND ".SALES_LEDGER.'.`'.SL_DEPARTMENT_CODE."`='".$data['department_id']."' ";
		$query .= " ORDER BY ".INVOICE.".`".I_ID."` DESC";
		if(isset($data['page_num'])){
			$row_start = 10 * $data['page_num'];
			$query .= " LIMIT ".$row_start.",10";
		}
		$invoice = $this->db->query($query);
		return $invoice->result();
	}

	public function update_invoice_detail($data)
	{
		$invoice_id = $data['invoice_id'];
		$order_id_list = explode('|', $data['order_id_list']);
		$discount_cate1_list = explode('|', $data['discount_cate1_list']);
		$discount_cate2_list = explode('|', $data['discount_cate2_list']);
		$this->db->where(ID_INVOICE_ID,$invoice_id);
		$this->db->delete(INVOICE_DETAIL);
		$data_update = array();
		for($i=0; $i < count($order_id_list); $i++) {
			$data_update[] = array(
				ID_INVOICE_ID => $invoice_id,
				ID_ORDER_ID => $order_id_list[$i],
		        ID_DISCOUNT_SUPPLIER => $discount_cate1_list[$i],
		        ID_DISCOUNT_ORTHER => $discount_cate2_list[$i],
			);
		}
		$this->db->insert_batch(INVOICE_DETAIL,$data_update);
	}

	/**
	*lấy danh sách id order theo invoice id
	*/
	public function get_list_order($invoice_id)
	{
		$this->db->select("*");
		$this->db->from(INVOICE_DETAIL);
		$this->db->join(SALES_LEDGER,INVOICE_DETAIL.'.`'.ID_ORDER_ID.'`='.SALES_LEDGER.'.`'.SL_ID.'`','left');
		$this->db->join(DEPARTMENT_LEDGER,SALES_LEDGER.'.`'.SL_DEPARTMENT_CODE.'`='.DEPARTMENT_LEDGER.'.`'.DL_DEPARTMENT_CODE.'`','left');
		$this->db->where(INVOICE_DETAIL.'.`'.ID_INVOICE_ID.'`',$invoice_id);
		$list_order = $this->db->get();
		return $list_order->result();
	}

	//xóa hết các row theo invoice_id
	public function del_by_invoice_id($invoice_id)
	{
		$this->db->where(ID_INVOICE_ID,$invoice_id);
		$this->db->delete(INVOICE_DETAIL);
	}

	public function get_list_department($invoice_id)
	{
		$this->db->select(SALES_LEDGER.'.`'.SL_DEPARTMENT_CODE.'`');
		$this->db->from(INVOICE_DETAIL);
		$this->db->join(SALES_LEDGER,INVOICE_DETAIL.'.`'.ID_ORDER_ID.'`='.SALES_LEDGER.'.`'.SL_ID.'`','left');
		$this->db->where(INVOICE_DETAIL.'.`'.ID_INVOICE_ID.'`',$invoice_id);
		$list_department = $this->db->get();
		return $list_department->result();
	}
}