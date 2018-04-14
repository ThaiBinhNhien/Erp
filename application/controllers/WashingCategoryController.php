<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WashingCategoryController extends VV_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Washing_Category','washing_category_model');
        
    }
	public function index()
	{
        $data['title']='出荷管理';
        $data['content']='warehouse/index';
        $this->load->view('templates/master',$data);
	}
    
     public function get_washing_category_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $result = $this->washing_category_model->getWashingCategoryView($id,$name);
        //var_dump($this->db->last_query());
        echo json_encode($result);
    }

    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $name = $this->input->post("name");
            $data[TLG_ID] = $id;
            $data[TLG_NAME] = $name;
            $result = $this->washing_category_model->add($data);
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
			logadd(TLG_ID . ":".$id, T_LAUNDRY_SEGMENT);
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
            $result = $this->washing_category_model->remove($id,T_LAUNDRY_SEGMENT);
            if(!$result){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                    return;
            }

            // LOG DELETE
			logdelete(TLG_ID . ":".$id, T_LAUNDRY_SEGMENT);
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
            $data[TLG_NAME] = $name;
            $data[TLG_ID] = $id_change;
            $data_log_edit["data_old"]=$this->washing_category_model->getById($id);
            try{
                 $result = $this->washing_category_model->edit($id,$data);
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
            $arr_where[TLG_ID] = $id;
            $data_log_edit["id"]=$arr_where;
            $data_log_edit["data_new"]=$data;
            logedit($data_log_edit, T_LAUNDRY_SEGMENT);

            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
        }
    }

    
}
