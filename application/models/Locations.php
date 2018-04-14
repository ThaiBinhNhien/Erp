<?php

class Locations extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'locations';
	}
}