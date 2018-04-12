<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BusinessController extends VV_Controller {

	// Construct function
	public function __construct()
    { 
        parent::__construct();
		$this->load->library('mpdf');
		$this->load->library('helper','helper');
		$this->load->model('Report_Sale','report_sale_model');
		$this->load->model('Product','product_model');
		$this->load->model('Customer','customer_model');
		$this->load->model('Stock','stock_model');
		$this->load->model('Base_master','location_model');
		$this->load->model('Supplier','supplier_model');
		$this->load->model('Sales_Destination','sales_destination_model');
		$this->load->model('ImportExportCsv');
		$this->LOGIN_INFO = $this->session->userdata('login-info'); 
		$this->LEVEL = $this->session->userdata('request-level');

		// var
		$this->varTitle = "title";
		$this->varContent = "content";
		$this->varTemplateMaster = "templates/master";
    }

    /**
	* Function: index
	* 営業管理
	* @access public
	*/
	public function index() {
		$data[$this->varTitle] = $this->lang->line('business-management');
		$data['list_customer'] = $this->customer_model->getAll(0,20);
		$data[$this->varContent] = 'business/index';
		$this->load->view($this->varTemplateMaster, $data);
	}

	/**
	* Function: inventory
	* 在庫管理
	* @access public
	*/
    public function inventory() { 
		$data[$this->varTitle] = $this->lang->line('title_inventory');
		$data['list_stock'] = $this->location_model->getAll(0,200);
		$data['list_place_buy'] = $this->supplier_model->getAll(0,200);
		$data['list_place_sale'] = $this->sales_destination_model->getAll(0,200);
		$data[$this->varContent] = 'business/inventory';
		$this->load->view($this->varTemplateMaster, $data);
    }
 
    /**
	* Function: produce
	* @access public
	*/
    public function produce() {
		$data[$this->varTitle] = '生産管理';
		$data[$this->varContent] = 'business/produce';
		$this->load->view($this->varTemplateMaster, $data);
	}

	/**
	* Function: function_daily_schedule
	* @access public
	* @return Array
	*/
	public function function_daily_schedule($getDataModel){
		$arrData = array();
		$arrGroupReport = array();
		$arrDate = array();
		$arrDepartmentView = array();

		if($getDataModel != null && count($getDataModel) > 0) {
			foreach ($getDataModel as $key => $value) {
				array_push(
					$arrGroupReport,
					array(
						"id" => $value["group_id"],
						"name" => $value["group_name"],
						"type" => $value["group_type"]
					)
				);
				array_push(
					$arrDate,
					array(
						"date" => date("Y-m-d", strtotime($value["date_delivery"])),
					)
				);
			}
		
			// $arrGroupReport
			$arrGroupReport = array_map("unserialize", array_unique(array_map("serialize", $arrGroupReport)));
			$arrGroupReport = array_values($arrGroupReport);

			// $arrDate
			$arrDate = array_map("unserialize", array_unique(array_map("serialize", $arrDate)));
			$arrDate = array_values($arrDate);

			// Set Data to group
			if($arrDate != null) {
				foreach ($arrDate as $keyDate => $valueDate) {
					$arrDepartmentDaily = array();

					foreach ($arrGroupReport as $keyGroup => $valueGroup) {
						$totalGroup = 0;
						foreach ($getDataModel as $keyDetail => $valueDetail) {
							$dateDelivery = date("Y-m-d", strtotime($valueDetail["date_delivery"]));
							if($dateDelivery == $valueDate["date"] && $valueDetail["group_id"] == $valueGroup["id"]) {
								$totalGroup += $valueDetail["amout_delivery"];
							}
						}

						array_push(
							$arrDepartmentDaily,
							array(
								"id" => $valueGroup["id"],
								"name" => $valueGroup["name"],
								"type" => $valueGroup["type"],
								"value" => $totalGroup
							)
						);
					}
					
					array_push(
						$arrData,
						array(
							"date" => $valueDate["date"],
							"data" => $arrDepartmentDaily
						)
					);
				}
			}

			// Check department
			$arrDepartmentDaily = array_values($arrDepartmentDaily);
			if(count($arrDepartmentDaily) <= 8) {
				array_push(
					$arrDepartmentView,
					$arrDepartmentDaily
				);
			}
			else {
				$countArr = ceil(count($arrDepartmentDaily)/8);
				for ($i=0; $i < $countArr; $i++) { 
					$dem=8 * $i;
					$demEnd=$dem+8;
					$arrDepartmentViewDetail = array();
					for ($j=$dem; $j < $demEnd; $j++) { 
						if(isset($arrDepartmentDaily[$j])) {
							array_push(
								$arrDepartmentViewDetail,
								$arrDepartmentDaily[$j]
							);
						}
					}
					array_push(
						$arrDepartmentView,
						$arrDepartmentViewDetail
					);
				}
			}
		}
		
		return array(
        	"department"=>$arrDepartmentView, 
        	"detail"=>$arrData
		);
		
	}

	/**
    * Function: pdf_daily_schedule_a
	* @access public
	* @return PDF,CSV
    */
	public function pdf_daily_schedule_a() {
		$csv = $this->input->get('csv');

		$data = [];
		$data[$this->varTitle] = $this->lang->line('pdf_daily_schedule_a');
		$data['date_report_now'] = $this->helper->readDateNotText(date('Y/m/d'));
		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A3-L','','',15,15,25,16,9,9);
			$pdf->SetTitle($data[$this->varTitle]);
			$htmlHeader= $this->load->view('templates/business/report_sale/pdf_header_schedule', $data, true);
			$pdf->SetHTMLHeader($htmlHeader);
		}

		/* DATA */
		$getPrint = $this->input->get('print');
		$dataFrom = $this->input->get('from');
		$dataTo = $this->input->get('to');
		$datetime = date("Y-m-d");
		if($dataFrom == NULL) {
			$dataFrom = $this->helper->getFirtDayInMonth($datetime);
		} 
		if($dataTo == NULL) {
			$dataTo = $this->helper->getLastDayInMonth($datetime);
		}

		$getDataModel = $this->report_sale_model->getRevenueSale($dataFrom,$dataTo,2);

		$getDataSchedule = $this->function_daily_schedule($getDataModel);

		$arrDepartmentView = $getDataSchedule['department'];
		$arrData = $getDataSchedule['detail'];
        $data['department'] = $arrDepartmentView;
		$data['detail'] = $arrData;
        /* END DATA */

		if($csv !== 'true') {
			// Export PDF
			$html= $this->load->view('templates/business/pdf_daily_schedule_template', $data, true);

			// write the HTML into the PDF
			$pdf->WriteHTML($html);


			// Add Page
			$isTotal = false;
			$dem=0;
			$totalAmount = 0;
			if($arrDepartmentView != null) {
				// Total
				if($arrData != null) {
					foreach ($arrData as $key => $value) {
						if($value['data'] != null) {
							foreach ($value['data'] as $key2 => $value2) {
								if($value2["type"] == 0) {
									$totalAmount += $value2['value'];
								}
							}
						}
					}
				}
				foreach ($arrDepartmentView as $key => $value) {
					$isTotal = false;
					
					if($key == (count($arrDepartmentView)-1)) {
						$isTotal = true;
					}
					
					$data['totalAmount'] = $totalAmount * CONFIG_CONSUMPTION_TAX;
					$data['valueControl'] = 0;
					$data['valueYukata'] = 0;
					$data['valueTotal'] = $totalAmount + $data['totalAmount'];
					$data['valueGrossTotal'] = $totalAmount + $data['totalAmount'];
					$data['isTotal'] = $isTotal;
					$data['detail_page'] = $value;
					$pdf->AddPage();
					$htmlPre = $html= $this->load->view('templates/business/report_sale/pdf_content_schedule_a', $data, true);
					$pdf->WriteHTML($htmlPre);
				}
			}

			$pdf->DeletePages(1);
			$output = $data[$this->varTitle].'.pdf';

			if($getPrint === 'true') { 
				$pdf->SetJS('this.print();');
			}

			if($getDataModel == null || count($getDataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			
			$pdf->Output("$output", 'I'); 
		} else {
			// Export Csv
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data[$this->varTitle], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding($data['date_report_now'], "UTF-8"))
			);
			
			array_push(
				$data_export,
				array("")
			);

			// Title
			if($arrDepartmentView != null && count($arrDepartmentView) > 0) {
				$data_export_title = array();
				array_push(
					$data_export_title,
					mb_convert_encoding("売上日", "UTF-8")
				);
				foreach ($arrDepartmentView[0] as $key => $value) {
					if($value["type"] == 0 || $value["type"] == '0') {
						array_push(
							$data_export_title,
							mb_convert_encoding($value['name'], "UTF-8")
						);
					}
				}
				array_push(
					$data_export_title,
					mb_convert_encoding("売上合計額", "UTF-8")
				);
				array_push(
					$data_export,
					$data_export_title
				);
			}

			$totalAll = 0;
			$valueControl = 0;
			$valueYukata = 0;
			if($arrData != null) {
				foreach ($arrData as $key => $value) {
					$data_export_detail = array();
					if($value['data'] != null) {
						$totalAmount = 0;
						array_push(
							$data_export_detail,
							$value['date']
						);
						foreach ($value['data'] as $keyDetail => $valueDetail) {
							if($value["type"] == 0 || $value["type"] == '0') {
								array_push(
									$data_export_detail,
									$valueDetail['value']
								);
								$totalAmount += $valueDetail['value'];
								$totalAll += $valueDetail['value'];
							}

							if($value["type"] == 1 || $value["type"] == '1') {
								$valueControl += $value['value'];
							}
							if($value["type"] == 2 || $value["type"] == '2') {
								$valueYukata += $value['value'];
							}
						}
						array_push(
							$data_export_detail,
							$totalAmount
						);
					}
					array_push(
						$data_export,
						$data_export_detail
					);
				}
			}

			array_push(
				$data_export,
				array("")
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("合計額 :", "UTF-8"),$totalAll)
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("リネン補充費 :", "UTF-8"),($totalAll * CONFIG_CONSUMPTION_TAX))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("ｺﾝﾄﾛｰﾙ :", "UTF-8"),$valueControl)
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("浴衣補充費 :", "UTF-8"),$valueYukata)
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("合　　　 計 :", "UTF-8"),($totalAll + ($totalAll * CONFIG_CONSUMPTION_TAX) + $valueControl + $valueYukata))
			);

			$this->ImportExportCsv->download_send_header_csv($data[$this->varTitle]);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
    * Function: pdf_daily_schedule_b
	* @access public
	* @return PDF,CSV
    */
	public function pdf_daily_schedule_b() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A3-L','','',15,15,25,16,9,9);
		}
		$data = [];
		/* DATA */
		$dataFrom = $this->input->get('from');
		$dataTo = $this->input->get('to');
		$datetime = date("Y-m-d");
		if($dataFrom == NULL) {
			$dataFrom = $this->helper->getFirtDayInMonth($datetime);
		}
		if($dataTo == NULL) {
			$dataTo = $this->helper->getLastDayInMonth($datetime);
		}

		$data[$this->varTitle] = $this->lang->line('pdf_daily_schedule_b');
		if($dataFrom == NULL && $dataFrom == NULL) {
			if(date('t') == date('d')) {
				$data[$this->varTitle] = $this->lang->line('pdf_daily_schedule_c');
			}
		}
		else {
			if(date('d',strtotime($dataFrom)) == 1 && date('d',strtotime($dataTo)) == date('t',strtotime($dataTo))) {
				$data[$this->varTitle] = $this->lang->line('pdf_daily_schedule_c');
			}
		}
		
		$data['date_report_now'] = $this->helper->readDateNotText(date('Y/m/d'));
		if($csv !== 'true') {
			$pdf->SetTitle($data[$this->varTitle]);
			$htmlHeader= $this->load->view('templates/business/report_sale/pdf_header_schedule', $data, true);
			$pdf->SetHTMLHeader($htmlHeader);
		}
		
		$getDataModel = $this->report_sale_model->getRevenueSale($dataFrom,$dataTo,1);

		$getDataSchedule = $this->function_daily_schedule($getDataModel);

		$arrDepartmentView = $getDataSchedule['department'];
		$arrData = $getDataSchedule['detail'];
		$data['department'] = $arrDepartmentView;
		$data['detail'] = $arrData;
		/* END DATA */

		if($csv !== 'true') {
			$html= $this->load->view('templates/business/pdf_daily_schedule_template', $data, true);

			// write the HTML into the PDF
			$pdf->WriteHTML($html);


			// Add Page
			$isTotal = false;
			$dem=0;
			$totalAmount = 0;
			if($arrDepartmentView != null) {
				// Total
				if($arrData != null) {
					foreach ($arrData as $key => $value) {
						if($value['data'] != null) {
							foreach ($value['data'] as $key2 => $value2) {
								if($value2["type"] == 0) {
									$totalAmount += $value2['value'];
								}
							}
						}
					}
				}
				foreach ($arrDepartmentView as $key => $value) {
					$isTotal = false;
					
					if($key == (count($arrDepartmentView)-1)) {
						$isTotal = true;
					}
					
					$data['valueTotal'] = $totalAmount + $data['totalAmount'];
					$data['isTotal'] = $isTotal;
					$data['detail_page'] = $value;
					$pdf->AddPage();
					$htmlPre = $html= $this->load->view('templates/business/report_sale/pdf_content_schedule_b', $data, true);
					$pdf->WriteHTML($htmlPre);
				}
			}

			$pdf->DeletePages(1);
			$output = $data[$this->varTitle].'.pdf';
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') {
				$pdf->SetJS('this.print();');
			}
			if($getDataModel == null || count($getDataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I');
		} else {
			// Export Csv
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data[$this->varTitle], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding($data['date_report_now'], "UTF-8"))
			);
			array_push(
				$data_export,
				array("")
			);

			// Title
			if($arrDepartmentView != null && count($arrDepartmentView) > 0) {
				$data_export_title = array();
				array_push(
					$data_export_title,
					mb_convert_encoding("売上日", "UTF-8")
				);
				foreach ($arrDepartmentView[0] as $key => $value) {
					if($value["type"] == 0 || $value["type"] == '0') {
						array_push(
							$data_export_title,
							mb_convert_encoding($value['name'], "UTF-8")
						);
					}
				}
				array_push(
					$data_export_title,
					mb_convert_encoding("売上合計額", "UTF-8")
				);
				array_push(
					$data_export,
					$data_export_title
				);
			}

			$totalAll = 0;
			if($arrData != null) {
				foreach ($arrData as $key => $value) {
					$data_export_detail = array();
					if($value['data'] != null) {
						$totalAmount = 0;
						array_push(
							$data_export_detail,
							$value['date']
						);
						foreach ($value['data'] as $keyDetail => $valueDetail) {
							if($value["type"] == 0 || $value["type"] == '0') {
								array_push(
									$data_export_detail,
									$valueDetail['value']
								);
								$totalAmount += $valueDetail['value'];
								$totalAll += $valueDetail['value'];
							}
						}
						array_push(
							$data_export_detail,
							$totalAmount
						);
					}
					array_push(
						$data_export,
						$data_export_detail
					);
				}
			}

			array_push(
				$data_export,
				array("")
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("合 計 :", "UTF-8"),$totalAll)
			);

			$this->ImportExportCsv->download_send_header_csv($data[$this->varTitle]);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}
	
	/**
    * Function: function_pdf_report_sales
	* @access public
	* @return Array
    */
	public function function_pdf_report_sales($getDataModel) {

        $arrCategory = array();
		
		if($getDataModel != null) {
			foreach ($getDataModel as $key => $value) {
				array_push(
					$arrCategory,
					array(
						"group_code" => $value["group_code"],
						"code" => $value["group_name"]
					)
				);
			}
		}
		
		// $arrGroupReport
		$arrCategory = array_map("unserialize", array_unique(array_map("serialize", $arrCategory)));
		$arrCategory = array_values($arrCategory);

        return array(
        	"meta"=>$arrCategory,
        	"detail"=>$getDataModel
        );
	}

	/**
    * Function: function_pdf_report_sales_product
	* @access public
	* @return Array
    */
	public function function_pdf_report_sales_product($getDataModel) {
		$arrCategory = array();
		$arrProduct = array();
		
		if($getDataModel != null) {
			foreach ($getDataModel as $key => $value) {
				array_push(
					$arrCategory,
					array(
						"group_code" => $value["group_code"],
						"code" => $value["group_name"]
					)
				);
				array_push(
					$arrProduct,
					array(
						"group_code" => $value["group_code"],
						"product_name" => $value["product_name"],
						"product_code" => $value["product_code"],
						"product_format" => $value["product_format"],
						"product_color" => $value["product_color"],
					)
				);
			}
		}
		
		// $arrGroupReport
		$arrCategory = array_map("unserialize", array_unique(array_map("serialize", $arrCategory)));
		$arrCategory = array_values($arrCategory);

		$arrProduct = array_map("unserialize", array_unique(array_map("serialize", $arrProduct)));
		$arrProduct = array_values($arrProduct);

        return array(
			"meta"=>$arrCategory,
			"group_product"=>$arrProduct,
        	"detail"=>$getDataModel
        );
	}

	/**
    * Function: function_pdf_report_sales_customer
	* @access public
	* @return Array
    */
	public function function_pdf_report_sales_customer($getDataModel) {
		$arrCategory = array();
		$arrDepartment = array();
		
		if($getDataModel != null) {
			foreach ($getDataModel as $key => $value) {
				array_push(
					$arrCategory,
					array(
						"group_code" => $value["group_code"],
						"code" => $value["group_name"]
					)
				);
				array_push(
					$arrDepartment,
					array(
						"department_code" => $value["department_code"],
						"department_name" => $value["department_name"],
						"group_code" => $value["group_code"]
					)
				);
			}
		}
		
		// $arrGroupReport
		$arrCategory = array_map("unserialize", array_unique(array_map("serialize", $arrCategory)));
		$arrCategory = array_values($arrCategory);

		$arrDepartment = array_map("unserialize", array_unique(array_map("serialize", $arrDepartment)));
		$arrDepartment = array_values($arrDepartment);

        return array(
			"meta"=>$arrCategory,
			"department"=>$arrDepartment,
        	"detail"=>$getDataModel
        );
	}

	/**
    * Function: get_date_by_sales
    * @access public
    */
	public function get_date_by_sales($dataFrom, $dataTo) {
		$date = "";
		$dataFrom = date('Y/m/d',strtotime($dataFrom));
		$dataTo = date('Y/m/d',strtotime($dataTo));

		if($dataFrom == $dataTo) {
			$date = $dataFrom;
		}
		else{
			$dateFirstYear = date('Y/m/d',strtotime("first day of january ".date('Y',strtotime($dataFrom))) );
			$dateLastYear = date('Y/m/d',strtotime("last day of december ".date('Y',strtotime($dataTo))) );
			$dateFirstMonth = date('Y/m/d',strtotime("first day of ".date('F',strtotime($dataFrom))) );
			$dateLastMonth = date('Y/m/d',strtotime("last day of ".date('F',strtotime($dataTo))) );

			if($dateFirstYear == $dataFrom && $dateLastYear == $dataTo) {
				$date = date('Y',strtotime($dataFrom));
			}
			else if($dateFirstMonth == $dataFrom && $dateLastMonth == $dataTo) {
				$date = date('Y/m/d',strtotime($dataFrom))." ～ 末";
			}
			else {
				$dateYearFirst = date('Y',strtotime($dataFrom));
				$dateYearLast = date('Y',strtotime($dataTo));
				$dateMonthFirst = date('m',strtotime($dataFrom));
				$dateMonthLast = date('m',strtotime($dataTo));
				if($dateYearFirst == $dateYearLast && $dateMonthFirst == $dateMonthLast) {
					$date = date('Y/m/d',strtotime($dataFrom))." ~ ".date('d',strtotime($dataTo));
				}
				else {
					$date = date('Y/m/d',strtotime($dataFrom))." ~ ".date('Y/m/d',strtotime($dataTo));
				}
			}
		}

		return $date;
	}

	/**
    * Function: pdf_sales_score
	* @access public
	* @return PDF,CSV
    */
	public function pdf_sales_score() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A3-L','','',15,15,25,16,9,9);
		}

		$data = [];
		$data[$this->varTitle] = $this->lang->line('pdf_sales_score');
		$data['date_report_now'] = $this->helper->readDate(date("Y/m/d"));

		if($csv !== 'true') {
			$pdf->SetTitle($data[$this->varTitle]);
			$htmlHeader= $this->load->view('templates/business/report_sale/pdf_header_schedule', $data, true);
			$pdf->SetHTMLHeader($htmlHeader);
		}

		/* DATE */
		$dataFrom = $this->input->get('from');
		$dataTo = $this->input->get('to');
		$dateType = $this->input->get('date_report');
		$datetime = date("Y-m-d");
		if($dataFrom == NULL) {
			if($dateType == 1) {
				$dataFrom = date("Y/m/d");
			}
			else if($dateType == 2) {
				$dataFrom = $this->helper->getFirtDayInWeekly($datetime);
			}
			else if($dateType == 3) {
				$dataFrom = $this->helper->getFirtDayInMonth($datetime);
			}
			else {
				$dataFrom = date('Y/m/d',strtotime("first day of january ".date('Y')) );
			}
		}
		if($dataTo== NULL) {
			if($dateType == 1) {
				$dataTo = date("Y/m/d");
			}
			else if($dateType == 2) {
				$dataTo = $this->helper->getLastDayInWeekly($datetime);
			}
			else if($dateType == 3) {
				$dataTo = $this->helper->getLastDayInMonth($datetime);
			}
			else {
				$dataTo = date('Y/m/d',strtotime("last day of december ".date('Y')) );
			}
			
		}

		/* DATA */
		$getDataModel = $this->report_sale_model->getRevenueByProduct($dataFrom,$dataTo,"","","",1);
        $getDetailSchedule = $this->function_pdf_report_sales($getDataModel);
        $arrCategoryView = $getDetailSchedule["meta"];
        $arrData = $getDetailSchedule["detail"];

		$data['detail'] = $arrData;
		/* END DATA */
		
		if($csv !== 'true') {
			$html= $this->load->view('templates/business/pdf_daily_schedule_template', $data, true);

			// write the HTML into the PDF
			$pdf->WriteHTML($html);


			// Add Page
			if($arrCategoryView != null) {
				$data['date_report'] = $this->get_date_by_sales($dataFrom, $dataTo);
				foreach ($arrCategoryView as $key => $value) {
					$data['category'] = $value;
					$data['detail'] = $arrData;
					$pdf->AddPage();
					$htmlPre = $html= $this->load->view('templates/business/report_sale/pdf_content_sales_score', $data, true);
					$pdf->WriteHTML($htmlPre);
				}
			}

			$pdf->DeletePages(1);
			$output = $data[$this->varTitle].'.pdf';
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') {
				$pdf->SetJS('this.print();');
			}
			if($getDataModel == null || count($getDataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I');
		} else {
			// Export Csv
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data[$this->varTitle], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding($data['date_report_now'], "UTF-8"))
			);
			array_push(
				$data_export,
				array("")
			);

			// Data
			if($arrCategoryView != null) {
				$totalNumberAll = 0;
				$totalAmountAll = 0;
				foreach ($arrCategoryView as $keyCate => $valueCate) {
					$totalNumber = 0;
					$totalAmount = 0;
					array_push(
						$data_export,
						array(mb_convert_encoding("ｸﾞﾙｰﾌﾟｺｰﾄﾞ:", "UTF-8"),$valueCate["group_code"])
					);
					array_push(
						$data_export,
						array(mb_convert_encoding("グループ:", "UTF-8"),mb_convert_encoding($valueCate['code'], "UTF-8"))
					);
					array_push(
						$data_export,
						array(
							mb_convert_encoding("売上日", "UTF-8"),
							mb_convert_encoding("商品コード", "UTF-8"),
							mb_convert_encoding("商品名", "UTF-8"),
							mb_convert_encoding("数量", "UTF-8"),
							mb_convert_encoding("ＣＯＬＯＲ", "UTF-8"),
							mb_convert_encoding("数量の合計", "UTF-8"),
							mb_convert_encoding("単価", "UTF-8"),
							mb_convert_encoding("金額", "UTF-8"),
						)
					);

					if($arrData != null) {
						foreach ($arrData as $key => $value) {
							if($valueCate["group_code"] == $value["group_code"]) {
								array_push(
									$data_export,
									array(
										$value['date_delivery'],
										$value['product_code'],
										mb_convert_encoding($value['product_name'], "UTF-8"),
										mb_convert_encoding($value['product_format'], "UTF-8"),
										mb_convert_encoding($value['product_color'], "UTF-8"),
										$value['product_quantity'],
										$value['product_price'],
										$value['product_amount']
									)
								);
								$totalNumber += $value['product_quantity'];
								$totalAmount += $value['product_amount'];
								$totalNumberAll += $value['product_quantity'];
								$totalAmountAll += $value['product_amount'];
							}
						}
					}

					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							mb_convert_encoding("合 計", "UTF-8"),
							mb_convert_encoding($totalNumber, "UTF-8"),
							"",
							mb_convert_encoding($totalAmount, "UTF-8"),
						)
					);
				}

				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						"",
						mb_convert_encoding("総合計", "UTF-8"),
						mb_convert_encoding($totalNumberAll, "UTF-8"),
						"",
						mb_convert_encoding($totalAmountAll, "UTF-8"),
					)
				);
			}

			$this->ImportExportCsv->download_send_header_csv($data[$this->varTitle]);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}
 
	/**
    * Function: pdf_sales_product
	* @access public
	* @return PDF,CSV
    */
	public function pdf_sales_product() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A3-L','','',15,15,25,16,9,9);
			$pdf->page = 0;
		}

		$data = [];
		$data[$this->varTitle] = $this->lang->line('pdf_sales_product');
		$data['date_report_now'] = $this->helper->readDate(date("Y/m/d"));

		if($csv !== 'true') {
			$pdf->SetTitle($data[$this->varTitle]);
			$htmlHeader= $this->load->view('templates/business/report_sale/pdf_header_schedule', $data, true);
			$pdf->SetHTMLHeader($htmlHeader);
		}

		/* DATE */
		$getProduct = $this->input->get('product');
		$dataFrom = $this->input->get('from');
		$dataTo = $this->input->get('to');
		$dateType = $this->input->get('date_report');
		$datetime = date("Y-m-d");
		if($dataFrom == NULL) {
			if($dateType == 1) {
				$dataFrom = date("Y/m/d");
			}
			else if($dateType == 2) {
				$dataFrom = $this->helper->getFirtDayInWeekly($datetime);
			}
			else if($dateType == 3) {
				$dataFrom = $this->helper->getFirtDayInMonth($datetime);
			}
			else {
				$dataFrom = date('Y/m/d',strtotime("first day of january ".date('Y')) );
			}
		}
		if($dataTo== NULL) {
			if($dateType == 1) {
				$dataTo = date("Y/m/d");
			}
			else if($dateType == 2) {
				$dataTo = $this->helper->getLastDayInWeekly($datetime);
			}
			else if($dateType == 3) {
				$dataTo = $this->helper->getLastDayInMonth($datetime);
			}
			else {
				$dataTo = date('Y/m/d',strtotime("last day of december ".date('Y')) );
			}
			
		}

		/* DATA */
		$getDataModel = $this->report_sale_model->getRevenueByProduct($dataFrom,$dataTo,"",$getProduct,"",2);
		$getDetailSchedule = $this->function_pdf_report_sales_product($getDataModel);
		$arrCategoryView = $getDetailSchedule["meta"];
		$arrData = $getDetailSchedule["detail"];

		$data['detail'] = $arrData;
		$data['group_product'] = $getDetailSchedule["group_product"];
		/* END DATA */

		if($csv !== 'true') {
			$html= $this->load->view('templates/business/pdf_daily_schedule_template', $data, true);

			// write the HTML into the PDF
			$pdf->WriteHTML($html);


			// Add Page
			if($arrCategoryView != null) {
				$data['date_report'] = $this->get_date_by_sales($dataFrom, $dataTo);
				foreach ($arrCategoryView as $key => $value) {
					$data['category'] = $value;
					$pdf->AddPage();
					$htmlPre = $html= $this->load->view('templates/business/report_sale/pdf_content_sales_product', $data, true);
					$pdf->WriteHTML($htmlPre);
				}
			}

			$pdf->DeletePages(1);
			$output = $data[$this->varTitle].'.pdf';
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') {
				$pdf->SetJS('this.print();');
			}
			if($getDataModel == null || count($getDataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I');
		} else {
			// Export Csv
			$detail = $data['detail'];
			$group_product = $data['group_product'];
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data[$this->varTitle], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding($data['date_report_now'], "UTF-8"))
			);
			array_push(
				$data_export,
				array("")
			);

			// Data
			if($arrCategoryView != null) {
				$totalQuantityAll = 0;
                $totalAmountAll = 0;
				foreach ($arrCategoryView as $keyCate => $valueCate) {
					$totalNumber = 0;
					$totalAmount = 0;
					array_push(
						$data_export,
						array(mb_convert_encoding("グループコード:", "UTF-8"),$valueCate["group_code"])
					);
					array_push(
						$data_export,
						array(mb_convert_encoding("グループ名:", "UTF-8"),mb_convert_encoding($valueCate['code'], "UTF-8"))
					);
					array_push(
						$data_export,
						array(
							mb_convert_encoding("売上日", "UTF-8"),
							mb_convert_encoding("商品コード", "UTF-8"),
							mb_convert_encoding("商品名", "UTF-8"),
							mb_convert_encoding("規格", "UTF-8"),
							mb_convert_encoding("ＣＯＬＯＲ", "UTF-8"),
							mb_convert_encoding("部署ｺｰﾄﾞ", "UTF-8"),
							mb_convert_encoding("部署名 ", "UTF-8"),
							mb_convert_encoding("数量合計", "UTF-8"),
							mb_convert_encoding("単価", "UTF-8"),
							mb_convert_encoding("金額", "UTF-8"),
						)
					);

					if($arrData != null) {
						foreach ($arrData as $key => $value) {
							if($valueCate["group_code"] == $value["group_code"]) {
								array_push(
									$data_export,
									array(
										$value['date_delivery'],
										$value['product_code'],
										mb_convert_encoding($value['product_name'], "UTF-8"),
										mb_convert_encoding($value['product_format'], "UTF-8"),
										mb_convert_encoding($value['product_color'], "UTF-8"),
										$value['department_code'],
										mb_convert_encoding($value['department_name'], "UTF-8"),
										$value['product_quantity'],
										$value['product_price'],
										$value['product_amount']
									)
								);
								$totalNumber += $value['product_quantity'];
								$totalAmount += $value['product_amount'];
								$totalQuantityAll += $value['product_quantity'];
								$totalAmountAll += $value['product_amount'];
							}
						}
					}
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding("合計", "UTF-8"),
							mb_convert_encoding($totalNumber, "UTF-8"),
							"",
							mb_convert_encoding($totalAmount, "UTF-8"),
						)
					);
				}

				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						"",
						"",
						"",
						mb_convert_encoding("総合計", "UTF-8"),
						mb_convert_encoding($totalQuantityAll, "UTF-8"),
						"",
						mb_convert_encoding($totalAmountAll, "UTF-8"),
					)
				);
			}

			$this->ImportExportCsv->download_send_header_csv($data[$this->varTitle]);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
    * Function: pdf_sales_customer
	* @access public
	* @return PDF,CSV
    */
	public function pdf_sales_customer() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A3-L','','',15,15,25,16,9,9);
			$pdf->page = 0;
		}

		$data = [];
		$data[$this->varTitle] = $this->lang->line('pdf_sales_customer');
		$data['date_report_now'] = $this->helper->readDate(date("Y/m/d"));

		if($csv !== 'true') {
			$pdf->SetTitle($data[$this->varTitle]);
			$htmlHeader= $this->load->view('templates/business/report_sale/pdf_header_schedule', $data, true);
			$pdf->SetHTMLHeader($htmlHeader);
		}

		/* DATE */
		$getCustomer = $this->input->get('customer');
		$dataFrom = $this->input->get('from');
		$dataTo = $this->input->get('to');
		$dateType = $this->input->get('date_report');
		$datetime = date("Y-m-d");
		if($dataFrom == NULL) {
			if($dateType == 1) {
				$dataFrom = date("Y/m/d");
			}
			else if($dateType == 2) {
				$dataFrom = $this->helper->getFirtDayInWeekly($datetime);
			}
			else if($dateType == 3) {
				$dataFrom = $this->helper->getFirtDayInMonth($datetime);
			}
			else {
				$dataFrom = date('Y/m/d',strtotime("first day of january ".date('Y')) );
			}
		}
		if($dataTo== NULL) {
			if($dateType == 1) {
				$dataTo = date("Y/m/d");
			}
			else if($dateType == 2) {
				$dataTo = $this->helper->getLastDayInWeekly($datetime);
			}
			else if($dateType == 3) {
				$dataTo = $this->helper->getLastDayInMonth($datetime);
			}
			else {
				$dataTo = date('Y/m/d',strtotime("last day of december ".date('Y')) );
			}
		}

		/* DATA */
		$getDataModel = $this->report_sale_model->getRevenueByProduct($dataFrom,$dataTo,$getCustomer,"","",2);
        $getDetailSchedule = $this->function_pdf_report_sales_customer($getDataModel);
		$arrCategoryView = $getDetailSchedule["meta"];
		$arrData = $getDetailSchedule["detail"];

		$data['detail'] = $arrData;
		$data['department'] = $getDetailSchedule["department"];
		/* END DATA */

		if($csv !== 'true') {
			$html= $this->load->view('templates/business/pdf_daily_schedule_template', $data, true);

			// write the HTML into the PDF
			$pdf->WriteHTML($html);

			// Add Page
			if($arrCategoryView != null) {
				$data['date_report'] = $this->get_date_by_sales($dataFrom, $dataTo);
				foreach ($arrCategoryView as $key => $value) {
					$data['category'] = $value;
					$pdf->AddPage();
					$htmlPre = $html= $this->load->view('templates/business/report_sale/pdf_content_sales_customer', $data, true);
					$pdf->WriteHTML($htmlPre);
				}
			}

			$pdf->DeletePages(1);
			$output = $data[$this->varTitle].'.pdf';
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') {
				$pdf->SetJS('this.print();');
			}
			if($getDataModel == null || count($getDataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I');
		} else {
			// Export Csv
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data['date_report_now'], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding($data[$this->varTitle], "UTF-8"))
			);
			array_push(
				$data_export,
				array("")
			);

			// Data
			if($arrCategoryView != null) {
				$totalNumberAll = 0;
				$totalAmountAll = 0;
				foreach ($arrCategoryView as $keyCate => $valueCate) {
					$totalNumber = 0;
					$totalAmount = 0;
					array_push(
						$data_export,
						array(mb_convert_encoding("グループコード:", "UTF-8"),$valueCate["group_code"])
					);
					array_push(
						$data_export,
						array(mb_convert_encoding("グループ名:", "UTF-8"),mb_convert_encoding($valueCate['code'], "UTF-8"))
					);
					array_push(
						$data_export,
						array(
							mb_convert_encoding("売上日", "UTF-8"),
							mb_convert_encoding("部署ｺｰﾄﾞ", "UTF-8"),
							mb_convert_encoding("部署名", "UTF-8"),
							mb_convert_encoding("商品コード", "UTF-8"),
							mb_convert_encoding("商品名", "UTF-8"),
							mb_convert_encoding("規格", "UTF-8"),
							mb_convert_encoding("ＣＯＬＯＲ ", "UTF-8"),
							mb_convert_encoding("数量の合計", "UTF-8"),
							mb_convert_encoding("単価", "UTF-8"),
							mb_convert_encoding("金額", "UTF-8"),
						)
					);

					if($arrData != null) {
						foreach ($arrData as $key => $value) {
							if($valueCate["group_code"] == $value["group_code"]) {
								array_push(
									$data_export,
									array(
										$value['date_delivery'],
										$value['department_code'],
										mb_convert_encoding($value['department_name'], "UTF-8"),
										$value['product_code'],
										mb_convert_encoding($value['product_name'], "UTF-8"),
										mb_convert_encoding($value['product_format'], "UTF-8"),
										mb_convert_encoding($value['product_color'], "UTF-8"),
										$value['product_quantity'],
										$value['product_price'],
										$value['product_amount']
									)
								);
								$totalNumber += $value['product_quantity'];
								$totalAmount += $value['product_amount'];
								$totalNumberAll += $value['product_quantity'];
								$totalAmountAll += $value['product_amount'];
							}
						}
					}
		

					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding("小計 ", "UTF-8"),
							mb_convert_encoding($totalNumber, "UTF-8"),
							"",
							mb_convert_encoding($totalAmount, "UTF-8"),
						)
					);
				}

				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						"",
						"",
						"",
						mb_convert_encoding("総合計", "UTF-8"),
						mb_convert_encoding($totalNumberAll, "UTF-8"),
						"",
						mb_convert_encoding($totalAmountAll, "UTF-8"),
					)
				);
			}

			$this->ImportExportCsv->download_send_header_csv($data[$this->varTitle]);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}
}
