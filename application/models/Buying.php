<?php

class Buying extends VV_Model {

	function __construct() {
		parent::__construct();
		$this->table_name = T_ORDER;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}
	public function get_product_list($array) {
		if (empty($array)) {
			$sql = "
			SELECT *
			FROM
			(
			SELECT *,
			(@num:=IF(@dateorder = `buying_id`, @num +1, IF(@dateorder := `buying_id`, 1, 1))) row_number
			FROM `buying_detail` AS b
			CROSS JOIN (SELECT @num:=0, @dateorder:=NULL) c
			WHERE b.buying_id IN(NULL)
			ORDER BY `buying_id` DESC
			) AS X
			WHERE x.row_number <= 20;
		";
		} else {
			$sql = "
			SELECT *
			FROM
			(
			SELECT *,
			(@num:=IF(@dateorder = `buying_id`, @num +1, IF(@dateorder := `buying_id`, 1, 1))) row_number
			FROM `buying_detail` AS b
			CROSS JOIN (SELECT @num:=0, @dateorder:=NULL) c
			WHERE b.buying_id IN(" . implode(',', $array) . ")
			ORDER BY `buying_id` DESC
			) AS X
			WHERE x.row_number <= 20;
		";
		}

		$result = $this->db->query($sql);
		return $result->result();
	}

	public function get_order_list_by_date() {
		$sql = "
			SELECT
			t1.id,t1.code,t1.created_at,t1.supplier_name,t1.status,CAST(created_at AS DATE) AS order_date
			FROM
			(
			SELECT *,CAST(created_at AS DATE) AS date1
			FROM
			(
			   SELECT *,
				  (@num3:=IF(@dateorder3 = CAST(created_at AS DATE), @num3 +1, IF(@dateorder3 := CAST(created_at AS DATE), 1, 1))) row_number
			  FROM `buying` t
			  CROSS JOIN (SELECT @num3:=0, @dateorder3:=NULL) c
			  ORDER BY CAST(created_at AS DATE) DESC
			) AS X
			WHERE x.row_number <= 2
			) AS t1
			INNER JOIN
			(
			SELECT  CAST(t.created_at AS DATE) AS date2
			FROM `buying` AS t
			GROUP BY CAST(created_at AS DATE)
			ORDER BY CAST(created_at AS DATE)  DESC
			LIMIT 2
			) AS t2
			ON t1.date1 = t2.date2
			ORDER BY t1.created_at DESC
		";

		$this->db->query("SET @num3:=0;");
		$this->db->query("SET @dateorder3:=NULL;");
		$result = $this->db->query($sql);
		return $result->result();
	}

	public function get_order_id_list() {
		$sql = "
			SELECT
			t1.id
			FROM
			(
			SELECT *,CAST(created_at AS DATE) AS date1
			FROM
			(
			   SELECT *,
				  (@num3:=IF(@dateorder3 = CAST(created_at AS DATE), @num3 +1, IF(@dateorder3 := CAST(created_at AS DATE), 1, 1))) row_number
			  FROM `buying` t
			  CROSS JOIN (SELECT @num3:=0, @dateorder3:=NULL) c
			  ORDER BY CAST(created_at AS DATE) DESC
			) AS X
			WHERE x.row_number <= 2
			) AS t1
			INNER JOIN
			(
			SELECT  CAST(t.created_at AS DATE) AS date2
			FROM `buying` AS t
			GROUP BY CAST(created_at AS DATE)
			ORDER BY CAST(created_at AS DATE)  DESC
			LIMIT 2
			) AS t2
			ON t1.date1 = t2.date2
			ORDER BY t1.created_at DESC
		";
		$this->db->query("SET @num3:=0;");
		$this->db->query("SET @dateorder3:=NULL;");
		$result = $this->db->query($sql);
		return $result->result_array();
	} //End function
	public function get_order_code() {
		$sql = "
		SELECT t.code FROM buying AS t
		ORDER BY t.code DESC
		LIMIT 1
		";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	/* Get supplier list */
	public function get_supplier_list() {
		$sql = " SELECT " . SUP_ID . "," . SUP_SUPPLIER_COMPANY_NAME .
			" FROM " . T_SUPPLIER
		;
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	/* Get processing content */
	public function get_processing_content() {
		$sql = " SELECT " . PC_ID . "," . PC_PROCESSING_CONTENT .
			" FROM " . T_PROCESSING_CONTENT
		;
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	/* Get warehouse location */
	public function get_warehouse_location() {
		$sql = " SELECT " . SHIP_ID . "," . WH_LOCATION .
			" FROM " . WAREHOUSE
		;
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function get_product_code_list() {
		$sql = "
		SELECT `code`
		FROM `product`
		";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	public function get_name($val) {
		$sql = "
		select name,standard,color from product where code=" . $val . "
		";
		$result = $this->db->query($sql);
		return $result->result_array();
		//echo (json_encode($result));

	}
	/* Get produce code when select supplier */
	public function get_produce_code($id) {
		$sql = "
		select " . PS_PRODUCT_ID .
			" from " . PRODUCTS_SUPPLIER .
			" where " . PS_SUPPLIER_ID . "=" . $id
		;
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	public function get_product_detail($id) {
		$sql = "
		select " . P_NAME . "," . P_COLOR . "," . P_STANDARD .
			" from " . PRODUCT .
			" where " . P_ID . "=" . $id
		;
		$result = $this->db->query($sql);
		return $result->result_array();

	}
	public function get_product_price($prod_id, $sup_id) {
		$sql = "
		select " . PS_PRICE .
			" from " . PRODUCTS_SUPPLIER .
			" where " . PS_SUPPLIER_ID . "=" . $sup_id . " and " . PS_PRODUCT_ID . "=" . $prod_id
		;
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	public function insert_order($buying_order) {
		$field = '';
		$values = '';
		foreach ($buying_order as $key => $val) {
			$field .= $key . ',';
			$values .= "'" . $val . "',";
		}
		$fields = rtrim($field, ',');
		$value1 = rtrim($values, ',');
		$sql = "insert into t_発注(" . $fields . ") values (" . $value1 . ")";
		$result = $this->db->query($sql);
		return $this->db->insert_id();
	}

	public function insert_warehouse_info($data) {
		$CI = &get_instance();
		$CI->load->model("Product");
		$product_id = explode("|", $data['product_id_list']);
		$price = explode("|", $data['price_list']);
		$amount_export_product = explode("|", $data['amount_export_list']);
		$list_data = array();
		for ($i = 0; $i < count($product_id); $i++) {
			$list_data[] = array(
				TGRI_ACCRUAL_DATE => $data['date'],
				TGRI_A_DISPOSAL_DAY => $data['date'],
				TGRI_PRODUCT_ID => $product_id[$i],
				TGRI_PRODUCT_NAME => $CI->Product->get_by_id($product_id[$i])->{PL_PRODUCT_NAME_BUY},
				TGRI_OUTBOUND_SLIP_ID => $data['warehouse_id'],
				TGRI_PROCESSING_CONTENT => $data['content_id'],
				TGRI_INVENTORY_LOCATION_ID => $data['stock_id'],
				TGRI_ID_SUPPLIER => $data['supplier_id'],
				TGRI_SALES_DES_ID => $data['sales_des_id'],
				TGRI_BASE_CODE => $data['stock_id'],
				TGRI_UNIT_PRICE => $price[$i],
				TGRI_UNIT_PRICE_SELL => $price[$i],
				TGRI_NUMBER_OF_GOODS_ISSUED => $amount_export_product[$i],
				TGRI_REGISTERED_USER => $data['user_id'],
			);
		}
		$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION, $list_data);
	}

	//thêm sản phẩm loại xuất hàng cho tolinen
	//nếu $tolinen_sale là 1 thì là bán cho tolinen
	public function insert_warehouse_info_2($data, $tolinen_sale = null) {
		$CI = &get_instance();
		$CI->load->model("Product");
		$product_id = explode("|", $data['product_id_list']);
		$arr_price = explode("|", $data['price_list']);
		$product_arr = array();
		$k = 0;
		foreach ($data['product_list'] as $product_list) {
			for ($i = 0; $i < count($product_list['arr_id']); $i++) {
				$price_buy = $product_list['arr_price'][$i];
				if ($tolinen_sale != 1) {
					$product_list['arr_price'][$i] = $arr_price[$k];
				}

				$product_arr[] = array(
					TGRI_ACCRUAL_DATE => $data['date'],
					TGRI_PRODUCT_ID => $product_list['arr_id'][$i],
					TGRI_PRODUCT_NAME => $CI->Product->get_by_id($product_list['arr_id'][$i])->{PL_PRODUCT_NAME_BUY},
					TGRI_OUTBOUND_SLIP_ID => $data['warehouse_id'],
					TGRI_PROCESSING_CONTENT => $data['content_id'],
					TGRI_INVENTORY_LOCATION_ID => $data['stock_id'],
					TGRI_BASE_CODE => $data['stock_id'],
					TGRI_UNIT_PRICE => $price_buy,
					TGRI_UNIT_PRICE_SELL => $product_list['arr_price'][$i],
					TGRI_NUMBER_OF_GOODS_ISSUED => $product_list['arr_amount'][$i],
					TGRI_REGISTERED_USER => $data['user_id'],
					TGRI_ID_SUPPLIER => $product_list['arr_supplier'][$i],
					TGRI_SALES_DES_ID => $data['sales_des_id'],
				);
			}
			$k++;
		}
		$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION, $product_arr);
	}

	public function get_product_id_of_warehouse($warehouse_id) {
		$this->db->distinct();
		$this->db->select(TGRI_PRODUCT_ID);
		$this->db->where(TGRI_OUTBOUND_SLIP_ID, $warehouse_id);
		$product_id = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		return $product_id->result();
	}

	//sửa lại thông tin xuất kho trước đó của sản phẩm nhập kho
	public function replace_export_info($warehouse_id, $product_id) {
		$arr_import = array();
		$i = 0;
		$number_real_export = $this->get_has_export($product_id, $warehouse_id); //số lượng xuất kho thực
		$number_have_warehouse_id = $this->get_number_export_have_warehouse_id($product_id, $warehouse_id); //số lượng xuất kho được đánh dấu
		$this->db->order_by(TGRI_ACCRUAL_DATE, 'asc');
		$this->db->where(TGRI_WAREHOUSE_HAS_EXPORT, $warehouse_id);
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$list_import = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		foreach ($list_import->result() as $import) {
			if ($i == 0) {
				$arr_import[] = array(
					TGRI_ID => $import->{TGRI_ID},
					TGRI_WAREHOUSE_HAS_EXPORT => null,
					TGRI_NUMBER_HAS_EXPORT => (int) $number_have_warehouse_id - (int) $number_real_export,
				);
			} else {
				$arr_import[] = array(
					TGRI_ID => $import->{TGRI_ID},
					TGRI_WAREHOUSE_HAS_EXPORT => null,
					TGRI_NUMBER_HAS_EXPORT => 0,
				);
			}
			$i++;
		}
		$this->db->update_batch(T_GOODS_RECEIPT_INFORMATION, $arr_import, TGRI_ID);
	}

	public function edit_warehouse_info($data) {

		if ($this->level == "P") {
			$this->db->where(TGRI_REGISTERED_USER, $this->LOGIN_INFO[U_ID]);
		}
		//xóa các sản phẩm cũ
		$this->db->where(TGRI_OUTBOUND_SLIP_ID, $data['warehouse_id']);
		$this->db->delete(T_GOODS_RECEIPT_INFORMATION);

		$CI = &get_instance();
		$CI->load->model("Product");
		$product_id = explode("|", $data['product_id_list']);
		$price = explode("|", $data['price_list']);
		$amount_export_product = explode("|", $data['amount_export_list']);
		for ($i = 0; $i < count($product_id); $i++) {
			$this->db->set(TGRI_ACCRUAL_DATE, $data['date']);
			$this->db->set(TGRI_PRODUCT_ID, $product_id[$i]);
			$this->db->set(TGRI_PRODUCT_NAME, $CI->Product->get_by_id($product_id[$i])->商品名);
			$this->db->set(TGRI_OUTBOUND_SLIP_ID, $data['warehouse_id']);
			$this->db->set(TGRI_PROCESSING_CONTENT, $data['content_id']);
			$this->db->set(TGRI_UNIT_PRICE, $price[$i]);
			$this->db->set(TGRI_NUMBER_OF_GOODS_ISSUED, $amount_export_product[$i]);
			$this->db->set(TGRI_REGISTERED_USER, $data['user_id']);
			$this->db->insert(T_GOODS_RECEIPT_INFORMATION);
		}
	}

	//lấy thông tin để tính fifo
	public function get_info_fifo($product_id, $stock_id) {
		$arr_id = '';
		$arr_date = '';
		$arr_price = '';
		$arr_amount = '';
		$arr_supplier = '';

		$query = "select * from `".T_GOODS_RECEIPT_INFORMATION."` "
				." where `".TGRI_PRODUCT_ID."` = ".$product_id." "
				." and `".TGRI_BASE_CODE."` = ".$stock_id." "
				." and `".TGRI_GOODS_RECEIPT_SLIP_ID."` > 0 "
				." and `".TGRI_CUMULATIVE_GOODS_RECEIPT."` > `".TGRI_NUMBER_HAS_EXPORT."` "
				." order by `".TGRI_ACCRUAL_DATE."` asc ";

		// $this->db->order_by(TGRI_ACCRUAL_DATE, 'asc');
		// $this->db->where(TGRI_PRODUCT_ID, $product_id);
		// $this->db->where(TGRI_BASE_CODE, $stock_id);
		// $this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID . ' > ', 0);
		// $this->db->where(TGRI_CUMULATIVE_GOODS_RECEIPT . ' > ' . TGRI_NUMBER_HAS_EXPORT);
		// $products = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		$products = $this->db->query($query);
		$i = 0;
		if (count($products->result()) > 0) {
			foreach ($products->result() as $product) {
				if ($i == 0) {
					$arr_id .= $product->{TGRI_ID};
					$arr_date .= $product->{TGRI_ACCRUAL_DATE};
					$arr_price .= $product->{TGRI_UNIT_PRICE};
					$arr_amount .= ((int) $product->{TGRI_CUMULATIVE_GOODS_RECEIPT}-(int) $product->{TGRI_NUMBER_HAS_EXPORT});
					$arr_supplier .= $product->{TGRI_ID_SUPPLIER};
					$i++;
				} else {
					$arr_id .= '|' . $product->{TGRI_ID};
					$arr_date .= '|' . $product->{TGRI_ACCRUAL_DATE};
					$arr_price .= '|' . $product->{TGRI_UNIT_PRICE};
					$arr_amount .= '|' . ((int) $product->{TGRI_CUMULATIVE_GOODS_RECEIPT}-(int) $product->{TGRI_NUMBER_HAS_EXPORT});
					$arr_supplier .= '|' . $product->{TGRI_ID_SUPPLIER};
					$i++;
				}
			}
		}
		return array(
			'arr_id' => $arr_id,
			'arr_date' => $arr_date,
			'arr_price' => $arr_price,
			'arr_amount' => $arr_amount,
			'arr_supplier' => $arr_supplier,
		);
	}

	public function get_info_back($product_id, $stock_id) {
		$arr_id = '';
		$arr_date = '';
		$arr_price = '';
		$arr_amount = '';
		$arr_supplier = '';

		$query = "select `" . TGRI_ID . "`,`" . TGRI_ACCRUAL_DATE . "`,`" . TGRI_UNIT_PRICE . "`,`" . TGRI_CUMULATIVE_GOODS_RECEIPT . "`,`" . TGRI_NUMBER_HAS_EXPORT . "`"
			. ",`" . TGRI_ID_SUPPLIER . "` from `" . T_GOODS_RECEIPT_INFORMATION . "` "
			. " where `" . TGRI_NUMBER_HAS_EXPORT . "` > 0 "
			. " and `" . TGRI_GOODS_RECEIPT_SLIP_ID . "` > 0"
			. " and `" . TGRI_PRODUCT_ID . "` = " . $product_id
			. " and `" . TGRI_BASE_CODE . "` = " . $stock_id
			. " order by `" . TGRI_ACCRUAL_DATE . "` DESC "
			. " limit 50 ";
		$products = $this->db->query($query);
		if (count($products->result()) > 0) {
			foreach ($products->result() as $key => $product) {
				if ($key == 0) {
					$arr_id .= $product->{TGRI_ID};
					$arr_date .= $product->{TGRI_ACCRUAL_DATE};
					$arr_price .= $product->{TGRI_UNIT_PRICE};
					$arr_amount .= (int) $product->{TGRI_NUMBER_HAS_EXPORT};
					$arr_supplier .= $product->{TGRI_ID_SUPPLIER};
				} else {
					$arr_id .= '|' . $product->{TGRI_ID};
					$arr_date .= '|' . $product->{TGRI_ACCRUAL_DATE};
					$arr_price .= '|' . $product->{TGRI_UNIT_PRICE};
					$arr_amount .= '|' . (int) $product->{TGRI_NUMBER_HAS_EXPORT};
					$arr_supplier .= '|' . $product->{TGRI_ID_SUPPLIER};
				}
			}
		}
		return array(
			'arr_id' => $arr_id,
			'arr_date' => $arr_date,
			'arr_price' => $arr_price,
			'arr_amount' => $arr_amount,
			'arr_supplier' => $arr_supplier,
		);
	}

	//lấy thông tin tính fifo trong màn hình edit
	public function get_info_edit_fifo($product_id, $stock_id, $warehouse_id) {
		$arr_id = '';
		$arr_date = '';
		$arr_price = '';
		$arr_amount = '';
		$number_real_export = $this->get_has_export($product_id, $warehouse_id); //số lượng xuất kho thực
		$number_have_warehouse_id = $this->get_number_export_have_warehouse_id($product_id, $warehouse_id); //số lượng xuất kho được đánh dấu
		// $this->db->order_by(TGRI_ACCRUAL_DATE, 'asc');
		// $this->db->where(TGRI_PRODUCT_ID, $product_id);
		// $this->db->where(TGRI_BASE_CODE, $stock_id);
		// $this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID . ' >', 0);
		// $this->db->where("(`" . TGRI_CUMULATIVE_GOODS_RECEIPT . "` > " . TGRI_NUMBER_HAS_EXPORT . "` or `" . TGRI_WAREHOUSE_HAS_EXPORT . "` = $warehouse_id)");
		// $products = $this->db->get(T_GOODS_RECEIPT_INFORMATION);

		$query = " select * from `".T_GOODS_RECEIPT_INFORMATION."` "
				." where `".TGRI_PRODUCT_ID."` = ".$product_id." "
				." and `".TGRI_BASE_CODE."` = ".$stock_id." "
				." and `".TGRI_GOODS_RECEIPT_SLIP_ID."` > 0 "
				." and (`".TGRI_CUMULATIVE_GOODS_RECEIPT."` > `".TGRI_NUMBER_HAS_EXPORT."` OR `".TGRI_WAREHOUSE_HAS_EXPORT."` = ".$warehouse_id.") "
				." order by `".TGRI_ACCRUAL_DATE."` asc ";
		$products = $this->db->query($query);

		$i = 0;
		foreach ($products->result() as $product) {
			if ($i == 0) {
				$arr_id .= $product->{TGRI_ID};
				$arr_date .= $product->{TGRI_ACCRUAL_DATE};
				$arr_price .= $product->{TGRI_UNIT_PRICE};
				$arr_amount .= ((int) $product->{TGRI_CUMULATIVE_GOODS_RECEIPT}-((int) $number_have_warehouse_id - (int) $number_real_export));
			} else {
				$arr_id .= '|' . $product->{TGRI_ID};
				$arr_date .= '|' . $product->{TGRI_ACCRUAL_DATE};
				$arr_price .= '|' . $product->{TGRI_UNIT_PRICE};
				if ($product->{TGRI_WAREHOUSE_HAS_EXPORT} == $warehouse_id) {
					$arr_amount .= '|' . $product->{TGRI_CUMULATIVE_GOODS_RECEIPT};
				} else {
					$arr_amount .= '|' . ($product->{TGRI_CUMULATIVE_GOODS_RECEIPT}-$product->{TGRI_NUMBER_HAS_EXPORT});
				}

			}
			$i++;
		}
		return array(
			'arr_id' => $arr_id,
			'arr_date' => $arr_date,
			'arr_price' => $arr_price,
			'arr_amount' => $arr_amount,
		);
	}

	public function get_number_export_have_warehouse_id($product_id, $warehouse_id) {
		$number = 0;
		$this->db->select("sum(" . TGRI_NUMBER_HAS_EXPORT . ") as amount");
		$this->db->from(T_GOODS_RECEIPT_INFORMATION);
		$this->db->where(TGRI_WAREHOUSE_HAS_EXPORT, $warehouse_id);
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$products = $this->db->get()->result();
		/*foreach($products as $product){
				$number += (int)$product->{TGRI_NUMBER_HAS_EXPORT};
			}
		*/
		return $products[0]->amount + 0;
	}

	// chèn số lượng đã xuất vào hóa đơn nhập kho
	public function insert_number_has_export($data, $warehouse_id) {
		$data_update = array();
		foreach ($data as $data_arr) {
			for ($i = 0; $i < count($data_arr['arr_tb_id']); $i++) {
				$number = $this->get_by_id($data_arr['arr_tb_id'][$i])->{TGRI_NUMBER_HAS_EXPORT};
				$data_update[] = array(
					TGRI_ID => $data_arr['arr_tb_id'][$i],
					TGRI_NUMBER_HAS_EXPORT => (int) $number + (int) $data_arr['arr_amount'][$i],
					TGRI_WAREHOUSE_HAS_EXPORT => $warehouse_id,
				);
			}
		}

		$this->db->update_batch(T_GOODS_RECEIPT_INFORMATION, $data_update, TGRI_ID);
	}

	//cập nhật số lượng đã xuất kho của hóa đơn nhập
	public function update_number_has_export($data) {
		$data_update = array();
		foreach ($data as $data_arr) {
			for ($i = 0; $i < count($data_arr['arr_tb_id']); $i++) {
				$data_update[] = array(
					TGRI_ID => $data_arr['arr_tb_id'][$i],
					TGRI_NUMBER_HAS_EXPORT => $data_arr['arr_amount_has_export'][$i],
				);
			}
		}
		$this->db->update_batch(T_GOODS_RECEIPT_INFORMATION, $data_update, TGRI_ID);
	}

	//lấy row dữ liệu của bảng thông tin xuất nhập kho theo id của bảng
	public function get_by_id($tb_id) {
		$this->db->where(TGRI_ID, $tb_id);
		$row = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		if (empty($row->result())) {
			return null;
		}

		return $row->result()[0];
	}

	//lấy danh sách ngày nhập kho
	public function get_list_date_import($product_id, $stock_id) {
		$arr_date = '';
		$this->db->order_by(TGRI_ACCRUAL_DATE, 'asc');
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$this->db->where(TGRI_INVENTORY_LOCATION_ID, $stock_id);
		$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID . ' >', 0);
		$products = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		if (count($products->result()) > 0) {
			foreach ($products->result() as $product) {
				$arr_date .= $product->{TGRI_ACCRUAL_DATE} . '|';
			}
		} else {
			return null;
		}

		return $arr_date;
	}

	public function get_price_product_with_date($product_id, $stock_id) {
		$arr_price = '';
		$this->db->distinct();
		$this->db->order_by(TGRI_ACCRUAL_DATE, 'asc');
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$this->db->where(TGRI_INVENTORY_LOCATION_ID, $stock_id);
		$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID . ' >', 0);
		$products = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		if (count($products->result()) > 0) {
			foreach ($products->result() as $product) {
				$arr_price .= $product->{TGRI_UNIT_PRICE}+0 . '|';
			}
		} else {
			return null;
		}

		return $arr_price;
	}

	public function get_amount_product_with_date($product_id, $stock_id) {
		$arr_amount = '';
		$this->db->distinct();
		$this->db->order_by(TGRI_ACCRUAL_DATE, 'asc');
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$this->db->where(TGRI_INVENTORY_LOCATION_ID, $stock_id);
		$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID . ' >', 0);
		$products = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		if (count($products->result()) > 0) {
			foreach ($products->result() as $product) {
				$arr_amount .= $product->{TGRI_GOODS_RECEIPT}+0 . '|';
			}
		} else {
			return null;
		}

		return $arr_amount;
	}

	// lấy danh sách sản phẩm theo id hóa đơn xuất hàng
	public function get_product_with_warehouse($id) {
		$this->db->select('*');
		$this->db->from(T_GOODS_RECEIPT_INFORMATION);
		$this->db->join(PRODUCT_LEDGER, T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_PRODUCT_ID . '`=' . PRODUCT_LEDGER . '.`' . PL_PRODUCT_ID . '`', 'left');
		$this->db->where(T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_OUTBOUND_SLIP_ID . '`', $id);
		$product_list = $this->db->get();
		return $product_list->result();
	}

	//danh sách hóa đơn xuât kho chi tiết loại fifo
	public function get_product_with_warehouse_2($id) {
		// $this->db->select('*');
		// $this->db->from(T_GOODS_RECEIPT_INFORMATION);
		// $this->db->join(PRODUCT_LEDGER,T_GOODS_RECEIPT_INFORMATION.'.`'.TGRI_PRODUCT_ID.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`','left');
		// $this->db->where(T_GOODS_RECEIPT_INFORMATION.'.`'.TGRI_OUTBOUND_SLIP_ID.'`',$id);
		$query = "select * from " . T_GOODS_RECEIPT_INFORMATION . " left join " . PRODUCT_LEDGER
			. " on " . T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_PRODUCT_ID . '` = ' . PRODUCT_LEDGER . '.`' . PL_PRODUCT_ID . '` '
			. " where " . T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_OUTBOUND_SLIP_ID . '` = ' . $id . '; ';
		$product_list = $this->db->query($query)->result();
		$list_product_arr = array();
		$price_unit_arr = array();
		$j = 0;
		for ($i = 0; $i < count($product_list); $i++) {
			if ($i == 0) {
				$list_product_arr[$j] = new stdClass();
				$list_product_arr[$j] = $product_list[$i];
				$list_product_arr[$j]->total_price = $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED} * $product_list[$i]->{TGRI_UNIT_PRICE_SELL};
				$price_unit_arr = self::get_price_unit($price_unit_arr, $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED}, $product_list[$i]->{TGRI_UNIT_PRICE_SELL});
				$list_product_arr[$j]->price_unit = self::export_price_unit_to_string($price_unit_arr);
				$list_product_arr[$j]->amount = $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED};
			} else {
				if ($product_list[$i]->{TGRI_PRODUCT_ID} == $product_list[$i - 1]->{TGRI_PRODUCT_ID}) {
					$price_unit_arr = self::get_price_unit($price_unit_arr, $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED}, $product_list[$i]->{TGRI_UNIT_PRICE_SELL});
					$list_product_arr[$j]->price_unit = self::export_price_unit_to_string($price_unit_arr);
					$list_product_arr[$j]->total_price += $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED} * $product_list[$i]->{TGRI_UNIT_PRICE_SELL};
					$list_product_arr[$j]->amount += $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED};
				} else {
					$j++;
					$list_product_arr[$j] = new stdClass();
					$price_unit_arr = array();
					$list_product_arr[$j] = $product_list[$i];
					$price_unit_arr = self::get_price_unit($price_unit_arr, $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED}, $product_list[$i]->{TGRI_UNIT_PRICE_SELL});
					$list_product_arr[$j]->price_unit = self::export_price_unit_to_string($price_unit_arr);
					$list_product_arr[$j]->total_price = $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED} * $product_list[$i]->{TGRI_UNIT_PRICE_SELL};
					$list_product_arr[$j]->amount = $product_list[$i]->{TGRI_NUMBER_OF_GOODS_ISSUED};
				}
			}
		}
		return $list_product_arr;
	}

	//đưa giá và số lượng sản phẩm vào mảng
	private function get_price_unit($arr, $amount, $price) {
		$has_import = false;
		for ($i = 0; $i < count($arr); $i++) {
			if ($arr[$i]['price'] == $price) {
				$arr[$i]['amount'] += $amount;
				$has_import = true;
			}
		}
		if ($has_import == false) {
			$arr[] = array('price' => $price, 'amount' => $amount);
		}
		return $arr;
	}

	//đưa dữ liệu đơn giá sản phẩm ra chuỗi
	private function export_price_unit_to_string($arr) {
		$unit_price_list = '';
		for ($i = 0; $i < count($arr); $i++) {
			if ($i == 0) {
				$unit_price_list .= $arr[$i]['price'] . "(" . $arr[$i]['amount'] . ")";
			} else {
				$unit_price_list .= "," . $arr[$i]['price'] . "(" . $arr[$i]['amount'] . ")";
			}

		}
		if (count($arr) == 1) {
			return $arr[0]['price'];
		}

		return $unit_price_list;
	}

	//xóa sản phẩm thông qua id hóa đơn xuất kho
	public function delete_with_warehouse_id($id) {
		if ($this->level == "P") {
			$this->db->where(TGRI_REGISTERED_USER, $this->LOGIN_INFO[U_ID]);
		}
		$this->db->where(TGRI_OUTBOUND_SLIP_ID, $id);
		$this->db->delete(T_GOODS_RECEIPT_INFORMATION);
	}

	//xóa tất cả các sản phẩm của phiếu xuất kho
	public function delete_product_of_warehouse_id($warehouse_id) {
		$this->db->where(TGRI_OUTBOUND_SLIP_ID, $warehouse_id);
		$this->db->delete(T_GOODS_RECEIPT_INFORMATION);
	}

	//lấy đơn giá FIFO
	public function get_price_unit_FIFO($product_id, $stock_id, $number_export) {
		$info_fifo = $this->get_info_fifo($product_id, $stock_id);
		$amount_list = $info_fifo['arr_amount']; //$this->get_amount_product_with_date($product_id,$stock_id);
		$price_list = $info_fifo['arr_price']; //$this->get_price_product_with_date($product_id,$stock_id);
		$amount_arr = explode('|', $amount_list);
		$price_arr = explode('|', $price_list);
		$n = 0;
		for ($i = 0; $i < count($price_arr); $i++) {
			$n += $amount_arr[$i];
			if ($n > $number_export) {
				return $price_arr[$i];
			}

		}
	}

	//tính tổng số lượng sản phẩm đã xuất kho
	public function get_number_export($product_id, $stock_id) {
		$number = 0;
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$this->db->where(TGRI_BASE_CODE, $stock_id);
		$this->db->where(TGRI_OUTBOUND_SLIP_ID . ' !=', null);
		$this->db->where(TGRI_PROCESSING_CONTENT . ' !=', 6);
		$product = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		foreach ($product->result() as $pro) {
			$number += $pro->{TGRI_NUMBER_OF_GOODS_ISSUED}+0;
		}
		return $number;
	}

	//lấy số lượng sản phẩm đã xuất kho trước đó trong hóa đơn xuất kho
	public function get_number_export_before($id_product, $id_export_warehouse) {
		$number = 0;
		$this->db->where(TGRI_OUTBOUND_SLIP_ID, $id_export_warehouse);
		$this->db->where(TGRI_PRODUCT_ID, $id_product);
		$id_current = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		if (!empty($id_current->result())) {
			$id_current = $id_current->result()[0]->{TGRI_ID};
		} else {
			$id_current = 0;
		}

		$this->db->select('*');
		$this->db->from(T_GOODS_RECEIPT_INFORMATION);
		$this->db->where(TGRI_OUTBOUND_SLIP_ID . "!=", null);
		$this->db->where(TGRI_PRODUCT_ID, $id_product);
		if ($id_current != 0) {
			$this->db->where(TGRI_ID . "<", $id_current);
		}

		$list_product = $this->db->get();
		foreach ($list_product->result() as $product) {
			$number += $product->{TGRI_NUMBER_OF_GOODS_ISSUED};
		}
		return $number;
	}

	//lấy số lượng sản phẩm đã đặt trong hóa đơn export trước đó
	public function get_has_export($id_product, $id_export_warehouse) {
		$number = 0;
		$this->db->select('sum(' . TGRI_NUMBER_OF_GOODS_ISSUED . ') as amount');
		$this->db->from(T_GOODS_RECEIPT_INFORMATION);
		$this->db->where(TGRI_OUTBOUND_SLIP_ID, $id_export_warehouse);
		$this->db->where(TGRI_PRODUCT_ID, $id_product);
		$product = $this->db->get();
		/*if(count($product->result())==0) return $number;
			foreach ($product->result() as $pro) {
				$number += $pro->{TGRI_NUMBER_OF_GOODS_ISSUED};
			}
		*/
		return $product->result()[0]->amount + 0;
	}

	//lấy giá trị id lón nhất của bảng nhập kho
	public function get_max_purchase_id() {
		$maxid = $this->db->query('SELECT MAX(' . GR_ID . ') AS `maxid` FROM `' . T_GOODS_RECEIPT . '`')->row()->maxid;
		return $maxid + 1;
	}

	//lấy giá trị lón nhất của hóa đơn nhập kho
	public function get_max_order_id() {
		$maxid = $this->db->query('SELECT MAX(' . TO_ID . ') AS `maxid` FROM `' . T_ORDER . '`')->row()->maxid;
		return $maxid + 1;
	}

	//lấy lũy tích nhập kho của sản phẩm theo hóa đơn nhập kho
	public function get_accumulation_of_product($purchase_id, $product_id) {
		$accumulation = 0;
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID, $purchase_id);
		$list_product = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		foreach ($list_product->result() as $product) {
			$accumulation += $product->{TGRI_CUMULATIVE_GOODS_RECEIPT};
		}
		return $accumulation;
	}

	//thêm data order nhập kho
	public function add_order($data) {
		$this->db->insert(T_ORDER, $data);
	}

	//sửa hóa đơn nhập kho
	public function edit_order($data) {
		if ($this->level == "P") {
			$this->db->where(TO_EMPLOYEE_ID, $this->LOGIN_INFO[U_ID]);
		}
		$this->db->where(TO_ID, $data[TO_ID]);
		$this->db->update(T_ORDER, $data);
	}

	//cập nhật danh sách sản phẩm order nhập kho
	public function update_product_list_purchase_order($data) {
		//xóa danh sách sản phẩm cũ
		if ($this->level == "P") {
			$this->db->where(TGRI_REGISTERED_USER, $this->LOGIN_INFO[U_ID]);
		}
		$this->db->where(TGRI_ORDER_SLIP_ID, $data['order_id']);
		$this->db->delete(T_GOODS_RECEIPT_INFORMATION);

		//thêm danh sách sản phẩm mới
		$list_data = array();
		for ($i = 0; $i < count($data['product_id_array']); $i++) {
			$list_data[] = array(
				TGRI_PRODUCT_ID => $data['product_id_array'][$i],
				TGRI_PRODUCT_NAME => $data['product_name_array'][$i],
				TGRI_ORDER_SLIP_ID => $data['order_id'],
				TGRI_UNIT_PRICE => $data['product_price_array'][$i],
				TGRI_BASE_CODE => $data['base_code'],
				TGRI_ACCRUAL_DATE => $data['order_date'],
				TGRI_A_DISPOSAL_DAY => $data['order_date'],
				TGRI_ID_SUPPLIER => $data['supplier_id'],
				TGRI_SALES_DES_ID => $data['sales_des_id'],
				TGRI_REGISTERED_USER => $data['register_user'],
				TGRI_NUMBER_OF_ORDERS => $data['product_amount_array'][$i],
				TGRI_REMARKS => $data['product_comment_array'][$i],
			);
		}
		$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION, $list_data);
	}

	//thêm data chi tiết sản phẩm cho order nhập kho
	public function add_list_product_for_order($data) {
		$list_data = array();
		for ($i = 0; $i < count($data['product_id_array']); $i++) {
			$list_data[] = array(
				TGRI_ACCRUAL_DATE => $data['order_date'],
				TGRI_A_DISPOSAL_DAY => $data['order_date'],
				TGRI_ID_SUPPLIER => $data['supplier_id'],
				TGRI_SALES_DES_ID => $data['sales_des_id'],
				TGRI_PROCESSING_CONTENT => $data['content_id'],
				TGRI_PRODUCT_ID => $data['product_id_array'][$i],
				TGRI_PRODUCT_NAME => $data['product_name_array'][$i],
				TGRI_ORDER_SLIP_ID => $data['order_id'],
				TGRI_REGISTERED_USER => $data['register_user'],
				TGRI_UNIT_PRICE => $data['product_price_array'][$i],
				TGRI_NUMBER_OF_ORDERS => $data['product_amount_array'][$i],
				TGRI_BASE_CODE => $data['base_code'],
				TGRI_REMARKS => $data['product_comment_array'][$i],
			);
		}
		$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION, $list_data);
	}

	//thêm sản phẩm order cho loaị chuyển kho
	public function add_list_product_for_order_2($data) {
		$data_insert = array();
		foreach ($data['list_product'] as $product) {
			for ($i = 0; $i < count($product['arr_id']); $i++) {
				$data_insert[] = array(
					TGRI_INVENTORY_LOCATION_ID => $data['stock'],
					TGRI_ACCRUAL_DATE => $product['arr_date'][$i],
					TGRI_PROCESSING_CONTENT => 4,
					TGRI_NUMBER_OF_ORDERS => $product['arr_amount'][$i],
					TGRI_PRODUCT_ID => $product['arr_id'][$i],
					TGRI_UNIT_PRICE => $product['arr_price'][$i],
					TGRI_PRODUCT_NAME => $product['arr_name'][$i],
					TGRI_BASE_CODE => $data['base_code'],
					TGRI_REGISTERED_USER => $data['register_user'],
					TGRI_ID_SUPPLIER => 0,
					TGRI_ORDER_SLIP_ID => $data['order_id'],
				);
			}
		}
		$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION, $data_insert);
	}

	//lấy thông tin order nhập kho
	public function get_detail_order_purchase($order_id) {
		$this->db->where(TO_ID, $order_id);
		$order_detail = $this->db->get(T_ORDER);
		if (empty($order_detail)) {
			return null;
		}

		return $order_detail->result()[0];
	}

	//lấy danh sách order nhập kho, giới hạn 10 hóa đơn
	public function get_list_order_purchase($data) {
		
		$query = " select ".TO_ID . ',' . TO_VENDOR_ID . ',' . TO_ORDER_DETAIL . ',' . TO_REGISTERED_USER . ',' . TO_BASE_CODE . ',' . TO_ORDER_DATE . ',' . TO_FORM . ',' . TO_RECEIPT." from ".T_ORDER
				." where NOT (`".TO_REGISTERED_USER."` <> '".$_SESSION['login-info'][U_ID]."' AND `".TO_FORM."` = 0) ";

		if($_SESSION['request-level'] == 'P'){
			$query .= " and `".$_SESSION['login-info'][U_ID]."` = `".TO_REGISTERED_USER."` ";
		}

		if (!empty($data['order_id'])) {
			$query .= " and `".TO_ID."` = '".$data['order_id']."' ";
		}

		if (isset($data['supplier_id']) && $data['supplier_id'] != '') {
			//$this->db->where(TO_VENDOR_ID, $data['supplier_id']);
			$query .= " and `".TO_VENDOR_ID."` = ".$data['supplier_id']." ";
		}

		if (!empty($data['content_id'])) {
			//$this->db->where(TO_ORDER_DETAIL, $data['content_id']);
			$query .= " and `".TO_ORDER_DETAIL."` = ".$data['content_id']." ";
		}

		if (!empty($data['user_id'])) {
			$query .= " and (`".TO_REGISTERED_USER."` = '".$data['user_id']."' OR `".TO_EMPLOYEE_ID."` = '".$data['user_id']."') ";
		}
		if (!empty($data['base_id'])) {
			$query .= " and `".TO_BASE_CODE."` = ".$data['base_id']." ";
		}

		if (!empty($data['order_date_start'])) {
			$query .= " and `".TO_ORDER_DATE."` >= '".str_replace('/', '-', $data['order_date_start'])."' ";
		}

		if (!empty($data['order_date_end'])) {
			$query .= " and `".TO_ORDER_DATE."` <= '".str_replace('/', '-', $data['order_date_end'])."' ";
		}

		if (!empty($data['sales_des_id'])) {
			$query .= " and `".TO_SALES_DESTINATION."` = ".$data['sales_des_id']." ";
		}

		if (!empty($data['status'])) {
			$query .= " and `".TO_FORM."` = ".($data['status'] - 1);
		}

		if (!empty($data['is_import'])) {
			$query .= " and `".TO_RECEIPT."` = ".($data['is_import'] - 1);
		}
		$query .= " order by `".TO_ID."` DESC ";
		$query .= " LIMIT ".$data['page'].", 20 ";

		$list_order = $this->db->query($query);
		return $list_order->result();
	}

	//lấy danh sách sản phẩm của order nhập kho
	public function product_list_of_order_purchase($order_id) {
		$this->db->select('*');
		$this->db->select(T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_REMARKS . "` AS 'remark'");
		$this->db->from(T_GOODS_RECEIPT_INFORMATION);
		$this->db->join(PRODUCT_LEDGER, T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_PRODUCT_ID . '`=' . PRODUCT_LEDGER . '.`' . PL_PRODUCT_ID . '`', 'left');
		$this->db->where(TGRI_ORDER_SLIP_ID, $order_id);
		$product_list = $this->db->get();
		return $product_list->result();
	}

	//xác nhận order nhập kho
	public function confirm_order_purchase($data) {
		$this->db->set(TO_AUTHORIZER, $data['confirm_user']);
		if ($data['confirm_user'] == null) {
			$this->db->set(TO_FORM, 1);
		} else {
			$this->db->set(TO_FORM, 2);
		}

		$this->db->where(TO_ID, $data['id']);
		$this->db->update(T_ORDER);
	}

	//thêm trạng thái cho biết order đã được nhập kho
	public function add_import_order_purchase($order_id, $check_has_import) {
		$this->db->set(TO_RECEIPT, $check_has_import);
		$this->db->where(TO_ID, $order_id);
		$this->db->update(T_ORDER);
	}

	//xóa danh sách sản phẩm order nhập kho
	public function del_product_list_purchase_order($order_id) {
		if ($this->level == "P") {
			$this->db->where(TGRI_REGISTERED_USER, $this->LOGIN_INFO[U_ID]);
		}
		$this->db->where(TGRI_ORDER_SLIP_ID, $order_id);
		$this->db->delete(T_GOODS_RECEIPT_INFORMATION);
	}

	//xóa order nhập kho
	public function del_purchase_order($order_id) {
		if ($this->level == "P") {
			$this->db->where(TO_EMPLOYEE_ID, $this->LOGIN_INFO[U_ID]);
		}
		$this->db->where(TO_ID, $order_id);
		$this->db->delete(T_ORDER);

	}

	public function update_order_tb_after_import($data) {
		$this->db->where(TO_ID, $data['id']);
		$this->db->where(TO_DELIVERY_DATE, NULL);
		$this->db->set(TO_DELIVERY_DATE, $data['date_import']);
		$this->db->update(T_ORDER);
	}

	public function insert_import_purchase($data) {

		$this->db->where(GR_ORDER_SLIP_ID, $data[GR_ORDER_SLIP_ID]);
		$t_purchase = $this->db->get(T_GOODS_RECEIPT);
		if ($t_purchase->num_rows() > 0) {
			$this->db->where(GR_ORDER_SLIP_ID, $data[GR_ORDER_SLIP_ID]);
			$this->db->update(T_GOODS_RECEIPT, $data);
			return $t_purchase->result()[0]->{GR_ID};
		} else {
			$this->db->insert(T_GOODS_RECEIPT, $data);
		}
		$id = $this->db->insert_id();
		//$this->db->close();
		return $id;
	}

	//thêm danh sách sản phẩm nhập kho
	public function insert_info_import_purchase($data) {
		self::add_import_order_purchase($data['order_id'], $data['check_has_import']);
		$product_list = array();
		for ($i = 0; $i < count($data['product_id_list']); $i++) {
			$product_list[$i] = array(
				TGRI_ID_SUPPLIER => $data['supplier_id'],
				TGRI_SALES_DES_ID => $data['sales_des_id'],
				TGRI_PRODUCT_ID => $data['product_id_list'][$i],
				TGRI_PRODUCT_NAME => $data['product_name_list'][$i],
				TGRI_GOODS_RECEIPT_SLIP_ID => $data['purchase_id'],
				TGRI_UNIT_PRICE => $data['product_price_list'][$i],
				TGRI_GOODS_RECEIPT => $data['product_amount_list'][$i],
				TGRI_NUMBER_OF_RETURNS => $data['back_number_list'][$i],
				TGRI_CUMULATIVE_GOODS_RECEIPT => $data['accumulation_list'][$i],
				TGRI_A_DISPOSAL_DAY => str_replace('/', '-', $data['product_date_list'][$i]),
				TGRI_ACCRUAL_DATE => str_replace('/', '-', $data['product_date_list'][$i]),
				TGRI_REGISTERED_USER => $data['register_user'],
				TGRI_PROCESSING_CONTENT => $data['content_id'],
				TGRI_BASE_CODE => $data['base_code'],
				TGRI_INVENTORY_LOCATION_ID => $data['stock_id'],
			);
			if ($data['content_id'] == 5) {
				$product_list[$i][TGRI_NUMBER_HAS_EXPORT] = $data['product_amount_list'][$i];
			}

		}
		$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID, $data['purchase_id']);
		$t_info = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		if ($t_info->num_rows() > 0) {
			//$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID,$data['purchase_id']);
			//$this->db->delete(T_GOODS_RECEIPT_INFORMATION);
			//$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION,$product_list);
			$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID, $data['purchase_id']);
			$this->db->update_batch(T_GOODS_RECEIPT_INFORMATION, $product_list, TGRI_PRODUCT_ID);
		} else {
			$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION, $product_list);
		}
	}

	//xử lý nhập kho cho chuyển kho
	public function insert_info_import_purchase_2($data) {
		$data_insert = array();
		foreach ($data['list_product'] as $product) {
			for ($i = 0; $i < count($product['arr_id']); $i++) {
				$data_insert[] = array(
					TGRI_INVENTORY_LOCATION_ID => $data['stock'],
					TGRI_PROCESSING_CONTENT => $data['content_id'],
					TGRI_ACCRUAL_DATE => $product['arr_date'][$i],
					TGRI_A_DISPOSAL_DAY => $product['arr_date'][$i],
					TGRI_GOODS_RECEIPT => $product['arr_amount'][$i],
					TGRI_CUMULATIVE_GOODS_RECEIPT => $product['arr_amount'][$i],
					TGRI_PRODUCT_ID => $product['arr_id'][$i],
					TGRI_UNIT_PRICE => $product['arr_price'][$i],
					TGRI_PRODUCT_NAME => $product['arr_name'][$i],
					TGRI_BASE_CODE => $data['base_code'],
					TGRI_REGISTERED_USER => $data['register_user'],
					TGRI_GOODS_RECEIPT_SLIP_ID => $data['purchase_id'],
				);
			}
		}
		$this->db->insert_batch(T_GOODS_RECEIPT_INFORMATION, $data_insert);
	}

	//lấy thông tin sản phẩm đã nhập kho dựa vào id sản phẩm và id hóa đơn nhập kho
	public function get_info_product_has_import($purchase_id, $product_id) {
		$amount = 0;
		$back_number = null;
		$date_import = null;
		$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID, $purchase_id);
		$this->db->where(TGRI_PRODUCT_ID, $product_id);
		$product_import = $this->db->get(T_GOODS_RECEIPT_INFORMATION);
		if ($product_import->num_rows() > 0) {
			$amount += $product_import->result()[0]->{TGRI_GOODS_RECEIPT};
			$back_number = $product_import->result()[0]->{TGRI_NUMBER_OF_RETURNS};
			$date_import = $product_import->result()[0]->{TGRI_ACCRUAL_DATE};
		}
		return array(
			'amount' => $amount,
			'back_number' => $back_number,
			'date_import' => $date_import);
	}

	//lấy hóa đơn nhập kho thông qua order nhập kho
	public function get_purchase_by_order_id($order_id) {
		$this->db->where(GR_ORDER_SLIP_ID, $order_id);
		$purchase = $this->db->get(T_GOODS_RECEIPT);
		if ($purchase->num_rows() > 0) {
			return $purchase->result()[0];
		}

		return null;
	}

	public function get_max_id_warehouse_has_export() {
		$this->db->order_by(TGRI_OUTBOUND_SLIP_ID, 'DESC');
		$list_warehouse = $this->db->get(T_GOODS_RECEIPT_INFORMATION)->result();
		return $list_warehouse[0]->{TGRI_OUTBOUND_SLIP_ID};
	}

	public function checklist_order($first_date, $last_date) {

	}

	//--Export delivery note (destination)
	public function export_delivery_note_destination($order_id) {
		/*$this->db->select(T_ORDER.'.`'.TO_ID.'`'. " AS 'order_id'".','.TSD_POSTAL_CODE." AS 'postal'".','.TSD_ADDRESS_1." AS 'address'".','.TSD_DISTRIBUTOR_NAME." AS 'name'".','.TO_ORDER_DATE ." AS 'date'");
			$this->db->from(T_ORDER);
			$this->db->where(T_ORDER.'.`'.TO_ID.'`', $order_id);
			$this->db->join(T_SALES_DESTINATION,T_SALES_DESTINATION.'.`'.TSD_ID.'`='.T_ORDER.'.`'.TO_SALES_DESTINATION.'`');
			$query = $this->db->get();
		*/
		$this->db->select(T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_OUTBOUND_SLIP_ID . '`' . " AS 'order_id'" . ',' .
			SUP_SUPPLIER_COMPANY_NAME . " AS 'supplier'" . ',' .
			T_SALES_DESTINATION . '.' . TSD_ADDRESS_1 . " AS 'address'" . ',' .
			TSD_DISTRIBUTOR_NAME . " AS 'distributor_name'" . ',' .
			TGRI_ACCRUAL_DATE . " AS 'date'" . ',' .
			T_SALES_DESTINATION . '.' . TSD_POSTAL_CODE . " AS 'postal_code'" . ',' .
			TGRI_A_DISPOSAL_DAY . " AS 'delivery_date'");
		$this->db->from(T_GOODS_RECEIPT_INFORMATION);
		$this->db->where(T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_OUTBOUND_SLIP_ID . '`', $order_id);
		$this->db->join(T_SALES_DESTINATION, T_SALES_DESTINATION . '.`' . TSD_ID . '`=' . T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_SALES_DES_ID . '`');
		$this->db->join(T_SUPPLIER, T_SUPPLIER . '.`' . SUP_ID . '`=' . T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_ID_SUPPLIER . '`');
		$query = $this->db->get();
		return $query->result();
		//var_dump($query);

	}

	public function get_array_import_product($base_id)
	{
		$query = "select `".TGRI_PRODUCT_ID."` from ".T_GOODS_RECEIPT_INFORMATION
				." where `".TGRI_GOODS_RECEIPT_SLIP_ID."` > 0 "
				." and `".TGRI_GOODS_RECEIPT_SLIP_ID."` is not null "
				." and `".TGRI_BASE_CODE."` = ".$base_id;
		$result = $this->db->query($query)->result();
		return $result;
	}

	//--Export delivery note (product)
	public function export_delivery_note_product($order_id) {
		$this->db->select(PL_PRODUCT_NAME_BUY . " AS 'name'" . ',' . PL_COLOR_TONE . " AS 'color'" . ',' . PL_STANDARD . " AS 'standard'" . ',' . TGRI_NUMBER_OF_GOODS_ISSUED . " AS 'amount'" . ',' . TGRI_UNIT_PRICE . " AS 'price'");
		$this->db->from(T_GOODS_RECEIPT_INFORMATION);
		//$this->db->where(TGRI_ORDER_SLIP_ID,$order_id);
		$this->db->where(T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_OUTBOUND_SLIP_ID . '`', $order_id);
		$this->db->join(PRODUCT_LEDGER, T_GOODS_RECEIPT_INFORMATION . '.`' . TGRI_PRODUCT_ID . '`=' . PRODUCT_LEDGER . '.`' . PL_PRODUCT_ID . '`');
		$query = $this->db->get();
		return $query->result();

	}
	//__Function is used for export purchase order csv
	/*public function get_order_information(){
			$this->db->select(T_ORDER.'.'.TO_ID.','.
							  TO_ORDER_DETAIL.','.
	                          TO_VENDOR_ID.','.
	                          TO_EMPLOYEE_ID.','.
	                          TO_ORDER_DATE.','.
	                          TO_INVENTORY_LOCATION_ID.','.
	                          TO_BASE_CODE.','.
	                          TO_FORM.','.
	                          TO_RECEIPT.','.
	                          TO_AUTHORIZER.','.
	                          TO_DISCOUNT.','.
	                          TO_STREET_ADDRESS.','.
	                          TO_DELIVERY_DATE.','.
	                          TO_REMARKS.','.
	                          TO_SALES_DESTINATION.','.
	                          SUP_SUPPLIER_COMPANY_NAME
							);
			$this->db->from(T_ORDER);
			$this->db->join(T_SUPPLIER,T_SUPPLIER.'.`'.SUP_ID.'`='.T_ORDER.'.`'.TO_VENDOR_ID.'`','left');
			$query = $this->db->get();
			return $query->result_array();
*/
	public function get_order_information($data) {
		/*--------------Get some fields-------------*/
		$this->db->select(T_ORDER . '.' . TO_ID . ',' .
			TO_ORDER_DETAIL . ',' .
			TO_VENDOR_ID . ',' .
			TO_EMPLOYEE_ID . ',' .
			TO_ORDER_DATE . ',' .
			TO_INVENTORY_LOCATION_ID . ',' .
			TO_BASE_CODE . ',' .
			TO_FORM . ',' .
			TO_RECEIPT . ',' .
			TO_AUTHORIZER . ',' .
			TO_DISCOUNT . ',' .
			TO_STREET_ADDRESS . ',' .
			TO_DELIVERY_DATE . ',' .
			TO_REMARKS . ',' .
			TO_SALES_DESTINATION . ',' .
			SUP_SUPPLIER_COMPANY_NAME
		);
		$this->db->from(T_ORDER);
		$this->db->join(T_SUPPLIER, T_SUPPLIER . '.`' . SUP_ID . '`=' . T_ORDER . '.`' . TO_VENDOR_ID . '`', 'left');
		/*--------------End-------------*/
		$this->db->order_by(TO_ID, 'DESC');
		if (!empty($data['order_id'])) {
			$this->db->where(T_ORDER . '.' . TO_ID, $data['order_id']);
		}

		if (!empty($data['supplier_id'])) {
			$this->db->where(TO_VENDOR_ID, $data['supplier_id']);
		}

		if (!empty($data['content_id'])) {
			$this->db->where(TO_ORDER_DETAIL, $data['content_id']);
		}

		if (!empty($data['user_id'])) {
			$this->db->group_start();
			$this->db->where(TO_REGISTERED_USER, $data['user_id']);
			$this->db->or_where(TO_EMPLOYEE_ID, $data['user_id']);
			$this->db->group_end();
		}
		if (!empty($data['base_id'])) {
			$this->db->where(TO_BASE_CODE, $data['base_id']);
		}

		if (!empty($data['order_date_start'])) {
			$this->db->where(TO_ORDER_DATE . '>=', str_replace('/', '-', $data['order_date_start']));
		}

		if (!empty($data['order_date_end'])) {
			$this->db->where(TO_ORDER_DATE . '<=', str_replace('/', '-', $data['order_date_end']));
		}

		if (!empty($data['sales_des_id'])) {
			$this->db->where(TO_SALES_DESTINATION, $data['sales_des_id']);
		}

		if (!empty($data['status'])) {
			$this->db->where(TO_FORM, $data['status'] - 1);
		}

		if (!empty($data['is_import'])) {
			$this->db->where(TO_RECEIPT, $data['is_import'] - 1);
		}

		//$this->db->limit(10,$data['page']*10);
		$list_order = $this->db->get();
		return $list_order->result_array();
	}
	//__Function is used for export warehouse order csv
	public function get_warehouse_information() {
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
		$query = $this->db->get();
		return $query->result_array();
	}

	public function pdf_checklist($data) {
		$this->db->select(T_ORDER . "." . TO_ID . " AS id," . TO_ORDER_DATE . " AS date," . T_PROCESSING_CONTENT . "." . PC_PROCESSING_CONTENT . " AS processing_content," . T_ORDER . "." . TO_REGISTERED_USER . " AS user," . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_PRODUCT_ID . " AS product_id," . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_PRODUCT_NAME . " AS product_name," . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_REMARKS . " note," . TGRI_UNIT_PRICE . " AS price,SUM(" . TGRI_NUMBER_OF_GOODS_ISSUED . ") AS quantity," . PRODUCT_LEDGER . "." . PL_REMARKS . " AS product_note,(CASE WHEN " . TGRI_ORDER_SLIP_ID . " IS NOT NULL THEN 1 WHEN " . TGRI_GOODS_RECEIPT_SLIP_ID . " IS NOT NULL THEN 2 WHEN " . TGRI_OUTBOUND_SLIP_ID . " IS NOT NULL THEN 3 ELSE 0 END) AS type,(CASE WHEN " . TGRI_ORDER_SLIP_ID . " IS NOT NULL OR " . TGRI_GOODS_RECEIPT_SLIP_ID . " IS NOT NULL THEN " . T_ORDER . "." . TO_VENDOR_ID . " ELSE " . T_ORDER . "." . TO_SALES_DESTINATION . " END) AS location");
		$this->db->join(T_GOODS_RECEIPT_INFORMATION, "(`" . T_GOODS_RECEIPT_INFORMATION . "`.`" . TGRI_ORDER_SLIP_ID . "`=" . T_ORDER . "." . TO_ID . " OR `" . T_GOODS_RECEIPT_INFORMATION . "`.`" . TGRI_GOODS_RECEIPT_SLIP_ID . "`=" . T_ORDER . "." . TO_ID . " OR `" . T_GOODS_RECEIPT_INFORMATION . "`.`" . TGRI_OUTBOUND_SLIP_ID . "`=" . T_ORDER . "." . TO_ID . ")");
		$this->db->join(PRODUCT_LEDGER, "`" . PRODUCT_LEDGER . "`.`" . PL_PRODUCT_ID . "`=" . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_PRODUCT_ID, "left outer");
		$this->db->join(T_PROCESSING_CONTENT, "`" . T_PROCESSING_CONTENT . "`.`" . PC_ID . "`=" . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_PROCESSING_CONTENT, "left outer");

		$this->db->group_by(T_ORDER . "." . TO_ID . "," . TO_ORDER_DATE . "," . T_PROCESSING_CONTENT . "." . PC_PROCESSING_CONTENT . "," . T_ORDER . "." . TO_REGISTERED_USER . "," . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_PRODUCT_ID . "," . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_PRODUCT_NAME . "," . T_GOODS_RECEIPT_INFORMATION . "." . TGRI_REMARKS . "," . TGRI_UNIT_PRICE . "," . PRODUCT_LEDGER . "." . PL_REMARKS . ",(CASE WHEN " . TGRI_ORDER_SLIP_ID . " IS NOT NULL THEN 1 WHEN " . TGRI_GOODS_RECEIPT_SLIP_ID . " IS NOT NULL THEN 2 WHEN " . TGRI_OUTBOUND_SLIP_ID . " IS NOT NULL THEN 3 ELSE 0 END),(CASE WHEN " . TGRI_ORDER_SLIP_ID . " IS NOT NULL OR " . TGRI_GOODS_RECEIPT_SLIP_ID . " IS NOT NULL THEN " . T_ORDER . "." . TO_VENDOR_ID . " ELSE " . T_ORDER . "." . TO_SALES_DESTINATION . " END)");
		if ($data['order_date_start'] != NULL && $data['order_date_start'] != "") {
			$this->db->where(array(TO_ORDER_DATE . " >=" => $data['order_date_start']));
		} else {
			$this->db->where(array(TO_ORDER_DATE . " >=" => '2018/01/01'));
		}
		if ($data['order_date_end'] != NULL && $data['order_date_end'] != "") {
			$this->db->where(array(TO_ORDER_DATE . " <=" => $data['order_date_end']));
		}
		if ($data['order_id'] != NULL && $data['order_id'] != "") {
			$this->db->where(array(T_ORDER . "." . TO_ID => $data['order_id']));
		}
		if ($data['supplier_id'] != NULL && $data['supplier_id'] != "") {
			$this->db->where(array(T_ORDER . "." . TO_VENDOR_ID => $data['supplier_id']));
		}
		if ($data['content_id'] != NULL && $data['content_id'] != "") {
			$this->db->where(array(T_ORDER . "." . TO_ORDER_DETAIL => $data['content_id']));
		}
		if ($data['user_id'] != NULL && $data['user_id'] != "") {
			$this->db->where("(" . T_ORDER . "." . TO_REGISTERED_USER . "=" . $data['user_id'] . " OR " . T_ORDER . "." . TO_EMPLOYEE_ID . "=" . $data['user_id'] . ")");
		}
		if ($data['base_id'] != NULL && $data['base_id'] != "") {
			$this->db->where(array(T_ORDER . "." . TO_BASE_CODE => $data['base_id']));
		}
		if ($data['sales_des_id'] != NULL && $data['sales_des_id'] != "") {
			$this->db->where(array(T_ORDER . "." . TO_SALES_DESTINATION => $data['sales_des_id']));
		}
		if ($data['status'] != NULL && $data['status'] != "") {
			$this->db->where(array(T_ORDER . "." . TO_FORM => $data['status']));
		}
		if ($data['is_import'] != NULL && $data['is_import'] != "") {
			$this->db->where(array(T_ORDER . "." . TO_RECEIPT => $data['is_import']));
		}

		return $this->db->get(T_ORDER)->result_array();

	}
	public function get_content($order_id) {
		$this->db->select(SHIP_SHIPMENT_CONTENTS . " AS 'id'");
		$this->db->from(T_ISSUE);
		$this->db->where(T_ISSUE . '.`' . SHIP_ID . '`', $order_id);
		$query = $this->db->get();
		return $query->result();
	}

	//lấy những xuất kho chưa hết
	public function get_product_has_in_stock($stock_id)
	{
		$query = "select `".TGRI_PRODUCT_ID."` from `".T_GOODS_RECEIPT_INFORMATION."` "
				." where `".TGRI_BASE_CODE."` = ".$stock_id." "
				." and `".TGRI_GOODS_RECEIPT_SLIP_ID."` > 0 "
				." and `".TGRI_CUMULATIVE_GOODS_RECEIPT."` > `".TGRI_NUMBER_HAS_EXPORT."` ";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function get_total_stock_product($product_id,$stock_id)
	{
		$query = "select sum(`".TGRI_CUMULATIVE_GOODS_RECEIPT."` - `".TGRI_NUMBER_HAS_EXPORT."`) as amount "
				." from `".T_GOODS_RECEIPT_INFORMATION."` "
				." where `".TGRI_PRODUCT_ID."` = '".$product_id."' "
				." and `".TGRI_BASE_CODE."` = '".$stock_id."' "
				." and `".TGRI_GOODS_RECEIPT_SLIP_ID."` > 0 "
				." and `".TGRI_CUMULATIVE_GOODS_RECEIPT."` > `".TGRI_NUMBER_HAS_EXPORT."` ";
		$amount = $this->db->query($query)->result()[0]->amount;
		return $amount;
	}

	public function get_info_stock($stock_id)
	{
		$product_id_list = array();
		$amount_list = array();
		$query = "select `".TGRI_PRODUCT_ID."` as product_id,(`".TGRI_CUMULATIVE_GOODS_RECEIPT."` - `".TGRI_NUMBER_HAS_EXPORT."`) as amount "
				." from `".T_GOODS_RECEIPT_INFORMATION."` "
				." where `".TGRI_BASE_CODE."` = ".$stock_id." "
				." and `".TGRI_GOODS_RECEIPT_SLIP_ID."` > 0 "
				." and `".TGRI_CUMULATIVE_GOODS_RECEIPT."` > `".TGRI_NUMBER_HAS_EXPORT."` ";
		$product_list = $this->db->query($query)->result();
		foreach ($product_list as $product) {
			$product_id_list[] = $product->product_id;
			$amount_list[] = $product->amount;
		}
		return array(
			'product_id_list' => $product_id_list,
			'amount_list' => $amount_list
		);
	}

}