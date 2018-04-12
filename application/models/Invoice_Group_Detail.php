<?php
/**
* 
*/
class Invoice_Group_Detail extends VV_Model
{
	function __construct()
	{
		parent::__construct();
		 
		$this->table_name = INVOICE_GROUP_DETAIL;
	}

	public function get_invoice_group_by_customer($customer_id)
	{
		$join = INVOICE_GROUP_DETAIL.'.'.IGD_ID_INVOICE_GROUP.'='.INVOICE_GROUP.'.'.IG_ID;
		$this->db->select('*');
		$this->db->from(INVOICE_GROUP_DETAIL);
		$this->db->join(INVOICE_GROUP,$join,'left');
		$this->db->where(INVOICE_GROUP_DETAIL.'.'.IGD_ID_DEPARTMENT_CUSTOMER,$customer_id);
		$invoice_group = $this->db->get();
		return $invoice_group->result()[0];
	}

	//lấy danh sách nhóm invoice theo customer id và list department id
	public function get_invoice_group_by_customer_department($customer_id,$department_id_list)
	{
		$this->db->select('DISTINCT('.INVOICE_GROUP.'.`'.IG_ID.'`),'.INVOICE_GROUP.'.*');
		$this->db->from(INVOICE_GROUP_DETAIL);
		$this->db->join(CUSTOMER_DEPARTMENT,INVOICE_GROUP_DETAIL.'.`'.IGD_ID_DEPARTMENT_CUSTOMER.'`='.CUSTOMER_DEPARTMENT.'.`'.CUS_DE_ID.'`','left');
		$this->db->join(INVOICE_GROUP,INVOICE_GROUP_DETAIL.'.`'.IGD_ID_INVOICE_GROUP.'`='.INVOICE_GROUP.'.`'.IG_ID.'`','left');
		$this->db->where(CUSTOMER_DEPARTMENT.'.`'.CD_CUSTOMER_ID.'`',$customer_id);
		foreach ($department_id_list as $department_id) {
			$this->db->or_where(CUSTOMER_DEPARTMENT.'.`'.CD_DEPARTMENT_CODE.'`',$department_id,false);
		}
		$list_invoice_group = $this->db->get();
		return $list_invoice_group->result();
	}

	public function get_by_invoice($invoice_id){
		/*$this->db->select(INVOICE_GROUP_DETAIL.".*,".CUS_CUSTOMER_NAME.",".DL_DEPARTMENT_NAME.",".CD_DEPARTMENT_CODE);
		$this->db->join("view_customer_department","`view_customer_department`.`".CUS_DE_ID."`=`".INVOICE_GROUP_DETAIL."`.`".IGD_ID_DEPARTMENT_CUSTOMER."`");
		$this->db->where(
			array(IGD_ID_INVOICE_GROUP => $invoice_id)
		);
		$this->db->get($this->table_name)->result_array();*/
		$query = "sELECT ".INVOICE_GROUP_DETAIL.".*,".CUS_CUSTOMER_NAME.",".DL_DEPARTMENT_NAME.",".CD_DEPARTMENT_CODE." FROM `".INVOICE_GROUP_DETAIL."` JOIN `view_customer_department` ON `view_customer_department`.`".CUS_DE_ID."`=`".INVOICE_GROUP_DETAIL."`.`".IGD_ID_DEPARTMENT_CUSTOMER."` WHERE `".IGD_ID_INVOICE_GROUP."` = '$invoice_id'";
		return $this->getQuery($query);
	}

	public function remove_by_invoice($invoice_id){
		$this->db->where(
			array(IGD_ID_INVOICE_GROUP => $invoice_id)
		);
		$this->db->delete($this->table_name);
	}

	public function getAvaiable(){
		$this->db->select(INVOICE_GROUP_DETAIL.".*");
		$this->db->join(INVOICE_GROUP,"`".INVOICE_GROUP."`.`".IG_ID."`=".INVOICE_GROUP_DETAIL.".".IGD_ID_INVOICE_GROUP);
		return $this->db->get(INVOICE_GROUP_DETAIL)->result_array();
	}
}