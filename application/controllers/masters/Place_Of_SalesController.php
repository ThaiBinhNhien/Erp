<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Place_Of_SalesController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sales_Destination','sales_destination_model');
        $this->load->model('User','user_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_place_of_sales');
        $data['content'] ='masters/place_of_sales/index';
        $this->load->view('templates/master',$data);
    }

    public function edit() {

        $data['title'] = $this->lang->line('ms_edit_place_of_sales');
        $data['content'] ='masters/place_of_sales/edit';
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
            $meta = $this->input->post('meta');
            $master[TSD_DISTRIBUTOR_NAME]     = $meta['distributor_name'];
            $master[TSD_FAX_NUMBER]     = $meta['fax_number'];
            $master[TSD_POSTAL_CODE]    = $meta['postal_code'];
            $master[TSD_PHONE_NUMBER]    = $meta['phone_number'];
            $master[TSD_ADDRESS_1]      = $meta['address_1'];
            $master[TSD_ADDRESS_2]      = $meta['address_2'];
            $master[TSD_USER_ID]        = $meta['user_id'];
            $master[TSD_OUTSOURCING]        = $meta['outsourcing'];
            $data_log_edit["data_old"]=$this->sales_destination_model->getById($id);
            
            try{
                $this->sales_destination_model->db->trans_begin();
                $this->sales_destination_model->edit($id,$master,T_SALES_DESTINATION);

                if ($this->sales_destination_model->db->trans_status() === FALSE){
                     $this->sales_destination_model->db->trans_rollback();
                      echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                }
                else
                {
                    // Log Edit
            $arr_where[TSD_ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$master;
            logedit($data_log_edit, T_SALES_DESTINATION);

                        $this->sales_destination_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                }
               
             }catch(Exception $ex){
                $this->sales_destination_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }

        }
        //$data['list_category'] = $this->category_model->getAll();
        $id = $this->input->get('id');
        $data['master'] = $this->sales_destination_model->getById($id);
        if($data['master'] == NULL){
            redirect( base_url('master/place_of_sales'), 'refresh');
            exit();
        }
        $data['list_contact_user'] = $this->user_model->getAll();
        $data['list_outsourcing'] = array('0' => 'Tolinen','1' => '外注' );//外注: Order ngoai
        $this->load->view('templates/master',$data);
    }
    public function search(){
        $data['distributor_id'] = $this->input->get('distributor_id');
        $data['distributor_name'] = $this->input->get('distributor_name');
        $data['fax_number'] = $this->input->get('fax_number');
        $data['postal_code'] = $this->input->get('postal_code');
        $data['phone_number'] = $this->input->get('phone_number');
        $data['address'] = $this->input->get('address');
        // $data['address_2'] = $this->input->get('address_2');
        // $data['user_id'] = $this->input->get('user_id');
        // $data['outsourcing'] = $this->input->get('outsourcing');

        $start_index      = $this->input->get('start_index');


        if($start_index == NULL){ 
            $start_index = 0;
        }

        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->sales_destination_model->search($data,$start_index,PAGE_SIZE,TSD_ID,SORT_MASTER);
        }

        echo json_encode($result);
    }
    public function create() {
        $data['title'] = $this->lang->line('ms_create_place_of_sales');
        $data['content'] ='masters/place_of_sales/create';
         if($this->input->server("REQUEST_METHOD") == "POST"){
            $meta = $this->input->post('meta');

            $checkIsExits = $this->sales_destination_model->isExitsRow(TSD_ID,$meta['distributor_id'] );

            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }
            $master[TSD_ID]             = $meta['distributor_id'];
            $master[TSD_DISTRIBUTOR_NAME]   = $meta['distributor_name'];
            $master[TSD_FAX_NUMBER]     = $meta['fax_number'];
            $master[TSD_POSTAL_CODE]    = $meta['postal_code'];
            $master[TSD_PHONE_NUMBER]    = $meta['phone_number'];
            $master[TSD_ADDRESS_1]      = $meta['address_1'];
            $master[TSD_ADDRESS_2]      = $meta['address_2'];
            $master[TSD_USER_ID]        = $meta['user_id'];
            $master[TSD_OUTSOURCING]        = $meta['outsourcing'];
            try{
                $this->sales_destination_model->db->trans_begin();
                $this->sales_destination_model->add($master,T_SALES_DESTINATION);

                if ($this->sales_destination_model->db->trans_status() === FALSE){
                     $this->sales_destination_model->db->trans_rollback();
                      echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                }
                else
                {
                    // LOG ADD
            logadd(TSD_ID . ":". $meta['distributor_id'], T_SALES_DESTINATION);
            
                        $this->sales_destination_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                }
               
             }catch(Exception $ex){
                $this->sales_destination_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
        }
        $data['list_outsourcing'] = array('0' => 'Tolinen','1' => '外注' );//外注: Order ngoai
        $data['list_contact_user'] = $this->user_model->getAll();
        $this->load->view('templates/master',$data);
    }
    
    public function delete(){

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->sales_destination_model->remove($id,T_SALES_DESTINATION);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(TSD_ID . ":".$id, T_SALES_DESTINATION);
            
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
        $title = $this->lang->line('ms_place_of_sales');
        // Data
        $result = $this->sales_destination_model->getAll(); 
        // Column name

        $column_title = array(TSD_ID,TSD_DISTRIBUTOR_NAME,TSD_POSTAL_CODE, TSD_ADDRESS_1, TSD_ADDRESS_2, TSD_PHONE_NUMBER, TSD_FAX_NUMBER, TSD_OUTSOURCING, TSD_USER_ID, TSD_SELLERS_CATEGORY);
        $column_show_data =array(TSD_ID,TSD_DISTRIBUTOR_NAME,TSD_POSTAL_CODE, TSD_ADDRESS_1, TSD_ADDRESS_2, TSD_PHONE_NUMBER, TSD_FAX_NUMBER, TSD_OUTSOURCING, TSD_USER_ID, TSD_SELLERS_CATEGORY);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_place_of_sales');
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
            $this->sales_destination_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[TSD_ID]        = (isset($value['A']) ? $value['A'] : null);
                if(!$this->sales_destination_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;

                }
                $data[TSD_DISTRIBUTOR_NAME] = (isset($value['B']) ? $value['B'] : null);
                $data[TSD_POSTAL_CODE] = (isset($value['C']) ? $value['C'] : null);
                $data[TSD_ADDRESS_1] = (isset($value['D']) ? $value['D'] : null);
                $data[TSD_ADDRESS_2] = (isset($value['E']) ? $value['E'] : null);
                $data[TSD_PHONE_NUMBER] = (isset($value['F']) ? $value['F'] : null);
                $data[TSD_FAX_NUMBER] = (isset($value['G']) ? $value['G'] : null);
                $data[TSD_OUTSOURCING] = (isset($value['H']) ? $value['H'] : null);
                $data[TSD_USER_ID] = (isset($value['I']) ? $value['I'] : null);
                $data[TSD_SELLERS_CATEGORY] = (isset($value['J']) ? $value['J'] : null);
                // Xóa trùng
                $where_dup[ID] = (isset($value['A']) ? $value['A'] : null);
                $this->sales_destination_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->sales_destination_model->add($data);

                if ($this->sales_destination_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->sales_destination_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->sales_destination_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->sales_destination_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", T_SALES_DESTINATION);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->sales_destination_model->db->trans_rollback();
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
