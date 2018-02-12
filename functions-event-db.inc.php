<?php
/**
 * Remove an event from the event table (aka: still under review) for the current calendar,
 * and from the default calendar if the event was submitted to it.
 */
function deletefromevent($eventid)
{
	$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	// delete event from default calendar if it had been forwarded
	if ($_SESSION['CALENDAR_ID'] != 'default') {
		// delete existing events in default calendar with same id
		$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='default'
	AND
	id='" . sqlescape($eventid) . "'
";
		$result =& DBQuery($query);
		if (is_string($result)) { return $result; }
	}
	return true;
}

function deletefromevent_public($eventid)
{ // Remove an event from the event_public table (aka: the event will no longer be public)
	$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
";
	$result =& DBQuery($query);
}

/**
 * Remove all repeating entries from the event table (aka: still under review)
 * for the current calendar, and from the default calendar if the event was submitted to it.
 */
function repeatdeletefromevent($repeatid)
{
	if (!empty($repeatid)) {
		$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	repeatid='" . sqlescape($repeatid) . "'
";
		$result =& DBQuery($query);
		if (is_string($result)) { return $result; }
		// delete event from default calendar if it had been forwarded
		if ($_SESSION['CALENDAR_ID'] != 'default') {
			// delete existing events in default calendar with same id
			$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='default'
	AND
	repeatid='" . sqlescape($repeatid) . "'
";
			$result =& DBQuery($query);
			if (is_string($result)) { return $result; }
		}
	}
	return true;
}

/**
 * Remove all repeating entries from the event_public table
 * (aka: the event will no longer be public),
 * and from the default calendar if the event was submitted to it.
 */
function repeatdeletefromevent_public($repeatid)
{
	if (!empty($repeatid)) {
		$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='" . $_SESSION['CALENDAR_ID'] . "'
	AND
	repeatid='" . sqlescape($repeatid) . "'
";
		$result =& DBQuery($query);
		if (is_string($result)) { return $result; }
		// delete event from default calendar if it had been forwarded
		if ($_SESSION['CALENDAR_ID'] != 'default') {
			// delete existing events in default calendar with same id
			$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='default'
	AND
	repeatid='" . sqlescape($repeatid) . "'
";
			$result =& DBQuery($query);
			if (is_string($result)) { return $result; }
		}
	}
	return true;
}

/**
 * Remove all repeating entries from the event table
 * (aka: still under review) for the current calendar.
 */
function deletefromrepeat($repeatid)
{
	if (!empty($repeatid)) {
		$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event_repeat
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($repeatid) . "'
";
		$result =& DBQuery($query);
		if (is_string($result)) { return $result; }
	}
	return true;
}

function insertintoevent($eventid, &$event)
{
	return insertintoeventsql($_SESSION['CALENDAR_ID'], $eventid, $event);
}

function insertintoeventsql($calendarid, $eventid, &$event)
{
	$changed = date('Y-m-d H:i:s', NOW);
	$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_event
	(
		calendarid,
		id,
		approved,
		rejectreason,
		timebegin,
		timeend,
		repeatid,
		sponsorid,
		displayedsponsor,
		displayedsponsorurl,
		title,
		wholedayevent,
		categoryid,
		description,
		location,
		webmap,
		price,
		contact_name,
		contact_phone,
		contact_email,
		recordchangedtime,
		recordchangeduser,
		showondefaultcal,
		showincategory
	)
VALUES
	(
		'" . sqlescape($calendarid) . "',
		'" . sqlescape($eventid) . "',
		0,
		'" . (!empty($event['rejectreason'])? sqlescape($event['rejectreason']) : '') . "',
		'" . (isset($event['timebegin'])? sqlescape($event['timebegin']) : '') . "',
		'" . (isset($event['timeend'])? sqlescape($event['timeend']) : '') . "',
		'" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') . "',
		'" . (isset($event['sponsorid'])? sqlescape($event['sponsorid']) : '') . "',
		'" . (isset($event['displayedsponsor'])? sqlescape(textString($event['displayedsponsor'])) : '') . "',
		'" . (isset($event['displayedsponsorurl'])? sqlescape(textString($event['displayedsponsorurl'])) : '') . "',
		'" . (isset($event['title'])? sqlescape(textString($event['title'])) : '') . "',
		'" . (isset($event['wholedayevent'])? sqlescape($event['wholedayevent']) : '') . "',
		'" . (isset($event['categoryid'])? sqlescape($event['categoryid']) : '') . "',
		'" . (isset($event['description'])? sqlescape($event['description']) : '') . "',
		'" . (isset($event['location'])? sqlescape(textString($event['location'])) : '') . "',
		'" . (isset($event['webmap'])? sqlescape(textString($event['webmap'])) : '') . "',
		'" . (isset($event['price'])? sqlescape(textString($event['price'])) : '') . "',
		'" . (isset($event['contact_name'])? sqlescape(textString($event['contact_name'])) : '') . "',
		'" . (isset($event['contact_phone'])? sqlescape(textString($event['contact_phone'])) : '') . "',
		'" . (isset($event['contact_email'])? sqlescape(textString($event['contact_email'])) : '') . "',
		'" . sqlescape($changed) . "',
		'" . sqlescape($_SESSION['AUTH_USERID']) . "',
		'" . sqlescape(isset($event['showondefaultcal'])? $event['showondefaultcal'] : 0) . "',
		'" . sqlescape(isset($event['showincategory'])? $event['showincategory'] : 0) . "'
	)
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return $eventid;
}

function insertintoevent_public(&$event)
{
	$changed = date('Y-m-d H:i:s', NOW);
	$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_event_public
	(
		calendarid,
		id,
		timebegin,
		timeend,
		repeatid,
		sponsorid,
		displayedsponsor,
		displayedsponsorurl,
		title,
		wholedayevent,
		categoryid,
		description,
		location,
		webmap,
		price,
		contact_name,
		contact_phone,
		contact_email,
		recordchangedtime,
		recordchangeduser
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . (isset($event['id'])? sqlescape($event['id']) : '') . "',
		'" . (isset($event['timebegin'])? sqlescape($event['timebegin']) : '') . "',
		'" . (isset($event['timeend'])? sqlescape($event['timeend']) : '') . "',
		'" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') . "',
		'" . (isset($event['sponsorid'])? sqlescape($event['sponsorid']) : '') . "',
		'" . (isset($event['displayedsponsor'])? sqlescape(textString($event['displayedsponsor'])) : '') . "',
		'" . (isset($event['displayedsponsorurl'])? sqlescape(textString($event['displayedsponsorurl'])) : '') . "',
		'" . (isset($event['title'])? sqlescape(textString($event['title'])) : '') . "',
		'" . (isset($event['wholedayevent'])? sqlescape($event['wholedayevent']) : '') . "',
		'" . (isset($event['categoryid'])? sqlescape($event['categoryid']) : '') . "',
		'" . (isset($event['description'])? sqlescape($event['description']) : '') . "',
		'" . (isset($event['location'])? sqlescape(textString($event['location'])) : '') . "',
		'" . (isset($event['webmap'])? sqlescape(textString($event['webmap'])) : '') . "',
		'" . (isset($event['price'])? sqlescape(textString($event['price'])) : '') . "',
		'" . (isset($event['contact_name'])? sqlescape(textString($event['contact_name'])) : '') . "',
		'" . (isset($event['contact_phone'])? sqlescape(textString($event['contact_phone'])) : '') . "',
		'" . (isset($event['contact_email'])? sqlescape(textString($event['contact_email'])) : '') . "',
		'" . sqlescape($changed) . "',
		'" . sqlescape($_SESSION['AUTH_USERID']) . "'
	)
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return true;
}

function updateevent($eventid, &$event)
{
	$changed = date('Y-m-d H:i:s', NOW);
	$query = "
UPDATE
	" . SCHEMANAME . "vtcal_event
SET
	approved=0,
	rejectreason='" . (isset($event['rejectreason'])? sqlescape($event['rejectreason']) : '') . "',
	timebegin='" . (isset($event['timebegin'])? sqlescape($event['timebegin']) : '') . "',
	timeend='" . (isset($event['timeend'])? sqlescape($event['timeend']) : '') . "',
	repeatid='" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') . "',
	sponsorid='" . (isset($event['sponsorid'])? sqlescape($event['sponsorid']) : '') . "',
	displayedsponsor='" . (isset($event['displayedsponsor'])? sqlescape(textString($event['displayedsponsor'])) : '') . "',
	displayedsponsorurl='" . (isset($event['displayedsponsorurl'])? sqlescape(textString($event['displayedsponsorurl'])) : '') . "',
	title='" . (isset($event['title'])? sqlescape(textString($event['title'])) : '') . "',
	wholedayevent='" . (isset($event['wholedayevent'])? sqlescape($event['wholedayevent']) : '') . "',
	categoryid='" . (isset($event['categoryid'])? sqlescape($event['categoryid']) : '') . "',
	description='" . (isset($event['description'])? sqlescape($event['description']) : '') . "',
	location='" . (isset($event['location'])? sqlescape(textString($event['location'])) : '') . "',
	webmap='" . (isset($event['webmap'])? sqlescape(textString($event['webmap'])) : '') . "',
	price='" . (isset($event['price'])? sqlescape(textString($event['price'])) : '') . "',
	contact_name='" . (isset($event['contact_name'])? sqlescape(textString($event['contact_name'])) : '') . "',
	contact_phone='" . (isset($event['contact_phone'])? sqlescape(textString($event['contact_phone'])) : '') . "',
	contact_email='" . (isset($event['contact_email'])? sqlescape(textString($event['contact_email'])) : '') . "',
	recordchangedtime='" . sqlescape($changed) . "',recordchangeduser='" . sqlescape($_SESSION['AUTH_USERID']) . "',
	showondefaultcal='" . (isset($event['showondefaultcal'])? sqlescape($event['showondefaultcal']) : '') . "',
	showincategory='" . (isset($event['showincategory'])? sqlescape($event['showincategory']) : '') . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return true;
}

function updateevent_public($eventid, &$event)
{
	$changed = date('Y-m-d H:i:s', NOW);
	$query = "
UPDATE
	" . SCHEMANAME . "vtcal_event_public
SET
	timebegin='" . (isset($event['timebegin'])? sqlescape($event['timebegin']) : '') . "',
	timeend='" . (isset($event['timeend'])? sqlescape($event['timeend']) : '') . "',
	repeatid='" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') . "',
	sponsorid='" . (isset($event['sponsorid'])? sqlescape($event['sponsorid']) : '') . "',
	displayedsponsor='" . (isset($event['displayedsponsor'])? sqlescape(textString($event['displayedsponsor'])) : '') . "',
	displayedsponsorurl='" . (isset($event['displayedsponsorurl'])? sqlescape(textString($event['displayedsponsorurl'])) : '') . "',
	title='" . (isset($event['title'])? sqlescape(textString($event['title'])) : '') . "',
	wholedayevent='" . (isset($event['wholedayevent'])? sqlescape($event['wholedayevent']) : '') . "',
	categoryid='" . (isset($event['categoryid'])? sqlescape($event['categoryid']) : '') . "',
	description='" . (isset($event['description'])? sqlescape($event['description']) : '') . "',
	location='" . (isset($event['location'])? sqlescape(textString($event['location'])) : '') . "',
	webmap='" . (isset($event['webmap'])? sqlescape(textString($event['webmap'])) : '') . "',
	price='" . (isset($event['price'])? sqlescape(textString($event['price'])) : '') . "',
	contact_name='" . (isset($event['contact_name'])? sqlescape(textString($event['contact_name'])) : '') . "',
	contact_phone='" . (isset($event['contact_phone'])? sqlescape(textString($event['contact_phone'])) : '') . "',
	contact_email='" . (isset($event['contact_email'])? sqlescape(textString($event['contact_email'])) : '') . "',
	recordchangedtime='" . sqlescape($changed) . "',recordchangeduser='" . sqlescape($_SESSION['AUTH_USERID']) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return true;
}

function insertintotemplate($template_name, &$event)
{
	$changed = date('Y-m-d H:i:s', NOW);
	$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_template
	(
		calendarid,
		name,
		sponsorid,
		displayedsponsor,
		displayedsponsorurl,
		title,
		wholedayevent,
		categoryid,
		description,
		location,
		webmap,
		price,
		contact_name,
		contact_phone,
		contact_email,
		recordchangedtime,
		recordchangeduser
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape($template_name) . "',
		'" . (isset($event['sponsorid'])? sqlescape($event['sponsorid']) : '') . "',
		'" . (isset($event['displayedsponsor'])? sqlescape(textString($event['displayedsponsor'])) : '') . "',
		'" . (isset($event['displayedsponsorurl'])? sqlescape(textString($event['displayedsponsorurl'])) : '') . "',
		'" . (isset($event['title'])? sqlescape(textString($event['title'])) : '') . "',
		'" . (isset($event['wholedayevent'])? sqlescape($event['wholedayevent']) : '') . "',
		'" . (isset($event['categoryid'])? sqlescape($event['categoryid']) : '') . "',
		'" . (isset($event['description'])? sqlescape($event['description']) : '') . "',
		'" . (isset($event['location'])? sqlescape(textString($event['location'])) : '') . "',
		'" . (isset($event['webmap'])? sqlescape(textString($event['webmap'])) : '') . "',
		'" . (isset($event['price'])? sqlescape(textString($event['price'])) : '') . "',
		'" . (isset($event['contact_name'])? sqlescape(textString($event['contact_name'])) : '') . "',
		'" . (isset($event['contact_phone'])? sqlescape(textString($event['contact_phone'])) : '') . "',
		'" . (isset($event['contact_email'])? sqlescape(textString($event['contact_email'])) : '') . "',
		'" . sqlescape($changed) . "',
		'" . sqlescape($_SESSION['AUTH_USERID']) . "'
	)
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return true;
}

function updatetemplate($templateid, $template_name, &$event)
{
	$changed = date('Y-m-d H:i:s', NOW);
	$query = "
UPDATE
	" . SCHEMANAME . "vtcal_template
SET
	name='" . sqlescape($template_name) . "',
	sponsorid='" . (isset($event['sponsorid'])? sqlescape($event['sponsorid']) : '') . "',
	displayedsponsor='" . (isset($event['displayedsponsor'])? sqlescape(textString($event['displayedsponsor'])) : '') . "',
	displayedsponsorurl='" . (isset($event['displayedsponsorurl'])? sqlescape(textString($event['displayedsponsorurl'])) : '') . "',
	title='" . (isset($event['title'])? sqlescape(textString($event['title'])) : '') . "',
	wholedayevent='" . (isset($event['wholedayevent'])? sqlescape($event['wholedayevent']) : '') . "',
	categoryid='" . (isset($event['categoryid'])? sqlescape($event['categoryid']) : '') . "',
	description='" . (isset($event['description'])? sqlescape($event['description']) : '') . "',
	location='" . (isset($event['location'])? sqlescape(textString($event['location'])) : '') . "',
	webmap='" . (isset($event['webmap'])? sqlescape(textString($event['webmap'])) : '') . "',
	price='" . (isset($event['price'])? sqlescape(textString($event['price'])) : '') . "',
	contact_name='" . (isset($event['contact_name'])? sqlescape(textString($event['contact_name'])) : '') . "',
	contact_phone='" . (isset($event['contact_phone'])? sqlescape(textString($event['contact_phone'])) : '') . "',
	contact_email='" . (isset($event['contact_email'])? sqlescape(textString($event['contact_email'])) : '') . "',
	recordchangedtime='" . sqlescape($changed) . "',
	recordchangeduser='" . sqlescape($_SESSION['AUTH_USERID']) . "'
WHERE
	sponsorid='" . sqlescape($_SESSION['AUTH_SPONSORID']) . "'
	AND
	id='" . sqlescape($templateid) . "'
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return true;
}

function insertintorepeat($repeatid, &$event, &$repeat)
{
	$repeat['startdate'] = datetime2timestamp($event['timebegin_year'], $event['timebegin_month'],
	 $event['timebegin_day'], 0, 0, 'am');
	$repeat['enddate'] = datetime2timestamp($event['timeend_year'], $event['timeend_month'],
	 $event['timeend_day'], 0, 0, 'am');
	$repeatdef = repeatinput2repeatdef($event, $repeat);
	$changed = date('Y-m-d H:i:s', NOW);
	// write record into repeat table
	$query = "
INSERT INTO
	" . SCHEMANAME . "vtcal_event_repeat
	(
		calendarid,
		id,
		repeatdef,
		startdate,
		enddate,
		recordchangedtime,
		recordchangeduser
	)
VALUES
	(
		'" . sqlescape($_SESSION['CALENDAR_ID']) . "',
		'" . sqlescape($repeatid) . "',
		'" . sqlescape($repeatdef) . "',
		'" . sqlescape($repeat['startdate']) . "',
		'" . sqlescape($repeat['enddate']) . "',
		'" . sqlescape($changed) . "',
		'" . sqlescape($_SESSION['AUTH_USERID']) . "'
	)
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	$repeat['id'] = $repeatid;
	return $repeat['id'];
}

function updaterepeat($repeatid, &$event, &$repeat)
{
	$repeat['startdate'] = datetime2timestamp($event['timebegin_year'], $event['timebegin_month'],
	 $event['timebegin_day'], 0, 0, 'am');
	$repeat['enddate'] = datetime2timestamp($event['timeend_year'], $event['timeend_month'],
	 $event['timeend_day'], 0, 0, 'am');
	$repeatdef = repeatinput2repeatdef($event, $repeat);
	// write record into repeat table
	$query = "
UPDATE
	" . SCHEMANAME . "vtcal_event_repeat
SET
	repeatdef='" . sqlescape($repeatdef) . "',
	startdate='" . sqlescape($repeat['startdate']) . "',
	enddate='" . sqlescape($repeat['enddate']) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($repeatid) . "'
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return $repeatid;
}

function publicizeevent($eventid, &$event)
{ // Make a non-repeating event public and remove the old event if a previous version existed.
	// if event delivers repeatid that's fine
	if (!empty($event['repeatid'])) { $r['repeatid'] = $event['repeatid']; }
	else {
		// get repeatid from old entry in event_public
		// (important if event changes from recurring to one-time)
		$result =& DBQuery("
SELECT
	repeatid
FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	id='" . sqlescape($eventid) . "'
");
		if (is_string($result)) { return $result; }
		if ($result->numRows() > 0) { $r =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0); }
	}
	if (!empty($r['repeatid'])) { repeatdeletefromevent_public($r['repeatid']); }
	else { deletefromevent_public($eventid); }
	// this line should not be necessary but some functions
	// still have a bug that doesn't pass the id in event['id']
	$event['id'] = $eventid;
	insertintoevent_public($event);
	$result =& DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_event
SET
	approved=1
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
");
	if (is_string($result)) { return $result; }
	// forward event to default calendar if that's indicated
	if ($_SESSION['CALENDAR_ID'] != 'default') {
		// delete existing events in default calendar with same id
		$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='default'
	AND
	id='" . sqlescape($eventid) . "'
";
		$result =& DBQuery($query);
		if (is_string($result)) { return $result; }
		if ($event['showondefaultcal'] == 1) {
			// add new event in default calendar (with approved=0)
			$eventcategoryid = $event['categoryid'];
			$event['categoryid'] = $event['showincategory'];
			insertintoeventsql('default', $eventid, $event);
			$event['categoryid'] = $eventcategoryid;
		}
		else {
			$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='default'
	AND
	id='" . sqlescape($eventid) . "'
";
			$result =& DBQuery($query);
			if (is_string($result)) { return $result; }
		}
	}
	return true;
}

function repeatpublicizeevent($eventid, &$event)
{ // Make a repeating event public and remove the old event if a previous version existed.
	deletefromevent_public($eventid);
	if (!empty($event['repeatid'])) { repeatdeletefromevent_public($event['repeatid']); }
	// forward events to default calendar: delete old events
	if ($_SESSION['CALENDAR_ID'] != 'default') {
		// delete existing events in default calendar with same id
		$e = $eventid;
		$dashpos = strpos($e, '-');
		if ($dashpos) { $e = substr($e, 0, $dashpos); }
		$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='default'
	AND
	id='" . sqlescape($e) . "'
";
		$result =& DBQuery($query);
		if (is_string($result)) { return $result; }
		if (!empty($event['repeatid'])) {
			$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='default'
	AND
	repeatid='" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') . "'
";
			$result =& DBQuery($query);
			if (is_string($result)) { return $result; }
		}
		// remove events if checkmark for forwarding is removed
		if ($event['showondefaultcal'] != 1) {
			$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='default'
	AND
	id='" . sqlescape($e) . "'
";
			$result =& DBQuery($query);
			if (is_string($result)) { return $result; }
			if (!empty($event['repeatid'])) {
				$query = "
DELETE FROM
	" . SCHEMANAME . "vtcal_event_public
WHERE
	calendarid='default'
	AND
	repeatid='" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') ."'
";
				$result =& DBQuery($query);
				if (is_string($result)) { return $result; }
			}
		}
	}

	// copy all events into event_public
	$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	repeatid='" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') . "'
");
	if (is_string($result)) { return $result; }
	for ($i=0; $i < $result->numRows(); $i++) {
		$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		//eventaddslashes($event);
		insertintoevent_public($event);
		// forward event to default calendar if that's indicated
		if ($_SESSION['CALENDAR_ID'] != 'default') {
			if ($event['showondefaultcal'] == 1) {
				// add new event in default calendar (with approved=0)
				$eventcategoryid = $event['categoryid'];
				$event['categoryid'] = $event['showincategory'];
				insertintoeventsql('default', $event['id'], $event);
				$event['categoryid'] = $eventcategoryid;
			}
		}
	}
	$query = "
UPDATE
	" . SCHEMANAME . "vtcal_event
SET
	approved=1
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	approved=0
	AND
	repeatid='" . (isset($event['repeatid'])? sqlescape($event['repeatid']) : '') . "'
";
	$result =& DBQuery($query);
	if (is_string($result)) { return $result; }
	return true;
}
?>