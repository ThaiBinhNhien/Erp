<?php

class Delivery_Detail extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DELIVERY_DETAIL;
	}

	public function getByDeliveryId($delivery_id){
		$data = array( 'delivery_id' => $order_id );
		return $this->getWhere($data);
	}
	
	public function getByOrderId($order_id){
		$sql = "SELECt dd.*,T.order_quantity,od.product_id,od.product_name,od.standard,od.color,od.package_size ";
		$sql .= "FROM `order` o LEFT JOIN `order_detail` od ON o.id=od.order_id ";
		$sql .= "RIGHT JOIN `delivery_detail` dd ON od.id=dd.order_detail_id ";
		$sql .= "LEFT JOIN (SELECT order_detail_id,SUM(quantity) AS order_quantity FROM `order_detail_floor` GROUP BY order_detail_id) T ";
		$sql .= "ON T.order_detail_id=od.id";
		return $this->getQuery($sql);
	}

	//lấy tổng số lượng sản phẩm có trong hóa đơn giao hàng
	public function get_amount_product($delivery_id)
	{
		$amount = 0;
		$this->db->where(DD_ORDER_ID,$delivery_id);
		$deliveries = $this->db->get(DELIVERY_DETAIL);
		if(count($deliveries->result()) == 0) return 0;
		foreach ($deliveries->result() as $delivery) {
			$amount += $delivery->{DD_QUANTITY};
		}
		return $amount;
	}

	public function get_info_by_order($order_id)
	{
		$this->db->select('*');
		$this->db->from(DELIVERY_DETAIL);
		$this->db->join(SALES_LEDGER,DELIVERY_DETAIL.'.'.DD_ORDER_ID.'='.SALES_LEDGER.'.'.SL_ID,'left');
		$this->db->join(PRODUCT_LEDGER,DELIVERY_DETAIL.'.'.DD_PRODUCT_CODE.'='.PRODUCT_LEDGER.'.'.PL_PRODUCT_ID,'left');
		$this->db->where(DELIVERY_DETAIL.'.'.DD_ORDER_ID,$order_id);
		$order = $this->db->get();
		return $order->result();
	}

	//tìm sản phẩm theo hạng mục loại
	public function get_product_by_category($order_id,$category_id)
	{
		$this->db->select('*');
		$this->db->from(DELIVERY_DETAIL);
		$this->db->join(SALES_LEDGER,DELIVERY_DETAIL.'.'.DD_ORDER_ID.'='.SALES_LEDGER.'.'.SL_ID,'left');
		$this->db->join(PRODUCT_LEDGER,DELIVERY_DETAIL.'.'.DD_PRODUCT_CODE.'='.PRODUCT_LEDGER.'.'.PL_PRODUCT_ID,'left');
		if($category_id==1) $this->db->where(PRODUCT_LEDGER.'.`'.PL_CATEGORIES.'`',$category_id);
		else $this->db->where("(".PRODUCT_LEDGER.'.`'.PL_CATEGORIES.'` <> 1 or '.PRODUCT_LEDGER.'.`'.PL_CATEGORIES."` is null )");
		$this->db->where(DELIVERY_DETAIL.'.'.DD_ORDER_ID,$order_id);
		$order = $this->db->get();
		return $order->result();
	}
	public function pdf_produce_actual_by_cus($date_from,$date_to,$type){
		$this->db->select(CUSTOMER.".".SL_CUSTOMER_ID.",".CUSTOMER.".".CUS_CUSTOMER_NAME.",SUM(IF(".PL_DRY_PRESS_LAUNDRY_CLASSIFICATION."=2,".DD_QUANTITY.",0)) AS dry_quantity,SUM(IF(".PL_DRY_PRESS_LAUNDRY_CLASSIFICATION."=4,".DD_QUANTITY.",0)) AS laundry_quantity,SUM(IF(".PL_DRY_PRESS_LAUNDRY_CLASSIFICATION."=2,(`".DD_QUANTITY."` * `".PL_ORGANIZATION_WEIGHT."`),0)) AS dry_weight,SUM(IF(".PL_DRY_PRESS_LAUNDRY_CLASSIFICATION."=4,(`".DD_QUANTITY."` * `".PL_ORGANIZATION_WEIGHT."`),0)) AS laundry_weight");
		$this->db->join(SALES_LEDGER,SALES_LEDGER.".".SL_ID."=".DELIVERY_DETAIL.".".DD_ORDER_ID);
		$this->db->join(CUSTOMER,CUSTOMER.".".CUS_ID."=".SALES_LEDGER.".".SL_CUSTOMER_ID);
		$this->db->join(PRODUCT_LEDGER,"`".PRODUCT_LEDGER."`.`".PL_PRODUCT_ID."`=".DELIVERY_DETAIL.".".DD_PRODUCT_CODE,"left outer");
		$this->db->where(
			array(
				SL_DELIVERY_DATE." >=" =>$date_from." 00:00:00",
				SL_DELIVERY_DATE." <=" =>$date_to." 23:59:59"
			)
		); 
		if($type != NULL){
			$this->db->where(
				array(
					CUSTOMER.".".CUS_TYPE_CUSTOMER => $type
				)
			);
		}
		if($this->level == 'P'){
			$this->db->where(SL_USER_ID." IN (SELECT ".U_ID." FROM ".USER_MASTER." WHERE ".U_BASE_CODE." = '".$this->LOGIN_INFO[U_BASE_CODE]."')");
		}
		$this->db->group_by(CUSTOMER.".".SL_CUSTOMER_ID.",".CUSTOMER.".".CUS_CUSTOMER_NAME);
		return $this->db->get($this->table_name)->result_array();
	}
	
	public function pdf_produce_actual_by_product($date_from,$date_to){
		/*$this->db->select(CUSTOMER.".".SL_CUSTOMER_ID.",".CUSTOMER.".".CUS_CUSTOMER_NAME.",".PL_STANDARD.",".PL_COLOR_TONE.",SUM(".DD_QUANTITY.") AS quantity,SUM(".DD_QUANTITY."*"..") AS weight");
		$this->db->join(SALES_LEDGER,SALES_LEDGER.".".SL_ID."=".DELIVERY_DETAIL.".".DD_ORDER_ID);
		$this->db->join(CUSTOMER,CUSTOMER.".".CUS_ID."=".SALES_LEDGER.".".SL_CUSTOMER_ID);
		$this->db->join(PRODUCT_LEDGER,"`".PRODUCT_LEDGER."`.`".PL_PRODUCT_ID."`=".DELIVERY_DETAIL.".".DD_PRODUCT_CODE,"left outer");
		$this->db->where(
			array(
				SL_DELIVERY_DATE." >=" =>$date_from." 00:00:00",
				SL_DELIVERY_DATE." <=" =>$date_to." 23:59:59"
			)
		);
		if($type != NULL){
			$this->db->where(
				array(
					CUSTOMER.".".CUS_TYPE_CUSTOMER => $type
				)
			);
		}
		$this->db->group_by(CUSTOMER.".".SL_CUSTOMER_ID.",".CUSTOMER.".".CUS_CUSTOMER_NAME.",".PRODUCT_LEDGER.".".PL_PRODUCT_ID.",".PRODUCT_LEDGER.".".PL_PRODUCT_NAME.",".PL_STANDARD.",".PL_COLOR_TONE);
		return $this->db->get($this->table_name)->result_array();*/
		$query = "sELECT `".CUSTOMER."`.`".SL_CUSTOMER_ID."`, `".CUSTOMER."`.`".CUS_CUSTOMER_NAME."`, `".PL_STANDARD."`, `".PL_COLOR_TONE."`, SUM(".DD_QUANTITY.") AS quantity, SUM(".DD_QUANTITY."*".PL_ORGANIZATION_WEIGHT.") AS weight FROM `".DELIVERY_DETAIL."` JOIN `".SALES_LEDGER."` ON ".SALES_LEDGER.".".SL_ID."=".DELIVERY_DETAIL.".".DD_ORDER_ID." JOIN `".CUSTOMER."` ON ".CUSTOMER.".".CUS_ID."=".SALES_LEDGER.".".SL_CUSTOMER_ID." LEFT OUTER JOIN `".PRODUCT_LEDGER."` ON `".PRODUCT_LEDGER."`.`".PL_PRODUCT_ID."`=".DELIVERY_DETAIL.".".DD_PRODUCT_CODE." WHERE `".SL_DELIVERY_DATE."` >= '$date_from 00:00:00' AND `".SL_DELIVERY_DATE."` <= '$date_to 23:59:59'";
		if($type != NULL){
			$query .= " AND ".CUS_TYPE_CUSTOMER."=$type";
		}
		if($this->level == 'P'){
			$query .= " AND ".SL_USER_ID." IN (SELECT ".U_ID." FROM ".USER_MASTER." WHERE ".U_BASE_CODE." = '".$this->LOGIN_INFO[U_BASE_CODE]."')";
			
		}
		$query .=" GROUP BY `".CUSTOMER."`.`".SL_CUSTOMER_ID."`, `".CUSTOMER."`.`".CUS_CUSTOMER_NAME."`, `".PRODUCT_LEDGER."`.`".PL_PRODUCT_ID."`, `".PRODUCT_LEDGER."`.`".PL_PRODUCT_NAME."`, `".PL_STANDARD."`, `".PL_COLOR_TONE."`";
		return $this->getQuery($query);
	}

}