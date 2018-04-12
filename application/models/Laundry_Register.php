<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Manage base master
*/
class Laundry_Register extends VV_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table_name = LAUNDRY_REGISTER;
    }

    public function pdf_produce_weight_by_device($date_from,$date_to){
    	$this->db->select(EQUIPMENT_M.".`".EQ_CODE."`,".EQUIPMENT_M.".".EQ_NAME.",".LAUNDRY_M.".".LM_CODE.",".LAUNDRY_M.".".LM_ITEM_NAME_1.",COUNT(".LAUNDRY_M.".".LM_CODE.") AS quantity".",SUM(".LAUNDRY_M.".".LM_WEIGHT.") AS weight");
    	$this->db->join(LAUNDRY_M,LAUNDRY_M.".".LM_CODE."=".LAUNDRY_REGISTER.".".LR_LAUNDRY_CODE);
    	$this->db->join(EQUIPMENT_M,EQUIPMENT_M.".`".EQ_CODE."`=".LAUNDRY_REGISTER.".".LR_EQUIPMENT_CODE
    		);
    	$this->db->where(
			array(
				LR_REGISTRATION_DATE." >=" =>$date_from." 00:00:00",
				LR_REGISTRATION_DATE." <=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(LAUNDRY_M.".".LM_CODE.",".LAUNDRY_M.".".LM_ITEM_NAME_1.",`".EQUIPMENT_M."`.`".EQ_CODE."`,`".EQUIPMENT_M."`.".EQ_NAME);
		return $this->db->get($this->table_name)->result_array();
    }
	
	public function pdf_produce_quantity_used_by_device($date_from,$date_to){
		$this->db->select(EQUIPMENT_M.".`".EQ_CODE."`,".EQUIPMENT_M.".".EQ_NAME.",".DETERGENT_LEDGER.".".DEL_CODE.",".DETERGENT_LEDGER.".".DEL_NAME.",".DETERGENT_LEDGER.".".DEL_UNIT_PRICE.",COUNT(".LAUNDRY_M.".".LM_CODE.") AS quantity".",SUM(".LAUNDRY_DETAIL.".".LD_AMOUNT_TO_USE.") AS amount_washing".",SUM(".LAUNDRY_M.".".LM_WEIGHT.") AS weight");
		$this->db->join(LAUNDRY_REGISTER,"`".LAUNDRY_REGISTER."`.`".LR_SEQUENCE_NO."`=".LAUNDRY_DETAIL.".".LD_SEQUENCE_NO);
		$this->db->join(DETERGENT_LEDGER,DETERGENT_LEDGER.".".DEL_CODE."=".LAUNDRY_DETAIL.".".LD_DETERGENT_CODE);
    	$this->db->join(LAUNDRY_M,LAUNDRY_M.".".LM_CODE."=".LAUNDRY_REGISTER.".".LR_LAUNDRY_CODE);
    	$this->db->join(EQUIPMENT_M,EQUIPMENT_M.".`".EQ_CODE."`=".LAUNDRY_REGISTER.".".LR_EQUIPMENT_CODE
    		);
		$this->db->where(
			array(
				LR_REGISTRATION_DATE." >=" =>$date_from." 00:00:00",
				LR_REGISTRATION_DATE." <=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(DETERGENT_LEDGER.".".DEL_CODE.",".DETERGENT_LEDGER.".".DEL_NAME.",".DETERGENT_LEDGER.".".DEL_UNIT_PRICE.",`".EQUIPMENT_M."`.`".EQ_CODE."`,`".EQUIPMENT_M."`.".EQ_NAME);
		return $this->db->get(LAUNDRY_DETAIL)->result_array();
	}

	public function pdf_produce_amount_powder_used_by_device($date_from,$date_to){
		$this->db->select(EQUIPMENT_M.".`".EQ_CODE."`,".EQUIPMENT_M.".".EQ_NAME.",".DETERGENT_LEDGER.".".DEL_CODE.",".DETERGENT_LEDGER.".".DEL_NAME.",`".LAUNDRY_M."`.`".LM_CODE.",`".LAUNDRY_M."`.".LM_ITEM_NAME_2.",".DETERGENT_LEDGER.".".DEL_UNIT_PRICE.",COUNT(".LAUNDRY_M.".".LM_CODE.") AS quantity".",SUM(".LAUNDRY_DETAIL.".".LD_AMOUNT_TO_USE.") AS amount_washing".",SUM(".LAUNDRY_M.".".LM_WEIGHT.") AS weight");
		$this->db->join(LAUNDRY_REGISTER,"`".LAUNDRY_REGISTER."`.`".LR_SEQUENCE_NO."`=".LAUNDRY_DETAIL.".".LD_SEQUENCE_NO);
		$this->db->join(DETERGENT_LEDGER,DETERGENT_LEDGER.".".DEL_CODE."=".LAUNDRY_DETAIL.".".LD_DETERGENT_CODE);
    	$this->db->join(LAUNDRY_M,LAUNDRY_M.".".LM_CODE."=".LAUNDRY_REGISTER.".".LR_LAUNDRY_CODE);
    	$this->db->join(EQUIPMENT_M,EQUIPMENT_M.".`".EQ_CODE."`=".LAUNDRY_REGISTER.".".LR_EQUIPMENT_CODE
    		);
		$this->db->where(
			array(
				LR_REGISTRATION_DATE." >=" =>$date_from." 00:00:00",
				LR_REGISTRATION_DATE." <=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(DETERGENT_LEDGER.".".DEL_CODE.",".DETERGENT_LEDGER.".".DEL_NAME.",".DETERGENT_LEDGER.".".DEL_UNIT_PRICE.",`".EQUIPMENT_M."`.`".EQ_CODE."`,`".EQUIPMENT_M."`.".EQ_NAME.",`".LAUNDRY_M."`.`".LM_CODE.",`".LAUNDRY_M."`.".LM_ITEM_NAME_2);
		return $this->db->get(LAUNDRY_DETAIL)->result_array();
	}

	public function Select_Laundry_Equipment_Time($lr_equipment_code,$lr_implementation_time)
	{
		$this->db->from(LAUNDRY_REGISTER);
		$this->db->where(LR_EQUIPMENT_CODE,$lr_equipment_code);
		$this->db->where(LR_IMPLEMENTATION_TIME, $lr_implementation_time);
		$select = $this->db->get()->row_array();
		return $select;
	}

	public function Detele_Laundry_Register($lr_sequence_no)
	{
		$this->db->where(LR_SEQUENCE_NO, $lr_sequence_no);
		$this->db->where(LR_SEQUENCE_NO," ");
		$delete = $this->db->delete(LAUNDRY_REGISTER);
		return $delete;		
	}

	public function Select_Data_Last_Laundry_ID()
	{
		$this->db->from(LAUNDRY_REGISTER);
		$this->db->order_by(LR_SEQUENCE_NO,'DESC');
		$select = $this->db->get()->row_array();
		return $select;
	}

	public function Insert_Data_Laundry_Register($lr_sequence_no, $lr_implementation_time, $lr_laundry_code , $lr_laundry_weight, $lr_amount_of_detergent, $lr_registration_date ,$lr_registered_person, $lr_excess_water_amount, $lr_equipment_code)
	{
		$data = array(
			LR_SEQUENCE_NO => $lr_sequence_no,
			LR_IMPLEMENTATION_TIME => $lr_implementation_time,
			LR_LAUNDRY_CODE => $lr_laundry_code,
			LR_LAUNDRY_WEIGHT => $lr_laundry_weight,
			LR_REGISTRATION_DATE => $lr_registration_date,
			LR_REGISTERED_PERSON => $lr_registered_person,
			LR_AMOUNT_OF_DETERGENT => $lr_amount_of_detergent,
			LR_EXCESS_WATER_AMOUNT => $lr_excess_water_amount,
			LR_EQUIPMENT_CODE => $lr_equipment_code
		);
		$insert = $this->db->insert(LAUNDRY_REGISTER,$data);
		return $insert;
	}


	public function Select_Conversion_Usage($cu_equipment_code,$cu_laundry_code)
	{
		$this->db->from(CONVERSION_USAGE);
		$this->db->where(CU_EQUIPMENT_CODE,$cu_equipment_code);
		$this->db->where(CU_LAUNDRY_CODE,$cu_laundry_code);
		$select = $this->db->get()->result_array();
		return $select;
	}

	public function Select_Conversion_Usage_Atsugi($cu_equipment_code, $cu_process_code)
	{
		$this->db->from(CONVERSION_USAGE);
		$this->db->where(CU_EQUIPMENT_CODE,$cu_equipment_code);
		$this->db->where(CU_PROCESS_CODE, $cu_process_code);
		$select = $this->db->get()->row_array();
		return $select;
	}
	public function Insert_Data_Laundry_Register_Atsugi($lr_sequence_no, $lr_implementation_time, $lr_laundry_code , $lr_laundry_weight, $lr_registration_date, $lr_registered_person,$lr_equipment_code)
	{
		$data = array(
			LR_SEQUENCE_NO => $lr_sequence_no,
			LR_IMPLEMENTATION_TIME => $lr_implementation_time,
			LR_LAUNDRY_CODE => $lr_laundry_code,
			LR_LAUNDRY_WEIGHT => $lr_laundry_weight,
			LR_REGISTRATION_DATE => $lr_registration_date,
			LR_REGISTERED_PERSON => $lr_registered_person,
			LR_EQUIPMENT_CODE => $lr_equipment_code
		);
		$insert = $this->db->insert(LAUNDRY_REGISTER,$data);
		return $insert;
	}

	public function Select_Laundry_Time($lr_implementation_time)
	{
		$this->db->from(LAUNDRY_REGISTER);
		$this->db->where(LR_IMPLEMENTATION_TIME);
		$select = $this->db->get()->row_array();
		return $select;
	}

	public function Delete_Laundry_Time($lr_implementation_time)
	{
		$this->db->where(LR_IMPLEMENTATION_TIME, $lr_implementation_time);
		$delete = $this->db->delete(LAUNDRY_REGISTER);
		return $delete;
	}
}
	