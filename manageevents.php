<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
require_once('application.inc.php');

if (!authorized()) { exit; }

pageheader(lang('manage_events'), "Update");
contentsection_begin(lang('manage_events'),true);

$ievent = 0;
$today = Decode_Date_US(date("m/d/Y"));
$today['timestamp_daybegin']=datetime2timestamp($today['year'],$today['month'],$today['day'],12,0,"am");

// Output list with events
$query  = "SELECT e.calendarid = 'default' as isdefaultcal, e.calendarid as calendarid, e.id AS id,e.approved,e.rejectreason,e.timebegin,e.timeend,e.repeatid,e.sponsorid,e.displayedsponsor,e.displayedsponsorurl,e.title,e.wholedayevent,e.categoryid,e.description,e.location,e.price,e.contact_name,e.contact_phone,e.contact_email,e.url,c.id AS cid,c.name AS category_name,s.id AS sid,s.name AS sponsor_name,s.url AS sponsor_url FROM vtcal_event e, vtcal_category c, vtcal_sponsor s WHERE ";
$query .= "e.categoryid = c.id AND e.sponsorid = s.id AND e.sponsorid='".sqlescape($_SESSION["AUTH_SPONSORID"])."' ORDER BY e.timebegin, e.wholedayevent DESC, e.id, isdefaultcal";
//Removed from the query's 'WHERE' clause: AND e.timebegin >= '".$today['timestamp_daybegin']."'
$result = DBQuery($query);
?>

<p><a href="addevent.php"><?php echo lang('add_new_event'); ?></a>
<?php

if ($result->numRows() > 0 ) {
	?>
	<?php echo lang('or_manage_existing_events'); ?></p><?php
	
	$defaultcalendarname = getCalendarName('default');
	
	/*
	
	Below you see a list of all <i>future</i> events. <span style="color:#FF0000; font-weight:bold">Past events are NOT shown here.</span><br>
	However, you can use the <a href="main.php?view=day">day</a>/<a href="main.php?view=week">week</a>/<a href="main.php?view=month">month</a> view to find, edit and delete past events.<br>
	<br>
	*/
	?>
	<table border="0" cellspacing="0" cellpadding="4">
	  <tr bgcolor="#CCCCCC">
	    <td bgcolor="#CCCCCC"><b><?php echo lang('title'); ?>/<?php echo lang('date'); ?>/<?php echo lang('time'); ?></b></td>
	    <td bgcolor="#CCCCCC"><b><?php echo lang('status'); ?></b></td>
	    <td bgcolor="#CCCCCC">&nbsp;</td>
	  </tr>
		<?php
	  $color = "#eeeeee";
	  for ($i=0; $i<$result->numRows(); $i++) {
	    $event = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
	    disassemble_timestamp($event);
	    
	    // Skip this event if this event is from the "default" calendar
	    // but is not following its corresponding event from this calendar or has yet to be approved.
	    if ($_SESSION['CALENDARID'] != "default" && $event['isdefaultcal'] == 1 && (!isset($PreviousEvent) || $event['id'] != $PreviousEvent['id'] || $PreviousEvent['approved'] == 0)) {
	    	continue;
	    }
	
			// keep track of repeat id and print recurring events only once
	  	if (!empty($event['repeatid'])) { 
			  if ( isset($recurring_exists) && array_key_exists ($event['repeatid'].$event['calendarid'],$recurring_exists) ) { continue; }
				else { 
				  // remember this recurring event
					$recurring_exists[$event['repeatid'].$event['calendarid']] = $event['repeatid'].$event['calendarid']; 
				}
			}
			
			if ($_SESSION['CALENDARID'] == "default" || $event['isdefaultcal'] == 0)
			{
				if ( $color == "#eeeeee" )
					{ $color = "#ffffff"; }
				else
					{ $color = "#eeeeee"; }
			}
			?>	
		  <tr bgcolor="<?php echo $color; ?>">
		    <td <?php if ($_SESSION['CALENDARID'] != "default" && $event['isdefaultcal'] == 1) { echo 'style="padding-top: 0; padding-bottom: 7px;" class="DefaultCalendarEvent"'; } ?> bgcolor="<?php echo $color; ?>" valign="top">
		    	<div>
			    <?php
			    if ($_SESSION['CALENDARID'] != "default" && $event['isdefaultcal'] == 1) {
			    	echo "This event was submitted to the &quot;".$defaultcalendarname."&quot; calendar";
			    	
			    	if (isset($PreviousEvent) && $PreviousEvent['title'] != $event['title']) {
			    		echo ',<br>but was renamed to: &quot;'.htmlentities($event['title']).'&quot;';
			    	}
			    	echo ".";
			    }
			    else {
			    	echo '<b>'.htmlentities($event['title']).'</b><br>';
					  // output date
					  echo Day_of_Week_Abbreviation(Day_of_Week($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']));
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
					?></div></td>
		    <td <?php if ($_SESSION['CALENDARID'] != "default" && $event['isdefaultcal'] == 1) { echo 'style="padding-top: 0; padding-bottom: 7px;" colspan="2"'; } ?> bgcolor="<?php echo $color; ?>" valign="top">
					<?php
			    if ($event['approved'] == -1) {
			      echo '<FONT color="red"><B>rejected</B></FONT>';
			      if (!empty($event['rejectreason'])) { echo "<BR><B>Reason:</B> ",htmlentities($event['rejectreason']); }
			    }
			    elseif ($event['approved'] == 0) {
			      echo '<FONT color="blue">',lang('submitted_for_approval'),'</FONT><br>';
			    }
			    elseif ($event['approved'] == 1) {
			      echo '<FONT color="green">',lang('approved'),'</FONT><br>';
			    }
					?></td>
			  <?php
			  if ($_SESSION['CALENDARID'] == "default" || $event['isdefaultcal'] == 0) {
			  	?>
			    <td <?php if ($_SESSION['CALENDARID'] != "default" && $event['isdefaultcal'] == 1) { echo 'style="padding-top: 0; padding-bottom: 7px;"'; } ?> bgcolor="<?php echo $color; ?>" valign="top"><?php
			    		adminButtons($event, array('update','copy','delete'), "small", "horizontal");
			    	 ?></td>
			    <?php
		    }
		    ?>
		  </tr>
			<?php
			$PreviousEvent['id'] = $event['id'];
			$PreviousEvent['title'] = $event['title'];
			$PreviousEvent['approved'] = $event['approved'];
		} // end: for ($i=0; $i<$result->numRows(); $i++)
	?>	
	</table>

	<br><b><?php echo lang('status_info_message'); ?></b><br>
	<table border="0" cellspacing="0" cellpadding="3">
	<tr>
	  <td><FONT color="red"><B><?php echo lang('rejected'); ?></B></FONT></td>
	  <td><?php echo lang('rejected_explanation'); ?></td>
	<tr>
	  <td><FONT color="blue"><?php echo lang('submitted_for_approval'); ?></FONT></td>
	  <td><?php echo lang('submitted_for_approval_explanation'); ?></td>
	<tr>
	  <td><FONT color="green"><?php echo lang('approved'); ?></FONT></td>
	  <td><?php echo lang('approved_explanation'); ?></td>
	</tr></table>
	
	<?php
} // end: if ($result->numRows() > 0 )

contentsection_end();
pagefooter();
DBclose();

?>