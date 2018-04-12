<?php

class Production extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'production_class';
	}

	public function pdf_produce_washing_amount($date){
		/*$this->db->select(POG_NAME.",".PRODUCTION_OVERVIEW_GROUP_M.".".POG_CODE.",".POC_CATEGORY_NAME.",".PRODUCTION_OVERVIEW_CATEGORY_M.".".POC_PRODUCTION_SUMMARY_CODE.",COUNT(".LR_SEQUENCE_NO.") AS quantity,SUM(".LR_LAUNDRY_WEIGHT.") AS weight");
		$this->db->join(CONVERSION_PRODUCTION_OVERVIEW,CONVERSION_PRODUCTION_OVERVIEW.".".CPO_LAUNDRY_CODE."=".LAUNDRY_REGISTER.".".LR_LAUNDRY_CODE);
		$this->db->join(PRODUCTION_OVERVIEW_CATEGORY_M,PRODUCTION_OVERVIEW_CATEGORY_M.".".POC_PRODUCTION_SUMMARY_CODE."=".CONVERSION_PRODUCTION_OVERVIEW.".".CPO_PRODUCTION_SUMMARY_CODE);
		$this->db->join(PRODUCTION_OVERVIEW_GROUP_M,PRODUCTION_OVERVIEW_GROUP_M.".".POG_CODE."=".PRODUCTION_OVERVIEW_CATEGORY_M.".".POC_PRODUCTION_OVERVIEW_GROUP_CODE);
		if($date != NULL && $date != ""){
			$this->db->where("FORMAT_DATE(".LR_REGISTRATION_DATE.",'yyyy-MM') = ".$date);
		}

		$this->db->group_by(POG_NAME.",".PRODUCTION_OVERVIEW_GROUP_M.".".POG_CODE.",".POC_CATEGORY_NAME.",".PRODUCTION_OVERVIEW_CATEGORY_M.".".POC_PRODUCTION_SUMMARY_CODE);
		$this->db->get(LAUNDRY_REGISTER)->result_array();*/
		$query = "sELECT `".POG_NAME."`, `".PRODUCTION_OVERVIEW_GROUP_M."`.`".POG_CODE."`, `".POC_CATEGORY_NAME."`, `".PRODUCTION_OVERVIEW_CATEGORY_M."`.`".POC_PRODUCTION_SUMMARY_CODE."`, COUNT(`".LR_SEQUENCE_NO."`) AS quantity, SUM(`".LR_LAUNDRY_WEIGHT."`) AS weight FROM `".LAUNDRY_REGISTER."` JOIN `".CONVERSION_PRODUCTION_OVERVIEW."` ON `".CONVERSION_PRODUCTION_OVERVIEW."`.`".CPO_LAUNDRY_CODE."`=`".LAUNDRY_REGISTER."`.`".LR_LAUNDRY_CODE."` JOIN `".PRODUCTION_OVERVIEW_CATEGORY_M."` ON `".PRODUCTION_OVERVIEW_CATEGORY_M."`.`".POC_PRODUCTION_SUMMARY_CODE."`=`".CONVERSION_PRODUCTION_OVERVIEW."`.`".CPO_PRODUCTION_SUMMARY_CODE."` JOIN `".PRODUCTION_OVERVIEW_GROUP_M."` ON `".PRODUCTION_OVERVIEW_GROUP_M."`.`".POG_CODE."`=`".PRODUCTION_OVERVIEW_CATEGORY_M."`.`".POC_PRODUCTION_OVERVIEW_GROUP_CODE."` WHERE DATE_FORMAT(".LR_REGISTRATION_DATE.",'%Y-%m') = '".$date."' GROUP BY `".POG_NAME."`, `".PRODUCTION_OVERVIEW_GROUP_M."`.`".POG_CODE."`, `".POC_CATEGORY_NAME."`, `".PRODUCTION_OVERVIEW_CATEGORY_M."`.`".POC_PRODUCTION_SUMMARY_CODE."`";
		return $this->getQuery($query);
	}
}