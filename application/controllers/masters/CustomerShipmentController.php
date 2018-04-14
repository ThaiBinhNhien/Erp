<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerShipmentController extends VV_Controller {
    
    // Construct function
	public function __construct()
    { 
		parent::__construct();
        $this->load->model('CustomerShipmentModel', 'customer_shipment_model');
        $this->load->model('CustomerShipment_Customer', 'customer_shipment_customer');
		$this->load->model('Customer','customer_model');
		$this->load->model('DepartmentShipment','department_shipment_model');
		$this->load->model('CustomerDepartmentShipment','customer_department_shipment_model');
		$this->load->model('ImportExportCsv');
    } 

    /**
	* Function: index
	* @access public
	*/
	public function index() {
        $data['title'] = $this->lang->line('ms_customer_shipment');
        $data['titleEdit'] = $this->lang->line('ms_customer_shipment_edit');
        $data['list_customer'] = $this->customer_model->getAll();
        $data['content'] ='masters/customer_shipment/index';
        $this->load->view('templates/master',$data);
    }
    
    /**
	* Function: get_list
	* @access public
	*/
	public function get_list(){
        
		$keyword["id"] = $this->input->get('id');
		$keyword["name"] = $this->input->get('name');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->customer_shipment_model->searchByKey($keyword,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
	}

	/**
    * Function: view edit
    * @access public
    */
	public function edit_customer() {
		$data['title'] = $this->lang->line('ms_customer_shipment');
        $id = $this->input->get("id");
		$data['customer'] = $this->customer_shipment_model->getById($id);
		$data['id_customer'] = $this->customer_shipment_model->getCustomerByCustomerM($id);
        if($data['customer'] == NULL){
            redirect( base_url('master/customer_shipment'), 'refresh');
            exit();
        }
		$data['lstDepartment'] = $this->department_shipment_model->getAll();
		$data['list_customer'] = $this->customer_model->getAll();
        $data['department'] = $this->customer_department_shipment_model->getByCustomer($data['customer'][CSHIPMENT_ID]);
        $data['content'] ='masters/customer_shipment/edit_customer';
        $this->load->view('templates/master',$data);
	}

	/**
    * Function: view create
    * @access public
    */
	public function create_customer() {
        $data['title'] = $this->lang->line('ms_customer_shipment');
		$data['lstDepartment'] = $this->department_shipment_model->getAll();
		$data['list_customer'] = $this->customer_model->getAll();
        $data['content'] ='masters/customer_shipment/create_customer';
        $this->load->view('templates/master',$data);
    }

    /**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
            $name = $this->input->post('name');
			$customer = $this->input->post('customer');
			$department = $this->input->post('department');

			try{
                $this->customer_shipment_model->db->trans_begin();
				$this->customer_shipment_customer->db->trans_begin();
				$this->customer_department_shipment_model->db->trans_begin();

				// Check exits for id
				$checkIsExits = $this->customer_shipment_model->isExitsRow(CSHIPMENT_ID,$id );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta T_EVENT
				$arr_add[CSHIPMENT_ID] = $id;
                $arr_add[CSHIPMENT_NAME] = $name;
                $this->customer_shipment_model->add($arr_add);
                
				// Detail
				$resultCustomer = count($customer);
				$arr_where_customer[CCS_CUSTOMER_SHIPMENT] = $id;
				$this->customer_shipment_customer->removeByWhere($arr_where_customer);
				if($resultCustomer > 0) {
					foreach ($customer as $key => $value) {
						$arr_add_customer = [];
						$arr_add_customer[CCS_CUSTOMER_SHIPMENT] = $id;
						$arr_add_customer[CCS_CUSTOMER] = $value;

						$this->customer_shipment_customer->add($arr_add_customer);
					}
				} else {
					$this->customer_shipment_model->db->trans_rollback();
					$this->customer_shipment_customer->db->trans_rollback();
					$this->customer_department_shipment_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}

				// Detail
				$resultDepartment = count($department);
				$arr_where_department[CDS_CUSTOMER_ID] = $id;
				$this->customer_department_shipment_model->removeByWhere($arr_where_department);
				if($resultDepartment > 0) {
					foreach ($department as $key => $value) {
						$arr_add_department[CDS_CUSTOMER_ID] = $id;
						$arr_add_department[CDS_DEPARTMENT_CODE] = $value;

						$this->customer_department_shipment_model->add($arr_add_department);
					}
				} else {
					$this->customer_shipment_model->db->trans_rollback();
					$this->customer_shipment_customer->db->trans_rollback();
					$this->customer_department_shipment_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}

				// End Query
				if ($this->customer_shipment_model->db->trans_status() === FALSE || $this->customer_shipment_customer->db->trans_status() === FALSE || $this->customer_department_shipment_model->db->trans_status() === FALSE)
				{
                    $this->customer_shipment_model->db->trans_rollback();
					$this->customer_shipment_customer->db->trans_rollback();
					$this->customer_department_shipment_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					// LOG ADD
					logadd(CSHIPMENT_ID . ":".$id, CUSTOMER_SHIPMENT);

                    $this->customer_shipment_model->db->trans_commit();
					$this->customer_shipment_customer->db->trans_commit();
					$this->customer_department_shipment_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
                $this->customer_shipment_model->db->trans_rollback();
				$this->customer_shipment_customer->db->trans_rollback();
				$this->customer_department_shipment_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_add_error")
				));
				return;
			}
		}
    }
    
    /**
    * Function: edit_post
    * @access public
    */
    public function edit_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$id_edit = $this->input->post('id');
            $name = $this->input->post('name');
			$customer = $this->input->post('customer');
			$department = $this->input->post('department');
			$data_log_edit["data_old"]=$this->customer_shipment_model->getById($id_edit);

			try{
                $this->customer_shipment_model->db->trans_begin();
                $this->customer_shipment_customer->db->trans_begin();
				$this->customer_department_shipment_model->db->trans_begin();

				// Meta
                $arr_edit[CSHIPMENT_NAME] = $name;
                $arr_where[CSHIPMENT_ID] = $id_edit;
                $this->customer_shipment_model->editByWhere($arr_where, $arr_edit);
                
				// Detail
				$resultCustomer = count($customer);
				$arr_where_customer[CCS_CUSTOMER_SHIPMENT] = $id_edit;
				$this->customer_shipment_customer->removeByWhere($arr_where_customer);
				if($resultCustomer > 0) {
					foreach ($customer as $key => $value) {
						$arr_add_customer = [];
						$arr_add_customer[CCS_CUSTOMER_SHIPMENT] = $id_edit;
						$arr_add_customer[CCS_CUSTOMER] = $value;

						$this->customer_shipment_customer->add($arr_add_customer);
					}
				} else {
					$this->customer_shipment_model->db->trans_rollback();
					$this->customer_shipment_customer->db->trans_rollback();
					$this->customer_department_shipment_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_edit_error")
					));
					return;
				}

				// Detail
				$resultDepartment = count($department);
				$arr_where_department[CDS_CUSTOMER_ID] = $id_edit;
				$this->customer_department_shipment_model->removeByWhere($arr_where_department);
				if($resultDepartment > 0) {
					foreach ($department as $key => $value) {
						$arr_add_department[CDS_CUSTOMER_ID] = $id_edit;
						$arr_add_department[CDS_DEPARTMENT_CODE] = $value;

						$this->customer_department_shipment_model->add($arr_add_department);
					}
				} else {
					$this->customer_shipment_model->db->trans_rollback();
					$this->customer_shipment_customer->db->trans_rollback();
					$this->customer_department_shipment_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_edit_error")
					));
					return;
				}

				// End Query
				if ($this->customer_shipment_model->db->trans_status() === FALSE || $this->customer_shipment_customer->db->trans_status() === FALSE || $this->customer_department_shipment_model->db->trans_status() === FALSE)
				{
                    $this->customer_shipment_model->db->trans_rollback();
					$this->customer_shipment_customer->db->trans_rollback();
					$this->customer_department_shipment_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_edit_error")
					));
					return;
				}
				else
				{
					// Log Edit
					$data_log_edit["id"]=$arr_where;
					$data_log_edit["data_new"]=$arr_edit;
					logedit($data_log_edit, CUSTOMER_SHIPMENT);

                    $this->customer_shipment_model->db->trans_commit();
					$this->customer_shipment_customer->db->trans_commit();
					$this->customer_department_shipment_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
                $this->customer_shipment_model->db->trans_rollback();
				$this->customer_shipment_customer->db->trans_rollback();
				$this->customer_department_shipment_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_edit_error")
				));
				return;
			}
		}
	}
	
	/**
    * Function: delete_post
    * @access public
    */
    public function delete_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');

			try{
                $this->customer_shipment_model->db->trans_begin();
                $this->customer_shipment_customer->db->trans_begin();

				// Meta
                $arr_where[CSHIPMENT_ID] = $id;
				$this->customer_shipment_model->removeByWhere($arr_where);
                
                // Detail
                $arr_where_detail[CCS_CUSTOMER_SHIPMENT] = $id;
                $this->customer_shipment_customer->removeByWhere($arr_where_detail);

				// End Query
				if ($this->customer_shipment_model->db->trans_status() === FALSE || $this->customer_shipment_customer->db->trans_status() === FALSE)
				{
                    $this->customer_shipment_model->db->trans_rollback();
                    $this->customer_shipment_customer->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					// LOG DELETE
					logdelete(CSHIPMENT_ID . ":".$id, CUSTOMER_SHIPMENT);

                    $this->customer_shipment_model->db->trans_commit();
                    $this->customer_shipment_customer->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
                $this->customer_shipment_model->db->trans_rollback();
                $this->customer_shipment_customer->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error")
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
			$title = $this->lang->line('ms_customer_shipment');
			$column_title = array(CSHIPMENT_ID,CSHIPMENT_NAME);
			$column_show_data = array(CSHIPMENT_ID,CSHIPMENT_NAME);
	
			$result = $this->customer_shipment_model->getAll();

			$this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);
		} else if($type == 2 || $type == "2") {
			$title = CUSTOMER_CUSTOMERSHIPMENT;
			$column_title = array(CCS_CUSTOMER_SHIPMENT,CCS_CUSTOMER);
			$column_show_data = array(CCS_CUSTOMER_SHIPMENT,CCS_CUSTOMER);
	
			$result = $this->customer_shipment_customer->getAll();

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
		$is_dup = false;
		$error_line = 0;
		$sheetData = $this->ImportExportCsv->import($filename);
		if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
        }
		try{
			if($get_type_csv == 1 || $get_type_csv == "1") {
				$this->customer_shipment_model->db->trans_begin();

				foreach ($sheetData as $key => $value) {
					$data = array();
					$data[CSHIPMENT_ID] = (isset($value['A']) ? $value['A'] : null);

					if(!$this->customer_shipment_model->checkDataNumber($data)){
						$error_line = $key+1;
						break;
					}
					
					$data[CSHIPMENT_NAME] = (isset($value['B']) ? $value['B'] : null);

					$where_dup[CSHIPMENT_ID] = (isset($value['A']) ? $value['A'] : null);
					$this->customer_shipment_model->removeByWhere($where_dup);

					$result = $this->customer_shipment_model->add($data);
					if ($this->customer_shipment_model->db->trans_status() === FALSE){
						$error_line = $key+1;
						break;
					} 
											
				}
				if ($this->customer_shipment_model->db->trans_status() === FALSE || $error_line != 0)
				{
					$this->customer_shipment_model->db->trans_rollback();
					$is_import = false;
				}
				else
				{
					logupcsv($target_file . " (".count($sheetData)." records)", CUSTOMER_SHIPMENT);
					$this->customer_shipment_model->db->trans_commit();
					$is_import = true;
				}
			} else if($get_type_csv == 2 || $get_type_csv == "2") {
				$this->customer_shipment_customer->db->trans_begin();

				foreach ($sheetData as $key => $value) {
					$data = array();
					$data[CCS_CUSTOMER_SHIPMENT] = (isset($value['A']) ? $value['A'] : null);
					$data[CCS_CUSTOMER] = (isset($value['B']) ? $value['B'] : null);

					if(!$this->customer_shipment_customer->checkDataNumber($data)){
						$error_line = $key+1;
						break;
					}

					$where_dup[CCS_CUSTOMER_SHIPMENT] = (isset($value['A']) ? $value['A'] : null);
					$where_dup[CCS_CUSTOMER] = (isset($value['B']) ? $value['B'] : null);
					$this->customer_shipment_customer->removeByWhere($where_dup);

					$result = $this->customer_shipment_customer->add($data);
					if ($this->customer_shipment_customer->db->trans_status() === FALSE){
						$error_line = $key+1;
						break;
					} 
											
				}
				if ($this->customer_shipment_customer->db->trans_status() === FALSE || $error_line != 0)
				{
					$this->customer_shipment_customer->db->trans_rollback();
					$is_import = false;
				}
				else
				{
					logupcsv($target_file . " (".count($sheetData)." records)", CUSTOMER_CUSTOMERSHIPMENT);
					$this->customer_shipment_customer->db->trans_commit();
					$is_import = true;
				}
			}           

		}catch(Exception $ex){
			$this->customer_shipment_model->db->trans_rollback();
			$this->customer_shipment_customer->db->trans_rollback();
			echo json_encode(array(
				"success" => false,
				"message" => $this->lang->line("message_import_error")
			));
			return;
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
			"message" => $this->lang->line("message_import_error"). " => ".$error_line." 行目のエラー"
		));
		return;
    }

	
}
