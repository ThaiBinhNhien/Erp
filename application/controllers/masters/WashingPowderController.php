<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class WashingPowderController extends VV_Controller {
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('WashingPowder','washing_powder_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
	public function index() {
        $data['title'] = $this->lang->line('ms_powder_main'); 
        $id = $this->input->get('id');
        $name = $this->input->get('name');
		$data['washing_powder'] = $this->washing_powder_model->SearchData($id,$name);
        $data['content'] ='masters/washing_powder/index';
        $this->load->view('templates/master',$data);
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
            $this->washing_powder_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
                $data = array();
                $data[DEL_CODE] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->washing_powder_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }

                $data[DEL_NAME] = (isset($value['B']) ? $value['B'] : null);
                $data[DEL_UNIT_PRICE] = (isset($value['C']) ? $value['C'] : null);

                $where_dup[DEL_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->washing_powder_model->removeByWhere($where_dup);

                $result = $this->washing_powder_model->add($data);
                if ($this->washing_powder_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->washing_powder_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->washing_powder_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->washing_powder_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", DETERGENT_LEDGER);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->washing_powder_model->db->trans_rollback();
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
        $title = $this->lang->line('ms_powder_main');

        // Data
        $result = $this->washing_powder_model->getAll(); 
        
        // Column name
        $column_title = array(DEL_CODE,DEL_NAME,DEL_UNIT_PRICE);
        $column_show_data = array(DEL_CODE,DEL_NAME,DEL_UNIT_PRICE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
	
}
