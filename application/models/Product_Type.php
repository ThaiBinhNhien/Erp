<?php

class Product_Type extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'product_type';
	}
}