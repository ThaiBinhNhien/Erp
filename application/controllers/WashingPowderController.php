<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WashingPowderController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('WashingPowder','washing_powder_model');
    }
	public function index()
	{
        $data['title']='出荷管理';
        $data['content']='warehouse/index';
        $this->load->view('templates/master',$data);
	}
    
     public function get_washing_powder_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $result = $this->washing_powder_model->getWashingPowderView($id,$name);
        //var_dump($this->db->last_query());
        echo json_encode($result);
    }

    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $price = $this->input->post("price");
            $data[DEL_CODE] = $id;
            $data[DEL_NAME] = $name;
            $data[DEL_UNIT_PRICE] = $price;
            $result = $this->washing_powder_model->add($data);
            if($this->db->affected_rows() == 0){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['id'] = $id;
            $data['name'] = $name;
            $data['price'] = $price;
            // LOG ADD
			logadd(DEL_CODE . ":".$id, DETERGENT_LEDGER);
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
            $result = $this->washing_powder_model->remove($id,DETERGENT_LEDGER);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                    return;
            }

            // LOG DELETE
			logdelete(DEL_CODE . ":".$id, DETERGENT_LEDGER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }

    public function edit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $id_change = $this->input->post("id_change");
            $name = $this->input->post("name");
            $price = $this->input->post("price");
            $data_log_edit["data_old"]=$this->washing_powder_model->getById($id);
            $data[DEL_CODE] = $id_change;
            $data[DEL_NAME] = $name;
            $data[DEL_UNIT_PRICE] = $price;
            try{
                 $result = $this->washing_powder_model->edit($id,$data);
            }catch(Exception $ex){

            }
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }

            // Log Edit
            $arr_where[DEL_CODE] = $id_change;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, DETERGENT_LEDGER);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
        }
    }
}
