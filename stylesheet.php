<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  header("Content-Type: text/css");	
  if (strpos(" ".$_SERVER["HTTP_USER_AGENT"],"MSIE") > 0) { $ie = 1; }
  else { $ie = 0; }  
?>

.calendartitle {
	FONT-WEIGHT: bold; 
	FONT-SIZE: 20px;
}
.datetitle {
	FONT-SIZE: 20px; 
}
.eventtitlebig {
	FONT-WEIGHT: bold; 
	FONT-SIZE: 24px; 
}
.eventtimebig {
	FONT-SIZE: 18px; 
}

/*.today {
	BACKGROUND-COLOR: <?php echo $_SESSION["TODAYCOLOR"]; ?>;
}
.future {
	BACKGROUND-COLOR: <?php echo $_SESSION["FUTURECOLOR"]; ?>;
}
.eventtime {
	FONT-SIZE: <?php if ($ie) { echo "x"; } ?>x-small;
}
.announcement {
	FONT-SIZE: medium;
}*/
.feedbackpos {
	FONT-WEIGHT: bold; 
	FONT-SIZE: <?php if ($ie) { echo "x-"; } ?>small; 
	COLOR: #008800;
}
.feedbackneg {
	FONT-WEIGHT: bold; 
	FONT-SIZE: <?php if ($ie) { echo "x-"; } ?>small; 
	COLOR: #CC0000;
}
code, pre {
   font-size: 10pt;
}