<?php
require_once('application.inc.php');
require_once('changecolors-functions.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }

if (isset($cancel)) {
	redirect2URL('update.php');
	exit;
};

// Load variables
$VariableErrors = array();
LoadVariables();

if (isset($save) && count($VariableErrors) == 0) {
	$result =& DBQuery("
SELECT
	count(*) AS reccount
FROM
	" . SCHEMANAME . "vtcal_colors
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
");
	if (is_string($result)) { DBErrorBox($result); exit; }
	$count =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	if ($count['reccount'] == 0) {
		$sql = MakeColorUpdateSQL($_SESSION['CALENDAR_ID'], 'insert');
	}
	else {
		$sql = MakeColorUpdateSQL($_SESSION['CALENDAR_ID'], 'update');
	}
	$result =& DBQuery($sql);
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	setCalendarPreferences();
	redirect2URL('update.php');
	exit;
}

pageheader(lang('change_colors', false), 'Update');
contentsection_begin(lang('change_colors'));
?>

<form action="changecolors.php" name="colorSettings" method="post">

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" /></p>

<?php ShowForm(); ?>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" /></p>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>