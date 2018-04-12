<?php
/**
* 
*/
class DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		 
	}
	public function get_all(){
		$query = $this->db->get(T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY);
		return $query->result();
	}

	//lấy danh sách sản phẩm theo id nơi bán hàng
	public function get_product_with_des($id)
	{
		$this->db->select('*');
		$this->db->from(T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY);
		$this->db->join(T_SALES_DESTINATION,T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY.'.`'.TPCT_SALEROOM.'`='.T_SALES_DESTINATION.'.`'.TSD_ID.'`','left');
		$this->db->join(PRODUCT_LEDGER,T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY.'.`'.TPCT_PRODUCT_ID.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`','left');
		$this->db->where(T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY.'.`'.TPCT_SALEROOM.'`',$id);
		$this->db->where(T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY.'.`'.TPCT_PRODUCT_ID.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`');
		$result = $this->db->get();
		return $result->result();
	}

	/**
	* lấy đơn giá
	* $product_id : id sản phẩm
	* $des_id : nơi bán
	*/
	public function get_price($product_id,$des_id)
	{
		$this->db->where(TPCT_PRODUCT_ID,$product_id);
		$this->db->where(TPCT_SALEROOM,$des_id);
		$prices = $this->db->get(T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY);
		$total_price = 0;
		foreach ($prices->result() as $price) {
			$total_price += $price->{TPCT_UNIT_SELLING_PRICE};
		}
		return $total_price;
	}
}