<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

$status_message = '';
if ($_SESSION['AUTH_ISMAINADMIN']) {
	if (isset($_GET['debug']) && $_GET['debug'] == 'toggle') {
		if (isset($_SESSION['DEBUG']) && $_SESSION['DEBUG'] == 'true') {
			$_SESSION['DEBUG'] = 'false';
			unset($_SESSION['DEFAULT_LANGUAGE']); // kill default language data in session
		}
		else {
			$_SESSION['DEBUG'] = 'true';
			$tmp_array = $lang; // store base language array
			require('languages/' . LANGUAGE . '.inc.php'); // load selected default language
			$_SESSION['DEFAULT_LANGUAGE'] = $lang; // store default language in session
			$lang = $tmp_array; // reload selected language array
			$status_message = '
<p align="center"><strong>Translation Notation:</strong> Selected Language = <span style="color:#fefefe; background:#3c3 none;">{S{Text String}S}</span>, Default Language = <span style="color:#fefefe; background:#99f none;">{D{Text String}D}</span>, Missing Text = <span style="color:#c00; background:#ff0 none; font-weight:bold;">{X{text_string}X}</span>.</p>' . "\n";
		}
	}
}

pageheader(lang('update_calendar', false), 'Update');

echo '
<div id="UpdateBlock"><div style="border:1px solid ' . $_SESSION['COLOR_BORDER'] . ';">';
echo $status_message; // show 'one time' interpretation instructions for language highlighting

if (isset($_GET['fbid']) && !setVar($fbid, $_GET['fbid'])) { unset($fbid); }
if (isset($_GET['fbparam']) && !setVar($fbparam, $_GET['fbparam'])) { unset($fbparam); }
if (isset($fbid) && isset($fbparam)) {
	$startHTML = '
<div class="NotificationBG pad" style="border-bottom:1px solid ' . $_SESSION['COLOR_BORDER'] . ';">';
	$endHTML = '</div>';
	if ($fbid == 'eaddsuccess' && !$_SESSION['AUTH_ISCALENDARADMIN']) {
		echo $startHTML;
		feedback(lang('new_event_submitted_notice') . ' ' . urldecode('"' . $fbparam . '"'), FEEDBACKPOS);
		echo $endHTML;
	}
	elseif ($fbid == 'eupdatesuccess' && !$_SESSION['AUTH_ISCALENDARADMIN'] ) {
		echo $startHTML;
		feedback(lang('updated_event_submitted_notice') . ' ' . urldecode('"' . $fbparam . '"'), FEEDBACKPOS);
		echo $endHTML;
	}
	elseif ($fbid == 'urlchangesuccess') {
		echo $startHTML;
		feedback(lang('hompage_changed_notice') . ' ' . urldecode('"' . $fbparam . '"'), FEEDBACKPOS);
		echo $endHTML;
	}
	elseif ($fbid == 'emailchangesuccess') {
		echo $startHTML;
		feedback(lang('email_changed_notice') . ' ' . urldecode('"' . $fbparam . '"'), FEEDBACKPOS);
		echo $endHTML;
	}
}

echo '
<table id="UpdateMainMenu" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr>

<!-- Sponsor Column -->
<td>
<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . ';">' . lang('event_options_header').  ':</h2>

<dl>

<dt><a href="addevent.php">' . lang('add_new_event') . '</a></dt>
<dd>' . lang('add_event_description') . '</dd>

<dt><a href="manageevents.php">' . lang('manage_events') . '</a></dt>
<dd>' . lang('manage_event_description') . '</dd>

<dt><a href="managetemplates.php">' . lang('manage_templates') . '</a></dt>
<dd>' . lang('manage_template_description') . '</dd>

</dl>

<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . ';">' . lang('backup_header') . ':</h2>

<dl>

<dt><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=export">' . lang('export_events') . '</a></dt>
<dd>' . lang('export_events_description') . '</dd>

<dt><a href="import.php">' . lang('import_events') . '</a></dt>
<dd>' . lang('import_events_description') . '</dd>

</dl>

<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . '">' . lang('options_for') . ' ' . htmlspecialchars($_SESSION['AUTH_SPONSORNAME'], ENT_COMPAT, 'UTF-8') . ':</h2>

<dl>

<dt><a href="changehomepage.php">' . lang('change_homepage') . '</a></dt>
<dd>' . lang('change_homepage_description') . '</dd>

<dt><a href="changeemail.php">' . lang('change_email') . '</a></dt>
<dd>' . lang('change_email_description') . '</dd>

</dl>';

if ($_SESSION['AUTH_LOGINSOURCE'] == 'DB' && strlen($_SESSION['AUTH_USERID']) > strlen(AUTH_DB_USER_PREFIX) &&
 substr($_SESSION['AUTH_USERID'], 0, strlen(AUTH_DB_USER_PREFIX)) == AUTH_DB_USER_PREFIX) {
	echo '
<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . '">' . lang('options_for') . ': <strong>' . $_SESSION['AUTH_USERID'] . '</strong></h2>

<dl>

<dt><a href="changeuserpassword.php">' . lang('change_password_of_user') . '</a></dt>
<dd> ' . lang('change_password_of_user_description') . '</dd>

</dl>';
}
echo '</td><!-- End Sponsor Column -->';

if ($_SESSION['AUTH_ISCALENDARADMIN']) {
	echo '
<td class="bgLight" style="border-left:1px solid ' . $_SESSION['COLOR_BORDER'] . '">
<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . ';">' . lang('calendar_options') . ':</h2>

<dl>

<dt><a href="approval.php">' . lang('approve_reject_event_updates') . '</a></dt>
<dd>' . lang('approve_reject_event_updates_description') . '</dd>

</dl>

<dl>

<dt style="border-top:1px dotted ' . $_SESSION['COLOR_BORDER'] . '"><a href="managesponsors.php">' . lang('manage_sponsors') . '</a></dt>
<dd>' . lang('manage_sponsors_description') . '</dd>

<dt><a href="deleteinactivesponsors.php">' . lang('delete_inactive_sponsors') . '</a></dt>
<dd>' . lang('delete_inactive_sponsors_description') . '</dd>

</dl>

<dl>

<dt style="border-top: 1px dotted ' . $_SESSION['COLOR_BORDER'] . '"><a href="changecalendarsettings.php">' . lang('change_header_footer_auth') . '</a></dt>
<dd>' . lang('change_header_footer_auth_description') . '</dd>

<dt><a href="changecolors.php">' . lang('change_colors') . '</a></dt>
<dd>' . lang('change_colors_description') . '</dd>

</dl>

<dl>

<dt style="border-top:1px dotted ' . $_SESSION['COLOR_BORDER'] . '"><a href="manageeventcategories.php">' . lang('manage_event_categories') . '</a></dt>
<dd>' . lang('manage_event_categories_description') . '</dd>

</dl>

<dl>

<dt style="border-top:1px dotted ' . $_SESSION['COLOR_BORDER'] . '"><a href="managesearchkeywords.php">' . lang('manage_search_keywords') . '</a></dt>
<dd>' . lang('manage_search_keywords_description') . '</dd>

<dt><a href="managefeaturedsearchkeywords.php">' . lang('manage_featured_search_keywords') . '</a></dt>
<dd>' . lang('manage_featured_search_keywords_description') . '</dd>

<dt><a href="viewsearchlog.php">' . lang('view_search_log') . '</a></dt>
<dd>' . lang('view_search_log_description') . '</dd>

</dl>
</td>';
}

if ($_SESSION['AUTH_ISMAINADMIN']) {
	echo '
<td' . (!$_SESSION['AUTH_ISCALENDARADMIN']? ' class="bgLight"' : '') . ' style="border-left:1px solid ' . $_SESSION['COLOR_BORDER'] . ';">
<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . ';">' . lang('main_administrators_options') . ':</h2>

<dl>';

	if (AUTH_DB) {
		echo '
<dt><a href="manageusers.php">' . lang('manage_users') . '</a> ' . AUTH_DB_NOTICE . '</dt>
<dd>' . lang('manage_users_description') . '</dd>' . "\n";
	}
	echo '
<dt><a href="managecalendars.php">' . lang('manage_calendars') . '</a></dt>
<dd>' . lang('manage_calendars_description') . '</dd>

<dt><a href="managelanguages.php">' . lang('manage_language_files') . '</a></dt>
<dd>' . lang('manage_language_files_description') . '</dd>

<dt><a href="managemainadmins.php">' . lang('manage_main_admins') . '</a></dt>
<dd>' . lang('manage_main_admins_description') . '</dd>

<dt><a href="update.php?debug=toggle">' . ((isset($_SESSION['DEBUG']) && $_SESSION['DEBUG'] == 'true')? lang('debug_disable') : lang('debug_enable')) . '</a></dt>
<dd>' . lang('debug_description') . '</dd>

</dl>

<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . ';">' . lang('community') . ':</h2>

<p>' . lang('external_resources') . ':</p>

<ul>
<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=docs">' . lang('external_resources_docs') . '</a></li>
<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=vtcalendar-announce">' . lang('external_resources_announce') . '</a></li>
<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=forums">' . lang('external_resources_forums') . '</a></li>
<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=bugs">' . lang('external_resources_bugs') . '</a></li>
</ul>

<h2 style="border-color: ' . $_SESSION['COLOR_BORDER'] . ';"> ' . lang('version_check') . ':</h2>

<div style="padding-top:10px;" id="VersionResult">&nbsp;</div>

<script type="text/javascript">/* <![CDATA[ */
function CheckVersionHandler(image, messageHTML, tableHTML)
{
	document.getElementById("VersionResult").innerHTML = tableHTML;
}
/* ]]> */</script>

<iframe src="checkversion.php" width="1" height="1" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</td>';
}
echo '</tr></tbody>
</table></div>

</div><!-- #UpdateBlock -->' . "\n";

pagefooter();
DBclose();
?>