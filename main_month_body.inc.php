<?php
  if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files
?>

<!-- Start Month Body -->
<table id="MonthTable" width="100%" border="0" cellpadding="3" cellspacing="0">
	<thead>
	<tr align="center">
	<?php if($week_start == 0){?>
		<td><strong><?php echo lang('sunday');?></strong></td>
	<?php } ?>
	<td><strong><?php echo lang('monday');?></strong></td>
	<td><strong><?php echo lang('tuesday');?></strong></td>
	<td><strong><?php echo lang('wednesday');?></strong></td>
	<td><strong><?php echo lang('thursday');?></strong></td>
	<td><strong><?php echo lang('friday');?></strong></td>
	<td><strong><?php echo lang('saturday');?></strong></td>
	<?php if($week_start == 1){?>
		<td><strong><?php echo lang('sunday');?></strong></td>
	<?php } ?>
	</tr>
	</thead>
	
	<tbody>
	<?php
	
  $ievent = 0;
  // read all events for this week from the DB
  $query = "SELECT e.id AS eventid,e.timebegin,e.timeend,e.sponsorid,e.title,e.wholedayevent,e.categoryid,c.id,c.name AS category_name FROM vtcal_event_public e, vtcal_category c ";
	$query .= "WHERE e.calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND c.calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND e.categoryid = c.id AND e.timebegin >= '".sqlescape($monthstart['timestamp'])."' AND e.timeend <= '".sqlescape($monthend['timestamp'])."'";
  if ($sponsorid != "all")  { $query.= " AND (e.sponsorid='".sqlescape($sponsorid)."')"; }

	if ( isset($filtercategories) && count($filtercategories) > 0 ) {
	  $query.= " AND (";
		for($c=0; $c < count($filtercategories); $c++) {
		  if ($c > 0) { $query.=" OR "; }
		  $query.= "(e.categoryid='".sqlescape($filtercategories[$c])."')";
    }
		$query.= ")";
	}
	else {
	   if ($categoryid != 0) { $query.= " AND (e.categoryid='".sqlescape($categoryid)."')"; }
	}

  if (!empty($keyword)) { $query.= " AND ((e.title LIKE '%".sqlescape($keyword)."%') OR (e.description LIKE '%".sqlescape($keyword)."%'))"; }
  $query.= " ORDER BY e.timebegin ASC, e.wholedayevent DESC";
  $result = DBQuery($database, $query ); 

  // read first event if one exists
  if ($ievent < $result->numRows()) {
    $event = $result->fetchRow(DB_FETCHMODE_ASSOC,$ievent);
    $event_timebegin  = timestamp2datetime($event['timebegin']);
    $event_timeend    = timestamp2datetime($event['timeend']);
  }

  // print 6 lines for the weeks
  for ($iweek=1; $iweek<=6; $iweek++) {
    // first day of the week
    $weekstart = Add_Delta_Days($monthstart['month'],$monthstart['day'],$monthstart['year'],($iweek-1)*7);
    $weekstart['timestamp'] = datetime2timestamp($weekstart['year'],$weekstart['month'],$weekstart['day'],12,0,"am");
    
    // print the 5th and the 6th week only if the days are still in this month
    if (($iweek < 5) || ($weekstart['month'] == $month['month'])) {
      echo "<tr>\n";

      // output event info for every day
      for ($weekday = 0; $weekday <= 6; $weekday++) {
        // calculate the appropriate day for the cell of the calendar
        $iday = Add_Delta_Days($monthstart['month'],$monthstart['day'],$monthstart['year'],($iweek-1)*7+$weekday);
        $iday['timebegin'] = datetime2timestamp($iday['year'],$iday['month'],$iday['day'],0,0,"am");
        $iday['timeend']   = datetime2timestamp($iday['year'],$iday['month'],$iday['day'],11,59,"pm");

        $iday['css'] = datetoclass($iday['month'],$iday['day'],$iday['year']);
        $iday['color'] = datetocolor($iday['month'],$iday['day'],$iday['year'],$colorpast,$colortoday,$colorfuture);
        $datediff = Delta_Days($iday['month'],$iday['day'],$iday['year'],date("m"),date("d"),date("Y"));
        
				echo "<td ";
				
				// If the day is not part of the current month, then output a background color.
        if ($month['month'] != $iday['month']) {
			    //echo 'style="background-color: #EEEEEE;" ';
			    echo 'class="MonthDay-OtherMonth" ';
			  }
        elseif ($datediff > 0) {
			    echo 'class="MonthDay-Past" ';
			  }
			  elseif ($datediff == 0) {
			    echo 'class="MonthDay-Today" ';
			  }
			  else {
			    echo 'class="MonthDay-Future" ';
			  }
				echo 'valign="top">';
				
				// Do not display events that are not in the current month.
				// Eventually this will be changed to the query does not pull the events in the first place.
				if ($month['month'] != $iday['month']) {
					echo "&nbsp;";
				}
				else {
					// Number for the current day
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
					if (!empty($_SESSION["AUTH_SPONSORID"])) { // display "add event" icon
	          echo '<td><a style="font-size: 11px;" href="addevent.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&timebegin_year='.$iday['year']."&timebegin_month=".$iday['month']."&timebegin_day=".$iday['day']."\" title=\"",lang('add_new_event'),"\">";
	          //echo "[New Event]";
	          echo '<img src="images/nuvola/16x16/actions/filenew.png" height="16" width="16" title="',lang('add_new_event'),'" alt="',lang('add_new_event'),'" border="0">';
	          echo '</a></td>';
	        }
					echo '<td width="100%"><div class="DayNumber"><b><a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=day&timebegin=',urlencode(datetime2timestamp($iday['year'],$iday['month'],$iday['day'],12,0,"am")),$queryStringExtension,'">';
					echo $iday['day'];
					echo "</a></b></div></td>";
					echo "</tr></table>";
				}
				
        // print all events of one day
        while (($ievent < $result->numRows())
                &&
               ($event_timebegin['year']==$iday['year']) &&
               ($event_timebegin['month']==$iday['month']) &&
               ($event_timebegin['day']==$iday['day'])) {
          
					// Do not display events that are not in the current month.
					// Eventually this will be changed to the query does not pull the events in the first place.
					if ($month['month'] == $iday['month']) {
					
				    $event_timebegin_num = timestamp2timenumber($event['timebegin']);
				    $event_timeend_num = timestamp2timenumber($event['timeend']);
						$begintimediff = $currentTimestamp_num - $event_timebegin_num;
						$endtimediff = $currentTimestamp_num - $event_timeend_num;
						$EventHasPassed = ( $datediff > 0 || ( $datediff == 0 && $endtimediff > 0 ) );
				
						if ($EventHasPassed) {
							$event['classExtension'] = "-Past";
						}
						
	      	  // print event
						echo '<p class="EventItem'.$event['classExtension'].'"><a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=event&eventid=',$event['eventid'],'&timebegin=';
						echo urlencode(datetime2timestamp($event_timebegin['year'],$event_timebegin['month'],$event_timebegin['day'],12,0,"am"));
						echo '">',htmlentities($event['title']),'</a></p>';
						
	        }
          // read next event if one exists
          $ievent++;
          if ($ievent < $result->numRows()) {
            $event = $result->fetchRow(DB_FETCHMODE_ASSOC,$ievent);
            $event_timebegin  = timestamp2datetime($event['timebegin']);
            $event_timeend    = timestamp2datetime($event['timeend']);
            $event['css'] = $iday['css'];
            $event['color'] = $iday['color'];
          }
        } // end: while (...)
        
        //}

				echo "</td>\n";
      } // end: for ($weekday = 0; $weekday <= 6; $weekday++)
      echo "</tr>\n";
    } // end: if (($iweek < 5) || ($weekstart[month] == $month[month])
  } // end: for ($iweek=1; $iweek<=6; $iweek++)

?>
</tbody>
</table>

<?php if (!empty($_SESSION["AUTH_SPONSORID"])) { ?>
<table border="0" cellpadding="3" cellspacing="0">
	<tr>
		<td><img src="images/nuvola/16x16/actions/filenew.png" height="16" width="16" alt="" border="0"></td>
		<td>= <?php echo lang('add_new_event'); ?></td>
	</tr>
</table>
<?php } ?>
<!-- End Month Body -->
