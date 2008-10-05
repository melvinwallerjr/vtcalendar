<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

/* Escape a string to be outputted in an XML document */
function xmlEscape($string) {
	return str_replace('"','&quot;',str_replace('>','&gt;',str_replace('<','&lt;',str_replace("'",'&apos;',str_replace('&','&amp;',$string)))));
}

/* Create a date/time formatted for XML */
function xmlSchemaDate($tick) {
	return date("Y-m-d",$tick)."T".date("H:i:s",$tick).substr(date("O",$tick),0,3).':'.substr(date("O",$tick),3,2);
}

/* Output an error message and set headers so that it is not cached. */
function outputErrorMessage($mesg) {
	header('HTTP/1.1 500 Internal Server Error');
	header('Expires: '.gmdate("D, d M Y H:i:s", mktime(0,0,0,1,1,1975)).' GMT');
	header('Cache-Control: no-store');
	header('Content-type: text/plain');
	echo "<!-- /* ERR\n\nError Message:\n\n". $mesg ."\n\nSee the instructions at http://www.howard.edu/calendar/public-export/instructions.php\n\n*/ -->";
	exit();
}

function dbtime2tick($dbtime) {
	$year = substr($dbtime, 0, 4);
	$month = substr($dbtime, 5, 2);
	$day = substr($dbtime, 8, 2);
	$hour = substr($dbtime, 11, 2);
	$min = substr($dbtime, 14, 2);
	$sec = substr($dbtime, 17, 2);
	return mktime($hour, $min, $sec, $month, $day, $year);
}

function createHTML(&$result, $config) {
	$ReturnData = "";
	
	if ($config['HTMLTemplate'] == "PARAGRAPH") {
		if ($result->numRows() == 0) {
			$ReturnData = '<p class="VTCAL_NoEvents"><i>There are no upcoming events.</i></p>';
		}
		else {
			$ievent = 0;
			while ($ievent < $result->numRows()) {
				$event = $result->fetchRow(DB_FETCHMODE_ASSOC,$ievent);
				
				$ReturnData = $ReturnData.'<p><b><a href="'.BASEURL.'main.php?calendarid='.urlencode($config['CalendarID']).'&view=event&eventid='.urlencode($event['id']).'&timebegin='.urlencode($event['timebegin']).$config['LinkFilterQueryString'].'"';
				
				if (isset($config['MaxTitleCharacters']) && ($config['MaxTitleCharacters'] < strlen($event['title']))) {
					$ReturnData = $ReturnData.' title="'.htmlentities($event['title']).'">'.htmlentities(trim(substr($event['title'],0,$config['MaxTitleCharacters']))).'</a>...</b>';
				}
				else {
					$ReturnData = $ReturnData.'>'.htmlentities($event['title']).'</a></b>';
				}
				
				if ($config['ShowDateTime'] == "Y") {
					$ReturnData = $ReturnData."<br>\n";
					if ($config['CombineRepeating'] == "Y" && $event['repeatdef'] != "") {
						$ReturnData = $ReturnData.createRepeatString($event['startdate'],$event['enddate'],$event['startdate_year'],$event['startdate_month'],$event['startdate_day'],$event['repeatdef'],$config);
					}
					else {
						$ReturnData = $ReturnData.htmlentities(FormatDate($config['DateFormat'], dbtime2tick($event['timebegin'])));
						
						$ReturnTime = FormatTimeDisplay($event, $config);
						if ($config['ShowAllDay'] == "Y" || ($config['ShowAllDay'] == "N" && $ReturnTime != "All Day")) {
							$ReturnData = $ReturnData.' - '.htmlentities($ReturnTime);
						}
					}
				}
				
				if ($event['location'] != "" && $config['ShowLocation'] == "Y") {
					$ReturnData = $ReturnData."<br>\n<i";
					if (isset($config['MaxLocationCharacters']) && ($config['MaxLocationCharacters'] < strlen($event['location']))) {
						$ReturnData = $ReturnData.' title="'.htmlentities($event['location']).'">'.htmlentities(trim(substr($event['location'],0,$config['MaxLocationCharacters']))).'...';
					}
					else {
						$ReturnData = $ReturnData.'>'.htmlentities($event['location']);
					}
					$ReturnData = $ReturnData.'</i>';
				}
				$ReturnData = $ReturnData."</p>\n\n";
				
				$ievent++;
			}
		}
	}
	elseif ($config['HTMLTemplate'] == "TABLE") {
		$ReturnData = $ReturnData.'<table class="VTCAL" border="0" cellspacing="0" cellpadding="4">'."\n\n";
		
		if ($result->numRows() == 0) {
			$ReturnData = $ReturnData.'<tr><td class="VTCAL_NoEvents" colspan="2">There are no upcoming events.</td></tr>';
		}
		else {
			$ievent = 0;
			while ($ievent < $result->numRows()) {
				$event = $result->fetchRow(DB_FETCHMODE_ASSOC,$ievent);
				
				$ReturnData = $ReturnData."<tr>\n";
				
				if ($config['ShowDateTime'] == "Y") {
					$ReturnData = $ReturnData.'<td class="VTCAL_DateTime" valign="top">'.htmlentities(FormatDate($config['DateFormat'], dbtime2tick($event['timebegin'])));
					
					$ReturnTime = FormatTimeDisplay($event, $config);
					if ($config['ShowAllDay'] == "Y" || ($config['ShowAllDay'] == "N" && $ReturnTime != "All Day")) {
						$ReturnData = $ReturnData.'<br><span>'.htmlentities($ReturnTime)."</span>";
					}
					
					$ReturnData = $ReturnData."</td>\n";
				}
				
				$ReturnData = $ReturnData.'<td class="VTCAL_TitleLocation" valign="top"><b><a href="'.BASEURL.'main.php?calendarid='.urlencode($config['CalendarID']).'&view=event&eventid='.urlencode($event['id']).'&timebegin='.urlencode($event['timebegin']).$config['LinkFilterQueryString'].'"';
				
				if (isset($config['MaxTitleCharacters']) && ($config['MaxTitleCharacters'] < strlen($event['title']))) {
					$ReturnData = $ReturnData.' title="'.htmlentities($event['title']).'">'.htmlentities(trim(substr($event['title'],0,$config['MaxTitleCharacters']))).'</a>...</b>';
				}
				else {
					$ReturnData = $ReturnData.'>'.htmlentities($event['title']).'</a></b>';
				}
					
				if ($event['location'] != "" && $config['ShowLocation'] == "Y") {
					$ReturnData = $ReturnData."<br>\n<i";
					if (isset($config['MaxLocationCharacters']) && ($config['MaxLocationCharacters'] < strlen($event['location']))) {
						$ReturnData = $ReturnData.' title="'.htmlentities($event['location']).'">'.htmlentities(trim(substr($event['location'],0,$config['MaxLocationCharacters']))).'...';
					}
					else {
						$ReturnData = $ReturnData.'>'.htmlentities($event['location']);
					}
					$ReturnData = $ReturnData.'</i>';
				}
				
				$ReturnData = $ReturnData."</td>\n</tr>\n\n";
				
				$ievent++;
			}
		}
		
		$ReturnData = $ReturnData."</table>\n\n";
	}
	elseif ($config['HTMLTemplate'] == "MAINSITE") {
		if ($result->numRows() == 0) {
			$ReturnData = '<p align="center"><i>No upcoming events.</i></p>';
		}
		else {
			$ievent = 0;
			while ($ievent < $result->numRows()) {
				$event = $result->fetchRow(DB_FETCHMODE_ASSOC,$ievent);
				
				$ReturnData = $ReturnData.'<p id="VTCAL_EventNum'.($ievent+1).'"><a href="'.BASEURL.'main.php?calendarid='.urlencode($config['CalendarID']).'&view=event&eventid='.urlencode($event['id']).'&timebegin='.urlencode($event['timebegin']).$config['LinkFilterQueryString'].'">';
				$ReturnData = $ReturnData.'<b>'.htmlentities(FormatDate($config['DateFormat'], dbtime2tick($event['timebegin']))).
					'<br>'.htmlentities(FormatTimeDisplay($event, $config))."<b><br></b></b>\n";
				
				$ReturnData = $ReturnData.'<span><u';
				if (isset($config['MaxTitleCharacters']) && ($config['MaxTitleCharacters'] < strlen($event['title']))) {
					$ReturnData = $ReturnData.' title="'.htmlentities($event['title']).'">'.htmlentities(trim(substr($event['title'],0,$config['MaxTitleCharacters']))).'...';
				}
				else {
					$ReturnData = $ReturnData.'>'.htmlentities($event['title']);
				}
				$ReturnData = $ReturnData."</u><br>\n";
				
				if ($event['location'] != "" && $config['ShowLocation'] == "Y") {
					$ReturnData = $ReturnData."<i";
					if (isset($config['MaxLocationCharacters']) && ($config['MaxLocationCharacters'] < strlen($event['location']))) {
						$ReturnData = $ReturnData.' title="'.htmlentities($event['location']).'">'.htmlentities(trim(substr($event['location'],0,$config['MaxLocationCharacters']))).'...';
					}
					else {
						$ReturnData = $ReturnData.'>'.htmlentities($event['location']);
					}
					$ReturnData = $ReturnData.'</i>';
				}
				else {
					$ReturnData = $ReturnData.'<i>&nbsp;</i>';
				}
				
				$ReturnData = $ReturnData."</span></a></p>\n\n";
				
				$ievent++;
			}
		}
	}
	
	return $ReturnData;
}

function createText(&$result, $config) {
	return "";
}

function createXML(&$result, $config) {
	$ReturnData = '<?xml version="1.0" encoding="ISO-8859-1"?>'."\n";
	$ReturnData = $ReturnData.'<Calendar '.
		'ID="'.xmlEscape($config['CalendarID']).'"'.
		' RequestTime="'.xmlSchemaDate(constCurrentTick).'"'.
		' MaxEvents="'.xmlEscape($config['MaxEvents']).'"'.
		">\n";
	$ievent = 0;
	while ($ievent < $result->numRows()) {
		$event = $result->fetchRow(DB_FETCHMODE_ASSOC,$ievent);
		
		$ReturnData = $ReturnData."\t<Event".
			' ID="'.xmlEscape($event['id']).'"'.
			' URL="'.xmlEscape(BASEURL.'main.php?calendarid='.urlencode($config['CalendarID']).'&view=event&eventid='.urlencode($event['id']).'&timebegin='.urlencode($event['timebegin'])).$config['LinkFilterQueryString'].'"'.
			">\n";
		
		$ReturnData = $ReturnData."\t\t<Title";
		if (isset($config['MaxTitleCharacters']) && ($config['MaxTitleCharacters'] < strlen($event['title']))) {
			$ReturnData = $ReturnData.' Full="'.xmlEscape($event['title']).'">'.xmlEscape(substr($event['title'],0,$config['MaxTitleCharacters']));
		}
		else {
			$ReturnData = $ReturnData.'>'.xmlEscape($event['title']);
		}
		$ReturnData = $ReturnData."</Title>\n";
		
		if ($config['ShowDateTime'] == "Y") {
			$ReturnData = $ReturnData."\t\t<Date>".xmlEscape(FormatDate($config['DateFormat'], dbtime2tick($event['timebegin'])))."</Date>\n";
			$ReturnData = $ReturnData."\t\t<Time>".xmlEscape(FormatTimeDisplay($event, $config))."</Time>\n";
		}
		
		if ($event['location'] != "" && $config['ShowLocation'] == "Y") {
			$ReturnData = $ReturnData."\t\t<Location";
			if (isset($config['MaxLocationCharacters']) && ($config['MaxLocationCharacters'] < strlen($event['location']))) {
				$ReturnData = $ReturnData.' Full="'.xmlEscape($event['location']).'">'.xmlEscape(substr($event['location'],0,$config['MaxLocationCharacters']));
			}
			else {
				$ReturnData = $ReturnData.'>'.xmlEscape($event['location']);
			}
			$ReturnData = $ReturnData."</Location>\n";
		}

		$ReturnData = $ReturnData."\t</Event>\n";
		$ievent++;
	}
	$ReturnData = $ReturnData.'</Calendar>';
	
	return $ReturnData;
}

/*
Huge - Wednesday, October 25, 2006
Long - Wed, October 25, 2006
Normal - October 25, 2006
Short - Oct. 25, 2006
Tiny - Oct 25 '06
Micro - Oct 25 or "Today"
*/
function FormatDate($format, $tick) {
	if ($format == "HUGE") {
		return date("l, F j, Y", $tick);
	}
	elseif ($format == "LONG") {
		return date("D, F j, Y", $tick);
	}
	elseif ($format == "NORMAL") {
		return date("F j, Y", $tick);
	}
	elseif ($format == "SHORT") {
		return date("M. j, Y", $tick);
	}
	elseif ($format == "TINY") {
		return date("M j, 'y", $tick);
	}
	elseif ($format == "MICRO") {
		//if (date("F j, Y", NOW) == date("F j, Y", $tick)) {
		//	return "Today";
		//}
		//else {
			return date("M j", $tick);
		//}
	}
}

/*
Time Display:
========================
-- Default to "Start" if no end time.
-- Ignored if "all day" event.
Start = 12:00pm
StartEndLong = 12:00pm to 12:30pm
StartEndNormal = 12:00pm - 12:30pm
StartEndTiny = 12:00pm-12:30pm
StartDurationLong = 12:00pm for 2 hours
StartDurationNormal = 12:00pm (2 hours)
StartDurationShort = 12:00pm 2 hours
*/
function FormatTimeDisplay(&$event, $config) {
	$starttick = dbtime2tick($event['timebegin']);
	$endtick = dbtime2tick($event['timeend']);
	
	if ($event['wholedayevent'] != 0) {
		return "All Day";
	}
	else {
		if ($config['TimeDisplay'] == "start" || substr($event['timeend'], 11, 5) == "23:59") {
			return FormatTime($config['TimeFormat'], $starttick);
		}
		elseif ($config['TimeDisplay'] == "startendlong") {
			return FormatTime($config['TimeFormat'], $starttick)." to ".FormatTime($config['TimeFormat'], $endtick);
		}
		elseif ($config['TimeDisplay'] == "startendnormal") {
			return FormatTime($config['TimeFormat'], $starttick)." - ".FormatTime($config['TimeFormat'], $endtick);
		}
		elseif ($config['TimeDisplay'] == "startendshort") {
			return FormatTime($config['TimeFormat'], $starttick)."-".FormatTime($config['TimeFormat'], $endtick);
		}
		elseif ($config['TimeDisplay'] == "startdurationlong") {
			return FormatTime($config['TimeFormat'], $starttick)." for ".FormatDuration($config['DurationFormat'], $endtick-$starttick);
		}
		elseif ($config['TimeDisplay'] == "startdurationnormal") {
			return FormatTime($config['TimeFormat'], $starttick)." (".FormatDuration($config['DurationFormat'], $endtick-$starttick).")";
		}
		elseif ($config['TimeDisplay'] == "startdurationshort") {
			return FormatTime($config['TimeFormat'], $starttick)." ".FormatDuration($config['DurationFormat'], $endtick-$starttick);
		}
	}
}

/*
Time Formats:
========================
-- Ignored if "all day" event.

If using AM/PM:
	Huge = 12:00 PM EST
	Long = 12:00 PM
	Normal = 12:00pm
	Short = 12:00p
	
If not using AM/PM:
	Long = 24:00 EST
	Normal = 24:00
*/
function FormatTime($format, $tick) {
	if (USE_AMPM) {
		if ($format == "huge") {
			return date("g:i A T", $tick);
		}
		elseif ($format == "long") {
			return date("g:i A", $tick);
		}
		elseif ($format == "normal") {
			return date("g:ia", $tick);
		}
		elseif ($format == "short") {
			return date("g:i", $tick).substr(date("a", $tick),0,1);
		}
	}
	else {
		if ($format == "long") {
			return date("H:i T", $tick);
		}
		elseif ($format == "normal") {
			return date("H:i", $tick);
		}
	}
}

/*
Duration Formats:
========================
-- Ignored if has no end time
Long = 2 hours 30 minutes
Normal = 2 hours 30 min
Short = 2 hrs 30 min
Tiny = 2hrs 30min
Micro = 2hr 30m
*/
function FormatDuration($format, $seconds) {
	$hours = floor($seconds / 60 / 60);
	$minutes = floor(($seconds - ($hours*60*60)) / 60);
	
	if ($format == "long") {
		if ($hours > 1) $hour_str = " hours";
		else            $hour_str = " hour";
		
		if ($minutes > 1) $minute_str = " minutes";
		else              $minute_str = " minute";
	}
	elseif ($format == "normal") {
		if ($hours > 1) $hour_str = " hours";
		else            $hour_str = " hour";
		
		$minute_str = " min";
	}
	elseif ($format == "short") {
		if ($hours > 1) $hour_str = " hrs";
		else            $hour_str = " hr";
		
		$minute_str = " min";
	}
	elseif ($format == "tiny") {
		if ($hours > 1) $hour_str = "hrs";
		else            $hour_str = "hr";
		
		$minute_str = "min";
	}
	elseif ($format == "micro") {
		$hour_str = "hr";
		$minute_str = "m";
	}
	
	if ($hours > 0 && $minutes > 0) {
		return $hours.$hour_str." ".$minutes.$minute_str;
	}
	elseif ($hours > 0) {
		return $hours.$hour_str;
	}
	elseif ($minutes > 0) {
		return $minutes.$minute_str;
	}
	else {
		return "";
	}
}
?>