<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

pageheader(lang('manage_search_keywords', false), 'Update');
contentsection_begin(lang('manage_search_keywords'), true);

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_searchkeyword
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	keyword
");

if (is_string($result)) { DBErrorBox($result); }
else {
	echo '
<p>' . lang('manage_search_keywords_message') . '</p>

<p><a href="addnewkeywordpair.php">' . lang('add_new_keyword_pair') . '</a>' . (($result->numRows() > 0)? lang('or_manage_existing_pairs') : '') . '</p>';

	if ($result->numRows() > 0) {
		echo '
<table border="0" cellspacing="0" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th>' . lang('keyword') . '</th>
<th>' . lang('alternative_keyword') . '</th>
<th>&nbsp;</th>
</tr></thead>
<tbody>';
		$color = 'even';
		for ($i=0; $i < $result->numRows(); $i++) {
			$color = ($color == 'even')? 'odd' : 'even';
			$searchkeyword = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo '<tr class="' . $color . '">
<td>' . htmlspecialchars($searchkeyword['keyword'], ENT_COMPAT, 'UTF-8') . '</td>
<td>' . htmlspecialchars($searchkeyword['alternative'], ENT_COMPAT, 'UTF-8') . '</td>
<td><a href="deletekeywordpair.php?id=' . urlencode($searchkeyword['id']) . '">' . lang('delete') . '</a></td>
</tr>';
		}
		echo '</tbody>
</table>' . "\n";
	}
}

contentsection_end();
pagefooter();
DBclose();
?>