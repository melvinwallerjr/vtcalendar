<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

if (isset($_POST['cancel']) && !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (isset($_POST['save']) && !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (isset($_POST['sponsor_email']) && !setVar($sponsor_email, $_POST['sponsor_email'], 'sponsor_email')) { unset($sponsor_email); }

if (isset($cancel)) {
	redirect2URL('update.php');
	exit;
}

// read sponsor name from DB
$result = DBQuery("
SELECT
	name
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");
$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);

if (isset($save)) {
	$sponsor['email'] = $sponsor_email;
	if (checkemail($sponsor['email'])) { // email is valid
		// save email to DB
		$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_sponsor
SET
	email='" . sqlescape($sponsor_email) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");
		$_SESSION['CALENDAR_ADMINEMAIL'] = $sponsor_email; // set new e-mail to current session
		// reroute to sponsormenu page
		redirect2URL('update.php?fbid=emailchangesuccess&fbparam=' .
		 urlencode(stripslashes($sponsor_email)));
		exit;
	}
}
else { // read the sponsor's email from the DB
	$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");
	$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
}

pageheader(lang('change_email', false), 'Update');
contentsection_begin(lang('change_email'));
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<p><label for="sponsor_email"><strong><?php echo lang('change_email_label'); ?></strong></label></p>

<?php
if (!empty($sponsor['email']) && !checkemail($sponsor['email'])) {
	feedbackblock(lang('email_invalid'), FEEDBACKNEG);
}
?>

<p><input type="text" id="sponsor_email" name="sponsor_email" value="<?php echo htmlspecialchars($sponsor['email'], ENT_COMPAT, 'UTF-8'); ?>" size="60" maxlength="<?php echo MAXLENGTH_EMAIL; ?>" /></p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>