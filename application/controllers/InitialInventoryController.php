<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InitialInventoryController extends VV_Controller {

	// Construct function
	public function __construct()  
    { 
        parent::__construct();
		$this->load->library('helper','helper');
		$this->load->model('Initial_Inventory','initial_inventory_model'); 
		$this->load->library('mpdf');
		$this->load->model('ImportExportCsv');
    }
	

	/**
	* Function: pdf_initial_inventory
	* Vòng xoáy bảng line
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_initial_inventory() {
        $data['title'] = "商品回転率";
        $review = $this->input->get('review');
        $csv = $this->input->get('csv');
		$base_code = $this->input->get('base_code');
		$type_product = $this->input->get('type_product');
		$date_from = $this->input->get('from');
		$date_to = $this->input->get('to');
		$date_exp = $this->helper->readDateOneYear($date_to); // thời gian tìm kiếm vòng xoay trong vòng 1 năm
        $data['exp_from'] = $date_from;
        $data['exp_to'] = $date_to;
        $datetime = new DateTime($date);

		$arrayNumberInitial = $this->initial_inventory_model->getListNumberInitial($date_to,$date_exp,$base_code,$type_product);
        $arrayProductInitial = array();
        $arrayResult = array();

        // year - month - day of from
        $yearFrom = date('Y',strtotime($date_from));
        $monthFrom = date('m',strtotime($date_from)); 
        $dayFrom = date('d',strtotime($date_from));

        // year - month - day of to
        $yearEnd = date('Y',strtotime($date_to));
        $monthEnd = date('m',strtotime($date_to));
        $dayEnd = date('d',strtotime($date_to));
		foreach ($arrayNumberInitial as $key => $value) {
			$arrayDetailInitial = array();
            
            $yearFirst = date('Y',strtotime($value['date_initial']));
            $monthFirst = date('m',strtotime($value['date_initial']));
            $date_initial = $this->helper->readDateMMYY($value['date_initial']);
            $countMonth = ($monthEnd-$monthFirst);
            $day_initial_from = "01";
            $day_initial_to = "31";
            if(($yearEnd-$yearFirst) > 0) {
                $countMonth = ($monthEnd+(12-$monthFirst));
            } else {
                // Trùng tháng
                if($monthEnd == $monthFirst) {
                    $countMonth = 1;
                }
            }
            $countDate = ($yearEnd-$yearFirst) + $countMonth;
            $number_initial = $value['number_initial'];
            $number_initial_first = $value['number_initial'];
            $number_export_all = 0;
            $number_disposal_all = 0;
            for ($i=0; $i < $countDate; $i++) { 
                if($monthFirst > 12) {
                    $monthFirst = 1;
                    $yearFirst++;
                }
                if($yearFirst == $yearFrom && $monthFirst == $monthFrom) {
                    $day_initial_from = $dayFrom;
                } else {
                    $day_initial_from = "01";
                }
                if($yearFirst == $yearEnd && $monthFirst == $monthEnd) {
                    $day_initial_to = $dayEnd;
                } else {
                    $day_initial_to = "31";
                }
                $date_initial_from = $yearFirst.'/'.$monthFirst.'/'.$day_initial_from;
                $date_initial_to = $yearFirst.'/'.$monthFirst.'/'.$day_initial_to;
                $date_initial = $this->helper->readDateMMYY($date_initial_from);

                // Number
                $number_delivery = $this->initial_inventory_model->getNumberDelivery($value['product_id'],$date_initial_from,$date_initial_to,$base_code);
                $number_disposal = $this->initial_inventory_model->getNumberDisposal($value['product_id'],$date_initial_from,$date_initial_to,$base_code);
                $number_export = $this->initial_inventory_model->getNumberExport($value['product_id'],$date_initial_from,$date_initial_to,$base_code);
                $number_export_all += $number_export;
                $number_disposal_all += $number_disposal;
                $number_initial += ($number_export-$number_disposal);
                $monthFirst++;
            }
            
			array_push(
				$arrayProductInitial,
				array(
                    "date_initial"=>$value['date_initial'],
                    "product_id"=>$value['product_id'],
                    "product_code_sell"=>$value['product_code_sell'],
                    "product_name_sell"=>$value['product_name_sell'],
                    "product_format"=>$value['product_format'],
                    "product_color"=>$value['product_color'],
                    "number_initial"=>$number_initial_first,
                    "number_export"=>$number_export_all,
                    "number_disposal"=>$number_disposal_all,
                    "number_product"=>$number_initial,
                    "detail"=> $arrayDetailInitial
				)
			);
        }


        $arrayProductInitialView = array();

        if($arrayProductInitial != null) {
            foreach ($arrayProductInitial as $key => $value) {
                $number_delivery = $this->initial_inventory_model->getNumberDelivery($value['product_id'],$date_from,$date_to,$base_code);
                array_push(
                    $arrayProductInitialView,
                    array(
                        "date_initial"=>$value['date_initial'],
                        "product_id"=>$value['product_id'],
                        "product_code_sell"=>$value['product_code_sell'],
                        "product_name_sell"=>$value['product_name_sell'],
                        "product_format"=>$value['product_format'],
                        "product_color"=>$value['product_color'],
                        "number_initial"=>$value['number_initial'],
                        "number_export"=>$value['number_export'],
                        "number_disposal"=>$value['number_disposal'],
                        "number_product"=>$value['number_product'],
                        "number_delivery"=>$number_delivery,
                    )
                );
            }
        }
        $data['data_result'] = $arrayProductInitialView;

        if(isset($review) && $review === 'true') {
            $data['content'] = 'business/initial_inventory';
            $this->load->view('templates/master', $data);

        } else {
            if($csv !== 'true') {
                $pdf = new mPDF('utf8','A3-L','','',15,15,15,15,9,9);  
                $pdf->SetTitle($data['title']);

                $html= $this->load->view('templates/business/report_inventory/pdf_initial_inventory', $data, true);
                $pdf->WriteHTML($html);
                
                $getPrint = $this->input->get('print');
                if($getPrint === 'true') { 
                    $pdf->SetJS('this.print();');
                }
                $output = $data['title'].'.pdf';
                if($arrayNumberInitial == null || count($arrayNumberInitial) <= 0) {
                    $pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
                }
                $pdf->Output("$output", 'I');
            } else {
                // Export csv
                $data_result = $data['data_result'];
                $data_export = array();
                array_push(
                    $data_export,
                    array(mb_convert_encoding($data['title'], "UTF-8"))
                );
                array_push(
                    $data_export,
                    array("")
                );
                array_push(
                    $data_export,
                    array(mb_convert_encoding("日付 :", "UTF-8"), $date_from." ～ ".$date_from)
                );
                array_push(
                    $data_export,
                    array("")
                );
                array_push(
                    $data_export,
                    array(
                        mb_convert_encoding("商品コード", "UTF-8"),
                        mb_convert_encoding("商品名", "UTF-8"),
                        mb_convert_encoding("規格", "UTF-8"),
                        mb_convert_encoding("色調", "UTF-8"),
                        mb_convert_encoding("棚卸日(直近)", "UTF-8"),
                        mb_convert_encoding("棚卸数(直近)", "UTF-8"),
                        mb_convert_encoding("累計出庫数", "UTF-8"),
                        mb_convert_encoding("累計廃棄数", "UTF-8"),
                        mb_convert_encoding("使用中リネン", "UTF-8"),
                        mb_convert_encoding("累計納品数", "UTF-8"),
                        mb_convert_encoding("回転率", "UTF-8")
                    )
                );

                if(isset($data_result) && $data_result != null) { 
                    foreach ($data_result as $key => $value) {
                        array_push(
                            $data_export,
                            array(
                                mb_convert_encoding($value['product_code_sell'], "UTF-8"),
                                mb_convert_encoding($value['product_name_sell'], "UTF-8"),
                                mb_convert_encoding($value['product_format'], "UTF-8"),
                                mb_convert_encoding($value['product_color'], "UTF-8"),
                                mb_convert_encoding($value['date_initial'], "UTF-8"),
                                mb_convert_encoding($value['number_initial'], "UTF-8"),
                                mb_convert_encoding($value['number_export'], "UTF-8"),
                                mb_convert_encoding($value['number_disposal'], "UTF-8"),
                                mb_convert_encoding($value['number_product'], "UTF-8"),
                                mb_convert_encoding($value['number_delivery'], "UTF-8"),
                                mb_convert_encoding(($value['number_delivery'] > 0 && $value['number_product'] > 0) ? round(($value['number_delivery']/$value['number_product']),2) : 0, "UTF-8")
                            )
                        );
                    }
                }

                $this->ImportExportCsv->download_send_header_csv($data['title']);
			    echo $this->ImportExportCsv->array_to_csv($data_export);
            }

        }
	}

}
