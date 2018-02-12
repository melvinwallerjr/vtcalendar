<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

pageheader(lang('manage_events', false), 'Update');
contentsection_begin(lang('manage_events'), true);

if (!isset($_GET['year']) || !setVar($year, $_GET['year'], 'timebegin_year')) { $year = date('Y', NOW); }
if (!isset($_GET['month']) || !setVar($month, $_GET['month'], 'timebegin_month')) { $month = date('n', NOW); }
if (!isset($_GET['timebegin']) || !setVar($timebegin,$_GET['timebegin'],'timebegin')) { unset($timebegin); }

if (isset($timebegin)) {
	$year = intval(substr($timebegin, 0, 4));
	$month = intval(substr($timebegin, 5, 2));
}

// Create timestamps for the selected month.
$startTimestamp = datetime2timestamp($year, $month, 1, DAY_BEG_H, 0, 'am');
$endTimestamp = datetime2timestamp($year + (($month == 12)? 1 : 0),
 $month + (($month == 12)? -11 : 1), 1, DAY_BEG_H, 0, 'am');

$ievent = 0;
$today = Decode_Date_US(date('m/d/Y', NOW));
$today['timestamp_daybegin'] = datetime2timestamp($today['year'], $today['month'], $today['day'], 12, 0, 'am');

// Event list with one-time events
$query = "
SELECT
	*,
	calendarid='default' AS isdefaultcal
FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	sponsorid='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
	AND
	timebegin >= '" . sqlescape($startTimestamp) . "'
	AND
	timeend < '" . sqlescape($endTimestamp) . "'
	AND
	repeatid = ''
ORDER BY
	timebegin,
	wholedayevent DESC,
	id,
	isdefaultcal
";
$singleresult =& DBQuery($query);

// Event list with repeating events
$query = "
SELECT
	e.*,
	e.calendarid='default' AS isdefaultcal,
	r.repeatdef,
	r.startdate,
	r.enddate
FROM
	" . SCHEMANAME . "vtcal_event e
JOIN
	" . SCHEMANAME . "vtcal_event_repeat r
ON
	e.repeatid=r.id
WHERE
	e.sponsorid='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
	AND
	e.timebegin >= '" . sqlescape($startTimestamp) . "'
	AND
	e.timeend < '" . sqlescape($endTimestamp) . "'
	AND
	e.repeatid != ''
ORDER BY
	e.repeatid,
	isdefaultcal,
	e.timebegin,
	e.wholedayevent DESC,
	e.id
";
$repeatresult =& DBQuery($query);

if (is_string($singleresult)) { DBErrorBox($singleresult); }
elseif (is_string($repeatresult)) { DBErrorBox($repeatresult); }
else {
	echo '
<form action="manageevents.php" method="get">

<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>
<td>' . lang('show_events_for') . ':</td>';
	$dateresults =& DBQuery("
SELECT
	substr(timebegin, 1, 7) AS yearmonth,
	count(*) AS eventcount
FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	sponsorid='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
GROUP BY
	1
ORDER BY
	1 DESC
");
	if (is_string($dateresults)) {
		echo '
<td><select name="month">';
		for ($m=1; $m <= 12; $m++) {
			echo '
<option value="' . $m . '"' . (($month == $m)? ' selected="selected"' : '') . '>' . Month_to_Text($m) . '</option>';
		}
		echo '
</select></td>
<td><select name="year">';
		$currentyear = date('Y', NOW);
		for ($y=1990; $y <= $currentyear+10; $y++) {
			echo '
<option vlaue="' . $y . '" ' . (($year == $y)? ' selected="selected"' : '') . '>' . $y . '</option>';
		}
		echo '
</select></td>';
	}
	else {
		echo '
<td><select name="timebegin">';
		$currentMonth = date('Y-m', NOW);
		for ($i=0; $i < $dateresults->numRows(); $i++) {
			$dateinfo =& $dateresults->fetchRow(DB_FETCHMODE_ASSOC, $i);
			if ($currentMonth !== true) {
				if ($currentMonth == $dateinfo['yearmonth']) { $currentMonth = true; }
				elseif ($currentMonth > $dateinfo['yearmonth']) {
					echo '
<option value="' . $currentMonth . '-01 00:00:00"' . (($year == substr($currentMonth, 0, 4) && $month == intval(substr($currentMonth, 5, 2)))? ' selected="selected"' : '') . '>' . Month_to_Text(intval(substr($currentMonth, 5, 2))) . ', ' . substr($currentMonth, 0, 4) . ' (0)</option>';
					$currentMonth = true;
				}
			}
			echo '
<option value="' . $dateinfo['yearmonth'] . '-01 00:00:00"' . (($year == substr($dateinfo['yearmonth'], 0, 4) && $month == intval(substr($dateinfo['yearmonth'], 5, 2)))? ' selected="selected"' : '') . '>' . Month_to_Text(intval(substr($dateinfo['yearmonth'], 5, 2))) . ', ' . substr($dateinfo['yearmonth'], 0, 4) . ' (' . $dateinfo['eventcount'] . ')</option>';
		}
		$dateresults->free();
		if ($currentMonth !== true) {
			echo '
<option value="' . $currentMonth . '-01 00:00:00"' . (($year == substr($currentMonth, 0, 4) && $month == intval(substr($currentMonth, 5, 2)))? ' selected="selected"' : '') . '>' . Month_to_Text(intval(substr($currentMonth, 5, 2))) . ', ' . substr($currentMonth, 0, 4) . ' (0)</option>';
			$currentMonth = true;
		}
		echo '
</select></td>';
	}
	echo '
<td><input type="submit" value="' . htmlspecialchars(lang('export_show', false), ENT_COMPAT, 'UTF-8') . '" /></td>
</tr></tbody>
</table>

</form>

<p><a href="addevent.php">' . lang('add_new_event') . '</a> ' . (($singleresult->numRows() > 0 || $repeatresult->numRows() > 0)? lang('or_manage_existing_events') : '') . '</p>';

	$defaultcalendarname = getCalendarName('default');
	echo '
<h2>' . lang('one_time_events') . ':</h2>';
	OutputManagedEvents('single', $singleresult, $defaultcalendarname, $month, $year);

	echo '<br />

<h2>' . lang('reccurring_events') . ':</h2>';
	OutputManagedEvents('repeat', $repeatresult, $defaultcalendarname, $month, $year);

	echo '<br />

<table border="0" cellspacing="0" cellpadding="3">
<caption class="alignLeft"><strong>' . lang('status_info_message') . '</strong></caption>
<tbody><tr>
<td class="txtWarn"><b>' . lang('rejected') . '</b></td>
<td>' . lang('rejected_explanation') . '</td>
</tr><tr>
<td class="txtInfo"><b>' . lang('submitted_for_approval') . '</b></td>
<td>' . lang('submitted_for_approval_explanation') . '</td>
</tr><tr>
<td class="txtGood"><b>' . lang('approved') . '</b></td>
<td>' . lang('approved_explanation') . '</td>
</tr></tbody>
</table>' . "\n";
}

function OutputManagedEvents($mode, &$result, $defaultcalendarname, $month, $year)
{
	if ($result->numRows() == 0) {
		echo '
<p>' . lang('no_managed_events') . date('F, Y', mktime(0, 0, 0, $month, 15, $year)) . '.</p>';
	}
	else {
		echo '
<table border="0" cellspacing="1" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th>' . lang('title') . '/' . lang('date') . '/' . lang('time') . '</th>
<th>' . lang('status') . '</th>
<th>' . lang('update') . '</th>
</tr></thead>
<tbody>';
		$color = 'even'; // The initial row color.
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			disassemble_timestamp($event);
			// Skip this event if this event is from the "default" calendar
			// but is not following its corresponding event from this calendar or has yet to be approved.
			if ($_SESSION['CALENDAR_ID'] != 'default' && $event['isdefaultcal'] == 1 &&
			 (!isset($PreviousEvent) || $event['id'] != $PreviousEvent['id'] ||
			 $PreviousEvent['approved'] == 0)) {
				continue;
			}
			if ($event['approved'] == -1) {
				$status = '<b class="txtWarn">' . lang('rejected') . '</b><br />';
				if (!empty($event['rejectreason'])) {
					$status .= '<b>' . lang('rejected_reason') . ':</b> ' .
					 htmlspecialchars($event['rejectreason'], ENT_COMPAT, 'UTF-8');
				}
			}
			elseif ($event['approved'] == 0) {
				$status = '<span class="txtInfo">' . lang('submitted_for_approval') . '</span><br />';
			}
			elseif ($event['approved'] == 1) {
				$status = '<span class="txtGood">' . lang('approved') . '</span><br />';
			}
			if ($event['repeatid'] != '') {
				if (!isset($PreviousEvent) || $event['repeatid'] != $PreviousEvent['repeatid']) {
					echo '<tr class="' . $color . '">
<td><strong>' . $event['title'] . '</strong><br />';

					// Output repeating event details.
					echo "\n" . '<span class="txtInfo">';
					repeatdef2repeatinput($event['repeatdef'], $event, $repeat);
					$startdate = timestamp2datetime($event['startdate']);
					printrecurrence($startdate['year'], $startdate['month'],
					 $startdate['month'], $event['repeatdef']);
					echo '</span>';

					echo '</td>
<td>' . $status . '</td>
<td>';
					adminButtons($event, array('update', 'copy', 'delete'), 'small', 'horizontal');
					echo '</td>
</tr>';
				}
			}
			echo '<tr class="' . $color . '">
<td' . (($_SESSION['CALENDAR_ID'] != 'default' && $event['isdefaultcal'] == 1)? ' class="DefaultCalendarEvent" style="padding-top:0; padding-bottom:7px;"' : '') . '><div>';
			// Output a simple message notifying the user that
			// their event was submitted to the default calendar.
			if ($_SESSION['CALENDAR_ID'] != 'default' && $event['isdefaultcal'] == 1) {
				echo str_replace('%DEFAULTCALNAME%', $defaultcalendarname,
				 lang('submitted_to_default_calendar'));
				if (isset($PreviousEvent) && $PreviousEvent['title'] != $event['title']) {
					echo str_replace('%TITLE%', htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8'),
					 lang('submitted_to_default_calendar_but_renamed'));
				}
				echo '.';
				// Unset PreviousEvent to avoid this message appearing multiple times.
				unset($PreviousEvent);
			}
			// Output the details for an event that is part of this calendar.
			else {
				if ($event['repeatid'] == '') {
					echo '<strong>' . htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8') . '</strong><br />';
				}
				// output date
				echo Day_of_Week_Abbreviation(Day_of_Week($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year'])) . ', ' . Month_to_Text_Abbreviation($event['timebegin_month']) . ' ' . $event['timebegin_day'] . ', ' . $event['timebegin_year'] . ' -- ';
				// output time
				if ($event['wholedayevent'] == 0) {
					echo timestring($event['timebegin_hour'], $event['timebegin_min'],
					 $event['timebegin_ampm']);
					if (endingtime_specified($event)) { // event has an explicit ending time
						echo ' - ', timestring($event['timeend_hour'], $event['timeend_min'],
						 $event['timeend_ampm']);
					}
				}
				else { echo lang('all_day'); }
			}
			echo '</div></td>
<td' . (($_SESSION['CALENDAR_ID'] != 'default' && $event['isdefaultcal'] == 1)? ' style="padding-top:0; padding-bottom:7px;" colspan="2"' : '') . '>' . (($_SESSION['CALENDAR_ID'] != 'default' && $event['isdefaultcal'] == 1 || $event['repeatid'] == '')? $status : '&nbsp;') . '</td>';
			if ($_SESSION['CALENDAR_ID'] == "default" || $event['isdefaultcal'] == 0) {
				echo '
<td' . (($_SESSION['CALENDAR_ID'] != 'default' && $event['isdefaultcal'] == 1)? ' style="padding-top:0; padding-bottom:7px;"' : '') . '>';
				adminButtons($event, ($event['repeatid'] != '')? array('delete') :
				 array('update', 'copy', 'delete'), 'small', 'horizontal');
				echo '</td>';
			}
			echo '
</tr>';
			$color = ($color == 'even')? 'odd' : 'even';
			$PreviousEvent['id'] = $event['id'];
			$PreviousEvent['title'] = $event['title'];
			$PreviousEvent['approved'] = $event['approved'];
			$PreviousEvent['repeatid'] = $event['repeatid'];
			$PreviousEvent['isdefaultcal'] = $event['isdefaultcal'];
		}
		echo '</tbody>
</table>' . "\n";
	}
}

contentsection_end();
pagefooter();
DBclose();
?>