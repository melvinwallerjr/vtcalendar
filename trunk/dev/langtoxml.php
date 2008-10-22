<?php

$lang['date_and_time_header'] = 'Date &amp; Time';
$lang['basic_event_info_header'] = 'Basic Event Information';
$lang['additional_event_info_header'] = 'Additional Event Information';
$lang['additional_event_info_description'] = 'XXX';
$lang['event_owner_info_header'] = 'Owner of this Event';
$lang['event_owner_info_description'] = 'This is the sponsor who owns this event in the calendar system.<br/>The sponsor who owns this event is able to copy and delete it, as well as submit new versions for approval.';
$lang['event_sponsor_info_header'] = 'Information About the Event\'s Sponsor';
$lang['event_sponsor_info_description'] = 'This is information about the department or organization that is the official sponsor of the event.<br/>For example, if this event was Commencement then the sponsor would be the Office of the Secretary.';

$lang['date_description'] = 'Choose between one of the radio buttons to determine whether your event is a one-time or a recurring event. Then you will be given the opportunity to specify the date of the one-time event or define the recurrence for a repeating event.<br/>The validity of the date you picked is checked after pressing the &quot;Preview Event&quot; button.';
$lang['time_description'] = 'Declare the event as being an &quot;all day event&quot; (for example &quot;Thanksgiving Day&quot;) or specify start and ending time for the event. Pick &quot;???&quot; for the hour of the ending time if the event does not have a specified ending time.';
$lang['category_description'] = 'The category that best fits your event. This facilitates searching.';
$lang['title_description'] = 'A short but descriptive title that is meaningful to the general audience.';
$lang['description_description'] = 'A detailed description of the event. To avoid unnecessary calls or e-mails to your office be as detailed as possible.<br/>You are not limited in space, and Web and e-mail addresses are automatically linked.';
$lang['location_description'] = 'Optionally describe the location of the event (e.g. Squires Colonial Hall Room 200.)';
$lang['price_description'] = 'A charge for taking part in the event. If it\'s free then leave the field blank.';
$lang['contact_name_description'] = 'Optionally specify the name of a person that can be contacted by people interested to learn more about the event.';
$lang['contact_phone_description'] = 'Optionally specify a phone number that a person can call for further information.<br/>If you include more than one number, make sure to specify what each number is for (e.g. phone, fax).';
$lang['contact_email_description'] = 'Optionally specify an email address that can be used to request further information.';

$lang['submit_to_default_calendar_header'] = 'Submit to the &quot;DEFAULTCALENDARNAME&quot; Calendar';
$lang['submit_to_default_calendar_text'] = '<b>Yes</b>, and assign it to the following category';
$lang['submit_to_default_calendar_description'] = 'Submit this event for approval to be added to the &quot;DEFAULTCALENDARNAME&quot; calendar.';

/* Escape a string to be outputted in an XML document */
function xmlEscape($string, $full = false) {
	$string = str_replace('>','&gt;',str_replace('<','&lt;',str_replace('&','&amp;',str_replace('\'', '\\\'', $string))));
	if ($full) {
		$string = str_replace("'",'&apos;',str_replace('"','&quot;', $string));
	}
	return $string;
}

$items = array_keys($lang);
for ($i = 0; $i < count($items); $i++) {
	echo '<Item Name="'.xmlEscape($items[$i]).'">\''.xmlEscape($lang[$items[$i]]).'\'</Item>'."\n";
}
?>