<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  if (isset($_POST['cancel'])) { setVar($cancel,$_POST['cancel'],'cancel'); } else { unset($cancel); }
  if (isset($_POST['save'])) { setVar($save,$_POST['save'],'save'); } else { unset($save); }
  if (isset($_POST['categoryid'])) { setVar($categoryid,$_POST['categoryid'],'categoryid'); } 
	else { 
    if (isset($_GET['categoryid'])) { setVar($categoryid,$_GET['categoryid'],'categoryid'); } 
		else { unset($categoryid); }
  }		
  if (isset($_POST['newcategoryid'])) { setVar($newcategoryid,$_POST['newcategoryid'],'categoryid'); } else { unset($newcategoryid); }
  if (isset($_POST['deleteevents'])) { setVar($deleteevents,$_POST['deleteevents'],'deleteevents'); } else { unset($deleteevents); }

  if (!authorized()) { exit; }
  if (!$_SESSION["AUTH_ADMIN"]) { exit; } // additional security

  if (isset($cancel)) {
    redirect2URL("manageeventcategories.php");
    exit;
  }

  // make sure the category exists
	$result = DBQuery("SELECT * FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($categoryid)."'" );
	if ( $result->numRows() != 1 ) {
		redirect2URL("manageeventcategories.php");
		exit;
	}
	else {
		$category = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	}

  if (isset($save) ) {
    if ($deleteevents=="1") {
		  $result = DBQuery("DELETE FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND categoryid='".sqlescape($categoryid)."'" );
		  $result = DBQuery("DELETE FROM vtcal_event_public WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND categoryid='".sqlescape($categoryid)."'" );
		}
		else {
   		$result = DBQuery("UPDATE vtcal_event SET categoryid='".sqlescape($newcategoryid)."' WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND categoryid='".sqlescape($categoryid)."'" );
   		$result = DBQuery("UPDATE vtcal_event_public SET categoryid='".sqlescape($newcategoryid)."' WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND categoryid='".sqlescape($categoryid)."'" );
		}
		$result = DBQuery("DELETE FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($categoryid)."'" );
    redirect2URL("manageeventcategories.php");
    exit;
  }

  pageheader(lang('delete_event_category'), "Update");
  contentsection_begin(lang('delete_event_category'));
?>
<font color="#ff0000"><b><?php echo lang('warning_event_category_delete'); ?> &quot;<b><?php echo htmlentities($category['name']); ?></b>&quot;</b></font>
<form method="post" action="deletecategory.php">
	<input type="radio" name="deleteevents" value="1"> <?php echo lang('delete_all_events_in_category'); ?><br>
  <input type="radio" name="deleteevents" value="0" checked> 
	<?php echo lang('reassign_all_events_to_category'); ?>
  <select name="newcategoryid" size="1">
<?php
  $result = DBQuery("SELECT * FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id!='".sqlescape($categoryid)."' ORDER BY name" ); 

  // print list with categories from the DB
  for ($i=0; $i<$result->numRows(); $i++) {
    $newcategory = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
    echo "<option ";
    echo "value=\"".$newcategory['id']."\">".htmlentities($newcategory['name'])."</option>\n";
  }
?>
  </select>
	<input type="hidden" name="categoryid" value="<?php echo $categoryid; ?>">
	<BR>
  <BR>
  <INPUT type="submit" name="save" value="<?php echo lang('ok_button_text'); ?>">
  <INPUT type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>">
</form>
<?php
  contentsection_end();
  require("footer.inc.php");
DBclose();
?>