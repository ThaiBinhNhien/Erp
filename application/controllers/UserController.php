<?php
/**
* ------------------------------
* User controller
* ------------------------------
* Manage users' information.
*/
class UserController extends VV_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->primaryModel = 'User';
		$this->load->model('User');
		$this->load->model('Customer','customer_model');
		$this->load->model('base_master', 'BaseMaster');
		$this->load->model('ImportExportCsv');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}

	public function index(){
		$keyword = $this->input->get('keyword');
		$this->User->__set('table_name', USER_VIEW);
		$data['keyword'] = $keyword;
		$data['content']='masters/user/user_list';
		$data['baseMaster'] = $this->BaseMaster->getAll(); 
		$data['title'] = $this->lang->line('user_list');
		$data['user_id'] = $this->LOGIN_INFO[U_ID];
		$this->load->view('templates/master', $data);
	}

	/**
	* Function: get_list
	* @access public
	*/
	public function get_list(){
        
		$keyword["username"] = $this->input->get('username');
		$keyword["name"] = $this->input->get('name');
		$keyword["base"] = $this->input->get('base');
        $start_index = $this->input->get('start_index');
        if($start_index == NULL || $start_index == ""){ 
            $start_index = 0;
        }

        if($start_index == 0 || $start_index >= PAGE_SIZE) {
            $result = $this->User->searchUser($keyword,$start_index,PAGE_SIZE);
        }
        echo json_encode($result);
    }

	public function login()
	{
		//If already logged in, redirect to home
		if($this->logged()) {
			redirect('/');
		}
		$hasError = false;
		if($this->input->method(TRUE) == 'POST') {
			//action login
			$username = $this->input->post('username', true);
			$password = $this->input->post('password', true);

			$user = $this->User->getWhereUser($username);
			
			if(count($user) != 1 OR !password_verify($password, $user[0][U_PASSWORD])) {
				$hasError = true;
			} else {
				$this->session->set_userdata('login-info', end($user));
				$this->session->set_userdata('customer-info',$this->customer_model->getCustomerByAccountID($user[0][U_ID]));
				redirect('/'); 
			}
		}

		$this->load->view('login', array('hasError' => $hasError));
	}

	public function logout()
	{
		$this->session->unset_userdata('login-info');
		$this->session->unset_userdata('request-level');
		redirect('login');
	}

	public function edit()
	{
		$id = $this->input->get('i', true);
		
		if($this->input->method(TRUE) == 'POST') {
			$user[U_PASSWORD] = $this->postValueWithDefault(U_PASSWORD, true, '');
			$user[U_NAME] = $this->postValueWithDefault(U_NAME, true, '');
			$user[U_SHIMEI] = $this->postValueWithDefault(U_SHIMEI, true, '');
			$user[U_BASE_CODE] = $this->postValueWithDefault(U_BASE_CODE, true, '');
			$user[U_POSITION] = $this->postValueWithDefault(U_POSITION, true, '');
			$user[U_EXTENSION_NUMBER] = $this->postValueWithDefault(U_EXTENSION_NUMBER, true, '');
			$user[U_COMPANY_DIRECT_LINE_TEL] = $this->postValueWithDefault(U_COMPANY_DIRECT_LINE_TEL, true, '');
			if(empty($id)) {
				$data['errorMessage'] = $this->lang->line('user_not_found');
			} else {
				//hash password
				if(empty($user[U_PASSWORD])){
					unset($user[U_PASSWORD]);
				}else{
					$user[U_PASSWORD] = password_hash($user[U_PASSWORD], PASSWORD_DEFAULT);
				}
				
				if($this->input->post('gr')){
					$user[U_USER_GROUP] = json_encode($this->input->post('gr'));
				} else {
					$user[U_USER_GROUP] = json_encode([]);
				}
				$this->User->edit($id, $user);
				$data['successMessage'] = $this->lang->line('updated_successfully');
			}
		}
		$data['baseMaster'] = $this->BaseMaster->getAll();
		$data['disable_user'] = true;
		$data['page_name'] = $this->lang->line('page_edit_user');
		$data['user'] = $this->User->getUserById($id);
		if($data['user'] == null) {
			redirect( base_url('master/user'), 'refresh');
		}
		$data['user'][U_USER_GROUP] = json_decode(html_entity_decode($data['user'][U_USER_GROUP]), true);
		$data['content']='masters/user/edit_user';
		$data['title'] = $this->lang->line('edit_user_title');
		$data['user_id'] = $this->LOGIN_INFO[U_ID];
		$this->load->view('templates/master', $data);
	}

	public function add()
	{
		if($this->input->method(TRUE) == 'POST') {
			$user[U_ID] = $this->input->post(U_ID, true);
			$user[U_PASSWORD] = $this->input->post(U_PASSWORD, true);
			$user[U_NAME] = $this->input->post(U_NAME, true); 
			$user[U_SHIMEI] = $this->input->post(U_SHIMEI, true);
			$user[U_BASE_CODE] = $this->input->post(U_BASE_CODE, true);
			$user[U_POSITION] = $this->input->post(U_POSITION, true);
			$user[U_EXTENSION_NUMBER] = $this->input->post(U_EXTENSION_NUMBER, true);
			$user[U_COMPANY_DIRECT_LINE_TEL] = $this->input->post(U_COMPANY_DIRECT_LINE_TEL, true);
			$user[U_USER_GROUP] = $this->input->post('gr');

			if(empty($user[U_ID]) or empty($user[U_PASSWORD])) {
				$data['errorMessage'] = $this->lang->line('invalid_user_registration');
				$data['user']  =$user;
			} else {
				$existedUser = $this->User->getById($user[U_ID]);
				if($existedUser) { //already existed
					$data['errorMessage'] = $this->lang->line('user_existed');
					$data['user']  =$user;
				} else {
					//hash password
					$user[U_PASSWORD] = password_hash($user[U_PASSWORD], PASSWORD_DEFAULT);
					
					if($this->input->post('gr')){
						$user[U_USER_GROUP] = json_encode($this->input->post('gr'));
					}

					$this->load->model('User');
					$this->User->add($user);
					$data['successMessage'] = $this->lang->line('added_successfully');
				}
			}
		}
		$data['baseMaster'] = $this->BaseMaster->getAll();
		$data['disable_user'] = false;
		$data['page_name'] = $this->lang->line('page_add_user');
		$data['content']='masters/user/add_user';
		$data['title'] = $this->lang->line('add_user_title');
		$this->load->view('templates/master', $data);
	}

	public function add_post()
	{
		if($this->input->method(TRUE) == 'POST') {
			$user[U_ID] = $this->input->post(U_ID, true);
			$user[U_PASSWORD] = $this->input->post(U_PASSWORD, true);
			$user[U_NAME] = $this->input->post(U_NAME, true); 
			$user[U_SHIMEI] = $this->input->post(U_SHIMEI, true);
			$user[U_BASE_CODE] = $this->input->post(U_BASE_CODE, true);
			$user[U_POSITION] = $this->input->post(U_POSITION, true);
			$user[U_EXTENSION_NUMBER] = $this->input->post(U_EXTENSION_NUMBER, true);
			$user[U_COMPANY_DIRECT_LINE_TEL] = $this->input->post(U_COMPANY_DIRECT_LINE_TEL, true);
			$user[U_USER_GROUP] = $this->input->post('gr');
			$confirm_password = $this->input->post('confirm-password');

			if(empty($user[U_ID]) or empty($user[U_PASSWORD])) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("invalid_user_registration")
				));
				return;
			} else {
				$existedUser = $this->User->getById($user[U_ID]);
				if($existedUser) { //already existed
					echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("user_existed")
					));
					return;
				} else {
					if($user[U_PASSWORD] != $confirm_password) { //confirm password
						echo json_encode(array(
							"success" => false,
							"message" => $this->lang->line("password-not-match-confirm")
						));
						return;
					}

					//hash password
					$user[U_PASSWORD] = password_hash($user[U_PASSWORD], PASSWORD_DEFAULT);
					
					if($this->input->post('gr')){
						$user[U_USER_GROUP] = json_encode($this->input->post('gr'));
					}

					$this->load->model('User');
					$this->User->add($user);

					// LOG ADD
					logadd(U_ID . ":".$user[U_ID], USER_MASTER);

					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("added_successfully")
					));
					return;
				}
			}
		}
		echo json_encode(array(
			"success" => false,
			"message" => $this->lang->line("message_add_error")
		));
		return;
	}

	public function isUserExisted(){
		$result['result'] = 0;
		$userId = $this->postValueWithDefault('id');
		if($userId) {
			$user = $this->User->getById($userId);
			$result['result'] = $user? 1 : 0;
		}
		echo json_encode($result);
	}


	public function edit_post()
	{
		if($this->input->method(TRUE) == 'POST') {
			$id = $this->postValueWithDefault('username', true);
			$user[U_PASSWORD] = $this->postValueWithDefault(U_PASSWORD, true, '');
			$user[U_NAME] = $this->postValueWithDefault(U_NAME, true, '');
			$user[U_SHIMEI] = $this->postValueWithDefault(U_SHIMEI, true, '');
			$user[U_BASE_CODE] = $this->postValueWithDefault(U_BASE_CODE, true, '');
			$user[U_POSITION] = $this->postValueWithDefault(U_POSITION, true, '');
			$user[U_EXTENSION_NUMBER] = $this->postValueWithDefault(U_EXTENSION_NUMBER, true, '');
			$user[U_COMPANY_DIRECT_LINE_TEL] = $this->postValueWithDefault(U_COMPANY_DIRECT_LINE_TEL, true, '');
			$confirm_password = $this->input->post('confirm-password');

			if(empty($id)) {
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("user_not_found")
				));
				return;
			} else {
				$data_log_edit["data_old"]=$this->User->getById($id);

				//hash password
				if(empty($user[U_PASSWORD])){
					unset($user[U_PASSWORD]);
				}else{
					if($user[U_PASSWORD] != $confirm_password) { //confirm password
						echo json_encode(array(
							"success" => false,
							"message" => $this->lang->line("password-not-match-confirm")
						));
						return;
					}
					$user[U_PASSWORD] = password_hash($user[U_PASSWORD], PASSWORD_DEFAULT);
				}
				
				if($this->LOGIN_INFO[U_ID] != $id) {
					if($this->input->post('gr')){
						$user[U_USER_GROUP] = json_encode($this->input->post('gr'));
					} else {
						$user[U_USER_GROUP] = json_encode([]);
					}
				}
				//$user[U_USER_GROUP] = json_encode($user[U_USER_GROUP]);
				$this->User->edit($id, $user);

				// Log Edit
				$arr_where[U_ID] = $id;
				$data_log_edit["id"]=$arr_where;
				$data_log_edit["data_new"]=$user;
				logedit($data_log_edit, USER_MASTER);

				echo json_encode(array(
					"success" => true,
					"message" => $this->lang->line("updated_successfully")
				));
				return;
			}
		}
		
		echo json_encode(array(
			"success" => false,
			"message" => $this->lang->line("message_edit_error")
		));
		return;
	}

	/**
    * Function: delete_post
    * @access public
    */
    public function delete_post(){ 

        if($this->input->server("REQUEST_METHOD") == "POST"){
            $id = $this->input->post('id');

			try{
				if($this->LOGIN_INFO[U_ID] != $id) {
					$this->User->db->trans_begin();

					// Meta
					$arr_where[U_ID] = $id;
					$this->User->removeByWhere($arr_where);

					// End Query
					if ($this->User->db->trans_status() === FALSE)
					{
						$this->User->db->trans_rollback();
						echo json_encode(array(
							"success" => false,
							"message" => $this->lang->line("message_delete_error")
						));
						return;
					}
					else
					{
						// LOG DELETE
						logdelete(U_ID . ":".$id, USER_MASTER);

						$this->User->db->trans_commit();
						echo json_encode(array(
							"success" => true,
							"message" => $this->lang->line("message_delete_success")
						));
						return;
					}
				}

			}catch(Exception $ex){
				$this->User->db->trans_rollback();
				echo json_encode(array(
					"success" => false,
					"message" => $this->lang->line("message_delete_error")
				));
				return; 
			}
		}
	}

	/**
    * Function: export
    * @access public
    */
	public function export(){
		$title = $this->lang->line('user_list');

		// Data
        $result = $this->User->getAll(); 
		
		// Column name
		$column_title = array(U_ID,U_PASSWORD,U_NAME,U_SHIMEI,U_BASE_CODE,U_POSITION,U_EXTENSION_NUMBER,U_COMPANY_DIRECT_LINE_TEL,U_USER_GROUP,U_UPDATE_DATE);
		$column_show_data = array(U_ID,"",U_NAME,U_SHIMEI,U_BASE_CODE,U_POSITION,U_EXTENSION_NUMBER,U_COMPANY_DIRECT_LINE_TEL,U_USER_GROUP,U_UPDATE_DATE);

        $this->ImportExportCsv->export($title, $column_title, $column_show_data,$result);  
	}  
	
	/**
	* Function: export
    * @access public
    */
	public function import(){
		$title = $this->lang->line('user_list');
		$filename = $_FILES["import_file"]["tmp_name"];
		$target_file = $_FILES["import_file"]["name"];

		// Import Csv
		$is_import = false;
		$error_line = 0;
		$sheetData = $this->ImportExportCsv->import($filename);
		if(empty($sheetData)) {
            echo json_encode(array(
                "success" => false,
                "message" => $this->lang->line("message_import_error")
            ));
            return;
		}
		
		try{
			$this->User->db->trans_begin();

			foreach ($sheetData as $key => $value) {
				$data = array();
				$data[U_ID] = (isset($value['A']) ? $value['A'] : null);

				if(!$this->User->checkDataNumber($data)){
                    $error_line = $key+1;
                    break;
				}
				
				$data[U_PASSWORD] = (isset($value['B']) ? password_hash($value['B'], PASSWORD_DEFAULT) : null);
				$data[U_NAME] = (isset($value['C']) ? $value['C'] : null);
				$data[U_SHIMEI] = (isset($value['D']) ? $value['D'] : null);
				$data[U_BASE_CODE] = (isset($value['E']) ? $value['E'] : null);
				$data[U_POSITION] = (isset($value['F']) ? $value['F'] : null);
				$data[U_EXTENSION_NUMBER] = (isset($value['G']) ? $value['G'] : null);
				$data[U_COMPANY_DIRECT_LINE_TEL] = (isset($value['H']) ? $value['H'] : null);
				$data[U_USER_GROUP] = (isset($value['I']) ? $value['I'] : null);
				$data[U_UPDATE_DATE] = (isset($value['J']) ? $value['J'] : null);

				$where_dup[U_ID] = $value['A'];
                $this->User->removeByWhere($where_dup);

				$result = $this->User->add($data);
				if ($this->User->db->trans_status() === FALSE){
                    $error_line = $key+1;
                    break;
                }
										
			}
			if ($this->User->db->trans_status() === FALSE || $error_line != 0)
			{
				$this->User->db->trans_rollback();
				$is_import = false;
			}
			else
			{
				$this->User->db->trans_commit();
				logupcsv($target_file . " (".count($sheetData)." records)", USER_MASTER);
				$is_import = true;
			}           

		}catch(Exception $ex){
			$this->User->db->trans_rollback();
			$is_import = false;
		}

		if($is_import == true) {
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_import_success")
			));
			return;
		}
		echo json_encode(array(
			"success" => false,
			"message" => $this->lang->line("message_import_error"). " => ".$error_line." 行目のエラー"
		));
		return;
    }

    public function get_user_type(){
    	$username = $this->input->get('username');
    	$user = $this->User->getUserType($username);
    	if($user == null){
    		echo 0;
    	}else{
    		echo $user[BM_MASTER_CHECK];
    	}
    	return;
    }

}