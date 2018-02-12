<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

if (!($_SESSION['AUTH_LOGINSOURCE'] == 'DB')) { redirect2URL('update.php'); }

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['user_oldpassword']) || !setVar($user_oldpassword, $_POST['user_oldpassword'], 'password')) { unset($user_oldpassword); }
if (!isset($_POST['user_newpassword1']) || !setVar($user_newpassword1, $_POST['user_newpassword1'], 'password')) { unset($user_newpassword1); }
if (!isset($_POST['user_newpassword2']) || !setVar($user_newpassword2, $_POST['user_newpassword2'], 'password')) { unset($user_newpassword2); }

if (isset($cancel)) {
	redirect2URL('update.php');
	exit;
}

if (isset($save)) {
	$user['oldpassword'] = $user_oldpassword;
	$user['newpassword1'] = $user_newpassword1;
	$user['newpassword2'] = $user_newpassword2;
	$oldpw_error = checkoldpassword($user, $_SESSION['AUTH_USERID']);
	$newpw_error = checknewpassword($user);
	if ($oldpw_error == 0) {
		if ($newpw_error == 0) { // new password is valid
			// save password to DB
			$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_user
SET
	password='" . sqlescape(crypt($user['newpassword1'])) . "'
WHERE
	id='" . sqlescape($_SESSION['AUTH_USERID']) . "'
");
			// reroute to sponsormenu page
			redirect2URL('update.php?fbid=passwordchangesuccess');
			exit;
		}
	}
}
pageheader(lang('change_password', false), 'Update');
contentsection_begin(lang('change_password'));
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>

<td><label for="user_oldpassword"><strong><?php echo lang('old_password'); ?></strong></label></td>
<td><?php if (isset($save) && $oldpw_error) { feedback(lang('old_password_wrong'), FEEDBACKNEG); } ?>
<input type="password" id="user_oldpassword" name="user_oldpassword" value="" size="20" maxlength="20" autocomplete="off" />
<i>&nbsp;<?php echo lang('case_sensitive'); ?></i></td>

</tr><tr>

<td><label for="user_newpassword1"><strong><?php echo lang('new_password'); ?></strong></label></td>
<td><?php
if (isset($save)) {
	if ($newpw_error == 1) { feedback(lang('two_passwords_dont_match'), FEEDBACKNEG); }
	elseif ($newpw_error == 2) { feedback(lang('new_password_invalid'), FEEDBACKNEG); }
}
?>
<input type="password" id="user_newpassword1" name="user_newpassword1" value="" size="20" maxlength="20" autocomplete="off" />
<i>&nbsp;<?php echo lang('case_sensitive'); ?></i></td>

</tr><tr>

<td><label for="user_newpassword2"><strong><?php echo lang('new_password'); ?></strong></label><br />
<?php echo lang('password_repeated'); ?></td>
<td><input type="password" id="user_newpassword2" name="user_newpassword2" value="" size="20" maxlength="20" autocomplete="off" />
<i>&nbsp;<?php echo lang('case_sensitive'); ?></i></td>

</tr></tbody>
</table><br />

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>