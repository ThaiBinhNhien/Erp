<?php

class Order_Reason extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = SALES_LEDGER; 
		$this->idCol = SL_ID;
	}
}