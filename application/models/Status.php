<?php

class Status extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'status';
	}
}