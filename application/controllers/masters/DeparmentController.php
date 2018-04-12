<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DeparmentController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Department','department_model');
        $this->load->model('Group_code','group_code_model');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
        $this->load->model('ImportExportCsv');
    }
	public function index() {
		$data['title'] = $this->lang->line('ms_deparment');
        $data['department'] = $this->department_model->getDepartmentView('','','');
        $data['group_code'] = $this->group_code_model->getAll();
        $data['content'] ='masters/deparment/index';
        $this->load->view('templates/master',$data);
	}
	public function get_department_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $code = $this->input->get('code');
        $result = $this->department_model->getDepartmentView($id, $name,$code);
        echo json_encode($result);
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
                $data[DL_DEPARTMENT_CODE] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->department_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                
                $data[DL_DEPARTMENT_NAME] = (isset($value['B']) ? $value['B'] : null);
                $data[DL_AGGREGATION_CODE] = (isset($value['C']) ? $value['C'] : null);

                $where_dup[DL_DEPARTMENT_CODE] = (isset($value['A']) ? $value['A'] : null);
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
                logupcsv($target_file . " (".count($sheetData)." records)", DEPARTMENT_LEDGER);
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
        $column_title = array(DL_DEPARTMENT_CODE,DL_DEPARTMENT_NAME,DL_AGGREGATION_CODE);
        $column_show_data = array(DL_DEPARTMENT_CODE,DL_DEPARTMENT_NAME,DL_AGGREGATION_CODE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
}
