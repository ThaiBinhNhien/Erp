<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @id       $Id: log_helper.php $
 * @author   $Author: PHAN TIEN ANH $
 * @Revesion $Rev: 1 $
 */

 /**
 * function	logupcsv
 */
if ( ! function_exists( 'logupcsv' ) ) {
    function logupcsv($data,$table_name='', $add_str='') {
        logd($data ,$table_name , $add_str, 'UP_CSV');
    }
}

/**
 * function	logadd
 */
if ( ! function_exists( 'logadd' ) ) {
    function logadd($data,$table_name='', $add_str='') {
        logd($data ,$table_name , $add_str, 'ADD');
    }
}

/**
 * function	logedit
 */
if ( ! function_exists( 'logedit' ) ) {
    function logedit($data,$table_name='', $add_str='') {
        // Logedit
        $message = "";
        $is_change = false;
        if (is_array($data) || is_object($data)) {
            // ID
            if(isset($data["id"])) {
                foreach ($data["id"] as $key => $value) {
                    $message .= $key . ":" . $value;
                }
            }

            // Data
            if(isset($data["data_old"]) && isset($data["data_new"])) {
                foreach ($data["data_old"] as $key_old => $value_old) {
                    foreach ($data["data_new"] as $key_new => $value_new) {
                        if($key_old == $key_new && $value_old != $value_new) {
                            $is_change = true;
                            $message .= " , ";
                            $message .= $key_old . " : " . $value_old . " => " . $value_new;
                        }
                    }
                }
            }
        }
        
        if($is_change == true) {
            logd($message ,$table_name , $add_str, 'EDIT');
        }
    }
}

/**
 * function	logdelete
 */
if ( ! function_exists( 'logdelete' ) ) {
    function logdelete($data,$table_name='', $add_str='') {
        logd($data ,$table_name, $add_str, 'DELETE');
    }
}

/**
 * function	logd
 */
if ( ! function_exists( 'logd' ) ) {
    function logd($data ,$table_name, $add_str='', $level='debug' , $show_filename=true) {

        if (is_array($data) || is_object($data)) {
            $space = "\n";
            $message = print_r($data,true) . $space . $add_str ;
        } else {
            $space = ' ';
            $message = $data . $space . $add_str ;
        }

        debug_log($level, $message,$table_name, 'application-'.$level);
    }
}

/**
 * function	debug_log
 */ 
if (!function_exists('debug_log'))
{
    function debug_log($level, $message,$table_name, $prefix = 'debug', $php_error = FALSE)
    {
        $_log =& load_class('MyLog');
        $_log->write_log_custom($level, $message,$table_name, $php_error, $prefix, FALSE);
    }
} 

/**
 * function	open_log
 */
if (!function_exists('open_log'))
{
    function open_log($start = 0,$number = 20)
    {
        $_log =& load_class('MyLog');
        $data = $_log->readLog();
        $returnData = [];
        if(!empty($data)) {
            $arrData = explode("\n",$data);
            $countArrData = count($arrData) - $start;
            foreach ($arrData as $key => $value) {
                $endKey = $countArrData-1;
                $startKey = $endKey - $number;
                if($startKey <= $key && $key < $endKey) {
                    if(isset($value) && !empty($value) && $value != "") {
                        $valueLog = explode(" - ",$value);
                        $arrLog = [];
                        $arrLog["date"] = isset($valueLog[0]) ? $valueLog[0] : "";
                        $arrLog["user"] = isset($valueLog[1]) ? $valueLog[1] : "";
                        $arrLog["table"] = isset($valueLog[2]) ? $valueLog[2] : "";
                        $arrLog["name_access"] = isset($valueLog[3]) ? $valueLog[3] : "";
                        $arrLog["infor"] = isset($valueLog[4]) ? str_replace(",","<br>",$valueLog[4]) : "";
                        array_push($returnData,$arrLog);
                    }
                }
            }
        }
        return $returnData;
    }
} 