<?php

class Customer_Class extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'customer_class';
	}
}