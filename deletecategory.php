<?php
require_once('application.inc.php');

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['categoryid']) || !setVar($categoryid, $_POST['categoryid'], 'categoryid')) {
	if (!isset($_GET['categoryid']) || !setVar($categoryid, $_GET['categoryid'], 'categoryid')) { unset($categoryid); }
}
if (!isset($_POST['newcategoryid']) || !setVar($newcategoryid, $_POST['newcategoryid'], 'categoryid')) { unset($newcategoryid); }
if (!isset($_POST['deleteevents']) || !setVar($deleteevents, $_POST['deleteevents'], 'deleteevents')) { unset($deleteevents); }

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (isset($cancel)) {
	redirect2URL('manageeventcategories.php');
	exit;
}

// make sure the category exists
$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($categoryid) . "'
");
if ($result->numRows() != 1) {
	redirect2URL('manageeventcategories.php');
	exit;
}
else {
	$category = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
}

if (isset($save)) {
	if ($deleteevents == '1') {
		$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	categoryid='" . sqlescape($categoryid) . "'
");
		$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	categoryid='" . sqlescape($categoryid) . "'
");
	}
	else {
 		$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_event
SET
	categoryid='" . sqlescape($newcategoryid) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	categoryid='" . sqlescape($categoryid) . "'
");
 		$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_event_public
SET
	categoryid='" . sqlescape($newcategoryid) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	categoryid='" . sqlescape($categoryid) . "'
");
	}
	$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($categoryid) . "'
");
	redirect2URL('manageeventcategories.php');
	exit;
}

$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id!='" . sqlescape($categoryid) . "'
ORDER BY
	name
");
if ($result->numRows() == 0) { // cannot delete the only remaining category
	redirect2URL('manageeventcategories.php');
	exit;
}

pageheader(lang('delete_event_category', false), 'Update');
contentsection_begin(lang('delete_event_category'));
?>

<form action="deletecategory.php" method="post">
<input type="hidden" name="categoryid" value="<?php echo htmlspecialchars($categoryid, ENT_COMPAT, 'UTF-8'); ?>" />

<p><strong class="txtWarn"><?php echo lang('warning_event_category_delete'); ?> &quot;<?php echo htmlspecialchars($category['name'], ENT_COMPAT, 'UTF-8'); ?>&quot;</strong></p>

<p><input type="radio" id="deleteevents1" name="deleteevents" value="1" />
<label for="deleteevents1"><?php echo lang('delete_all_events_in_category'); ?></label><br />
<input type="radio" id="deleteevents0" name="deleteevents" value="0" checked="checked" />
<label for="deleteevents0"><?php echo lang('reassign_all_events_to_category'); ?></label>
<?php
// print list with categories from the DB
echo '<select name="newcategoryid" size="1">' . "\n";
for ($i=0; $i < $result->numRows(); $i++) {
	$newcategory = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
	echo '<option value="' . $newcategory['id'] . '">' .
	 htmlspecialchars($newcategory['name'], ENT_COMPAT, 'UTF-8') . '</option>' . "\n";
}
echo '</select>';
?>
</p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>