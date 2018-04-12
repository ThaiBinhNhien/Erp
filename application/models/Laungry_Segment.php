<?php

class Laungry_Segment extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_LAUNDRY_SEGMENT;
		$this->idCol = TLG_ID;
	}
	
}