<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Washing_CategoryController extends VV_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Washing_Category','washing_category_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');

    }
	public function index() {
		$data['title'] = $this->lang->line('ms_washing_category');
		$data['washing_category'] = $this->washing_category_model->getAll();
        $data['content'] ='masters/washing_category/index';
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
            $this->washing_category_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
                $data = array();
                $data[TLG_ID] = (isset($value['A']) ? $value['A'] : null);

                if(!$this->washing_category_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                
                $data[TLG_NAME] = (isset($value['B']) ? $value['B'] : null);

                $where_dup[TLG_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->washing_category_model->removeByWhere($where_dup);

                $result = $this->washing_category_model->add($data);
                if ($this->washing_category_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->washing_category_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->washing_category_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->washing_category_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", T_LAUNDRY_SEGMENT);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->washing_category_model->db->trans_rollback();
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
        $title = $this->lang->line('ms_washing_category');

        // Data
        $result = $this->washing_category_model->getAll(); 
        
        // Column name
        $column_title = array(TLG_ID,TLG_NAME);
        $column_show_data = array(TLG_ID,TLG_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    

}
