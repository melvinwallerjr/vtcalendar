<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

// Output an error message if $result is a string.
if (is_string($result)) { DBErrorBox($result); }
else {
	// Otherwise, the query was successful.
	// read first event if one exists
	if ($result->numRows() > 0) {
		$event['calendarid'] = $_SESSION['CALENDAR_ID'];
		$event['id'] = $eventid;
		if ((isset($_SESSION['AUTH_SPONSORID']) && $_SESSION['AUTH_SPONSORID'] == $event['sponsorid']) ||
		 !empty($_SESSION['AUTH_ISCALENDARADMIN'])) {
			echo '
<div class="NoPrint" style="padding:5px;">';
			adminButtons($event, array('update', 'copy', 'delete'), 'normal', 'horizontal');
			echo '</div>' . "\n";
		}
		print_event($event);
	}
}
?>