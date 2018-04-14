<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_Product_CustomerController extends VV_Controller {
	
	// Construct function
	public function __construct() 
    { 
        parent::__construct();
		$this->load->model('Customer','customer_model'); 
		$this->load->model('CustomerShipmentModel','customer_shipment_model');
		$this->load->model('Base_master','base_model');
		$this->load->model('ProductSet','product_set_model');
		$this->load->model('ProductShipmentSet','product_set_shipment_model');
		$this->load->model('ProductSetCustomerShipment','product_set_customer_shipment_model'); 
		$this->load->model('ImportExportCsv');
	}
	
	public function index() {
		$data['title'] = $this->lang->line('ms_setting_product_customer');
		$data['set_product'] = $this->product_set_shipment_model->getAll();
        $data['list_customer'] = $this->customer_shipment_model->getAll();
        $data['content'] ='masters/setting_product_customer/index';
        $this->load->view('templates/master',$data);
	}
	
	/**
	* Function: load_set_product_by_customer
	* @access public
	*/
	public function load_set_product_by_customer(){
        $customer_code = $this->input->get('customer_code');
		$result = $this->product_set_customer_shipment_model->getSetProductCustomer(null,$customer_code);
        echo json_encode($result);
	}

	/**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $customer_code = $this->input->post('customer_code');
			$set_product = $this->input->post('set_product');

			try{
				$this->product_set_customer_shipment_model->db->trans_begin();

				// Detail
				
				$resultCustomer = count($set_product);
				if($set_product != "" && $resultCustomer > 0) {
					// Delete
					$where_remove[CP_CUSTOMER] = $customer_code;

					$this->product_set_customer_shipment_model->removeByWhere($where_remove);

					if($set_product != null && $set_product != "") {

						foreach ($set_product as $key => $value) {
							$meta_customer[CP_CUSTOMER] = $customer_code;
							$meta_customer[CP_PRODUCT_SET] = $value;

							$this->product_set_customer_shipment_model->add($meta_customer);
						}
					}
				} else {
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => "商品セットは必須です。ご入力ください。"
					));
					return;
				}

				// End Query
				if ($this->product_set_customer_shipment_model->db->trans_status() === FALSE)
				{
					$this->product_set_customer_shipment_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					$this->product_set_customer_shipment_model->db->trans_commit();
					logadd(CP_CUSTOMER . ":".$customer_code, CUSTOMER_PRODUCTSET);
					echo json_encode(array(
						"success" => true,
						"have" => false,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->product_set_customer_shipment_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"have" => false,
					"message" => $this->lang->line("message_add_error")
				));
				return;
			}
		}
	}

	/**
    * Function: export
    * @access public
    */
	public function export(){
		$title = $this->lang->line('ms_setting_product_customer');

		// Data
		$result = $this->product_set_customer_shipment_model->getAll(); 
		
		// Column name
		$column_title = array(CP_CUSTOMER,CP_PRODUCT_SET);
		$column_show_data = array(CP_CUSTOMER,CP_PRODUCT_SET);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('ms_setting_product_customer');
		$filename = $_FILES["import_file"]["tmp_name"];
		$target_file = $_FILES["import_file"]["name"];

		// Import Csv
		$is_import = false;
		$sheetData = $this->ImportExportCsv->import($filename);
		if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
		}
		
		$error_line = 0;
		try{
			$this->product_set_customer_shipment_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[CP_CUSTOMER] = (isset($value['A']) ? $value['A'] : null);
				$data[CP_PRODUCT_SET] = (isset($value['B']) ? $value['B'] : null);

				if(!$this->product_set_customer_shipment_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }

				// Xóa trùng
				$where_dup[CP_CUSTOMER] = (isset($value['A']) ? $value['A'] : null);
				$where_dup[CP_PRODUCT_SET] = (isset($value['B']) ? $value['B'] : null);
				$this->product_set_customer_shipment_model->removeByWhere($where_dup);

				$result = $this->product_set_customer_shipment_model->add($data);

				if ($this->product_set_customer_shipment_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                }  
										
			}
			if ($this->product_set_customer_shipment_model->db->trans_status() === FALSE || $error_line != 0)
			{
				$this->product_set_customer_shipment_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				$this->product_set_customer_shipment_model->db->trans_commit();
				logupcsv($target_file . " (".count($sheetData)." records)", PRODUCT_SET_CUSTOMER);
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->product_set_customer_shipment_model->db->trans_rollback();
			$is_import = false;
		}

		if($is_import == true) {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_import_success")
			));
			return;
		}
		echo json_encode(array(
			"success" => false,
			"message" => $this->lang->line("message_import_error") . " => ".$error_line." 行目のエラー"
		));
		return;
    }
	
}
