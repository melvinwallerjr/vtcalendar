<?php
/*if (!isset($_GET['rawdata'])) {
	define("NOEXPORTFORM", true);
	require("../../export.php");
	exit;
}*/

// Do not show the DB error HTML if we cannot connect to the DB.
// Must before the application.inc.php include.
define("HIDEDBERROR", true);

require_once('application.inc.php');

$result =& DBQuery("SELECT ");

DBClose();
	
?>