<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN'] ) { exit; } // additional security

if (!isset($_POST['edit']) || !setVar($edit, $_POST['edit'], 'edit')) { unset($edit); }
if (!isset($_POST['delete']) || !setVar($delete, $_POST['delete'], 'delete')) { unset($delete); }
if (!isset($_POST['userid']) || !setVar($userid, $_POST['userid'], 'userid')) { unset($userid); }

if (isset($edit)) {
	redirect2URL('changeuserinfo.php?chooseuser=1&userid=' . $userid);
	exit;
}
elseif (isset($delete)) {
	redirect2URL('deleteuser.php?userid=' . $userid);
	exit;
}

pageheader(lang('manage_users', false), 'Update');
contentsection_begin(lang('manage_users'), true);

$numLines = 15;

echo '
<form name="mainform" action="' . $_SERVER['PHP_SELF'] . '" method="post">

<p><a href="changeuserinfo.php">' . lang('add_new_user') . '</a> <label for="userid">' . lang('or_modify_existing_user') . '</label></p>

<p><select id="userid" name="userid" size="' . $numLines . '" ondblclick="document.mainform.edit.click()" style="width:200px">';
$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_user
ORDER BY
	id
");
if (is_string($result)) { DBErrorBox($result); }
else {
	for ($i=0; $i < $result->numRows(); $i++) {
		$user =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo '
<option value="' . $user['id'] . '">' . $user['id'] . '</option>';
	}
	echo '
</select></p>

<p><input type="submit" name="edit" value="' . lang('edit', false) . '" />
&nbsp;
<input type="submit" name="delete" value="' . lang('delete', false) . '" /></p>

<p><b>' . $result->numRows() . ' ' . lang('users_total') . '</b></p>

</form>

<script type="text/javascript">/* <![CDATA[ */
document.mainform.userid.focus();
/* ]]> */</script>' . "\n";
}

contentsection_end();
pagefooter();
DBclose();
?>