<?php

class WeekCounter {

	const STARTDAY = 01;
	const STARTMONTH = 03;
	
	private $day;
	private $month;
	private $year;

	public function __construct($year, $month, $day) {
		$this->day = sprintf("%02d", $day);
		$this->month = sprintf("%02d", $month);
		$this->year = sprintf("%04d", $year);
	}

	function whichWeek() {

		$dateFrom = $this->findStartDate($this->year, $this->month, $this->day);
		$dateTo = date_create($this->year.'-'.$this->month.'-'.$this->day);
		
		$interval = date_diff($dateFrom, $dateTo);
		$numberOfWeek = ceil($interval->format('%a')/7);

		if($dateTo->format('N') == 4) {
			$numberOfWeek++;
		}

		return $numberOfWeek;
	}

	/**
	* The method checks the given date - its day number (1 - Monday, 7 - Sunday), returns the INT value that is missing until Thursday
	*/
	private function findThursday(DateTime $date) {
		switch($date->format('N')) {
			case 1: return 3; break;
			case 2: return 2; break;
			case 3: return 1; break;
			case 4: return 0; break;
			case 5: return 6; break;
			case 6: return 5; break;
			case 7: return 4; break;
		}
	}

	/**
	* The method which is to find the first Thursday in March from 01.03
	*/
	private function findStartDate($year, $month, $day) {
		if($month < "03") {
			$year--;
		}
		if($month == "03" && $day < 7) {
			if(!$this->isBetweenThursday($year, $month, $day)) {
				$year--;
			}
		}
			$month = "03";
			$day = "01";

		$date = date_create($year."-".$month."-".$day);
		$date->add(new DateInterval('P'.$this->findThursday($date).'D'));

		return $date;
	}

	/**
	* Method called when the date received is shorter than 7 days from 01/03 - we check if it is Thursday at that time
	*/
	private function isBetweenThursday($year, $month, $day) {
		$dateFrom = date_create($year."-".self::STARTMONTH."-".self::STARTDAY);
		$dateTo = date_create($year."-".$month."-".$day);
		$interval = date_diff($dateTo, $dateFrom);

		if($dateTo->format('N') <= $day) {
			return false;
		} else {
			return true;
		}
	}
}