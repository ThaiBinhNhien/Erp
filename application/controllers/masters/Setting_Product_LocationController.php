<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_Product_LocationController extends VV_Controller {
	
	// Construct function
	public function __construct()
    { 
        parent::__construct();
		$this->load->model('Customer','customer_model');
		$this->load->model('Base_master','base_model');
		$this->load->model('ProductSet','product_set_model');
		$this->load->model('ProductSetBaseCustomer','product_set_customer_model');
		$this->load->model('ImportExportCsv');
	}

	public function index() {
		$data['title'] = $this->lang->line('ms_setting_product_location_customer');
		$data['set_product'] = $this->product_set_model->getAll();
		$data['list_base'] = $this->base_model->getAll();
        $data['list_customer'] = $this->customer_model->getAll();
        $data['content'] ='masters/setting_product_location/index';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: load_customer_by_set_product_base
	* @access public
	*/
	public function load_customer_by_set_product_base(){
		$customer_code = $this->input->get('customer_code');
        $base_code = $this->input->get('base_code');
		$result = $this->product_set_customer_model->getSetProductBaseCustomer($base_code,null,$customer_code);
        echo json_encode($result);
	}

	/**
    * Function: add_post 
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$base_code = $this->input->post('base_code');
			$customer_code = $this->input->post('customer_code');
			$set_product = $this->input->post('set_product');

			try{
				$this->product_set_customer_model->db->trans_begin();

				// Detail
				
				$resultCustomer = count($set_product);
				if($set_product != "" && $resultCustomer > 0) {
					// Delete
					$where_remove[PSC_BASE_CODE] = $base_code;
					$where_remove[PSC_CUSTOMER_ID] = $customer_code;

					$this->product_set_customer_model->removeByWhere($where_remove);

					if($set_product != null && $set_product != "") {

						foreach ($set_product as $key => $value) {
							$meta_customer[PSC_BASE_CODE] = $base_code;
							$meta_customer[PSC_CUSTOMER_ID] = $customer_code;
							$meta_customer[PSC_PRODUCT_SET_CODE] = $value;

							$this->product_set_customer_model->add($meta_customer);
						}
					}
				}else {
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => "商品セットは必須です。ご入力ください。"
					));
					return;
				}

				// End Query
				if ($this->product_set_customer_model->db->trans_status() === FALSE)
				{
					$this->product_set_customer_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_edit_error")
					));
					return;
				}
				else
				{
					$this->product_set_customer_model->db->trans_commit();
					logadd(PSC_BASE_CODE . ":".$base_code .",". PSC_CUSTOMER_ID . ":".$customer_code, PRODUCT_SET_CUSTOMER);
					echo json_encode(array(
						"success" => true,
						"have" => false,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->product_set_customer_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"have" => false,
					"message" => $this->lang->line("message_edit_error")
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
		$title = $this->lang->line('ms_setting_product_location_customer');

		// Data
		$result = $this->product_set_customer_model->getAll(); 
		
		// Column name 
		$column_title = array(PSC_BASE_CODE,PSC_CUSTOMER_ID,PSC_PRODUCT_SET_CODE);
		$column_show_data = array(PSC_BASE_CODE,PSC_CUSTOMER_ID,PSC_PRODUCT_SET_CODE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('ms_setting_product_location_customer');
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
			$this->product_set_customer_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[PSC_BASE_CODE] = (isset($value['A']) ? $value['A'] : null);
				$data[PSC_CUSTOMER_ID] = (isset($value['B']) ? $value['B'] : null);
				$data[PSC_PRODUCT_SET_CODE] = (isset($value['C']) ? $value['C'] : null);

				if(!$this->product_set_customer_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }

				// Xóa trùng
				$where_dup[PSC_BASE_CODE] = (isset($value['A']) ? $value['A'] : null);
				$where_dup[PSC_CUSTOMER_ID] = (isset($value['B']) ? $value['B'] : null);
				$where_dup[PSC_PRODUCT_SET_CODE] = (isset($value['C']) ? $value['C'] : null);
				$this->product_set_customer_model->removeByWhere($where_dup);

				$result = $this->product_set_customer_model->add($data);

				if ($this->product_set_customer_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                }  
										
			}
			if ($this->product_set_customer_model->db->trans_status() === FALSE || $error_line != 0)
			{
				$this->product_set_customer_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				$this->product_set_customer_model->db->trans_commit();
				logupcsv($target_file . " (".count($sheetData)." records)", PRODUCT_SET_CUSTOMER);
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->product_set_customer_model->db->trans_rollback();
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
