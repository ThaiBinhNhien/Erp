<?php
/**
* Basic model, contains basic methods. Other models must extends this.
*/
class VV_Model extends CI_Model
{
	protected $table_name;
	protected $idCol;
	protected $valueDateUpdate; // ngày cập nhật

	/*
	* Var $keepDeleted
	* Decide if a model really delete data from database or just update is_deleted
	*/
	protected $keepDeleted;

	function __construct()
	{
		parent::__construct();
		$this->keepDeleted = false;
		$this->level = $this->session->userdata('request-level');
		$this->LOGIN_INFO = $this->session->userdata('login-info');
	}

	public function __set($property, $value) {
		$this->{$property} = $value;
	}

	/*public function __get($property)
	{
		return $this->{$property};
	}*/


	/**
	* Function add
	* Add new record to database
	* @param array $information new record information
	* @return id new record
	* @access public
	*/
	public function add($information,$table=NULL)
	{	
		// check empty
		$information = array_map(function($value) {
		   return $value === "" ? NULL : $value;
		}, $information);
		foreach ($information as $key => $value) {
			$information[$key] = html_escape($value);
		}
		// table
		if($table == NULL)
			$table = $this->table_name;
		$this->db->insert($table, $information);
		
		return $this->db->insert_id();
	}
	
		/**
	* Function added
	* Add new record to database
	* @param array $information new record information
	* @return true/false
	* @access public
	*/
	public function added($information,$table=NULL)
	{

		if($table == NULL)
			$table = $this->table_name;

		$information = array_map(function($value) {
		   return $value === "" ? NULL : $value;
		}, $information);
		
		foreach ($information as $key => $value) {
			$information[$key] = html_escape($value);
		}
		return $this->db->insert($table, $information);
	}

	/**
	* Function add
	* Add new record to database
	* @param array $data new record information
	* @return id new record
	* @access public
	*/
	public function add_batch($data,$table=NULL)
	{
		if($table == NULL)
			$table = $this->table_name;
		return $this->db->insert_batch($table, $information);
	}

	/**
	* Function edit
	* Update information of an object by its ID
	* @param int $id the object ID
	* @param array $information object information
	* @return boolean
	* @access public
	*/
	public function edit($id, $information,$table=NULL) 
	{
		if($table == NULL)
			$table = $this->table_name;

		$information = array_map(function($value) {
		   return $value === "" ? NULL : $value;
		}, $information);

		foreach ($information as $key => $value) {
			$information[$key] = html_escape($value);
		}
		$this->db->where($this->idCol, $id);
		$this->db->update($table, $information);
		return $this->db->affected_rows() !== false;
	}

	/**
	* Function edit
	* Update information of an object by its ID
	* @param int $id the object ID
	* @param array $information object information
	* @return boolean
	* @access public
	*/
	public function editByWhere($whereClause, $information,$table=NULL)
	{
		if($table == NULL)
			$table = $this->table_name;
		foreach ($information as $key => $value) {
			$information[$key] = html_escape($value);
		}
		$this->db->where($whereClause);
		$this->db->update($table, $information);
		return $this->db->affected_rows() !== false;
	}

	/**
	* Function remove
	* Delete object
	* @param int $id the object ID
	* @return boolean
	* @access public
	*/
	public function remove($id,$table=NULL) 
	{
		if($table == NULL)
			$table = $this->table_name;
		$this->db->where($this->idCol, $id);
		
		if($this->keepDeleted) {
			$this->db->update($table, array('is_deleted', 1));
		} else {
			$this->db->delete($table);
		}
		return $this->db->affected_rows() > 0;
	}

	/**
	* Function emptyTable
	* Delete object
	* @param int $id the object ID
	* @return boolean
	* @access public
	*/
	public function emptyTable($table=NULL) 
	{
		if($table == NULL)
			$table = $this->table_name;
		
		$this->db->empty_table($table);

		return $this->db->affected_rows() > 0;
	}

	/**
	* Function remove
	* Delete object
	* @param int $id the object ID
	* @return boolean
	* @access public
	*/
	public function removeByWhere($whereClause)
	{
		$this->db->where($whereClause);
		
		if($this->keepDeleted) {
			$this->db->update($this->table_name, array('is_deleted', 1));
		} else {
			$this->db->delete($this->table_name);
		}
		return $this->db->affected_rows() > 0;
	}


	/**
	* Function getById
	* Get an object information by its ID
	* @param int $id the object ID
	* @return array of object information
	* @access public
	*/
	public function getById($id)
	{
		$this->db->where("CAST(`".$this->idCol."` AS  CHAR(512))='".$id."'");
		if(isset($this->colAuth) && !empty($this->colAuth) && isset($this->valAuth) && !empty($this->valAuth) && $this->level == "P"){
			$this->db->where(array($this->colAuth => $this->valAuth));
		}
		$data = $this->db->get($this->table_name)->result_array();
		return end($data);
	}

	/**
	* Function getAll
	* Get all object
	* @param 
	* @return array of object information
	* @access public
	*/
	public function getAll($start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{

		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		} else {
			// Default
			if($this->idCol !== NULL)
				$this->db->order_by($this->idCol, SORT_MASTER);
		}
		if(isset($this->colAuth) && !empty($this->colAuth) && isset($this->valAuth) && !empty($this->valAuth) && $this->level == "P"){
			$this->db->where(array($this->colAuth => $this->valAuth));
		}
		$query = $this->db->get($this->table_name);

		$data = array();
		if($query !== FALSE && $query->num_rows() > 0){
			$data = $query->result_array();
		}

		return $data;
	}

	/**
	* Function getById
	* Get an object information by its ID
	* @param array $conditons. Default value is false, means get all rows.
	* @return array of object information
	* @access public
	*/
	public function getWhere($conditions = false,$start_index = NULL,$number = NULL,$order_by = NULL,$order_type = NULL)
	{
		if($conditions) {
			$this->db->where($conditions);
		}
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index);
		}

		if($order_by !== NULL && $order_type !== NULL){
			$this->db->order_by($order_by,$order_type);
		}
		return $this->db->get($this->table_name)->result_array();
	}

	/**
	* Function getById
	* Get an object information by its ID
	* @param sql query.
	* @return array of object information
	* @access public
	*/
	public function getQuery($query = NULL,$start_index = NULL,$number = NULL, $binds = NULL)
	{
		if($start_index !== NULL && $number !== NULL){
			$query .= " LIMIT $start_index,$number";
		}
		
		return $this->db->query($query,$binds)->result_array();
	}

	/**
	* Function isExitsRow
	* @return array true or false
	* @access public
	*/
	public function isExitsRow($column = NULL,$value = NULL)
	{
		if($column !== NULL && $value !== NULL){
			$this->db->where($column, $value);
			$data = $this->db->get($this->table_name)->result_array();
			if($data) {
				return true;
			}
		}
		return false;
	}


	/**
	* Function checkDataNumber
	* @return array true or false
	* @access public
	*/
	public function checkDataNumber($arrData  = NULL)
	{
		if($arrData !== NULL){
			foreach ($arrData as $value){
				if($value != null ||   $value != ""){
					if(!is_numeric($value)){
						return false;
					}
				}
				
			}
			return true;
		}
		return false;
	}

	/**
	* Function isCheckUpdated
	* Kiểm tra xem dữ liệu đó đã được update trong quá trình mình mở xem chưa
	* @return array true or false
	* @access public
	*/
	public function isCheckDataUpdated($id, $date, $table=NULL) 
	{
		if($table == NULL)
			$table = $this->table_name;

		if($id !== NULL && $date !== NULL){
			if($this->idCol !== NULL && $this->valueDateUpdate !== NULL) {
				$this->db->where($this->idCol, $id);
				$this->db->where($this->valueDateUpdate, $date);
				$data = $this->db->get($this->table_name)->result_array();
				if($data) {
					return true;
				}
			}
		}
		return false;

	}
}