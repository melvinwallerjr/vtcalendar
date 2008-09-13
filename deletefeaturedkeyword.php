<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  if (isset($_GET['id'])) { setVar($id,$_GET['id'],'searchkeywordid'); } else { unset($id); }

  if (!authorized()) { exit; }
  if (!$_SESSION["AUTH_ADMIN"]) { exit; } // additional security

	$query = "DELETE FROM vtcal_searchfeatured WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($id)."'";
	$result = DBQuery($query );
  redirect2URL("managefeaturedsearchkeywords.php");
  exit;
?>