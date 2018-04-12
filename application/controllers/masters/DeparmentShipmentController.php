<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DeparmentShipmentController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('DepartmentShipment','department_model');
        $this->load->model('Group_code','group_code_model');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
        $this->load->model('ImportExportCsv');
    } 
	public function index() {
		$data['title'] = $this->lang->line('ms_deparment_shipment');
        $data['department'] = $this->department_model->getDepartmentView('','','');
        $data['group_code'] = $this->group_code_model->getAll();
        $data['content'] ='masters/deparment_shipment/index';
        $this->load->view('templates/master',$data);
	}
	public function get_department_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $code = $this->input->get('code');
        $result = $this->department_model->getDepartmentView($id, $name,$code);
        echo json_encode($result);
    }

    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $data[DSL_DEPARTMENT_CODE] = $id;
            $data[DSL_DEPARTMENT_NAME] = $name;
            $result = $this->department_model->add($data);
            if($this->db->affected_rows() == 0){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['id'] = $id;
            $data['name'] = $name;
            // LOG ADD
			logadd(DSL_DEPARTMENT_CODE . ":".$id, DEPARTMENT_SHIPMENT_LEDGER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success"),
                        "data" => $data
                    ));
        }
    }

    public function remove(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->department_model->remove($id,DEPARTMENT_SHIPMENT_LEDGER);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                    return;
            }
            // LOG DELETE
			logdelete(DSL_DEPARTMENT_CODE . ":".$id, DEPARTMENT_SHIPMENT_LEDGER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }

    public function edit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $id_change = $this->input->post("id_change");
            $name = $this->input->post("name");
            $data_log_edit["data_old"]=$this->department_model->getById($id_change);
            $data[DSL_DEPARTMENT_NAME] = $name;
            $data[DSL_DEPARTMENT_CODE] = $id_change;
            try{
                 $result = $this->department_model->edit($id,$data);
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
            $arr_where[DSL_DEPARTMENT_CODE] = $id_change;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, T_EVENT);

            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
        }
    }

    public function import(){
        $filename = $_FILES["import_file"]["tmp_name"];
        $target_file = $_FILES["import_file"]["name"];
            
        $sheetData = $this->ImportExportCsv->import($filename);
        if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
        }
        $error_line = 0;
        $is_import = false;
        try{
            $this->department_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
                $data = array();
                $data[DSL_DEPARTMENT_CODE] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->department_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                
                $data[DSL_DEPARTMENT_NAME] = (isset($value['B']) ? $value['B'] : null);

                $where_dup[DSL_DEPARTMENT_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->department_model->removeByWhere($where_dup);

                $result = $this->department_model->add($data);
                if ($this->department_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->department_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->department_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->department_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", DEPARTMENT_SHIPMENT_LEDGER);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->department_model->db->trans_rollback();
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
            "message" => $this->lang->line("message_import_error") . " => ".$error_line." 行目のエラー"
        ));
        return; 
        
    }

    public function export(){
        $title = $this->lang->line('ms_deparment');

        // Data
        $result = $this->department_model->getAll(); 
        
        // Column name
        $column_title = array(DSL_DEPARTMENT_CODE,DSL_DEPARTMENT_NAME);
        $column_show_data = array(DSL_DEPARTMENT_CODE,DSL_DEPARTMENT_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
}
