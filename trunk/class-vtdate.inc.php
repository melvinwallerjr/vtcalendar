<?php
require_once("languages/en.inc.php");
require_once("functions.inc.php");

echo "<pre>\n";

$dowstart = 0;

//echo date("c", strtotime("2 month -2 day", mktime(0, 0, 0, 1, 1, 2008)));

//echo vtDateRepeater::_determineDaysForDOWIncrement(0, 1, -2);

// Determine the first and last day of the month
$firstDay = new vtDate(2008, 1, 1);
$lastDay = new vtDate($firstDay->getYear(), $firstDay->getMonth(), $firstDay->getDaysInMonth());

// Determine the first day displayed on the calendar.
// This may be part of the last or current month.
$firstDisplayDay =& $firstDay->getWeekStartDate($dowstart);

// Determine the last day displayed on the calendar.
// This may be part of the current or next month.
$lastDisplayDay =& $lastDay->getWeekEndDate($dowstart);

$displayDays = $lastDisplayDay->getDayDiff($firstDisplayDay);

//echo $firstDisplayDay->getDateStamp() . "\n";
//echo $lastDisplayDay->getDateStamp() . "\n";
//echo $displayDays . "\n";

echo "</pre>";


echo "<table border='1' cellpadding='2' cellspacing='0'>\n";

echo '<tr><td align="center" colspan="7">' . $firstDay->format("%F") . '</td></tr>';

// Week Day Names
echo "<tr>\n";
for ($i = 0; $i < 7; $i++) {
	echo "<td align='center'>" . vtDate::format("%D", strtotime("+".$i." days", $firstDisplayDay->getEpoch())) . "</td>\n";
}
echo "</tr>\n";

$currentDay =& $firstDisplayDay->copy();
for ($i = 0; $i <= $displayDays; $i++) {
	if ($i % 7 == 0) {
		echo "<tr>";
	}
	
	if ($currentDay->getMonth() != $firstDay->getMonth()) {
		echo "<td bgcolor='#DDDDDD'>";
	}
	else {
		echo "<td>";
	}
	
	echo $currentDay->format("%j") . "</td>";
	if ($i != 0 && ($i + 1) % 7 == 0) {
		echo "</tr>\n";
	}
	
	$currentDay->add("1 day");
}

echo "</table>\n";

// Stores information about a date and provides several functions used by the VTCalendar.
class vtDate {
	var $_epoch;
	var $_year;
	var $_month;
	var $_day;
	var $_hour;
	var $_minute;
	var $_second;
	var $_dow;
	var $_daysInMonth;
	
	// Create a new instance of vtDate
	function vtDate($year_date_or_string, $month = null, $day = null, $hour = "0", $minute = "0", $second = "0", $isPM = false) {
		
		if ($month === null) {
			if (is_string($year_date_or_string)) {
				if (($this->_epoch = strtotime($year_date_or_string)) === false) {
					trigger_error('vtDate() year_date_or_string could not be parsed using strtotime.', E_USER_WARNING);
				}
			}
			else {
				$this->_epoch = intval($year_date_or_string);
			}
		}
		elseif ($day === null) {
			trigger_error("vtDate() invalid call to constructor. 'month' was set but not 'day'.", E_USER_ERROR);
		}
		elseif (preg_match("/^[0-9]+$/", $year_date_or_string . $month . $day . $hour . $minute . $second)) {
			$this->_epoch = mktime(intval($hour) + ($isPM ? 12 : 0), intval($minute), intval($second), intval($month), intval($day), intval($year_date_or_string));
		}
		else {
			trigger_error("vtDate() year_date_or_string is not a supported data type.", E_USER_ERROR);
		}
		
		$this->_processEpoch();
	}
	
	// Get the parts of the date.
	function _processEpoch() {
		$parts = explode("\n", date("Y\nm\nd\nH\ni\ns\nw\nt", $this->_epoch));
		$this->_year = intval($parts[0]);
		$this->_month = intval($parts[1]);
		$this->_day = intval($parts[2]);
		$this->_hour = intval($parts[3]);
		$this->_minute = intval($parts[4]);
		$this->_second = intval($parts[5]);
		$this->_dow = intval($parts[6]);
		$this->_daysInMonth = intval($parts[7]);
	}
	
	function getDateStamp() {
		return $this->_year . "-" . sprintf("%02s", $this->_month) . "-" . sprintf("%02s", $this->_day);
	}
	
	function getTimeStamp() {
		return sprintf("%02s", $this->_hour) . ":" . sprintf("%02s", $this->_minute) . ":" . sprintf("%02s", $this->_second);
	}
	
	function getDateTimeStamp() {
		return $this->getDateStamp() . " " . $this->getTimeStamp();
	}
	
	function getEpoch() {
		return $this->_epoch;
	}
	
	function getYear() {
		return $this->_year;
	}
	
	function getMonth() {
		return $this->_month;
	}
	
	function getDay() {
		return $this->_day;
	}
	
	function getHour() {
		return $this->_hour;
	}
	
	function getMinute() {
		return $this->_minute;
	}
	
	function getSecond() {
		return $this->_second;
	}
	
	function isPM() {
		return $this->_hour > 12;
	}
	
	function getDOW() {
		return $this->_dow;
	}
	
	function getDaysInMonth() {
		return $this->_daysInMonth;
	}
	
	function setDate($year, $month, $day) {
		if (!checkdate($month, $day, $year)) {
			return false;
		}
		$this->_epoch = mktime($this->_hour, $this->_minute, $this->_second, $month, $day, $year);
		$this->_processEpoch();
		return true;
	}
	
	function setYear($year) {
		return $this->setDate($year, $this->_month, $this->_day);
	}
	
	function setMonth($month) {
		return $this->setDate($this->_year, $month, $this->_day);
	}
	
	function setDay($day) {
		return $this->setDate($this->_year, $this->_month, $day);
	}
	
	// $change can be '+1 day', '-1 week', 'next thursday', etc. see strtotime()
	function add($change) {
		$this->_epoch = strtotime($change, $this->_epoch);
		$this->_processEpoch();
	}
	
	function &getWeekStartDate($firstDOW = 0) {
		if ($firstDOW < 0) {
			trigger_error('getWeekStartDate() firstDOW cannot be less than 0. Defaulting to 0', E_USER_WARNING);
			$firstDOW = 0;
		}
		if ($firstDOW > 6) {
			trigger_error('getWeekStartDate() firstDOW cannot be greater than 6. Defaulting to 6.', E_USER_WARNING);
			$firstDOW = 6;
		}
		
		$firstDay =& $this->copy();
		
		if ($firstDOW > $this->_dow) {
			$firstDay->add(($firstDOW - $this->_dow - 7) . " day");
		}
		elseif ($firstDOW < $this->_dow) {
			$firstDay->add("-" . ($this->_dow - $firstDOW) . " day");
		}
		
		return $firstDay;
	}
	
	function &getWeekEndDate($firstDOW = 0) {
		$lastDay =& $this->copy();
		
		if ($firstDOW > $this->_dow) {
			$lastDay->add((($firstDOW - $this->_dow - 7) + 6) . " day");
		}
		elseif ($firstDOW < $this->_dow) {
			$lastDay->add(((($this->_dow - $firstDOW) * -1) + 6) . " day");
		}
		
		return $lastDay;
	}
	
	function getDayDiff(&$otherDate) {
		$thisJD = GregorianToJD($this->_month, $this->_day, $this->_year);
		$otherJD = GregorianToJD($otherDate->_month, $otherDate->_day, $otherDate->_year);
		return $thisJD - $otherJD;
	}
	
	function format($format, $epoch = null) {
		if (trim($format) == "") return $format;
		$validCodes = "%dDjlNwzWFmMntLoYyaABgGhHisueIOPTZcU";
		$finalString = "";
		
		if ($epoch === null) $epoch = $this->_epoch;
		
		$lastEnd = 0;
		$offset = 0;
		while ($offset <= strlen($format) && ($index = strpos($format, "%", $offset)) !== false) {
			
			// Append characters that were skipped.
			$finalString .= substr($format, $lastEnd, $index - $lastEnd);
			
			// Get the date code
			$code = substr($format, $index + 1, 1);
			
			// If the code is empty or invalid, just output the %X pair literally.
			if ($code == "" || strpos($validCodes, $code) === false) {
				$finalString .= "%" . $code;
			}
			else {
				switch($code) {
					case '%': $finalString .= "%"; break;
					case 'F': $finalString .= lang(strtolower(date("F", $epoch))); break;
					case 'M': $finalString .= lang(strtolower(date("M", $epoch))); break;
					case 'D': $finalString .= lang(strtolower(date("D", $epoch))); break;
					case 'l': $finalString .= lang(strtolower(date("l", $epoch))); break;
					case 'A': $finalString .= lang(strtolower(date("A", $epoch))); break;
					case 'a': $finalString .= lang(strtolower(date("a", $epoch))); break;
					default:  $finalString .= date($code, $epoch);
				}
			}
			
			$offset = $index + 2;
			$lastEnd = $offset;
		}
		
		$finalString .= substr($format, $lastEnd, strlen($format));
		
		return $finalString;
	}
	
	function &copy() {
		$copy = new vtDate($this->_epoch);
		return $copy;
	}
}
?>