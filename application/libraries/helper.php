<?php
 class helper{
	public function __construct(){
		$this->day_in_week = -1;
	}

	/**
	* @return 
		0 : Sunday
		1 : Monday
		2 : Tuesday
		3 : Wednesday
		4 : Thursday
		5 : Friday
		6 : Saturday
	*/
	public function getDayInWeek($date){
		$this->day_in_week  = date('w', strtotime($date));
		return $this->day_in_week ;
	}

	public function toDayString( $value){
		$data = array('日','月','火','水','水','金','土');
		return $data[$value];
	}

	public function readDateTime($date){
		if($date == NULL)
			return NULL;
		$datetime = new DateTime($date);
		$year = $datetime->format('Y');
		$month = $datetime->format('m');
		$day = $datetime->format('d');
		$hour = $datetime->format('H');
		$minute = $datetime->format('i');
		$day_in_week = self::getDayInWeek($date);
		$day_in_week = self::toDayString($day_in_week);
		return $year.'年'.$month.'月'.$day.'日'."($day_in_week)".' '.$hour.':'.$minute;
	}

	public function readDate($date){
		if($date == NULL)
			return NULL;
		$year = date('Y',strtotime($date));
		$month = date('m',strtotime($date));
		$day = date('d',strtotime($date));
		$day_in_week = self::getDayInWeek($date);
		$day_in_week = self::toDayString($day_in_week);
		return $year.'年'.$month.'月'.$day.'日'."($day_in_week)";
	}

	public function readDateNotText($date){
		if($date == NULL)
			return NULL;
		$year = date('Y',strtotime($date));
		$month = date('m',strtotime($date));
		$day = date('d',strtotime($date));
		$day_in_week = self::getDayInWeek($date);
		$day_in_week = self::toDayString($day_in_week);
		return $year.'年'.$month.'月'.$day.'日';
	}

	public function readDateOneYear($date){
		if($date == NULL)
			return NULL;
		$year = date('Y',strtotime($date));
		$month = date('m',strtotime($date));
		$day = date('d',strtotime($date));
		$date = ($year-1).'/'.$month.'/'.$day;
		return $date;
	}
	public function readDateMMYY($date){
		if($date == NULL)
			return NULL;
		$year = date('Y',strtotime($date));
		$month = date('m',strtotime($date));
		$date = $year.'/'.$month;
		return $date;
	}

	public function readDateYearKing($date){
		if($date == NULL)
			return NULL;
		$number_year = 0;
		$year = date('Y',strtotime($date));
		$month = date('m',strtotime($date));
		$day = date('d',strtotime($date));
		$day_in_week = self::getDayInWeek($date);
		$day_in_week = self::toDayString($day_in_week);
		$number_year = ($year - YEAR_KING_START) + YEAR_KING_NUMBER;
		return YEAR_KING_JAPAN . $number_year.'年'.$month.'月'.$day.'日';
	}

	public function convertDateJapantoDate($date){
        $vowels = array('年', '月', '日', '火', '水', '水', '金', '土');
        list($year,$month,$day) = explode('-', str_replace($vowels, "-", $date));

        return $year.'-'.$month.'-'.$day;
    }

    public function readDateTimeReport($date){
		if($date == NULL)
			return NULL;
		$datetime = new DateTime($date);
		$year = $datetime->format('Y');
		$year = substr($year, 2);
		$month = $datetime->format('m');
		$day = $datetime->format('d');
		$day_in_week = self::getDayInWeek($date);
		$day_in_week = self::toDayString($day_in_week);
		return $year.'/'.$month.'/'.$day."($day_in_week)";
	}

	/**
    * Function: getFirtDayInMonth
	* @access public
	* @return date
    */
	public function getFirtDayInMonth($date = NULL){
		if($date == NULL) {
			$year = date('Y');
			$month = date('m');
		}
		else {
			$year = date('Y',strtotime($date));
			$month = date('m',strtotime($date)); 
		}
		$day = "1";
		$date = $year.'/'.$month.'/'.$day;
		return $date;
	}

	/**
    * Function: getLastDayInMonth
	* @access public
	* @return date
    */
	public function getLastDayInMonth($date){

		if($date == NULL) {
			$year = date('Y');
			$month = date('m');
			$day = date('t');
		}
		else {
			$year = date('Y',strtotime($date));
			$month = date('m',strtotime($date));
			$day = date('t',strtotime($date));
		}
		$date = $year.'/'.$month.'/'.$day;
		return $date;
	}

	public function getLastDayInMonthDY($date){
		if($date == NULL) {
			$month = date('m');
			$day = date('t');
		}
		else {
			$month = date('m',strtotime($date));
			$day = date('t',strtotime($date));
		}

		return $day.'年'.$month.'月';
	}

	/**
    * Function: getFirtDayInWeekly
	* @access public
	* @return date
    */
	public function getFirtDayInWeekly(){
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		if(0 < $day && $day < 10) {
			$day = "01";
		} else if(10 < $day && $day <= 20) {
			$day = "11";
		} else {
			$day = "21";
		}
		$date = $year.'/'.$month.'/'.$day;
		return $date;
	}

	/**
    * Function: getLastDayInWeekly
	* @access public
	* @return date
    */
	public function getLastDayInWeekly(){
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		if(0 < $day && $day < 10) {
			$day = "10";
		} else if(10 < $day && $day <= 20) {
			$day = "20";
		} else {
			$day = "31";
		}
		$date = $year.'/'.$month.'/'.$day;
		return $date;
	}
}