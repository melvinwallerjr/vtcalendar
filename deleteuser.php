<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['deleteuser']) || !setVar($deleteuser, $_POST['deleteuser'], 'deleteuser')) { unset($deleteuser); }
if (!isset($_POST['deleteconfirmed']) || !setVar($deleteconfirmed, $_POST['deleteconfirmed'], 'deleteconfirmed')) { unset($deleteconfirmed); }
if (!isset($_POST['userid']) || !setVar($userid, $_POST['userid'], 'userid')) {
	if (!isset($_GET['userid']) || !setVar($userid, $_GET['userid'], 'userid')) { unset($userid); }
}

if (isset($cancel)) {
	redirect2URL('manageusers.php');
	exit;
}

if (isset($deleteconfirmed)) {
	// get the user from the database
	$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_user
WHERE
	id='" . sqlescape($userid) . "'
");
	$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_auth
WHERE
	userid='" . sqlescape($userid) . "'
");

	redirect2URL('manageusers.php');
	exit;
}
elseif (isset($check) && empty($userid)) {
	// reroute to sponsormenu page
	redirect2URL('update.php?fbid=userdeletefailed');
	exit;
}

// print page header
pageheader(lang('delete_user', false), 'Update');
contentsection_begin(lang('delete_user'));
?>

<form action="deleteuser.php" method="post">
<input type="hidden" name="userid" value="<?php echo htmlspecialchars($userid, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="deleteconfirmed" value="1" />

<p><strong><?php echo lang('delete_user_confirm'); ?> &quot;<?php echo $userid; ?>&quot;</strong></p>

<p><input type="submit" name="deleteuser" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>