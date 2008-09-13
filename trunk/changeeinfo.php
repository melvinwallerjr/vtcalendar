<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
require_once('application.inc.php');
require_once("inputedata.inc.php");

/* ==========================================================
     Get the data passed via the query string and form
========================================================== */

if (isset($_POST['choosetemplate'])) { setVar($choosetemplate, $_POST['choosetemplate'],'choosetemplate'); } else { unset($choosetemplate); }
if (isset($_POST['preview'])) { setVar($preview, $_POST['preview'],'preview'); } else { unset($preview); }
if (isset($_POST['savethis'])) { setVar($savethis, $_POST['savethis'],'savethis'); } else { unset($savethis); }
if (isset($_POST['edit'])) { setVar($edit, $_POST['edit'],'edit'); } else { unset($edit); }
if (isset($_POST['eventid'])) { setVar($eventid, $_POST['eventid'],'eventid'); }
else { 
  if (isset($_GET['eventid'])) { setVar($eventid, $_GET['eventid'],'eventid'); } 
	else {
		unset($eventid); 
	}
}
if (isset($_POST['cancel'])) { setVar($cancel, $_POST['cancel'],'cancel'); } else { unset($cancel); }

// If the event is a copy of the passed eventid. '1' is true. Any other value is false.
if (isset($_POST['copy'])) { setVar($copy, $_POST['copy'],'copy'); } 
elseif (isset($_GET['copy'])) { setVar($copy, $_GET['copy'],'copy'); } 
else { $copy = 0; }

if (isset($_POST['check'])) { setVar($check, $_POST['check'],'check'); } else { unset($check); }
if (isset($_POST['templateid'])) { setVar($templateid, $_POST['templateid'],'templateid'); } else { unset($templateid); }
if (isset($_POST['httpreferer'])) { setVar($httpreferer, $_POST['httpreferer'],'httpreferer'); } else { unset($httpreferer); }
if (isset($_GET['timebegin_year'])) { setVar($timebegin_year, $_GET['timebegin_year'],'timebegin_year'); } else { unset($timebegin_year); }
if (isset($_GET['timebegin_month'])) { setVar($timebegin_month, $_GET['timebegin_month'],'timebegin_month'); } else { unset($timebegin_month); }
if (isset($_GET['timebegin_day'])) { setVar($timebegin_day, $_GET['timebegin_day'],'timebegin_day'); } else { unset($timebegin_day); }
if (isset($_POST['repeat'])) {
	if (isset($_POST['repeat']['mode'])) { setVar($repeat['mode'], $_POST['repeat']['mode'],'mode'); } else { unset($repeat['mode']); }
	if (isset($_POST['repeat']['interval1'])) { setVar($repeat['interval1'], $_POST['repeat']['interval1'],'interval1'); } else { unset($repeat['interval1']); }
	if (isset($_POST['repeat']['interval2'])) { setVar($repeat['interval2'], $_POST['repeat']['interval2'],'interval2'); } else { unset($repeat['interval2']); }
	if (isset($_POST['repeat']['frequency1'])) { setVar($repeat['frequency1'], $_POST['repeat']['frequency1'],'frequency1'); } else { unset($repeat['frequency1']); }
	if (isset($_POST['repeat']['frequency2modifier1'])) { setVar($repeat['frequency2modifier1'], $_POST['repeat']['frequency2modifier1'],'frequency2modifier1'); } else { unset($repeat['frequency2modifier1']); }
	if (isset($_POST['repeat']['frequency2modifier2'])) { setVar($repeat['frequency2modifier2'], $_POST['repeat']['frequency2modifier2'],'frequency2modifier2'); } else { unset($repeat['frequency2modifier2']); }
}
else {
  unset($repeat);
}

// The data about the event.
if (isset($_POST['event'])) {
	if (isset($_POST['event']['timebegin_year'])) { setVar($event['timebegin_year'],$_POST['event']['timebegin_year'],'timebegin_year'); } else { unset($event['timebegin_year']); }
	if (isset($_POST['event']['timebegin_month'])) { setVar($event['timebegin_month'],$_POST['event']['timebegin_month'],'timebegin_month'); } else { unset($event['timebegin_month']); }
	if (isset($_POST['event']['timebegin_day'])) { setVar($event['timebegin_day'],$_POST['event']['timebegin_day'],'timebegin_day'); } else { unset($event['timebegin_day']); }
	if (isset($_POST['event']['timebegin_hour'])) { setVar($event['timebegin_hour'],$_POST['event']['timebegin_hour'],'timebegin_hour'); } else { unset($event['timebegin_hour']); }
	if (isset($_POST['event']['timebegin_min'])) { setVar($event['timebegin_min'],$_POST['event']['timebegin_min'],'timebegin_min'); } else { unset($event['timebegin_min']); }
	if (isset($_POST['event']['timebegin_ampm'])) { setVar($event['timebegin_ampm'],$_POST['event']['timebegin_ampm'],'timebegin_ampm'); } else { unset($event['timebegin_ampm']); }
	if (isset($_POST['event']['timeend_year'])) { setVar($event['timeend_year'],$_POST['event']['timeend_year'],'timeend_year'); } else { unset($event['timeend_year']); }
	if (isset($_POST['event']['timeend_month'])) { setVar($event['timeend_month'],$_POST['event']['timeend_month'],'timeend_month'); } else { unset($event['timeend_month']); }
	if (isset($_POST['event']['timeend_day'])) { setVar($event['timeend_day'],$_POST['event']['timeend_day'],'timeend_day'); } else { unset($event['timeend_day']); }
	if (isset($_POST['event']['timeend_hour'])) { setVar($event['timeend_hour'],$_POST['event']['timeend_hour'],'timeend_hour'); } else { unset($event['timeend_hour']); }
	if (isset($_POST['event']['timeend_min'])) { setVar($event['timeend_min'],$_POST['event']['timeend_min'],'timeend_min'); } else { unset($event['timeend_min']); }
	if (isset($_POST['event']['timeend_ampm'])) { setVar($event['timeend_ampm'],$_POST['event']['timeend_ampm'],'timeend_ampm'); } else { unset($event['timeend_ampm']); }
	if (isset($_POST['event']['wholedayevent'])) { setVar($event['wholedayevent'],$_POST['event']['wholedayevent'],'wholedayevent'); } else { unset($event['wholedayevent']); }
	if (isset($_POST['event']['categoryid'])) { setVar($event['categoryid'],$_POST['event']['categoryid'],'categoryid'); } else { unset($event['categoryid']); }
	if (isset($_POST['event']['title'])) { setVar($event['title'],$_POST['event']['title'],'title'); } else { unset($event['title']); }
	if (isset($_POST['event']['location'])) { setVar($event['location'],$_POST['event']['location'],'location'); } else { unset($event['location']); }
	if (isset($_POST['event']['price'])) { setVar($event['price'],$_POST['event']['price'],'price'); } else { unset($event['price']); }
	if (isset($_POST['event']['description'])) { setVar($event['description'],$_POST['event']['description'],'description'); } else { unset($event['description']); }
	if (isset($_POST['event']['url'])) { setVar($event['url'],$_POST['event']['url'],'url'); } else { unset($event['url']); }
	if (isset($_POST['event']['sponsorid'])) { setVar($event['sponsorid'],$_POST['event']['sponsorid'],'sponsorid'); } else { unset($event['sponsorid']); }
	if (isset($_POST['event']['displayedsponsor'])) { setVar($event['displayedsponsor'],$_POST['event']['displayedsponsor'],'displayedsponsor'); } else { unset($event['displayedsponsor']); }
	if (isset($_POST['event']['displayedsponsorurl'])) { setVar($event['displayedsponsorurl'],$_POST['event']['displayedsponsorurl'],'url'); } else { unset($event['displayedsponsorurl']); }
	if (isset($_POST['event']['showincategory'])) { setVar($event['showincategory'],$_POST['event']['showincategory'],'categoryid'); } else { unset($event['showincategory']); }
	if (isset($_POST['event']['showondefaultcal'])) { setVar($event['showondefaultcal'],$_POST['event']['showondefaultcal'],'showondefaultcal'); } else { unset($event['showondefaultcal']); }
	if (isset($_POST['event']['contact_name'])) { setVar($event['contact_name'],$_POST['event']['contact_name'],'contact_name'); } else { unset($event['contact_name']); }
	if (isset($_POST['event']['contact_phone'])) { setVar($event['contact_phone'],$_POST['event']['contact_phone'],'contact_phone'); } else { unset($event['contact_phone']); }
	if (isset($_POST['event']['contact_email'])) { setVar($event['contact_email'],$_POST['event']['contact_email'],'contact_email'); } else { unset($event['contact_email']); }
	if (isset($_POST['event']['repeatid'])) { setVar($event['repeatid'],$_POST['event']['repeatid'],'repeatid'); } else { unset($event['repeatid']); }
	if (isset($_POST['event']['defaultallsponsor'])) { $event['defaultallsponsor'] = true; } else { unset($event['defaultallsponsor']); }
	if (isset($_POST['event']['defaultdisplayedsponsor'])) { $event['defaultdisplayedsponsor'] = true; } else { unset($event['defaultdisplayedsponsor']); }
	if (isset($_POST['event']['defaultdisplayedsponsorurl'])) { $event['defaultdisplayedsponsorurl'] = true; } else { unset($event['defaultdisplayedsponsorurl']); }
}
else {
  unset($event);	
}

// Check that the user is authorized.
if (!authorized()) { exit; }

// Set up where the user will be redirected if canceling or after submitting the event.
if (!isset($httpreferer)) {
	if (empty($_SERVER["HTTP_REFERER"])) {
		$httpreferer = "update.php";
	}
	else {
  	$httpreferer = $_SERVER["HTTP_REFERER"];
  }
}

// TODO: Should be removed?
if (isset($detailscaller)) { $httpreferer .= "&detailscaller=$detailscaller"; }

// Redirect the user back if cancel was pressed.
if (isset($cancel)) {
  redirect2URL($httpreferer);
  exit;
};

// Do some checks if the event ID was set.
if (!empty($eventid)) {
  $query = "SELECT sponsorid FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'";
  $result = DBQuery($query );
  
  // Check that the record exists in "vtcal_event".
  if ($result->numRows() > 0) {
  	  $e = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
  }
  
  // If it doesn't, check that it exists in "vtcal_event_public"
  else {
  	$query = "SELECT * FROM vtcal_event_public WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'";
		$result = DBQuery($query ); 
  	
		// If the event exists in "event_public", then insert it into "event" since it is missing...
		if ($result->numRows() > 0) {
			$e = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			insertintoevent($e['id'],$e);
		}
		
		// Otherwise, the event does not exist at all.
		else {
	    redirect2URL($httpreferer);
	    exit;
		}
  }
  
  // If the user is not the admin and not the sponsor, then redirect them away from this page.
  if (empty($_SESSION["AUTH_ADMIN"]) || !isset($_SESSION["AUTH_SPONSORID"]) || $_SESSION["AUTH_SPONSORID"] != $e['sponsorid']) {
       redirect2URL($httpreferer);
       exit;
  }
}

// Include the eventid with the submitted event data.
if (isset($eventid)) { $event['id'] = $eventid; }

// Check if the event data is valid.
$eventvalid = checkevent($event, $repeat);

// Override the passed sponsorid with the user's sponsor ID to avoid potential tampering with the values.
if (empty($event['sponsorid'])) {
  $event['sponsorid']=$_SESSION["AUTH_SPONSORID"];
}

// If the event is not repeating, make sure the end date is the same as the begin date.
if ($repeat['mode'] == 0) {
  $event['timeend_year']=$event['timebegin_year'];
  $event['timeend_month']=$event['timebegin_month'];
  $event['timeend_day']=$event['timebegin_day'];
}

// Otherwise, set up the repeating data.
if ($repeat['mode'] > 0 && !empty($repeat['interval1'])) {
	$repeat['repeatdef'] = repeatinput2repeatdef($event,$repeat);
}

// if event is a "whole day event" than set time to 12am
if ($event['wholedayevent']==1) {
  $event['timebegin_hour']=12;
  $event['timebegin_min']=0;
  $event['timebegin_ampm']="am";
  $event['timeend_hour']=11;
  $event['timeend_min']=59;
  $event['timeend_ampm']="pm";
}

// Reset the sponsor name/URL if the buttons were pressed.
if (isset($event['defaultdisplayedsponsor']) || isset($event['defaultallsponsor'])) {
  $event['displayedsponsor']=getSponsorName($event['sponsorid']);
}
if (isset($event['defaultdisplayedsponsorurl']) || isset($event['defaultallsponsor'])) {
  $event['displayedsponsorurl']=getSponsorURL($event['sponsorid']);
}

// Save event into DB (if it is valid).
if ((isset($savethis) || isset($saveall)) && $eventvalid) {
	
	// Assign a begin/end timestamp (YYYY-MM-DD HH:MM:SS AMPM)
  assemble_timestamp($event);

  // Make a list containing all the resulting dates (in case there are any)
  unset($repeatlist);
  if ($repeat['mode']>=1 && $repeat['mode']<=2) { $repeatlist = producerepeatlist($event,$repeat); }

	// Update an existing event (not a copy)
  if (isset($eventid) && (!isset($copy) || $copy != 1)) {

		// Before the event was non-reocurring
    if (empty($event['repeatid'])) {
    
    	// If the event is now reocurring
      if (sizeof($repeatlist) > 0) {
      	
        // Delete the old single event
        deletefromevent($eventid);

    	  // Insert recurrences
        $event['repeatid'] = $eventid; // = getNewEventId();
        insertintorepeat($event['repeatid'],$event,$repeat);
        insertrecurrences($event['repeatid'],$event,$repeatlist);
      }
      
      // Otherwise, the event is still non-reocurring.
      else {
      
      	// Delete the event if is a recurring event but has no real recurrences
        if ($repeat['mode']>=1 && $repeat['mode']<=2) {
          deletefromevent($eventid);
    	  }
    	  
    	  // Otherwise, update the event in the DB
        else {
          $event['repeatid']="";
	        updateevent($eventid, $event);
        }
      }
    }
    
    // Before the event was reocurring
    else {
    	
    	// The event still has recurrences
      if (!empty($repeatlist)) {
      
       	// Apply the changes to all recurrences
        if (isset($saveall) || (isset($savethis) /* && recurrenceschanged($event['repeatid'],$repeat,$event) */)) {
        	
       	  // Delete the old events
          repeatdeletefromevent($event['repeatid']);

          // Insert the new recurrences
          updaterepeat($event['repeatid'],$event,$repeat);
          insertrecurrences($event['repeatid'],$event,$repeatlist);
    	  }
    	  
    	  // Apply the changes only to one recurrence (recurrence pattern hasn't changed)
        elseif (isset($savethis)) {
          updateevent($eventid,$event);
        }
      }
      
      // The event is now non-reocurring.
      else {
      
      	// Delete the event if it is a recurring event but has no real recurrences
      	// TODO: Does this ever apply?
        if ($repeat['mode']>=1 && $repeat['mode']<=2) {
          repeatdeletefromevent($event['repeatid']);
          deletefromrepeat($event['repeatid']);
     	  }
     	  
				// Change the event to a non-reocurring event.
        else {
					deletefromrepeat($event['repeatid']);
     	    $oldrepeatid=$event['repeatid'];
					$eventid=$event['repeatid']; // added to avoid "...-0001" in eventid if it's not repeating
          $event['repeatid']="";
          insertintoevent($eventid,$event);
    	    
					// Delete all old recurring events but one
          repeatdeletefromevent($oldrepeatid);
          repeatdeletefromevent_public($oldrepeatid);
        }
      }
    }

    // Whatever the "admin" edits gets approved right away
    if ($_SESSION["AUTH_ADMIN"]) {
      if (!empty($event['repeatid'])) {
      	repeatpublicizeevent($eventid,$event);
      }
      else {
      	publicizeevent($eventid,$event);
      }
    }

    // Redirect the user back to the previous page.
    if (strpos($httpreferer,"update.php")) {
      redirect2URL("update.php?fbid=eupdatesuccess&fbparam=".urlencode($event['title']));
      exit;    
		}
    else {
      $target = $httpreferer;
      if (isset($detailscaller)) { $target .= "&detailscaller=".$detailscaller; }
      redirect2URL($target);
			exit;
    }
  }
  
  // Insert as a new event or copy of an existing event
  else {
  	// Event is re-ocurring.
    if (sizeof($repeatlist) > 0) {
    
	    // Create the new event ID.
      $event['repeatid'] = getNewEventId();
      
      // Insert in the DB.
      insertintorepeat($event['repeatid'],$event,$repeat);
      insertrecurrences($event['repeatid'],$event,$repeatlist);
      $eventid = "";
    }
    
  	// Event is not re-ocurring.
    else {
      $event['repeatid'] = "";
      
	    // Create the new event ID.
	    $eventid = getNewEventId();
	    
	    
	    // Insert into the DB.
      insertintoevent($eventid,$event);
    }
    
    $event['id'] = $eventid;

    // Whatever the "admin" edits gets approved right away
    if ($_SESSION["AUTH_ADMIN"]) {
    	if (!empty($event['repeatid'])) { repeatpublicizeevent($eventid,$event); }
      else { publicizeevent($eventid,$event); }
    }

    // Redirect the user back to the previous page.
    if (strpos($httpreferer,"update.php")) {
      redirect2URL("update.php?fbid=eaddsuccess&fbparam=".urlencode($event['title']));
      exit;
		}
    else {
      $target = $httpreferer;
      if (isset($detailscaller)) { $target .= "&detailscaller=".$detailscaller; }
      redirect2URL($target);
			exit;
    }
  }
}

// read sponsor name from DB
//$result = DBQuery("SELECT name,url FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($_SESSION["AUTH_SPONSORID"])."'" ); 
//$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);

// Display preview
if (isset($check) && $eventvalid && isset($preview)) {
	pageheader(lang('preview_event'), "Update");

	// determine the text representation in the form "MM/DD/YYYY" and the day of the week
	$day['text'] = Encode_Date_US($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']);
	$day['dow_text'] = Day_of_Week_Abbreviation(Day_of_Week($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']));
	assemble_timestamp($event);
	$event['css'] = datetoclass($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']);
	$event['color'] = datetocolor($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year'],$colorpast,$colortoday,$colorfuture);
	removeslashes($event);

	// determine the name of the category
	$result = DBQuery("SELECT id,name AS category_name FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($event['categoryid'])."'" ); 

	if ($result->numRows() > 0) { // error checking, actually there should be always a category
		$e = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		$event['category_name']=$e['category_name'];
	}
	else {
		$event['category_name']="???";
	}

	contentsection_begin(lang('preview_event'));

	?>
	<form method="post" action="changeeinfo.php">
	<p><input type="submit" name="savethis" value="<?php echo lang('save_changes'); ?>">
	<?php
	/*
			if ($repeat['mode'] > 0 && !empty($event['repeatid'])) {
				if (!recurrenceschanged($event['repeatid'],$repeat,$event)) {
					echo '<input type="submit" name="saveall" value="Save changes for ALL recurrences"><BR><BR>';
				}
			}
	*/
	?>
	<input type="submit" name="edit" value="<?php echo lang('go_back_to_make_changes'); ?>"> &nbsp;&nbsp;&nbsp;
	<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" onclick="location.href = '<?php echo $httpreferer; ?>'; return false;"></p>
	<p style="font-size: 18px; font-weight: bold; padding-bottom: 6px; margin-bottom: 0;"><?php
	  echo Day_of_Week_to_Text(Day_of_Week($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year'])),", ";
	  echo Month_to_Text($event['timebegin_month'])," ",$event['timebegin_day'],", ",$event['timebegin_year'];
	?></p>

	<table border="0" cellpadding="0" cellspacing="0"><tr><td style="border: 1px solid #666666;"><?php
  print_event($event);
	?></td></tr></table>
	
	<BR>
	<?php
	if (!checkeventtime($event)) {
		echo "<BR>";
		feedback(lang('warning_ending_time_before_starting_time'),1);
	}
	if ($event['timeend_hour']==0) {
		echo "<BR>";
		feedback(lang('warning_no_ending_time'),1);
	}

	echo '<span class="bodytext">';
	if ($repeat['mode'] > 0) {
		echo lang('recurring_event'),": ";
		$repeatdef = repeatinput2repeatdef($event,$repeat);
		printrecurrence($event['timebegin_year'],
										$event['timebegin_month'],
										$event['timebegin_day'],
										$repeatdef);
		echo "<BR>";
		$repeatlist = producerepeatlist($event,$repeat);
		printrecurrencedetails($repeatlist);
	}
	else {
		//echo lang('no_recurrences_defined');
	}
	
	if (isset($detailscaller)) { echo "<INPUT type=\"hidden\" name=\"detailscaller\" value=\"",$detailscaller,"\">\n"; }
	passeventvalues($event,$event['sponsorid'],$repeat); // add the common input fields
	
	?><INPUT type="hidden" name="check" value="1"><?php
	
	echo '<INPUT type="hidden" name="httpreferer" value="',$httpreferer,'">',"\n";
	if (isset($eventid)) { echo "<INPUT type=\"hidden\" name=\"eventid\" value=\"",$event['id'],"\">\n"; }
	if (isset($copy)) { echo "<INPUT type=\"hidden\" name=\"copy\" value=\"",$copy,"\">\n"; }
	?>
	<p><input type="submit" name="savethis" value="<?php echo lang('save_changes'); ?>">
	<input type="submit" name="edit" value="<?php echo lang('go_back_to_make_changes'); ?>"> &nbsp;&nbsp;&nbsp;
	<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" onclick="location.href = '<?php echo $httpreferer; ?>'; return false;"></p>
	</span>
	</form>
	<?php
	contentsection_end();
} // end: if (isset($check) && $eventvalid && isset($preview))

// Display input form
else {
	if (isset($eventid)) {
		if (isset($copy) && $copy == 1) {
			pageheader(lang('copy_event'), "Update");
			echo "<INPUT type=\"hidden\" name=\"copy\" value=\"",$copy,"\">\n";
		} else {
			pageheader(lang('update_event'), "Update");
		}
	}
	else {
		pageheader(lang('add_new_event'), "Update");
	}
	
	// Preset event with defaults if the form has not yet been submitted.
	if (!isset($check)) {
		defaultevent($event,$_SESSION["AUTH_SPONSORID"]);
	}
	
	// Load template if necessary
	if (isset($templateid)) {
		if ($templateid > 0) {
			$result = DBQuery("SELECT * FROM vtcal_template WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($templateid)."'" ); 
			$event = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		}
	}
	
	// "add new event" was started from week,month or detail view.
	if (isset($timebegin_year)) { $event['timebegin_year']=$timebegin_year; }
	if (isset($timebegin_month)) { $event['timebegin_month']=$timebegin_month; }
	if (isset($timebegin_day)) { $event['timebegin_day']=$timebegin_day; }
	
	// Load event to update information if it's the first time the form is viewed.
	if (isset($eventid) && (!isset($check) || $check != 1)) {
		$result = DBQuery("SELECT * FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'" ); 
		
		// Event exists in vtcal_event.
		if ($result->numRows() > 0) {
			$event = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		}
		// For some reason the event is not in vtcal_event (even though it should be).
		// Try to load it from "event_public".
		else {
			$result = DBQuery("SELECT * FROM vtcal_event_public WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'" ); 
	
			// Event exists in "event_public".
			// Insert into vtcal_event since it is missing.
			if ($result->numRows() > 0) {
				$event = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
				//eventaddslashes($event);
				insertintoevent($event['id'],$event);
			}
		}
	
		disassemble_timestamp($event);
		if (!empty($event['repeatid'])) {
			readinrepeat($event['repeatid'],$event,$repeat);
		}
		else { $repeat['mode'] = 0; }
	  //$sponsorid = $event[sponsorid];
	}
	
	contentsection_begin(lang('input_event_information'));
	
	echo "<form name=\"inputevent\" method=\"post\" action=\"changeeinfo.php\">\n";
	inputeventbuttons($httpreferer);
	
	if (isset($detailscaller)) { 
		echo "<INPUT type=\"hidden\" name=\"detailscaller\" value=\"",$detailscaller,"\">\n"; 
	}
	if (!isset($check)) { $check = 0; }
	inputeventdata($event,$event['sponsorid'],1,$check,1,$repeat,$copy);
	echo '<INPUT type="hidden" name="httpreferer" value="',$httpreferer,'">',"\n";
	if (isset($eventid)) { echo "<INPUT type=\"hidden\" name=\"eventid\" value=\"",$event['id'],"\">\n"; }
	echo '<INPUT type="hidden" name="event[repeatid]" value="',HTMLSpecialChars($event['repeatid']),"\">\n";
	if (!$_SESSION["AUTH_ADMIN"]) { echo "<INPUT type=\"hidden\" name=\"event[sponsorid]\" value=\"",$event['sponsorid'],"\">\n"; }
	if (isset($copy)) { echo "<INPUT type=\"hidden\" name=\"copy\" value=\"",$copy,"\">\n"; }
	
	inputeventbuttons($httpreferer);
	echo "</form>\n";
	
	contentsection_end();
} // end: ELSE of displaying the input form

pagefooter();
DBclose();
	
function passeventtimevalues($event,$repeat) {
  echo '<INPUT type="hidden" name="event[timebegin_year]" value="',HTMLSpecialChars($event['timebegin_year']),"\">\n";
  echo '<INPUT type="hidden" name="event[timebegin_month]" value="',HTMLSpecialChars($event['timebegin_month']),"\">\n";
  echo '<INPUT type="hidden" name="event[timebegin_day]" value="',HTMLSpecialChars($event['timebegin_day']),"\">\n";
  echo '<INPUT type="hidden" name="event[timebegin_hour]" value="',HTMLSpecialChars($event['timebegin_hour']),"\">\n";
  echo '<INPUT type="hidden" name="event[timebegin_min]" value="',HTMLSpecialChars($event['timebegin_min']),"\">\n";
  echo '<INPUT type="hidden" name="event[timebegin_ampm]" value="',HTMLSpecialChars($event['timebegin_ampm']),"\">\n";
  echo '<INPUT type="hidden" name="event[timeend_year]" value="',HTMLSpecialChars($event['timeend_year']),"\">\n";
  echo '<INPUT type="hidden" name="event[timeend_month]" value="',HTMLSpecialChars($event['timeend_month']),"\">\n";
  echo '<INPUT type="hidden" name="event[timeend_day]" value="',HTMLSpecialChars($event['timeend_day']),"\">\n";
  echo '<INPUT type="hidden" name="event[timeend_hour]" value="',HTMLSpecialChars($event['timeend_hour']),"\">\n";
  echo '<INPUT type="hidden" name="event[timeend_min]" value="',HTMLSpecialChars($event['timeend_min']),"\">\n";
  echo '<INPUT type="hidden" name="event[timeend_ampm]" value="',HTMLSpecialChars($event['timeend_ampm']),"\">\n";
  if (!empty($event['repeatid'])) {
		echo '<INPUT type="hidden" name="event[repeatid]" value="',$event['repeatid'],"\">\n";
	}
	echo '<INPUT type="hidden" name="repeat[mode]" value="',HTMLSpecialChars($repeat['mode']),'">',"\n";
  if (!empty($repeat['interval1'])) { echo '<INPUT type="hidden" name="repeat[interval1]" value="',$repeat['interval1'],'">',"\n"; }
 	if (!empty($repeat['frequency1'])) { echo '<INPUT type="hidden" name="repeat[frequency1]" value="',$repeat['frequency1'],'">',"\n"; }
  if (!empty($repeat['interval2'])) { echo '<INPUT type="hidden" name="repeat[interval2]" value="',$repeat['interval2'],'">',"\n"; }
  if (!empty($repeat['frequency2modifier1'])) { echo '<INPUT type="hidden" name="repeat[frequency2modifier1]" value="',$repeat['frequency2modifier1'],'">',"\n"; }
  if (!empty($repeat['frequency2modifier2'])) { echo '<INPUT type="hidden" name="repeat[frequency2modifier2]" value="',$repeat['frequency2modifier2'],'">',"\n"; }
}

function passeventvalues($event,$sponsorid,$repeat) {
  // pass the values
//  echo '<INPUT type="hidden" name="event[rejectreason]" value="',HTMLSpecialChars($event['rejectreason']),"\">\n";
	passeventtimevalues($event,$repeat);
  echo '<INPUT type="hidden" name="event[sponsorid]" value="',HTMLSpecialChars($event['sponsorid']),"\">\n";
  echo '<INPUT type="hidden" name="event[title]" value="',HTMLSpecialChars($event['title']),"\">\n";
  echo '<INPUT type="hidden" name="event[wholedayevent]" value="',HTMLSpecialChars($event['wholedayevent']),"\">\n";
  echo '<INPUT type="hidden" name="event[categoryid]" value="',HTMLSpecialChars($event['categoryid']),"\">\n";
  echo '<INPUT type="hidden" name="event[description]" value="',HTMLSpecialChars($event['description']),"\">\n";
  echo '<INPUT type="hidden" name="event[location]" value="',HTMLSpecialChars($event['location']),"\">\n";
  echo '<INPUT type="hidden" name="event[price]" value="',HTMLSpecialChars($event['price']),"\">\n";
  echo '<INPUT type="hidden" name="event[contact_name]" value="',HTMLSpecialChars($event['contact_name']),"\">\n";
  echo '<INPUT type="hidden" name="event[contact_phone]" value="',HTMLSpecialChars($event['contact_phone']),"\">\n";
  echo '<INPUT type="hidden" name="event[contact_email]" value="',HTMLSpecialChars($event['contact_email']),"\">\n";
  echo '<INPUT type="hidden" name="event[url]" value="',HTMLSpecialChars($event['url']),"\">\n";
  echo '<INPUT type="hidden" name="event[displayedsponsor]" value="',HTMLSpecialChars($event['displayedsponsor']),"\">\n";
  echo '<INPUT type="hidden" name="event[displayedsponsorurl]" value="',HTMLSpecialChars($event['displayedsponsorurl']),"\">\n";
	echo '<INPUT type="hidden" name="event[showondefaultcal]" value="',HTMLSpecialChars($event['showondefaultcal']),"\">\n";
  echo '<INPUT type="hidden" name="event[showincategory]" value="',HTMLSpecialChars($event['showincategory']),"\">\n";
} // end: function passeventvalues

// test if the recurrence info was changed, return true if it was
// not used because changing only one instance of a recurring event was too error-prone
/*
function recurrenceschanged($repeatid,&$repeat,&$event) {
  $repeat['startdate'] = datetime2timestamp($event['timebegin_year'],$event['timebegin_month'],$event['timebegin_day'],0,0,"am");
  $repeat['enddate'] = datetime2timestamp($event['timeend_year'],$event['timeend_month'],$event['timeend_day'],0,0,"am");

  $query = "SELECT * FROM vtcal_event_repeat WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($repeatid)."'";
  $result = DBQuery($query ); 
  $r = $result->fetchRow(DB_FETCHMODE_ASSOC,0);

  return ($r['repeatdef']!=$repeat['repeatdef']) ||
         (substr($r['startdate'],0,10)!=substr($repeat['startdate'],0,10)) ||
         (substr($r['enddate'],0,10)!=substr($repeat['enddate'],0,10));
} // end: function recurrenceschanged
*/

function insertrecurrences($repeatid,&$event,&$repeatlist) {
  $i = 0;
  while ($dateJD = each($repeatlist)) {
    $i++;
    $date = Decode_Date_US(JDToJulian($dateJD['value']));
    $event['timebegin_month'] = $date['month'];
    $event['timebegin_day']   = $date['day'];
    $event['timebegin_year']  = $date['year'];
    $event['timeend_month'] = $date['month'];
    $event['timeend_day']   = $date['day'];
    $event['timeend_year']  = $date['year'];
    assemble_timestamp($event);

    // insert event
    $eventidext = "";
	  if ($i<1000) {
      if ($i<100) {
	      if ($i<10) { 
		      $eventidext .= "0"; 
		    }
        $eventidext .= "0";
	    }
	    $eventidext .= "0";
	  }
    $eventidext .= $i;

    insertintoevent($repeatid."-".$eventidext,$event);
  } // end: while ($dateJD = each($repeatlist))
} // end: function insertrecurrences

/*function savechangesbuttons($event,$repeat) {
  echo '<INPUT type="submit" name="savethis" value="',lang('save_changes'),'"> ';
/ *
  if ($repeat['mode'] > 0 && !empty($event['repeatid'])) {
    if (!recurrenceschanged($event['repeatid'],$repeat,$event)) {
      echo '<INPUT type="submit" name="saveall" value="Save changes for ALL recurrences"><BR><BR>';
    }
  }
* /
} // end: function savechangesbuttons */

function inputeventbuttons($httpreferer) {
	?>
	<p><INPUT type="submit" name="preview" value="<?php echo lang('preview_event'); ?>">
  <INPUT type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>"  onclick="location.href = '<?php echo $httpreferer; ?>'; return false;"></p>
	<?php
}
?>