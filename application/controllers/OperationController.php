<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class OperationController extends VV_Controller {
 
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Shipment_Detail','shipment_detail_model');
        $this->load->model('DrivingSituation','drivingsituation_model');
        $this->load->model('FinishingSituation','finishingsituation_model');
        $this->load->model('Delivery_Detail','delivery_detail_model');
        $this->load->model('Laundry_Register','laundry_register_model');
        $this->load->model('Production','production_model');
        $this->load->model('Customer','customer_model');
        $this->load->model('Machine','machine_model');
        $this->load->model('Laundry','laundry_model');
        $this->load->model('Sale','sale_model');
        $this->load->library('mpdf');
        $this->load->library('graph');
        $this->load->library('helper','helper');
        $this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/PHPExcel_iofactory');
    }
	public function business()
	{
        $data['title']='営業管理';
        $data['content']='operation/business';

        $this->load->view('templates/master',$data);
        
	}
    public function produce()
    {
        $data['title']='営業管理';
        $data['content']='operation/produce';
        $data['customer'] = $this->customer_model->getAll();
        $data['machine'] = $this->machine_model->getAll();
        $data['laundry'] = $this->laundry_model->getAll();
        $this->load->view('templates/master',$data);
        
    }
	public function pdf_produce_shipment(){
		$html = "";
		$mpdf = new mPDF('utf8','A4');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $condition['date_from'] = $date_from;
        $condition['date_to'] = $date_to;
        $this->shipment_detail_model->setWhereClause($condition);
        $data['shipment'] = $this->shipment_detail_model->getPdfByDate($date_from,$date_to);
        $html = $this->load->view("templates/operation/pdf_produce_shipment",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("納品量合計");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        if($data['shipment'] == null || count($data['shipment']) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("納品量合計.pdf","I");
	}

    public function csv_produce_shipment(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("納品量合計");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $condition['date_from'] = $date_from;
        $condition['date_to'] = $date_to;
        $this->shipment_detail_model->setWhereClause($condition);
        $shipment = $this->shipment_detail_model->getPdfByDate($date_from,$date_to);
        $current_row = 1;
        for($i=0;$i<count($shipment);$i++){
            $total_quantity = 0;
            $total_weight = 0;
            $activeSheet->setCellValue("A".$current_row,"納品数・重量　合計" );
            $activeSheet->setCellValue("D".$current_row,$this->helper->readDate($shipment[$i][OS_ORDER_DATE]));
            $current_row += 1;
            $activeSheet->setCellValue("A".$current_row,"項目コード");
            $activeSheet->setCellValue("B".$current_row,"項目コード名");
            $activeSheet->setCellValue("C".$current_row,"出荷数の合計");
            $activeSheet->setCellValue("D".$current_row,"納品重量の合計　(Kg)");
            $current_row += 1;
            for(;$i<count($shipment);$i++){ 
                $total_quantity += $shipment[$i]['quantity'];
                $total_weight += $shipment[$i]['weight'];
                $activeSheet->setCellValue("A".$current_row,$shipment[$i][OSHD_PRODUCT_CODE]);
                $activeSheet->setCellValue("B".$current_row,$shipment[$i][PL_PRODUCT_NAME]);
                $activeSheet->setCellValue("C".$current_row,number_format($shipment[$i]['quantity']));
                $activeSheet->setCellValue("D".$current_row,number_format($shipment[$i]['weight'],2,'.',','));
                $current_row += 1;
                if($shipment[$i+1][OS_ORDER_DATE] != $shipment[$i][OS_ORDER_DATE]){
                    break;
                }
            }
            $activeSheet->setCellValue("C".$current_row,number_format($total_quantity));
            $activeSheet->setCellValue("D".$current_row,number_format($total_weight,2,'.',','));
            $current_row += 2;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "納品量合計.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }


	public function pdf_produce_shipment_cus(){
		$html = "";
		$mpdf = new mPDF('utf8','A3');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $cus = $this->input->get('cus');
        $condition['date_from'] = $date_from;
        $condition['date_to'] = $date_to;
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['customer'] = $cus;
        $this->shipment_detail_model->setWhereClause($condition);
        $data['shipment'] = $this->shipment_detail_model->getPdfByCustomer($date_from,$date_to,$cus);
        $html = $this->load->view("templates/operation/pdf_produce_shipment_cus",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("納品集計表");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        if($data['shipment'] == null || count($data['shipment']) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("納品集計表.pdf","I");
	}

    public function csv_produce_shipment_cus(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("納品集計表");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $cus = $this->input->get('cus');
        $condition['date_from'] = $date_from;
        $condition['date_to'] = $date_to;
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $data['customer'] = $cus;
        $this->shipment_detail_model->setWhereClause($condition);
        $shipment = $this->shipment_detail_model->getPdfByCustomer($date_from,$date_to,$cus);
        $current_row = 1;
        $index = 0;
        for($i=0;$i<count($shipment);$i++){ 
        $total_quantity = 0;
        $total_weight = 0;
        $pageno += 1;
            $total_quantity = 0;
            $total_weight = 0;
            $activeSheet->setCellValue("A".$current_row,"納品集計表");
            $activeSheet->setCellValue("B".$current_row,$date_from."  ~  ".$date_to);
            $activeSheet->setCellValue("G".$current_row,"No".$pageno);
            $current_row += 1;
            $activeSheet->setCellValue("B".$current_row,$shipment[$i][CUS_CUSTOMER_NAME]);
            $current_row += 1;
            $activeSheet->setCellValue("A".$current_row,"商品コード");
            $activeSheet->setCellValue("B".$current_row,"商品名");
            $activeSheet->setCellValue("C".$current_row,"規格");
            $activeSheet->setCellValue("D".$current_row,"COLOR");
            $activeSheet->setCellValue("E".$current_row,"出荷数");
            $activeSheet->setCellValue("F".$current_row,"重量");
            $activeSheet->setCellValue("G".$current_row,"合計");
            $current_row += 1;
            for(;$i<count($shipment);$i++){ 
                $total_quantity += $shipment[$i]['quantity'];
                $total_weight += $shipment[$i]['weight'];
                $activeSheet->setCellValue("A".$current_row,$shipment[$i][OSHD_PRODUCT_CODE]);
                $activeSheet->setCellValue("B".$current_row,$shipment[$i][PL_PRODUCT_NAME]);
                $activeSheet->setCellValue("C".$current_row,$shipment[$i][PL_STANDARD]);
                $activeSheet->setCellValue("D".$current_row,$shipment[$i][PL_COLOR_TONE]);
                $activeSheet->setCellValue("E".$current_row,number_format($shipment[$i]['quantity']));
                $activeSheet->setCellValue("F".$current_row,number_format($shipment[$i][PL_ORGANIZATION_WEIGHT],2,'.',','));
                $activeSheet->setCellValue("G".$current_row,number_format($shipment[$i]['quantity']*$shipment[$i][PL_ORGANIZATION_WEIGHT],2,'.',','));
                $current_row += 1;
                if($shipment[$i+1][OSHD_CUSTOMER_ID] != $shipment[$i][OSHD_CUSTOMER_ID]) {
                    break;
                
                }
            }
            $activeSheet->setCellValue("D".$current_row,"合計(枚)");
            $activeSheet->setCellValue("E".$current_row,number_format($total_quantity));
            $activeSheet->setCellValue("F".$current_row,"合計(kg)");
            $activeSheet->setCellValue("G".$current_row,number_format($total_weight,2,'.',','));
            $current_row += 2;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "納品集計表.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	public function pdf_produce_quantity_used_by_device(){
		$html = "";
		$mpdf = new mPDF('utf8','A3-L');
        
        $condition['date_from'] = $this->input->get('date_from');
        $condition['date_to'] =  $this->input->get('date_to');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $temp = $this->laundry_register_model->pdf_produce_quantity_used_by_device($data['date_from'],$data['date_to']);

        $resource = array();
        foreach ($temp as $key => $value) {
        	if(!isset($resource[$value[DEL_CODE]])){
        		$resource[$value[DEL_CODE]]['id'] = $value[DEL_CODE];
        		$resource[$value[DEL_CODE]]['name'] = $value[DEL_NAME];
        		$resource[$value[DEL_CODE]]['price'] = $value[DEL_UNIT_PRICE];
        		$resource[$value[DEL_CODE]]['quantity'] = $value['weight'];
        		$resource[$value[DEL_CODE]]['detail'] = array($value);
        	}
        	else{
        		array_push($resource[$value[DEL_CODE]]['detail'], $value);
        		$resource[$value[DEL_CODE]]['quantity'] += $value['weight'];
        	}
        }
        $data['lstMaster'] = $resource;
        $mpdf->setAutoTopMargin = 'stretch';
        $html = $this->load->view("templates/operation/pdf_produce_quantity_used_by_device",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("洗剤別機器使用量");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        if($temp == null || count($temp) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("洗剤別機器使用量.pdf","I");
	}

    public function csv_produce_quantity_used_by_device(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("洗剤別機器使用量");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $condition['date_from'] = $this->input->get('date_from');
        $condition['date_to'] =  $this->input->get('date_to');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $temp = $this->laundry_register_model->pdf_produce_quantity_used_by_device($data['date_from'],$data['date_to']);

        $resource = array();
        foreach ($temp as $key => $value) {
            if(!isset($resource[$value[DEL_CODE]])){
                $resource[$value[DEL_CODE]]['id'] = $value[DEL_CODE];
                $resource[$value[DEL_CODE]]['name'] = $value[DEL_NAME];
                $resource[$value[DEL_CODE]]['price'] = $value[DEL_UNIT_PRICE];
                $resource[$value[DEL_CODE]]['quantity'] = $value['weight'];
                $resource[$value[DEL_CODE]]['detail'] = array($value);
            }
            else{
                array_push($resource[$value[DEL_CODE]]['detail'], $value);
                $resource[$value[DEL_CODE]]['quantity'] += $value['weight'];
            }
        }
        $lstMaster = $resource;
        $current_row = 1;
        $activeSheet->setCellValue("A".$current_row,"洗剤別機器使用量");
        $activeSheet->setCellValue("I".$current_row,$data['date_from']."  ~  ".$data['date_to']);
        $current_row += 1;
        foreach ($lstMaster as $key => $value) {
            $activeSheet->setCellValue("A".$current_row,"洗剤コード");
            $activeSheet->setCellValue("B".$current_row,"洗剤名");
            $activeSheet->setCellValue("G".$current_row,"洗剤量(kq)");
            $activeSheet->setCellValue("H".$current_row,"単価");
            $activeSheet->setCellValue("I".$current_row,"金額");
            $current_row += 1;
            $activeSheet->setCellValue("A".$current_row,$value['id']);
            $activeSheet->setCellValue("B".$current_row,$value['name']);
            $activeSheet->setCellValue("G".$current_row,$value['quantity']);
            $activeSheet->setCellValue("H".$current_row,$value['price']);
            $activeSheet->setCellValue("I".$current_row,$value['quantity']*$value['price']);
            $current_row += 1;
            $activeSheet->setCellValue("C".$current_row,"機器コード");
            $activeSheet->setCellValue("D".$current_row,"機器名");
            $activeSheet->setCellValue("E".$current_row,"洗濯回数");
            $activeSheet->setCellValue("F".$current_row,"使用量(g/ml)");
            $activeSheet->setCellValue("G".$current_row,"洗剤量(kg)");
            $activeSheet->setCellValue("H".$current_row,"単価");
            $activeSheet->setCellValue("I".$current_row,"金額");
            foreach ($value['detail'] as  $item) {
                $activeSheet->setCellValue("C".$current_row,$item[EQ_CODE]);
                $activeSheet->setCellValue("D".$current_row,$item[EQ_NAME]);
                $activeSheet->setCellValue("E".$current_row,$item['quantity']);
                $activeSheet->setCellValue("F".$current_row,$item['amount_washing']);
                $activeSheet->setCellValue("G".$current_row,$item['weight']);
                $activeSheet->setCellValue("H".$current_row,$item[DEL_UNIT_PRICE]);
                $activeSheet->setCellValue("I".$current_row,$item[DEL_UNIT_PRICE]*$item['weight']);
                $current_row += 1;
            }
            $current_row += 2;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "洗剤別機器使用量.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

    public function pdf_produce_amount_powder_used_by_device(){
        $html = "";
        $mpdf = new mPDF('utf8','A3-L');
        
        $condition['date_from'] = $this->input->get('date_from');
        $condition['date_to'] =  $this->input->get('date_to');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $temp = $this->laundry_register_model->pdf_produce_amount_powder_used_by_device($data['date_from'],$data['date_to']);

        $resource = array();
        foreach ($temp as $key => $value) {
            if(!isset($resource[$value[EQ_CODE]])){
                $resource[$value[EQ_CODE]]['id'] = $value[EQ_CODE];
                $resource[$value[EQ_CODE]]['name'] = $value[DEL_NAME];
                $resource[$value[EQ_CODE]]['detail'] = null;
            }
            if(!isset($resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]])){
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['name'] = $value[LM_ITEM_NAME_2];
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['quantity'] = 0;
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['amount'] = 0;
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['detail'] =array();

            }
            $item['id'] =$value[DEL_CODE];
            $item['name'] =$value[DEL_NAME];
            $item['price'] =$value[DEL_UNIT_PRICE];
            $item['quantity'] =$value['quantity'];
            $item['amount_washing'] =$value['amount_washing'];
            $item['weight'] = $value['weight'];
            array_push($resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['detail'], $item);
            $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['quantity'] += $item['weight'];
            $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['amount'] += $item['quantity']*$item['price']  ;
        }
        //var_dump($this->db->last_query());
        $data['lstMaster'] = $resource;
        $mpdf->setAutoTopMargin = 'stretch';
        $html = $this->load->view("templates/operation/pdf_produce_amount_powder_used_by_device",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("機器別洗剤使用量");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        if($temp == null || count($temp) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("機器別洗剤使用量.pdf","I");
    }

    public function csv_produce_amount_powder_used_by_device(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("機器別洗剤使用量");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $condition['date_from'] = $this->input->get('date_from');
        $condition['date_to'] =  $this->input->get('date_to');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $temp = $this->laundry_register_model->pdf_produce_amount_powder_used_by_device($data['date_from'],$data['date_to']);

        $resource = array();
        foreach ($temp as $key => $value) {
            if(!isset($resource[$value[EQ_CODE]])){
                $resource[$value[EQ_CODE]]['id'] = $value[EQ_CODE];
                $resource[$value[EQ_CODE]]['name'] = $value[DEL_NAME];
                $resource[$value[EQ_CODE]]['detail'] = null;
            }
            if(!isset($resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]])){
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['name'] = $value[LM_ITEM_NAME_2];
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['quantity'] = 0;
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['amount'] = 0;
                $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['detail'] =array();

            }
            $item['id'] =$value[DEL_CODE];
            $item['name'] =$value[DEL_NAME];
            $item['price'] =$value[DEL_UNIT_PRICE];
            $item['quantity'] =$value['quantity'];
            $item['amount_washing'] =$value['amount_washing'];
            $item['weight'] = $value['weight'];
            array_push($resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['detail'], $item);
            $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['quantity'] += $item['weight'];
            $resource[$value[EQ_CODE]]['detail'][$value[LM_CODE]]['amount'] += $item['quantity']*$item['price']  ;
        }
        //var_dump($this->db->last_query());
        $lstMaster = $resource;
        $current_row = 1;
        $activeSheet->setCellValue("A".$current_row,"機器別洗剤使用量");
        $activeSheet->setCellValue("I".$current_row,$data['date_from']."  ~  ".$data['date_to']);
        $current_row += 1;
        foreach ($lstMaster as $key => $value) {
            $activeSheet->setCellValue("A".$current_row,$value['name']);
            $current_row += 1;
            $activeSheet->setCellValue("A".$current_row,"洗濯コード");
            $activeSheet->setCellValue("B".$current_row,"洗濯品名");
            $activeSheet->setCellValue("G".$current_row,"洗剤量(kq)");
            $activeSheet->setCellValue("I".$current_row,"金額");
            $current_row += 1;
            foreach ($value['detail'] as $item) {
                $activeSheet->setCellValue("A".$current_row,$item['id']);
                $activeSheet->setCellValue("B".$current_row,$item['name']);
                $activeSheet->setCellValue("G".$current_row,$item['quantity']);
                $activeSheet->setCellValue("I".$current_row,$item['amount']);
                $current_row += 1;
                $activeSheet->setCellValue("C".$current_row,"洗剤コード");
                $activeSheet->setCellValue("D".$current_row,"洗剤名");
                $activeSheet->setCellValue("E".$current_row,"洗濯回数");
                $activeSheet->setCellValue("F".$current_row,"使用量(g/ml)");
                $activeSheet->setCellValue("G".$current_row,"洗剤量(kg)");
                $activeSheet->setCellValue("H".$current_row,"単価");
                $activeSheet->setCellValue("I".$current_row,"金額");
                 $current_row += 1;
                foreach ($item['detail'] as $detail) {
                    $activeSheet->setCellValue("C".$current_row,$detail['quantity']);
                    $activeSheet->setCellValue("D".$current_row,$detail['name']);
                    $activeSheet->setCellValue("E".$current_row,number_format($detail['quantity']));
                    $activeSheet->setCellValue("F".$current_row,number_format($detail['amount_washing']));
                    $activeSheet->setCellValue("G".$current_row,number_format($detail['weight'],2,'.',','));
                    $activeSheet->setCellValue("H".$current_row,number_format($detail['price'],2,'.',','));
                    $activeSheet->setCellValue("I".$current_row,number_format($detail['price']*$detail['weight'],2,'.',',')."¥");
                    $current_row += 1;
                }
            }
            $current_row += 2;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "機器別洗剤使用量.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	public function pdf_produce_washing_amount(){
		$html = "";
		$mpdf = new mPDF('utf8','A4-L');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $data['date'] = (new DateTime($data['date_from']))->format('Y-m');
        $result = $this->production_model->pdf_produce_washing_amount($data['date']);

        $resource = NULL;
        if($result != NULL){
            foreach ($result as $key => $value) {
                if(!isset($resource[$value[POG_CODE]])){
                    $resource[$value[POG_CODE]]['name'] = $value[POG_NAME];
                    $resource[$value[POG_CODE]]['detail'] = array();
                }
                $item['item_name'] = $value[POC_CATEGORY_NAME];
                $item['quantity'] = $value['quantity'];
                $item['weight'] = $value['weight'];
                array_push($resource[$value[POG_CODE]]['detail'],$item);
            }
        }
        
        $data['lstMaster'] = $resource;
        $mpdf->setAutoTopMargin = 'stretch';
        $html = $this->load->view("templates/operation/pdf_produce_washing_amount",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("生産概要洗濯量");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        if($result == null || count($result) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("生産概要洗濯量.pdf","I");
	}

    public function csv_produce_washing_amount(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("生産概要洗濯量");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $data['date'] = (new DateTime($data['date_from']))->format('Y-m');
        $result = $this->production_model->pdf_produce_washing_amount($data['date']);

        $resource = NULL;
        if($result != NULL){
            foreach ($result as $key => $value) {
                if(!isset($resource[$value[POG_CODE]])){
                    $resource[$value[POG_CODE]]['name'] = $value[POG_NAME];
                    $resource[$value[POG_CODE]]['detail'] = array();
                }
                $item['item_name'] = $value[POC_CATEGORY_NAME];
                $item['quantity'] = $value['quantity'];
                $item['weight'] = $value['weight'];
                array_push($resource[$value[POG_CODE]]['detail'],$item);
            }
        }
        
        $lstMaster = $resource;
        $current_row = 1;
        $activeSheet->setCellValue("A".$current_row,"月間生産概要    ".$lstMaster['date']);
        $current_row += 1;
        foreach ($lstMaster as $key => $value) {
            $total_quantity = 0;
            $total_weight = 0;
            $activeSheet->setCellValue("A".$current_row,$value['name']);
            $activeSheet->setCellValue("B".$current_row,"回数");
            $activeSheet->setCellValue("C".$current_row,"重量(Kg)");
            $current_row += 1;
            foreach ($value['detail'] as $item) { 
                $total_quantity += $item['quantity'];
                $total_weight += $item['weight'];
                $activeSheet->setCellValue("A".$current_row,$item['item_name']);
                $activeSheet->setCellValue("B".$current_row,number_format($item['quantity']));
                $activeSheet->setCellValue("C".$current_row,number_format($item['weight'],2,'.',','));
                $current_row += 1;
            }
            $activeSheet->setCellValue("B".$current_row,number_format($total_quantity));
            $activeSheet->setCellValue("C".$current_row,number_format($total_weight,2,'.',','));
            $current_row += 2;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "生産概要洗濯量.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	public function pdf_produce_weight_by_device(){
		$html = "";
		$mpdf = new mPDF('utf8','A4-L');
        
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $temp = $this->laundry_register_model->pdf_produce_weight_by_device($data['date_from'],$data['date_to']);
        $resource = array();
        foreach ($temp as $key => $value) {
        	if(!isset($resource[$value[EQ_CODE]])){
        		$resource[$value[EQ_CODE]]['name'] = $value[EQ_NAME];
        		$resource[$value[EQ_CODE]]['detail'] = array($value);
        	}
        	else{
        		array_push($resource[$value[EQ_CODE]]['detail'], $value);
        	}
        }
        //var_dump($resource);
        $data['lstMaster'] = $resource;
        $mpdf->setAutoTopMargin = 'stretch';
        $html = $this->load->view("templates/operation/pdf_produce_weight_by_device",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("機器別洗濯量");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        //ar_dump($resource);
        if($temp == null || count($temp) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("機器別洗濯量.pdf","I");
	}



    public function csv_produce_weight_by_device(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("機器別洗濯量");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $machine = $this->input->get('machine');
        $laundry = $this->input->get('laundry');
        $temp = $this->laundry_register_model->pdf_produce_weight_by_device($data['date_from'],$data['date_to']);
        $resource = array();
        foreach ($temp as $key => $value) {
            if(!isset($resource[$value[EQ_CODE]])){
                $resource[$value[EQ_CODE]]['name'] = $value[EQ_NAME];
                $resource[$value[EQ_CODE]]['detail'] = array($value);
            }
            else{
                array_push($resource[$value[EQ_CODE]]['detail'], $value);
            }
        }
        //var_dump($resource);
        $lstMaster = $resource;
        $current_row = 1;
        
        foreach ($lstMaster as $key => $value) {
            $total_quantity = 0;
            $total_weight = 0;
            $activeSheet->setCellValue("A".$current_row,"機器別洗濯量   ".$value['name']);
            $activeSheet->setCellValue("E".$current_row,$data['date_from']." ~ ".$data['date_to']);
            $current_row += 1;
            $activeSheet->setCellValue("A".$current_row,"洗濯コード");
            $activeSheet->setCellValue("B".$current_row,"洗濯品名");
            $activeSheet->setCellValue("C".$current_row,"洗濯回数");
            $activeSheet->setCellValue("D".$current_row,"重量");
            $activeSheet->setCellValue("E".$current_row,"洗濯量(Kg)");
            $current_row += 1;
            foreach ($value['detail'] as $item) { 
                $total_quantity += $item['quantity'];
                $total_weight += $item['weight'];
                $activeSheet->setCellValue("A".$current_row,$item[LM_CODE]);
                $activeSheet->setCellValue("B".$current_row,$item[LM_ITEM_NAME_1]);
                $activeSheet->setCellValue("C".$current_row,number_format($item['quantity']));
                $activeSheet->setCellValue("D".$current_row,number_format($item['weight'],2,'.',','));
                $activeSheet->setCellValue("E".$current_row,number_format($item['weight'],2,'.',','));
                $current_row += 1;
            }
            $activeSheet->setCellValue("C".$current_row,number_format($total_quantity));
            $activeSheet->setCellValue("E".$current_row,number_format($total_weight,2,'.',','));
            $current_row += 2;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "機器別洗濯量.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	public function pdf_produce_actual_by_cus(){
		$html = "";
		$mpdf = new mPDF('utf8','A4-L');
        $type = $this->input->get('type');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $data1 = $this->delivery_detail_model->pdf_produce_actual_by_cus($data['date_from'],$data['date_to'],$type);

        $datetime_from = new DateTime($data['date_from']);
		$year_from = $datetime_from->format('Y');
		$month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
		$month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $data2 = $this->delivery_detail_model->pdf_produce_actual_by_cus($date1,$date2,$type);
        
        foreach ($data1 as $key => $value) {
        	$data1[$key]["dry_quantity_last_year"] = 100;
        	$data1[$key]["dry_weight_last_year"] = 100;
        	$data1[$key]["laundry_quantity_last_year"] = 100;
        	$data1[$key]["laundry_weight_last_year"] = 100;
        	$data1[$key]["total_quantity_last_year"] = 100;
        	$data1[$key]["total_weight_last_year"] = 100;
        	foreach ($data2 as $item) {
        		if($value[SL_CUSTOMER_ID] == $item[SL_CUSTOMER_ID]){
        			$data1[$key]["dry_quantity_last_year"] = $value["dry_quantity"]/$item["dry_quantity"]*100;
        			$data1[$key]["dry_weight_last_year"] = $value["dry_weight"]/$item["dry_weight"]*100;
        			$data1[$key]["laundry_quantity_last_year"] = $item["laundry_quantity"] == 0 ?0:$value["laundry_quantity"]/$item["laundry_quantity"]*100;
        			$data1[$key]["laundry_weight_last_year"] = $item["laundry_weight"] == 0 ?0:$value["laundry_weight"]/$item["laundry_weight"]*100;
        			$data1[$key]["total_quantity_last_year"] = ($value["dry_quantity"]+$value["laundry_quantity"])/($value["dry_quantity"]+$value["laundry_quantity"])*100;
        			$data1[$key]["total_weight_last_year"] = ($value["dry_weight"]+$value["laundry_quantity"])/($value["dry_weight"]+$value["laundry_weight"])*100;
        		}
        	}
        }
        $data['lstMaster'] = $data1;

        $mpdf->setAutoTopMargin = 'stretch';
        $html = $this->load->view("templates/operation/pdf_produce_actual_by_cus",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("得意先別生産実績表_テナント");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        //var_dump($html);
        if($data1 == null || count($data1) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("得意先別生産実績表_テナント.pdf","I");
	}

    public function csv_produce_actual_by_cus(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("得意先別生産実績表_テナント");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $data1 = $this->delivery_detail_model->pdf_produce_actual_by_cus($data['date_from'],$data['date_to'],$type);

        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $data2 = $this->delivery_detail_model->pdf_produce_actual_by_cus($date1,$date2,$type);
        
        foreach ($data1 as $key => $value) {
            $data1[$key]["dry_quantity_last_year"] = 100;
            $data1[$key]["dry_weight_last_year"] = 100;
            $data1[$key]["laundry_quantity_last_year"] = 100;
            $data1[$key]["laundry_weight_last_year"] = 100;
            $data1[$key]["total_quantity_last_year"] = 100;
            $data1[$key]["total_weight_last_year"] = 100;
            foreach ($data2 as $item) {
                if($value[SL_CUSTOMER_ID] == $item[SL_CUSTOMER_ID]){
                    $data1[$key]["dry_quantity_last_year"] = $value["dry_quantity"]/$item["dry_quantity"]*100;
                    $data1[$key]["dry_weight_last_year"] = $value["dry_weight"]/$item["dry_weight"]*100;
                    $data1[$key]["laundry_quantity_last_year"] = $item["laundry_quantity"] == 0 ?0:$value["laundry_quantity"]/$item["laundry_quantity"]*100;
                    $data1[$key]["laundry_weight_last_year"] = $item["laundry_weight"] == 0 ?0:$value["laundry_weight"]/$item["laundry_weight"]*100;
                    $data1[$key]["total_quantity_last_year"] = ($value["dry_quantity"]+$value["laundry_quantity"])/($value["dry_quantity"]+$value["laundry_quantity"])*100;
                    $data1[$key]["total_weight_last_year"] = ($value["dry_weight"]+$value["laundry_quantity"])/($value["dry_weight"]+$value["laundry_weight"])*100;
                }
            }
        }
        $lstMaster = $data1;
        $current_row = 1;
        $total_quantity = 0;
        $total_weight = 0;
        $activeSheet->setCellValue("C".$current_row,"得意先別生産実績表");
        $current_row += 1;
        $activeSheet->setCellValue("F".$current_row,$data['date_from']." ~ ".$data['date_to']);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"得意先");
        $activeSheet->setCellValue("B".$current_row,"区分");
        $activeSheet->setCellValue("C".$current_row,"数量");
        $activeSheet->setCellValue("D".$current_row,"重量(g)");
        $activeSheet->setCellValue("E".$current_row,"前年比(数量)");
        $activeSheet->setCellValue("F".$current_row,"前年比(重量)");
        $current_row += 1;
        foreach ($lstMaster as $key => $value) {
            $activeSheet->setCellValue("A".$current_row,'['.$value[CUS_ID].']'.$value[CUS_CUSTOMER_NAME]);
            $activeSheet->setCellValue("B".$current_row,"ドライ");
            $activeSheet->setCellValue("C".$current_row,number_format($value['dry_quantity']));
            $activeSheet->setCellValue("D".$current_row,number_format($value['dry_weight'],2,'.',','));
            $activeSheet->setCellValue("E".$current_row,number_format($value['dry_quantity_last_year'],2)."%");
            $activeSheet->setCellValue("F".$current_row,number_format($value['dry_weight_last_year'],2)."%");
            $current_row += 1;
            $activeSheet->setCellValue("B".$current_row,"ランドリー");
            $activeSheet->setCellValue("C".$current_row,number_format($value['laundry_quantity']));
            $activeSheet->setCellValue("D".$current_row,number_format($value['laundry_weight'],2,'.',','));
            $activeSheet->setCellValue("E".$current_row,number_format($value['laundry_quantity_last_year'],2)."%");
            $activeSheet->setCellValue("F".$current_row,number_format($value['laundry_weight_last_year'],2)."%");
            $current_row += 1;
            $activeSheet->setCellValue("B".$current_row,"得意先合計");
            $activeSheet->setCellValue("C".$current_row,number_format($value['dry_quantity']+$value['laundry_quantity']));
            $activeSheet->setCellValue("D".$current_row,number_format($value['dry_weight']+$value['laundry_weight'],2,'.',','));
            $activeSheet->setCellValue("E".$current_row,number_format($value["total_quantity_last_year"],2)."%");
            $activeSheet->setCellValue("F".$current_row,number_format($value["total_weight_last_year"],2)."%");
            $current_row += 2;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "得意先別生産実績表_テナント.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	public function pdf_produce_actual_by_product(){
		$html = "";
		$mpdf = new mPDF('utf8','A4-L');
        
        $type = $this->input->get('type');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $data1 = $this->delivery_detail_model->pdf_produce_actual_by_product($data['date_from'],$data['date_to'],$type);
        

        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $data2 = $this->delivery_detail_model->pdf_produce_actual_by_product($date1,$date2,$type);
        $resource = array();
        $data['sum_quantity'] = 0;
        $data['sum_weight'] = 0;
        $data['sum_quantity_last_year'] = 0;
        $data['sum_weight_last_year'] = 0;
        foreach ($data1 as $key => $value) {
            if(!isset($resource[$value[CUS_ID]])){
                $resource[$value[CUS_ID]]['cus_name'] = $value[CUS_CUSTOMER_NAME];
                $resource[$value[CUS_ID]]['total_quantity'] = 0;
                $resource[$value[CUS_ID]]['total_weight'] = 0;
                $resource[$value[CUS_ID]]['total_quantity_last_year'] = 0;
                $resource[$value[CUS_ID]]['total_weight_last_year'] = 0;
                $resource[$value[CUS_ID]]['detail'] = array();
            }
            $item['id'] = $value[PL_PRODUCT_ID];
            $item['name'] = $value[PL_PRODUCT_NAME];
            $item['standard'] = $value[PL_STANDARD];
            $item['color'] = $value[PL_COLOR_TONE];
            $item['quantity'] = $value['quantity'];
            $item['weight'] = $value['weight'];
            $resource[$value[CUS_ID]]['total_quantity'] += $value['quantity'];
            $resource[$value[CUS_ID]]['total_weight'] += $value['weight'];
            $data['sum_quantity'] += $value['quantity'];
            $data['sum_weight'] += $value['weight'];
            $item["quantity_last_year"] = 100;
            $item["weight_last_year"] = 100;
            foreach ($data2 as $last_year) {
                if($value[SL_CUSTOMER_ID] == $last_year[SL_CUSTOMER_ID] && $value[PL_PRODUCT_ID] == $last_year[PL_PRODUCT_ID]){
                    $item["quantity_last_year"] = $last_year['quantity'] == 0? 0:$item['quantity']*100/$last_year['quantity'];
                    $item["weight_last_year"] = $last_year['weight'] == 0? 0:$item['weight']*100/$last_year['weight'];
                    $resource[$value[CUS_ID]]['total_quantity_last_year'] += $last_year['quantity'];
                    $resource[$value[CUS_ID]]['total_weight_last_year'] += $last_year['weight'];
                    $data['sum_quantity_last_year'] += $last_year['quantity'];
                    $data['sum_weight_last_year'] += $last_year['weight'];
                }
            }
        }
        $data['lstMaster'] = $resource;
        $mpdf->setAutoTopMargin = 'stretch';
        $html = $this->load->view("templates/operation/pdf_produce_actual_by_product",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("テナント生産実績表");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        //var_dump($html);
        if($data1 == null || count($data1) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("テナント生産実績表.pdf","I");
	}

    public function csv_produce_actual_by_product(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("得意先別生産実績表_テナント");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $type = $this->input->get('type');
        $data['date_from'] = $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $data1 = $this->delivery_detail_model->pdf_produce_actual_by_product($data['date_from'],$data['date_to'],$type);

        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $data2 = $this->delivery_detail_model->pdf_produce_actual_by_product($date1,$date2,$type);
        $resource = array();
        $data['sum_quantity'] = 0;
        $data['sum_weight'] = 0;
        $data['sum_quantity_last_year'] = 0;
        $data['sum_weight_last_year'] = 0;
        foreach ($data1 as $key => $value) {
            if(!isset($resource[$value[CUS_ID]])){
                $resource[$value[CUS_ID]]['cus_name'] = $value[CUS_CUSTOMER_NAME];
                $resource[$value[CUS_ID]]['total_quantity'] = 0;
                $resource[$value[CUS_ID]]['total_weight'] = 0;
                $resource[$value[CUS_ID]]['total_quantity_last_year'] = 0;
                $resource[$value[CUS_ID]]['total_weight_last_year'] = 0;
                $resource[$value[CUS_ID]]['detail'] = array();
            }
            $item['id'] = $value[PL_PRODUCT_ID];
            $item['name'] = $value[PL_PRODUCT_NAME];
            $item['standard'] = $value[PL_STANDARD];
            $item['color'] = $value[PL_COLOR_TONE];
            $item['quantity'] = $value['quantity'];
            $item['weight'] = $value['weight'];
            $resource[$value[CUS_ID]]['total_quantity'] += $value['quantity'];
            $resource[$value[CUS_ID]]['total_weight'] += $value['weight'];
            $data['sum_quantity'] += $value['quantity'];
            $data['sum_weight'] += $value['weight'];
            $item["quantity_last_year"] = 100;
            $item["weight_last_year"] = 100;
            foreach ($data2 as $last_year) {
                if($value[SL_CUSTOMER_ID] == $last_year[SL_CUSTOMER_ID] && $value[PL_PRODUCT_ID] == $last_year[PL_PRODUCT_ID]){
                    $item["quantity_last_year"] = $last_year['quantity'] == 0? 0:$item['quantity']*100/$last_year['quantity'];
                    $item["weight_last_year"] = $last_year['weight'] == 0? 0:$item['weight']*100/$last_year['weight'];
                    $resource[$value[CUS_ID]]['total_quantity_last_year'] += $last_year['quantity'];
                    $resource[$value[CUS_ID]]['total_weight_last_year'] += $last_year['weight'];
                    $data['sum_quantity_last_year'] += $last_year['quantity'];
                    $data['sum_weight_last_year'] += $last_year['weight'];
                }
            }
        }
        $lstMaster = $resource;
        $current_row = 1;
        $activeSheet->setCellValue("C".$current_row,"得意先別生産実績表");
        $activeSheet->setCellValue("H".$current_row,$data['date_from']." ~ ".$data['date_to']);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"得意先");
        $activeSheet->setCellValue("B".$current_row,"商品名");
        $activeSheet->setCellValue("C".$current_row,"規格");
        $activeSheet->setCellValue("D".$current_row,"COLOR");
        $activeSheet->setCellValue("E".$current_row,"数量");
        $activeSheet->setCellValue("F".$current_row,"重量(g)");
        $activeSheet->setCellValue("G".$current_row,"前年比(数量)");
        $activeSheet->setCellValue("H".$current_row,"前年比(重量)");
        $current_row += 1;
        foreach ($lstMaster as $key => $value) {
            $first = true;
            foreach ($value['detail'] as $item) {
                $activeSheet->setCellValue("A".$current_row,$first == true? $value['cus_name']:'');
                $activeSheet->setCellValue("B".$current_row,$item['name']);
                $activeSheet->setCellValue("C".$current_row,$item['standard']);
                $activeSheet->setCellValue("D".$current_row,$item['color']);
                $activeSheet->setCellValue("E".$current_row,number_format($item['quantity'],2));
                $activeSheet->setCellValue("F".$current_row,number_format($item['weight'],2,'.',','));
                $activeSheet->setCellValue("G".$current_row,number_format($item['quantity_last_year'],2)."%");
                $activeSheet->setCellValue("H".$current_row,number_format($item['weight_last_year'],2)."%");
                $current_row += 1;
            }
            $activeSheet->setCellValue("D".$current_row,"制服･作業着 合計");
            $activeSheet->setCellValue("E".$current_row,number_format($value['total_quantity'],2));
            $activeSheet->setCellValue("F".$current_row,number_format($value['total_weight'],2,'.',','));
            $activeSheet->setCellValue("G".$current_row,$value['total_quantity_last_year'] == 0?0:number_format($value['total_quantity']*100/$value['total_quantity_last_year'],2)."%");
            $activeSheet->setCellValue("H".$current_row,$value['total_weight_last_year'] == 0?0:number_format($value['total_weight']*100/$value['total_weight_last_year'],2)."%");
            $current_row += 1;
        }
        $activeSheet->setCellValue("D".$current_row,"得意先合計");
        $activeSheet->setCellValue("E".$current_row,number_format($sum_quantity,2));
        $activeSheet->setCellValue("F".$current_row,number_format($sum_weight,2,'.',','));
        $activeSheet->setCellValue("G".$current_row,$sum_quantity_last_year == 0?0:number_format($sum_quantity*100/$sum_quantity_last_year,2)."%");
        $activeSheet->setCellValue("H".$current_row,$sum_weight_last_year == 0?0:number_format($sum_weight*100/$sum_weight_last_year,2)."%");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "得意先別生産実績表_テナント.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }



    public function pdf_produce_business(){
        $html = "";
        $mpdf = new mPDF('','A3-L','gothic');
        $data['date_from'] =  $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $type = NULL;
        if($this->input->get('hotel_check') == true){
            $type = 1;
        }
        if($this->input->get('tetant_check') == true){
            $type = 2;
        }
        $type = NULL;
        $data1 = $this->sale_model->pdf_produce_business_ask_money(date('Y-m-d'),$data['date_from'],$data['date_to'],$type);
        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $year_now = date('Y');
        $month_now = date('m');
        $day_now = date('d');

        $data2 = $this->sale_model->pdf_produce_business_ask_money($year_now.'-'.$month_now.'-'.$day_now,$date1,$date2,$type);
        $result1 = array();

        foreach ($data1 as $key => $value) {
            if(!isset($result1[$value[CUS_ID]])){
                $result1[$value[CUS_ID]]['cus_name'] = $value[CUS_CUSTOMER_NAME];
                $result1[$value[CUS_ID]]['detail'] = array();
            }
            if(!isset($result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]])){
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['depart_name'] = $value[GR_GROUP_NAME];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today'] = $value['amount_today'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = 0;
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = 100;
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth'] = $value['amount'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = 0;
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = 100;

            }
            foreach ($data2 as $item) {
                if($value[CUS_ID] == $item[CUS_ID]){
                    if($value[DL_AGGREGATION_CODE] == $item[DL_AGGREGATION_CODE]){
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = $item['amount_today'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'] - $item['amount'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = $item['amount_today'] == 0 ?0:round($value['amount_today']*100/$item['amount_today'],1);
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = $item['amount'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'] - $item['amount'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = $item['amount'] == 0 ?0:round($value['amount_']*100/$item['amount'],1);
                    }
                }
            }
        }
        $data1 = $this->sale_model->pdf_produce_business_not_ask_money(date('Y-m-d'),$data['date_from'],$data['date_to'],$type);
        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $year_now = date('Y');
        $month_now = date('m');
        $day_now = date('d');

        $data2 = $this->sale_model->pdf_produce_business_not_ask_money($year_now.'-'.$month_now.'-'.$day_now,$date1,$date2,$type);
        $result2 = array();

        foreach ($data1 as $key => $value) {
            $result2[$value['etc']]['cus_name'] = "その他売上";
            $result2[$value['etc']]['detail'] = array();
            if(!isset($result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]])){
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['depart_name'] = $value[GR_GROUP_NAME];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today'] = $value['amount_today'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = 0;
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = 100;
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth'] = $value['amount'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = 0;
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = 100;

            }
            foreach ($data2 as $item) {
                if($value['etc'] == $item['etc']){
                    if($value[DL_AGGREGATION_CODE] == $item[DL_AGGREGATION_CODE]){
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = $item['amount_today'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'] - $item['amount'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = $item['amount_today'] == 0 ?0:round($value['amount_today']*100/$item['amount_today'],1);
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = $item['amount'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'] - $item['amount'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = $item['amount'] == 0 ?0:round($value['amount_']*100/$item['amount'],1);
                    }
                }
            }
        }
        $data['customer'] = $result1 + $result2;
        $mpdf->setAutoTopMargin = 'stretch';
        $html = $this->load->view("templates/operation/pdf_produce_business",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("営業日報");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        //var_dump($html);
        if($data1 == null || count($data1) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("営業日報.pdf","I");
    }

    public function csv_produce_business(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("営業日報");
        $activeSheet = $objPHPExcel->getActiveSheet();
       $data['date_from'] =  $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $type = NULL;
        if($this->input->get('hotel_check') == true){
            $type = 1;
        }
        if($this->input->get('tetant_check') == true){
            $type = 2;
        }
        $type = NULL;
        $data1 = $this->sale_model->pdf_produce_business_ask_money(date('Y-m-d'),$data['date_from'],$data['date_to'],$type);
        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $year_now = date('Y');
        $month_now = date('m');
        $day_now = date('d');

        $data2 = $this->sale_model->pdf_produce_business_ask_money($year_now.'-'.$month_now.'-'.$day_now,$date1,$date2,$type);
        $result1 = array();

        foreach ($data1 as $key => $value) {
            if(!isset($result1[$value[CUS_ID]])){
                $result1[$value[CUS_ID]]['cus_name'] = $value[CUS_CUSTOMER_NAME];
                $result1[$value[CUS_ID]]['detail'] = array();
            }
            if(!isset($result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]])){
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['depart_name'] = $value[GR_GROUP_NAME];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today'] = $value['amount_today'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = 0;
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = 100;
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth'] = $value['amount'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = 0;
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'];
                $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = 100;

            }
            foreach ($data2 as $item) {
                if($value[CUS_ID] == $item[CUS_ID]){
                    if($value[DL_AGGREGATION_CODE] == $item[DL_AGGREGATION_CODE]){
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = $item['amount_today'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'] - $item['amount'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = $item['amount_today'] == 0 ?0:round($value['amount_today']*100/$item['amount_today'],1);
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = $item['amount'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'] - $item['amount'];
                        $result1[$value[CUS_ID]]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = $item['amount'] == 0 ?0:round($value['amount_']*100/$item['amount'],1);
                    }
                }
            }
        }
        $data1 = $this->sale_model->pdf_produce_business_not_ask_money(date('Y-m-d'),$data['date_from'],$data['date_to'],$type);
        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $year_now = date('Y');
        $month_now = date('m');
        $day_now = date('d');

        $data2 = $this->sale_model->pdf_produce_business_not_ask_money($year_now.'-'.$month_now.'-'.$day_now,$date1,$date2,$type);
        $result2 = array();

        foreach ($data1 as $key => $value) {
            $result2[$value['etc']]['cus_name'] = "その他売上";
            $result2[$value['etc']]['detail'] = array();
            if(!isset($result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]])){
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['depart_name'] = $value[GR_GROUP_NAME];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today'] = $value['amount_today'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = 0;
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = 100;
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth'] = $value['amount'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = 0;
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'];
                $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = 100;

            }
            foreach ($data2 as $item) {
                if($value['etc'] == $item['etc']){
                    if($value[DL_AGGREGATION_CODE] == $item[DL_AGGREGATION_CODE]){
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_today_lastyear'] = $item['amount_today'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_day'] = $value['amount_today'] - $item['amount'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_day'] = $item['amount_today'] == 0 ?0:round($value['amount_today']*100/$item['amount_today'],1);
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['amount_thismonth_lastyear'] = $item['amount'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['difference_month'] = $value['amount'] - $item['amount'];
                        $result2[$value['etc']]['detail'][$value[DL_AGGREGATION_CODE]]['percent_month'] = $item['amount'] == 0 ?0:round($value['amount_']*100/$item['amount'],1);
                    }
                }
            }
        }
        $customer = $result1 + $result2;
        $current_row = 1;
        $activeSheet->setCellValue("D".$current_row,"得意先別生産実績表");
        $current_row += 1;
        $activeSheet->setCellValue("C".$current_row,"日報日付: ".$this->helper->readDate(date('Y-m-d')));
        $activeSheet->setCellValue("I".$current_row,"対象期間 ".$data['date_from']." ～ ".$data['date_to']);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"得意先名");
        $activeSheet->setCellValue("B".$current_row,"細目");
        $activeSheet->setCellValue("C".$current_row,"本日売上");
        $activeSheet->setCellValue("D".$current_row,"前年同日売上");
        $activeSheet->setCellValue("E".$current_row,"差額");
        $activeSheet->setCellValue("F".$current_row,"比率");
        $activeSheet->setCellValue("G".$current_row,"当月累計");
        $activeSheet->setCellValue("H".$current_row,"前年同月累計");
        $activeSheet->setCellValue("I".$current_row,"差額");
        $activeSheet->setCellValue("K".$current_row,"比率");
        $current_row += 1;
        foreach ($customer as $value) { 
            $index = 0; 
            $total_amount_today = 0;
            $total_amount_today_lastyear = 0;
            $total_difference_day = 0;
            $total_amount_thismonth = 0;
            $amount_thismonth_lastyesr = 0;
            $difference_month = 0;
            foreach ($value['detail'] as $key => $item) {
                $total_amount_today += $item['amount_today'];
                $total_amount_today_lastyear += $item['amount_today_lastyear'];
                $total_difference_day += $item['difference_day'];
                $total_amount_thismonth += $item['amount_thismonth'];
                $total_amount_thismonth_lastyear += $item['amount_thismonth_lastyesr'];
                $total_difference_month += $item['difference_month'];

                $activeSheet->setCellValue("A".$current_row,$index==0? $value['cus_name']:'');
                $activeSheet->setCellValue("B".$current_row,$item['depart_name']);
                $activeSheet->setCellValue("C".$current_row,number_format($item['amount_today'],2,'.',',')."¥");
                $activeSheet->setCellValue("D".$current_row,number_format($item['amount_today_lastyear'],2,'.',',')."¥");
                $activeSheet->setCellValue("E".$current_row,number_format($item['difference_day'],2,'.',',')."¥");
                $activeSheet->setCellValue("F".$current_row,$item['percent_day']."%");
                $activeSheet->setCellValue("G".$current_row,number_format($item['amount_thismonth'],2,'.',',')."¥");
                $activeSheet->setCellValue("H".$current_row,number_format($item['amount_thismonth_lastyear'],2,'.',',')."¥");
                $activeSheet->setCellValue("I".$current_row,number_format($item['difference_month'],2,'.',',')."¥");
                $activeSheet->setCellValue("K".$current_row,$item['percent_month']."%");
                $current_row += 1;
            }
            $activeSheet->setCellValue("B".$current_row,"小 計");
            $activeSheet->setCellValue("C".$current_row,number_format($total_amount_today,2,'.',',')."¥");
            $activeSheet->setCellValue("D".$current_row,number_format($total_amount_today_lastyear,2,'.',',')."¥");
            $activeSheet->setCellValue("E".$current_row,number_format($total_difference_day,2,'.',',')."¥");
            $activeSheet->setCellValue("F".$current_row,$total_amount_today_lastyear ==0 ?0:round($total_amount_today/$total_amount_today_lastyear,1)."%");
            $activeSheet->setCellValue("G".$current_row,number_format($total_amount_thismonth,2,'.',',')."¥");
            $activeSheet->setCellValue("H".$current_row,number_format($total_amount_thismonth_lastyear,2,'.',',')."¥");
            $activeSheet->setCellValue("I".$current_row,number_format($total_difference_month,2,'.',',')."¥");
            $activeSheet->setCellValue("K".$current_row,$total_amount_thismonth_lastyear == 0 ? 0:round($total_amount_thismonth/$total_amount_thismonth_lastyear,1)."%");
           
            $current_row += 1;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "営業日報.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	public function pdf_produce_enegy_used(){
		$html = "";
		$mpdf = new mPDF('utf8','A4-L');
        
        $data['date_from'] =  $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $type = $this->input->get('type');
        if($type == 2){
            $datetime_from = new DateTime($data['date_from']);
            $year_from = $datetime_from->format('Y');
            $month_from = $datetime_from->format('m');
            $day_from = $datetime_from->format('d');

            $datetime_to = new DateTime($data['date_to']);
            $year_to = $datetime_to->format('Y');
            $month_to = $datetime_to->format('m');
            $day_to = $datetime_to->format('d');

            $date1 = ($year_from-1)."-".$month_from."-".$day_from;
            $date2 = ($year_to-1)."-".$month_to."-".$day_to;

            $data['date_from'] = $date1;
            $data['date_to'] = $date2;
        }
        $data1 = $this->drivingsituation_model->pdf_produce_enegy_used($data['date_from'],$data['date_to']);

        $datetime_from = new DateTime($data['date_from']);
		$year_from = $datetime_from->format('Y');
		$month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
		$month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $data2 = $this->drivingsituation_model->pdf_produce_enegy_used($date1,$date2);
        $data1["supply_oil_last_year"] = $data2["supply_oil"] == null?0:$data2["supply_oil"];
        $data1["used_oil_last_year"] = $data2["used_oil"] == null?0:$data2["used_oil"];
        $data1["used_oil1_last_year"] = $data2["used_oil1"] == null?0:$data2["used_oil1"];
        $data1["used_oil2_last_year"] = $data2["used_oil2"] == null?0:$data2["used_oil2"];
        $data1["supply_water_last_year"] = $data2["supply_water"] == null?0:$data2["supply_water"];
        $data1["supply_water1_last_year"] = $data2["supply_water1"] == null?0:$data2["supply_water1"];
        $data1["supply_water2_last_year"] = $data2["supply_water2"] == null?0:$data2["supply_water2"];
        $data1["electric_used_last_year"] = $data2["electric_used"] == null?0:$data2["electric_used"];
        $data1["water_kensui_used_last_year"] = $data2["water_kensui_used"] == null?0:$data2["water_kensui_used"];
        $data1["used_gas_last_year"] = $data2["used_gas"] == null?0:$data2["used_gas"];
        $data1["gas1_last_year"] = $data2["gas1"] == null?0:$data2["gas1"];
        $data1["gas2_last_year"] = $data2["gas2"] == null?0:$data2["gas2"];
        $data1["water_meter_used_last_year"] = $data2["water_meter_used"] == null?0:$data2["water_meter_used"];
        $data1["water_meter1_last_year"] = $data2["water_meter1"] == null?0:$data2["water_meter1"];
        $data1["water_meter2_last_year"] = $data2["water_meter2"] == null?0:$data2["water_meter2"];
        $data1["water_special_used_last_year"] = $data2["water_special_used"] == null?0:$data2["water_special_used"];
        $data1["weight_last_year"] = $data2["weight"] == null?0:$data2["weight"];
        $data['lstMaster'] = $data1;
        
        $html = $this->load->view("templates/operation/pdf_produce_enegy_used",$data,true);
        $mpdf->SetTitle("ボイラー");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        if($data1 == null || count($data1) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("ボイラー.pdf","I");
	}

    public function csv_produce_enegy_used(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("ボイラー");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $data['date_from'] =  $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $type = $this->input->get('type');
        if($type == 2){
            $datetime_from = new DateTime($data['date_from']);
            $year_from = $datetime_from->format('Y');
            $month_from = $datetime_from->format('m');
            $day_from = $datetime_from->format('d');

            $datetime_to = new DateTime($data['date_to']);
            $year_to = $datetime_to->format('Y');
            $month_to = $datetime_to->format('m');
            $day_to = $datetime_to->format('d');

            $date1 = ($year_from-1)."-".$month_from."-".$day_from;
            $date2 = ($year_to-1)."-".$month_to."-".$day_to;

            $data['date_from'] = $date1;
            $data['date_to'] = $date2;
        }
        $data1 = $this->drivingsituation_model->pdf_produce_enegy_used($data['date_from'],$data['date_to']);

        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;

        $data2 = $this->drivingsituation_model->pdf_produce_enegy_used($date1,$date2);
        $data1["supply_oil_last_year"] = $data2["supply_oil"] == null?0:$data2["supply_oil"];
        $data1["used_oil_last_year"] = $data2["used_oil"] == null?0:$data2["used_oil"];
        $data1["used_oil1_last_year"] = $data2["used_oil1"] == null?0:$data2["used_oil1"];
        $data1["used_oil2_last_year"] = $data2["used_oil2"] == null?0:$data2["used_oil2"];
        $data1["supply_water_last_year"] = $data2["supply_water"] == null?0:$data2["supply_water"];
        $data1["supply_water1_last_year"] = $data2["supply_water1"] == null?0:$data2["supply_water1"];
        $data1["supply_water2_last_year"] = $data2["supply_water2"] == null?0:$data2["supply_water2"];
        $data1["electric_used_last_year"] = $data2["electric_used"] == null?0:$data2["electric_used"];
        $data1["water_kensui_used_last_year"] = $data2["water_kensui_used"] == null?0:$data2["water_kensui_used"];
        $data1["used_gas_last_year"] = $data2["used_gas"] == null?0:$data2["used_gas"];
        $data1["gas1_last_year"] = $data2["gas1"] == null?0:$data2["gas1"];
        $data1["gas2_last_year"] = $data2["gas2"] == null?0:$data2["gas2"];
        $data1["water_meter_used_last_year"] = $data2["water_meter_used"] == null?0:$data2["water_meter_used"];
        $data1["water_meter1_last_year"] = $data2["water_meter1"] == null?0:$data2["water_meter1"];
        $data1["water_meter2_last_year"] = $data2["water_meter2"] == null?0:$data2["water_meter2"];
        $data1["water_special_used_last_year"] = $data2["water_special_used"] == null?0:$data2["water_special_used"];
        $data1["weight_last_year"] = $data2["weight"] == null?0:$data2["weight"];
        $lstMaster = $data1;
        $current_row = 1;
        $activeSheet->setCellValue("A".$current_row,"エネルギー使用量");
        $activeSheet->setCellValue("E".$current_row,"ボイラー及び設備機器運転日誌");
        $current_row += 1;
        $activeSheet->setCellValue("E".$current_row,$data['date_from']." ～ ".$data['date_to']);
        $current_row += 1;
        $activeSheet->setCellValue("C".$current_row,"前年");
        $activeSheet->setCellValue("F".$current_row,"前年");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●給油量の合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['supply_oil']."l");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['supply_oil_last_year']."l");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●油量使用量の合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['supply_oil']."l");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['supply_oil_last_year']."l");
        $activeSheet->setCellValue("D".$current_row,"◆1号の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['used_oil1']."l");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['used_oil1_last_year']."l");
        $current_row += 1;
        $activeSheet->setCellValue("D".$current_row,"◆2号の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['used_oil2']."l");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['used_oil2_last_year']."l");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●給水使用量の合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['supply_water']."m3");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['supply_water_last_year']."m3");
        $activeSheet->setCellValue("D".$current_row,"◆1号の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['supply_water1']."m3");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['supply_water1_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("D".$current_row,"◆2号の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['supply_water2']."m3");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['supply_water2_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●電力使用量の合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['electric_used']."Kwh");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['electric_used_last_year']."Kwh");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●県水使用量の合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['water_kensui_used']."m3");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['water_kensui_used_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●ガスメーターの合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['used_gas']."m3");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['used_gas_last_year']."m3");
        $activeSheet->setCellValue("D".$current_row,"◆1号の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['gas1']."m3");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['gas1_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("D".$current_row,"◆2号の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['gas2']."m3");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['gas2_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●ガスメーターの合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['water_meter_used']."m3");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['water_meter_used_last_year']."m3");
        $activeSheet->setCellValue("D".$current_row,"◆No1の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['water_meter2']."m3");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['water_meter2_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("D".$current_row,"◆No2の小計");
        $activeSheet->setCellValue("E".$current_row,$lstMaster['water_meter2']."m3");
        $activeSheet->setCellValue("F".$current_row,$lstMaster['water_meter2_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●井水メーター(星製薬)の合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['water_special_used']."m3");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['water_special_used_last_year']."m3");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"●洗濯量の合計");
        $activeSheet->setCellValue("B".$current_row,$lstMaster['weight']."m3");
        $activeSheet->setCellValue("C".$current_row,$lstMaster['weight_last_year']."m3");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "ボイラー.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	public function pdf_produce_enegy_graph(){
		$html = "";
		$mpdf = new mPDF('utf8','A3-L');
        $mpdf->useGraphs = true;
        $mpdf->showImageErrors = true;
        $data['date_from'] =  $this->input->get('date_from');
        $data['date_to'] = $this->input->get('date_to');
        $datetime_from = new DateTime($data['date_from']);
        $year_from = $datetime_from->format('Y');
        $month_from = $datetime_from->format('m');
        $day_from = $datetime_from->format('d');

        $datetime_to = new DateTime($data['date_to']);
        $year_to = $datetime_to->format('Y');
        $month_to = $datetime_to->format('m');
        $day_to = $datetime_to->format('d');

        $date1 = ($year_from-1)."-".$month_from."-".$day_from;
        $date2 = ($year_to-1)."-".$month_to."-".$day_to;
        $data['lstMaster'] = array();
        
        $html = $this->load->view("templates/operation/pdf_produce_enegy_graph",$data,true);
        //var_dump($html);
        $mpdf->SetTitle("ボイラー運転グラフ");
        
        $data1 = $this->drivingsituation_model->pdf_oil_washing($date1,$date2);
        $data2 = $this->drivingsituation_model->pdf_activity_machine($date1,$date2);
        $data3 = $this->drivingsituation_model->pdf_water_graph($date1,$date2);
        $data5 = $this->drivingsituation_model->pdf_electric_washing($date1,$date2);
        $data6 = $this->drivingsituation_model->pdf_water_kensui_washing($date1,$date2);
        //$data1 = $this->getGraphTest();
        //var_dump($this->db->last_query());

 		$html  = str_replace($html, "{image1}", $this->getGraph1($data1));
 		$html .= str_replace($html, "{image2}", $this->getGraph2($data2));
 		$html .= str_replace($html, "{image3}", $this->getGraph3($data3));
		$html .= str_replace($html, "{image4}", $this->getGraph4($data1));
		$html .= str_replace($html, "{image5}", $this->getGraph5($data5));
		$html .= str_replace($html, "{image6}", $this->getGraph6($data6));
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
         $mpdf->WriteHTML($html);
        if($data1 == null || count($data1) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
 		$mpdf->Output("ボイラー運転グラフ.pdf","I");
 		//var_dump($html);
	}

	function pdf_produce_finishing_situation(){
		$html = "";
		$mpdf = new mPDF('utf8','A3-L');
        $mpdf->useGraphs = true;
        $mpdf->showImageErrors = true;
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $resource = $this->finishingsituation_model->pdf_produce_finishing_situation($data['date_from'],$data['date_to']);
        if($resource != null){
            foreach ($resource as $item) {
                if(!isset($data["Master"][$item[PT_PRODUCT_NAME]])){
                    $data["Master"][$item[PT_PRODUCT_NAME]]['total'] = $item['total'];
                }
            }
        }
        $html = $this->load->view("templates/operation/pdf_produce_finishing_situation",$data,true);
        $mpdf->SetTitle("仕上状況");
        if($this->input->get('print') == 'true'){
            $mpdf->SetJS('this.print();');
        }
        $mpdf->WriteHTML($html);
        if($resource == null || count($resource) <= 0) {
            $mpdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
        }
        $mpdf->Output("仕上状況.pdf","I");
        //echo($html);
	}
    public function csv_produce_finishing_situation(){
        $objReader = PHPExcel_IOFactory::createReader(EXCEL_TYPE);
        $objPHPExcel = $objReader->load(EXCEL_PATH.'empty.'.EXCEL_TYPE);
        $objPHPExcel->getActiveSheet()->setTitle("仕上状況");
        $activeSheet = $objPHPExcel->getActiveSheet();
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $resource = $this->finishingsituation_model->pdf_produce_finishing_situation($data['date_from'],$data['date_to']);
        $Master = array();
        if($resource != null){
            foreach ($resource as $item) {
                if(!isset($data["Master"][$item[PT_PRODUCT_NAME]])){
                    $Master[$item[PT_PRODUCT_NAME]]['total'] = $item['total'];
                }
            }
        }
        $current_row = 1;
        $activeSheet->setCellValue("A".$current_row,"エネルギー使用量 仕上量(タオル室・ローラー・プレス)");
        $activeSheet->setCellValue("D".$current_row,"※仕上重量においては、月間生産概要にて別計算");
        $activeSheet->setCellValue("H".$current_row,$this->helper->readDate(date('Y-m-d')));
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,$data['date_from']." ～ ".$data['date_to']);
        $activeSheet->setCellValue("H".$current_row,"単位：枚");
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"シーツ仕上前");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_SHEET]) == true?$Master[FSD_SHEET]['total']:0 );
        $activeSheet->setCellValue("C".$current_row,"シーツしみ");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_SHEETS]) == true?$Master[FSD_SHEETS]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"シーツ洗直し");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_SHEET_WASH_AGAIN]) == true?$Master[FSD_SHEET_WASH_AGAIN]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"シーツ破れ");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_SHEET_BREAKING]) == true?$Master[FSD_SHEET_BREAKING]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"(内5号機仕上)");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_SHEETS_2]) == true?$Master[FSD_SHEETS_2]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"TOP仕上前");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_TOP]) == true?$Master[FSD_TOP]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"シーツしみ");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_TOP_STAINS]) == true?$Master[FSD_TOP_STAINS]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"シーツ洗直し");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_TOP_WASH_AGAIN]) == true?$Master[FSD_TOP_WASH_AGAIN]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"シーツ破れ");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_TOP_BREAK]) == true?$Master[FSD_TOP_BREAK]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"(内5号機仕上)");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_TOP_2]) == true?$Master[FSD_TOP_2]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"デュベ仕上前");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_DUVE]) == true?$Master[FSD_DUVE]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"デュベしみ");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_DUVES_STAIN]) == true?$Master[FSD_DUVES_STAIN]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"デュベ洗直し");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_DUVET_WASH_AGAIN]) == true?$Master[FSD_DUVET_WASH_AGAIN]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"デュベ破れ");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_DUVE_TEAR]) == true?$Master[FSD_DUVE_TEAR]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"(内5号機仕上)");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_DUVE_2]) == true?$Master[FSD_DUVE_2]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"ピロケース");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_PIROCASE]) == true?$Master[FSD_PIROCASE]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"バスタオル(ﾌﾟｰﾙ含)");
        $activeSheet->setCellValue("B".$current_row,isset($Master[BT]) == true?$Master[BT]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"クリーナータオル");
        $activeSheet->setCellValue("D".$current_row,isset($Master[CT]) == true?$Master[CT]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"フェイスタオル");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FT]) == true?$Master[FT]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"バスローブ");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_BATHROBES]) == true?$Master[FSD_BATHROBES]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"ウォッシュタオル");
        $activeSheet->setCellValue("B".$current_row,isset($Master[WT]) == true?$Master[WT]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"ベーシング");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_BASING]) == true?$Master[FSD_BASING]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"バスマット");
        $activeSheet->setCellValue("B".$current_row,isset($Master[BM]) == true?$Master[BM]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"ディッシュタオル");
        $activeSheet->setCellValue("D".$current_row,isset($Master[DT]) == true?$Master[DT]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"ナイトガウン");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_NIGHTGOWN]) == true?$Master[FSD_NIGHTGOWN]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"浴衣浴衣");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_FSD_YUKATA]) == true?$Master[FSD_FSD_YUKATA]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"フィットネス上下");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_TRAINER_AND_OTHERS]) == true?$Master[FSD_TRAINER_AND_OTHERS]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"甚平(上)");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_JINBEI_UPPER]) == true?$Master[FSD_JINBEI_UPPER]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"甚平(下)");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_JINPING_BOTTOM]) == true?$Master[FSD_JINPING_BOTTOM]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"アカスリ");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_AKASURI]) == true?$Master[FSD_AKASURI]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"靴下");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_SOCKS]) == true?$Master[FSD_SOCKS]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"ナプキン他");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_NAPKIN_AND_OTHERS]) == true?$Master[FSD_NAPKIN_AND_OTHERS]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"TDクロス2");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_TD_CROSS_2]) == true?$Master[FSD_TD_CROSS_2]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"短尺他");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_SHORT_SCALE_2]) == true?$Master[FSD_SHORT_SCALE_2]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"短尺他しみ2");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_SHORT_STUBBLE_2]) == true?$Master[FSD_SHORT_STUBBLE_2]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"短尺他洗直し2");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_SHORT_SCALE_OTHER_WASH_2]) == true?$Master[FSD_SHORT_SCALE_OTHER_WASH_2]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"短尺他破れ2");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_SHORT_SCALE_OTHER_CRACK_2]) == true?$Master[FSD_SHORT_SCALE_OTHER_CRACK_2]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"長尺他");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_OTHERS]) == true?$Master[FSD_OTHERS]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"長尺他しみ2");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_LONG_LENGTH_STAIN_2]) == true?$Master[FSD_LONG_LENGTH_STAIN_2]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"長尺他洗直し2");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_LONG_LENGTH_WASH_AGAIN_2]) == true?$Master[FSD_LONG_LENGTH_WASH_AGAIN_2]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"長尺他破れ2");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_LONG_RAKE_OTHER_TEAR_2]) == true?$Master[FSD_LONG_RAKE_OTHER_TEAR_2]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"ポリクロス");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_POLYCLOTH_2]) == true?$Master[FSD_POLYCLOTH_2]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"白衣");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_PANTS]) == true?$Master[FSD_PANTS]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"ズボン");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_SOCKS]) == true?$Master[FSD_SOCKS]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"帽子");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_HAT]) == true?$Master[FSD_HAT]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"ワンピース");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_ONE_PIECE]) == true?$Master[FSD_ONE_PIECE]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"前掛");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_FRONT_HANGING]) == true?$Master[FSD_FRONT_HANGING]['total']:0);
        $activeSheet->setCellValue("C".$current_row,"三角布");
        $activeSheet->setCellValue("D".$current_row,isset($Master[FSD_TRIANGULAR_CLOTH]) == true?$Master[FSD_TRIANGULAR_CLOTH]['total']:0);
        $activeSheet->setCellValue("E".$current_row,"エプロン");
        $activeSheet->setCellValue("F".$current_row,isset($Master[FSD_APRON]) == true?$Master[FSD_APRON]['total']:0);
        $activeSheet->setCellValue("G".$current_row,"スリッパ");
        $activeSheet->setCellValue("H".$current_row,isset($Master[FSD_SLIPPER]) == true?$Master[FSD_SLIPPER]['total']:0);
        $current_row += 1;
        $activeSheet->setCellValue("A".$current_row,"星製薬");
        $activeSheet->setCellValue("B".$current_row,isset($Master[FSD_STAR_PHARMACEUTICAL]) == true?$Master[FSD_STAR_PHARMACEUTICAL]['total']:0);
        $current_row += 1;
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, EXCEL_TYPE);
        //$objWriter->setUseBOM(true);
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_name = "仕上状況.".EXCEL_TYPE;
        header ( 'Content-Encoding: Shift_JIS') ;
        header ( 'Content-Type: application/octet-stream; charset=Shift_JIS') ;
        header('Content-Disposition: attachment;filename='.$file_name);

        $objWriter->save("php://output");
    }

	function getGraph1($data){
		$stickLablel = array();
		foreach ($data as $key => $value) {
			$date=date_create($value['date']);
			array_push($stickLablel, date_format($date,"m/d"));
		}
		//var_dump($stickLablel);
		//var_dump($stickLablel);

		$datay1 = array();
		$datay2 = array();
		foreach ($data as $key => $value) {
			array_push($datay1, ($value['total_oil']/$value['total_washing'])."");
			array_push($datay2,$value['total_washing']);
		}

		$graph = new Graph(1800,500,"auto");
		//$graph->SetMarginColor('#aeaeae');
		$graph->SetMargin(70,70,70,70);
		$graph->legend->SetFont(FF_MINCHO,FS_NORMAL,15);
		$graph->SetTickDensity(TICKD_SPARSE,TICKD_VERYSPARSE); 

		$graph->SetScale('textint');
		$graph->xaxis->SetTickLabels($stickLablel);
		$graph->xaxis->SetLabelFormatString('My',true);
		$graph->SetYScale(0,'int');

		$graph->xaxis->SetLabelFormatString('m/d',true);
		$graph->yaxis->SetLabelFormatString('%dl/t');
		$graph->yaxis->SetLabelMargin(10);
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,12);
		
		$lp1 = new BarPlot($datay1);
		//$lp1->SetWidth(10);
		$lp1->SetFillColor("#ac3973");
		
		$lp1->value->HideZero();
		//$lp1->SetCSIMTargets($targ1,$stickLablel);
		$graph->Add($lp1);
		$lp1->value->Show();

		$lp2 = new LinePlot($datay2);
		$lp2->mark->SetType(MARK_DIAMOND);
		$lp2->mark->SetWidth(15);
		$lp2->mark->SetFillColor('blue');
		$graph->AddY(0,$lp2);
		$lp2->SetColor('blue');
		//$lp2->SetFillColor('#aeaeae');
		//$lp2->SetCSIMTargets($targ2,$stickLablel);
		
		$graph->ynaxis[0]->SetLabelFormatString('%dt/量');
		$graph->ynaxis[0]->SetLabelMargin(10);
		$graph->ynaxis[0]->SetFont(FF_MINCHO,FS_NORMAL,12);
		
		$lp2->value->Show();
		$graph->legend->SetAbsPos(0.1,0.1,'left','top');
		$graph->legend->SetMarkAbsSize(15);
		$graph->legend->SetLayout(LEGEND_HOR);
		$graph->legend->SetFrameWeight(1);
		$lp1->SetLegend("重油・洗濯量比");
		$lp2->SetLegend('洗濯量');
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
		ob_start();
		imagepng($gdImgHandler);
		$image_data = ob_get_contents();
		ob_end_clean();

		return '<img src="data:image/jpg;base64,' . base64_encode($image_data).'" />';
	}

	function getGraph2($data){
		$stickLablel = array();
		foreach ($data as $key => $value) {
			$date=date_create($value['date']);
			array_push($stickLablel, date_format($date,"m/d"));
		}
		//var_dump($stickLablel);
		//var_dump($stickLablel);

		$datay1 = array();
		$datay2 = array();
		$datay3 = array();
		$datay4 = array();
		foreach ($data as $key => $value) {
			//var_dump($value['time1']);
			array_push($datay1, $value['time1']);
			array_push($datay2, $value['time2']);
			array_push($datay3, $value['blow1']);
			array_push($datay4, $value['blow2']);
		}
		
		$graph = new Graph(1800,500,"auto");
		//$graph->SetMarginColor('#aeaeae');
		$graph->SetMargin(100,100,100,100);
		$graph->legend->SetColumns(2);
		$graph->legend->SetFont(FF_MINCHO,FS_NORMAL,15);
		$graph->SetTickDensity(TICKD_SPARSE,TICKD_VERYSPARSE);

		$graph->SetScale('textint');
		$graph->xaxis->SetTickLabels($stickLablel);
		
		
		$graph->SetYScale(0,'int');

		//$graph->xaxis->SetLabelFormatString('m/d',true);
		$graph->yaxis->SetLabelFormatString('%d:00');
		$graph->yaxis->SetLabelMargin(10);
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,12);
		
		$lp1 = new BarPlot($datay1);
		$lp1->SetNoFill(); 
		$lp1->SetFillColor("#ac3973");
		$lp1->SetLegend('稼働時間(1号)');

		$lp2 = new BarPlot($datay2);
		$lp2->SetNoFill(); 
		$lp2->SetFillColor("pink");
		$lp2->SetLegend('稼働時間(2号)');
		 
		$gbplot = new GroupBarPlot(array($lp1,$lp2));
		$graph->Add($gbplot);

		$lp3 = new LinePlot($datay3);
		$lp3->SetLegend('ブロー量(1号)');
		$lp3->SetBarCenter();
		$lp3->mark->SetType(MARK_DIAMOND);
		$lp3->mark->SetWidth(15);
		$lp3->mark->SetFillColor('blue');
		$graph->AddY(0,$lp3);
		$lp3->SetColor('blue');

		$lp4 = new LinePlot($datay4);
		$lp4->SetLegend('ブロー量(2号)');
		$lp4->SetBarCenter();
		$lp4->mark->SetType(MARK_DIAMOND);
		$lp4->mark->SetWidth(15);
		$lp4->mark->SetFillColor('#00ffff');
		$graph->AddY(0,$lp4);
		$lp4->SetColor('#00ffff');

		$lp1->value->Show();
		$lp2->value->Show();
		$lp3->value->Show();
		$lp4->value->Show();
		$graph->ynaxis[0]->SetLabelFormatString('%dt/量');
		$graph->ynaxis[0]->SetLabelMargin(10);
		$graph->ynaxis[0]->SetFont(FF_MINCHO,FS_NORMAL,12);
		$graph->legend->SetAbsPos(0.1,0.1,'left','top');
		$graph->legend->SetMarkAbsSize(15);
		$graph->legend->SetLayout(LEGEND_HOR);
		$graph->legend->SetFrameWeight(1);
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
		ob_start();
		imagepng($gdImgHandler);
		$image_data = ob_get_contents();
		ob_end_clean();

		return '<img src="data:image/jpg;base64,' . base64_encode($image_data).'" />';
	}

	function getGraph3($data){
		$stickLablel = array();
		foreach ($data as $key => $value) {
			$date=date_create($value['date']);
			array_push($stickLablel, date_format($date,"m/d"));
		}
		//var_dump($stickLablel);
		//var_dump($stickLablel);

		$datay1 = array();
		$datay2 = array();
		$datay3 = array();
		foreach ($data as $key => $value) {
			//var_dump($value['time1']);
			array_push($datay1, $value['hot_well']);
			array_push($datay2, $value['boiler']);
			array_push($datay3, $value['drain']);
		}
		
		$graph = new Graph(1800,500,"auto");
		//$graph->SetMarginColor('#aeaeae');
		$graph->SetMargin(100,100,100,100);
		$graph->legend->SetColumns(2);
		$graph->legend->SetFont(FF_MINCHO,FS_NORMAL,15);
		$graph->SetTickDensity(TICKD_SPARSE,TICKD_VERYSPARSE);

		$graph->SetScale('textint');
		$graph->xaxis->SetTickLabels($stickLablel);
		
		
		$graph->SetYScale(0,'int');

		//$graph->xaxis->SetLabelFormatString('m/d',true);
		$graph->yaxis->SetLabelFormatString('%d m');
		$graph->yaxis->SetLabelMargin(10);
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,12);
		
		$lp1 = new BarPlot($datay1);
		$lp1->SetNoFill(); 
		$lp1->SetFillColor("#ac3973");
		$lp1->SetLegend('稼働時間(1号)');

		$lp2 = new BarPlot($datay2);
		$lp2->SetNoFill(); 
		$lp2->SetFillColor("pink");
		$lp2->SetLegend('稼働時間(2号)');
		 
		$gbplot = new GroupBarPlot(array($lp1,$lp2));
		$graph->Add($gbplot);

		$lp3 = new LinePlot($datay3);
		$lp3->SetLegend('ブロー量(1号)');
		$lp3->SetBarCenter();
		$lp3->mark->SetType(MARK_DIAMOND);
		$lp3->mark->SetWidth(15);
		$lp3->mark->SetFillColor('blue');
		$graph->AddY(0,$lp3);
		$lp3->SetColor('blue');

		$lp1->value->Show();
		$lp2->value->Show();
		$lp3->value->Show();
		$graph->ynaxis[0]->SetLabelFormatString("%d %%");
		$graph->ynaxis[0]->SetLabelMargin(10);
		$graph->ynaxis[0]->SetFont(FF_MINCHO,FS_NORMAL,12);
		$graph->legend->SetAbsPos(0.1,0.1,'left','top');
		$graph->legend->SetMarkAbsSize(15);
		$graph->legend->SetLayout(LEGEND_HOR);
		$graph->legend->SetFrameWeight(1);
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
		ob_start();
		imagepng($gdImgHandler);
		$image_data = ob_get_contents();
		ob_end_clean();

		return '<img src="data:image/jpg;base64,' . base64_encode($image_data).'" />';
	}

	function getGraph4($data){
		$stickLablel = array();
		foreach ($data as $key => $value) {
			$date=date_create($value['date']);
			array_push($stickLablel, date_format($date,"m/d"));
		}
		//var_dump($stickLablel);
		//var_dump($stickLablel);

		$datay1 = array();
		$datay2 = array();
		foreach ($data as $key => $value) {
			array_push($datay1, ($value['total_oil'])."");
			array_push($datay2,$value['total_washing']);
		}

		$graph = new Graph(1800,500,"auto");
		//$graph->SetMarginColor('#aeaeae');
		$graph->SetMargin(70,70,70,70);
		$graph->legend->SetFont(FF_MINCHO,FS_NORMAL,15);
		$graph->SetTickDensity(TICKD_SPARSE,TICKD_VERYSPARSE); 

		$graph->SetScale('textint');
		$graph->xaxis->SetTickLabels($stickLablel);
		$graph->xaxis->SetLabelFormatString('My',true);
		$graph->SetYScale(0,'int');

		$graph->xaxis->SetLabelFormatString('m/d',true);
		$graph->yaxis->SetLabelFormatString('%d l');
		$graph->yaxis->SetLabelMargin(10);
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,12);
		
		$lp1 = new BarPlot($datay1);
		//$lp1->SetWidth(10);
		$lp1->SetFillColor("#ac3973");
		$lp1->SetLegend('重油使用量');
		$lp1->value->HideZero();
		//$lp1->SetCSIMTargets($targ1,$stickLablel);
		$graph->Add($lp1);
		$lp1->value->Show();

		$lp2 = new LinePlot($datay2);
		$lp2->SetLegend('洗濯量');
		$lp2->mark->SetType(MARK_DIAMOND);
		$lp2->mark->SetWidth(15);
		$lp2->mark->SetFillColor('blue');
		$graph->AddY(0,$lp2);
		$lp2->SetColor('blue');
		//$lp2->SetFillColor('#aeaeae');
		//$lp2->SetCSIMTargets($targ2,$stickLablel);
		
		$graph->ynaxis[0]->SetLabelFormatString('%dt/量');
		$graph->ynaxis[0]->SetLabelMargin(10);
		$graph->ynaxis[0]->SetFont(FF_MINCHO,FS_NORMAL,12);
		
		$lp2->value->Show();
		$graph->legend->SetAbsPos(0.1,0.1,'left','top');
		$graph->legend->SetMarkAbsSize(15);
		$graph->legend->SetLayout(LEGEND_HOR);
		$graph->legend->SetFrameWeight(1);
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
		ob_start();
		imagepng($gdImgHandler);
		$image_data = ob_get_contents();
		ob_end_clean();

		return '<img src="data:image/jpg;base64,' . base64_encode($image_data).'" />';
	}

	function getGraph5($data){
		$stickLablel = array();
		foreach ($data as $key => $value) {
			$date=date_create($value['date']);
			array_push($stickLablel, date_format($date,"m/d"));
		}
		//var_dump($stickLablel);
		//var_dump($stickLablel);

		$datay1 = array();
		$datay2 = array();
		foreach ($data as $key => $value) {
			array_push($datay1, ($value['total_power']));
			array_push($datay2,$value['total_washing']);
		}

		$graph = new Graph(1800,500,"auto");
		//$graph->SetMarginColor('#aeaeae');
		$graph->SetMargin(70,70,70,70);
		$graph->legend->SetFont(FF_MINCHO,FS_NORMAL,15);
		$graph->SetTickDensity(TICKD_SPARSE,TICKD_VERYSPARSE); 

		$graph->SetScale('textint');
		$graph->xaxis->SetTickLabels($stickLablel);
		$graph->xaxis->SetLabelFormatString('My',true);
		$graph->SetYScale(0,'int');

		$graph->xaxis->SetLabelFormatString('m/d',true);
		$graph->yaxis->SetLabelFormatString('%d Kwh');
		$graph->yaxis->SetLabelMargin(10);
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,12);
		
		$lp1 = new BarPlot($datay1);
		//$lp1->SetWidth(10);
		$lp1->SetFillColor("#ac3973");
		$lp1->SetLegend('電力量');
		$lp1->value->HideZero();
		//$lp1->SetCSIMTargets($targ1,$stickLablel);
		$graph->Add($lp1);
		$lp1->value->Show();

		$lp2 = new LinePlot($datay2);
		$lp2->SetLegend('洗濯量');
		$lp2->mark->SetType(MARK_DIAMOND);
		$lp2->mark->SetWidth(15);
		$lp2->mark->SetFillColor('blue');
		$graph->AddY(0,$lp2);
		$lp2->SetColor('blue');
		//$lp2->SetFillColor('#aeaeae');
		//$lp2->SetCSIMTargets($targ2,$stickLablel);
		
		$graph->ynaxis[0]->SetLabelFormatString('%dt/量');
		$graph->ynaxis[0]->SetLabelMargin(10);
		$graph->ynaxis[0]->SetFont(FF_MINCHO,FS_NORMAL,12);
		
		$lp2->value->Show();
		$graph->legend->SetAbsPos(0.1,0.1,'left','top');
		$graph->legend->SetMarkAbsSize(15);
		$graph->legend->SetLayout(LEGEND_HOR);
		$graph->legend->SetFrameWeight(1);
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
		ob_start();
		imagepng($gdImgHandler);
		$image_data = ob_get_contents();
		ob_end_clean();

		return '<img src="data:image/jpg;base64,' . base64_encode($image_data).'" />';
	}

	function getGraph6($data){
		$stickLablel = array();
		foreach ($data as $key => $value) {
			$date=date_create($value['date']);
			array_push($stickLablel, date_format($date,"m/d"));
		}
		//var_dump($stickLablel);
		//var_dump($stickLablel);

		$datay1 = array();
		$datay2 = array();
		foreach ($data as $key => $value) {
			array_push($datay1, ($value['total_water_kensui']));
			array_push($datay2,$value['total_washing']);
		}

		$graph = new Graph(1800,500,"auto");
		//$graph->SetMarginColor('#aeaeae');
		$graph->SetFrame(false);
		$graph->SetMargin(70,70,70,70);
		$graph->legend->SetFont(FF_MINCHO,FS_NORMAL,15);
		
		$graph->SetTickDensity(TICKD_SPARSE,TICKD_VERYSPARSE); 

		$graph->SetScale('textint');
		$graph->xaxis->SetTickLabels($stickLablel);
		$graph->xaxis->SetLabelFormatString('My',true);
		$graph->SetYScale(0,'int');

		$graph->xaxis->SetLabelFormatString('m/d',true);
		$graph->yaxis->SetLabelFormatString('%d l');
		$graph->yaxis->SetLabelMargin(10);
		$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,12);
		
		$lp1 = new BarPlot($datay1);
		//$lp1->SetWidth(10);
		$lp1->SetFillColor("#ac3973");
		$lp1->SetLegend('井水(当社)');
		$lp1->value->HideZero();
		//$lp1->SetCSIMTargets($targ1,$stickLablel);
		$graph->Add($lp1);
		$lp1->value->Show();

		$lp2 = new LinePlot($datay2);
		$lp2->SetLegend('洗濯量');
		$lp2->mark->SetType(MARK_DIAMOND);
		$lp2->mark->SetWidth(15);
		$lp2->mark->SetFillColor('blue');
		$graph->AddY(0,$lp2);
		$lp2->SetColor('blue');
		//$lp2->SetFillColor('#aeaeae');
		//$lp2->SetCSIMTargets($targ2,$stickLablel);
		
		$graph->ynaxis[0]->SetLabelFormatString('%dt/量');
		$graph->ynaxis[0]->SetLabelMargin(10);
		$graph->ynaxis[0]->SetFont(FF_MINCHO,FS_NORMAL,12);
		
		$lp2->value->Show();
		$graph->legend->SetFrameWeight(1);
		$graph->legend->SetAbsPos(0.1,0.1,'left','top');
		$graph->legend->SetMarkAbsSize(15);
		$graph->legend->SetLayout(LEGEND_HOR);
		$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
		ob_start();
		imagepng($gdImgHandler);
		$image_data = ob_get_contents();
		ob_end_clean();

		return '<img src="data:image/jpg;base64,' . base64_encode($image_data).'" />';
	}
}

