<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StatisticalGroupController extends VV_Controller {
	
	// Construct function
	public function __construct()
    { 
		parent::__construct();
		$this->load->model('Group_code','group_code_model');
		$this->load->model('ImportExportCsv');
	} 

    /**
	* Function: index
	* @access public
	*/
	public function index() { 
		$data['title'] = $this->lang->line('ms_statistical_group');
		$data['titleAdd'] = $this->lang->line('ms_statistical_group_add');
        $data['content'] ='masters/statistical_group/index';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: add
	* @access public
	*/
	public function add() {
		$data['title'] = $this->lang->line('ms_statistical_group_add');
        $data['content'] ='masters/statistical_group/add';
        $this->load->view('templates/master',$data);
    }
    
    /**
	* Function: edit
	* @access public
	*/
	public function edit() {
		$data['title'] = $this->lang->line('ms_statistical_group_edit');
        $data['content'] ='masters/statistical_group/edit';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: get_list
	* @access public
	*/
	public function get_list(){
        $id = $this->input->get('id');
        $name = $this->input->get('input_search');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->group_code_model->searchGroupCode($id, $name,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
	}
	
	/**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
			$group_code = $this->input->post('id');
			$group_name = $this->input->post('group_name');
			$group_type = $this->input->post('group_type');
			$group_report = $this->input->post('group_report');

			try{
				$this->group_code_model->db->trans_begin();

				$checkIsExits = $this->group_code_model->isExitsRow(GR_GROUP_CODE,$group_code );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta
				$arr_add[GR_GROUP_CODE] = $group_code;
				$arr_add[GR_GROUP_NAME] = $group_name;
				$arr_add[GR_GROUP_TYPE] = $group_type;
				$arr_add[GR_GROUP_SCHEDULE] = $group_report;
				$this->group_code_model->add($arr_add);

				// End Query
				if ($this->group_code_model->db->trans_status() === FALSE)
				{
					$this->group_code_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					// LOG ADD
					logadd(GR_GROUP_CODE . ":".$group_code, GROUP_REPORT);

					$this->group_code_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->group_code_model->db->trans_rollback();
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
			$group_code = $this->input->post('group_code');
            $group_name = $this->input->post('group_name');
			$group_type = $this->input->post('group_type');
			$group_report = $this->input->post('group_report');
			$data_log_edit["data_old"]=$this->group_code_model->getById($group_code);

			try{
				$this->group_code_model->db->trans_begin();
				
				// Meta
				$arr_edit[GR_GROUP_NAME] = $group_name;
				$arr_edit[GR_GROUP_TYPE] = $group_type;
				$arr_edit[GR_GROUP_SCHEDULE] = $group_report;
                $arr_where[GR_GROUP_CODE] = $group_code;
				$this->group_code_model->editByWhere($arr_where, $arr_edit);

				// End Query
				if ($this->group_code_model->db->trans_status() === FALSE)
				{
					$this->group_code_model->db->trans_rollback();
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
					logedit($data_log_edit, GROUP_REPORT);

					$this->group_code_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->group_code_model->db->trans_rollback();
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
				$this->group_code_model->db->trans_begin();

				// Meta
                $arr_where[GR_GROUP_CODE] = $id;
				$this->group_code_model->removeByWhere($arr_where);

				// End Query
				if ($this->group_code_model->db->trans_status() === FALSE)
				{
					$this->group_code_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					// LOG DELETE
					logdelete(GR_GROUP_CODE . ":".$id, GROUP_REPORT);

					$this->group_code_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->group_code_model->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error")
				));
				return;
			}
		}
	}

	public function import(){
        $filename = $_FILES["import_file"]["tmp_name"];
        $target_file = $_FILES["import_file"]["name"];
            
		$sheetData = $this->ImportExportCsv->import($filename);
		if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
        }
        $error_line = 0;
        $is_import = false;
        try{
            $this->group_code_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
				$data = array();
				$data[GR_GROUP_CODE] = (isset($value['A']) ? $value['A'] : null);
				
				if(!$this->group_code_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
				}

                $data[GR_GROUP_NAME] = (isset($value['B']) ? $value['B'] : null);
                $data[GR_GROUP_TYPE] = (isset($value['C']) ? $value['C'] : null);
                $data[GR_GROUP_SCHEDULE] = (isset($value['D']) ? $value['D'] : null);

                $where_dup[GR_GROUP_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->group_code_model->removeByWhere($where_dup);

                $result = $this->group_code_model->add($data);
                if ($this->group_code_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->group_code_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->group_code_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->group_code_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", GROUP_REPORT);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->group_code_model->db->trans_rollback();
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

    public function export(){
        $title = $this->lang->line('ms_statistical_group');

        // Data
        $result = $this->group_code_model->getAll(); 
        
        // Column name
        $column_title = array(GR_GROUP_CODE,GR_GROUP_NAME,GR_GROUP_TYPE,GR_GROUP_SCHEDULE);
        $column_show_data = array(GR_GROUP_CODE,GR_GROUP_NAME,GR_GROUP_TYPE,GR_GROUP_SCHEDULE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
}