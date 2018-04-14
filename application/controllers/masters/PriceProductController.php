<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PriceProductController extends VV_Controller {

	// Construct function
	public function __construct()
    { 
        parent::__construct(); 
        $this->load->model('Price_model','price_model');
        $this->load->model('Product','product_model');
        $this->load->model('Customer','customer_model');
        $this->load->model('Base_master','base_model');
        $this->load->model('Product_Base','product_base_model');
        $this->load->model('Price_Import','price_import_model');
        $this->load->model('Price_Export','price_export_model');
        $this->load->model('Supplier','supplier_model');
		$this->load->model('Sales_Destination','sales_destination_model');
        $this->load->model('ImportExportCsv');
    }

	public function index() { 
        $data['title'] = $this->lang->line('ms_price_product_title');
        
        // Data
        $type = $this->input->get('type');
        if($type == 2 || $type == 3) {
            // buy
            $data['list_buy'] = $this->supplier_model->getAll();

            // sell
            $data['list_sell'] = $this->sales_destination_model->getAll();
        } else {
            // Base code
            $data['list_base_all'] = $this->base_model->getAll(); 

            $arrWhereBase[BM_MASTER_CHECK] = false;
            $data['list_base'] = $this->base_model->getWhereGaichyu($arrWhereBase);

            $arrWhereBase[BM_MASTER_CHECK] = true;
            $data['list_base_gaichyn'] = $this->base_model->getWhereGaichyu($arrWhereBase);
        }

        $data['content'] ='masters/price_product/index';
        $this->load->view('templates/master',$data);
    }

    /**
	* Function: add
	* @access public
	*/
    public function add() {
        $data['title'] = $this->lang->line('ms_price_product_title');
        $type = $this->input->get('type');
        if($type == 1) {
            $data['content'] ='masters/price_product/add_sale';
        } else if($type == 2){
            $data['content'] ='masters/price_product/add_import';
        } else if($type == 3){
            $data['content'] ='masters/price_product/add_export';
        }
        
        $this->load->view('templates/master',$data);
    }

    /**
    * Function: add_post
    * @access public
    */
    public function add_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $type = $this->input->post('type');

            if($type == 1 || $type == "1") {
                $product = $this->input->post('product');
                $product_name = $this->input->post('product_name');
                $basecode = $this->input->post('basecode');
                $customer = $this->input->post('customer');
                $price = $this->input->post('price');
                $price_gaichyu = $this->input->post('price_gaichyu');
                $type_have = $this->input->post('have');

                try{
                    $this->product_base_model->db->trans_begin();

                    // Check exist
                    /*if($type_have != 'true') {
                        $where_price_meta[BB_PRODUCT_CODE] = $product;
                        if(!empty($basecode)) {
                            $where_price_meta[BB_BASE_CODE] = $basecode;
                        }
                        if(!empty($basecode_gaichyu)) {
                            $where_price_meta[BB_BASE_CODE] = $basecode_gaichyu;
                        }
                        $where_price_meta[BB_CUSTOMER_NUMBER] = $customer;
                        $row_where = $this->product_base_model->getWhere($where_price_meta);
                        $count_row_where = count($row_where);
                        if($count_row_where > 0) {
                            echo json_encode(array(
                                "success" => false,
                                "have" => true,
                                "message" => $this->lang->line("message_error_exits_insert_price")
                            ));
                            return;
                        }
                    }
                    else {
                        $where_price_meta[BB_PRODUCT_CODE] = $product;
                        if(!empty($basecode)) {
                            $where_price_meta[BB_BASE_CODE] = $basecode;
                        }
                        if(!empty($basecode_gaichyu)) {
                            $where_price_meta[BB_BASE_CODE] = $basecode_gaichyu;
                        }
                        $where_price_meta[BB_CUSTOMER_NUMBER] = $customer;
                        $this->product_base_model->removeByWhere($where_price_meta);
                    }*/

                    // Add
                    $list_price_id = "";
                    if($product != null) {
                        foreach ($product as $key => $value) {
                            if($value != null && $value != "") {
                                // Remove
                                $where_price_meta[BB_PRODUCT_CODE] = $value;
                                $where_price_meta[BB_BASE_CODE] = $basecode;
                                $where_price_meta[BB_CUSTOMER_NUMBER] = $customer;
                                $this->product_base_model->removeByWhere($where_price_meta);

                                // Add
                                $price_meta[BB_PRODUCT_CODE] = $value;
                                $price_meta[BB_PRODUCT_NAME] = $product_name[$key];
                                $price_meta[BB_BASE_CODE] = $basecode;
                                $price_meta[BB_CUSTOMER_NUMBER] = $customer;
                                $price_meta[BB_UNIT_SELLING_PRICE] = isset($price[$key]) ? $price[$key] : 0;
                                $price_meta[BB_GAICHYU_PRICE] = isset($price_gaichyu[$key]) ? $price_gaichyu[$key] : 0;
                                
                                if(!empty($price[$key]) && !empty($price_gaichyu[$key])) {
                                    if($price_gaichyu[$key] > $price[$key]){
                                        echo json_encode(array(
                                            "success" => false,
                                            "have" => false,
                                            "message" => $this->lang->line("message_add_error_price_gaichyn")
                                        ));
                                        return;
                                    } 
                                }

                                $price_id = $this->product_base_model->add($price_meta);

                                $list_price_id .= $price_id . ";"; 
                                if ($this->product_base_model->db->trans_status() === FALSE)
                                {
                                    $this->product_base_model->db->trans_rollback();
                                    echo json_encode(array(
                                        "success" => false,
                                        "have" => false,
                                        "message" => $this->lang->line("message_add_error")
                                    ));
                                    return;
                                }
                            } else {
                                $this->product_base_model->db->trans_rollback();
                                echo json_encode(array(
                                    "success" => false,
                                    "have" => false,
                                    "message" => "商品は必須です。ご入力ください。"
                                ));
                                return;
                            }
                        }
                    }

                    // End Query
                    if ($this->product_base_model->db->trans_status() === FALSE)
                    {
                        $this->product_base_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                    }
                    else
                    {
                        // LOG ADD
                        logadd("id :".$list_price_id , PRODUCT_BASE);
                    
                        $this->product_base_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->product_base_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
                }
            } else if($type == 2 || $type == "2") {
                $product = $this->input->post('product');
                $place = $this->input->post('place');
                $note = $this->input->post('note');
                $price = $this->input->post('price');
                $type_have = $this->input->post('have');

                try{
                    $this->price_import_model->db->trans_begin(); 

                    // Check exist
                    /*if($type_have != 'true') {
                        $where_price_meta[TPNS_VENDOR_ID] = $place;
                        $where_price_meta[TPNS_ID_PRODUCT] = $product;
                        $row_where = $this->price_import_model->getWhere($where_price_meta);
                        $count_row_where = count($row_where);
                        if($count_row_where > 0) {
                            echo json_encode(array(
                                "success" => false,
                                "have" => true,
                                "message" => $this->lang->line("message_error_exits_insert_price")
                            ));
                            return;
                        }
                    }
                    else {
                        $where_price_meta[TPNS_VENDOR_ID] = $place;
                        $where_price_meta[TPNS_ID_PRODUCT] = $product;
                        $this->price_import_model->removeByWhere($where_price_meta);
                    }*/

                    // Add
                    $list_price_id = "";
                    if($product != null) {
                        foreach ($product as $key => $value) {
                            // Remove
                            $where_price_meta[TPNS_VENDOR_ID] = $place;
                            $where_price_meta[TPNS_ID_PRODUCT] = $value;
                            $this->price_import_model->removeByWhere($where_price_meta);

                            // AddMeta
                            $price_meta[TPNS_VENDOR_ID] = $place;
                            $price_meta[TPNS_ID_PRODUCT] = $value;
                            $price_meta[TPNS_PURCHASE_PRICE] = isset($price[$key]) ? $price[$key] : 0;
                            $price_meta[TPNS_REMARKS] = isset($note[$key]) ? $note[$key] : "";

                            $price_id = $this->price_import_model->add($price_meta);
                            $list_price_id .= $price_id . ";"; 
                            if ($this->price_import_model->db->trans_status() === FALSE)
                            {
                                $this->price_import_model->db->trans_rollback();
                                echo json_encode(array(
                                    "success" => false,
                                    "have" => false,
                                    "message" => $this->lang->line("message_add_error")
                                ));
                                return;
                            }
                        }
                    }

                    // End Query
                    if ($this->price_import_model->db->trans_status() === FALSE)
                    {
                        $this->price_import_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                    }
                    else
                    {
                        // LOG ADD
                        logadd("id :".$list_price_id , T_PRODUCT_NUMBER_FOR_SUPPLIER);

                        $this->price_import_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->price_import_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
                }
            } else if($type == 3 || $type == "3") {
                $product = $this->input->post('product');
                $place = $this->input->post('place');
                $note = $this->input->post('note');
                $price = $this->input->post('price');
                $type_have = $this->input->post('have');

                try{
                    $this->price_export_model->db->trans_begin(); 

                    // Check exist
                    /*if($type_have != 'true') {
                        $where_price_meta[TPCT_SALEROOM] = $place;
                        $where_price_meta[TPCT_PRODUCT_ID] = $product;
                        $row_where = $this->price_export_model->getWhere($where_price_meta);
                        $count_row_where = count($row_where);
                        if($count_row_where > 0) {
                            echo json_encode(array(
                                "success" => false,
                                "have" => true,
                                "message" => $this->lang->line("message_error_exits_insert_price")
                            ));
                            return;
                        }
                    }
                    else {
                        $where_price_meta[TPCT_SALEROOM] = $place;
                        $where_price_meta[TPCT_PRODUCT_ID] = $product;
                        $this->price_export_model->removeByWhere($where_price_meta);
                    }*/

                    // Add
                    $list_price_id = "";
                    if($product != null) {
                        foreach ($product as $key => $value) {
                            // Remove
                            $where_price_meta[TPCT_SALEROOM] = $place;
                            $where_price_meta[TPCT_PRODUCT_ID] = $value;
                            $this->price_export_model->removeByWhere($where_price_meta);

                            // AddMeta
                            $price_meta[TPCT_SALEROOM] = $place;
                            $price_meta[TPCT_PRODUCT_ID] = $value;
                            $price_meta[TPCT_UNIT_SELLING_PRICE] = isset($price[$key]) ? $price[$key] : 0;
                            $price_meta[TPCT_REMARKS] = isset($note[$key]) ? $note[$key] : "";

                            $price_id = $this->price_export_model->add($price_meta);
                            $list_price_id .= $price_id . ";"; 
                            if ($this->price_export_model->db->trans_status() === FALSE)
                            {
                                $this->price_export_model->db->trans_rollback();
                                echo json_encode(array(
                                    "success" => false,
                                    "have" => false,
                                    "message" => $this->lang->line("message_add_error")
                                ));
                                return;
                            }
                        }
                    }

                    

                    // End Query
                    if ($this->price_export_model->db->trans_status() === FALSE)
                    {
                        $this->price_export_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                    }
                    else
                    {
                        // LOG ADD
                        logadd("id :".$list_price_id , T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY);

                        $this->price_export_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->price_export_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
                }
            }
        }
    }

    /**
    * Function: edit_post
    * @access public
    */
    public function edit_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $type = $this->input->post('type');

            if($type == 1 || $type == "1") {
                //$product = $this->input->post('product');
                //$basecode = $this->input->post('basecode');
                //$customer = $this->input->post('customer');
                $product_name = $this->input->post('product_name');
                $price = $this->input->post('price');
                $price_gaichyn = $this->input->post('price_gaichyn');
                $type_have = $this->input->post('have');
                $price_id = $this->input->post('price_id');
                $data_log_edit["data_old"]=$this->product_base_model->getById($price_id);

                try{
                    $this->product_base_model->db->trans_begin();

                    // Meta
                    //$price_meta[BB_PRODUCT_CODE] = $product;
                    //$price_meta[BB_BASE_CODE] = $basecode;
                    //$price_meta[BB_CUSTOMER_NUMBER] = $customer;
                    $price_meta[BB_PRODUCT_NAME] = $product_name;
                    $price_meta[BB_UNIT_SELLING_PRICE] = $price;
                    $price_meta[BB_GAICHYU_PRICE] = $price_gaichyn;

                    $where_array[BB_ID] = $price_id;

                    if(!empty($price) && !empty($price_gaichyn)) {
                        if($price_gaichyn > $price){
                            echo json_encode(array(
                                "success" => false,
                                "have" => false,
                                "message" => $this->lang->line("message_add_error_price_gaichyn")
                            ));
                            return;
                        }
                    }

                    $price_id = $this->product_base_model->editByWhere($where_array,$price_meta);

                    // End Query
                    if ($this->product_base_model->db->trans_status() === FALSE)
                    {
                        $this->product_base_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    }
                    else
                    {
                        // Log Edit
                        $data_log_edit["id"]=$where_array;
                        $data_log_edit["data_new"]=$price_meta;
                        logedit($data_log_edit, PRODUCT_BASE);
                    
                        $this->product_base_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->product_base_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
            } else if($type == 2 || $type == "2") {
                //$product = $this->input->post('product');
                //$place = $this->input->post('place');
                $note = $this->input->post('note');
                $price = $this->input->post('price');
                $type_have = $this->input->post('have');
                $price_id = $this->input->post('price_id');
                $data_log_edit["data_old"]=$this->price_import_model->getById($price_id);

                try{
                    $this->price_import_model->db->trans_begin();

                    // Meta
                    //$price_meta[TPNS_ID_PRODUCT] = $product;
                    //$price_meta[TPNS_VENDOR_ID] = $place;
                    $price_meta[TPNS_REMARKS] = $note;
                    $price_meta[TPNS_PURCHASE_PRICE] = $price;

                    $where_array[TPNS_ID] = $price_id;

                    $price_id = $this->price_import_model->editByWhere($where_array,$price_meta);

                    // End Query
                    if ($this->price_import_model->db->trans_status() === FALSE)
                    {
                        $this->price_import_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    }
                    else
                    {
                        // Log Edit
                        $data_log_edit["id"]=$where_array;
                        $data_log_edit["data_new"]=$price_meta;
                        logedit($data_log_edit, T_PRODUCT_NUMBER_FOR_SUPPLIER);

                        $this->price_import_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->price_import_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
            } else if($type == 3 || $type == "3") {
                //$product = $this->input->post('product');
                //$place = $this->input->post('place');
                $note = $this->input->post('note');
                $price = $this->input->post('price');
                $type_have = $this->input->post('have');
                $price_id = $this->input->post('price_id');
                $data_log_edit["data_old"]=$this->price_export_model->getById($price_id);

                try{
                    $this->price_export_model->db->trans_begin();

                    // Meta
                    //$price_meta[TPCT_PRODUCT_ID] = $product;
                    //$price_meta[TPCT_SALEROOM] = $place;
                    $price_meta[TPCT_REMARKS] = $note;
                    $price_meta[TPCT_UNIT_SELLING_PRICE] = $price;

                    $where_array[TPCT_ID] = $price_id;

                    $price_id = $this->price_export_model->editByWhere($where_array,$price_meta);

                    // End Query
                    if ($this->price_export_model->db->trans_status() === FALSE)
                    {
                        $this->price_export_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    }
                    else
                    {
                        // Log Edit
                        $data_log_edit["id"]=$where_array;
                        $data_log_edit["data_new"]=$price_meta;
                        logedit($data_log_edit, T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY);

                        $this->price_export_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->price_export_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
            }
        }
    }

     /**
    * Function: delete_post
    * @access public
    */
    public function delete_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $type = $this->input->post('type');
            $price_id = $this->input->post('price_id');

            if($type == 1 || $type == "1") {
                try{
                    $this->product_base_model->db->trans_begin();
                    
                    $where_array[BB_ID] = $price_id;

                    $price_id = $this->product_base_model->removeByWhere($where_array);

                    // End Query
                    if ($this->product_base_model->db->trans_status() === FALSE)
                    {
                        $this->product_base_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_delete_error")
                        ));
                        return;
                    }
                    else
                    {
                        // LOG DELETE
                        logdelete(BB_ID . ":".$price_id, PRODUCT_BASE);
                    
                        $this->product_base_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_delete_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->product_base_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_delete_error")
                    ));
                    return;
                }
            } else if($type == 2 || $type == "2") {
                try{
                    $this->price_import_model->db->trans_begin();
                    
                    $where_array[TPNS_ID] = $price_id;

                    $price_id = $this->price_import_model->removeByWhere($where_array);

                    // End Query
                    if ($this->price_import_model->db->trans_status() === FALSE)
                    {
                        $this->price_import_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_delete_error")
                        ));
                        return;
                    }
                    else
                    {
                        // LOG DELETE
                        logdelete(TPNS_ID . ":".$price_id, T_PRODUCT_NUMBER_FOR_SUPPLIER);

                        $this->price_import_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_delete_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->price_import_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_delete_error")
                    ));
                    return;
                }
            } else if($type == 3 || $type == "3") {
                try{
                    $this->price_export_model->db->trans_begin();
                    
                    $where_array[TPCT_ID] = $price_id;

                    $price_id = $this->price_export_model->removeByWhere($where_array);

                    // End Query
                    if ($this->price_export_model->db->trans_status() === FALSE)
                    {
                        $this->price_export_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "have" => false,
                            "message" => $this->lang->line("message_delete_error")
                        ));
                        return; 
                    }
                    else
                    {
                        // LOG DELETE
                        logdelete(TPCT_ID . ":".$price_id, T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY);

                        $this->price_export_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "have" => false,
                            "message" => $this->lang->line("message_delete_success")
                        ));
                        return;
                    }

                }catch(Exception $ex){
                    $this->price_export_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "have" => false,
                        "message" => $this->lang->line("message_delete_error")
                    ));
                    return;
                }
            }
        }
    }
    
    /**
	* Function: get_product_price_sale
	* @access public
	*/
	public function get_product_price_sale(){

        $input_search_base = $this->input->get('input_search_base');
        $input_search_product = $this->input->get('input_search_product');
        $input_search_customer = $this->input->get('input_search_customer');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->price_model->searchPriceSale($input_search_base,$input_search_product,$input_search_customer,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
    }

    /**
	* Function: get_product_price_import
	* @access public
	*/
	public function get_product_price_import(){
        
        $keyword = $this->input->get('input_search');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->price_model->searchPriceImport($keyword,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
    }

    /**
	* Function: get_product_price_export
	* @access public
	*/
	public function get_product_price_export(){
        
        $keyword = $this->input->get('input_search');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->price_model->searchPriceExport($keyword,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
    }
    
    // Import price sale
    public function import_price_sale(){
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
            $this->price_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
                $data = array(); 
                
                $data[BB_PRODUCT_CODE] = (isset($value['B']) ? $value['B'] : null);
                $data[BB_BASE_CODE] = (isset($value['D']) ? $value['D'] : null);

                if(!$this->price_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }
                
                $data[BB_ID] = (isset($value['A']) ? $value['A'] : null);
                $data[BB_PRODUCT_NAME] = (isset($value['C']) ? $value['C'] : null);
                $data[BB_CUSTOMER_NUMBER] = (isset($value['E']) ? $value['E'] : null);
                $data[BB_UNIT_SELLING_PRICE] = (isset($value['F']) ? $value['F'] : null);
                $data[BB_GAICHYU_PRICE] = (isset($value['G']) ? $value['G'] : null);

                $where_dup[BB_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->price_model->removeByWhere($where_dup);

                $result = $this->price_model->add($data);
                if ($this->price_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->price_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->price_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->price_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", PRODUCT_BASE);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->price_model->db->trans_rollback();
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

    // Import price nhập
    public function import_price_import(){
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
            $this->price_import_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
                $data = array();
               
                $data[TPNS_VENDOR_ID] = (isset($value['B']) ? $value['B'] : null);
                $data[TPNS_ID_PRODUCT] = (isset($value['C']) ? $value['C'] : null);

                if(!$this->price_import_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }

                $data[TPNS_ID] = (isset($value['A']) ? $value['A'] : null);
                $data[TPNS_PURCHASE_PRICE] = (isset($value['D']) ? $value['D'] : null);
                $data[TPNS_REMARKS] = (isset($value['E']) ? $value['E'] : null);

                $where_dup[TPNS_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->price_import_model->removeByWhere($where_dup);

                $result = $this->price_import_model->add($data);
                if ($this->price_import_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->price_import_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->price_import_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->price_import_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", T_PRODUCT_NUMBER_FOR_SUPPLIER);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->price_import_model->db->trans_rollback();
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

    // Import price xuất
    public function import_price_export(){
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
            $this->price_export_model->db->trans_begin();
            foreach ($sheetData as $key => $value) {
                $data = array();
                $data[TPCT_PRODUCT_ID] = (isset($value['B']) ? $value['B'] : null);

                if(!$this->price_export_model->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
                }

                $data[TPCT_ID] = (isset($value['A']) ? $value['A'] : null);
                $data[TPCT_SALEROOM] = (isset($value['C']) ? $value['C'] : null);
                $data[TPCT_UNIT_SELLING_PRICE] = (isset($value['D']) ? $value['D'] : null);
                $data[TPCT_REMARKS] = (isset($value['E']) ? $value['E'] : null);

                $where_dup[TPCT_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->price_export_model->removeByWhere($where_dup);

                $result = $this->price_export_model->add($data);
                if ($this->price_export_model->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                } 
                                      
            }
            if ($this->price_export_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->price_export_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                        
                $this->price_export_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->price_export_model->db->trans_rollback();
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

    // sale
    public function export_price_sale(){
        $title = $this->lang->line('ms_price_product_title');

        // Data
        $result = $this->price_model->getAll(); 
        
        // Column name
        $column_title = array(BB_ID,BB_PRODUCT_CODE,BB_PRODUCT_NAME,BB_BASE_CODE,BB_CUSTOMER_NUMBER,"売上単価",BB_GAICHYU_PRICE);
        $column_show_data = array(BB_ID,BB_PRODUCT_CODE,BB_PRODUCT_NAME,BB_BASE_CODE,BB_CUSTOMER_NUMBER,BB_UNIT_SELLING_PRICE,BB_GAICHYU_PRICE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }

    // nhập
    public function export_price_import(){
        $title = $this->lang->line('ms_price_product_title');

        // Data
        $result = $this->price_import_model->getAll(); 
        
        // Column name
        $column_title = array(TPNS_ID,"仕入先コード","商品コード",TPNS_PURCHASE_PRICE,TPNS_REMARKS);
        $column_show_data = array(TPNS_ID,TPNS_VENDOR_ID,TPNS_ID_PRODUCT,TPNS_PURCHASE_PRICE,TPNS_REMARKS);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }

    // xuất
    public function export_price_export(){
        $title = $this->lang->line('ms_price_product_title');

        // Data
        $result = $this->price_export_model->getAll(); 
        
        // Column name
        $column_title = array(TPCT_ID,"商品コード","売上先ID","売上単価",TPCT_REMARKS);
        $column_show_data = array(TPCT_ID,TPCT_PRODUCT_ID,TPCT_SALEROOM,TPCT_UNIT_SELLING_PRICE,TPCT_REMARKS);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
}