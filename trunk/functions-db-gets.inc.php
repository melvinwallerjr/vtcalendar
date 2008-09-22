<?php
// Gets the data for a calendar.
// Returns a DB row if successful.
// Returns a number if more than one row was found.
// Returns a string of a DB error occurred.
function getCalendarData($calendarid) {
	$result = DBQuery("SELECT * FROM vtcal_calendar WHERE id='".sqlescape($calendarid)."'");
	
	if ( is_string($result) ) {
		return $result;
	}
	elseif ($result->numRows() != 1) {
		return $result->numRows();
	}
	else {
		return $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	}
}

// Determine if a calendar with the specified ID exists.
// Returns true if the calendar eixsts. False otherwise.
// Returns a string of a DB error occurred.
function calendar_exists($calendarid) {
	$result = DBQuery("SELECT count(id) FROM vtcal_calendar WHERE id='".sqlescape($calendarid)."'" );
	$r = $result->fetchRow(0);
	return ($r[0]==1);
}

function setCalendarPreferences() {
	$result = DBQuery("SELECT * FROM vtcal_calendar WHERE id='".sqlescape($_SESSION['CALENDAR_ID'])."'" );
	$calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	
	$_SESSION['CALENDAR_TITLE'] = $calendar['title'];
	$_SESSION['CALENDAR_NAME'] = $calendar['name'];
	$_SESSION['CALENDAR_HEADER'] = $calendar['header'];
	$_SESSION['CALENDAR_FOOTER'] = $calendar['footer'];
	$_SESSION['CALENDAR_VIEWAUTHREQUIRED'] = $calendar['viewauthrequired'];
	$_SESSION['CALENDAR_FORWARD_EVENT_BY_DEFAULT'] = $calendar['forwardeventdefault'];
	
	// TODO: Query to load color table
	/*

Search (calendar.css.php):

// (.+)
\$_SESSION\['COLOR_([^']+)'\] = "([^"]+)";

Replace:

if (isset($result['\l2'])) { setVar($_SESSION['COLOR_\2'], $result['\l2'], 'color'); }

For sql replace:

  `\l2` char(7) NOT NULL,

*/
	
	
if (isset($result['bg'])) { setVar($_SESSION['COLOR_BG'], $result['bg'], 'color'); }
if (isset($result['text'])) { setVar($_SESSION['COLOR_TEXT'], $result['text'], 'color'); }
if (isset($result['text_faded'])) { setVar($_SESSION['COLOR_TEXT_FADED'], $result['text_faded'], 'color'); }
if (isset($result['text_warning'])) { setVar($_SESSION['COLOR_TEXT_WARNING'], $result['text_warning'], 'color'); }
if (isset($result['link'])) { setVar($_SESSION['COLOR_LINK'], $result['link'], 'color'); }
if (isset($result['body'])) { setVar($_SESSION['COLOR_BODY'], $result['body'], 'color'); }
if (isset($result['today'])) { setVar($_SESSION['COLOR_TODAY'], $result['today'], 'color'); }
if (isset($result['todaylight'])) { setVar($_SESSION['COLOR_TODAYLIGHT'], $result['todaylight'], 'color'); }
if (isset($result['light_cell_bg'])) { setVar($_SESSION['COLOR_LIGHT_CELL_BG'], $result['light_cell_bg'], 'color'); }
if (isset($result['table_header_text'])) { setVar($_SESSION['COLOR_TABLE_HEADER_TEXT'], $result['table_header_text'], 'color'); }
if (isset($result['table_header_bg'])) { setVar($_SESSION['COLOR_TABLE_HEADER_BG'], $result['table_header_bg'], 'color'); }
if (isset($result['border'])) { setVar($_SESSION['COLOR_BORDER'], $result['border'], 'color'); }
if (isset($result['keyword_highlight'])) { setVar($_SESSION['COLOR_KEYWORD_HIGHLIGHT'], $result['keyword_highlight'], 'color'); }
if (isset($result['h2'])) { setVar($_SESSION['COLOR_H2'], $result['h2'], 'color'); }
if (isset($result['h3'])) { setVar($_SESSION['COLOR_H3'], $result['h3'], 'color'); }
if (isset($result['title'])) { setVar($_SESSION['COLOR_TITLE'], $result['title'], 'color'); }
if (isset($result['tabgrayed'])) { setVar($_SESSION['COLOR_TABGRAYED'], $result['tabgrayed'], 'color'); }
if (isset($result['filternotice_bg'])) { setVar($_SESSION['COLOR_FILTERNOTICE_BG'], $result['filternotice_bg'], 'color'); }
if (isset($result['filternotice_font'])) { setVar($_SESSION['COLOR_FILTERNOTICE_FONT'], $result['filternotice_font'], 'color'); }
if (isset($result['filternotice_fontfaded'])) { setVar($_SESSION['COLOR_FILTERNOTICE_FONTFADED'], $result['filternotice_fontfaded'], 'color'); }
if (isset($result['filternotice_bgimage'])) { setVar($_SESSION['COLOR_FILTERNOTICE_BGIMAGE'], $result['filternotice_bgimage'], 'color'); }
if (isset($result['eventbar_past'])) { setVar($_SESSION['COLOR_EVENTBAR_PAST'], $result['eventbar_past'], 'color'); }
if (isset($result['eventbar_current'])) { setVar($_SESSION['COLOR_EVENTBAR_CURRENT'], $result['eventbar_current'], 'color'); }
if (isset($result['eventbar_future'])) { setVar($_SESSION['COLOR_EVENTBAR_FUTURE'], $result['eventbar_future'], 'color'); }
if (isset($result['monthdaylabels_past'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_PAST'], $result['monthdaylabels_past'], 'color'); }
if (isset($result['monthdaylabels_current'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_CURRENT'], $result['monthdaylabels_current'], 'color'); }
if (isset($result['monthdaylabels_future'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_FUTURE'], $result['monthdaylabels_future'], 'color'); }
if (isset($result['othermonth'])) { setVar($_SESSION['COLOR_OTHERMONTH'], $result['othermonth'], 'color'); }
if (isset($result['littlecal_today'])) { setVar($_SESSION['COLOR_LITTLECAL_TODAY'], $result['littlecal_today'], 'color'); }
if (isset($result['littlecal_highlight'])) { setVar($_SESSION['COLOR_LITTLECAL_HIGHLIGHT'], $result['littlecal_highlight'], 'color'); }
if (isset($result['littlecal_fontfaded'])) { setVar($_SESSION['COLOR_LITTLECAL_FONTFADED'], $result['littlecal_fontfaded'], 'color'); }
if (isset($result['littlecal_line'])) { setVar($_SESSION['COLOR_LITTLECAL_LINE'], $result['littlecal_line'], 'color'); }
if (isset($result['gobtn_bg'])) { setVar($_SESSION['COLOR_GOBTN_BG'], $result['gobtn_bg'], 'color'); }
if (isset($result['gobtn_border'])) { setVar($_SESSION['COLOR_GOBTN_BORDER'], $result['gobtn_border'], 'color'); }
	
	/*$_SESSION["BGCOLOR"] = $calendar['bgcolor'];
	$_SESSION["MAINCOLOR"] = $calendar['maincolor'];
	$_SESSION["TODAYCOLOR"] = $calendar['todaycolor'];
	$_SESSION["PASTCOLOR"] = $calendar['pastcolor'];		
	$_SESSION["FUTURECOLOR"] = $calendar['futurecolor'];		
	$_SESSION["TEXTCOLOR"] = $calendar['textcolor'];		
	$_SESSION["LINKCOLOR"] = $calendar['linkcolor'];		
	$_SESSION["GRIDCOLOR"] = $calendar['gridcolor'];*/
	
	$result = DBQuery("SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' AND admin='1'" ); 
	$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	$_SESSION['CALENDAR_ADMINEMAIL'] = $sponsor['email'];
}

function getNumCategories() {
	$result = DBQuery("SELECT count(*) FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."'" ); 
	$r = $result->fetchRow(0);
	return $r[0];
}

/* Get the name of a category from the database */
function getCategoryName($categoryid) {
	$result = DBQuery("SELECT name FROM vtcal_category WHERE id='".sqlescape($categoryid)."'" );
	if ($result->numRows() > 0) {
		$category = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		return $category['name'];
	}
	else {
		return "";
	}
}

/* Get the name of a calendar from the database */
function getCalendarName($calendarid) {
	$result = DBQuery("SELECT name FROM vtcal_calendar WHERE id='".sqlescape($calendarid)."'" );
	if ($result->numRows() > 0) {
		$calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		return $calendar['name'];
	}
	else {
		return "";
	}
}

/* Get the name of a calendar that a sponsor belongs to from the database */
function getSponsorCalendarName($sponsorid) {
	$result = DBQuery("SELECT c.name FROM vtcal_sponsor AS s, vtcal_calendar AS c WHERE s.id = '".sqlescape($sponsorid)."' AND c.id = s.calendarid");
	if ($result->numRows() > 0) {
		$calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		return $calendar['name'];
	}
	else {
		return "";
	}
}

/* Get the name of a sponsor from the database */
function getSponsorName($sponsorid) {
	$result = DBQuery("SELECT name FROM vtcal_sponsor WHERE id='".sqlescape($sponsorid)."'" );
	if ($result->numRows() > 0) {
		$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		return $sponsor['name'];
	}
	else {
		return "";
	}
}

/* Get the URL of a sponsor from the database */
function getSponsorURL($sponsorid) {
	$result = DBQuery("SELECT url FROM vtcal_sponsor WHERE id='".sqlescape($sponsorid)."'" );
	if ($result->numRows() > 0) {
		$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		return $sponsor['url'];
	}
	else {
		return "";
	}
}

// Get the number of unapproved events for an entire calendar. */
function num_unapprovedevents($repeatid) {
	$result = DBQuery("SELECT id FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' AND repeatid='".sqlescape($repeatid)."' AND approved=0"); 
	return $result->numRows();
}

// returns true if a particular userid exists in the database
function userExistsInDB($userid) {
	if ( AUTH_DB ) {
		$query = "SELECT count(id) FROM vtcal_user WHERE id='".sqlescape($userid)."'";
		$result = DBQuery($query ); 
		$r = $result->fetchRow(0);
		if ($r[0]>0) { return true; }
	}
	
	return false; // default rule
}

// returns true if the user-id is valid
function isValidUser($userid) {
	
	// If we are using HTTP authentication, we must assume all
	// users are valid, since we have no way of verifying HTTP users.
	if ( AUTH_HTTP ) {
		return true;
	}
	
	if ( AUTH_DB ) {
		$query = "SELECT count(id) FROM vtcal_user WHERE id='".sqlescape($userid)."'";
		$result = DBQuery($query ); 
		$r = $result->fetchRow(0);
		if ($r[0]>0) { return true; }
	}
	
	if ( AUTH_LDAP ) {
		// TODO: Checks against the LDAP
		return preg_match(REGEXVALIDUSERID, $userid);
	}

	return false; // default rule
}
?>