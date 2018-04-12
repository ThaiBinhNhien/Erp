<?php

class DrivingSituation extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = DRIVING_SITUATION_DATA;
		$this->idCol = CUS_ID;
	}

	public function pdf_oil_washing($date_from,$date_to){
		$this->db->select("DATE_FORMAT(".DSD_DRIVING_DATE.",'%Y-%m-%d') AS date".",SUM(".DSD_OIL_QUANTITY_NO1_USAGE."+".DSD_OIL_QUANTITY_NO2_USAGE.") AS total_oil,".",SUM(".DSD_LAUNDRY_VOLUME.") AS total_washing");
		$this->db->where(
			array(
				DSD_DRIVING_DATE.">=" =>$date_from." 00:00:00",
				DSD_DRIVING_DATE."<=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(DSD_DRIVING_DATE);
		$this->db->order_by(DSD_DRIVING_DATE,"ASC");
		return $this->db->get($this->table_name)->result_array();
	}
	
	public function pdf_activity_machine($date_from,$date_to){
		$this->db->select("DATE_FORMAT(".DSD_DRIVING_DATE.",'%Y-%m-%d') AS date ,DATE_FORMAT(".DSD_OPERATING_TIME_1.",'%H')+DATE_FORMAT(".DSD_OPERATING_TIME_1.",'%i')/60 AS time1,DATE_FORMAT(".DSD_OPERATING_TIME_2.",'%H')+DATE_FORMAT(".DSD_OPERATING_TIME_2.",'%i')/60 AS  time2,SUM(".DSD_BLOW_AMOUNT_1.") AS blow1,SUM(".DSD_BLOW_AMOUNT_2.") AS blow2");
		$this->db->where(
			array(
				DSD_DRIVING_DATE.">=" =>$date_from." 00:00:00",
				DSD_DRIVING_DATE."<=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(DSD_DRIVING_DATE);
		$this->db->order_by(DSD_DRIVING_DATE,"ASC");
		return $this->db->get($this->table_name)->result_array();
	}

	public function pdf_produce_enegy_used($date_from,$date_to){
		$this->db->select("SUM(IFNULL(".DSD_SUPPLY_OIL.",0)) AS supply_oil,SUM(IFNULL(".DSD_OIL_QUANTITY_NO1_USAGE.",0)+IFNULL(".DSD_OIL_QUANTITY_NO2_USAGE.",0)) AS used_oil,SUM(IFNULL(".DSD_OIL_QUANTITY_NO1_USAGE.",0)) AS used_oil1,SUM(IFNULL(".DSD_OIL_QUANTITY_NO2_USAGE.",0)) AS used_oil2,SUM(IFNULL(".DSD_WATER_SUPPLY_NO1_USAGE.",0)+IFNULL(".DSD_WATER_SUPPLY_NO2_USAGE.",0)) AS supply_water,SUM(IFNULL(".DSD_WATER_SUPPLY_NO1_USAGE.",0)) AS supply_water1,SUM(IFNULL(".DSD_WATER_SUPPLY_NO2_USAGE.",0)) AS supply_water2,SUM(IFNULL(".DSD_POWER_USAGE.",0)) AS electric_used,SUM(IFNULL(".DSD_TOTAL_WATER_USAGE.",0)) AS water_kensui_used,SUM(IFNULL(".DSD_GAS_METER_NO1.",0)+IFNULL(".DSD_GAS_METER_NO2.",0)) AS used_gas,SUM(IFNULL(".DSD_GAS_METER_NO1.",0)) AS gas1,SUM(IFNULL(".DSD_GAS_METER_NO2.",0)) AS gas2,SUM(IFNULL(".DSD_WATER_METER_NO1.",0)+IFNULL(".DSD_WATER_METER_NO2.",0)) AS water_meter_used,SUM(IFNULL(".DSD_WATER_METER_NO1.",0)) AS water_meter1,SUM(IFNULL(".DSD_WATER_METER_NO2.",0)) AS water_meter2,SUM(IFNULL(".DSD_TOTAL_WATER_USAGE.",0)) AS water_special_used,SUM(IFNULL(".DSD_LAUNDRY_VOLUME.",0)) AS weight");
		$this->db->where(
			array(
				DSD_DRIVING_DATE.">=" =>$date_from." 00:00:00",
				DSD_DRIVING_DATE."<=" =>$date_to." 23:59:59"
			)
		);
		$result = $this->db->get($this->table_name)->result_array();
		if($result != NULL){
			$result = $result[0];
		}
		return $result;
	}
	public function pdf_water_graph($date_from,$date_to){
		$this->db->select("DATE_FORMAT(".DSD_DRIVING_DATE.",'%Y-%m-%d') AS date ,SUM(".DSD_HOT_WELL_USAGE.") AS hot_well,SUM(".DSD_GAS_METER_BOILER.") AS boiler,(SUM(".DSD_DRAIN_RECOVERY_RATE."*(".DSD_WATER_SUPPLY_NO1_USAGE."+".DSD_WATER_SUPPLY_NO2_USAGE.")/100)/SUM(".DSD_WATER_SUPPLY_NO1_USAGE."+".DSD_WATER_SUPPLY_NO2_USAGE.")*100) AS drain");
		$this->db->where(
			array(
				DSD_DRIVING_DATE.">=" =>$date_from." 00:00:00",
				DSD_DRIVING_DATE."<=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(DSD_DRIVING_DATE);
		$this->db->order_by(DSD_DRIVING_DATE,"ASC");
		return $this->db->get($this->table_name)->result_array();
	}

	public function pdf_electric_washing($date_from,$date_to){
		$this->db->select("DATE_FORMAT(".DSD_DRIVING_DATE.",'%Y-%m-%d') AS date".",SUM(".DSD_POWER_USAGE.") AS total_power,".",SUM(".DSD_LAUNDRY_VOLUME.") AS total_washing");
		$this->db->where(
			array(
				DSD_DRIVING_DATE.">=" =>$date_from." 00:00:00",
				DSD_DRIVING_DATE."<=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(DSD_DRIVING_DATE);
		$this->db->order_by(DSD_DRIVING_DATE,"ASC");
		return $this->db->get($this->table_name)->result_array();
	}

	public function pdf_water_kensui_washing($date_from,$date_to){
		$this->db->select("DATE_FORMAT(".DSD_DRIVING_DATE.",'%Y-%m-%d') AS date".",SUM(".DSD_TOTAL_WATER_USAGE
			.") AS total_water_kensui,".",SUM(".DSD_LAUNDRY_VOLUME.") AS total_washing");
		$this->db->where(
			array(
				DSD_DRIVING_DATE.">=" =>$date_from." 00:00:00",
				DSD_DRIVING_DATE."<=" =>$date_to." 23:59:59"
			)
		);
		$this->db->group_by(DSD_DRIVING_DATE);
		$this->db->order_by(DSD_DRIVING_DATE,"ASC");
		return $this->db->get($this->table_name)->result_array();
	}

		public function Insert_Data_CSV($dsd_driving_date,$dsd_working_time_1,$dsd_working_time_2,$dsd_working_time_3,$dsd_uptime_4,$dsd_hot_well_usage,$dsd_drain_recovery_rate,$dsd_total_water_usage,$dsd_power_usage,$dsd_prefecture_water_consumption,$dsd_well_water_consumption,$dsd_water_meter_no1,$dsd_water_meter_no2,$dsd_gas_meter_boiler,$dsd_gas_meter_ghp,$dsd_gas_meter_rest_room,$dsd_laundry_volume,$dsd_inoue_meter_star_pharmaceutical)
	{
		$data = array(
			DSD_DRIVING_DATE => $dsd_driving_date,
			DSD_WORKING_TIME_1 => $dsd_working_time_1,
			DSD_WORKING_TIME_2 => $dsd_working_time_2,
			DSD_HOT_WELL_USAGE => $dsd_hot_well_usage,
			DSD_DRAIN_RECOVERY_RATE => $dsd_drain_recovery_rate,
			DSD_TOTAL_WATER_USAGE => $dsd_total_water_usage,
			DSD_POWER_USAGE => $dsd_power_usage,
			DSD_PREFECTURE_WATER_CONSUMPTION => $dsd_prefecture_water_consumption,
			DSD_WELL_WATER_CONSUMPTION => $dsd_well_water_consumption,
			DSD_WATER_METER_NO1 => $dsd_water_meter_no1,
			DSD_WATER_METER_NO2 => $dsd_water_meter_no2,
			DSD_LAUNDRY_VOLUME => $dsd_laundry_volume,
			DSD_INOUE_METER_STAR_PHARMACEUTICAL => $dsd_inoue_meter_star_pharmaceutical,
			DSD_WORKING_TIME_3 => $dsd_working_time_3,
			DSD_UPTIME_4 => $dsd_uptime_4,
			DSD_GAS_METER_BOILER => $dsd_gas_meter_boiler,
			DSD_GAS_METER_GHP => $dsd_gas_meter_ghp,
			DSD_GAS_METER_REST_ROOM => $dsd_gas_meter_rest_room
		);
		$insert = $this->db->insert(DRIVING_SITUATION_DATA,$data);
		return $insert;
	}

	public function Update_Data_CSV($dsd_driving_date,$dsd_working_time_1,$dsd_working_time_2,$dsd_working_time_3,$dsd_uptime_4,$dsd_hot_well_usage,$dsd_drain_recovery_rate,$dsd_total_water_usage,$dsd_power_usage,$dsd_prefecture_water_consumption,$dsd_well_water_consumption,$dsd_water_meter_no1,$dsd_water_meter_no2,$dsd_gas_meter_boiler,$dsd_gas_meter_ghp,$dsd_gas_meter_rest_room,$dsd_laundry_volume,$dsd_inoue_meter_star_pharmaceutical)
	{
		$data = array(
			DSD_WORKING_TIME_1 => $dsd_working_time_1,
			DSD_WORKING_TIME_2 => $dsd_working_time_2,
			DSD_HOT_WELL_USAGE => $dsd_hot_well_usage,
			DSD_DRAIN_RECOVERY_RATE => $dsd_drain_recovery_rate,
			DSD_TOTAL_WATER_USAGE => $dsd_total_water_usage,
			DSD_POWER_USAGE => $dsd_power_usage,
			DSD_PREFECTURE_WATER_CONSUMPTION => $dsd_prefecture_water_consumption,
			DSD_WELL_WATER_CONSUMPTION => $dsd_well_water_consumption,
			DSD_WATER_METER_NO1 => $dsd_water_meter_no1,
			DSD_WATER_METER_NO2 => $dsd_water_meter_no2,
			DSD_LAUNDRY_VOLUME => $dsd_laundry_volume,
			DSD_INOUE_METER_STAR_PHARMACEUTICAL => $dsd_inoue_meter_star_pharmaceutical,
			DSD_WORKING_TIME_3 => $dsd_working_time_3,
			DSD_UPTIME_4 => $dsd_uptime_4,
			DSD_GAS_METER_BOILER => $dsd_gas_meter_boiler,
			DSD_GAS_METER_GHP => $dsd_gas_meter_ghp,
			DSD_GAS_METER_REST_ROOM => $dsd_gas_meter_rest_room
		);
		$this->db->where(DSD_DRIVING_DATE,$dsd_driving_date);
		$insert = $this->db->update(DRIVING_SITUATION_DATA,$data);
		return $insert;
	}

	public function Check_Date_Boiler_Data($date)
	{
		$this->db->from(DRIVING_SITUATION_DATA);
		$this->db->where(DSD_DRIVING_DATE,$date);
		$data = $this->db->get()->row_array();
		return $data;
	}

	public function Export_Data_CSV()
	{
		$this->db->select(
			'd.'.DSD_DRIVING_DATE.', d.'.DSD_WORKING_TIME_1.', d.'.DSD_WORKING_TIME_2.', 
			d.'.DSD_WORKING_TIME_3.', d.'.DSD_UPTIME_4.', d.'.DSD_HOT_WELL_USAGE.', 
			d.'.DSD_DRAIN_RECOVERY_RATE.', d.'.DSD_TOTAL_WATER_USAGE.', d.'.DSD_POWER_USAGE.', d.'.DSD_PREFECTURE_WATER_CONSUMPTION.', 
			d.'.DSD_WELL_WATER_CONSUMPTION.', d.'.DSD_WATER_METER_NO1.', d.'.DSD_WATER_METER_NO2.', d.'.DSD_LAUNDRY_VOLUME.', 
			d.'.DSD_INOUE_METER_STAR_PHARMACEUTICAL.', d.'.DSD_GAS_METER_BOILER.', d.'.DSD_GAS_METER_GHP.', 
			d.'.DSD_GAS_METER_REST_ROOM.', d.'.DSD_REGISTERED_PERSON
		);
		$this->db->from(DRIVING_SITUATION_DATA .' as d');
		$data = $this->db->get();
		return $data->result_array();
	}
}