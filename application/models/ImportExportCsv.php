<?php

class ImportExportCsv extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('phpexcel'); 
        $this->load->library('PHPExcel/PHPExcel_iofactory');
	}

    /**
     * @param
     * $title : title
     * $column_title : table title
     * $column_show_data : database title
     * $column_value_data : database value
     * 
	* Function: export
	* @access public 
	*/
    public function export($title, $column_title, $column_show_data,$result){

        $data = array();

        // Title
        if(isset($column_title)) {
            $data_detail = array();
            foreach($column_title as $key_title=>$value_title) {
                $value_title = str_replace(array("\r\n", "\n\r", "\n", "\r",'"'), '', $value_title);
                array_push(
                    $data_detail,
                    mb_convert_encoding($value_title, "UTF-8") // Convert data to shift-JIS
                );
            }
            array_push(
                $data,
                $data_detail
            );
        }

        // Data
        if(isset($column_show_data)) {
            foreach ($result as $key => $value) {
                $data_detail = array();
                foreach($column_show_data as $key_title=>$value_title) {
                    if($value_title != null && $value_title != "") {
                   $value_data = str_replace(array("\r\n", "\n\r", "\n", "\r"), '', $value[$value_title]);
                    } else {
                        $value_data = "";
                    }
                    array_push(
                        $data_detail,
                        mb_convert_encoding($value_data, "UTF-8") // Convert data to shift-JIS
                    );
                }
                array_push(
                    $data,
                    $data_detail
                ); 
            }
        }

        header('Content-Encoding: UTF-8') ;
        header('Content-Type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachement; filename='.rawurlencode($title.'.csv'));

        echo "\xEF\xBB\xBF";
        $stream = fopen('php://output', 'w');
        foreach($data as $row){
            fputcsv($stream, $row);
        }
    }

    /**
     * @param
     * $filename : file
     * 
	* Function: import
	* @access public
	*/
    public function import($filename){
        $row = 0;
        $sheetTitle = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
        $sheetData = array();

        // get encode
        $buffer = file_get_contents($filename);
        $encode = mb_detect_encoding(str_replace(array("\0", "\xFE","\xFF"), "", $buffer), mb_list_encodings());
        
        if($encode == false) {
            $encode = "UTF-8";
        }
        
        if (($handle = fopen($filename, "r")) !== FALSE) {
            //while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
                while (($data = fgetcsv($handle, 0, ",","'")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row > 1) {
                    $arr_data = array();
                    for ($c=0; $c < $num; $c++) {

                        // Convert data to UTF-8
                        if(isset($sheetTitle[$c])) {
                            if($data[$c] != null && $data[$c] != "") {
                                $arr_data[$sheetTitle[$c]] = mb_convert_encoding($data[$c], "UTF-8", "$encode");
                            }
                        }

                    }
                    if(count($arr_data) > 0) {
                        array_push(
                            $sheetData,
                            $arr_data
                        );
                    }
                }
            }
            fclose($handle);
        }

		return $sheetData;
    }

    // Xuất csv có detail
    function export_detail($title,$sheets){
        
        $data = array();

        // Title
        if(isset($sheets)) {
            foreach ($sheets as $index => $sheet_data) {
                if($index != 0){
                    $data_detail = array();
                    array_push(
                        $data_detail,
                        mb_convert_encoding('detail', "UTF-8")
                    );
                    array_push(
                        $data_detail,
                        mb_convert_encoding($sheet_data['title'], "UTF-8")
                    );
                    array_push(
                        $data,
                        $data_detail
                    );
                }

                // Title
                if(isset($sheet_data['column_title'])) {
                    $data_detail = array();
                    foreach($sheet_data['column_title'] as $key_title=>$value_title) {
                        array_push(
                            $data_detail,
                            mb_convert_encoding($value_title, "UTF-8") // Convert data to shift-JIS
                        );
                    }
                    array_push(
                        $data,
                        $data_detail
                    );
                }

                // Data
                if(isset($sheet_data['column_value_data'])) {
                    foreach ($sheet_data['column_value_data'] as $key => $value) {
                        $data_detail = array();
                        foreach($sheet_data['column_show_data'] as $key_title=>$value_title) {
                            array_push(
                                $data_detail,
                                mb_convert_encoding($value[$value_title], "UTF-8") // Convert data to shift-JIS
                            );
                        }
                        array_push(
                            $data,
                            $data_detail
                        );
                    }
                }
            }
        }

        header('Content-Encoding: UTF-8') ;
        header('Content-Type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachement; filename='.rawurlencode($title.'.csv'));
          
        echo "\xEF\xBB\xBF";
        $stream = fopen('php://output', 'w');
        foreach($data as $row){
            fputcsv($stream, $row);
        }
        
    }

    // Import csv có detail
    public function import_detail($filename){
        $row = 0;
        $sheetTitle = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
        $sheetData = array();
        $sheetData_master = array();
        $sheetData_detail = array();
        $sheetData_detail_data = array();
        $flag_is_master = true;
        $i_detail = 0;

        // get encode
        $buffer = file_get_contents($filename);
        $encode = mb_detect_encoding(str_replace(array("\0", "\xFE","\xFF"), "", $buffer), mb_list_encodings());
        
        if($encode == false) {
            $encode = "UTF-8";
        }

        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ",","'")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row > 1) {
                    $arr_data = array();
                    $result['item_detail'] = array();
                    $result['master'] = array();
                    for ($c=0; $c < $num; $c++) {

                        // Convert data to UTF-8
                        if($c == 0 && $data[$c] == 'detail') {
                            $flag_is_master = false;
                        }

                        if($flag_is_master == true) {
                            if(isset($sheetTitle[$c])) {
                                $arr_data[$sheetTitle[$c]] = mb_convert_encoding($data[$c], "UTF-8", "$encode");
                            }
                        } else {

                            if($c == 0 && $data[$c] == 'detail') {
                                $sheetData_detail_data = array();
                                $i_detail++;
                                $row = 0;
                                $flag_is_master = false;
                                $c++;
                                $sheetData_detail[$i_detail]['name'] = mb_convert_encoding($data[$c], "UTF-8", "$encode");
                                break;
                            } 

                            if(isset($sheetTitle[$c])) {
                                $arr_data[$sheetTitle[$c]] = mb_convert_encoding($data[$c], "UTF-8", "$encode");
                            }

                        }
                        
                    }
                    if($flag_is_master == true) {
                        if(count($arr_data) > 0) {
                            array_push(
                                $sheetData_master,
                                $arr_data
                            );
                        }
                    } else {
                        if(count($arr_data) > 0) {
                            array_push(
                                $sheetData_detail_data,
                                $arr_data
                            );
                            $sheetData_detail[$i_detail]['detail'] = $sheetData_detail_data;
                        }
                    }
                }

            }
            fclose($handle);
        }

        $sheetData_detail = array_map("unserialize", array_unique(array_map("serialize", $sheetData_detail)));
        $sheetData_detail = array_values($sheetData_detail);
            
        $sheetData['master'] = $sheetData_master;
        $sheetData['item_detail'] = $sheetData_detail;

        return $sheetData;
        
    }
    
    /*
	 * Header for csv
	 */
	public function download_send_header_csv($title){
        header('Content-Encoding: UTF-8') ;
        header('Content-Type: application/csv; charset=UTF-8');
        header('Content-Disposition: attachement; filename='.rawurlencode($title.'.csv'));
    }

    /*
	 * Array to csv
     * @Param $array_data
	 */
	public function array_to_csv($array_data){
        ob_start();
        echo "\xEF\xBB\xBF";
        $stream = fopen('php://output', 'w');
        foreach($array_data as $row){
            fputcsv($stream, $row);
        }
        fclose($stream);
        return ob_get_clean();
    }
}