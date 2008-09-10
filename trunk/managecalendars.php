<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  $database = DBopen();
  if (!authorized($database)) { exit; }
  if (!$_SESSION["AUTH_MAINADMIN"] ) { exit; } // additional security
 
	pageheader(lang('manage_calendars'),
					lang('manage_calendars'),
					 "Update","",$database);
	contentsection_begin(lang('manage_calendars'),true);
?>
<p><a href="editcalendar.php?new=1"><?php echo lang('add_new_calendar'); ?></a> <?php echo lang('or_modify_existing_calendar'); ?></p>

<table border="0" cellspacing="0" cellpadding="4">
  <tr bgcolor="#CCCCCC">
    <td bgcolor="#CCCCCC"><b><?php echo lang('calendar_id'); ?></b></td>
    <td bgcolor="#CCCCCC"><b><?php echo lang('calendar_name'); ?></b></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
<?php
  $result = DBQuery($database, "SELECT * FROM vtcal_calendar ORDER BY id" ); 

  $color = "#eeeeee";
  for ($i=0; $i<$result->numRows(); $i++) {
    $calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
		if ( $color == "#eeeeee" ) { $color = "#ffffff"; } else { $color = "#eeeeee"; }
?>	
  <tr bgcolor="<?php echo $color; ?>">
    <td bgcolor="<?php echo $color; ?>"><?php echo htmlentities($calendar['id']); ?></td>
    <td bgcolor="<?php echo $color; ?>"><?php echo htmlentities($calendar['name']); ?></td>
    <td bgcolor="<?php echo $color; ?>"><a href="editcalendar.php?cal[id]=<?php echo urlencode($calendar['id']); ?>"><?php echo lang('edit'); ?></a>&nbsp; 
<?php
  if ( $calendar['id'] != "default" ) {
?>
		<a href="deletecalendar.php?cal[id]=<?php echo urlencode($calendar['id']); ?>"><?php echo lang('delete'); ?></a>
<?php
  } // end: if ( $calendar['id'] != "default" )
?>
		</td>
  </tr>
<?php
  } // end: for ($i=0; $i<$result->numRows(); $i++)
?>	
<?php
  if ( $color == "#eeeeee" ) { $color = "#ffffff"; } else { $color = "#eeeeee"; }
?>		
	<tr bgcolor="<?php echo $color; ?>">
	  <td colspan="3" bgcolor="<?php echo $color; ?>">
		  <b><?php echo $result->numRows(); ?> <?php echo lang('calendars'); ?></b>
		</td>
	</tr>
</table>
<?php
  contentsection_end();
  require("footer.inc.php");
DBclose($database);
?>