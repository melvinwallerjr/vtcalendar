<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  $database = DBCONNECTION;
  if (!authorized($database)) { exit; }
  if (!$_SESSION["AUTH_ADMIN"]) { exit; } // additional security
 
	pageheader(lang('manage_featured_search_keywords'),
					 lang('manage_featured_search_keywords'),
					 "Update","",$database);
	contentsection_begin(lang('manage_featured_search_keywords'),true);

  $result = DBQuery($database, "SELECT * FROM vtcal_searchfeatured WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY keyword" ); 
?>
<p><?php echo lang('featured_search_keywords_message'); ?><p>

<p><a href="editfeaturedkeyword.php"><?php echo lang('add_new_featured_keyword'); ?></a>
<?php
  if ($result->numRows() > 0 ) {
?>
<?php echo lang('or_manage_existing_keywords'); ?></p>

<table border="0" cellspacing="0" cellpadding="4">
  <tr bgcolor="#CCCCCC">
    <td bgcolor="#CCCCCC"><b><?php echo lang('keyword'); ?></b></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
<?php
  $color = "#eeeeee";
  for ($i=0; $i<$result->numRows(); $i++) {
    $searchkeyword = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
		if ( $color == "#eeeeee" ) { $color = "#ffffff"; } else { $color = "#eeeeee"; }
?>	
  <tr bgcolor="<?php echo $color; ?>">
    <td bgcolor="<?php echo $color; ?>"><?php echo htmlentities($searchkeyword['keyword']); ?></td>
    <td bgcolor="<?php echo $color; ?>">&nbsp;<a href="editfeaturedkeyword.php?id=<?php echo urlencode($searchkeyword['id']); ?>"><?php echo lang('edit'); ?></a>&nbsp;&nbsp; 
	<a href="deletefeaturedkeyword.php?id=<?php echo urlencode($searchkeyword['id']); ?>"><?php echo lang('delete'); ?></a></td>
  </tr>
<?php
  } // end: for ($i=0; $i<$result->numRows(); $i++)
?>	
</table>

<?php
  } // end: if ($result->numRows() > 0 )
  contentsection_end();
  require("footer.inc.php");
DBclose($database);
?>