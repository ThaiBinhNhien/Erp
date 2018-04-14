<?php
/**
 *
 */
class Invoice extends VV_Model {

	function __construct() {
		parent::__construct();
		$this->table_name = INVOICE;
		$this->idCol = I_ID;
		$this->valueDateUpdate = I_UPDATE_DATE;

	}

	public function get_max_id() {
		$this->db->order_by(I_ID, 'DESC');
		$invoice = $this->db->get(INVOICE);
		if (count($invoice->result()) == 0) {
			return 1;
		}

		return $invoice->result()[0]->{I_ID}+1;
	}

	//thêm data bảng invoice
	public function add_invoice($data) {
		$this->db->insert(INVOICE, $data);
	}

	//thêm danh sách nhóm giấy đòi tiền
	public function add_list_invoice($data_arr) {
		$invoice_id_arr = array();
		foreach ($data_arr as $invoice) {
			$this->db->insert(INVOICE, $invoice);
			$invoice_id = $this->db->insert_id();
			$invoice_id_arr[] = $invoice_id;
		}
		return $invoice_id_arr;
	}

	public function get_all() {
		$this->db->order_by(I_ID, 'DESC');
		if ($_SESSION['request-level'] == 'P') {
			$this->db->where(I_USER_ID, $_SESSION['login-info'][U_ID]);
		}

		$this->db->limit(10);
		$invoice = $this->db->get(INVOICE);
		return $invoice->result();
	}

	public function get_by_id($invoice_id) {
		$this->db->select("*");
		$this->db->from(INVOICE);
		$this->db->where(INVOICE . '.`' . I_ID . '`', $invoice_id);
		$invoice = $this->db->get();
		if ($invoice->num_rows() == 0) {
			return null;
		}

		return $invoice->result()[0];
	}

	public function update_invoice($data) {
		$this->db->where(I_ID, $data[I_ID]);
		$this->db->update(INVOICE, $data);
	}

	//xóa invoice
	public function del_by_id($invoice_id) {
		$this->db->where(I_ID, $invoice_id);
		$this->db->delete(INVOICE);
	}

	public function get_discount_gaichyu($cus_id, $base_id, $user_id) {
		$this->db->select(FG_TONINEN_FEE . " as linen_discount," . FG_ENVIROMENT_FEE . " as environment_discount," . FG_LAUNDRY_FEE . " as other_discount," . FG_DEPARTMENT_ID . " as department");
		$this->db->from(FEE_OF_GAICHYU);
		$this->db->where(FG_CUSTOMER_ID, $cus_id);
		$this->db->where(FG_GAICHYU_BASE_ID, $base_id);
		$this->db->where(FG_CONTACT_USER_ID, $user_id);
		$discount_gaichyu = $this->db->get();
		if (!empty($discount_gaichyu->result())) {
			return $discount_gaichyu->result()[0];
		} else {
			$data = new stdClass();
			$data->linen_discount = 0;
			$data->environment_discount = 0;
			$data->other_discount = 0;
			$data->department = null;
			return $data;
		}
	}
}