<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

// Get the start and end range.
if (!isset($_GET['rangestart']) || ($rangestart = strtotime($_GET['rangestart'])) === false) { unset($rangestart); }
if (!isset($_GET['rangeend']) || ($rangeend = strtotime($_GET['rangeend'])) === false) { $rangeend = time(); }

// Set the start to 21 days before the end, if the start is not set.
if (!isset($rangestart)) {
	$rangestart = strtotime(date('Y-m-d', $rangeend) . ' -21 days');
}

// Create the start and end timestamps.
$rangestartTimestamp = datetime2timestamp(date('Y', $rangestart),
 date('m', $rangestart), date('d', $rangestart), DAY_BEG_H, 0, 'am');
$rangeendTimestamp = datetime2timestamp(date('Y', $rangeend),
 date('m', $rangeend), date('d', $rangeend), DAY_END_H, 59, 'pm');

pageheader(lang('view_search_log', false), 'Update');
contentsection_begin(lang('view_search_log'), true);

echo '
<p><a href="deletesearchlog.php">' . lang('clear_search_log') . '</a></p>

<form action="viewsearchlog.php" method="get">

<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>
<td><strong>' . lang('view_entries_from') . ':</strong></td>
<td><input type="text" name="rangestart" value="' . date('n/j/Y', $rangestart) . '" size="10" /></td>
<td>to</td>
<td><input type="text" name="rangestart" value="' . date('n/j/Y', $rangeend) . '" size="10" /></td>
<td><input type="submit" value="' . htmlspecialchars(lang('export_show', false), ENT_COMPAT, 'UTF-8') . '" /></td>
<td>(m/d/yyyy)</td>
</tr></tbody>
</table>

</form>';

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_searchlog
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	time >= '" . $rangestartTimestamp . "'
	AND
	time <= '" . $rangeendTimestamp . "'
ORDER BY
	time DESC
");

if (is_string($result)) { DBErrorBox($result); }
else {
	if ($result->numRows() == 0) {
		echo '
<p><b>' . lang('search_log_is_empty') . '</b></p>';
	}
	else {
		echo '<pre>';
		for ($i=0; $i < $result->numRows(); $i++) {
			$searchlog =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo htmlspecialchars($searchlog['time'], ENT_COMPAT, 'UTF-8') . ' ' . str_pad($searchlog['ip'], 15, ' ', STR_PAD_LEFT) . ' ' . str_pad($searchlog['numresults'], 5, ' ', STR_PAD_LEFT) . ' ' . htmlspecialchars($searchlog['keyword'], ENT_COMPAT, 'UTF-8') . "\n";
		}
		echo '</pre>';
	}
}

contentsection_end();
pagefooter();
DBclose();
?>