<?php

//category bán
class Dry_Press_Laundry_Classfication extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DRY_PRESS_LAUNDRY_CLASSIFICATION;
		$this->idCol = DPLC_ID;
	}

	
}