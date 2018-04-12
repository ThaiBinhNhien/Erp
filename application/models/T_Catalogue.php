<?php
//category bán
class T_Catalogue extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_EVENT;
		$this->idCol = TE_ID;
	}
}