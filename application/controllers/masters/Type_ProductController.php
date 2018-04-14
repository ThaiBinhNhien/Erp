<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Type_ProductController extends VV_Controller {
	
	public function index() {
		$data['title'] = $this->lang->line('ms_type_product');
        $data['content'] ='masters/type_product/index';
        $this->load->view('templates/master',$data);
	}
	
}
