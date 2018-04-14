<?php
/**
* 
*/
class Sales_Destination extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_SALES_DESTINATION;
		$this->idCol = TSD_ID;
		  
	}
	public function get_all()
	{
		$query = "SELECT ".T_SALES_DESTINATION.".*, (SELECT COUNT(*) FROM "
		.T_ISSUE." "
		." where ".T_SALES_DESTINATION.".`".TSD_ID."`=".T_ISSUE.".`".SHIP_DISTRIBUTOR_ID."` "
		." and ".T_ISSUE.".`".SHIP_EMPLOYEE_ID."` = '".$_SESSION['login-info'][U_ID]."' "
		."and ".T_ISSUE.".`".SHIP_SHIP_DATE."`>DATE_FORMAT(LAST_DAY(NOW() - INTERVAL ".EXP_USABILITY." MONTH), '%Y-%m-%d 23:59:59')) "
		."as count_use "
		." from ".T_SALES_DESTINATION." "
		." order by count_use DESC ";
		$list_sale_des = $this->db->query($query)->result();
		return $list_sale_des;
	}
	public function get_by_id($id)
	{
		$this->db->where(TSD_ID,$id);
		$sales_des = $this->db->get(T_SALES_DESTINATION);
		if(!isset($sales_des->result()[0])) return null;
		return $sales_des->result()[0];
	}
	
	public function search($data , $start_index = NULL,$number = NULL,$column_by =NULL ,$column_type = NULL)
	{
		$this->db->select('s.'.TSD_ID .' as id, s.'. TSD_DISTRIBUTOR_NAME . ' as distributor_name ,  s.'. TSD_POSTAL_CODE . ' as postal_code ,  s.'. TSD_ADDRESS_1 . ' as address_1 ,  s.'. TSD_ADDRESS_2 . ' as address_2 ,  s.'. TSD_PHONE_NUMBER . ' as phone_number');
		$this->db->from(T_SALES_DESTINATION .' as s');

		if(!empty($data['distributor_id'])) $this->db->where(TSD_ID,$data['distributor_id']);
		if(!empty($data['distributor_name'])) $this->db->like(TSD_DISTRIBUTOR_NAME,$data['distributor_name'], 'both');
		if(!empty($data['postal_code'])) $this->db->like(TSD_POSTAL_CODE,$data['postal_code']);
		if(!empty($data['phone_number'])) $this->db->like(TSD_PHONE_NUMBER,$data['phone_number'], 'both');
		if(!empty($data['fax_number'])) $this->db->like(TSD_FAX_NUMBER,$data['fax_number'],'both');

		$address  = $data['address'];
		if($address != NULL && $address != ""){
			$this->db->where("(".TSD_ADDRESS_1." LIKE '%$address%' OR ".TSD_ADDRESS_2." LIKE '%$address%')");
		}
		
		if($column_by != NULL && $column_type != NULL){
			$this->db->order_by($column_by, $column_type);
		}
		$this->db->limit($number,$start_index);
		$sale_des = $this->db->get();
		return $sale_des->result();
	}
}