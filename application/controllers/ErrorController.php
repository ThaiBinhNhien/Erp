<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ErrorController extends CI_Controller {

    public function AccessDenied()
    {
        $data['title']=$this->lang->line('title_access_denied');
        $data['content']='error/access_denied';
        $this->load->view('templates/master',$data);
    }

    public function ErrorDatabase()
    {
        $data['title']=$this->lang->line('title_error_database');
        $data['content']='error/error_database';
        $this->load->view('templates/master',$data);
    }
}