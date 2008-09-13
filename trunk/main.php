<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
/*

How this script executes:

1. Include globalsettings.inc.php
	A. Includes config.inc.php
		- Defines calendar configuration settings.
	B. Determine if a new calendar ID was set.
	C. If a new calendar ID was set, then reload preferences and logout the user.
	D. If the session variable is not set, then set it to the default, reload preferences and log the user out.
	E. If the visitor is using an old browser, exclude month view.
	F. Setup the week starting day, and whether or not we are using a 24-clock.

2. Includes functions.inc.php
	A. Defines some color constants.
	B. Includes other function files.
	C. Defines various other contants.

3. Includes main_globalsettings.inc.php
  A. Sets various variables if they are in the _POST, _GET or _COOKIE.
	B. Checks if 'userid' and 'password' were submitted in the _POST. If so, validates and sets. If not, unsets.
	C. Attempts to pull the current 'view' from _GET or _SESSION. If either is found, validates and sets. If not, unsets.
	D. Checks if the 'eventid', 'categoryid', 'sponsorid', 'keyword', 'filtercategories' and various time filters are in the _GET. If so, validates and sets. If not, unsets.
	E. Checks for a 'CategoryFilter' cookie. If so, validates and sets. If not, unsets.

4. Open the database and verify that the user is authorized.
	A. If the calendar does not require authentication, then return authorized.
	B. If authentication is required...
		a. If the user is already logged in, then return authorized.
		b. Otherwise, show the login form (and make sure SSL is being used).

5. Set the 'view' to a default if necessary, and make sure the current view is allowed or possible.

6. Setup begin/end time filters and variables.

7. Set the default body color, but set it to the 'today' color if only today is being viewed.
*/
	require_once('globalsettings.inc.php');
	require_once('main_globalsettings.inc.php');
	
	// Verify that the user is authorized.
	if (!viewauthorized()) { exit; }

	// Set the default body color.
	$bodycolor = $_SESSION['MAINCOLOR'];
	
	// By default, do not show the "today" color.
	$IsTodayBodyColor = 0;
	
	// if only today is shown highlight it
	if ( $view == "day" ) { 
		if ( $showdate['day']==$today['day'] && $showdate['month']==$today['month'] && $showdate['year']==$today['year']) {
				$IsTodayBodyColor = 1;
	  		$bodycolor = $colortoday; 
		}
	}
	
	// read all categories from the DB in two arrays
	$result = DBQuery("SELECT * FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY name" ); 
	$numcategories = $result->numRows();
	for ($c=0; $c<$numcategories; $c++) {
	  $categorydata = $result->fetchRow(DB_FETCHMODE_ASSOC, $c);
		$categories_id[$c]= $categorydata['id'];
		$categories_name[$c]= $categorydata['name'];
	}

	if ( isset($filtercategories) ) {
		if ( count($filtercategories)==$numcategories  ) {
		  unset($filtercategories); // if all categories are selected that means there is NO filter
			setcookie ("CategoryFilter", "", time()-(3600*24), BASEPATH, BASEDOMAIN); // delete filter cookie
		}
		else {		
			$categoryfilter = array_flip ( $filtercategories );
			// set a cookie
			$filtercookie = "";
			for($c=0; $c<count($filtercategories); $c++) {
				if ($c > 0) { $filtercookie .= ","; }		
				$filtercookie .= $filtercategories[$c];
			}
			setcookie ("CategoryFilter", $filtercookie, time()+3600*24*365, BASEPATH, BASEDOMAIN);
		}
	}
	else {
	  // check for existence of a cookie & read it
		if ( isset($CategoryFilter) ) {
			$filtercategories = split ( ",", $CategoryFilter );
			$categoryfilter = array_flip ( $filtercategories );
		}
		if ( isset($filtercategories) && count($filtercategories)==$numcategories ) {
		  unset($filtercategories); // if all categories are selected that means there is NO filter
		  unset($categoryfilter);
			setcookie ("CategoryFilter", $filtercookie, time()-3600, BASEPATH, BASEDOMAIN); // delete filter cookie
		}
	}
	
	// The base text for the page title, which can be changed by the main_(view)_data.inc.php files.
	$basetitle = "";
	
	// Load any information that we may need to display in the header.
	// Typically this only changes the base title, however, it may load data from the database.
	// A situation where it will do this is with events, since it will want to output the event title in the <title> tag.
	require("main_".$view."_data.inc.php");
	
	// Output the header HTML
	if ( $view == "day" ) {
		pageheader(lang('day_page_header').$basetitle, "Day");
	}
	elseif ( $view == "week" ) {
		pageheader(lang('week_page_header').$basetitle, "Week");
	}
	elseif ( $view == "month" ) { 
		pageheader(lang('month_page_header').$basetitle, "Month");
	}
	elseif ( $view == "event" ) { 
		pageheader(lang('event_page_header').$basetitle, "");
	}
	elseif ( $view == "search" ) { 
		pageheader(lang('search_page_header').$basetitle, "Search");
	}
	elseif ( $view == "searchresults" ) { 
		pageheader(lang('searchresults_page_header').$basetitle, "SearchResults");
	}
	elseif ( $view == "subscribe" ) { 
		pageheader(lang('subscribe_page_header').$basetitle, "Subscribe");
	}
	elseif ( $view == "filter" ) { 
		pageheader(lang('filter_page_header').$basetitle, "Filter");
	}

// Output the calendar table.
?>
<table id="CalendarTable" width="100%" border="0" cellpadding="8" cellspacing="0">
<tr>
	
<?php
// If the column should be on the left, output it first then the body.
if (COLUMNSIDE == "LEFT") {
	include('main_column.inc.php');
	include('main_body.inc.php');
}
// If the column should be on the right, output the body then the column.
elseif (COLUMNSIDE == "RIGHT") {
	include('main_body.inc.php');
	include('main_column.inc.php');
}
?>

</tr>
</table>
<table id="PoweredBy" width="100%" border="0" cellpadding="4" cellspacing="0"><tr><td align="right"><!--Powered by univCal <?php if (file_exists("VERSION.txt")) { include('VERSION.txt'); } ?>. --> Based on <a href="http://vtcalendar.sourceforge.net/" target="_blank">VTCalendar</a></td></tr></table>

<?php
	require("footer.inc.php");
	DBclose();
?>