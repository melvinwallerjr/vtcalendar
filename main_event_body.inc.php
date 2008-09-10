<?php
  if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

  // read first event if one exists
  if ($result->numRows()>0) {
    $event['calendarid'] = $_SESSION["CALENDARID"];
    $event['id'] = $eventid;
    
    if ((isset($_SESSION["AUTH_SPONSORID"]) && $_SESSION["AUTH_SPONSORID"]==$event['sponsorid']) || !empty($_SESSION["AUTH_ADMIN"])) {
    	?><div style="padding: 5px;"><?php adminButtons($event, array('update','copy','delete'), "normal", "horizontal"); ?></div>
    	
    	<?php
    }
		print_event($event);    
	}
?>