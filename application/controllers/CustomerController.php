<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class CustomerController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer','customer_model');
        $this->load->model('User','user_model');
        $this->load->model('Product','product_model');
        $this->load->model('Customer_Department','customer_department_model');
    }
	public function index()
	{
        $data['title']='出荷管理';
        $data['content']='shipments/index';
        $this->load->view('templates/master',$data);
	}
    public function get()
	{
        $id = $this->input->get('id');
        $result = $this->customer_model->getById($id);
        echo json_encode($result);
	}
    public function get_customer_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $fax = $this->input->get('fax');
        $address = $this->input->get('address');
        $phoneNumber = $this->input->get('phoneNumber');        
        $start_index = $this->input->get('start_index');
        if($start_index == NULL){
            $start_index = 0;
        }
        
        $result = $this->customer_model->getCustomerView($id,$name,$fax,null,$address,$phoneNumber,$start_index,PAGE_SIZE);
        echo json_encode($result);
    }
	public function search_by_name() 
	{
        $name = $this->input->get('name');
        $cus_type =  $this->input->get('cus_type');
        $start_index = $this->input->get('start_index');
        $number = $this->input->get('number');  
        if($number == NULL || $number == ""){
            $number = PAGE_SIZE;
        }
        $result = $this->customer_model->search_by_name($name,$cus_type,$start_index,$number);
        echo json_encode($result);
	}

    public function get_deparment_by_customer(){ 
        $customer_id = $this->input->get('customer_id');
        $result = $this->customer_department_model->getByCustomer($customer_id);
        echo json_encode($result);
    }

    /**
    * Function: get product by customer
    * Dùng trong shipment
    * @access public
	*/
    public function get_product_by_customer(){ 
        //$customer_id = $this->input->get('customer_id');
        //$result = $this->customer_model->getProductByCustomer($customer_id);
        $result = $this->product_model->getProductView(null,null,2,false);
        echo json_encode($result);
    }
    

    public function get_product_set_by_customer(){
        $customer_id = $this->input->get('customer_id');
        $result = $this->customer_model->getProductSetByCus($customer_id);
        echo json_encode($result);
    }

    public function get_deparment_by_customer_catif(){ 
        $customer_id = $this->input->get('customer_id');
        $result = $this->customer_department_model->getByCustomer($customer_id);
        echo json_encode($result);
    }

    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $end_code = $this->input->post("end_code");
            $address1 = $this->input->post("address1");
            $address2 = $this->input->post("address2");
            $phone_number = $this->input->post("phone_number");
            $fax = $this->input->post("fax");
            $classification = $this->input->post("classification");
            $department = $this->input->post("department");
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            if($username != NULL && $password == NULL || $username == NULL && $password != NULL){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            
            try{
                $this->customer_model->db->trans_begin();
                $data[CUS_ID] = $id;
                $data[CUS_CUSTOMER_NAME] = $name;
                $data[CUS_CLOSING_DATE_CODE] = $end_code;
                $data[CUS_ADDRESS_1] = $address1;
                $data[CUS_ADDRESS_2] = $address2;
                $data[CUS_PHONE_NUMBER] = $phone_number;
                $data[CUS_FACSIMILE] = $fax;
                $data[CUS_TYPE_CUSTOMER] = $classification;
                $data[CUS_ACCOUNT_ID] = $username;

                $this->customer_model->add($data,CUSTOMER);
                foreach ($department as $key => $value) {
                   $cus_de[CD_CUSTOMER_ID] = $id;
                   $cus_de[CD_DEPARTMENT_CODE] = $value[0];
                   $cus_de[CD_NOT_ASK_MONEY] = intval($value[1]);
                   $cus_de[CD_USER_ID] = $value[2];
                   $cus_de[CD_FL_COPY_SHIPMENT] = intval($value[3]);
                   $this->customer_department_model->add($cus_de,CUSTOMER_DEPARTMENT);
                }
                if($username != NULL){
                    $user = null;
                    $user[U_ID] = $username;
                    $user[U_PASSWORD] = password_hash($password, PASSWORD_DEFAULT);
                    $user[U_NAME] = $name;
                    $user[U_USER_GROUP] = '{"'.GR_CUSTOMERS.'":"'.GR_CUSTOMERS.'"}';
                    $this->user_model->add($user);
                }
                
                if ($this->customer_model->db->trans_status() === FALSE)
                {
                    $this->customer_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
                }
                else
                {
                    // LOG ADD
                logadd(CUS_ID . ":".$id, CUSTOMER);
                    
                    $this->customer_model->db->trans_commit();
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success")
                    ));
                    return;
                }
            }catch(Exception $ex){
                $this->customer_model->db->trans_rollback();
            }

        }
    }
    
    public function remove(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->customer_model->remove($id,CUSTOMER);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
			logdelete(CUS_ID . ":".$id, CUSTOMER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }

    public function edit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $end_code = $this->input->post("end_code");
            $address1 = $this->input->post("address1");
            $address2 = $this->input->post("address2");
            $phone_number = $this->input->post("phone_number");
            $fax = $this->input->post("fax");
            $classification = $this->input->post("classification");
            $department = $this->input->post("department");
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $customerInfo = $this->customer_model->getById($id);
            $data_log_edit["data_old"]=$this->customer_model->getById($id);
            try{
                $this->customer_model->db->trans_begin();
                $data[CUS_CUSTOMER_NAME] = $name;
                $data[CUS_CLOSING_DATE_CODE] = $end_code;
                $data[CUS_ADDRESS_1] = $address1;
                $data[CUS_ADDRESS_2] = $address2;
                $data[CUS_PHONE_NUMBER] = $phone_number;
                $data[CUS_FACSIMILE] = $fax;
                $data[CUS_TYPE_CUSTOMER] = $classification;
                if($customerInfo[CUS_ACCOUNT_ID] == NULL){
                    $data[CUS_ACCOUNT_ID] = $username;
                }
                $this->customer_model->edit($id,$data,CUSTOMER);
                $this->customer_department_model->removeByCustomer($id);
                foreach ($department as $key => $value) {
                   $cus_de[CD_CUSTOMER_ID] = $id;
                   $cus_de[CD_DEPARTMENT_CODE] = $value[0];
                   $cus_de[CD_NOT_ASK_MONEY] = intval($value[1]);
                   $cus_de[CD_USER_ID] = $value[2];
                   $cus_de[CD_FL_COPY_SHIPMENT] = intval($value[3]);
                   $this->customer_department_model->add($cus_de,CUSTOMER_DEPARTMENT);
                }
                if($customerInfo[CUS_ACCOUNT_ID] == NULL && $username != NULL && $password != NULL){
                    if($username != NULL && $password == NULL || $username == NULL && $password != NULL){
                        throw new Exception("");
                    }
                    $user = null;
                    $user[U_ID] = $username;
                    $user[U_PASSWORD] = password_hash($password, PASSWORD_DEFAULT);
                    $user[U_NAME] = $name;
                    $user[U_USER_GROUP] = '{"'.GR_CUSTOMERS.'":"'.GR_CUSTOMERS.'"}';
                    $this->user_model->add($user);

                }
                if ($this->customer_model->db->trans_status() === FALSE)
                {
                    $this->customer_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
                else
                {
                    // Log Edit
                    $arr_where[CUS_ID] = $id;
                    $data_log_edit["id"]=$arr_where;
                    $data_log_edit["data_new"]=$data;
                    logedit($data_log_edit, CUSTOMER);

                    $this->customer_model->db->trans_commit();
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
                    return;
                }
            }catch(Exception $ex){
                $this->customer_model->db->trans_rollback();
            }
        }
    }
}
