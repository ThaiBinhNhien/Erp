<?php

class Price_Export extends VV_Model
{
	
	function __construct()
	{
        parent::__construct();
        $this->table_name = T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY;
        $this->idCol = TPCT_ID; 
		 
    }
}