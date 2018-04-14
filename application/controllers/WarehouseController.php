<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WarehouseController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Warehouse','warehouse_model');
    }
	public function index()
	{
        $data['title']='出荷管理';
        $data['content']='warehouse/index';
        $this->load->view('templates/master',$data);
	}
    
     public function get_warehouse_view(){
        $name = $this->input->get('name');
        $result = $this->warehouse_model->getWarehouseView($name);
        //var_dump($this->db->last_query());
        echo json_encode($result);
    }

    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $name = $this->input->post("name");
            $data[TSP_INVENTORY_LOCATION] = $name;
            $result = $this->warehouse_model->add($data);
            if(!$result){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['id'] = $result;
            $data['name'] = $name;
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success"),
                        "data" => $data
                    ));
        }
    }

    public function remove(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->warehouse_model->remove($id,T_STOCK_PLACE);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                    return;
            }
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }

    public function edit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $data[TSP_INVENTORY_LOCATION] = $name;
            try{
                 $result = $this->warehouse_model->edit($id,$data);
            }catch(Exception $ex){

            }
           
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
        }
    }
}
