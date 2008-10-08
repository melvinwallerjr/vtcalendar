<?php
require_once('application.inc.php');

if (!authorized()) { exit; }

pageheader(lang('update_calendar'), "Update");

?>

<!-- Start Link Table -->
<div id="UpdateBlock"><div style="border: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;">

<?php
if (isset($_GET['fbid'])) { $fbid = $_GET['fbid']; } else { unset($fbid); }
if (isset($_GET['fbparam'])) { $fbparam = $_GET['fbparam']; } else { unset($fbparam); }
if ( isset($fbid) ) {
	$startHTML = '<div class="NotificationBG" style="padding: 8px; border-bottom: 1px solid '.$_SESSION['COLOR_BORDER'].';">';
	$endHTML = '</div>';
	if ($fbid=="eaddsuccess" && !$_SESSION['AUTH_ISCALENDARADMIN']) {
		echo $startHTML;
		feedback(lang('new_event_submitted_notice')." ".stripslashes(urldecode("\"$fbparam\"")),FEEDBACKPOS);
		echo $endHTML;
	}
	elseif ($fbid=="eupdatesuccess" && !$_SESSION['AUTH_ISCALENDARADMIN'] ) {
		echo $startHTML;
		feedback(lang('updated_event_submitted_notice')." ".stripslashes(urldecode("\"$fbparam\"")),FEEDBACKPOS);
		echo $endHTML;
	}
	elseif ($fbid=="urlchangesuccess") {
		echo $startHTML;
		feedback(lang('hompage_changed_notice')." ".stripslashes(urldecode("\"$fbparam\"")),FEEDBACKPOS);
		echo $endHTML;
	}
	elseif ($fbid=="emailchangesuccess") {
		echo $startHTML;
		feedback(lang('email_changed_notice')." ".stripslashes(urldecode("\"$fbparam\"")),FEEDBACKPOS);
		echo $endHTML;
	}
}
?>

<table id="UpdateMainMenu" cellspacing="0" cellpadding="10" border="0">
<tr>
	
	<!-- Start Sponsor Level Column -->
	<td valign="top">
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;">Event Options:</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><a href="addevent.php"><?php echo lang('add_new_event'); ?></a></dt>
				<dd>Add a new event to the calendar.</dd>
				<dt><a href="manageevents.php"><?php echo lang('manage_events'); ?></a></dt>
				<dd style="padding-bottom: 4px;">View events that have been submitted, and see if they have been approved.</dd>
				<dt><a href="managetemplates.php"><?php echo lang('manage_templates'); ?></a></dt>
				<dd style="padding-bottom: 4px;">Create templates to easily add new events with similar information.</dd>
			</dl>
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;">Backup &amp; Restore:</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><a href="main.php?calendarid=<?php echo urlencode($_SESSION['CALENDAR_ID']); ?>view=export"><?php echo lang('export_events'); ?></a></dt>
				<dd>Export events to a file you can save on your computer as a backup, or to transfer to another calendar.</dd>
				<dt><a href="import.php"><?php echo lang('import_events'); ?></a></dt>
				<dd>Import an XML file that contains events as a batch.</dd>
			</dl>
		
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>; padding-top: 8px;"><?php echo htmlentities($_SESSION["AUTH_SPONSORNAME"]); ?> Options:&nbsp;</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><a href="changehomepage.php"><?php echo lang('change_homepage'); ?></a></dt>
				<dd>Change the default homepage address for &quot;<?php echo htmlentities($_SESSION["AUTH_SPONSORNAME"]); ?>&quot;.</dd>
				<dt><a href="changeemail.php"><?php echo lang('change_email'); ?></a></dt>
				<dd>Change the default e-mail for &quot;<?php echo htmlentities($_SESSION["AUTH_SPONSORNAME"]); ?>&quot;.</dd>
			</dl>
		
		<?php
		if ( $_SESSION['AUTH_LOGINSOURCE'] == "DB" && strlen($_SESSION["AUTH_USERID"]) > strlen(AUTH_DB_USER_PREFIX) && substr($_SESSION["AUTH_USERID"],0,strlen(AUTH_DB_USER_PREFIX)) == AUTH_DB_USER_PREFIX ) {
			?>
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>; padding-top: 8px;">User <?php echo $_SESSION["AUTH_USERID"]; ?>'s Options:&nbsp;</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><a href="changeuserpassword.php"><?php echo lang('change_password_of_user'); ?></a></dt>
				<dd>Change the password you use when logging in to the calendar.</dd>
			</dl>
			<?php
		} // end: if ( AUTH_DB ... )
		?>
	</td>
	<!-- End Sponsor Level Column -->
<?php

if ($_SESSION['AUTH_ISCALENDARADMIN']) {
	?>
	<td valign="top" style="border-left: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>; background-color: <?php echo $_SESSION['COLOR_LIGHT_CELL_BG']; ?>;">
		<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;">Calendar Options:&nbsp;</h2>
		<dl style="margin-top: 0; padding-top: 2px;">
			<dt><a href="approval.php"><?php echo lang('approve_reject_event_updates'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Approve, edit or deny events that have been submitted by sponsors for this calendar.</dd>

			<dt style="border-top: 1px dotted <?php echo $_SESSION['COLOR_BORDER']; ?>; padding-top: 6px;"><a href="managesponsors.php"><?php echo lang('manage_sponsors'); ?></a></dt>
			<dd style="padding-bottom: 2px;">Sponsors are groups of users who submit under a common name, such as &quot;Chess Club&quot;.</dd>

			<dt><a href="deleteinactivesponsors.php"><?php echo lang('delete_inactive_sponsors'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Automatically remove sponsors who have not submitted events in a specific amount of time.</dd>

			<dt style="border-top: 1px dotted <?php echo $_SESSION['COLOR_BORDER']; ?>; padding-top: 6px;"><a href="changecalendarsettings.php"><?php echo lang('change_header_footer_auth'); ?></a></dt>
			<dd style="padding-bottom: 2px;">Change the header and footer HTML, as well as basic colors in the calendar. You can also change whether or not the calendar requires authentication for viewing the events.</dd>

			<dt><a href="changecolors.php"><?php echo lang('change_colors'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Change the calendar colors to match your web site's design.</dd>

			<dt style="border-top: 1px dotted <?php echo $_SESSION['COLOR_BORDER']; ?>; padding-top: 6px;"><a href="manageeventcategories.php"><?php echo lang('manage_event_categories'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Categories are used when a person wants to filter events on the calendar. All events must be assigned to one category.</dd>

			<dt style="border-top: 1px dotted <?php echo $_SESSION['COLOR_BORDER']; ?>; padding-top: 6px;"><a href="managesearchkeywords.php"><?php echo lang('manage_search_keywords'); ?></a></dt>
			<dd>Add, edit and remove keyword synonyms.</dd>

			<dt><a href="managefeaturedsearchkeywords.php"><?php echo lang('manage_featured_search_keywords'); ?></a></dt>
			<dd>When a &quot;Featured keyword&quot; is used in a search, a message automatically appears at the top of the search results.</dd>

			<dt><a href="viewsearchlog.php"><?php echo lang('view_search_log'); ?></a></dt>
			<dd>You can view a log of all the keywords searched here, which can be useful when you want to create keyword synonyms or featured keywords.</dd>
		</dl>
	</td>
	<?php
}

if ( $_SESSION['AUTH_ISMAINADMIN'] ) {
	?>
	<td valign="top" style="border-left: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;">
		<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;"><?php echo lang('main_administrators_options'); ?>:&nbsp;</h2>
		<dl style="margin-top: 0; padding-top: 2px;">
			<dt><?php	if ( AUTH_DB ) { ?><a href="manageusers.php"><?php echo lang('manage_users'); ?></a> <?php echo AUTH_DB_NOTICE; ?><?php } ?></dt>
			<dd>Add, edit and remove user accounts from the database.</dd>
		</dl>
		<dl>
			<dt><a href="managecalendars.php"><?php echo lang('manage_calendars'); ?></a></dt>
			<dd>Add, edit and remove calendars as well as set who has 'administrative' access to the calendar.</dd>
		</dl>
		<dl>
			<dt><a href="managemainadmins.php"><?php echo lang('manage_main_admins'); ?></a></dt>
			<dd>Add, edit and remove users who have full access to the entire calendar system.</dd>
		</dl>
		<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;">VTCalendar Community:&nbsp;</h2>
		<p>The following are external links to various VTCalendar resources:</p>
		<ul>
			<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=docs">Documentation &amp; Faq</a></li>
			<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=vtcalendar-announce">New Release Mailing List</a></li>
			<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=forums">Forums</a></li>
			<li><a href="http://vtcalendar.sourceforge.net/jump.php?name=bugs">Report Bugs</a></li>
		</ul>
		<?php if (CHECKVERSION) { ?>
			<!--[if lte IE 6]><style type="text/css">
			.HideIE6 { display: none; }
			</style><![endif]-->
			<h2 class="HideIE6" style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;">Version Check:&nbsp;</h2>
			<div class="HideIE6" style="margin-top: 0; padding-top: 10px;" id="VersionResult"></div>
			<script type="text/javascript"><!-- //<![CDATA[
			function CheckVersionHandler(image, messageHTML, tableHTML) {
				document.getElementById("VersionResult").innerHTML = tableHTML.replace('<br/>', '<br/><br/>');
			}
			if (!is_ie || is_ie7up) {
				document.write('<iframe src="checkversion.php?width=250" width="1" height="1" frameborder="0" marginheight="0" marginwidth="0" allowtransparency="true"></iframe>');
			}
			// ]]> --></script>
		<?php } ?>
	</td>
	<?php
}

?>
</tr>
</table>
</div></div>
<?php
	pagefooter();
DBclose();
?>