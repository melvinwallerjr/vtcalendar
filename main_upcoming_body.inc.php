<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

if (SHOW_UPCOMING_TAB) {
	$ievent = 0;
	$todayTimeStamp = datetime2timestamp($today['year'], $today['month'], $today['day'], 12, 0, 'am');

	// read all events for this week from the DB
	// TODO: Should only show next 365 days worth of events.
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
	" . SCHEMANAME.  "vtcal_category c
WHERE
	e.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	c.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	e.categoryid=c.id
	AND
	e.timeend >= '" . sqlescape(datetime2timestamp($today['year'], $today['month'], $today['day'], 12, 0, 'am')) . "'
";

	// Filter by sponsor ID if one was specified.
	if ($sponsorid != 'all')  { $query .= " AND e.sponsorid='" . sqlescape($sponsorid) . "'"; }

	// Filter by categories if one or more were specified.
	if (isset($CategoryFilter) && count($CategoryFilter) > 0) {
		$query .= " AND (";
		for ($c=0; $c < count($CategoryFilter); $c++) {
			if ($c > 0) { $query .= " OR "; }
			$query .= "e.categoryid='" . sqlescape($CategoryFilter[$c]) . "'";
		}
		$query .= ")";
	}
	else {
		 if ($categoryid != 0) { $query .= " AND e.categoryid='" . sqlescape($categoryid) . "'"; }
	}

	// Filter by keyword if one was specified from the search form.
	if (!empty($keyword)) { $query .= " AND (e.title LIKE '%" . sqlescape($keyword) . "%' OR e.description LIKE '%" . sqlescape($keyword) . "%')"; }

	$query .= " ORDER BY e.timebegin ASC, e.wholedayevent DESC LIMIT " . MAX_UPCOMING_EVENTS;
	$result =& DBQuery($query);

	// Output an error message if $result is a string.
	if (is_string($result)) { DBErrorBox($result); }

	// Otherwise, the query was successful.
	else {
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

		$previousDate = '';
		$previousWholeDay = false;
		$firstDaysEvent = true;
		$displayedFirstEvent = false;
		// print all events of one day
		$out = '';
		while ($ievent < $result->numRows()) {
			// print event
			disassemble_timestamp($event);
			$datediff = Delta_Days($event['timebegin_month'], $event['timebegin_day'],
			 $event['timebegin_year'], date('m', NOW), date('d', NOW), date('Y', NOW));
			$timediff = $event_timeend_num - $event_timebegin_num;
			$begintimediff = NOW_AS_TIMENUM - $event_timebegin_num;
			$endtimediff = NOW_AS_TIMENUM - (($event_timeend_num == 0)? 1440 : $event_timeend_num);
			$EventHasPassed = ($datediff > 0 || ($datediff == 0 && $endtimediff > 0));
			// Do not show events that have passed.
			if (!$EventHasPassed) {
//echo '<pre>'; print_r($event); echo '</pre>';
				if ($previousDate != $event['timebegin_year'] .
				 $event['timebegin_month'] . $event['timebegin_day']) {
					$previousWholeDay = false;
					$firstDaysEvent = true;
					$previousDate = $event['timebegin_year'] . $event['timebegin_month'] .
					 $event['timebegin_day'];
					$formattedDateLabel = day_view_date_format($event['timebegin_day'],
					 Day_of_Week_to_Text(Day_of_Week($event['timebegin_month'],
					 $event['timebegin_day'], $event['timebegin_year'])),
					 Month_to_Text($event['timebegin_month']), $event['timebegin_year']);
					$eventDayTimeStamp = datetime2timestamp($event['timebegin_year'],
					 $event['timebegin_month'], $event['timebegin_day'], 12, 0, 'am');
					$out .= '<tr' . (!$displayedFirstEvent? ' id="FirstDateRow"' : '') . '>
<td colspan="2" class="DateRow"><div' . (($todayTimeStamp == $eventDayTimeStamp)? ' id="TodayDateRow"' : '') . '>';
					if (!empty($_SESSION['AUTH_SPONSORID'])) {
						$out .= '<a class="NoPrint" href="addevent.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;timebegin_year=' . $event['timebegin_year'] . '&amp;timebegin_month=' . $event['timebegin_month'] . '&amp;timebegin_day=' . $event['timebegin_day'] . '" title="' . lang('add_new_event', false) . '"><img src="images/new.gif" height="16" width="16" alt="' . lang('add_new_event', false) . '" /></a> ';
					}
					$out .= '<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=day&amp;timebegin=' . urlencode($eventDayTimeStamp) . $queryStringExtension . '">' . $formattedDateLabel . '</a></div></td>
</tr>';
				}
				else {
					$firstDaysEvent = false;
				}

				// Start of Event Row & Time Column
				$out .= '<tr class="BorderTop">
<td width="1%" class="TimeColumn alignRight" nowrap="nowrap">';

				if ($event['wholedayevent'] == 0) { // Time of the Event
					$out .= timestring($event['timebegin_hour'],
					 $event['timebegin_min'], $event['timebegin_ampm']);
					if (!($event['timeend_hour'] == DAY_END_H && $event['timeend_min'] == 59) ||
					 $event_timeend_num == 0) {
						$out .= '<br />
<small>' . timenumber2timelabel((($event_timeend_num == 0)? 1440 : $event_timeend_num) - $event_timebegin_num) . '</small>';
					}
				}
				else { // "All Day" marker
					if (!$previousWholeDay ) { echo lang('all_day'); }
					$previousWholeDay = true;
				}

				// End of Time Column, Start Data Column
				$out .= '</td>
<td width="98%" class="DataColumn"><div class="EventLeftBar">';
				if ($event['sponsorid'] != 1) {
					$out .= '
<span class="fromCal">' . lang('calendar') . ': ' . getSponsorCalendarName($event['sponsorid']) . '</span><br />';
				}
				$out .= '
<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=event&amp;eventid=' . $event['eventid'] . '&amp;timebegin=' . urlencode(datetime2timestamp($event_timebegin['year'], $event_timebegin['month'], $event_timebegin['day'], 12, 0, 'am')) . '"><b>' . $event['title'] . '</b></a>';
				if (!empty($event['location'])) { $out .= ' - ' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8'); }
				//$out .= ' -- <i>' . htmlspecialchars($event['category_name'], ENT_COMPAT, 'UTF-8') . '</i>';
				if (!empty($event['webmap'])) {
					$out .= ' <a href="' . htmlspecialchars($event['webmap'], ENT_COMPAT, 'UTF-8') .
					 '" target="_blank">[' . lang('webmap') . ']</a>';
				}
				$description = trim(strip_tags(preg_replace('/<br\s*\/?>/i', ' ', $event['description'])));
				if (!empty($event['description'])) {
					if (strlen(trim(strip_tags($event['description']))) < 140) {
						$out .= '<br />' . "\n" . $description;
					}
					else {
						$out .= '<br />
' . substr($description, 0, 140) . '&hellip;
<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=event&amp;eventid=' . $event['eventid'] . '&amp;timebegin=' . urlencode(datetime2timestamp($event_timebegin['year'], $event_timebegin['month'], $event_timebegin['day'], 12, 0, 'am')) . '">more</a>';
					}
				}

				// End Data Column & Event Row
				$out .= '</div></td>
</tr>';

				// Mark that the first event has been displayed.
				$displayedFirstEvent = true;
			}

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

		if (!empty($out)) { echo $out; }
		else {
			echo '<tr>
<td colspan="3" class="NoAnnouncement">' . lang('no_upcoming_events') . '</td>
</tr>';
		}
		echo '</tbody>
</table><!-- #DayTable -->';
	}
}
?>