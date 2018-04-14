<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Overview_Category_MController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Overview_Category_M','overview_category_m_model'); 
        $this->load->model('Overview_Group_M','overview_group_m_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() { 
        $data['title'] = $this->lang->line('ms_overview_category_m');
        $data['content'] ='masters/overview_category_m/index';
        $data['list_group_m'] = $this->overview_group_m_model->getAll();
        $this->load->view('templates/master',$data);
    }
    public function search(){
        $data['cat_id'] = $this->input->get('cat_id');
        $data['cat_name'] = $this->input->get('cat_name');
        $start_index      = $this->input->get('start_index');
        if($start_index == NULL){ 
            $start_index = 0;
        } 
        
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
           $result = $this->overview_category_m_model->search($data,$start_index,PAGE_SIZE,POC_PRODUCTION_SUMMARY_CODE,SORT_MASTER);
        }
        
        echo json_encode($result);
    }
    public function delete(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->overview_category_m_model->remove($id,PRODUCTION_OVERVIEW_CATEGORY_M);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(POC_PRODUCTION_SUMMARY_CODE . ":".$id, PRODUCTION_OVERVIEW_CATEGORY_M);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $checkIsExits = $this->overview_category_m_model->isExitsRow(POC_PRODUCTION_SUMMARY_CODE,$id );

            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }
            $data[POC_PRODUCTION_SUMMARY_CODE] = $id;
            $display_order = $this->input->post("display_order");
            $group_m = $this->input->post("group_m");
            $name_group_m = $this->input->post("name_group_m");
            
            $data[POC_CATEGORY_NAME] = $name;
            $data[POC_DISPLAY_ORDER] = $display_order;
            $data[POC_PRODUCTION_OVERVIEW_GROUP_CODE] = $group_m;
            $result = $this->overview_category_m_model->added($data);
            if(!$result){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['category_id']    = $id;
            $data['category_name']  = $name;
            $data['display_order']  = $display_order;
            $data['group_m']        = $name_group_m;

            // LOG ADD
            logadd(POC_PRODUCTION_SUMMARY_CODE . ":".$id, PRODUCTION_OVERVIEW_CATEGORY_M);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success"),
                        "data" => $data
                    ));
        }
    }
    
    public function edit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $display_order = $this->input->post("display_order");
            $group_m = $this->input->post("group_m");
            $data_log_edit["data_old"]=$this->overview_category_m_model->getById($id);
            
            $data[POC_CATEGORY_NAME] = $name;
            $data[POC_DISPLAY_ORDER] = $display_order;
            $data[POC_PRODUCTION_OVERVIEW_GROUP_CODE] = $group_m;
            try{
                 $result = $this->overview_category_m_model->edit($id,$data);
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
            $arr_where[POC_PRODUCTION_SUMMARY_CODE] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, PRODUCTION_OVERVIEW_CATEGORY_M);

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
        $title = $this->lang->line('ms_overview_category_m');
        // Data
        $result = $this->overview_category_m_model->getAll(); 
        // Column name
        $column_title = array(POC_PRODUCTION_SUMMARY_CODE,POC_PRODUCTION_OVERVIEW_GROUP_CODE, POC_DISPLAY_ORDER, POC_CATEGORY_NAME);
        $column_show_data =array(POC_PRODUCTION_SUMMARY_CODE,POC_PRODUCTION_OVERVIEW_GROUP_CODE, POC_DISPLAY_ORDER, POC_CATEGORY_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_overview_category_m');
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
            $this->overview_category_m_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[POC_PRODUCTION_SUMMARY_CODE]        = (isset($value['A']) ? $value['A'] : null);
                $data[POC_PRODUCTION_OVERVIEW_GROUP_CODE] = (isset($value['B']) ? $value['B'] : null);
                if(!$this->overview_category_m_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;

                }
               
                $data[POC_DISPLAY_ORDER] = (isset($value['C']) ? $value['C'] : null);
                $data[POC_CATEGORY_NAME] = (isset($value['D']) ? $value['D'] : null);
                
                // Xóa trùng
                $where_dup[POC_PRODUCTION_SUMMARY_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->overview_category_m_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->overview_category_m_model->add($data);

                if ($this->overview_category_m_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->overview_category_m_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->overview_category_m_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->overview_category_m_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", PRODUCTION_OVERVIEW_CATEGORY_M);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->overview_category_m_model->db->trans_rollback();
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
