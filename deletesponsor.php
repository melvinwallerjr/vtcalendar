<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['deleteevents']) || !setVar($deleteevents, $_POST['deleteevents'], 'deleteevents')) { unset($deleteevents); }
if (!isset($_POST['id']) || !setVar($id, $_POST['id'], 'sponsorid')) {
	if (!isset($_GET['id']) || !setVar($id, $_GET['id'], 'sponsorid')) { unset($id); }
}
if (!isset($_POST['newsponsorid']) || !setVar($newsponsorid, $_POST['newsponsorid'], 'sponsorid')) { unset($newsponsorid); }

if (isset($cancel)) {
	redirect2URL('managesponsors.php');
	exit;
}

// make sure the sponsor exists
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
if ($result->numRows() != 1) {
	redirect2URL('managesponsors.php');
	exit;
}
else {
	$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
}

if (isset($save) ) {
	if ($deleteevents == '1') {
		$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
");
		$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
");
	}
	else {
 		$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_event
SET
	sponsorid='" . sqlescape($newsponsorid) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
");
 		$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_event_public
SET
	sponsorid='" . sqlescape($newsponsorid) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
");
	}
	$result = DBQuery("
DELETE FROM
	"  .SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($id) . "'
");
	$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_auth
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($id) . "'
");
	redirect2URL('managesponsors.php');
	exit;
}

$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id!='" . sqlescape($id) . "'
ORDER BY
	name
");
if ($result->numRows() == 0) { // cannot delete the last remaining sponsor
	redirect2URL('managesponsors.php');
	exit;
}

pageheader(lang('delete_sponsor', false), 'Update');
contentsection_begin(lang('delete_sponsor'));
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php if (isset($id)) { echo '<input type="hidden" name="id" value="' . htmlspecialchars($id, ENT_COMPAT, 'UTF-8') . '" />' . "\n"; } ?>

<p><strong class="txtWarn"><?php echo lang('delete_sponsor_confirm'); ?> &quot;<?php echo $sponsor['name']; ?>&quot;</strong></p>

<p><input type="radio" id="deleteevents1" name="deleteevents" value="1" />
<label for="deleteevents1"><?php echo lang('delete_all_events_of_sponsor'); ?></label><br />
<input type="radio" id="deleteevents0" name="deleteevents" value="0" checked="checked" />
<label for="deleteevents0"><?php echo lang('reassign_all_events_to_sponsor'); ?></label>
<select name="newsponsorid" size="1">
<?php
// print list with categories from the DB
for ($i=0; $i < $result->numRows(); $i++) {
	$newsponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
	echo '<option value="' . $newsponsor['id'] . '">' . $newsponsor['name'] . '</option>' . "\n";
}
?>
</select></p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>