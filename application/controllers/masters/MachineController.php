<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MachineController extends VV_Controller {
   public function __construct()
    {
        parent::__construct();
        $this->load->model('Machine','machine_model');
        $this->load->model('ImportExportCsv');
    }
	public function index() {
		$data['title'] = $this->lang->line('ms_M_machine');
		$data['machine'] = $this->machine_model->getAll();
        $data['content'] ='masters/machine/index';
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
        
        $error_line = 0;
        $is_import = false;
        try{
            $this->machine_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
                $data = array();
                $data[EQ_CODE] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->machine_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }

                $data[EQ_NAME] = (isset($value['B']) ? $value['B'] : null);

                $where_dup[EQ_CODE] = (isset($value['A']) ? $value['A'] : null);
                $this->machine_model->removeByWhere($where_dup);

                $result = $this->machine_model->add($data);
                if ($this->machine_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->machine_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->machine_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->machine_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", EQUIPMENT_M);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->machine_model->db->trans_rollback();
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
        $title = $this->lang->line('ms_M_machine');

        // Data
        $result = $this->machine_model->getAll(); 
        
        // Column name
        $column_title = array(EQ_CODE,EQ_NAME);
        $column_show_data = array(EQ_CODE,EQ_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
}
