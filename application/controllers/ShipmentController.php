<?php
/**
* Class ShipmentController
* Manage Shipment 
* 
* @author Creater: PHAN TIEN ANH
* @author Updater: PHAN TIEN ANH
*
* Last updated: 2017-11-06
* File  location: application/controllers/ShipmentController.php 
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class ShipmentController extends VV_Controller {
 	
 	// Construct function
	public function __construct()
    { 
        parent::__construct();
        $this->load->model('Shipment','shipment_model');
        $this->load->model('CustomerShipmentModel','customer_of_shipment_model');
        $this->load->model('Shipment_Detail','shipment_detail_model');
        $this->load->model('Shipment_Classification','shipment_classification_model');
        $this->load->model('ProductShipmentSet','product_set_shipment_model');
        $this->load->model('My_One_Touch','my_one_touch_model');
        $this->load->model('Customer','customer_model');
        $this->load->model('Department','department_model');
        $this->load->model('Product','product_model');
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('CustomerDepartmentShipment','customer_department_shipment_model');
        $this->LOGIN_INFO = $this->session->userdata('login-info');
        $this->load->library('helper','helper');
        $this->load->model('ImportExportCsv'); 

        // Var
        $this->varTitle = "title";
    }

    /**
	* Function: index
	* index page
	* @access public
	*/
	public function index() 
	{
        $data['role_manager'] = $this->checkIsGroupRole(GR_SYSTEM_ADMINISTRATOR);
        $data['role_shipment'] = $this->checkIsGroupRole(GR_ATSUGI_FACTORY_PERSONNEL);
        $data['role_order'] = $this->checkIsGroupRole(GR_TOKYO_OTHER_ORDERING_PERSON);
        $data[$this->varTitle] = $this->lang->line('shipment_index');
        $data['list_classification'] = $this->shipment_classification_model->getClassificationByBase($this->LOGIN_INFO[U_BASE_CODE]);
        $data['content'] = 'shipments/index';
        $this->load->view('templates/master',$data);
	}

	/**
	* Function: get_shipment_view
	* search in shipment
	* @access public
	*/
	public function get_shipment_view(){
        
        $ticket_no = $this->input->get('ticket_no');
        $voter = $this->input->get('voter');
        $shipping_category = $this->input->get('shipping_category');
        $shipment_status = $this->input->get('shipment_status');
        $delivery_from = $this->input->get('delivery_from');
        $delivery_to = $this->input->get('delivery_to');
        $customer = $this->input->get('customer');
        $department_name = $this->input->get('department_name');
        $text_note = $this->input->get('text_note');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }
        $result = array();
        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->shipment_model->getShipmentView($ticket_no,$voter,$shipping_category,$shipment_status,$delivery_from,$delivery_to,$customer,$department_name,$text_note,$start_index,PAGE_SIZE,OS_ID,"DESC");
        }
        echo json_encode($result);
    }

    /**
    * Function: get_customer_by_classification
    * @access public
    */
    public function get_customer_by_classification(){ 
        $classification = $this->input->get('classification_id');
        $search_name = $this->input->get('name');
        $start_index = $this->input->get('start_index');
        $number = $this->input->get('number');
        $result = array();
        $result = $this->shipment_classification_model->getCustomerByClassification($classification, true, $search_name);
        echo json_encode($result);
    }

    /**
    * Function: get_deparment_by_customer
    * @access public
    */
    public function get_deparment_by_customer(){ 
        $customer_id = $this->input->get('customer_id');
        $result = $this->customer_department_shipment_model->getByCustomer($customer_id);
        echo json_encode($result);
    }

    /**
    * Function: get_customer_by_department
    * @access public
    */
    public function get_customer_by_department(){ 
        $department_id = $this->input->get('department_id');
        $result = $this->customer_department_shipment_model->getByDepartment($department_id);
        echo json_encode($result);
    }

    /**
    * Function: add_shipment
    * creater shipment
    * @access public
    */
    public function add_shipment() 
	{
        $data[$this->varTitle]=$this->lang->line('add_shipment');
        $data['shipment_id']="";
        $data['user_name'] = $this->LOGIN_INFO[U_ID];
        $data['list_classification'] = $this->shipment_classification_model->getClassificationByBase($this->LOGIN_INFO[U_BASE_CODE]);
        $data['product_default'] = $this->product_model->getProductSelectBox(null,null,2,false,0,1,PL_PRODUCT_ID,"DESC");
        //$data['list_customer_shipment'] = $this->customer_of_shipment_model->getAll();
        $data['content']='shipments/add_shipment';
        $this->load->view('templates/master',$data);
	}

    /**
    * Function: get_set_product
    * @access public
    */
    public function get_set_product(){ 
        $customer = $this->input->get('customer_id');
        $result = $this->product_set_shipment_model->getSetProductByCustomerForShipment($customer);
        echo json_encode($result);
    }

    /**
    * Function: get_setproduct_by_customer_base 
    * @access public
    */
    public function get_my_one_touch(){ 
        $delivery_classifition = $this->input->get('delivery_classifition_id');
        $customer = $this->input->get('customer_id');
        $department = $this->input->get('department_id');
        $user_name = $this->LOGIN_INFO[U_ID];
        $result = $this->my_one_touch_model->getProductByUserClassifition($user_name,$delivery_classifition,$customer,$department);
        echo json_encode($result);
    }

    /**
    * Function: get_detail_set_one_touch
    * @access public
    */
    public function get_detail_set_one_touch(){
        $set_product = $this->input->get('set_product');
        $my_one_touch = $this->input->get('my_one_touch');
        $customer = $this->input->get('customer');
        $department = $this->input->get('department'); 
        $classification = $this->input->get('classification');  
        $user_name = $this->LOGIN_INFO[U_ID];
        if($my_one_touch != "") {
            $result = $this->product_model->get_by_one_touch($my_one_touch,$customer,$department,$user_name);
        }
        else { 
            $result = $this->product_model->get_by_set_shipment($set_product,$customer);  
        }

        $list_customer = $this->shipment_classification_model->getCustomerByClassification($classification, true, '');
        $list_department = $this->customer_department_shipment_model->getByCustomer($customer);
        
        echo json_encode(array(
            "list_customer" => $list_customer,
            "list_department" => $list_department,
            "product" => $result
        ));
    }

    /**
    * Function: get_detail_product
    * @access public
    */
    public function get_detail_product(){ 
        $product_id = $this->input->get('product_id');
        $result = $this->product_model->get_product_by_id($product_id);
        echo json_encode($result);
    }

    /**
    * Function: get_container_shipment
    * @access public
    */
    public function get_container_shipment(){ 
        $lblTotal = "";
        $lblWeight = "";
        $lblTruckMain ="";
        $lblTruckAid ="";
        $arrDetailContainer = [];
        $arrCustomer = array();
        $arrNumberContainer = array();

        if($this->input->method(TRUE) == 'POST') {
            $type_delivery = $this->input->post('type_delivery'); 

            $ContInTruck = $this->input->post('ContInTruck'); 
            $WeightInTruck = $this->input->post('WeightInTruck');
            $Truck = $this->input->post('Truck');
            $detail = $this->input->post('detail');
            

            $coutOrder = 0;
            $countNumberDelivery = 0;
            if($detail != null && $detail != '') {
                if(count($detail) <= 0) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line('message_not_add_detail')
                    ));
                    return;
                }

                // Container
                $valueWeight = 0;
                foreach ($detail as $key => $value) {
                    
                    $quantity = $value['quantity'];
                    if($type_delivery === 'true') {
                        $quantity = $value['quantity_delivery'];
                        $countNumberDelivery += $quantity;
                    }
                    
                    // Validation
                    if($type_delivery === 'true') {
                        if(($quantity == '') || ($quantity != '' && (int)$quantity < 0)) {
                            echo json_encode(array(
                                "success" => false,
                                "message" => $this->lang->line('message_check_isNull_quantity_error')
                            ));
                            return;
                        }
                    } else {
                        if(($quantity == '') || ($quantity != '' && (int)$quantity <= 0)) {
                            echo json_encode(array(
                                "success" => false,
                                "message" => $this->lang->line('message_check_isNull_quantity_error')
                            ));
                            return;
                        }
                    }
                    

                    if(($value['container1'] == '') || ($value['container1'] != '' && (int)$value['container1'] <= 0) ) {
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line('message_check_isNull_container_error')
                        ));
                        return;
                    }
                    if(($value['container2'] == '') || ($value['container2'] != '' && (int)$value['container2'] <= 0) ) {
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line('message_check_isNull_container_error')
                        ));
                        return;
                    }

                    if((int)$quantity > 0 && (int)$value['container1'] > 0) {
                        // Validation container
                        if($value['container2'] != '' && (int)$value['container2'] > 0) {
                            if((int)$value['container2'] < (int)$value['container1']) {
                                echo json_encode(array(
                                    "success" => false,
                                    "message" => $this->lang->line('message_check_container_error')
                                ));
                                return;
                            }
                        }

                        // MAX_CONTAINER
                        if((int)$value['container1'] > MAX_CONTAINER) {
                            echo json_encode(array(
                                "success" => false,
                                "message" => $this->lang->line('message_error_max_container')
                            ));
                            return;
                        }
                        if((int)$value['container2'] > MAX_CONTAINER) {
                            echo json_encode(array(
                                "success" => false,
                                "message" => $this->lang->line('message_error_max_container')
                            ));
                            return;
                        }

                        array_push($arrNumberContainer, $value['container1']);
                        array_push($arrNumberContainer, $value['container2']);

                        // Weight
                        if($value['product_weight'] == '') {
                            $value['product_weight'] = 0;
                        }
                        if((int)$quantity > 0 && (int)$value['container1'] > 0) {
                            $quantity_order = (int)$value['quantity'] + (int)$value['quantity_change'];
                            if($type_delivery === 'true') {
                                $quantity_order = $quantity;
                            }
                            $valueWeight += $quantity_order * (int)$value['product_weight'];
                        }

                        $coutOrder++;
                    }

                    // Detail Container
                    $arrDetailContainer[] = array($value['customer'], $value['department'],$value['product_id'], $value['container1'], $value['container2'],$value['customer_name'], $value['department_name']);
                    array_push($arrCustomer,$value['customer']);
                }

                if($type_delivery === 'true') {
                    if((int)$countNumberDelivery <= 0) {
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line('message_check_isNull_quantity_error')
                        ));
                        return;
                    }
                }

                // bóc tách array
                if($arrDetailContainer != null && $arrDetailContainer != '') {
                    $arrCustomer = array_map("unserialize", array_unique(array_map("serialize", $arrCustomer)));

                    $arrCustomerDepartment = array();
                    foreach ($arrCustomer as $key => $value) {
                        $idCustomer = $value;
                        $arrContainerDepartment = array();

                        $arrDepartment = array();
                        foreach ($arrDetailContainer as $keyContainer => $valueContainer) {
                            if($idCustomer == $valueContainer[0]) {
                                array_push($arrDepartment,$valueContainer[1]);
                            }
                        }    

                        array_push(
                            $arrCustomerDepartment,
                            array(
                                'customer' => $idCustomer,
                                'detail' => array_unique($arrDepartment)
                            )
                        );
                    }
                }
                else {
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line('message_not_select_container_error')
                    ));
                    return;
                }

                // Count container
                $listCountContainer = [];
                if($arrCustomerDepartment != null && $arrCustomerDepartment != '') {
                    foreach ($arrCustomerDepartment as $key => $value) {
                        $idCustomer = $value['customer'];
                        $countDepartment = sizeof($value['detail']);
                        if($countDepartment > 1) {
                            foreach ($value['detail'] as $key2 => $detail) {
                                $arrContainerDepartment = array();
                                $nameContainer = '';
                                foreach ($arrDetailContainer as $keyContainer => $valueContainer) {
                                    if($idCustomer == $valueContainer[0] && $detail == $valueContainer[1]) {
                                        if($valueContainer[3] != 0)
                                            array_push($arrContainerDepartment,$valueContainer[3]);
                                        if($valueContainer[4] != 0)
                                            array_push($arrContainerDepartment,$valueContainer[4]);
                                        $nameContainer = $valueContainer[6];
                                    }
                                }    

                                // Count Container
                                $arrContainerDepartment = array_map("unserialize", array_unique(array_map("serialize", $arrContainerDepartment)));
                                $arrContainerDepartment = array_values($arrContainerDepartment);
                                $countContainer = ($arrContainerDepartment[count($arrContainerDepartment)-1] - $arrContainerDepartment[0])+1;

                                array_push(
                                    $listCountContainer,
                                    array(
                                        'container' => $nameContainer,
                                        'num' => $countContainer
                                    )
                                );
                            }
                        } 
                        else {
                            $arrContainerDepartment = array();
                            $nameContainer = '';
                            foreach ($arrDetailContainer as $keyContainer => $valueContainer) {
                                if($idCustomer == $valueContainer[0]) {
                                    if($valueContainer[3] != 0)
                                        array_push($arrContainerDepartment,$valueContainer[3]);
                                    if($valueContainer[4] != 0)
                                        array_push($arrContainerDepartment,$valueContainer[4]);
                                    $nameContainer = $valueContainer[5];
                                }
                            }    

                            // Count Container
                            $arrContainerDepartment = array_map("unserialize", array_unique(array_map("serialize", $arrContainerDepartment)));
                            $arrContainerDepartment = array_values($arrContainerDepartment);
                            $countContainer = ($arrContainerDepartment[count($arrContainerDepartment)-1] - $arrContainerDepartment[0])+1;

                            array_push(
                                $listCountContainer,
                                array(
                                    'container' => $nameContainer,
                                    'num' => $countContainer
                                )
                            );
                        }
                    }
                }

                // Container
                $listCountContainernew = array();
                foreach ($listCountContainer as $key => $value) {
                    $nameContainer = $value['container'];
                    $numContainer = 0;
                    foreach ($listCountContainer as $key2 => $value2) {
                        if($nameContainer == $value2['container']) {
                            $numContainer = (float)$numContainer + (float)$value2['num'];
                        }
                    }
                    array_push(
                        $listCountContainernew,
                        array(
                            'container' => $nameContainer,
                            'num' => $numContainer
                        )
                    );
                }

                $listCountContainernew = array_map("unserialize", array_unique(array_map("serialize", $listCountContainernew)));

                $listCountContainernew = array_values($listCountContainernew);

                // Check Detail
                if($coutOrder < 1) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line('message_check_isNull_detail')
                    ));
                    return;
                }

                // Count container
                $arrNumberContainer = array_map("unserialize", array_unique(array_map("serialize", $arrNumberContainer)));
                $arrNumberContainer = array_values($arrNumberContainer);
                $lblTotal = count($arrNumberContainer);

                // Weight
                $valueWeight = round((((float)$lblTotal * (float)CONFIG_NUM_CONTWEIGHT * 1000) + $valueWeight) / 1000);
                $lblWeight = $valueWeight;

                // Truck
                $dblValue = (float)$lblTotal / (float)$ContInTruck;
                $intRet = (float)$dblValue - (float)$Truck;

                if($intRet < 0) {
                    $lblTruckMain = 1;
                    $lblTruckAid = 0;
                } elseif($intRet == 0) {
                    $lblTruckMain = $Truck;
                    $lblTruckAid = 0;
                }
                else {
                    $lblTruckMain = $Truck;
                    $lblTruckAid = ceil($intRet);
                }

                // Check total
                $totalWeightTruck = ((int)$lblTruckMain + (int)$lblTruckAid) * $WeightInTruck;
                if((float)$lblWeight > (float)$totalWeightTruck) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line('message_check_total_error')
                    ));
                    return;
                }
            } else {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line('message_not_add_detail')
                ));
                return;
            }
        } else {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line('message_error_ajax')
            ));
            return;
        }

        echo json_encode(array(
            "success" => true,
            "lblTotal" => $lblTotal,
            "lblWeight" => $lblWeight,
            "lblTruckMain" => $lblTruckMain,
            "lblTruckAid" => $lblTruckAid,
            "detailContainer" => $listCountContainernew,
        ));
    }

    /**
    * Function: getListCountContainer
    * @access public
    */
    public function getListCountContainer($detail){ 
        $listCountContainer = array();
        if($detail != null) {
            $arrDetailContainer = [];
            $arrCustomer = array();

            foreach ($detail as $key => $value) {
                // Detail Container
                $arrDetailContainer[] = array($value[OSHD_CUSTOMER_ID], $value[OSHD_DEPARTMENT_ID],$value[OSHD_PRODUCT_CODE], $value[OSHD_CONTAINER1], $value[OSHD_CONTAINER2],$value['customer_name'], $value['department_name']);
                array_push($arrCustomer,$value[OSHD_CUSTOMER_ID]);
            }

            // bóc tách array
            $arrCustomer = array_unique($arrCustomer);
            $arrCustomerDepartment = array();
            foreach ($arrCustomer as $key => $value) {
                $idCustomer = $value;
                $arrContainerDepartment = array();

                $arrDepartment = array();
                foreach ($arrDetailContainer as $keyContainer => $valueContainer) {
                    if($idCustomer == $valueContainer[0]) {
                        array_push($arrDepartment,$valueContainer[1]);
                    }
                }    

                array_push(
                    $arrCustomerDepartment,
                    array(
                        'customer' => $idCustomer,
                        'detail' => array_unique($arrDepartment)
                    )
                );
            }

            // Count container
            if($arrCustomerDepartment != null && $arrCustomerDepartment != '') {
                foreach ($arrCustomerDepartment as $key => $value) {
                    $idCustomer = $value['customer'];
                    $countDepartment = sizeof($value['detail']);
                    if($countDepartment > 1) {
                        foreach ($value['detail'] as $key2 => $detail) {
                            $arrContainerDepartment = array();
                            $nameContainer = '';
                            foreach ($arrDetailContainer as $keyContainer => $valueContainer) {
                                if($idCustomer == $valueContainer[0] && $detail == $valueContainer[1]) {
                                    if($valueContainer[3] != 0)
                                        array_push($arrContainerDepartment,$valueContainer[3]);
                                    if($valueContainer[4] != 0)
                                        array_push($arrContainerDepartment,$valueContainer[4]);
                                    $nameContainer = $valueContainer[6];
                                }
                            }    

                            // Count Container
                            $arrContainerDepartment = array_map("unserialize", array_unique(array_map("serialize", $arrContainerDepartment)));
                            $arrContainerDepartment = array_values($arrContainerDepartment);
                            $countContainer = ($arrContainerDepartment[count($arrContainerDepartment)-1] - $arrContainerDepartment[0])+1;

                            array_push(
                                $listCountContainer,
                                array(
                                    'container' => $nameContainer,
                                    'num' => $countContainer
                                )
                            );
                        }
                    } 
                    else {
                        $arrContainerDepartment = array();
                        $nameContainer = '';
                        foreach ($arrDetailContainer as $keyContainer => $valueContainer) {
                            if($idCustomer == $valueContainer[0]) {
                                if($valueContainer[3] != 0)
                                    array_push($arrContainerDepartment,$valueContainer[3]);
                                if($valueContainer[4] != 0)
                                    array_push($arrContainerDepartment,$valueContainer[4]);
                                $nameContainer = $valueContainer[5];
                            }
                        }    

                        // Count Container
                        $arrContainerDepartment = array_map("unserialize", array_unique(array_map("serialize", $arrContainerDepartment)));
                        $arrContainerDepartment = array_values($arrContainerDepartment);
                        if($arrContainerDepartment != null && count($arrContainerDepartment) >  0) {
                            $countContainer = ($arrContainerDepartment[count($arrContainerDepartment)-1] - $arrContainerDepartment[0])+1;
                        } else {
                            $countContainer = 0;
                        }

                        array_push(
                            $listCountContainer,
                            array(
                                'container' => $nameContainer,
                                'num' => $countContainer
                            )
                        );
                    }
                }
            }
        }

        $listCountContainernew = array();
        foreach ($listCountContainer as $key => $value) {
            $nameContainer = $value['container'];
            $numContainer = 0;
            foreach ($listCountContainer as $key2 => $value2) {
                if($nameContainer == $value2['container']) {
                    $numContainer = (float)$numContainer + (float)$value2['num'];
                }
            }
            array_push(
                $listCountContainernew,
                array(
                    'container' => $nameContainer,
                    'num' => ($numContainer > 0) ? $numContainer : ""
                )
            );
        }

        $listCountContainernew = array_map("unserialize", array_unique(array_map("serialize", $listCountContainernew)));
        $listCountContainernew = array_values($listCountContainernew);

        return $listCountContainernew;
    }

    /**
    * Function: add_shipment_post
    * @access public
    */
    public function add_shipment_post(){ 

        $user_name = $this->LOGIN_INFO[U_ID];

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $data_meta = $this->input->post('data_meta');
            $data_detail = $this->input->post('data_detail');
            $status = $this->input->post('data_status');

            try{
                if($data_meta != null && $data_meta != '') {
                    $this->shipment_model->db->trans_begin(); 
                    // Meta
                    $shipment_meta[OS_DELIVERY_CLASSIFICATION] = $data_meta['OS_DELIVERY_CLASSIFICATION']; // chuyen phat nhanh
                    $shipment_meta[OS_ORDER_DATE] = date("Y/m/d"); // ngay tao order
                    $shipment_meta[OS_DELIVERY_DATE] = $data_meta['OS_DELIVERY_DATE']; // ngay du dinh giao hang
                    $shipment_meta[OS_STATUS] = $status; // trang thai
                    $shipment_meta[OS_ORDERER] = $user_name; // người tạo order
                    $shipment_meta[OS_NOTE] = $data_meta['OS_NOTE']; // ghi chú
                    $shipment_meta[OS_SHIPMENT_DECISION_DATETIME] = $data_meta['OS_SHIPMENT_DECISION_DATETIME']; // ngày yêu cầu hóa đơn
                    $shipment_meta[OS_TOTAL_NUMBER_CONTAINERS] = $data_meta['OS_TOTAL_NUMBER_CONTAINERS']; // total
                    $shipment_meta[OS_GROSS_WEIGHT] = $data_meta['OS_GROSS_WEIGHT']; // trọng lượng order
                    $shipment_meta[OS_NUMBER_TRUCKS] = $data_meta['OS_NUMBER_TRUCKS']; // số truck
                    $shipment_meta[OS_NUMBER_TRAIN] = $data_meta['OS_NUMBER_TRAIN']; // số xe

                    $order_id = $this->shipment_model->add($shipment_meta);

                    // Detail
                    if($data_detail != null && $data_detail != '') {
                        foreach ($data_detail as $key => $value) {
                           if((int)$value['quantity'] > 0 && (int)$value['container1'] > 0) {
                                $shipment_detail[OSHD_ORDER_ID] = $order_id; // id order
                                $shipment_detail[OSHD_CUSTOMER_ID] = $value['customer']; // customer
                                $shipment_detail[OSHD_DEPARTMENT_ID] = $value['department']; // phong ban
                                $shipment_detail[OSHD_PRODUCT_CODE] = $value['product_id']; // product
                                $shipment_detail[OSHD_QUANTITY] = $value['quantity']; // số lượng
                                $shipment_detail[OSHD_CONTAINER1] = $value['container1'];
                                $shipment_detail[OSHD_CONTAINER2] = $value['container2'];
                                $shipment_detail[OSHD_COMMENT] = $value['comment'];

                                $this->shipment_detail_model->add($shipment_detail);
                            }
                        }
                    }

                    // End Query
                    if ($this->shipment_model->db->trans_status() === FALSE)
                    {
                        $this->shipment_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_add_error")
                        ));
                        return;
                    }
                    else
                    {
                        $this->shipment_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_add_success")
                        ));
                        return;
                    }
                }

            }catch(Exception $ex){
                $this->shipment_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
        }
    }

    /**
    * Function: detail_order
    * @access public
    */
    public function detail_order()
	{
        $csv = $this->input->get('csv');
        $id = (int)$this->input->get('id');
        $data['order_id'] = $id;
        $data[$this->varTitle]=$this->lang->line('detail_shipment');
        $data['master'] = $this->shipment_model->getMasterById($id);
        $data['detail'] = $this->shipment_detail_model->getDetailByOrder($id);
        $data['listCountContainer'] = $this->getListCountContainer($data['detail']);

        if($csv !== 'true') {
            $data['content']='shipments/detail_order';
            $this->load->view('templates/master',$data);
        } else {
            // Export csv
            $TotalContainer = $this->input->get('TotalContainer');
            $Weight = $this->input->get('Weight');
            $truck = $this->input->get('truck');
            $Nonsense = $this->input->get('Nonsense');
			$detail = $data['detail'];
            $data_export = array();
            array_push(
				$data_export,
				array(mb_convert_encoding($data[$this->varTitle], "UTF-8"))
            );
            array_push(
                $data_export,
                array("")
            );
            array_push(
                $data_export,
                array("")
            );
            if(isset($data['master']) && $data['master'] != null) {
                array_push(
                    $data_export,
                    array(mb_convert_encoding("出荷票No:", "UTF-8"),mb_convert_encoding($data['master'][OS_ID], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("起票者:", "UTF-8"),mb_convert_encoding($data['master'][OS_ORDERER], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("出荷依頼日:", "UTF-8"),mb_convert_encoding($data['master'][OS_ORDER_DATE], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("納品予定日:", "UTF-8"),mb_convert_encoding($data['master'][OS_DELIVERY_DATE], "UTF-8"),mb_convert_encoding($data['master']['delivery_classifition'], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("備考:", "UTF-8"),mb_convert_encoding($data['master'][OS_NOTE], "UTF-8"))
                );
                $OS_STATUS = "";
                if($data['master'][OS_STATUS] != '') {
                    if((int)$data['master'][OS_STATUS] == 1) {
                        $OS_STATUS = '一時保存';
                    }
                    else if((int)$data['master'][OS_STATUS] == 2) {
                        $OS_STATUS = '出荷未確定';
                    }
                    else if((int)$data['master'][OS_STATUS] == 3) {
                        $OS_STATUS = '再依頼';
                    }
                    else if((int)$data['master'][OS_STATUS] == 4) {
                        $OS_STATUS = '出荷確定(不足)';
                    }
                    else if((int)$data['master'][OS_STATUS] == 5) {
                        $OS_STATUS = '出荷確定';
                    }
                }

                array_push(
                    $data_export,
                    array(mb_convert_encoding("形態:", "UTF-8"),mb_convert_encoding($OS_STATUS, "UTF-8"))
                );

                array_push(
                    $data_export,
                    array("")
                );

                array_push(
                    $data_export,
                    array(
                        mb_convert_encoding("得意先", "UTF-8"),
                        mb_convert_encoding("部署", "UTF-8"),
                        mb_convert_encoding("商品コード", "UTF-8"),
                        mb_convert_encoding("商品名", "UTF-8"),
                        mb_convert_encoding("規格", "UTF-8"),
                        mb_convert_encoding("カラー", "UTF-8"),
                        mb_convert_encoding("発注数", "UTF-8"),
                        mb_convert_encoding("変更数", "UTF-8"),
                        mb_convert_encoding("出荷数", "UTF-8"),
                        mb_convert_encoding("コンテナ", "UTF-8"),
                        mb_convert_encoding("コンテナ", "UTF-8"),
                        mb_convert_encoding("コメント", "UTF-8"),
                    )
                );

                if($data['detail'] != null && $data['detail'] != '') {
                    foreach ($data['detail'] as $key => $value) {
                        array_push(
                            $data_export,
                            array(
                                mb_convert_encoding($value['customer_name'], "UTF-8"),
                                mb_convert_encoding($value['department_name'], "UTF-8"),
                                mb_convert_encoding($value['product_code'], "UTF-8"),
                                mb_convert_encoding($value['product_name'], "UTF-8"),
                                mb_convert_encoding($value['product_format'], "UTF-8"),
                                mb_convert_encoding($value['product_color'], "UTF-8"),
                                mb_convert_encoding($value[OSHD_QUANTITY], "UTF-8"),
                                mb_convert_encoding($value[OSHD_QUANTITY_CHANGE], "UTF-8"),
                                mb_convert_encoding($value[OSHD_DELIVERY], "UTF-8"),
                                mb_convert_encoding($value[OSHD_CONTAINER1], "UTF-8"),
                                mb_convert_encoding($value[OSHD_CONTAINER2], "UTF-8"),
                                mb_convert_encoding($value[OSHD_COMMENT], "UTF-8"),
                            )
                        );
                    }
                }

                array_push(
                    $data_export,
                    array("")
                );
                if($data['listCountContainer'] != null && $data['listCountContainer'] != "") {
                    foreach ($data['listCountContainer'] as $key => $value) {
                        if($key == 0) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("合計", "UTF-8"),
                                    mb_convert_encoding($TotalContainer, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else if($key == 1) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("重量", "UTF-8"),
                                    mb_convert_encoding($Weight, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else if($key == 2) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else if($key == 3) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else {
                            array_push(
                                $data_export,
                                array(
                                    "",
                                    "",
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        }
                    }

                    if(count($data['listCountContainer']) < 4) {
                        if(count($data['listCountContainer']) == 0) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("合計", "UTF-8"),
                                    mb_convert_encoding($TotalContainer, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("重量", "UTF-8"),
                                    mb_convert_encoding($Weight, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        } else if(count($data['listCountContainer']) == 1) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("重量", "UTF-8"),
                                    mb_convert_encoding($Weight, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        } else if(count($data['listCountContainer']) == 2) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        } else if(count($data['listCountContainer']) == 3) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        }
                    }
                }
            }
            
            $this->ImportExportCsv->download_send_header_csv($data[$this->varTitle]);
			echo $this->ImportExportCsv->array_to_csv($data_export);
        }
	}

    /**
    * Function: detail_shipment_2
    * @access public
    */
    public function detail_order_confirm() 
    {
        $id = $this->input->get('id');
        $data['order_id'] = $id;
        $data[$this->varTitle]=$this->lang->line('shipment_export');
        $data['master'] = $this->shipment_model->getMasterById($id);

        // NẾU NULL
        if($data['master'] == NULL){
            redirect( base_url('shipment'), 'refresh');
            exit();
        }
        if($data['master'][OS_STATUS] == 1 || $data['master'][OS_STATUS] == "1") {
            redirect( base_url('shipment'), 'refresh');
            exit();
        }

        $data['detail'] = $this->shipment_detail_model->getDetailByOrder($id);
        $data['listCountContainer'] = $this->getListCountContainer($data['detail']);
        $data['content']='shipments/detail_order_confirm';
        $this->load->view('templates/master',$data);
    }

    /**
    * Function: export_post
    * @access public
    */
    public function detail_order_confirm_post(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $user_name = $this->LOGIN_INFO[U_ID];

            $id_order = $this->input->post('id_order');
            $data_meta = $this->input->post('data_meta');
            $data_detail = $this->input->post('data_detail');
            $data_status = $this->input->post('data_status');

            try{
                $this->shipment_model->db->trans_begin(); 
                $this->shipment_detail_model->db->trans_begin(); 

                // kiểm tra dữ liệu đã update chưa
                if(!$this->shipment_model->isCheckDataUpdated($id_order,$data_meta['OS_UPDATE_DATE'])) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_error_data_updated")
                    ));
                    return;
                }

                // Delete shipment detail
                $whereClause = array(
                    OSHD_ORDER_ID => $id_order
                );
                $this->shipment_detail_model->removeByWhere($whereClause);

                // Query
                $quantity_delivery_all = 0;
                foreach ($data_detail as $key => $value) {
                    $shipment_detail[OSHD_ORDER_ID] = $id_order; // id order
                    $shipment_detail[OSHD_CUSTOMER_ID] = $value['customer']; // customer
                    $shipment_detail[OSHD_DEPARTMENT_ID] = $value['department']; // phong ban
                    $shipment_detail[OSHD_PRODUCT_CODE] = $value['product_id']; // product
                    $shipment_detail[OSHD_QUANTITY] = $value['quantity']; // số lượng
                    $shipment_detail[OSHD_QUANTITY_CHANGE] = $value['quantity_change'];
                    $shipment_detail[OSHD_DELIVERY] = $value['quantity_delivery'];
                    $shipment_detail[OSHD_CONTAINER1] = $value['container1'];
                    $shipment_detail[OSHD_CONTAINER2] = $value['container2'];
                    $shipment_detail[OSHD_COMMENT] = $value['comment'];

                    if($value['quantity'] != '') {
                        $quantity_change = 0;
                        $quantity_delivery = 0;
                        if($value['quantity_change'] != '') { $quantity_change=$value['quantity_change'];}
                        if($value['quantity_delivery'] != '') { $quantity_delivery=$value['quantity_delivery'];}

                        $compareQuantity = (int)$quantity_delivery - ((int)$value['quantity'] + (int)$quantity_change);
                        if($compareQuantity < 0) {
                            $data_status = '4';
                        }
                    }

                    // Validation quantity
                    if($value['quantity_delivery'] != '') {
                        $quantity_order = (float)$value['quantity'] + (float)$value['quantity_change'];
                        $quantity_delivery = (float)$value['quantity_delivery'];
                        $quantity_delivery_all += $quantity_delivery;
                        if($quantity_delivery > $quantity_order) {
                            $this->shipment_model->db->trans_rollback();
                            $this->shipment_detail_model->db->trans_rollback();
                            echo json_encode(array(
                                "success" => false,
                                "message" => $this->lang->line("message_incorrect_quantity_shipment")
                            ));
                            return;
                        }
                    }

                    $this->shipment_detail_model->add($shipment_detail);
                }

                if($quantity_delivery_all == 0 || $quantity_delivery_all == "0") {
                    $this->shipment_model->db->trans_rollback();
                    $this->shipment_detail_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_check_isNull_quantity_error")
                    ));
                    return;
                }

                // Meta
                if($data_meta != null && $data_meta != '') {
                    $shipment_meta[OS_ORDER_CONFIRMATION_DATETIME] = date("Y/m/d"); // ngay xac nhan hoa don
                    $shipment_meta[OS_TOTAL_NUMBER_CONTAINERS] = $data_meta['OS_TOTAL_NUMBER_CONTAINERS']; // total
                    $shipment_meta[OS_GROSS_WEIGHT_SHIPPING] = $data_meta['OS_GROSS_WEIGHT']; // trọng lượng order
                    $shipment_meta[OS_NUMBER_TRUCKS] = $data_meta['OS_NUMBER_TRUCKS']; // số truck
                    $shipment_meta[OS_NUMBER_TRAIN] = $data_meta['OS_NUMBER_TRAIN']; // số xe
                    $shipment_meta[OS_SHIPPER] = $user_name; // status
                    $shipment_meta[OS_STATUS] = $data_status; // status
                    $shipment_meta[OS_ORDER_CONFIRMATION] = 1;
                    $shipment_meta[OS_FINAL_DELIVERY] = 1;

                    $this->shipment_model->edit($id_order, $shipment_meta);
                }

                // End Query
                if ($this->shipment_model->db->trans_status() === FALSE || $this->shipment_detail_model->db->trans_status() === FALSE)
                {
                    $this->shipment_model->db->trans_rollback();
                    $this->shipment_detail_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
                else
                {
                    $this->shipment_model->db->trans_commit();
                    $this->shipment_detail_model->db->trans_commit();
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
                    return;
                }
            } 
            catch(Exception $ex){
                $this->shipment_model->db->trans_rollback();
                $this->shipment_detail_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_edit_error")
                ));
                return;
            }
        }
    }

    /**
    * Function: detail_shipment
    * @access public
    */
	public function detail_shipment()
	{ 
        $csv = $this->input->get('csv');

        $data['role_manager'] = $this->checkIsGroupRole(GR_SYSTEM_ADMINISTRATOR);
        $data['role_order'] = $this->checkIsGroupRole(GR_TOKYO_OTHER_ORDERING_PERSON);
        $data['role_shipment'] = $this->checkIsGroupRole(GR_ATSUGI_FACTORY_PERSONNEL);
        $id = (int)$this->input->get('id');
        $print = (boolean)$this->input->get('print');
        $data['order_id'] = $id;
        $data[$this->varTitle]=$this->lang->line('detail_shipment_2');
        $data['master'] = $this->shipment_model->getMasterById($id);

        // NẾU NULL
        if($data['master'] == NULL){
            redirect( base_url('shipment'), 'refresh');
            exit();
        }

        $data['detail'] = $this->shipment_detail_model->getDetailByOrder($id);
        $data['listCountContainer'] = $this->getListCountContainer($data['detail']);

        if($csv !== 'true') {
            $data['content']='shipments/detail_shipment';
            if($print == true) {
            
                $this->load->library('mpdf');
                $pdf = new mPDF('utf8','A3-L','','',15,15,25,16,9,9);
                $pdf->SetTitle($data[$this->varTitle]);

                // write the HTML into the PDF
                $html = $this->load->view('templates/shipments/detail_shipment',$data,true);
                $stylesheet = file_get_contents('asset/css/style.css');
                $pdf->WriteHTML($stylesheet, 1);
                
                $html = str_replace('　', '&nbsp;', $html);
                $html = str_replace('href=', 'title=', $html);
                $html = str_replace("出荷伝票 編集画面へ","",$html);
                $html = str_replace("削除","",$html);
                $html = str_replace("MENU画面へ","",$html);
                $html = str_replace("印刷","",$html);
                $html = str_replace("CSV出力","",$html);

                $pdf->WriteHTML($html, 2);
                $output = $data[$this->varTitle].'.pdf';
                $pdf->SetJS('this.print();');
                $pdf->Output("$output", 'I');
            }
            else {
                $this->load->view('templates/master',$data);
            }
        } else {
            // Export csv
            $TotalContainer = $this->input->get('TotalContainer');
            $Weight = $this->input->get('Weight');
            $truck = $this->input->get('truck');
            $Nonsense = $this->input->get('Nonsense');
			$detail = $data['detail'];
            $data_export = array();
            array_push(
				$data_export,
				array(mb_convert_encoding($data[$this->varTitle], "UTF-8"))
            );
            array_push(
                $data_export,
                array("")
            );
            array_push(
                $data_export,
                array("")
            );
            if(isset($data['master']) && $data['master'] != null) {
                array_push(
                    $data_export,
                    array(mb_convert_encoding("出荷票No:", "UTF-8"),mb_convert_encoding($data['master'][OS_ID], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("起票者:", "UTF-8"),mb_convert_encoding($data['master'][OS_ORDERER], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("納品予定日:", "UTF-8"),mb_convert_encoding($data['master'][OS_DELIVERY_DATE], "UTF-8"),mb_convert_encoding($data['master']['delivery_classifition'], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("備考:", "UTF-8"),mb_convert_encoding($data['master'][OS_NOTE], "UTF-8"))
                );
                $OS_STATUS = "";
                if($data['master'][OS_STATUS] != '') {
                    if((int)$data['master'][OS_STATUS] == 1) {
                        $OS_STATUS = '一時保存';
                    }
                    else if((int)$data['master'][OS_STATUS] == 2) {
                        $OS_STATUS = '出荷未確定';
                    }
                    else if((int)$data['master'][OS_STATUS] == 3) {
                        $OS_STATUS = '再依頼';
                    }
                    else if((int)$data['master'][OS_STATUS] == 4) {
                        $OS_STATUS = '出荷確定(不足)';
                    }
                    else if((int)$data['master'][OS_STATUS] == 5) {
                        $OS_STATUS = '出荷確定';
                    }
                }

                array_push(
                    $data_export,
                    array(mb_convert_encoding("形態:", "UTF-8"),mb_convert_encoding($OS_STATUS, "UTF-8"))
                );

                array_push(
                    $data_export,
                    array("")
                );

                array_push(
                    $data_export,
                    array(
                        mb_convert_encoding("得意先", "UTF-8"),
                        mb_convert_encoding("部署", "UTF-8"),
                        mb_convert_encoding("商品コード", "UTF-8"),
                        mb_convert_encoding("商品名", "UTF-8"),
                        mb_convert_encoding("規格", "UTF-8"),
                        mb_convert_encoding("カラー", "UTF-8"),
                        mb_convert_encoding("発注数", "UTF-8"),
                        mb_convert_encoding("変更数", "UTF-8"),
                        mb_convert_encoding("出荷数", "UTF-8"),
                        mb_convert_encoding("コンテナ", "UTF-8"),
                        mb_convert_encoding("コンテナ", "UTF-8"),
                        mb_convert_encoding("コメント", "UTF-8"),
                    )
                );

                if($data['detail'] != null && $data['detail'] != '') {
                    foreach ($data['detail'] as $key => $value) {
                        array_push(
                            $data_export,
                            array(
                                mb_convert_encoding($value['customer_name'], "UTF-8"),
                                mb_convert_encoding($value['department_name'], "UTF-8"),
                                mb_convert_encoding($value['product_code'], "UTF-8"),
                                mb_convert_encoding($value['product_name'], "UTF-8"),
                                mb_convert_encoding($value['product_format'], "UTF-8"),
                                mb_convert_encoding($value['product_color'], "UTF-8"),
                                mb_convert_encoding($value[OSHD_QUANTITY], "UTF-8"),
                                mb_convert_encoding($value[OSHD_QUANTITY_CHANGE], "UTF-8"),
                                mb_convert_encoding($value[OSHD_DELIVERY], "UTF-8"),
                                mb_convert_encoding($value[OSHD_CONTAINER1], "UTF-8"),
                                mb_convert_encoding($value[OSHD_CONTAINER2], "UTF-8"),
                                mb_convert_encoding($value[OSHD_COMMENT], "UTF-8"),
                            )
                        );
                    }
                }

                array_push(
                    $data_export,
                    array("")
                );
                if($data['listCountContainer'] != null && $data['listCountContainer'] != "") {
                    foreach ($data['listCountContainer'] as $key => $value) {
                        if($key == 0) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("合計", "UTF-8"),
                                    mb_convert_encoding($TotalContainer, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else if($key == 1) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("重量", "UTF-8"),
                                    mb_convert_encoding($Weight, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else if($key == 2) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else if($key == 3) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        } else {
                            array_push(
                                $data_export,
                                array(
                                    "",
                                    "",
                                    "",
                                    "",
                                    mb_convert_encoding($value['container'], "UTF-8"),
                                    mb_convert_encoding($value['num'], "UTF-8"),
                                )
                            );
                        }
                    }

                    if(count($data['listCountContainer']) < 4) {
                        if(count($data['listCountContainer']) == 0) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("合計", "UTF-8"),
                                    mb_convert_encoding($TotalContainer, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("重量", "UTF-8"),
                                    mb_convert_encoding($Weight, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        } else if(count($data['listCountContainer']) == 1) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("重量", "UTF-8"),
                                    mb_convert_encoding($Weight, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        } else if(count($data['listCountContainer']) == 2) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("トラック", "UTF-8"),
                                    mb_convert_encoding($truck, "UTF-8"),
                                )
                            );
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        } else if(count($data['listCountContainer']) == 3) {
                            array_push(
                                $data_export,
                                array(
                                    mb_convert_encoding("臨車", "UTF-8"),
                                    mb_convert_encoding($Nonsense, "UTF-8"),
                                )
                            );
                        }
                    }
                }
            }
            
            $this->ImportExportCsv->download_send_header_csv($data[$this->varTitle]);
			echo $this->ImportExportCsv->array_to_csv($data_export);
        }
	}

    /**
    * Function: delete_order
    * @access public
    */
    public function delete_shipment(){
        if( $this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id_order');
            $result = $this->shipment_model->remove($id);

            $message = $this->lang->line("message_remove_success");
            if($result == true){
                $message = $this->lang->line("message_remove_error");
            }
            echo json_encode(array("success" => $result,"message" => $message));
        }
    }

    /**
    * Function: edit_shipment
    * @access public
    */
    public function edit_shipment()
	{
        $data[$this->varTitle]=$this->lang->line('edit_shipment');
        $id = $this->input->get('id');
        $data['order_id'] = $id;
        $data['list_classification'] = $this->shipment_classification_model->getClassificationByBase($this->LOGIN_INFO[U_BASE_CODE]);
        //$data['list_product'] = $this->product_model->getAll(0,20);
        $data['product_default'] = $this->product_model->getProductSelectBox(null,null,2,false,0,1,PL_PRODUCT_ID,"DESC");
        $data['master'] = $this->shipment_model->getMasterById($id);

        // NẾU NULL
        if($data['master'] == NULL){
            redirect( base_url('shipment'), 'refresh');
            exit();
        }
        
        $data['detail'] = $this->shipment_detail_model->getDetailByOrder($id);

        $data['listCountContainer'] = $this->getListCountContainer($data['detail']);
        if($data['master'] != "") {
            $data['list_customer'] = $this->shipment_classification_model->getCustomerByClassification($data['master'][OS_DELIVERY_CLASSIFICATION], true, ''); 
        }
        $data['content']='shipments/edit_shipment';
        $this->load->view('templates/master',$data);
	}

    /**
    * Function: edit_shipment_post
    * @access public
    */
    public function edit_shipment_post()
    {
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id_order = $this->input->post('order_id');
            $data_meta = $this->input->post('data_meta');
            $data_detail = $this->input->post('data_detail');

            // Check nếu đã xác định xuất hàng
            if($data_meta['OS_STATUS'] == 4 || $data_meta['OS_STATUS'] == "4") {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_check_confirmed_shipment")
                ));
                return;
            }
            if($data_meta['OS_STATUS'] == 5 || $data_meta['OS_STATUS'] == "5") {
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_check_confirmed_shipment")
                ));
                return;
            }

            try{
                if($data_meta != null && $data_meta != '') {
                    $this->shipment_model->db->trans_begin();
                    $this->shipment_detail_model->db->trans_begin();

                    // kiểm tra dữ liệu đã update chưa
                    if(!$this->shipment_model->isCheckDataUpdated($id_order,$data_meta['OS_UPDATE_DATE'])) {
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_error_data_updated")
                        ));
                        return;
                    }

                    // Delete shipment detail
                    $whereClause = array(
                        OSHD_ORDER_ID => $id_order
                    );
                    $this->shipment_detail_model->removeByWhere($whereClause);

                    // Query
                    foreach ($data_detail as $key => $value) {
                        $shipment_detail[OSHD_ORDER_ID] = $id_order; // id order
                        $shipment_detail[OSHD_CUSTOMER_ID] = $value['customer']; // customer
                        $shipment_detail[OSHD_DEPARTMENT_ID] = $value['department']; // phong ban
                        $shipment_detail[OSHD_PRODUCT_CODE] = $value['product_id']; // product
                        $shipment_detail[OSHD_QUANTITY] = $value['quantity']; // số lượng
                        $shipment_detail[OSHD_QUANTITY_CHANGE] = $value['quantity_change'];
                        $shipment_detail[OSHD_DELIVERY] = $value['quantity_delivery'];
                        $shipment_detail[OSHD_CONTAINER1] = $value['container1'];
                        $shipment_detail[OSHD_CONTAINER2] = $value['container2'];
                        $shipment_detail[OSHD_COMMENT] = $value['comment'];

                        $this->shipment_detail_model->add($shipment_detail);
                    }

                    // Meta
                    $shipment_meta[OS_SHIPMENT_DECISION_DATETIME] = $data_meta['OS_SHIPMENT_DECISION_DATETIME'];
                    $shipment_meta[OS_DELIVERY_DATE] = $data_meta['OS_DELIVERY_DATE'];
                    $shipment_meta[OS_DELIVERY_CLASSIFICATION] = $data_meta['OS_DELIVERY_CLASSIFICATION'];
                    $shipment_meta[OS_NOTE] = $data_meta['OS_NOTE'];
                    $shipment_meta[OS_TOTAL_NUMBER_CONTAINERS] = $data_meta['OS_TOTAL_NUMBER_CONTAINERS']; // total
                    $shipment_meta[OS_GROSS_WEIGHT] = $data_meta['OS_GROSS_WEIGHT']; // trọng lượng order
                    $shipment_meta[OS_NUMBER_TRUCKS] = $data_meta['OS_NUMBER_TRUCKS']; // số truck
                    $shipment_meta[OS_NUMBER_TRAIN] = $data_meta['OS_NUMBER_TRAIN']; // số xe

                    // Check trạng thái
                    $get_status_confirm = $this->shipment_model->getFieldShipment(OS_STATUS,$id_order);

                    if($get_status_confirm != '' && $get_status_confirm != null) {
                        if((int)$get_status_confirm == 4 || (int)$get_status_confirm == 5) {
                            $shipment_meta[OS_STATUS] = 3; // status

                            $get_number_request = $this->shipment_model->getFieldShipment(OS_NUMBER_REQUEST,$id_order);
                            if($get_number_request != '' && $get_number_request != null) {
                                $shipment_meta[OS_NUMBER_REQUEST] = (int)$get_number_request + 1;
                            }
                        } else if((int)$get_status_confirm == 1) {
                            // Nếu lưu tạm thì chưa xác định xuất hàng [出荷未確定]
                            $shipment_meta[OS_STATUS] = 2; // status
                        }
                    }

                    $this->shipment_model->edit($id_order, $shipment_meta);

                    // End Query
                    if ($this->shipment_model->db->trans_status() === FALSE || $this->shipment_detail_model->db->trans_status() === FALSE)
                    {
                        $this->shipment_model->db->trans_rollback();
                        $this->shipment_detail_model->db->trans_rollback();
                        echo json_encode(array(
                            "success" => false,
                            "message" => $this->lang->line("message_edit_error")
                        ));
                        return;
                    }
                    else
                    {
                        $this->shipment_model->db->trans_commit();
                        $this->shipment_detail_model->db->trans_commit();
                        echo json_encode(array(
                            "success" => true,
                            "message" => $this->lang->line("message_edit_success")
                        ));
                        return;
                    }

                }
            }
            catch(Exception $ex){
                $this->shipment_model->db->trans_rollback();
                $this->shipment_detail_model->db->trans_rollback();
                echo json_encode(array(
                    "success" => false,
                    "message" => $this->lang->line("message_add_error")
                ));
                return;
            }
        }
    }

    /**
    * Function: edit_shipment_post
    * @access public
    */
    public function getListDetailOrder($detail){
        $arrCustomer = array();
        $arrDepartment = array();
        $arrDetailOrder = array();

        foreach ($detail as $key => $value) {
            array_push($arrCustomer,
                array(
                    "name" => $value['customer_name'],
                    "id" => $value[OSHD_CUSTOMER_ID],
                )
            );
            array_push($arrDepartment,
                array(
                    "department"=>$value['department_name'],
                    "id_department"=>$value[OSHD_DEPARTMENT_ID],
                    "id_customer"=>$value[OSHD_CUSTOMER_ID]
                )
            );
        }

        $arrCustomer = array_map("unserialize", array_unique(array_map("serialize", $arrCustomer)));
        $arrDepartment = array_map("unserialize", array_unique(array_map("serialize", $arrDepartment)));

        // Customer
        foreach ($arrCustomer as $key => $value) {
            $idCustomer = $value['id'];
            $nameCustomer = $value['name'];
            $arrDepartmentOrder = array();
            $rowCustomer = 0;
            $numberDelivery = 0;
            $totalDelivery = 0;
            foreach ($arrDepartment as $keyDepartment => $valueDepartment) {
                if($idCustomer == $valueDepartment['id_customer']) {
                    $arrDetail = array();
                    $rowDepartment = 0;
                    foreach ($detail as $keyShipment => $valueShipment) {
                        if($valueDepartment['id_customer'] == $valueShipment[OSHD_CUSTOMER_ID] && $valueDepartment['id_department'] == $valueShipment[OSHD_DEPARTMENT_ID]) {
                            array_push($arrDetail,
                                array(
                                    "product_name"=>$valueShipment['product_name'],
                                    "product_format"=>$valueShipment['product_format'],
                                    "product_color"=>$valueShipment['product_color'],
                                    "product_weight"=>$valueShipment['product_weight'],
                                    "quantity_order"=>$valueShipment[OSHD_QUANTITY],
                                    "quantity_change"=>$valueShipment[OSHD_QUANTITY_CHANGE],
                                    "quantity_delivery"=>$valueShipment[OSHD_DELIVERY],
                                    "container1"=>$valueShipment[OSHD_CONTAINER1],
                                    "container2"=>$valueShipment[OSHD_CONTAINER2],
                                    "comment"=>$valueShipment[OSHD_COMMENT],
                                    "total"=>$valueShipment[OSHD_DELIVERY] * $valueShipment['product_weight']
                                )
                            );
                            $numberDelivery = $numberDelivery + $valueShipment[OSHD_DELIVERY];
                            $totalDelivery = $totalDelivery + ($valueShipment[OSHD_DELIVERY] * $valueShipment['product_weight']);
                            $rowCustomer++;
                            $rowDepartment++;
                        }
                    }
                    array_push($arrDepartmentOrder,
                        array(
                            "department"=>$valueDepartment['department'],
                            "row"=>$rowDepartment,
                            "detail"=>$arrDetail
                        )
                    );
                } 
            }

            array_push($arrDetailOrder,
                array(
                    "number_delivery"=>$numberDelivery,
                    "total"=>$totalDelivery,
                    "customer"=>$nameCustomer,
                    "row"=>$rowCustomer,
                    "detail"=>$arrDepartmentOrder
                )
            );
        }

        return $arrDetailOrder;
    }

    /**
    * Function: report_function
    * @access public
    */
    public function report_function($id, $title){
        $data = [];
        $data[$this->varTitle]=$title;
        $data['master'] = $this->shipment_model->getMasterById($id);
        $data['detail'] = $this->shipment_detail_model->getDetailByOrder($id);

        $data['OS_ORDER_DATE'] = $this->helper->readDateTimeReport($data['master'][OS_ORDER_DATE]);
        $data['OS_DELIVERY_DATE'] = $this->helper->readDateTimeReport($data['master'][OS_DELIVERY_DATE]);

        $data['listCountContainer'] = $this->getListCountContainer($data['detail']);
        $data['listDetail'] = $this->getListDetailOrder($data['detail']);

        return $data;
    }

    /**
    * Function: edit_shipment_post
    * @access public
    */
    public function report_bill_shipment()
    {
        $this->load->library('mpdf');
        $pdf = new mPDF('utf8','A4-L','','',15,15,25,16,9,9);

        //$title=$this->lang->line('report_bill_shipment');
        $title = $this->input->get('title');
        $pdf->SetTitle($title);
        $id = (int)$this->input->get('id');
        $data = $this->report_function($id, $title);
        $htmlHeader= $this->load->view('templates/shipments/report/report_header', $data, true);
        $pdf->SetHTMLHeader($htmlHeader);

        $html= $this->load->view('templates/shipments/report/bill_shipment', $data, true);

        // write the HTML into the PDF
        $pdf->WriteHTML($html);
        $output = $title.'.pdf';
        $pdf->SetJS('this.print();');
        $pdf->Output("$output", 'I');
    }

    /**
    * Function: report_status_shipment
    * @access public
    */
    public function report_status_shipment()
    {
        $this->load->library('mpdf');
        $pdf = new mPDF('utf8','A4-L','','',15,15,25,16,9,9);

        $id = (int)$this->input->get('id');
        $title=$this->lang->line('report_status_shipment');
        $pdf->SetTitle($title);
        $data = $this->report_function($id, $title);
        $htmlHeader= $this->load->view('templates/shipments/report/report_header', $data, true);
        $pdf->SetHTMLHeader($htmlHeader);
        $html= $this->load->view('templates/shipments/report/bill_shipment', $data, true);

        // write the HTML into the PDF
        $pdf->WriteHTML($html);
        $output = $title.'.pdf';
        $pdf->Output("$output", 'I');
    }

    /**
    * Function: report_status_shipment_customer
    * @access public
    */
    public function report_status_shipment_customer() {
        $this->load->library('mpdf');
        $pdf = new mPDF('utf8','A4-L','','',15,15,25,16,9,9); 

        $id = (int)$this->input->get('id');
        $title=$this->lang->line('report_status_shipment_customer');
        $pdf->SetTitle($title);
        $data = $this->report_function($id, $title);
        $htmlHeader= $this->load->view('templates/shipments/report/report_header', $data, true);
        $pdf->SetHTMLHeader($htmlHeader);
        $html= $this->load->view('templates/shipments/report/report_status_shipment_customer', $data, true);

        // write the HTML into the PDF
        $pdf->WriteHTML($html);
        $output = $title.'.pdf';
        $pdf->Output("$output", 'I'); 
    }

    /**
    * Function: get_page_set_container
    * @access public
    */
    public function get_page_set_container($detail, $arrSet) {
        $listSetContainer = array();
        $arrCustomer = array();
        
        // Array set
        $arrSetContainer = array();
        if($arrSet != null) {
            foreach ($arrSet as $key => $value) {
                $arrValue = explode("-", $value);
                if(count($arrValue) > 1) {
                    for ($i=$arrValue[0]; $i <= $arrValue[1]; $i++) { 
                        array_push($arrSetContainer,"$i");
                    }
                } else {
                    array_push($arrSetContainer,$value);
                }
            }
        }

        // Detail
        if($detail != null) {
            // Get Container
            $arrContainer = array();
            $listContainer = array();

            foreach ($detail as $key => $value) {

                // Detail Container
                $countProductInContainer = ($value[OSHD_CONTAINER2] - $value[OSHD_CONTAINER1]) + 1;
                $numberContainerStart = (int)$value[OSHD_CONTAINER1];
                for ($i=0; $i < $countProductInContainer; $i++) { 
                    if($value[OSHD_CONTAINER1] <= $numberContainerStart && $numberContainerStart <= $value[OSHD_CONTAINER2]) {
                        if(($arrSetContainer != null && in_array($numberContainerStart, $arrSetContainer)) || $arrSetContainer == null) {
                            array_push($arrContainer,
                                array(
                                    "id" => $value[OSHD_ID],
                                    "container" => $numberContainerStart,
                                    "customer_id" => $value[OSHD_CUSTOMER_ID],
                                    "customer_name" => $value['customer_name'],
                                    "department_name" => $value['department_name'],
                                    "product_name"=>$value['product_name'],
                                    "product_format"=>$value['product_format'],
                                    "product_color"=>$value['product_color'],
                                    "product_weight"=>$value['product_weight'],
                                    "quantity_order"=>$value[OSHD_QUANTITY],
                                    "quantity_change"=>$value[OSHD_QUANTITY_CHANGE],
                                    "quantity_delivery"=>$value[OSHD_DELIVERY],
                                    "comment"=>$value[OSHD_COMMENT],
                                    "total"=>$value[OSHD_DELIVERY] * $valueShipment['product_weight']
                                )
                            );
                            array_push($listContainer,$numberContainerStart);
                        }
                    }
                    $numberContainerStart++;
                }
                
            }

            $arrContainer = array_map("unserialize", array_unique(array_map("serialize", $arrContainer)));
            $listContainer = array_map("unserialize", array_unique(array_map("serialize", $listContainer)));
            $listContainer = array_values($listContainer);
            $arrCustomer = array_map("unserialize", array_unique(array_map("serialize", $arrCustomer)));
            sort($listContainer);

            // Set Array
            if($listContainer != null) {
                foreach ($listContainer as $key => $value) {
                    $listCustomerByContainer = array();
                    if($arrContainer != null) {
                        foreach ($arrContainer as $key2 => $value2) {
                            if($value == $value2['container']) {
                                $listProductByCustomer = array();
                                foreach ($arrContainer as $key3 => $value3) {
                                    if($value == $value3['container'] && $value2['customer_id'] == $value3['customer_id']) {
                                        array_push($listProductByCustomer,
                                            array(
                                                "id" => $value3['id'],
                                                "product_name"=>$value3['product_name'],
                                                "product_format"=>$value3['product_format'],
                                                "product_color"=>$value3['product_color'],
                                                "product_weight"=>$value3['product_weight'],
                                                "quantity_order"=>$value3['quantity_order'],
                                                "quantity_change"=>$value3['quantity_change'],
                                                "quantity_delivery"=>$value3['quantity_delivery'],
                                                "comment"=>$value3['comment'],
                                                "total"=>$value3['total']
                                            )
                                        );
                                    }
                                }
                                
                                $listProductByCustomer = array_map("unserialize", array_unique(array_map("serialize", $listProductByCustomer)));
                                $listProductByCustomer = array_values($listProductByCustomer);
                                array_push($listCustomerByContainer,
                                    array(
                                        'customer_id' => $value2['customer_id'],
                                        'customer_name' => $value2['customer_name'], 
                                        'department_name' => $value2['department_name'], 
                                        'detail' => $listProductByCustomer
                                    )
                                );
                            }
                        }
                    }
                    $listCustomerByContainer = array_map("unserialize", array_unique(array_map("serialize", $listCustomerByContainer)));
                    $listCustomerByContainer = array_values($listCustomerByContainer);
                    array_push($listSetContainer,
                        array(
                            'container' => $value,
                            'customer' => $listCustomerByContainer, 
                        )
                    );
                }
            }

        }

        $listSetContainer = array_map("unserialize", array_unique(array_map("serialize", $listSetContainer)));
        $listSetContainer = array_values($listSetContainer);

        return $listSetContainer;
    }

    /**
    * Function: build_sorter
    * @access public
    */
    public function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }
    function build_cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    /**
    * Function: masterNoReportSetContainer
    * @access public
    * @param 
    */
    public function masterNoReportSetContainer($date_order, $date_delivery, $check_time, $classification) {
        $no_report = '';
        /*$noReportClassification = '';
        $intDateDiff = $check_time;

        $arrNo1 = unserialize(GROUP_NO1);
        $arrNo2 = unserialize(GROUP_NO2);
        $arrNo3 = unserialize(GROUP_NO3);

        // Check by classification
        if(in_array($classification, $arrNo2) && $check_time == 1) {
            $noReportClassification = 'NO.1';
        }
        if(in_array($classification, $arrNo1) && $check_time == 1) {
            $noReportClassification = 'NO.2';
        }
        if(in_array($classification, $arrNo2) && $check_time == 2) {
            $noReportClassification = 'NO.3';
        }
        if(in_array($classification, $arrNo3) && $check_time == 1) {
            $noReportClassification = 'NO.1';
        }
        if(in_array($classification, $arrNo3) && $check_time == 2) {
            $noReportClassification = 'NO.2';
        }

        // Check Date
        if((strtotime($date_order) <= strtotime($date_delivery) && $check_time == $intDateDiff) || 
            (strtotime($date_order) > strtotime($date_delivery) && $check_time >= $intDateDiff &&
            $check_time <= $intDateDiff+1)) {    
            $no_report = $noReportClassification;
        }
        */
        return $no_report;
    }

    /**
    * Function: report_set_container
    * @access public
    */
    public function report_set_container() {
        $this->load->library('mpdf');
        $pdf = new mPDF();

        $id = (int)$this->input->get('id');
        $set = $this->input->get('set');
        $arrSet = explode(",",$set);
        $arrSet = array_filter($arrSet, function($value) { return $value !== ''; });

        $data = [];
        $data[$this->varTitle] = $this->lang->line('report_set_container');
        $pdf->SetTitle($data[$this->varTitle]);

        $data['master'] = $this->shipment_model->getMasterById($id);
        $data['detail'] = $this->shipment_detail_model->getDetailByOrder($id);

        $data['OS_ORDER_DATE'] = $this->helper->readDateTimeReport($data['master'][OS_ORDER_DATE]);
        $data['OS_DELIVERY_DATE'] = $this->helper->readDateTimeReport($data['master'][OS_DELIVERY_DATE]);
        $data['DATE_NOW'] = $this->helper->readDateTimeReport(date("Y-m-d"));

        $listSetContainer = $this->get_page_set_container($data['detail'], $arrSet);

        $html= $this->load->view('templates/shipments/report/report_set_container', $data, true);

        $data['setNoContainer'] = $this->shipment_model->getNoReportSetContainer($data['master'][OS_DELIVERY_CLASSIFICATION],$data['master']['check_time']);

        // write the HTML into the PDF
        $pdf->WriteHTML($html);

        if($listSetContainer != null) {
            foreach ($listSetContainer as $key => $value) {
                $data['dataReport'] = $value;
                $pdf->AddPage();
                $htmlPre = $html= $this->load->view('templates/shipments/report/report_set_container_page', $data, true);
                $pdf->WriteHTML($htmlPre);
            }
        }

        $pdf->DeletePages(1);
        $output = $data[$this->varTitle].'.pdf';
        if($listSetContainer == null || count($listSetContainer) <= 0) {
            $pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $pdf->Output("$output", 'I');
    }

    /**
    * Function: export
    * @access public
    */
	public function export(){
		$title = $this->lang->line('shipment_index');

		// Data
        $ticket_no = $this->input->get('ticket_no');
        $voter = $this->input->get('voter');
        $shipping_category = $this->input->get('shipping_category');
        $shipment_status = $this->input->get('shipment_status');
        $delivery_from = $this->input->get('delivery_from');
        $delivery_to = $this->input->get('delivery_to');
        $customer = $this->input->get('customer');
        $department_name = $this->input->get('department_name');
        $text_note = $this->input->get('text_note');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }
        $result = $this->shipment_model->getShipmentView($ticket_no,$voter,$shipping_category,$shipment_status,$delivery_from,$delivery_to,$customer,$department_name,$text_note,$start_index,PAGE_SIZE,OS_ORDER_DATE,"DESC");
		
		// Column name
		$column_title = array("出荷票No","作成日","お得意先","部署名","配送便区分","形態","納品予定日");
		$column_show_data = array("ticket_no","creater_date","customer_name","department_name","delivery_classification","status","delivery_date");
        
        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}
}
