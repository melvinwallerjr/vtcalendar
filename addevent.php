<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['httpreferer']) || !setVar($httpreferer, $_POST['httpreferer'], 'httpreferer')) { unset($httpreferer); }
if (!isset($_GET['timebegin_year']) || !setVar($timebegin_year, $_GET['timebegin_year'], 'timebegin_year')) { unset($timebegin_year); }
if (!isset($_GET['timebegin_month']) || !setVar($timebegin_month, $_GET['timebegin_month'], 'timebegin_month')) { unset($timebegin_month); }
if (!isset($_GET['timebegin_day']) || !setVar($timebegin_day, $_GET['timebegin_day'], 'timebegin_day')) { unset($timebegin_day); }

if (isset($_POST['cancel'])) {
	redirect2URL('update.php');
	exit;
};

if (!isset($httpreferer)) { $httpreferer = $_SERVER['HTTP_REFERER']; }

// read sponsor name from DB
$result =& DBQuery("
SELECT
	name,
	url
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");

// Output an error message if the query failed.
if (is_string($result)) {
	pageheader(lang('choose_template', false), '');
	contentsection_begin(lang('choose_template'));
	DBErrorBox('Could not read sponsor name from DB: ' . $result);
	contentsection_end();
	pagefooter();
	DBclose();
	exit;
}

$sponsor =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);

// test if any template exists already
$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_template
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");

// Output an error message if the query failed.
if (is_string($result)) {
	pageheader(lang('choose_template', false), '');
	contentsection_begin(lang('choose_template'));
	DBErrorBox('Could not test if template already exists: ' . $result);
	contentsection_end();
	pagefooter();
	DBclose();
	exit;
}

if ($result->numRows() == 0) {
	// reroute to input page
	$url = 'changeeinfo.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']);
	// if addevent was called by clicking on the icons in week or month view provide the date info
	if (isset($timebegin_year)) {
		$url .= '&templateid=0&timebegin_year=' . $timebegin_year .
		 '&timebegin_month=' . $timebegin_month . '&timebegin_day=' . $timebegin_day;
	}
	redirect2URL($url);
	exit;
}

$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_template
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	sponsorid='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");

// print page header
pageheader(lang('choose_template', false), '');
contentsection_begin('<label for="templateid">' . lang('choose_template') . '</label>');

// Output an error message if $result is a string.
if (is_string($result)) { DBErrorBox($result); }
else {
	// Otherwise, the query was successful.
	echo '
<form action="changeeinfo.php" method="post">
<input type="hidden" name="httpreferer" value="' . htmlspecialchars($httpreferer, ENT_COMPAT, 'UTF-8') . '" />';
	// forward date info, if the page was called with date info appended
	// can later be done with PHP session management
	if (isset($timebegin_year)) {
		echo '
<input type="hidden" name="timebegin_year" value="' . htmlspecialchars($timebegin_year, ENT_COMPAT, 'UTF-8') . '" />';
	}
	if (isset($timebegin_month)) {
		echo '
<input type="hidden" name="timebegin_month" value="' . htmlspecialchars($timebegin_month, ENT_COMPAT, 'UTF-8') . '" />';
	}
	if (isset($timebegin_day)) {
		echo '
<input type="hidden" name="timebegin_day" value="' . htmlspecialchars($timebegin_day, ENT_COMPAT, 'UTF-8') . '" />';
	}
	echo'
<p><select id="templateid" name="templateid" size="6">
<option value="0" selected="selected">-- ' . lang('blank', false) . ' --</option>';
	for ($i=0; $i < $result->numRows(); $i++) {
		$template =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo '<option value="' . htmlspecialchars($template['id'], ENT_COMPAT, 'UTF-8') . '">' .
		 htmlspecialchars($template['name'], ENT_COMPAT, 'UTF-8') . '</option>' . "\n";
	}
	echo '
</select></p>

<p><input type="submit" name="choosetemplate" value="' . htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;
<input type="submit" name="cancel" value="' . htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8') . '" /></p>

</form>';
}

contentsection_end();
pagefooter();
DBclose();
?>