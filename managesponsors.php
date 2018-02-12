<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['edit']) || !setVar($edit, $_POST['edit'], 'edit')) { unset($edit); }
if (!isset($_POST['delete']) || !setVar($delete, $_POST['delete'], 'delete')) { unset($delete); }
if (!isset($_POST['id']) || !setVar($id, $_POST['id'], 'sponsorid')) { unset($id); }

if (isset($edit)) {
	redirect2URL('editsponsor.php?id=' . $id);
	exit;
}
elseif (isset($delete)) {
	$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($id) . "'
");
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	$sponsor =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	if ($sponsor['admin'] == 0) { redirect2URL('deletesponsor.php?id=' . $id); }
	else { $errorMessage = 'You cannot delete the administrative sponsor for this calendar.'; }
}

pageheader(lang('manage_sponsors', false), 'Update');
contentsection_begin(lang('manage_sponsors'), true);

echo '
<p>' . lang('manage_sponsors_description') . '</p>';

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	name
");

if (is_string($result)) { DBErrorBox($result); }
else {
	echo '
<form name="mainform" action="managesponsors.php" method="post">

<p><a href="editsponsor.php">' . lang('add_new_sponsor') . '</a> <label for="id">' . lang('or_modify_existing_sponsor') . '</label></p>';

	if (isset($errorMessage)) {
		echo '
<p><b class="txtWarn">' . $errorMessage . '</b></p>';
	}
	$numLines = 15;
	echo '
<p><select id="id" name="id" size="' . $numLines . '" ondblclick="document.mainform.edit.click()">';
	for ($i=0; $i < $result->numRows(); $i++) {
		$sponsor =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo '
<option value="' . htmlspecialchars($sponsor['id'], ENT_COMPAT, 'UTF-8') . '">' . htmlspecialchars($sponsor['name'], ENT_COMPAT, 'UTF-8') . ($sponsor['admin']? ' **' : '') . '</option>';
	}
	echo '
</select></p>

<p><input type="submit" name="edit" value="' . htmlspecialchars(lang('edit', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;
<input type="submit" name="delete" value="' . htmlspecialchars(lang('delete', false), ENT_COMPAT, 'UTF-8') . '" /></p>

<p>' . lang('sponsor_twin_asterisk_note') . '</p>

<p><b>' . $result->numRows() . ' ' . lang('sponsors_total') . '</b></p>

</form>

<script type="text/javascript">/* <![CDATA[ */
document.mainform.id.focus();
/* ]]> */</script>' . "\n";
}

contentsection_end();
pagefooter();
DBclose();
?>