<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

function xmlEscape($string)
{ // Escape a string to be outputted in an XML document
	return str_replace(
		array('"',      '>',    '<',    '\'',     '&'),
		array('&quot;', '&gt;', '&lt;', '&apos;', '&amp;'),
		$string
	);
}

function xmlSchemaDate($tick)
{ // Create a date/time formatted for XML
	return date('Y-m-d', $tick) . 'T' . date('H:i:s', $tick) .
	 substr(date('O', $tick), 0, 3) . ':' . substr(date('O', $tick), 3, 2);
}

function outputErrorMessage($mesg)
{ // Output an error message and set headers so that it is not cached.
	header('HTTP/1.1 500 Internal Server Error');
	header('Expires: ' . gmdate('D, d M Y H:i:s', mktime(0, 0, 0, 1, 1, 1975)) . ' GMT');
	header('Cache-Control: no-store');
	header('Content-type: text/plain');
	echo "<!-- /* ERR\n\nError Message(s):\n\n" . $mesg . "\n\n*/ -->";
	exit;
}

function dbtime2tick($dbtime)
{
	$year = substr($dbtime, 0, 4);
	$month = substr($dbtime, 5, 2);
	$day = substr($dbtime, 8, 2);
	$hour = substr($dbtime, 11, 2);
	$min = substr($dbtime, 14, 2);
	$sec = substr($dbtime, 17, 2);
	return mktime($hour, $min, $sec, $month, $day, $year);
}

function FormatDate($format, $tick)
{
	if ($format == 'huge') { // Huge - Wednesday, October 25, 2006
		return date('l, F j, Y', $tick);
	}
	elseif ($format == 'long') { // Long - Wed, October 25, 2006
		return date('D, F j, Y', $tick);
	}
	elseif ($format == 'normal') { // Normal - October 25, 2006
		return date('F j, Y', $tick);
	}
	elseif ($format == 'short') { // Short - Oct. 25, 2006
		return date('M. j, Y', $tick);
	}
	elseif ($format == 'tiny') { // Tiny - Oct 25 '06
		return date('M j, \'y', $tick);
	}
	elseif ($format == 'micro') { // Micro - Oct 25 or "Today"
		//if (date('F j, Y', NOW) == date('F j, Y', $tick)) { return 'Today'; }
		//else { return date('M j', $tick); }
		return date('M j', $tick);
	}
}

function FormatTimeDisplay(&$event, &$FormData)
{ // Time Display: Default to "Start" if no end time, Ignored if "all day" event.
	$starttick = dbtime2tick($event['timebegin']);
	$endtick = dbtime2tick($event['timeend']);
	if ($event['wholedayevent'] != 0) { return 'All Day'; }
	elseif ($FormData['timedisplay'] == 'start' || substr($event['timeend'], 11, 5) == '23:59') {
		// Start = 12:00pm
		return FormatTime($FormData['timeformat'], $starttick);
	}
	elseif ($FormData['timedisplay'] == 'startendlong') {
	// StartEndLong = 12:00pm to 12:30pm
	return FormatTime($FormData['timeformat'], $starttick) .
	 ' to ' . FormatTime($FormData['timeformat'], $endtick);
	}
	elseif ($FormData['timedisplay'] == 'startendnormal') {
		// StartEndNormal = 12:00pm - 12:30pm
		return FormatTime($FormData['timeformat'], $starttick) .
		 ' - ' . FormatTime($FormData['timeformat'], $endtick);
	}
	elseif ($FormData['timedisplay'] == 'startendshort') {
		// StartEndTiny = 12:00pm-12:30pm
		return FormatTime($FormData['timeformat'], $starttick) .
		 '-' . FormatTime($FormData['timeformat'], $endtick);
	}
	elseif ($FormData['timedisplay'] == 'startdurationlong') {
		// StartDurationLong = 12:00pm for 2 hours
		return FormatTime($FormData['timeformat'], $starttick) .
		 ' for ' . FormatDuration($FormData['durationformat'], $endtick - $starttick);
	}
	elseif ($FormData['timedisplay'] == 'startdurationnormal') {
		// StartDurationNormal = 12:00pm (2 hours)
		return FormatTime($FormData['timeformat'], $starttick) .
		 ' (' . FormatDuration($FormData['durationformat'], $endtick - $starttick) . ')';
	}
	elseif ($FormData['timedisplay'] == 'startdurationshort') {
		// StartDurationShort = 12:00pm 2 hours
		return FormatTime($FormData['timeformat'], $starttick) .
		 ' ' . FormatDuration($FormData['durationformat'], $endtick - $starttick);
	}
}

function FormatTime($format, $tick)
{ // Time Formats: Ignored if "all day" event.
	if (USE_AMPM) { // if using AMPM
		if ($format == 'huge') { // Huge = 12:00 PM EST
			return date('g:i A T', $tick);
		}
		elseif ($format == 'long') { // Long = 12:00 PM
			return date('g:i A', $tick);
		}
		elseif ($format == 'normal') { // Normal = 12:00pm
			return date('g:ia', $tick);
		}
		elseif ($format == 'short') { // Short = 12:00p
			return date('g:i', $tick) . substr(date('a', $tick), 0, 1);
		}
	}
	else { // not using AMPM
		if ($format == 'long') { // Long = 24:00 EST
			return date('H:i T', $tick);
		}
		elseif ($format == 'normal') { // Normal = 24:00
			return date('H:i', $tick);
		}
	}
}

function FormatDuration($format, $seconds)
{ // Duration Formats: Ignored if has no end time
	$hours = floor($seconds / 60 / 60);
	$minutes = floor(($seconds - ($hours * 60 * 60)) / 60);
	if ($format == 'long') { // Long = 2 hours 30 minutes
		$hour_str = ($hours > 1)? ' hours' : ' hour';
		$minute_str = ($minutes > 1)? ' minutes' : ' minute';
	}
	elseif ($format == 'normal') { // Normal = 2 hours 30 min
		$hour_str = ($hours > 1)? ' hours' : ' hour';
		$minute_str = ' min';
	}
	elseif ($format == 'short') { // Short = 2 hrs 30 min
		$hour_str = ($hours > 1)? ' hrs' : ' hr';
		$minute_str = ' min';
	}
	elseif ($format == 'tiny') { // Tiny = 2hrs 30min
		$hour_str = ($hours > 1)? 'hrs' : 'hr';
		$minute_str = 'min';
	}
	elseif ($format == 'micro') { // Micro = 2hr 30m
		$hour_str = 'hr';
		$minute_str = 'm';
	}
	if ($hours > 0 && $minutes > 0) { return $hours . $hour_str . ' ' . $minutes . $minute_str; }
	elseif ($hours > 0) { return $hours . $hour_str; }
	elseif ($minutes > 0) { return $minutes . $minute_str; }
	else { return ''; }
}
?>