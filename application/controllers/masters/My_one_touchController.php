<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My_One_TouchController extends VV_Controller {
	
	// Construct function
	public function __construct()
    { 
        parent::__construct();
		$this->load->model('My_One_Touch','my_one_touch_model');
		$this->load->model('My_one_touch_detail','my_one_touch_detail_model');
		$this->load->model('Product','product_model');
		$this->load->model('Customer','customer_model');
		$this->load->model('CustomerShipmentModel','customer_shipment_model');
		$this->load->model('Base_master','base_model');
		$this->load->model('Department','department_model');
		$this->load->model('DepartmentShipment','department_shipment_model');
		$this->load->model('Shipment_Classification', 'classification_model');
		$this->load->model('User', 'user_model');
		$this->load->model('ImportExportCsv');
	} 

	public function index() {
		$data['title'] = $this->lang->line('ms_my_one_touch');
        $data['content'] ='masters/my_one_touch/index';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: add
	* @access public
	*/
	public function add() {
		$data['title'] = $this->lang->line('ms_add_my_one_touch');

		// Data
		$data['list_customer'] = $this->customer_shipment_model->getAll(); 
		$data['list_classification'] = $this->classification_model->getAll();
		$data['list_user'] = $this->user_model->getAll();
		
        $data['content'] ='masters/my_one_touch/add';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: edit
	* @access public
	*/
	public function edit() {
		$data['title'] = $this->lang->line('ms_edit_my_one_touch');

		// Data
		$id_my_one_touch = $this->input->get("id");
		$user_my_one_touch = $this->input->get("user");
		$arr_where[MOT_ID] = $id_my_one_touch;
		$arr_where[MOT_USER_ID] = $user_my_one_touch;
		$data['data_meta'] = $this->my_one_touch_model->getWhere($arr_where);
		$data['data_detail'] = $this->my_one_touch_detail_model->getWhereDetail($id_my_one_touch,$user_my_one_touch);
		$data['list_customer'] = $this->customer_shipment_model->getAll();
		$data['list_classification'] = $this->classification_model->getAll();
		$data['list_user'] = $this->user_model->getAll();
		
        $data['content'] ='masters/my_one_touch/edit';
        $this->load->view('templates/master',$data);
	}
	
	/**
	* Function: get_list
	* @access public
	*/
	public function get_list(){
        $keyword = $this->input->get('input_search');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->my_one_touch_model->getListSearch($keyword,$start_index);
		}
		
        echo json_encode($result);
	}

	/**
    * Function: delete_post
    * @access public
    */
    public function delete_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');

			try{
				$this->my_one_touch_model->db->trans_begin();
				$this->my_one_touch_detail_model->db->trans_begin();

				// Meta
                $arr_where[MOT_ID] = $id;
				$this->my_one_touch_model->removeByWhere($arr_where);

				$arr_where_detail[MOTD_MOT_ID] = $id;
				$this->my_one_touch_detail_model->removeByWhere($arr_where_detail);

				// End Query
				if ($this->my_one_touch_model->db->trans_status() === FALSE || $this->my_one_touch_detail_model->db->trans_status() === FALSE)
				{
					$this->my_one_touch_model->db->trans_rollback();
					$this->my_one_touch_detail_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					$this->my_one_touch_model->db->trans_commit();
					$this->my_one_touch_detail_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->my_one_touch_model->db->trans_rollback();
				$this->my_one_touch_detail_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error")
				));
				return;
			}
		}
	}

	/**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$form_id = $this->input->post('form_id');
            $form_name = $this->input->post('form_name');
			$classification = $this->input->post('classification');
			$username = $this->input->post('username');
			$detail = $this->input->post('detail');

			try{
				$this->my_one_touch_model->db->trans_begin();
				$this->my_one_touch_detail_model->db->trans_begin();

				/*$checkIsExits = $this->my_one_touch_model->isExitsRow(MOT_ID,$form_id );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}*/

				// Remove
				$where_remove_meta[MOT_ID] = $form_id;
				$where_remove_meta[MOT_USER_ID] = $username;

				$this->my_one_touch_model->removeByWhere($where_remove_meta);

				// ADD
				$meta_classification[MOT_ID] = $form_id;
				$meta_classification[MOT_USER_ID] = $username;
				$meta_classification[MOT_NAME] = $form_name;
				$meta_classification[MOT_DELIVERY_CLASSIFICATION] = $classification;

				$this->my_one_touch_model->add($meta_classification);
				$id_my_one_touch = $form_id;

				// Detail
				$resultDetail = count($detail);
				if($resultDetail > 0) {
					// Delete
					$where_remove[MOTD_MOT_ID] = $id_my_one_touch;
					$where_remove[MOTD_USER_ID] = $username;

					$this->my_one_touch_detail_model->removeByWhere($where_remove);

					if($detail != null && $detail != "") {
						foreach ($detail as $key => $value) {
							$meta_detail[MOTD_MOT_ID] = $id_my_one_touch;
							$meta_detail[MOTD_USER_ID] = $username;
							$meta_detail[MOTD_CUSTOMER_ID] = $value["customer"];
							$meta_detail[MOTD_DEPARTMENT_ID] = $value["department"];
							$meta_detail[MOTD_PRODUCT_CODE] = $value["product"];
							$meta_detail[MOTD_QUANTITY] = $value["quantity"];
							$meta_detail[MOTD_CONTAINER1] = $value["container"];
							$meta_detail[MOTD_CONTAINER2] = $value["container2"];
							$meta_detail[MOTD_COMMENT] = $value["comment"];

							$this->my_one_touch_detail_model->add($meta_detail);
						}
					}
				} else {
					$this->my_one_touch_model->db->trans_rollback();
					$this->my_one_touch_detail_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_error_requeird_product")
					));
					return;
				}

				// End Query
				if ($this->my_one_touch_model->db->trans_status() === FALSE || $this->my_one_touch_detail_model->db->trans_status() === FALSE)
				{
					$this->my_one_touch_model->db->trans_rollback();
					$this->my_one_touch_detail_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					$this->my_one_touch_model->db->trans_commit();
					$this->my_one_touch_detail_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"have" => false,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}
				

			}catch(Exception $ex){
				$this->my_one_touch_model->db->trans_rollback();
				$this->my_one_touch_detail_model->db->trans_rollback();
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
    * Function: edit_post
    * @access public
    */
    public function edit_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$id_my_one_touch = $this->input->post('id_my_one_touch');
            $form_name = $this->input->post('form_name');
			$classification = $this->input->post('classification');
			$username = $this->input->post('username');
			$detail = $this->input->post('detail');
			$form_id = $id_my_one_touch;

			try{
				$this->my_one_touch_model->db->trans_begin();
				$this->my_one_touch_detail_model->db->trans_begin();

				// Remove
				$where_remove_meta[MOT_ID] = $form_id;
				$where_remove_meta[MOT_USER_ID] = $username;

				$this->my_one_touch_model->removeByWhere($where_remove_meta);

				// ADD
				$meta_classification[MOT_ID] = $form_id;
				$meta_classification[MOT_USER_ID] = $username;
				$meta_classification[MOT_NAME] = $form_name;
				$meta_classification[MOT_DELIVERY_CLASSIFICATION] = $classification;

				$this->my_one_touch_model->add($meta_classification);
				//$this->my_one_touch_model->edit($id_my_one_touch, $meta_classification);

				// Detail
				$resultDetail = count($detail);
				if($resultDetail > 0) {
					// Delete
					$where_remove[MOTD_MOT_ID] = $id_my_one_touch;
					$where_remove[MOTD_USER_ID] = $username;

					$this->my_one_touch_detail_model->removeByWhere($where_remove);

					if($detail != null && $detail != "") {
						foreach ($detail as $key => $value) {
							$meta_detail[MOTD_MOT_ID] = $id_my_one_touch;
							$meta_detail[MOTD_USER_ID] = $username;
							$meta_detail[MOTD_CUSTOMER_ID] = $value["customer"];
							$meta_detail[MOTD_DEPARTMENT_ID] = $value["department"];
							$meta_detail[MOTD_PRODUCT_CODE] = $value["product"];
							$meta_detail[MOTD_QUANTITY] = $value["quantity"];
							$meta_detail[MOTD_CONTAINER1] = $value["container"];
							$meta_detail[MOTD_CONTAINER2] = $value["container2"];
							$meta_detail[MOTD_COMMENT] = $value["comment"];

							$this->my_one_touch_detail_model->add($meta_detail);
						}
					}
				} else {
					$this->my_one_touch_model->db->trans_rollback();
					$this->my_one_touch_detail_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_error_requeird_product")
					));
					return;
				}

				// End Query
				if ($this->my_one_touch_model->db->trans_status() === FALSE || $this->my_one_touch_detail_model->db->trans_status() === FALSE)
				{
					$this->my_one_touch_model->db->trans_rollback();
					$this->my_one_touch_detail_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"have" => false,
						"message" => $this->lang->line("message_edit_error")
					));
					return;
				}
				else
				{
					$this->my_one_touch_model->db->trans_commit();
					$this->my_one_touch_detail_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"have" => false,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}
				

			}catch(Exception $ex){
				$this->my_one_touch_model->db->trans_rollback();
				$this->my_one_touch_detail_model->db->trans_rollback();
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
			$title = $this->lang->line('ms_my_one_touch');
			$column_title = array("ワンタッチID","ユーザ名",MOT_NAME,MOT_DELIVERY_CLASSIFICATION);
			$column_show_data = array(MOT_ID,MOT_USER_ID,MOT_NAME,MOT_DELIVERY_CLASSIFICATION);
	
			$result = $this->my_one_touch_model->getAll();

			$this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
		} else if($type == 2 || $type == "2") {
			$title = MY_ONE_TOUCH_DETAIL;
			$column_title = array(MOTD_MOT_ID,MOTD_USER_ID,MOTD_STT_SHOW,MOTD_CUSTOMER_ID,MOTD_DEPARTMENT_ID,MOTD_PRODUCT_CODE,MOTD_QUANTITY,MOTD_CONTAINER1,MOTD_CONTAINER2,MOTD_COMMENT);
			$column_show_data = array(MOTD_MOT_ID,MOTD_USER_ID,MOTD_STT_SHOW,MOTD_CUSTOMER_ID,MOTD_DEPARTMENT_ID,MOTD_PRODUCT_CODE,MOTD_QUANTITY,MOTD_CONTAINER1,MOTD_CONTAINER2,MOTD_COMMENT);
	
			$result = $this->my_one_touch_detail_model->getAvaiable();

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

		$is_import = false;
		$is_dup = false;
		$error_line = 0;
		if($get_type_csv == 1 || $get_type_csv == "1") {
			$title = $this->lang->line('ms_my_one_touch');

			// Import Csv
			$sheetData = $this->ImportExportCsv->import($filename);
			if(empty($sheetData)) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_import_error")
				));
				return;
			}

			try{
				$this->my_one_touch_model->db->trans_begin();
	
				foreach ($sheetData as $key => $value) {
					$item = array();
					$item[MOT_ID] = (isset($value['A']) ? $value['A'] : null);
	
					if(!$this->my_one_touch_model->checkDataNumber($item)){
						$error_line = $key+1;
						break;
					}
	
					$item[MOT_USER_ID] = (isset($value['B']) ? $value['B'] : null);
					$item[MOT_NAME] = (isset($value['C']) ? $value['C'] : null);
					$item[MOT_DELIVERY_CLASSIFICATION] = (isset($value['D']) ? $value['D'] : null);
	
					$where_dup[MOT_ID] = (isset($value['A']) ? $value['A'] : null);
					$where_dup[MOT_USER_ID] = (isset($value['B']) ? $value['B'] : null);
					$this->my_one_touch_model->removeByWhere($where_dup);
	
					$result = $this->my_one_touch_model->add($item);
					if ($this->my_one_touch_model->db->trans_status() === FALSE){
						$error_line = $key+1;
						break;
					} 
					$index = $key + 1;						
				}
				
				if ($this->my_one_touch_model->db->trans_status() === FALSE || $error_line != 0)
				{
	
					$this->my_one_touch_model->db->trans_rollback();
					$is_import = false;
				}
				else
				{
						
					$this->my_one_touch_model->db->trans_commit();
					$is_import = true;
				}           
	
			}catch(Exception $ex){
				$this->my_one_touch_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_import_error")
				));
				return;
			}

		} else if($get_type_csv == 2 || $get_type_csv == "2") {
			$title = MY_ONE_TOUCH_DETAIL;

			// Import Csv
			$sheetData = $this->ImportExportCsv->import($filename);
			if(empty($sheetData)) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_import_error")
				));
				return;
			}

			try{
				$this->my_one_touch_detail_model->db->trans_begin();
	
				foreach ($sheetData as $key => $value) {
					$item = array();
					$where_dup = array();
					$item[MOTD_MOT_ID] = (isset($value['A']) ? $value['A'] : null);
					
					$item[MOTD_STT_SHOW] = (isset($value['C']) ? $value['C'] : null);
					$item[MOTD_CUSTOMER_ID] = (isset($value['D']) ? $value['D'] : null);
					$item[MOTD_DEPARTMENT_ID] = (isset($value['E']) ? $value['E'] : null);
					$item[MOTD_PRODUCT_CODE] = (isset($value['F']) ? $value['F'] : null);

					if(!$this->my_one_touch_detail_model->checkDataNumber($item)){
						$error_line = $key+1;
						break;
					}
					$item[MOTD_USER_ID] = (isset($value['B']) ? $value['B'] : null);
					$item[MOTD_QUANTITY] = (isset($value['G']) ? $value['G'] : null);
					$item[MOTD_CONTAINER1] = (isset($value['H']) ? $value['H'] : null);
					$item[MOTD_CONTAINER2] = (isset($value['I']) ? $value['I'] : null);
					$item[MOTD_COMMENT] = (isset($value['J']) ? $value['J'] : null);

					$where_dup[MOTD_MOT_ID] = (isset($value['A']) ? $value['A'] : null);
					$where_dup[MOTD_USER_ID] = (isset($value['B']) ? $value['B'] : null);
					$where_dup[MOTD_CUSTOMER_ID] = (isset($value['D']) ? $value['D'] : null);
					$where_dup[MOTD_DEPARTMENT_ID] = (isset($value['E']) ? $value['E'] : null);
					$where_dup[MOTD_PRODUCT_CODE] = (isset($value['F']) ? $value['F'] : null);
					$this->my_one_touch_detail_model->removeByWhere($where_dup);
	
					$result = $this->my_one_touch_detail_model->add($item);
					if ($this->my_one_touch_detail_model->db->trans_status() === FALSE){
						$error_line = $key+1;
						break;
					} 
					$index = $key + 1;						
				}
				
				if ($this->my_one_touch_detail_model->db->trans_status() === FALSE || $error_line != 0)
				{
	
					$this->my_one_touch_detail_model->db->trans_rollback();
					$is_import = false;
				}
				else
				{
						
					$this->my_one_touch_detail_model->db->trans_commit();
					$is_import = true;
				}           
	
			}catch(Exception $ex){
				$this->my_one_touch_detail_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_import_error")
				));
				return;
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
            "message" => $this->lang->line("message_import_error") . " => ".$error_line." 行目のエラー"
        ));
        return; 
    }
}
