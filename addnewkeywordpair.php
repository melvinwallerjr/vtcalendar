<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (!isset($_POST['keyword']) || !setVar($keyword, $_POST['keyword'], 'keyword')) { unset($keyword); }
if (!isset($_POST['alternativekeyword']) || !setVar($alternativekeyword, $_POST['alternativekeyword'], 'keyword')) {unset($alternativekeyword); }

if (isset($cancel)) {
	redirect2URL('managesearchkeywords.php');
	exit;
}

if (isset($save) && !empty($keyword) && !empty($alternativekeyword) ) {
	$result =& DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_searchkeyword
	(
		calendarid,
		keyword,
		alternative
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape(mb_strtolower($keyword, 'UTF-8')) . "',
		'" . sqlescape(mb_strtolower($alternativekeyword, 'UTF-8')) . "'
	)
");
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	else {
		redirect2URL('managesearchkeywords.php');
		exit;
	}
}

pageheader(lang('add_new_keyword_pair', false), 'Update');
contentsection_begin(lang('add_new_keyword_pair'));
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="check" value="1" />

<?php echo lang('add_new_keyword_pair_instructions'); ?><br />

<table cellpadding="3" cellspacing="3" border="0">
<tbody><tr>
<td><label for="keyword"><strong><?php echo lang('keyword'); ?>:</strong></label><br />
<?php if (isset($check) && empty($keyword)) { feedback(lang('keyword_cannot_be_empty'), 1); } ?>
<input type="text" id="keyword" name="keyword" value="<?php if (!empty($keyword)) { echo htmlspecialchars($keyword, ENT_COMPAT, 'UTF-8'); } ?>" size="20" maxlength="<?php echo MAXLENGTH_KEYWORD; ?>" /></td>
<td><label for="alternativekeyword"><strong><?php echo lang('alternative_keyword'); ?></strong></label><br />
<?php if (isset($check) && empty($alternativekeyword)) { feedback(lang('keyword_cannot_be_empty'), 1); } ?>
<input type="text" id="alternativekeyword" name="alternativekeyword" value="<?php if (!empty($alternativekeyword)) { echo htmlspecialchars($alternativekeyword, ENT_COMPAT, 'UTF-8'); } ?>" size="20" maxlength="<?php echo MAXLENGTH_KEYWORD; ?>" /></td>
</tr></tbody>
</table>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>