<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (!isset($_POST['approveallevents']) || !setVar($approveallevents, $_POST['approveallevents'], 'approveallevents')) { unset($approveallevents); }
if (!isset($_POST['eventidlist']) || !setVar($eventidlist, $_POST['eventidlist'], 'eventidlist')) { unset($eventidlist); }
if (!isset($_GET['approveall']) || !setVar($approveall, $_GET['approveall'], 'approveall')) { unset($approveall); }
if (!isset($_GET['approvethis']) || !setVar($approvethis, $_GET['approvethis'], 'approvethis')) { unset($approvethis); }
if (!isset($_GET['reject']) || !setVar($reject, $_GET['reject'], 'reject')) { unset($reject); }
if (!isset($_POST['eventid']) || !setVar($eventid, $_POST['eventid'], 'eventid')) {
	if (!isset($_GET['eventid']) || !setVar($eventid, $_GET['eventid'], 'eventid')) { unset($eventid); }
}
if (!isset($_POST['rejectreason']) || !setVar($rejectreason, $_POST['rejectreason'], 'rejectreason')) { unset($rejectreason); }
if (!isset($_POST['rejectconfirmedall']) || !setVar($rejectconfirmedall, $_POST['rejectconfirmedall'], 'rejectconfirmedall')) { unset($rejectconfirmedall); }
if (!isset($_POST['rejectconfirmedthis']) || !setVar($rejectconfirmedthis, $_POST['rejectconfirmedthis'], 'rejectconfirmedthis')) { unset($rejectconfirmedthis); }

// Approve all events.
if (isset($approveallevents)) {
	$eventids = split(',', $eventidlist);
	for ($i=0; $i < count($eventids); $i++) {
		$eventid = $eventids[$i];
		if (!empty($eventid)) {
			$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
");
			if (is_string($result)) {
				DBErrorBox($result);
				exit;
			}
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC);
			if ($event['approved'] == 0) {
				//eventaddslashes($event);
				if (!empty($event['repeatid'])) { repeatpublicizeevent($eventid, $event); }
				else { publicizeevent($eventid, $event); }
			}
		}
	}
	redirect2URL('approval.php');
	exit;
}
elseif (isset($eventid)) {
	// Approve a single event.
	// check if event is marked as "submitted" (to avoid multiple approvals/rejections)
	$query = "
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_event
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
";
	$result =& DBQuery($query);
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	$event =& $result->fetchRow(DB_FETCHMODE_ASSOC);
	if ($event['approved'] == 0) {
		if (isset($approvethis)) {
			// eventaddslashes($event);
			publicizeevent($eventid, $event);
		}
		elseif (isset($approveall)) {
			// approve all events with the same repeatid
			repeatpublicizeevent($eventid, $event);
		}
		elseif (isset($rejectconfirmedthis)) {
			$result =& DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_event
SET
	approved=-1,
	rejectreason='" . sqlescape($rejectreason) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($eventid) . "'
");
			if (is_string($result)) {
				DBErrorBox($result);
				exit;
			}
			sendrejectionemail($eventid);
		}
		elseif (isset($rejectconfirmedall)) {
			// determine repeatid
			$result =& DBQuery("
UPDATE
	" . SCHEMANAME . "vtcal_event
SET
	approved=-1,
	rejectreason='" . sqlescape($rejectreason) . "'
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	approved=0
	AND
	repeatid='" . sqlescape($event['repeatid']) . "'
");
			if (is_string($result)) {
				DBErrorBox($result);
				exit;
			}
			sendrejectionemail($eventid);
		}
		// ask for confirmation, reason for rejection
		elseif (isset($reject)) {
			include('reject.inc.php');
			exit;
		}
	}
	redirect2URL('approval.php');
	exit;
}

pageheader(lang('approve_reject_event_updates', false), 'Update');
contentsection_begin(lang('approve_reject_event_updates'), true);
echo '<p>' . lang('approval_description') . '</p>' . "\n";

// print list with events
$query = "
SELECT
	e.id AS id,
	e.approved,
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
	s.calendarid AS sponsor_calendarid,
	s.url AS sponsor_url,
	s.calendarid AS sponsor_calendarid,
	e.showondefaultcal AS showondefaultcal,
	e.showincategory AS showincategory
FROM
	" . SCHEMANAME . "vtcal_event e,
	" . SCHEMANAME . "vtcal_category c,
	" . SCHEMANAME . "vtcal_sponsor s
WHERE
	e.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	c.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	e.categoryid=c.id
	AND
	e.sponsorid=s.id
	AND
	e.approved=0
ORDER BY
	e.timebegin ASC,
	e.wholedayevent DESC
";
$result =& DBQuery($query);

if (is_string($result)) { DBErrorBox($result); }
elseif ($result->numRows() == 0) {
	echo '<b>' . lang('no_events_for_approval') . '</b>';
}
else {
	// read first event if one exists
	$ievent = 0;
	$event_id = '';
	while ($ievent < $result->numRows()) {
		$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
		$event_id .= (($ievent++ > 0)? ',' : '') . htmlspecialchars($event['id'], ENT_COMPAT, 'UTF-8');
	}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="eventidlist" value="<?php echo htmlspecialchars($event_id, ENT_COMPAT, 'UTF-8'); ?>" />
<p><input type="submit" name="approveallevents" value="<?php echo htmlspecialchars(lang('approve_all_events', false), ENT_COMPAT, 'UTF-8'); ?>" /></p>
</form>

<?php
	$defaultcalendarname = getCalendarName('default');
	// Loop through all the events waiting for approval
	for ($i=0; $i < $result->numRows(); $i++) {
		$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		disassemble_timestamp($event);
		// Keep track of repeat IDs so we only output repeating events once.
		if (!empty($event['repeatid'])) {
			if (isset($recurring_exists) && array_key_exists($event['repeatid'], $recurring_exists)) {
				// Skip to the next event if this event is repeating and has already been outputted.
				continue;
			}
			else {
				// Remember this recurring event so we only add it once.
				$recurring_exists[$event['repeatid']] = $event['repeatid'];
			}
		}
		echo '<p><big>' . Day_of_Week_to_Text(Day_of_Week($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year'])) . ', ' . Month_to_Text($event['timebegin_month']), ' ', $event['timebegin_day'], ', ', $event['timebegin_year'] . '</big>';
		// Output details about how the event repeats, if it is a repeating event.
		if (!empty($event['repeatid'])) {
			echo '<br />' . "\n" . '<span class="txtGood">';
			readinrepeat($event['repeatid'], $event, $repeat);
			$repeatdef = repeatinput2repeatdef($event, $repeat);
			printrecurrence($event['timebegin_year'], $event['timebegin_month'],
			 $event['timebegin_day'], $repeatdef);
			echo '</span>';
		}
		// Note that the event will also be submitted to the default calendar.
		if ($_SESSION['CALENDAR_ID'] != "default" && $event['showondefaultcal'] == 1) {
			echo '<br />' . "\n" .'<span class="txtWarn"><strong>Note:</strong> This event will also be submitted to the &quot;' . htmlspecialchars($defaultcalendarname, ENT_COMPAT, 'UTF-8') . '&quot; calendar under the &quot;' . htmlspecialchars(getCategoryName($event['showincategory']), ENT_COMPAT, 'UTF-8') . '&quot; category.</span>';
		}
		echo '</p>' . "\n";
?>

<table border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td class="bgLight" style="border: 1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>">
<p><strong>Submitted by:</strong>
<?php
		echo htmlspecialchars($event['sponsor_name'], ENT_COMPAT, 'UTF-8');
		if ($_SESSION['CALENDAR_ID'] == 'default' && $event['sponsor_calendarid'] != 'default') {
			echo ' <span class="txtWarn">(from the &quot;' . htmlspecialchars(getCalendarName($event['sponsor_calendarid']), ENT_COMPAT, 'UTF-8') . '&quot; calendar)</span>';
		}
?></p>
<p><?php adminButtons($event, array('approve', 'reject', 'edit'), 'small', 'horizontal'); ?></p>
<div class="eventBody"><?php print_event($event, false); ?></div>
</td>
</tr></tbody>
</table>
<?php
	}
}
contentsection_end();
pagefooter();
DBclose();

function sendrejectionemail($eventid)
{
	// determine sponsor id, name
	$query = "
SELECT
	e.title AS event_title,
	e.rejectreason AS event_rejectreason,
	s.name AS sponsor_name,
	s.email AS sponsor_email,
	s.id AS sponsorid
FROM
	" . SCHEMANAME . "vtcal_event e,
	" . SCHEMANAME . "vtcal_sponsor s
WHERE
	e.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	e.sponsorid=s.id
	AND
	e.id='" . sqlescape($eventid) . "'
";
	$result =& DBQuery($query);
	if (!is_string($result)) {
		$d =& $result->fetchRow(DB_FETCHMODE_ASSOC);
		$subject = lang('email_submitted_event_rejected', false);
		$body = lang('email_admin_rejected_event', false) . "\n";
		$body .= $d['event_title'] . "\n\n";
		$body .= lang('email_reason_for_rejection', false) . "\n";
		$body .= $d['event_rejectreason'] . "\n\n";
		$body .= lang('email_login_edit_resubmit', false);
		/*
		// taken out because it would need to be adapted to work for the calendar forwarding
		// feature which it currently does not. also, rejection is extremely rarely used.
		$body .= 'You can update the information for this particular event by clicking here:' . "\n";
		$body .= 'http' . (isset($_SERVER['HTTPS'])? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
		$body .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')) . '/';
		$body .= 'changeeinfo.php?calendarid=' . $_SESSION['CALENDAR_ID'];
		$body .= '&authsponsorid=' . $d['sponsorid'] . '&eventid=' . $eventid . '&httpreferer=update.php';
		*/
		sendemail2sponsor($d['sponsor_name'], $d['sponsor_email'], $subject, $body);
	}
}
?>