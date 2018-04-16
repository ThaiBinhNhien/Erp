<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseController extends VV_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *    http://example.com/index.php/welcome
	 *  - or -
	 *    http://example.com/index.php/welcome/index
	 *  - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('ImportExportCsv');
		$this->load->model('Buying');
		$this->load->model('Warehouse');
		$this->load->model('Supplier');
		$this->load->model('Processing_Content');
		$this->load->model('User');
		$this->load->model('Stock');
		$this->load->model('Sales_Destination');
		$this->load->model('Base_master');
		$this->load->model('Supplier', 'supplier_model');
		$this->load->model('Sales_Destination', 'sales_destination_model');
		$this->load->model('Inventory', 'inventory_model');
		$this->load->model('ReceiptInformation', 'receipt_information_model');
		$this->load->model('DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY');
		$this->load->library('helper', 'helper');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
		$this->level = $this->session->userdata('request-level');
		$this->role = $this->checkIsGroupRole(GR_PURCHASE_MANAGEMENT_OFFICER);
		$this->load->library('mpdf');
		$this->load->library('helper', 'helper');
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/PHPExcel_iofactory');
    $this->load->helper('url');
	}

	public function test_info_back()
	{
		$info_back = $this->Buying->get_info_back(32504,1);
		$info_fifo = $this->Buying->get_info_fifo(32504,1);
		print_r($info_back);echo "<br>";
		print_r($info_fifo);
	}

	public function update_buying() {
		$query1 = "select 商品ID as product_id,出庫数 as num_export from t_入出庫情報 where 出荷伝票ID is not null "
			. "and 処理内容 <> 9 and 出庫数 > 0 "
			. "order by 商品ID ASC";
		$tb_export = $this->db->query($query1)->result();
		$query2 = "select id,商品ID as product_id,入庫数 as num_import from t_入出庫情報 where 入庫伝票ID is not null "
			. "and 入庫数 > 0 "
			. "order by 商品ID ASC,発生日 ASC;";
		$tb_import = $this->db->query($query2)->result();
		$num_export = array();
		$i = 0;

		foreach ($tb_export as $index => $tb) {
			if ($index == 0) {
				$num_export[$i] = array(
					'product_id' => $tb->product_id,
					'num_export' => $tb->num_export,
				);
			} else {
				if ($num_export[$i]['product_id'] != $tb->product_id) {
					$i++;
					$num_export[$i] = array(
						'product_id' => $tb->product_id,
						'num_export' => $tb->num_export,
					);
				} else {
					$num_export[$i]['num_export'] += ($tb->num_export);
				}
			}
		}

		$num_import = array();
		$amount_export = 0;
		$amount_has_export = array();
		$i = 0;
		foreach ($tb_import as $index => $tb) {
			if ($i == 0) {
				$amount_export = (int) $this->get_amount_by_product_id($tb->product_id, $num_export);
				$i++;
			} else {
				if ((int) $tb_import[$index]->product_id != (int) $tb_import[$index - 1]->product_id) {
					$amount_export = (int) $this->get_amount_by_product_id($tb->product_id, $num_export);
					$i = 0;
				}
			}
			if ($tb->num_import < $amount_export) {
				$amount_has_export[] = array(
					'id' => $tb->id,
					'出庫数量_注文' => $tb->num_import,
				);
				$amount_export = (int) $amount_export - (int) ($tb->num_import);
			} else {
				$amount_has_export[] = array(
					'id' => $tb->id,
					'出庫数量_注文' => $amount_export,
				);
				$amount_export = 0;
			}
		}
	}

	public function get_amount_by_product_id($product_id, $arr) {
		foreach ($arr as $i => $value) {
			if ($value['product_id'] == $product_id) {
				return $value['num_export'];
			}

		}
		return 0;
	}

	public function insert_supplier_product() {
		$query1 = "select t_入出庫情報.`商品ID` as product_id,t_発注.`仕入先ID` as supplier,t_入出庫情報.`仕入単価` as price_buy from t_入出庫情報 "
			. "left join t_発注 on t_入出庫情報.`発注伝票ID`=t_発注.`id` "
			. "where t_入出庫情報.`発注伝票ID` is not null "
			. "order by t_入出庫情報.`商品ID` ASC,t_発注.`仕入先ID` ASC,t_入出庫情報.`発生日` DESC ";
		$product_supplier = $this->db->query($query1)->result();
		$tb_supplier_product = array();
		foreach ($product_supplier as $i => $detail) {
			if ($i == 0) {
				$tb_supplier_product[] = array(
					TPNS_VENDOR_ID => $detail->supplier,
					TPNS_ID_PRODUCT => $detail->product_id,
					TPNS_PURCHASE_PRICE => $detail->price_buy,
				);
			} else {
				if (($product_supplier[$i]->product_id != $product_supplier[$i - 1]->product_id)
					 && ($product_supplier[$i]->supplier != $product_supplier[$i - 1]->supplier)) {
					$tb_supplier_product[] = array(
						TPNS_VENDOR_ID => $detail->supplier,
						TPNS_ID_PRODUCT => $detail->product_id,
						TPNS_PURCHASE_PRICE => $detail->price_buy,
					);
				}

			}
		}
	}

	public function insert_sales_des_product() {
		$query1 = "select t_入出庫情報.`商品ID` as product_id,t_出荷.`販売先ID` as sales_des,t_入出庫情報.`販売単価` as price_sell from t_入出庫情報 "
			. "left join t_出荷 on t_入出庫情報.`出荷伝票ID`=t_出荷.`id` "
			. "where t_入出庫情報.`出荷伝票ID` is not null "
			. "order by t_入出庫情報.`商品ID` ASC,t_出荷.`販売先ID` ASC,t_入出庫情報.`発生日` DESC ";
		$product_sales_des = $this->db->query($query1)->result();
		$tb_sales_des_product = array();
		foreach ($product_sales_des as $i => $detail) {
			if ($i == 0) {
				if ($product_sales_des[$i]->sales_des != '') {
					$tb_sales_des_product[] = array(
						TPCT_SALEROOM => $detail->sales_des,
						TPCT_PRODUCT_ID => $detail->product_id,
						TPCT_UNIT_SELLING_PRICE => $detail->price_sell,
					);
				}

			} else {
				if (($product_sales_des[$i]->product_id != $product_sales_des[$i - 1]->product_id)
					 && ($product_sales_des[$i]->sales_des != $product_sales_des[$i - 1]->sales_des) && ($product_sales_des[$i]->sales_des != '')) {
					$tb_sales_des_product[] = array(
						TPCT_SALEROOM => $detail->sales_des,
						TPCT_PRODUCT_ID => $detail->product_id,
						TPCT_UNIT_SELLING_PRICE => $detail->price_sell,
					);
				}

			}
		}
	}

	public function update_amount_stock() {
		$query = "select `商品ID` as product_id,拠点コード as stock_id,(入庫累計 - 出庫数量_注文) as amount "
			. " from t_入出庫情報 "
			. " where 入庫伝票ID > 0 "
			. " and  入庫累計 > 出庫数量_注文 "
			. " order by stock_id asc ";
		$list_amount = $this->db->query($query)->result();
		$amount_arr = array();
		$i = 0;
		foreach ($list_amount as $key => $value) {
			if ($key == 0) {
				$amount_arr[$i] = array();
				$amount_arr[$i]['product_id_list'] = array();
				$amount_arr[$i]['number_plus'] = array();
			} else {
				if ($list_amount[$key]->stock_id != $list_amount[$key - 1]->stock_id) {
					$i++;
					$amount_arr[$i] = array();
					$amount_arr[$i]['product_id_list'] = array();
					$amount_arr[$i]['number_plus'] = array();
				}
			}
			$amount_arr[$i]['product_id_list'][] = $value->product_id;
			$amount_arr[$i]['number_plus'][] = $value->amount;
			$amount_arr[$i]['stock_id'] = $value->stock_id;
		}
	}

	public function import_price_buying()
	{
		$file = fopen(base_url("asset/gia_mua_ban.csv"), "r");
		$data_price_supplier = array();
		$data_price_des = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
			foreach (explode(" ", $csv_data[0]) as $value) {
				if($value != '') $data_price_supplier[] = array(
					TPNS_VENDOR_ID => $value,
					TPNS_ID_PRODUCT => $csv_data[2],
					TPNS_PURCHASE_PRICE => $csv_data[3]
				);
			}

			foreach (explode(" ", $csv_data[1]) as $value) {
				if($value != '') $data_price_des[] = array(
					TPCT_SALEROOM => $value,
					TPCT_PRODUCT_ID => $csv_data[2],
					TPCT_UNIT_SELLING_PRICE => $csv_data[4]
				);
			}
		}
		$this->db->insert_batch(T_PRODUCT_NUMBER_FOR_SUPPLIER,$data_price_supplier);
		$this->db->insert_batch(T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY,$data_price_des);
	}

	//import bảng nhập kho senzaito
	public function import_tb_senzaito()
	{
		include 'asset/nhap_kho_senzaito.php';
		foreach($T_入庫 as &$import_tb){
			$import_tb['id'] += 18000;
		}
		$this->db->update_batch(T_GOODS_RECEIPT,$T_入庫,'id');
	}

	public function update_import_tb_shirre()
	{
		include 'asset/nhap_kho_shirre.php';
		$data_update = array();
		foreach ($T_入庫 as $import_tb) {
			$data_update[] = array(
				'id' => $import_tb['入庫伝票ID'],
				'仕入先ID' => $import_tb['仕入先ID']
			);
		}
		//$this->db->update_batch(T_GOODS_RECEIPT,$data_update,'id');
	}

	//cập nhật nhà cung cấp của bảng nhập kho senzaito
	public function update_supplier_senzaito_import_tb()
	{
		$file = fopen(base_url("asset/update_supplier.csv"), "r");
		$data_update = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
			$old_supplier_id = $csv_data[0];
			$new_supplier_id = $csv_data[1];
			$query = "select `id` from `".T_GOODS_RECEIPT."` where `".GR_VENDOR_ID."` = ".$old_supplier_id." and `id` > 18000";
			$result = $this->db->query($query)->result_array();
			foreach ($result as &$import_tb) {
				$import_tb[GR_VENDOR_ID] = $new_supplier_id;
				array_push($data_update, $import_tb);
			}
		}
		$this->db->update_batch(T_GOODS_RECEIPT,$data_update,'id');
		//print_r($data_update);
	}

	public function import_order_tb_senzaito()
	{
		include 'asset/order_senzaito.php';
		foreach ($T_発注 as &$import_tb) {
			$import_tb['id'] += 17000;
		}
		//$this->db->insert_batch(T_ORDER,$T_発注);
	}
	//cập nhật nhà cung cấp của bảng order senzaito
	public function update_supplier_senzaito_order_tb()
	{
		$file = fopen(base_url("asset/update_supplier.csv"), "r");
		$data_update = array();
		while (!feof($file)) {
			$csv_data = fgetcsv($file);
			$old_supplier_id = $csv_data[0];
			$new_supplier_id = $csv_data[1];
			$query = "select `id` from `".T_ORDER."` where `".TO_VENDOR_ID."` = ".$old_supplier_id." and `id` > 17000";
			$result = $this->db->query($query)->result_array();
			foreach ($result as &$import_tb) {
				$import_tb[TO_VENDOR_ID] = $new_supplier_id;
				array_push($data_update, $import_tb);
			}
		}
		//$this->db->update_batch(T_ORDER,$data_update,'id');
	}
	//import bảng xuất kho senzaito
	public function import_export_tb_senzaito()
	{
		include 'asset/xuat_kho_senzaito.php';
		foreach ($T_出荷 as &$export_tb) {
			$export_tb['id'] += 17000;
		}
		//$this->db->insert_batch(T_ISSUE,$T_出荷);
	}

	public function get_number_import()
	{
		ini_set('max_execution_time', 600);
		$check_id_has_process = array();//id bảng xuất nhập kho đã thao tác
		$query = "select * from 入出庫情報 "
				." where (発注数 > 0 or 入庫数 > 0)"
				." and (発注伝票ID > 0 or 入庫伝票ID > 0)"
				." order by 商品ID ASC, 処理日 ASC "
				." LIMIT 1000 ;";
		$list_info_buying = $this->db->query($query)->result();
		echo count($list_info_buying);
		$i = 0;
		$group_by_product = array();
		foreach ($list_info_buying as $id => $row) {
			if($id == 0){}
			else if($list_info_buying[$id]->商品ID != $list_info_buying[$id-1]->商品ID) $i++;
			$group_by_product[$i][] = $row;
		}
		$arr_update_id = array();
		foreach ($group_by_product as $group_by_date) {//danh sách sort theo id sản phẩm tăng dần
			foreach ($group_by_date as $value2) {//danh sách sort theo ngày tăng dần
				$id_import_tb = null;
				$total_import = 0;
				if($value2->発注伝票ID > 0 && !in_array($value2->入出庫ID,$check_id_has_process)){
					$check_id_has_process[] = $value2->入出庫ID;
					foreach ($group_by_date as $k => $value3) {
						if($value3->入庫伝票ID > 0 && $total_import+$value3->入庫数 <= $value2->発注数 && !in_array($value3->入出庫ID, $check_id_has_process)){
							$check_id_has_process[] = $value3->入出庫ID;
							if($id_import_tb == null) $id_import_tb = $value3->入庫伝票ID;
							$arr_update_id[] = array(
								"tb_id" => $value3->入出庫ID,
								"product_id" => $value3->商品ID,
								"old_import_id" => $value3->入庫伝票ID,
								"new_import_id" => $value2->発注伝票ID,
								"order_id" => $value2->発注伝票ID
							);
							$value3->入庫伝票ID = $id_import_tb;
							$total_import += $value3->入庫数;
						}
						if($value3->入庫伝票ID > 0 && !in_array($value3->入出庫ID, $check_id_has_process)){

						}
					}
				}
			}
		}

		foreach ($arr_update_id as $key => $value) {
			print_r($value);echo "<br>";
		}
	}

	const no_template = 'no-template';
	public function index() {
		$data['title'] = '仕入管理';
		$data['content'] = 'purchase/index';

		$this->load->model('Buying');
		$this->load->model('Supplier');
		$this->load->model('Processing_Content');
		$this->load->model('User');
		$this->load->model('Stock');
		$this->load->model('Sales_Destination');
		$this->load->model('Base_master');

		$supplier_list = $this->Supplier->get_all_by_number_use(); //sắp xếp theo số lần dùng nhiều nhất
		$data['supplier_list'] = $supplier_list;
		$data['order_content_list'] = $this->Processing_Content->get_with_order_purchase();
		$data['register_user_list'] = $this->User->get_all();
		$data['base_list'] = $this->Base_master->get_all();
		$data['sales_des_list'] = $this->Sales_Destination->get_all();

		$isAdmin = $this->checkIsGroupRole(GR_SYSTEM_ADMINISTRATOR);
		$data_search['page'] = 0;
		if(!$isAdmin) $data_search['base_id'] = $this->LOGIN_INFO[U_BASE_CODE];
		$order_list = $this->Buying->get_list_order_purchase($data_search);
		foreach ($order_list as $order) {
			$user = $this->User->get_by_id($order->{TO_REGISTERED_USER});
			$supplier = $this->Supplier->get_by_id($order->{TO_VENDOR_ID});
			if (!empty($supplier)) {
				$order->supplier = $supplier->{SUP_SUPPLIER_COMPANY_NAME};
			} else {
				$order->supplier = null;
			}

			$processing_content = $this->Processing_Content->get_by_id($order->{TO_ORDER_DETAIL});
			if (!empty($processing_content)) {
				$order->content_order = $processing_content->{PC_PROCESSING_CONTENT};
			} else {
				$order->content_order = null;
			}

			if (!empty($user)) {
				$base = $this->Base_master->get_by_id($order->{TO_BASE_CODE});
				if (!empty($base)) {
					$order->base = $base->{BM_BASE_NAME};
				} else {
					$order->base = '規定外';
				}

				$order->register_user = $user->{U_NAME};
			} else {
				$order->base = null;
				$order->register_user = null;
			}
			$purchase = $this->Buying->get_purchase_by_order_id($order->{TO_ID});
			if (!empty($purchase)) {
				$order->import_date = $purchase->{GR_ARRIVAL_DAY};
			} else {
				$order->import_date = null;
			}

		}

		$data['isAdmin'] = $isAdmin;
		$data['order_list'] = $order_list;
		$this->load->view('templates/master', $data);
	}

	public function ajax_search_order_purchase() {

		$data['page'] = $_POST['page'];
		$data['order_id'] = $_POST['order_id'];
		$data['supplier_id'] = $_POST['supplier_id'];
		$data['content_id'] = $_POST['content_id'];
		$data['user_id'] = $_POST['user_id'];
		$data['base_id'] = $_POST['stock_id'];
		$data['order_date_start'] = $_POST['order_date_start'];
		$data['order_date_end'] = $_POST['order_date_end'];
		$data['sales_des_id'] = $_POST['sales_des_id'];
		$data['status'] = $_POST['status'];
		$data['is_import'] = $_POST['is_import'];
		$order_list = $this->Buying->get_list_order_purchase($data);
		foreach ($order_list as $order) {
			$user = $this->User->get_by_id($order->{TO_REGISTERED_USER});
			$order->id = $order->{TO_ID};
			$order->order_date = $order->{TO_ORDER_DATE};
			if ($order->order_date == null) {
				$order->order_date = '';
			}

			$supplier = $this->Supplier->get_by_id($order->{TO_VENDOR_ID});
			if (!empty($supplier)) {
				$order->supplier = $supplier->{SUP_SUPPLIER_COMPANY_NAME};
			}

			$content = $this->Processing_Content->get_by_id($order->{TO_ORDER_DETAIL});
			if (!empty($content)) {
				$order->content_order = $content->{PC_PROCESSING_CONTENT};
			}

			$base = $this->Base_master->get_by_id($order->{TO_BASE_CODE});
			if(!empty($base)){
				$order->base = $base->{BM_BASE_NAME};
			}else{
				$order->base = "規定外";
			}

			if (!empty($user)) {
				
				$order->register_user = $user->{U_NAME};
			} else {
				$order->register_user = null;
			}
			switch ($order->{TO_FORM}) {
			case 0:$order->status = '一時保存';
				break;
			case 1:$order->status = '承認待';
				break;
			case 2:$order->status = '承認済';
				break;
			default:$order->status = '一時保存';
				break;
			}
			switch ($order->{TO_RECEIPT}) {
			case 0:$order->is_import = '未';
				break;
			case 1:$order->is_import = '済';
				break;
			default:$order->is_import = '未';
				break;
			}
			$purchase = $this->Buying->get_purchase_by_order_id($order->{TO_ID});
			if (!empty($purchase)) {
				$order->import_date = $purchase->{GR_ARRIVAL_DAY};
			} else {
				$order->import_date = '';
			}

		}
		echo (json_encode(array('data' => $order_list)));
	}
	
	public function get_order_list() {
		$data = $this->Buying->get_supplier_list();
		echo json_encode($data);
	}
	public function get_buying_order_list_limit() {

		$num_row = $this->input->post('num_row');
		$row = 10;
		$data = $this->Buying->get_buying_order_list_limit($num_row, $row);
		echo (json_encode($data));
	}
	public function get_buying_order_by_id() {

		$code = $this->input->post('code');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$supplier_name = $this->input->post('supplier_name');
		$status = $this->input->post('status');
		$reason = $this->input->post('reason');
		$dk = array();
		if (!empty($code)) {$dk['code'] = $code;}
		if (!empty($status)) {$dk['status'] = $status;}
		if (!empty($supplier_name)) {$dk['supplier_id'] = $supplier_name;}
		if (!empty($from_date)) {$dk['from-date'] = date('Y-m-d', strtotime($from_date));}
		if (!empty($from_date)) {
			$dk['to-date'] = date('Y-m-d', strtotime($to_date));
		}
		if (!empty($reason)) {$dk['reason'] = $reason;}
		//Send data to model
		$data['data'] = $this->Buying->get_buying_order_by_id($dk);
		//Print data got reponse
		echo json_encode($data);
	}
	public function get_buying_order_by_id_limit() {

		$code = $this->input->post('code');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$supplier_name = $this->input->post('supplier_name');
		$status = $this->input->post('status');
		$reason = $this->input->post('reason');
		$dk = array();
		if (!empty($code)) {$dk['code'] = $code;}
		if (!empty($status)) {$dk['status'] = $status;}
		if (!empty($supplier_name)) {$dk['supplier_id'] = $supplier_name;}
		if (!empty($from_date)) {$dk['from-date'] = date('Y-m-d', strtotime($from_date));}
		if (!empty($from_date)) {
			$dk['to-date'] = date('Y-m-d', strtotime($to_date));
		}
		if (!empty($reason)) {$dk['reason'] = $reason;}
		//Send data to model
		$num_row = $this->input->post('num_row');
		$data = $this->Buying->get_buying_order_by_id_limit($dk, $num_row);
		//Print data got reponse
		echo (json_encode($data));
	}
	public function add_purchase() {
		$data['title'] = '発注書新規作成画面';
		$data['content'] = 'purchase/add_purchase';

		$user_id = $_SESSION['login-info'][U_ID];
		$data['max_id'] = $this->Buying->get_max_order_id($user_id);
		$data['supplier_list'] = $this->Supplier->get_all();
		$data['order_content_list'] = $this->Processing_Content->get_with_order_purchase();
		$data['sales_des_list'] = $this->Sales_Destination->get_all(); //danh sách nơi bán hàng
		$isAdmin = $this->checkIsGroupRole(GR_SYSTEM_ADMINISTRATOR);
		$data['base_list'] = $this->Base_master->get_by_role($isAdmin); //nếu user là admin thì lấy hết danh sách, ko thì chỉ lấy cứ điểm của user đó
		$data['isAdmin'] = $isAdmin;
		foreach ($data['sales_des_list'] as $sales_des) {
			$sales_des->id = $sales_des->{TSD_ID};
			$sales_des->name = $sales_des->{TSD_DISTRIBUTOR_NAME};
			$sales_des->outsourcing = $sales_des->{TSD_OUTSOURCING}; //order ngoài
		}
		//echo($_SESSION['request-level']);
		$this->load->view('templates/master', $data);
	}

	//ajax lưu order nhập kho
	public function ajax_save_order() {
		//$product_amount = $_POST['amount_product'];
		$this->Buying->db->trans_begin();

		$this->load->model('Warehouse');

		$order_data[TO_ID] = $_POST['order_id'];
		$order_data[TO_ORDER_DETAIL] = $_POST['content_id']; //nội dung nhập kho
		$order_data[TO_VENDOR_ID] = $_POST['supplier_id']; //nơi mua vào
		$order_data[TO_SALES_DESTINATION] = $_POST['sales_des_id']; //nơi bán hàng
		$order_data[TO_REGISTERED_USER] = $_POST['user_id']; //nguoi tạo order
		$order_data[TO_EMPLOYEE_ID] = $_POST['user_id']; //nguoi tạo order
		$order_data[TO_ORDER_DATE] = $_POST['date_create']; //ngày tạo
		$order_data[TO_DELIVERY_DATE] = $_POST['date_delivery']; //ngày giao
		$order_data[TO_FORM] = $_POST['status']; //tình trạng lưu/lưu tạm
		$order_data[TO_DISCOUNT] = $_POST['discount']; //chiết khấu
		$order_data[TO_REMARKS] = $_POST['comment']; //ghi chú
		$order_data[TO_BASE_CODE] = $_POST['stock_id']; //id kho
		$order_data[TO_INVENTORY_LOCATION_ID] = $_POST['stock_id'];
		$order_data[TO_STREET_ADDRESS] = $_POST['stock_address']; //địa chỉ kho khác
		$this->Buying->add_order($order_data); //thêm data cho bảng order

		$list_product_order['order_id'] = $_POST['order_id'];
		$list_product_order['register_user'] = $_POST['user_id'];
		$list_product_order['base_code'] = $_POST['stock_id']; //cứ điểm
		$list_product_order['content_id'] = $_POST['content_id']; //nội dung xử lý
		$list_product_order['order_date'] = $_POST['date_create']; //ngày đặt
		$list_product_order['supplier_id'] = $_POST['supplier_id']; //nhà cung cấp
		$list_product_order['sales_des_id'] = $_POST['sales_des_id']; //nơi bán hàng
		$list_product_order['product_id_array'] = explode('|', $_POST['product_id']);
		$list_product_order['product_name_array'] = explode('|', $_POST['product_name']);
		$list_product_order['product_amount_array'] = explode('|', $_POST['product_amount']);
		$list_product_order['product_price_array'] = explode('|', $_POST['product_price_list']);
		$list_product_order['product_comment_array'] = explode('|', $_POST['product_comment']);
		$this->Buying->add_list_product_for_order($list_product_order);

		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
		}

	}

	//ajax sửa hóa đơn order
	public function ajax_edit_purchase_order() {
		//$product_amount = $_POST['amount_product'];

		$update_date = $_POST['update_date'];
		$this->Warehouse->table_name = T_ORDER;
		if (!$this->Warehouse->isCheckDataUpdated($_POST['order_id'], $update_date, T_ORDER)) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_has_update_before"),
			));
			die();
		}

		$order = $this->Buying->get_detail_order_purchase($_POST['order_id']);
		if ($_SESSION['request-level'] == 'P') {
			if ($order->{TO_EMPLOYEE_ID} != $_SESSION['login-info'][U_ID]) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_edit_error"),
				));
				die();
			}
		}

		$this->Buying->db->trans_begin();
		$order_data[TO_ID] = $_POST['order_id'];
		$order_data[TO_ORDER_DETAIL] = $_POST['content_id']; //nội dung nhập kho
		$order_data[TO_VENDOR_ID] = $_POST['supplier_id']; //nơi mua vào
		$order_data[TO_SALES_DESTINATION] = $_POST['sales_des_id']; //nơi bán hàng
		$order_data[TO_ORDER_DATE] = $_POST['date_create']; //ngày tạo
		$order_data[TO_DELIVERY_DATE] = $_POST['delivery_date']; //ngày giao hàng
		$order_data[TO_FORM] = $_POST['status']; //tình trạng lưu/lưu tạm
		$order_data[TO_DISCOUNT] = $_POST['discount']; //chiết khấu
		$order_data[TO_REMARKS] = $_POST['comment']; //ghi chú
		$order_data[TO_BASE_CODE] = $_POST['stock_id']; //id kho
		$order_data[TO_STREET_ADDRESS] = $_POST['stock_address']; //địa chỉ kho khác
		$order_data[TO_FORM] = 1;
		$this->Buying->edit_order($order_data); //edit data cho bảng order

		$list_product_order['order_id'] = $_POST['order_id'];
		$list_product_order['base_code'] = $_POST['stock_id'];
		$list_product_order['order_date'] = $_POST['date_create'];
		$list_product_order['supplier_id'] = $_POST['supplier_id'];
		$list_product_order['sales_des_id'] = $_POST['sales_des_id'];
		$list_product_order['register_user'] = $_SESSION['login-info'][U_ID];
		$list_product_order['product_id_array'] = explode('|', $_POST['product_id']);
		$list_product_order['product_name_array'] = explode('|', $_POST['product_name']);
		$list_product_order['product_amount_array'] = explode('|', $_POST['product_amount']);
		$list_product_order['product_price_array'] = explode('|', $_POST['product_price_unit']);
		$list_product_order['product_comment_array'] = explode('|', $_POST['product_comment']);
		$this->Buying->update_product_list_purchase_order($list_product_order);

		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_edit_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_edit_success"),
			));
		}
	}

	public function ajax_get_list_product_by_supplier() {

		$supplier_id = $_POST['supplier_id'];
		$list_product = $this->Supplier->get_list_product_in_supplier($supplier_id);
		foreach ($list_product as $product) {
			$product->product_id = $product->{PL_PRODUCT_ID};
			$product->id = $product->{PL_PRODUCT_CODE_BUY}; //id mua vào
			$product->name = $product->{PL_PRODUCT_NAME_BUY};
			$product->color = $product->{PL_COLOR_TONE};
			if(!isset($product->{PL_COLOR_TONE})) $product->color = '';
			$product->standard = $product->{PL_STANDARD};
			if(!isset($product->{PL_STANDARD})) $product->standard = '';
			$product->price_unit = $product->{TPNS_PURCHASE_PRICE};
			$product->accumulation = 0; //lũy kế nhập kho
		}
		echo (json_encode($list_product));
	}
	public function ajax_get_list_product_by_supplier_2() {

		$supplier_id = $_POST['supplier_id'];
		$list_product = $this->Supplier->get_list_product_in_supplier_2($supplier_id);

		echo (json_encode($list_product));
	}

	public function detail_purchase() {

		$this->load->model('Base_master');
		$id = $this->input->get('id');
		$data['title'] = '発注書詳細閲覧画面';
		$data['content'] = 'purchase/detail_purchase';
		if(!is_numeric($id)) redirect('/purchase');
		$order = $this->Buying->get_detail_order_purchase($id);
		if (empty($order)) {
			redirect('/purchase');
		}
		if($_SESSION['request-level'] == 'P' && $order->{TO_REGISTERED_USER}!=$_SESSION['login-info'][U_ID]){
			redirect('/access-denied');
		}

		$discount = $order->{TO_DISCOUNT}; //chiết khấu
		$sum_price = 0; //cộng tất cả tiền của các sản phẩm
		$total_price = 0; //trừ bớt tiền của chiết khấu
		$purchase = $this->Buying->get_purchase_by_order_id($order->{TO_ID});
		$has_import = 0; //để kiểm tra nhập kho chưa
		if (!empty($purchase)) {
			$purchase_id = $purchase->{GR_ID};
			$has_import = 1;
		}
		$product_list = $this->Buying->product_list_of_order_purchase($order->{TO_ID});
		foreach ($product_list as $product) {
			if ($has_import) {
				$product->accumulation = $this->Buying->get_accumulation_of_product($purchase_id, $product->{PL_PRODUCT_ID});
			}
//lũy kế nhập kho
			else {
				$product->accumulation = 0;
			}

			$product->price = $product->{TGRI_UNIT_PRICE} * $product->{TGRI_NUMBER_OF_ORDERS};
			$sum_price += $product->price;
		}
		$total_price = $sum_price - $sum_price * $discount / 100; //trừ đi phần trăm chiết khấu
		$data['id'] = $id;
		$user = $this->User->get_by_id($order->{TO_REGISTERED_USER});
		if (!empty($user)) {
			$data['user'] = $user->{U_NAME};
		}
//người đăng ký
		else {
			$data['user'] = null;
		}

		$data['create_date'] = $order->{TO_ORDER_DATE};
		$supplier = $this->Supplier->get_by_id($order->{TO_VENDOR_ID});
		if (!empty($supplier)) {
			$data['supplier_place'] = $supplier->{SUP_SUPPLIER_COMPANY_NAME};
		}
//nhà cung cấp
		else {
			$data['supplier_place'] = null;
		}

		$data['is_confirm'] = 0;
		$data['has_import'] = $has_import;
		if (!empty($order->{TO_AUTHORIZER})) {
			$data['is_confirm'] = 1;
			$data['confirm_user'] = $this->User->get_by_id($order->{TO_AUTHORIZER})->{U_NAME};
		}
		$data['product_list'] = $product_list;
		$data['sum_price'] = $sum_price;
		$data['discount'] = $discount;
		$sales_des = $this->Sales_Destination->get_by_id($order->{TO_SALES_DESTINATION});
		if (!empty($sales_des)) {
			$data['sales_des'] = $sales_des->{TSD_DISTRIBUTOR_NAME};
		}
//nơi bán
		else {
			$data['sales_des'] = null;
		}

		if ($order->{TO_BASE_CODE} == 0) {
			$data['stock'] = $order->{TO_STREET_ADDRESS};
		} else {
			$data['stock'] = $this->Base_master->get_by_id($order->{TO_BASE_CODE})->{BM_BASE_NAME};
		}

		$order_content = $this->Processing_Content->get_by_id($order->{TO_ORDER_DETAIL});
		if (!empty($order_content)) {
			$data['order_content'] = $order_content->{PC_PROCESSING_CONTENT};
		}
//nội dung đặt order
		else {
			$data['order_content'] = null;
		}

		$data['content_id'] = $order->{TO_ORDER_DETAIL};
		$data['date_import'] = str_replace('-', '/', $order->{TO_DELIVERY_DATE});
		$data['total_price'] = $total_price;
		$data['remark'] = $order->{TO_REMARKS};
		$data['status'] = $order->{TO_FORM};
		$data['done_import'] = $order->{TO_RECEIPT};//đã nhập kho đủ số lượng order chưa
		$data['info_user'] = $this->LOGIN_INFO[U_NAME];
		$data['level_user'] = $this->level;
		$data['permission'] = $this->checkIsGroupRole(GR_SYSTEM_ADMINISTRATOR) | $this->checkIsGroupRole(GR_PURCHASE_MANAGEMENT_OFFICER);
		$this->load->view('templates/master', $data);
	}

	public function print_purchase_order()
	{
		$id = $this->input->get('id');
		$data['title'] = '発注伝票（注文書）';
		$data['content'] = 'purchase/print_purchase_order';
		if(!is_numeric($id)) redirect('/purchase');
		$order = $this->Buying->get_detail_order_purchase($id);
		if (empty($order)) {
			redirect('/purchase');
		}

		$discount = $order->{TO_DISCOUNT}; //chiết khấu
		$sum_price = 0; //cộng tất cả tiền của các sản phẩm
		$total_price = 0; //trừ bớt tiền của chiết khấu
		$purchase = $this->Buying->get_purchase_by_order_id($order->{TO_ID});
		$has_import = 0; //để kiểm tra nhập kho chưa
		if (!empty($purchase)) {
			$purchase_id = $purchase->{GR_ID};
			$has_import = 1;
		}
		$product_list = $this->Buying->product_list_of_order_purchase($order->{TO_ID});
		foreach ($product_list as $product) {
			if ($has_import) {
				$product->accumulation = $this->Buying->get_accumulation_of_product($purchase_id, $product->{PL_PRODUCT_ID});
			}
			//lũy kế nhập kho
			else {
				$product->accumulation = 0;
			}

			$product->price = $product->{TGRI_UNIT_PRICE} * $product->{TGRI_NUMBER_OF_ORDERS};
			$sum_price += $product->price;
		}
		$total_price = $sum_price - $sum_price * $discount / 100; //trừ đi phần trăm chiết khấu
		$data['id'] = $id;
		$user = $this->User->get_by_id($order->{TO_REGISTERED_USER});
		if (!empty($user)) {
			$data['user'] = $user->{U_NAME};
		}
		//người đăng ký
		else {
			$data['user'] = null;
		}

		$data['create_date'] = $order->{TO_ORDER_DATE};
		$supplier = $this->Supplier->get_by_id($order->{TO_VENDOR_ID});
		if (!empty($supplier)) {
			$data['supplier_place'] = $supplier->{SUP_SUPPLIER_COMPANY_NAME};
			$data['supplier_user_name'] = $supplier->{SUP_USER_ID};
			$data['supplier_id'] = $supplier->{SUP_ID};
		}
		//nhà cung cấp
		else {
			$data['supplier_place'] = null;
			$data['supplier_user_name'] = NULL;
		}

		$data['is_confirm'] = 0;
		$data['has_import'] = $has_import;
		if (!empty($order->{TO_AUTHORIZER})) {
			$data['is_confirm'] = 1;
			$data['confirm_user'] = $this->User->get_by_id($order->{TO_AUTHORIZER})->{U_NAME};
		}
		$data['product_list'] = $product_list;
		$data['sum_price'] = $sum_price;
		$data['discount'] = $discount;
		$sales_des = $this->Sales_Destination->get_by_id($order->{TO_SALES_DESTINATION});
		if (!empty($sales_des)) {
			$data['sales_des'] = $sales_des->{TSD_DISTRIBUTOR_NAME};
		}
//nơi bán
		else {
			$data['sales_des'] = null;
		}

		if ($order->{TO_BASE_CODE} == 0) {
			$data['stock'] = $order->{TO_STREET_ADDRESS};
		} else {
			$data['stock'] = $this->Base_master->get_by_id($order->{TO_BASE_CODE})->{BM_BASE_NAME};
		}

		$order_content = $this->Processing_Content->get_by_id($order->{TO_ORDER_DETAIL});
		if (!empty($order_content)) {
			$data['order_content'] = $order_content->{PC_PROCESSING_CONTENT};
		}
//nội dung đặt order
		else {
			$data['order_content'] = null;
		}

		$data['content_id'] = $order->{TO_ORDER_DETAIL};
		$data['date_import'] = str_replace('-', '/', $order->{TO_DELIVERY_DATE});
		$data['total_price'] = $total_price;
		$data['remark'] = $order->{TO_REMARKS};
		$data['base_master'] = $this->Base_master->get_by_id($user->{U_BASE_CODE});//cứ điểm của người tạo phiếu
		$data['base'] = $this->Base_master->get_by_id($order->{TO_BASE_CODE});//cứ điểm của kho
		$data['status'] = $order->{TO_FORM};
		$data['done_import'] = $order->{TO_RECEIPT};//đã nhập kho đủ số lượng order chưa
		$data['info_user'] = $this->LOGIN_INFO[U_NAME];
		$data['level_user'] = $this->level;
		$data['permission'] = $this->checkIsGroupRole(GR_PURCHASE_MANAGEMENT_OFFICER) | $this->checkIsGroupRole(GR_PURCHASE_MANAGEMENT_OFFICER);
		$this->load->view('templates/master', $data);
	}

	public function print_pdf_purchase_order()
	{
		$id = $this->input->post('id');
		$data['title'] = '発注伝票（注文書）';
		$data['content'] = 'purchase/print_purchase_order';
		$order = $this->Buying->get_detail_order_purchase($id);
		if (empty($order)) {
			redirect('/purchase');
		}

		$discount = $order->{TO_DISCOUNT}; //chiết khấu
		$sum_price = 0; //cộng tất cả tiền của các sản phẩm
		$total_price = 0; //trừ bớt tiền của chiết khấu
		$purchase = $this->Buying->get_purchase_by_order_id($order->{TO_ID});
		$has_import = 0; //để kiểm tra nhập kho chưa
		if (!empty($purchase)) {
			$purchase_id = $purchase->{GR_ID};
			$has_import = 1;
		}
		$product_list = $this->Buying->product_list_of_order_purchase($order->{TO_ID});
		foreach ($product_list as $product) {
			if ($has_import) {
				$product->accumulation = $this->Buying->get_accumulation_of_product($purchase_id, $product->{PL_PRODUCT_ID});
			}
			//lũy kế nhập kho
			else {
				$product->accumulation = 0;
			}

			$product->price = $product->{TGRI_UNIT_PRICE} * $product->{TGRI_NUMBER_OF_ORDERS};
			$sum_price += $product->price;
		}
		$total_price = $sum_price - $sum_price * $discount / 100; //trừ đi phần trăm chiết khấu
		$data['id'] = $id;
		$user = $this->User->get_by_id($order->{TO_REGISTERED_USER});
		if (!empty($user)) {
			$data['user'] = $user->{U_NAME};
		}
		//người đăng ký
		else {
			$data['user'] = null;
		}

		$data['create_date'] = $order->{TO_ORDER_DATE};
		$supplier = $this->Supplier->get_by_id($order->{TO_VENDOR_ID});
		if (!empty($supplier)) {
			$data['supplier_place'] = $supplier->{SUP_SUPPLIER_COMPANY_NAME};
			$data['supplier_user_name'] = $supplier->{SUP_USER_ID};
		}
		//nhà cung cấp
		else {
			$data['supplier_place'] = null;
			$data['supplier_user_name'] = null;
		}

		$data['is_confirm'] = 0;
		$data['has_import'] = $has_import;
		if (!empty($order->{TO_AUTHORIZER})) {
			$data['is_confirm'] = 1;
			$data['confirm_user'] = $this->User->get_by_id($order->{TO_AUTHORIZER})->{U_NAME};
		}
		$data['product_list'] = $product_list;
		$data['sum_price'] = $sum_price;
		$data['discount'] = $discount;
		$sales_des = $this->Sales_Destination->get_by_id($order->{TO_SALES_DESTINATION});
		if (!empty($sales_des)) {
			$data['sales_des'] = $sales_des->{TSD_DISTRIBUTOR_NAME};
		}
//nơi bán
		else {
			$data['sales_des'] = null;
		}

		if ($order->{TO_BASE_CODE} == 0) {
			$data['stock'] = $order->{TO_STREET_ADDRESS};
		} else {
			$data['stock'] = $this->Base_master->get_by_id($order->{TO_BASE_CODE})->{BM_BASE_NAME};
		}

		$order_content = $this->Processing_Content->get_by_id($order->{TO_ORDER_DETAIL});
		if (!empty($order_content)) {
			$data['order_content'] = $order_content->{PC_PROCESSING_CONTENT};
		}
//nội dung đặt order
		else {
			$data['order_content'] = null;
		}

		$data['content_id'] = $order->{TO_ORDER_DETAIL};
		$data['date_import'] = str_replace('-', '/', $order->{TO_DELIVERY_DATE});
		$data['total_price'] = $total_price;
		$data['remark'] = $order->{TO_REMARKS};
		$data['base_master'] = $this->Base_master->get_by_id($user->{U_BASE_CODE});//cứ điểm của người tạo phiếu
		$data['base'] = $this->Base_master->get_by_id($order->{TO_BASE_CODE});//cứ điểm của kho
		$data['status'] = $order->{TO_FORM};
		$data['done_import'] = $order->{TO_RECEIPT};//đã nhập kho đủ số lượng order chưa
		$data['info_user'] = $this->LOGIN_INFO[U_NAME];
		$data['level_user'] = $this->level;
		$data['permission'] = $this->checkIsGroupRole(GR_PURCHASE_MANAGEMENT_OFFICER) | $this->checkIsGroupRole(GR_PURCHASE_MANAGEMENT_OFFICER);
		$data['comment'] = $_POST['comment'];
		$data['remark_arr'] = $_POST['remark'];
		$pdf_html = $this->load->view('templates/purchase/report/print_pdf_purchase_order', $data,true);
		$pdf_footer = $this->load->view('templates/purchase/report/footer_purchase_order', $data,true);
		$this->load->library('Mpdf/mpdf.php');
/*		
		$this->mpdf->SetHTMLHeader("<div><span style='font-size:12px;width:50%'>発注書NO:".$id." 仕入先NO:".$supplier->{SUP_ID}."</span>"
			."<span style='text-align:right;width:50%;margin-left:300px;font-size:12px;float:right;'>発注日:".$order->{TO_ORDER_DATE}."</span></div>");*/
		$header = '<div class="order_number">発注書NO:'.$id.' 仕入先NO:'.$supplier->{SUP_ID}.'</div>';
		$header .= '<div class="date">発注日 '.str_replace('-','/',$order->{TO_ORDER_DATE}).'</div>';
		$this->mpdf->SetHTMLHeader($header);	

		$this->mpdf->SetHTMLFooter($pdf_footer);
		$this->mpdf->WriteHTML($pdf_html);
		$this->mpdf->Output();
	}

	//xóa order nhập kho
	public function ajax_del_purchase_order($value = '') {
		$this->Buying->db->trans_begin();

		$order_id = $_POST['order_id'];
		$order = $this->Buying->get_detail_order_purchase($order_id);
		if ($_SESSION['request-level'] == 'P') {
			if ($order->{TO_EMPLOYEE_ID} != $_SESSION['login-info'][U_ID]) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error"),
				));
				die();
			}
		}
		$this->Buying->del_product_list_purchase_order($order_id);
		$this->Buying->del_purchase_order($order_id);
		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_delete_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_delete_success"),
			));
		}
	}

	//xác nhận order nhập kho
	public function ajax_confirm_order_purchase() {
		$this->Buying->db->trans_begin();

		$order_id = $_POST['order_id'];
		$confirm_user = $_POST['confirm_user'];
		if (!empty($_POST['delete_flag'])) {
			$confirm_user = null;
		}
//trường họp xóa xác nhận
		$data['id'] = $order_id;
		$data['confirm_user'] = $confirm_user;
		$this->Buying->confirm_order_purchase($data);
		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
		}
	}

	public function detail_export_order() {
		$this->load->model('Warehouse');
		$this->load->model('User');
		$this->load->model('User_Stock_Export');
		$this->load->model('Sales_Destination');
		$this->load->model('Processing_Content');
		$this->load->model('Product');
		$this->load->model('Buying');
		$this->load->model('Stock');
		$this->load->model('DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY');
		$data['title'] = '出庫票閲覧画面';
		$data['content'] = 'purchase/detail_export_order';
		$id = $this->input->get('id');
		$data['export_content'] = $this->Buying->get_content($id);
		if(!is_numeric($id)) redirect('purchase/export-purchase');
		$t_warehouse = $this->Warehouse->get_by_id($id);
		if (empty($t_warehouse)) {
			header('Location: ' . base_url('purchase/export-purchase'));
		}

		$issuer = $this->User->get_by_id($t_warehouse->{SHIP_EMPLOYEE_ID}); //người cấp phiếu
		$ship_issuer = $this->User_Stock_Export->get_by_id($t_warehouse->{SHIP_ISSUER}); // người xuất kho
		$sales_destination = $this->Sales_Destination->get_by_id($t_warehouse->{SHIP_DISTRIBUTOR_ID}); // nơi bán hàng
		$processing_content = $this->Processing_Content->get_by_id($t_warehouse->{SHIP_SHIPMENT_CONTENTS}); // nội dung xuất hàng
		$product_list = $this->Buying->get_product_with_warehouse_2($id); // lấy danh sách sản phẩm theo id xuất hàng
		$sum_total_price = 0; // cộng tất cả tổng tiền
		foreach ($product_list as $product) {
			$product->amount_stock = $this->Buying->get_total_stock_product($product->{TGRI_PRODUCT_ID}, $t_warehouse->{SHIP_INVENTORY_LOCATION_ID}); // số lượng trong kho
			$sum_total_price += $product->total_price;
		}

		$data['id'] = $id;
		$max_id = $this->Buying->get_max_id_warehouse_has_export();
		if ($id == $max_id && $t_warehouse->{SHIP_SHIPMENT_CONTENTS} != 11 && $t_warehouse->{SHIP_SHIPMENT_CONTENTS} != 6
			 && $t_warehouse->{SHIP_SHIPMENT_CONTENTS} != 9) {
			$data['check_edit'] = 1;
		} else {
			$data['check_edit'] = 0;
		}

		if (!empty($issuer)) {
			$data['issuer'] = $issuer->{U_NAME};
		}
		// tên người cấp phiếu
		else {
			$data['issuer'] = null;
		}

		if (!empty($ship_issuer)) {
			$data['ship_issuer'] = $ship_issuer->{UX_NAME};
		}
		// tên người xuất hàng
		else {
			$data['ship_issuer'] = null;
		}

		$data['date_export'] = $t_warehouse->{SHIP_SHIP_DATE}; // ngày xuất kho
		$data['sales_destination'] = $sales_destination->{TSD_DISTRIBUTOR_NAME}; // nơi bán hàng
		if (!empty($processing_content)) {
			$data['processing_content'] = $processing_content->{PC_PROCESSING_CONTENT};
		}
		// nội dung xử lý
		else {
			$data['processing_content'] = null;
		}

		$stock = $this->Base_master->get_by_id($t_warehouse->{SHIP_INVENTORY_LOCATION_ID});
		if (!empty($stock)) {
			$data['stock'] = $stock->{BM_BASE_NAME};
		} else {
			$data['stock'] = null;
		}

		$data['product_list'] = $product_list; // danh sách thông tin sản phẩm
		$data['sum_total_price'] = $sum_total_price; // cộng tất cả tổng tiền
		$data['note'] = $t_warehouse->{SHIP_REMARKS}; // ghi chú(note)
		$data['is_P'] = $this->checkIsGroupRole(GR_PURCHASING_MANAGEMENT_PERSONNEL);
		$this->load->view('templates/master', $data);
	}
	public function edit_purchase_order() {
		$this->load->model('Buying');
		$this->load->model('User');
		$this->load->model('Supplier');
		$this->load->model('Processing_Content');
		$this->load->model('Stock');
		$this->load->model('Sales_Destination');
		$this->load->model('Base_master');
		$id = $this->input->get('id');
		$data['title'] = '発注書編集画面';
		$data['id'] = $id;
		$data['content'] = 'purchase/editOrder';
		if(!is_numeric($id)) redirect('/purchase');
		$order = $this->Buying->get_detail_order_purchase($id);
		if (empty($order)) {
			redirect('/purchase');
		}

		$purchase = $this->Buying->get_purchase_by_order_id($order->{TO_ID});
		if ($_SESSION['request-level'] == 'P') {
			if ($order->{TO_EMPLOYEE_ID} != $_SESSION['login-info'][U_ID]) {
				redirect('/access-denied');
			}
		}
		$discount = $order->{TO_DISCOUNT}; //chiết khấu
		$sum_price = 0; //cộng tất cả tiền của các sản phẩm
		$total_price = 0; //trừ bớt tiền của chiết khấu
		$product_list = $this->Buying->product_list_of_order_purchase($order->{TO_ID});
		foreach ($product_list as $product) {
			if (!empty($purchase)) {
				$product->accumulation = $this->Buying->get_accumulation_of_product($purchase->{GR_ID}, $product->{TGRI_PRODUCT_ID});
			}
			//lũy kế nhập kho
			else {
				$product->accumulation = 0;
			}

			$product->price = $product->{TGRI_UNIT_PRICE} * $product->{TGRI_NUMBER_OF_ORDERS};
			$sum_price += $product->price;
		}
		$total_price = $sum_price - $sum_price * $discount / 100;
		$data['id'] = $id;
		$data['user'] = $this->User->get_by_id($order->{TO_REGISTERED_USER})->{U_NAME}; //người đăng ký
		$data['create_date'] = $order->{TO_ORDER_DATE};
		$data['delivery_date'] = $order->{TO_DELIVERY_DATE};
		$data['supplier_id'] = $order->{TO_VENDOR_ID}; //id nhà cung cấp
		$data['is_confirm'] = 0;
		if (!empty($order->{TO_AUTHORIZER})) {
			$data['is_confirm'] = 1;
			$data['confirm_user'] = $this->User->get_by_id($order->{TO_AUTHORIZER})->{U_NAME};
		}
		$data['supplier_list'] = $this->Supplier->get_all(); //danh sách nhà cung cấp
		$data['sales_des_list'] = $this->Sales_Destination->get_all(); //danh sách nơi bán hàng
		foreach ($data['sales_des_list'] as $sales_des) {
			$sales_des->id = $sales_des->{TSD_ID};
			$sales_des->name = $sales_des->{TSD_DISTRIBUTOR_NAME};
			$sales_des->outsourcing = $sales_des->{TSD_OUTSOURCING}; //order ngoài
		}
		$data['sales_des_id'] = $order->{TO_SALES_DESTINATION}; //id nơi bán hàng
		$data['base_id'] = $order->{TO_BASE_CODE}; //id cứ điểm
		$isAdmin = $this->checkIsGroupRole(GR_SYSTEM_ADMINISTRATOR);
		$data['base_list'] = $this->Base_master->get_by_role($isAdmin); //danh sách cứ điểm
		$data['isAdmin'] = $isAdmin; //để biết có phải admin ko
		$data['stock_address'] = $order->{TO_STREET_ADDRESS}; //địa chỉ kho khác
		$data['product_list'] = $product_list;
		$data['product_list_by_supplier'] = self::get_list_product_by_supplier($data['supplier_id'])['list_product']; //danh sách sản phẩm theo nhà cung cấp
		$data['order_content_id'] = $order->{TO_ORDER_DETAIL};
		$data['order_content_list'] = $this->Processing_Content->get_with_order_purchase(); //nội dung order
		$data['json_product_list'] = self::get_list_product_by_supplier($data['supplier_id'])['json_product_list'];
		$data['sum_price'] = $sum_price;
		$data['discount'] = $discount;
		$data['update_date'] = $order->{TO_UPDATE_DATE};
		$data['total_price'] = $total_price;
		$data['remark'] = $order->{TO_REMARKS};
		$data['info_user'] = $this->LOGIN_INFO[U_NAME];
		$data['level_user'] = $this->level;
		$this->load->view('templates/master', $data);
	}

	//lấy danh sách sản phẩm theo nhà cung cấp
	private function get_list_product_by_supplier($supplier_id) {
		$this->load->model('Supplier');
		$this->load->model('Buying');
		$list_product = $this->Supplier->get_list_product_in_supplier($supplier_id);
		foreach ($list_product as $product) {
			$product->product_id = $product->{PL_PRODUCT_ID};
			$product->buy_code = $product->{PL_PRODUCT_CODE_BUY};
			$product->name = $product->{PL_PRODUCT_NAME_BUY};
			$product->color = $product->{PL_COLOR_TONE};
			$product->standard = $product->{PL_STANDARD};
			$product->price_unit = $product->{TPNS_PURCHASE_PRICE};
			$product->accumulation = 0; //lũy kế nhập kho
		}
		return array(
			'json_product_list' => json_encode($list_product),
			'list_product' => $list_product,
		);
	}

	public function edit_export_order() {
		$this->load->model('Warehouse');
		$this->load->model('User');
		$this->load->model('User_Stock_Export');
		$this->load->model('Sales_Destination');
		$this->load->model('Processing_Content');
		$this->load->model('Product');
		$this->load->model('Buying');
		$this->load->model('Stock');
		$this->load->model('DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY');
		$data['title'] = '発注書編集画面';
		$data['content'] = 'purchase/edit_export_order';
		ini_set('display_errors', 1);
		ini_set('max_execution_time', 300);

		$id = $this->input->get('id');

		if(!is_numeric($id)) redirect('purchase/export-purchase');
		$t_warehouse = $this->Warehouse->get_by_id($id);
		if ($_SESSION['request-level'] == 'P') {
			if ($_SESSION['login-info'][U_ID] != $t_warehouse->{SHIP_EMPLOYEE_ID}) {
				redirect('/access-denied');
			}
		}

		if (empty($t_warehouse)) {
			header('Location: ' . base_url('purchase/export-purchase'));
		}

		$max_id = $this->Buying->get_max_id_warehouse_has_export();
		if ($max_id != $id | $t_warehouse->{SHIP_SHIPMENT_CONTENTS} == 11 | $t_warehouse->{SHIP_SHIPMENT_CONTENTS} == 9) {
			header('Location: ' . base_url('purchase/export-purchase'));
			return false;
		}
		$issuer = $this->User->get_by_id($t_warehouse->{SHIP_EMPLOYEE_ID}); //người cấp phiếu
		$product_list = $this->Buying->get_product_with_warehouse_2($id); // lấy danh sách sản phẩm theo id xuất hàng
		$sum_total_price = 0;
		$product_id_list = array();
		foreach ($product_list as $product) {
			$product->amount_stock = $this->Buying->get_total_stock_product($product->{TGRI_PRODUCT_ID}, $t_warehouse->{SHIP_BASE_CODE}); // số lượng trong kho
			$sum_total_price += $product->total_price;
			$product_id_list[] = $product->{TGRI_PRODUCT_ID};
		}
		$list_product_id = $this->DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY->get_product_with_des($t_warehouse->{TPCT_SALEROOM}); // danh sách id sản pẩm theo nơi bán
		// lấy file json thong tin sản phẩm theo nơi bán

		$info_stock = $this->Buying->get_info_stock($t_warehouse->{SHIP_BASE_CODE});
		$i = 0;
		$json_list_product = null;
		foreach ($list_product_id as $DesProduct) {
			if (self::check_can_get_info($info_stock, $product_id_list, $DesProduct->{TPCT_PRODUCT_ID}) == true) {
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}] = $DesProduct;
				$info_fifo = $this->Buying->get_info_edit_fifo($DesProduct->{TPCT_PRODUCT_ID}, $t_warehouse->{SHIP_BASE_CODE}, $id);
				if($t_warehouse->{SHIP_SHIPMENT_CONTENTS} == 8){
					$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->price = $DesProduct->{TPCT_UNIT_SELLING_PRICE};
				}else{
					$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->price = explode('|',$info_fifo['arr_price'])[0];
				}
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->total_stock_product = array_sum(explode('|', $info_fifo['arr_amount'])); // tổng sản phẩm tồn kho
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->array_price_at_date = $info_fifo['arr_price']; // danh sách giá( theo ngày tăng dần, cách nhau bởi dấu | )
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->array_amount_at_date = $info_fifo['arr_amount']; // danh sách số lượng( theo ngày tăng dần, cách nhau bởi dấu | )
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->buy_code = $DesProduct->{PL_PRODUCT_CODE_BUY};// mã mua
			}
		}
		// end

		$data['id'] = $id;
		$data['stock_id'] = $t_warehouse->{SHIP_BASE_CODE};
		$base_master = $this->Base_master->get_by_id($data['stock_id']);
		if (!empty($base_master)) {
			$data['stock_name'] = $base_master->{BM_BASE_NAME};
		} else {
			$data['stock_name'] = null;
		}

		if (!empty($issuer)) {
			$data['issuer'] = $issuer->{U_NAME};
		}
		// tên người cấp phiếu
		else {
			$data['issuer'] = null;
		}

		$data['ship_issuer_id'] = $t_warehouse->{SHIP_ISSUER}; // id người xuất kho
		$data['user_list'] = $this->User_Stock_Export->get_all(); //danh sách tất cả user
		$data['date_export'] = $t_warehouse->{SHIP_SHIP_DATE}; // ngày xuất kho
		$data['sales_destination_id'] = $t_warehouse->{SHIP_DISTRIBUTOR_ID}; //id nơi bán hàng của hóa đơn
		$data['sales_destination_list'] = $this->Sales_Destination->get_all(); //danh sách nơi bán hàng
		$data['tolinen_sale'] = $this->Sales_Destination->get_by_id($t_warehouse->{SHIP_DISTRIBUTOR_ID})->{TSD_OUTSOURCING};
		$data['processing_content_id'] = $t_warehouse->{SHIP_SHIPMENT_CONTENTS}; //id nội dung xử lý của hóa đơn
		$data['processing_content_list'] = $this->Processing_Content->get_all(); //danh sách nội dung xử lý
		$data['update_date'] = $t_warehouse->{SHIP_UPDATE_DATE};
		$data['product_list'] = $product_list; // danh sách thông tin sản phẩm
		$data['sum_total_price'] = $sum_total_price; // cộng các tổng tiền của sản phẩm
		$data['list_product_id'] = $list_product_id;
		$data['note'] = $t_warehouse->{SHIP_REMARKS}; // ghi chú(note)
		$data['json_list_product'] = json_encode($json_list_product);
		$this->load->view('templates/master', $data);
	}

	private function check_can_get_info($info_stock, $product_id_list, $product_id) {
		$check = false;
		if (in_array($product_id, $product_id_list)) {
			return true;
		} else {
			foreach ($info_stock['product_id_list'] as $key => $value) {
				if ($product_id == $value) {
					if ($info_stock['amount_list'][$key] > 0) {
						$check = true;
					}
				}

			}
		}
		return $check;
	}

	public function ajax_edit_export_order() {
		$this->Buying->db->trans_begin();
		$warehouse_id = $_POST['a_warehouse_id']; //id hóa đơn xuất hàng
		$voter_id = $_POST['a_voter_id']; // id người cấp phiếu
		$issuer_id = $_POST['a_issuer_id']; // id người xuất kho
		$date = $_POST['a_date']; // ngày xuất kho
		$sales_distination_id = $_POST['a_sales_distination_id']; // id nơi bán hàng
		$content_id = $_POST['a_content_id']; // id nội dung giao hàng
		$note = $_POST['a_note']; // ghi chú
		$update_date = $_POST['update_date']; // ngày cập nhật
		$product_id_list = $_POST['a_product_id_list']; // danh sách id sản phẩm
		$amount_export_list = $_POST['a_amount_export_list']; // danh sách số lượng sản phẩm
		$price_list = $_POST['a_price_list']; // danh sách giá tiền
		$tolinen_sale = $_POST['tolinen_sale'];
		if (!$this->Warehouse->isCheckDataUpdated($warehouse_id, $update_date, T_ISSUE)) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_has_update_before"),
			));
			die();
		}

		$product_list = $this->Buying->get_product_with_warehouse_2($warehouse_id);
		/*$stock = array();
		$stock['product_id_list'] = array();
		$stock['amount_plus'] = array();
		$stock['stock_id'] = $_POST['stock_id'];
		foreach ($product_list as $product) {
			$stock['product_id_list'][] = $product->{TGRI_PRODUCT_ID};
			$stock['number_plus'][] = $product->amount;
		}
		$this->Stock->update_stock_product($stock);*/

		$T_Shipment[SHIP_ID] = $warehouse_id;
		$T_Shipment[SHIP_SHIPMENT_CONTENTS] = $content_id;
		$T_Shipment[SHIP_DISTRIBUTOR_ID] = $sales_distination_id;
		$T_Shipment[SHIP_EMPLOYEE_ID] = $voter_id;
		$T_Shipment[SHIP_SHIP_DATE] = $date;
		$T_Shipment[SHIP_ISSUER] = $issuer_id;
		$T_Shipment[SHIP_REMARKS] = $note;
		$T_Shipment[SHIP_SAVE_STATUS] = 1;
		$this->Warehouse->update($T_Shipment);

		$product_id_of_warehouse = $this->Buying->get_product_id_of_warehouse($warehouse_id);
		foreach ($product_id_of_warehouse as $product_id) {
			$this->Buying->replace_export_info($warehouse_id, $product_id->{TGRI_PRODUCT_ID});
		}

		$product_list = array();
		$amount_list = explode('|', $amount_export_list);
		$id_list = explode('|', $product_id_list);
		for ($i = 0; $i < count($amount_list); $i++) {
			$product_list[$i] = array();
			$product_list[$i] = self::get_list_info_import($id_list[$i], $amount_list[$i], $_POST['stock_id']);
		}
		$this->Buying->insert_number_has_export($product_list, $warehouse_id);

		$this->Buying->delete_product_of_warehouse_id($warehouse_id);

		if ($tolinen_sale == 0) {
//nếu là xuất kho cho tolien
			$t_buying['date'] = $date;
			$t_buying['stock_id'] = $_POST['stock_id'];
			$t_buying['product_id_list'] = $product_id_list;
			$t_buying['product_list'] = $product_list;
			$t_buying['warehouse_id'] = $warehouse_id;
			$t_buying['content_id'] = $content_id;
			$t_buying['price_list'] = $price_list;
			$t_buying['user_id'] = $voter_id;
			$t_buying['sales_des_id'] = $sales_distination_id;
			$this->Buying->insert_warehouse_info_2($t_buying, 1);
		} else {
			$t_buying['stock_id'] = $_POST['stock_id'];
			$t_buying['date'] = $date;
			$t_buying['product_id_list'] = $product_id_list;
			$t_buying['warehouse_id'] = $warehouse_id;
			$t_buying['content_id'] = $content_id;
			$t_buying['price_list'] = $price_list;
			$t_buying['product_list'] = $product_list;
			$t_buying['user_id'] = $voter_id;
			$t_buying['sales_des_id'] = $sales_distination_id;
			$this->Buying->insert_warehouse_info_2($t_buying, 0); // edit sản phẩm
		}

		/*$stock_data['stock_id'] = $_POST['stock_id'];
		$stock_data['product_id_list'] = explode('|', $product_id_list);
		$stock_data['number_plus'] = explode('|', $amount_export_list);
		foreach ($stock_data['number_plus'] as &$amount) {
			$amount *= (-1);
		}
		$this->Stock->update_stock_product($stock_data);*/

		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_edit_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_edit_success"),
			));
		}
	}

	public function ajax_del_export_order() {
		$this->Buying->db->trans_begin();

		$this->load->model('Buying');
		$this->load->model('Warehouse');
		$id = $_POST['id'];
		$warehouse = $this->Warehouse->get_by_id($id);
		if ($_SESSION['request-level'] == 'P') {
			if ($warehouse->{SHIP_EMPLOYEE_ID} != $_SESSION['login-info'][U_ID]) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error"),
				));
				die();
			}
		}
		$this->Buying->delete_with_warehouse_id($id);
		$this->Warehouse->delete_export_order($id);
		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_delete_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_delete_success"),
			));
		}
	}

	//xử lý nhập kho
	public function processing_import() {

		$data['title'] = '発注書 入庫処理画面';
		$data['content'] = 'purchase/processing_import';
		$this->load->model('Buying');
		$this->load->model('User');
		$this->load->model('Supplier');
		$this->load->model('Sales_Destination');
		$this->load->model('Stock');
		$this->load->model('Processing_Content');
		$this->load->model('Base_master');
		$id = $this->input->get('id');
		if(!is_numeric($id)) redirect('purchase/export-purchase');
		$order = $this->Buying->get_detail_order_purchase($id);
		$discount = $order->{TO_DISCOUNT}; //chiết khấu
		$sum_price = 0; //cộng tất cả tiền của các sản phẩm
		$total_price = 0; //trừ bớt tiền của chiết khấu
		$product_list = $this->Buying->product_list_of_order_purchase($order->{TO_ID});
		$purchase = $this->Buying->get_purchase_by_order_id($order->{TO_ID});
		$purchase_id = null;
		$has_import = 0; //để kiểm tra nhập kho chưa
		if (!empty($purchase)) {
			$purchase_id = $purchase->{GR_ID};
			$has_import = 1;
		}
		foreach ($product_list as $product) {
			if (!$has_import) {
				$product->accumulation = 0;
				$product->back_number = 0;
				$product->amount = 0;
				$product->date_import = null;
			} else {
				$import_info = $this->Buying->get_info_product_has_import($purchase_id, $product->{TGRI_PRODUCT_ID});
				$product->accumulation = $this->Buying->get_accumulation_of_product($purchase_id, $product->{TGRI_PRODUCT_ID}); //lũy kế nhập kho
				$product->back_number = $import_info['back_number'];
				$product->amount = $import_info['amount'];
				$product->date_import = $import_info['date_import'];
			}

			$product->price = $product->{TGRI_UNIT_PRICE} * $product->accumulation;
			$sum_price += $product->price;
		}
		$total_price = $sum_price - $sum_price * $discount / 100; //trừ đi phần trăm chiết khấu
		$data['id'] = $id;
		$data['user'] = $this->User->get_by_id($order->{TO_REGISTERED_USER})->{U_NAME}; //người đăng ký
		$data['create_date'] = $order->{TO_ORDER_DATE};
		$supplier = $this->Supplier->get_by_id($order->{TO_VENDOR_ID});
		if (!empty($supplier)) {
			$data['supplier_place'] = $supplier->{SUP_SUPPLIER_COMPANY_NAME};
		}
//nhà cung cấp
		else {
			$data['supplier_place'] = null;
		}

		$data['supplier_id'] = $order->{TO_VENDOR_ID};
		$data['is_confirm'] = 0;
		if (!empty($order->{TO_AUTHORIZER})) {
			$data['is_confirm'] = 1;
			$data['confirm_user'] = $this->User->get_by_id($order->{TO_AUTHORIZER})->{U_NAME};
		}
		$data['product_list'] = $product_list;
		$data['sum_price'] = $sum_price;
		$data['discount'] = $discount;
		$sales_des = $this->Sales_Destination->get_by_id($order->{TO_SALES_DESTINATION});
		if (!empty($sales_des)) {
			$data['sales_des'] = $sales_des->{TSD_DISTRIBUTOR_NAME};
		}
//nơi bán
		else {
			$data['sales_des'] = null;
		}

		$data['sales_des_id'] = $order->{TO_SALES_DESTINATION}; //nơi bán hàng
		if ($order->{TO_BASE_CODE} == 0) {
			$data['base'] = $order->{TO_STREET_ADDRESS};
		} else {
			$data['base'] = $this->Base_master->get_by_id($order->{TO_BASE_CODE})->{BM_BASE_NAME};
		}

		$data['base_id'] = $order->{TO_BASE_CODE};
		$data['has_import'] = $has_import;
		$order_content = null;
		if ($order->{TO_ORDER_DETAIL} == 11) {
			$order_content = $this->Processing_Content->get_by_id($order->{TO_ORDER_DETAIL});
			$data['content_id'] = $order->{TO_ORDER_DETAIL};
		}
		if ($order->{TO_ORDER_DETAIL} == 2) {
			$order_content = $this->Processing_Content->get_by_id(5);
			$data['content_id'] = 5;
		}
		if ($order->{TO_ORDER_DETAIL} != 11 && $order->{TO_ORDER_DETAIL} != 2) {
			$order_content = $this->Processing_Content->get_by_id(4);
			$data['content_id'] = 4;
		}
		if (!empty($order_content)) {
			$data['order_content'] = $order_content->{PC_PROCESSING_CONTENT};
		}
//nội dung đặt order
		else {
			$data['order_content'] = null;
		}
		$data['update_date'] = $order->{TO_UPDATE_DATE};
		$data['total_price'] = $total_price;
		$data['remark'] = $order->{TO_REMARKS};
		$this->load->view('templates/master', $data);
	}

	public function ajax_save_processing_import() {
		$this->load->model('Buying');
		$this->load->model('Stock');
		$this->load->model('User');
		$this->load->model('Warehouse');
		$order_id = $_POST['order_id'];
		$supplier_id = $_POST['supplier_id'];
		$sales_des_id = $_POST['sales_des_id'];
		$order_date = $_POST['order_date'];
		$date_import = date('Y-m-d');
		$update_date = $_POST['update_date'];
		$stock_id = $_POST['stock_id'];
		$register_user = $_SESSION['login-info'][U_ID];
		$product_id_list = $_POST['product_id'];
		$product_name_list = $_POST['product_name'];
		$product_amount_list = $_POST['product_amount'];
		$back_number_list = $_POST['back_number'];
		$accumulation_list = $_POST['product_accumulation'];
		$product_price_list = $_POST['product_price'];
		$product_date_list = $_POST['product_date'];
		$amount_plus_list = $_POST['amount_plus'];

		$this->Warehouse->table_name = T_ORDER;
		if (!$this->Warehouse->isCheckDataUpdated($order_id, $update_date, T_ORDER)) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_has_update_before"),
			));
			die();
		}

		$this->Buying->db->trans_begin();
		//dữ liệu bảng nhập kho
		$import_data[GR_VENDOR_ID] = $supplier_id; //id nơi mua vào
		$import_data[GR_ARRIVAL_DAY] = $date_import; //ngày nhập hàng
		$import_data[GR_REQUEST_DATE] = $order_date; //ngày yêu cầu
		$import_data[GR_REGISTERED_USER] = $register_user; //user đăng ký
		$import_data[GR_EMPLOYEE_ID] = $register_user; //nhân viên
		$import_data[GR_ORDER_SLIP_ID] = $order_id; //id hóa đơn order
		$import_data[GR_INVENTORY_LOCATION_ID] = $stock_id; //id kho
		$import_data[GR_GOODS_RECEIPT_DETAIL] = $_POST['content_id']; //nội dung nhập kho
		$import_data[GR_BASE_CODE] = $stock_id;
		//chưa rõ mã cứ điểm
		$purchase_id = $this->Buying->insert_import_purchase($import_data);

		$info_import_data['product_id_list'] = explode('|', $product_id_list);
		$info_import_data['product_name_list'] = explode('|', $product_name_list);
		$info_import_data['product_amount_list'] = explode('|', $product_amount_list);
		$info_import_data['back_number_list'] = explode('|', $back_number_list);
		$info_import_data['accumulation_list'] = explode('|', $accumulation_list);
		$info_import_data['product_price_list'] = explode('|', $product_price_list);
		$info_import_data['product_date_list'] = explode('|', $product_date_list);
		$info_import_data['purchase_id'] = $purchase_id; //id bảng nhập kho
		$info_import_data['register_user'] = $register_user;
		$info_import_data['content_id'] = $_POST['content_id'];
		$info_import_data['order_id'] = $order_id;
		$info_import_data['stock_id'] = $stock_id;
		$info_import_data['base_code'] = $stock_id;
		$info_import_data['supplier_id'] = $supplier_id;
		$info_import_data['sales_des_id'] = $sales_des_id;
		$info_import_data['check_has_import'] = $_POST['check_has_import'];
		$this->Buying->insert_info_import_purchase($info_import_data);

		if ($_POST['content_id'] == 5 && !$_POST['has_import']) {
//nếu nội dung nhập kho là nhập kho ngoài thì tạo xuất kho
			$T_Shipment[SHIP_SHIPMENT_CONTENTS] = 6; //xuất kho loại đặt order ngoài
			$T_Shipment[SHIP_DISTRIBUTOR_ID] = $_POST['sales_des_id'];
			$T_Shipment[SHIP_EMPLOYEE_ID] = $register_user;
			$T_Shipment[SHIP_SHIP_DATE] = date('Y-m-d');
			$T_Shipment[SHIP_ISSUER] = $register_user;
			$T_Shipment[SHIP_REMARKS] = null;
			$T_Shipment[SHIP_INVENTORY_LOCATION_ID] = $stock_id;
			$T_Shipment[SHIP_BASE_CODE] = $stock_id;
			$T_Shipment['形態'] = 1; //trạng thái lưu
			$this->Warehouse->insert($T_Shipment);

			$t_buying['date'] = date('Y-m-d');
			$t_buying['stock_id'] = $stock_id;
			$t_buying['product_id_list'] = $_POST['product_id'];
			$t_buying['warehouse_id'] = ($this->Warehouse->get_max_id()) - 1;
			$t_buying['content_id'] = 6; //xuất kho loại đặt order ngoài
			$t_buying['price_list'] = $product_price_list;
			$t_buying['amount_export_list'] = $product_amount_list;
			$t_buying['user_id'] = $register_user;
			$t_buying['supplier_id'] = $supplier_id;
			$t_buying['sales_des_id'] = $sales_des_id;
			$this->Buying->insert_warehouse_info($t_buying);
		}

		/*if ($_POST['content_id'] != 5) {
			$stock = array();
			$stock['product_id_list'] = explode('|', $product_id_list);
			$stock['number_plus'] = explode('|', $amount_plus_list);
			$stock['stock_id'] = $stock_id;
			$this->Stock->update_stock_product($stock);
		}*/

		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
		}

	}

	public function export_order_pdf() {
		$this->load->model('Buying');
		$data['order_list'] = $this->Buying->get_export_order_list();

		$data['pdf_template'] = '';
		$data['content'] = 'purchase/export_order_template';
		$html = $this->load->view('templates/master', $data, true);
		$pdfFilePath = "output_pdf_name.pdf";
		//load mPDF library
		$this->load->library('m_pdf');
		$footer = "
        <div>
        <p>株式会社　テーオーリネンサプライ</p>
        <p>本社　〒102-8578　東京都千代田区紀尾井町４－１　　電話(03) 3221-4081 (代表)</p>
        <p>工場　〒243-0801　神奈川県厚木市上依知３００６－１電話(046)2861-33111 (代表)</p>
        </div>";
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
	}
	public function strip_tower() {
		$data['title'] = '出庫管理';
		$this->load->model('Buying');
		$data['product'] = $this->Buying->product_code_order_detail();
		$data['list'] = $this->Buying->floor_order_detail1();
		$data['floor'] = $this->Buying->floor_order_detail();
		$data['content'] = 'purchase/strip_tower';
		//$this->load->view('templates/master',$data);
		$html = $this->load->view('templates/master', $data);
		$pdfFilePath = "output_pdf_name.pdf";
		//load mPDF library
		$this->load->library('m_pdf');
		/*  $this->m_pdf->pdf->WriteHTML($html);
			        //download it.
		*/
	}
	public function warehouse() {
		$data['title'] = '出庫管理';
		$data['content'] = 'purchase/warehouse';
		$this->load->model('Warehouse');
		$this->load->model('Sales_Destination');
		$this->load->model('User');
		$this->load->model('Processing_Content');
		$this->load->model('User_Stock_Export');

		$filterData['num_page'] = 0;
		$t_warehouse = $this->Warehouse->filter($filterData);
		foreach ($t_warehouse as $warehouse) {
			$warehouse->sales_des = $this->Sales_Destination->get_by_id($warehouse->{SHIP_DISTRIBUTOR_ID})->{TSD_DISTRIBUTOR_NAME}; //nơi xuất kho
			$content = $this->Processing_Content->get_by_id($warehouse->{SHIP_SHIPMENT_CONTENTS});
			if (!empty($content)) {
				$warehouse->content = $content->{PC_PROCESSING_CONTENT};
			}
//nội dung xử lý
			else {
				$warehouse->content = null;
			}

			$user = $this->User->get_by_id($warehouse->{SHIP_EMPLOYEE_ID});
			if (!empty($user)) {
				$warehouse->issuer = $user->{U_NAME};
			}
//người tạo giấy
			else {
				$warehouse->issuer = null;
			}

			if ($warehouse->{SHIP_SAVE_STATUS} == 1) {
				$warehouse->status = '保存';
			}
//lưu
			else {
				$warehouse->status = '一時保存';
			}
//lưu tạm
		}
		$data['sales_des_list'] = $this->Sales_Destination->get_all();
		$data['content_list'] = $this->Processing_Content->get_with_warehouse();
		$data['issuer_list'] = $this->User->get_all_user_by_warehouse();
		$data['shiper_list'] = $this->User_Stock_Export->get_all();
		$array_user = $this->Warehouse->get_arr_user_by_warehouse();
		$data['warehouse_list'] = $t_warehouse;
		foreach ($data['issuer_list'] as $key => $user) {
			$obj_user = new stdClass();
			$obj_user->user = $user->{U_ID};
			if(!in_array($obj_user, $array_user)) unset($data['issuer_list'][$key]);
		}
		$this->load->view('templates/master', $data);
	}

	//tìm danh sách xuất kho
	public function ajax_warehouse() {
		$this->load->model('Warehouse');
		$this->load->model('Sales_Destination');
		$this->load->model('User');
		$this->load->model('Processing_Content');
		$filterData;
		if (!empty($_POST['order_no'])) {
			$filterData['order_no'] = $_POST['order_no'];
		}

		if (!empty($_POST['distination_id'])) {
			$filterData['distination_id'] = $_POST['distination_id'];
		}

		if (!empty($_POST['content_id'])) {
			$filterData['content_id'] = $_POST['content_id'];
		}

		if (!empty($_POST['export_date_start'])) {
			$filterData['export_date_start'] = $_POST['export_date_start'];
		}

		if (!empty($_POST['export_date_end'])) {
			$filterData['export_date_end'] = $_POST['export_date_end'];
		}

		if (!empty($_POST['issuer_id'])) {
			$filterData['issuer_id'] = $_POST['issuer_id'];
		}
//người cấp phiếu
		if (!empty($_POST['shipper_id'])) {
			$filterData['shipper_id'] = $_POST['shipper_id'];
		}
//người xuất kho
		if (!empty($_POST['status'])) {
			$filterData['status'] = $_POST['status'] - 1;
		}
//tình trạng
		$filterData['num_page'] = $_POST['num_page'];
		$t_warehouse = $this->Warehouse->filter($filterData);
		foreach ($t_warehouse as $warehouse) {
			$warehouse->date_export = $warehouse->{SHIP_SHIP_DATE};
			$warehouse->sales_des = $this->Sales_Destination->get_by_id($warehouse->{SHIP_DISTRIBUTOR_ID})->{TSD_DISTRIBUTOR_NAME}; //nơi xuất kho
			$content = $this->Processing_Content->get_by_id($warehouse->{SHIP_SHIPMENT_CONTENTS});
			if (!empty($content)) {
				$warehouse->content = $content->{PC_PROCESSING_CONTENT};
			}
//nội dung xử lý
			$issuer = $this->User->get_by_id($warehouse->{SHIP_EMPLOYEE_ID});
			if (!empty($issuer)) {
				$warehouse->issuer = $issuer->{U_NAME};
			}
//người tạo giấy
			else {
				$warehouse->issuer = null;
			}

			if ($warehouse->形態 == 1) {
				$warehouse->status = '保存';
			}
//lưu
			else {
				$warehouse->status = '一時保存';
			}
//lưu tạm
		}
		$t_warehouse['data'] = $t_warehouse;
		echo json_encode($t_warehouse);
	}
	public function ajax_warehouse_() {
		$this->load->model('Warehouse');
		$this->load->model('Sales_Destination');
		$this->load->model('User');
		$this->load->model('Processing_Content');
		$filterData;
		if (!empty($_POST['order_no'])) {
			$filterData['order_no'] = $_POST['order_no'];
		}

		if (!empty($_POST['distination_id'])) {
			$filterData['distination_id'] = $_POST['distination_id'];
		}

		if (!empty($_POST['content_id'])) {
			$filterData['content_id'] = $_POST['content_id'];
		}

		if (!empty($_POST['export_date_start'])) {
			$filterData['export_date_start'] = $_POST['export_date_start'];
		}

		if (!empty($_POST['export_date_end'])) {
			$filterData['export_date_end'] = $_POST['export_date_end'];
		}

		if (!empty($_POST['issuer_id'])) {
			$filterData['issuer_id'] = $_POST['issuer_id'];
		}
//người cấp phiếu
		if (!empty($_POST['shipper_id'])) {
			$filterData['shipper_id'] = $_POST['shipper_id'];
		}
//người xuất kho
		if (!empty($_POST['status'])) {
			$filterData['status'] = $_POST['status'] - 1;
		}
//tình trạng
		$filterData['num_page'] = $_POST['num_page'];
		$t_warehouse = $this->Warehouse->filter($filterData);
		foreach ($t_warehouse as $warehouse) {
			$warehouse->date_export = $warehouse->{SHIP_SHIP_DATE};
			$warehouse->sales_des = $this->Sales_Destination->get_by_id($warehouse->{SHIP_DISTRIBUTOR_ID})->{TSD_DISTRIBUTOR_NAME}; //nơi xuất kho
			$content = $this->Processing_Content->get_by_id($warehouse->{SHIP_SHIPMENT_CONTENTS});
			if (!empty($content)) {
				$warehouse->content = $content->{PC_PROCESSING_CONTENT};
			}
//nội dung xử lý
			$issuer = $this->User->get_by_id($warehouse->{SHIP_EMPLOYEE_ID});
			if (!empty($issuer)) {
				$warehouse->issuer = $issuer->{U_NAME};
			}
//người tạo giấy
			else {
				$warehouse->issuer = null;
			}

			if ($warehouse->形態 == 1) {
				$warehouse->status = '保存';
			}
//lưu
			else {
				$warehouse->status = '一時保存';
			}
//lưu tạm
		}
		echo json_encode($t_warehouse);
	}
	public function add_warehouse() {
		$data['title'] = '出庫票新規作成画面';
		$data['content'] = 'purchase/add_warehouse';
		$this->load->model("Product"); //database sản phẩm
		$this->load->model('Warehouse');
		$this->load->model('User');
		$this->load->model('Sales_Destination'); //database nơi bán hàng
		$this->load->model('DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY'); //liên kết nơi bán và sản phẩm
		$this->load->model('Processing_Content'); // nội dung xử lý
		$this->load->model('Base_master');
		$this->load->model('Stock');
		$this->load->model('User_Stock_Export');
		$product_list = $this->Product->get_All();
		$data['max_id'] = $this->Warehouse->get_max_id(); // giá trị lớn nhất của hóa đơn xuất kho
		$data['warehouse_person'] = $this->User_Stock_Export->get_all(); // người xuất kho
		$data['Sales_Destinations'] = $this->Sales_Destination->get_all();
		$data['processing_list'] = $this->Processing_Content->get_with_warehouse();
		$isAdmin = $this->checkIsGroupRole(GR_SYSTEM_ADMINISTRATOR);
		$data['base_list_1'] = $this->Base_master->get_by_role($isAdmin);
		$data['base_list_2'] = $this->Base_master->get_all();
		$data['isAdmin'] = $isAdmin;
		foreach ($data['Sales_Destinations'] as $sales_des) {
			$sales_des->id = $sales_des->{TSD_ID};
			$sales_des->name = $sales_des->{TSD_DISTRIBUTOR_NAME};
			$sales_des->outsourcing = $sales_des->{TSD_OUTSOURCING}; //order ngoài
		}
		$this->load->view('templates/master', $data);
	}

	public function ajax_add_warehouse() {
		$this->Buying->db->trans_begin();
		$warehouse_id = $_POST['a_warehouse_id']; //id hóa đơn xuất hàng
		$voter_id = $_POST['a_voter_id']; // id người cấp phiếu
		$issuer_id = $_POST['a_issuer_id']; // id người xuất kho
		$date = $_POST['a_date']; // ngày xuất kho
		$sales_distination_id = $_POST['a_sales_distination_id']; // id nơi bán hàng
		$content_id = $_POST['a_content_id']; // id nội dung giao hàng
		$note = $_POST['a_note']; // ghi chú
		$product_id_list = $_POST['a_product_id_list']; // danh sách id sản phẩm
		$amount_export_list = $_POST['a_amount_export_list']; // danh sách số lượng sản phẩm
		$price_list = $_POST['a_price_list']; // danh sách tổng giá tiền
		$tolinen_sale = $_POST['tolinen_sale']; //nơi bán hàng có phải là tolien ko

		$product_list = array();
		$amount_list = explode('|', $amount_export_list);
		$id_list = explode('|', $product_id_list);
		for ($i = 0; $i < count($amount_list); $i++) {
			$product_list[$i] = array();
			$product_list[$i] = self::get_list_info_import($id_list[$i], $amount_list[$i], $_POST['stock_id']);
		}

		$T_Shipment[SHIP_ID] = $warehouse_id;
		$T_Shipment[SHIP_SHIPMENT_CONTENTS] = $content_id;
		$T_Shipment[SHIP_DISTRIBUTOR_ID] = $sales_distination_id;
		$T_Shipment[SHIP_EMPLOYEE_ID] = $voter_id;
		$T_Shipment[SHIP_SHIP_DATE] = $date;
		$T_Shipment[SHIP_ISSUER] = $issuer_id;
		$T_Shipment[SHIP_REGISTERED_USER] = $issuer_id;
		$T_Shipment[SHIP_REMARKS] = $note;
		$T_Shipment[SHIP_BASE_CODE] = $_POST['stock_id'];
		$T_Shipment[SHIP_INVENTORY_LOCATION_ID] = $_POST['stock_id'];
		$T_Shipment['形態'] = (int) $_POST['a_status']; //trạng thái lưu
		$this->Warehouse->insert($T_Shipment);

		$this->Buying->insert_number_has_export($product_list, $warehouse_id);
		if ($tolinen_sale == 1) {
//nếu là xuất kho cho tolien
			$t_buying['date'] = $date;
			$t_buying['stock_id'] = $_POST['stock_id'];
			$t_buying['product_id_list'] = $product_id_list;
			$t_buying['product_list'] = $product_list;
			$t_buying['warehouse_id'] = $warehouse_id;
			$t_buying['content_id'] = $content_id;
			$t_buying['user_id'] = $voter_id;
			$t_buying['price_list'] = $price_list;
			$t_buying['sales_des_id'] = $sales_distination_id;
			$this->Buying->insert_warehouse_info_2($t_buying, 1);
		} else {
//nếu xuất kho đi bán
			$t_buying['date'] = $date;
			$t_buying['stock_id'] = $_POST['stock_id'];
			$t_buying['product_id_list'] = $product_id_list;
			$t_buying['warehouse_id'] = $warehouse_id;
			$t_buying['content_id'] = $content_id;
			$t_buying['price_list'] = $price_list;
			$t_buying['amount_export_list'] = $amount_export_list;
			$t_buying['user_id'] = $voter_id;
			$t_buying['product_list'] = $product_list;
			$t_buying['price_list'] = $price_list;
			$t_buying['sales_des_id'] = $sales_distination_id;
			$this->Buying->insert_warehouse_info_2($t_buying, 0);
			//$this->Buying->insert_warehouse_info($t_buying);
		}

		/*$data_stock['stock_id'] = $_POST['stock_id'];
		$data_stock['product_id_list'] = explode('|', $product_id_list);
		$amount_export_arr = explode('|', $amount_export_list);
		foreach ($amount_export_arr as &$amount) {
			$amount *= (-1);
		}
		$data_stock['number_plus'] = $amount_export_arr;
		$this->Stock->update_stock_product($data_stock);*/

		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
		}
	}

	// điều chỉnh tồn kho
	public function ajax_correct_stock() {
		$this->load->model('Warehouse'); // model warehouse
		$this->load->model('Buying');
		$this->load->model('Stock');
		$this->Buying->db->trans_begin();

		$warehouse_id = $_POST['a_warehouse_id']; //id hóa đơn xuất hàng
		$voter_id = $_POST['a_voter_id']; // id người cấp phiếu
		$issuer_id = $_POST['a_issuer_id']; // id người xuất kho
		$date = $_POST['a_date']; // ngày xuất kho
		$sales_distination_id = $_POST['a_sales_distination_id']; // id nơi bán hàng
		$content_id = $_POST['a_content_id']; // id nội dung giao hàng
		$note = $_POST['a_note']; // ghi chú
		$product_id_list = $_POST['a_product_id_list']; // danh sách id sản phẩm
		$amount_export_list = $_POST['a_amount_export_list']; // danh sách số lượng sản phẩm
		$price_list = $_POST['a_price_list']; // danh sách tổng giá tiền
		$tolinen_sale = $_POST['tolinen_sale']; //nơi bán hàng có phải là tolien ko

		$T_Shipment[SHIP_ID] = $warehouse_id;
		$T_Shipment[SHIP_SHIPMENT_CONTENTS] = $content_id;
		$T_Shipment[SHIP_DISTRIBUTOR_ID] = $sales_distination_id;
		$T_Shipment[SHIP_EMPLOYEE_ID] = $voter_id;
		$T_Shipment[SHIP_SHIP_DATE] = $date;
		$T_Shipment[SHIP_ISSUER] = $issuer_id;
		$T_Shipment[SHIP_REGISTERED_USER] = $issuer_id;
		$T_Shipment[SHIP_REMARKS] = $note;
		$T_Shipment[SHIP_BASE_CODE] = $_POST['stock_id'];
		$T_Shipment[SHIP_INVENTORY_LOCATION_ID] = $_POST['stock_id'];
		$T_Shipment['形態'] = (int) $_POST['a_status']; //trạng thái lưu
		$this->Warehouse->insert($T_Shipment);

		$product_id_arr = explode('|', $product_id_list);
		$amount_export_arr = explode('|', $amount_export_list);
		$product_id_positive = array(); //có số lượng dương
		$amount_export_positive = array(); //-----
		$product_id_negative = array(); //có số lượng âm
		$amount_export_negative = array(); //-------
		foreach ($amount_export_arr as $i => $amount) {
			if ($amount > 0) {
				$product_id_positive[] = $product_id_arr[$i];
				$amount_export_positive[] = $amount;
			} else {
				$product_id_negative[] = $product_id_arr[$i];
				$amount_export_negative[] = $amount;
			}
		}

		$product_list = array();
		for ($i = 0; $i < count($amount_export_positive); $i++) {
			$product_list[$i] = array();
			$product_list[$i] = self::get_list_info_import($product_id_positive[$i], $amount_export_positive[$i], $_POST['stock_id']);
		}

		$this->Buying->insert_number_has_export($product_list, $warehouse_id);

		//xuất kho cho số dương
		$t_buying['date'] = $date;
		$t_buying['stock_id'] = $_POST['stock_id'];
		$t_buying['product_id_list'] = $product_id_list;
		$t_buying['product_list'] = $product_list;
		$t_buying['warehouse_id'] = $warehouse_id;
		$t_buying['content_id'] = $content_id;
		$t_buying['user_id'] = $voter_id;
		$t_buying['price_list'] = $price_list;
		$t_buying['sales_des_id'] = $sales_distination_id;
		$this->Buying->insert_warehouse_info_2($t_buying, 1);

		$product_negative_list = array();
		for ($i = 0; $i < count($amount_export_negative); $i++) {
			$product_negative_list[$i] = array();
			$product_negative_list[$i] = self::get_list_info_back($product_id_negative[$i], $amount_export_negative[$i], $_POST['stock_id']);
		}
		$this->Buying->update_number_has_export($product_negative_list); //cập nhật số lượng đã xuất khi nhập số âm

		//xuất kho cho số âm
		$t_buying2['date'] = $date;
		$t_buying2['stock_id'] = $_POST['stock_id'];
		$t_buying2['product_id_list'] = $product_id_list;
		$t_buying2['product_list'] = $product_negative_list;
		$t_buying2['warehouse_id'] = $warehouse_id;
		$t_buying2['content_id'] = $content_id;
		$t_buying2['user_id'] = $voter_id;
		$t_buying2['price_list'] = $price_list;
		$t_buying2['sales_des_id'] = $sales_distination_id;
		$this->Buying->insert_warehouse_info_2($t_buying2, 1);

		//cập nhật số lượng trong kho
		/*$amount_export = explode('|', $amount_export_list);
		foreach ($amount_export as &$amount) {
			$amount *= (-1);
		}
		$data_stock['stock_id'] = $_POST['stock_id'];
		$data_stock['product_id_list'] = explode('|', $product_id_list);
		$data_stock['number_plus'] = $amount_export;
		$this->Stock->update_stock_product($data_stock);*/

		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
		}
	}

	//chuyển kho
	public function ajax_save_move_stock() {
		$this->load->model('Warehouse');
		$this->load->model('Buying');
		$this->load->model('User');
		$this->load->model('Stock');

		$this->Buying->db->trans_begin();

		$arr_amount = explode('|', $_POST['a_amount_export_list']);
		$arr_product_id = explode('|', $_POST['a_product_id_list']);
		$list_product = array(); //lấy thông tin của product
		for ($i = 0; $i < count($arr_product_id); $i++) {
			$list_product[$i] = array();
			$list_product[$i] = self::get_list_info_import($arr_product_id[$i], $arr_amount[$i], $_POST['stock_from']);
		}

		//tạo xuất kho
		$warehouse_id = $_POST['a_warehouse_id']; //id hóa đơn xuất hàng
		$voter_id = $_POST['a_voter_id']; // id người cấp phiếu
		$issuer_id = $_POST['a_issuer_id']; // id người xuất kho
		$date = $_POST['a_date']; // ngày xuất kho
		$sales_distination_id = $_POST['a_sales_distination_id']; // id nơi bán hàng
		$content_id = $_POST['a_content_id']; // id nội dung giao hàng
		$note = $_POST['a_note']; // ghi chú
		$product_id_list = $_POST['a_product_id_list']; // danh sách id sản phẩm
		$amount_export_list = $_POST['a_amount_export_list']; // danh sách số lượng sản phẩm
		$total_price_list = $_POST['a_price_list']; // danh sách tổng giá tiền
		$T_Shipment[SHIP_ID] = $warehouse_id;
		$T_Shipment[SHIP_SHIPMENT_CONTENTS] = $content_id;
		$T_Shipment[SHIP_DISTRIBUTOR_ID] = $sales_distination_id;
		$T_Shipment[SHIP_EMPLOYEE_ID] = $voter_id;
		$T_Shipment[SHIP_SHIP_DATE] = $date;
		$T_Shipment[SHIP_ISSUER] = $issuer_id;
		$T_Shipment[SHIP_REMARKS] = $note;
		$T_Shipment[SHIP_INVENTORY_LOCATION_ID] = $_POST['stock_from'];
		$T_Shipment[SHIP_BASE_CODE] = $_POST['stock_from'];
		$T_Shipment['形態'] = $_POST['a_status']; //trạng thái lưu
		$this->Warehouse->insert($T_Shipment);
		$product_list = array();
		$amount_list = explode('|', $amount_export_list);
		$id_list = explode('|', $product_id_list);
		for ($i = 0; $i < count($amount_list); $i++) {
			$product_list[$i] = array();
			$product_list[$i] = self::get_list_info_import($id_list[$i], $amount_list[$i], $_POST['stock_from']);
		}

		$this->Buying->insert_number_has_export($product_list, $warehouse_id);

		$t_buying['date'] = date('m/d/Y h:i:s a', time());
		$t_buying['product_id_list'] = $product_id_list;
		$t_buying['warehouse_id'] = $warehouse_id;
		$t_buying['content_id'] = $content_id;
		$t_buying['product_list'] = $product_list;
		$t_buying['total_price_list'] = $total_price_list;
		$t_buying['amount_export_list'] = $amount_export_list;
		$t_buying['user_id'] = $voter_id;
		$t_buying['stock_id'] = $_POST['stock_from'];
		$t_buying['sales_des_id'] = $sales_distination_id;
		$t_buying['price_list'] = $total_price_list;
		$this->Buying->insert_warehouse_info_2($t_buying, 1);

		//tạo order nhập kho
		$order_id = $this->Buying->get_max_order_id();
		$order_data[TO_ID] = $order_id;
		$order_data[TO_ORDER_DETAIL] = $content_id; //nội dung nhập kho
		$order_data[TO_VENDOR_ID] = 0; //nơi mua vào
		$order_data[TO_SALES_DESTINATION] = 0; //nơi bán hàng
		$order_data[TO_REGISTERED_USER] = $voter_id; //nguoi tạo order
		$order_data[TO_EMPLOYEE_ID] = $voter_id; //nguoi tạo order
		$order_data[TO_ORDER_DATE] = $date; //ngày tạo
		$order_data[TO_FORM] = 2; //tình trạng lưu/lưu tạm
		$order_data[TO_DISCOUNT] = 0; //chiết khấu
		$order_data[TO_REMARKS] = $note; //ghi chú
		$order_data[TO_BASE_CODE] = $_POST['stock_to'];
		$order_data[TO_INVENTORY_LOCATION_ID] = $_POST['stock_to']; //id kho
		$order_data[TO_STREET_ADDRESS] = null; //địa chỉ kho khác
		$order_data[TO_RECEIPT] = 1;
		$order_data[TO_AUTHORIZER] = $voter_id; //người xác nhận
		$this->Buying->add_order($order_data); //thêm data cho bảng order

		$list_product_order['order_id'] = $order_id;
		$list_product_order['register_user'] = $voter_id;
		$list_product_order['base_code'] = $_POST['stock_to'];
		$list_product_order['stock'] = $_POST['stock_to'];
		$list_product_order['list_product'] = $list_product;
		$this->Buying->add_list_product_for_order_2($list_product_order);

		//xử lý nhập kho
		//dữ liệu bảng nhập kho
		$import_data[GR_VENDOR_ID] = 0; //id nơi mua vào
		$import_data[GR_ARRIVAL_DAY] = $date; //ngày nhập hàng
		$import_data[GR_REQUEST_DATE] = $date; //ngày yêu cầu
		$import_data[GR_REGISTERED_USER] = $voter_id; //user đăng ký
		$import_data[GR_EMPLOYEE_ID] = $voter_id; //nhân viên
		$import_data[GR_ORDER_SLIP_ID] = $order_id; //id hóa đơn order
		$import_data[GR_INVENTORY_LOCATION_ID] = $_POST['stock_to']; //id kho
		//chưa rõ mã cứ điểm
		$purchase_id = $this->Buying->insert_import_purchase($import_data);

		$list_product_import['purchase_id'] = $purchase_id;
		$list_product_import['register_user'] = $voter_id;
		$list_product_import['content_id'] = 10;
		$list_product_import['base_code'] = $_POST['stock_to'];
		$list_product_import['list_product'] = $list_product;
		$list_product_import['stock'] = $_POST['stock_to'];
		$this->Buying->insert_info_import_purchase_2($list_product_import);

		//điều chỉnh số lượng dự trữ sản phẩm trong kho xuất và kho nhập
		/*$data_stock['product_id_list'] = explode('|', $product_id_list);
		$data_stock['number_plus'] = explode('|', $amount_export_list);
		$data_stock['stock_id'] = $_POST['stock_to'];
		$this->Stock->update_stock_product($data_stock); //cập nhật số lượng khi nhập kho
		$data_stock['stock_id'] = $_POST['stock_from'];
		foreach ($data_stock['number_plus'] as &$number) {
			$number *= (-1);
		}
		$this->Stock->update_stock_product($data_stock);*/

		if ($this->Buying->db->trans_status() === FALSE) {
			$this->Buying->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
		} else {
			$this->Buying->db->trans_commit();
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_add_success"),
			));
		}
	}

	/*lấy danh sách thông tin nhập kho trong trường hợp di chuyển kho
		  $export_amount : số lượng đã xuất kho
		  $amount : số lượng
	*/
	private function get_list_info_import($product_id, $amount, $stock_id) {

		$this->load->model('Buying');
		$this->load->model('Product');
		$info_fifo = $this->Buying->get_info_fifo($product_id, $stock_id);
		$product = $this->Product->get_by_id($product_id);
		$list_date = $info_fifo['arr_date'];
		$list_price = $info_fifo['arr_price'];
		$list_amount = $info_fifo['arr_amount'];
		$list_tb_id = $info_fifo['arr_id'];
		$list_supplier = $info_fifo['arr_supplier'];
		$arr_date = explode('|', $list_date);
		$arr_price = explode('|', $list_price);
		$arr_amount = explode('|', $list_amount);
		$arr_tb_id = explode('|', $list_tb_id);
		$arr_supplier = explode('|', $list_supplier);

		if ($amount > array_sum($arr_amount)) {
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_add_error"),
			));
			die();
		}
		$date_import = array();
		$amount_import = array();
		$price_import = array();
		$name_import = array();
		$id_import = array();
		$tb_id_import = array();
		$supplier_import = array();
		$i = 0; //số dùng để chuyển phần tử mảng
		$n = 0; //số so sánh để dừng vòng lặp
		while ($n < $amount) {
			$date_import[] = $arr_date[$i];
			$price_import[] = $arr_price[$i];
			$name_import[] = $product->{PL_PRODUCT_NAME_BUY};
			$id_import[] = $product_id;
			$tb_id_import[] = $arr_tb_id[$i];
			$supplier_import[] = $arr_supplier[$i];
			if (($amount - $n) > $arr_amount[$i]) {
				$amount_import[] = $arr_amount[$i];
				$n += $arr_amount[$i];
				$i++;
				continue;
			} else {
				$amount_import[] = $amount - $n;
				$n += ($amount - $n);
				continue;
			}
		}
		return array(
			'arr_date' => $date_import,
			'arr_amount' => $amount_import,
			'arr_price' => $price_import,
			'arr_id' => $id_import,
			'arr_name' => $name_import,
			'arr_tb_id' => $tb_id_import,
			'arr_supplier' => $supplier_import,
		);
	}

	private function get_list_info_back($product_id, $amount, $stock_id) {
		$info_back = $this->Buying->get_info_back($product_id, $stock_id);
		$product = $this->Product->get_by_id($product_id);
		$arr_date = explode('|', $info_back['arr_date']);
		$arr_price = explode('|', $info_back['arr_price']);
		$arr_amount = explode('|', $info_back['arr_amount']);
		$arr_tb_id = explode('|', $info_back['arr_id']);
		$arr_supplier = explode('|', $info_back['arr_supplier']);
		$date_import = array();
		$amount_has_export = array(); //số lượng đã xuất trong hóa đơn nhập
		$amount_export = array(); //số lượng xuất trong hóa đơn xuất
		$price_import = array();
		$id_import = array();
		$name_import = array();
		$tb_id_import = array();
		$supplier_import = array();
		$n = 0;
		$i = 0;
		$amount_back = abs($amount);
		while ($n < $amount_back) {
			$date_import[] = $arr_date[$i];
			$price_import[] = $arr_price[$i];
			$name_import[] = $product->{PL_PRODUCT_NAME_BUY};
			$id_import[] = $product_id;
			$tb_id_import[] = $arr_tb_id[$i];
			$supplier_import[] = $arr_supplier[$i];
			if (($amount_back - $n) > $arr_amount[$i]) {
				$amount_has_export[] = 0;
				$amount_export[] = $arr_amount[$i] * (-1);
				$n += $arr_amount[$i];
				$i++;
			} else {
				$amount_has_export[] = $arr_amount[$i] - ($amount_back - $n);
				$amount_export[] = ($amount_back - $n) * (-1);
				$n = $amount_back;
			}
		}
		return array(
			'arr_date' => $date_import,
			'arr_amount' => $amount_export,
			'arr_amount_has_export' => $amount_has_export,
			'arr_price' => $price_import,
			'arr_id' => $id_import,
			'arr_name' => $name_import,
			'arr_tb_id' => $tb_id_import,
			'arr_supplier' => $supplier_import,
		);
	}

	public function ajax_get_list_product() {
		$this->load->model('Product');
		$this->load->model('DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY');
		$this->load->model('Stock');
		$this->load->model('Buying');
		$i = 0;
		$stock_id = null;
		$Sales_Destination_Id = $_POST['id'];
		$stock_id = $_POST['stock_id'];
		$json_list_product = null;
		foreach ($this->DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY->get_product_with_des($Sales_Destination_Id) as $DesProduct) {
			$info_fifo = $this->Buying->get_info_fifo($DesProduct->{TPCT_PRODUCT_ID}, $stock_id);
			$amount_stock = array_sum(explode('|', $info_fifo['arr_amount']));
			if ($amount_stock > 0) {
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}] = $DesProduct;
				if ($DesProduct->{TSD_OUTSOURCING} == 1) {
					$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->price = $DesProduct->{TPCT_UNIT_SELLING_PRICE};
				}
				//giá sản phẩm
				else {
					$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->price = explode('|', $info_fifo['arr_price'])[0];
				}
				//self::get_price_unit_export_FIFO($DesProduct->{TPCT_PRODUCT_ID},$stock_id);
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->name = $DesProduct->{PL_PRODUCT_NAME_BUY};
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->total_stock_product = array_sum(explode('|', $info_fifo['arr_amount']));// tổng sản phẩm tồn kho
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->array_price_at_date = $info_fifo['arr_price']; //$this->Buying->get_price_product_with_date($DesProduct->{TPCT_PRODUCT_ID},$stock_id); // danh sách giá( theo ngày tăng dần, cách nhau bởi dấu | )
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->array_amount_at_date = $info_fifo['arr_amount']; //$this->Buying->get_amount_product_with_date($DesProduct->{TPCT_PRODUCT_ID},$stock_id); // danh sách số lượng( theo ngày tăng dần, cách nhau bởi dấu | )
				$json_list_product["id" . $DesProduct->{TPCT_PRODUCT_ID}]->number_export = 0; //số lượng đã xuất kho
			}
		}
		if ($stock_id == 'aaa' | empty($json_list_product)) {
			echo json_encode(json_decode("{}"));
			return null;
		}
		echo json_encode($json_list_product);
	}

	public function ajax_get_list_product_2() {
		$Sales_Destination_Id = $_POST['id'];
		$stock_id = $_POST['stock_id'];
		$list_product = $this->DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY->get_product_with_des($Sales_Destination_Id);
		$json_list_product = array();
		$arr_import_product = $this->Buying->get_array_import_product($stock_id);
		$arr_product_in_stock = $this->Buying->get_product_has_in_stock($stock_id);//danh sách sản phẩm còn trong kho
		foreach ($list_product as $product) {
			$pro = new stdClass();
			$pro->{TGRI_PRODUCT_ID} = $product->{TPCT_PRODUCT_ID};
			if (in_array($pro, $arr_product_in_stock) && $_POST['order_content']!=9) {
				$json_list_product['id' . $product->{TPCT_PRODUCT_ID}] = new stdClass();
				$json_list_product['id' . $product->{TPCT_PRODUCT_ID}] = $product;
				if ($product->{TSD_OUTSOURCING} == 1) {
					$json_list_product["id" . $product->{TPCT_PRODUCT_ID}]->price = $product->{TPCT_UNIT_SELLING_PRICE};
				}
				$json_list_product['id' . $product->{TPCT_PRODUCT_ID}]->name = $product->{PL_PRODUCT_NAME_BUY};
				$json_list_product['id' . $product->{TPCT_PRODUCT_ID}]->buy_code = $product->{PL_PRODUCT_CODE_BUY};
			}
			if($_POST['order_content']==9){
				$obj_product = new stdClass();
				$obj_product->{TGRI_PRODUCT_ID} = $product->{TPCT_PRODUCT_ID};
				if(in_array($obj_product, $arr_import_product)){
					$json_list_product['id' . $product->{TPCT_PRODUCT_ID}] = new stdClass();
					$json_list_product['id' . $product->{TPCT_PRODUCT_ID}] = $product;
					if ($product->{TSD_OUTSOURCING} == 1) {
						$json_list_product["id" . $product->{TPCT_PRODUCT_ID}]->price = $product->{TPCT_UNIT_SELLING_PRICE};
					}
					$json_list_product['id' . $product->{TPCT_PRODUCT_ID}]->name = $product->{PL_PRODUCT_NAME_BUY};
					$json_list_product['id' . $product->{TPCT_PRODUCT_ID}]->buy_code = $product->{PL_PRODUCT_CODE_BUY};
				}
			}
		}
		if (empty($json_list_product)) {
			echo json_encode(json_decode("{}"));
			return null;
		}
		echo json_encode($json_list_product);
	}

	public function ajax_get_info_export() {
		ini_set('display_errors', 1);
		$price = null;
		$product_id = $_POST['product_id'];
		$stock_id = $_POST['stock_id'];
		$sales_des_id = $_POST['sales_des_id'];
		$sales_des = $this->Sales_Destination->get_by_id($sales_des_id);
		$info_fifo = $this->Buying->get_info_fifo($product_id, $stock_id);
		$info_back = $this->Buying->get_info_back($product_id, $stock_id);
		$total_stock_product = array_sum(explode('|', $info_fifo['arr_amount']));
		$array_price_at_date = $info_fifo['arr_price'];
		$array_amount_at_date = $info_fifo['arr_amount'];
		if ($sales_des->{TSD_OUTSOURCING} != 1) {
			$price = explode('|', $info_fifo['arr_price'])[0];
		}

		$json_list_product = array(
			'total_stock_product' => $total_stock_product,
			'array_price_at_date' => $array_price_at_date,
			'array_amount_at_date' => $array_amount_at_date,
			'array_price_back_at_date' => $info_back['arr_price'],
			'array_amount_back_at_date' => $info_back['arr_amount'],
		);
		if ($price != null) {
			$json_list_product['price'] = $price;
		}

		echo json_encode($json_list_product);
	}

	//lấy giá ban đầu cho sản phẩm tính FIFO
	private function get_price_unit_export_FIFO($product_id, $stock_id) {
		$this->load->model('Buying');
		$number_export = $this->Buying->get_number_export($product_id, $stock_id);
		$price_unit = $this->Buying->get_price_unit_FIFO($product_id, $stock_id, $number_export);
		return $price_unit;
	}

	/**
	 * Function: debt
	 * This is View for [仕入請求管理]
	 * @access public
	 * @author PHAN TIEN ANH
	 */
	public function debt() {
		$data['title'] = $this->lang->line('title_purcha_manager');
		$data['list_place_buy'] = $this->supplier_model->getAll();
		$data['list_place_sale'] = $this->sales_destination_model->getAll();
		$data['content'] = 'purchase/debt';
		$this->load->view('templates/master', $data);
	}

	/**
	 * Function: detailDebt
	 * This is View for checkprice[単価チェック]
	 * @access public
	 * @author PHAN TIEN ANH
	 */
	public function detailDebt() {
		$data['title'] = $this->lang->line('title_purcha_price_check');

		// Data
		$keyword['type_report'] = $this->input->get('type_report');
		$keyword['date_delivery_from'] = $this->input->get('date_delivery_from');
		$keyword['date_delivery_to'] = $this->input->get('date_delivery_to');
		$data['date_month'] = $this->input->get('date_month');
		$keyword['place_buy'] = $this->input->get('place_buy');
		$keyword['place_sale'] = $this->input->get('place_sale');
		$data['place_buy_name'] = $this->input->get('place_buy_name');
		$data['place_sale_name'] = $this->input->get('place_sale_name');
		$keyword['date_import_from'] = $data['date_month'] . "/1";
		$keyword['date_import_to'] = $data['date_month'] . "/31";
		$keyword["check_price"] = "0";

		$data['data_check'] = $this->inventory_model->getListInforImport($keyword);
		// End Data

		$data['content'] = 'purchase/detailDebt';
		$this->load->view('templates/master', $data);
	}

	/**
	 * Function: check_price
	 * @access public
	 * @method POST
	 * @author PHAN TIEN ANH
	 */
	public function check_price() {
		if ($this->input->server("REQUEST_METHOD") == "POST") {
			$data = $this->input->post("data");
			if (count($data) != 0) {
				foreach ($data as $key => $value) {
					$this->receipt_information_model->editCheckPriceById($value);
				}
			}
		}
		echo json_encode(array(
			"success" => true,
			"message" => $this->lang->line("message_checklist_success"),
		));
	}

	/**
	 * Function: pdf_check_price
	 * @access public
	 * @method GET
	 * @author PHAN TIEN ANH
	 */
	public function pdf_check_price() {
		$this->load->library('mpdf');
		$pdf = new mPDF('utf8', 'A3-L', '', '', 15, 15, 15, 16, 9, 9);

		$title = $this->lang->line('pdf_check_price');
		$pdf->SetTitle($title);
		$data = array();
		$data['title'] = $title;
		$data['user_login'] = $this->LOGIN_INFO[U_ID];

		// Data
		$keyword['type_report'] = $this->input->get('type_report');
		$keyword['date_delivery_from'] = $this->input->get('date_delivery_from');
		$keyword['date_delivery_to'] = $this->input->get('date_delivery_to');
		$data['date_month'] = $this->input->get('date_month');
		$keyword['place_buy'] = $this->input->get('place_buy');
		$keyword['place_sale'] = $this->input->get('place_sale');
		$data['place_buy_name'] = $this->input->get('place_buy_name');
		$data['place_sale_name'] = $this->input->get('place_sale_name');
		$data['date_report_now'] = $keyword['date_import_from'] = $data['date_month'] . "/1";
		$keyword['date_import_to'] = $data['date_month'] . "/31";
		$keyword["check_price"] = "0";

		$data['data_check'] = $this->inventory_model->getListInforImport($keyword);
		// End Data

		$html = $this->load->view('templates/purchase/report/pdf_check_price', $data, true);

		// Set footer
		$htmlFooter = $this->load->view('templates/purchase/report/pdf_footer', $data, true);
		$pdf->SetHTMLFooter($htmlFooter);

		// write the HTML into the PDF
		$pdf->WriteHTML($html);
		$output = $title . '.pdf';

		$getPrint = $this->input->get('print');
		if ($getPrint === 'true') {
			$pdf->SetJS('this.print();');
		}
		if($data['data_check'] == null || count($data['data_check']) <= 0) {
            $pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
		$pdf->Output("$output", 'I');
	}

	public function pdf_checklist() {
		$this->load->library('mpdf');
		$mpdf = new mPDF('utf8', 'A3-L');
		$resource = array();
		$data['order_id'] = $this->input->get('order_id');
		$data['supplier_id'] = $this->input->get('supplier_id');
		$data['content_id'] = $this->input->get('content_id');
		$data['user_id'] = $this->input->get('user_id');
		$data['base_id'] = $this->input->get('stock_id');
		$data['order_date_start'] = $this->input->get('order_date_start');
		$data['order_date_end'] = $this->input->get('order_date_end');
		$data['sales_des_id'] = $this->input->get('sales_des_id');
		$data['status'] = $this->input->get('status');
		$data['is_import'] = $this->input->get('is_import');
		$data = $this->Buying->pdf_checklist($data);

		foreach ($data as $key => $value) {
			if (!isset($resource[$value['type']])) {
				$type_name = '発注処理';
				if ($value['type'] == 2) {
					$type_name = '入庫処理';
				}
				if ($value['type'] == 3) {
					$type_name = ' 出庫処理';
				}
				$resource[$value['type']]['name'] = $type_name;
				$resource[$value['type']]['detail'] = array();
			}
			$company_name = '';
			if ($value['type'] == 1 || $value['type'] == 2) {
				$company_name = $this->Supplier->getById($value['location'])[SUP_SUPPLIER_COMPANY_NAME];
			} else {
				$company_name = '';
			}
			$company = $value['location'];
			if ($value['type'] == 3) {
				$company = '-1';
			}
			if (!isset($resource[$value['type']]['detail'][$value['id']])) {
				$resource[$value['type']]['detail'][$value['id']]['date'] = $value['date'];
				$resource[$value['type']]['detail'][$value['id']]['processing_content'] = $value['processing_content'];
				$resource[$value['type']]['detail'][$value['id']]['user'] = $value['user'];
				$resource[$value['type']]['detail'][$value['id']]['detail'] = array();
			}
			if (!isset($resource[$value['type']]['detail'][$value['id']]['detail'][$company])) {
				$resource[$value['type']]['detail'][$value['id']]['detail'][$company]['name'] = $company_name;
				$resource[$value['type']]['detail'][$value['id']]['detail'][$company]['detail'] = array();
			}
			$item['product_id'] = $value['product_id'];
			$item['product_name'] = $value['product_name'];
			$item['note'] = $value['note'];
			$item['price'] = $value['price'];
			$item['quantity'] = $value['quantity'];
			$item['amount'] = $value['price'] * $value['quantity'];
			$item['product_note'] = $value['product_note'];
			array_push($resource[$value['type']]['detail'][$value['id']]['detail'][$company]['detail'], $item);
		}

		$mpdf->setAutoTopMargin = 'stretch';
		$result['lstMaster'] = $resource;
		$html = $this->load->view("templates/purchase/report/pdf_checklist", $result, true);
		//var_dump($html);
		$mpdf->SetTitle("チェックリスト");
		$mpdf->WriteHTML($html);

		$mpdf->Output("チェックリスト.pdf", "I");
		//var_dump($html);
	}

	public function checklist() {
		$data['title'] = "チェックリスト印刷";
		$data['content'] = 'purchase/report/pdf_checklist';
		$first_date = $this->input->get('first_date');
		$last_date = $this->input->get('last_date');
		$checklist_order = $this->Buying->checklist_order($first_date, $last_date);
		$pdf_html = $this->load->view('templates/purchase/report/pdf_checklist', $data, true);
		$pdf_header = $this->load->view('templates/purchase/report/pdf_checklist_header', null, true);
		$this->load->library('mpdf/mpdf.php');
		$this->mpdf->SetHTMLHeader($pdf_header);
		$this->mpdf->WriteHTML($pdf_html);
		$this->mpdf->Output();
	}

	public function sum() {
		$data['title'] = '出庫票新規作成画面';
		$data['content'] = 'purchase/sum_purchase';
		$this->load->view('templates/master', $data);
	}
	public function get_product_info() {
		$code = $this->input->get('code');
		$this->load->model('Buying');
		$data['name'] = $this->Buying->get_product_info($code);
		echo json_encode($data['name']);
	}

	public function get_product_code_list() {
		$this->load->model('Buying');
		$data['product_code'] = $this->Buying->get_product_code_list();
		echo json_encode($data['product_code']);
	}
	public function add_buying_order() {
		$val = $this->input->post("order_info");
		$this->load->model('Buying');
		$data_enc = json_encode($val);
		$data_dec = json_decode($data_enc);
		$buying_order = (json_decode($data_dec, true));
		$ref = $this->Buying->insert_order($buying_order);
		echo $ref;
	}
	public function add_buying_order_detail() {
		$buying_id = $this->input->post('id');
		$list = $this->input->post('product_list');
		$data_enc = json_encode($list);
		$data_dec = json_decode($data_enc);
		$products = json_decode($data_dec, true);
		$this->load->model('Buying_Detail');
		$this->Buying_Detail->insert_order($products);
	} //End function add_buying_order_detail
	public function update_buying_order() {
		$id = $this->input->post('id');
		$data = $this->input->post('data');
		$this->load->model('Buying');
		$res = $this->Buying->update_buying_order($id, $data);
		echo $res;
	}
	public function update_buying_order_detail() {
		$id = $this->input->post('id');
		$prod_list = $this->input->post('prod_list');
		$this->load->model('Buying');
		$prod_list1 = json_decode($prod_list, true);
		$id = $this->Buying->update_buying_order_detail($id, $prod_list1);
	}
	public function get_product_code() {
		$data = $this->input->get('data');
		$this->load->model('Buying');
		$prod = $this->Buying->get_produce_code($data);
		echo json_encode($prod);
	}
	public function get_product_detail() {
		$id = $this->input->post('data');
		$this->load->model('Buying');
		$prod = $this->Buying->get_product_detail($id);
		echo json_encode($prod);
	}
	public function get_product_price() {
		$prod_id = $this->input->post('prod_id');
		$sup_id = $this->input->post('sup_id');
		$this->load->model('Buying');
		$price = $this->Buying->get_product_price($prod_id, $sup_id);
		echo json_encode($price);
	}
	//__Print export delivery note
	/*

  */
	public function export_delivery_note() {
		/*$html = "";
			        $mpdf = new mPDF('utf8','A4');
			        $date_from = $this->input->get('date_from');
			        $date_to = $this->input->get('date_to');
			        $condition['date_from'] = $date_from;
			        $condition['date_to'] = $date_to;
			        $this->shipment_detail_model->setWhereClause($condition);
			        $data['shipment'] = $this->shipment_detail_model->getPdfByDate($date_from,$date_to);
			        $html = $this->load->view("templates/operation/pdf_produce_shipment",$data,true);
			        //var_dump($html);
			        $mpdf->SetTitle("納品集計表");
			        $mpdf->WriteHTML($html);
		*/
		//$html = "";

		$mpdf = new mPDF('utf8', 'A4');

		$order_id = $_GET['id'];
		$data['order_info'] = $this->Buying->export_delivery_note_destination($order_id);
		$data['list_of_product'] = $this->Buying->export_delivery_note_product($order_id);
		//var_dump($data);

		$html = $this->load->view("templates/purchase/pdf_delivery_note", $data, true);
		$mpdf->SetTitle("納品集計表");
		$mpdf->WriteHTML($html);
		$mpdf->Output("納品書.pdf", "I");

		//$mpdf->Output();
		/*
	        $html = $this->load->view("templates/purchase/pdf_delivery_note",$data,false);
	        $mpdf->SetTitle("納品集計表");
	        $mpdf->WriteHTML($html);
	        $mpdf->Output("納品書.pdf","D");
	        //echo 'abc';
*/

	}
	public function export_purchase_csv() {
		$data['page'] = $this->input->get('page');
		$data['order_id'] = $this->input->get('order_id');
		$data['supplier_id'] = $this->input->get('supplier_id');
		$data['content_id'] = $this->input->get('content_id');
		$data['user_id'] = $this->input->get('user_id');
		$data['base_id'] = $this->input->get('stock_id');
		$data['order_date_start'] = $this->input->get('order_date_start');
		$data['order_date_end'] = $this->input->get('order_date_end');
		$data['sales_des_id'] = $this->input->get('sales_des_id');
		$data['status'] = $this->input->get('status');
		$data['is_import'] = $this->input->get('is_import');
		$title = '発注伝票一覧';
		//$result = $this->Buying->get_order_information();
		$result = $this->Buying->get_order_information($data);
		//var_dump($result);
		$column_title = array(
			TO_ID,
			TO_ORDER_DETAIL,
			TO_VENDOR_ID,
			TO_EMPLOYEE_ID,
			TO_ORDER_DATE,
			TO_INVENTORY_LOCATION_ID,
			TO_BASE_CODE,
			TO_FORM,
			TO_RECEIPT,
			TO_AUTHORIZER,
			TO_DISCOUNT,
			TO_STREET_ADDRESS,
			TO_DELIVERY_DATE,
			TO_REMARKS,
			TO_SALES_DESTINATION,
			SUP_SUPPLIER_COMPANY_NAME, //Not undefined
		);
		$column_show_data = array(
			TO_ID,
			TO_ORDER_DETAIL,
			TO_VENDOR_ID,
			TO_EMPLOYEE_ID,
			TO_ORDER_DATE,
			TO_INVENTORY_LOCATION_ID,
			TO_BASE_CODE,
			TO_FORM,
			TO_RECEIPT,
			TO_AUTHORIZER,
			TO_DISCOUNT,
			TO_STREET_ADDRESS,
			TO_DELIVERY_DATE,
			TO_REMARKS,
			TO_SALES_DESTINATION,
			SUP_SUPPLIER_COMPANY_NAME, //Not undefined
		);
		$this->ImportExportCsv->export($title, $column_title, $column_show_data, $result);
	}
	public function export_warehouse_csv() {
		$title = '出庫伝票一覧';
		$data['order_no'] = $this->input->get('order_id');
		$data['distination_id'] = $this->input->get('distination_id');
		$data['content_id'] = $this->input->get('content_id');
		$data['export_date_start'] = $this->input->get('export_date_start');
		$data['issuer_id'] = $this->input->get('issuer_id');
		$data['shipper_id'] = $this->input->get('shipper_id');
		$data['status'] = $this->input->get('status');
		$result = $this->Warehouse->get_warehouse_information($data);
		$column_title = array(
			SHIP_ID,
			//SHIP_SHIPMENT_CONTENTS,
			PC_PROCESSING_CONTENT,
			SHIP_DISTRIBUTOR_ID,
			SHIP_EMPLOYEE_ID,
			SHIP_SHIP_DATE,
			//SHIP_BASE_CODE,
			SHIP_GO_TO,
			SHIP_REMARKS,
			SHIP_GOODS_RECEIPT_SLIP_ID,
			SHIP_SAVE_STATUS,
			TSD_DISTRIBUTOR_NAME,
			BM_BASE_NAME,
		);
		$column_show_data = array(
			SHIP_ID,
			PC_PROCESSING_CONTENT,
			SHIP_DISTRIBUTOR_ID,
			SHIP_EMPLOYEE_ID,
			SHIP_SHIP_DATE,
			//SHIP_BASE_CODE,
			SHIP_GO_TO,
			SHIP_REMARKS,
			SHIP_GOODS_RECEIPT_SLIP_ID,
			SHIP_SAVE_STATUS,
			TSD_DISTRIBUTOR_NAME,
			BM_BASE_NAME,
		);
		$this->ImportExportCsv->export($title, $column_title, $column_show_data, $result);
	}

}
