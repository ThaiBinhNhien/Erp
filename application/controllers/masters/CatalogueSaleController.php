<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CatalogueSaleController extends VV_Controller {
    
    // Construct function
	public function __construct()
    { 
		parent::__construct();
		$this->load->model('CatalogueSale');
		$this->load->model('ImportExportCsv');
    }

    /**
	* Function: index
	* @access public
	*/
	public function index() {
        $data['title'] = $this->lang->line('ms_catalogue_sale');
        $data['titleEdit'] = $this->lang->line('ms_catalogue_sale_edit');
        $data['content'] ='masters/catalogue_sale/index';
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
            $result = $this->CatalogueSale->searchByKey($keyword,$start_index,PAGE_SIZE);
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
				$this->CatalogueSale->db->trans_begin();

				// Check exits for id
				$checkIsExits = $this->CatalogueSale->isExitsRow(ICR_EVENT_CATEGORY,$id );

				if($checkIsExits) {
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_exits_id_error")
					));
					return;
				}

				// Meta T_EVENT
				$arr_add[ICR_EVENT_CATEGORY] = $id;
				$arr_add[ICR_ITEM_CATEGORY_NAME] = $name;
				$this->CatalogueSale->add($arr_add);

				// End Query
				if ($this->CatalogueSale->db->trans_status() === FALSE)
				{
					$this->CatalogueSale->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_add_error")
					));
					return;
				}
				else
				{
					$this->CatalogueSale->db->trans_commit();
					logadd(ICR_EVENT_CATEGORY . ":".$id, ITEM_CLASSIFICATION_REGISTER);
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_add_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->CatalogueSale->db->trans_rollback();
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
			$data_log_edit["data_old"]=$this->CatalogueSale->getById($id_edit);

			try{
				$this->CatalogueSale->db->trans_begin();
				
				// Meta
				$arr_edit[ICR_ITEM_CATEGORY_NAME] = $name;
                $arr_where[ICR_EVENT_CATEGORY] = $id_edit;
				$this->CatalogueSale->editByWhere($arr_where, $arr_edit);

				// End Query
				if ($this->CatalogueSale->db->trans_status() === FALSE)
				{
					$this->CatalogueSale->db->trans_rollback();
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
					logedit($data_log_edit, ITEM_CLASSIFICATION_REGISTER);

					$this->CatalogueSale->db->trans_commit();
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_edit_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->CatalogueSale->db->trans_rollback();
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
				$this->CatalogueSale->db->trans_begin();

				// Meta
                $arr_where[ICR_EVENT_CATEGORY] = $id;
				$this->CatalogueSale->removeByWhere($arr_where);

				// End Query
				if ($this->CatalogueSale->db->trans_status() === FALSE)
				{
					$this->CatalogueSale->db->trans_rollback();
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("message_delete_error")
					));
					return;
				}
				else
				{
					$this->CatalogueSale->db->trans_commit();
					logdelete(ICR_EVENT_CATEGORY . ":".$id, ITEM_CLASSIFICATION_REGISTER);
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_delete_success")
					));
					return;
				}

			}catch(Exception $ex){
				$this->CatalogueSale->db->trans_rollback();
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
		$title = $this->lang->line('ms_catalogue_sale');

		// Data
        $result = $this->CatalogueSale->getAll(); 
		
		// Column name
		$column_title = array("売上種目区分ID","売上種目区分名");
		$column_show_data = array(ICR_EVENT_CATEGORY,ICR_ITEM_CATEGORY_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('ms_catalogue_sale');
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
			$this->CatalogueSale->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[ICR_EVENT_CATEGORY] = (isset($value['A']) ? $value['A'] : null);

				if(!$this->CatalogueSale->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
				}

				$data[ICR_ITEM_CATEGORY_NAME] = (isset($value['B']) ? $value['B'] : null);

				$where_dup[ICR_EVENT_CATEGORY] = (isset($value['A']) ? $value['A'] : null);
                $this->CatalogueSale->removeByWhere($where_dup);

				$result = $this->CatalogueSale->add($data);
				if ($this->CatalogueSale->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                }
						 				
			}
			if ($this->CatalogueSale->db->trans_status() === FALSE || $error_line != 0)
			{ 
				$this->CatalogueSale->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				$this->CatalogueSale->db->trans_commit();
				logupcsv($target_file . " (".count($sheetData)." records)", ITEM_CLASSIFICATION_REGISTER);
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->CatalogueSale->db->trans_rollback();
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
