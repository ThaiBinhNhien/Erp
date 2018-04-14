<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class CSVController extends CI_Controller {
	public $row_header = 1; // Số dòng truyền $header
	public function __construct()
    {
        parent::__construct();
		$this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }

	public function Export($titleSheet,$header,$data,$filename)
    {
    	$objExcel = new PHPExcel();
		if($titleSheet != null)
		{
			/* Tạo Worksheet theo số lượng title */
			//echo "<pre>",print_r($titleSheet),"</pre>";
			//echo "<pre>",print_r($data),"</pre>";
 			foreach($titleSheet as $keytitle => $nametitle)
 			{
 				/* Duyệt mảng data truyền vào */
 				foreach($data as $data_key => $data_value)
 				{
 					/* So sánh khoá title và data */
 					if($data_key == $keytitle)
 					{
 						if($keytitle == 0)
 						{
 							$objWorkSheet = $objExcel->setActiveSheetIndex($keytitle);
 						}
 						else
 						{
 							$objWorkSheet = $objExcel->createSheet($keytitle);
 						}
 						$objExcel->getSheet($keytitle)->fromArray($header,NULL,'A1'); //Truyền dữ liệu header bắt đầu từ A1
 						foreach (range('A', $objExcel->getSheet($keytitle)->getHighestDataColumn()) as $col) 
 						{
        					$objExcel->getSheet($keytitle)->getColumnDimension($col)->setAutoSize(true);
        					$objExcel->getSheet($keytitle)->getStyle('A')->getNumberFormat()->setFormatCode('dd/mm/yyyy'); // Định dạng kiểu dd/mm/yyyy cho cột A
    					} 
				 		$objExcel->getSheet($keytitle)->fromArray($data[$keytitle],NULL,'A2'); // Truyền dữ liệu data bắt đầu từ A2
 						if($nametitle != "")
						{
		 					$objWorkSheet->setTitle($nametitle);
		 				}
 					}
 				} 
 			}
 		}
 		//echo "<pre>",print_r($objExcel),"</pre>";
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
		header ( 'Content-Type: application/octet-stream; charset=Shift_JIS');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objExcel,'Excel5');
		$export = $objWriter->save('php://output');
    }

     public function Import($filename)
    {
    	$row_data = $this->row_header+1;
    	$inputFileType = PHPExcel_IOFactory::identify($filename);
	    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	    $objPHPExcel = $objReader->load($filename);
	    $sheetCount = $objPHPExcel->getSheetCount(); //Đếm số lượng sheet trong file
	    for($i = 0; $i < $sheetCount; $i++)
	    {
		    $sheet = $objPHPExcel->getSheet($i);  
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
			$rowData[] = $sheet->rangeToArray('A'. $row_data .':'.$highestColumn.$highestRow, NULL, TRUE,FALSE); // chuyển dữ liệu từ csv sang mảng
		}
	    return $rowData;
    }

    public function exportExcel() 
	{
		$this->load->model('DrivingSituation');
		$filename = "abc";
		$titleSheet = array('csv1');
		$header = array(DSD_DRIVING_DATE,DSD_WORKING_TIME_1,DSD_WORKING_TIME_2,DSD_WORKING_TIME_3,DSD_UPTIME_4,DSD_HOT_WELL_USAGE,DSD_DRAIN_RECOVERY_RATE,DSD_TOTAL_WATER_USAGE,DSD_POWER_USAGE,DSD_PREFECTURE_WATER_CONSUMPTION,DSD_WELL_WATER_CONSUMPTION,DSD_WATER_METER_NO1,DSD_WATER_METER_NO2,DSD_REGISTERED_PERSON,DSD_GAS_METER_BOILER,DSD_GAS_METER_GHP,DSD_GAS_METER_REST_ROOM,DSD_LAUNDRY_VOLUME,DSD_INOUE_METER_STAR_PHARMACEUTICAL);
		$data[] = $this->DrivingSituation->Export_Data_CSV(); //Lọc dữ liệu để xuất file CSV
		foreach($data as $data_key => $data_value)
		{
			foreach($data_value as $insert_value)
			{
				$dsd_driving_date = PHPExcel_Shared_Date::PHPToExcel($insert_value[DSD_DRIVING_DATE]); //Chuyển đổi ngày từ PHP sang dạng General trong excel
				if($dsd_driving_date == null)
				{
					$dsd_driving_date = "0";
				}
				$data1[$data_key][] = array($dsd_driving_date,$insert_value[DSD_WORKING_TIME_1],$insert_value[DSD_WORKING_TIME_2],$insert_value[DSD_WORKING_TIME_3],$insert_value[DSD_UPTIME_4],$insert_value[DSD_HOT_WELL_USAGE],$insert_value[DSD_DRAIN_RECOVERY_RATE],$insert_value[DSD_TOTAL_WATER_USAGE],$insert_value[DSD_POWER_USAGE],$insert_value[DSD_PREFECTURE_WATER_CONSUMPTION],$insert_value[DSD_WELL_WATER_CONSUMPTION],$insert_value[DSD_WATER_METER_NO1],$insert_value[DSD_WATER_METER_NO2],$insert_value[DSD_REGISTERED_PERSON],$insert_value[DSD_GAS_METER_BOILER],$insert_value[DSD_GAS_METER_GHP],$insert_value[DSD_GAS_METER_REST_ROOM],$insert_value[DSD_LAUNDRY_VOLUME],$insert_value[DSD_INOUE_METER_STAR_PHARMACEUTICAL]);
			}
		}
		//echo "<pre>",print_r($data1),"</pre>";
		$export = $this->Export($titleSheet,$header,$data1,$filename); // Xuất dữ liệu cho file CSV
		return $export;
	}


    public function Import_Column($filename)
    {
    	$row_data = $this->row_header;
    	$inputFileType = PHPExcel_IOFactory::identify($filename);
	    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	    $objPHPExcel = $objReader->load($filename);
	    $sheetCount = $objPHPExcel->getSheetCount(); //Đếm số lượng sheet trong file
	    for($i = 0; $i < $sheetCount; $i++)
	    { 	
		    $sheet = $objPHPExcel->getSheet($i); 
		    $highestColumn = $sheet->getHighestColumn();
		    $highestRow = $sheet->getHighestRow();  
			$place_file = $sheet->rangeToArray('A1',NULL,TRUE,FALSE);
			$date_file = $sheet->rangeToArray('B1',NULL,TRUE,FALSE);
			$day_file = $sheet->rangeToArray('D2:'.$highestColumn.'2');
			$id_product = $sheet->rangeToArray('A3:A'.$highestRow);
			$data_file = $sheet->rangeToArray('D3:'.$highestColumn.$highestRow);		
		}
		$rowData = array("place"=>$place_file,"date"=>$date_file,"day"=>$day_file,"id_product"=>$id_product,"data"=>$data_file);
		//echo "<pre>",print_r($rowData),"</pre>";
	    return $rowData;
    }

    public function Function_Import($filename, $row_load)
    {
    	$inputFileType = PHPExcel_IOFactory::identify($filename);
	    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	    $objPHPExcel = $objReader->load($filename);
	    $sheetCount = $objPHPExcel->getSheetCount();
	    for($i = 0; $i < $sheetCount; $i++)
	    {
		    $sheet = $objPHPExcel->getSheet($i);  
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
			$rowData[] = $sheet->rangeToArray('A'.$row_load.':'.$highestColumn.$highestRow, NULL, TRUE,FALSE);
		}
	    return $rowData;
    }

	public function importExcel()
	{
		$data = array();
		$year = "";
		$day = "";
		$month = "";
		$accept = true;
		$date_now = date("Y-m-d");
		//echo "<pre>",print_r($_POST),"</pre>";
		if(isset($_FILES["import_file"]) && isset($_POST["data"]))
		{
			$name= $_FILES["import_file"]["name"];
			$tmp_link = $_FILES["import_file"]["tmp_name"];
			$file_extension = @strtolower(end(explode('.',$name)));
      		$check_extension= array("csv");
      		if(in_array($file_extension,$check_extension)=== false){
      			//echo '<script>alert("Không phải loại file CSV")</script>'; 
				  $accept = false;
				  echo json_encode(array(
						"success" => false,
						"message" => $this->lang->line("jquery_validation_extension")
					));
					return;
      		}
      		/* Import dữ liệu file CSV Boiler data */
			if($_POST["data"] == "boiler")
			{
	      		if($accept)
	      		{	
					$filename = EXCEL_PATH.$name;
					move_uploaded_file($tmp_link, $filename);
					$data = $this->Import($filename);
					//echo "<pre>",print_r($data),"</pre>";
					$this->load->model('DrivingSituation');
					foreach($data as $data_value)
					{
						//echo "<pre>",print_r($data_value),"</pre>";
						foreach($data_value as $insert_value)
						{
							$dsd_driving_date = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($insert_value[0])); //Chuyển dữ liệu ngày từ Excel sang PHP
							//echo "<pre>",print_r($dsd_driving_date),"</pre>";
							$check = $this->DrivingSituation->Check_Date_Boiler_Data($dsd_driving_date); // Lọc data theo ngày
							//echo "<pre>",print_r($check),"</pre>";
							if($check != null)
							{	
								$update = $this->DrivingSituation->Update_Data_CSV($dsd_driving_date,$insert_value[1],$insert_value[2],$insert_value[3],$insert_value[4],$insert_value[5],$insert_value[6],$insert_value[7],$insert_value[8],$insert_value[9],$insert_value[10],$insert_value[11],$insert_value[12],$insert_value[14],$insert_value[15],$insert_value[16],$insert_value[17],$insert_value[18]);
							}
							else
							{
								$insert = $this->DrivingSituation->Insert_Data_CSV($dsd_driving_date,$insert_value[1],$insert_value[2],$insert_value[3],$insert_value[4],$insert_value[5],$insert_value[6],$insert_value[7],$insert_value[8],$insert_value[9],$insert_value[10],$insert_value[11],$insert_value[12],$insert_value[14],$insert_value[15],$insert_value[16],$insert_value[17],$insert_value[18]);
							}
						}
					}
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_import_success")
					));
					return;
				}
			}
			else if($_POST["data"] == "production" && isset($_POST["production_data"]))
			{
				/* Import dữ liệu CSV Towel */
				if($_POST["production_data"] == "towel")
				{
					if($accept)
					{
						$filename = EXCEL_PATH.$name;
						move_uploaded_file($tmp_link, $filename);
						$data = $this->Import_Column($filename);
						$this->load->model('Finishing_Situation');
						//echo "<pre>",print_r($data),"</pre>";
						$place = $data["place"][0];
						$date = $data["date"][0];
						$day = $data["day"][0];
						$data_file = $data["data"];
						$id_product = $data["id_product"];		
						foreach($place as $place_value)
						{
							if(strtolower($place_value) == "tokyo")
							{
								$place = 1;
							}
							if(strtolower($place_value) == "atsugi")
							{
								$place = 2;
							}
						}
						foreach($date as $date_value)
						{
							foreach($day as $day_value)
							{
								$date_implode = $date_value."/".$day_value;
								$date_config[] = date("Y-m-d",strtotime($date_implode)); 
							}
						}		
						foreach($id_product as $key_id_product => $value_id_product)
						{
							foreach($data_file as $key_data_file => $value_data_file)
							{
								if($value_id_product[0] == "")
								{
									break;
								}
								if($key_id_product == $key_data_file)
								{
									foreach($value_data_file as $key_value_data => $value_data)
									{	
										foreach($date_config as $key_date_config => $value_date_config)
										{
											if($key_value_data == $key_date_config)
											{
												$check_code = $this->Finishing_Situation->Check_Towel_Code_Data($value_id_product[0]);
												$check_date = $this->Finishing_Situation->Check_Date_Towel_Data($value_date_config, $value_id_product[0],$place);
												if( $check_code != null )
												{
													if($check_date == null)
													{
														$insert = $this->Finishing_Situation->Insert_Data_Towel($value_date_config, $value_id_product[0],$place,mb_convert_encoding($value_data,"UTF-8"));
													}
													else
													{
														$update = $this->Finishing_Situation->Update_Data_Towel($value_date_config, $value_id_product[0], $place,mb_convert_encoding($value_data,"UTF-8"));
													}
												}
											}
										}
									}
								}
							}
						}
						echo json_encode(array(
							"success" => true,
							"message" => $this->lang->line("message_import_success")
						));
						return;
					}
				}

				/* Import dữ liệu file CSV Roller  */
				else if($_POST["production_data"] == "roller")
				{
					if($accept)
		      		{	
						$filename = EXCEL_PATH.$name;
						move_uploaded_file($tmp_link, $filename);
						$data = $this->Function_Import($filename,1);
						//echo "<pre>",print_r($data),"</pre>";
						$this->load->model('Finishing_Situation');
						foreach($data as $data_value)
						{
							//echo "<pre>",print_r($data_value),"</pre>";
							foreach($data_value as $insert_value)
							{
								$fsd_date = $insert_value[0]; //Chuyển dữ liệu ngày từ Excel sang PHP
								//echo "<pre>",print_r($fsd_date),"</pre>";
								$check = $this->Finishing_Situation->Check_Date_Situation_Data($fsd_date); // Lọc data theo ngày
								//echo "<pre>",print_r($check),"</pre>";
								if($check != null)
								{	
									$insert = $this->Finishing_Situation->Update_Data_Roller($fsd_date, $insert_value[1], $insert_value[2], $insert_value[3], $insert_value[4], $insert_value[5], $insert_value[6], $insert_value[7], $insert_value[8], $insert_value[9], $insert_value[10], $insert_value[11], $insert_value[12], $insert_value[13], $insert_value[14], $insert_value[15], $insert_value[16], $insert_value[17], $insert_value[18], $insert_value[19], $insert_value[20], $insert_value[21], $insert_value[22], $insert_value[23], $insert_value[24], $insert_value[25], $insert_value[26], $insert_value[27], $insert_value[28], $insert_value[29], $insert_value[30], $insert_value[31], $insert_value[32], $insert_value[33], $insert_value[34], $insert_value[35], $insert_value[36], $insert_value[37], $insert_value[38], $insert_value[39], $insert_value[40], $insert_value[41], $insert_value[42], $insert_value[43], $insert_value[44]);
								}
								else
								{
									$insert = $this->Finishing_Situation->Insert_Data_Roller($fsd_date, $insert_value[1], $insert_value[2], $insert_value[3], $insert_value[4], $insert_value[5], $insert_value[6], $insert_value[7], $insert_value[8], $insert_value[9], $insert_value[10], $insert_value[11], $insert_value[12], $insert_value[13], $insert_value[14], $insert_value[15], $insert_value[16], $insert_value[17], $insert_value[18], $insert_value[19], $insert_value[20], $insert_value[21], $insert_value[22], $insert_value[23], $insert_value[24], $insert_value[25], $insert_value[26], $insert_value[27], $insert_value[28], $insert_value[29], $insert_value[30], $insert_value[31], $insert_value[32], $insert_value[33], $insert_value[34], $insert_value[35], $insert_value[36], $insert_value[37], $insert_value[38], $insert_value[39], $insert_value[40], $insert_value[41], $insert_value[42], $insert_value[43], $insert_value[44]);
								}
							}
						}
						echo json_encode(array(
							"success" => true,
							"message" => $this->lang->line("message_import_success")
						));
						return;
					}
				}
				/* Import dữ liệu CSV Laundry Register */
				else if($_POST["production_data"] == "laundry_register")
				{
					if($accept)
		      		{	
						$filename = EXCEL_PATH.$name;
						move_uploaded_file($tmp_link, $filename);
						$data = $this->Function_Import($filename,6);
						$this->load->model('Laundry_Register');
						$this->load->model('Laundry_Detail');
						//echo "<pre>",print_r($data),"</pre>";
						foreach($data as $data_value)
						{
							foreach($data_value as $insert_value)
							{
								if($insert_value[0] == "")
								{
									break;
								}
								$select_id = $this->Laundry_Register->Select_Laundry_Equipment_Time($insert_value[5],$insert_value[0]);
								//echo "<pre>",print_r($select_id),"</pre>";
								if($select_id != null)
								{
									$detele_id = $this->Laundry_Register->Detele_Laundry_Register($select_id[LR_SEQUENCE_NO]);
								}
								$lr_sequence_no_last = $this->Laundry_Register->Select_Data_Last_Laundry_ID();
								if($lr_sequence_no_last == "")
								{
									$lr_sequence_no = 1;
								}
								else
								{
									$lr_sequence_no = $lr_sequence_no_last[LR_SEQUENCE_NO] + 1;
								}
								if(is_numeric($insert_value[1]) && is_numeric($insert_value[2]) && is_numeric($insert_value[3]) && is_numeric($insert_value[4]) && is_numeric($insert_value[5]))
								{
									$insert = $this->Laundry_Register->Insert_Data_Laundry_Register($lr_sequence_no,$insert_value[0],$insert_value[1],$insert_value[2],$insert_value[3], $date_now, $_SESSION['login-info'][U_NAME],$insert_value[4],$insert_value[5]);
									$detele_detail_id = $this->Laundry_Detail->Delete_Laundry_Detail($select_id[LR_SEQUENCE_NO]);
									$select_detail_id = $this->Laundry_Register->Select_Conversion_Usage($insert_value[5],$insert_value[2]);
									//echo "<pre>",print_r($select_detail_id),"</pre>";
									foreach($select_detail_id as $value_detail_id)
									{
										$insert_detail_id = $this->Laundry_Detail->Insert_Data_Laundry_Detail($value_detail_id[CU_DETERGENT_CODE],mb_convert_encoding($value_detail_id[CU_AMOUNT_TO_USE],"UTF-8"));
									}
								}
							}
						}
						echo json_encode(array(
							"success" => true,
							"message" => $this->lang->line("message_import_success")
						));
						return;
					}
				}
				/* Import dữ liệu CSV Laundry Detail Atsugi */
				else if($_POST["production_data"] == "laundry_detail_atsugi")
				{
					if($accept)
					{
						$filename = EXCEL_PATH.$name;
						move_uploaded_file($tmp_link, $filename);
						$data = $this->Function_Import($filename,1);
						$this->load->model('Laundry_Register');
						$this->load->model('Laundry_Detail');		
						//echo "<pre>",print_r($data),"</pre>";
						foreach($data as $data_value)
						{
							foreach($data_value as $key_insert => $insert_value)
							{
								if($key_insert == 4)
								{
									$number_machine = $insert_value[0];
									//echo "<pre>",print_r($number_machine),"</pre>";
								}
								if($key_insert == 6)
								{
									$year = "20".$insert_value[2];
								}
								if($key_insert == 7)
								{
									$month = $insert_value[2];
								}
								if($key_insert == 8)
								{
									$day = $insert_value[2];
									$date_time_php = $year."/".$month."/".$day." 00:00:00";
									$select_id = $this->Laundry_Register->Select_Laundry_Equipment_Time($number_machine,$date_time_php);
									//echo "<pre>",print_r($select_id),"</pre>";
									if($select_id != null)
									{
										$detele_detail_id = $this->Laundry_Detail->Delete_Laundry_Detail($select_id[LR_SEQUENCE_NO]);
										$delete_register_id = $this->Laundry_Detail->Delete_Laundry_Date($number_machine,$date_time_php);
									}
								}
								if($key_insert >= 11)
								{
									if(is_numeric($insert_value[0]) && is_numeric($insert_value[2]))
									{
										if($insert_value[0] == "")
										{
											break;
										}
										else
										{
											//echo "<pre>",print_r($insert_value[0]),"</pre>";
											$select_conver_atsugi = $this->Laundry_Register->Select_Conversion_Usage_Atsugi($insert_value[0] ,$number_machine);
											//echo "<pre>",print_r($select_conver_atsugi),"</pre>";
											if($select_conver_atsugi != "")
											{
												$select_laundry_m = $this->Laundry_Detail->Select_Data_Laundry_M($select_conver_atsugi[LM_CODE]);
												//echo "<pre>",print_r($select_laundry_m),"</pre>";
												$laundry_m_weight = $select_laundry_m[LM_WEIGHT];
												if($insert_value[2] != 0)
												{
													for($i = 1; $i <= $insert_value[2];)
													{
														$lr_sequence_no_last = $this->Laundry_Register->Select_Data_Last_Laundry_ID();
														if($lr_sequence_no_last == "")
														{
															$lr_sequence_no = 1;
														}
														else
														{
															$lr_sequence_no = $lr_sequence_no_last[LR_SEQUENCE_NO] + 1;
														}
														$insert = $this->Laundry_Register->Insert_Data_Laundry_Register_Atsugi($lr_sequence_no,$date_time_php,$number_machine,$laundry_m_weight,$date_now, $_SESSION['login-info'][U_NAME],$insert_value[0]);
														$insert_detail_id = $this->Laundry_Detail->Insert_Data_Laundry_Detail($select_conver_atsugi[CU_DETERGENT_CODE],mb_convert_encoding($select_conver_atsugi[CU_AMOUNT_TO_USE],"UTF-8"));
														$i++;
													}
												}
											}
										}
									}
								}
							}
						}
						echo json_encode(array(
							"success" => true,
							"message" => $this->lang->line("message_import_success")
						));
						return;
					}
				}
				/* Import dữ liệu CSV Laundry Detail Tokyo */
				else if($_POST["production_data"] == "laundry_detail_tokyo")
				{
					if($accept)
					{
						$filename = EXCEL_PATH.$name;
						move_uploaded_file($tmp_link, $filename);
						$data = $this->Function_Import($filename,1);
						$this->load->model('Laundry_Register');
						$this->load->model('Laundry_Detail');
						foreach($data as $data_value)
						{
							foreach($data_value as $insert_value)
							{
								//echo "<pre>",print_r($insert_value[1]),"</pre>";
								$select_time = $this->Laundry_Register->Select_Laundry_Time($insert_value[1]);
								//echo "<pre>",print_r($select_time),"</pre>";
								if($select_time != "")
								{
									$detele_detail_id = $this->Laundry_Detail->Delete_Laundry_Detail($select_time[LR_SEQUENCE_NO]);
									$detele_register_id = $this->Laundry_Register->Delete_Laundry_Time($insert_value[1]);
								}
								$lr_sequence_no_last = $this->Laundry_Register->Select_Data_Last_Laundry_ID();
								if($lr_sequence_no_last == "")
								{
									$lr_sequence_no = 1;
								}
								else
								{
									$lr_sequence_no = $lr_sequence_no_last[LR_SEQUENCE_NO] + 1;
								}
								if(is_numeric($insert_value[0]) && is_numeric($insert_value[1]) && is_numeric($insert_value[2]) && is_numeric($insert_value[4]))
								{
									$insert_register = $this->Laundry_Register->Insert_Data_Laundry_Register_Atsugi($lr_sequence_no, $insert_value[1], $insert_value[2], $insert_value[4], $date_now, $_SESSION['login-info'][U_NAME],$insert_value[0]);
									$select_detail_id = $this->Laundry_Register->Select_Conversion_Usage($insert_value[0], $insert_value[2]);
									foreach($select_detail_id as $value_detail_id)
									{
										$insert_detail = $this->Laundry_Detail->Insert_Data_Laundry_Detail($value_detail_id[CU_DETERGENT_CODE], mb_convert_encoding($value_detail_id[CU_AMOUNT_TO_USE],"UTF-8"));
									}
								}
							}
						}
						echo json_encode(array(
							"success" => true,
							"message" => $this->lang->line("message_import_success")
						));
						return;
					}
				}
				else
				{
					echo json_encode(array(
						"success" => true,
						"message" => $this->lang->line("message_import_error")
					));
					return;
				}
			}
		}
		else
		{
			echo json_encode(array(
				"success" => true,
				"message" => $this->lang->line("message_import_error")
			));
			return;
		}
		
		echo json_encode(array(
			"success" => true,
			"message" => $this->lang->line("message_import_error")
		));
		return;
	}
}
?>