<?php

class Notification_model extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = TAB_NOTIFICATION;
		$this->idCol = TN_ID;
	}
	
} 