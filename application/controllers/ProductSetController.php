<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProductSetController extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('ProductSet','product_set_model');
    }

    function get_info(){
    	$id = $this->input->get('id');
    	$result = $this->product_set_model->getDetail($id);
    	echo json_encode($result);
    }
}
