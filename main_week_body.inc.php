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
	e.location,
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
	e.timebegin >= '" . sqlescape($weekfrom['timestamp']) . "'
	AND
	e.timeend <= '" . sqlescape($weekto['timestamp']) . "'
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
<table id="WeekdayTable" width="100%" border="0" cellspacing="0" cellpadding="4">
<thead><tr>';
	// print the days of the week in the header of the table
	for ($weekday=0; $weekday <= 6; $weekday++) {
		$iday = Add_Delta_Days($weekfrom['month'], $weekfrom['day'], $weekfrom['year'], $weekday);
		$datediff = Delta_Days($iday['month'], $iday['day'], $iday['year'],
		 date('m', NOW), date('d', NOW), date('Y', NOW));
		echo '
<th align="center"' . (($datediff == 0)? ' class="Weekday-Today"' : '') . ' nowrap="nowrap"><div><b>' . Day_of_Week_to_Text(($weekday + WEEK_STARTING_DAY) %7) . '<br />
<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=day&amp;timebegin=' . urlencode(datetime2timestamp($iday['year'], $iday['month'], $iday['day'], 12, 0, 'am')) . $queryStringExtension . '">' . week_header_date_format($iday['day'], Month_to_Text_Abbreviation($iday['month']), 0, 3) . '</a></b></div>';
		if (!empty($_SESSION['AUTH_SPONSORID'])) { // display "add event" icon
			echo '
<div style="padding-top:3px;" class="NoPrint"><a href="addevent.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;timebegin_year=' . $iday['year'] . '&amp;timebegin_month=' . $iday['month'] . '&amp;timebegin_day=' . $iday['day'] . '" title="' . lang('add_new_event', false) . '"><img src="images/new.gif" height="16" width="16" alt="' . lang('add_new_event', false) . '" /></a></div>';
		}
		echo '</th>';
	}
	echo '
</tr></thead>
<tbody><tr>';

	// read first event if one exists
	if ($ievent < $result->numRows()) {
		$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
		$event_timebegin = timestamp2datetime($event['timebegin']);
		$event_timeend = timestamp2datetime($event['timeend']);
	}

	// output event info for every day
	for ($weekday=0; $weekday <= 6; $weekday++) {
		$events_per_day = 0;
		$iday = Add_Delta_Days($weekfrom['month'], $weekfrom['day'], $weekfrom['year'], $weekday);
		$datediff = Delta_Days($iday['month'], $iday['day'], $iday['year'],
		 date('m', NOW), date('d', NOW), date('Y', NOW));
		$iday['timebegin'] = datetime2timestamp($iday['year'], $iday['month'], $iday['day'], 0, 0, 'am');
		$iday['timeend'] = datetime2timestamp($iday['year'], $iday['month'], $iday['day'], 11, 59, 'pm');
		echo '<td' . (($datediff > 0)? ' class="Weekday-Past"' : (($datediff == 0)? ' class="Weekday-Today"' : '')) . '>';
		$event['classExtension'] = '';

		// print all events of one day
		while ($ievent < $result->numRows() && $event_timebegin['year'] == $iday['year'] &&
		 $event_timebegin['month'] == $iday['month'] && $event_timebegin['day'] == $iday['day']) {
			// Increment the number of events that have happened on this day.
			$events_per_day++;
			$event_timebegin_num = timestamp2timenumber($event['timebegin']);
			$event_timeend_num = timestamp2timenumber($event['timeend']);
			$begintimediff = NOW_AS_TIMENUM - $event_timebegin_num;
			$endtimediff = NOW_AS_TIMENUM - (($event_timeend_num == 0)? 1440 : $event_timeend_num);
			$event['timelabel'] = timenumber2timelabel((($event_timeend_num == 0)? 1440 :
			 $event_timeend_num) - $event_timebegin_num);
			$EventHasPassed = ($datediff > 0 || ($datediff == 0 && $endtimediff > 0));
			if ($EventHasPassed) { $event['classExtension'] = '-Past'; }

			// print event
			print_week_event($event);

			// read next event if one exists
			$ievent++;
			if ($ievent < $result->numRows()) {
				$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
				$event_timebegin = timestamp2datetime($event['timebegin']);
				$event_timeend = timestamp2datetime($event['timeend']);
				$event['classExtension'] = '';
			}
		}

		// Make sure there is something in the column to prevent older browsers from having display problems.
		if ($events_per_day < 1) { echo '&nbsp;'; }

		echo '</td>';
	}
	echo '
</tr></tbody>
</table><!-- #WeekdayTable -->' . "\n";

	if (!empty($_SESSION['AUTH_SPONSORID'])) {
		echo '
<table class="NoPrint" border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<td><img src="images/new.gif" height="16" width="16" alt="New" /></td>
<td>= ' . lang('add_new_event') . '</td>
</tr></tbody>
</table>' . "\n";
	}
}

function print_week_event(&$event)
{ // prints one event in the format of the week view
	global $queryStringExtension;

	disassemble_timestamp($event);
	$event_timeend_num = timestamp2timenumber($event['timeend']);
	$event_timebegin = timestamp2datetime($event['timebegin']);
	$event_timeend = timestamp2datetime($event['timeend']);

	echo '
<div class="WeekEvent' . $event['classExtension'] . '">
<div class="WeekEvent-Time">';
	if ($event['wholedayevent'] == 0) {
		echo timestring($event['timebegin_hour'], $event['timebegin_min'], $event['timebegin_ampm']);
		if (!($event['timeend_hour'] == DAY_END_H && $event['timeend_min'] == 59) ||
		 $event_timeend_num == 0) {
			echo ' (' . $event['timelabel'] . ')';
		}
	}
	else { echo lang('all_day'); }
	echo '</div>
<div class="WeekEvent-Title">';
	if ($event['sponsorid'] != 1) {
		echo '
<span class="fromCal">' . lang('calendar') . ': ' . getSponsorCalendarName($event['sponsorid']) . '</span><br />';
	}
	echo '<b><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=event&amp;eventid=' . $event['eventid'] . '&amp;timebegin=' . urlencode(datetime2timestamp($event_timebegin['year'], $event_timebegin['month'], $event_timebegin['day'], 12, 0, 'am')) . $queryStringExtension . '">' . $event['title'] . '</a></b></div>';

	if (!empty($event['location'])) {
		echo '
<div class="WeekEvent-Category">' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8') . '</div>' . "\n";
	}
	echo '
</div>' . "\n";
}
?>