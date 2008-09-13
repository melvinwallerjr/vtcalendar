<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('application.inc.php');

  if (!authorized()) { exit; }
 
	pageheader(lang('manage_templates'), "Update");
	contentsection_begin(lang('manage_templates'), true);

  $result = DBQuery("SELECT * FROM vtcal_template WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND sponsorid='".sqlescape($_SESSION["AUTH_SPONSORID"])."' ORDER BY name" ); 
?>
<p><a href="addtemplate.php"><?php echo lang('add_new_template'); ?></a>
<?php
  if ($result->numRows() > 0 ) {
?>
<?php echo lang('or_modify_existing_template'); ?></p>

<table border="0" cellspacing="0" cellpadding="4">
  <tr bgcolor="#CCCCCC">
    <td bgcolor="#CCCCCC"><b><?php echo lang('template_name'); ?></b></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
<?php
  $color = "#eeeeee";
  for ($i=0; $i<$result->numRows(); $i++) {
    $template = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
		if ( $color == "#eeeeee" ) { $color = "#ffffff"; } else { $color = "#eeeeee"; }
?>	
  <tr bgcolor="<?php echo $color; ?>">
    <td bgcolor="<?php echo $color; ?>"><?php echo htmlentities($template['name']); ?></td>
    <td bgcolor="<?php echo $color; ?>"><a href="updatetinfo.php?templateid=<?php echo urlencode($template['id']); ?>"><?php echo lang('edit'); ?></a> 
	&nbsp;<a href="deletetemplate.php?templateid=<?php echo urlencode($template['id']); ?>"><?php echo lang('delete'); ?></a></td>
  </tr>
<?php
  } // end: for ($i=0; $i<$result->numRows(); $i++)
?>	
</table>
<br>
<?php
  } // end: if ($result->numRows() > 0 )
  contentsection_end();
  pagefooter();
DBclose();
?>