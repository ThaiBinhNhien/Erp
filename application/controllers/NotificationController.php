<?php
/**
* ------------------------------
* Notification controller
* ------------------------------
*/
class NotificationController extends VV_Controller
{
	
	function __construct()
	{
        parent::__construct();
        $this->load->model('Notification_model','notification_model');
        $this->LOGIN_INFO = $this->session->userdata('login-info');
        $this->LIMIT_NOTIFICATION = 50;
	}

	public function index(){
        //die(var_dump(JWT::encode("FFF", "ABB")));
        //die(var_dump(JWT::decode("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IkZGRiI.4x_PlHRi4_0LteR-UTU_Ucu77kRJ2-gLGMmY0HkYURA", "ABB")));
		$data['content']='notification';
		$data['title'] = 'Notification';
		$this->load->view('templates/master', $data);
    }
    
    /**
    * ------------------------------
    * add_post_notification controller
    * ------------------------------
    */
    public function add_post_notification(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $arr[TN_USER] = $this->input->post('username');
            $arr[TN_SUBJECT] = $this->input->post('subject');
            $arr[TN_MESSAGE] = $this->input->post('message');

            $this->notification_model->db->trans_begin(); 
            $insert_id = $this->notification_model->add($arr);
            $success = false;
            if ($this->notification_model->db->trans_status() === FALSE)
            {
                $this->notification_model->db->trans_rollback();
                $success = false;
            }
            else
            {
                $this->notification_model->db->trans_commit();
                $success = true;
            }
            $detail = $this->notification_model->getById($insert_id); 
            $arr['username'] = $detail[TN_USER];
            $arr['subject'] = $detail[TN_SUBJECT];
            $arr['message'] = $detail[TN_MESSAGE];
            $arr['created_at'] = $detail[TN_DATE_CREATER];
            $arr['id'] = $detail[TN_ID];
            $arr['new_count_message'] = $this->notification_model->db->where(TN_STATUS,0)->where(TN_USER,$this->LOGIN_INFO[U_ID])->limit($this->LIMIT_NOTIFICATION)->count_all_results(TAB_NOTIFICATION);
            $arr['success'] = $success;
            $arr['token'] = TOKEN_SOCKET;

            echo json_encode($arr);
        }
    }

    /**
    * ------------------------------
    * get_list_notification controller
    * ------------------------------
    */
    public function get_list_notification(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $get_query = $this->notification_model->db->select('*')->where(TN_STATUS,0)->where(TN_USER,$this->LOGIN_INFO[U_ID])->from(TAB_NOTIFICATION)->order_by(TN_ID,'desc')->limit($this->LIMIT_NOTIFICATION)->get();
            
            $result = array();
            if($get_query) {
                $result = $get_query->result_array();
                
            }

            $arr['result'] = $result;
            $arr['token'] = TOKEN_SOCKET;
            echo json_encode($arr);
        }
    }

    /**
    * ------------------------------
    * update_ready_notification controller
    * ------------------------------
    */
    public function update_ready_notification(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id_notification = $this->input->post('id');
            $information[TN_STATUS] = 1;

            $this->notification_model->db->trans_begin(); 
            $this->notification_model->edit($id_notification,$information);

            $success = false;
            if ($this->notification_model->db->trans_status() === FALSE)
            {
                $this->notification_model->db->trans_rollback();
                $success = false;
            }
            else
            {
                $this->notification_model->db->trans_commit();
                $success = true;
            }

            $detail = $this->notification_model->getById($id_notification); 
            $arr['username'] = $detail[TN_USER];
            $arr['new_count_message'] = $this->notification_model->db->where(TN_STATUS,0)->where(TN_USER,$this->LOGIN_INFO[U_ID])->limit($this->LIMIT_NOTIFICATION)->count_all_results(TAB_NOTIFICATION);
            $arr['success'] = $success;
            $arr['token'] = TOKEN_SOCKET;

            echo json_encode($arr);
        }
    }

}