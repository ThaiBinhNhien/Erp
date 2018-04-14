<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OverviewGroupMController extends VV_Controller {
    
    // Construct function
	public function __construct()
    { 
		parent::__construct();
		$this->load->model('Overview_Group_M', 'overview_group_model');
		$this->load->model('ImportExportCsv');
		$this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
 
    /**
	* Function: index
	* @access public
	*/
	public function index() {
        $data['title'] = $this->lang->line('ms_overview_group');
        $data['content'] ='masters/ms_overview_group/index';
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
            $result = $this->overview_group_model->searchByKey($keyword,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
    }

    /**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $name = $this->input->post('name');
			$id = $this->input->post('id');

			try{
				$this->overview_group_model->db->trans_begin();

				// Check exits for id
				$checkIsExits = $this->overview_group_model->isExitsRow(POG_CODE,$id );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta T_EVENT
				$arr_add[POG_CODE] = $id;
                $arr_add[POG_NAME] = $name;
				$this->overview_group_model->add($arr_add);

				// End Query
				if ($this->overview_group_model->db->trans_status() === FALSE)
				{
					$this->overview_group_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					// LOG ADD
					logadd(POG_CODE . ":".$id, PRODUCTION_OVERVIEW_GROUP_M);

					$this->overview_group_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->overview_group_model->db->trans_rollback();
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
			$data_log_edit["data_old"]=$this->overview_group_model->getById($id_edit);

			try{
				$this->overview_group_model->db->trans_begin();
				
				// Meta
                $arr_edit[POG_NAME] = $name;
                $arr_where[POG_CODE] = $id_edit;
				$this->overview_group_model->editByWhere($arr_where, $arr_edit);

				// End Query
				if ($this->overview_group_model->db->trans_status() === FALSE)
				{
					$this->overview_group_model->db->trans_rollback();
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
					logedit($data_log_edit, PRODUCTION_OVERVIEW_GROUP_M);

					$this->overview_group_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->overview_group_model->db->trans_rollback();
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
				$this->overview_group_model->db->trans_begin();

				// Meta
                $arr_where[POG_CODE] = $id;
				$this->overview_group_model->removeByWhere($arr_where);

				// End Query
				if ($this->overview_group_model->db->trans_status() === FALSE)
				{
					$this->overview_group_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					// LOG DELETE
					logdelete(POG_CODE . ":".$id, PRODUCTION_OVERVIEW_GROUP_M);

					$this->overview_group_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->overview_group_model->db->trans_rollback();
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
		$title = $this->lang->line('ms_overview_group');

		// Data
        $result = $this->overview_group_model->getAll();
		
		// Column name
		$column_title = array(POG_CODE,POG_NAME);
		$column_show_data = array(POG_CODE,POG_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('ms_overview_group');
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
			$this->overview_group_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[POG_CODE] = (isset($value['A']) ? $value['A'] : null);

				if(!$this->overview_group_model->checkDataNumber($data)){
					$error_line = $key+1;
                    break;
				}

                $data[POG_NAME] = (isset($value['B']) ? $value['B'] : null);

				$where_dup[POG_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->overview_group_model->removeByWhere($where_dup);

                $result = $this->overview_group_model->add($data);
                if ($this->overview_group_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
										
			}

			if ($this->overview_group_model->db->trans_status() === FALSE || $error_line != 0)
			{
				$this->overview_group_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				logupcsv($target_file . " (".count($sheetData)." records)", PRODUCTION_OVERVIEW_GROUP_M);
				$this->overview_group_model->db->trans_commit();
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->overview_group_model->db->trans_rollback();
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
