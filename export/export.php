<?php
// Make sure this script does not take a long time to execute.
set_time_limit(10);

define("CACHEMINUTES", 5);

define("ALLOWINCLUDES", TRUE); // Allows this file to include other files (e.g. config.inc.php).

@(include_once('DB.php')) or die('');
@(include_once('../version.inc.php')); // TODO: Should this fail if the file cannot be loaded?
@(include_once('../config.inc.php')) or die('');
require_once('../config-defaults.inc.php');
require_once('../functions.inc.php');
require_once('../languages/'.LANGUAGE.'.inc.php');
require_once('../constants.inc.php');
require_once('functions.inc.php');
require_once('../main_export_data.inc.php');

// ==========================================================
// Get the calendar ID from the query string
// ==========================================================

// If the query string is passing a valid CalendarID, set it to a variable.
if ( isset($_GET['calendarid']) && isValidInput($_GET['calendarid'],'calendarid') )
	{ $CalendarID = $_GET['calendarid']; }
elseif ( isset($_GET['calendar']) && isValidInput($_GET['calendar'],'calendarid') ) 
	{ $CalendarID = $_GET['calendar']; }

// Otherwise, the CalendarID is missing or invalid
else { outputErrorMessage("The CalendarID was not specified or is invalid."); }

// ==========================================================
// Load the Calendar Information
// ==========================================================

$DBCONNECTION =& DBOpen();
if (is_string($DBCONNECTION)) {
	outputErrorMessage("A database error occurred: " . $DBCONNECTION);
}

$calendardata =& getCalendarData($CalendarID);

// If there was an error, output the reason.
if (is_string($calendardata)) {
	outputErrorMessage("A database error occurred: " . $calendardata);
}

// If a number was returned, then the calendar does not exist or somehow too many records returned.
elseif (is_int($calendardata)) {
	if ($calendardata == 0) {
		outputErrorMessage("The '".$CalendarID."' calendar does not exist.");
	} else {
		outputErrorMessage("Too many records returned when attempting to retrieve the calendar information (".$calendardata.").");
	}
}

// If the calendar requires authentication to view, then exit.
elseif ($calendardata['viewauthrequired'] != 0) {
	outputErrorMessage("The '".$CalendarID."' calendar requires authentication to be viewed, so it cannot be used by the public export script.");
}

// ==========================================================
// Get the events from the database.
// ==========================================================

$query = BuildExportQuery($CalendarID, $FormData);

// Execute the query, and output an error message if one was caught.
if (is_string( $result =& DBQuery($query) ) ) {
	outputErrorMessage("A database error occurred: ". $result);
}

// ==========================================================
// Set headers to allow caching.
// ==========================================================

// Set the expiration of the returned data.
//Header("Expires: " . gmdate("D, d M Y H:i:s", time() + (CACHEMINUTES*60)) . " GMT");

// Set that this file was last updated right now.
//Header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . " GMT");

if (isset($_GET['raw'])) Header("Content-Type: text/plain");

switch($FormData['format']) {
	case "rss":
		if (!isset($_GET['raw'])) Header("Content-Type: text/xml");
		echo GenerateRSS($result, $CalendarID, $calendardata['name'] .": ".$calendardata['title'], BASEURL);
		break;
	case "rss1_0":
		if (!isset($_GET['raw'])) Header("Content-Type: text/xml");
		echo GenerateRSS1_0($result, $CalendarID, $calendardata['name'] .": ".$calendardata['title'], BASEURL);
		break;
	case "rss2_0":
		if (!isset($_GET['raw'])) Header("Content-Type: text/xml");
		echo GenerateRSS2_0($result, $CalendarID, $calendardata['name'] .": ".$calendardata['title'], BASEURL, BASEURL.EXPORTURL.'?'.http_build_query($_GET));
		break;
	case "xml":
		if (!isset($_GET['raw'])) Header("Content-Type: text/xml");
		echo GenerateXML($result, $CalendarID, $calendardata['name'] .": ".$calendardata['title'], BASEURL);
		break;
	case "ical":
		if (!isset($_GET['raw'])) Header("Content-Type: text/calendar; charset=\"utf-8\"; name=\"export.ics\"");
		if (!isset($_GET['raw'])) Header("Content-disposition: attachment; filename=export.ics");
		echo GenerateICal($result, $CalendarID, $calendardata['name'] .": ".$calendardata['title'], BASEURL);
		break;
	case "vxml":
		if (!isset($_GET['raw'])) Header("Content-Type: text/xml");
		echo GenerateVXML($result);
		break;
	case "html":
		if (!isset($_GET['raw'])) Header("Content-Type: text/html");
		echo GenerateHTML($result);
		break;
	case "js":
		if (!isset($_GET['raw'])) Header("Content-Type: application/x-javascript");
		echo GenerateJSArray($result, $CalendarID, BASEURL);
		break;
	default:
		echo "Format not supported";
}




/**
 * Build a query for exporting events.
 * @param int the ID for calendar to retrieve events from.
 * @param array the parameters to get the query by.
 * @return string the query.
 */
function BuildExportQuery($CalendarID, &$FormData) {
	$query = "SELECT e.id, e.description, e.timebegin, e.timeend, e.title, e.wholedayevent, e.categoryid, e.location, e.displayedsponsor, e.sponsorid, c.name as category_name, s.name as sponsor_name FROM vtcal_event_public e, vtcal_sponsor s, vtcal_category c WHERE e.calendarid='". sqlescape($CalendarID) ."' AND e.categoryid = c.id AND e.sponsorid = s.id";
	
	// Filter by date.
	if (isset($FormData['timebegin'])) {
		if ($FormData['timebegin'] == "upcoming") {
			$query .= " AND (e.timebegin >= '" . sqlescape(NOW_AS_TEXT) ."' OR e.timeend < '" . sqlescape(NOW_AS_TEXT) ."') ";
			$BeginTicks = NOW;
		}
		elseif ($FormData['timebegin'] == "today") {
			$query .= " AND e.timebegin >= '" . sqlescape(substr(NOW_AS_TEXT, 0, 10))." 00:00:00' ";
			$BeginTicks = NOW;
		}
		else {
			$query .= " AND e.timebegin >= '" . sqlescape($FormData['timebegin']). " 00:00:00' ";
			$BeginTicks = strtotime($FormData['timebegin']);
		}
		
		if (isset($FormData['timeend'])) {
			if (isValidInput($FormData['timeend'], 'int_gte1')) {
				$query .= " AND e.timeend <= '" . sqlescape(date("Y-m-d", strtotime($FormData['timeend']." day", $BeginTicks))) . " 23:59:59' ";
			}
			else {
				$query .= " AND e.timeend <= '" . sqlescape($FormData['timeend']). " 23:59:59' ";
			}
		}
	}
	
	// Show only the specified categories.
	if (isset($FormData['categories']) && count($FormData['categories']) > 0) {
		$query .= " AND (";
		for ($i = 0; $i < count($FormData['categories']); $i++) {
			if ($i > 0) $query .= " OR ";
			$query .= " e.categoryid = '".sqlescape($FormData['categories'][$i])."' ";
		}
		$query .= ") ";
	}
	
	// Filter by the specified sponsor string, if one was specified.
	if ($FormData['sponsor'] == "specific") {
		$query .= " AND e.displayedsponsor LIKE '%" . sqlescape($FormData['specificsponsor']) . "%'";
	}
	
	// Order the query
	$query .= " ORDER BY e.timebegin, e.title";
	
	// Append a LIMIT if a maximum number of events was specified.
	if (isset($FormData['maxevents'])) $query .= ' LIMIT ' . $FormData['maxevents'];
	
	return $query;
}
?>