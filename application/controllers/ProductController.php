<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Product','product_model');
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('User','user_model');
        $this->customer_account = $this->session->userdata('customer-info');

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
	public function search_by_sale_code()
	{
        $code = $this->input->get('code');
        $start_index = $this->input->get('start_index');
        $number = $this->input->get('number');
        $this->product_model->db->select(PL_PRODUCT_ID." AS id,".PL_PRODUCT_NAME." AS name,".PL_COLOR_TONE." AS color,".PL_STANDARD." AS standard,".PL_STANDARD." AS unit,".PL_NUMBER_PACKAGE." AS package_size,".PL_PRODUCT_CODE_SALE." AS sale_code");
        $data = array(
        	PL_PRODUCT_CODE_SALE => $code
        );
        $this->product_model->db->like(PL_PRODUCT_CODE_SALE, $code, 'after');  
        $result = $this->product_model->getWhere(null,$start_index,$number);
        echo json_encode($result);
    }
    public function search_by_name()
	{
        $name = $this->input->get('name');
        $start_index = $this->input->get('start_index');
        $number = $this->input->get('number');
        $this->product_model->db->select(PL_PRODUCT_ID." AS id,".PL_PRODUCT_NAME." AS name,".PL_COLOR_TONE." AS color,".PL_STANDARD." AS standard,".PL_STANDARD." AS unit,".PL_NUMBER_PACKAGE." AS package_size");
        $this->product_model->db->like(PL_PRODUCT_NAME, $name, 'both');  
        $result = $this->product_model->getWhere(null,$start_index,$number);
        echo json_encode($result);
	}

    public function search_by_sale_code_not_special()
    {
        $code = $this->input->get('code');
        $start_index = $this->input->get('start_index');
        $number = $this->input->get('number');
         
        $result = $this->product_model->search_by_sale_code_not_special($code);
        echo json_encode($result);
    }

    public function search_by_sale_code_with_special()
    {
        $code = $this->input->get('code');
        $base_id = $this->input->get('base_id');
        $customer_id = $this->input->get("customer_id");
        $start_index = $this->input->get('start_index');
        $department_id = $this->input->get('department_id');
        $number = $this->input->get('number');
        if($this->customer_account != null && $department_id != null){
            $obj = $this->customer_department_model->getByCusAndDepart($customer_id,$department_id);
            if($obj != null){
                $base_id = $this->user_model->getById($obj[CD_USER_ID])[U_BASE_CODE];
            }
        }
        $result = $this->product_model->search_by_sale_code_with_special($code,$customer_id,$base_id);
        echo json_encode($result); 
    }
}
