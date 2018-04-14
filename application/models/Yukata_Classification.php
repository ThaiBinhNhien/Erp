<?php
//category bán
class Yukata_Classification extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = T_YUKATA_CLASSIFICATION;
		$this->idCol = TYC_ID;
	}

}