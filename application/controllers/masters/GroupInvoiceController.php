<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GroupInvoiceController extends VV_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_Group','invoice_group_model');
        $this->load->model('Invoice_Group_Detail','invoice_detail_group_model');
        $this->load->model('Customer','customer_model');
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('User','user_model');
        $this->load->model('ImportExportCsv');
    }
	public function index() {
		$data['title'] = $this->lang->line('ms_group_invoice');
        $data['content'] ='masters/group_invoice/index';
        $data['group_invoice'] = $this->invoice_group_model->getAll();
        $this->load->view('templates/master',$data);
	}
	public function edit_group_invoice() {
		$data['title'] = $this->lang->line('ms_edit_group_invoice');
		$id = $this->input->get('id');
		$data['group_invoice'] =  $this->invoice_group_model->getById($id);
        if($data['group_invoice'] == NULL){
                redirect( base_url("master/group-invoice"),'refresh');
                return;
            }
		$data['detail'] = $this->invoice_detail_group_model->get_by_invoice($id);
        $data['cus_id'] = null;
        if(empty($data['detail'])==false){
            $cus_dep = $this->customer_department_model->getById($data['detail'][0][IGD_ID_DEPARTMENT_CUSTOMER]);
            $data['cus_id'] = $cus_dep[CD_CUSTOMER_ID];
            $cus_dep= $this->customer_department_model->getByCustomer($cus_dep[CD_CUSTOMER_ID]);
        } else {
            $cus_dep= $this->customer_department_model->getByCustomer(null);
        }
        $ids = array_column($cus_dep, CUS_DE_ID);
        $data['department'] = $cus_dep;
        $data['cus_dep'] = array_diff($ids, array_column($data['detail'], IGD_ID_DEPARTMENT_CUSTOMER));
        
		$data['customer'] = $this->customer_model->getCustomerInDepartment();
        $data['content'] ='masters/group_invoice/edit_group_invoice';
        $data['lstUser'] = $this->user_model->getAll();
        $this->load->view('templates/master',$data);
	}
	public function create_group_invoice() {
		$data['title'] = $this->lang->line('ms_add_group_invoice');
        $data['content'] ='masters/group_invoice/create_group_invoice';
        $data['customer'] = $this->customer_model->getCustomerInDepartment();
        $data['lstUser'] = $this->user_model->getAll();
        $this->load->view('templates/master',$data);
	}

    /**
    * Function: export
    * @access public
    */
    public function export_master(){
        $title = $this->lang->line('ms_edit_group_invoice');
        $column_title = array(IG_ID,IG_INVOICE_NAME,IG_DISPLAY_NAME,IG_STREET_ADDRESS,IG_STREET_ADDRESS_2,IG_DISCOUNT,IG_ENVIRONMENTAL_CHECK,IG_ENVIRONMENTAL_LOAD,IG_FIXED_AMOUNT,IG_TAX_CHECK,IG_TAX,IG_POST_OFFICE,IG_TELEPHONE,IG_FAX,IG_CLOSING_DATE,IG_AGGREGATE,IG_COLLECTIVE_OUTPUT,TG_USER_ID);
        $column_show_data = array(IG_ID,IG_INVOICE_NAME,IG_DISPLAY_NAME,IG_STREET_ADDRESS,IG_STREET_ADDRESS_2,IG_DISCOUNT,IG_ENVIRONMENTAL_CHECK,IG_ENVIRONMENTAL_LOAD,IG_FIXED_AMOUNT,IG_TAX_CHECK,IG_TAX,IG_POST_OFFICE,IG_TELEPHONE,IG_FAX,IG_CLOSING_DATE,IG_AGGREGATE,IG_COLLECTIVE_OUTPUT,TG_USER_ID);

        $data = array();
        $item['title'] = $title;
        $item['column_title'] = $column_title;
        $item['column_show_data'] = $column_show_data;
        $item['column_value_data'] = $this->invoice_group_model->getAll();
        array_push($data,$item);

        // Column name
        

        $this->ImportExportCsv->export_detail($title, $data);  
    }

    public function export_detail(){
        $title = $this->lang->line('ms_edit_group_invoice');

        $data = array();

        $item['title'] = INVOICE_GROUP_DETAIL;
        $item['column_title'] = array(IGD_ID,IGD_ID_INVOICE_GROUP,IGD_ID_DEPARTMENT_CUSTOMER);
        $item['column_show_data'] = array(IGD_ID,IGD_ID_INVOICE_GROUP,IGD_ID_DEPARTMENT_CUSTOMER);
        $item['column_value_data'] = $this->invoice_detail_group_model->getAvaiable();

        array_push($data,$item);
        // Column name
        

        $this->ImportExportCsv->export_detail($item['title'], $data);  
    }
     
    /**
    * Function: export
    * @access public
    */
    public function import_master(){
        $title = $this->lang->line('ms_edit_group_invoice');
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
            $this->invoice_group_model->db->trans_begin();

            // Empty table
            $this->invoice_group_model->emptyTable();
            foreach ($sheetData['master'] as $key => $value) {
                $item = array();
                $item[IG_ID] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->invoice_group_model->checkDataNumber($item)){
                    $error_line = $key+1;
                    break;
                }
                
                $item[IG_INVOICE_NAME] = (isset($value['B']) ? $value['B'] : null);
                $item[IG_DISPLAY_NAME] = (isset($value['C']) ? $value['C'] : null);
                $item[IG_STREET_ADDRESS] = (isset($value['D']) ? $value['D'] : null);
                $item[IG_STREET_ADDRESS_2] = (isset($value['E']) ? $value['E'] : null);
                $item[IG_DISCOUNT] = (isset($value['F']) ? $value['F'] : null);
                $item[IG_ENVIRONMENTAL_CHECK] = (isset($value['G']) ? $value['G'] : null);
                $item[IG_ENVIRONMENTAL_LOAD] = (isset($value['H']) ? $value['H'] : null);
                $item[IG_FIXED_AMOUNT] = (isset($value['I']) ? $value['I'] : null);
                $item[IG_TAX_CHECK] = (isset($value['J']) ? $value['J'] : null);
                $item[IG_TAX] = (isset($value['K']) ? $value['K'] : null);
                $item[IG_POST_OFFICE] = (isset($value['L']) ? $value['L'] : null);
                $item[IG_FAX] = (isset($value['M']) ? $value['M'] : null);
                $item[IG_CLOSING_DATE] = (isset($value['N']) ? $value['N'] : null);
                $item[IG_AGGREGATE] = (isset($value['O']) ? $value['O'] : null);
                $item[IG_COLLECTIVE_OUTPUT] = (isset($value['P']) ? $value['P'] : null);
                $item[TG_USER_ID] = (isset($value['Q']) ? $value['Q'] : null);

                $where_dup[IG_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->invoice_group_model->removeByWhere($where_dup);

                $result = $this->invoice_group_model->add($item);
                if ($this->invoice_group_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                $index = $key + 1;                      
            }
            if ($this->invoice_group_model->db->trans_status() === FALSE || $error_line != 0)
            {

                $this->invoice_group_model->db->trans_rollback();
                logupcsv($target_file . " (".count($sheetData)." records)", INVOICE_GROUP);
                $is_import = false;
            }
            else
            {
                    
                $this->invoice_group_model->db->trans_commit();
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->invoice_group_model->db->trans_rollback();
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

    public function import_detail(){
        $title = $this->lang->line('ms_edit_group_invoice');
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
            $this->invoice_detail_group_model->db->trans_begin();

            // Empty table
            $this->invoice_detail_group_model->emptyTable();
            foreach ($sheetData['master'] as $key => $value) {
                $item = array();
                $item[IGD_ID] = (isset($value['A']) ? $value['A'] : null);
                $item[IGD_ID_INVOICE_GROUP] = (isset($value['B']) ? $value['B'] : null);
                $item[IGD_ID_DEPARTMENT_CUSTOMER] = (isset($value['C']) ? $value['C'] : null);


                $where_dup[IGD_ID] = $item[IGD_ID];
                $this->invoice_detail_group_model->removeByWhere($where_dup);

                $result = $this->invoice_detail_group_model->add($item);
                if ($this->invoice_detail_group_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                $index = $key + 1;                      
            }
            if ($this->invoice_detail_group_model->db->trans_status() === FALSE || $error_line != 0)
            {

                $this->invoice_detail_group_model->db->trans_rollback();
                logupcsv($target_file . " (".count($sheetData)." records)", INVOICE_GROUP);
                $is_import = false;
            }
            else
            {
                    
                $this->invoice_detail_group_model->db->trans_commit();
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->invoice_detail_group_model->db->trans_rollback();
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
}
