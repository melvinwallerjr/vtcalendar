<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
	require_once('application.inc.php');

	if (!authorized()) { exit; }
	if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security
 
	pageheader(lang('manage_event_categories'), "Update");
	contentsection_begin(lang('manage_event_categories'),true);

	$result = DBQuery("SELECT * FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' ORDER BY name" ); 
?>
<p><a href="addnewcategory.php"><?php echo lang('add_new_event_category'); ?></a>
<?php
	if ($result->numRows() > 0 ) {
?>
<?php echo lang('or_modify_existing_category'); ?></p>

<table border="0" cellspacing="0" cellpadding="4">
	<tr bgcolor="#CCCCCC">
		<td bgcolor="#CCCCCC"><b><?php echo lang('category_name'); ?></b></td>
		<td bgcolor="#CCCCCC">&nbsp;</td>
	</tr>
<?php
	$color = "#eeeeee";
	for ($i=0; $i<$result->numRows(); $i++) {
		$category = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
		if ( $color == "#eeeeee" ) { $color = "#ffffff"; } else { $color = "#eeeeee"; }
?>	
	<tr bgcolor="<?php echo $color; ?>">
		<td bgcolor="<?php echo $color; ?>"><?php echo htmlentities($category['name']); ?></td>
		<td bgcolor="<?php echo $color; ?>"><a href="renamecategory.php?categoryid=<?php echo urlencode($category['id']); ?>"><?php echo lang('rename'); ?></a> 
	&nbsp;<a href="deletecategory.php?categoryid=<?php echo urlencode($category['id']); ?>"><?php echo lang('delete'); ?></a></td>
	</tr>
<?php
	} // end: for ($i=0; $i<$result->numRows(); $i++)
?>	
</table>

<?php
	} // end: if ($result->numRows() > 0 )
	
	contentsection_end();
	pagefooter();
DBclose();
?>