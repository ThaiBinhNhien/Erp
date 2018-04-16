<?php
/*
    * 
    * @Class AdminController
    * @author TRAN MINH TRI
    */
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminController extends VV_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('Shipment','shipment_model');
		$this->load->model('Order');
		$this->load->model('Request_For_Payment');
		$this->load->model('Buying');
		$this->load->model('Issuing');
		$this->load->model('Dashboard_model','Dash_Board');

		$this->customer_account = $this->session->userdata('customer-info'); 
    }
	
	public function index() 
	{
		

		$data['list_order'] = $this->get_list_order();
		$data['list_revenue'] = $this->get_list_revenue();
		$data['list_shipment']	= $this->get_list_shipment();
		$data['list_purchare'] = $this->get_list_purchanging();
		$data['list_color'] = $this->array_color();
		$data['title'] = $this->lang->line('dash_board');

		$data['author_order'] = $this->get_role(1);
		$data['author_revenue'] = $this->get_role(2);
		$data['author_shipment'] = $this->get_role(3);
		$data['author_purchare'] = $this->get_role(4);

		$this->load->view('templates/master',$data);
	}
	public function get_role($input_role){
		$_status_role_order = $this->checkIsRoleHome($input_role);
		return $_status_role_order;
	}
	public function get_list_order()
	{

		$array_order_list = [];
		$constants_order = 1;
		$_status_role_order = $this->checkIsRoleHome($constants_order);
		if($_status_role_order == false)
		{
			$array_order_list = [];
		}
		else 
		{
			$user_name = $this->session->userdata('login-info');
			$tmp_level = $this->session->userdata('request-level');
			if($tmp_level == 'F')
			{
				// get full
				$array_order_list = $this->Dash_Board->get_order_list_by_date(); 
			}
			else if($tmp_level == 'P')
			{ 
				//get personal
				$customer = $this->customer_account == null? null:$this->customer_account[CUS_ID];
        		$is_customer = $this->customer_account == null? 2:1;
				$array_order_list = $this->Dash_Board->get_order_personal_list_by_date($user_name[U_ID],$customer,$is_customer);
			}	
		}
		return $array_order_list;
		
	}

	public function get_list_revenue()
	{

		$array_result_revenue = [];
		$constants_revenue = 2;
		$_status_role_revenue = $this->checkIsRoleHome($constants_revenue);
		if($_status_role_revenue == false)
		{
			$array_result_revenue = [];
		}
		else
		{
			$user_name = $this->session->userdata('login-info');
			$tmp_level = $this->session->userdata('request-level');
			if($tmp_level == 'F')
			{
				// get full
				$array_result_revenue = $this->Dash_Board->get_revenue_list();
			}
			else if($tmp_level == 'P')
			{
				//get personal
				$array_result_revenue = $this->Dash_Board->get_revenue_person_list($user_name[U_ID]);
			}	
		}
		return $array_result_revenue;
	}

	public function get_list_shipment()
	{
		
		$array_shipment_list = [];
		$constants_shippment = 3;
		$_status_role_shippment = $this->checkIsRoleHome($constants_shippment);
		if($_status_role_shippment == false)
		{
			$array_shipment_list = [];
		}
		else
		{
			$tmp_level = $this->session->userdata('request-level');
			if($tmp_level == 'F')
			{
				// get full
				$array_shipment_list = $this->Dash_Board->get_shipment_list_by_date();
			}
		}
		return  $array_shipment_list;
	}

	public function get_list_purchanging()
	{

		$array_result = [];
		$constants_purchare = 4;
		$_status_role_purchare =  $this->checkIsRoleHome($constants_purchare);
		if($_status_role_purchare == false)
		{
			$array_result = [];
		}
		else
		{
			$tmp_level = $this->session->userdata('request-level');
			if($tmp_level == 'F')
			{
				// get full
				$array_result = $this->Dash_Board->get_purchanging_list();
				
			}
		}
		return $array_result;
	}

	public function array_color()
	{
		$CSS_COLOR_NAMES = ["red","#0099ba","Blue","BlueViolet","Chocolate","Coral","CornflowerBlue","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","Darkorange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed","Indigo","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen"];
		return $CSS_COLOR_NAMES;
	}

	//get list product
	public function get_detail_order()
	{
		$data = [];
		if(isset($_GET['id'])){
			
			$post_id = $this->input->get('id');
			$data['rel'] = $this->Dash_Board->get_detail_product($post_id);
			
		}
		echo json_encode($data);
		
	}

	public function get_product_revenue()
	{
		$data = [];
		if(isset($_GET['id'])){
			$post_id = $this->input->get('id');
			$data['rel'] = $this->Dash_Board->get_product_of_revenue($post_id);
		}
		echo json_encode($data);
	}
	public function get_product_of_shipment()
	{
		$data = [];
		if(isset($_GET['id'])){
			$post_id = $this->input->get('id');
			$data['rel'] = $this->Dash_Board->get_detail_shipment($post_id);
		}
		echo json_encode($data);	
	}
	public function get_purchar_detail()
	{
		$data = [];
		if(isset($_GET['id'])){
			$post_id = $this->input->get('id');
			$this->load->model('Buying');
			$order = $this->Buying->get_detail_order_purchase($post_id);
			$data['rel'] = $this->Buying->product_list_of_order_purchase($order->{TO_ID});
		}
		echo json_encode($data);
	}
	public function edit_flicker()
	{
		# code...
		$data = [];
		$post_id = $this->input->post('id_shipment');
		$arr_infor[OS_FLAG_FLICKER] = 1;
		$arr_where[OS_ID] = $post_id;
		$data['rel'] = $this->shipment_model->editByWhere($arr_where, $arr_infor);
		echo json_encode($data);
	}

}
