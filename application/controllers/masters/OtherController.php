<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OtherController extends VV_Controller {
	
	public function index() {
		$data['title'] = $this->lang->line('ms_other');
        $data['content'] ='masters/other/index';
        $this->load->view('templates/master',$data);
	}
	
}
