<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_washingController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_washing','m_washing_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_M_washing');
        $data['content'] ='masters/M_washing/index';
        $this->load->view('templates/master',$data);
    }
    public function search(){
        $data['item_id'] = $this->input->get('item_id');
        $data['item_name'] = $this->input->get('item_name');
        $data['id'] = $this->input->get('id');
        $start_index      = $this->input->get('start_index');
        if($start_index == NULL){ 
            $start_index = 0;
        } 
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
           $result = $this->m_washing_model->search($data,$start_index,PAGE_SIZE,LM_CODE,SORT_MASTER);
        }
        
        echo json_encode($result);
    }
    public function delete(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->m_washing_model->remove($id,LAUNDRY_M);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(LM_CODE . ":".$id, LAUNDRY_M);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $item_name_1 = $this->input->post("item_name_1");
            $item_name_2 = $this->input->post("item_name_2");
            $weight = $this->input->post("weight");
            $temperature = $this->input->post("temperature");
            $checkIsExits = $this->m_washing_model->isExitsRow(LM_CODE,$id );

            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }
            $data[LM_CODE] = $id;
            $data[LM_ITEM_NAME_1] = $item_name_1;
            $data[LM_ITEM_NAME_2] = $item_name_2;
            $data[LM_WEIGHT] = $weight;
            $data[LM_WASHING_TEMPERATURE] = $temperature;
            $result = $this->m_washing_model->added($data);
            if(!$result){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['id']          = $id;
            $data['item_name_1'] = $item_name_1;
            $data['item_name_2'] = $item_name_2;
            $data['weight']      = $weight;
            $data['temperature'] = $temperature;

            // LOG ADD
            logadd(LM_CODE . ":".$id, LAUNDRY_M);
            
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
            $item_name_1 = $this->input->post("item_name_1");
            $item_name_2 = $this->input->post("item_name_2");
            $weight = $this->input->post("weight");
            $temperature = $this->input->post("temperature");
            $data_log_edit["data_old"]=$this->m_washing_model->getById($id);

            $data[LM_ITEM_NAME_1] = $item_name_1;
            $data[LM_ITEM_NAME_2] = $item_name_2;
            $data[LM_WEIGHT] = $weight;
            $data[LM_WASHING_TEMPERATURE] = $temperature;
            try{
                 $result = $this->m_washing_model->edit($id,$data);
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
            $arr_where[LM_CODE] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, LAUNDRY_M);

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
        $title = $this->lang->line('ms_M_washing');
 
        // Data
        $result = $this->m_washing_model->getAll(); 
        
        // Column name
        $column_title = array(LM_CODE,LM_ITEM_NAME_1,LM_ITEM_NAME_2, LM_WEIGHT, LM_WASHING_TEMPERATURE);
        $column_show_data =array(LM_CODE,LM_ITEM_NAME_1,LM_ITEM_NAME_2, LM_WEIGHT, LM_WASHING_TEMPERATURE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_M_washing');
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
            $this->m_washing_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[LM_CODE]        = (isset($value['A']) ? $value['A'] : null);

                if(!$this->m_washing_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                
                $data[LM_WEIGHT] = (isset($value['D']) ? $value['D'] : null);
                

                if(!$this->m_washing_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                $data[LM_ITEM_NAME_1] = (isset($value['B']) ? $value['B'] : null);
                $data[LM_ITEM_NAME_2] = (isset($value['C']) ? $value['C'] : null);
                $data[LM_WASHING_TEMPERATURE] = (isset($value['E']) ? $value['E'] : null);
                // Xóa trùng
                $where_dup[LM_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->m_washing_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->m_washing_model->add($data);

                if ($this->m_washing_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->m_washing_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->m_washing_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->m_washing_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", LAUNDRY_M);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->m_washing_model->db->trans_rollback();
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
