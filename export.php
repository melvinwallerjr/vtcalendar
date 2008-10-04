<?php
require_once('session_start.inc.php');
header("Cache-control: private");
require_once('application.inc.php');
require_once("icalendar.inc.php");

// translates text into XML text, writing entity names like "&amp;" instead of "&"
function text2xmltext($text) {
	return htmlspecialchars(ereg_replace("\'","&apos;",$text));
}

if (isset($_GET['cancel'])) setVar($cancel,$_GET['cancel'],'cancel'); else unset($cancel);
if (isset($_GET['type'])) setVar($type,$_GET['type'],'type'); else unset($type);
if (isset($_GET['sponsortype'])) setVar($sponsortype,$_GET['sponsortype'],'sponsortype'); else unset($sponsortype);
if (isset($_GET['eventid'])) setVar($eventid,$_GET['eventid'],'eventid'); else unset($eventid);
if (isset($_GET['timebegin'])) setVar($timebegin,$_GET['timebegin'],'timebegin'); else unset($timebegin);
if (isset($_GET['timebegin_year'])) setVar($timebegin_year,$_GET['timebegin_year'],'timebegin_year'); else unset($timebegin_year);
if (isset($_GET['timebegin_month'])) setVar($timebegin_month,$_GET['timebegin_month'],'timebegin_month'); else unset($timebegin_month);
if (isset($_GET['timebegin_day'])) setVar($timebegin_day,$_GET['timebegin_day'],'timebegin_day'); else unset($timebegin_day);
if (isset($_GET['timeend'])) setVar($timeend,$_GET['timeend'],'timeend'); else unset($timeend);
if (isset($_GET['timeend_year'])) setVar($timeend_year,$_GET['timeend_year'],'timeend_year'); else unset($timeend_year);
if (isset($_GET['timeend_month'])) setVar($timeend_month,$_GET['timeend_month'],'timeend_month'); else unset($timeend_month);
if (isset($_GET['timeend_day'])) setVar($timeend_day,$_GET['timeend_day'],'timeend_day'); else unset($timeend_day);
if (isset($_GET['rangedays'])) setVar($rangedays,$_GET['rangedays'],'rangedays'); else unset($rangedays);
if (isset($_GET['categoryid'])) setVar($categoryid,$_GET['categoryid'],'categoryid'); else unset($categoryid);
if (isset($_GET['categoryidlist'])) setVar($categoryidlist,$_GET['categoryidlist'],'categoryidlist'); else unset($categoryidlist);
if (isset($_GET['keyword'])) setVar($keyword,$_GET['keyword'],'keyword'); else unset($keyword);
if (isset($_GET['specificsponsor'])) setVar($specificsponsor,$_GET['specificsponsor'],'specificsponsor'); else unset($specificsponsor);

if ( isset($_SERVER["HTTPS"]) ) { $calendarurl = "https"; } else { $calendarurl = "http"; } 
$calendarurl .= "://".$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'], "/"))."/";
		
if (!viewauthorized()) exit;

if (isset($cancel)) {
	redirect2URL("update.php");
	exit;
}

// Check if the submitted data is valid
$doExport = isset($type) && ($type == "xml" || $type == "rss" || $type == "ical" || $type == "rss1_0" || $type == "vxml");

// Display the form if we are not doing the export.
if (!$doExport) {
	if (!defined("NOEXPORTFORM")) {
		require("export-form.inc.php");
	}
}

// Otherwise, output the export data
else {
	// determine which sponsors to show
	if ($sponsortype=="self" && !empty($_SESSION["AUTH_SPONSORID"])) { 
		$displayedsponsor = $_SESSION["AUTH_SPONSORID"];
	}
	elseif ($sponsortype == "specific") {
		$displayedsponsor = $specificsponsor; 
	}
	else {
		$displayedsponsor = ""; 
	}

	// Ignore the date range if the event ID is specified.
	if (isset($eventid)) {
		$timebegin = "";
		$timeend = "";
	}
	else {
		// determine today's date
		$today = Decode_Date_US(date("m/d/Y", NOW));
		if (isset($timebegin) && $timebegin == "now") {
			$timebegin = date("Y-m-d H:i:s", NOW);
		}
		elseif (!isset($timebegin) || $timebegin=="today") {
			if (isset($timebegin_year)) { // details was called from the searchform
				$timebegin = datetime2timestamp($timebegin_year,$timebegin_month,$timebegin_day,12,0,"am");
			}
			else { // details is called without any time limits, use "today" as default
				$timebegin = datetime2timestamp($today['year'],$today['month'],$today['day'],12,0,"am");
			}
		}
	
		if (!isset($timeend) || $timeend=="today") {
			if (isset($timeend_year)) {
				$timeend = datetime2timestamp($timeend_year,$timeend_month,$timeend_day,11,59,"pm");
			}
			if (isset($timeend) && $timeend=="today") {
				$timeend = datetime2timestamp($today['year'],$today['month'],$today['day'],11,59,"pm");
			}
		}
		if (isset($rangedays)) {
			$timebeginrange = timestamp2datetime($timebegin);
			$timeendrange = Add_Delta_Days($timebeginrange['month'],$timebeginrange['day'],$timebeginrange['year'],$rangedays);
			$timeend = datetime2timestamp($timeendrange['year'],$timeendrange['month'],$timeendrange['day'],11,59,"pm");
		}
	}

	if (!isset($categoryid)) { $categoryid=0; }
	if (!isset($keyword)) { $keyword=""; }

	$query = "SELECT e.recordchangedtime,e.recordchangeduser,e.repeatid,e.id AS id,e.timebegin,e.timeend,e.sponsorid,e.displayedsponsor,e.displayedsponsorurl,e.title,e.wholedayevent,e.categoryid,e.description,e.location,e.price,e.contact_name,e.contact_phone,e.contact_email,c.id AS cid,c.name AS category_name,s.id AS sid,s.name AS sponsor_name,s.url AS sponsor_url FROM vtcal_event_public e, vtcal_category c, vtcal_sponsor s WHERE e.calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' AND c.calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' AND e.categoryid = c.id AND e.sponsorid = s.id";

	if (!empty($eventid))  { $query.= " AND e.id='".sqlescape($eventid)."'"; }
	if (!empty($timebegin)) { 
		$date = substr($timebegin,0,10);
		$query.= " AND (";
		// also get "all day" events
		//$query.= "(e.timebegin = '".sqlescape($date)." 00:00:00' AND e.timeend = '".sqlescape($date)." 23:59:00')"; 
		$query.= "(e.timebegin = '".sqlescape($date)." 00:00:00' AND e.wholedayevent = '1')"; 
		$query.= " OR e.timebegin >= '".sqlescape($timebegin)."')"; 
	}
	if (!empty($timeend)) { $query.= " AND e.timeend <= '".sqlescape($timeend)."'"; }
	if (!empty($displayedsponsor))  { $query.= " AND e.displayedsponsor LIKE '%".sqlescape($displayedsponsor)."%'"; }

	if (!empty($categoryidlist)) {
		$query.= " AND (";
		$aCategoryIdList = explode(",",$categoryidlist);
		$i=0;
		foreach($aCategoryIdList as $sCategoryId) {
			if (isValidInput($sCategoryId, 'categoryid')) {
				$i++;
				if ($i > 1) {
					$query.= " OR "; 
				}
				$query.= "e.categoryid='".sqlescape($sCategoryId)."'"; 
			}
		}
		$query.= ")";
	}
	else {
			if (isset($categoryid) && $categoryid!=0) { 
			$query.= " AND e.categoryid='".sqlescape($categoryid)."'"; 
		}
	}

	if (!empty($keyword)) { $query.= " AND ((e.title LIKE '%".sqlescape($keyword)."%') or (e.description LIKE '%".sqlescape($keyword)."%'))"; }
	$query.= " ORDER BY e.timebegin ASC, e.wholedayevent DESC";
	
	$result =& DBQuery($query ); 
	
	if (!is_string($result)) {
		if ($type == "rss") {
			Header("Content-Type: text/xml");
			echo GenerateRSS($result, $_SESSION['CALENDAR_ID'], $_SESSION['CALENDAR_TITLE'], $calendarurl, $timebegin);
		}
		if ($type == "rss1_0") { 
			Header("Content-Type: text/xml");
			echo GenerateRSS1_0($result, $_SESSION['CALENDAR_ID'], $_SESSION['CALENDAR_TITLE'], $calendarurl, $timebegin);
		}
		elseif ($type == "xml") {
			Header("Content-Type: text/xml");
			echo GenerateXML($result, $_SESSION['CALENDAR_ID'], $_SESSION['CALENDAR_TITLE'], $calendarurl, $timebegin);
		}
		elseif ($type == "ical") {
			Header("Content-Type: text/calendar; charset=\"utf-8\"; name=\"".$icalname.".ics\"");
			Header("Content-disposition: attachment; filename=".$icalname.".ics");
			echo GenerateICal($result, $_SESSION['CALENDAR_ID'], $_SESSION['CALENDAR_NAME'], $calendarurl, $timebegin);
		}
		elseif ($type == "vxml") {
			Header("Content-Type: text/xml");
			echo GenerateVXML($result);
		}
	}
}

DBclose();
?>