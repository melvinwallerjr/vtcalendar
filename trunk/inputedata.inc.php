<?php
  if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

function defaultevent(&$event,$sponsorid) {

	// Set the default date.
  $event['timebegin_year']=date("Y");
  $event['timebegin_month']=0;
  $event['timebegin_day']=0;
  
  // Set the default begin/end time.
  $event['timebegin_hour']=0;
  $event['timebegin_min']=0;
  $event['timebegin_ampm']="pm";
  $event['timeend_hour']=0;
  $event['timeend_min']=0;
  $event['timeend_ampm']="pm";

  // find sponsor name
  $result = DBQuery("SELECT name,url FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($sponsorid)."'" ); 
  $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);

  $event['sponsorid']=$sponsorid;
  $event['title']="";
  $event['wholedayevent']=0;
  $event['categoryid']=0;
  $event['description']="";
  $event['location']="";
  $event['price']="";
  $event['contact_name']="";
  $event['contact_phone']="";
  $event['contact_email']="";
  $event['url']="http://";
  $event['displayedsponsor'] = "";
  $event['displayedsponsorurl'] = ""; //$sponsor['url'];

  return 1;
} /* function defaultevent */

/* checks the validity of the time 1am-12pm or 0:00-23:00 */
function checktime($hour,$min) {
   global $use_ampm;
   if ($use_ampm){
      return
         (($hour>0) && ($hour<=12)) &&
         (($min>=0) && ($min<=59));
   }else{
	   return
         (($hour>=0) && ($hour<23)) &&
         (($min>=0) && ($min<=59));
   }
}

function checkeventdate(&$event,&$repeat) {
  if ($repeat['mode']==0) { // it's a one-time event (no recurrences)
    return (checkdate($event['timebegin_month'],
                      $event['timebegin_day'],
		                  $event['timebegin_year']));
  }
  else { // it's a recurring event
    return (checkdate($event['timebegin_month'],
                      $event['timebegin_day'],
                      $event['timebegin_year'])
            &&
            !empty($event['timeend_month']) && !empty($event['timeend_day']) && !empty($event['timeend_year'])
						&&
						checkdate($event['timeend_month'],
                      $event['timeend_day'],
                      $event['timeend_year'])
	          &&
            checkstartenddate($event['timebegin_month'],
	                            $event['timebegin_day'],
                              $event['timebegin_year'],
                              $event['timeend_month'],
                              $event['timeend_day'],
                              $event['timeend_year']));
  }
}

function checkstartenddate($startdate_month,$startdate_day,$startdate_year,
                           $enddate_month,$enddate_day,$enddate_year) {
  if (strlen($startdate_month) == 1) { $startdate_month = "0".$startdate_month; }
  if (strlen($startdate_day) == 1) { $startdate_day = "0".$startdate_day; }
  if (strlen($enddate_month) == 1) { $enddate_month = "0".$enddate_month; }
  if (strlen($enddate_day) == 1) { $enddate_day = "0".$enddate_day; }

  $startdate = $startdate_year.$startdate_month.$startdate_day;
  $enddate = $enddate_year.$enddate_month.$enddate_day;

  return $startdate <= $enddate;
} // end: function checkstartenddate

function checkeventtime(&$event) {
  if ($event['wholedayevent']==1) {
    return 1;
  }
  else {
    /* create two temporary variables to compare times */
    $timebegin_hour = $event['timebegin_hour'];
    if (strlen($timebegin_hour) == 1) { $timebegin_hour = "0".$timebegin_hour; }
    elseif ($timebegin_hour == "12") { $timebegin_hour = "00"; }
    $timebegin_min = $event['timebegin_min'];
    if (strlen($timebegin_min) == 1) { $timebegin_min = "0".$timebegin_min; }
    $timebegin = $event['timebegin_ampm'].$timebegin_hour.$timebegin_min;

    $timeend_hour = $event['timeend_hour'];
    if (strlen($timeend_hour) == 1) { $timeend_hour = "0".$timeend_hour; }
    elseif ($timeend_hour == "12") { $timeend_hour = "00"; }
    $timeend_min = $event['timeend_min'];
    if (strlen($timeend_min) == 1) { $timeend_min = "0".$timeend_min; }
    $timeend = $event['timeend_ampm'].$timeend_hour.$timeend_min;

    return
      (
        checktime($event['timebegin_hour'],$event['timebegin_min'])
      );
  }
}

function checkevent(&$event,&$repeat) {
  return
    (!empty($event['title'])) &&
    checkeventdate($event, $repeat) &&
    checkeventtime($event) &&
    ($event['categoryid']>=1) &&
    checkURL(urldecode($event['url'])) &&
    checkURL(urldecode($event['displayedsponsorurl'])) &&
		($_SESSION['CALENDARID'] == "default" || !isset($event['showondefaultcal']) || $event['showondefaultcal']==0 || $event['showincategory']!=0);
}

// shows the inputfields for the recurrence information
function inputrecurrences(&$event,&$repeat,$check) {
	?>
	<INPUT type="radio" name="repeat[mode]" id="repeatmode1" value="1"<?php if ($repeat['mode']==1) { echo " checked"; } ?>><label for="repeatmode1"> 
	<?php echo lang('repeat'); ?></label>
	<SELECT name="repeat[interval1]" size="1">
		<OPTION value="every"<?php if (isset($repeat['interval1']) && $repeat['interval1']=="every") { echo " selected"; } ?>><?php echo lang('every'); ?></OPTION>
		<OPTION value="everyother"<?php if (isset($repeat['interval1']) && $repeat['interval1']=="everyother") { echo " selected"; } ?>><?php echo lang('every_other'); ?></OPTION>
		<OPTION value="everythird"<?php if (isset($repeat['interval1']) && $repeat['interval1']=="everythird") { echo " selected"; } ?>><?php echo lang('every_third'); ?></OPTION>
		<OPTION value="everyfourth"<?php if (isset($repeat['interval1']) && $repeat['interval1']=="everyfourth") { echo " selected"; } ?>><?php echo lang('every_fourth'); ?></OPTION>
	</SELECT>
	<SELECT name="repeat[frequency1]" size="1">
		<OPTION value="day"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="day") { echo " selected"; } ?>><?php echo lang('day'); ?></OPTION>
		<OPTION value="week"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="week") { echo " selected"; } ?>><?php echo lang('week'); ?></OPTION>
		<OPTION value="month">Month<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="month") { echo " selected"; } ?></OPTION>
		<OPTION value="year"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="year") { echo " selected"; } ?>><?php echo lang('year'); ?></OPTION>
		<OPTION value="sunday"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="sunday") { echo " selected"; } ?>><?php echo lang('sun'); ?></OPTION>
		<OPTION value="monday"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="monday") { echo " selected"; } ?>><?php echo lang('mon'); ?></OPTION>
		<OPTION value="tuesday"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="tuesday") { echo " selected"; } ?>><?php echo lang('tue'); ?></OPTION>
		<OPTION value="wednesday"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="wednesday") { echo " selected"; } ?>><?php echo lang('wed'); ?></OPTION>
		<OPTION value="thursday"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="thursday") { echo " selected"; } ?>><?php echo lang('thu'); ?></OPTION>
		<OPTION value="friday"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="friday") { echo " selected"; } ?>><?php echo lang('fri'); ?></OPTION>
		<OPTION value="saturday"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="saturday") { echo " selected"; } ?>><?php echo lang('sat'); ?></OPTION>
		<OPTION value="monwedfri"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="monwedfri") { echo " selected"; } ?>><?php echo lang('mon'); ?>, <?php echo lang('wed'); ?>, <?php echo lang('fri'); ?></OPTION>
		<OPTION value="tuethu"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="tuethu") { echo " selected"; } ?>><?php echo lang('tue'); ?> &amp; <?php echo lang('thu'); ?></OPTION>
		<OPTION value="montuewedthufri"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="montuewedthufri") { echo " selected"; } ?>><?php echo lang('mon'); ?> - <?php echo lang('fri'); ?></OPTION>
		<OPTION value="satsun"<?php if (isset($repeat['frequency1']) && $repeat['frequency1']=="satsun") { echo " selected"; } ?>><?php echo lang('sat'); ?> &amp; <?php echo lang('sun'); ?></OPTION>
	</SELECT>
	<BR>
	<INPUT type="radio" name="repeat[mode]" id="repeatmode2" value="2"<?php if ($repeat['mode']==2) { echo " checked"; } ?>> <label for="repeatmode2"><?php echo lang('repeat_on_the'); ?></label>
	<SELECT name="repeat[frequency2modifier1]" size="1">
		<OPTION value="first"<?php if (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1']=="first") { echo " selected"; } ?>><?php echo lang('first'); ?></OPTION>
		<OPTION value="second"<?php if (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1']=="second") { echo " selected"; } ?>><?php echo lang('second'); ?></OPTION>
		<OPTION value="third"<?php if (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1']=="third") { echo " selected"; } ?>><?php echo lang('third'); ?></OPTION>
		<OPTION value="fourth"<?php if (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1']=="fourth") { echo " selected"; } ?>><?php echo lang('fourth'); ?></OPTION>
		<OPTION value="last"<?php if (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1']=="last") { echo " selected"; } ?>><?php echo lang('last'); ?></OPTION>
	</SELECT>
	<SELECT name="repeat[frequency2modifier2]" size="1">
		<OPTION value="sun"<?php if (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2']=="sun") { echo " selected"; } ?>><?php echo lang('sun'); ?></OPTION>
		<OPTION value="mon"<?php if (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2']=="mon") { echo " selected"; } ?>><?php echo lang('mon'); ?></OPTION>
		<OPTION value="tue"<?php if (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2']=="tue") { echo " selected"; } ?>><?php echo lang('tue'); ?></OPTION>
		<OPTION value="wed"<?php if (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2']=="wed") { echo " selected"; } ?>><?php echo lang('wed'); ?></OPTION>
		<OPTION value="thu"<?php if (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2']=="thu") { echo " selected"; } ?>><?php echo lang('thu'); ?></OPTION>
		<OPTION value="fri"<?php if (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2']=="fri") { echo " selected"; } ?>><?php echo lang('fri'); ?></OPTION>
		<OPTION value="sat"<?php if (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2']=="sat") { echo " selected"; } ?>><?php echo lang('sat'); ?></OPTION>
	</SELECT>
	of the month every
	<SELECT name="repeat[interval2]" size="1">
		<OPTION value="month"<?php if (isset($repeat['interval2']) && $repeat['interval2']=="month") { echo " selected"; } ?>><?php echo lang('month'); ?></OPTION>
		<OPTION value="2months"<?php if (isset($repeat['interval2']) && $repeat['interval2']=="2months") { echo " selected"; } ?>><?php echo lang('other_month'); ?></OPTION>
		<OPTION value="3months"<?php if (isset($repeat['interval2']) && $repeat['interval2']=="3months") { echo " selected"; } ?>>3 <?php echo lang('months'); ?></OPTION>
		<OPTION value="4months"<?php if (isset($repeat['interval2']) && $repeat['interval2']=="4months") { echo " selected"; } ?>>4 <?php echo lang('months'); ?></OPTION>
		<OPTION value="6months"<?php if (isset($repeat['interval2']) && $repeat['interval2']=="6months") { echo " selected"; } ?>>6 <?php echo lang('months'); ?></OPTION>
		<OPTION value="year"<?php if (isset($repeat['interval2']) && $repeat['interval2']=="year") { echo " selected"; } ?>><?php echo lang('year'); ?></OPTION>
	</SELECT>
	<BR>
	<BR>
	<?php
  if (isset($check) && $repeat['mode'] > 0) {

    if (!isset($event['timeend_month']) || !isset($event['timeend_day']) || !isset($event['timeend_year'])) {
      feedback(lang('specify_valid_ending_date'),1);
		}
    elseif (
		    !checkdate($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']) &&
        !checkdate($event['timeend_month'],$event['timeend_day'],$event['timeend_year'])
				) {
      feedback(lang('specify_valid_dates'),1);
    }
    elseif (!checkdate($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year'])) {
      feedback(lang('specify_valid_starting_date'),1);
    }
    elseif (!checkdate($event['timeend_month'],$event['timeend_day'],$event['timeend_year'])) {
      feedback(lang('specify_valid_ending_date'),1);
    }
    elseif (!checkstartenddate($event['timebegin_month'],
                               $event['timebegin_day'],
			                         $event['timebegin_year'],
                               $event['timeend_month'],
			                         $event['timeend_day'],
			                         $event['timeend_year'])) {
      feedback(lang('ending_date_after_starting_date'),1);
    }
  } // end: if (isset($check) && repeat[mode] > 0)
	
	?> from <?php
  inputdate($event['timebegin_month'],"event[timebegin_month]",
						$event['timebegin_day'],"event[timebegin_day]",
						$event['timebegin_year'],"event[timebegin_year]");
  echo " ",lang('to')," ";
	if (!isset($event['timeend_month']) || !isset($event['timeend_day']) || !isset($event['timeend_year'])) {
			inputdate(0,"event[timeend_month]",
			0,"event[timeend_day]",
			$event['timebegin_year'],"event[timeend_year]");
  }
	else {
		inputdate($event['timeend_month'],"event[timeend_month]",
							$event['timeend_day'],"event[timeend_day]",
							$event['timeend_year'],"event[timeend_year]");
	}
	
	?><BR><?php
} // end: function inputrecurrences

/* print out the event input form and use the provided parameter as preset */
function inputeventdata(&$event,$sponsorid,$inputrequired,$check,$displaydatetime,&$repeat,$copy) {
  /* now printing the HTML code for the input form */
  global $use_ampm;
  $unknownvalue = "???"; /* this is printed when the value of input field is unspecified */

  // the value of the radio box when user chooses recurring event
  $recurring = 10;
  
  $defaultButtonPressed = isset($event['defaultdisplayedsponsor']) || isset($event['defaultdisplayedsponsorurl']) || isset($event['defaultallsponsor']);

  // read sponsor name from DB
  //$result = DBQuery("SELECT name,url FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($sponsorid)."'" ); 
  //$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
  
	// switch from "recurring event" to "repeat ..."
	if ($repeat['mode']==$recurring) { $repeat['mode'] = 1; }
	
	if ($displaydatetime) {
		?>
		<div style="padding: 4px; margin-bottom: 6px; border-top: 1px solid #666666; background-color: #EEEEEE;"><h3 style="margin: 0; padding: 0; color: #0066CC; font-size: 16px;">Date &amp; Time:</h3></div>
		
		<div style="padding-left: 18px;">
		
		<?php
		// Do not allow the date/time to be changed if we are logged into the default calendar and the current event is from a different calendar.
		if ($_SESSION['CALENDARID'] == "default" && isset($event['showondefaultcal']) && $event['showondefaultcal'] == '1' && (!isset($copy) || $copy != 1)) {
			passeventtimevalues($event, $repeat);
			
			// Output the basic date/time information.
			echo Day_of_Week_to_Text(Day_of_Week($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']));
		  echo ", ";
			echo substr(Month_to_Text($event['timebegin_month']),0,3)," ",$event['timebegin_day'],", ",$event['timebegin_year'];
		  echo " -- ";
		  if ($event['wholedayevent']==0) {
				echo timestring($event['timebegin_hour'],$event['timebegin_min'],$event['timebegin_ampm']);
				if (endingtime_specified($event)) { // event has an explicit ending time
					echo " - ",timestring($event['timeend_hour'],$event['timeend_min'],$event['timeend_ampm']);
				}
		  }
			else {
			  echo lang('all_day');
			}
		
			// Output additional re-occurring event information.
			if (!empty($event['repeatid'])) {
				echo "<br>\n";
				echo '<font color="#00AA00">';
				readinrepeat($event['repeatid'],$event,$repeat);
				$repeatdef = repeatinput2repeatdef($event,$repeat);
				printrecurrence($event['timebegin_year'],
												$event['timebegin_month'],
												$event['timebegin_day'],
												$repeatdef);
				echo '</font>';
			}
		}
		
		// Otherwise, allow the date/time to be edited.
		else {
			?>
			<table border="0" cellpadding="2" cellspacing="0">
			<TR><TD class="bodytext" valign="top"><strong><?php echo lang('date'); ?>:</strong><?php
			
			if ($inputrequired) {
				?><FONT color="#FF0000">*</FONT><?php
			}
			
			?></TD><TD class="bodytext" valign="top"><?php
			
		  if ($inputrequired && $check && $repeat['mode'] == 0 && !checkeventdate($event,$repeat) && !$defaultButtonPressed) {
		    feedback(lang('date_invalid'),1);
		  }
	
			echo '<INPUT type="radio" name="repeat[mode]" value="0" id="onetime"';
			if (!isset($repeat['mode']) || $repeat['mode']==0) { echo " checked"; }
			echo ' onClick="this.form.submit()">';
			echo "\n<label for=\"onetime\">",lang('one_time_event'),"</label> ";
	
			if ($repeat['mode']==0) {
				if (!isset($event['timebegin_month'])) { $event['timebegin_month'] = 0; }
				if (!isset($event['timebegin_day'])) { $event['timebegin_day'] = 0; }
				if (!isset($event['timebegin_year'])) { $event['timebegin_year'] = 0; }
				
				inputdate($event['timebegin_month'],"event[timebegin_month]",
					$event['timebegin_day'],"event[timebegin_day]",
					$event['timebegin_year'],"event[timebegin_year]");
			}
			
			// Why is "$repeat['mode'] == $recurring" in this expression?! It's impossible for that to be true.
			if ($repeat['mode'] == 0 || $repeat['mode'] == $recurring) {
				echo "<BR>\n";
				echo "<INPUT type=\"radio\" name=\"repeat[mode]\" id=\"recurringevent\" value=\"$recurring\"";
				if ($repeat['mode']>=1) { echo " checked"; }
				echo ' onClick="this.form.submit()"><label for="recurringevent"> ',lang('recurring_event'),'</label>';
				echo "<BR>\n";
			}
			elseif ($repeat['mode']>=1 && $repeat['mode']<=2) {
				echo "<BR>\n";
				inputrecurrences($event,$repeat,$check);
			}
			echo "<BR>\n";
			
			?></TD></TR>
			
			<TR><TD class="bodytext" valign="top"><strong><?php echo lang('time'); ?>:</strong><?php
			
			if ($inputrequired) {
					?><FONT color="#FF0000">*</FONT><?php
			}
			
			?></TD><TD class="bodytext" valign="top"><?php
			
		  if ($inputrequired && $check && $event['wholedayevent']==0 && $event['timebegin_hour']==0 && !$defaultButtonPressed) {
		    feedback(lang('specify_all_day_or_starting_time'),1);
		  }
		  
		  ?>
			<INPUT type="radio" name="event[wholedayevent]" id="alldayevent" value="1"<?php if ($event['wholedayevent']==1) { echo " checked "; } ?>>
			<label for="alldayevent"><?php echo lang('all_day_event'); ?></label><BR>
			
			<INPUT type="radio" name="event[wholedayevent]" id="timedevent" value="0"<?php if ($event['wholedayevent']==0) { echo " checked "; } ?>>
			<label for="timedevent"><?php echo lang('timed_event'); ?>: <?php echo lang('from'); ?></label>
			<SELECT name="event[timebegin_hour]" size="1" onclick="setRadioButton('timedevent',true);">
			<?php
			
		  if ($event['timebegin_hour']==0) {
		    echo "<OPTION selected value=\"0\">",$unknownvalue,"</OPTION>\n";
		  }
	  	// print list with hours and select the one read from the DB
			if($use_ampm){
				$start_hour=1;
				$end_hour=12;
			}else{
				$start_hour=0;
				$end_hour=23;
			}
			for ($i=$start_hour; $i<=$end_hour; $i++) {
				echo "<OPTION ";
				if (isset($event['timebegin_hour']) && $event['timebegin_hour']==$i) { echo "selected "; }
				echo "value=\"$i\">$i</OPTION>\n";
			}
			
			?>
			</SELECT>
			<B>:</B>
			<SELECT name="event[timebegin_min]" size="1" onclick="setRadioButton('timedevent',true);">
			<?php
			
		  // print list with minutes and select the one read from the DB
		  for ($i=0; $i<=55; $i+=5) {
		    echo "<OPTION ";
		    if (isset($event['timebegin_min']) && $event['timebegin_min']==$i) { echo "selected "; }
		    if ($i < 10) { $j="0"; } else { $j=""; } // "0","5" to "00", "05"
		    echo "value=\"$i\">$j$i</OPTION>\n";
		  }
		  
			?>
			</SELECT>
			<?php 
	
		  if($use_ampm){
				?><SELECT name="event[timebegin_ampm]" size="1" onclick="setRadioButton('timedevent',true);">
		        <OPTION value="am"<?php if (isset($event['timebegin_ampm']) && $event['timebegin_ampm']=="am") {echo "selected"; } ?>>am</OPTION>
		        <OPTION value="pm"<?php if (isset($event['timebegin_ampm']) && $event['timebegin_ampm']=="pm") {echo "selected "; } ?>>pm</OPTION>
		       </SELECT><?php
			}
		
			echo ' ' . lang('to') . ' ';
		
			?><SELECT name="event[timeend_hour]" size="1" onclick="setRadioButton('timedevent',true);"><?php
		
		  if (!endingtime_specified($event)) {
		    $event['timeend_hour']=0;
		  }
	
			echo "<OPTION ";
			if (isset($event['timeend_hour']) && $event['timeend_hour']==0) { echo "selected "; }
			echo "value=\"0\">$unknownvalue</OPTION>\n";
			
			// print list with hours and select the one read from the DB
			if($use_ampm){
			  $start_hour=1;
			  $end_hour=12;
			}else{
			  $start_hour=0;
			  $end_hour=23;
			}
		  for ($i=$start_hour; $i<=$end_hour; $i++) {
		    echo "<OPTION ";
		    if (isset($event['timeend_hour']) && $event['timeend_hour']==$i) { echo "selected "; }
		    echo "value=\"$i\">$i</OPTION>\n";
		  }
		  
			?>
			</SELECT>
			<B>:</B>
			<SELECT name="event[timeend_min]" size="1" onclick="setRadioButton('timedevent',true);">
			<?php
			
		  // print list with minutes and select the one read from the DB
		  for ($i=0; $i<=55; $i+=5) {
		    echo "<OPTION ";
		    if (isset($event['timeend_min']) && $event['timeend_min']==$i) { echo "selected "; }
		    if ($i < 10) { $j="0"; } else { $j=""; } // "0","5" to "00", "05"
		    echo "value=\"$i\">$j$i</OPTION>\n";
		  }
			?>
			</SELECT>
			<?php
			
			if($use_ampm){
				?><SELECT name="event[timeend_ampm]" size="1" onclick="setRadioButton('timedevent',true);">
				<OPTION value="am" <?php if (isset ($event['timeend_ampm']) && $event['timeend_ampm']=="am") {echo "selected "; } ?>>am</OPTION>
				<OPTION value="pm" <?php if (isset($event['timeend_ampm']) && $event['timeend_ampm']=="pm") {echo "selected "; } ?>>pm</OPTION>
				</SELECT>
				<?php
			}
			?>
			&nbsp;<I><?php echo lang('ending_time_not_required'); ?></I>
			</TD>
			</TR>
			</table>
			<?php
		}
		
		?></div><?php
		
	} // End of date/time block.
	?>
	
	<div style="margin-top: 16px; padding: 4px; margin-bottom: 6px; border-top: 1px solid #666666; background-color: #EEEEEE;"><h3 style="margin: 0; padding: 0; color: #0066CC; font-size: 16px;">Basic Event Information:</h3></div>
	<div style="padding-left: 18px;">
	<table border="0" cellpadding="2" cellspacing="0">
	<TR>
	<TD class="bodytext" valign="top">
	<strong><?php echo lang('category'); ?>:</strong>
	<?php
	if ($inputrequired) {
		?><FONT color="#FF0000">*</FONT><?php
  }
  
	?>
	</TD>
	<TD class="bodytext" valign="top">
	<?php

  if ($inputrequired && $check && ($event['categoryid']==0) && !$defaultButtonPressed) {
    feedback(lang('choose_category'),1);
  }
  
	?>
  <SELECT name="event[categoryid]" size="1">
	<?php
	
  // read event categories from DB
  $result = DBQuery("SELECT * FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY name ASC" ); 

  // print list with categories and select the one read from the DB

  if ($event['categoryid']==0) {
    echo "<OPTION selected value=\"0\">$unknownvalue</OPTION>\n";
  }
  for ($i=0;$i<$result->numRows();$i++) {
    $category = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);

    echo "<OPTION ";
    if (isset($event['categoryid']) && $event['categoryid']==$category['id']) { echo "selected "; }
    echo "value=\"".htmlentities($category['id'])."\">".htmlentities($category['name'])."</OPTION>\n";
  }
?>
      </SELECT>
    </TD>
  </TR>
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('title'); ?>:</strong>
<?php
  if ($inputrequired) {
?>
<FONT color="#FF0000">*</FONT>
<?php
  }
?>
    </TD>
    <TD class="bodytext" valign="top">
<?php
  if ($inputrequired && $check && (empty($event['title'])) && !$defaultButtonPressed) {
    feedback(lang('choose_title'),1);
  }
?>
      <INPUT type="text" size="24" name="event[title]" maxlength=<?php echo constTitleMaxLength; ?> value="<?php
  if (isset($event['title'])) {
	  if ($check) { $event['title']=$event['title']; }
    echo HTMLSpecialChars($event['title']);
	}
?>">
      <I><?php echo lang('title_example'); ?></I><BR>
    </TD>
  </TR>
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('description'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
      <TEXTAREA name="event[description]" rows="10" cols="60" wrap=virtual><?php
  if (isset($event['description'])) {
	  if ($check) { $event['description']=$event['description']; }
    echo HTMLSpecialChars($event['description']);
	}
?></TEXTAREA>
      <BR>
      <i>Note:</i> Web and e-mail addresses are automatically linked.
    </TD>
  </TR>
	</table>
	</div>
	
	<div style="margin-top: 16px; padding: 4px; margin-bottom: 6px; border-top: 1px solid #666666; background-color: #EEEEEE;">
		<h3 style="margin: 0; padding: 0; color: #0066CC; font-size: 16px;">Additional Event Information:</h3>
	</div>
	<div style="padding-left: 18px;">
	<table border="0" cellpadding="2" cellspacing="0">
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('location'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
      <INPUT type="text" size="24" name="event[location]" maxlength=<?php echo constLocationMaxLength; ?> value="<?php
  if (isset($event['location'])) {
    if ($check) { $event['location']=$event['location']; }
    echo HTMLSpecialChars($event['location']);
	}
?>"> <I><?php echo lang('location_example'); ?></I><BR>
    </TD>
  </TR>
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('price'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
      <INPUT type="text" size="24" name="event[price]" maxlength=<?php echo constPriceMaxLength; ?>  value="<?php
  if (isset($event['price'])) {
    if ($check) { $event['price']=$event['price']; }
    echo HTMLSpecialChars($event['price']);
	}
?>"> <I><?php echo lang('price_example'); ?></I><BR>
    </TD>
  </TR>
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('contact_name'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
      <INPUT type="text" size="24" name="event[contact_name]" maxlength=<?php echo constContact_nameMaxLength; ?> value="<?php
  if (isset($event['contact_name'])) {
    if ($check) { $event['contact_name']=$event['contact_name']; }
    echo HTMLSpecialChars($event['contact_name']);
	}
?>"> <I><?php echo lang('contact_name_example'); ?></I>
    </TD>
  </TR>
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('contact_phone'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
      <INPUT type="text" size="24" name="event[contact_phone]" maxlength=<?php echo constContact_phoneMaxLength; ?> value="<?php
  if (isset($event['contact_phone'])) {
    if ($check) { $event['contact_phone']=$event['contact_phone']; }
    echo HTMLSpecialChars($event['contact_phone']);
	}
?>"> <I><?php echo lang('contact_phone_example'); ?></I>
    </TD>
  </TR>
  <TR>
    <TD class="bodytext" valign="top">
       <strong><?php echo lang('contact_email'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
      <INPUT type="text" size="24" name="event[contact_email]" maxlength=<?php echo constEmailMaxLength; ?> value="<?php
  if (isset($event['contact_email'])) {
    if ($check) { $event['contact_email']=$event['contact_email']; }
    echo HTMLSpecialChars(urldecode($event['contact_email']));
	}
?>"> <I><?php echo lang('contact_email_example'); ?></I>
    </TD>
  </TR>
  <?php /*
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('event_page_web_address'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
<?php
  if ($check && isset($event['url']) && !checkURL($event['url']) && !$defaultButtonPressed) {
    feedback(lang('url_invalid'),1);
  }
?>
      <INPUT type="text" size="50" name="event[url]" maxlength=<?php echo constUrlMaxLength; ?> value="<?php
  if (isset($event['url'])) {
    if ($check) { $event['url']=$event['url']; }
    echo HTMLSpecialChars($event['url']);
	}
?>">
      <BR>
      <I><?php echo lang('event_page_url_example'); ?></I><BR>
    </TD>
  </TR>
  */ ?>
  </table>
  </div>
	<?php
  if (!$_SESSION["AUTH_ADMIN"]) {
  	// Not actually submitted since it has no "name" attribute. The point of this is to allow the "Restore default" buttons to work properly.
  	?><input type="hidden" id="selectedsponsorid" value="<?php echo $event['sponsorid']; ?>"><?php
  }
  else {
		?>
		<div style="margin-top: 16px; padding: 4px; margin-bottom: 6px; border-top: 1px solid #666666; background-color: #EEEEEE;">
			<h3 style="margin: 0; padding: 0; color: #0066CC; font-size: 16px;">Owner of this Event:</h3>
			<div style="padding: 2px; padding-left: 15px;">This is the sponsor who owns this event in the calendar system.<br>
			The sponsor who owns this event is able to copy and delete it, as well as submit new versions for approval.</div>
			</div>
		<div style="padding-left: 18px;">
	  <table border="0" cellpadding="2" cellspacing="0">
	  <TR>
	    <TD class="bodytext">
	      <strong><?php echo lang('sponsor'); ?>:</strong>
	    </TD>
	    <TD class="bodytext"><?php
	    	if ($_SESSION['CALENDARID'] == "default" && isset($event['showondefaultcal']) && $event['showondefaultcal'] == '1' && (!isset($copy) || $copy != 1)) {
	    		?><input type="hidden" id="selectedsponsorid" name="event[sponsorid]" value="<?php echo $event['sponsorid']; ?>">
	    		<input type="hidden" name="event[showondefaultcal]" value="<?php echo $event['showondefaultcal']; ?>">
	    		<input type="hidden" name="event[showincategory]" value="<?php echo $event['showincategory']; ?>"><?php
	    		echo htmlentities(getSponsorName($event['sponsorid']));
	    		echo ' (from the &quot;'.htmlentities(getSponsorCalendarName($event['sponsorid'])).'&quot; calendar)';
	    	}
	    	else {
		    	?>
		      <SELECT id="selectedsponsorid" name="event[sponsorid]" size="1">
						<?php
						// read sponsors from DB
						$result = DBQuery("SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY name ASC" ); 
						
						// print list with sponsors and select the one read from the DB
						
						for ($i=0;$i<$result->numRows();$i++) {
							$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
							
							echo "<OPTION ";
							if ($event['sponsorid']==$sponsor['id']) { echo "selected "; }
							echo "value=\"".htmlentities($sponsor['id'])."\">".htmlentities($sponsor['name'])."</OPTION>\n";
						}
						?>
		      </SELECT>
		     <?php
		    }
		    ?>
	      <!--<INPUT type="submit" name="event[defaultallsponsor]" value="<?php echo lang('button_restore_all_sponsor_defaults'); ?>">-->
	    </TD>
	  </TR>
		</table>
		</div>
		<?php
  } // end: if ($_SESSION["AUTH_ADMIN"])
	?>
	
	<div style="margin-top: 16px; padding: 4px; margin-bottom: 6px; border-top: 1px solid #666666; background-color: #EEEEEE;">
		<h3 style="margin: 0; padding: 0; color: #0066CC; font-size: 16px;">Information About the Event's Sponsor:</h3>
		<div style="padding: 2px; padding-left: 15px;">This is information about the department or organization that is the official sponsor of the event.<br>
		For example, if this event was Commencement then the sponsor would be the Office of the Secretary.</div>
		</div>
	<div style="padding-left: 18px;">
	<table border="0" cellpadding="2" cellspacing="0">
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('displayed_sponsor_name'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
      <INPUT type="text" id="defaultsponsornametext" size="50" name="event[displayedsponsor]" maxlength=<?php echo constDisplayedsponsorMaxLength; ?> value="<?php
  if (isset($event['displayedsponsor'])) {
    if ($check) { $event['displayedsponsor']=$event['displayedsponsor']; }
    echo HTMLSpecialChars($event['displayedsponsor']);
	}
?>">
      <INPUT type="submit" id="defaultsponsornamebutton" name="event[defaultdisplayedsponsor]" value="Restore default" onclick="return SetSponsorDefault(1);">
    </TD>
  </TR>
  <TR>
    <TD class="bodytext" valign="top">
      <strong><?php echo lang('sponsor_page_web_address'); ?>:</strong>
    </TD>
    <TD class="bodytext" valign="top">
<?php
  if ($check && isset($event['displayedsponsorurl']) && !checkURL($event['displayedsponsorurl']) && !$defaultButtonPressed) {
    feedback(lang('url_invalid'),1);
  }
?>
      <INPUT type="text" id="defaultsponsorurltext" size="50" name="event[displayedsponsorurl]" maxlength=<?php echo constDisplayedsponsorurlMaxLength; ?> value="<?php
  if (isset($event['displayedsponsorurl'])) {
    if ($check) { $event['displayedsponsorurl']=$event['displayedsponsorurl']; }
    echo HTMLSpecialChars($event['displayedsponsorurl']);
	}
?>">
      <INPUT type="submit" id="defaultsponsorurlbutton" name="event[defaultdisplayedsponsorurl]" value="<?php echo lang('button_restore_default'); ?>" onclick="return SetSponsorDefault(2);">
      <BR>
    </TD>
  </TR>
  </table>
  </div>
<?php
  if ( $_SESSION["CALENDARID"] != "default" && $inputrequired ) {
	  $defaultcalendarname = getCalendarName('default');
		?>
		<div style="margin-top: 16px; padding: 4px; margin-bottom: 6px; border-top: 1px solid #666666; background-color: #EEEEEE;">
			<h3 style="margin: 0; padding: 0; color: #0066CC; font-size: 16px;">Submit to the &quot;<?php echo $defaultcalendarname; ?>&quot; calendar.:</h3>
			<div style="padding: 2px; padding-left: 15px;">Submit this event for approval to be added to the &quot;<?php echo $defaultcalendarname; ?>&quot; calendar.</div>
		</div>
		<div style="padding-left: 18px;">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top"><input type="checkbox" name="event[showondefaultcal]" value="1"<?php 
	  		if ( (isset($event['showondefaultcal']) && $event['showondefaultcal']=="1") ||
				     (!isset($event['showondefaultcal']) && $_SESSION["FORWARDEVENTDEFAULT"]=="1")
				) { echo " checked"; }
	      ?>></td>
	    <td valign="top"><b>Yes</b>,&nbsp;</td>
			<td>submit this event to the &quot;<?php echo $defaultcalendarname; ?>&quot; calendar and
				<table border="0" cellpadding="2" cellspacing="0">
		  		<tr>
			  		<td>assign it to the</td>
			  		<td>
			  			<SELECT name="event[showincategory]" size="1">
								<?php
								  // read event categories from DB
								  $result = DBQuery("SELECT * FROM vtcal_category WHERE calendarid='default' ORDER BY name ASC" );
								
								  // print list with categories and select the one read from the DB
								  if (empty($event['showincategory'])) {
								    echo "<OPTION selected value=\"0\">$unknownvalue</OPTION>\n";
								  }
								  for ($i=0;$i<$result->numRows();$i++) {
								    $category = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
								
								    echo "<OPTION ";
								    if (!empty($event['showincategory']) && $event['showincategory']==$category['id']) { echo "selected "; }
								    echo "value=\"".htmlentities($category['id'])."\">".htmlentities($category['name'])."</OPTION>\n";
								  }
								?>
				      </SELECT>
						</td>
			  		<td>category on that calendar.</td>
		  		</tr>
		  	</table>
	      <?php
			  if ($check && !empty($event['showondefaultcal']) && $event['showondefaultcal']==1 && (empty($event['showincategory']) || $event['showincategory']==0) && !$defaultButtonPressed) {
			    feedback(lang('choose_category'),1);
			  }
				?>
		  </td>
		</tr>
		</table>
		</div>
		<?php
  } // end: if ( $_SESSION["CALENDARID"] != "default" )
?>
<INPUT type="hidden" name="check" value="1">
<?php
  return 1;
} // end of function: "inputeventdata"
?>