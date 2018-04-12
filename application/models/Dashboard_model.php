<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Manage base master
*/
class Dashboard_model extends VV_Model
{
	function __construct()
	{
		parent::__construct();
     }

    // revicen order!
	//get data revicen order!
	public function get_order_list_by_date()
	{
		$this->db->select()
				->from(SALES_LEDGER)
				->where(SL_STATUS, 1)
				->limit(1000)
				->order_by(SL_DATE_CHANGE, 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	//get data revicen order of personal!
	public function get_order_personal_list_by_date($name_personal)
	{
		$array_where = array(SL_USER_ID => $name_personal, SL_STATUS => 1);
		$this->db->select()
				->from(SALES_LEDGER)
				->where($array_where)
				->limit(1000)
				->order_by(SL_DATE_CHANGE, 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}
	public function get_detail_product($id_order)
	{
		$this->db->select()
				->from(ORDER_DETAIL.' odt')
				->where('odt.'.OD_ORDER_ID, $id_order)
				->join(PRODUCT_LEDGER.' prd', 'odt.'.OD_PRODUCT_CODE. ' = '.'prd.'.PL_PRODUCT_ID)
				->limit(20);
		$query = $this->db->get()->result_array();
		return $query;
	}
	// end revicen order!

	//shipment query
	public function get_shipment_list_by_date()
	{
		$this->db->select('o.*, d.'.DC_NAME)
				->from(ORDER_SHIPMENT.' o')
				->join(DELIVERY_CLASSIFICATION .' d' , 'o.'.OS_DELIVERY_CLASSIFICATION.'='.'d.'.DC_ID)
				->limit(1000)
				->order_by(OS_UPDATE_DATE, 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_detail_shipment($id_shipment)
	{
		$this->db->select()
				->from(ORDER_SHIPMENT_DETAIL.' odt')
				->where(OSHD_ORDER_ID, $id_shipment)
				->join(PRODUCT_LEDGER.' prd', 'odt.'.OD_PRODUCT_CODE. ' = '.'prd.'.PL_PRODUCT_ID)
				->limit(20);
		$query = $this->db->get()->result_array();
		return $query;
	}
	//end shipment query

	// revenue query
	public function get_revenue_list()
	{
		$this->db->select('in.*, cs.'.CUS_TYPE_CUSTOMER)
				->from(INVOICE.' in')
				->join(CUSTOMER .' cs' , 'in.'.I_CUSTOMER_ID.'='.'cs.'.CUS_ID)
				->limit(1000)
				->order_by(I_UPDATE_DATE, 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_revenue_person_list($name_personal)
	{
		$this->db->select('in.*, cs.'.CUS_TYPE_CUSTOMER)
				->from(INVOICE.' in')
				->where(I_USER_ID, $name_personal)
				->join(CUSTOMER .' cs' , 'in.'.I_CUSTOMER_ID.'='.'cs.'.CUS_ID)
				->limit(1000)
				->order_by(I_UPDATE_DATE, 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_product_of_revenue($id_revenue)
	{

		$this->db->select('idt.*, odt.*, prd.'.PL_PRODUCT_NAME.', prd.'.PL_COLOR_TONE.' , prd.'.PL_STANDARD)
				->from(INVOICE_DETAIL.' idt' )
				->where('idt.'.ID_INVOICE_ID, $id_revenue)
				->join(ORDER_DETAIL.' odt', 'idt.`'.ID_ORDER_ID. '`='.'odt.'.OD_ORDER_ID)
				->join(PRODUCT_LEDGER.' prd', 'odt.`'.OD_PRODUCT_CODE. '`='.'prd.`'.PL_PRODUCT_ID.'`')
				->limit(20);
		$query = $this->db->get()->result_array();
		return $query;
	}
	// end revenue

	//purchanging query
	public function get_purchanging_list()
	{
		$this->db->select('tod.*, tgri.`'.TGRI_PRODUCT_ID.'`, tgri.`'.TGRI_UNIT_PRICE.'`, tgri.`'.TGRI_PRODUCT_NAME.'`, tgri.`'.TGRI_NUMBER_OF_ORDERS.'`, bm.`'.BM_COMPANY_NAME."`")
				->from(T_ORDER.' tod')
				->join(T_GOODS_RECEIPT_INFORMATION .' tgri' , 'tod.`'.TO_ID.'`='.'tgri.`'.TGRI_ORDER_SLIP_ID."`")
				->join("`".BASE_MASTER.'` bm', 'tod.`'.TO_BASE_CODE.'`='.'bm.`'.BM_BASE_CODE."`")
				->limit(1000)
				->order_by(TO_UPDATE_DATE, 'DESC');
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_product_of_purchar($id_purchar)
	{
		$this->db->select()
				->from(INVOICE_DETAIL.' idt' )
				->where('idt.'.ID_INVOICE_ID, $id_purchar)
				->join(ORDER_DETAIL.' odt', 'idt.`'.ID_ORDER_ID. '`='.'odt.'.OD_ORDER_ID)
				->join(PRODUCT_LEDGER.' prd', 'odt.`'.OD_PRODUCT_CODE. '`='.'prd.`'.PL_PRODUCT_ID.'`')
				->limit(20);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function edit_ficker_shipment($id_click)
	{
		# code...
		$this->db->trans_start(); 
		$data = array(
			FLAG_FLICKER => 1,
		);
		$this->db->where(OS_ID, $id_click);
		$this->db->update(ORDER_SHIPMENT, $data);
		$this->db->trans_complete();
		if($this->db->trans_status() === TRUE) 
		{ 
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}
	