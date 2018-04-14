<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerController extends VV_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer','customer_model');
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('Department','department_model');
        $this->load->model('User','user_model');
        $this->load->model('ImportExportCsv');
    }
	public function index() {
		$data['title'] = $this->lang->line('ms_customer');
        $data['content'] ='masters/customer/index';
        $data['lstCus'] = $this->customer_model->getAll(0,PAGE_SIZE);
       
        $this->load->view('templates/master',$data); 
	}
	public function edit_customer() {
		$data['title'] = $this->lang->line('ms_edit_customer');
        $id = $this->input->get("id");
        $data['customer'] = $this->customer_model->getById($id);
        if($data['customer'] == NULL){
            redirect( base_url('master/customer'), 'refresh');
            exit();
        }
        $data['lstUser'] = $this->user_model->getUserNotCustomer();
        foreach ($data['lstUser'] as $key => $value) {
            $data['lstUser'][$key]['id'] = $value[U_ID];
        }
        $data['lstDepartment'] = $this->department_model->getAll();
        $data['department'] = $this->customer_department_model->getByCustomer($data['customer'][CUS_ID]);
        $data['userInfo'] = $this->user_model->getById($data['customer'][CUS_ACCOUNT_ID]);
        $data['content'] ='masters/customer/edit_customer';
        $this->load->view('templates/master',$data);
	}
	public function create_customer() {
        $data['title'] = $this->lang->line('ms_add_customer');
        $data['lstUser'] = $this->user_model->getUserNotCustomer();
        foreach ($data['lstUser'] as $key => $value) {
            $data['lstUser'][$key]['id'] = $value[U_ID];
        }
        $data['lstDepartment'] = $this->department_model->getAll();
        $data['content'] ='masters/customer/create_customer';
        $this->load->view('templates/master',$data);
    }

    public function import_master(){
        $title = $this->lang->line('ms_customer');
        $filename = $_FILES["import_file"]["tmp_name"];
        $target_file = $_FILES["import_file"]["name"];

        // Import Csv
        $is_import = false;
        $is_dup = false;
        $error_line = 0;
        $index = 0;
        $sheetData = $this->ImportExportCsv->import_detail($filename);
        if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
        }
        try{
            $this->customer_model->db->trans_begin();

            foreach ($sheetData['master'] as $key => $value) {
                $item = array();
                $item[CUS_ID] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->customer_model->checkDataNumber($item)){
                    $error_line = $key+1;
                    break;
                }
                
                $item[CUS_CUSTOMER_NAME] = (isset($value['B']) ? $value['B'] : null);
                $item[CUS_CLOSING_DATE_CODE] = (isset($value['C']) ? $value['C'] : null);
                $item[CUS_ADDRESS_1] = (isset($value['D']) ? $value['D'] : null);
                $item[CUS_ADDRESS_2] = (isset($value['E']) ? $value['E'] : null);
                $item[CUS_PHONE_NUMBER] = (isset($value['F']) ? $value['F'] : null);
                $item[CUS_FACSIMILE] = (isset($value['G']) ? $value['G'] : null);
                $item[CUS_TYPE_CUSTOMER] = (isset($value['H']) ? $value['H'] : null);
                $item[CUS_ACCOUNT_ID] = (isset($value['I']) ? $value['I'] : null);
                
                $where_dup[CUS_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->customer_model->removeByWhere($where_dup);

                $result = $this->customer_model->add($item);
                if ($this->customer_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                $index = $key + 1;                      
            }
            if ($this->customer_model->db->trans_status() === FALSE || $error_line != 0)
            {

                $this->customer_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                    
                $this->customer_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", CUSTOMER);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->customer_model->db->trans_rollback();
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
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

    public function import_detail_1(){
        $title = $this->lang->line('ms_customer');
        $filename = $_FILES["import_file"]["tmp_name"];
        $target_file = $_FILES["import_file"]["name"];

        // Import Csv
        $is_import = false;
        $is_dup = false;
        $error_line = 0;
        $index = 0;
        $sheetData = $this->ImportExportCsv->import_detail($filename);
        if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
        }
        try{
            $this->customer_department_model->db->trans_begin();

            foreach ($sheetData['master'] as $key => $value) {
                $item = array();
                $item[CUS_DE_ID] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->customer_department_model->checkDataNumber($item)){
                    $error_line = $key+1;
                    break;
                }
                
                $item[CUS_DE_ID] = (isset($value['A']) ? $value['A'] : null);
                $item[CD_CUSTOMER_ID] = (isset($value['B']) ? $value['B'] : null);
                $item[CD_DEPARTMENT_CODE] = (isset($value['C']) ? $value['C'] : null);
                $item[CD_NOT_ASK_MONEY] = (isset($value['D']) ? intval($value['D']) : 0); 
                $item[CD_USER_ID] = (isset($value['E']) ? $value['E'] : null);
                $item[CD_FL_COPY_SHIPMENT] = (isset($value['F']) ? intval($value['F']) : 0);

                $where_dup[CUS_DE_ID] = $item[CUS_DE_ID];
                $this->customer_department_model->removeByWhere($where_dup);
                
                $result = $this->customer_department_model->add($item);
                if ($this->customer_department_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                $index = $key + 1;                      
            }
            if ($this->customer_department_model->db->trans_status() === FALSE || $error_line != 0)
            {

                $this->customer_department_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                    
                $this->customer_department_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", CUSTOMER_DEPARTMENT);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->customer_department_model->db->trans_rollback();
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
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

    public function export_master(){
        $title = $this->lang->line('ms_customer');
        $column_title = array(CUS_ID,CUS_CUSTOMER_NAME,CUS_CLOSING_DATE_CODE,CUS_ADDRESS_1,CUS_ADDRESS_2,CUS_PHONE_NUMBER,CUS_FACSIMILE,CUS_TYPE_CUSTOMER,CUS_ACCOUNT_ID);
        $column_show_data = array(CUS_ID,CUS_CUSTOMER_NAME,CUS_CLOSING_DATE_CODE,CUS_ADDRESS_1,CUS_ADDRESS_2,CUS_PHONE_NUMBER,CUS_FACSIMILE,CUS_TYPE_CUSTOMER,CUS_ACCOUNT_ID);

        $data = array();
        $item['title'] = $title;
        $item['column_title'] = $column_title;
        $item['column_show_data'] = $column_show_data;
        $item['column_value_data'] = $this->customer_model->getAll();
        array_push($data,$item);

        $this->ImportExportCsv->export_detail($title, $data); 
    }

    public function export_detail_1(){
        $data = array();
        $item['title'] = CUSTOMER_DEPARTMENT; 
        $item['column_title'] = array(CUS_DE_ID,CD_CUSTOMER_ID,CD_DEPARTMENT_CODE,CD_NOT_ASK_MONEY,CD_USER_ID,CD_FL_COPY_SHIPMENT);
        $item['column_show_data'] = array(CUS_DE_ID,CD_CUSTOMER_ID,CD_DEPARTMENT_CODE,CD_NOT_ASK_MONEY,CD_USER_ID,CD_FL_COPY_SHIPMENT);
        $item['column_value_data'] = $this->customer_department_model->getAvaiable();
        array_push($data,$item);
         $this->ImportExportCsv->export_detail($item['title'], $data); 
    }

    public function get_customer_selectbox(){ 
        $p = $this->input->get('p');
        $q = $this->input->get('q');
        $per_page = $this->input->get('per_page');
        
        $page = $p > 0 ? ($p - 1) : 1;
        $start_index = $page * PAGE_SIZE_SELECTBOX;

        $result = array();
        $result = $this->customer_model->getCustomerSelectBox($q,false,$start_index,PAGE_SIZE_SELECTBOX,PL_PRODUCT_ID,SORT_MASTER);
        $count = $this->customer_model->getCustomerSelectBox($q,true);

        echo json_encode(['msg' => "", 'p' => $p, 'count' => $count, 'per_page' => $per_page
        , 'data' => $result]);
    }


    public function get_infor_of_customer(){ 
        $customer = $this->input->get('customer');
        $result = $this->customer_model->getInforByCustomer($customer);
        echo json_encode($result);
    }
}
