<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SupplierController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier','supplier_model');
        $this->load->model('Supplier_Category','supplier_category_model');
        $this->load->model('User','user_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_supplier');
        $data['content'] ='masters/supplier/index';
        $data['list_contact_user'] = $this->user_model->getAll();
        $this->load->view('templates/master',$data);
    }
    public function edit_supplier() {

        $data['title'] = $this->lang->line('ms_edit_supplier');
        $data['content'] ='masters/supplier/edit_supplier';
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
            $meta = $this->input->post('meta');
            $master[SUP_SUPPLIER_COMPANY_NAME]               = $meta['sup_company_name'];
            $master[SUP_PHONE_NUMBER]                        = $meta['sup_phone_number'];
            $master[SUP_USER_ID]                             = $meta['sup_contact_name'];
            $master[SUP_FAX_NUMBER]                          = $meta['sup_fax_number'];
            $master[SUP_ADDRESS_1]                           = $meta['sup_address_1'];
            $master[SUP_ADDRESS_2]                           = $meta['sup_address_2'];
            $master[SUP_POSTAL_CODE]                         = $meta['sup_postal_code'];
            $master[SUP_CLOSING_DATE]                        = $meta['sup_closing_date'];
            $master[SUP_PAYMENT_SITE]                        = $meta['sup_payment_site'];
            $master[SUP_VENDOR_ID]                           = $meta['sup_vendor_id'];
            $data_log_edit["data_old"]=$this->supplier_model->getById($id);
            try{
                $this->supplier_model->db->trans_begin();
                $this->supplier_model->edit($id,$master,T_SUPPLIER);

                if ($this->supplier_model->db->trans_status() === FALSE){
                     $this->supplier_model->db->trans_rollback();
                      echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                }
                else
                {
                    // Log Edit
                    $arr_where[SUP_ID] = $id;
                    $data_log_edit["id"]=$arr_where;
                    $data_log_edit["data_new"]=$master;
                    logedit($data_log_edit, T_SUPPLIER);

                        $this->supplier_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                }
               
             }catch(Exception $ex){
                $this->supplier_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
        }
        //$data['list_category'] = $this->category_model->getAll();
        $id = $this->input->get('id');
        $data['master'] = $this->supplier_model->getById($id);
        if($data['master'] == NULL){
            redirect( base_url('master/supplier'), 'refresh');
            exit();
        }
        //$data['list_contact_user'] = $this->user_model->getAll();
        $data['list_sup_vendor'] = $this->supplier_category_model->getAll();
        $this->load->view('templates/master',$data);
    }
    public function search_supplier(){
        $data['sup_id'] = $this->input->get('sup_id');
        $data['sup_company_name'] = $this->input->get('sup_company_name');
        $data['sup_phone_number'] = $this->input->get('sup_phone_number');
        $data['sup_contact_name'] = $this->input->get('sup_contact_name');
        $data['sup_fax_number']   = $this->input->get('sup_fax_number');
        $data['sup_address']    = $this->input->get('sup_address');
        $data['sup_postal_code']    = $this->input->get('sup_postal_code');
        $start_index      = $this->input->get('start_index');

        if($start_index == NULL){ 
            $start_index = 0;
        } 
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->supplier_model->search_supplier($data,$start_index,PAGE_SIZE,SUP_ID,SORT_MASTER);
        }
        ///$result = $this->supplier_model->search_supplier($data,$start_index,PAGE_SIZE,SUP_ID,"ASC");
        
        echo json_encode($result);

    }
    public function create_supplier() {
        $data['title'] = $this->lang->line('ms_create_supplier');
        $data['content'] ='masters/supplier/create_supplier';
         if($this->input->server("REQUEST_METHOD") == "POST"){
            $meta = $this->input->post('meta');
            $checkIsExits = $this->supplier_model->isExitsRow(SUP_ID,$meta['sup_id'] );
            
            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }

            $master[SUP_ID]                                  = $meta['sup_id'];
            $master[SUP_SUPPLIER_COMPANY_NAME]               = $meta['sup_company_name'];
            $master[SUP_PHONE_NUMBER]                        = $meta['sup_phone_number'];
            $master[SUP_USER_ID]                             = $meta['sup_contact_name'];
            $master[SUP_FAX_NUMBER]                          = $meta['sup_fax_number'];
            $master[SUP_ADDRESS_1]                           = $meta['sup_address_1'];
            $master[SUP_ADDRESS_2]                           = $meta['sup_address_2'];
            $master[SUP_POSTAL_CODE]                         = $meta['sup_postal_code'];
            $master[SUP_CLOSING_DATE]                        = $meta['sup_closing_date'];
            $master[SUP_PAYMENT_SITE]                        = $meta['sup_payment_site'];
            $master[SUP_VENDOR_ID]                           = $meta['sup_vendor_id'];
            try{
                $this->supplier_model->db->trans_begin();
                $this->supplier_model->add($master,T_SUPPLIER);

                if ($this->supplier_model->db->trans_status() === FALSE){
                     $this->supplier_model->db->trans_rollback();
                      echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                }
                else
                {
                         // LOG ADD
                        logadd(SUP_ID . ":".$meta['sup_id'], T_SUPPLIER);
                        $this->supplier_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                }
               
             }catch(Exception $ex){
                $this->supplier_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
        }
        //$data['list_contact_user'] = $this->user_model->getAll();
        $data['list_sup_vendor'] = $this->supplier_category_model->getAll();
        
        $this->load->view('templates/master',$data);
    }
    
    public function delete_supplier(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->supplier_model->remove($id,T_SUPPLIER);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(SUP_ID . ":".$id, T_SUPPLIER);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    
/**
    * Function: export
    * @access public
    */
    public function export(){

        $title = $this->lang->line('ms_supplier');
        // Data
        $result = $this->supplier_model->getAll(); 
        // Column name
        $column_title = array(SUP_ID,SUP_SUPPLIER_COMPANY_NAME,SUP_ADDRESS_1,SUP_ADDRESS_2
            , SUP_POSTAL_CODE, SUP_PHONE_NUMBER, SUP_FAX_NUMBER,SUP_CLOSING_DATE , SUP_PAYMENT_SITE, SUP_USER_ID,SUP_VENDOR_ID);
        $column_show_data = array(SUP_ID,SUP_SUPPLIER_COMPANY_NAME,SUP_ADDRESS_1,SUP_ADDRESS_2
            , SUP_POSTAL_CODE, SUP_PHONE_NUMBER, SUP_FAX_NUMBER,SUP_CLOSING_DATE , SUP_PAYMENT_SITE, SUP_USER_ID,SUP_VENDOR_ID);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }

    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_supplier');
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
            $this->supplier_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[SUP_ID]        = (isset($value['A']) ? $value['A'] : null);
                if(!$this->supplier_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;

                }
                $data[SUP_SUPPLIER_COMPANY_NAME] = (isset($value['B']) ? $value['B'] : null);
                $data[SUP_ADDRESS_1] = (isset($value['C']) ? $value['C'] : null);
                $data[SUP_ADDRESS_2] = (isset($value['D']) ? $value['D'] : null);
                $data[SUP_POSTAL_CODE] = (isset($value['E']) ? $value['E'] : null);
                $data[SUP_PHONE_NUMBER] = (isset($value['F']) ? $value['F'] : null);
                $data[SUP_FAX_NUMBER] = (isset($value['G']) ? $value['G'] : null);
                $data[SUP_CLOSING_DATE] = (isset($value['H']) ? $value['H'] : null);
                $data[SUP_PAYMENT_SITE] = (isset($value['I']) ? $value['I'] : null);
                $data[SUP_USER_ID] = (isset($value['J']) ? $value['J'] : null);
                $data[SUP_VENDOR_ID] = (isset($value['K']) ? $value['K'] : null);
                // Xóa trùng
                $where_dup[SUP_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->supplier_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->supplier_model->add($data);

                if ($this->supplier_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->supplier_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->supplier_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->supplier_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", T_SUPPLIER);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->supplier_model->db->trans_rollback();
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
