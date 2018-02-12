<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['cancel']) || !setVar($cancel, $_POST['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_POST['save']) || !setVar($save, $_POST['save'], 'save')) { unset($save); }
if (!isset($_POST['users']) || !setVar($users, $_POST['users'], 'users')) { unset($users); }
if (!isset($_POST['title']) || !setVar($title, $_POST['title'], 'calendarTitle')) { unset($title); }
if (!isset($_POST['header']) || !setVar($header, $_POST['header'], 'calendarHeader')) { unset($header); }
if (!isset($_POST['htmlheader']) || !setVar($htmlheader, $_POST['htmlheader'], 'calendarHTMLHeader')) { unset($htmlheader); }
if (!isset($_POST['footer']) || !setVar($footer, $_POST['footer'], 'calendarFooter')) { unset($footer); }
if (!isset($_POST['viewauthrequired']) || !setVar($viewauthrequired, $_POST['viewauthrequired'], 'viewauthrequired')) { unset($viewauthrequired); }
if (!isset($_POST['forwardeventdefault']) || !setVar($forwardeventdefault, $_POST['forwardeventdefault'], 'forwardeventdefault')) { unset($forwardeventdefault); }

if (isset($cancel)) {
	redirect2URL('update.php');
	exit;
};

// Re-read the settings from the DB if one of the required fields was not set.
if (!(isset($title) && isset($header) && isset($htmlheader) &&
 isset($footer) && isset($viewauthrequired))) {
	$title = $_SESSION['CALENDAR_TITLE'];
	$header = $_SESSION['CALENDAR_HEADER'];
	$language = $_SESSION['CALENDAR_LANGUAGE'];
	$htmlheader = $_SESSION['CALENDAR_HTMLHEADER'];
	$footer = $_SESSION['CALENDAR_FOOTER'];
	$viewauthrequired = $_SESSION['CALENDAR_VIEWAUTHREQUIRED'];
	$forwardeventdefault = $_SESSION['CALENDAR_FORWARD_EVENT_BY_DEFAULT'];
}

$addPIDError = '';
$pidsAddedCount = 0;
if (isset($save)) {
	// check validity of users
	if (!empty($users)) {
		// disassemble the users string and check all PIDs against the DB
		$pidsInvalid = '';
		$pidsTokens = split("[ ,;\n\t]", $users);
		$pidsAdded = array();
		for ($i=0; $i < count($pidsTokens); $i++) {
			$pidName = $pidsTokens[$i];
			$pidName = trim($pidName);
			if (!empty($pidName)) {
				if (isValidUser($pidName)) {
					$pidsAdded[$pidsAddedCount] = $pidName;
					$pidsAddedCount++;
				}
				else {
					if (!empty($pidsInvalid)) { $pidsInvalid .= ', '; }
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
		// save the settings to database
		if (!isset($forwardeventdefault) || $forwardeventdefault != '1') { $forwardeventdefault = '0'; }
		$result =& DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_calendar
SET
	title='" . sqlescape($title) . "',
	header='" . sqlescape($header) . "',
	htmlheader='" . sqlescape($htmlheader) . "',
	footer='" . sqlescape($footer) . "',
	viewauthrequired='" . sqlescape($viewauthrequired) . "',
	forwardeventdefault='" . sqlescape($forwardeventdefault) . "'
WHERE
	id='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
");
		if (is_string($result)) { DBErrorBox($result); exit; }
		// substitute existing auth info with the new one
		$result =& DBQuery("
DELETE FROM
	" . SCHEMANAME . "vtcal_calendarviewauth
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
");
		if (is_string($result)) {
			DBErrorBox($result);
			exit;
		}
		for ($i=0; $i < $pidsAddedCount; $i++) {
			$result =& DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_calendarviewauth
	(
		calendarid,
		userid
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape($pidsAdded[$i]) . "'
	)
");
			if (is_string($result)) {
				DBErrorBox($result);
				exit;
			}
		}
		setCalendarPreferences();
		redirect2URL('update.php');
		exit;
	}
}

// read sponsor name from DB
$result =& DBQuery("
SELECT
	name
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
");
if (is_string($result)) {
	DBErrorBox($result);
	exit;
}
$sponsor =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
pageheader(lang('change_header_footer_auth', false), 'Update');
contentsection_begin(lang('change_header_footer_auth'));
?>

<form name="globalSettings" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" /></p>

<p><label for="title"><strong><?php echo lang('calendar_title'); ?>:</strong></label>
<span class="greyed"><?php echo lang('empty_or_any_text'); ?></span><br />
<input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title, ENT_COMPAT, 'UTF-8'); ?>" size="30" maxlength="<?php echo MAXLENGTH_CALENDARTITLE; ?>" /></p>

<p><label for="htmlheader"><strong><?php echo lang('htmlheader_html'); ?>:</strong></label>
<span class="greyed"><?php echo lang('empty_or_any_html'); ?></span><br />
<?php echo lang('htmlheader_html_description'); ?><br />
<textarea id="htmlheader" name="htmlheader" cols="70" rows="10" style="width:99%;"><?php echo htmlspecialchars($htmlheader, ENT_COMPAT, 'UTF-8'); ?></textarea></p>

<p><label for="header"><strong><?php echo lang('header_html'); ?>:</strong></label>
<span class="greyed"><?php echo lang('empty_or_any_html'); ?></span><br />
<textarea id="header" name="header" cols="70" rows="10" class="tinymce" style="width:99%;"><?php echo htmlspecialchars($header, ENT_COMPAT, 'UTF-8'); ?></textarea></p>

<p><label for="footer"><strong><?php echo lang('footer_html'); ?>:</strong></label>
<span class="greyed"><?php echo lang('empty_or_any_html'); ?></span><br />
<textarea id="footer" name="footer" cols="70" rows="10" class="tinymce" style="width:99%;"><?php echo htmlspecialchars($footer, ENT_COMPAT, 'UTF-8'); ?></textarea></p>

<?php
if ($_SESSION['CALENDAR_ID'] != 'default') {
	$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_calendar
WHERE
	id='default'
");
	if (is_string($result)) {
		DBErrorBox($result);
	}
	else {
		$c =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
		$defaultcalendarname = $c['name'];
?>
<table border="0" cellspacing="0" cellpadding="5">
<tbody><tr>
<td><input type="checkbox" id="forwardeventdefault" name="forwardeventdefault" value="1"<?php if ($forwardeventdefault == '1') { echo ' checked="checked"'; } ?> /></td>
<td><label for="forwardeventdefault"><strong><?php echo lang('forward_event_default') . ' ' . $defaultcalendarname; ?></strong></label><br />
<?php echo lang('forward_event_default_disable'); ?></td>
</tr></tbody>
</table><br />
<?php
	}
}
?>

<p><b><?php echo lang('login_required_for_viewing'); ?></b></p>

<table border="0" cellspacing="0" cellpadding="5">
<tbody><tr>
<td><input type="radio" id="viewauthrequired0" name="viewauthrequired" value="0"<?php if ($viewauthrequired == 0) { echo ' checked="checked"'; } ?> /></td>
<td><label for="viewauthrequired0"><?php echo lang('no_login_required'); ?></label></td>
</tr><tr>
<td><input type="radio" id="viewauthrequired2" name="viewauthrequired" value="2"<?php if ($viewauthrequired == 2) { echo ' checked="checked"'; } ?> /></td>
<td><label for="viewauthrequired2"><?php echo lang('login_required_any_login'); ?></label></td>
</tr><tr>
<td><input type="radio" id="viewauthrequired1" name="viewauthrequired" value="1"<?php if ($viewauthrequired == 1) { echo ' checked="checked"'; } ?> /></td>
<td><label for="viewauthrequired1"><?php echo lang('login_required_user_ids'); ?>:</label><br />
<?php
if (!empty($addPIDError)) { feedback($addPIDError, 1); }
if (isset($users)) {
	echo '<textarea name="users" cols="40" rows="6">' . htmlspecialchars($users, ENT_COMPAT, 'UTF-8') . '</textarea><br />' . "\n";
}
else {
	$query = "
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_calendarviewauth
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	userid
";
	$result =& DBQuery($query );
	if (is_string($result)) {
		DBErrorBox($result);
	}
	else {
		echo '<textarea name="users" cols="40" rows="6">';
		$i = 0;
		while ($i < $result->numRows()) {
			$viewauth =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo (($i++ > 0)? ',' : '') . htmlspecialchars($viewauth['userid'], ENT_COMPAT, 'UTF-8');
		}
		echo '</textarea><br />' . "\n";
	}
}
?>
<i><?php echo lang('separate_user_ids'); ?></i></td>
</tr></tbody>
</table>

<p><input type="submit" name="save" value="<?php echo htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" class="button" /></p>

</form>

<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">/* <![CDATA[ */
$(document).ready(function() {
	$("textarea.tinymce").tinymce({
		// Location of TinyMCE script
		script_url: "scripts/tiny_mce/tiny_mce.js",

		// Specify current document language
		language: "<?php echo lang('lang', false); ?>",

		// General options
		theme: "advanced",
		plugins: "safari,pagebreak,style,table,advhr,advimage,advlink," +
		 "emotions,iespell,inlinepopups,insertdatetime,media,searchreplace," +
		 "contextmenu,paste,directionality,fullscreen,noneditable,visualchars," +
		 "nonbreaking,xhtmlxtras",

		// Theme options
		theme_advanced_buttons1: "fullscreen,visualaid,|,search,replace,|," +
		 "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,bold,italic,underline," +
		 "strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|," +
		 "bullist,numlist,outdent,indent,|,backcolor,forecolor",
		theme_advanced_buttons2: "formatselect,fontselect,fontsizeselect,attribs," +
		 "styleprops,|,sub,sup,|,charmap,emotions,iespell,media,advhr,hr,|,link," +
		 "unlink,anchor,image,cleanup,removeformat,code",
		theme_advanced_buttons3: "tablecontrols,|,blockquote,cite,abbr,acronym,del,ins,|," +
		 "ltr,rtl,|,visualchars,nonbreaking,|,insertdate,inserttime,|,help",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
		theme_advanced_resizing: true,

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url: "lists/link_list.js",
		//external_image_list_url: "lists/image_list.js",
		//media_external_list_url: "lists/media_list.js",

		// Replace values for the template plugin
		//template_replace_values: { username: "Some User", staffid: "991234" }
	});
});
/* ]]> */</script>
<?php
contentsection_end();
pagefooter();
DBclose();
?>