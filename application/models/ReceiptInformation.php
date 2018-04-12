<?php

class ReceiptInformation extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->table_name = T_GOODS_RECEIPT_INFORMATION;
        $this->idCol = TGRI_ID;
	}

	/**
	* Function: editCheckPriceById
	* @access public 
	*/ 
	public function editCheckPriceById($id = NULL)
	{
		$query = 
		"
			UPDATE `erp_tolinen`.`".T_GOODS_RECEIPT_INFORMATION."` SET `".TGRI_CHECK_PRICE."`=b'1' WHERE  `id`=".$id."
		";

		return $this->db->query($query);
	}
}