<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

pageheader(lang('reject_event_update', false), 'Update');
contentsection_begin(lang('reject_event_update'));

$query = "
SELECT
	e.id AS id,
	e.timebegin,
	e.timeend,
	e.repeatid,
	e.sponsorid,
	e.displayedsponsor,
	e.displayedsponsorurl,
	e.title,
	e.wholedayevent,
	e.categoryid,
	e.description,
	e.location,
	e.webmap,
	e.price,
	e.contact_name,
	e.contact_phone,
	e.contact_email,
	c.id AS cid,
	c.name AS category_name,
	s.id AS sid,
	s.name AS sponsor_name,
	s.url AS sponsor_url
FROM
	" . SCHEMANAME . "vtcal_event e,
	" . SCHEMANAME . "vtcal_category c,
	" . SCHEMANAME . "vtcal_sponsor s
WHERE
	e.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	c.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	s.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	e.categoryid=c.id
	AND
	e.sponsorid=s.id
	AND
	e.id='" . sqlescape($eventid) . "'
";
if (is_string($result =& DBQuery($query))) {
	DBErrorBox('Error retrieving record from ' . SCHEMANAME . 'vtcal_event' . $result);
	exit;
}
$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
disassemble_timestamp($event);

if (!empty($event['repeatid'])) {
	readinrepeat($event['repeatid'], $event, $repeat);
	echo lang('recurring_event') . ': ';
	$repeatdef = repeatinput2repeatdef($event, $repeat);
	printrecurrence($event['timebegin_year'], $event['timebegin_month'], $event['timebegin_day'], $repeatdef);
}
echo '
<form action="approval.php" method="post">
<input type="hidden" name="eventid" value="' . htmlspecialchars($eventid, ENT_COMPAT, 'UTF-8') . '" />

<p><label for="rejectreason"><strong>' . lang('reason_for_rejection') . '</strong></label></p>

<textarea id="rejectreason" name="rejectreason" rows="2" cols="50"></textarea><br />

<p>';
if (!empty($event['repeatid']) && num_unapprovedevents($event['repeatid']) > 1) {
	echo '<input type="submit" name="rejectconfirmedall" value="' . htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;' . "\n";
}
else {
	echo '<input type="submit" name="rejectconfirmedthis" value="' . htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;' . "\n";
}
echo '<input type="submit" name="cancel" value="' . htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8') . '" /></p>

</form>';

contentsection_end();
pagefooter();
DBclose();
?>