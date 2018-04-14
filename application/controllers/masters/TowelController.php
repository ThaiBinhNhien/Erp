<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TowelController extends VV_Controller {
    
    // Construct function
	public function __construct()
    { 
		parent::__construct();
		$this->load->model('TowelModel', 'towel_model');
		$this->load->model('Overview_Category_M','overview_category_model');
		$this->load->model('ImportExportCsv');
		$this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }

    /**
	* Function: index
	* @access public
	*/
	public function index() {
        $data['title'] = $this->lang->line('ms_towel');
        $data['titleEdit'] = $this->lang->line('ms_towel_edit');
        $data['list_production_group'] = $this->overview_category_model->getAll(null,null,POC_PRODUCTION_SUMMARY_CODE,"ASC");
        $data['content'] ='masters/towel/index';
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
            $result = $this->towel_model->searchByKey($keyword,$start_index,PAGE_SIZE);
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
            $weight = $this->input->post('weight');
            $type = $this->input->post('type');
			$id = $this->input->post('id');

			try{
				$this->towel_model->db->trans_begin();

				// Check exits for id
				$checkIsExits = $this->towel_model->isExitsRow(PT_PRODUCT_CODE,$id );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta T_EVENT
				$arr_add[PT_PRODUCT_CODE] = $id;
                $arr_add[PT_PRODUCT_NAME] = $name;
                $arr_add[PT_PRODUCT_WEIGHT] = $weight;
                $arr_add[PT_PRODUCT_TYPE] = $type;
				$this->towel_model->add($arr_add);

				// End Query
				if ($this->towel_model->db->trans_status() === FALSE)
				{
					$this->towel_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					// LOG ADD
					logadd(PT_PRODUCT_CODE . ":".$id, PRODUCT_TOWEL);

					$this->towel_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->towel_model->db->trans_rollback();
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
            $weight = $this->input->post('weight');
            $type = $this->input->post('type');
			$data_log_edit["data_old"]=$this->towel_model->getById($id_edit);

			try{
				$this->towel_model->db->trans_begin();
				
				// Meta
                $arr_edit[PT_PRODUCT_NAME] = $name;
                $arr_edit[PT_PRODUCT_WEIGHT] = $weight;
                $arr_edit[PT_PRODUCT_TYPE] = $type;
                $arr_where[PT_PRODUCT_CODE] = $id_edit;
				$this->towel_model->editByWhere($arr_where, $arr_edit);

				// End Query
				if ($this->towel_model->db->trans_status() === FALSE)
				{
					$this->towel_model->db->trans_rollback();
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
					logedit($data_log_edit, PRODUCT_TOWEL);

					$this->towel_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->towel_model->db->trans_rollback();
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
				$this->towel_model->db->trans_begin();

				// Meta
                $arr_where[PT_PRODUCT_CODE] = $id;
				$this->towel_model->removeByWhere($arr_where);

				// End Query
				if ($this->towel_model->db->trans_status() === FALSE)
				{
					$this->towel_model->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					// LOG DELETE
					logdelete(PT_PRODUCT_CODE . ":".$id, PRODUCT_TOWEL);

					$this->towel_model->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->towel_model->db->trans_rollback();
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
		$title = $this->lang->line('ms_towel');

		// Data
        $result = $this->towel_model->getAll();
		
		// Column name
		$column_title = array(PT_PRODUCT_CODE,PT_PRODUCT_NAME,PT_PRODUCT_WEIGHT,PT_PRODUCT_TYPE);
		$column_show_data = array(PT_PRODUCT_CODE,PT_PRODUCT_NAME,PT_PRODUCT_WEIGHT,PT_PRODUCT_TYPE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('ms_towel');
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
			$this->towel_model->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[PT_PRODUCT_CODE] = (isset($value['A']) ? $value['A'] : null);

				if(!$this->towel_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
				}

				$data[PT_PRODUCT_NAME] = (isset($value['B']) ? $value['B'] : null);
				if(isset($value['C']))
					$data[PT_PRODUCT_WEIGHT] = (isset($value['C']) ? $value['C'] : null);
				if(isset($value['D']))
                	$data[PT_PRODUCT_TYPE] = (isset($value['D']) ? $value['D'] : null);

				$where_dup[PT_PRODUCT_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->towel_model->removeByWhere($where_dup);

                $result = $this->towel_model->add($data);
                if ($this->towel_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
										
			}
			if ($this->towel_model->db->trans_status() === FALSE || $error_line != 0)
			{
				$this->towel_model->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				logupcsv($target_file . " (".count($sheetData)." records)", PRODUCT_TOWEL);
				$this->towel_model->db->trans_commit();
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->towel_model->db->trans_rollback();
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
