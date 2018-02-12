<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN'] ) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['check']) || !setVar($check, $_POST['check'], 'check')) { unset($check); }
if (!isset($_POST['new']) || !setVar($new, $_POST['new'], 'check')) {
	if (!isset($_GET['new']) || !setVar($new, $_GET['new'], 'check')) { unset($new); }
}
if (isset($_GET['cal'])) {
	unset($cal); // Unset cal since we want nothing set but the id.
	if (!isset($_GET['cal']['id']) || !setVar($cal['id'], $_GET['cal']['id'], 'calendarid')) { unset($cal['id']); }
}
elseif (isset($_POST['cal'])) {
	if (!isset($_POST['cal']['id']) || !setVar($cal['id'], $_POST['cal']['id'], 'calendarid')) { unset($cal['id']); }
	if (!isset($_POST['cal']['name']) || !setVar($cal['name'], $_POST['cal']['name'], 'calendarname')) { unset($cal['name']); }
	if (!isset($_POST['cal']['language']) || !setVar($cal['language'], $_POST['cal']['language'], 'calendarlanguage')) { unset($cal['language']); }
	if (!isset($_POST['cal']['admins']) || !setVar($cal['admins'], $_POST['cal']['admins'], 'users')) { unset($cal['admins']); }
	if (!isset($_POST['cal']['forwardeventdefault']) || !setVar($cal['forwardeventdefault'], $_POST['cal']['forwardeventdefault'], 'forwardeventdefault')) { unset($cal['forwardeventdefault']); }
}
else { unset($cal); }

if (isset($cancel)) {
	redirect2URL('managecalendars.php');
	exit;
}

function checkcalendar(&$cal)
{
	return (!empty($cal['id']) && !empty($cal['name']));
}

$calendarexists = false;
$addPIDError = '';
if (isset($save) && checkcalendar($cal) ) {
	$query = "
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_calendar
WHERE
	id='" . sqlescape($cal['id']) . "'
";
	if (is_string($result =& DBQuery($query))) {
		DBErrorBox('Error determining if calendar already exists: ' . $result);
		exit;
	}

	if (!isset($cal['forwardeventdefault']) || $cal['forwardeventdefault'] != '1') {
		$cal['forwardeventdefault'] = '0';
	}
	if (isset($new)) {
		$calendarexists = $result->numRows() > 0;
		$result->free();
		if (!$calendarexists) {
			$result->free();
			// create new calendar
			$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_calendar
	(
		id,
		name,
		title,
		language,
		header,
		htmlheader,
		footer,
		viewauthrequired,
		forwardeventdefault
	)
VALUES
	(
		'" . sqlescape($cal['id']) . "',
		'" . sqlescape($cal['name']) . "',
		'',
		'" . sqlescape($cal['language']) . "',
		'',
		'',
		'',
		'0',
		'" . sqlescape($cal['forwardeventdefault']) . "'
	)
";
			if (is_string($result =& DBQuery($query))) {
				DBErrorBox('Error creating calendar: ' . $result);
				exit;
			}

			$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_sponsor
	(
		calendarid,
		name,
		email,
		url,
		admin
	)
VALUES
	(
		'" . sqlescape($cal['id']) . "',
		'" . sqlescape(lang('default_sponsor_name', false)) . "',
		'',
		'" . sqlescape(BASEURL . $cal['id']) . "/',
		'1'
	)
";
			if (is_string($result =& DBQuery($query))) {
				DBErrorBox('Error creating default sponsor: ' . $result);
				exit;
			}

			// Create a default category
			$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_category
	(
		calendarid,
		name
	)
VALUES
	(
		'" . sqlescape($cal['id']) . "',
		'" . sqlescape(lang('default_category_name', false)) . "'
	)
";
			if (is_string($result =& DBQuery($query))) {
				DBErrorBox('Error creating default category: ' . $result);
				exit;
			}
		}
	}
	else {
		// update existing calendar
		$query = "
UPDATE
	" . SCHEMANAME . "vtcal_calendar
SET
	name='" . sqlescape($cal['name']) . "',
	language='" . sqlescape($cal['language']) . "',
	forwardeventdefault='" . sqlescape($cal['forwardeventdefault']) . "'
WHERE
	id='" . sqlescape($cal['id']) . "'
";
		if (is_string($result =& DBQuery($query))) {
			DBErrorBox('Error updating calendar: ' . $result);
			exit;
		}
	}

	if (!$calendarexists) {
		// check validity of cal-admins
		$pidsAdded = array();

		if (!empty($cal['admins'])) {
			// disassemble the admins string and check all PIDs against the DB
			$pidsInvalid = '';
			$pidsTokens = split("[ ,;\n\t]", $cal['admins']);
			$pidsAddedCount = 0;
			for ($i=0; $i < count($pidsTokens); $i++) {
				$pidName = $pidsTokens[$i];
				$pidName = trim($pidName);
				if (!empty($pidName)) {
					if (isvaliduser($pidName)) {
						$pidsAdded[$pidsAddedCount] = $pidName;
						$pidsAddedCount++;
					}
					else {
						if (!empty($pidsInvalid)) { $pidsInvalid .= ','; }
						$pidsInvalid .= $pidName;
					}
				}
			}
			// feedback message(s)
			if (!empty($pidsInvalid)) {
				if (strpos($pidsInvalid, ',') > 0) { // more than one user-ID
					$addPIDError = lang('user_ids_invalid') . ' &quot;' . $pidsInvalid . '&quot;';
				}
				else {
					$addPIDError = lang('user_id_invalid') . ' &quot;' . $pidsInvalid . '&quot;';
				}
			}
		}

		if (empty($addPIDError)) {
			// determine the id of sponsor "Administration"
			$query = "
SELECT
	id
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($cal['id']) . "'
	AND
	admin='1'
";
			if (is_string($result =& DBQuery($query))) {
				DBErrorBox('Error determining ID of admin sponsor: ' . $result);
				exit;
			}
			$s =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
			$administrationId = $s['id'];
			$result->free();

			// substitute existing auth info with the new one
			$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_auth
WHERE
	calendarid='" . sqlescape($cal['id']) . "'
	AND
	sponsorid='" . sqlescape($administrationId) . "'
";
			if (is_string($result =& DBQuery($query))) {
				DBErrorBox('Error deleting users from admin sponsor: ' . $result);
				exit;
			}

			for ($i=0; $i < count($pidsAdded); $i++) {
				$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_auth
	(
		calendarid,
		userid,
		sponsorid
	)
VALUES
	(
		'" . $cal['id'] . "',
		'" . $pidsAdded[$i] . "',
		'" . $administrationId . "'
	)
";
				if (is_string($result =& DBQuery($query))) {
					DBErrorBox('Error adding user to admin sponsor: ' . $result);
					exit;
				}
			}

			redirect2URL('managecalendars.php');
			exit;
		}
	}
}

if (isset($cal['id'])) {
	pageheader(lang('edit_calendar', false), 'Update');
	contentsection_begin(lang('edit_calendar'));
	if (!isset($check)) {
		$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_calendar
WHERE
	id='" . sqlescape($cal['id']) . "'
");
		if (is_string($result)) {
			DBErrorBox('Error retrieving calendar info: ' . $result);
			contentsection_end();
			pagefooter();
			DBclose();
			exit;
		}
		else {
			$cal = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
			$result->free();
		}
	}
}
else {
	pageheader(lang('add_new_calendar', false), 'Update');
	contentsection_begin(lang('add_new_calendar'));
}
?>

<form action="editcalendar.php" method="post">
<input type="hidden" name="check" value="1" />
<?php if (isset($new)) { echo '<input type="hidden" name="new" value="1" />' . "\n"; } ?>

<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>

<td><?php echo (isset($new)? '<label for="calid">' : '') . lang('calendar_id') . (isset($new)? '</label>' : ''); ?>: <span class="txtWarn">*</span></td>
<td><?php
if (isset($check)) {
	if (empty($cal['id']) || !isValidInput($cal['id'], 'calendarid')) {
		feedback(lang('choose_valid_calendar_id') . ' ' . constCalendaridVALIDMESSAGE, FEEDBACKNEG);
	}
	elseif ($calendarexists) {
		feedback(lang('calendar_already_exists'), FEEDBACKNEG);
	}
}
if (isset($new)) {
	echo '<input type="text" id="calid" name="cal[id]" value="';
	if (isset($check)) { $cal['id'] = stripslashes($cal['id']); }
	if (isset($cal['id'])) { echo htmlspecialchars($cal['id'], ENT_COMPAT, 'UTF-8'); }
	echo '" size="20" maxlength="' . MAXLENGTH_CALENDARID . '" />
<i>' . lang('calendar_id_example') . '</i>';
}
else {
	echo '<input type="hidden" name="cal[id]" value="' . htmlspecialchars($cal['id'], ENT_COMPAT, 'UTF-8') . '" /><b>' . $cal['id'] . '</b>' . "\n";
}
?></td>

</tr><tr>

<td><label for="calname"><?php echo lang('calendar_name'); ?>:</label> <span class="txtWarn">*</span></td>
<td><?php
if (isset($check)) {
	if (empty($cal['name']) || !isValidInput($cal['name'], 'calendarname')) {
		feedback(lang('choose_valid_calendar_name') . ' ' . constCalendarnameVALIDMESSAGE, FEEDBACKNEG);
	}
}
echo '<input type="text" id="calname" name="cal[name]" value="';
if (isset($check)) { $cal['name'] = stripslashes($cal['name']); }
if (isset($cal['name'])) { echo htmlspecialchars($cal['name'], ENT_COMPAT, 'UTF-8'); }
echo '" size="50" maxlength="' . MAXLENGTH_CALENDARNAME . '" />
<i>' . lang('calendar_name_example') . '</i>';
?></td>

</tr><tr>

<td><label for="callanguage"><?php echo lang('language'); ?>:</label></td>
<td><?php
if (isset($check)) {
	if (empty($cal['language']) || !isValidInput($cal['language'], 'calendarlanguage')) {
		echo 'language missing<br />';
	}
}
?><select id="callanguage" name="cal[language]"><?php
if ($dh = opendir('languages')) { // PHP4 compatable directory read
	while (($file = readdir($dh)) !== false) {
		if (preg_match("|^(.*)\.inc\.php$|", $file, $matches)) { $languages[] = $matches[1]; }
	}
	closedir($dh);
}
if (isset($languages) && count($languages) > 0) {
	foreach ($languages as $language) {
		$sel = ((isset($cal['name']) && $language == $cal['language']) ||
		 (!isset($cal['name']) && $language == LANGUAGE))? ' selected="selected"' : '';
	    echo '<option value="' . $language . '"' . $sel . '>' . mb_strtoupper($language, 'UTF-8') . '</option>', "\n";
	}
}
else { echo '<option value="en">EN</option>' . "\n"; }
?></select></td>

</tr><tr>

<td><label for="caladmins"><?php echo lang('administrators'); ?></label></td>
<td><?php
if (!empty($addPIDError)) { feedback($addPIDError, 1); }
echo '<textarea id="caladmins" name="cal[admins]" cols="40" rows="3">';
if (isset($cal['admins'])) { echo htmlspecialchars($cal['admins'], ENT_COMPAT, 'UTF-8'); }
elseif (isset($cal['id'])) {
	// determine the automatically generated sponsor-id
	$result = DBQuery("
SELECT
	id
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($cal['id']) . "'
	AND
	admin='1'
");
	$s = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	$administrationId = $s['id'];
	$result->free();
	$query = "
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_auth
WHERE
	calendarid='" . sqlescape($cal['id']) . "'
	AND
	sponsorid='" . sqlescape($administrationId) . "'
ORDER BY
	userid
";
		$result = DBQuery($query);
		$i = 0;
		while ($i < $result->numRows()) {
			$authorization = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo (($i++ > 0)? ',' : '') . htmlspecialchars($authorization['userid'], ENT_COMPAT, 'UTF-8');
		}
		$result->free();
	}
	echo '</textarea><br />
<i>' . lang('administrators_example') . '</i>';
?></td>

</tr><?php if (!isset($cal['id']) || $cal['id'] != 'default') { ?><tr>

<td>&nbsp;</td>
<td><?php
$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_calendar
WHERE
	id='default'
");
$c = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
$defaultcalendarname = $c['name'];
?><table border="0">
<tbody><tr>
<td><input type="checkbox" id="forwardeventdefault" name="cal[forwardeventdefault]" value="1"<?php if (isset($cal['forwardeventdefault']) && $cal['forwardeventdefault'] == '1') { echo ' checked="checked"'; } ?> /></td>
<td><label for="forwardeventdefault"><?php echo lang('also_display_on_calendar_message') . ' ' . $defaultcalendarname ?></label><br />
<?php echo lang('also_display_on_calendar_notice'); ?></td>
</tr></tbody>
</table></td>
</tr><?php } ?><tr>
<td>&nbsp;</td>
<td><p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" /></p></td>

</tr></tbody>
</table>

</form>

<?php
contentsection_end();
pagefooter();
DBclose();
?>