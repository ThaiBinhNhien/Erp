<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MsShipmentController extends VV_Controller {
	
	// Construct function
	public function __construct()
    { 
        parent::__construct();
		$this->load->model('Shipment_Classification','shipment_classification_model');
		$this->load->model('Shipment_Classification_Customer','shipment_classification_customer_model');
		$this->load->model('Shipment_Classification_Base','shipment_classification_base_model');
		$this->load->model('Customer','customer_model');
		$this->load->model('CustomerShipmentModel', 'customer_shipment_model');
		$this->load->model('Base_master','base_model');
		$this->load->model('ImportExportCsv');
	} 
	
	public function index() {
		$data['title'] = $this->lang->line('ms_shipment');
        $data['content'] ='masters/shipment/index';
        $this->load->view('templates/master',$data);
	}
	public function edit_shipment() {
		$data['title'] = $this->lang->line('ms_edit_shipment');
        $data['content'] ='masters/shipment/edit_shipment';
        $this->load->view('templates/master',$data);
	}

	/**
    * Function: courier
    * @access public
    */
	public function courier(){
		$data['title'] = $this->lang->line('ms_courier');
        $data['content'] ='masters/shipment/courier';
        $this->load->view('templates/master',$data);
	}

	/**
    * Function: courier_add
    * @access public
    */
	public function courier_add(){
		$data['title'] = $this->lang->line('ms_courier_add');
		$data['list_base'] = $this->base_model->getAll();
        $data['list_customer'] = $this->customer_shipment_model->getAll();
        $data['content'] ='masters/shipment/courier_add';
        $this->load->view('templates/master',$data);
	}

	/**
    * Function: courier_edit
    * @access public
    */
	public function courier_edit(){
		$data['title'] = $this->lang->line('ms_courier_edit');
		$id_classification = $this->input->get('id');
		$where_classification[DC_ID] = $id_classification;
		$where_classification_customer[DCC_DELIVERY_CLASSIFICATION] = $id_classification;
		$where_classification_base[DB_DELIVERY_CLASSIFICATION] = $id_classification;
		$data['data_meta'] = $this->shipment_classification_model->getWhere($where_classification);
		$data['data_customer'] = $this->shipment_classification_customer_model->getWhere($where_classification_customer);
		$data['data_base'] = $this->shipment_classification_base_model->getWhere($where_classification_base);
		$data['list_base'] = $this->base_model->getAll();
        $data['list_customer'] = $this->customer_shipment_model->getAll();
        $data['content'] ='masters/shipment/courier_edit';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: get_shipment_classification
	* @access public
	*/
	public function get_shipment_classification(){
        
		$keyword["id"] = $this->input->get('id');
		$keyword["name"] = $this->input->get('name');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
		}
		
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->shipment_classification_model->searchClassification($keyword,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
	}
	
	 /**
    * Function: delete_shipment_classification
    * @access public
    */
    public function delete_shipment_classification(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
			try{
				$this->shipment_classification_model->db->trans_begin();
				
				$where_array[DC_ID] = $id;

				$this->shipment_classification_model->removeByWhere($where_array);

				// End Query
				if ($this->shipment_classification_model->db->trans_status() === FALSE)
				{
					$this->shipment_classification_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					logdelete(DC_ID . ":".$id, DELIVERY_CLASSIFICATION);
					$this->shipment_classification_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"have" => false,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->shipment_classification_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"have" => false,
					"message" => $this->lang->line("message_delete_error")
				));
				return;
			}
		}
	}

	/**
    * Function: courier_add_post
    * @access public
    */
    public function courier_add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$id = $this->input->post('id');
            $name = $this->input->post('name');
			$number_container = $this->input->post('number_container');
			$number_truck = $this->input->post('number_truck');
			$number_max_truck = $this->input->post('number_max_truck');
			$classification_base = $this->input->post('classification_base');
			$classification_customer = $this->input->post('classification_customer');

			try{
				$this->shipment_classification_model->db->trans_begin();
				$this->shipment_classification_customer_model->db->trans_begin();
				$this->shipment_classification_base_model->db->trans_begin();

				$checkIsExits = $this->shipment_classification_model->isExitsRow(DC_ID,$id );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}
				
				// Meta
				$price_meta[DC_ID] = $id;
				$price_meta[DC_NAME] = $name;
				$price_meta[DC_NUMBER_CONTAINER] = $number_container;
				$price_meta[DC_NUMBER_TRUCK] = $number_truck;
				$price_meta[DC_NUMBER_MAX_TRUCK] = $number_max_truck;

				$this->shipment_classification_model->add($price_meta);
				$id_classification = $id;

				// Detail : classification - customer
				$resultCustomer = count($classification_customer);
				if($classification_customer != "" && $resultCustomer > 0) {
					foreach ($classification_customer as $key => $value) {
						$price_meta_customer[DCC_DELIVERY_CLASSIFICATION] = $id_classification;
						$price_meta_customer[DCC_CUSTOMER_ID] = $value;

						$this->shipment_classification_customer_model->add($price_meta_customer);
					}
				}

				// Detail : classification - base
				$resultBase = count($classification_base);
				if($classification_base != "" && $resultBase > 0) {
					foreach ($classification_base as $key => $value) {
						$price_meta_base[DB_DELIVERY_CLASSIFICATION] = $id_classification;
						$price_meta_base[DB_BASE_CODE] = $value;

						$this->shipment_classification_base_model->add($price_meta_base);
					}
				}

				// End Query
				if ($this->shipment_classification_model->db->trans_status() === FALSE || $this->shipment_classification_customer_model->db->trans_status() === FALSE || $this->shipment_classification_base_model->db->trans_status() === FALSE)
				{
					$this->shipment_classification_model->db->trans_rollback();
					$this->shipment_classification_customer_model->db->trans_rollback();
					$this->shipment_classification_base_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					logadd(DC_ID . ":".$id, DELIVERY_CLASSIFICATION);

					$this->shipment_classification_model->db->trans_commit();
					$this->shipment_classification_customer_model->db->trans_commit();
					$this->shipment_classification_base_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"have" => false,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->shipment_classification_model->db->trans_rollback();
				$this->shipment_classification_customer_model->db->trans_rollback();
				$this->shipment_classification_base_model->db->trans_rollback();
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
    * Function: courier_edit_post
    * @access public
    */
    public function courier_edit_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$classification_id = $this->input->post('classification_id');
			$name = $this->input->post('name');
			$data_log_edit["data_old"]=$this->shipment_classification_model->getById($classification_id);
			$number_container = $this->input->post('number_container');
			$number_truck = $this->input->post('number_truck');
			$number_max_truck = $this->input->post('number_max_truck');
			$classification_base = $this->input->post('classification_base');
			$classification_customer = $this->input->post('classification_customer');

			try{
				$this->shipment_classification_model->db->trans_begin();
				$this->shipment_classification_customer_model->db->trans_begin();
				$this->shipment_classification_base_model->db->trans_begin();

				// Meta
				$price_meta[DC_NAME] = $name;
				$price_meta[DC_NUMBER_CONTAINER] = $number_container;
				$price_meta[DC_NUMBER_TRUCK] = $number_truck;
				$price_meta[DC_NUMBER_MAX_TRUCK] = $number_max_truck;

				$this->shipment_classification_model->edit($classification_id,$price_meta);

				// Detail : classification - customer
				$arrRemoveByWhere[DCC_DELIVERY_CLASSIFICATION] = $classification_id;
				$this->shipment_classification_customer_model->removeByWhere($arrRemoveByWhere);
				$resultCustomer = count($classification_customer);
				if($classification_customer != "" && $resultCustomer > 0) {
					foreach ($classification_customer as $key => $value) {
						$price_meta_customer[DCC_DELIVERY_CLASSIFICATION] = $classification_id;
						$price_meta_customer[DCC_CUSTOMER_ID] = $value;

						$this->shipment_classification_customer_model->add($price_meta_customer);
					}
				}

				// Detail : classification - base
				$arrRemoveByWhereBase[DB_DELIVERY_CLASSIFICATION] = $classification_id;
				$this->shipment_classification_base_model->removeByWhere($arrRemoveByWhereBase);
				$resultBase = count($classification_base);
				if($classification_base != "" && $resultBase > 0) {
					foreach ($classification_base as $key => $value) {
						$price_meta_base[DB_DELIVERY_CLASSIFICATION] = $classification_id;
						$price_meta_base[DB_BASE_CODE] = $value;

						$this->shipment_classification_base_model->add($price_meta_base);
					}
				}

				// End Query
				if ($this->shipment_classification_model->db->trans_status() === FALSE || $this->shipment_classification_customer_model->db->trans_status() === FALSE || $this->shipment_classification_base_model->db->trans_status() === FALSE)
				{
					$this->shipment_classification_model->db->trans_rollback();
					$this->shipment_classification_customer_model->db->trans_rollback();
					$this->shipment_classification_base_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_edit_error")
					));
					return;
				}
				else
				{
					// Log Edit
					$arr_where_edit[DC_ID] =  $classification_id;
					$data_log_edit["id"]=$arr_where_edit;
					$data_log_edit["data_new"]=$price_meta;
					logedit($data_log_edit, DELIVERY_CLASSIFICATION);

					$this->shipment_classification_model->db->trans_commit();
					$this->shipment_classification_customer_model->db->trans_commit();
					$this->shipment_classification_base_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"have" => false,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->shipment_classification_model->db->trans_rollback();
				$this->shipment_classification_customer_model->db->trans_rollback();
				$this->shipment_classification_base_model->db->trans_rollback();
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
		$type = $this->input->get('type');

		if($type == 1 || $type == "1") {
			$title = $this->lang->line('ms_courier');
			$column_title = array(DC_ID,DC_NAME,DC_NUMBER_CONTAINER,DC_NUMBER_TRUCK,DC_NUMBER_MAX_TRUCK);
			$column_show_data = array(DC_ID,DC_NAME,DC_NUMBER_CONTAINER,DC_NUMBER_TRUCK,DC_NUMBER_MAX_TRUCK);
	
			$result = $this->shipment_classification_model->getAll();

			$this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);
		} else if($type == 2 || $type == "2") {
			$title = DELIVERYCLASSIFICATION_CUSTOMER;
			$column_title = array(DCC_DELIVERY_CLASSIFICATION,DCC_CUSTOMER_ID);
			$column_show_data = array(DCC_DELIVERY_CLASSIFICATION,DCC_CUSTOMER_ID);
	
			$result = $this->shipment_classification_customer_model->getAvaiable();

			$this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);
		} else if($type == 3 || $type == "3") {
			$title = DELIVERY_BASE;
			$column_title = array(DB_DELIVERY_CLASSIFICATION,DB_BASE_CODE);
			$column_show_data = array(DB_DELIVERY_CLASSIFICATION,DB_BASE_CODE);
	
			$result = $this->shipment_classification_base_model->getAvaiable();

			$this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);
		}
 
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$get_type_csv = $this->input->post('get_type_csv');
		$filename = $_FILES["import_file"]["tmp_name"];
		$target_file = $_FILES["import_file"]["name"];

		// Import Csv
		$is_import = false;
		$index = 0;
		$error_line = 0;
		$sheetData = $this->ImportExportCsv->import($filename);
		if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
		}

		if($get_type_csv == 1 || $get_type_csv == "1") {

			$this->shipment_classification_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[DC_ID] = (isset($value['A']) ? $value['A'] : null);

				if(!$this->shipment_classification_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
				}
				
				$data[DC_NAME] = (isset($value['B']) ? $value['B'] : null);
				$data[DC_NUMBER_CONTAINER] = (isset($value['C']) ? $value['C'] : null);
				$data[DC_NUMBER_TRUCK] = (isset($value['D']) ? $value['D'] : null);
				$data[DC_NUMBER_MAX_TRUCK] = (isset($value['E']) ? $value['E'] : null);

				// Check exits
				$where_dup[DC_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->shipment_classification_model->removeByWhere($where_dup);

                $result = $this->shipment_classification_model->add($data);
                if ($this->shipment_classification_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
				$index = $key + 1;	
										
			}

			if ($this->shipment_classification_model->db->trans_status() === FALSE || $error_line != 0)
			{

				$this->shipment_classification_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
					
				$this->shipment_classification_model->db->trans_commit();
				$is_import = true;
			}   
		} else if($get_type_csv == 2 || $get_type_csv == "2") {

			$this->shipment_classification_customer_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$item_detail = array();
				$item_detail[DCC_DELIVERY_CLASSIFICATION] = (isset($value['A']) ? $value['A'] : null);
				$item_detail[DCC_CUSTOMER_ID] = (isset($value['B']) ? $value['B'] : null);

				$where_dup_detail[DCC_DELIVERY_CLASSIFICATION] = (isset($value['A']) ? $value['A'] : null);
				$where_dup_detail[DCC_CUSTOMER_ID] = (isset($value['B']) ? $value['B'] : null);
				$this->shipment_classification_customer_model->removeByWhere($where_dup_detail);
				
				$this->shipment_classification_customer_model->add($item_detail);
				$index +=  $key+1;
				if ($this->shipment_classification_customer_model->db->trans_status() === FALSE){
					
					$error_line = $index;
					break;
				} 	
										
			}

			if ($this->shipment_classification_customer_model->db->trans_status() === FALSE || $error_line != 0)
			{

				$this->shipment_classification_customer_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
					
				$this->shipment_classification_customer_model->db->trans_commit();
				$is_import = true;
			}
		} else if($get_type_csv == 3 || $get_type_csv == "3") {

			$this->shipment_classification_base_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$item_detail = array();
				$item_detail[DB_DELIVERY_CLASSIFICATION] = (isset($value['A']) ? $value['A'] : null);
				$item_detail[DB_BASE_CODE] = (isset($value['B']) ? $value['B'] : null);

				$where_dup_detail2[DB_DELIVERY_CLASSIFICATION] = (isset($value['A']) ? $value['A'] : null);
				$where_dup_detail2[DB_BASE_CODE] = (isset($value['B']) ? $value['B'] : null);
				$this->shipment_classification_base_model->removeByWhere($where_dup_detail2);
				
				$this->shipment_classification_base_model->add($item_detail);
				$index +=  $key+1;
				if ($this->shipment_classification_base_model->db->trans_status() === FALSE){
					
					$error_line = $index;
					break;
				}	
										
			}

			if ($this->shipment_classification_base_model->db->trans_status() === FALSE || $error_line != 0)
			{

				$this->shipment_classification_base_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
					
				$this->shipment_classification_base_model->db->trans_commit();
				$is_import = true;
			}

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
			"message" => $this->lang->line("message_import_error")
		));
		return; 
    }
	
}
