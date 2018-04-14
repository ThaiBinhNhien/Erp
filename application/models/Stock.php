<?php
class Stock extends VV_Model
{
	
	function __construct()
	{
		parent::__construct(); 
		$this->table_name = T_STOCK_PLACE;
		$this->idCol = TSP_ID;
		 
	}

	public function get_all(){
		$stock = $this->db->get(T_STOCK_PLACE);
		return $stock->result();
	}

	public function get_total_stock_product($product_id,$stock_id)
	{
		$query = "select sum(`".S_STOCK_QUANTITY."`) as amount "
		." from `".STOCK."` "
		." where `".S_PRODUCT_ID."` = ".$product_id." "
		." and `".S_INVENTORY_LOCATION_ID."` = ".$stock_id;
		$stocks = $this->db->query($query);
		return $stocks->result()[0]->amount+0;
	}

	//lấy số lượng hàng còn trong kho
	public function get_total_stock_product_2($product_id,$stock_id)
	{
		$total = 0;
		/*$this->db->where(TGRI_GOODS_RECEIPT_SLIP_ID." is not null ");
		$this->db->where(TGRI_PRODUCT_ID,$product_id);
		$this->db->where(TGRI_CUMULATIVE_GOODS_RECEIPT." > ".TGRI_NUMBER_HAS_EXPORT);
		$this->db->where(TGRI_PROCESSING_CONTENT.' !=',2);
		$this->db->where(TGRI_BASE_CODE,$stock_id);*/
		$query = "select sum(`".TGRI_CUMULATIVE_GOODS_RECEIPT."` - `".TGRI_NUMBER_HAS_EXPORT."`) as amount from ".T_GOODS_RECEIPT_INFORMATION
		." where `".TGRI_GOODS_RECEIPT_SLIP_ID."` is not null "
		." and `".TGRI_PRODUCT_ID."` = ".$product_id." "
		." and `".TGRI_CUMULATIVE_GOODS_RECEIPT."` > `".TGRI_NUMBER_HAS_EXPORT."` "
		." and `".TGRI_PROCESSING_CONTENT."` <> 2 "
		." and `".TGRI_BASE_CODE."` = ".$stock_id.";";
		$product_list = $this->db->query($query);
		/*foreach ($product_list->result() as $product) {
			$total += (int)$product->{TGRI_CUMULATIVE_GOODS_RECEIPT} - (int)$product->{TGRI_NUMBER_HAS_EXPORT};
		}*/
		return $product_list->result();
	}

	public function get_by_id($stock_id)
	{
		$this->db->where(TSP_ID,$stock_id);
		$stock = $this->db->get(T_STOCK_PLACE);
		if(empty($stock->result())) return null;
		return $stock->result()[0];
	}

	/*
	$data['stock_id']:id kho
	$data['product_id_list']:danh sách id sản phẩm
	$data['number_plus']:số lượng cộng vô, có thể là 'âm' hoặc 'dương'
	*/
	public function update_stock_product($data)
	{
		for($i=0; $i < count($data['product_id_list']); $i++) {
			$this->db->where(S_INVENTORY_LOCATION_ID,$data['stock_id']);
			$this->db->where(S_PRODUCT_ID,$data['product_id_list'][$i]);
			$result = $this->db->get(STOCK);
			if($result->num_rows()>0){
				$this->db->where(S_INVENTORY_LOCATION_ID,$data['stock_id']);
				$this->db->where(S_PRODUCT_ID,$data['product_id_list'][$i]);
				$this->db->set(S_STOCK_QUANTITY, S_STOCK_QUANTITY.'+'.$data['number_plus'][$i].'',FALSE);
				$this->db->update(STOCK);
				
				$this->db->where(S_INVENTORY_LOCATION_ID,$data['stock_id']);
				$this->db->where(S_PRODUCT_ID,$data['product_id_list'][$i]);
				$row = $this->db->get(STOCK)->result();
				if((int)$row[0]->{S_STOCK_QUANTITY} <= 0) 
					$this->db->delete(STOCK,array(S_INVENTORY_LOCATION_ID => $data['stock_id'],
													S_PRODUCT_ID => $data['product_id_list'][$i]
												));
			}else{
				$product = array(
					S_INVENTORY_LOCATION_ID => $data['stock_id'],
					S_PRODUCT_ID => $data['product_id_list'][$i],
					S_STOCK_QUANTITY => $data['number_plus'][$i]
				);
				$this->db->insert(STOCK,$product);
			}
		}
	}

	public function get_info_stock($stock_id)
	{
		$product_id_list = array();
		$amount_list = array();
		//$this->db->where(S_INVENTORY_LOCATION_ID,$stock_id);
		$query = "select * from `".STOCK."` where `".S_INVENTORY_LOCATION_ID."` = ".$stock_id;
		$product_list = $this->db->query($query)->result();
		foreach ($product_list as $product) {
			$product_id_list[] = $product->{S_PRODUCT_ID};
			$amount_list[] = $product->{S_STOCK_QUANTITY};
		}
		return array(
			'product_id_list' => $product_id_list,
			'amount_list' => $amount_list
		);
	}

	public function get_list_product_by_stock($stock_id)
	{
		$this->db->select('*');
		$this->db->from(STOCK);
		$this->db->join(PRODUCT_LEDGER,STOCK.'.`'.S_PRODUCT_ID.'`='.PRODUCT_LEDGER.'.`'.PL_PRODUCT_ID.'`','left');
		$this->db->where(STOCK.'.`'.S_INVENTORY_LOCATION_ID.'`',$stock_id);
		$product_list = $this->db->get();
		return $product_list->result();
	}
}