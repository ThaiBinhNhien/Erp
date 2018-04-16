<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OrderController extends VV_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library("mpdf");
        $this->load->model('Customer','customer_model');
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('Order','order_model');
        $this->load->model('Order_Detail','order_detail_model');
        $this->load->model('Delivery','delivery_model');
        $this->load->model('Delivery_Detail','delivery_detail_model');
        $this->load->model('Order_Reason','order_reason_model');
        $this->load->model('Product','product_model');
        $this->load->library('helper','helper');
        $this->load->model('User','user_model');
        $this->load->model('Shipment','shipment_model');
        $this->load->model('Shipment_Detail','shipment_detail_model');
        $this->LOGIN_INFO = $this->session->userdata('login-info');
        $this->customer = $this->customer_model->getByUser($this->LOGIN_INFO[U_ID]);
        $this->customer_account = $this->session->userdata('customer-info');
        $this->level = $this->session->userdata('request-level');
        $this->cus_type =  0;
        $this->base_id = $this->LOGIN_INFO[U_BASE_CODE];
        if($this->customer != null){
            $values = array_column($this->customer, CUS_TYPE_CUSTOMER);
            $values = array_unique($values);
            if(count($values) >= 2){
                $this->cus_type = 0;
            }else{
                $this->cus_type = $values[0];
            }
        }
            

        if($this->customer_account != NULL){
            $this->cus_type = $this->customer_account != null?$this->customer_account[CUS_TYPE_CUSTOMER]:-1;
        }
        //var_dump($this->LOGIN_INFO[U_ID]);
        $this->load->model('ImportExportCsv');

    }
	public function index() {
        $data['title'] = $this->lang->line('receive_order');
        $data['content'] ='orders/receiveOrder';
        if($this->customer_account == null){
            
            $data['list_cus'] = $this->customer_model->getAll();
            //$data['list_user'] = $this->user_model->getAll();
            if($this->level == "P"){
                $data['list_user'] = $this->user_model->getUserForOrderManager($this->LOGIN_INFO[U_ID]);
                $data['list_user2'] = $this->user_model->getUserForCustomer($this->LOGIN_INFO[U_ID]);
            } else {
                $data['list_user'] = $this->user_model->getAll();
            }
            $data['cus_type'] = $this->cus_type;
        }
        else{

            $data['list_cus'] = array($this->customer_account);
            $data['list_user'] = $this->user_model->getUserByCustomer($this->customer_account['得意先コード']);
            $data['list_user2'] = $this->user_model->getUserByCustomer2($this->customer_account['得意先コード']);
            $data['cus_type'] = $this->cus_type;
            if($this->order_model->getByCreatedId($this->LOGIN_INFO[U_ID]) == NULL){
                if($data['cus_type'] == 1)
                    redirect( base_url('order/create-order'), 'refresh');
                else{
                    redirect( base_url('order/create-order-2'), 'refresh');
                }
            }
        }
        
        $data['list_department'] = $this->customer_department_model->getDepartment();
        //$data['list_user'] = $this->customer_model->getAll();
        $this->load->view('templates/master',$data);
	}
    public function get_deparment_by_customer(){ 
        $customer_id = $this->input->get('customer_id');
        $result = $this->customer_department_model->getDepartment($customer_id);
        echo json_encode($result);
    }

    public function get_customer_by_department(){ 
        $department = $this->input->get('department_id');
        $result = $this->customer_department_model->getCustomerByDepartment($department);
        echo json_encode($result);
    }
    
    public function detail_order() {
        $data['title'] = $this->lang->line('detail_order');
        $data['content']='orders/detailOrder';
        $id = $this->input->get('id');
        // Check role
        $count_data_by_role = $this->order_model->getCountCheckRole($id);
        if(count($count_data_by_role) <= 0) {
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }

        // master order
        $data['master'] = $this->order_model->getById($id); 
        if($data['master'] == NULL){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }

        if($data['master'][SL_ORDER_CLASSIFICATION] != 1){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $cus_temp = $this->customer_account == null? null:$this->customer_account[CUS_ID];
        if($this->level == 'P' && $this->order_model->checkOwner($id,$cus_temp) == null){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        } 
        $data['detail']['order_data'] = $this->order_detail_model->getByOrderIdWithFloor($id); 
        $base_code_price = $this->LOGIN_INFO[U_BASE_CODE];
        $base_code_arr = $this->customer_department_model->getBaseByCustomerDepartment($data['master'][SL_CUSTOMER_ID],$data['master'][SL_DEPARTMENT_CODE]);
        if($base_code_arr != null) {
            $base_code_price = $base_code_arr[0]['base_code'];
        }
        $data['detail']['delivery_data'] = $this->order_detail_model->getByOrderDelivery($id, $base_code_price , $data['master'][SL_CUSTOMER_ID]);
        $data['detail']['floor'] = $this->order_detail_floor_model->getFloorNameByOrderId($id);
        $data['master']['orderdate_print'] = $this->helper->readDate($data['master']['order_date']);
        $data['master']['deliveryexpected_date_print'] = $this->helper->readDate($data['master'][SL_DELIVERY_DATE]);
        $data['master']['deliverydate_print'] = $this->helper->readDate($data['master'][SL_REVENUE_DATE] == NULL?NULL:$data['master'][SL_REVENUE_DATE]);
        
        // is gaichyu
        $data['is_gaichyu'] = false;
        $data['is_gaichyu_login'] = false;
        $master_order = $this->order_detail_model->getInforOrderById($id, SL_ID);
        if($master_order[0]['is_gaichyu'] == 1 || $master_order[0]['is_gaichyu'] == "1") {
           $data['is_gaichyu'] = true;

           $is_gaichyu_hotel = $this->checkIsGroupRole(GR_SUBCONTRACTOR_LOCAL);
           $is_gaichyu_tenal = $this->checkIsGroupRole(GR_SUBCONTRACTOR_TENANT);
           if($is_gaichyu_hotel == true || $is_gaichyu_tenal == true) {
            $data['is_gaichyu_login'] = true;
           }
        } 

        // copy data order -> shipment
        $data['flg_copy'] = $this->delivery_model->checkCopyOrderShipment($id,$data['master'][SL_DEPARTMENT_CODE]);

        $this->load->view('templates/master',$data);
	}
    public function detail_order2() {
        $data['content']='orders/detailOrder2';
        $data['title'] = $this->lang->line('detail_order');
        $id = $this->input->get('id');

        // Check role
        $count_data_by_role = $this->order_model->getCountCheckRole($id);
        if(count($count_data_by_role) <= 0) {
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }

        $data['master'] = $this->order_model->getById($id); 
        if($data['master'] == NULL){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        if($data['master'][SL_ORDER_CLASSIFICATION] != 2){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $cus_temp = $this->customer_account == null? null:$this->customer_account[CUS_ID];
        if($this->level == 'P' && $this->order_model->checkOwner($id,$cus_temp) == null){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $data['detail']['order_data'] = $this->order_detail_model->getByOrderId($id);
        $base_code_price = $this->LOGIN_INFO[U_BASE_CODE];
        $base_code_arr = $this->customer_department_model->getBaseByCustomerDepartment($data['master'][SL_CUSTOMER_ID],$data['master'][SL_DEPARTMENT_CODE]);
        if($base_code_arr != null) {
            $base_code_price = $base_code_arr[0]['base_code'];
        }
        $data['detail']['delivery_data'] = $this->order_detail_model->getByOrderDelivery($id, $base_code_price, $data['master'][SL_CUSTOMER_ID]);
        $data['master']['orderdate_print'] = $this->helper->readDate($data['master']['order_date']);
        $data['master']['deliveryexpected_date_print'] = $this->helper->readDate($data['master'][SL_DELIVERY_DATE]);
        $data['master']['deliverydate_print'] = $this->helper->readDate($data['master'][SL_REVENUE_DATE] == NULL?NULL:$data['master'][SL_REVENUE_DATE]);
        
        // is gaichyu
        $data['is_gaichyu'] = false;
        $data['is_gaichyu_login'] = false;
        $master_order = $this->order_detail_model->getInforOrderById($id, SL_ID);
        if($master_order[0]['is_gaichyu'] == 1 || $master_order[0]['is_gaichyu'] == "1") {
           $data['is_gaichyu'] = true;

           $is_gaichyu_hotel = $this->checkIsGroupRole(GR_SUBCONTRACTOR_LOCAL);
           $is_gaichyu_tenal = $this->checkIsGroupRole(GR_SUBCONTRACTOR_TENANT);
           if($is_gaichyu_hotel == true || $is_gaichyu_tenal == true) {
            $data['is_gaichyu_login'] = true;
           }
        }

        // copy data order -> shipment
        $data['flg_copy'] = $this->delivery_model->checkCopyOrderShipment($id,$data['master'][SL_DEPARTMENT_CODE]);
        
        $this->load->view('templates/master',$data);
	}
    public function edit_order() {
        $data['title'] = $this->lang->line('edit_order');
        $data['content'] ='orders/edit_order';
        
        // edit order request
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
            $meta = $this->input->post('meta');
            $detail = $this->input->post('detail');
            $master = $this->order_model->getById($id);
            $date_update = $meta["date_update"];
            $cus_temp = $this->customer_account == null? null:$this->customer_account[CUS_ID];
            if($this->level == 'P' && $this->order_model->checkOwner($id,$cus_temp) == null){
                redirect( base_url('receive-order'), 'refresh');
                exit();
            }
            if($this->order_model->isCheckDataUpdated($id,$date_update,SALES_LEDGER) == false){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_error_data_updated")
                ));;
               return;
            }
            if($master == NULL){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));;
               return;
            }
            if($master[SL_REVENUE_DATE] != NULL && $master[SL_REVENUE_DATE] != ""){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));;
               return;
            }
            $detail_old = $this->order_detail_model->getByOrderId($id);
            if($detail_old == null){
               echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));;
               return;
            }
            $master = array();
            // get item remove is valid
            $id_old = array_column($detail_old,"id");
            $id_new = array_column($detail, 'id');
            $id_removed = array_diff($id_old, $id_new);
            // check item remove valid
            foreach ($id_removed as $key => $value) {
                if($value != ''){
                    $data = $this->order_detail_model->getDeliveryByDetail($value);
                    if($data != null){
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    }
                }
            }

            // check item has edited valid
            /*foreach ($detail as $key => $value) {
                if($value['id'] != ''){
                    $data_delivery = $this->order_detail_model->getDeliveryByDetail($value['id']);
                    $data_detail = $this->order_detail_model->getById($value['id']);
                    $new_quantity = 0.0;
                    $floor = json_decode($value['floor'],true);
                    foreach ($floor as $index => $quantity) {
                        $new_quantity += floatval($quantity);
                    }

                    if($data_delivery != null && $data_delivery[0]['quantity_delivery'] > $new_quantity){
                        var_dump($data_delivery[0]['quantity_delivery']);
                        var_dump($new_quantity);
                        var_dump($value['id']);
                        var_dump($data_detail[]);
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    } 

                }
            }*/
            try{
                $this->order_model->db->trans_begin();
                $master[SL_SUMMARY] = $meta['note'];
                $master[SL_CUSTOMER_ID] = $meta['customer_id'] !=""?$meta['customer_id']:NULL;
                $master[SL_SALES_DATE] = $meta['order_date'];
                $master[SL_DELIVERY_DATE] = $meta['delivery_date'];
                $master[SL_DEPARTMENT_CODE] = $meta['department'];
                $master[SL_ORDER_CLASSIFICATION] = 1;
                $this->order_model->db->set(SL_NUMBER_ORDER_MODIFY, SL_NUMBER_ORDER_MODIFY.'+1', FALSE);
                $master[SL_DATE_CHANGE] = date('Y-m-d H:i:s');
                $master[SL_STATUS] = 1;
                $this->order_model->edit($id,$master,SALES_LEDGER);
                // insert new item
                foreach ($detail as $key => $value) {
                    if($value['id'] == ''){
                        $floor = json_decode($value['floor'],true);
                        $order_detail[OD_ORDER_ID] = $id;
                        $order_detail[OD_PRODUCT_CODE] = $value['product_id'];
                        $order_detail[OD_PRODUCT_NAME] = $value['product_name'];
                        $order_detail[OD_ADD] = $value['addition'];
                        $order_detail[OD_QUANTITY] = 0.0;
                        foreach ($floor as $index => $quantity) {
                            $order_detail[OD_QUANTITY] += $quantity;
                        }
                        $detail_id = $this->order_detail_model->add($order_detail,ORDER_DETAIL);
                        
                        foreach ($floor as $index => $quantity) {
                            $floor_data[F_DETAIL_ID] = $detail_id;
                            $floor_data[F_FLOOR_NAME] = $index;
                            $floor_data[F_QUANTITY] = $quantity;
                            $this->order_detail_floor_model->add($floor_data);
                        }
                    }
                }
                // update old item
                foreach ($detail as $key => $value) {
                    if($value['id'] != ''){
                        $floor = json_decode($value['floor'],true);
                        $order_detail[OD_PRODUCT_CODE] = $value['product_id'];
                        $order_detail[OD_PRODUCT_NAME] = $value['product_name'];
                        $order_detail[OD_ADD] = $value['addition'];
                        $order_detail[OD_QUANTITY] = 0.0;
                        if($value['special'] == 1){
                            $value[OD_QUANTITY] = 1;
                        }else{
                             foreach ($floor as $index => $quantity) {
                                $order_detail[OD_QUANTITY] += $quantity;
                            }

                        }
                       
                        
                        $this->order_detail_model->edit($value['id'],$order_detail,ORDER_DETAIL);
                        if($value['special'] != 1){
                             foreach ($floor as $index => $quantity) {
                                $floor_data[F_DETAIL_ID] = $value['id'];
                                $floor_data[F_FLOOR_NAME] = $index;
                                $floor_data[F_QUANTITY] = $quantity;
                                $whereClause = array(
                                    F_DETAIL_ID => $value['id'],
                                    F_FLOOR_NAME => $index
                                );
                                $this->order_detail_floor_model->removeByWhere($whereClause);
                                
                                $this->order_detail_floor_model->add($floor_data);
                            }

                        }
                       
                    }
                }
                // delete not exists
                foreach ($id_removed as $key => $value) {
                    $this->order_detail_model->remove($value,ORDER_DETAIL);
                }


                if ($this->order_model->db->trans_status() === FALSE)
                {
                    $this->order_model->db->trans_rollback();
                    
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
                else
                {
                    
                    $this->order_model->db->trans_commit();
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
                    return;
                }
            }catch(Exception $ex){

            }
            
        }
        // view edit
        $id = $this->input->get('id');

        // Check role
        $count_data_by_role = $this->order_model->getCountCheckRole($id);
        if(count($count_data_by_role) <= 0) {
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }

        $cus_temp = $this->customer_account == null? null:$this->customer_account[CUS_ID];
        if($this->level == 'P' && $this->order_model->checkOwner($id,$cus_temp) == null){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $data['master'] = $this->order_model->getById($id);
        if($data['master'] == NULL){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        if($data['master'][SL_REVENUE_DATE] != NULL && $data['master'][SL_REVENUE_DATE] != ""){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        if($data['master'][SL_ORDER_CLASSIFICATION] != 1){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $data['detail']['order_data'] = $this->order_detail_model->getByOrderIdWithFloor($id);
        $data['detail']['floor'] = $this->order_detail_floor_model->getFloorNameByOrderId($id);
        $data['list_product'] = array();
        $data['list_customer'] = $this->customer_model->getByType($this->cus_type,0,PAGE_SIZE);
        $data['base_id'] = $this->base_id;
        $data['is_customer'] = $this->customer_account == null? 0:1;
        $data['department'] = $this->customer_department_model->getByCustomer($data['master'][SL_CUSTOMER_ID]);
        if($data['master'][SL_CUSTOMER_ID] !== NULL){

            $customer = $this->customer_model->getById($data['master'][SL_CUSTOMER_ID]);

            if(in_array($customer, $data['list_customer']) == false){
                array_push($data['list_customer'], $customer);
            }
        }
        
        $temp = array();
        foreach ($data['detail']['order_data'] as $key => $value) {
            $product = $this->product_model->getById($value[OD_PRODUCT_CODE]);

            if(in_array($product, $data['list_product']) == false){
                array_push($temp, $product);
            }

        }

        if(count($temp) > 0){
            $data['list_product'] = array_merge($data['list_product'] , $temp);
        }

        $this->load->view('templates/master',$data);
	}
    public function edit_order_2() {
        $data['content']='orders/edit_order2';
        $data['title'] = $this->lang->line('edit_order');
        
        // edit order request
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
            $meta = $this->input->post('meta');
            $detail = $this->input->post('detail');
            $master = $this->order_model->getById($id);
            $date_update = $meta["date_update"];
            $cus_temp = $this->customer_account == null? null:$this->customer_account[CUS_ID];
            if($this->level == 'P' && $this->order_model->checkOwner($id,$cus_temp) == null){
                redirect( base_url('receive-order'), 'refresh');
                exit();
            }
            if($this->order_model->isCheckDataUpdated($id,$date_update,SALES_LEDGER) == false){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_error_data_updated")
                ));;
               return;
            }
            if($master == NULL){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));;
               return;
            }
            if($master[SL_REVENUE_DATE] != NULL && $master[SL_REVENUE_DATE] != ""){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));;
               return;
            }
            $master = array();
            $detail_old = $this->order_detail_model->getByOrderId($id);
            if($detail_old == null){
               echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));;
               return;
            }
            
            // get item remove is valid
            $id_old = array_column($detail_old,"id");
            $id_new = array_column($detail, 'id');
            $id_removed = array_diff($id_old, $id_new);
            // check item remove valid
            foreach ($id_removed as $key => $value) {
                if($value != ''){
                    $data = $this->order_detail_model->getDeliveryByDetail($value);
                    if($data != null){
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    }
                }
            }
            // check item has edited valid
            foreach ($detail as $key => $value) {
                if($value['id'] != ''){
                    $data_delivery = $this->order_detail_model->getDeliveryByDetail($value['id']);
                    $data_detail = $this->order_detail_model->getById($value['id']);
                    $new_quantity = $value['quantity'];
                    if($data_delivery != null && $data_delivery[0]['quantity_delivery'] > $new_quantity){
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    } 
                }
            }
            try{
                $this->order_model->db->trans_begin();

                $master[SL_SUMMARY] = $meta['note'];
                $master[SL_CUSTOMER_ID] = $meta['customer_id'] !=""?$meta['customer_id']:NULL;
                $master[SL_SALES_DATE] = $meta['order_date'];
                $master[SL_DELIVERY_DATE] = $meta['delivery_date'];
                $master[SL_DEPARTMENT_CODE] = $meta['department'];
                $master[SL_ORDER_CLASSIFICATION] = 2;
                $this->order_model->db->set(SL_NUMBER_ORDER_MODIFY, SL_NUMBER_ORDER_MODIFY.'+1', FALSE);
                $master[SL_DATE_CHANGE] = date('Y-m-d H:i:s');
                $master[SL_STATUS] = 1;
                $this->order_model->edit($id,$master,SALES_LEDGER);
                // insert new item
                foreach ($detail as $key => $value) {
                    if($value['id'] == ''){
                        $order_detail[OD_ORDER_ID] = $id;
                        $order_detail[OD_PRODUCT_CODE] = $value['product_id'];
                        $order_detail[OD_PRODUCT_NAME] = $value['product_name'];
                        $order_detail[OD_QUANTITY] = $value['quantity'];
                        $detail_id = $this->order_detail_model->add($order_detail,ORDER_DETAIL);
                    }
                }
                // update old item
                foreach ($detail as $key => $value) {
                    if($value['id'] != ''){
                        $order_detail[OD_PRODUCT_CODE] = $value['product_id'];
                        $order_detail[OD_PRODUCT_NAME] = $value['product_name'];
                        if($value['special'] == 1){
                            $value['quantity'] = 1;
                        }
                        $order_detail[OD_QUANTITY] = $value['quantity'];
                        $this->order_detail_model->edit($value['id'],$order_detail,ORDER_DETAIL);
                        
                    }
                }
                // delete not exists
                foreach ($id_removed as $key => $value) {
                    $this->order_detail_model->remove($value,ORDER_DETAIL);
                }


                if ($this->order_model->db->trans_status() === FALSE)
                {
                    $this->order_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
                else
                {
                    
                    $this->order_model->db->trans_commit();
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
                    return;
                }
            }catch(Exception $ex){
                $this->order_model->db->trans_rollback();
                echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                ));
                return;
            }
            
        }
        // view edit order
        $id = $this->input->get('id');

        // Check role
        $count_data_by_role = $this->order_model->getCountCheckRole($id);
        if(count($count_data_by_role) <= 0) {
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        
        $cus_temp = $this->customer_account == null? null:$this->customer_account[CUS_ID];
        if($this->level == 'P' && $this->order_model->checkOwner($id,$cus_temp) == null){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        
        $data['master'] = $this->order_model->getById($id);
        if($data['master'] == NULL){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        if($data['master'][SL_REVENUE_DATE] != NULL && $data['master'][SL_REVENUE_DATE] != ""){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        if($data['master'][SL_ORDER_CLASSIFICATION] != 2){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $data['detail']['order_data'] = $this->order_detail_model->getByOrderId($id);
        $data['list_product'] = array();
        $data['list_customer'] = $this->customer_model->getByType($this->cus_type,0,PAGE_SIZE);
        $data['department'] = $this->customer_department_model->getByCustomer($data['master'][SL_CUSTOMER_ID]);
        $data['base_id'] = $this->base_id;
        $data['is_customer'] = $this->customer_account == null? 0:1;
        if($data['master']['customer_id'] !== NULL){
            $customer = $this->customer_model->getById($data['master']['customer_id']);
            if(in_array($customer, $data['list_customer']) == false){
                array_push($data['list_customer'], $customer);
            }
        }
        
        $temp = array();
        foreach ($data['detail']['order_data'] as $key => $value) {
            $product = $this->product_model->getById($value[OD_PRODUCT_CODE]);
            if(in_array($product, $data['list_product']) == false){
                array_push($temp, $product);
            }
        }
        if(count($temp) > 0){
            $data['list_product'] = array_merge( $data['list_product'] , $temp);
        }

        $this->load->view('templates/master',$data);
    }
    
    /*
    * Function : edit_delivery_order
    * Description : view for delivery
    * @author PHAN TIEN ANH
    */
    public function edit_delivery_order() {  
        $id = $this->input->get('id'); 
        
        // get order information
        $data['master'] = $this->order_detail_model->getInforOrderById($id, SL_ID); 
        if(!empty($data['master'])) {
            $data['master'] = array_shift($data['master']); 
        }

        if($data['master'] == NULL && $data['master'][SL_STATUS] != 1 || $data['master'][SL_STATUS] != "1"){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        
        // is gaichyu
        $data['is_gaichyu'] = false;
        $data['is_gaichyu_login'] = false;
        if($data['master']['is_gaichyu'] == 1 || $data['master']['is_gaichyu'] == "1") {
        $data['is_gaichyu'] = true;

        $is_gaichyu_hotel = $this->checkIsGroupRole(GR_SUBCONTRACTOR_LOCAL);
        $is_gaichyu_tenal = $this->checkIsGroupRole(GR_SUBCONTRACTOR_TENANT);
        if($is_gaichyu_hotel == true || $is_gaichyu_tenal == true) {
            $data['is_gaichyu_login'] = true;
        }
        }

        // Date order
        $data['master']['orderdate_print'] = $this->helper->readDate($data['master'][SL_SALES_DATE]);

        // intended date for delivery
        $data['master']['deliveryexpected_date_print'] = $this->helper->readDate($data['master'][SL_DELIVERY_DATE]);

        // date for delivery
        $data['master']['delivery_date_print'] = $this->helper->readDate($data['master'][SL_REVENUE_DATE]);
        
        // get order detail
        /*$base_code_price = $this->LOGIN_INFO[U_BASE_CODE];
        if($data['is_gaichyu'] == true) {
            $base_code_price = $data['master']['base_code']; 
        }*/
        $base_code_price = $this->LOGIN_INFO[U_BASE_CODE];
        $base_code_arr = $this->customer_department_model->getBaseByCustomerDepartment($data['master'][SL_CUSTOMER_ID],$data['master'][SL_DEPARTMENT_CODE]);
        if($base_code_arr != null) {
            $base_code_price = $base_code_arr[0]['base_code'];
        }

        $data['detail']['delivery_data'] = $this->order_detail_model->getByOrderDelivery($id, $base_code_price,$data['master'][SL_CUSTOMER_ID]);

        $data['content']='orders/edit_delivery_order';
        $data['title'] = $this->lang->line('edit_delivery_order');
        $this->load->view('templates/master',$data);
	}

    /*
    * Function : edit_delivery_post
    * Description : post function for delivery
    * @author PHAN TIEN ANH
    */
    public function edit_delivery_post() {
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id_order = $this->input->post('id_order');
            $delivery_date = $this->input->post('delivery_date');
            $date_update = $this->input->post('date_update');
            $note = $this->input->post('note');
            $detail = $this->input->post('detail');

            try{
                $this->delivery_model->db->trans_begin(); 
                $sumTotal = 0; 

                // kiểm tra dữ liệu đã update chưa
                if(!$this->order_model->isCheckDataUpdated($id_order,$date_update)) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_error_data_updated")
                    ));
                    return;
                }

                // Delete delivery
                $whereClause = array(
                    DD_ORDER_ID => $id_order
                );
                $this->delivery_model->removeByWhere($whereClause);

                // Query
                $detailCount = 0; 
                $quantity_product = 0;
                foreach ($detail as $key => $value) {
                    if($value['product_id'] != '' && $value['amount'] != '' && (float)$value['amount'] > 0){
                        $detailCount++;
                        $delivery_detail[DD_ORDER_ID] = $id_order;
                        $delivery_detail[DD_ORDER_DETAIL_ID] = $value['order_id'];
                        $delivery_detail[DD_PRODUCT_CODE] = $value['product_id'];
                        $delivery_detail[DD_PRODUCT_NAME] = $value['product_name'];
                        $delivery_detail[DD_DELIVERY_AMOUNT] = $value['amount'];

                        if(!empty($value['product_id'])) {
                            $quantity_product++;
                        }

                        // Validation
                        if((float)$value['special'] != 1) {
                            if($value['quantity'] > $value['quantity_order']) {
                                $this->delivery_model->db->trans_rollback();
                                echo json_encode(array(
                                    "success" => false,
                                    "message" => $this->lang->line("message_incorrect_quantity")
                                ));
                                return;
                            }
                        }

                        // Check
                        if($value['quantity'] != $value['quantity_old']) {
                            $delivery_detail[DD_CHECK] = 0;
                        }
                        else{
                            $delivery_detail[DD_CHECK] = ($value['check'] != '') ? (int)$value['check'] : 0;
                        }

                        // special
                        if($value['special'] != '' && (float)$value['special'] == 1) {
                            $delivery_detail[DD_UNIT_PRICE] = $value['amount'];
                            $delivery_detail[DD_QUANTITY] = 1;
                        }
                        else {
                            $delivery_detail[DD_UNIT_PRICE] = $value['price'];
                            $delivery_detail[DD_QUANTITY] = $value['quantity'];
                        }

                        // price_gaichyu
                        if($value['special'] != '' && (float)$value['special'] == 1) {
                            $delivery_detail[DD_GAICHYU_PRICE] = 0;
                        }
                        else {
                            $delivery_detail[DD_GAICHYU_PRICE] = $value['price_gaichyu'];
                        }

                        // Total
                        $sumTotal += (float)$value['amount'];

                        $this->delivery_model->add($delivery_detail);

                        if ($this->delivery_model->db->trans_status() === FALSE)
                        {
                            $this->delivery_model->db->trans_rollback();
                            echo json_encode(array(
                                "success" => false,
                                "message" => $this->lang->line("message_edit_error")
                            ));
                            return;
                        }
                    }
                }

                if($quantity_product == 0) {
                    $this->delivery_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }

                // Detail > 0
                if($detailCount > 0) {
                    // Update Order
                    $update_order[SL_REVENUE_DATE] = $delivery_date;
                    $update_order[SL_DELIVERY_NOTE] = $note; 
                    $update_order[SL_DELIVERY_AMOUNT] = $sumTotal;
                    $update_order[SL_TAX] = (float)$sumTotal * ((float)CONFIG_CONSUMPTION_TAX);
                    $update_order[SL_DATE_CHANGE] = date('Y-m-d H:i:s');
                    $update_order[SL_BASE_CODE] = $this->base_id;
                    
                    $this->delivery_model->db->set(SL_NUMBER_DELIVERY_MODIFY, SL_NUMBER_DELIVERY_MODIFY.'+1', FALSE);
                    $this->delivery_model->editOrder($id_order, $update_order);
                    
                    // End Query
                    if ($this->delivery_model->db->trans_status() === FALSE)
                    {
                        $this->delivery_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    }
                    else
                    {
                        $this->delivery_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                    }
                }
                else {
                    $this->delivery_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_delivery_detail_error")
                    ));
                    return;
                }

            }catch(Exception $ex){
                $this->delivery_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));
                return;
            }
        }
    }

    public function create_order() {
        if($this->cus_type != 1 && $this->cus_type != 0){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $data['content']='orders/createOrder';
        $data['title'] = $this->lang->line('create_order');

        // add order
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $meta = $this->input->post('meta');
            $detail = $this->input->post('detail');
            $this->order_model->db->trans_begin();
            try{
                $master[SL_SUMMARY] = $meta['note'];
                $master[SL_CUSTOMER_ID] = $meta['customer_id'] !=""?$meta['customer_id']:NULL;
                $master[SL_SALES_DATE] = $meta['order_date'];
                $master[SL_STATUS] = $meta['status'];
                $master[SL_ORDER_CLASSIFICATION] = 1;
                $master[SL_DELIVERY_DATE] = $meta['delivery_expected'];
                $master[SL_DEPARTMENT_CODE] = $meta['department'];
                $master[SL_USER_ID] = $this->LOGIN_INFO[U_ID];
                $master[SL_DATE_CHANGE] = date('Y-m-d H:i:s');
                $order_id = $this->order_model->add($master,SALES_LEDGER);

                foreach ($detail as $key => $value) {
                    if($value['product_id'] != ''){
                        $floor = json_decode($value['floor'],true);
                        $order_detail[OD_ORDER_ID] = $order_id;
                        $order_detail[OD_PRODUCT_CODE] = $value['product_id'];
                        $order_detail[OD_PRODUCT_NAME] = $value['product_name'];
                        $order_detail[OD_ADD] = $value['addition'];
                        $order_detail[OD_QUANTITY] = 0.0;
                        if($value['special'] == 1){
                            $order_detail[OD_QUANTITY] = 1;
                        }else{
                            foreach ($floor as $index => $quantity) {
                                $order_detail[OD_QUANTITY] += $quantity;
                            }
                        }
                        
                        $detail_id = $this->order_detail_model->add($order_detail,ORDER_DETAIL);
                        
                        if($value['special'] != 1){
                            // add floor
                            foreach ($floor as $index => $quantity) {
                                $floor_data[F_DETAIL_ID] = $detail_id;
                                $floor_data[F_FLOOR_NAME] = $index;
                                $floor_data[F_QUANTITY] = $quantity;
                                $this->order_detail_floor_model->add($floor_data);
                            }
                        }
                        
                    }
                    
                } 

                if ($this->order_model->db->trans_status() === FALSE)
                {
                        $this->order_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                }
                else
                {
                        $this->order_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                }
            }catch(Exception $ex){
                var_dump($ex);
                $this->order_model->db->trans_rollback();
                echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
            
        }

        // view order
        $data['list_product'] = array();
        $data['list_customer'] = $this->customer_model->getByType(1,0,PAGE_SIZE);
        $data['base_id'] = $this->base_id;
        $data['is_customer'] = $this->customer_account == null? 0:1;
        if($this->customer_account != NULL){
            $data['list_customer'] = array($this->customer_account);
        }
        $this->load->view('templates/master',$data);
	}

    public function create_order_2(){
        if($this->cus_type != 2 && $this->cus_type != 0){
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $data['content']='orders/createOrder2';
        $data['title'] = $this->lang->line('create_order');

        // add order
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $meta = $this->input->post('meta');
            $detail = $this->input->post('detail');
            $this->order_model->db->trans_begin();
            try{
                $master[SL_SUMMARY] = $meta['note'];
                $master[SL_CUSTOMER_ID] = $meta['customer_id'] !=""?$meta['customer_id']:NULL;
                $master[SL_SALES_DATE] = $meta['order_date'];
                $master[SL_STATUS] = $meta['status'];
                $master[SL_ORDER_CLASSIFICATION] = 2;
                $master[SL_DELIVERY_DATE] = $meta['delivery_expected'];
                $master[SL_DEPARTMENT_CODE] = $meta['department'];
                $master[SL_USER_ID] = $this->LOGIN_INFO[U_ID];
                $master[SL_DATE_CHANGE] = date('Y-m-d H:i:s');
                $order_id = $this->order_model->add($master,SALES_LEDGER);
                foreach ($detail as $key => $value) {
                    if($value['product_id'] != ''){
                        if($value['quantity'] == null || $value['quantity'] == '')
                            continue;
                        $order_detail[OD_ORDER_ID] = $order_id;
                        $order_detail[OD_PRODUCT_CODE] = $value['product_id'];
                        $order_detail[OD_PRODUCT_NAME] = $value['product_name'];
                        if($value['special'] == 1){
                            $value['quantity'] = 1;
                        }
                        $order_detail[OD_QUANTITY] = $value['quantity'];
                        $detail_id = $this->order_detail_model->add($order_detail,ORDER_DETAIL);
                        
                    }
                    
                } 

                if ($this->order_model->db->trans_status() === FALSE)
                {
                        $this->order_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                }
                else
                {
                        $this->order_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                }
            }catch(Exception $ex){
                $this->order_model->db->trans_rollback();
                echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
            
        }
        // view order
        $data['list_product'] = array();
        $data['list_customer'] = $this->customer_model->getByType(2,0,PAGE_SIZE);
        $data['base_id'] = $this->base_id;
        $data['is_customer'] = $this->customer_account == null? 0:1;
        if($this->customer_account != NULL){
            $data['list_customer'] = array($this->customer_account);
        }
        $this->load->view('templates/master',$data);
    }

    public function check_list_post() {
        if($this->input->server("REQUEST_METHOD") == "POST"){
            // Data
            $data = $this->input->post("data");
            $date_update = $this->input->post("date_update");
            $id_order = $this->input->post("id_order");
            if(count($data) != 0){ 
                foreach ($data as $key => $value) { 
                    // kiểm tra dữ liệu đã update chưa
                    if($key == 0) {
                        if(!$this->order_model->isCheckDataUpdated($id_order[$key],$date_update[$key])) {
                            echo json_encode(array(
                                "success" => false,
                                "message" => $this->lang->line("message_error_data_updated")
                            ));
                            return;
                        }
                    }

                    $this->delivery_model->editOrder($id_order[$key],array(SL_ID =>$id_order[$key]));
                    $this->delivery_model->checkList($value,array(DD_CHECK =>1));
                }
            }
        }
        echo json_encode(array(
            "success" => true,
            "message" => $this->lang->line("message_checklist_success")
        ));
	}

    public function get_order_view(){
        
        $customer = $this->input->get('customer');
        $user = $this->input->get('user');
        $order_from = $this->input->get('order_from');
        $order_to = $this->input->get('order_to');
        $delivery_from = $this->input->get('delivery_from');
        $delivery_to = $this->input->get('delivery_to');
        $status = $this->input->get('status');
        $status = $status == ""?null:$status;
        $claim_check = $this->input->get('claim_check');
        $department = $this->input->get('department');
        $start_index = $this->input->get('start_index');
        $order_no = $this->input->get('order_no');
        $customer = $this->customer_account == null? $customer:$this->customer_account[CUS_ID];
        $is_customer = $this->customer_account == null? 0:1;
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }
        if($start_index == 0 || $start_index >= PAGE_SIZE) { 
            $result = $this->order_model->getOrderView($user,$customer,$status,$claim_check,$department,$order_from,$order_to,$delivery_from,$delivery_to,
            $order_no,$is_customer,$start_index,PAGE_SIZE,SL_DATE_CHANGE,"DESC");
        }
        echo json_encode($result);
    }
 
    /**
	* Function: function_list_order_checklist
	* @access public
	*/
	public function function_list_order_checklist($dataModel) {
        $datadetail = array();
        $string_data = "";

		if($dataModel != NULL) {
			foreach ($dataModel as $key => $value) {
				array_push(
					$datadetail,
					$value["order_id"]
				);
			}

			// Group BY
			$datadetail = array_map("unserialize", array_unique(array_map("serialize", $datadetail)));
			$datadetail = array_values($datadetail);
        }
        
        $string_data = implode(",",$datadetail);;
		
		return $string_data;
    }
    
    /**
	* Function: get_checklist_view
	* @access public 
	*/ 
    public function get_checklist_view(){
        
        $user = $this->input->get('user');
        $customer = $this->input->get('customer');
        $order_from = $this->input->get('order_from');
        $order_to = $this->input->get('order_to');
        $delivery_from = $this->input->get('delivery_from');
        $delivery_to = $this->input->get('delivery_to');
        $department = $this->input->get('department');
        $order_no = $this->input->get('order_no');
        $resultOrder_default = $this->delivery_model->getChecklistDelivery(null,null,null,null,null,null,null,null, true);
        $resultOrder = $this->delivery_model->getChecklistDelivery($user,$customer,$order_from,$order_to,$delivery_from,$delivery_to,$department,$order_no, true);
        if($resultOrder != null && $resultOrder != "") {
            $listChecklist = $this->function_list_order_checklist($resultOrder);
            $resultDetail = $this->delivery_model->getChecklistDelivery($user,$customer,$order_from,$order_to,$delivery_from,$delivery_to,$department,$order_no, false,$listChecklist);
        }
        echo json_encode(
            array(
                "order" => $resultOrder,
                "detail" => $resultDetail,
                "count_default" => count($resultOrder_default),
                "count_search" => count($resultOrder)
            ));
    }



    public function delete_order(){
        if( $this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');
            $master = $this->order_model->getById($id);
            if($master == NULL){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_remove_error")
                ));;
               return;
            }
            if($master[SL_REVENUE_DATE] != NULL && $master[SL_REVENUE_DATE] != ""){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_remove_error")
                ));;
               return;
            }
            if($this->customer_account != null && $this->LOGIN_INFO[U_ID] != $master[SL_USER_ID]){
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_remove_error")
                ));;
               return;
            }
            $result = $this->order_model->remove($id,SALES_LEDGER);
            $message = $this->lang->line("message_remove_success");
            if($result == true){
                $message = $this->lang->line("message_remove_error");
            }
            echo json_encode(array("success" => $result,"message" => $message));
        }
    }

    public function pdf_floor(){
        $id = $this->input->get('id');
        $mpdf = new mPDF();
        $order = $this->order_model->getById($id);
        if($order == NULL)
        {
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $html = "";
        $data['date'] = $this->helper->readDate($order[SL_DELIVERY_DATE]);
        $data['data'] = $this->order_model->pdfFloor($id);
        if($order[SL_ORDER_CLASSIFICATION] == 1){
            $html = $this->load->view("templates/orders/pdf_floor",$data,true);
        }
         
        //var_dump($html);
        $mpdf->SetTitle("客室短冊");
        $mpdf->WriteHTML($html);
        $mpdf->Output("客室短冊.pdf","I");
        
    }
    public function pdf_order(){
        $id = $this->input->get('id');
        $mpdf = new mPDF();
        $order = $this->order_model->getById($id);
        if($order == NULL)
        {
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $html = "";
        $data['date'] = $this->helper->readDate($order[SL_DELIVERY_DATE]);
        $data['floor'] = $this->order_model->pdfFloor($id);
        $data['productLst'] = $this->order_detail_model->getByOrderId($id);
        $size = count($data['productLst']);
        $size = (int)($size/20) + ($size%20 != 0?1:0);
        $temp = $data['productLst'];
        $data['productLst'] = array();
        $j = 0;
        for($i=0;$i<$size;$i++){
            $data['productLst'][$i] = array();
            $index = 0;
            for(;$j<count($temp) && $j<($i+1)*20;$j++){
                $data['productLst'][$i][$index] = $temp[$j];
                $index += 1;
            }
        }
        if($order[SL_ORDER_CLASSIFICATION] == 1){
            $html = $this->load->view("templates/orders/pdf_order",$data,true);
        }
         
        //var_dump($html);
        $mpdf->SetTitle("客室納品書");
        $mpdf->WriteHTML($html);
        $mpdf->Output("客室納品書.pdf","I");
    }

    public function pdf_delivery(){
        $id = $this->input->get('id');
        $mpdf = new mPDF('utf8','A4');
        $order = $this->order_model->getById($id);
        if($order == NULL)
        {
            redirect( base_url('receive-order'), 'refresh');
            exit();
        }
        $delivery = $this->delivery_model->getByOrderId($id);
        $html = "";
        $data['id'] = $order[SL_ID];
        $data['company_name'] = $order['customer_name'];
        $data['other_name'] = $order['customer_short_name'];
        $data['delivery'] = $delivery;
        $data["date"] = $this->helper->readDate($order[SL_DELIVERY_DATE]);
        $size = count($data['delivery']);
        $size = (int)($size/25) + ($size%25 != 0?1:0);
        $temp = $data['delivery'];
        $data['delivery'] = array();
        $j = 0;
        for($i=0;$i<$size;$i++){
            $data['delivery'][$i] = array();
            $index = 0;
            for(;$j<count($temp) && $j<($i+1)*25;$j++){
                $data['delivery'][$i][$index] = $temp[$j];
                $index += 1;
            }
        }

        $mpdf->setFooter('');
        $html = $this->load->view("templates/orders/pdf_delivery",$data,true);

        $mpdf->SetTitle("客室短冊");
        $mpdf->WriteHTML($html);
        $mpdf->Output("客室短冊.pdf","I");
        
    }

    public function check_list() {
        $data['title'] = $this->lang->line('check_list');
        $data['content'] ='orders/checklist';
        $data['list_cus'] = $this->customer_model->getAll();
        //$data['list_user'] = $this->user_model->getAll();
        if($this->level == "P"){
            $data['list_user'] = $this->user_model->getUserForOrderManager($this->LOGIN_INFO[U_ID]);
            $data['list_user2'] = $this->user_model->getUserForCustomer($this->LOGIN_INFO[U_ID]);
        } else {
            $data['list_user'] = $this->user_model->getAll();
        }
        $data['cus_type'] = $this->cus_type;
        $data['list_department'] = $this->customer_department_model->getDepartment();
        $this->load->view('templates/master',$data);
    }
    

    /**
	* Function: pdf_checklist
	* @access public
	*/
	public function pdf_checklist() {
		$this->load->library('mpdf');
		$pdf = new mPDF('utf8','A3-L','','',15,15,25,16,9,9);  
		
		$title=$this->lang->line('pdf_check_list');
		$pdf->SetTitle($title);
		$data = array();
        $data['title'] = $title;
        $data['user_login'] = $this->LOGIN_INFO[U_ID];
		$data['date_report_now'] = $this->helper->readDateYearKing(date("Y/m/d"));
        $htmlHeader= $this->load->view('templates/orders/pdf_checklist/pdf_header', $data, true);
        $pdf->SetHTMLHeader($htmlHeader);
        
        // Data
        $user = $this->input->get('user');
        $customer = $this->input->get('customer');
        $order_from = $this->input->get('order_from');
        $order_to = $this->input->get('order_to');
        $delivery_from = $this->input->get('delivery_from');
        $delivery_to = $this->input->get('delivery_to');
        $department = $this->input->get('department');
        $order_no = $this->input->get('order_no');
        $data["data_order"] = $this->delivery_model->getChecklistDelivery($user,$customer,$order_from,$order_to,$delivery_from,$delivery_to,$department,$order_no, true);
        if( $data["data_order"] != null &&  $data["data_order"] != "") {
            $listChecklist = $this->function_list_order_checklist($data["data_order"]);
            $data["data_detail"] = $this->delivery_model->getChecklistDelivery($user,$customer,$order_from,$order_to,$delivery_from,$delivery_to,$department,$order_no, false,$listChecklist);
        }
        // End Data

		$html= $this->load->view('templates/orders/pdf_checklist/pdf_content', $data, true);
		
		// write the HTML into the PDF
        $pdf->WriteHTML($html);
        $output = $title.'.pdf';
        
        $getPrint = $this->input->get('print');
		if($getPrint === 'true') { 
			$pdf->SetJS('this.print();');
        }
        if($data["data_order"] == null || count($data["data_order"]) <= 0) {
            $pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $pdf->Output("$output", 'I'); 
    }
    
    /**
    * Function: export
    * @access public
    */
	public function export(){
		$title = $this->lang->line('receive_order');

		// Data
        $customer = $this->input->get('customer');
        $user = $this->input->get('user');
        $order_from = $this->input->get('order_from');
        $order_to = $this->input->get('order_to');
        $delivery_from = $this->input->get('delivery_from');
        $delivery_to = $this->input->get('delivery_to');
        $status = $this->input->get('status');
        $status = $status == ""?null:$status;
        $claim_check = $this->input->get('claim_check');
        $department = $this->input->get('department');
        $start_index = $this->input->get('start_index');
        $order_no = $this->input->get('order_no');
        
        if($start_index == NULL){
            $start_index = 0;
        }
        $result = $this->order_model->getOrderView($user,$customer,$status,$claim_check,$department,$order_from,$order_to,$delivery_from,$delivery_to,
            $order_no,$start_index,PAGE_SIZE,SL_SALES_DATE,"DESC");
		
		// Column name
		$column_title = array("注文No","注文日","お得意先","部署名","起票者","形態","注文数","追加","納品数","売上(納品)日");
		$column_show_data = array("id","order_date","customer_name","department","created_name","status","order_number","add_number","delivery_number","delivery_expected");

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
    }
    
    /**
    * Function: copy_order_to_shipment
    * copy order giao hàng sang xuất hàng
    * @access public
    */
	public function copy_order_to_shipment(){
        $order_id = $this->input->post('order_id');
        $customer_id = $this->input->post('customer_id');
        $success = false;
        $message = $this->lang->line("message_copy_order_to_shipment_error");
        $user_name = $this->LOGIN_INFO[U_ID];

        if($order_id != null && $order_id != "") {
            // Validation
            $flg_copy_department = $this->delivery_model->checkCopyOrderShipmentDepartment($customer_id);
            if((int)$flg_copy_department <= 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_copy_order_to_shipment_error_department")
                ));
                return;
            }

            // Begin
            $this->shipment_model->db->trans_begin();
            $this->shipment_detail_model->db->trans_begin();
            $detail_delivery = $this->shipment_model->getOrderToShipment($order_id); 

            if($detail_delivery != null && count($detail_delivery) > 0) {
                $shipment_meta = [];
                $shipment_meta[OS_ORDER_DATE] = date("Y/m/d"); // ngay tao order
                $shipment_meta[OS_DELIVERY_DATE] = date("Y/m/d"); // ngay du dinh giao hang
                $shipment_meta[OS_STATUS] = 5; // trang thai
                $shipment_meta[OS_ORDERER] = $user_name; // người tạo order
                $shipment_meta[OS_SHIPPER] = $user_name; // người gửi hàng
                $shipment_meta[OS_ORDER_CONFIRMATION] = 1;
                $shipment_meta[OS_FINAL_DELIVERY] = 1;
                $shipment_meta[OS_ORDER_CONFIRMATION_DATETIME] = date("Y/m/d");
                $shipment_meta[OS_SHIPMENT_DECISION_DATETIME] = date("Y/m/d"); // ngày yêu cầu hóa đơn
                $shipment_meta[OS_FLAG_COPY_DELIVERY] = true;

                $shipment_id = $this->shipment_model->add($shipment_meta);

                foreach ($detail_delivery as $key => $value) {
                    if($value['quantity'] != "" && $value['quantity'] != null && (int)$value['quantity'] > 0) {
                        $shipment_detail = [];
                        $shipment_detail[OSHD_ORDER_ID] = $shipment_id; // id order
                        $shipment_detail[OSHD_CUSTOMER_ID] = $value['customer_id']; // customer
                        $shipment_detail[OSHD_DEPARTMENT_ID] = DEPARTMENT_SHIPMENT_COPY_ORDER; // phong ban
                        $shipment_detail[OSHD_PRODUCT_CODE] = $value['product_id']; // product
                        $shipment_detail[OSHD_QUANTITY] = $value['quantity']; // số lượng
                        $shipment_detail[OSHD_DELIVERY] = $value['quantity']; // số lượng

                        $this->shipment_detail_model->add($shipment_detail);

                        if ($this->shipment_detail_model->db->trans_status() === FALSE)
                        {
                            $this->shipment_model->db->trans_rollback();
                            $this->shipment_detail_model->db->trans_rollback();
                            echo json_encode(array(
                                "success" => $success,
                                "message" => $message
                            ));
                            return;
                        }
                    }
                }
                
                if ($this->shipment_model->db->trans_status() === FALSE)
                {
                    $this->shipment_model->db->trans_rollback();
                    $this->shipment_detail_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => $success,
                        "message" => $message
                    ));
                    return;
                }
                else
                {
                    $this->shipment_model->db->trans_commit();
                    $this->shipment_detail_model->db->trans_commit();

                    $delivery_detail = [];
                    $delivery_detail[SL_FLG_COPY_SHIPMENT] = true;
                    $this->order_reason_model->edit($order_id,$delivery_detail);
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_copy_order_to_shipment_success")
                    ));
                    return;
                }
            }
        }

        echo json_encode(array(
            "success" => $success,
            "message" => $message
        ));
    }
}
