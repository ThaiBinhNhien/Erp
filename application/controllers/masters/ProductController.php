<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProductController extends VV_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ImportExportCsv');
        $this->load->model('Product','product_model');
        $this->load->model('Supplier','supplier_model');
        $this->load->model('Category','category_model');
        $this->load->model('T_Category','t_category_model');
        $this->load->model('Catalogue','catalogue_model');
        $this->load->model('T_Catalogue','t_catalogue_model');
        $this->load->model('Dry_Press_Laundry_Classfication','dry_press_laundry_model');
        $this->load->model('Yukata_Classification','yukata_model');
        $this->load->model('Overview_Group_M','overview_group_m_model');
        $this->load->model('Overview_Category_M','overview_category_m_model');
        $this->load->model('User','user_model');
        $this->load->library('phpexcel');
        $this->load->library('PHPExcel/PHPExcel_iofactory');
        $this->load->model('Laungry_Segment','laungry_segment_model');
        
    }
    public function index() {
        $data['title'] = $this->lang->line('ms_product');
        // $data['list_product'] = $this->product_model->getAll();
        // $data['list_supplier'] = $this->supplier_model->getAll();
        // $data['list_category'] = $this->category_model->getAll();
        // $data['list_t_category'] = $this->t_category_model->getAll();
        // $data['list_catalogue'] = $this->catalogue_model->getAll();
        // $data['list_t_catalogue'] = $this->t_catalogue_model->getAll();
        $data['content'] ='masters/product/index';

       

        $this->load->view('templates/master',$data);
    }
    public function edit_product() {
        $data['title'] = $this->lang->line('ms_edit_product');
        $data['content'] ='masters/product/edit-product';

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
            $meta = $this->input->post('meta');
            $data_log_edit["data_old"]=$this->product_model->getById($id);
          // $master[PL_PRODUCT_ID]          = 100;
            //$master[PL_T_CATALOGUE]              = $this->getValueInt($meta['catalogue']);
            //$master[PL_T_CATALOGUE]              = (!empty($meta['catalogue'])) ? $meta['catalogue'] : null;
            $master[PL_PRODUCT_CATEGORY_ID]         =  (!empty($meta['category'])) ? $meta['category'] : null;

            //$master[PL_PRODUCT_NAME]                = $meta['product_name'];
            $master[PL_COLOR_TONE]                  = $meta['product_color_tone'];
            $master[PL_STANDARD]                    = $meta['product_standard'];
            $master[PL_ORGANIZATION_PILE]           = $meta['product_organization_pile'];
            $master[PL_ORGANIZATION_WEIGHT]         = $meta['product_organization_weight'];
            //$master[PL_ORGANIZATION_CAL]            = $meta['product_organization_cal'];
            //$master[PL_ORGANIZATION_DATE]           = $meta['product_organization_date'];
            //$master[PL_MAIN_USE]                    =$meta['product_main_use'];
            $master[PL_REMARKS]                     = $meta['product_remark'];
            $master[PL_REMARKS_2]                   = $meta['product_remark_2'];
            $master[PL_STANDARD_STOCK_NUMBER]       = (!empty($meta['product_standard_stock_number'])) ? $meta['product_standard_stock_number'] : null;
            // $master[PL_YUKATA_CLASSIFICATION_FOR_SALE]          =   (!empty($meta['product_yurata_classification_for_sale'])) ? $meta['product_yurata_classification_for_sale'] : null; 

            if($meta['product_wash_classification'] != "" && $meta['product_wash_classification'] != null) {
                if($meta['product_wash_classification'] == 0){
                    $master[PL_WASH_CLASSIFICATION] = false;
                }else{
                    $master[PL_WASH_CLASSIFICATION] = true;
                }
            }

            $master[PL_LAUNDRY_SEGMENT]             = (!empty($meta['product_laundry_segment'])) ? $meta['product_laundry_segment'] : null;
            $master[PL_CATEGORIES]                  =(!empty($meta['product_pl_categories'])) ? $meta['product_pl_categories'] : null;
            //$master[PL_STANDARD]                        = $meta['product_unit'];
            $master[PL_DRY_PRESS_LAUNDRY_CLASSIFICATION]        = (!empty($meta['product_dry_press_laundry'])) ? $meta['product_dry_press_laundry'] : null;


            $master[PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT] =  (!empty($meta['container_upper_mouting_amount'])) ? $meta['container_upper_mouting_amount'] : null;
            $master[PL_T_CATALOGUE]                 = (!empty($meta['t_catalogue'])) ? $meta['t_catalogue'] : null;
            $master[PL_T_PRODUCT_CATEGORY_ID]       = (!empty($meta['t_category'])) ? $meta['t_category'] : null;
            //t_type_order
            $master[PL_TYPE_SHOW_ORDER]       = (!empty($meta['t_type_order'])) ? $meta['t_type_order'] : null;

            //b'0' column PL_SPECIAL
            if($meta['product_type'] != "" && $meta['product_type'] != null) {
                if($master[PL_TYPE_SHOW_ORDER] == 1 || $master[PL_TYPE_SHOW_ORDER] == "1") {
                    $master[PL_SPECIAL] = false;
                }
                else {
                    if($meta['product_type'] == 0){
                        $master[PL_SPECIAL] = false;
                    }else{
                        $master[PL_SPECIAL] = true;
                    }
                }
            }
           
            // if($meta['use_sale'] == 0){
            //     $master[PL_USE_SALE] = false;
            // }else{
            //     $master[PL_USE_SALE] = true;
            // }
            $master[PL_PRODUCT_CODE_SALE]             = $meta['sell_product_id'];
            $master[PL_PRODUCT_CODE_BUY]              = $meta['buy_product_id'];
            $master[PL_PRODUCT_NAME]           = $meta['sell_product_name'];
            $master[PL_PRODUCT_NAME_BUY]            = $meta['buy_product_name'];
            $master[PL_PRODUCTION_SUMMARY_CODE]     = $meta['production_sumary'];
            //$master[PL_TOKYO_FLAG]                  = $meta['tokyo_flag'];
            //Số lượng 1 bó
            $master[PL_NUMBER_PACKAGE]           = $meta['product_number_package'];

            try{
                $this->product_model->db->trans_begin();
                $this->product_model->edit($id,$master,PRODUCT_LEDGER);

                if ($this->product_model->db->trans_status() === FALSE){
                     $this->product_model->db->trans_rollback();
                      echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                }
                else
                {
                    // Log Edit
                    $arr_where[PL_PRODUCT_ID] = $id;
                    $data_log_edit["id"]=$arr_where;
                    $data_log_edit["data_new"]=$master;
                    logedit($data_log_edit, PRODUCT_LEDGER);
                    
                        $this->product_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                }
               
             }catch(Exception $ex){
                $this->product_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
  
        }
        $id = $this->input->get('id');
        $data['master'] = $this->product_model->getById($id);
        $data['list_category'] = $this->category_model->getAll();
        $data['list_t_category'] = $this->t_category_model->getAll();
        //$data['list_catalogue'] = $this->catalogue_model->getAll();
        $data['list_t_catalogue'] = $this->t_catalogue_model->getAll();
        $data['list_dry_press_laundry'] = $this->dry_press_laundry_model->getAll();
        //$data['list_yukata'] = $this->yukata_model->getAll();
        $data['list_product_type'] = array('0' => '普通商品','1' => '特定商品' );//sp binh thuong, sp dac biet
        //$data['list_pl_categories'] = array('1' => '仕入品','2' => '洗剤' );//1: 仕入品、hàng mua vào, 2: 洗剤 bột giặt
        $data['list_pl_categories'] = array('1' => 'リネン品','2' => '洗剤等', '3' => 'リネン売上品');
        //list_pl_categories(1 : Hang tolinen, 2: bot giat , 3: hàng bán (không mua)): 
        $data['list_wash'] = array('0' => '1年未満','1' => '2年以内' );// 0: 1年未満 --> dùng 1 năm , 1：2年以内 --> dùng 2 năm hết
        //$data['list_use_sale'] = array('0' => '売却用なし','1' => '売却用' );//khong dung de ban, dung de ban
        $data['list_laundry_segment'] = $this->laungry_segment_model->getAll();
        $data['production_sumary'] = $this->overview_category_m_model->getAll();
        $info_user = $this->session->userdata('login-info');
        $username = $info_user[U_ID];
        //$username = $info_user['ユーザID'];
        
        $user_type= $this->user_model->getUserType($username);
        $flag_tolinen = $user_type[BM_MASTER_CHECK];
        $data['is_tolinen']= $flag_tolinen;
        if($data['master'] == NULL){
            redirect( base_url('master/product'), 'refresh');
            exit();
        }
        $this->load->view('templates/master',$data);
    }

  
    public function get_product_view(){ 
        $product_id = $this->input->get('product_id');
        //$supplier = $this->input->get('supplier');
        $product_name = $this->input->get('product_name');
        $type_product = $this->input->get('type_product'); 
        $special = $this->input->get('special'); 
        // $t_category = $this->input->get('t_category');
        // $category = $this->input->get('category');
        // $t_catalogue = $this->input->get('t_catalogue'); 
        // $catalogue = $this->input->get('catalogue');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->product_model->getProductView($product_id,$product_name,$type_product
            ,$special,$start_index,PAGE_SIZE,PL_PRODUCT_ID,SORT_MASTER);
        }

        
        echo json_encode($result);
    }

    /*
    @Param : type_product
	1 : nhập, xuất, chuyển, bán từ kho
	2 : xuất hàng
	3 : bán cho khách sạn
	 */
    public function get_product_selectbox(){ 
        $p = $this->input->get('p');
        $q = $this->input->get('q');
        $type_product = $this->input->get('type_product');
        $customer_shipment = $this->input->get('customer_shipment');
        //$customer_shipment = "";
        $per_page = $this->input->get('per_page');
        
        $page = $p > 0 ? ($p - 1) : 1;
        $start_index = $page * PAGE_SIZE_SELECTBOX;

        $result = array();
        $product_code_sell = $q;
        $result = $this->product_model->getProductSelectBox($product_code_sell,null,$type_product,$customer_shipment
            ,false,$start_index,PAGE_SIZE_SELECTBOX,PL_PRODUCT_ID,SORT_MASTER);

        $count = $this->product_model->getProductSelectBox($product_code_sell,null,$type_product,$customer_shipment
        ,true);;

        echo json_encode(['msg' => "", 'p' => $p, 'count' => $count, 'per_page' => $per_page
        , 'data' => $result]);
    }

    
    public function create_product() { 

        $data['title'] = $this->lang->line('ms_create_product');
        $data['content'] ='masters/product/create-product';
        if($this->input->server("REQUEST_METHOD") == "POST"){

            $meta = $this->input->post('meta');
            // $master[PL_PRODUCT_ID]          = 100;
            //$master[PL_T_CATALOGUE]              = $meta['catalogue'];
            $master[PL_PRODUCT_CATEGORY_ID]         =  $meta['category'];

            //$master[PL_PRODUCT_NAME]                = $meta['product_name'];
            $master[PL_COLOR_TONE]                  = $meta['product_color_tone'];
            $master[PL_STANDARD]                    = $meta['product_standard'];
            $master[PL_ORGANIZATION_PILE]           = $meta['product_organization_pile'];
            $master[PL_ORGANIZATION_WEIGHT]         = $meta['product_organization_weight'];
            //$master[PL_ORGANIZATION_CAL]            = $meta['product_organization_cal'];
            //$master[PL_ORGANIZATION_DATE]           = $meta['product_organization_date'];
            //$master[PL_MAIN_USE]                    = $meta['product_main_use'];
            $master[PL_REMARKS]                     = $meta['product_remark'];
            
            $master[PL_REMARKS_2]                   = $meta['product_remark_2'];
            $master[PL_STANDARD_STOCK_NUMBER]       = $meta['product_standard_stock_number'];
            // $master[PL_YUKATA_CLASSIFICATION_FOR_SALE]          = $meta['product_yurata_classification_for_sale'];
            $master[PL_PRODUCTION_SUMMARY_CODE]     = $meta['production_sumary'];
            //$master[PL_TOKYO_FLAG]                  = $meta['tokyo_flag'];

            if($meta['product_wash_classification'] != "" && $meta['product_wash_classification'] != null) {
                if($meta['product_wash_classification'] == 0){
                    $master[PL_WASH_CLASSIFICATION] = false;
                }else{
                    $master[PL_WASH_CLASSIFICATION] = true;
                }
            }
            $master[PL_LAUNDRY_SEGMENT]             = $meta['product_laundry_segment'];
            $master[PL_CATEGORIES]                  =$meta['product_pl_categories'];
            //$master[PL_STANDARD]                        = $meta['product_unit'];
            $master[PL_DRY_PRESS_LAUNDRY_CLASSIFICATION]        =  $meta['product_dry_press_laundry'];


            $master[PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT] =  $meta['container_upper_mouting_amount'];
            $master[PL_T_CATALOGUE]                 = $meta['t_catalogue'];
            $master[PL_T_PRODUCT_CATEGORY_ID]       = $meta['t_category'];
            //t_type_order
            $master[PL_TYPE_SHOW_ORDER]       = $meta['t_type_order'];

            //b'0' column PL_SPECIAL
            if($meta['product_type'] != "" && $meta['product_type'] != null) {
                if($master[PL_TYPE_SHOW_ORDER] == 1 || $master[PL_TYPE_SHOW_ORDER] == "1") {
                    $master[PL_SPECIAL] = false;
                }
                else {
                    if($meta['product_type'] == 0){
                        $master[PL_SPECIAL] = false;
                    }else{
                        $master[PL_SPECIAL] = true;
                    }
                }
            }
           
            $master[PL_PRODUCT_CODE_SALE]             = $meta['sell_product_id'];
            $master[PL_PRODUCT_CODE_BUY]              = $meta['buy_product_id'];
            if( $master[PL_TYPE_SHOW_ORDER] != 1 &&  $master[PL_TYPE_SHOW_ORDER] != "1") {
                $checkSellIsExits = $this->product_model->isExitsRow(PL_PRODUCT_CODE_SALE,$meta['sell_product_id'] );

                if($checkSellIsExits) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_exits_sell_id_error")
                    ));
                    return;
                }
            }
            $checkBuyIsExits = $this->product_model->isExitsRow(PL_PRODUCT_CODE_BUY,$meta['buy_product_id'] );

            if($checkBuyIsExits) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_exits_buy_id_error")
                ));
                return;
            }
            $master[PL_PRODUCT_NAME]           = $meta['sell_product_name'];
            $master[PL_PRODUCT_NAME_BUY]            = $meta['buy_product_name'];
            //Số lượng 1 bó
            $master[PL_NUMBER_PACKAGE]           = $meta['product_number_package'];
            
        
            try{
                $this->product_model->db->trans_begin();
                $order_id = $this->product_model->add($master,PRODUCT_LEDGER);

                if ($this->product_model->db->trans_status() === FALSE){
                     $this->product_model->db->trans_rollback();
                      echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                }
                else
                {
                    // LOG ADD
                    logadd(PL_PRODUCT_ID . ":".$order_id, PRODUCT_LEDGER);
                        $this->product_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                }
               
             }catch(Exception $ex){
                $this->product_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
        }
        $data['list_category'] = $this->category_model->getAll();
        $data['list_t_category'] = $this->t_category_model->getAll(); 
        //$data['list_catalogue'] = $this->catalogue_model->getAll();
        $data['list_t_catalogue'] = $this->t_catalogue_model->getAll();
        $data['list_dry_press_laundry'] = $this->dry_press_laundry_model->getAll();
        //$data['list_yukata'] = $this->yukata_model->getAll();
        $data['list_product_type'] = array('0' => '普通商品','1' => '特定商品' );//sp binh thuong, sp dac biet
        $data['list_pl_categories'] = array('1' => '仕入品','2' => '洗剤' );//1:仕入品、hàng  mua vào, 2: 洗剤 bột giặt
        $data['list_wash'] = array('0' => '1年未満','1' => '2年以内' );// 0: 1年未満 --> dùng 1 năm , 1：2年以内 --> dùng 2 năm hết
        //$data['list_use_sale'] = array('0' => '売却用なし','1' => '売却用' );//khong dung de ban, dung de ban
        $data['list_laundry_segment'] = $this->laungry_segment_model->getAll();
        $data['production_sumary'] = $this->overview_category_m_model->getAll(); 

        $info_user = $this->session->userdata('login-info');
        $username = $info_user[U_ID];
        $user_type= $this->user_model->getUserType($username);
        $flag_tolinen = $user_type[BM_MASTER_CHECK];
        $data['is_tolinen']= $flag_tolinen;
        $this->load->view('templates/master',$data);
    }
    public function delete_product(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->product_model->remove($id,PRODUCT_LEDGER);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }
            logdelete(PL_PRODUCT_ID . ":".$id, PRODUCT_LEDGER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }

    /**
    * Function: export
    * @access public
    */
    public function export(){

        $title = $this->lang->line('ms_product');
        // Data
        $result = $this->product_model->getAll(); 
        // Column name
        $column_title = array(
            PL_PRODUCT_ID,
            "仕入商品ｺｰﾄﾞ", 
            "売上商品ｺｰﾄﾞ", 
            "仕入商品名", 
            "売上商品名",
            PL_COLOR_TONE, 
            PL_STANDARD,  
            PL_SPECIAL, 
            PL_ORGANIZATION_PILE, 
            PL_ORGANIZATION_WEIGHT,
            PL_REMARKS,
            PL_REMARKS_2, 
            PL_STANDARD_STOCK_NUMBER ,
            "償却区分",
            PL_LAUNDRY_SEGMENT, 
            PL_CATEGORIES, 
            PL_DRY_PRESS_LAUNDRY_CLASSIFICATION, 
            PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT ,
            PL_T_CATALOGUE,
            "仕入区分ｺｰﾄﾞ" ,
            "売上区分ｺｰﾄﾞ",
            PL_PRODUCTION_SUMMARY_CODE, 
            PL_NUMBER_PACKAGE,
            PL_TYPE_SHOW_ORDER
        );
        $column_show_data = array(
            PL_PRODUCT_ID,
            PL_PRODUCT_CODE_BUY, 
            PL_PRODUCT_CODE_SALE, 
            PL_PRODUCT_NAME_BUY, 
            PL_PRODUCT_NAME, 
            PL_COLOR_TONE, 
            PL_STANDARD, 
            PL_SPECIAL, 
            PL_ORGANIZATION_PILE, 
            PL_ORGANIZATION_WEIGHT , 
            PL_REMARKS ,
            PL_REMARKS_2 , 
            PL_STANDARD_STOCK_NUMBER , 
            PL_WASH_CLASSIFICATION,
            PL_LAUNDRY_SEGMENT, 
            PL_CATEGORIES, 
            PL_DRY_PRESS_LAUNDRY_CLASSIFICATION, 
            PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT ,
            PL_T_CATALOGUE, 
            PL_T_PRODUCT_CATEGORY_ID ,
            PL_PRODUCT_CATEGORY_ID,
            PL_PRODUCTION_SUMMARY_CODE,
            PL_NUMBER_PACKAGE,
            PL_TYPE_SHOW_ORDER 
        ); 

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    
    /**
    * Function: export
    * @access public
    */
    public function import(){
        $title = $this->lang->line('ms_product');
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
            $this->product_model->db->trans_begin();
            // Empty table
            foreach ($sheetData as $key => $value) {
                //reset avalidable data
                $data = null;
                //Field is number
                $data[PL_PRODUCT_ID]        = (isset($value['A']) ? $value['A'] : null);
                if($data[PL_PRODUCT_ID] != null && $data[PL_PRODUCT_ID] != "") {
                    if(!$this->product_model->checkDataNumber($data)){
                        $error_line = $key+1;
                        break;
                    }
                }

                $data[PL_PRODUCT_CODE_BUY] = (isset($value['B']) ? $value['B'] : null);
                $data[PL_PRODUCT_CODE_SALE] = (isset($value['C']) ? $value['C'] : null);
                //$data[PL_T_CATALOGUE] = (isset($value['D']) ? $value['D'] : null);
                //$data[PL_PRODUCT_CATEGORY_ID] = (isset($value['E']) ? $value['E'] : null);
                $data[PL_PRODUCT_NAME_BUY] = (isset($value['D']) ? $value['D'] : null);
                $data[PL_PRODUCT_NAME] = (isset($value['E']) ? $value['E'] : null);
                $data[PL_COLOR_TONE] = (isset($value['F']) ? $value['F'] : null);
                $data[PL_STANDARD] = (isset($value['G']) ? $value['G'] : null);
                if(isset($value['H']) && $value['H'] != "" && $value['H'] != null) {
                    if($value['H'] == 1 || $value['H'] == "1" ) {
                        $data[PL_SPECIAL] = true;
                    } else {
                        $data[PL_SPECIAL] = false;
                    }
                }
                $data[PL_ORGANIZATION_PILE] = (isset($value['I']) ? $value['I'] : null);
                $data[PL_ORGANIZATION_WEIGHT] = (isset($value['J']) ? $value['J'] : null);
                //$data[PL_ORGANIZATION_CAL] = (isset($value['M']) ? $value['M'] : null);
                //$data[PL_ORGANIZATION_DATE] = (isset($value['N']) ? $value['N'] : null);
                $data[PL_REMARKS] = (isset($value['K']) ? $value['K'] : null);
                $data[PL_REMARKS_2] = (isset($value['L']) ? $value['L'] : null);
                $data[PL_STANDARD_STOCK_NUMBER] = (isset($value['M']) ? $value['M'] : null);
                if(isset($value['N']) && $value['N'] != "" && $value['N'] != null) {
                    if($value['N'] == 1 || $value['N'] == "1") {
                        $data[PL_WASH_CLASSIFICATION] = true;
                    } else {
                        $data[PL_WASH_CLASSIFICATION] = false;
                    }
                }
                $data[PL_LAUNDRY_SEGMENT] = (isset($value['O']) ? $value['O'] : null); 

                if(isset($value['P']) && $value['P'] != "" && $value['P'] != null) {
                    if($value['P'] == 1 || $value['P'] == "1" ) {
                        $data[PL_CATEGORIES] = 1;
                    } else if($value['P'] == 2 || $value['P'] == "2" ) {
                        $data[PL_CATEGORIES] = 2;
                    }
                }

                $data[PL_DRY_PRESS_LAUNDRY_CLASSIFICATION] = (isset($value['Q']) ? $value['Q'] : null);
                $data[PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT] = (isset($value['R']) ? $value['R'] : null);
                $data[PL_T_CATALOGUE] = (isset($value['S']) ? $value['S'] : null);
                $data[PL_T_PRODUCT_CATEGORY_ID] = (isset($value['T']) ? $value['T'] : null);

                $data[PL_PRODUCT_CATEGORY_ID] = (isset($value['U']) ? $value['U'] : null);
                //$data[PL_TOKYO_FLAG] = (isset($value['AB']) ? $value['AB'] : null);
                $data[PL_PRODUCTION_SUMMARY_CODE] = (isset($value['V']) ? $value['V'] : null);
                $data[PL_NUMBER_PACKAGE] = (isset($value['W']) ? $value['W'] : null);
                $data[PL_TYPE_SHOW_ORDER] = (isset($value['X']) ? $value['X'] : null);
                
                // Xóa trùng
                $where_dup[PL_PRODUCT_ID] = (isset($value['A']) ? $value['A'] : null);
                $this->product_model->removeByWhere($where_dup);
                
                // Add
                $result = $this->product_model->add($data);

                if ($this->product_model->db->trans_status() === FALSE)
                {
                    $error_line = $key+1;
                    $is_import = false;
                    break;
                }
                                        
            }
            if ($this->product_model->db->trans_status() === FALSE || $error_line != 0)
            {
                $this->product_model->db->trans_rollback();
                $is_import = false;
            }
            else
            {
                $this->product_model->db->trans_commit();
                logupcsv($target_file . " (".count($sheetData)." records)", PRODUCT_LEDGER);
                $is_import = true;
            }           

        }catch(Exception $ex){
            $this->product_model->db->trans_rollback();
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
    public function get_key_random(){
        $type = $this->input->get('type');
        $valueRandom =null;
        $arrValueOfColumn = $this->product_model->getArrValueOfColumn($type);
        $arrayValue= array();
        foreach ($arrValueOfColumn as $row)
        {
                array_push($arrayValue, $row['key']);
               
        }
    
        $valueMax = max($arrayValue);
        if($valueMax ==null){
            $valueRandom = 1;
        }else{
            $valueRandom = $valueMax + 1;
        }
    
        echo json_encode($valueRandom);
    }
    
   
}
