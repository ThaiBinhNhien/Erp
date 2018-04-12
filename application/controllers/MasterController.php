<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MasterController extends VV_Controller {
	public function index() {
        $data['title']='マスタ';
        $data['content']='masters/index';
        $this->load->view('templates/master',$data);
	}
    public function user() {
        $data['title']='ユーザマスタ管理';
        $data['content']='masters/user';
        $this->load->view('templates/master',$data);
	}
    public function add_user() {
        $data['title']='ユーザマスタ　新規作成画面';
        $data['content']='masters/add_user';
        $this->load->view('templates/master',$data);
	}
     public function detail_user() {
        $data['title']='ユーザマスタ 詳細閲覧画面';
        $data['content']='masters/detail_user';
        $this->load->view('templates/master',$data);
	}
   
}
