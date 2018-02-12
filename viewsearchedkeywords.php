<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_GET['rangestart']) || ($rangestart = strtotime($_GET['rangestart'])) === false) { unset($rangestart); }
if (!isset($_GET['rangeend']) || ($rangeend = strtotime($_GET['rangeend'])) === false) { $rangeend = time(); }

$rangeend = date('Y-m-d', $rangeend);
if (isset($rangestart)) { $rangestart = date('Y-m-d', $rangestart); }
else { $rangestart = date('Y-m-d', strtotime($rangeend . ' -7 days')); }

// Create timestamps for the selected range.
//$rangestartTimestamp = $rangestart . ' ' . DAY_BEG_H . ':00:00";
//$rangeendTimestamp = $rangeend . ' ' . DAY_END_H . ':59:59';

pageheader(lang('searched_keywords', false), 'Update');
contentsection_begin(lang('searched_keywords'), true);

echo '
<form action="viewsearchedkeywords.php" method="get">

<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>
<td><strong>Report Range:</strong></td>
<td><input type="text" name="rangestart" value="' . htmlspecialchars($rangestart, ENT_COMPAT, 'UTF-8') . '" size="10" /></td>
<td>to</td>
<td><input type="text" name="rangestart" value="' . htmlspecialchars($rangeend, ENT_COMPAT, 'UTF-8') . '" size="10" /></td>
<td><input type="submit" value="' . htmlspecialchars(lang('export_show', false), ENT_COMPAT, 'UTF-8') . '" /></td>
<td>(yyyy-mm-dd)</td>
</tr></tbody>
</table>

</form>';

$result =& DBquery("
SELECT
	sum(count) AS sum,
	keyword
FROM
	" . SCHEMANAME . "vtcal_searchedkeywords
WHERE
	searchdate >= '" . $rangestart . "'
	AND
	searchdate <= '" . $rangeend . "'
GROUP BY
	keyword
");

if (is_string($result)) { DBErrorBox($result); }
else {
	echo '
<table border="0" cellspacing="0" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th class="alignRight">Hits</th>
<th>Keyword</th>
</tr></thead>
<tbody>';

	// The initial row color.

	if ($result->numRows() > 0) {
		$color = 'even';
		for ($i=0; $i < $result->numRows(); $i++) {
			$color = ($color == 'even')? 'odd' : 'even';
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo '<tr class="' . $color . '">
<td class="alignRight">' . $record['sum'] . '</td>
<td>' . $record['keyword'] . '</td>
</tr>';
		}
	}
	echo '</tbody>
</table>' . "\n";
}

contentsection_end();
pagefooter();
DBclose();
?>