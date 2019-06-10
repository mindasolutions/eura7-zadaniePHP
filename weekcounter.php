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
	* The method which is to find the first Thursday in March from 01.03
	*/
	private function findStartDate($year, $month, $day) {
		if($month < self::STARTMONTH) {
			$year--;
		}
		if($month == self::STARTMONTH && $day < 7) {
			if(!$this->isThursdayBetween($year, $month, $day)) {
				$year--;
			}
		}
		return date_create(date('Y-m-d', strtotime('first Thursday of March '.$year)));
	}

	/**
	* Method called when the date received is shorter than 7 days from 01/03 - we check if it is Thursday at that time
	*/
	private function isThursdayBetween($year, $month, $day) {
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