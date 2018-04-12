<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LocationController extends VV_Controller {
	
	// Construct function
	public function __construct()
    { 
		parent::__construct();
		$this->load->model('Base_master','base_master_model');
		$this->load->model('ImportExportCsv');
	}

	/**
	* Function: get_location_by_gaichyu
    * @access public
    * @param $is_gaichyu
	*/
    public function get_location_by_gaichyu(){
		$is_gaichyu = $this->input->get("is_gaichyu");
        if($is_gaichyu == "true") {
            $arrWhereBase[BM_MASTER_CHECK] = true;
        } else {
            $arrWhereBase[BM_MASTER_CHECK] = false;
        }
        $result = $this->base_master_model->getWhere($arrWhereBase);
        echo json_encode($result);
    }

	/**
    * Function: index
    * @access public
    */
	public function index() {
		$data['title'] = $this->lang->line('ms_location');
		$data['content'] ='masters/location/index';
        $this->load->view('templates/master',$data);
	}

	/**
    * Function: add
    * @access public
    */
	public function add() {
		$data['title'] = $this->lang->line('ms_add_location');
        $data['content'] ='masters/location/add';
        $this->load->view('templates/master',$data);
	}

	/**
    * Function: edit
    * @access public
    */
	public function edit() {
		$data['title'] = $this->lang->line('ms_edit_location');
		$id_location = $this->input->get("id");
		$where_location[BM_BASE_CODE] = $id_location;
		$data['data_meta'] = $this->base_master_model->getWhere($where_location);
        $data['content'] ='masters/location/edit';
        $this->load->view('templates/master',$data); 
	}

	/**
	* Function: get_list
	* @access public
	*/
	public function get_list(){ 
		
		$data_search["form_id"] = $this->input->get('form_id');
		$data_search["name"] = $this->input->get('name');
		$data_search["company"] = $this->input->get('company');
		$data_search["province"] = $this->input->get('province');
		$data_search["post_office"] = $this->input->get('post_office');
		$data_search["phone"] = $this->input->get('phone');
		$data_search["fax"] = $this->input->get('fax');
		$data_search["address"] = $this->input->get('address');
		$getCheck = $this->input->get('BM_MASTER_CHECK');
		if(isset($getCheck) && $getCheck != "") {
			$BM_MASTER_CHECK = $getCheck === 'true'? '1': '0';
			$data_search["BM_MASTER_CHECK"] = $BM_MASTER_CHECK;
		}
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->base_master_model->searchByKey($data_search,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
	}

	/**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$data_meta = $this->input->post('data_post');

			try{
				$this->base_master_model->db->trans_begin();

				$checkIsExits = $this->base_master_model->isExitsRow(BM_BASE_CODE,$data_meta[0]["BM_BASE_CODE"] );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta
				$arr_add[BM_BASE_CODE]=$data_meta[0]["BM_BASE_CODE"];
				$arr_add[BM_BASE_NAME]=$data_meta[0]["BM_BASE_NAME"];
				$arr_add[BM_COMPANY_NAME]=$data_meta[0]["BM_COMPANY_NAME"];
				$arr_add[BM_POSTAL_CODE]=$data_meta[0]["BM_POSTAL_CODE"];
				$arr_add[BM_PREFECTURES]=$data_meta[0]["BM_PREFECTURES"];
				$arr_add[BM_ADDRESS_1]=$data_meta[0]["BM_ADDRESS_1"];
				$arr_add[BM_ADDRESS_2]=$data_meta[0]["BM_ADDRESS_2"];
				$arr_add[BM_PHONE_NUMBER]=$data_meta[0]["BM_PHONE_NUMBER"];
				$arr_add[BM_FAX_NUMBER]=$data_meta[0]["BM_FAX_NUMBER"];
				$arr_add[BM_PAYEE_1_BANK_NAME]=$data_meta[0]["BM_PAYEE_1_BANK_NAME"];
				$arr_add[BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH]=$data_meta[0]["BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH"];
				$arr_add[BM_PAYEE_1_BRANCH_NAME]=$data_meta[0]["BM_PAYEE_1_BRANCH_NAME"];
				$arr_add[BM_PAYEE_1__BRANCH_NAME__ENGLISH]=$data_meta[0]["BM_PAYEE_1__BRANCH_NAME__ENGLISH"];
				$arr_add[BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION]=$data_meta[0]["BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION"];
				$arr_add[BM_PAYEE_1__ACCOUNT_NUMBER]=$data_meta[0]["BM_PAYEE_1__ACCOUNT_NUMBER"];
				$arr_add[BM_TRANSFER_DESTINATION_2_BANK_NAME]=$data_meta[0]["BM_TRANSFER_DESTINATION_2_BANK_NAME"];
				$arr_add[BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH]=$data_meta[0]["BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH"];
				$arr_add[BM_BANK_TRANSFER_2_BRANCH_NAME]=$data_meta[0]["BM_BANK_TRANSFER_2_BRANCH_NAME"];
				$arr_add[BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH]=$data_meta[0]["BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH"];
				$arr_add[BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION]=$data_meta[0]["BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION"];
				$arr_add[BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER]=$data_meta[0]["BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER"];
				$arr_add[BM_TRANSFER_DESTINATION_3_BANK_NAME]=$data_meta[0]["BM_TRANSFER_DESTINATION_3_BANK_NAME"];
				$arr_add[BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH]=$data_meta[0]["BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH"];
				$arr_add[BM_PAYEE_3_BRANCH_NAME]=$data_meta[0]["BM_PAYEE_3_BRANCH_NAME"];
				$arr_add[BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH]=$data_meta[0]["BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH"];
				$arr_add[BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION]=$data_meta[0]["BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION"];
				$arr_add[BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER]=$data_meta[0]["BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER"];
				$BM_MASTER_CHECK = $data_meta[0]["BM_MASTER_CHECK"] === 'true'? true: false;
				$arr_add[BM_MASTER_CHECK]=$BM_MASTER_CHECK;
				$this->base_master_model->add($arr_add);

				// End Query
				if ($this->base_master_model->db->trans_status() === FALSE)
				{
					$this->base_master_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					$this->base_master_model->db->trans_commit();
					logadd(BM_BASE_CODE . ":".$data_meta[0]["BM_BASE_CODE"], BASE_MASTER);
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->base_master_model->db->trans_rollback();
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
			$id_location = $this->input->post('id_location');
			$data_meta = $this->input->post('data_post');
			$data_log_edit["data_old"]=$this->base_master_model->getById($id_location);

			try{
				$this->base_master_model->db->trans_begin();

				// Meta
				$arr_add[BM_BASE_NAME]=$data_meta[0]["BM_BASE_NAME"];
				$arr_add[BM_COMPANY_NAME]=$data_meta[0]["BM_COMPANY_NAME"];
				$arr_add[BM_POSTAL_CODE]=$data_meta[0]["BM_POSTAL_CODE"];
				$arr_add[BM_PREFECTURES]=$data_meta[0]["BM_PREFECTURES"];
				$arr_add[BM_ADDRESS_1]=$data_meta[0]["BM_ADDRESS_1"];
				$arr_add[BM_ADDRESS_2]=$data_meta[0]["BM_ADDRESS_2"];
				$arr_add[BM_PHONE_NUMBER]=$data_meta[0]["BM_PHONE_NUMBER"];
				$arr_add[BM_FAX_NUMBER]=$data_meta[0]["BM_FAX_NUMBER"];
				$arr_add[BM_PAYEE_1_BANK_NAME]=$data_meta[0]["BM_PAYEE_1_BANK_NAME"];
				$arr_add[BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH]=$data_meta[0]["BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH"];
				$arr_add[BM_PAYEE_1_BRANCH_NAME]=$data_meta[0]["BM_PAYEE_1_BRANCH_NAME"];
				$arr_add[BM_PAYEE_1__BRANCH_NAME__ENGLISH]=$data_meta[0]["BM_PAYEE_1__BRANCH_NAME__ENGLISH"];
				$arr_add[BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION]=$data_meta[0]["BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION"];
				$arr_add[BM_PAYEE_1__ACCOUNT_NUMBER]=$data_meta[0]["BM_PAYEE_1__ACCOUNT_NUMBER"];
				$arr_add[BM_TRANSFER_DESTINATION_2_BANK_NAME]=$data_meta[0]["BM_TRANSFER_DESTINATION_2_BANK_NAME"];
				$arr_add[BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH]=$data_meta[0]["BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH"];
				$arr_add[BM_BANK_TRANSFER_2_BRANCH_NAME]=$data_meta[0]["BM_BANK_TRANSFER_2_BRANCH_NAME"];
				$arr_add[BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH]=$data_meta[0]["BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH"];
				$arr_add[BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION]=$data_meta[0]["BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION"];
				$arr_add[BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER]=$data_meta[0]["BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER"];
				$arr_add[BM_TRANSFER_DESTINATION_3_BANK_NAME]=$data_meta[0]["BM_TRANSFER_DESTINATION_3_BANK_NAME"];
				$arr_add[BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH]=$data_meta[0]["BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH"];
				$arr_add[BM_PAYEE_3_BRANCH_NAME]=$data_meta[0]["BM_PAYEE_3_BRANCH_NAME"];
				$arr_add[BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH]=$data_meta[0]["BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH"];
				$arr_add[BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION]=$data_meta[0]["BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION"];
				$arr_add[BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER]=$data_meta[0]["BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER"];
				$BM_MASTER_CHECK = $data_meta[0]["BM_MASTER_CHECK"] === 'true'? true: false;
				$arr_add[BM_MASTER_CHECK]=$BM_MASTER_CHECK;
				
				$where_array[BM_BASE_CODE] = $id_location;
				$this->base_master_model->editByWhere($where_array,$arr_add);

				// End Query
				if ($this->base_master_model->db->trans_status() === FALSE)
				{
					$this->base_master_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_edit_error")
					));
					return;
				}
				else
				{
					// Log Edit
					$data_log_edit["id"]=$where_array;
					$data_log_edit["data_new"]=$arr_add;
					logedit($data_log_edit, BASE_MASTER);

					$this->base_master_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->base_master_model->db->trans_rollback();
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
				$this->base_master_model->db->trans_begin();

				// Meta
                $arr_where[BM_BASE_CODE] = $id;
				$this->base_master_model->removeByWhere($arr_where);

				// End Query
				if ($this->base_master_model->db->trans_status() === FALSE)
				{
					$this->base_master_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					$this->base_master_model->db->trans_commit();
					logdelete(BM_BASE_CODE . ":".$id, BASE_MASTER);
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->base_master_model->db->trans_rollback();
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
		$title = $this->lang->line('ms_location');

		// Data
        $result = $this->base_master_model->getAll(); 
		
		// Column name
		$column_title = array(BM_BASE_CODE,BM_BASE_NAME,BM_COMPANY_NAME,BM_POSTAL_CODE,BM_PREFECTURES,BM_ADDRESS_1,BM_ADDRESS_2,
		BM_PHONE_NUMBER,BM_FAX_NUMBER,BM_CLOSING_DATE,BM_BILLING_CLASSIFICATION,
		BM_PAYEE_1_BANK_NAME,BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH,
		BM_PAYEE_1_BRANCH_NAME,BM_PAYEE_1__BRANCH_NAME__ENGLISH,
		BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION,BM_PAYEE_1__ACCOUNT_NUMBER,
		BM_TRANSFER_DESTINATION_2_BANK_NAME,BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH,
		BM_BANK_TRANSFER_2_BRANCH_NAME,BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH,
		BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION,BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER,
		BM_TRANSFER_DESTINATION_3_BANK_NAME,BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH,
		BM_PAYEE_3_BRANCH_NAME,BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH,
		BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION,BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER,BM_MASTER_CHECK);
		
		$column_show_data = array(BM_BASE_CODE,BM_BASE_NAME,BM_COMPANY_NAME,BM_POSTAL_CODE,BM_PREFECTURES,BM_ADDRESS_1,BM_ADDRESS_2,
		BM_PHONE_NUMBER,BM_FAX_NUMBER,BM_CLOSING_DATE,BM_BILLING_CLASSIFICATION,
		BM_PAYEE_1_BANK_NAME,BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH,
		BM_PAYEE_1_BRANCH_NAME,BM_PAYEE_1__BRANCH_NAME__ENGLISH,
		BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION,BM_PAYEE_1__ACCOUNT_NUMBER,
		BM_TRANSFER_DESTINATION_2_BANK_NAME,BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH,
		BM_BANK_TRANSFER_2_BRANCH_NAME,BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH,
		BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION,BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER,
		BM_TRANSFER_DESTINATION_3_BANK_NAME,BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH,
		BM_PAYEE_3_BRANCH_NAME,BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH,
		BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION,BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER,BM_MASTER_CHECK);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('ms_location');
		$filename = $_FILES["import_file"]["tmp_name"];
		$target_file = $_FILES["import_file"]["name"];

		// Import Csv
		$is_import = false;
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
			$this->base_master_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[BM_BASE_CODE] = (isset($value['A']) ? $value['A'] : null);

				if(!$this->base_master_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
				}

				$data[BM_BASE_NAME] = (isset($value['B']) ? $value['B'] : null);
				$data[BM_COMPANY_NAME] = (isset($value['C']) ? $value['C'] : null);
				$data[BM_POSTAL_CODE] = (isset($value['D']) ? $value['D'] : null);
				$data[BM_PREFECTURES] = (isset($value['E']) ? $value['E'] : null);
				$data[BM_ADDRESS_1] = (isset($value['F']) ? $value['F'] : null);
				$data[BM_ADDRESS_2] = (isset($value['G']) ? $value['G'] : null);
				$data[BM_PHONE_NUMBER] = (isset($value['H']) ? $value['H'] : null);
				$data[BM_FAX_NUMBER] = (isset($value['I']) ? $value['I'] : null);
				$data[BM_CLOSING_DATE] = (isset($value['J']) ? $value['J'] : null);
				$data[BM_BILLING_CLASSIFICATION] = (isset($value['K']) ? $value['K'] : null);
				$data[BM_PAYEE_1_BANK_NAME] = (isset($value['L']) ? $value['L'] : null);
				$data[BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH] = (isset($value['M']) ? $value['M'] : null);
				$data[BM_PAYEE_1_BRANCH_NAME] = (isset($value['N']) ? $value['N'] : null);
				$data[BM_PAYEE_1__BRANCH_NAME__ENGLISH] = (isset($value['O']) ? $value['O'] : null);
				$data[BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION] = (isset($value['P']) ? $value['P'] : null);
				$data[BM_PAYEE_1__ACCOUNT_NUMBER] = (isset($value['Q']) ? $value['Q'] : null);
				$data[BM_TRANSFER_DESTINATION_2_BANK_NAME] = (isset($value['R']) ? $value['R'] : null);
				$data[BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH] = (isset($value['S']) ? $value['S'] : null);
				$data[BM_BANK_TRANSFER_2_BRANCH_NAME] = (isset($value['T']) ? $value['T'] : null);
				$data[BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH] = (isset($value['U']) ? $value['U'] : null);
				$data[BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION] = (isset($value['V']) ? $value['V'] : null);
				$data[BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER] = (isset($value['W']) ? $value['W'] : null);
				$data[BM_TRANSFER_DESTINATION_3_BANK_NAME] = (isset($value['X']) ? $value['X'] : null);
				$data[BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH] = (isset($value['Y']) ? $value['Y'] : null);
				$data[BM_PAYEE_3_BRANCH_NAME] = (isset($value['Z']) ? $value['Z'] : null);
				$data[BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH] = (isset($value['AA']) ? $value['AA'] : null);
				$data[BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION] = (isset($value['AB']) ? $value['AB'] : null);
				$data[BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER] = (isset($value['AC']) ? $value['AC'] : null);
				$data[BM_MASTER_CHECK] = (isset($value['AD']) ? $value['AD'] : null);

				$where_dup[BM_BASE_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->base_master_model->removeByWhere($where_dup);

				$result = $this->base_master_model->add($data);
				if ($this->base_master_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
										
			}
			if ($this->base_master_model->db->trans_status() === FALSE || $error_line != 0)
			{
				$this->base_master_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				$this->base_master_model->db->trans_commit();
				logupcsv($target_file . " (".count($sheetData)." records)", BASE_MASTER);
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->base_master_model->db->trans_rollback();
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
			"message" => $this->lang->line("message_import_error"). " => ".$error_line." 行目のエラー"
		));
		return;
    }
	
}
