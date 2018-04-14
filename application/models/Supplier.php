<?php

class Supplier extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_SUPPLIER;
		$this->idCol = SUP_ID;
		 
	}

	public function get_all()
	{
		$this->db->from($this->table_name);
		$this->db->order_by(SUP_ID,'asc');
		$result = $this->db->get();
		return $result->result();
	}

	//lấy danh sách nơi mua vào sort theo số lần sử dụng
	public function get_all_by_number_use()
	{
		$query = "SELECT ".T_SUPPLIER.".*, (SELECT COUNT(distinct ".TO_ID.") FROM "
		.T_ORDER." "
		." where ".T_SUPPLIER.".`".SUP_ID."`=".T_ORDER.".`".TO_VENDOR_ID."` "
		." and ".T_ORDER.".`".TO_EMPLOYEE_ID."` = '".$_SESSION['login-info'][U_ID]."' "
		."and ".T_ORDER.".`".TO_ORDER_DATE."`>DATE_FORMAT(LAST_DAY(NOW() - INTERVAL ".EXP_USABILITY." MONTH), '%Y-%m-%d 23:59:59')) "
		."as count_use "
		." from ".T_SUPPLIER." "
		." order by count_use DESC ";
		$list_supplier = $this->db->query($query)->result();
		
		return $list_supplier;
	}

	public function get_list_product_in_supplier($supplier_id)
	{
		$this->db->select('*');
		$this->db->from(T_PRODUCT_NUMBER_FOR_SUPPLIER);
		$this->db->join(T_SUPPLIER,T_PRODUCT_NUMBER_FOR_SUPPLIER.'.`'.TPNS_VENDOR_ID.'`='.T_SUPPLIER.'.`'.SUP_ID.'`','left');
		$this->db->join(PRODUCT_LEDGER,T_PRODUCT_NUMBER_FOR_SUPPLIER.'.`'.TPNS_ID_PRODUCT.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`','left');
		$this->db->where(T_PRODUCT_NUMBER_FOR_SUPPLIER.'.`'.TPNS_VENDOR_ID.'`',$supplier_id);
		$list_product = $this->db->get();
		return $list_product->result();
	}

	public function get_by_id($supplier_id)
	{
		$this->db->select('*');
		$this->db->from(T_SUPPLIER);
		$this->db->where(SUP_ID,$supplier_id);
		$supplier = $this->db->get();
		if(count($supplier->result())==0) return null;
		return $supplier->result()[0];
	}

	public function search_supplier($data , $start_index = NULL,$number = NULL,$supplier_by =NULL ,$supplier_type = NULL)
	{
		$this->db->select('s.'.SUP_ID .' as supplier_id, s.'. SUP_SUPPLIER_COMPANY_NAME . ' as sup_company_name ,  s.'. SUP_POSTAL_CODE . ' as sup_postal_code ,  s.'. SUP_FAX_NUMBER . ' as sup_fax_number ,  s.'. SUP_ADDRESS_1 . ' as sup_address_1 ,  s.'. SUP_ADDRESS_2 . ' as sup_address_2');
		$this->db->from(T_SUPPLIER .' as s');

		if(!empty($data['sup_id'])) $this->db->where(SUP_ID,$data['sup_id']);
		if(!empty($data['sup_company_name'])) $this->db->like(SUP_SUPPLIER_COMPANY_NAME,$data['sup_company_name'], 'both');
		if(!empty($data['sup_phone_number'])) $this->db->like(SUP_PHONE_NUMBER,$data['sup_phone_number'], 'both');
		if(!empty($data['sup_fax_number'])) $this->db->like(SUP_FAX_NUMBER,$data['sup_fax_number'],'both');

		$address  = $data['sup_address'];
		if($address != NULL && $address != ""){
			$this->db->where("(".SUP_ADDRESS_1." LIKE '%$address%' OR ".SUP_ADDRESS_2." LIKE '%$address%')");
		}
		if(!empty($data['sup_fax_number'])) $this->db->like(SUP_FAX_NUMBER,$data['sup_fax_number'], 'both'); 
		
		if(!empty($data['sup_postal_code'])) $this->db->like(SUP_POSTAL_CODE,$data['sup_postal_code'], 'both'); 
		//temp : SUP_USER_ID -> SUP_CONTACT_NAME
		if(!empty($data['sup_contact_name'])) $this->db->where(SUP_USER_ID,$data['sup_contact_name']);

		if($supplier_by != NULL && $supplier_type != NULL){
			$this->db->order_by($supplier_by, $supplier_type);
		}
		
		if($start_index !== NULL && $number !== NULL){
			$this->db->limit($number,$start_index );
		}
		
		$supplier = $this->db->get();
		return $supplier->result();
	}

}