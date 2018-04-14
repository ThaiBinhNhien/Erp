<?php

class Washing_Product extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'washing_product';
	}
}