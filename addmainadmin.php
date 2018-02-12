<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (!isset($_POST['mainuserid']) || !setVar($mainuserid, $_POST['mainuserid'], 'userid')) { unset($mainuserid); }

function checkuser(&$user)
{
	return (!empty($user['id']) && isValidInput($user['id'], 'userid'));
}

function mainAdminExistsInDB($mainuserid)
{
	$query = "
SELECT
	count(id)
FROM
	" . SCHEMANAME . "vtcal_adminuser
WHERE
	id='" . sqlescape($mainuserid) . "'
";
	$result =& DBQuery($query);
	// To avoid duplicate records, always return true if a DB error occurred.
	if (is_string($result)) { return true; }
	$r =& $result->fetchRow(0);
	if ($r[0] > 0) { return true; }
	return false; // default rule
}

if (isset($cancel)) {
	redirect2URL("managemainadmins.php");
	exit;
};

if (!empty($mainuserid)) { $user['id'] = $mainuserid; }
else { $user['id'] = ""; }
if (isset($save) && checkuser($user) && !mainAdminExistsInDB($user['id']) &&
 isValidUser($user['id']) ) { // save user into DB
	$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_adminuser
	(
		id
	)
VALUES
	(
		'" . sqlescape($user['id']) . "'
	)
";
	$result =& DBQuery($query );
	if (is_string($result)) {
		pageheader(lang('add_new_main_admin', false), 'Update');
		contentsection_begin(lang('add_new_main_admin'));
		DBErrorBox('Could not insert new admin user: '.  $result);
		contentsection_end();
		pagefooter();
		DBclose();
	}
	else {
		redirect2URL('managemainadmins.php');
	}
	exit;
}

// print page header
if (!empty($chooseuser)) {
	if (empty($mainuserid)) { // no user was selected
		redirect2URL('update.php?fbid=userupdatefailed');
		exit;
	}
	else {
		pageheader(lang('edit_user', false), 'Update');
		contentsection_begin(lang('edit_user'));
	}
}
else {
	pageheader(lang('add_new_main_admin', false), 'Update');
	contentsection_begin(lang('add_new_main_admin'));
}

// load user to update information if it's the first time the form is viewed
if (isset($user['id']) && (!isset($check) || $check != 1)) {
	$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_user
WHERE
	id='" . sqlescape($user['id']) . "'
");
	if (is_string($result)) {
		DBErrorBox('Could not retrieve the user\'s profile from the DB: ' . $result);
	}
	else {
		$user =& $result->fetchRow(DB_FETCHMODE_ASSOC);
	}
}
?>

<form name="mainform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="check" value="1" />

<table border="0" cellpadding="2" cellspacing="0">
<tbody><tr>
<td><label for="mainuserid"><strong><?php echo lang('user_id'); ?>:</strong></label></td>
<td><?php
if (isset($check) && $check && (empty($mainuserid))) {
	feedback(lang('choose_user_id'), FEEDBACKNEG);
}
elseif (isset($check) && $check && mainAdminExistsInDB($mainuserid)) {
	feedback(lang('already_main_admin'), FEEDBACKNEG);
}
elseif (isset($check) && $check && !isValidUser($mainuserid)) {
	feedback(lang('user_not_exists'), FEEDBACKNEG);
}
?><input type="text" id="mainuserid" name="mainuserid" value="<?php
if (!empty($mainuserid)) { echo htmlspecialchars(($check)? stripslashes($mainuserid) : $mainuserid, ENT_COMPAT, 'UTF-8'); }
?>" size="20" maxlength="50" />
<i><?php echo lang('user_id_example'); ?></i></td>
</tr><tr>
<td>&nbsp;</td>
<td><p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p></td>
</tr></tbody>
</table>

</form>

<script type="text/javascript">/* <![CDATA[ */
document.mainform.userid.focus();
/* ]]> */</script>
<?php
contentsection_end();
pagefooter();
DBclose();
?>