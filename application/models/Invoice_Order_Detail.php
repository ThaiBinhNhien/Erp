<?php
/**
* 
*/
class Invoice_Order_Detail extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		 
	}

	public function add_product($data)
	{
		$invoice_id = $data['invoice_id'];
		$product_id_list = explode('|',$data['product_id_list']);
		$product_name_list = explode('|', $data['product_name_list']);
		$amount_list = explode('|', $data['amount_list']);
		$price_list = explode('|', $data['price_list']);
		$sum_price_list = explode('|', $data['sum_price_list']);
		$data_insert = array();
		for ($i=0; $i < count($product_id_list); $i++) { 
			$data_insert[] = array(
				IOD_INVOICE_ID => $invoice_id,
				IOD_PRODUCT_ID => $product_id_list[$i],
				IOD_PRODUCT_NAME => $product_name_list[$i],
				IOD_AMOUNT => $amount_list[$i],
				IOD_PRICE => $price_list[$i],
				IOD_SUM_PRICE => $sum_price_list[$i]
			);
		}
		$this->db->insert_batch(INVOICE_ORDER_DETAIL,$data_insert);
	}

	//lấy tất cả danh sách sản phẩm theo loại
	public function get_list_product_cate($invoice_id,$category_id)
	{
		$this->db->select('*');
		$this->db->from(INVOICE_ORDER_DETAIL);
		$this->db->join(PRODUCT_LEDGER,INVOICE_ORDER_DETAIL.'.`'.IOD_PRODUCT_ID.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`','left');
		$this->db->where(INVOICE_ORDER_DETAIL.'.`'.IOD_INVOICE_ID.'`',$invoice_id);
		if($category_id==1) $this->db->where(PRODUCT_LEDGER.'.`'.PL_CATEGORIES.'`',$category_id);
		else $this->db->where("(".PRODUCT_LEDGER.'.`'.PL_CATEGORIES.'` <> 1 or '.PRODUCT_LEDGER.'.`'.PL_CATEGORIES."` is null )");
		$list_product = $this->db->get();
		return $list_product->result();
	}

	//xóa danh sách sản phẩm của invoice khỏi bảng
	public function del_by_invoice($invoice_id)
	{
		$this->db->where(IOD_INVOICE_ID,$invoice_id);
		$this->db->delete(INVOICE_ORDER_DETAIL);
	}

	//tìm giấy đòi tiền ko chỉ định hóa đơn order
	public function search_invoice($data)
	{
		$this->db->select('DISTINCT('.I_ID.') AS '.ID_INVOICE_ID);
		if(!empty($data['invoice_id'])) $this->db->where(I_ID,$data['invoice_id']);
		if(!empty($data['user_id'])) $this->db->where(I_USER_ID,$data['user_id']);
		if(!empty($data['department_id'])) $this->db->where(I_DEPARTMENT_ID,$data['department_id']);
		if(!empty($data['customer_id'])) $this->db->where(I_CUSTOMER_ID,$data['customer_id']);
		if((!empty($data['ship_date_start'])) or (!empty($data['ship_date_end']))) $this->db->where(I_ID,0);
		if($_SESSION['request-level']=='P') $this->db->where(I_USER_ID,$_SESSION['login-info']['id']);//phân quyền
		$this->db->where(I_HAVE_ORDER,0);
		$list_invoice = $this->db->get(INVOICE);
		return $list_invoice->result();
	}

	//lấy theo giấy đòi tiền và phân loại sản phẩm
	public function get_product_by_invoice_and_category($invoice_id,$category_id)
	{
		$this->db->select('*');
		$this->db->from(INVOICE_ORDER_DETAIL);
		$this->db->join(PRODUCT_LEDGER,INVOICE_ORDER_DETAIL.'.`'.IOD_PRODUCT_ID.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`','left');
		$this->db->where(INVOICE_ORDER_DETAIL.'.`'.IOD_INVOICE_ID.'`',$invoice_id);
		$this->db->where(PRODUCT_LEDGER.'.`'.PL_T_CATALOGUE.'`',$category_id);
		$list_product = $this->db->get();
		return $list_product->result();
	}

	public function update_detail($data)
	{
		$invoice_id = $data['invoice_id'];
		$product_id_arr = explode('|', $data['product_id_list']);
		$product_price_arr = explode('|', $data['product_price_list']);
		$product_amount_arr = explode('|', $data['product_amount_list']);
		foreach ($product_id_arr as $i => $product_id) {
			$this->db->or_where('('.IOD_PRODUCT_ID.'='.$product_id." AND ".IOD_INVOICE_ID."=".$invoice_id.')');
		}
		$this->db->delete(INVOICE_ORDER_DETAIL);
		$data_insert = array();
		foreach ($product_id_arr as $i => $product_id) {
			$data_insert[] = array(
				IOD_INVOICE_ID => $invoice_id,
				IOD_PRODUCT_ID => $product_id,
				IOD_AMOUNT => $product_amount_arr[$i],
				IOD_PRICE => 0,
				IOD_SUM_PRICE => $product_price_arr[$i]
			);
		}
		$this->db->insert_batch(INVOICE_ORDER_DETAIL,$data_insert);
		//print_r($list_detail->result());
	}
}