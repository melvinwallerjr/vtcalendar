<?php
/*
1. Defines some color constants.
2. Includes other function files.
3. Defines various other contants.
4. Defines numerous functions:
		
		Misc Functions:
		----------------------------------------------------
		function getNewEventId()
		function feedback($msg,$type)
		function verifyCancelURL($httpreferer)
		function redirect2URL($url)
		function getFullCalendarURL($calendarid)
		function sendemail2sponsor($sponsorname,$sponsoremail,$subject,$body)
		function sendemail2user($useremail,$subject,$body)
		function highlight_keyword($keyword, $text)
		function make_clickable($text)
		function removeslashes(&$event)
		function checkURL($url)
		function checkemail($email)
		function setVar(&$var,$value,$type)
		function lang($sTextKey)
		function escapeJavaScriptString($string)
		
		Generic Database Functions:
		----------------------------------------------------
		function DBopen()
		function DBclose()
		function DBQuery($query)
		
		Authenticate users:
		----------------------------------------------------
		function checknewpassword(&$user)
		function checkoldpassword(&$user,$userid)
		function displaylogin($errormsg="")
		function displaymultiplelogin($errorMessage="")
		function displaynotauthorized()
		function userauthenticated($userid,$password)
		function authorized()
		function viewauthorized()
		function logout()
		
		Get various information from the database:
		----------------------------------------------------
		function getCalendarData($calendarid)
		function calendar_exists($calendarid)
		function setCalendarPreferences()
		function getNumCategories()
		function getCategoryName($categoryid)
		function getCalendarName($calendarid)
		function getSponsorCalendarName($sponsorid)
		function getSponsorName($sponsorid)
		function getSponsorURL($sponsorid)
		function num_unapprovedevents($repeatid)
		function userExistsInDB($userid)
		function isValidUser($userid)
		
		Date/Time Conversions & Formatting:
		----------------------------------------------------
		function datetocolor($month,$day,$year,$colorpast,$colortoday,$colorfuture)
		function datetoclass($month,$day,$year)
		function printeventdate(&$event)
		function printeventtime(&$event)
		function yearmonth2timestamp($year,$month)
		function yearmonthday2timestamp($year,$month,$day)
		function datetime2timestamp($year,$month,$day,$hour,$min,$ampm)
		function timestamp2datetime($timestamp)
		function timestamp2timenumber($timestamp)
		function timenumber2timelabel($timenum)
		function datetime2ISO8601datetime($year,$month,$day,$hour,$min,$ampm)
		function ISO8601datetime2datetime($ISO8601datetime)
		function disassemble_eventtime(&$event)
		function settimeenddate2timebegindate(&$event)
		function assemble_eventtime(&$event)
		function timestring($hour,$min,$ampm)
		function endingtime_specified(&$event)
		
		Message Windows:
		----------------------------------------------------
		function contentsection_begin($headertext="", $showBackToMenuButton=false)
		function contentsection_end()
		function helpwindow_header()
		function helpwindow_footer()
		
		Event Date/Time Functions:
		----------------------------------------------------
		function inputdate($month,$monthvar,$day,$dayvar,$year,$yearvar)
		function readinrepeat($repeatid,&$event,&$repeat)
		function repeatinput2repeatdef(&$event,&$repeat)
		function getfirstslice($s)
		function repeatdefdisassemble($repeatdef,&$frequency,&$interval,&$frequencymodifier,&$endyear,&$endmonth,&$endday)
		function printrecurrence($startyear,$startmonth,$startday,$repeatdef)
		function repeatdefdisassembled2repeatlist($startyear,$startmonth,$startday,$frequency,$interval,$frequencymodifier,$endyear,$endmonth,$endday) {
		function producerepeatlist(&$event,&$repeat)
		function printrecurrencedetails(&$repeatlist)
		function repeatdef2repeatinput($repeatdef,&$event,&$repeat)
		
		Modification of events:
		----------------------------------------------------
		function deletefromevent($eventid)
		function deletefromevent_public($eventid)
		function repeatdeletefromevent($repeatid)
		function repeatdeletefromevent_public($repeatid)
		function deletefromrepeat($repeatid)
		function insertintoevent($eventid,&$event)
		function insertintoeventsql($calendarid,$eventid,&$event)
		function insertintoevent_public(&$event)
		function updateevent($eventid,&$event)
		function updateevent_public($eventid,&$event)
		function insertintotemplate($template_name,&$event)
		function updatetemplate($templateid,$template_name,&$event)
		function insertintorepeat($repeatid,&$event,&$repeat)
		function updaterepeat($repeatid,&$event,&$repeat)
		function publicizeevent($eventid,&$event)
		function repeatpublicizeevent($eventid,&$event)
*/
	
  require_once("datecalc.inc.php");
  require_once("header.inc.php");
  require_once("email.inc.php");
  
	require_once("functions-misc.inc.php");
	require_once("functions-dbgeneric.inc.php");
	require_once("functions-authentication.inc.php");
	require_once("functions-dates.inc.php");
	require_once("functions-event-dates.inc.php");
	require_once("functions-event-db.inc.php");
	require_once("functions-content.inc.php);
?>