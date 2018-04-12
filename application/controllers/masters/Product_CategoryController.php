<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_CategoryController extends VV_Controller {
	
	public function index() {
		$data['title'] = $this->lang->line('ms_product_category');
        $data['content'] ='masters/product_category/index';
        $this->load->view('templates/master',$data);
	}
	public function edit_product_category() {
		$data['title'] = $this->lang->line('ms_edit_product_category');
        $data['content'] ='masters/product_category/edit_product_category';
        $this->load->view('templates/master',$data);
	}
	
}
