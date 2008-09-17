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
	$result = DBQuery("SELECT * FROM vtcal_calendar WHERE id='".sqlescape($_SESSION["CALENDARID"])."'" );
	$calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	
	$_SESSION["TITLE"] = $calendar['title'];
	$_SESSION["NAME"] = $calendar['name'];
	$_SESSION["HEADER"] = $calendar['header'];
	$_SESSION["FOOTER"] = $calendar['footer'];
	$_SESSION["VIEWAUTHREQUIRED"] = $calendar['viewauthrequired'];
	$_SESSION["FORWARDEVENTDEFAULT"] = $calendar['forwardeventdefault'];
	
	$_SESSION["BGCOLOR"] = $calendar['bgcolor'];
	$_SESSION["MAINCOLOR"] = $calendar['maincolor'];
	$_SESSION["TODAYCOLOR"] = $calendar['todaycolor'];
	$_SESSION["PASTCOLOR"] = $calendar['pastcolor'];		
	$_SESSION["FUTURECOLOR"] = $calendar['futurecolor'];		
	$_SESSION["TEXTCOLOR"] = $calendar['textcolor'];		
	$_SESSION["LINKCOLOR"] = $calendar['linkcolor'];		
	$_SESSION["GRIDCOLOR"] = $calendar['gridcolor'];
	
	$result = DBQuery("SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND admin='1'" ); 
	$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	$_SESSION["ADMINEMAIL"] = $sponsor['email'];
}

function getNumCategories() {
  $result = DBQuery("SELECT count(*) FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."'" ); 
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
  $result = DBQuery("SELECT id FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND repeatid='".sqlescape($repeatid)."' AND approved=0"); 
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