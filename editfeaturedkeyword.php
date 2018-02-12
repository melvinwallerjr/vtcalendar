<?php
require_once('application.inc.php');

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (!isset($_POST['keyword']) || !setVar($keyword, $_POST['keyword'], 'keyword')) { unset($keyword); }
if (!isset($_POST['featuretext']) || !setVar($featuretext, $_POST['featuretext'], 'featuretext')) { unset($featuretext); }
if (!isset($_POST['id']) || !setVar($id, $_POST['id'], 'searchkeywordid')) {
	if (!isset($_GET['id']) || !setVar($id, $_GET['id'], 'searchkeywordid')) { unset($id); }
}

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (isset($cancel)) {
	redirect2URL('managefeaturedsearchkeywords.php');
	exit;
}

$keywordexists = false;
if (isset($save) && !empty($keyword) && !empty($featuretext) ) {
	$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_searchfeatured
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	keyword='" . sqlescape($keyword) . "'
");
	if ($result->numRows() > 0) {
		if ($result->numRows() > 1) { $keywordexists = true; }
		else { // exactly one result
			if (isset($id)) {
				$searchkeyword = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
				if ($searchkeyword['id'] != $id) { $keywordexists = true; }
			}
			else { $keywordexists = true; }
		}
	}
	if (!$keywordexists) {
		if (isset($id)) { // edit, not new
			$result = DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_searchfeatured
SET
	keyword='" . sqlescape(mb_strtolower($keyword, 'UTF-8')) . "',
	featuretext='" . sqlescape($featuretext) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($id) . "'
");
		}
		else {
			$result = DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_searchfeatured
	(
		calendarid,
		keyword,
		featuretext
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape(mb_strtolower($keyword, 'UTF-8')) . "',
		'" . sqlescape($featuretext) . "'
	)
");
		}
		redirect2URL('managefeaturedsearchkeywords.php');
		exit;
	}
}

if (isset($id)) {
	pageheader(lang('edit_featured_keyword', false), 'Update');
	contentsection_begin(lang('edit_featured_keyword'));
	if (!isset($check)) {
		$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_searchfeatured
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($id) . "'
");
		$searchkeyword = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
		$keyword = $searchkeyword['keyword'];
		$featuretext = $searchkeyword['featuretext'];
	}
}
else {
	pageheader(lang('add_new_featured_keyword', false), 'Update');
	contentsection_begin(lang('add_new_featured_keyword'));
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="check" value="1" />
<?php if (!empty($id)) { echo '<input type="hidden" name="id" value="' . htmlspecialchars($id, ENT_COMPAT, 'UTF-8') . '" />' . "\n"; } ?>

<p><?php echo lang('featured_keyword_message'); ?></p>

<p><label for="keyword"><strong><?php echo lang('keyword'); ?>:</strong></label><br />
<?php
if (isset($check)) {
	if ($keywordexists) { feedbackblock(lang('keyword_already_exists'), FEEDBACKNEG); }
	elseif (empty($keyword)) { feedbackblock(lang('keyword_cannot_be_empty'), FEEDBACKNEG); }
}
?>
<input type="text" id="keyword" name="keyword" value="<?php if (!empty($keyword)) {	echo htmlspecialchars($keyword, ENT_COMPAT, 'UTF-8'); } ?>" size="20" maxlength="100" /></p>

<p><label for="featuretext"><strong><?php echo lang('featured_text'); ?></strong></label><br />
<?php
if (isset($check)) {
	if (empty($featuretext)) { feedbackblock(lang('featured_text_cannot_be_empty'), FEEDBACKNEG); }
}
?>
<textarea id="featuretext" name="featuretext" rows="6" cols="60"><?php if (!empty($featuretext)) { echo htmlspecialchars($featuretext, ENT_COMPAT, 'UTF-8'); } ?></textarea></p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>