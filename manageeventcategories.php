<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

pageheader(lang('manage_event_categories', false), 'Update');
contentsection_begin(lang('manage_event_categories'), true);

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	name
");

if (is_string($result)) { DBErrorBox($result); }
else {
	echo '
<p><a href="addnewcategory.php">' . lang('add_new_event_category') . '</a>' . (($result->numRows() > 0)? ' ' . lang('or_modify_existing_category') : '') . '.</p>';
	if ($result->numRows() > 0) {
		echo '
<table border="0" cellspacing="1" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th>' . lang('category_name') . '</th>
<th>&nbsp;</th>
</tr></thead>
<tbody>';
		$color = 'even';
		for ($i=0; $i < $result->numRows(); $i++) {
			$color = ($color == 'even')? 'odd' : 'even';
			$category = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo '<tr class="' . $color . '">
<td>' . htmlspecialchars($category['name'], ENT_COMPAT, 'UTF-8') . '</td>
<td><a href="renamecategory.php?categoryid=' . urlencode($category['id']) .'">' . lang('rename') . '</a>&nbsp;
<a href="deletecategory.php?categoryid=' . urlencode($category['id']) . '">' . lang('delete') . '</a></td>
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