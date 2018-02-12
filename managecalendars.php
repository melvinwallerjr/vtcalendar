<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN'] ) { exit; } // additional security

pageheader(lang('manage_calendars', false), 'Update');
contentsection_begin(lang('manage_calendars'), true);
$calculateTotals = isset($_GET['totals']);

// determine today's date
$today = Decode_Date_US(date('m/d/Y', NOW));
$todayTimeStamp = datetime2timestamp($today['year'], $today['month'], $today['day'], 12, 0, 'am');

if ($calculateTotals) {
	// Count all events.
	$result =& DBQuery("
SELECT
	count(id) AS count,
	calendarid
FROM
	" . SCHEMANAME . "vtcal_event_public v
GROUP BY
	calendarid
ORDER BY
	calendarid
");

	if (is_string($result)) {
		echo '
<p>' . lang('dberror_nototals') . ': ' . $result . '</p>';
	}
	else {
		$totalEvents = array();
		$totalEvents['_'] = 0;
		for ($i=0; $i < $result->numRows(); $i++) {
			$calendar =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			$totalEvents['_'] += $calendar['count'];
			if (isset($totalEvents[$calendar['calendarid']])) {
				$totalEvents[$calendar['calendarid']] += $calendar['count'];
			}
			else {
				$totalEvents[$calendar['calendarid']] = $calendar['count'];
			}
		}

		$result->free();
		// Count only upcoming events.
		$result =& DBQuery("
SELECT
	count(id) AS count,
	calendarid
FROM
	" . SCHEMANAME . "vtcal_event_public v
WHERE
	timebegin >= '" . sqlescape($todayTimeStamp) . "'
GROUP BY
	calendarid
ORDER BY
	calendarid
");

		if (is_string($result)) {
			echo '
<p>' . lang('dberror_noupcomingtotals') . ': ' . $result . '</p>';
		}
		else {
			$upcomingEvents = array();
			$upcomingEvents['_'] = 0;
			for ($i=0; $i < $result->numRows(); $i++) {
				$calendar =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
				$upcomingEvents['_'] += $calendar['count'];
				if (isset($upcomingEvents[$calendar['calendarid']])) {
					$upcomingEvents[$calendar['calendarid']] += $calendar['count'];
				}
				else {
					$upcomingEvents[$calendar['calendarid']] = $calendar['count'];
				}
			}
			$result->free();
		}
	}
}

$result =& DBQuery("
SELECT
	id,
	name
FROM
	" . SCHEMANAME . "vtcal_calendar
ORDER BY
	id
");

if (is_string($result)) { DBErrorBox($result); }
else {
	echo '
<p><a href="editcalendar.php?new=1">' . lang('add_new_calendar') . '</a> ' . lang('or_modify_existing_calendar') . '</p>

<table border="0" cellspacing="1" cellpadding="5">
<thead><tr class="TableHeaderBG">
<th>' . lang('calendar_id') . '</th>
<th>' . lang('calendar_name') . '</th>';
	if ($calculateTotals) {
		echo '
<th class="alignRight">' . lang('upcoming_total') . '</th>';
	}
	echo '
<th>' . (!$calculateTotals? '<a href="managecalendars.php?totals=y">' . lang('show_totals') . '</a>' : '&nbsp;') . '</th>
</tr></thead>
<tfoot><tr class="TableHeaderBG">
<td colspan="2">' . $result->numRows() . ' ' . lang('calendars') . '</td>';
	if ($calculateTotals) {
		echo '
<td class="alignRight">';
		if (isset($upcomingEvents) && isset($totalEvents)) {
			echo $upcomingEvents['_'] . ' / ' . $totalEvents['_'];
		}
		else { echo '&nbsp;'; }
		echo '</td>';
	}
	echo '
<td>&nbsp;</td>
</tr></tfoot>
<tbody>';

	$color = 'even'; // The initial row color.
	for ($i=0; $i < $result->numRows(); $i++) {
		$color = ($color == 'even')? 'odd' : 'even';
		$calendar =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo '<tr class="' . $color . '">
<td><a href="main.php?calendarid=' . urlencode($calendar['id']) . '">' . htmlspecialchars($calendar['id'], ENT_COMPAT, 'UTF-8') . '</a></td>
<td>' . htmlspecialchars($calendar['name'], ENT_COMPAT, 'UTF-8') . '</td>';
		if ($calculateTotals) {
			echo '
<td class="alignRight">';
			if (isset($upcomingEvents) && isset($totalEvents)) {
				echo (isset($upcomingEvents[$calendar['id']])? $upcomingEvents[$calendar['id']] : 0) . ' / ' . (isset($totalEvents[$calendar['id']])? $totalEvents[$calendar['id']] : 0);
			}
			else { echo '**'; }
			echo '</td>';
		}
		echo '
<td><a href="editcalendar.php?cal[id]=' . urlencode($calendar['id']) . '">' . lang('edit') . '</a>&nbsp;';
		if ($calendar['id'] != 'default') {
			echo '
<a href="deletecalendar.php?cal[id]=' . urlencode($calendar['id']) . '">' . lang('delete') . '</a>';
		}
		echo '</td>
</tr>';
	}
	echo '</tbody>
</table>' . "\n";
	$result->free();
}

contentsection_end();
pagefooter();
DBclose();
?>