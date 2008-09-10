<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
require_once('globalsettings.inc.php');

//  if (isset($_POST['userid'])) { setVar($userid,$_POST['userid'],'userid'); } else { unset($userid); }
//  if (isset($_POST['password'])) { setVar($password,$_POST['password'],'password'); } else { unset($password); }

// the next if statement is just to avoid that it redirects when using in testing mode 
if ( $_SERVER['HTTP_HOST'] != "localhost" ) {
	$protocol = "http";
	if ( isset($_SERVER['HTTPS'])) { $protocol .= "s"; }
	if ( BASEURL != SECUREBASEURL && $protocol."://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"] != SECUREBASEURL."update.php" ) {
		redirect2URL(SECUREBASEURL."update.php?calendar=".$_SESSION["CALENDARID"]);
	}
}

$database = DBCONNECTION;
if (!authorized($database)) { exit; }

// read sponsor name from DB
$result = DBQuery($database, "SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($_SESSION["AUTH_SPONSORID"])."'" ); 
$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);

pageheader(lang('update_calendar'),
					 lang('update_calendar'),
					 "Update","",$database);

?>

<!-- Start Link Table -->
<div id="UpdateBlock"><div style="border: 1px solid #666666;">

<?php
if (isset($_GET['fbid'])) { $fbid = $_GET['fbid']; } else { unset($fbid); }
if (isset($_GET['fbparam'])) { $fbparam = $_GET['fbparam']; } else { unset($fbparam); }
if ( isset($fbid) ) {
	$startHTML = '<div style="padding: 8px; border-bottom: 1px solid #666666; background-color: #FFFFCC;">';
	$endHTML = '</div>';
	if ($fbid=="eaddsuccess" && !$_SESSION["AUTH_ADMIN"]) {
		echo $startHTML;
		feedback(lang('new_event_submitted_notice')." ".stripslashes(urldecode("\"$fbparam\"")),0);
		echo $endHTML;
	}
	elseif ($fbid=="eupdatesuccess" && !$_SESSION["AUTH_ADMIN"] ) {
		echo $startHTML;
		feedback(lang('updated_event_submitted_notice')." ".stripslashes(urldecode("\"$fbparam\"")),0);
		echo $endHTML;
	}
	elseif ($fbid=="urlchangesuccess") {
		echo $startHTML;
		feedback(lang('hompage_changed_notice')." ".stripslashes(urldecode("\"$fbparam\"")),0);
		echo $endHTML;
	}
	elseif ($fbid=="emailchangesuccess") {
		echo $startHTML;
		feedback(lang('email_changed_notice')." ".stripslashes(urldecode("\"$fbparam\"")),0);
		echo $endHTML;
	}
}
?>

<table id="UpdateMainMenu" cellspacing="0" cellpadding="10" border="0">
<tr>
	
	<!-- Start Sponsor Level Column -->
	<td valign="top">
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid #666666;">Event Options:</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><A href="addevent.php"><?php echo lang('add_new_event'); ?></A></dt>
				<dd>Add a new event to the calendar.</dd>
				<dt><A href="manageevents.php"><?php echo lang('manage_events'); ?></A></dt>
				<dd style="padding-bottom: 4px;">View events that have been submitted, and see if they have been approved.</dd>
				<dt><A href="managetemplates.php"><?php echo lang('manage_templates'); ?></A></dt>
				<dd style="padding-bottom: 4px;">Create templates to easily add new events with similar information.</dd>
			</dl>
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid #666666;">Backup &amp; Restore:</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><A href="export.php"><?php echo lang('export_events'); ?></A></dt>
				<dd>Export events to a file you can save on your computer as a backup, or to transfer to another calendar.</dd>
				<dt><A href="import.php"><?php echo lang('import_events'); ?></A></dt>
				<dd>Import an XML file that contains events as a batch.</dd>
			</dl>
		
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid #666666; padding-top: 8px;"><?php echo htmlentities($sponsor['name']); ?> Options:&nbsp;</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><A href="changehomepage.php"><?php echo lang('change_homepage'); ?></A></dt>
				<dd>Change the default homepage address for &quot;<?php echo htmlentities($sponsor['name']); ?>&quot;.</dd>
				<dt><A href="changeemail.php"><?php echo lang('change_email'); ?></A></dt>
				<dd>Change the default e-mail for &quot;<?php echo htmlentities($sponsor['name']); ?>&quot;.</dd>
			</dl>
		
		<?php
		if ( $_SESSION["AUTH_TYPE"] == "DB" && strlen($_SESSION["AUTH_USERID"]) > strlen(AUTH_DB_USER_PREFIX) && substr($_SESSION["AUTH_USERID"],0,strlen(AUTH_DB_USER_PREFIX)) == AUTH_DB_USER_PREFIX ) {
			?>
			<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid #666666; padding-top: 8px;">User <?php echo $_SESSION["AUTH_USERID"]; ?>'s Options:&nbsp;</h2>
			<dl style="margin-top: 0; padding-top: 2px;">
				<dt><A href="changeuserpassword.php"><?php echo lang('change_password_of_user'); ?></A></dt>
				<dd>Change the password you use when logging in to the calendar.</dd>
			</dl>
			<?php
		} // end: if ( AUTH_DB ... )
		?>
	</td>
	<!-- End Sponsor Level Column -->
<?php
if ($_SESSION["AUTH_ADMIN"]) {
?>
	<td valign="top" style="border-left: 1px solid #666666; background-color: #EEEEEE;">
	  <h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid #666666;">Calendar Options:&nbsp;</h2>
		<dl style="margin-top: 0; padding-top: 2px;">
			<dt><a href="approval.php"><?php echo lang('approve_reject_event_updates'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Approve, edit or deny events that have been submitted by sponsors for this calendar.</dd>
			<dt style="border-top: 1px dotted #666666; padding-top: 6px;"><a href="managesponsors.php"><?php echo lang('manage_sponsors'); ?></a></dt>
			<dd>Sponsors are groups of users who submit under a common name, such as &quot;Chess Club&quot;.</dd>
			<dt><a href="deleteinactivesponsors.php"><?php echo lang('delete_inactive_sponsors'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Automatically remove sponsors who have not submitted events in a specific amount of time.</dd>
			<dt style="border-top: 1px dotted #666666; padding-top: 6px;"><a href="changecalendarsettings.php"><?php echo lang('change_header_footer_colors_auth'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Change the header and footer HTML, as well as basic colors in the calendar. You can also change whether or not the calendar requires authentication for viewing the events.</dd>
			<dt style="border-top: 1px dotted #666666; padding-top: 6px;"><a href="manageeventcategories.php"><?php echo lang('manage_event_categories'); ?></a></dt>
			<dd style="padding-bottom: 8px;">Categories are used when a person wants to filter events on the calendar. All events must be assigned to one category.</dd>
			<dt style="border-top: 1px dotted #666666; padding-top: 6px;"><a href="managesearchkeywords.php"><?php echo lang('manage_search_keywords'); ?></a></dt>
			<dd>Add, edit and remove keyword synonyms.</dd>
			<dt><a href="managefeaturedsearchkeywords.php"><?php echo lang('manage_featured_search_keywords'); ?></a></dt>
			<dd>When a &quot;Featured keyword&quot; is used in a search, a message automatically appears at the top of the search results.</dd>
			<dt><a href="viewsearchlog.php"><?php echo lang('view_search_log'); ?></a></dt>
			<dd>You can view a log of all the keywords searched here, which can be useful when you want to create keyword synonyms or featured keywords.</dd>
		</dl>
	</td>
<?php
} // end: if ($_SESSION["AUTH_ADMIN"])
?>
<?php
if ( $_SESSION["AUTH_MAINADMIN"] ) {
?>
	<td valign="top" style="border-left: 1px solid #666666;">
		<h2 style="margin:0; padding: 0; padding-bottom: 4px; border-bottom: 1px solid #666666;"><?php echo lang('main_administrators_options'); ?>:&nbsp;</h2>
		<dl style="margin-top: 0; padding-top: 2px;">
			<dt><?php	if ( AUTH_DB ) { ?><A href="manageusers.php"><?php echo lang('manage_users'); ?></A> <?php echo AUTH_DB_NOTICE; ?><?php } ?></dt>
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
	</td>
<?php
} // end: if ( $_SESSION["AUTH_MAINADMIN"] )
?>
</tr>
</table>
</div></div>
<?php
  require("footer.inc.php");
DBclose($database);
?>