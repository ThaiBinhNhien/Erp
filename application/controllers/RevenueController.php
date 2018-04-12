<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RevenueController extends VV_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
        $data['title']='売上管理';
        $data['content']='revenues/index';
        $this->load->view('templates/master',$data);
	}
    public function add_revenues()
	{
        $data['title']='請求書作成画面';
        $data['content']='revenues/add_revenues';
        $this->load->view('templates/master',$data);
	}
      public function view_revenues()
	{
        $data['title']='作成済請求書 詳細閲覧画面';
        $data['content']='revenues/view_revenues';
        $this->load->view('templates/master',$data);
	}
        public function edit_revenues()
	{
        $data['title']='請求書　編集画面';
        $data['content']='revenues/edit_revenues';
        $this->load->view('templates/master',$data);
	}
        public function created_revenues()
	{
        $data['title']='作成済請求書';
        $data['content']='revenues/created_revenues';
        $this->load->view('templates/master',$data);
	}
            public function choose_revenues()
	{
        $data['title']='作成済請求書';
        $data['content']='revenues/choose_revenues';
        $this->load->view('templates/master',$data);
	}
               public function detail_revenues_2()
	{
        $data['title']='作成済請求書';
        $data['content']='revenues/detail_revenues_2';
        $this->load->view('templates/master',$data);
	}
            public function edit_createdRevenues()
	{
        $data['title']='作成済請求書';
        $data['content']='revenues/edit_createdRevenues';
        $this->load->view('templates/master',$data);
	}
}
