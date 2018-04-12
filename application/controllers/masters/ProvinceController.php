<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProvinceController extends VV_Controller {
	
	public function index() {
		$data['title'] = $this->lang->line('ms_province');
        $data['content'] ='masters/province/index';
        $this->load->view('templates/master',$data);
	}
	
}
