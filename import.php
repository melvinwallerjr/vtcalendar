<?php
require_once('application.inc.php');

if (!isset($_GET['cancel']) || !setVar($cancel, $_GET['cancel'], 'cancel')) { unset($cancel); }
if (!isset($_GET['importurl']) || !setVar($importurl, $_GET['importurl'], 'importurl')) { unset($importurl); }
if (!isset($_GET['startimport']) || !setVar($startimport, $_GET['startimport'], 'startimport')) { unset($startimport); }

if (!authorized()) { exit; }

if (isset($cancel)) {
	redirect2URL('update.php');
	exit;
}

function eventtimestampvalid($timestamp)
{ // check that the time adheres to the standard "2000-03-22 15:00:00" 
	return (strlen($timestamp) == 19 &&
	 preg_match("^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$", $timestamp) &&
	 checkdate(substr($timestamp, 5, 2), substr($timestamp, 8, 2), substr($timestamp, 0, 4)) &&
	 substr($timestamp, 11, 2) >= 0 && substr($timestamp, 11, 2) <= 23 && substr($timestamp, 14, 2) >= 0 &&
	 substr($timestamp, 14, 2) <= 59 && substr($timestamp, 17, 2) >= 0 && substr($timestamp, 17, 2) <= 59);
}

function eventtimebeginvalid($timebeginstamp)
{ // check that the timestamp for the starting time is valid
	return eventtimestampvalid($timebeginstamp);
}

function eventtimeendvalid($timeendstamp)
{ // check that the timestamp for the ending time is valid
	return eventtimestampvalid($timeendstamp);
}

function saveevent()
{
	global $eventlist, $event, $eventnr, $date, $timebegin, $timeend, $error, $validcategory;
	// construct timestamps from the info $date, $timebegin, $timeend
	$event['sponsorid'] = $_SESSION['AUTH_SPONSORID'];
	if ($_SESSION['AUTH_ISCALENDARADMIN']) { $event['approved'] = 1; }
	else { $event['approved'] = 0; }
	$event['rejectreason'] = '';
	$event['repeatid'] = '';
	$event['timebegin'] = $date . ' ' . $timebegin . ':00';
	if (empty($timeend)) { $timeend = '23:59'; }
	$event['timeend'] = $date . ' ' . $timeend . ':00';
	$event['wholedayevent'] = ($timebegin == '00:00' && $timeend == '23:59');

	// make sure that the previous event got all the input fields
	if (!(strlen($event['displayedsponsor']) <= MAXLENGTH_DISPLAYEDSPONSOR)) {
		feedback(lang('import_error_displayedsponsor') . ': ' .
		 htmlspecialchars($event['displayedsponsor'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		 $error = true;
	}
	if (!(strlen($event['displayedsponsorurl']) <= MAXLENGTH_URL &&
	 checkurl($event['displayedsponsorurl']))) {
		feedback(lang('import_error_displayedsponsorurl') . ': ' .
		 htmlspecialchars($event['displayedsponsorurl'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		 $error = true;
	}
	if (!(eventtimebeginvalid($event['timebegin']))) {
		feedback(lang('import_error_timebegin') . ': ' .
		 htmlspecialchars($event['timebegin'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(eventtimeendvalid($event['timeend']))) {
		feedback(lang('import_error_timeend') . ': ' .
		 htmlspecialchars($event['timeend'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(array_key_exists($event['categoryid'], $validcategory))) {
		feedback(lang('import_error_categoryid') . ': ' .
		 htmlspecialchars($event['categoryid'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(!empty($event['title']) && strlen($event['title']) <= MAXLENGTH_TITLE)) {
		feedback(lang('import_error_title') . ': ' .
		 htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(strlen($event['description']) <= MAXLENGTH_DESCRIPTION)) {
		feedback(lang('import_error_description') . ': ' .
		 htmlspecialchars($event['description'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(strlen($event['location']) <= MAXLENGTH_LOCATION)) {
		feedback(lang('import_error_location') . ': ' .
		 htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(strlen($event['webmap']) <= MAXLENGTH_WEBMAP)) {
		feedback(lang('import_error_webmap') . ': ' .
		 htmlspecialchars($event['webmap'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(strlen($event['price']) <= MAXLENGTH_PRICE)) {
		feedback(lang('import_error_price') . ': ' .
		 htmlspecialchars($event['price'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(strlen($event['contact_name']) <= MAXLENGTH_CONTACT_NAME)) {
		feedback(lang('import_error_contact_name') . ': ' .
		 htmlspecialchars($event['contact_name'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(strlen($event['contact_phone']) <= MAXLENGTH_CONTACT_PHONE)) {
		feedback(lang('import_error_contact_phone') . ': ' .
		 htmlspecialchars($event['contact_phone'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	if (!(strlen($event['contact_email']) <= MAXLENGTH_EMAIL)) {
		feedback(lang('import_error_contact_email') . ': ' .
		 htmlspecialchars($event['contact_email'], ENT_COMPAT, 'UTF-8'), FEEDBACKNEG);
		$error = true;
	}
	// save all the data of the previous event in the array
	if (!$error) {
		$eventnr++;
		$eventlist[$eventnr] = $event;
	}
}

function xmlstartelement_importevent($parser, $element, $attrs)
{ // XML parser element handler for start element
	global $xmlcurrentelement, $xmlelementattrs, $firstelement, $event,
	 $eventnr, $date, $timebegin, $timeend, $error;
	$xmlcurrentelement = $element;
	$xmlelementattrs = $attrs;
	if (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'events') {
		if (!$firstelement) { // <events> must always be the first element
			feedback(lang('import_error_events'), FEEDBACKNEG);
		}
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'event') {
		// start new element
		$date = '';
		$timebegin = '';
		$timeend = '';
		$event['displayedsponsor'] = '';
		$event['displayedsponsorurl'] = '';
		$event['categoryid'] = '';
		$event['title'] = '';
		$event['description'] = '';
		$event['location'] = '';
		$event['webmap'] = '';
		$event['price'] = '';
		$event['contact_name'] = '';
		$event['contact_phone'] = '';
		$event['contact_email'] = '';
	}
	$firstelement = 0;
}

function xmlendelement_importevent($parser, $element)
{ // XML parser element handler for end element
	global $xmlcurrentelement, $xmlelementattrs, $event, $error;
	$xmlcurrentelement = '';
	$xmlelementattrs = '';
	if (mb_strtolower($element, 'UTF-8') == 'event') { saveevent(); }
}

function xmlcharacterdata_importevent($parser, $data)
{
	global $xmlcurrentelement, $xmlelementattrs, $firstelement, $eventlist,
	 $event, $eventnr, $date, $timebegin, $timeend, $error;
	if (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'displayedsponsor') {
		$event['displayedsponsor'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'displayedsponsorurl') {
		$event['displayedsponsorurl'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'date') {
		$date = $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'timebegin') {
		$timebegin = $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'timeend') {
		$timeend = $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'categoryid') {
		$event['categoryid'] = $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'title') {
		$event['title'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'description') {
		$event['description'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'location') {
		$event['location'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'webmap') {
		$event['webmap'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'price') {
		$event['price'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'contact_name') {
		$event['contact_name'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'contact_phone') {
		$event['contact_phone'] .= $data;
	}
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'contact_email') {
		$event['contact_email'] .= $data;
	}
	// Append the URL to the end of the description.
	elseif (mb_strtolower($xmlcurrentelement, 'UTF-8') == 'url') {
		$event['description'] .= "\n\n" . lang('more_information') . ': ' . $data;
	}
}

function xmlerror_importevent($xml_parser)
{ // default error handler
	feedbackblock('XML error: ' . xml_error_string(xml_get_error_code($xml_parser)) .
	 ' at line ' . xml_get_current_line_number($xml_parser), FEEDBACKNEG);
}

pageheader(lang('import_events', false), 'Update');
contentsection_begin(lang('import_events'));

$showinputbox = 1;
if (isset($importurl)) {
	if (checkurl($importurl)) {
		// get list of valid category-IDs
		$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
"); 
		for ($i=0; $i < $result->numRows(); $i++) {
			$category = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			$validcategory[$category['id']] = true;
		}
		// open remote file and parse it
		$firstelement = 1;
		$eventnr = 0;
		$error = false;
		$parsexmlerror = parsexml($importurl, 'xmlstartelement_importevent',
		 'xmlendelement_importevent', 'xmlcharacterdata_importevent', 'xmlerror_importevent');
		if ($parsexmlerror == FILEOPENERROR) {
			feedbackblock(lang('import_error_open_url'), FEEDBACKNEG);
		}
		if ($error) {
			feedbackblock(lang('no_events_imported'), FEEDBACKNEG);
		}
		if (!$parsexmlerror) {
			if (!$error) {
				if ($eventnr > 0) {
					// determine sponsor name & URL
					$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($event['sponsorid']) . "'
");
					$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
					$id = getNewEventId();
					$id1 = substr($id, 0, 10);
					for ($i=1; $i <= $eventnr; $i++) {
						$event = $eventlist[$i];
						if (empty($event['displayedsponsor'])) {
							$event['displayedsponsor'] = $sponsor['name'];
						}
						if (empty($event['displayedsponsorurl'])) {
							$event['displayedsponsorurl'] = $sponsor['url'];
						}
						$id1++;
						$eventid = $id1 . '000';
						$event['id'] = $eventid;
						insertintoevent($eventid, $event);
						if ($_SESSION['AUTH_ISCALENDARADMIN']) {
							publicizeevent($eventid, $event);
						}
					}
					$showinputbox = 0;
					feedbackblock($eventnr . ' ' . lang('events_successfully_imported'), FEEDBACKPOS);
				}
				else {
					feedbackblock(lang('import_file_contains_no_events'), FEEDBACKNEG);
				}
			}
		}
	}
}
if ($showinputbox) {
	echo '
<form method="get" action="' . $_SERVER['PHP_SELF'] . '">

<p><label for="importurl"><strong>' . lang('enter_import_url_message') . '</strong></label></p>

<p><input type="text" id="importurl" name="importurl" value="' . (isset($importurl)? htmlspecialchars($importurl, ENT_COMPAT, 'UTF-8') : '') . '" size="60" maxlength="' . MAXLENGTH_IMPORTURL . '" /><br />
' . lang('enter_import_url_example') . '</p>

<p><input type="submit" name="startimport" value="' . htmlspecialchars(lang('ok_button_text', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;
<input type="submit" name="cancel" value="' . htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8') . '" /></p>

</form>

<div class="bgLight pad">

<h2>' . lang('how_to_import') . '</h2>

' . lang('help_import_intro') . "\n";
?>
<hr size="1" />

<pre>
&lt;events&gt;
	&lt;event&gt;
		&lt;displayedsponsor&gt;Athletics Department&lt;/displayedsponsor&gt;
		&lt;displayedsponsorurl&gt;http://www.example.com/&lt;/displayedsponsorurl&gt;
		&lt;date&gt;2000-03-15&lt;/date&gt;
		&lt;timebegin&gt;15:00&lt;/timebegin&gt;
		&lt;timeend&gt;&lt;/timeend&gt;
		&lt;categoryid&gt;9&lt;/categoryid&gt;
		&lt;title&gt;Baseball vs. Kent&lt;/title&gt;
		&lt;description&gt;VT is playing vs. Kent&hellip;&lt;/description&gt;
		&lt;location&gt;English Field&lt;/location&gt;
		&lt;webmap&gt;http://maps.google.com/&hellip;&lt;/webmap&gt;
		&lt;price&gt;free&lt;/price&gt;
		&lt;contact_name&gt;Jennifer Meyers&lt;/contact_name&gt;
		&lt;contact_phone&gt;231-4933&lt;/contact_phone&gt;
		&lt;contact_email&gt;jmeyer@example.com&lt;/contact_email&gt;
		&lt;url&gt;http://www.hokiesportsinfo.com/baseball/&lt;/url&gt;
	&lt;/event&gt;
	&lt;event&gt;
		&lt;displayedsponsor&gt;Indian Student Association&lt;/displayedsponsor&gt;
		&lt;displayedsponsorurl&gt;http://fbox.example.com:10021/org/isa/&lt;/displayedsponsorurl&gt;
		&lt;date&gt;1999-11-06&lt;/date&gt;
		&lt;timebegin&gt;17:00&lt;/timebegin&gt;
		&lt;timeend&gt;21:00&lt;/timeend&gt;
		&lt;categoryid&gt;9&lt;/categoryid&gt;
		&lt;title&gt;Diwali '99&lt;/title&gt;
		&lt;description&gt;A two and half hour cultural show at Buruss Auditorium. 
		The show includes traditional Indian dance, a fashion show featuring traditional 
		clothes from different parts of India, a live orchestra playing popular hindi songs, 
		a tickle-your-belly skit based on the recent elections in India, a jam of guitar and 
		Indian classical musical instruments, children's show among others events.
		&lt;/description&gt;
		&lt;location&gt;Buruss Auditorium&lt;/location&gt;
		&lt;webmap&gt;http://maps.yahoo.com/&hellip;&lt;/webmap&gt;
		&lt;price&gt;free&lt;/price&gt;
		&lt;contact_name&gt;Akash Rai&lt;/contact_name&gt;
		&lt;contact_phone&gt;540-951-7764&lt;/contact_phone&gt;
		&lt;contact_email&gt;arai@example.com&lt;/contact_email&gt;
		&lt;url&gt;http://fbox.vt.edu:10021/org/isa/diwali99/&lt;/url&gt;
	&lt;/event&gt;
	&lt;event&gt;
		&hellip;
	&lt;/event&gt;
	&hellip;  
&lt;/events&gt;
</pre>

<hr size="1" />

<?php
	$import_data_format = '';
	// read event categories from DB
	$result =& DBQuery("
	SELECT
		*
	FROM
		" . SCHEMANAME . "vtcal_category
	WHERE
		calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	ORDER BY
		name ASC
	");
	if (is_string($result)) { DBErrorBox($result); }
	else {
		$import_data_format = '
<table border="1" cellspacing="0" cellpadding="5">
<thead><tr>
<th>' . lang('help_categoryid_index') . '</th>
<th>' . lang('help_categoryid_name') . '</th>
</tr></thead>
<tbody>';
		// print list with categories and select the one read from the DB
		for ($i=0; $i < $result->numRows(); $i++) {
			$category =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			$import_data_format .= '<tr>
<td>' . $category['id'] . '</td>
<td>' . $category['name'] . '</td>
</tr>';
		}
		$import_data_format .= '</tbody>
</table>' . "\n";
	}
	echo str_replace('@@IMPORT_DATA_FORMAT@@', $import_data_format, lang('help_import_data_format_intro'));
	echo lang('help_import_data_format') . '
</div>' . "\n";
}

contentsection_end();
pagefooter();
DBclose();
?>