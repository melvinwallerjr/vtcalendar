<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

pageheader(lang('manage_featured_search_keywords', false), 'Update');
contentsection_begin(lang('manage_featured_search_keywords'), true);

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_searchfeatured
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	keyword
");

if (is_string($result)) { DBErrorBox($result); }
else {
	echo '
<p>' . lang('featured_search_keywords_message') . '</p>

<p><a href="editfeaturedkeyword.php">' . lang('add_new_featured_keyword') . '</a>' . (($result->numRows() > 0)? ' ' . lang('or_manage_existing_keywords') : '') . '</p>';

	if ($result->numRows() > 0 ) {
		echo '
<table border="0" cellspacing="0" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th>' . lang('keyword') . '</th>
<th>&nbsp;</th>
</tr></thead>
<tbody>';
		$color = 'even';
		for ($i=0; $i < $result->numRows(); $i++) {
			$color = ($color == 'even')? 'odd' : 'even';
			$searchkeyword =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo '<tr class="' . $color . '">
<td>' . htmlspecialchars($searchkeyword['keyword'], ENT_COMPAT, 'UTF-8') . '</td>
<td>&nbsp;<a href="editfeaturedkeyword.php?id=' . urlencode($searchkeyword['id']) . '">' . lang('edit') . '</a> &nbsp;
<a href="deletefeaturedkeyword.php?id=' . urlencode($searchkeyword['id']) . '">' . lang('delete') . '</a></td>
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