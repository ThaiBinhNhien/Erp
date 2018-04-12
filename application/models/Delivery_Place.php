<?php

class Delivery_Place extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'delivery_place';
	}
}