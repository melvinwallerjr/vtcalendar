<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['sponsor_url']) || !setVar($sponsor_url, $_POST['sponsor_url'], 'sponsor_url')) { unset($sponsor_url); }

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
	$sponsor['url'] = $sponsor_url;
	if (checkURL($sponsor['url'])) { // url is valid
		// save url to DB
		$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_sponsor
SET
	url='" . sqlescape($sponsor_url) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");
		// reroute to sponsormenu page
		redirect2URL('update.php?fbid=urlchangesuccess&fbparam=' . urlencode(stripslashes($sponsor_url)));
		exit;
	}
}
else { // read the sponsor's url from the DB
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

pageheader(lang('change_homepage', false), 'Update');
contentsection_begin(lang('change_homepage'));
?>

<form action="changehomepage.php" method="post">

<p><label for="sponsor_url"><strong><?php echo lang('change_homepage_label'); ?></strong></label><br />
<i><?php echo lang('change_homepage_example'); ?></i></p>

<?php
if (!empty($sponsor['url']) && !checkURL($sponsor['url'])) {
	feedbackblock(lang('url_invalid'), FEEDBACKNEG);
}
?>

<p><input type="text" id="sponsor_url" name="sponsor_url" value="<?php echo htmlspecialchars($sponsor['url'], ENT_COMPAT, 'UTF-8'); ?>" size="60" maxlength="<?php echo MAXLENGTH_URL; ?>" /></p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>