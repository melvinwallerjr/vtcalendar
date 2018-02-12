<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

// ================================
// Display input form
// ================================

if (isset($eventid)) {
	if (isset($copy) && $copy == 1) {
		pageheader(lang('copy_event', false), 'Update');
		echo '<input type="hidden" name="copy" value="' . $copy . '" />' . "\n";
	}
	else {
		pageheader(lang('update_event', false), 'Update');
	}
}
else {
	pageheader(lang('add_new_event', false), 'Update');
}

// Preset event with defaults if the form has not yet been submitted.
if (!isset($check)) { defaultevent($event, $_SESSION['AUTH_SPONSORID']); }

// Load template if necessary
if (isset($templateid)) {
	if ($templateid > 0) {
		$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_template
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($templateid) . "'
");
		$event = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	}
}

// "add new event" was started from week,month or detail view.
if (isset($timebegin_year)) { $event['timebegin_year'] = $timebegin_year; }
if (isset($timebegin_month)) { $event['timebegin_month'] = $timebegin_month; }
if (isset($timebegin_day)) { $event['timebegin_day'] = $timebegin_day; }

// Load event to update information if it's the first time the form is viewed.
if (isset($eventid) && (!isset($check) || $check != 1)) {
	$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
");

	// Event exists in "vtcal_event".
	if ($result->numRows() > 0) { $event = $result->fetchRow(DB_FETCHMODE_ASSOC, 0); }
	// For some reason the event is not in "vtcal_event" (even though it should be).
	// Try to load it from "event_public".
	else {
		$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
");

		// Event exists in "event_public".
		// Insert into "vtcal_event" since it is missing.
		if ($result->numRows() > 0) {
			$event = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
			//eventaddslashes($event);
			insertintoevent($event['id'], $event);
		}
	}

	disassemble_timestamp($event);
	if (!empty($event['repeatid'])) { readinrepeat($event['repeatid'], $event, $repeat); }
	else { $repeat['mode'] = 0; }
	//$sponsorid = $event[sponsorid];
}

contentsection_begin(lang('input_event_information'));

echo '
<form name="inputevent" action="changeeinfo.php" method="post">';
inputeventbuttons($httpreferer);

if (!isset($check)) { $check = 0; }
inputeventdata($event, $event['sponsorid'], 1, $check, 1, $repeat, $copy);
echo '
<input type="hidden" name="httpreferer" value="' . htmlspecialchars($httpreferer, ENT_COMPAT, 'UTF-8') . '" />';
if (isset($eventid)) { echo '
<input type="hidden" name="eventid" value="' . htmlspecialchars($event['id'], ENT_COMPAT, 'UTF-8') . '" />'; }
echo '
<input type="hidden" name="event[repeatid]" value="' .
 (isset($event['repeatid'])? htmlspecialchars($event['repeatid'], ENT_COMPAT, 'UTF-8') : '') . '" />';
if (!$_SESSION['AUTH_ISCALENDARADMIN']) {
	echo '
<input type="hidden" name="event[sponsorid]" value="' . htmlspecialchars($event['sponsorid'], ENT_COMPAT, 'UTF-8') . '" />';
}
if (isset($copy)) { echo '
<input type="hidden" name="copy" value="' . htmlspecialchars($copy, ENT_COMPAT, 'UTF-8') . '" />'; }

inputeventbuttons($httpreferer);
echo '
</form>';

contentsection_end();

function inputeventbuttons($httpreferer)
{
?>
<p><input type="submit" name="preview" value="<?php echo htmlspecialchars(lang('preview_event', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" onclick="location.href='<?php echo htmlspecialchars($httpreferer, ENT_COMPAT, 'UTF-8'); ?>';return false;" /></p>
<?php
}
?>