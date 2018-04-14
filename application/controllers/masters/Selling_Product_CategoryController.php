<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Selling_Product_CategoryController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category','category_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_selling_product_category');
        $data['content'] ='masters/selling_product_category/index';
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
           $result = $this->category_model->search_category($data,$start_index,PAGE_SIZE,CATE_CATEGORY_CODE,SORT_MASTER);
        }

        echo json_encode($result);
    }
    public function delete_category(){ 
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->category_model->remove($id,CATEGORIES);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
			logdelete(CATE_CATEGORY_CODE . ":".$id, CATEGORIES);
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
            $checkIsExits = $this->category_model->isExitsRow(CATE_CATEGORY_CODE,$id );

            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }
            $data[CATE_CATEGORY_CODE] = $id;
            $data[CATE_CATEGORY_NAME] = $name;
            $result = $this->category_model->added($data);
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
			logadd(CATE_CATEGORY_CODE . ":".$id, CATEGORIES);
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
            $data[CATE_CATEGORY_NAME] = $name;
            $data_log_edit["data_old"]=$this->category_model->getById($id);
            try{
                 $result = $this->category_model->edit($id,$data);
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
            $arr_where[CATE_CATEGORY_CODE] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, CATEGORIES);

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
        $title = $this->lang->line('ms_selling_product_category');
        // Data
        $result = $this->category_model->getAll(); 
        // Column name
        $column_title = array(CATE_CATEGORY_CODE,CATE_CATEGORY_NAME);
        $column_show_data =array(CATE_CATEGORY_CODE,CATE_CATEGORY_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);
    }
    
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_selling_product_category');
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
            $this->category_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[CATE_CATEGORY_CODE]        = (isset($value['A']) ? $value['A'] : null);
                if(!$this->category_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;

                }
               
                $data[CATE_CATEGORY_NAME] = (isset($value['B']) ? $value['B'] : null);
                // Xóa trùng
                $where_dup[CATE_CATEGORY_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->category_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->category_model->add($data);

                if ($this->category_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->category_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->category_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->category_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", CATEGORIES);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->category_model->db->trans_rollback();
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
