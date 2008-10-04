<?php
function GenerateRSS(&$result, $calendarID, $calendarTitle, $calendarurl, $timebegin) {
	$resultString = "";
	
	$resultString .= '<?xml version="1.0"?>'."\n";
	$resultString .= '<rss version="0.91">'."\n";
	$resultString .= "<channel>\n";
	$resultString .= "<title>".text2xmltext($calendarTitle)."</title>\n";
	
	if (substr($timebegin,8,1) == "0") { $day = substr($timebegin,9,1); } 
	else { $day = substr($timebegin,8,2); }
	if (substr($timebegin,5,1) == "0") { $month = substr($timebegin,6,1); } 
	else { $month = substr($timebegin,5,2); }
	$date = $month."/".$day."/".substr($timebegin,0,4);
	
	$resultString .= "<description>".text2xmltext($date)."</description>\n";

	$resultString .= "<link>".text2xmltext($calendarurl)."?calendarid=".text2xmltext($calendarID)."</link>\n\n";
		
	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
			disassemble_timestamp($event);
			
			$resultString .= "<item>\n";
			$resultString .= "<title>".text2xmltext($event['title'])."</title>\n";
			$resultString .= "<link>".text2xmltext($calendarurl)."main.php?view=event&amp;calendarid=".text2xmltext($calendarID)."&amp;eventid=".text2xmltext($event['id'])."</link>\n";
			$resultString .= "<description>";
			if ($event['wholedayevent']==0) {
				$resultString .= text2xmltext(timestring($event['timebegin_hour'],$event['timebegin_min'],$event['timebegin_ampm']). ": ");
			}
			else {
				$resultString .= "All day: ";
			}
			$resultString .= text2xmltext($event['category_name'])."</description>\n";
			$resultString .= "</item>\n";
		}
		$result->free();
	}
		
	$resultString .= "</channel>\n";
	$resultString .= "</rss>\n";
	
	return $resultString;
}

function GenerateRSS1_0(&$result, $calendarID, $calendarTitle, $calendarurl, $timebegin) {
	$resultString = "";
	
	if (substr($timebegin,8,1) == "0") { $day = substr($timebegin,9,1); } 
	else { $day = substr($timebegin,8,2); }
	if (substr($timebegin,5,1) == "0") { $month = substr($timebegin,6,1); } 
	else { $month = substr($timebegin,5,2); }
	$date = $month."/".$day."/".substr($timebegin,0,4);
	
	// Header
	$resultString .= '<?xml version="1.0"?>' . "\n"
		. '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'
		. ' xmlns:rss091="http://purl.org/rss/1.0/modules/rss091/"'
		. ' xmlns:syn="http://purl.org/rss/1.0/modules/syndication/"'
		. ' xmlns:dc="http://purl.org/dc/elements/1.1/"'
		. ' xmlns="http://purl.org/rss/1.0/">' . "\n"
		. '<channel rdf:about="'. text2xmltext($calendarurl) . '?calendarid=' . text2xmltext($calendarID) . "\">\n"
		. '<link>'.  text2xmltext($calendarurl) . '?calendarid='.  text2xmltext($calendarID) . "</link>\n"

		. '<description>'. text2xmltext($date) . "</description>\n"
		. '<title>'. text2xmltext($calendarTitle) . "</title>\n"
		. "<items>\n"
		. "<rdf:Seq>\n";

	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
			$resultString .= '<rdf:li resource="'.text2xmltext($calendarurl)."main.php?view=event&amp;calendarid=".text2xmltext($calendarID)."&amp;eventid=".text2xmltext($event['id'])."\"/>\n";
		}
	}

	$resultString .= "</rdf:Seq>\n"
		. "</items>\n"
		. "</channel>\n";
		
	if (!is_string($result)) {
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
			disassemble_timestamp($event);
			$resultString .= "<item rdf:about=\"".text2xmltext($calendarurl)."main.php?view=event&amp;calendarid=".text2xmltext($calendarID)."&amp;eventid=".text2xmltext($event['id'])."\">\n";
			$resultString .= "<link>".text2xmltext($calendarurl)."main.php?view=event&amp;calendarid=".text2xmltext($calendarID)."&amp;eventid=".text2xmltext($event['id'])."</link>\n";
			$resultString .= "<title>".text2xmltext($event['title'])."</title>\n";
			$resultString .= "<description>";
			if ($event['wholedayevent']==0) {
				$resultString .= text2xmltext(timestring($event['timebegin_hour'],$event['timebegin_min'],$event['timebegin_ampm']). ": ");
			}
			else {
				$resultString .= "All day: ";
			}
			$resultString .= text2xmltext($event['category_name'])."</description>\n";
			$resultString .= "</item>\n";
		}
		
		$result->free();
	}

	$resultString .= "</rdf:RDF>\n";
	
	return $resultString;
}

function GenerateXML(&$result, $calendarID, $calendarTitle, $calendarurl, $timebegin) {
	$resultString = "";
	
	$resultString .= '<?xml version="1.0"?>'."\n";
	$resultString .= "<events>\n";
	for ($i=0; $i < $result->numRows(); $i++) {
		$event = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);

		unset($repeat);
		// read in repeatid if necessary
		if (!empty($event['repeatid'])) {
			//$queryRepeat = "SELECT * FROM vtcal_event_repeat WHERE calendarid='".sqlescape($calendarID)."' AND id='".sqlescape($event['repeatid'])."'";
			$queryRepeat = "SELECT * FROM vtcal_event_repeat WHERE id='".sqlescape($event['repeatid'])."'";
			$repeatresult = DBQuery($queryRepeat ); 
			if ( $repeatresult->numRows () > 0 ) {
				$repeat = $repeatresult->fetchRow(DB_FETCHMODE_ASSOC,0);
			}
		}

		// convert some data fields
		$date = substr($event['timebegin'],0,10);
		$timebegin = substr($event['timebegin'],11,5);
		$timeend = substr($event['timeend'],11,5);
		
		// output XML code
		$resultString .= "<event>\n";
		$resultString .= "<eventid>".$event['id']."</eventid>\n";
		$resultString .= "<sponsorid>".$event['sponsorid']."</sponsorid>\n";
		$resultString .= "<inputsponsor>".text2xmltext($event['sponsor_name'])."</inputsponsor>\n";
		$resultString .= "<displayedsponsor>".text2xmltext($event['displayedsponsor'])."</displayedsponsor>\n";
		$resultString .= "<displayedsponsorurl>".text2xmltext($event['displayedsponsorurl'])."</displayedsponsorurl>\n";
		$resultString .= "<date>".$date."</date>\n";
		$resultString .= "<timebegin>".$timebegin."</timebegin>\n";
		$resultString .= "<timeend>".$timeend."</timeend>\n";
		$resultString .= "<repeat_vcaldef>";
		if (!empty($repeat['repeatdef'])) { $resultString .= $repeat['repeatdef']; }
		$resultString .= "</repeat_vcaldef>\n";
		$resultString .= "<repeat_startdate>";
		if (!empty($repeat['startdate'])) { $resultString .= substr($repeat['startdate'],0,10); }
		$resultString .= "</repeat_startdate>\n";
		$resultString .= "<repeat_enddate>";
		if (!empty($repeat['enddate'])) { $resultString .= substr($repeat['enddate'],0,10); }
		$resultString .= "</repeat_enddate>\n";
		$resultString .= "<categoryid>".$event['categoryid']."</categoryid>\n";
		$resultString .= "<category>".text2xmltext($event['category_name'])."</category>\n";
		$resultString .= "<title>".text2xmltext($event['title'])."</title>\n";
		$resultString .= "<description>".text2xmltext($event['description'])."</description>\n";
		$resultString .= "<location>".text2xmltext($event['location'])."</location>\n";
		$resultString .= "<price>".text2xmltext($event['price'])."</price>\n";
		$resultString .= "<contact_name>".text2xmltext($event['contact_name'])."</contact_name>\n";
		$resultString .= "<contact_phone>".text2xmltext($event['contact_phone'])."</contact_phone>\n";
		$resultString .= "<contact_email>".text2xmltext($event['contact_email'])."</contact_email>\n";
		$resultString .= "<url></url>\n";
		$resultString .= "<recordchangedtime>".substr($event['recordchangedtime'],0,19)."</recordchangedtime>\n";
		$resultString .= "<recordchangeduser>".$event['recordchangeduser']."</recordchangeduser>\n";
		$resultString .= "</event>\n";
	}
	$resultString .= "</events>\n";
	
	return $resultString;
}

function GenerateICal(&$result, $calendarID, $calendarName, $calendarurl, $timebegin) {
	$resultString = "";
	
	$icalname = "calendar";
	if ($categoryid != 0) {
		if (!is_string($result) && $result->numRows() > 0) {
			$event = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			$icalname = str_replace(array(" ","-","/"),"_",$event['category_name']);
		}
	}
	else {
		$icalname = str_replace(array(" ","-","/"),"_",$calendarName);
	}
	
	//Header("Content-Type: text/calendar; charset=\"utf-8\"; name=\"".$icalname.".ics\"");
	//Header("Content-disposition: attachment; filename=".$icalname.".ics");
	
	$resultString .= getICalHeader();
	
	if (!is_string($result)) {

		// this is for Apple iCal since it does not take the calendar name from the .ics file name
		if ($result->numRows() > 0) {
			$resultString .= "X-WR-CALNAME;VALUE=TEXT:".$icalname.CRLF;	
		}
		
		for ($i=0; $i < $result->numRows(); $i++) {
			$event =& $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
			$resultString .= getICalFormat($event);
		}
		$result->free();
	}
	
	$resultString .= getICalFooter();	
	
	return $resultString;
}

function GenerateVXML(&$result) {
	$resultString = "";
	
	$resultString .= '<?xml version="1.0"?>'."\n";
	$resultString .= '<vxml version="2.0">'."\n<form>\n<block>\n<prompt>\n";
	$resultString .= text2xmltext(lang('vxml_welcome'))." ";
	$resultString .= '<break size="medium"/>'."\n";
	$iNumEvents = $result->numRows();
	if ($iNumEvents > 0) {
		$resultString .= text2xmltext(lang('vxml_there_are')).' '.$iNumEvents.' '.text2xmltext(lang('vxml_events_for_today')).' '.text2xmltext(date("F j", NOW));
	}
	else {
		$resultString .= text2xmltext(lang('vxml_no_more_events')).' '.text2xmltext(date("F j", NOW));
	}
	
	if (date("j", NOW) == "1") { $resultString .= "st"; }
	elseif (date("j", NOW) == "2") { $resultString .= "nd"; }
	elseif (date("j", NOW) == "3") { $resultString .= "rd"; }
	else { $resultString .= "th"; }
	$resultString .= ".\n";
	
	$resultString .= '<break size="medium"/>'."\n";

	for ($i=0; $i < $iNumEvents; $i++) {
		$event = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
	
		if ($event['wholedayevent'] == '1') {
			$resultString .= text2xmltext(lang('all_day'));
		}
		else {
			$aTimeBegin = timestamp2datetime($event['timebegin']);
			$resultString .= $aTimeBegin['hour'];
			if ($aTimeBegin['min'] != "00") {
				$resultString .= " ".$aTimeBegin['min'];
			}
			$resultString .= strtoupper($aTimeBegin['ampm'])."\n";
		}
		$resultString .= '<break size="small"/>'."\n";
			
		$resultString .= text2xmltext($event['title'])."\n";
		
		$resultString .= '<break size="large"/>'."\n";
	}

	$resultString .= '<break size="large"/>'."\n";
	$resultString .= text2xmltext(lang('vxml_goodbye'))."\n";

	$resultString .= "\n</prompt>\n</block>\n</form>\n</vxml>\n";
	
	return $resultString;
}
?>