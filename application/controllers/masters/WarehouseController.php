<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class WarehouseController extends VV_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Warehouse','warehouse_model');
    }
	public function index() {
		$data['title'] = $this->lang->line('ms_warehouse');
		$data['warehouse'] = $this->warehouse_model->getAll();
        $data['content'] ='masters/warehouse/index';
        $this->load->view('templates/master',$data);
	}
	
}
