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
	
	// The following block should only come from the output of color-loadfromdb.xsl (run against colors.xml).
	// START GENERATED
	if (isset($record['BG'])) { setVar($_SESSION['COLOR_BG'], $record['BG'], 'color'); }
	if (isset($record['Text'])) { setVar($_SESSION['COLOR_TEXT'], $record['Text'], 'color'); }
	if (isset($record['Text_Faded'])) { setVar($_SESSION['COLOR_TEXT_FADED'], $record['Text_Faded'], 'color'); }
	if (isset($record['Text_Warning'])) { setVar($_SESSION['COLOR_TEXT_WARNING'], $record['Text_Warning'], 'color'); }
	if (isset($record['Link'])) { setVar($_SESSION['COLOR_LINK'], $record['Link'], 'color'); }
	if (isset($record['Body'])) { setVar($_SESSION['COLOR_BODY'], $record['Body'], 'color'); }
	if (isset($record['Today'])) { setVar($_SESSION['COLOR_TODAY'], $record['Today'], 'color'); }
	if (isset($record['TodayLight'])) { setVar($_SESSION['COLOR_TODAYLIGHT'], $record['TodayLight'], 'color'); }
	if (isset($record['Light_Cell_BG'])) { setVar($_SESSION['COLOR_LIGHT_CELL_BG'], $record['Light_Cell_BG'], 'color'); }
	if (isset($record['Table_Header_Text'])) { setVar($_SESSION['COLOR_TABLE_HEADER_TEXT'], $record['Table_Header_Text'], 'color'); }
	if (isset($record['Table_Header_BG'])) { setVar($_SESSION['COLOR_TABLE_HEADER_BG'], $record['Table_Header_BG'], 'color'); }
	if (isset($record['Border'])) { setVar($_SESSION['COLOR_BORDER'], $record['Border'], 'color'); }
	if (isset($record['Keyword_Highlight'])) { setVar($_SESSION['COLOR_KEYWORD_HIGHLIGHT'], $record['Keyword_Highlight'], 'color'); }
	if (isset($record['H2'])) { setVar($_SESSION['COLOR_H2'], $record['H2'], 'color'); }
	if (isset($record['H3'])) { setVar($_SESSION['COLOR_H3'], $record['H3'], 'color'); }
	if (isset($record['Title'])) { setVar($_SESSION['COLOR_TITLE'], $record['Title'], 'color'); }
	if (isset($record['TabGrayed'])) { setVar($_SESSION['COLOR_TABGRAYED'], $record['TabGrayed'], 'color'); }
	if (isset($record['FilterNotice_BG'])) { setVar($_SESSION['COLOR_FILTERNOTICE_BG'], $record['FilterNotice_BG'], 'color'); }
	if (isset($record['FilterNotice_Font'])) { setVar($_SESSION['COLOR_FILTERNOTICE_FONT'], $record['FilterNotice_Font'], 'color'); }
	if (isset($record['FilterNotice_FontFaded'])) { setVar($_SESSION['COLOR_FILTERNOTICE_FONTFADED'], $record['FilterNotice_FontFaded'], 'color'); }
	if (isset($record['FilterNotice_BGImage'])) { setVar($_SESSION['COLOR_FILTERNOTICE_BGIMAGE'], $record['FilterNotice_BGImage'], 'color'); }
	if (isset($record['EventBar_Past'])) { setVar($_SESSION['COLOR_EVENTBAR_PAST'], $record['EventBar_Past'], 'color'); }
	if (isset($record['EventBar_Current'])) { setVar($_SESSION['COLOR_EVENTBAR_CURRENT'], $record['EventBar_Current'], 'color'); }
	if (isset($record['EventBar_Future'])) { setVar($_SESSION['COLOR_EVENTBAR_FUTURE'], $record['EventBar_Future'], 'color'); }
	if (isset($record['MonthDayLabels_Past'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_PAST'], $record['MonthDayLabels_Past'], 'color'); }
	if (isset($record['MonthDayLabels_Current'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_CURRENT'], $record['MonthDayLabels_Current'], 'color'); }
	if (isset($record['MonthDayLabels_Future'])) { setVar($_SESSION['COLOR_MONTHDAYLABELS_FUTURE'], $record['MonthDayLabels_Future'], 'color'); }
	if (isset($record['OtherMonth'])) { setVar($_SESSION['COLOR_OTHERMONTH'], $record['OtherMonth'], 'color'); }
	if (isset($record['LittleCal_Today'])) { setVar($_SESSION['COLOR_LITTLECAL_TODAY'], $record['LittleCal_Today'], 'color'); }
	if (isset($record['LittleCal_Highlight'])) { setVar($_SESSION['COLOR_LITTLECAL_HIGHLIGHT'], $record['LittleCal_Highlight'], 'color'); }
	if (isset($record['LittleCal_FontFaded'])) { setVar($_SESSION['COLOR_LITTLECAL_FONTFADED'], $record['LittleCal_FontFaded'], 'color'); }
	if (isset($record['LittleCal_Line'])) { setVar($_SESSION['COLOR_LITTLECAL_LINE'], $record['LittleCal_Line'], 'color'); }
	if (isset($record['GOBtn_BG'])) { setVar($_SESSION['COLOR_GOBTN_BG'], $record['GOBtn_BG'], 'color'); }
	if (isset($record['GOBtn_Border'])) { setVar($_SESSION['COLOR_GOBTN_BORDER'], $record['GOBtn_Border'], 'color'); }
	if (isset($record['NewBorder'])) { setVar($_SESSION['COLOR_NEWBORDER'], $record['NewBorder'], 'color'); }
	if (isset($record['NewBG'])) { setVar($_SESSION['COLOR_NEWBG'], $record['NewBG'], 'color'); }
	if (isset($record['ApproveBorder'])) { setVar($_SESSION['COLOR_APPROVEBORDER'], $record['ApproveBorder'], 'color'); }
	if (isset($record['ApproveBG'])) { setVar($_SESSION['COLOR_APPROVEBG'], $record['ApproveBG'], 'color'); }
	if (isset($record['CopyBorder'])) { setVar($_SESSION['COLOR_COPYBORDER'], $record['CopyBorder'], 'color'); }
	if (isset($record['CopyBG'])) { setVar($_SESSION['COLOR_COPYBG'], $record['CopyBG'], 'color'); }
	if (isset($record['DeleteBorder'])) { setVar($_SESSION['COLOR_DELETEBORDER'], $record['DeleteBorder'], 'color'); }
	if (isset($record['DeleteBG'])) { setVar($_SESSION['COLOR_DELETEBG'], $record['DeleteBG'], 'color'); }
	// END GENERATED
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