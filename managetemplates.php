<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

pageheader(lang('manage_templates', false), 'Update');
contentsection_begin(lang('manage_templates'), true);

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_template
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
ORDER BY
	name
");
if (is_string($result)) { DBErrorBox($result); }
else {
	echo '
<p>' . lang('manage_templates_description') . '</p>

<p><a href="addtemplate.php">' . lang('add_new_template') . '</a>' . (($result->numRows() > 0)? lang('or_modify_existing_template') : '') . '</p>';
	if ($result->numRows() > 0 ) {
		echo '
<table border="0" cellspacing="0" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th>' . lang('template_name') . '</th>
<th>&nbsp;</th>
</tr></thead>
<tbody>';
		$color = 'even';
		for ($i=0; $i < $result->numRows(); $i++) {
			$color = ($color == 'even')? 'odd' : 'even';
			$template = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo '<tr class="' . $color . '">
<td>' . htmlspecialchars($template['name'], ENT_COMPAT, 'UTF-8') . '</td>
<td><a href="updatetinfo.php?templateid=' . urlencode($template['id']) . '">' . lang('edit') . '</a>&nbsp;
<a href="deletetemplate.php?templateid=' . urlencode($template['id']) . '">' . lang('delete') . '</a></td>
</tr>';
		}
		echo '</tbody>
</table><br />' . "\n";
	}
}

contentsection_end();
pagefooter();
DBclose();
?>