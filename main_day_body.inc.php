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
	e.webmap,
	e.description,
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
	e.timebegin >= '" . sqlescape($showdate['timestamp_daybegin']) . "'
	AND
	e.timeend <= '" . sqlescape($showdate['timestamp_dayend']) . "'
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
	// Admin controls
	if (!empty($_SESSION['AUTH_SPONSORID'])) {
		echo '
<div style="padding:5px;">';
		adminButtons($showdate, array('new'), 'normal', 'horizontal');
		echo '</div>';
	}
	echo '
<table id="DayTable" width="100%" border="0" cellspacing="0" cellpadding="6">
<tbody>';

	// read first event if one exists
	if ($ievent < $result->numRows()) {
		$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
		$event_timebegin = timestamp2datetime($event['timebegin']);
		$event_timeend = timestamp2datetime($event['timeend']);
		$event_timebegin_num = timestamp2timenumber($event['timebegin']);
		$event_timeend_num = timestamp2timenumber($event['timeend']);
	}
	else {
		echo '<tr>
<td colspan="3" class="NoAnnouncement">' . lang('no_events') . '</td>
</tr>';
	}
	$previousWholeDay = false;
	// print all events of one day
	while ($ievent < $result->numRows()) {
		// print event
		disassemble_timestamp($event);
		$datediff = Delta_Days($event['timebegin_month'], $event['timebegin_day'],
		 $event['timebegin_year'], date('m', NOW), date('d', NOW), date('Y', NOW));
		$timediff = $event_timeend_num - $event_timebegin_num;
		$begintimediff = NOW_AS_TIMENUM - $event_timebegin_num;
		$endtimediff = NOW_AS_TIMENUM - (($event_timeend_num == 0)? 1440 : $event_timeend_num);
		$EventHasPassed = ($datediff > 0 || ($datediff == 0 && $endtimediff > 0));
		// Start of Event Row & Time Column
		echo '<tr' . (($ievent != 0 && $event['wholedayevent'] == 0)? ' class="BorderTop"' : '') . '>
<td width="1%" class="TimeColumn' . ($EventHasPassed? '-Past' : '') . ' alignRight" nowrap="nowrap">';
		if ($event['wholedayevent'] == 0) { // Time of the Event
			echo timestring($event['timebegin_hour'], $event['timebegin_min'], $event['timebegin_ampm']);
			if (!($event['timeend_hour'] == DAY_END_H && $event['timeend_min'] == 59) ||
			 $event_timeend_num == 0) {
				echo '<br />
<small>' . timenumber2timelabel((($event_timeend_num == 0)? 1440 : $event_timeend_num) - $event_timebegin_num) . '</small>';
			}
		}
		else { // "All Day" marker
			if (!$previousWholeDay ) { echo lang('all_day'); }
			$previousWholeDay = true;
		}
		// End of Time Column, Start Data Column
		echo '</td>
<td width="98%" class="DataColumn' . ($EventHasPassed? '-Past' : '') . '"><div class="EventLeftBar">';
		if ($event['sponsorid'] != 1) {
			echo '
<span class="fromCal">' . lang('calendar') . ': ' . getSponsorCalendarName($event['sponsorid']) . '</span><br />';
		}
		echo '
<b><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=event&amp;eventid=' . $event['eventid'] . '&amp;timebegin=' . urlencode(datetime2timestamp($event_timebegin['year'], $event_timebegin['month'], $event_timebegin['day'], 12, 0, 'am')) . '">' . $event['title'] . '</a></b>';
		if (!empty($event['location'])) { echo ' - ' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8'); }
		//echo ' -- <i>' . htmlspecialchars($event['category_name'], ENT_COMPAT, 'UTF-8') . '</i>';
		if (!empty($event['webmap'])) {
			echo ' <a href="' . htmlspecialchars($event['webmap'], ENT_COMPAT, 'UTF-8') .
			 '" target="_blank">[' . lang('webmap') . ']</a>';
		}
		$description = trim(strip_tags(preg_replace('/<br\s*\/?>/i', ' ', $event['description'])));
		if (!empty($description)) {
			if (strlen($description) < 140) {
				echo '<br />' . "\n" . $description;
			}
			else {
				echo '<br />' . "\n" . substr($description, 0, 140) . '&hellip;
<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=event&amp;eventid=' , $event['eventid'] . '&amp;timebegin=' . urlencode(datetime2timestamp($event_timebegin['year'] , $event_timebegin['month'], $event_timebegin['day'], 12, 0, 'am')) . '">more</a>';
			}
		}
		// End Data Column & Event Row
		echo '</div></td>
</tr>';
		// read next event if one exists
		$ievent++;
		if ($ievent < $result->numRows()) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
			$event_timebegin = timestamp2datetime($event['timebegin']);
			$event_timeend = timestamp2datetime($event['timeend']);
			$event_timebegin_num = timestamp2timenumber($event['timebegin']);
			$event_timeend_num = timestamp2timenumber($event['timeend']);
		}
	}
	echo '</tbody>
</table><!-- #DayTable -->' . "\n";
}
?>