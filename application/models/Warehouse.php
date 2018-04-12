<?php

class Warehouse extends VV_Model {

	function __construct() {
		parent::__construct();
		$this->table_name = T_ISSUE;

		$this->idCol = SHIP_ID;
		$this->valueDateUpdate = SHIP_UPDATE_DATE;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}

	public function get_max_id() {
		$this->db->select_max(SHIP_ID);
		$warehouse = $this->db->get(T_ISSUE);
		if ($warehouse->result()[0]->id == null) {
			return 1;
		}

		return $warehouse->result()[0]->id + 1;
	}

	public function get_arr_user_by_warehouse()
	{
		$query = " select DISTINCT `".SHIP_EMPLOYEE_ID."` as user from `".T_ISSUE."`;";
		$data = $this->db->query($query)->result();
		return $data;
	}

	public function insert($arr) {
		$data = $arr;
		$this->db->insert(T_ISSUE, $data);
	}

	public function get_by_id($id) {
		$this->db->where(SHIP_ID, $id);
		$data = $this->db->get(T_ISSUE);
		if (empty($data)) {
			return null;
		}

		return $data->result()[0];
	}

	public function update($arr) {
		if ($this->level == "P") {
			$this->db->where(SHIP_EMPLOYEE_ID, $this->LOGIN_INFO[U_ID]);
		}
		$this->db->where(SHIP_ID, $arr[SHIP_ID]);
		$this->db->update(T_ISSUE, $arr);
	}

	public function delete_export_order($id) {
		if ($this->level == "P") {
			$this->db->where(SHIP_EMPLOYEE_ID, $this->LOGIN_INFO[U_ID]);
		}
		$this->db->where(SHIP_ID, $id);
		$this->db->delete(T_ISSUE);
	}
	function getWarehouseView($name) {
		$this->db->select("*," . TSP_INVENTORY_LOCATION . " AS name," . TSP_ID . " AS id");
		if ($name != NULL && $name != "") {
			$this->db->like(TSP_INVENTORY_LOCATION, $name, 'after');
		}

		return $this->db->get($this->table_name)->result_array();
	}
	public function filter($data) {
		if (!empty($data['order_no'])) {
			$this->db->where(SHIP_ID, $data['order_no']);
		}

		if (!empty($data['distination_id'])) {
			$this->db->where(SHIP_DISTRIBUTOR_ID, $data['distination_id']);
		}

		if (!empty($data['content_id'])) {
			$this->db->where(SHIP_SHIPMENT_CONTENTS, $data['content_id']);
		}

		if (!empty($data['export_date_start'])) {
			$this->db->where(SHIP_SHIP_DATE . ' >=', $data['export_date_start']);
		}

		if (!empty($data['export_date_end'])) {
			$this->db->where(SHIP_SHIP_DATE . ' <=', $data['export_date_end']);
		}

		if (!empty($data['issuer_id'])) {
			$this->db->where(SHIP_EMPLOYEE_ID, $data['issuer_id']);
		}

		if (!empty($data['shipper_id'])) {
			$this->db->where(SHIP_ISSUER, $data['shipper_id']);
		}

		if (isset($data['status'])) {
			$this->db->where(SHIP_SAVE_STATUS, $data['status']);
		}
//trạng thái
		$this->db->order_by(SHIP_ID, 'DESC');
		$row_start = $data['num_page'];
		$this->db->limit(20, $row_start);
		$warehouse = $this->db->get(T_ISSUE);
		return $warehouse->result();
	}
	public function get_warehouse_information($data) {
		$this->db->select(T_ISSUE . '.' . SHIP_ID . ',' .
			PC_PROCESSING_CONTENT . ',' .
			SHIP_DISTRIBUTOR_ID . ',' .
			SHIP_EMPLOYEE_ID . ',' .
			SHIP_SHIP_DATE . ',' .
			//SHIP_BASE_CODE.','.
			SHIP_GO_TO . ',' .
			SHIP_REMARKS . ',' .
			SHIP_GOODS_RECEIPT_SLIP_ID . ',' .
			SHIP_SAVE_STATUS . ',' .
			TSD_DISTRIBUTOR_NAME . ',' .
			BM_BASE_NAME
		);
		$this->db->from(T_ISSUE);
		$this->db->join(T_PROCESSING_CONTENT, T_PROCESSING_CONTENT . '.`' . PC_ID . '`=' . T_ISSUE . '.`' . SHIP_SHIPMENT_CONTENTS . '`');
		$this->db->join(BASE_MASTER, BASE_MASTER . '.`' . BM_BASE_CODE . '`=' . T_ISSUE . '.`' . SHIP_BASE_CODE . '`');
		$this->db->join(T_SALES_DESTINATION, T_SALES_DESTINATION . '.`' . TSD_ID . '`=' . T_ISSUE . '.`' . SHIP_DISTRIBUTOR_ID . '`');
		if (!empty($data['order_no'])) {
			$this->db->where(T_ISSUE . '.' . SHIP_ID, $data['order_no']);
		}

		if (!empty($data['distination_id'])) {
			$this->db->where(SHIP_DISTRIBUTOR_ID, $data['distination_id']);
		}

		if (!empty($data['content_id'])) {
			$this->db->where(SHIP_SHIPMENT_CONTENTS, $data['content_id']);
		}

		if (!empty($data['export_date_start'])) {
			$this->db->where(SHIP_SHIP_DATE . ' >=', $data['export_date_start']);
		}

		if (!empty($data['export_date_end'])) {
			$this->db->where(SHIP_SHIP_DATE . ' <=', $data['export_date_end']);
		}

		if (!empty($data['issuer_id'])) {
			$this->db->where(SHIP_EMPLOYEE_ID, $data['issuer_id']);
		}

		if (!empty($data['shipper_id'])) {
			$this->db->where(SHIP_ISSUER, $data['shipper_id']);
		}

		if (!empty($data['status'])) {
			$this->db->where(SHIP_SAVE_STATUS, $data['status']);
		}
//trạng thái
		$this->db->order_by(SHIP_ID, 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}
}