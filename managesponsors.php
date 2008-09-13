<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  if (!authorized()) { exit; }
  if (!$_SESSION["AUTH_ADMIN"]) { exit; } // additional security

  if (isset($_POST['edit'])) { setVar($edit,$_POST['edit'],'edit'); } else { unset($edit); }
  if (isset($_POST['delete'])) { setVar($delete,$_POST['delete'],'delete'); } else { unset($delete); }
  if (isset($_POST['id'])) { setVar($id,$_POST['id'],'sponsorid'); } else { unset($id); }

  if ( isset($edit) ) {
	  redirect2URL("editsponsor.php?id=".$id); exit;
	}
  elseif ( isset($delete) ) {
    $result = DBQuery("SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($id)."'" ); 
    $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
    
		if ( $sponsor['admin'] == 0 ) {
	    redirect2URL("deletesponsor.php?id=".$id);
		}
		else {
			$errorMessage = "You cannot delete the administrative sponsor for this calendar.";
		}
	}
 
	pageheader(lang('manage_sponsors'), "Update");
	contentsection_begin(lang('manage_sponsors'),true);
?>
<form method="post" name="mainform" action="managesponsors.php">
<p><a href="editsponsor.php"><?php echo lang('add_new_sponsor'); ?></a> <?php echo lang('or_modify_existing_sponsor'); ?></p>
<?php
	if (isset($errorMessage)) {
		echo '<p><b><font color="#CC0000">'.$errorMessage.'</font></b></p>';
	}
	
  $numLines = 15;
?>
<select name="id" size="<?php echo $numLines; ?>">
<?php
  $result = DBQuery("SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY name" ); 

  for ($i=0; $i<$result->numRows(); $i++) {
    $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
?>	
  <option value="<?php echo htmlentities($sponsor['id']); ?>"><?php echo htmlentities($sponsor['name']); ?><?php if ($sponsor['admin']) { echo ' **'; } ?></option>
<?php
  } // end: for ($i=0; $i<$result->numRows(); $i++)
?>	
</select><br>
<input type="submit" name="edit" value="<?php echo lang('button_edit'); ?>">
<input type="submit" name="delete" value="<?php echo lang('button_delete'); ?>"><br>
<p>The sponsor marked with a ** is the administrative sponsor of this calendar.</p>
<p><b><?php echo $result->numRows(); ?> <?php echo lang('sponsors_total'); ?></b></p>
</form>
<script language="JavaScript" type="text/javascript"><!--
document.mainform.id.focus();
//--></script>

<?php
  contentsection_end();
  require("footer.inc.php");
DBclose();
?>