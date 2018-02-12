<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (!isset($_POST['deleteconfirmed']) || !setVar($deleteconfirmed, $_POST['deleteconfirmed'], 'deleteconfirmed')) { unset($deleteconfirmed); }
if (!isset($_POST['mainuserid']) || !setVar($mainuserid, $_POST['mainuserid'], 'userid')) {
	if (!isset($_GET['mainuserid']) || !setVar($mainuserid, $_GET['mainuserid'], 'userid')) { unset($mainuserid); }
}

if (isset($cancel)) {
	redirect2URL('managemainadmins.php');
	exit;
}

if (isset($deleteconfirmed)) {
	// get the user from the database
	$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_adminuser
WHERE
	id='" . sqlescape($mainuserid) . "'
");
	redirect2URL('managemainadmins.php');
	exit;
}
elseif (isset($check) && empty($mainuserid)) {
	// reroute to sponsormenu page
	redirect2URL('update.php?fbid=userdeletefailed');
	exit;
}

// print page header
pageheader(lang('delete_main_admin', false), '');
contentsection_begin(lang('delete_main_admin'));
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="mainuserid" value="<?php echo htmlspecialchars($mainuserid, ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="deleteconfirmed" value="1" />

<p><strong><?php echo lang('delete_main_admin_confirm'); ?> &quot;<?php echo $mainuserid; ?>&quot;</strong></p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>