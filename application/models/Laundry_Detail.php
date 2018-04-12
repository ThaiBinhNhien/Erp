<?php 
class Laundry_Detail extends VV_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function Delete_Laundry_Detail($ld_sequence_no)
	{
		$this->db->where(LD_SEQUENCE_NO,$ld_sequence_no);
		$this->db->where(LD_SEQUENCE_NO," ");
		$delete = $this->db->delete(LAUNDRY_DETAIL);
		return $delete;
	}

	public function Insert_Data_Laundry_Detail($ld_detergent_code, $ld_amount_to_use)
	{
		$data = array(
			LD_DETERGENT_CODE => $ld_detergent_code,
			LD_AMOUNT_TO_USE => $ld_amount_to_use
		);
		$insert = $this->db->insert(LAUNDRY_DETAIL, $data);
		return $insert;
	}
	
	public function Select_Data_Laundry_M($lm_code)
	{
		$this->db->from(LAUNDRY_M);
		$this->db->where(LM_CODE, $lm_code);
		$select = $this->db->get()->row_array();
		return $select;
	}

	public function Delete_Laundry_Date($lr_equipment_code, $lr_implementation_time)
	{
		$this->db->where(LR_EQUIPMENT_CODE, $lr_equipment_code);
		$this->db->where(LR_IMPLEMENTATION_TIME, $lr_implementation_time);
		$delete = $this->db->delete(LAUNDRY_REGISTER);
		return $delete;
	}
}
?>