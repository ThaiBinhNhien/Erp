<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LogController extends VV_Controller {
    
    // Construct function
	public function __construct()
    { 
		parent::__construct();
    }

    /**
	* Function: index
	* @access public
	*/
	public function index() {
        $data['title'] = $this->lang->line('ms_log');
        $data['data_log'] = open_log(0,PAGE_SIZE);
        $data['content'] ='masters/log/index';
        $this->load->view('templates/master',$data);
    }

    /**
	* Function: get_view_log
	* @access public
	*/
	public function get_view_log() {
        $start_index = $this->input->get('start_index');
        $result = [];

        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = open_log($start_index,PAGE_SIZE);
        }
        echo json_encode($result);
    }
	
}
