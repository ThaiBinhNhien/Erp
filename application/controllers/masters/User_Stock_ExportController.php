<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Stock_ExportController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Stock_Export','user_export_model');
        $this->load->model('Base_master','base_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_user_stock_export');
        $data['content'] ='masters/user_stock_export/index';
        $data['list_base'] = $this->base_model->getAll();
    
        $this->load->view('templates/master',$data);
    }
    
    public function search(){
        $data['ux_id'] = $this->input->get('ux_id');
        $data['ux_name'] = $this->input->get('ux_name');
        $data['ux_base']    = $this->input->get('ux_base');
        $data['ux_address']   = $this->input->get('ux_address');
        $data['ux_number']      = $this->input->get('ux_number');
       
        $start_index      = $this->input->get('start_index');

        if($start_index == NULL){ 
            $start_index = 0;
        } 
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->user_export_model->search($data,$start_index,PAGE_SIZE,UX_ID,SORT_MASTER);
        }
        echo json_encode($result);
    }
    public function delete(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->user_export_model->remove($id,USER_STOCK_EXPORT);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(UX_ID . ":".$id, USER_STOCK_EXPORT);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $ux_id                  = $this->input->post("ux_id");
            $ux_name                = $this->input->post("ux_name");
            $ux_name1               = $this->input->post("ux_name1");
            $ux_base                = $this->input->post("ux_base");
            $ux_name_base           = $this->input->post("ux_name_base");
            $ux_regency             = $this->input->post("ux_regency");
            $ux_address             = $this->input->post("ux_address");
            $ux_number              = $this->input->post("ux_number");

            $checkIsExits = $this->user_export_model->isExitsRow(UX_ID,$ux_id);

            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }

            $data[UX_ID]            = $ux_id;
            $data[UX_NAME]          = $ux_name;
            $data[UX_NAME1]         = $ux_name1;
            $data[UX_BASE_CODE]     = $ux_base;
            $data[UX_REGENCY]       = $ux_regency;
            $data[UX_ADDRESS]       = $ux_address;
            $data[UX_NUMBER]        = $ux_number;

            $result = $this->user_export_model->added($data);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data["id"]                 = $ux_id;
            $data["ux_name"]            = $ux_name;
            $data["ux_name1"]           = $ux_name1;
            $data["ux_base"]            = $ux_name_base;
            $data["ux_regency"]         = $ux_regency;
            $data["ux_address"]         = $ux_address;
            $data["ux_number"]          = $ux_number;
           
            // LOG ADD
            logadd(UX_ID . ":".$ux_id, USER_STOCK_EXPORT);
            
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

            $ux_name            = $this->input->post("ux_name");
            $ux_name1            = $this->input->post("ux_name1");
            $ux_base         = $this->input->post("ux_base");
            $ux_regency         = $this->input->post("ux_regency");
            $ux_address  = $this->input->post("ux_address");
            $ux_number            = $this->input->post("ux_number");
            $data_log_edit["data_old"]=$this->user_export_model->getById($id);
            
            $data[UX_NAME]          = $ux_name;
            $data[UX_NAME1]     = $ux_name1;
            $data[UX_BASE_CODE]       = $ux_base;
            $data[UX_REGENCY]= $ux_regency;
            $data[UX_ADDRESS]= $ux_address;
            $data[UX_NUMBER]= $ux_number;
            $result = $this->user_export_model->edit($id, $data);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }
            // Log Edit
            $arr_where[UX_ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, USER_STOCK_EXPORT);

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
        $title = $this->lang->line('ms_user_stock_export');
 
        // Data
        $result = $this->user_export_model->getAll(); 
        
        // Column name
        $column_title = array(UX_ID,UX_NAME,UX_NAME1, UX_BASE_CODE, UX_REGENCY,UX_ADDRESS, UX_NUMBER);
        $column_show_data = array(UX_ID,UX_NAME,UX_NAME1, UX_BASE_CODE, UX_REGENCY,UX_ADDRESS, UX_NUMBER);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_user_stock_export');
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
            $this->user_export_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[UX_ID]        = (isset($value['A']) ? $value['A'] : null);

                if(!$this->user_export_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                

                $data[UX_NAME] = (isset($value['B']) ? $value['B'] : null);
                $data[UX_NAME1] = (isset($value['C']) ? $value['C'] : null);
                $data[UX_BASE_CODE] = (isset($value['D']) ? $value['D'] : null);
                $data[UX_REGENCY] = (isset($value['E']) ? $value['E'] : null);
                $data[UX_ADDRESS] = (isset($value['F']) ? $value['F'] : null);
                $data[UX_NUMBER] = (isset($value['G']) ? $value['G'] : null);
                
                // Xóa trùng
                $where_dup[UX_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->user_export_model->removeByWhere($where_dup);
               
                // Add
                $result = $this->user_export_model->add($data);

                if ($this->user_export_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->user_export_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->user_export_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->user_export_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", USER_STOCK_EXPORT);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->user_export_model->db->trans_rollback();
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
