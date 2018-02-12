<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN']) { exit; } // additional security

pageheader(lang('manage_main_admins', false), 'Update');
contentsection_begin(lang('manage_main_admins'), true);

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_adminuser
ORDER BY
	id
");

if (is_string($result))	{ DBErrorBox($result); }
else {
	echo '
<p><a href="addmainadmin.php">' . lang('add_new_main_admin') . '</a> ' . lang('or_delete_existing') . '</p>

<table border="0" cellspacing="0" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th>' . lang('user_id') . '</th>
<th>&nbsp;</th>
</tr></thead>
<tbody>';
	$color = 'even';
	for ($i=0; $i < $result->numRows(); $i++) {
		$color = ($color == 'even')? 'odd' : 'even';
		$user =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo '<tr class="' . $color . '">
<td>' . htmlspecialchars($user['id'], ENT_COMPAT, 'UTF-8') . '</td>
<td><a href="deletemainadmin.php?mainuserid=' . urlencode($user['id']) . '">' . lang('delete') . '</a></td>
</tr>' ;
	}
	echo '</tbody>
</table><br />

<p><b>' . $result->numRows() . ' ' . lang('main_admins_total') . '</b></p>' . "\n";
}

contentsection_end();
pagefooter();
DBclose();
?>