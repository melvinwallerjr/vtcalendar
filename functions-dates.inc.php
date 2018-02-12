<?php
function yearmonthday2timestamp($year, $month, $day)
{ // converts a year/month/day-pair to a timestamp in the format "1999-09-17"
	return $year . '-' . (($month < 10)? '0' : '') . (int)$month . '-' . (($day < 10)? '0' : '') . (int)$day;
}

function datetime2timestamp($year, $month, $day, $hour, $min, $ampm)
{ // converts a date/time to a timestamp in the format "1999-09-16 18:57:00"
	if (USE_AMPM) { // if am/pm format is used
		if ($ampm == 'pm' && $hour < 12) { $hour += 12; } /* 12pm is noon */
		elseif ($ampm == 'am' && $hour == 12) { $hour = 0; } /* 12am is midnight */
	}
	return $year . '-' . (($month < 10)? '0' : '') . (int)$month . '-' . (($day < 10)? '0' : '') .
	 (int)$day . ' ' . (($hour < 10)? '0' : '') . $hour . ':' . (($min < 10)? '0' : '') . $min . ':00';
}

function timestamp2datetime($timestamp)
{ // converts a timestamp "1999-09-16 18:57:00" to a date/time format
	/* split the date/time field-info into its parts */
	/* format returned by postgres is "1999-09-10 07:30:00" */
	$datetime['year'] = substr($timestamp, 0, 4);
	$datetime['month'] = substr($timestamp, 5, 2);
	if (substr($datetime['month'], 0, 1) == '0') { /* remove leading "0" */
		$datetime['month'] = substr($datetime['month'], 1, 1);
	}
	$datetime['day'] = substr($timestamp, 8, 2);
	if (substr($datetime['day'], 0, 1) == '0') { /* remove leading "0" */
		$datetime['day'] = substr($datetime['day'], 1, 1);
	}
	$datetime['hour'] = substr($timestamp, 11, 2);
	/* convert 24 hour into 1-12am/pm  if am, pm in data format is used */
	if (USE_AMPM) {
		if ($datetime['hour'] < 12) {
			$datetime['ampm'] = 'am';
			if ($datetime['hour'] == 0) { $datetime['hour'] = 12; }
		}
		else {
			$datetime['ampm'] = 'pm';
			if ($datetime['hour'] > 12) { $datetime['hour'] -= 12; }
		}
	}
	if (substr($datetime['hour'], 0, 1) == '0') { /* remove leading "0" */
		$datetime['hour'] = substr($datetime['hour'], 1, 1);
	}
	$datetime['min'] = substr($timestamp, 14, 2);
	return $datetime;
}

/**
 * Converts the time from a timestamp "1999-09-16 18:57:00" to a number
 * representing the number of seconds that have passed in that day.
 */
function timestamp2timenumber($timestamp)
{
	$hour = substr($timestamp, 11, 2);
	$minute = substr($timestamp, 14, 2);
	return ($hour * 60) + $minute;
}

function timenumber2timelabel($timenum)
{ // converts the number of minutes from 00:00:00 to a label for output.
	if ($timenum > 59) {
		$hours = floor($timenum / 60);
		$timenum -= $hours * 60;
	}
	if ($timenum == 59) { // whole hour adjustment, related to end of day
		$hours++;
		$timenum = 0;
	}
	if ($timenum > 0) { $minutes = $timenum; }
	if (isset($hours) && isset($minutes)) {
		return $hours . 'hr ' . $minutes . 'm';
	}
	elseif (isset($hours) && !isset($minutes)) {
		return $hours . ' hour' . (($hours > 1)? 's' : '');
	}
	elseif (!isset($hours) && isset($minutes)) {
		return $minutes . ' min';
	}
	else { return ''; }
}

/**
 * Returns a ISO 8601 date based on the passed year/month/day/hour/min/ampm.
 * This is primarily used by the vCalendar format.
 */
function datetime2ISO8601datetime($year, $month, $day, $hour, $min, $ampm)
{
	$datetime = strtr(datetime2timestamp($year, $month, $day, $hour, $min, $ampm), ' ', 'T');
	$datetime = str_replace('-', '', $datetime);
	$datetime = str_replace(':', '', $datetime);
	return $datetime;
}

/**
 * Returns the year/month/day/hour/min/ampm for a ISO 8601 date
 * This is primarily used by the vCalendar format.
 */
function ISO8601datetime2datetime($ISO8601datetime)
{
	$datetime['year'] = substr($ISO8601datetime, 0, 4);
	$datetime['month'] = substr($ISO8601datetime, 4, 2);
	if (substr($datetime['month'], 0, 1) == '0') { // remove leading "0"
		$datetime['month'] = substr($datetime['month'], 1, 1);
	}
	$datetime['day'] = substr($ISO8601datetime, 6, 2);
	if (substr($datetime['day'], 0, 1) == '0') { // remove leading "0"
		$datetime['day'] = substr($datetime['day'], 1, 1);
	}
	$datetime['hour']  = substr($ISO8601datetime, 9, 2);
	// convert 24 hour into 1-12am/pm
	if ($datetime['hour'] < 12) {
		$datetime['ampm'] = 'am';
		if ($datetime['hour'] == 0) { $datetime['hour'] = 12; }
	}
	else {
		$datetime['ampm'] = 'pm';
		if ($datetime['hour'] > 12) { $datetime['hour'] -= 12; }
	}
	if (substr($datetime['hour'], 0, 1) == '0') { // remove leading "0"
		$datetime['hour'] = substr($datetime['hour'], 1, 1);
	}
	$datetime['min'] = substr($ISO8601datetime, 11, 2);
	return $datetime;
}

function disassemble_timestamp(&$event)
{ // Assign the year/month/day/hour/min/ampm based on the events begin/end timestamps.
	$timebegin = timestamp2datetime($event['timebegin']);
	$event['timebegin_year'] = $timebegin['year'];
	$event['timebegin_month'] = $timebegin['month'];
	$event['timebegin_day'] = $timebegin['day'];
	$event['timebegin_hour'] = $timebegin['hour'];
	$event['timebegin_min'] = $timebegin['min'];
	$event['timebegin_ampm'] = $timebegin['ampm'];
	$timeend = timestamp2datetime($event['timeend']);
	$event['timeend_year'] = $timeend['year'];
	$event['timeend_month'] = $timeend['month'];
	$event['timeend_day'] = $timeend['day'];
	$event['timeend_hour'] = $timeend['hour'];
	$event['timeend_min'] = $timeend['min'];
	$event['timeend_ampm'] = $timeend['ampm'];
	return 0;
}

function settimeenddate2timebegindate(&$event)
{ // for non-recurring events the ending time equals the starting time
	$event['timeend_year'] = $event['timebegin_year'];
	$event['timeend_month'] = $event['timebegin_month'];
	$event['timeend_day'] = $event['timebegin_day'];
}

function assemble_timestamp(&$event)
{ // Assign timestamps (YYYY-MM-DD HH-MM-SS AMPM) for the events begin/end times
	// Assign the begin timestamp.
	$event['timebegin'] = datetime2timestamp($event['timebegin_year'], $event['timebegin_month'],
	 $event['timebegin_day'], $event['timebegin_hour'], $event['timebegin_min'], $event['timebegin_ampm']);
	// If event doesn't have an ending time, set it to the end of the day.
	if (!isset($event['timeend_hour']) || $event['timeend_hour'] == 0) {
		$event['timeend_hour'] = DAY_END_H;
		$event['timeend_min'] = 59;
		if (USE_AMPM) { $event['timeend_ampm'] = 'pm'; }
	}
	// Assign the end timestamp.
	$event['timeend'] = datetime2timestamp($event['timeend_year'], $event['timeend_month'],
	 $event['timeend_day'], $event['timeend_hour'], $event['timeend_min'], $event['timeend_ampm']);
}

function timestring($hour, $min, $ampm)
{ // returns a string like "5:00pm" from the input "5", "0", "pm"
	return (int)$hour . ':' . (($min < 10)? '0' : '') . (int)$min . $ampm;
}

function endingtime_specified(&$event)
{ // returns true if the ending time is not 11:59pm (meaning: not specified)
	return !(isset($event['timeend_hour']) && isset($event['timeend_min']) &&
	 isset($event['timeend_ampm']) && $event['timeend_hour'] == 11 &&
	 $event['timeend_min'] == 59 && $event['timeend_ampm'] == 'pm');
}
?>