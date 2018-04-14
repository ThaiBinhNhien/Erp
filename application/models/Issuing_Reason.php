<?php

class Issuing_Reason extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'issuing_reason';
	}
}