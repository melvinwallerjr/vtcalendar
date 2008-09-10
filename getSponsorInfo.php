<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
require_once('globalsettings.inc.php');

if (isset($_GET['sponsorid'])) { setVar($sponsorid,$_GET['sponsorid'],'sponsorid'); } else { unset($sponsorid); }
if (isset($_GET['type'])) { $type = $_GET['type']; } else { unset($type); }

if (!isset($sponsorid)) {
	echo "INVALID_SPONSOR_ID:", $_GET['sponsorid'];
}
else {
  $database = DBopen();
  $result = DBQuery($database, "SELECT * FROM vtcal_sponsor WHERE id='".sqlescape($sponsorid)."'" ); 
  
  if ($result->numRows() == 0) {
  	echo "SPONSOR_ID_NOTFOUND:", $_GET['sponsorid'];
  }
  else {
	  $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	  if ($type == "name") {
	  	echo $sponsor['name'];
	  }
	  elseif ($type == "url") {
	  	echo $sponsor['url'];
	  }
  }
}
?>