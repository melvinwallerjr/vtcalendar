<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  if (isset($_GET['templateid'])) { setVar($templateid,$_GET['templateid'],'templateid'); } else { unset($templateid); }

  $database = DBCONNECTION;
  if (!authorized($database)) { exit; }

  if (!empty($templateid)) {
	  $result = DBQuery($database, "DELETE FROM vtcal_template WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND sponsorid='".sqlescape($_SESSION["AUTH_SPONSORID"])."' AND id='".sqlescape($templateid)."'" );
  }

  redirect2URL("managetemplates.php");
  exit;
?>