<?php
	if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files
	
?><table width="100%" border="0" cellpadding="0" cellspacing="10"><tr><td><?php
echo "<p>" . lang('subscribe_message') . "</p>";

$color = $_SESSION['COLOR_BG'];
$iCalDirName = 'calendars/';

?>
<p><b><?php echo lang('whole_calendar'); ?>:</b><br/><?php echo htmlentities($_SESSION['CALENDAR_NAME']); ?> &nbsp; 
<a href="<?php echo BASEURL . EXPORT_PATH; ?>?calendar=<?php echo urlencode($_SESSION['CALENDAR_ID']); ?>&format=rss2_0&timebegin=upcoming"><?php echo lang('rss_feed'); ?></a> &nbsp;
<a href="webcal://<?php echo preg_replace('/^[A-Za-z]+:\/\//', '', BASEURL) . EXPORT_PATH; ?>?calendar=<?php echo urlencode($_SESSION['CALENDAR_ID']); ?>&format=ical&timebegin=upcoming"><?php echo lang('subscribe'); ?></a> &nbsp;
<a href="<?php echo BASEURL . EXPORT_PATH; ?>?calendar=<?php echo urlencode($_SESSION['CALENDAR_ID']); ?>&format=ical&timebegin=upcoming"><?php echo lang('download'); ?></a>
</p>

<?php

?><p><b>...or by category:</b></p>
	<blockquote>
		<table border="0" cellspacing="2" cellpadding="4">
			<tr bgcolor="<?php echo $color; ?>">
				<td bgcolor="<?php echo $_SESSION['COLOR_TABLE_HEADER_BG']; ?>"><b><?php echo lang('category'); ?></b></td>
				<td align="right" bgcolor="<?php echo $_SESSION['COLOR_TABLE_HEADER_BG']; ?>"><b><?php echo lang('upcoming_events'); ?></b></td>
				<td align="center" bgcolor="<?php echo $_SESSION['COLOR_TABLE_HEADER_BG']; ?>"><b><?php echo lang('ways_to_subscribe'); ?></b></td>
			</tr>
<?php

// The number of ICS files found.
$fileCount = 0;
	
// Output a list of static ICS files if they exist.
if (is_dir($iCalDirName) && $iCalDir = opendir($iCalDirName)) {
	/* This is the correct way to loop over the directory. */
	while ( ($file = readdir($iCalDir)) != false) {
		if (strlen($file)>4 && substr($file,strlen($file)-4,4)==".ics") {
			if ( $color == $_SESSION['COLOR_LIGHT_CELL_BG'] ) { $color = $_SESSION['COLOR_BG']; } else { $color = $_SESSION['COLOR_LIGHT_CELL_BG']; }
			?>	
			<tr bgcolor="<?php echo $color; ?>">
				<td bgcolor="<?php echo $color; ?>"><?php echo htmlentities(substr($file,0,strlen($file)-4)); ?></td>
				<td bgcolor="<?php echo $color; ?>"><a href="webcal://<?php echo substr(BASEURL,7).$iCalDirName.htmlentities($file); ?>"><?php echo lang('subscribe'); ?></a> &nbsp; 
			<a href="<?php echo BASEURL.$iCalDirName.htmlentities($file); ?>"><?php echo lang('download'); ?></a></td>
			</tr>
			<?php
			$fileCount++;
		}
	}
	
	closedir($iCalDir);
}

// Get the categories from the DB if no files were found (or if we never searched for files anyway).
if ($fileCount == 0) {
	$result =& DBQuery("SELECT count(e.id) as eventcount, c.id, c.name FROM ".TABLEPREFIX."vtcal_category c LEFT JOIN ".TABLEPREFIX."vtcal_event_public e ON c.calendarid = e.calendarid AND c.id = e.categoryid AND e.timeend > '" . sqlescape(NOW_AS_TEXT) . "' WHERE c.calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' GROUP BY c.id ORDER BY c.name"); 
	if (is_string($result)) {
		DBErrorBox($result); 
	}
	else {
		for ($i=0; $i<$result->numRows(); $i++) {
			$category =& $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
			if ( $color == $_SESSION['COLOR_LIGHT_CELL_BG'] ) { $color = $_SESSION['COLOR_BG']; } else { $color = $_SESSION['COLOR_LIGHT_CELL_BG']; }
			?>	
			<tr bgcolor="<?php echo $color; ?>">
				<td bgcolor="<?php echo $color; ?>"><?php echo htmlentities($category['name']); ?></td>
				<td align="right" bgcolor="<?php echo $color; ?>"><?php echo $category['eventcount']; ?></td>
				<td bgcolor="<?php echo $color; ?>">

<a href="<?php echo BASEURL . EXPORT_PATH; ?>?calendar=<?php echo urlencode($_SESSION['CALENDAR_ID']); ?>&format=rss2_0&timebegin=upcoming&categories=<?php echo $category['id']; ?>"><?php echo lang('rss_feed'); ?></a> &nbsp;
<a href="webcal://<?php echo preg_replace('/^[A-Za-z]+:\/\//', '', BASEURL) . EXPORT_PATH; ?>?calendar=<?php echo urlencode($_SESSION['CALENDAR_ID']); ?>&format=ical&timebegin=upcoming&categories=<?php echo $category['id']; ?>"><?php echo lang('subscribe'); ?></a> &nbsp;
<a href="<?php echo BASEURL . EXPORT_PATH; ?>?calendar=<?php echo urlencode($_SESSION['CALENDAR_ID']); ?>&format=ical&timebegin=upcoming&categories=<?php echo $category['id']; ?>"><?php echo lang('download'); ?></a>
				</td>
			</tr>
			<?php
		}
	}
}

?></blockquote></table>

</td></tr></table>