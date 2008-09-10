<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  if (isset($_GET['id'])) { setVar($id,$_GET['id'],'searchkeywordid'); } else { unset($id); }

  $database = DBCONNECTION;
  if (!authorized($database)) { exit; }
  if (!$_SESSION["AUTH_ADMIN"]) { exit; } // additional security

	$query = "DELETE FROM vtcal_searchkeyword WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($id)."'";
	$result = DBQuery($database, $query );
  redirect2URL("managesearchkeywords.php");
  exit;
?>