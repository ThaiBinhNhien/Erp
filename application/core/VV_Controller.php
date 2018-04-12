<?php
/**
* Root controller, others must inherited from this class
*/
class VV_Controller extends CI_Controller
{
	protected $primaryModel;

	const LOGIN_URI = 'login';

	public function __construct()
	{
		parent::__construct();

		$uri = uri_string();
		if($uri != self::LOGIN_URI) {
			//Check if logged in or not
			if(!self::logged()) {
				redirect(self::LOGIN_URI);
			}

			if(!self::checkPrivilege()){
				redirect('access-denied');
			}
		}

	}

	/*  
	* Create new record
	*/
	public function create()
	{
		$data = $this->input->post(null, true);

		$id = $this->{$primaryModel}->add($data);
		return $id;
	}

	/*
	* Update a record
	*/
	public function edit()
	{
		$data = $this->input->post(null, true);
		$id = $this->input->get('id', true);

		$result = $this->{$primaryModel}->edit($id, $data);

		return $result;
	}

	/*
	* Delete a row
	*/
	public function delete()
	{
		$id = $this->input->get('id', true);

		$result = $this->{$primaryModel}->remove($id);

		return $result;
	}

	/*
	* Get an instance by it id
	*/
	public function get()
	{
		$id = $this->input->get('id', true);
		if($id){
			return $this->{$primaryModel}->getById($id);
		} else {
			return null;
		}
	}

	/*
	* Get all instances
	*/
	public function getAll()
	{
		return $this->{$primaryModel}->getAll();
	}

	/*
	* Get all instances
	*/
	public function getAllWithoutDeleted()
	{
		return $this->{$primaryModel}->getWhere(array('is_deleted' => 0));
	}


	/*
	* kiem tra quyen han truoc khi vao thuc thi yeu cau
	* @return boolean
	*/
	private function checkPrivilege() {
		//check if current url need to check role or not.
		$uri = uri_string();

		$uriRole = $this->config->item('roleOf');

		if(isset($uriRole[$uri])){
			$uriRole = $uriRole[$uri];
			//Get user from session
			$userRoles = json_decode(html_entity_decode($this->session->userdata('login-info')[U_USER_GROUP]), true);
			$level = '';
			$allow = false;

			if($userRoles != null) {
				foreach($userRoles as $role) {
					if(isset($uriRole[$role])) {
						$allow = true;

						//if one of roles' level is F, the level will be F.
						$level = (empty($level) OR $level == 'P')? $uriRole[$role] : $level;
					}
				}
			}

			//set level for current request
			$this->session->set_userdata('request-level', $level);
			return $allow;
		}

		return true;
	}

	/*
	* Check if user logged or not
	*/
	protected function logged(){
		return $this->session->has_userdata('login-info');
	}

	/**
	* Get post value. if it is null, return default.
	*/
	protected function postValueWithDefault($key, $useXss=true, $default = null) {
		$value = $this->input->post($key, $useXss);
		return $value == null? $default : $value;
	}

	/**
	* Get post value. if it is null, return default.
	*/
	protected function getValueInt($key) {
		return (!empty($key)) ? $key : null;
	}

	/* kiểm tra group in user */
	public function checkIsGroupRole($group_role){
		$loginInfo = $this->session->userdata('login-info');
		if($loginInfo != null) {
			$userRoles = json_decode(html_entity_decode($loginInfo[U_USER_GROUP]), true);
			if(in_array($group_role, $userRoles)){
				return true;
			}
			else{
				return false;
			}
		}
		else {
			return false;
		}
	}

	/**
	* Role for Home
	* @param $group
	1 : order
	2 : sales
	3 : shipment
	4 : buy
	*/
	public function checkIsRoleHome($group){
		$loginInfo = $this->session->userdata('login-info');
		$groupRole = $this->config->item('roleOfHome')[$group];

		if($loginInfo != null && $groupRole != null) {
			$userRoles = json_decode(html_entity_decode($loginInfo[U_USER_GROUP]), true);
			
			$allow = false;
			
			foreach($userRoles as $role) {
				if(isset($groupRole[$role])) {
					$allow = true;
				}
			}

			return $allow;

		}
		else {
			return false;
		}
	}
}