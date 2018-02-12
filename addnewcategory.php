<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (isset($_POST['category'])) {
	if (!isset($_POST['category']['name']) || !setVar($category['name'], $_POST['category']['name'], 'category_name')) { unset($category['name']); }
}
else { unset($category); }

if (isset($cancel)) {
	redirect2URL('manageeventcategories.php');
	exit;
}

// check if name already exists
$namealreadyexists = false;
if (!empty($category['name'])) {
	$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	name='" . sqlescape($category['name']) . "'
");
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	else {
		$namealreadyexists = ($result->numRows() > 0);
	}
}

if (isset($save) && !$namealreadyexists && !empty($category['name']) ) {
	$result =& DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_category
	(
		calendarid,
		name
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape($category['name']) . "'
	)
");
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	else {
		redirect2URL('manageeventcategories.php');
		exit;
	}
}

pageheader(lang('add_new_event_category', false), 'Update');
contentsection_begin(lang('add_new_event_category'));
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="check" value="1" />

<?php
if (isset($check)) {
	if (empty($category['name'])) {
		feedbackblock(lang('category_name_cannot_be_empty'), FEEDBACKNEG);
	}
	elseif ($namealreadyexists) {
		feedbackblock(lang('category_name_already_exists'), FEEDBACKNEG);
	}
}
?>
<p><label for="categoryname"><strong><?php echo lang('category_name'); ?>:</strong></label>
<input type="text" id="categoryname" name="category[name]" value="<?php if (!empty($category['name'])) { echo htmlspecialchars($category['name'], ENT_COMPAT, 'UTF-8'); } ?>" size="25" maxlength="<?php echo MAXLENGTH_CATEGORY_NAME; ?>" /></p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>