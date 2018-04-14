<?php

class Finishing_Situation extends VV_Model
{
	function __construct()
	{
		parent::__construct();
		 
	}	

	public function Check_Date_Situation_Data($date)
	{
		$this->db->from(FINISHING_SITUATION_DATA);
		$this->db->where(FSD_DATE,$date);
		$select = $this->db->get()->row_array();
		return $select;
	}

	public function Check_Towel_Code_Data($towel_code)
	{
		$this->db->from(TOWEL_ITEM);
		$this->db->where(TOWEL_CODE,$towel_code);
		$select = $this->db->get()->row_array();
		return $select;
	}

	public function Check_Date_Towel_Data($date, $towel_code,$towel_place)
	{
		$this->db->from(TOWEL_RESULT);
		$this->db->where(TOWEL_DATE,$date);
		$this->db->where(TOWEL_CODE,$towel_code);
		$this->db->where(TOWEL_PLACE,$towel_place);
		$select = $this->db->get()->row_array();
		return $select;
	}

	public function Insert_Data_Towel($towel_date, $towel_code, $towel_place, $towel_finished_number)
	{
		$data = array(
			TOWEL_DATE => $towel_date,
			TOWEL_CODE => $towel_code,
			TOWEL_PLACE => $towel_place,
			TOWEL_FINISHED_NUMBER => $towel_finished_number
		);
		$insert = $this->db->insert(TOWEL_RESULT,$data);
		return $insert;
	}

	public function Update_Data_Towel($towel_date, $towel_code, $towel_place, $towel_finished_number)
	{
		$data = array(
			TOWEL_FINISHED_NUMBER => $towel_finished_number
		);
		$this->db->where(TOWEL_DATE,$towel_date);
		$this->db->where(TOWEL_CODE,$towel_code);
		$this->db->where(TOWEL_PLACE,$towel_place);
		$update = $this->db->update(TOWEL_RESULT, $data);
		return $update;
	}
	
	public function Insert_Data_Roller($fsd_date, $fsd_sheet, $fsd_sheet_2, $fsd_cancel, $fsd_sheets, $fsd_sheet_wash_again, $fsd_sheet_breaking, $fsd_top, $fsd_top_2, $fsd_top_stains, $fsd_top_wash_again, $fsd_top_break, $fsd_duve, $fsd_duve_2, $fsd_duves_stain, $fsd_duvet_wash_a, $fsd_duve_tear, $fsd_pirocase, $fsd_nightgown, $fsd_fsd_yukata, $fsd_trainer_and_others,
	$fsd_socks, $fsd_napkin_and_others, $fsd_td_cross_2, $fsd_short_scale_2, $fsd_short_stubble_2, $fsd_short_scale_other_wash_2, $fsd_short_scale_other_crack_2, 
	$fsd_others, $fsd_long_length_stain_2, $fsd_long_length_wash_again_2, $fsd_long_rake_other_tear_2, $fsd_polycloth_2, $fsd_white_coat, $fsd_pants, $fsd_hat, $fsd_one_piece,
	$fsd_front_hanging, $fsd_triangular_cloth, $fsd_apron, $fsd_star_pharmaceutical, $fsd_slipper, $fsd_akasuri, $fsd_bathrobes, $fsd_bt)
	{
		$data = array(
			FSD_DATE => $fsd_date,
			FSD_SHEET => $fsd_sheet,
			FSD_SHEETS_2 => $fsd_sheet_2,
			FSD_CANCEL => $fsd_cancel,
			FSD_SHEETS => $fsd_sheets,
			FSD_SHEET_WASH_AGAIN => $fsd_sheet_wash_again,
			FSD_SHEET_BREAKING => $fsd_sheet_breaking,
			FSD_TOP => $fsd_top,
			FSD_TOP_2 => $fsd_top_2,
			FSD_TOP_STAINS => $fsd_top_stains,
			FSD_TOP_WASH_AGAIN => $fsd_top_wash_again,
			FSD_TOP_BREAK => $fsd_top_break,
			FSD_DUVE => $fsd_duve,
			FSD_DUVE_2 => $fsd_duve_2,
			FSD_DUVES_STAIN => $fsd_duves_stain,
			FSD_DUVET_WASH_AGAIN => $fsd_duvet_wash_a,
			FSD_DUVE_TEAR => $fsd_duve_tear,
			FSD_PIROCASE => $fsd_pirocase,
			FSD_NIGHTGOWN => $fsd_nightgown,
			FSD_FSD_YUKATA => $fsd_fsd_yukata,
			FSD_TRAINER_AND_OTHERS => $fsd_trainer_and_others,
			FSD_SOCKS => $fsd_socks,
			FSD_NAPKIN_AND_OTHERS => $fsd_napkin_and_others,
			FSD_TD_CROSS_2 => $fsd_td_cross_2,
			FSD_SHORT_SCALE_2 => $fsd_short_scale_2,
			FSD_SHORT_STUBBLE_2 => $fsd_short_stubble_2,
			FSD_SHORT_SCALE_OTHER_WASH_2 => $fsd_short_scale_other_wash_2,
			FSD_SHORT_SCALE_OTHER_CRACK_2 => $fsd_short_scale_other_crack_2,
			FSD_OTHERS => $fsd_others,
			FSD_LONG_LENGTH_STAIN_2 => $fsd_long_length_stain_2,
			FSD_LONG_LENGTH_WASH_AGAIN_2 => $fsd_long_length_wash_again_2,
			FSD_LONG_RAKE_OTHER_TEAR_2 => $fsd_long_rake_other_tear_2,
			FSD_POLYCLOTH_2 => $fsd_polycloth_2,
			FSD_WHITE_COAT => $fsd_white_coat,
			FSD_PANTS => $fsd_pants,
			FSD_HAT => $fsd_hat,
			FSD_ONE_PIECE => $fsd_one_piece,
			FSD_FRONT_HANGING => $fsd_front_hanging,
			FSD_TRIANGULAR_CLOTH => $fsd_triangular_cloth,
			FSD_APRON => $fsd_apron,
			FSD_STAR_PHARMACEUTICAL => $fsd_star_pharmaceutical,
			FSD_SLIPPER => $fsd_slipper,
			FSD_AKASURI => $fsd_akasuri,
			FSD_BATHROBES => $fsd_bathrobes,
			FSD_BT => $fsd_bt,
		);	
		$insert = $this->db->insert(FINISHING_SITUATION_DATA,$data);
		return $insert;
	}

	public function Update_Data_Roller($fsd_date, $fsd_sheet, $fsd_sheet_2, $fsd_cancel, $fsd_sheets, $fsd_sheet_wash_again, $fsd_sheet_breaking, $fsd_top, $fsd_top_2, $fsd_top_stains, $fsd_top_wash_again, $fsd_top_break, $fsd_duve, $fsd_duve_2, $fsd_duves_stain, $fsd_duvet_wash_a, $fsd_duve_tear, $fsd_pirocase, $fsd_nightgown, $fsd_fsd_yukata, $fsd_trainer_and_others,
	$fsd_socks, $fsd_napkin_and_others, $fsd_td_cross_2, $fsd_short_scale_2, $fsd_short_stubble_2, $fsd_short_scale_other_wash_2, $fsd_short_scale_other_crack_2, 
	$fsd_others, $fsd_long_length_stain_2, $fsd_long_length_wash_again_2, $fsd_long_rake_other_tear_2, $fsd_polycloth_2, $fsd_white_coat, $fsd_pants, $fsd_hat, $fsd_one_piece,
	$fsd_front_hanging, $fsd_triangular_cloth, $fsd_apron, $fsd_star_pharmaceutical, $fsd_slipper, $fsd_akasuri, $fsd_bathrobes, $fsd_bt)
	{
		$data = array(
			FSD_SHEET => $fsd_sheet,
			FSD_SHEETS_2 => $fsd_sheet_2,
			FSD_CANCEL => $fsd_cancel,
			FSD_SHEETS => $fsd_sheets,
			FSD_SHEET_WASH_AGAIN => $fsd_sheet_wash_again,
			FSD_SHEET_BREAKING => $fsd_sheet_breaking,
			FSD_TOP => $fsd_top,
			FSD_TOP_2 => $fsd_top_2,
			FSD_TOP_STAINS => $fsd_top_stains,
			FSD_TOP_WASH_AGAIN => $fsd_top_wash_again,
			FSD_TOP_BREAK => $fsd_top_break,
			FSD_DUVE => $fsd_duve,
			FSD_DUVE_2 => $fsd_duve_2,
			FSD_DUVES_STAIN => $fsd_duves_stain,
			FSD_DUVET_WASH_AGAIN => $fsd_duvet_wash_a,
			FSD_DUVE_TEAR => $fsd_duve_tear,
			FSD_PIROCASE => $fsd_pirocase,
			FSD_NIGHTGOWN => $fsd_nightgown,
			FSD_FSD_YUKATA => $fsd_fsd_yukata,
			FSD_TRAINER_AND_OTHERS => $fsd_trainer_and_others,
			FSD_SOCKS => $fsd_socks,
			FSD_NAPKIN_AND_OTHERS => $fsd_napkin_and_others,
			FSD_TD_CROSS_2 => $fsd_td_cross_2,
			FSD_SHORT_SCALE_2 => $fsd_short_scale_2,
			FSD_SHORT_STUBBLE_2 => $fsd_short_stubble_2,
			FSD_SHORT_SCALE_OTHER_WASH_2 => $fsd_short_scale_other_wash_2,
			FSD_SHORT_SCALE_OTHER_CRACK_2 => $fsd_short_scale_other_crack_2,
			FSD_OTHERS => $fsd_others,
			FSD_LONG_LENGTH_STAIN_2 => $fsd_long_length_stain_2,
			FSD_LONG_LENGTH_WASH_AGAIN_2 => $fsd_long_length_wash_again_2,
			FSD_LONG_RAKE_OTHER_TEAR_2 => $fsd_long_rake_other_tear_2,
			FSD_POLYCLOTH_2 => $fsd_polycloth_2,
			FSD_WHITE_COAT => $fsd_white_coat,
			FSD_PANTS => $fsd_pants,
			FSD_HAT => $fsd_hat,
			FSD_ONE_PIECE => $fsd_one_piece,
			FSD_FRONT_HANGING => $fsd_front_hanging,
			FSD_TRIANGULAR_CLOTH => $fsd_triangular_cloth,
			FSD_APRON => $fsd_apron,
			FSD_STAR_PHARMACEUTICAL => $fsd_star_pharmaceutical,
			FSD_SLIPPER => $fsd_slipper,
			FSD_AKASURI => $fsd_akasuri,
			FSD_BATHROBES => $fsd_bathrobes,
			FSD_BT => $fsd_bt,
		);	
		$this->db->where(FSD_DATE,$fsd_date);
		$update = $this->db->update(FINISHING_SITUATION_DATA,$data);
		return $update;
	}
}

?>