<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Disposal_InventoryController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Disposal_Inventory','disposal_inventory_model');
        $this->load->model('Product','product_model');
        $this->load->model('Base_master','base_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_disposal_inventory');
        $data['content'] ='masters/disposal_inventory/index';
        $data['list_product'] = $this->product_model->getAll();
        $data['list_base'] = $this->base_model->getAll();
    
        $this->load->view('templates/master',$data);
    }
    
    public function search(){
        $data['di_product'] = $this->input->get('di_product');
        $data['di_base']    = $this->input->get('di_base');
        $data['di_from_date']   = $this->input->get('di_from_date');
        $data['di_to_date']      = $this->input->get('di_to_date');
        
      
        $start_index      = $this->input->get('start_index');

        if($start_index == NULL){ 
            $start_index = 0;
        } 
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->disposal_inventory_model->search($data,$start_index,PAGE_SIZE,DI_ID,SORT_MASTER);
        }
        echo json_encode($result);
    }
    public function delete(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->disposal_inventory_model->remove($id,DISPOSAL_INVENTORY);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(DI_ID . ":".$id, DISPOSAL_INVENTORY);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){

            // $di_base            = $this->input->post("di_base");
            // $name_di_base            = $this->input->post("name_di_base");
            // $di_product         = $this->input->post("di_product");
            // $name_di_product         = $this->input->post("name_di_product");
            // $di_disposal_amount  = $this->input->post("di_disposal_amount");
            // $di_date            = $this->input->post("di_date");

            $meta               = $this->input->post("meta");
            $di_base            = $meta["di_base"];
            $name_di_base       = $meta["name_di_base"];
            $di_product         = $meta["di_product"];
            $name_di_product    = $meta["name_di_product"];
            $di_disposal_amount  = $meta["di_disposal_amount"];
            $di_date            = $meta["di_date"];
            $lstProduct = $this->input->post("detail");
            $dataRespone = [];
             try{
                $this->product_model->db->trans_begin();


                foreach ($lstProduct as $key => $value) {
                    $product = $value['product'];
                    $amount = $value['amount'];
                    $name_product = $value['name_product'];
                    //reset avalidable data
                    $data = null;
                    //check key exist
                    $data[DI_DATE]          = $di_date;
                    $data[DI_BASE_CODE]     = $di_base;
                    $data[DI_PRODUCT]       = $product;
                    $row_where = $this->disposal_inventory_model->getWhere($data);
                    $count_row_where = count($row_where);
                    if($count_row_where > 0) {
                        $this->disposal_inventory_model->db->trans_rollback();
                        echo json_encode(array(
                                "success" => false,
                                "name_product"  => $name_product,
                                "message" =>  $this->lang->line("message_exits_name_product_error")
                            ));
                        
                        return;
                    }
                    
                    $data[DI_DISPOSAL_NUMBER]= $amount;
                   
                    $result = $this->disposal_inventory_model->add($data);
                    if(!$result){
                        $this->disposal_inventory_model->db->trans_rollback();
                        echo json_encode(array(
                                "success" => false,
                                "message" =>  $this->lang->line("message_add_error")
                            ));
                            return;
                    }

                    $arrayName = array(
                             'id' => $result,
                             'di_base' => $name_di_base,
                             'di_product' =>   $name_product,
                             'di_disposal_amount'  =>   $amount,
                             'di_date' => $di_date,
                     );
                    array_push($dataRespone,$arrayName);
                  
                }
                if ($this->disposal_inventory_model->db->trans_status() === FALSE)
                {
                    $this->disposal_inventory_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
                }
                else
                {
                    $this->disposal_inventory_model->db->trans_commit();
                    //LOG ADD
                    logadd(DI_ID . ":".$result, DISPOSAL_INVENTORY);
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success"),
                        "data" => $dataRespone
                    ));
                    return;
                }

            }catch(Exception $ex){
                $this->disposal_inventory_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }   

            
        }
    }

    public function edit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");

            $di_disposal_amount  = $this->input->post("di_disposal_amount");
            $data_log_edit["data_old"]=$this->disposal_inventory_model->getById($id);
            $data[DI_DISPOSAL_NUMBER]= $di_disposal_amount;

            $result = $this->disposal_inventory_model->edit($id, $data);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }
            // Log Edit
            $arr_where[DI_ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, DISPOSAL_INVENTORY);

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
        $title = $this->lang->line('ms_disposal_inventory');
 
        // Data
        $result = $this->disposal_inventory_model->getAll(); 
        
        // Column name
        $column_title = array(DI_DATE,DI_BASE_CODE, DI_PRODUCT, DI_DISPOSAL_NUMBER);
        $column_show_data = array(DI_DATE,DI_BASE_CODE, DI_PRODUCT, DI_DISPOSAL_NUMBER);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_disposal_inventory');
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
            $this->disposal_inventory_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                
                $data[DI_DATE] = (isset($value['A']) ? $value['A'] : null);
                $data[DI_BASE_CODE] = (isset($value['B']) ? $value['B'] : null);
                $data[DI_PRODUCT] = (isset($value['C']) ? $value['C'] : null);
                $data[DI_DISPOSAL_NUMBER] = (isset($value['D']) ? $value['D'] : null);
               
                // Xóa trùng
                $where_dup[DI_DATE] = (isset($value['A']) ? $value['A'] : null);
                $where_dup[DI_BASE_CODE] = (isset($value['B']) ? $value['B'] : null);
                $where_dup[DI_PRODUCT] = (isset($value['C']) ? $value['C'] : null);
               
                $this->disposal_inventory_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->disposal_inventory_model->add($data);

                if ($this->disposal_inventory_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->disposal_inventory_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->initial_inventory_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->disposal_inventory_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", DISPOSAL_INVENTORY);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->disposal_inventory_model->db->trans_rollback();
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
