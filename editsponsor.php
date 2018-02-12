<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (!isset($_POST['id']) || !setVar($id, $_POST['id'], 'sponsorid')) {
	if (!isset($_GET['id']) || !setVar($id, $_GET['id'], 'sponsorid')) { unset($id); }
}
if (isset($_POST['sponsor'])) {
	if (!isset($_POST['sponsor']['name']) || !setVar($sponsor['name'], textString($_POST['sponsor']['name']), 'sponsor_name')) { unset($sponsor['name']); }
	if (!isset($_POST['sponsor']['email']) || !setVar($sponsor['email'], textString($_POST['sponsor']['email']), 'email')) { unset($sponsor['email']); }
	if (!isset($_POST['sponsor']['url']) || !setVar($sponsor['url'], textString($_POST['sponsor']['url']), 'sponsor_url')) { $sponsor['url'] = ''; }
	if (!isset($_POST['sponsor']['admins']) || !setVar($sponsor['admins'], $_POST['sponsor']['admins'], 'sponsor_admins')) { $sponsor['admins'] = ''; }
}
else { unset($sponsor); }

if (isset($cancel)) {
	redirect2URL('managesponsors.php');
	exit;
}

function checksponsor(&$sponsor)
{
	return (!empty($sponsor['name']) && !empty($sponsor['email']) &&
	 (empty($sponsor['url']) || checkURL($sponsor['url'])));
}

function emailsponsoraccountchanged(&$sponsor)
{
	$subject = lang('email_account_updated_subject', false);
	$body = lang('email_account_updated_body', false);
	$body .= '   ' . lang('sponsor_name', false) . ' ' . stripslashes($sponsor['name']) . "\n";
	$body .= '   ' . lang('email', false) . ': ' . stripslashes($sponsor['email']) . "\n";
	$body .= '   ' . lang('homepage', false) . ': ' . stripslashes($sponsor['url']) . "\n\n";
	$body .= SECUREBASEURL . 'update.php?calendarid=' . $_SESSION['CALENDAR_ID'] . "\n\n";
	$body .= lang('email_add_event_instructions', false);
	sendemail2sponsor($sponsor['name'], $sponsor['email'], $subject, $body);
}

$sponsorexists = false;
$addPIDError = '';
$pidsAdded = array();
if (isset($save) && checksponsor($sponsor) ) {
	$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	name='" . sqlescape($sponsor['name']) . "'
");
	if ($result->numRows() > 0) {
		if ($result->numRows() > 1) { $sponsorexists = true; }
		else { // exactly one result
			if (isset($id)) {
				$s = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
				if ($s['id'] != $id) { $sponsorexists = true; }
			}
			else { $sponsorexists = true; }
		}
	}
	if (!$sponsorexists) {
		// check validity of sponsor-admins
		if (!empty($sponsor['admins'])) {
			// disassemble the admins string and check all PIDs against the DB
			$pidsInvalid = '';
			$pidsTokens = split("[ ,;\n\t]", $sponsor['admins']);
			$pidsAddedCount = 0;
			for ($i=0; $i < count($pidsTokens); $i++) {
				$pidName = $pidsTokens[$i];
				$pidName = trim($pidName);
				if (!empty($pidName)) {
					if (isvaliduser($pidName)) {
						$pidsAdded[$pidsAddedCount] = $pidName;
						$pidsAddedCount++;
					}
					else {
						if (!empty($pidsInvalid)) { $pidsInvalid .= ','; }
						$pidsInvalid .= $pidName;
					}
				}
			}
			// save the changes
			// feedback message(s)
			if (!empty($pidsInvalid)) {
				if (strpos($pidsInvalid, ',') > 0) { // more than one user-ID
					$addPIDError = lang('user_ids_invalid') . ' &quot;' . $pidsInvalid . '&quot;';
				}
				else {
					$addPIDError = lang('user_id_invalid') . ' &quot;' . $pidsInvalid . '&quot;';
				}
			}
		}
		if (empty($addPIDError)) {
			if (isset($id)) { // edit, not new
				$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_sponsor
SET
	name='" . sqlescape($sponsor['name']) ."',
	email='" . sqlescape($sponsor['email']) . "',
	url='" . sqlescape($sponsor['url']) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($id) . "'
");

				// substitute existing auth info with the new one
				$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_auth
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
");
				for ($i=0; $i < count($pidsAdded); $i++) {
					$result = DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_auth
	(
		calendarid,
		userid,
		sponsorid
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape($pidsAdded[$i]) . "',
		'" . sqlescape($id) . "'
	)
");
				}
			}
			else {
				$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_sponsor
	(
		calendarid,
		name,
		email,
		url
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape($sponsor['name']) . "',
		'" . sqlescape($sponsor['email']) . "',
		'" . sqlescape($sponsor['url']) . "'
	)
";
				$result = DBQuery($query);

				// determine the automatically generated sponsor-id
				$result = DBQuery("
SELECT
	id
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	name='" . sqlescape($sponsor['name']) . "'
	AND
	email='" . sqlescape($sponsor['email']) . "'
	AND
	url='" . sqlescape($sponsor['url']) . "'
");
				$s = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
				$id = $s['id'];

				// substitute existing auth info with the new one
				$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_auth
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
");
				for ($i=0; $i < count($pidsAdded); $i++) {
					$result = DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_auth
	(
		calendarid,
		userid,
		sponsorid
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape($pidsAdded[$i]) . "',
		'" . sqlescape($id) . "'
	)
");
				}
			}

			emailsponsoraccountchanged($sponsor);
			redirect2URL('managesponsors.php');
			exit;
		}
	}
}

if (isset($id)) {
	pageheader(lang('edit_sponsor', false), 'Update');
	contentsection_begin(lang('edit_sponsor'));
	if (!isset($check)) {
		$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($id) . "'
");
		$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	}
}
else {
	pageheader(lang('add_new_sponsor', false), 'Update');
	contentsection_begin(lang('add_new_sponsor'));
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="check" value="1" />
<?php if (isset($id)) { echo '<input type="hidden" name="id" value="' . htmlspecialchars($id, ENT_COMPAT, 'UTF-8') . '" />' . "\n"; } ?>

<?php if (isset($sponsor) && $sponsor['admin']) { ?>
<p><b>Note:</b> Users added to this sponsor will have administrative access to this calendar.</p>
<?php } ?>

<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>

<td><label for="sponsorname"><strong><?php echo lang('sponsor_name'); ?></strong></label> <span class="txtWarn">*</span></td>
<td><?php
if (isset($check)) {
	if (empty($sponsor['name'])) { feedbackblock(lang('choose_sponsor_name'), FEEDBACKNEG); }
	elseif ($sponsorexists) { feedbackblock(lang('sponsor_already_exists'), FEEDBACKNEG); }
}
?>
<input type="text" id="sponsorname" name="sponsor[name]" value="<?php
if (isset($check)) { $sponsor['name'] = stripslashes($sponsor['name']); }
if (isset($sponsor['name'])) { echo htmlspecialchars($sponsor['name'], ENT_COMPAT, 'UTF-8'); }
?>" size="50" maxlength="<?php echo MAXLENGTH_SPONSOR_NAME; ?>" />
<i><?php echo lang('sponsor_name_example'); ?></i></td>

</tr><tr>

<td><label for="sponsoremail"><strong><?php echo lang('email'); ?>:</strong></label> <span class="txtWarn">*</span></td>
<td><?php
if (isset($check) && (empty($sponsor['email']))) { feedbackblock(lang('choose_email'), FEEDBACKNEG);} ?>
<input type="text" id="sponsoremail" name="sponsor[email]" value="<?php
if (isset($check)) { $sponsor['email'] = stripslashes($sponsor['email']); }
if (isset($sponsor['email'])) { echo htmlspecialchars($sponsor['email'], ENT_COMPAT, 'UTF-8'); }
?>" size="20" maxlength="<?php echo MAXLENGTH_EMAIL; ?>" />
<i><?php echo lang('email_example'); ?></i></td>

</tr><tr>

<td><label for="sponsorurl"><strong><?php echo lang('homepage'); ?>:</strong></label></td>
<td><?php
if (isset($check) && !checkURL($sponsor['url'])) { feedbackblock(lang('url_invalid'), FEEDBACKNEG); } ?>
<input type="text" id="sponsorurl" name="sponsor[url]" value="<?php
if (isset($check)) { $sponsor['url'] = stripslashes($sponsor['url']); }
if (isset($sponsor['url'])) { echo htmlspecialchars($sponsor['url'], ENT_COMPAT, 'UTF-8'); }
?>" size="50" maxlength="<?php echo MAXLENGTH_URL; ?>" />
<i><?php echo lang('url_example'); ?></i></td>

</tr><tr>

<td><label for="sponsoradmins"><strong><?php
if (isset($sponsor) && $sponsor['admin']) { echo lang('administrative_members'); }
else { echo lang('sponsor_members'); }
?></strong></label></td>
<td><?php if (!empty($addPIDError)) { feedbackblock($addPIDError, 1); } ?>
<textarea id="sponsoradmins" name="sponsor[admins]" cols="40" rows="3"><?php
if (isset($sponsor['admins'])) { echo htmlspecialchars($sponsor['admins'], ENT_COMPAT, 'UTF-8'); }
elseif (isset($id)) {
	$query = "
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_auth
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
ORDER BY
	userid
";
	$result = DBQuery($query);
	$i = 0;
	while ($i < $result->numRows()) {
		$authorization = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo (($i++ > 0)? ',' : '') . htmlspecialchars($authorization['userid'], ENT_COMPAT, 'UTF-8');
	}
}
?></textarea><br />
<i><?php echo lang('administrative_members_example'); ?></i></td>

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