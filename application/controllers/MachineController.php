<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MachineController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Machine','machine_model');
    }
	public function index()
	{
        $data['title']='出荷管理';
        $data['content']='warehouse/index';
        $this->load->view('templates/master',$data);
	}
    
     public function get_machine_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $result = $this->machine_model->getMachineView($id, $name);
        //var_dump($this->db->last_query());
        echo json_encode($result);
    }

    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $data[EQ_CODE] = $id;
            $data[EQ_NAME] = $name;
            $result = $this->machine_model->add($data);
            if($this->db->affected_rows() == 0){
                
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
            }
            $data['id'] = $id;
            $data['name'] = $name;

            // LOG ADD
			logadd(EQ_CODE . ":".$id, EQUIPMENT_M);
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
            $result = $this->machine_model->remove($id,EQUIPMENT_M);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                    return;
            }

            // LOG DELETE
			logdelete(EQ_CODE . ":".$id, EQUIPMENT_M);
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
            $data[EQ_NAME] = $name;
            $data[EQ_CODE] = $id_change;
            $data_log_edit["data_old"]=$this->machine_model->getById($id);

            try{
                 $result = $this->machine_model->edit($id,$data);
            }catch(Exception $ex){

            }
           
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
            }

            // Log Edit
            $arr_where[EQ_CODE] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, EQUIPMENT_M);

            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
        }
    }
}
