<?php
require_once("languages/en.inc.php");
require_once("functions.inc.php");
require_once("class-vtdate.inc.php");

$repeater = new vtDateRepeater("E 20090101 20090201 E W"); //;I 20080101 20090101 E D;I 20070101 20090101 1 S 12");
$date = new vtDate(2008, 1, 1);
$repeater->_moveToNextDate(0, $date);

class vtDateRepeater {
	var $_repeatList;
	
	function vtDateRepeater($repeatMixed = array()) {
		$this->_repeatList = array();
		
		if (!is_array($repeatMixed)) {
			$repeatMixed = explode(";", $repeatMixed);
		}
		
		// Process all the repeat strings
		for ($i = 0; $i < count($repeatMixed); $i++) {
		
			if (!is_array($repeatMixed[$i])) {
				$repeatMixed[$i] = explode(" ", $repeatMixed[$i]);
			}
			
			// Validate all the repeats
			if ($this->_isValidRepeat($repeatMixed[$i])) {
				
				// Assign the dates as vtDates for easier processing
				//$repeatMixed[$i][1] = new vtDate(substr($repeatMixed[$i][1], 0, 4), substr($repeatMixed[$i][1], 4, 2), substr($repeatMixed[$i][1], 6, 2));
				//$repeatMixed[$i][2] = new vtDate(substr($repeatMixed[$i][2], 0, 4), substr($repeatMixed[$i][2], 4, 2), substr($repeatMixed[$i][2], 6, 2));
				
				// Add the repeat to the list
				$this->_repeatList[count($this->_repeatList)] = $repeatMixed[$i];
			}
		}
		
		echo "<pre>";
		var_dump($this->_repeatList);
		echo "</pre>";
	}
	
	function _moveToNextDate($repeatIndex, &$dateMarker) {
		$listItem =& $this->_repeatList[$repeatIndex];
		
		$multipliers = array('E'=>1, 'O'=>2, 'T'=>3, 'F'=>4);
		$intervalsDOW = array('S'=>0, 'O'=>1, 'T'=>2, 'E'=>3, 'H'=>4, 'F'=>5, 'A'=>6);
		
		// TODO: Remove these
		$multiplierNames = array('E'=>'Every', 'O'=>'Every other', 'T'=>'Every third', 'F'=>'Every fourth');
		$intervals = array(
			'D'=>'day', 'W'=>'week', 'M'=>'month', 'Y'=>'year', 'K'=>'weekday',
			'S'=>'sunday', 'O'=>'monday', 'T'=>'tuesday', 'E'=>'wednesday', 'H'=>'thursday', 'F'=>'friday', 'A'=>'saturday');
		
		if (is_numeric($listItem[3])) {
			if ($listItem[3] == 0) {
				$dateMarker->setDay(1);
				$dateMarker->add(($listItem[5]+1) . " month");
				
				if ($listItem[4] == "K") {
					$days = $this->_determineDaysForWeekdayIncrement($dateMarker->getDOW(), -1) * -1;
				}
				else {
					$intervalDOW = $intervalsDOW[$listItem[4]];
					$days = $this->_determineDaysForDOWIncrement($dateMarker->getDOW(), $intervalDOW, -1) * -1;
				}
				
				$dateMarker->add($days . " day");
			}
			else {
				$dateMarker->setDay(1);
				$dateMarker->add($listItem[5] . " month");
				
				if ($listItem[4] == "K") {
					$days = $this->_determineDaysForWeekdayIncrement($dateMarker->getDOW(), 1);
				}
				else {
					$intervalDOW = $intervalsDOW[$listItem[4]];
					$days = $this->_determineDaysForDOWIncrement($dateMarker->getDOW(), $intervalDOW, 1);
				}
				
				$dateMarker->add($days . " day");
			}
		}
		else {
			switch ($listItem[4]) {
				// Increment by X number of days
				case 'D':
					$dateMarker->add($multipliers[$listItem[3]] . " day");
					break;
				
				// Increment by X number of weeks
				case 'W':
					$dateMarker->add((7 * $multipliers[$listItem[3]]) . " day");
					break;
					
				// Increment X number of months.
				// Return false if we could not find a match before passing the end date.
				case 'M':
					// TODO: Check each month till a matching day is found
					// If we pass the end date then return false.
					break;
				
				// Increment X number of years.
				// Return false if we could not find a match before passing the end date.
				case 'Y':
					// TODO: Check each year till a matching day is found
					// If we pass the end date then return false.
					break;
				
				// Increment X number of weekdays.
				case 'K':
					$dateMarker->add($days = $this->_determineDaysForWeekdayIncrement($dateMarker->getDOW(), $multipliers[$listItem[3]]) . " day");
					break;
				
				// Increment X number of a specific day of the week.
				default:
					$dateMarker->add($this->_determineDaysForDOWIncrement($dateMarker->getDOW(), $intervalsDOW[$listItem[4]], $multipliers[$listItem[3]]) . " day");
			}
		}
		
		echo "New Date: " . $dateMarker->format("%c");
		
		return true;
	}
	
	function _determineDaysForWeekdayIncrement($startDOW, $increment) {
		if ($increment == 0) trigger_error('vtDateRepeater->_determineDaysForWeekdayIncrement() $increment cannot be zero.', E_USER_ERROR);
		if ($startDOW < 0 || $startDOW > 6) trigger_error('vtDateRepeater->_determineDaysForWeekdayIncrement() $startDOW out of range.', E_USER_ERROR);
		
		$days = 0;
		$weekdays = 0;
		while ($weekdays < abs($increment)) {
			if ($increment < 0) {
				if ($startDOW == 0) $startDOW = 6;
				else $startDOW--;
			}
			else {
				if ($startDOW == 6) $startDOW = 0;
				else $startDOW++;
			}
			
			if ($startDOW > 0 && $startDOW < 6)
				$weekdays++;
			
			$days++;
		}
		return $days;
	}
	
	function _determineDaysForDOWIncrement($startDOW, $dow, $increment) {
		if ($increment == 0) trigger_error('vtDateRepeater->_determineDaysForWeekdayIncrement() $increment cannot be zero.', E_USER_ERROR);
		if ($startDOW < 0 || $startDOW > 6) trigger_error('vtDateRepeater->_determineDaysForWeekdayIncrement() $startDOW out of range.', E_USER_ERROR);
		if ($dow < 0 || $dow > 6) trigger_error('vtDateRepeater->_determineDaysForWeekdayIncrement() $dow out of range.', E_USER_ERROR);
		
		$days = 0;
		while ($startDOW != $dow) {
			if ($increment < 0) {
				if ($startDOW == 0) $startDOW = 6;
				else $startDOW--;
			}
			else {
				if ($startDOW == 6) $startDOW = 0;
				else $startDOW++;
			}
			
			$days++;
		}
		
		return $days + ((abs($increment) - 1) * 7);
	}
	
	function _isValidRepeat(&$repeat) {
		// Repeats must have at least three items.
		if (count($repeat) < 3) {
			return false;
		}
		
		// Make sure that:
		// 1. The first item in the repeat is an I or an E (include or exclude).
		// 2. The first and second item are 8 digits.
		if (!preg_match("/^[IE]$/", $repeat[0]) || !preg_match("/^[0-9]{8}$/", $repeat[1]) || !preg_match("/^[0-9]{8}$/", $repeat[2])) {
			return false;
		}
		
		// Fail if either of the two dates are not valid Gregorian dates.
		if (!checkdate(substr($repeat[1], 4, 2), substr($repeat[1], 6, 2), substr($repeat[1], 0, 4)) ||
			!checkdate(substr($repeat[2], 4, 2), substr($repeat[2], 6, 2), substr($repeat[2], 0, 4))) {
			return false;
		}
		
		// Fail if the end date is before the start date.
		if ($repeat[1] > $repeat[2]) {
			return false;
		}
		
		// The rest of the repeat does not matter if the dates match.
		// This means a single day is included/excluded.
		if ($repeat[1] == $repeat[2]) {
			return true;
		}
		
		// Repeats that do not have matching dates need at least 5 items.
		if (count($repeat) < 5) {
			return false;
		}
		
		// If the fourth item is a number, then the repeat must have
		// at least 6 items and the last item must be a number from 1-12.
		// The fifth item only allows 'weekdays' and the individual weekdays themselves.
		if (preg_match("/^[12340]$/", $repeat[3])) {
			if (count($repeat) < 6 || !preg_match("/^([1-9]|(10|11|12))$/", $repeat[5]) || !preg_match("/^[KSOTEHFA]$/", $repeat[4])) {
				return false;
			}
		}
		
		// If the fourth item is a character, then make sure the fifth item has a valid value.
		elseif (preg_match("/^[EOTF]$/", $repeat[3])) {
			if (!preg_match("/^[DWMYKSOTEHFA]$/", $repeat[4])) {
				return false;
			}
		}
		
		// Fail if the fourth item is invalid.
		else {
			return false;
		}
		
		// Return true since no errors were found.
		return true;
	}
}
?>