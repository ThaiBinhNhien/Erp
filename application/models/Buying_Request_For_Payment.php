<?php

class Buying_Request_For_Payment extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'buying_request_for_payment';
	}
}