<?php
require_once('application.inc.php');

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (!isset($_POST['categoryid']) || !setVar($categoryid, $_POST['categoryid'], 'categoryid')) {
	if (!isset($_GET['categoryid']) || !setVar($categoryid, $_GET['categoryid'], 'categoryid')) { unset($categoryid); }
}
if (isset($_POST['category'])) {
	if (!isset($_POST['category']['name']) || !setVar($category['name'], $_POST['category']['name'], 'category_name')) { unset($category['name']); }
}
else { unset($category); }

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

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
	AND
	id!='" . sqlescape($categoryid) . "'
");
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	if ($result->numRows() > 0) { $namealreadyexists = true; }
}

if (isset($save) && !$namealreadyexists && !empty($category['name']) ) {
	$result =& DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_category
SET
	name='" . sqlescape($category['name']) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($categoryid) . "'
");
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	redirect2URL('manageeventcategories.php');
	exit;
}
else { // read category from DB
	if (!isset($check)) {
		$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($categoryid) . "'
");
		if (is_string($result)) { DBErrorBox($result); exit; }
		if ($result->numRows() != 1) {
			redirect2URL('manageeventcategories.php');
			exit;
		}
		else {
			$category = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
		}
	}
}

pageheader(lang('rename_event_category', false), 'Update');
contentsection_begin(lang('rename_event_category'));

echo '
<form action="' . $_SERVER['PHP_SELF'] . '" method="post">
<input type="hidden" name="categoryid" value="' . htmlspecialchars($categoryid, ENT_COMPAT, 'UTF-8') . '" />
<input type="hidden" name="check" value="1" />';

if (isset($check)) {
	if (empty($category['name'])) { feedbackblock(lang('category_name_cannot_be_empty'), FEEDBACKNEG); }
	elseif ($namealreadyexists) { feedback(lang('category_name_already_exists'), FEEDBACKNEG); }
}

echo '
<p><label for="categoryname"><strong>' . lang('category_name') . ':</strong></label>
<input type="text" id="categoryname" name="category[name]" value="' . htmlspecialchars($category['name'], ENT_COMPAT, 'UTF-8') . '" size="25" maxlength="' . MAXLENGTH_CATEGORY_NAME . '" /></p>

<p><input type="submit" name="save" value="' . htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;
<input type="submit" name="cancel" value="' . htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8') . '" /></p>

</form>' . "\n";

contentsection_end();
pagefooter();
DBclose();
?>