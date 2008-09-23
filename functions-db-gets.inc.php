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
	$result =& DBQuery("SELECT * FROM vtcal_calendar WHERE id='".sqlescape($_SESSION['CALENDAR_ID'])."'" );
	if (is_string($result)) return $result;
	
	$calendar =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	$_SESSION['CALENDAR_TITLE'] = $calendar['title'];
	$_SESSION['CALENDAR_NAME'] = $calendar['name'];
	$_SESSION['CALENDAR_HEADER'] = $calendar['header'];
	$_SESSION['CALENDAR_FOOTER'] = $calendar['footer'];
	$_SESSION['CALENDAR_VIEWAUTHREQUIRED'] = $calendar['viewauthrequired'];
	$_SESSION['CALENDAR_FORWARD_EVENT_BY_DEFAULT'] = $calendar['forwardeventdefault'];
	$result->free();
	
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

	$result =& DBQuery("SELECT * FROM vtcal_colors WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."'" );
	if (is_string($result)) return $result;

	$record =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	
	// The following block should only come from the output of colors-dbload.xsl (run against colors.xml).
	if (isset($record['bg'])) { setVar($_SESSION['COLOR_BG'], $record['bg'], 'color'); }
	if (isset($record['text'])) { setVar($_SESSION['COLOR_TEXT'], $record['text'], 'color'); }
	if (isset($record['text_faded'])) { setVar($_SESSION['COLOR_TEXT_FADED'], $record['text_faded'], 'color'); }
	if (isset($record['text_warning'])) { setVar($_SESSION['COLOR_TEXT_WARNING'], $record['text_warning'], 'color'); }
	if (isset($record['link'])) { setVar($_SESSION['COLOR_LINK'], $record['link'], 'color'); }
	if (isset($record['body'])) { setVar($_SESSION['COLOR_BODY'], $record['body'], 'color'); }
	if (isset($record['today'])) { setVar($_SESSION['COLOR_TODAY'], $record['today'], 'color'); }
	if (isset($record['todaylight'])) { setVar($_SESSION['COLOR_TODAYLIGHT'], $record['todaylight'], 'color'); }
	if (isset($record['light_cell_bg'])) { setVar($_SESSION['COLOR_LIGHT_CELL_BG'], $record['light_cell_bg'], 'color'); }
	if (isset($record['table_header_text'])) { setVar($_SESSION['COLOR_TABLE_HEADER_TEXT'], $record['table_header_text'], 'color'); }
	if (isset($record['table_header_bg'])) { setVar($_SESSION['COLOR_TABLE_HEADER_BG'], $record['table_header_bg'], 'color'); }
	if (isset($record['border'])) { setVar($_SESSION['COLOR_BORDER'], $record['border'], 'color'); }
	if (isset($record['keyword_highlight'])) { setVar($_SESSION['COLOR_KEYWORD_HIGHLIGHT'], $record['keyword_highlight'], 'color'); }
	if (isset($record['h2'])) { setVar($_SESSION['COLOR_H2'], $record['h2'], 'color'); }
	if (isset($record['h3'])) { setVar($_SESSION['COLOR_H3'], $record['h3'], 'color'); }
	if (isset($record['title'])) { setVar($_SESSION['COLOR_TITLE'], $record['title'], 'color'); }
	if (isset($record['tabgrayed'])) { setVar($_SESSION['COLOR_TABGRAYED'], $record['tabgrayed'], 'color'); }
	if (isset($record['filternotice_bg'])) { setVar($_SESSION['COLOR_FILTERNOTICE_BG'], $record['filternotice_bg'], 'color'); }
	if (isset($record['filternotice_font'])) { setVar($_SESSION['COLOR_FILTERNOTICE_FONT'], $record['filternotice_font'], 'color'); }
	if (isset($record['filternotice_fontfaded'])) { setVar($_SESSION['COLOR_FILTERNOTICE_FONTFADED'], $record['filternotice_fontfaded'], 'color'); }
	if (isset($record['filternotice_bgimage'])) { setVar($_SESSION['COLOR_FILTERNOTICE_BGIMAGE'], $record['filternotice_bgimage'], 'color'); }
	if (isset($record['eventbar_past'])) { setVar($_SESSION['COLOR_EVENTBAR_PAST'], $record['eventbar_past'], 'color'); }
	if (isset($record['eventbar_current'])) { setVar($_SESSION['COLOR_EVENTBAR_CURRENT'], $record['eventbar_current'], 'color'); }
	if (isset($record['eventbar_future'])) { setVar($_SESSION['COLOR_EVENTBAR_FUTURE'], $record['eventbar_future'], 'color'); }
	if (isset($record['monthdaylabels_past'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_PAST'], $record['monthdaylabels_past'], 'color'); }
	if (isset($record['monthdaylabels_current'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_CURRENT'], $record['monthdaylabels_current'], 'color'); }
	if (isset($record['monthdaylabels_future'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_FUTURE'], $record['monthdaylabels_future'], 'color'); }
	if (isset($record['othermonth'])) { setVar($_SESSION['COLOR_OTHERMONTH'], $record['othermonth'], 'color'); }
	if (isset($record['littlecal_today'])) { setVar($_SESSION['COLOR_LITTLECAL_TODAY'], $record['littlecal_today'], 'color'); }
	if (isset($record['littlecal_highlight'])) { setVar($_SESSION['COLOR_LITTLECAL_HIGHLIGHT'], $record['littlecal_highlight'], 'color'); }
	if (isset($record['littlecal_fontfaded'])) { setVar($_SESSION['COLOR_LITTLECAL_FONTFADED'], $record['littlecal_fontfaded'], 'color'); }
	if (isset($record['littlecal_line'])) { setVar($_SESSION['COLOR_LITTLECAL_LINE'], $record['littlecal_line'], 'color'); }
	if (isset($record['gobtn_bg'])) { setVar($_SESSION['COLOR_GOBTN_BG'], $record['gobtn_bg'], 'color'); }
	if (isset($record['gobtn_border'])) { setVar($_SESSION['COLOR_GOBTN_BORDER'], $record['gobtn_border'], 'color'); }
	$result->free();
	
	$result =& DBQuery("SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' AND admin='1'" );
	if (is_string($result)) return $result;
	$sponsor =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	$_SESSION['CALENDAR_ADMINEMAIL'] = $sponsor['email'];
	$result->free();
	
	return true;
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