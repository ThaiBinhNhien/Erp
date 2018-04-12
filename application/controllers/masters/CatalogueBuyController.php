<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CatalogueBuyController extends VV_Controller {
    
    // Construct function
	public function __construct()
    { 
		parent::__construct();
		$this->load->model('CatalogueBuy');
		$this->load->model('Product','product_model');
		$this->load->model('ImportExportCsv');
		$this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
 
    /**
	* Function: index
	* @access public
	*/
	public function index() {
        $data['title'] = $this->lang->line('ms_catalogue_buy');
        $data['titleEdit'] = $this->lang->line('ms_catalogue_buy_edit');
        $data['content'] ='masters/catalogue_buy/index';
        $this->load->view('templates/master',$data);
    }
    
    /**
	* Function: get_list
	* @access public
	*/
	public function get_list(){ 
        
		$keyword["id"] = $this->input->get('id');
		$keyword["name"] = $this->input->get('name');
		$keyword["type"] = $this->input->get('type');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) { 
            $result = $this->CatalogueBuy->searchByKey($keyword,$start_index,PAGE_SIZE);
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
			$type = $this->input->post('type');
			$type_product = $this->input->post('type_product');

			try{
				$this->CatalogueBuy->db->trans_begin();

				// Check exits for id
				$checkIsExits = $this->CatalogueBuy->isExitsRow(TE_ID,$id );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta T_EVENT
				$arr_add[TE_ID] = $id;
				$arr_add[TE_ITEM_CATEGORY_NAME] = $name;
				$arr_add[TE_TYPE_EVENT] = $type;
				if($type == 1 || $type == "1") {
					if($type_product == 2 || $type_product == "2") {
						$arr_add[TE_FLG_OUTSOURCE] = true;
					} else {
						$arr_add[TE_FLG_OUTSOURCE] = false;
					}
				}
				$this->CatalogueBuy->add($arr_add);

				// End Query
				if ($this->CatalogueBuy->db->trans_status() === FALSE)
				{
					$this->CatalogueBuy->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					$this->CatalogueBuy->db->trans_commit();
					// LOG ADD
					logadd(TE_ID . ":".$id, T_EVENT);
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->CatalogueBuy->db->trans_rollback();
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
			$type = $this->input->post('type');
			$type_product = $this->input->post('type_product');
			$data_log_edit["data_old"]=$this->CatalogueBuy->getById($id_edit);

			try{
				$this->CatalogueBuy->db->trans_begin();
				
				// Meta
				$arr_edit[TE_ITEM_CATEGORY_NAME] = $name;
				$arr_edit[TE_TYPE_EVENT] = $type;
				$arr_where[TE_ID] = $id_edit;
				if($type == 1 || $type == "1") {
					if($type_product == 2 || $type_product == "2") {
						$arr_edit[TE_FLG_OUTSOURCE] = true;
					} else {
						$arr_edit[TE_FLG_OUTSOURCE] = false;
					}
				}
				$this->CatalogueBuy->editByWhere($arr_where, $arr_edit);

				// End Query
				if ($this->CatalogueBuy->db->trans_status() === FALSE)
				{
					$this->CatalogueBuy->db->trans_rollback();
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
					logedit($data_log_edit, T_EVENT);

					$this->CatalogueBuy->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->CatalogueBuy->db->trans_rollback();
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
				$this->CatalogueBuy->db->trans_begin();

				// Meta
                $arr_where[TE_ID] = $id;
				$this->CatalogueBuy->removeByWhere($arr_where);

				// End Query
				if ($this->CatalogueBuy->db->trans_status() === FALSE)
				{
					$this->CatalogueBuy->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					$this->CatalogueBuy->db->trans_commit();
					// LOG DELETE
					logdelete(TE_ID . ":".$id, T_EVENT);
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->CatalogueBuy->db->trans_rollback();
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
		$title = $this->lang->line('ms_catalogue_buy');

		// Data
        $result = $this->CatalogueBuy->getAll();
		
		// Column name
		$column_title = array("種目区分ID","種目区分名","種目区分名",TE_FLG_OUTSOURCE);
		$column_show_data = array(TE_ID,TE_ITEM_CATEGORY_NAME,TE_TYPE_EVENT,TE_FLG_OUTSOURCE); 

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('ms_catalogue_buy');
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
			$this->CatalogueBuy->db->trans_begin();

			// table
			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[TE_ID] = (isset($value['A']) ? $value['A'] : null);

				if(!$this->CatalogueBuy->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
				}
				
				$data[TE_ITEM_CATEGORY_NAME] = (isset($value['B']) ? $value['B'] : null);
				$data[TE_TYPE_EVENT] = (isset($value['C']) ? $value['C'] : null);
				$data[TE_FLG_OUTSOURCE] = (isset($value['D']) ? $value['D'] : null);
				//$data[TE_TYPE_EVENT] = (isset($value['C']) ? $value['C'] : null);

				// Xóa trùng
				$where_dup[TE_ID] = (isset($value['A']) ? $value['A'] : null);
				$this->CatalogueBuy->removeByWhere($where_dup);

				// Add
				$result = $this->CatalogueBuy->add($data);

				if ($this->CatalogueBuy->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                }  
										
			}
			if ($this->CatalogueBuy->db->trans_status() === FALSE || $error_line != 0)
			{
				$this->CatalogueBuy->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				$this->CatalogueBuy->db->trans_commit();
				logupcsv($target_file . " (".count($sheetData)." records)", T_EVENT);
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->CatalogueBuy->db->trans_rollback();
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
