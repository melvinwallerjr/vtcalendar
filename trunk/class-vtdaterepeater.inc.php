<?php
require_once("languages/en.inc.php");
require_once("functions.inc.php");
require_once("class-vtdate.inc.php");

$repeater = new vtDateRepeater("E 20080101 20080101;I 20080101 20090101 E D;I 20070101 20090101 1 X 12");
$date = new vtDate(2008, 1, 1);
$repeater->_getNextDate(0, $date);

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
				$repeatMixed[$i][1] = new vtDate(substr($repeatMixed[$i][1], 0, 4), substr($repeatMixed[$i][1], 4, 2), substr($repeatMixed[$i][1], 6, 2));
				$repeatMixed[$i][2] = new vtDate(substr($repeatMixed[$i][2], 0, 4), substr($repeatMixed[$i][2], 4, 2), substr($repeatMixed[$i][2], 6, 2));
				
				// Add the repeat to the list
				$this->_repeatList[count($this->_repeatList)] = $repeatMixed[$i];
			}
		}
		
		echo "<pre>";
		var_dump($this->_repeatList);
		echo "</pre>";
	}
	
	function _getNextDate($repeatIndex, &$startingVTDate) {
		echo $this->_repeatList[$repeatIndex][1]->format("%c<br>");
		echo $this->_repeatList[$repeatIndex][1]->getDayDiff($startingVTDate);
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
		
		// If the fourth item is a number, then the repeat must have at least 6 items and the last item must be a number from 1-12.
		if (preg_match("/^[123450]$/", $repeat[3])) {
			if (count($repeat) < 6 || !preg_match("/^([1-9]|(10|11|12))$/", $repeat[5])) {
				return false;
			}
		}
		elseif (!preg_match("/^[EOTF]$/", $repeat[3])) {
			return false;
		}
		
		// Fail if the fifth item is invalid.
		if (!preg_match("/^[DWMYKSOTEHFAXV]$/", $repeat[4])) {
			return false;
		}
		
		// Return true since no errors were found.
		return true;
	}
}
?>