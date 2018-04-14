<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fee_Of_GaichyuController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Fee_Of_Gaichyu','fee_of_gaichyu_model');
        $this->load->model('Customer','customer_model');
        $this->load->model('User','user_model');
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('Department','department_model');
        $this->load->model('Base_master','base_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_fee_of_gaichyu');
        $data['content'] ='masters/fee_of_gaichyu/index';
         // Customer
        $data['list_gaichyu_customer'] = $this->customer_model->getGaichyuCustomerAll();
        //Cu diem gaichyu =1
        $arrWhereBase[BM_MASTER_CHECK] = 1;
        $data['list_gaichyu_base'] = $this->base_model->getWhere($arrWhereBase);
        $data['list_gaichyu_user'] = $this->user_model->getGaichyuUser();
       
        $data['list_department'] = $this->department_model->getAll();
        
        $this->load->view('templates/master',$data);
    }
    
    public function search(){
        $data['gaichyu_customer'] = $this->input->get('gaichyu_customer');
        $data['gaichyu_base'] = $this->input->get('gaichyu_base');
        $data['gaichyu_user'] = $this->input->get('gaichyu_user');
        $data['deparment'] = $this->input->get('deparment');
        $start_index      = $this->input->get('start_index');

        if($start_index == NULL){ 
            $start_index = 0;
        } 
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->fee_of_gaichyu_model->search($data,$start_index,PAGE_SIZE,FG_ID,SORT_MASTER);
        }
        echo json_encode($result);
    }
    public function delete(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->fee_of_gaichyu_model->remove($id,FEE_OF_GAICHYU);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(FG_ID . ":".$id, FEE_OF_GAICHYU);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){

            $gaichyu_customer       = $this->input->post("gaichyu_customer");
            $gaichyu_base           = $this->input->post("gaichyu_base");
            $gaichyu_user           = $this->input->post("gaichyu_user");
            $deparment              = $this->input->post("deparment");
            $tolinen_fee            = $this->input->post("tolinen_fee");
            $enviroment_fee         = $this->input->post("enviroment_fee");
            $laundry_fee            = $this->input->post("laundry_fee");    

            $name_gaichyu_customer  = $this->input->post("name_gaichyu_customer");
            $name_gaichyu_base      = $this->input->post("name_gaichyu_base");
            $name_gaichyu_user      = $this->input->post("name_gaichyu_user");
            $name_deparment         = $this->input->post("name_deparment");

            //check exist
            $where_key[FG_CUSTOMER_ID]     = $gaichyu_customer;
            $where_key[FG_GAICHYU_BASE_ID] = $gaichyu_base;
            $where_key[FG_CONTACT_USER_ID] = $gaichyu_user;

            $row_where = $this->fee_of_gaichyu_model->getWhere($where_key);
            $count_row_where = count($row_where);
            if($count_row_where > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }

            $data[FG_CUSTOMER_ID]       = $gaichyu_customer;
            $data[FG_GAICHYU_BASE_ID]   = $gaichyu_base;
            $data[FG_CONTACT_USER_ID]   = $gaichyu_user;
            $data[FG_TONINEN_FEE]       = $tolinen_fee;
            $data[FG_ENVIROMENT_FEE]    = $enviroment_fee;
            $data[FG_LAUNDRY_FEE]       = $laundry_fee;
            $data[FG_DEPARTMENT_ID]     = $deparment;

            $result = $this->fee_of_gaichyu_model->add($data);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data["id"]       = $result;
            $data["gaichyu_customer_name"]       = $name_gaichyu_customer;
            $data["gaichyu_base_name"]   = $name_gaichyu_base;
            $data["contact_user_name"]   = $name_gaichyu_user;
            $data["tolinen_fee"]         = $tolinen_fee;
            $data["enviroment_fee"]      = $enviroment_fee;
            $data["laundry_fee"]         = $laundry_fee;
            $data["department_name"]     = $name_deparment;

            // LOG ADD
            logadd(FG_ID . ":".$result, FEE_OF_GAICHYU);
            
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
            $deparment              = $this->input->post("deparment");
            $tolinen_fee            = $this->input->post("tolinen_fee");
            $enviroment_fee         = $this->input->post("enviroment_fee");
            $laundry_fee            = $this->input->post("laundry_fee");    

          
            $data_log_edit["data_old"]=$this->fee_of_gaichyu_model->getById($id);
            $data[FG_TONINEN_FEE]       = $tolinen_fee;
            $data[FG_ENVIROMENT_FEE]    = $enviroment_fee;
            $data[FG_LAUNDRY_FEE]       = $laundry_fee;
            $data[FG_DEPARTMENT_ID]     = $deparment;

            $result = $this->fee_of_gaichyu_model->edit($id, $data);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }
            // Log Edit
            $arr_where[FG_ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, FEE_OF_GAICHYU);

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
        $title = $this->lang->line('ms_fee_of_gaichyu');
 
        // Data
        $result = $this->fee_of_gaichyu_model->getAll(); 
        
        // Column name
        $column_title = array(FG_ID,FG_CUSTOMER_ID,FG_GAICHYU_BASE_ID, FG_CONTACT_USER_ID, FG_TONINEN_FEE, FG_ENVIROMENT_FEE, FG_LAUNDRY_FEE, FG_DEPARTMENT_ID);
        $column_show_data =array(FG_ID,FG_CUSTOMER_ID,FG_GAICHYU_BASE_ID, FG_CONTACT_USER_ID, FG_TONINEN_FEE, FG_ENVIROMENT_FEE, FG_LAUNDRY_FEE, FG_DEPARTMENT_ID);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_fee_of_gaichyu');
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
            $this->fee_of_gaichyu_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[FG_ID]        = (isset($value['A']) ? $value['A'] : null);

                if(!$this->fee_of_gaichyu_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                
                $data[FG_CUSTOMER_ID] = (isset($value['B']) ? $value['B'] : null);
                $data[FG_GAICHYU_BASE_ID] = (isset($value['C']) ? $value['C'] : null);

               
                $data[FG_CONTACT_USER_ID] = (isset($value['D']) ? $value['D'] : null);
                $data[FG_TONINEN_FEE] = (isset($value['E']) ? $value['E'] : null);
                $data[FG_ENVIROMENT_FEE] = (isset($value['F']) ? $value['F'] : null);
                $data[FG_LAUNDRY_FEE] = (isset($value['G']) ? $value['G'] : null);
                $data[FG_DEPARTMENT_ID] = (isset($value['H']) ? $value['H'] : null);
                
                // Xóa trùng
                $where_dup[FG_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->fee_of_gaichyu_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->fee_of_gaichyu_model->add($data);

                if ($this->fee_of_gaichyu_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->fee_of_gaichyu_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->fee_of_gaichyu_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->fee_of_gaichyu_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", FEE_OF_GAICHYU);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->fee_of_gaichyu_model->db->trans_rollback();
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
