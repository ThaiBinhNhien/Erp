<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class GroupInvoiceController extends VV_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_Group','invoice_group_model');
        $this->load->model('Customer_Department','customer_department_model');
        $this->load->model('Invoice_Group_Detail','invoice_group_detail_model');
        
    }
	public function get_group_invoice_view(){
        $id = $this->input->get('id');
        $name = $this->input->get('name');
        $display_name = $this->input->get('display_name');
        $address = $this->input->get('address');
        $result = $this->invoice_group_model->getInvoiceGroupView($id, $name,$display_name,$address);
        //var_dump($this->db->last_query());
        echo json_encode($result);
    }
    public function create(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $user = $this->input->post("user");
            $name = $this->input->post("name");
            $display_name = $this->input->post("display_name");
            $address = $this->input->post("address");
            $address2 = $this->input->post("address2");
            $environment_fee = $this->input->post("environment_fee");
            $environment_fee_check = $this->input->post("environment_fee_check");
            $fixed_amount = $this->input->post("fixed_amount");
            $tax = $this->input->post("tax");
            $tax_check = $this->input->post("tax_check");
            $discount = $this->input->post("discount");
            $post_office = $this->input->post("post_office");
            $telephone = $this->input->post("telephone");
            $fax = $this->input->post("fax");
            $closing_date = $this->input->post("closing_date");
            $aggregate = $this->input->post("aggregate");
            $collective_output = $this->input->post("collective_output");
            $detail = $this->input->post("detail");
           
            try{
                $this->invoice_group_model->db->trans_begin();
                $data[IG_ID] = $id;
                $data[TG_USER_ID] = $user;
                $data[IG_INVOICE_NAME] = $name;
                $data[IG_DISPLAY_NAME] = $display_name;
                $data[IG_STREET_ADDRESS] = $address;
                $data[IG_STREET_ADDRESS_2] = $address2;
                $data[IG_DISCOUNT] = $discount;
                $data[IG_ENVIRONMENTAL_LOAD] = $environment_fee;
                $data[IG_ENVIRONMENTAL_CHECK] = $environment_fee_check;
                $data[IG_FIXED_AMOUNT] = $fixed_amount;
                $data[IG_TAX] = $tax;
                $data[IG_TAX_CHECK] = $tax_check;
                $data[IG_POST_OFFICE] = $post_office;
                $data[IG_TELEPHONE] = $telephone;
                $data[IG_FAX] = $fax;
                $data[IG_CLOSING_DATE] = $closing_date;
                $data[IG_AGGREGATE] = $aggregate;
                $data[IG_COLLECTIVE_OUTPUT] = $collective_output;
                $group_id = $this->invoice_group_model->add($data,INVOICE_GROUP);
                foreach ($detail as $key => $value) {
                   $cus_de[IGD_ID_INVOICE_GROUP] = $id;
                   $cus_de[IGD_ID_DEPARTMENT_CUSTOMER] = $value['id_dp'];
                   $this->invoice_group_detail_model->add($cus_de,INVOICE_GROUP_DETAIL);
                }
                if ($this->invoice_group_model->db->trans_status() === FALSE)
                {
                    $this->invoice_group_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_add_error")
                    ));
                    return;
                }
                else
                {
                    // LOG ADD
                    logadd(IG_ID . ":".$id, INVOICE_GROUP);
            
                    $this->invoice_group_model->db->trans_commit();
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_add_success")
                    ));
                    return;
                }
            }catch(Exception $ex){
                $this->invoice_group_model->db->trans_rollback();
            }

        }
    }

    public function remove(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $result = $this->invoice_group_model->remove($id,INVOICE_GROUP);
            if($result == false){
                echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_remove_error")
                    ));
                return;
            }

            // LOG DELETE
			logdelete(IG_ID . ":".$id, INVOICE_GROUP);
            echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_remove_success")
                    ));
        }
    }

    public function edit(){ 
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post("id");
            $user = $this->input->post("user");
            $name = $this->input->post("name");
            $display_name = $this->input->post("display_name");
            $address = $this->input->post("address");
            $address2 = $this->input->post("address2");
            $environment_fee = $this->input->post("environment_fee");
            $environment_fee_check = $this->input->post("environment_fee_check");
            $fixed_amount = $this->input->post("fixed_amount");
            $tax = $this->input->post("tax");
            $tax_check = $this->input->post("tax_check");
            $discount = $this->input->post("discount");
            $post_office = $this->input->post("post_office");
            $telephone = $this->input->post("telephone");
            $fax = $this->input->post("fax");
            $closing_date = $this->input->post("closing_date");
            $aggregate = $this->input->post("aggregate");
            $collective_output = $this->input->post("collective_output");
            $detail = $this->input->post("detail");
            $data_log_edit["data_old"]=$this->invoice_group_model->getById($id);
            
            try{
                $this->invoice_group_model->db->trans_begin();
                $data[IG_INVOICE_NAME] = $name;
                $data[TG_USER_ID] = $user;
                $data[IG_DISPLAY_NAME] = $display_name;
                $data[IG_STREET_ADDRESS] = $address;
                $data[IG_STREET_ADDRESS_2] = $address2;
                $data[IG_DISCOUNT] = $discount;
                $data[IG_ENVIRONMENTAL_LOAD] = $environment_fee;
                $data[IG_ENVIRONMENTAL_CHECK] = $environment_fee_check;
                $data[IG_FIXED_AMOUNT] = $fixed_amount;
                $data[IG_TAX] = $tax;
                $data[IG_TAX_CHECK] = $tax_check;
                $data[IG_POST_OFFICE] = $post_office;
                $data[IG_TELEPHONE] = $telephone;
                $data[IG_FAX] = $fax;
                $data[IG_CLOSING_DATE] = $closing_date;
                $data[IG_AGGREGATE] = $aggregate;
                $data[IG_COLLECTIVE_OUTPUT] = $collective_output;
                $this->invoice_group_model->edit($id,$data,INVOICE_GROUP);
                $this->invoice_group_detail_model->remove_by_invoice($id);
                foreach ($detail as $key => $value) {
                   $cus_de[IGD_ID_INVOICE_GROUP] = $id;
                   $cus_de[IGD_ID_DEPARTMENT_CUSTOMER] = $value['id_dp'];
                   $this->invoice_group_detail_model->add($cus_de,INVOICE_GROUP_DETAIL);
                }
                if ($this->invoice_group_model->db->trans_status() === FALSE)
                {
                    $this->invoice_group_model->db->trans_rollback();
                    echo json_encode(array(
                        "success" => false,
                        "message" => $this->lang->line("message_edit_error")
                    ));
                    return;
                }
                else
                {
                    // Log Edit
                    $arr_where[IG_ID] = $id;
                    $data_log_edit["id"]=$arr_where;
                    $data_log_edit["data_new"]=$data;
                    logedit($data_log_edit, INVOICE_GROUP);

                    $this->invoice_group_model->db->trans_commit();
                    echo json_encode(array(
                        "success" => true,
                        "message" => $this->lang->line("message_edit_success")
                    ));
                    return;
                }
            }catch(Exception $ex){
                $this->invoice_group_model->db->trans_rollback();
            }
        }
    }
}
