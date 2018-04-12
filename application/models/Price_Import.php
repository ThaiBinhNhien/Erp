<?php

class Price_Import extends VV_Model
{
	
	function __construct()
	{
        parent::__construct();
        $this->table_name = T_PRODUCT_NUMBER_FOR_SUPPLIER;
        $this->idCol = TPNS_ID;
		 
    }
}