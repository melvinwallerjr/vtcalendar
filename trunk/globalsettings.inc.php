<?php
// Allow any script that includes globalsettings.inc.php include files that restrict their access.
define("ALLOWINCLUDES", TRUE);

// Include the necessary files.
require_once('DB.php');
require_once('config.inc.php');
require_once('inputvalidation.inc.php');
require_once('functions.inc.php');
require_once('languages/'.LANGUAGE.'.inc.php');
require_once("content_modules.inc.php");

/* ============================================================
                Open the database connection
============================================================ */

define("DBCONNECTION", DBOpen());
if (is_string(DBCONNECTION)) {
	include("dberror.php");
	exit;
}

/* ============================================================
         Constants that define valid values for fields.
============================================================ */

define("REGEXVALIDCOLOR","/^#[ABCDEFabcdef0-9]{6,6}$/");
//NOT USED define("BGCOLORNAVBARACTIVE","#993333");
//NOT USED define("BGCOLORWEEKMONTHNAVBAR","#993333");
//NOT USED define("BGCOLORDETAILSHEADER","#993333");
define("MAXLENGTH_URL","100");
define("MAXLENGTH_TITLE","75");
define("MAXLENGTH_DESCRIPTION","5000");
define("MAXLENGTH_LOCATION","100");
define("MAXLENGTH_PRICE","100");
define("MAXLENGTH_CONTACT_NAME","100");
define("MAXLENGTH_CONTACT_PHONE","100");
define("MAXLENGTH_CONTACT_EMAIL","100");
define("MAXLENGTH_SPONSOR","50");
define("FEEDBACKPOS","0");
define("FEEDBACKNEG","1");

/* ============================================================
                   Current date and time
============================================================ */

define("NOW", date("Y-m-d H:i:s"));
define("NOW_AS_TIMENUM",  timestamp2timenumber(NOW));

/* ============================================================
           Load the calendar preferences and logout
============================================================ */

// Get the specified calendar ID from the query string, either as 'calendarid' or 'calendar'.
if (isset($_GET['calendarid'])) {
	$calendarid = $_GET['calendarid'];
}
elseif (isset($_GET['calendar'])) {
	$calendarid = $_GET['calendar'];
}

// Unset the calendar ID if it is invalid.
if (!isValidInput($calendarid,'calendarid')) {
	unset($calendarid);
}

// Unset the calendar ID if it is already set in the session.
if (isset($_SESSION["CALENDARID"]) && isset($calendarid) && $_SESSION["CALENDARID"] == $calendarid) {
	unset($calendarid);
}

// Set a default calendar if one was not specified in the query string or session.
if (!isset($_SESSION["CALENDARID"]) && !isset($calendarid)) {
  $calendarid = "default";
}

// If the calendar ID was specified then load that calendar
if (isset($calendarid)) { 
  if (calendar_exists($calendarid)) { 
    $_SESSION["CALENDARID"] = $calendarid;
    setCalendarPreferences();
		logout();
  }
}

/* ============================================================
                        Define colors
============================================================ */

$colorpast = $_SESSION["PASTCOLOR"];
$colortoday  = $_SESSION["TODAYCOLOR"];
$colorfuture = $_SESSION["FUTURECOLOR"];

/* ============================================================
                  Fixes for slow browsers
============================================================ */
if ( $_SERVER["HTTP_USER_AGENT"] == "Mozilla/4.0 (compatible; MSIE 5.22; Mac_PowerPC)" ) {
	$enableViewMonth = false;
} 
else { 
  $enableViewMonth = true; 
}

/* ============================================================
     Set up the week starting day and time display format.
============================================================ */

// Sets variable to according to week starting day specified in "config.inc.php".
// Sunday is default week starting day if WEEK_STARTING_DAY isn't defined in "config.inc.php'
if (WEEK_STARTING_DAY == 0 || WEEK_STARTING_DAY == 1 ) {
    $week_start = WEEK_STARTING_DAY;
}
else {
  $week_start = 0;  
}

if (USE_AMPM == false) {
  $use_ampm = false;
  $day_beg_h = 0; // if 0:00 - 23:00 time format is used, appropriate day start/end hours will be passed to datetime2timestamp funtions where calculating day edges
  $day_end_h = 23;
}
else {
  $use_ampm = true;
  $day_beg_h = 0;
  $day_end_h = 11;
}
?>