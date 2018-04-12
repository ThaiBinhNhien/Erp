<?php

class Request_For_Payment_Detail extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'request_for_payment_detail';
	}
}