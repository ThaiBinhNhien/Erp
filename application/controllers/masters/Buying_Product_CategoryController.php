<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Buying_Product_CategoryController extends VV_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('T_Category','t_category_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
	public function index() {
		$data['title'] = $this->lang->line('ms_buying_product_category');
        $data['content'] ='masters/buying_product_category/index';
        $this->load->view('templates/master',$data);
	}
	public function search_category(){
        $data['cat_id'] = $this->input->get('cat_id');
        $data['cat_name'] = $this->input->get('cat_name');
        $start_index      = $this->input->get('start_index');
        if($start_index == NULL){ 
            $start_index = 0;
        } 

        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->t_category_model->search_category($data,$start_index,PAGE_SIZE,ID,SORT_MASTER);
        }
       
   
        echo json_encode($result);
    }
    public function delete_category(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->t_category_model->remove($id,T_PRODUCT_CATEGORY);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
			logdelete(ID . ":".$id, T_PRODUCT_CATEGORY);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create_category(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $checkIsExits = $this->t_category_model->isExitsRow(ID,$id );

            if($checkIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_id_error")
                ));
                return;
            }
            $data[ID] = $id;
            $data[TPC_NAME] = $name;
            $result = $this->t_category_model->added($data);
            if(!$result){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['category_id'] = $id;
            $data['category_name'] = $name;

            // LOG ADD
			logadd(ID . ":".$id, T_PRODUCT_CATEGORY);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success"),
                        "data" => $data
            ));
        }
    }

    public function edit_category(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $data[TPC_NAME] = $name;
            $data_log_edit["data_old"]=$this->t_category_model->getById($id);
            try{
                 $result = $this->t_category_model->edit($id,$data);
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
            $arr_where[ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, T_PRODUCT_CATEGORY);

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
        $title = $this->lang->line('ms_buying_product_category');
        // Data
        $result = $this->t_category_model->getAll(); 
        // Column name
        $column_title = array(ID,TPC_NAME);
        $column_show_data =array(ID,TPC_NAME);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_buying_product_category');
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
            $this->t_category_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[ID]        = (isset($value['A']) ? $value['A'] : null);
                if(!$this->t_category_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;

                }
                
                $data[TPC_NAME] = (isset($value['B']) ? $value['B'] : null);
                // Xóa trùng
                $where_dup[ID] = (isset($value['A']) ? $value['A'] : null);
                $this->t_category_model->removeByWhere($where_dup);
                
                // Add 
                $result = $this->t_category_model->add($data);

                if ($this->t_category_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->t_category_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->t_category_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->t_category_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", T_PRODUCT_CATEGORY);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->t_category_model->db->trans_rollback();
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
