<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_Shipment_ProductController extends VV_Controller {
	
	// Construct function
	public function __construct()
    { 
        parent::__construct();
		$this->load->model('ProductShipmentSet','product_set_model');
		$this->load->model('ProductSetProductShipment','product_set_product_model');
		$this->load->model('ImportExportCsv');
	}

	public function index() {
		$data['title'] = $this->lang->line('ms_setting_shipment_product');
        $data['content'] ='masters/setting_shipment_product/index';
        $this->load->view('templates/master',$data);
    }
    
    // Add
	public function add() {
		$data['title'] = $this->lang->line('ms_add_setting_shipment_product');
        $data['content'] ='masters/setting_shipment_product/add';
        $this->load->view('templates/master',$data);
    }
    
    // Edit
	public function edit() {
		$data['title'] = $this->lang->line('ms_edit_setting_shipment_product');
		$id_set_product = $this->input->get("id");
		$where_set_product[PSS_PRODUCT_SET_CODE] = $id_set_product;
		$data['data_meta'] = $this->product_set_model->getWhere($where_set_product);
		$data['data_detail'] = $this->product_set_product_model->getByIdSetProduct($id_set_product);
        $data['content'] ='masters/setting_shipment_product/edit';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: get_list
	* @access public
	*/
	public function get_list(){
        
        $keyword['id'] = $this->input->get('input_search_id');
        $keyword['name'] = $this->input->get('input_search_name');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }
        else {
            $start_index = $start_index + 1;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->product_set_model->searchSetProduct($keyword,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
    }
    
    /**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$id_set_product = $this->input->post('id');
            $name = $this->input->post('name');
			$detail = $this->input->post('detail');

			try{
				$this->product_set_model->db->trans_begin();
				$this->product_set_product_model->db->trans_begin();

				$checkIsExits = $this->product_set_model->isExitsRow(PSS_PRODUCT_SET_CODE,$id_set_product );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta
				$arr_add[PSS_PRODUCT_SET_CODE] = $id_set_product;
				$arr_add[PSS_PRODUCT_SET_NAME] = $name;
				$this->product_set_model->add($arr_add);

				// Detail
				$resultProduct = count($detail);
				if($resultProduct > 0) {
					foreach ($detail as $key => $value) {
						$arr_add_set_product[PSPS_PRODUCT_SET_CODE] = $id_set_product;
						$arr_add_set_product[PSPS_PRODUCT_CODE] = $value["id"];
						$arr_add_set_product[PSPS_SERIAL_NUMBER] = $value["stt"];

						if($value["stt"] == "" || $value["stt"] == null) {
							$this->product_set_model->db->trans_rollback();
							$this->product_set_product_model->db->trans_rollback();
							echo json_encode(array(
								"success" => false,
								"message" => $this->lang->line("message_is_product_not_null_stt")
							));
							return;
						}

						$this->product_set_product_model->add($arr_add_set_product);
					}
				} else {
					$this->product_set_model->db->trans_rollback();
					$this->product_set_product_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_error_requeird_product")
					));
					return;
				}

				// End Query
				if ($this->product_set_model->db->trans_status() === FALSE || $this->product_set_product_model->db->trans_status() === FALSE)
				{
					$this->product_set_model->db->trans_rollback();
					$this->product_set_product_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					// LOG ADD
					logadd(PSS_PRODUCT_SET_CODE . ":".$id_set_product, PRODUCT_SET_SHIPMENT);

					$this->product_set_model->db->trans_commit();
					$this->product_set_product_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->product_set_model->db->trans_rollback();
				$this->product_set_product_model->db->trans_rollback();
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
            $name = $this->input->post('name');
			$detail = $this->input->post('detail');
			$id_set_product = $this->input->post('id');
			$data_log_edit["data_old"]=$this->product_set_model->getById($id_set_product);

			try{
				$this->product_set_model->db->trans_begin();
				$this->product_set_product_model->db->trans_begin();
				
				// Meta
                $arr_edit[PSS_PRODUCT_SET_NAME] = $name;
                $arr_where[PSS_PRODUCT_SET_CODE] = $id_set_product;
				$this->product_set_model->editByWhere($arr_where, $arr_edit);

				// Detail
				$resultProduct = count($detail);
				$arr_where_set_product[PSPS_PRODUCT_SET_CODE] = $id_set_product;
				$this->product_set_product_model->removeByWhere($arr_where_set_product);
				if($resultProduct > 0) {
					foreach ($detail as $key => $value) {
						$arr_add_set_product[PSPS_PRODUCT_SET_CODE] = $id_set_product;
						$arr_add_set_product[PSPS_PRODUCT_CODE] = $value["id"];
						$arr_add_set_product[PSPS_SERIAL_NUMBER] = $value["stt"];

						if($value["stt"] == "" || $value["stt"] == null) {
							$this->product_set_model->db->trans_rollback();
							$this->product_set_product_model->db->trans_rollback();
							echo json_encode(array(
								"success" => false,
								"message" => $this->lang->line("message_is_product_not_null_stt")
							));
							return;
						}

						$this->product_set_product_model->add($arr_add_set_product);
					}
				} else {
					$this->product_set_model->db->trans_rollback();
					$this->product_set_product_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_error_requeird_product")
					));
					return;
				}
				
				// End Query
				if ($this->product_set_model->db->trans_status() === FALSE || $this->product_set_product_model->db->trans_status() === FALSE)
				{
					$this->product_set_model->db->trans_rollback();
					$this->product_set_product_model->db->trans_rollback();
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
					logedit($data_log_edit, PRODUCT_SET_SHIPMENT);

					$this->product_set_model->db->trans_commit();
					$this->product_set_product_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->product_set_model->db->trans_rollback();
				$this->product_set_product_model->db->trans_rollback();
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
				$this->product_set_model->db->trans_begin();
				$this->product_set_product_model->db->trans_begin();

				// Meta
                $arr_where[PSS_PRODUCT_SET_CODE] = $id;
				$this->product_set_model->removeByWhere($arr_where);

				$where_dup_detail[PSPS_PRODUCT_SET_CODE] = $id;
				$this->product_set_product_model->removeByWhere($where_dup_detail);

				// End Query
				if ($this->product_set_model->db->trans_status() === FALSE || $this->product_set_product_model->db->trans_status() === FALSE)
				{
					$this->product_set_model->db->trans_rollback();
					$this->product_set_product_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					// LOG DELETE
					logdelete(PSS_PRODUCT_SET_CODE . ":".$id, PRODUCT_SET_SHIPMENT);
					$this->product_set_model->db->trans_commit();
					$this->product_set_product_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->product_set_model->db->trans_rollback();
				$this->product_set_product_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error")
				));
				return;
			}
		}
	}

	public function import(){
		$get_type_csv = $this->input->post('get_type_csv');
		$filename = $_FILES["import_file"]["tmp_name"];
		$target_file = $_FILES["import_file"]["name"];

        // Import Csv
        $is_import = false;
        $is_dup = false;
        $error_line = 0;
        $index = 0;
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
				$this->product_set_model->db->trans_begin();
				$this->product_set_product_model->db->trans_begin();
	
				foreach ($sheetData as $key => $value) {
					$item = array();
					$item[PSS_PRODUCT_SET_CODE] = (isset($value['A']) ? $value['A'] : null);
					
					if(!$this->product_set_model->checkDataNumber($item)){
						$error_line = $key+1;
						break;
					}
					
					$item[PSS_PRODUCT_SET_NAME] = (isset($value['B']) ? $value['B'] : null);

					$where_dup[PSS_PRODUCT_SET_CODE] = (isset($value['A']) ? $value['A'] : null);
					$this->product_set_model->removeByWhere($where_dup);					

					$result = $this->product_set_model->add($item);
					if ($this->product_set_model->db->trans_status() === FALSE){
						$error_line = $key+1;
						break;
					} else {
						$where_dup_detail[PSPS_PRODUCT_SET_CODE] = (isset($value['A']) ? $value['A'] : null);
						$this->product_set_product_model->removeByWhere($where_dup_detail);
					}
					$index = $key + 1;  						
				}
				
				if ($this->product_set_model->db->trans_status() === FALSE || $error_line != 0)
				{
					$this->product_set_model->db->trans_rollback();
					$this->product_set_product_model->db->trans_rollback();
					$is_import = false;
				}
				else 
				{
					$this->product_set_model->db->trans_commit();
					$this->product_set_product_model->db->trans_commit();
					$is_import = true;
				}
			} else if($get_type_csv == 2 || $get_type_csv == "2") {
				$this->product_set_product_model->db->trans_begin();
	
				foreach ($sheetData as $key => $value) {
					$item = array();
					$item_detail[PSPS_PRODUCT_SET_CODE] = (isset($value['A']) ? $value['A'] : null);
                    $item_detail[PSPS_PRODUCT_CODE] = $value["B"];
					$item_detail[PSPS_SERIAL_NUMBER] = $value["C"];
                    
                    $this->product_set_product_model->add($item_detail);
                    if ($this->product_set_product_model->db->trans_status() === FALSE){
                        $error_line = $index + $key+1;
                        break;
                    }			
				}
				
				if ($this->product_set_product_model->db->trans_status() === FALSE || $error_line != 0)
				{
	
					$this->product_set_product_model->db->trans_rollback();
					$is_import = false;
				}
				else
				{
						
					$this->product_set_product_model->db->trans_commit();
					$is_import = true;
				}
			}           

        }catch(Exception $ex){
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
            "message" => $this->lang->line("message_import_error") . " => ".$error_line." 行目のエラー"
        ));
        return; 
    }
    public function export(){
		$type = $this->input->get('type');

		if($type == 1 || $type == "1") {
			$title = $this->lang->line('ms_setting_shipment_product');
			$column_title = array(PSS_PRODUCT_SET_CODE,PSS_PRODUCT_SET_NAME);
			$column_show_data = array(PSS_PRODUCT_SET_CODE,PSS_PRODUCT_SET_NAME);
	
			$result = $this->product_set_model->getAll();

			$this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);
		} else if($type == 2 || $type == "2") {
			$title = PRODUCT_SET_PRODUCT_SHIPMENT;
			$column_title = array(PSPS_PRODUCT_SET_CODE,PSPS_PRODUCT_CODE,PSPS_SERIAL_NUMBER);
			$column_show_data = array(PSPS_PRODUCT_SET_CODE,PSPS_PRODUCT_CODE,PSPS_SERIAL_NUMBER);
	
			$result = $this->product_set_product_model->getAvaiable();

			$this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);
		}
    }
	
}
