<?php 

/**
 * @id       $Class: CI_MyLog
 * @author   $Author: PHAN TIEN ANH $
 * @Revesion $Rev: 1 $
 */

class CI_MyLog extends CI_Log  {

    function CI_MyLog ()
    {
        parent::__construct();

        $this->ci =& get_instance();

        $this->LOGIN_INFO = $this->ci->session->userdata('login-info');
    }

    /**
	 * Write Log File
	 *
	 * @param	string	$level
	 * @param	string	$msg
	 * @param	string	$table
	 * @return	bool
	 */
	public function write_log_custom($level, $msg, $table_name = '')
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$filepath = $this->_log_path.'/change/log-'.date('Y').'.txt';
		$message = '';

		if ( ! file_exists($filepath))
		{
			$newfile = TRUE;
		}

		if ( ! $fp = @fopen($filepath, 'ab'))
		{
			return FALSE;
		}

		flock($fp, LOCK_EX);

		// Instantiating DateTime
		if (strpos($this->_date_fmt, 'u') !== FALSE)
		{
			$microtime_full = microtime(TRUE);
			$microtime_short = sprintf("%06d", ($microtime_full - floor($microtime_full)) * 1000000);
			$date = new DateTime(date('Y-m-d H:i:s.'.$microtime_short, $microtime_full));
			$date = $date->format($this->_date_fmt);
		}
		else
		{
			$date = date($this->_date_fmt);
		}

        // Write Message
        $user_name = $this->LOGIN_INFO[U_ID];
		$message .= $this->_format_line_custom($date,$user_name,$table_name,$level, $msg);

		for ($written = 0, $length = self::strlen($message); $written < $length; $written += $result)
		{
			if (($result = fwrite($fp, self::substr($message, $written))) === FALSE)
			{
				break;
			}
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		if (isset($newfile) && $newfile === TRUE)
		{
			chmod($filepath, $this->_file_permissions);
		}

		return is_int($result);
	}
	
	/**
	 * Read Log File
	 *
	 * @return	array
	 */
	public function readLog(){
		$filepath = $this->_log_path.'/change/log-'.date('Y').'.txt';
		$dataRead = "";
		if(file_exists($filepath)) {
			$myfile = fopen($filepath, "r") or die("Unable to open file!");
			$dataRead = fread($myfile,filesize($filepath));
			fclose($myfile);
		}
		return $dataRead;
	}
    
    /**
	 * Format the log line.
	 *
	 * @param	string	$date
	 * @param	string	$user
	 * @param	string	$table
     * @param	string	$name_access
     * @param	string	$infor
	 * @return	string	Formatted log inline
	 */
	protected function _format_line_custom($date, $user, $table, $name_access, $infor)
	{
		return $date.' - '.$user.' - '.$table.' - '.$name_access.' - '.$infor."\n";
	}
}