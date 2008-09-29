<?php
require_once("languages/en.inc.php");
require_once("functions.inc.php");
require_once("class-vtdate.inc.php");

?><pre><?php

$repeater = new vtDateRepeater("E 20090101 20090201 0 S 1"); //;I 20080101 20090101 E D;I 20070101 20090101 1 S 12");
$date = new vtDate(2008, 1, 1);
$repeater->_moveToNextDate(0, $date);
echo "New Date: " . $date->format("%c");

?></pre><?php

class vtDateRepeater {
	var $_repeatList;
	
	function vtDateRepeater($repeatMixed = array()) {
		$this->_repeatList = array();
		
		if (!is_array($repeatMixed)) {
			$repeatMixed = explode(";", $repeatMixed);
		}
		
		// Process all the repeat strings
		for ($i = 0; $i < count($repeatMixed); $i++) {
			
			// Insert valid repeat strings into the list.
			if (($newRepeat =& $this->_parseRepeat($repeatMixed[$i])) !== false) {
				$this->_repeatList[] =& $newRepeat;
			}
		}
		
		echo "<pre>";
		var_dump($this->_repeatList);
		echo "</pre>";
	}
	
	function &_parseRepeat($repeatString) {
		$split = explode(" ", $repeatString);
		$repeat = array();
		
		// Fail if the string does not have at least two parts.
		if (count($split) < 2) {
			$repeat = false;
			return $repeat;
		}
		
		// Assign the first two parts to the repeat array.
		$repeat['filter'] = $split[0];
		$repeat['start'] = $split[1];
		
		// Fail if the first item in the repeat is not an I or an E (include or exclude).
		if (count($split) < 1 || !preg_match("/^[IE]$/", $repeat['filter'])) {
			$repeat = false;
			return $repeat;
		}
		
		// Fail if the start date is invalid.
		if (count($split) < 2 || !preg_match("/^[0-9]{8}$/", $repeat['start']) ||
			!checkdate(substr($repeat['start'], 4, 2), substr($repeat['start'], 6, 2), substr($repeat['start'], 0, 4))) {
			$repeat = false;
			return $repeat;
		}
		else {
			$repeat['startDate'] = new vtDate(substr($repeat['start'], 0, 4), substr($repeat['start'], 4, 2), substr($repeat['start'], 6, 2));
		}
		
		// If the date is the last part of the repeat string,
		// then it specifices a single day and not a repeat.
		if (count($split) == 2) {
			$repeat = false;
			return $repeat;
		}
		
		// Fail if the string does not have at least five parts.
		if (count($split) < 5) {
			$repeat = false;
			return $repeat;
		}
		
		// Assign the next two parts to the repeat array.
		$repeat['end'] = $split[2];
		$repeat['mode'] = $split[3];
		$repeat['interval'] = $split[4];
		
		// Validate the ending date for the repeat.
		if (count($split) < 3 || !preg_match("/^[0-9]{8}$/", $repeat['end']) ||
			!checkdate(substr($repeat['end'], 4, 2), substr($repeat['end'], 6, 2), substr($repeat['end'], 0, 4))) {
			$repeat = false;
			return $repeat;
		}
		else {
			$repeat['endDate'] = new vtDate(substr($repeat['end'], 0, 4), substr($repeat['end'], 4, 2), substr($repeat['end'], 6, 2));
		}
		
		// If the fourth item is a number, then the repeat must have
		// at least 6 items and the last item must be a number from 1-12.
		// The fifth item only allows 'weekdays' and the individual weekdays themselves.
		if (preg_match("/^[12340]$/", $repeat['mode'])) {
			
			// Fail if the string does not have at least 6 parts.
			if (count($split) < 6) {
				$repeat = false;
				return $repeat;
			}
			
			$repeat['months'] = $split[5];
			if (count($split) < 6 || !preg_match("/^([1-9]|(10|11|12))$/", $repeat['months']) || !preg_match("/^[KSOTEHFA]$/", $repeat['interval'])) {
				$repeat = false;
				return $repeat;
			}
		}
		
		// If the fourth item is a character, then make sure the fifth item has a valid value.
		elseif (preg_match("/^[EOTF]$/", $repeat['mode'])) {
			if (!preg_match("/^[DWMYKSOTEHFA]$/", $repeat['interval'])) {
				$repeat = false;
				return $repeat;
			}
		}
		
		// Fail if the fourth item is invalid.
		else {
			$repeat = false;
			return $repeat;
		}
		
		return $repeat;
	}
	
	function _moveToNextDate($repeatIndex, &$dateMarker) {
		$listItem =& $this->_repeatList[$repeatIndex];
		
		// Loopups to convert codes to integers.
		$multipliers = array('E'=>1, 'O'=>2, 'T'=>3, 'F'=>4);
		$intervalsDOW = array('S'=>0, 'O'=>1, 'T'=>2, 'E'=>3, 'H'=>4, 'F'=>5, 'A'=>6);
		
		// TODO: Remove these
		/*$multiplierNames = array('E'=>'Every', 'O'=>'Every other', 'T'=>'Every third', 'F'=>'Every fourth');
		$intervals = array(
			'D'=>'day', 'W'=>'week', 'M'=>'month', 'Y'=>'year', 'K'=>'weekday',
			'S'=>'sunday', 'O'=>'monday', 'T'=>'tuesday', 'E'=>'wednesday', 'H'=>'thursday', 'F'=>'friday', 'A'=>'saturday');*/
		
		// If the fourth field is numeric then the repeat is either
		// an ordinal (i.e. 'first') or the 'last' X of the month.
		if (is_numeric($listItem['mode'])) {
			if ($listItem['mode'] == 0) {
				$dateMarker->setDay(1);
				$dateMarker->add(($listItem['months']+1) . " month");
				
				if ($listItem['interval'] == "K") {
					$days = $this->_determineDaysForWeekdayIncrement($dateMarker->getDOW(), -1) * -1;
				}
				else {
					$intervalDOW = $intervalsDOW[$listItem['interval']];
					$days = $this->_determineDaysForDOWIncrement($dateMarker->getDOW(), $intervalDOW, -1) * -1;
				}
				
				$dateMarker->add($days . " day");
			}
			else {
				$dateMarker->setDay(1);
				$dateMarker->add($listItem['months'] . " month");
				
				if ($listItem['interval'] == "K") {
					$days = $this->_determineDaysForWeekdayIncrement($dateMarker->getDOW(), 1);
				}
				else {
					$intervalDOW = $intervalsDOW[$listItem['interval']];
					$days = $this->_determineDaysForDOWIncrement($dateMarker->getDOW(), $intervalDOW, 1);
				}
				
				$dateMarker->add($days . " day");
			}
		}
		
		// Otherwise, the repeat is a normal repeat (e.g. every 2 days).
		else {
			switch ($listItem['interval']) {
				// Increment by X number of days
				case 'D':
					$dateMarker->add($multipliers[$listItem['mode']] . " day");
					break;
				
				// Increment by X number of weeks
				case 'W':
					$dateMarker->add((7 * $multipliers[$listItem['mode']]) . " day");
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
					$dateMarker->add($days = $this->_determineDaysForWeekdayIncrement($dateMarker->getDOW(), $multipliers[$listItem['mode']]) . " day");
					break;
				
				// Increment X number of a specific day of the week.
				default:
					$dateMarker->add($this->_determineDaysForDOWIncrement($dateMarker->getDOW(), $intervalsDOW[$listItem['interval']], $multipliers[$listItem['mode']]) . " day");
			}
		}
		
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
}
?>