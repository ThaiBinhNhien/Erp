<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DepartmentController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('Department','department_model');
    }
	public function index()
	{
        $data['title']='出荷管理';
        $data['content']='shipments/index';
        $this->load->view('templates/master',$data);
	}
    public function get()
	{
        $this->product_model->db->select(PL_PRODUCT_ID." AS id,".PL_PRODUCT_NAME." AS name,".PL_COLOR_TONE." AS color,".PL_STANDARD." AS standard,".PL_STANDARD." AS unit,".PL_NUMBER_PACKAGE." AS package_size,".PRODUCT_LEDGER.".*");
        $id = $this->input->get('id');
        $result = $this->product_model->getById($id);
        echo json_encode($result);
	}
     public function get_department_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $code = $this->input->get('code');
        $result = $this->department_model->getDepartmentView($id, $name,$code);
        //var_dump($this->db->last_query());
        echo json_encode($result);
    }
	public function get_by_customer()
	{
        $customer_id = $this->input->get('customer_id');
        $result = $this->customer_department_model->getByCustomer($customer_id);
        echo json_encode($result);
	}
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $code = $this->input->post("code");
            $name_code = $this->input->post("name_code");
            $data[DL_DEPARTMENT_CODE] = $id;
            $data[DL_AGGREGATION_CODE] = $code;
            $data[DL_DEPARTMENT_NAME] = $name;
            $result = $this->department_model->add($data);
            if($this->db->affected_rows() == 0){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['id'] = $id;
            $data['code'] = $code;
            $data['name'] = $name;
            $data['name_code'] = $name_code;
            // LOG ADD
			logadd(DL_DEPARTMENT_CODE . ":".$id, DEPARTMENT_LEDGER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success"),
                        "data" => $data
                    ));
        }
    }

    public function remove(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->department_model->remove($id,DEPARTMENT_LEDGER);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                    return;
            }
            // LOG DELETE
			logdelete(DL_DEPARTMENT_CODE . ":".$id, DEPARTMENT_LEDGER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }

    public function edit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $id_change = $this->input->post("id_change");
            $name = $this->input->post("name");
            $code = $this->input->post("code");
            $data_log_edit["data_old"]=$this->department_model->getById($id_change);
            $data[DL_AGGREGATION_CODE] = $code;
            $data[DL_DEPARTMENT_NAME] = $name;
            $data[DL_DEPARTMENT_CODE] = $id_change;
            try{
                 $result = $this->department_model->edit($id,$data);
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
            $arr_where[DL_DEPARTMENT_CODE] = $id_change;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, T_EVENT);

            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
        }
    }
}
