<?php
function text2xmltext($text)
{ // translates text into XML text, writing entity names like "&amp;" instead of "&"
	return htmlspecialchars(ereg_replace("\'", '&apos;', $text));
}

function GenerateRSS(&$result, $calendarID, $calendarTitle, $calendarurl, $timebegin=NULL)
{
	$resultString = '';
	if ($timebegin === NULL) { $timebegin = date('Y-m-d 00:00:00', NOW); }
	$resultString .= '<?xml version="1.0" encoding="utf-8"?>
<rss version="0.91">
	<channel>
		<title>' . text2xmltext($calendarTitle) . '</title>';
	$day = (substr($timebegin, 8, 1) == '0')? substr($timebegin, 9, 1) : substr($timebegin, 8, 2);
	$month = (substr($timebegin, 5, 1) == '0')? substr($timebegin, 6, 1) : substr($timebegin, 5, 2);
	$date = $month . '/' . $day . '/' . substr($timebegin, 0, 4);
	$resultString .= '
		<description>' . text2xmltext($date) . '</description>
		<link>' . text2xmltext($calendarurl) . '?calendarid=' . text2xmltext($calendarID) . '</link>';
	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			disassemble_timestamp($event);
			$resultString .= '
		<item>
			<title>' . Month_to_Text_Abbreviation($event['timebegin_month']) . ' ' . $event['timebegin_day'] . ': ' . text2xmltext($event['title']) . '</title>
			<link>' . text2xmltext($calendarurl) . 'main.php?view=event&amp;calendarid=' . text2xmltext($calendarID) . '&amp;eventid=' . text2xmltext($event['id']) . '</link>
			<description>';
			if ($event['wholedayevent'] == 0) {
				$resultString .= text2xmltext(timestring($event['timebegin_hour'],
				 $event['timebegin_min'], $event['timebegin_ampm']) . ':');
			}
			else {
				$resultString .= 'All day:';
			}
			$resultString .= ' ' . text2xmltext($event['category_name']) . '</description>
		</item>';
		}
		$result->free();
	}
	$resultString .= '
	</channel>
</rss>' . "\n";
	return $resultString;
}

function GenerateRSS1_0(&$result, $calendarID, $calendarTitle, $calendarurl, $timebegin=NULL)
{
	$resultString = '';
	if ($timebegin === NULL) $timebegin = date('Y-m-d 00:00:00', NOW);
	$day = (substr($timebegin, 8, 1) == '0')? substr($timebegin, 9, 1) : substr($timebegin, 8, 2);
	$month = (substr($timebegin, 5, 1) == '0')? substr($timebegin, 6, 1) : substr($timebegin, 5, 2);
	$date = $month . '/' . $day . '/' . substr($timebegin, 0, 4);
	$resultString .= '<?xml version="1.0" encoding="utf-8"?>
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
 xmlns:rss091="http://purl.org/rss/1.0/modules/rss091#"
 xmlns:syn="http://purl.org/rss/1.0/modules/syndication/"
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns="http://purl.org/rss/1.0/">
	<channel rdf:about="' . text2xmltext($calendarurl) . '?calendarid=' . text2xmltext($calendarID) . '">
		<link>' . text2xmltext($calendarurl) . '?calendarid=' . text2xmltext($calendarID) . '</link>
		<description>' . text2xmltext($date) . '</description>
		<title>' . text2xmltext($calendarTitle) . '</title>
		<items>
			<rdf:Seq>';
	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			$resultString .= '
				<rdf:li resource="' . text2xmltext($calendarurl) . 'main.php?view=event&amp;calendarid=' . text2xmltext($calendarID) . '&amp;eventid=' . text2xmltext($event['id']) . '" />';
		}
	}
	$resultString .= '
			</rdf:Seq>
		</items>
	</channel>';
	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			disassemble_timestamp($event);
			$resultString .= '
	<item rdf:about="' . text2xmltext($calendarurl) . 'main.php?view=event&amp;calendarid=' . text2xmltext($calendarID) . '&amp;eventid=' . text2xmltext($event['id']) . '">
		<link>' . text2xmltext($calendarurl) . 'main.php?view=event&amp;calendarid=' . text2xmltext($calendarID) . '&amp;eventid=' . text2xmltext($event['id']) . '</link>
		<title>' . Month_to_Text_Abbreviation($event['timebegin_month']) . ' ' . $event['timebegin_day'] . ': ' . text2xmltext($event['title']) . '</title>
		<description>';
			if ($event['wholedayevent'] == 0) {
				$resultString .= text2xmltext(timestring($event['timebegin_hour'],
				 $event['timebegin_min'], $event['timebegin_ampm']) . ':');
			}
			else {
				$resultString .= 'All day:';
			}
			$resultString .= ' ' . text2xmltext($event['category_name']) . '</description>
	</item>';
		}
		$result->free();
	}
	$resultString .= '
</rdf:RDF>' . "\n";
	return $resultString;
}

function GenerateRSS2_0(&$result, $calendarID, $calendarTitle, $calendarurl, $selfurl='', $timebegin=NULL)
{
	$resultString = '';
	if ($timebegin === NULL) { $timebegin = date('Y-m-d 00:00:00', NOW); }
	$resultString .= '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>' . text2xmltext($calendarTitle) . '</title>
		<link>' . text2xmltext($calendarurl) . '?calendarid=' . text2xmltext($calendarID) . '</link>
		<pubDate>' . gmdate('r', NOW) . '</pubDate>
		<lastBuildDate>' . gmdate('r', NOW) . '</lastBuildDate>
		<generator>VTCalendar' . (defined('VERSION')? ' ' . VERSION : '') . '</generator>
		<atom:link href="' . text2xmltext($selfurl) . '" rel="self" type="application/rss+xml" />';
	$day = (substr($timebegin, 8, 1) == '0')? substr($timebegin, 9, 1) : substr($timebegin, 8, 2);
	$month = (substr($timebegin, 5, 1) == '0')? substr($timebegin, 6, 1) : substr($timebegin, 5, 2);
	$date = $month . '/' . $day . '/' . substr($timebegin, 0, 4);
	$resultString .= '
		<description>' . text2xmltext($date) . '</description>';
	if (defined('CACHEMINUTES')) {
		$resultString .= '
		<ttl>' . CACHEMINUTES . '</ttl>';
	}
	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			disassemble_timestamp($event);
			$resultString .= '
		<item>
			<title>' . Month_to_Text_Abbreviation($event['timebegin_month']) . ' ' . $event['timebegin_day'] . ': ' . text2xmltext($event['title']) . '</title>
			<link>' . text2xmltext($calendarurl) . 'main.php?view=event&amp;calendarid=' . text2xmltext($calendarID) . '&amp;eventid=' . text2xmltext($event['id']) . '</link>
			<guid>' . text2xmltext($calendarurl) . 'main.php?view=event&amp;calendarid=' . text2xmltext($calendarID) . '&amp;eventid=' . text2xmltext($event['id']) . '</guid>
			<category>' . text2xmltext($event['category_name']) . '</category>
			<description>&lt;em&gt;';
			if ($event['wholedayevent'] == 0) {
				$resultString .= text2xmltext(timestring($event['timebegin_hour'],
				 $event['timebegin_min'], $event['timebegin_ampm']) . ':');
			}
			else {
				$resultString .= 'All day:';
			}
			$resultString .= ' ' . text2xmltext($event['category_name']) . '&lt;/em&gt;';
			if (!empty($event['description'])) {
				if (strip_tags($event['description']) == $event['description']) { // no HTML
					$resultString .= text2xmltext('<br />' .
					 preg_replace("/((\r\n)|[\r\n])/", '<br />', make_clickable($event['description'])));
				}
				else {
					$matches = true;
					while ($matches) {
						// change 'event description' urls that link within the calendar from
						// relative paths to absolute paths to support calls from outside the calendar
						preg_match('`(src="|\href=")([^"]*)(")`', $event['description'], $matches);
						if (isset($matches[2]) && strpos($matches[2], ':') === false &&
						 strpos($matches[2], '../') === false && strpos($matches[2], '/') !== 0) {
							$event['description'] = str_replace('"' . $matches[2],
							 '"' . $calendarurl . str_replace('./', '', $matches[2]), $event['description']);
						}
						else { $matches = false; }
					}
					$resultString .= text2xmltext('<br />' . $event['description']);
				}
			}
			$resultString .= '</description>
		</item>';
		}
		$result->free();
	}
	$resultString .= '
	</channel>
</rss>' . "\n";
	return $resultString;
}

function GenerateXML(&$result, $calendarID, $calendarTitle, $calendarurl)
{
	$resultString = '';
	$resultString .= '<?xml version="1.0" encoding="utf-8"?>
<events>';
	for ($i=0; $i < $result->numRows(); $i++) {
		$event = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		unset($repeat);
		// read in repeatid if necessary
		if (!empty($event['repeatid'])) {
			/*
			$queryRepeat = "
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_event_repeat
WHERE
	calendarid='" . sqlescape($calendarID) . "'
	AND
	id='" . sqlescape($event['repeatid']) . "'
";
			*/
			$queryRepeat = "
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_event_repeat
WHERE
	id='" . sqlescape($event['repeatid']) . "'
";
			if (is_string($repeatresult =& DBQuery($queryRepeat))) { return ''; }
			if ($repeatresult->numRows () > 0) {
				$repeat =& $repeatresult->fetchRow(DB_FETCHMODE_ASSOC, 0);
			}
		}
		// convert some data fields
		$date = substr($event['timebegin'], 0, 10);
		$timebegin = substr($event['timebegin'], 11, 5);
		$timeend = substr($event['timeend'], 11, 5);
		$matches = !empty($event['description']);
		while ($matches) {
			// change 'event description' urls that link within the calendar from
			// relative paths to absolute paths to support calls from outside the calendar
			preg_match('`(src="|\href=")([^"]*)(")`', $event['description'], $matches);
			if (isset($matches[2]) && strpos($matches[2], ':') === false &&
			 strpos($matches[2], '../') === false && strpos($matches[2], '/') !== 0) {
				$event['description'] = str_replace('"' . $matches[2],
				 '"' . $calendarurl . str_replace('./', '', $matches[2]), $event['description']);
			}
			else { $matches = false; }
		}
		// output XML code
		$resultString .= '
	<event>
		<eventid>' . $event['id'] . '</eventid>
		<sponsorid>' . $event['sponsorid'] . '</sponsorid>
		<inputsponsor>' . text2xmltext($event['sponsor_name']) . '</inputsponsor>
		<displayedsponsor>' . text2xmltext($event['displayedsponsor']) . '</displayedsponsor>
		<displayedsponsorurl>' . text2xmltext($event['displayedsponsorurl']) . '</displayedsponsorurl>
		<date>' . $date . '</date>
		<timebegin>' . $timebegin . '</timebegin>
		<timeend>' . $timeend . '</timeend>
		<repeat_vcaldef>' . (isset($repeat['repeatdef'])? $repeat['repeatdef'] : '') . '</repeat_vcaldef>
		<repeat_startdate>' . (!empty($repeat['startdate'])? substr($repeat['startdate'], 0, 10) : '') . '</repeat_startdate>
		<repeat_enddate>' . (!empty($repeat['enddate'])? substr($repeat['enddate'], 0, 10) : '') . '</repeat_enddate>
		<categoryid>' . $event['categoryid'] . '</categoryid>
		<category>' . text2xmltext($event['category_name']) . '</category>
		<title>' . text2xmltext($event['title']) . '</title>
		<description>' . text2xmltext($event['description']) . '</description>
		<location>' . text2xmltext($event['location']) . '</location>
		<webmap>' . text2xmltext($event['webmap']) . '</webmap>
		<price>' . text2xmltext($event['price']) . '</price>
		<contact_name>' . text2xmltext($event['contact_name']) . '</contact_name>
		<contact_phone>' . text2xmltext($event['contact_phone']) . '</contact_phone>
		<contact_email>' . text2xmltext($event['contact_email']) . '</contact_email>
		<url></url>
		<recordchangedtime>' . substr($event['recordchangedtime'], 0, 19) .'</recordchangedtime>
		<recordchangeduser>' . $event['recordchangeduser'] . '</recordchangeduser>
	</event>';
	}
	$resultString .= '
</events>' . "\n";
	return $resultString;
}

function GenerateICal(&$result, $calendarName, $calendarURL)
{
	$resultString = '';
	$icalname = 'calendar';
	$icalname = preg_replace("/[^A-Za-z0-9_]/", "_", $calendarName);
	$resultString .= 'BEGIN:VCALENDAR' . CRLF;
	$resultString .= 'VERSION:2.3' . CRLF;
	$resultString .= 'METHOD:PUBLISH' . CRLF;
	$resultString .= 'PRODID:-//Virginia Tech//VTCalendar//EN' . CRLF;
	if (!is_string($result)) {
		// this is for Apple iCal since it does not take
		// the calendar name from the .ics file name
		if ($result->numRows() > 0) {
			$resultString .= 'X-WR-CALNAME;VALUE=TEXT:' . $icalname . CRLF;
		}
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			$resultString .= GenerateICal4Event($event, $calendarURL);
		}
		$result->free();
	}
	$resultString .= 'END:VCALENDAR' . CRLF;
	return $resultString;
}

function GenerateVXML(&$result)
{
	$resultString = '<?xml version="1.0" encoding="utf-8"?>
<vxml version="2.0">
	<form>
		<block>
			<prompt>
' . text2xmltext(lang('vxml_welcome', false)) . '
<break size="medium" />' . "\n";
	$iNumEvents = $result->numRows();
	if ($iNumEvents > 0) {
		$resultString .= text2xmltext(lang('vxml_there_are', false)) . ' ' . $iNumEvents . ' ' .
		 text2xmltext(lang('vxml_events_for_today', false)) . ' ' . text2xmltext(date('F j', NOW));
	}
	else {
		$resultString .= text2xmltext(lang('vxml_no_more_events', false)) . ' ' . text2xmltext(date('F j', NOW));
	}
	if (date('j', NOW) == '1') { $resultString .= 'st'; }
	elseif (date('j', NOW) == '2') { $resultString .= 'nd'; }
	elseif (date('j', NOW) == '3') { $resultString .= 'rd'; }
	else { $resultString .= 'th'; }
	$resultString .= '.' . "\n" . '<break size="medium" />' . "\n";
	for ($i=0; $i < $iNumEvents; $i++) {
		$event = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		if ($event['wholedayevent'] == '1') {
			$resultString .= text2xmltext(lang('all_day', false)) . "\n";
		}
		else {
			$aTimeBegin = timestamp2datetime($event['timebegin']);
			$resultString .= $aTimeBegin['hour'];
			if ($aTimeBegin['min'] != '00') {
				$resultString .= ' ' . $aTimeBegin['min'];
			}
			$resultString .= mb_strtoupper($aTimeBegin['ampm'], 'UTF-8') . "\n";
		}
		$resultString .= '<break size="small" />' . "\n";
		$resultString .= text2xmltext($event['title']) . "\n\n";
		$resultString .= '<break size="large" />' . "\n\n";
	}
	$resultString .= '<break size="large" />' . "\n\n";
	$resultString .= text2xmltext(lang('vxml_goodbye', false)) . '
			</prompt>
		</block>
	</form>
</vxml>' . "\n";
	return $resultString;
}

function GenerateJSArray(&$result, $calendarID, $calendarurl)
{
	$resultString = '';
	$fields = array('title', 'link', 'timebegin', 'timeend', 'wholedayevent', 'location', 'webmap',
	 'sponsorid', 'sponsor_name', 'displayedsponsor', 'categoryid', 'category_name', 'description');
	$resultString .= '
document.VTCal_EventFields = ["' . implode('", "', $fields) . '"];
function VTCal_GetFieldIndex(field)
{
	switch (field) {';
	for ($i=0; $i < count($fields); $i++) {
		$resultString .= '
		case "' . $fields[$i] . '": return ' . $i . ';';
	}
	$resultString .= '
		default: return -1;
	}
}
document.VTCal_EventData = [];';
	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			$matches = !empty($event['description']);
			while ($matches) {
				// change 'event description' urls that link within the calendar from
				// relative paths to absolute paths to support calls from outside the calendar
				preg_match('`(src="|\href=")([^"]*)(")`', $event['description'], $matches);
				if (isset($matches[2]) && strpos($matches[2], ':') === false &&
				 strpos($matches[2], '../') === false && strpos($matches[2], '/') !== 0) {
					$event['description'] = str_replace('"' . $matches[2],
					 '"' . $calendarurl . str_replace('./', '', $matches[2]), $event['description']);
				}
				else { $matches = false; }
			}
			$resultString .= '
document.VTCal_EventData[' . $i . '] = [
	"' . escapeJavaScriptString($event['title']) . '",
	"' . escapeJavaScriptString($calendarurl . 'main.php?view=event&calendarid=' . text2xmltext($calendarID) . '&eventid=' . text2xmltext($event['id'])) . '",
	"' . escapeJavaScriptString($event['timebegin']) . '",
	"' . escapeJavaScriptString($event['timeend']) . '",
	' . (($event['wholedayevent'] == '1')? 'true' : 'false') . ',
	"' . escapeJavaScriptString($event['location']) . '",
	"' . escapeJavaScriptString($event['webmap']) . '",
	"' . escapeJavaScriptString($event['sponsorid']) . '",
	"' . escapeJavaScriptString($event['sponsor_name']) . '",
	"' . escapeJavaScriptString($event['displayedsponsor']) . '",
	"' . escapeJavaScriptString($event['categoryid']) . '",
	"' . escapeJavaScriptString($event['category_name']) . '",
	"' . escapeJavaScriptString($event['description']) . '"
];';
		}
	}
	return $resultString;
}

function GenerateHTML(&$result, $calendarID, $calendarurl, &$FormData)
{
	$resultString = '';
	$linkCategoryFilter = (isset($FormData['categories']) && $FormData['keepcategoryfilter'])?
	 '&amp;categoryfilter=' . urlencode(implode(',', $FormData['categories'])) : '';
	if ($FormData['htmltype'] == 'paragraph') {
		if ($result->numRows() == 0) {
			$resultString .= '<p class="VTCAL_NoEvents"><i>There are no upcoming events.</i></p>' . "\n";
		}
		else {
			$ievent = 0;
			while ($ievent < $result->numRows()) {
				$event = $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
				$resultString .= '<p><b><a href="' . BASEURL . 'main.php?calendarid=' .
				 urlencode($calendarID) . '&amp;view=event&amp;eventid=' . urlencode($event['id']) .
				 '&amp;timebegin=' . urlencode($event['timebegin']) . $linkCategoryFilter . '"';
				if (isset($FormData['maxtitlecharacters']) &&
				 $FormData['maxtitlecharacters'] < strlen($event['title'])) {
					$resultString .= ' title="' . htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8') . '">' .
					 htmlspecialchars(trim(substr($event['title'], 0, $FormData['maxtitlecharacters'])), ENT_COMPAT, 'UTF-8') .
					 '</a>&hellip;</b>';
				}
				else {
					$resultString .= '>' . htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8') . '</a></b>';
				}
				if ($FormData['showdatetime'] == '1') {
					$resultString .= '<br />' . "\n" . htmlspecialchars(FormatDate($FormData['dateformat'],
					 dbtime2tick($event['timebegin'])), ENT_COMPAT, 'UTF-8');
					$ReturnTime = FormatTimeDisplay($event, $FormData);
					if ($FormData['showallday'] == '1' ||
					 ($FormData['showallday'] == '0' && $ReturnTime != 'All Day')) {
						$resultString .= ' - ' . htmlspecialchars($ReturnTime, ENT_COMPAT, 'UTF-8');
					}
				}
				if ($event['location'] != '' && $FormData['showlocation'] == '1') {
					$resultString .= '<br />' . "\n" . '<i';
					if (isset($FormData['maxlocationcharacters']) &&
					 $FormData['maxlocationcharacters'] < strlen($event['location'])) {
						$resultString .= ' title="' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8') . '">' .
						 htmlspecialchars(trim(substr($event['location'], 0,
						 $FormData['maxlocationcharacters'])), ENT_COMPAT, 'UTF-8') . '&hellip;';
					}
					else {
						$resultString .= '>' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8');
					}
					$resultString .= '</i>';
				}
				if ($event['webmap'] != '' && $FormData['showwebmap'] == '1') {
					$resultString .= ' <a href="' . htmlspecialchars($FormData['webmap'], ENT_COMPAT, 'UTF-8') .
					 '">[' . lang('webmap') . ']</a>';
				}
				$resultString .= '</p>' . "\n";
				$ievent++;
			}
		}
	}
	elseif ($FormData['htmltype'] == 'table') {
		$resultString .= '
<table class="VTCAL" border="0" cellspacing="0" cellpadding="4">
<tbody>';
		if ($result->numRows() == 0) {
			$resultString .= '<tr>
<td class="VTCAL_NoEvents" colspan="2">There are no upcoming events.</td>
</tr>';
		}
		else {
			$ievent = 0;
			while ($ievent < $result->numRows()) {
				$event = $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
				$resultString .= '<tr>';
				if ($FormData['showdatetime'] == '1') {
					$resultString .= '
<td class="VTCAL_DateTime">' . htmlspecialchars(FormatDate($FormData['dateformat'], dbtime2tick($event['timebegin'])), ENT_COMPAT, 'UTF-8');
					$ReturnTime = FormatTimeDisplay($event, $FormData);
					if ($FormData['showallday'] == '1' || ($FormData['showallday'] == '0' &&
					 $ReturnTime != 'All Day')) {
						$resultString .= '<br />' . "\n" . htmlspecialchars($ReturnTime, ENT_COMPAT, 'UTF-8');
					}
					$resultString .= '</td>';
				}
				$resultString .= '
<td class="VTCAL_TitleLocation"><b><a href="' . BASEURL . 'main.php?calendarid=' . urlencode($calendarID) . '&amp;view=event&amp;eventid=' . urlencode($event['id']) . '&amp;timebegin=' . urlencode($event['timebegin']) . $linkCategoryFilter . '"';
				if (isset($FormData['maxtitlecharacters']) &&
				 $FormData['maxtitlecharacters'] < strlen($event['title'])) {
					$resultString .= ' title="' . htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8') . '">' .
					 htmlspecialchars(trim(substr($event['title'], 0, $FormData['maxtitlecharacters'])),
					  ENT_COMPAT, 'UTF-8') . '</a>&hellip;</b>';
				}
				else {
					$resultString .= '>' . htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8') . '</a></b>';
				}
				if ($event['location'] != '' && $FormData['showlocation'] == '1') {
					if (isset($FormData['maxlocationcharacters']) &&
					 $FormData['maxlocationcharacters'] < strlen($event['location'])) {
						$resultString .= '<br />
<i title="' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8') . '">' . htmlspecialchars(trim(substr($event['location'], 0, $FormData['maxlocationcharacters'])), ENT_COMPAT, 'UTF-8') . '&hellip;</i>';
					}
					else {
						$resultString .= '<br />
<i>' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8') . '</i>';
					}
				}
				if ($event['webmap'] != '' && $FormData['showwebmap'] == '1') {
					$resultString .= ' <a href="' . htmlspecialchars($event['webmap'], ENT_COMPAT, 'UTF-8') .
					 '">[' . lang('webmap') . ']</a>';
				}
				$resultString .= '</td>' . "\n" . '</tr>';
				$ievent++;
			}
		}
		$resultString .= '</tbody>' . "\n" . '</table>' . "\n";
	}
	elseif ($FormData['htmltype'] == 'mainsite') {
		if ($result->numRows() == 0) {
			$resultString .= '<p align="center"><i>No upcoming events.</i></p>' . "\n";
		}
		else {
			$ievent = 0;
			while ($ievent < $result->numRows()) {
				$event = $result->fetchRow(DB_FETCHMODE_ASSOC, $ievent);
				$resultString .= '
<p id="VTCAL_EventNum' . ($ievent + 1) . '"><a href="' . BASEURL . 'main.php?calendarid=' . urlencode($calendarID) . '&amp;view=event&amp;eventid=' . urlencode($event['id']) . '&amp;timebegin=' . urlencode($event['timebegin']) . $linkCategoryFilter . '"><b>' . htmlspecialchars(FormatDate($FormData['dateformat'], dbtime2tick($event['timebegin'])), ENT_COMPAT, 'UTF-8') . '<br />
' . htmlspecialchars(FormatTimeDisplay($event, $FormData), ENT_COMPAT, 'UTF-8') . '</b><br />';
				if (isset($FormData['maxtitlecharacters']) &&
				 $FormData['maxtitlecharacters'] < strlen($event['title'])) {
					$resultString .= '
<u title="' . htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8') . '">' . htmlspecialchars(trim(substr($event['title'], 0, $FormData['maxtitlecharacters'])), ENT_COMPAT, 'UTF-8') . '&hellip;</u><br />';
				}
				else {
					$resultString .= '
<u>' . htmlspecialchars($event['title'], ENT_COMPAT, 'UTF-8') . '</u><br />';
				}
				if ($event['location'] != '' && $FormData['showlocation'] == '1') {
					if (isset($FormData['maxlocationcharacters']) && ($FormData['maxlocationcharacters'] < strlen($event['location']))) {
						$resultString .= '
<i title="' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8') . '">' . htmlspecialchars(trim(substr($event['location'], 0, $FormData['maxlocationcharacters'])), ENT_COMPAT, 'UTF-8') . '&hellip;</i>';
					}
					else {
						$resultString .= '
<i>' . htmlspecialchars($event['location'], ENT_COMPAT, 'UTF-8') . '</i>';
					}
				}
				$resultString .= '</a>';
				if ($event['webmap'] != '' && $FormData['showwebmap'] == '1') {
					$resultString .= ' <a href="' . htmlspecialchars($event['webmap'], ENT_COMPAT, 'UTF-8') .
					 '">[' . lang('webmap') . ']</a>';
				}
				$resultString .= '</p>' . "\n";
				$ievent++;
			}
		}
	}
	if ($FormData['jshtml']) {
		$jsparts = ceil(strlen($resultString) / 200);
		$jsEscapedResult = '';
		for ($i=0; $i < $jsparts; $i++) {
			$jsEscapedResult .= 'document.write("' .
			 escapeJavaScriptString(substr($resultString, $i * 200, 200)) .
			 '");' . "\n";
		}
		return $jsEscapedResult;
	}
	else {
		return $resultString;
	}
}

function FormatICalText($text)
{
	$ical = '';
	$nl_at_nextspace = 0;
	for ($i=0; $i < strlen($text); $i++) {
		$c = substr($text, $i, 1);
		if ($i > 0 && $i / 45 == floor($i / 45)) { $nl_at_nextspace = 1; }
		if ($c == ' ' && $nl_at_nextspace) {
			$ical .= ' ' . CRLF . ' ';
			$nl_at_nextspace = 0;
		}
		elseif ($c == chr(13)) {
			$ical .= "\\n" . CRLF . ' ';
			$i++;
		}
		else { $ical .= $c; }
	}
	return $ical;
}

function GenerateICal4Event(&$event, $calendarURL)
{
	disassemble_timestamp($event);
	$dtstart = date('Ymd\THis', GetUTCTime(mktime(
		intval(($event['timebegin_ampm'] == 'am')?
		 (($event['timebegin_hour'] == 12)? 0 : $event['timebegin_hour']) :
		 (($event['timebegin_hour'] == 12)? $event['timebegin_hour'] : $event['timebegin_hour'] + 12)
		),
		intval($event['timebegin_min']),
		0,
		intval($event['timebegin_month']),
		intval($event['timebegin_day']),
		intval($event['timebegin_year'])
	)));
	$dtend = date('Ymd\THis', GetUTCTime(mktime(
		intval(($event['timeend_ampm'] == 'am')?
		 (($event['timeend_hour'] == 12)? 0 : $event['timeend_hour']) :
		 (($event['timeend_hour'] == 12)? $event['timeend_hour'] : $event['timeend_hour'] + 12)
		),
		intval($event['timeend_min']),
		0,
		intval($event['timeend_month']),
		intval($event['timeend_day']),
		intval($event['timeend_year'])
	)));
	$ical = 'BEGIN:VEVENT' . CRLF;
	$ical .= 'DTSTAMP:' . $dtstart . 'Z' . CRLF;
	$ical .= 'UID:' . $event['id'] . '@' . $calendarURL . CRLF;
	$ical .= 'CATEGORIES:' . $event['category_name'] . CRLF;
	if ($event['wholedayevent'] == 1) {
		$ical .= 'DTSTART;VALUE=DATE:' . substr($dtstart, 0, 8) . CRLF;
		$ical .= 'DTEND;VALUE=DATE:' . substr($dtend, 0, 8) . CRLF;
	}
	else {
		$ical .= 'DTSTART:' . $dtstart . 'Z' . CRLF;
		$ical .= 'DTEND:' . $dtend . 'Z' . CRLF;
	}
	$ical .= 'SUMMARY:' . $event['title'] . CRLF;
	$ical .= 'DESCRIPTION:';
	if (!empty($event['description'])) {
		$matches = true;
		while ($matches) {
			// change 'event description' urls that link within the calendar from
			// relative paths to absolute paths to support calls from outside the calendar
			preg_match('`(src="|\href=")([^"]*)(")`', $event['description'], $matches);
			if (isset($matches[2]) && strpos($matches[2], ':') === false &&
			 strpos($matches[2], '../') === false && strpos($matches[2], '/') !== 0) {
				$event['description'] = str_replace('"' . $matches[2],
				 '"' . $calendarurl . str_replace('./', '', $matches[2]), $event['description']);
			}
			else { $matches = false; }
		}
		$ical .= FormatICalText($event['description']);
		$ical .= '\n\n' . CRLF;
	}
	if (!empty($event['price'])) {
		$ical .= ' ' . lang('price', false) . ': ';
		$ical .= FormatICalText($event['price']);
		$ical .= '\n' . CRLF;
	}
	if (!empty($event['sponsor_name'])) {
		$ical .= ' ' . lang('sponsor', false) . ': ';
		$ical .= FormatICalText($event['sponsor_name']);
		$ical .= '\n' . CRLF;
	}
	if (!(empty($event['sponsor_url']) || $event['sponsor_url'] == 'http://')) {
		$ical .= ' ' . lang('homepage', false) . ': ';
		$ical .= FormatICalText($event['sponsor_url']);
		$ical .= '\n' . CRLF;
	}
	if (!empty($event['contact_name'])) {
		$ical .= ' ' . lang('contact', false) . ': ';
		$ical .= FormatICalText($event['contact_name']);
		$ical .= '\n' . CRLF;
	}
	if (!empty($event['contact_phone'])) {
		$ical .= ' ' . lang('phone', false) . ': ';
		$ical .= FormatICalText($event['contact_phone']);
		$ical .= '\n' . CRLF;
	}
	if (!empty($event['contact_email'])) {
		$ical .= ' ' . lang('email', false) . ': ';
		$ical .= FormatICalText($event['contact_email']);
		$ical .= '\n' . CRLF;
	}
	if (!empty($event['location'])) {
		$ical .= 'LOCATION: ' . $event['location'] . CRLF;
	}
	if (!empty($event['webmap'])) {
		$ical .= 'WEB MAP: ' . $event['webmap'] . CRLF;
	}
	$ical .= 'END:VEVENT' . CRLF;
	return $ical;
}
?>