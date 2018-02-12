<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

$ievent = 0;

// read events from the DB
$query = "
SELECT
	e.id AS eventid,
	e.timebegin,
	e.timeend,
	e.sponsorid,
	e.title,
	e.wholedayevent,
	e.categoryid,
	c.id,
	c.name AS category_name
FROM
	" . SCHEMANAME . "vtcal_event_public e,
	" . SCHEMANAME . "vtcal_category c
WHERE
	e.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	c.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	e.categoryid=c.id
	AND
	e.timebegin >= '" . sqlescape($monthstart['timestamp']) . "'
	AND
	e.timeend <= '" . sqlescape($monthend['timestamp']) . "'
";

// Filter by sponsor if necessary
if ($sponsorid != 'all') { $query .= " AND e.sponsorid='" . sqlescape($sponsorid) . "'"; }

// Filter by category filters if necessary
if (isset($CategoryFilter) && count($CategoryFilter) > 0) {
	$query .= " AND (";
	for ($c=0; $c < count($CategoryFilter); $c++) {
		if ($c > 0) { $query .= " OR "; }
		$query .= "e.categoryid='" . sqlescape($CategoryFilter[$c]) . "'";
	}
	$query .= ")";
}
else {
	 if (isset($categoryid) && $categoryid != 0) {
		$query .= " AND e.categoryid='" . sqlescape($categoryid) . "'";
	}
}

// Filter the results by a keyword from the search form.
if (!empty($keyword)) {
	$query .= " AND (e.title LIKE '%" . sqlescape($keyword) .
	 "%' OR e.description LIKE '%" . sqlescape($keyword) . "%')";
}
$query .= " ORDER BY e.timebegin ASC, e.wholedayevent DESC";
$result =& DBQuery($query . "\n");

// Output an error message if $result is a string.
if (is_string($result)) { DBErrorBox($result); }

// Otherwise, the query was successful.
else {
	echo '
<table id="MonthTable" width="100%" border="0" cellspacing="0" cellpadding="3">
<thead><tr>';
	if (WEEK_STARTING_DAY == 0) {
		echo '
<th>' . lang('sunday') . '</th>';
	}
	echo '
<th>' . lang('monday') . '</th>
<th>' . lang('tuesday') . '</th>
<th>' . lang('wednesday') . '</th>
<th>' . lang('thursday') . '</th>
<th>' . lang('friday') . '</th>
<th>' . lang('saturday') . '</th>';
	if (WEEK_STARTING_DAY == 1) {
		echo '
<th>' . lang('sunday') . '</th>';
	}
	echo '
</tr></thead>
<tbody>';

	// read first event if one exists
	if ($ievent < $result->numRows()) {
		$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
		$event_timebegin = timestamp2datetime($event['timebegin']);
		$event_timeend = timestamp2datetime($event['timeend']);
	}

	// Loop through the 6 possible rows for each week.
	// If less rows are necessary,
	for ($iweek=1; $iweek <= 6; $iweek++) {
		// Determine the first day of the week
		$weekstart = Add_Delta_Days($monthstart['month'], $monthstart['day'],
		 $monthstart['year'], ($iweek - 1) * 7);
		$weekstart['timestamp'] = datetime2timestamp($weekstart['year'],
		 $weekstart['month'], $weekstart['day'], 12, 0, 'am');
		// Output only the weeks where the first day is in the current month (excluding the first week)
		if ($iweek == 1 || $weekstart['month'] == $month['month']) {
			echo '<tr>';
			// Output each day for the week.
			for ($weekday = 0; $weekday <= 6; $weekday++) {
				// Calculate the day's date information.
				$iday = Add_Delta_Days($monthstart['month'], $monthstart['day'],
				 $monthstart['year'], (($iweek - 1) * 7) + $weekday);
				$iday['timebegin'] = datetime2timestamp($iday['year'],
				 $iday['month'], $iday['day'], 0, 0, 'am');
				$iday['timeend'] = datetime2timestamp($iday['year'],
				 $iday['month'], $iday['day'], 11, 59, 'pm');
				// Determine the number of days between the day and the current date.
				$datediff = Delta_Days($iday['month'], $iday['day'],
				 $iday['year'], date('m', NOW), date('d', NOW), date('Y', NOW));
				// Set the CSS class for how the day should be styled.
				$TDclass = '';
				if ($month['month'] != $iday['month']) { $TDclass = ' class="MonthDay-OtherMonth"'; }
				elseif ($datediff > 0) { $TDclass = ' class="MonthDay-Past"'; }
				elseif ($datediff == 0) { $TDclass = ' class="MonthDay-Today"'; }
				else { $TDclass = ' class="MonthDay-Future"'; }
				echo '
<td' . $TDclass . '>';

				// Do not display events that are not in the current month.
				// TODO: Change this so the query does not pull the events in the first place.
				if (!SHOW_MONTH_OVERLAP && $month['month'] != $iday['month']) {
					echo '&nbsp;';
				}
				else {
					// Output a table with the day's number.
					echo '
<div class="DayNumber">';
					// Display an "add event" icon
					if (!empty($_SESSION['AUTH_SPONSORID'])) {
						echo '
<a class="floatLeft NoPrint" href="addevent.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;timebegin_year=' . $iday['year'] . '&amp;timebegin_month=' . $iday['month'] . '&amp;timebegin_day=' . $iday['day'] . '" title="' . lang('add_new_event', false) . '"><img src="images/new.gif" height="16" width="16" alt="' . lang('add_new_event', false) . '" /></a>';
					}
					echo '
<b><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=day&amp;timebegin=' . urlencode(datetime2timestamp($iday['year'], $iday['month'], $iday['day'], 12, 0, 'am')) . $queryStringExtension . '">' . $iday['day'] . '</a></b></div>';
				}
				// Output all the events for the day.
				while ($ievent < $result->numRows() && $event_timebegin['year'] == $iday['year'] &&
				 $event_timebegin['month'] == $iday['month'] && $event_timebegin['day'] == $iday['day']) {
					// Only display events that are in the current month.
					// TODO: Change so the query does not pull the events in the first place.
					if (SHOW_MONTH_OVERLAP || $month['month'] == $iday['month']) {
						disassemble_timestamp($event);
						$event_timebegin_num = timestamp2timenumber($event['timebegin']);
						$event_timeend_num = timestamp2timenumber($event['timeend']);
						$begintimediff = NOW_AS_TIMENUM - $event_timebegin_num;
						$endtimediff = NOW_AS_TIMENUM - (($event_timeend_num == 0)? 1440 : $event_timeend_num);
						$event_timelabel = timenumber2timelabel((($event_timeend_num == 0)? 1440 :
						 $event_timeend_num) - $event_timebegin_num);
						$EventHasPassed = ($datediff > 0 || ($datediff == 0 && $endtimediff > 0));
						// If the event has passed, use the correct CSS class.
						if ($EventHasPassed) { $event['classExtension'] = '-Past'; }
						else { $event['classExtension'] = ''; }
						// Output the event data.
						echo '
<p class="EventItem' . $event['classExtension'] . '"><small>';
						if ($event['wholedayevent'] == 0) { // Time of the Event
							echo timestring($event_timebegin['hour'], $event_timebegin['min'],
							 $event_timebegin['ampm']);
							if (!($event['timeend_hour'] == DAY_END_H && $event['timeend_min'] == 59) ||
							 $event_timeend_num == 0) {
								 echo ' (' . $event_timelabel . ')';
							}
						}
						else { // "All Day" marker
							if (!$previousWholeDay ) { echo lang('all_day'); }
							$previousWholeDay = true;
						}
						echo '</small><br />';
						if ($event['sponsorid'] != 1) {
							echo '
<span class="fromCal">' . lang('calendar') . ': ' . getSponsorCalendarName($event['sponsorid']) . '</span><br />';
						}
						echo '
<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=event&amp;eventid=' . $event['eventid'] . '&amp;timebegin=' . urlencode(datetime2timestamp($event_timebegin['year'], $event_timebegin['month'], $event_timebegin['day'], 12, 0, 'am')) . '">' . $event['title'] . '</a></p>';
					}
					// Read the next event
					$ievent++;
					if ($ievent < $result->numRows()) {
						$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
						$event_timebegin = timestamp2datetime($event['timebegin']);
						$event_timeend = timestamp2datetime($event['timeend']);
					}
				}
				echo '</td>';
			}
			echo '
</tr>';
		}
	}
	echo '</tbody>
</table><!-- #MonthTable -->';

	if (!empty($_SESSION['AUTH_SPONSORID'])) {
		echo '
<table class="NoPrint" border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<td><img src="images/new.gif" height="16" width="16" alt="New" /></td>
<td>= ' . lang('add_new_event') . '</td>
</tr></tbody>
</table>';
	}
}
?>