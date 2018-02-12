<?php
require_once('application.inc.php');

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (isset($cancel)) {
	redirect2URL('viewsearchlog.php');
	exit;
}

if (isset($save)) {
	$result = DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_searchlog
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
");
	redirect2URL('viewsearchlog.php');
	exit;
}

pageheader(lang('clear_search_log', false), 'Update');
contentsection_begin(lang('clear_search_log'));
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<p><?php echo lang('clear_search_log_confirm'); ?></p>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>