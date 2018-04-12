<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SaleController extends VV_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function direct_url() {
		header("Location: " . base_url());
	}

	/*public function import_cus_department()
	{
		$file = fopen(base_url("asset/csv_cus_department.csv"), "r");
		$data = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
			$data[] = array(
				CUS_DE_ID => $csv_data[0],
				CD_CUSTOMER_ID => $csv_data[1],
				CD_DEPARTMENT_CODE => $csv_data[2]
			);
		}
		$this->db->insert_batch(CUSTOMER_DEPARTMENT,$data);
	}

	public function import_inv_detail()
	{
		$file = fopen(base_url("asset/inv_detail.csv"), "r");
		$data = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
			$data[] = array(
				IGD_ID_DEPARTMENT_CUSTOMER => $csv_data[0],
				IGD_ID_INVOICE_GROUP => $csv_data[1]
			);
		}
		$this->db->insert_batch(INVOICE_GROUP_DETAIL,$data);
	}

	public function import_invoice_group()
	{
		$file = fopen(base_url("asset/invoice-group.csv"), "r");
		$data = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
				$data[] = array(
					IG_ID => $csv_data[8],
					IG_INVOICE_NAME => $csv_data[7],
					IG_DISPLAY_NAME => $csv_data[7],
					IG_STREET_ADDRESS => $csv_data[1],
					IG_STREET_ADDRESS_2 => $csv_data[2],
					IG_DISCOUNT => $csv_data[11],
					IG_ENVIRONMENTAL_LOAD => $csv_data[9],
					IG_ENVIRONMENTAL_CHECK => $csv_data[14],
					IG_TAX => $csv_data[10],
					IG_TAX_CHECK => $csv_data[12],
					IG_POST_OFFICE => $csv_data[0],
					IG_TELEPHONE => $csv_data[3],
					IG_FAX => $csv_data[4],
					IG_CLOSING_DATE => $csv_data[13],
					IG_AGGREGATE => $csv_data[16],
					IG_COLLECTIVE_OUTPUT => $csv_data[15],
					TG_USER_ID => "admin"
				);
		}
		$this->db->insert_batch(INVOICE_GROUP,$data);
	}*/

	//update người phụ trách nhóm invoice
	/*public function update_person_charge()
	{
		$file = fopen(base_url("asset/user_phu_trach_invoice.csv"), "r");
		$data = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
			$data[] = array(
				IG_ID => $csv_data[1],
				TG_USER_ID => $csv_data[0]
			);
		}
		$this->db->update_batch(INVOICE_GROUP,$data,IG_ID);
	}*/

	//update người phụ trách cus_de
	public function update_person_charge_cus_dep()
	{
		$file = fopen(base_url("asset/user_charge_cus_department.csv"), "r");
		$data = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
			$data[] = array(
				CUS_DE_ID => $csv_data[0],
				CD_USER_ID => $csv_data[1]
			);
		}
		$this->db->update_batch(CUSTOMER_DEPARTMENT,$data,CUS_DE_ID);
	}

	public function index() {
		$this->load->model('User');
		$this->load->model('Sale');
		$this->load->model('Customer');
		$this->load->model('Department');
		$this->load->model('Delivery_Detail');
		$this->load->model('Order_Detail');
		$data['title'] = '売上管理';
		$data['content'] = 'sales/index';

		$list_order = $this->Sale->get_order_group_by_customer_invoice_group();

		foreach ($list_order as $order) {
			$order->id = $order->{SL_ID};
			$order->inv_group = $order->{IGD_ID_INVOICE_GROUP};
			$order->amount_order = $this->Order_Detail->get_amount_product_in_order($order->{SL_ID});
			$order->amount_ship = $this->Delivery_Detail->get_amount_product($order->{SL_ID});
			$date_ship = date_create($order->{SL_REVENUE_DATE});
			$order->ship_date = date_format($date_ship, "Y-m-d");
		}

		$data['user_list'] = $this->User->get_all();
		$data['customer_list'] = $this->Customer->get_all();
		$data['department_list'] = $this->Department->get_all();
		$data['list_order'] = $list_order;
		$data['json_list_order'] = json_encode($list_order);
		$this->load->view('templates/master', $data);
	}

	public function add_sale() {
		$this->load->model('Invoice');
		$this->load->model('Customer');
		$this->load->model('Sale');
		$this->load->model('Delivery_Detail');
		$this->load->model('Department');
		$this->load->model('Invoice_Group_Detail');
		$this->load->model('Invoice_Group');
		$this->load->model('User');
		$data['title'] = '請求書作成画面';
		$data['content'] = 'sales/add_sales';
		$max_id = $this->Invoice->get_max_id();
		if (empty($_POST['cus_and_inv'])) {
			header("Location: " . base_url('sale/add-sale-2'));
		}
		$cus_inv = $_POST['cus_and_inv'];

		$customer_id = (int) substr($cus_inv, 3, strpos($cus_inv, 'inv') - 3);
		$customer_name = $this->Customer->get_by_id($customer_id)->{CUS_CUSTOMER_NAME};
		$order_id_list = $_POST[$cus_inv];
		$order_list = null; //danh sách order
		$tax = 0;
		$environment_tax = 0;
		$discount = 0;
		$list_department = '';
		$sum_price_cate1 = 0;
		$sum_price_cate2 = 0;
		$list_department_id = array();

		$user = $this->User->get_by_id($_SESSION['login-info'][U_ID]);
		$check_gaichyu = $user->{BM_MASTER_CHECK};
		$discount_gaichyu = $this->Invoice->get_discount_gaichyu($customer_id, $user->{U_BASE_CODE}, $user->{U_ID});

		$inv_group_id = (int) substr($cus_inv, strpos($cus_inv, 'inv') + 3, strlen($cus_inv) - 1);
		$inv_group = $this->Invoice_Group->get_by_id($inv_group_id);

		if ($inv_group->{IG_TAX_CHECK} == 1) {
			$tax = $inv_group->{IG_TAX};
		}

		if ($inv_group->{IG_ENVIRONMENTAL_CHECK} == 1) {
			$environment_tax = $inv_group->{IG_ENVIRONMENTAL_LOAD};
		} else {
			$discount = $inv_group->{IG_DISCOUNT} * (-1);
		}

		for ($i = 0; $i < count($order_id_list); $i++) {
			$order_list[$i] = new stdClass();
			$order_list[$i]->id = $order_id_list[$i];
			$order_list[$i]->product_list_cate1 = $this->Delivery_Detail->get_product_by_category($order_id_list[$i], 1); //ds sản phẩm khăn
			$order_list[$i]->product_list_cate2 = $this->Delivery_Detail->get_product_by_category($order_id_list[$i], 2); //ds sản phẩm giặc
			$sale = $this->Sale->get_by_id($order_id_list[$i]); //lấy hóa đơn doanh thu
			$department_id = $sale->{SL_DEPARTMENT_CODE};
			$order_list[$i]->department_id = $department_id;
			$department = $this->Department->get_by_id($department_id);
			if (!empty($department)) {
				$order_list[$i]->department = $department->{DL_DEPARTMENT_NAME};
			}
//tên phòng bang
			else {
				$order_list[$i]->department = null;
			}

			$order_list[$i]->sum_price_cate1 = $this->sum_price($order_list[$i]->product_list_cate1, $check_gaichyu); //cộng tiền các mặt hàng khăn trong hóa đơn
			$order_list[$i]->sum_price_cate2 = $this->sum_price($order_list[$i]->product_list_cate2, $check_gaichyu); //cộng tiền các mặt hành giặc trong hóa đơn
			if ($check_gaichyu == 1) {
				if ($discount_gaichyu->department != $department_id) {
					$sum_price_cate1 += $order_list[$i]->sum_price_cate1; //tổng tiền mặt hàng khăn
					$sum_price_cate2 += $order_list[$i]->sum_price_cate2; //tổng tiền mặt hàng giặc
				}
			} else {
				$sum_price_cate1 += $order_list[$i]->sum_price_cate1; //tổng tiền mặt hàng khăn
				$sum_price_cate2 += $order_list[$i]->sum_price_cate2; //tổng tiền mặt hàng giặc
			}
			if ($i == 0) {
				$list_department .= $order_list[$i]->department;
			} else {
				$list_department .= ', ' . $order_list[$i]->department;
			}
			$list_department_id[] = $department_id;
		}
		$data['id'] = $max_id;
		$data['customer_name'] = $customer_name;
		$data['customer_id'] = $customer_id;
		$data['list_department'] = $list_department;
		$data['sum_price_cate1'] = $sum_price_cate1;
		$data['sum_price_cate2'] = $sum_price_cate2;
		$data['date_ship'] = $this->Sale->get_space_time_ship($order_id_list);
		$data['order_list'] = $order_list;
		$data['tax'] = $tax; //tổng thuế tiêu thụ
		$data['environment_tax'] = $environment_tax;
		$data['discount'] = $discount;
		$data['inv_group'] = $inv_group;
		$data['discount_gaichyu'] = $discount_gaichyu;
		if ($check_gaichyu == 1) {
			$data['content'] = 'sales/add_sales_gaichyu';
		}
		$this->load->view('templates/master', $data);
	}

	public function add_sale_2() {
		$this->load->model('Invoice');
		$this->load->model('Invoice_Group');
		$this->load->model('User');
		$this->load->model('Product');
		$data['title'] = '売上管理システム';
		$data['content'] = 'sales/add_sale_2';
		$data['invoice_id'] = $this->Invoice->get_max_id();
		$data['base_master'] = $this->User->get_base_master($_SESSION['login-info'][U_ID]);
		//set cứng id của nhóm invoice, khách hàng, phòng bang của khách vãng lai đều là 1000
		$invoice_group = $this->Invoice_Group->get_by_id(1000);
		$tax = $invoice_group->{IG_TAX};
		$product_list = $this->Product->get_all();
		foreach ($product_list as $product) {
			$product->id = $product->{PL_PRODUCT_ID};
			$product->sale_code = $product->{PL_PRODUCT_CODE_SALE};
			if(!empty($product->{BB_PRODUCT_NAME})) $product->name = $product->{BB_PRODUCT_NAME};
			else $product->name = $product->{PL_PRODUCT_NAME};
			$product->standard = $product->{PL_STANDARD};
			$product->color = $product->{PL_COLOR_TONE};
			$product->price = $product->{BB_UNIT_SELLING_PRICE};
			$product->special = $product->{PL_SPECIAL};
		}
		$data['product_list'] = $product_list;
		$data['tax'] = $tax;
		$this->load->view('templates/master', $data);
	}

	public function ajax_create_list() {
		$this->db->trans_begin();

		$this->load->model("Invoice_Group");
		$this->load->model("Invoice");
		$this->load->model("Invoice_Detail");
		$this->load->model('Delivery_Detail');
		$this->load->model('Sale');
		$this->load->model('User');

		$user = $this->User->get_by_id($_SESSION['login-info'][U_ID]);
		$check_gaichyu = $user->{BM_MASTER_CHECK};

		$json_list_order = $_POST['json_list_order'];
		$order_id_list = '';
		$inv_data = array();
		$inv_detail_data = array();
		$i = 0;
		foreach ($json_list_order as $id => $order) {
			$environment_tax = 0;
			$discount = 0;
			$tax = 0;
			$inv_group = $this->Invoice_Group->get_by_id($order['inv_group']);
			if ($inv_group->{IG_ENVIRONMENTAL_CHECK} == 1) {
				$environment_tax = $inv_group->{IG_ENVIRONMENTAL_LOAD};
			} elseif ($inv_group->{IG_DISCOUNT} > 0) {
				$discount = (int) $inv_group->{IG_DISCOUNT} * (-1);
			}

			if ($inv_group->{IG_TAX_CHECK} == 1) {
				$tax = (int) $inv_group->{IG_TAX};
			}

			$product_list_cate1 = $this->Delivery_Detail->get_product_by_category($order['id'], 1);
			$product_list_cate2 = $this->Delivery_Detail->get_product_by_category($order['id'], 2);
			$price_cate1 = $this->sum_price($product_list_cate1, $check_gaichyu);
			$price_cate2 = $this->sum_price($product_list_cate2, $check_gaichyu);
			$price = $price_cate1 + $price_cate1 * $environment_tax / 100 + $price_cate1 * $discount / 100 + $price_cate2;
			$total_price = $price + $price * $tax / 100;
			if ($id == 0) {
				$order_id_list .= $order['id'];
				$inv_data[$i] = array(
					I_CUSTOMER_ID => $order['customer_id'],
					I_DATE_CREATE => date('Y-m-d'),
					I_USER_ID => $_SESSION['login-info'][U_ID],
					I_TOTAL_PRICE => $total_price,
					I_INVOICE_GROUP_ID => $order['inv_group'],
				);
				$inv_detail_data[$i] = array();
				$inv_detail_data[$i][] = array(
					ID_ORDER_ID => $order['id'],
				);
			} else {
				$order_id_list .= '|' . $order['id'];
				if ($json_list_order[$id]['customer_id'] != $json_list_order[$id - 1]['customer_id'] | $json_list_order[$id]['inv_group'] != $json_list_order[$id - 1]['inv_group']) {
					$i++;
					$inv_data[$i] = array(
						I_CUSTOMER_ID => $order['customer_id'],
						I_DATE_CREATE => date('Y-m-d'),
						I_USER_ID => $_SESSION['login-info'][U_ID],
						I_TOTAL_PRICE => $total_price,
						I_INVOICE_GROUP_ID => $order['inv_group'],
					);
					$inv_detail_data[$i] = array();
					$inv_detail_data[$i][] = array(
						ID_ORDER_ID => $order['id'],
					);
				} else {
					$inv_data[$i][I_TOTAL_PRICE] += $total_price;
					$inv_detail_data[$i][] = array(
						ID_ORDER_ID => $order['id'],
					);
				}
			}
		}
		$invoice_id_arr = $this->Invoice->add_list_invoice($inv_data);
		foreach ($invoice_id_arr as $id => $invoice_id) {
			foreach ($inv_detail_data[$id] as &$inv_detail) {
				$inv_detail[ID_INVOICE_ID] = $invoice_id;
			}
		}
		$this->Invoice_Detail->add_list_detail($inv_detail_data);
		if ($check_gaichyu == 0) {
			$this->Sale->update_status_create_invoice($order_id_list, 1);
		} else {
			$this->Sale->update_status_create_invoice_gaichyu($order_id_list, 1);
		}

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
			$this->db->trans_rollback();
		} else {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
			$this->db->trans_commit();
		}
	}

	public function ajax_get_list_department_by_customer() {
		$this->load->model('Department');
		$customer_id = $_POST['customer_id'];
		$list_department = array();
		$all_department = $this->Department->getDepartmentByCustomer($customer_id);
		for ($i = 0; $i < count($all_department); $i++) {
			$list_department[$i] = new stdClass;
			$list_department[$i]->department_id = $all_department[$i][DL_DEPARTMENT_CODE];
			$list_department[$i]->department_name = $all_department[$i][DL_DEPARTMENT_NAME];
		}
		echo json_encode($list_department);
	}

	//ajax lấy danh sách sản phẩm theo mã khách hàng và mã cứ điểm
	public function ajax_get_list_product() {
		$this->load->model('Product_Base');
		$data['base_id'] = $_POST['base_id'];
		$data['customer_id'] = $_POST['customer_id'];
		$list_product = null;
		$all_product = $this->Product_Base->get_by_base_and_customer($data);
		for ($i = 0; $i < count($all_product); $i++) {
			$list_product[$i] = new stdClass;
			$list_product[$i]->product_id = $all_product[$i]->{BB_PRODUCT_CODE};
			$list_product[$i]->product_name = $all_product[$i]->{PL_PRODUCT_NAME};
			$list_product[$i]->standard = $all_product[$i]->{PL_STANDARD};
			$list_product[$i]->color = $all_product[$i]->{PL_COLOR_TONE};
			$list_product[$i]->sell_price = $all_product[$i]->{BB_UNIT_SELLING_PRICE};
		}
		echo json_encode($list_product);
	}

	//cộng tiền tất cả tiền các mặt hàng có trong hóa đơn giao hàng
	private function sum_price($delivery_detail, $check_gaichyu = 0) {
		$price = 0;
		if (count($delivery_detail) == 0) {
			return $price;
		}

		foreach ($delivery_detail as $delivery) {
			if ($check_gaichyu == 1) {
				$price += $delivery->{DD_GAICHYU_PRICE} * $delivery->{DD_QUANTITY};
			} else {
				$price += $delivery->{DD_UNIT_PRICE} * $delivery->{DD_QUANTITY};
			}

		}
		return $price;
	}

	public function ajax_save_sale() {
		$this->db->trans_begin();

		$this->load->model('Invoice');
		$this->load->model('Invoice_Detail');
		$this->load->model('Sale');
		$this->load->model('User');
		$invoice_id = $_POST['invoice_id'];
		$customer_id = $_POST['customer_id'];
		$invoice_group_id = $_POST['invoice_group_id'];
		$comment = $_POST['comment'];
		$address = $_POST['address'];
		$order_id_list = $_POST['order_id_list'];
		$discount_cate1 = $_POST['discount_cate1'];
		$discount_cate2 = $_POST['discount_cate2'];
		$total_price = $_POST['total_price'];
		$invoice[I_ID] = $invoice_id;
		$invoice[I_CUSTOMER_ID] = $customer_id;
		$invoice[I_INVOICE_GROUP_ID] = $invoice_group_id;
		$invoice[I_STREET_ADDRESS] = $address;
		$invoice[I_REMARKS] = $comment;
		$invoice[I_USER_ID] = $_SESSION['login-info'][U_ID];
		$invoice[I_TOTAL_PRICE] = $total_price;
		$this->Invoice->add_invoice($invoice);
		$invoice_detail['invoice_id'] = $invoice_id;
		$invoice_detail['order_id_list'] = $order_id_list;
		$invoice_detail['discount_cate1'] = $discount_cate1;
		$invoice_detail['discount_cate2'] = $discount_cate2;
		$this->Invoice_Detail->add_detail($invoice_detail);

		$user = $this->User->get_by_id($_SESSION['login-info'][U_ID]);
		if ($user->{BM_MASTER_CHECK} == 0) {
			$this->Sale->update_status_create_invoice($order_id_list, 1);
		} else {
			$this->Sale->update_status_create_invoice_gaichyu($order_id_list, 1);
		}

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
			$this->db->trans_rollback();
		} else {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
			$this->db->trans_commit();
		}
	}

	public function ajax_save_sale_2() {
		$this->db->trans_begin();

		$this->load->model('Invoice');
		$this->load->model('Invoice_Order_Detail');
		$this->load->model('Invoice_Group_Detail');

		$data1[I_ID] = $_POST['invoice_id'];
		$data1[I_CUSTOMER_ID] = 1000;
		$data1[I_DEPARTMENT_ID] = $_POST['department_name'];
		$data1[I_DATE_CREATE] = str_replace('/', '-', $_POST['date_create']);
		$data1[I_REMARKS] = $_POST['remark'];
		$data1[I_STREET_ADDRESS] = $_POST['address'];
		$data1[I_OTHER_CUSTOMER] = $_POST['cus_name'];
		$data1[I_HAVE_ORDER] = 0;
		$data1[I_USER_ID] = $_POST['user_id'];
		$data1[I_TOTAL_PRICE] = $_POST['total_price'];
		$data1[I_PAID_DATE_START] = str_replace('/', '-', $_POST['paid_date_start']);
		$data1[I_PAID_DATE_END] = str_replace('/', '-', $_POST['paid_date_end']);
		$data1[I_STATUS] = 1;
		$data1[I_INVOICE_GROUP_ID] = 1000;
		$this->Invoice->add_invoice($data1);
		$data2['invoice_id'] = $_POST['invoice_id'];
		$data2['product_id_list'] = $_POST['list_product_id'];
		$data2['product_name_list'] = $_POST['list_product_name'];
		$data2['amount_list'] = $_POST['list_amount'];
		$data2['price_list'] = $_POST['list_sell_price'];
		$data2['sum_price_list'] = $_POST['list_price'];
		$this->Invoice_Order_Detail->add_product($data2);

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
			$this->db->trans_rollback();
		} else {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
			$this->db->trans_commit();
		}
	}

	public function ajax_search_order() {
		$this->load->model('Sale');
		$this->load->model('Customer');
		$this->load->model('Delivery_Detail');
		$this->load->model('Order_Detail');
		$data = array();
		if (!empty($_POST['order_no'])) {
			$data['order_no'] = $_POST['order_no'];
		}

		if (!empty($_POST['user_id'])) {
			$data['user_id'] = $_POST['user_id'];
		}

		if (!empty($_POST['customer_id'])) {
			$data['customer_id'] = $_POST['customer_id'];
		}

		if (!empty($_POST['department_id'])) {
			$data['department_id'] = $_POST['department_id'];
		}

		if (!empty($_POST['ship_date_start'])) {
			$data['ship_date_start'] = str_replace('/', '-', $_POST['ship_date_start']);
		}

		if (!empty($_POST['ship_date_end'])) {
			$data['ship_date_end'] = str_replace('/', '-', $_POST['ship_date_end']);
		}

		if (!empty($_POST['order_date_start'])) {
			$data['order_date_start'] = str_replace('/', '-', $_POST['order_date_start']);
		}

		if (!empty($_POST['order_date_end'])) {
			$data['order_date_end'] = str_replace('/', '-', $_POST['order_date_end']);
		}

		$list_order = $this->Sale->get_order_group_by_customer_invoice_group($data);
		foreach ($list_order as $order) {
			$order->customer_name = $order->{CUS_CUSTOMER_NAME};
			$order->id = $order->{SL_ID};
			$order->department = $order->{DL_DEPARTMENT_NAME};
			$order->user = $order->{SL_USER_ID};
			$order->amount_order = $this->Order_Detail->get_amount_product_in_order($order->{SL_ID});
			$ship_date = date_create($order->{SL_REVENUE_DATE});
			$order->ship_date = date_format($ship_date, "Y-m-d");
			$order->amount_ship = $this->Delivery_Detail->get_amount_product($order->{SL_ID});
			$order->inv_group = $order->{IGD_ID_INVOICE_GROUP};
		}
		echo json_encode($list_order);
	}

	public function ajax_list_order_CSV() {
		$this->load->model('ImportExportCsv');
		$this->load->model('Customer');
		$this->load->model('Sale');
		$this->load->model('Department');
		$this->load->model('User');
		$list_order = json_decode($_POST['json_list_order']);
		//tên kh,mã kh,số order,tên phòng bang, mã phòng bang, người đặt order, số order, ngày giao hàng, số giao hàng
		$col_title = array("お得意先", "得意先コード", "注文No", "部署名", "部署コード", "起票者", "注文数", "売上確定日", "納品数");
		$col_value = array('customer_name', 'customer_id', 'id', 'department_name', 'department_id', 'user', 'amount_order', 'ship_date', 'amount_ship');
		foreach ($list_order as &$order) {
			$order = (array) $order;
			$order['customer_name'] = $this->Customer->get_by_id($order['customer_id'])->{CUS_CUSTOMER_NAME};
			$row_order = $this->Sale->get_by_id($order['id']);
			$order['department_id'] = $row_order->{SL_DEPARTMENT_CODE};
			$order['department_name'] = $this->Department->get_by_id($order['department_id'])->{DL_DEPARTMENT_NAME};
			$order['user'] = $row_order->{SL_USER_ID};
		}
		$this->ImportExportCsv->export('CSV order', $col_title, $col_value, $list_order);

	}

	public function view_sale() {
		$data['title'] = '作成済請求書 詳細閲覧画面';
		$data['content'] = 'sales/view_sales';
		$this->load->view('templates/master', $data);
	}

	//đang làm
	public function edit_sale() {
		$invoice_id = $_GET['inv_id'];
		$this->load->model('Invoice');
		$this->load->model('Customer');
		$this->load->model('Sale');
		$this->load->model('Delivery_Detail');
		$this->load->model('Department');
		$this->load->model('Invoice_Group_Detail');
		$this->load->model('Invoice_Order_Detail');
		$this->load->model('Invoice_Detail');
		$this->load->model('Invoice_Group');
		$this->load->model('User');
		$data['title'] = '請求書　編集画面';
		$data['content'] = 'sales/edit_sales';
		if(!is_numeric($invoice_id)) redirect('/sale/created_sale');
		$invoice = $this->Invoice->get_by_id($invoice_id);
		if (empty($invoice)) {
			redirect('/sale/created_sale');
		}

		$invoice_group = $this->Invoice_Group->get_by_id($invoice->{I_INVOICE_GROUP_ID});
		if ($_SESSION['request-level'] == 'P') {
			if ($invoice->{I_USER_ID} != $_SESSION['login-info'][U_ID]) {
				redirect('/access-denied');
			}

		}
		if ($invoice->{I_HAVE_ORDER} == 1) {
			$customer_name = $this->Customer->get_by_id($invoice->{I_CUSTOMER_ID})->{CUS_CUSTOMER_NAME};

			$user = $this->User->get_by_id($invoice->{I_USER_ID});
			$check_gaichyu = $user->{BM_MASTER_CHECK};
			$discount_gaichyu = $this->Invoice->get_discount_gaichyu($invoice->{I_CUSTOMER_ID}, $user->{U_BASE_CODE}, $user->{U_ID});

			$tax = 0;
			$environment_tax = 0;
			$discount = 0;
			if ($invoice_group->{IG_TAX_CHECK} == 1) {
				$tax = $invoice_group->{IG_TAX};
			}

			if ($invoice_group->{IG_ENVIRONMENTAL_CHECK} == 1) {
				$environment_tax = $invoice_group->{IG_ENVIRONMENTAL_LOAD};
			} else {
				$discount = $invoice_group->{IG_DISCOUNT};
			}

			$list_order = array();
			$department_list = '';
			$date_ship = null;
			$sum_price_cate1 = 0;
			$sum_price_cate2 = 0;
			$order_id_arr = array();
			$list_order = $this->Invoice_Detail->get_list_order($invoice_id);
			$i = 0;
			foreach ($list_order as $order) {
				$order_id_arr[] = $order->{ID_ORDER_ID};
				if ($i = 0) {
					$department_list .= $order->{DL_DEPARTMENT_NAME};
				} else {
					$department_list .= "," . $order->{DL_DEPARTMENT_NAME};
				}

				$order->product_list_cate1 = $this->Delivery_Detail->get_product_by_category($order->{ID_ORDER_ID}, 1); //ds sản phẩm khăn
				$order->product_list_cate2 = $this->Delivery_Detail->get_product_by_category($order->{ID_ORDER_ID}, 2);
				$order->sum_price_cate1 = $this->sum_price($order->product_list_cate1, $check_gaichyu) - $this->sum_price($order->product_list_cate1, $check_gaichyu) * $order->{ID_DISCOUNT_SUPPLIER} / 100;
				$order->sum_price_cate2 = $this->sum_price($order->product_list_cate2, $check_gaichyu) - $this->sum_price($order->product_list_cate2, $check_gaichyu) * $order->{ID_DISCOUNT_ORTHER} / 100;
				// $sum_price_cate1 += $order->sum_price_cate1;
				// $sum_price_cate2 += $order->sum_price_cate2;

				if ($check_gaichyu == 1) {
					if ($discount_gaichyu->department != $order->{SL_DEPARTMENT_CODE}) {
						$sum_price_cate1 += $order->sum_price_cate1; //tổng tiền mặt hàng khăn
						$sum_price_cate2 += $order->sum_price_cate2; //tổng tiền mặt hàng giặc
					}
				} else {
					$sum_price_cate1 += $order->sum_price_cate1; //tổng tiền mặt hàng khăn
					$sum_price_cate2 += $order->sum_price_cate2; //tổng tiền mặt hàng giặc
				}

				$i++;
			}
			$date_ship = $this->Sale->get_space_time_ship($order_id_arr);
			$data['id'] = $invoice_id;
			$data['customer_name'] = $customer_name;
			$data['invoice'] = $invoice_group->{IG_INVOICE_NAME};
			$data['address'] = $invoice->{I_STREET_ADDRESS};
			$data['date_ship'] = $date_ship;
			$data['department_list'] = $department_list;
			$data['sum_price_cate1'] = $sum_price_cate1;
			$data['sum_price_cate2'] = $sum_price_cate2;
			$data['environment_tax'] = $environment_tax;
			$data['discount'] = $discount;
			$data['tax'] = $tax;
			$data['remark'] = $invoice->{I_REMARKS};
			$data['update_date'] = $invoice->{I_UPDATE_DATE};
			$data['list_order'] = $list_order;
			$data['discount_gaichyu'] = $discount_gaichyu;
			if ($check_gaichyu) {
				$data['content'] = 'sales/edit_sales_gaichyu';
			}

			$this->load->view('templates/master', $data);
		} else {
			$data['content'] = 'sales/edit_sales_no_order';
			$tax = $invoice_group->{IG_TAX};
			$address = $invoice->{I_STREET_ADDRESS};
			$customer_name = $invoice->{I_OTHER_CUSTOMER};
			$department_name = $invoice->{I_DEPARTMENT_ID};
			$paid_date['start'] = str_replace('-', '/', $invoice->{I_PAID_DATE_START});
			$paid_date['end'] = str_replace('-', '/', $invoice->{I_PAID_DATE_END});
			$product_list_cate1 = $this->Invoice_Order_Detail->get_list_product_cate($invoice_id, 1);
			$product_list_cate2 = $this->Invoice_Order_Detail->get_list_product_cate($invoice_id, 2);
			$sum_price_cate1 = self::sum_price_for_no_order($product_list_cate1);
			$sum_price_cate2 = self::sum_price_for_no_order($product_list_cate2);
			$data['id'] = $invoice_id;
			$data['invoice'] = $invoice_group->{IG_INVOICE_NAME};
			$data['tax'] = $tax;
			$data['address'] = $address;
			$date_create = date_create($invoice->{I_DATE_CREATE});
			$data['date_create'] = date_format($date_create, "Y/m/d");
			$data['remark'] = $invoice->{I_REMARKS};
			$data['customer_name'] = $customer_name;
			$data['department_name'] = $department_name;
			$data['paid_date'] = $paid_date;
			$data['update_date'] = $invoice->{I_UPDATE_DATE};
			$data['product_list_cate1'] = $product_list_cate1;
			$data['product_list_cate2'] = $product_list_cate2;
			$data['sum_price_cate1'] = $sum_price_cate1;
			$data['sum_price_cate2'] = $sum_price_cate2;
			$this->load->view('templates/master', $data);
		}
	}

	public function ajax_edit_sale() {
		$this->load->model('Invoice');
		$this->load->model('Invoice_Detail');
		$invoice_id = $_POST['invoice_id'];
		$total_price = $_POST['total_price'];
		$remark = $_POST['remark'];
		$address = $_POST['address'];
		$update_date = $_POST['update_date'];
		$discount_cate1_list = $_POST['discount_cate1_list'];
		$discount_cate2_list = $_POST['discount_cate2_list'];
		$order_id_list = $_POST['order_id_list'];

		if (!$this->Invoice->isCheckDataUpdated($invoice_id, $update_date, INVOICE)) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_has_update_before"),
			));
			die();
		}

		$this->db->trans_begin();

		$invoice_data[I_ID] = $invoice_id;
		$invoice_data[I_TOTAL_PRICE] = $total_price;
		$invoice_data[I_STREET_ADDRESS] = $address;
		$invoice_data[I_REMARKS] = $remark;
		$this->Invoice->update_invoice($invoice_data); //cập nhật dữ liệu mới cho bảng invoice
		$invoice_detail_data['invoice_id'] = $invoice_id;
		$invoice_detail_data['order_id_list'] = $order_id_list;
		$invoice_detail_data['discount_cate1_list'] = $discount_cate1_list;
		$invoice_detail_data['discount_cate2_list'] = $discount_cate2_list;
		$this->Invoice_Detail->update_invoice_detail($invoice_detail_data); //cập nhật dữ liệu mới cho bảng invoice detail
		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_edit_error"),
			));
			$this->db->trans_rollback();
		} else {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_edit_success"),
			));
			$this->db->trans_commit();
		}
	}

	public function ajax_edit_sale_no_order() {
		$this->db->trans_begin();

		$this->load->model('Invoice');
		$this->load->model('Invoice_Order_Detail');
		$invoice_id = $_POST['invoice_id'];
		$customer = $_POST['customer'];
		$department = $_POST['department'];
		$paid_date_start = $_POST['paid_date_start'];
		$paid_date_end = $_POST['paid_date_end'];
		$remark = $_POST['remark'];
		$address = $_POST['address'];
		$total_price = $_POST['total_price'];
		$update_date = $_POST['update_date'];
		$product_id_list = $_POST['product_id_list'];
		$product_amount_list = $_POST['product_amount_list'];
		$product_price_list = $_POST['product_price_list'];

		if (!$this->Invoice->isCheckDataUpdated($invoice_id, $update_date, INVOICE)) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_has_update_before"),
			));
			die();
		}

		$invoice_data[I_ID] = $invoice_id;
		$invoice_data[I_OTHER_CUSTOMER] = $customer;
		$invoice_data[I_REMARKS] = $remark;
		$invoice_data[I_STREET_ADDRESS] = $address;
		$invoice_data[I_HAVE_ORDER] = 0;
		$invoice_data[I_DEPARTMENT_ID] = $department;
		$invoice_data[I_TOTAL_PRICE] = $total_price;
		$invoice_data[I_PAID_DATE_START] = $paid_date_start;
		$invoice_data[I_PAID_DATE_END] = $paid_date_end;
		$invoice_data[I_CHECK_UPDATE] = 1;
		$this->Invoice->update_invoice($invoice_data);

		if ($product_id_list == '') {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_edit_success"),
			));
			$this->db->trans_commit();
			die();
		}

		$invoice_detail_data['invoice_id'] = $invoice_id;
		$invoice_detail_data['product_id_list'] = $product_id_list;
		$invoice_detail_data['product_amount_list'] = $product_amount_list;
		$invoice_detail_data['product_price_list'] = $product_price_list;
		$this->Invoice_Order_Detail->update_detail($invoice_detail_data);

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_edit_error"),
			));
			$this->db->trans_rollback();
		} else {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_edit_success"),
			));
			$this->db->trans_commit();
		}
	}

	//xóa invoice
	public function ajax_del_sale() {

		$this->db->trans_begin();

		$this->load->model('Sale');
		$this->load->model('Invoice_Detail');
		$this->load->model('Invoice');
		$this->load->model('Invoice_Order_Detail');
		$invoice_id = $_POST['invoice_id'];
		$invoice = $this->Invoice->get_by_id($invoice_id);
		if ($_SESSION['request-level'] == 'P') {
			if ($invoice->{I_USER_ID} != $_SESSION['login-info'][U_ID]) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error"),
				));
				return false;
			}
		}
		if ($invoice->{I_HAVE_ORDER}) {
			$order_list = $this->Invoice_Detail->get_list_order($invoice_id);
			$order_id_list = ''; //chuỗi order id ngăng cách nhau bởi dấu ','
			for ($i = 0; $i < count($order_list); $i++) {
				if ($i == 0) {
					$order_id_list .= $order_list[$i]->{ID_ORDER_ID};
				} else {
					$order_id_list .= ',' . $order_list[$i]->{ID_ORDER_ID};
				}

			}
			//$this->Sale->update_status_create_invoice($order_id_list,0);//cập nhật tình trạng đòi tiền order về 0
			$this->Invoice_Detail->del_by_invoice_id($invoice_id); //xóa d74 liệ trong bảng chi tiết giấy đòi tiền
		} else {
			$this->Invoice_Order_Detail->del_by_invoice($invoice_id);
		}
//nếu ko chỉ địn hóa đơn order
		$this->Invoice->del_by_id($invoice_id); //xóa bảng giấy đòi tiền

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_delete_error"),
			));
			$this->db->trans_rollback();
		} else {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_edit_success"),
			));
			$this->db->trans_commit();
		}
	}

	public function created_sale() {
		$this->load->model('Invoice');
		$this->load->model('Invoice_Detail');
		$this->load->model('Customer');
		$this->load->model('Department');
		$this->load->model('User');
		$data['title'] = '作成済請求書';
		$data['content'] = 'sales/created_sales';
		$invoice_list = $this->Invoice_Detail->search_invoice(array("page_num" => 0));
		foreach ($invoice_list as $invoice) {
			$invoice->id = $invoice->{I_ID};
			$invoice->customer_id = $invoice->{I_CUSTOMER_ID};
			$invoice->department = '';
			$invoice->department_id = '';
			$invoice->price = $invoice->{I_TOTAL_PRICE}; //tiền đòi
			if (!$invoice->{I_HAVE_ORDER}) {
				$invoice->department = $invoice->{I_DEPARTMENT_ID};
				$invoice->customer = $invoice->{I_OTHER_CUSTOMER};
				$invoice->department_id = 0;
			} else {
				$customer = $this->Customer->get_by_id($invoice->{I_CUSTOMER_ID});
				if (!empty($customer)) {
					$invoice->customer = $customer->{CUS_CUSTOMER_NAME};
				} else {
					$invoice->customer = null;
				}

				$invoice->detail = $this->Invoice_Detail->get_detail($invoice->{I_ID});
				$i = 0;
				foreach ($invoice->detail as $order) {
					$department = $this->Department->get_by_id($order->{SL_DEPARTMENT_CODE});
					if ($i == 0) {
						if (!empty($department)) {
							$invoice->department .= $department->{DL_DEPARTMENT_NAME};
						}

						$invoice->department_id .= $order->{SL_DEPARTMENT_CODE};
					} else {
						if (!empty($department)) {
							$invoice->department .= ',' . $department->{DL_DEPARTMENT_NAME};
						}

						$invoice->department_id .= ',' . $order->{SL_DEPARTMENT_CODE};
					}
					$i++;
				}
				$unique_department = array_unique(explode(',', $invoice->department));
				$invoice->department = '';
				$i = 0;
				foreach ($unique_department as $department) {
					if ($i == 0) {
						$invoice->department .= $department;
					} else {
						$invoice->department .= ',' . $department;
					}

					$i++;
				}
			}
			$dt = new DateTime($invoice->{I_DATE_CREATE});
			$invoice->date_created = $dt->format('Y/m/d');

		}
		$data['invoice_list'] = $invoice_list;
		$data['customer_list'] = $this->Customer->get_all();
		$data['department_list'] = $this->Department->get_all();
		$data['user_list'] = $this->User->get_all();
		$this->load->view('templates/master', $data);
	}

	//tìm giấy đòi tiền đã tạo
	public function ajax_search_created() {
		$this->load->model('Invoice_Detail');
		$this->load->model('Invoice');
		$this->load->model('Department');
		$this->load->model('Customer');
		$data = null;
		if (!empty($_POST['invoice_id'])) {
			$data['invoice_id'] = $_POST['invoice_id'];
		}

		if (!empty($_POST['order_id'])) {
			$data['order_id'] = $_POST['order_id'];
		}

		if (!empty($_POST['user_id'])) {
			$data['user_id'] = $_POST['user_id'];
		}

		if (!empty($_POST['ship_date_start'])) {
			$ship_date_start = strtotime($_POST['ship_date_start']);
			$data['ship_date_start'] = date('Y-m-d', $ship_date_start);
		}
		if (!empty($_POST['ship_date_end'])) {
			$ship_date_end = strtotime($_POST['ship_date_end']);
			$data['ship_date_end'] = date('Y-m-d', $ship_date_end);
		}
		if (isset($_POST['customer_id'])) {
			$data['customer_id'] = $_POST['customer_id'];
		}

		if (!empty($_POST['department_id'])) {
			$data['department_id'] = $_POST['department_id'];
		}

		$data['page_num'] = $_POST['page_num'];
		$invoice_list = $this->Invoice_Detail->search_invoice($data);
		foreach ($invoice_list as $invoice) {
			$invoice_detail = $this->Invoice_Detail->get_detail($invoice->{I_ID});
			$invoice->id = $invoice->{I_ID};
			$invoice->customer = '';
			$invoice->department = '';
			$invoice->price = $invoice->{I_TOTAL_PRICE}; //tiền đòi
			if (!$invoice->{I_HAVE_ORDER}) {
				$invoice->customer = $invoice->{I_OTHER_CUSTOMER};
				$invoice->department = $invoice->{I_DEPARTMENT_ID};
				$invoice->price = $invoice->{I_TOTAL_PRICE};
			} else {
				$customer = $this->Customer->get_by_id($invoice->{I_CUSTOMER_ID});
				if (!empty($customer)) {
					$invoice->customer = $customer->{CUS_CUSTOMER_NAME};
				} else {
					$invoice->customer = '';
				}

			}
			$dt = new DateTime($invoice->{I_DATE_CREATE});
			$invoice->date_created = $dt->format('Y/m/d');
			$invoice->remark = $invoice->{I_REMARKS};
			if (empty($invoice->{I_REMARKS})) {
				$invoice->remark = '';
			}

			$i = 0;
			foreach ($invoice_detail as $order) {
				$department = $this->Department->get_by_id($order->{SL_DEPARTMENT_CODE});
				if (!empty($department)) {
					if ($i == 0) {
						$invoice->department .= $department->{DL_DEPARTMENT_NAME};
					} else {
						$invoice->department .= ',' . $department->{DL_DEPARTMENT_NAME};
					}

					$i++;
				}
			}
			$unique_department = array_unique(explode(',', $invoice->department));
			$invoice->department = '';
			$i = 0;
			foreach ($unique_department as $department) {
				if ($i == 0) {
					$invoice->department .= $department;
				} else {
					$invoice->department .= ',' . $department;
				}

				$i++;
			}
			if ($invoice->customer == '') {
				$invoice->customer = ' ';
			}

			if ($invoice->department == '') {
				$invoice->department = ' ';
			}

		}
		$data = new stdClass();
		$data->data = $invoice_list;
		echo (json_encode($data));
	}

	public function ajax_export_csv_created() {
		$this->load->model('Invoice_Detail');
		$this->load->model('Invoice');
		$this->load->model('Department');
		$this->load->model('Customer');
		$this->load->model('ImportExportCsv');
		$data = null;
		if (!empty($_GET['invoice_id'])) {
			$data['invoice_id'] = $_GET['invoice_id'];
		}

		if (!empty($_GET['order_id'])) {
			$data['order_id'] = $_GET['order_id'];
		}

		if (!empty($_GET['user_id'])) {
			$data['user_id'] = $_GET['user_id'];
		}

		if (!empty($_GET['ship_date_start'])) {
			$ship_date_start = strtotime($_GET['ship_date_start']);
			$data['ship_date_start'] = date('Y-m-d', $ship_date_start);
		}
		if (!empty($_GET['ship_date_end'])) {
			$ship_date_end = strtotime($_GET['ship_date_end']);
			$data['ship_date_end'] = date('Y-m-d', $ship_date_end);
		}
		if (isset($_GET['customer_id'])) {
			$data['customer_id'] = $_GET['customer_id'];
		}

		if (!empty($_GET['department_id'])) {
			$data['department_id'] = $_GET['department_id'];
		}

		$invoice_list = $this->Invoice_Detail->search_invoice($data);
		$arr_data = array();
		foreach ($invoice_list as $i => $invoice) {
			$invoice_detail = $this->Invoice_Detail->get_detail($invoice->{I_ID});
			$arr_data[$i] = array();
			$arr_data[$i]['invoice_id'] = $invoice->{I_ID};
			$arr_data[$i]['date_create'] = $invoice->{I_DATE_CREATE};
			$arr_data[$i]['total_price'] = $invoice->{I_TOTAL_PRICE};
			$arr_data[$i]['department_name'] = '';
			$arr_data[$i]['department_id'] = '';
			if (!$invoice->{I_HAVE_ORDER}) {
				$arr_data[$i]['customer_name'] = $invoice->{I_OTHER_CUSTOMER};
				$arr_data[$i]['customer_id'] = $invoice->{I_CUSTOMER_ID};
				$arr_data[$i]['department_name'] = $invoice->{I_DEPARTMENT_ID};
				$arr_data[$i]['department_id'] = null;
			} else {
				$customer = $this->Customer->get_by_id($invoice->{I_CUSTOMER_ID});
				if (!empty($customer)) {
					$arr_data[$i]['customer_name'] = $customer->{CUS_CUSTOMER_NAME};
				} else {
					$arr_data[$i]['customer_name'] = null;
				}

				$arr_data[$i]['customer_id'] = $invoice->{I_CUSTOMER_ID};
			}
			$index = 0;
			foreach ($invoice_detail as $order) {
				$department = $this->Department->get_by_id($order->{SL_DEPARTMENT_CODE});
				if ($index == 0) {
					if (!empty($department)) {
						$arr_data[$i]['department_name'] .= $department->{DL_DEPARTMENT_NAME};
					} else {
						$arr_data[$i]['department_name'] .= '';
					}

					$arr_data[$i]['department_id'] .= $order->{SL_DEPARTMENT_CODE};
				} else {
					if (!empty($department)) {
						$arr_data[$i]['department_name'] .= '|' . $department->{DL_DEPARTMENT_NAME};
					} else {
						$arr_data[$i]['department_name'] .= '|';
					}

					$arr_data[$i]['department_id'] .= '|' . $order->{SL_DEPARTMENT_CODE};
				}
				$index++;
			}
			$unique_department = array_unique(explode('|', $arr_data[$i]['department_name']));
			$unique_department_id = array_unique(explode('|', $arr_data[$i]['department_id']));
			$arr_data[$i]['department_name'] = '';
			$arr_data[$i]['department_id'] = '';
			foreach ($unique_department as $index => $department) {
				if ($index == 0) {
					$arr_data[$i]['department_name'] .= $department;
					$arr_data[$i]['department_id'] .= $unique_department_id[$index];
				} else {
					$arr_data[$i]['department_name'] .= '|' . $department;
					$arr_data[$i]['department_id'] .= '|' . $unique_department_id[$index];
				}
			}

		}
		$col_title = array("請求書No", "作成日", "お得意先", "得意先コード", "部署名", "部署コード", "請求金額");
		$col_value = array('invoice_id', 'date_create', 'customer_name', 'customer_id', 'department_name', 'department_id', 'total_price');
		$this->ImportExportCsv->export('CSV order', $col_title, $col_value, $arr_data);
	}

	public function choose_sale() {
		$data['title'] = '作成済請求書';
		$data['content'] = 'sales/choose_sales';
		$this->load->view('templates/master', $data);
	}
	public function detail_sale_2() {
		$invoice_id = $_GET['inv_id'];
		$this->load->model('Invoice');
		$this->load->model('Customer');
		$this->load->model('Sale');
		$this->load->model('Delivery_Detail');
		$this->load->model('Department');
		$this->load->model('Invoice_Group_Detail');
		$this->load->model('Invoice_Detail');
		$this->load->model('Invoice_Order_Detail');
		$this->load->model('Invoice_Group');
		$this->load->model('User');
		$data['title'] = '作成済請求書';
		if(!is_numeric($invoice_id)) redirect('/sale/created_sale');
		$invoice = $this->Invoice->get_by_id($invoice_id);
		if (empty($invoice)) {
			redirect('/sale/created_sale');
		}

		$invoice_group = $this->Invoice_Group->get_by_id($invoice->{I_INVOICE_GROUP_ID});
		if ($_SESSION['request-level'] == 'P') {
			if ($invoice->{I_USER_ID} != $_SESSION['login-info'][U_ID]) {
				redirect('/access-denied');
			}

		}

		if ($invoice->{I_HAVE_ORDER} == 1) {
		//loại có hóa đơn order

			$data['content'] = 'sales/detail_sales_2';
			$customer_name = $this->Customer->get_by_id($invoice->{I_CUSTOMER_ID})->{CUS_CUSTOMER_NAME};
			$tax = 0;
			$environment_tax = 0;
			$discount = 0;
			if ($invoice_group->{IG_TAX_CHECK} == 1) {
				$tax = $invoice_group->{IG_TAX};
			}

			if ($invoice_group->{IG_ENVIRONMENTAL_CHECK} == 1) {
				$environment_tax = $invoice_group->{IG_ENVIRONMENTAL_LOAD};
			} else {
				$discount = $invoice_group->{IG_DISCOUNT};
			}

			$user = $this->User->get_by_id($invoice->{I_USER_ID});
			$check_gaichyu = $user->{BM_MASTER_CHECK};
			$discount_gaichyu = $this->Invoice->get_discount_gaichyu($invoice->{I_CUSTOMER_ID}, $user->{U_BASE_CODE}, $user->{U_ID});

			$list_order = array();
			$department_list = '';
			$date_ship = null;
			$sum_price_cate1 = 0;
			$sum_price_cate2 = 0;
			$order_id_arr = array();
			$list_order = $this->Invoice_Detail->get_list_order($invoice_id);
			$i = 0;
			foreach ($list_order as $order) {
				$order_id_arr[] = $order->{ID_ORDER_ID};
				if ($i == 0) {
					$department_list .= $order->{DL_DEPARTMENT_NAME};
				} else {
					$department_list .= "," . $order->{DL_DEPARTMENT_NAME};
				}

				$order->product_list_cate1 = $this->Delivery_Detail->get_product_by_category($order->{ID_ORDER_ID}, 1); //ds sản phẩm khăn
				$order->product_list_cate2 = $this->Delivery_Detail->get_product_by_category($order->{ID_ORDER_ID}, 2);
				$order->sum_price_cate1 = $this->sum_price($order->product_list_cate1, $check_gaichyu) - $this->sum_price($order->product_list_cate1, $check_gaichyu) * $order->{ID_DISCOUNT_SUPPLIER} / 100;
				$order->sum_price_cate2 = $this->sum_price($order->product_list_cate2, $check_gaichyu) - $this->sum_price($order->product_list_cate2, $check_gaichyu) * $order->{ID_DISCOUNT_ORTHER} / 100;
				// $sum_price_cate1 += $order->sum_price_cate1;
				// $sum_price_cate2 += $order->sum_price_cate2;

				if ($check_gaichyu == 1) {
					if ($discount_gaichyu->department != $order->{SL_DEPARTMENT_CODE}) {
						$sum_price_cate1 += $order->sum_price_cate1; //tổng tiền mặt hàng khăn
						$sum_price_cate2 += $order->sum_price_cate2; //tổng tiền mặt hàng giặc
					}
				} else {
					$sum_price_cate1 += $order->sum_price_cate1; //tổng tiền mặt hàng khăn
					$sum_price_cate2 += $order->sum_price_cate2; //tổng tiền mặt hàng giặc
				}

				$i++;
			}
			$date_ship = $this->Sale->get_space_time_ship($order_id_arr);
			$data['id'] = $invoice_id;
			$data['customer_name'] = $customer_name;
			$data['invoice'] = $invoice_group->{IG_INVOICE_NAME};
			$data['address'] = $invoice->{I_STREET_ADDRESS};
			$data['date_ship'] = $date_ship;
			$data['department_list'] = $department_list;
			$data['sum_price_cate1'] = $sum_price_cate1;
			$data['sum_price_cate2'] = $sum_price_cate2;
			$data['environment_tax'] = $environment_tax;
			$data['discount'] = $discount;
			$data['tax'] = $tax;
			$data['remark'] = $invoice->{I_REMARKS};
			$data['list_order'] = $list_order;
			$data['discount_gaichyu'] = $discount_gaichyu;

			if ($check_gaichyu == 1) {
				$data['content'] = 'sales/detail_sales_gaichyu';
			}

			$this->load->view('templates/master', $data);

		} else {
			$data['content'] = 'sales/detail_sales_no_order';
			$tax = $invoice_group->{IG_TAX};
			$address = $invoice->{I_STREET_ADDRESS};
			$customer_name = $invoice->{I_OTHER_CUSTOMER};
			$department_name = $invoice->{I_DEPARTMENT_ID};
			$paid_date['start'] = str_replace('-', '/', $invoice->{I_PAID_DATE_START});
			$paid_date['end'] = str_replace('-', '/', $invoice->{I_PAID_DATE_END});
			$product_list_cate1 = $this->Invoice_Order_Detail->get_list_product_cate($invoice_id, 1);
			$product_list_cate2 = $this->Invoice_Order_Detail->get_list_product_cate($invoice_id, 2);
			$sum_price_cate1 = self::sum_price_for_no_order($product_list_cate1);
			$sum_price_cate2 = self::sum_price_for_no_order($product_list_cate2);
			$data['id'] = $invoice_id;
			$data['invoice'] = $invoice_group->{IG_INVOICE_NAME};
			$data['tax'] = $tax;
			$data['address'] = $address;
			$data['remark'] = $invoice->{I_REMARKS};
			$data['customer_name'] = $customer_name;
			$data['department_name'] = $department_name;
			$data['paid_date'] = $paid_date;
			$data['product_list_cate1'] = $product_list_cate1;
			$data['product_list_cate2'] = $product_list_cate2;
			$data['sum_price_cate1'] = $sum_price_cate1;
			$data['sum_price_cate2'] = $sum_price_cate2;
			$this->load->view('templates/master', $data);
		}
	}

	//tính tổng tiền danh sách sp ko hóa đơn order
	private function sum_price_for_no_order($product_list) {
		$sum_price = 0;
		foreach ($product_list as $product) {
			$sum_price += $product->{IOD_AMOUNT} * $product->{IOD_PRICE};
			if ($product->{IOD_PRICE} == 0) {
				$sum_price += $product->{IOD_SUM_PRICE};
			}

		}
		return $sum_price;
	}

	public function edit_createdSale() {
		$data['title'] = '作成済請求書';
		$data['content'] = 'sales/edit_createdSales';
		$this->load->view('templates/master', $data);
	}

	public function print_sale() {
		$invoice_id = $_GET['inv_id'];
		$this->load->model('Invoice');
		$this->load->model('Customer');
		$this->load->model('Sale');
		$this->load->model('Delivery_Detail');
		$this->load->model('Department');
		$this->load->model('Invoice_Group_Detail');
		$this->load->model('Invoice_Detail');
		$this->load->model('Invoice_Order_Detail');
		$this->load->model('Invoice_Group');
		$this->load->model('User');
		$data['title'] = '作成済請求書';
		if(!is_numeric($invoice_id)) redirect('/sale/created_sale');
		$invoice = $this->Invoice->get_by_id($invoice_id);
		$invoice_group = $this->Invoice_Group->get_by_id($invoice->{I_INVOICE_GROUP_ID});
		$pdf_html = null;
		$header = '';

		if ($invoice->{I_HAVE_ORDER} == 1) {
//loại có hóa đơn order

			$data['content'] = 'sales/detail_sales_2';
			$department_id_list = '';
			$customer_name = $this->Customer->get_by_id($invoice->{I_CUSTOMER_ID})->{CUS_CUSTOMER_NAME};
			$tax = 0;
			$environment_tax = 0;
			$discount = 0;
			if ($invoice_group->{IG_TAX_CHECK} == 1) {
				$tax = $invoice_group->{IG_TAX};
			}

			if ($invoice_group->{IG_ENVIRONMENTAL_CHECK} == 1) {
				$environment_tax = $invoice_group->{IG_ENVIRONMENTAL_LOAD};
			} else {
				$discount = $invoice_group->{IG_DISCOUNT};
			}

			$user = $this->User->get_by_id($invoice->{I_USER_ID});
			$check_gaichyu = $user->{BM_MASTER_CHECK};
			$discount_gaichyu = $this->Invoice->get_discount_gaichyu($invoice->{I_CUSTOMER_ID}, $user->{U_BASE_CODE}, $user->{U_ID});

			$list_order = array();
			$department_list = '';
			$date_ship = null;
			$sum_price_cate1 = 0;
			$sum_price_cate2 = 0;
			$order_id_arr = array();
			$list_order = $this->Invoice_Detail->get_list_order($invoice_id);
			$i = 0;
			foreach ($list_order as $order) {
				$order_id_arr[] = $order->{ID_ORDER_ID};
				if ($i == 0) {
					$department_list .= $order->{DL_DEPARTMENT_NAME};
					$department_id_list .= $order->{DL_DEPARTMENT_CODE};
				} else {
					$department_list .= "," . $order->{DL_DEPARTMENT_NAME};
					$department_id_list .= "," . $order->{DL_DEPARTMENT_CODE};
				}
				$order->product_list_cate1 = $this->Delivery_Detail->get_product_by_category($order->{ID_ORDER_ID}, 1); //ds sản phẩm khăn
				$order->product_list_cate2 = $this->Delivery_Detail->get_product_by_category($order->{ID_ORDER_ID}, 2);
				$order->sum_price_cate1 = $this->sum_price($order->product_list_cate1, $check_gaichyu) - $this->sum_price($order->product_list_cate1, $check_gaichyu) * $order->{ID_DISCOUNT_SUPPLIER} / 100;
				$order->sum_price_cate2 = $this->sum_price($order->product_list_cate2, $check_gaichyu) - $this->sum_price($order->product_list_cate2, $check_gaichyu) * $order->{ID_DISCOUNT_ORTHER} / 100;
				// $sum_price_cate1 += $order->sum_price_cate1;
				// $sum_price_cate2 += $order->sum_price_cate2;

				if ($check_gaichyu == 1) {
					if ($discount_gaichyu->department != $order->{SL_DEPARTMENT_CODE}) {
						$sum_price_cate1 += $order->sum_price_cate1; //tổng tiền mặt hàng khăn
						$sum_price_cate2 += $order->sum_price_cate2; //tổng tiền mặt hàng giặc
					}
				} else {
					$sum_price_cate1 += $order->sum_price_cate1; //tổng tiền mặt hàng khăn
					$sum_price_cate2 += $order->sum_price_cate2; //tổng tiền mặt hàng giặc
				}

				$i++;
			}
			$date_ship = $this->Sale->get_space_time_ship($order_id_arr);
			$data['id'] = $invoice_id;
			$data['customer_name'] = $customer_name;
			$data['customer'] = $this->Customer->get_by_id($invoice->{I_CUSTOMER_ID});
			$data['invoice'] = $invoice_group->{IG_INVOICE_NAME};
			$data['invoice_group'] = $invoice_group;
			$data['address'] = $invoice->{I_STREET_ADDRESS};
			$data['date_ship'] = $date_ship;
			$data['department_list'] = $department_list;
			$data['sum_price_cate1'] = $sum_price_cate1;
			$data['sum_price_cate2'] = $sum_price_cate2;
			$data['environment_tax'] = $environment_tax;
			$data['discount'] = $discount;
			$data['tax'] = $tax;
			$data['remark'] = $invoice->{I_REMARKS};
			$data['list_order'] = $list_order;
			$data['discount_gaichyu'] = $discount_gaichyu;

			if ($check_gaichyu == 1) {
				$pdf_html = $this->load->view('templates/sales/invoice_pdf_gaichyu', $data, true);
			} else {
				$pdf_html = $this->load->view('templates/sales/invoice_pdf_1', $data, true);
			}

			/*$header = "請求書NO: ".$invoice_id." 得意先NO: ".$invoice->{I_CUSTOMER_ID};
    		$header .= " 部署NO: ".$department_id_list."||".date('m/d/Y');*/
			$l_header = "<p>請求書NO:" . $invoice_id . " 得意先NO:" . $invoice->{I_CUSTOMER_ID} . ' 部署NO:' . $department_id_list . '</p>';
			$r_header = date('m/d/Y');

		} else {
			$data['content'] = 'sales/detail_sales_no_order';
			$tax = $invoice_group->{IG_TAX};
			$address = $invoice->{I_STREET_ADDRESS};
			$customer_name = $invoice->{I_OTHER_CUSTOMER};
			$department_name = $invoice->{I_DEPARTMENT_ID};
			$paid_date['start'] = str_replace('-', '/', $invoice->{I_PAID_DATE_START});
			$paid_date['end'] = str_replace('-', '/', $invoice->{I_PAID_DATE_END});
			$product_list_cate1 = $this->Invoice_Order_Detail->get_list_product_cate($invoice_id, 1);
			$product_list_cate2 = $this->Invoice_Order_Detail->get_list_product_cate($invoice_id, 2);
			$sum_price_cate1 = self::sum_price_for_no_order($product_list_cate1);
			$sum_price_cate2 = self::sum_price_for_no_order($product_list_cate2);
			$data['id'] = $invoice_id;
			$data['invoice'] = $invoice_group->{IG_INVOICE_NAME};
			$data['tax'] = $tax;
			$data['address'] = $address;
			$data['remark'] = $invoice->{I_REMARKS};
			$data['customer_name'] = $customer_name;
			$data['department_name'] = $department_name;
			$data['paid_date'] = $paid_date;
			$data['product_list_cate1'] = $product_list_cate1;
			$data['product_list_cate2'] = $product_list_cate2;
			$data['sum_price_cate1'] = $sum_price_cate1;
			$data['sum_price_cate2'] = $sum_price_cate2;
			//$this->load->view('templates/master',$data);
			$pdf_html = $this->load->view('templates/sales/invoice_pdf_2', $data, true);
			/*$header = "請求書NO: ".$invoice_id." 得意先NO: ".$invoice->{I_CUSTOMER_ID};
    		$header .= "部署NO: ||".date('m/d/Y');*/
			$l_header = "<span>請求書NO:" . $invoice_id . " 得意先NO:" . $invoice->{I_CUSTOMER_ID} . ' 部署NO:</span>';
			$r_header = date('m/d/Y');
		}

		$this->load->library('Mpdf/mpdf.php');
		$this->mpdf->SetHTMLHeader('<div style="text-align:left;float:left;width:80%;font-size:12px;">' . $l_header . '</div>' . '<div style="text-align:right;float:left;width:20%;font-size:10px;">' . $r_header . '</div>');
		$this->mpdf->WriteHTML($pdf_html);
		$this->mpdf->Output();
	}

	//tính tổng tiền các sản phẩm trong giấy đòi tiền theo loại sản phẩm
	public function sum_price_by_product($product_list_category) {
		$sum_price = 0;
		foreach ($product_list_category as $product) {
			$sum_price += $product->{DD_UNIT_PRICE} * $product->{DD_QUANTITY};
		}
		return $sum_price;
	}

	//thêm thông tin cho từng sản phẩm
	public function convert_product_list($product_list_category, $have_order) {
		$this->load->model('Invoice');
		foreach ($product_list_category as $product) {
			$product->discount = 0;
			if ($have_order) {
				$product->date = date("m/d/Y", strtotime($product->{SL_DELIVERY_DATE})); //ngày giao hàng
				$product->amount = $product->{DD_QUANTITY};
				$product->price_unit = $product->{DD_UNIT_PRICE}; //tiền trên 1 sản phẩm
				$product->price = $product->amount * $product->price_unit; //tiền đơn hàng trong invoice
			} else {
				$product->date = date("m/d/Y", strtotime($this->Invoice->get_by_id($product->{ID_INVOICE_ID})->{I_DATE_CREATE})); //NGÀY TẠO
				$product->amount = $product->{IOD_AMOUNT};
				$product->price_unit = $product->{IOD_PRICE};
				$product->price = $product->amount * $product->price_unit;
			}
		}
	}

	public function back() {
		echo json_encode(array(
			"success" => true,
			"message" => '',
		));
	}
}
