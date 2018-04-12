<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supplier_CategoryController extends VV_Controller {
	public function __construct() 
    {
        parent::__construct();
        $this->load->model('Supplier_Category','supplier_category_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
	public function index() {
		$data['title'] = $this->lang->line('ms_supplier_category');
        $data['content'] ='masters/supplier_category/index';
        $this->load->view('templates/master',$data);
	}
	public function search_category(){
        $data['cat_id'] = $this->input->get('cat_id');
        $data['cat_name'] = $this->input->get('cat_name');
        $start_index      = $this->input->get('start_index');
        if($start_index == NULL){ 
            $start_index = 0;
        } 
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
           $result = $this->supplier_category_model->search_category($data,$start_index,PAGE_SIZE,TSC_ID,SORT_MASTER);
        }
        
        echo json_encode($result);
    }
    public function delete_category(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->supplier_category_model->remove($id,T_SUPPLIER_CLASSIFICATION);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(TSC_ID . ":".$id, T_SUPPLIER_CLASSIFICATION);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create_category(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $checkIsExits = $this->supplier_category_model->isExitsRow(TSC_ID,$id );

            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }
            $data[TSC_ID] = $id;
            $data[TSC_NAME] = $name;
            $result = $this->supplier_category_model->added($data);
            if(!$result){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['category_id'] = $id;
            $data['category_name'] = $name;

            // LOG ADD
            logadd(TSC_ID . ":".$id, T_SUPPLIER_CLASSIFICATION);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success"),
                        "data" => $data
                    ));
        }
    }
    
    public function edit_category(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $data_log_edit["data_old"]=$this->supplier_category_model->getById($id);

            $data[TSC_NAME] = $name;
            try{
                 $result = $this->supplier_category_model->edit($id,$data);
            }catch(Exception $ex){

            }
            
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }

            // Log Edit
            $arr_where[TSC_ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, T_SUPPLIER_CLASSIFICATION);

            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
        }
    }

/**
    * Function: export
    * @access public
    */
    public function export(){
        $title = $this->lang->line('ms_supplier_category');
        // Data
        $result = $this->supplier_category_model->getAll(); 
        // Column name
        $column_title = array(TSC_ID,TSC_NAME);
        $column_show_data =array(TSC_ID,TSC_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_supplier_category');
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
            $this->supplier_category_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[TSC_ID]        = (isset($value['A']) ? $value['A'] : null);
                if(!$this->supplier_category_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;

                }
               
                $data[TSC_NAME] = (isset($value['B']) ? $value['B'] : null);
                // Xóa trùng
                $where_dup[TSC_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->supplier_category_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->supplier_category_model->add($data);

                if ($this->supplier_category_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->supplier_category_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->supplier_category_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->supplier_category_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", T_SUPPLIER_CLASSIFICATION);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->supplier_category_model->db->trans_rollback();
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
            "message" => $this->lang->line("message_import_error") . ".Line: " . $error_line
        ));
        return; 
    }

	
}
