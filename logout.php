<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');
  logout();
	
  // reroute to calendar home page
  redirect2URL("main.php");
  exit;
?>