<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Initial_InventoryController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Initial_Inventory','initial_inventory_model');
        $this->load->model('Product','product_model');
        $this->load->model('Base_master','base_model');
        $this->load->model('ImportExportCsv');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_initial_inventory');
        $data['content'] ='masters/initial_inventory/index';
        $data['list_product'] = $this->product_model->getAll();
        $data['list_base'] = $this->base_model->getAll();
    
        $this->load->view('templates/master',$data);
    }
    
    public function search(){
        $data['in_product'] = $this->input->get('in_product');
        $data['in_base']    = $this->input->get('in_base');
        $data['in_from_date']   = $this->input->get('in_from_date');
        $data['in_to_date']      = $this->input->get('in_to_date');
       
        $start_index      = $this->input->get('start_index');

        if($start_index == NULL){ 
            $start_index = 0;
        } 
        //PAGE_SIZE
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->initial_inventory_model->search($data,$start_index,PAGE_SIZE,IN_ID,SORT_MASTER);
        }
        echo json_encode($result);
    }
    public function delete(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->initial_inventory_model->remove($id,INITIAL_INVENTORY);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
            logdelete(IN_ID . ":".$id, INITIAL_INVENTORY);
            
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $meta               = $this->input->post("meta");
            $in_base            = $meta["in_base"];
            $name_in_base       = $meta["name_in_base"];
            $in_product         = $meta["in_product"];
            $name_in_product    = $meta["name_in_product"];
            $in_initial_amount  = $meta["in_initial_amount"];
            $in_date            = $meta["in_date"];
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
                    $data[IN_DATE]          = $in_date;
                    $data[IN_BASE_CODE]     = $in_base;
                    $data[IN_PRODUCT]       = $product;
                    $row_where = $this->initial_inventory_model->getWhere($data);
                    $count_row_where = count($row_where);
                    if($count_row_where > 0) {
                        $this->initial_inventory_model->db->trans_rollback();
                        echo json_encode(array(
                                "success" => false,
                                "name_product"  => $name_product,
                                "message" =>  $this->lang->line("message_exits_name_product_error")
                            ));
                        
                        return;
                    }

                    $data[IN_INITIAL_AMOUNT]= $amount;
                   
                    $result = $this->initial_inventory_model->add($data);
                    if(!$result){
                        $this->initial_inventory_model->db->trans_rollback();
                        echo json_encode(array(
                                "success" => false,
                                "message" =>  $this->lang->line("message_add_error")
                            ));
                            return;
                    }

                    $arrayName = array(
                             'id' => $result,
                             'in_base' => $name_in_base,
                             'in_product' =>   $name_product,
                             'in_initial_amount'  =>   $amount,
                             'in_date' => $in_date,
                     );
                    array_push($dataRespone,$arrayName);
                  
                }
                
                if ($this->initial_inventory_model->db->trans_status() === FALSE)
                {
                    $this->initial_inventory_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
                }
                else
                {
                    $this->initial_inventory_model->db->trans_commit();
                    //LOG ADD
                    logadd(IN_ID . ":".$result, INITIAL_INVENTORY);
                    echo json_encode(array(
                        "success" => true,
                        "message" =>  $this->lang->line("message_add_success"),
                        "data" => $dataRespone
                    ));
                    return;
                }
             }catch(Exception $ex){
                $this->initial_inventory_model->db->trans_rollback();
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

            $in_initial_amount  = $this->input->post("in_initial_amount");
            $data_log_edit["data_old"]=$this->initial_inventory_model->getById($id);
            $data[IN_INITIAL_AMOUNT]= $in_initial_amount;

            $result = $this->initial_inventory_model->edit($id, $data);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }
            // Log Edit
            $arr_where[IN_ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, INITIAL_INVENTORY);

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
        $title = $this->lang->line('ms_initial_inventory');
 
        // Data
        $result = $this->initial_inventory_model->getAll(); 
        
        // Column name
        $column_title = array(IN_DATE,IN_BASE_CODE, IN_PRODUCT, IN_INITIAL_AMOUNT);
        $column_show_data = array(IN_DATE,IN_BASE_CODE, IN_PRODUCT, IN_INITIAL_AMOUNT);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_initial_inventory');
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
            $this->initial_inventory_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                
                $data[IN_DATE] = (isset($value['A']) ? $value['A'] : null);
                $data[IN_BASE_CODE] = (isset($value['B']) ? $value['B'] : null);
                $data[IN_PRODUCT] = (isset($value['C']) ? $value['C'] : null);
                $data[IN_INITIAL_AMOUNT] = (isset($value['D']) ? $value['D'] : null);
               
                // Xóa trùng
                $where_dup[IN_DATE] = (isset($value['A']) ? $value['A'] : null);
                $where_dup[IN_BASE_CODE] = (isset($value['B']) ? $value['B'] : null);
                $where_dup[IN_PRODUCT] = (isset($value['C']) ? $value['C'] : null);
               
                $this->initial_inventory_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->initial_inventory_model->add($data);

                if ($this->initial_inventory_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->initial_inventory_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->initial_inventory_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->initial_inventory_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", INITIAL_INVENTORY);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->initial_inventory_model->db->trans_rollback();
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
