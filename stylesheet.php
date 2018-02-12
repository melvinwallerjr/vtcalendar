<?php
//require_once('config.inc.php');
//require_once('session_start.inc.php');

header("Content-Type: text/css");	
if (strpos(" ".$_SERVER["HTTP_USER_AGENT"],"MSIE") > 0) { $ie = 1; }
else { $ie = 0; }  
?>

.feedbackpos {
	font-weight: bold; 
	font-size: <?php if ($ie) { echo "x-"; } ?>small; 
	color: #080;
}
.feedbackneg {
	font-weight: bold; 
	font-size: <?php if ($ie) { echo "x-"; } ?>small; 
	color: #c00;
}
code, pre {
	 font-size: 10pt;
}
