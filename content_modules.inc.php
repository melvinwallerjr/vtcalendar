<?php

/*
function displayLittleCalendar($month, $view, $showdate, $queryStringExtension)
function displayMonthSelector()
function print_event($event, $linkfeatures=true)
function adminButtons($eventORshowdate, $buttons, $size, $orientation)
*/

function displayLittleCalendar($month, $view, $showdate, $queryStringExtension) {
	global $week_start;
	global $day_beg_h, $day_end_h;
	global $colorpast, $colortoday, $colorfuture;
	
	$today = Decode_Date_US(date("m/d/Y"));
	
	/*$plus_one_month['day']   = 1;
	$plus_one_month['month'] = $month['month'] + 1;
	$plus_one_month['year']  = $month['year'];
	if ($plus_one_month['month'] == 13) {
		$plus_one_month['month'] = 1;
		$plus_one_month['year']++;
	}*/

	// date of first Sunday or Monday according to week beginning day in month1
	$month['dow'] = Day_of_Week($month['month'],1,$month['year']);

	// $week_correction - variable to make one week correction according to week's starting weekday
	if ($week_start == 1 && $month['dow'] == 0){
		$week_correction=7;
	} else {
		$week_correction=0;
	}

	$monthstart = Add_Delta_Days($month['month'],1,$month['year'],-$month['dow']+$week_start-$week_correction);

	// when does this particular week start and end?
	$dow = Day_of_Week($showdate['month'],$showdate['day'],$showdate['year']);
	$weekfrom = Add_Delta_Days($showdate['month'],$showdate['day'],$showdate['year'],-$dow+$week_start); //if $week_start is 1 we get Monday as week's start
	$weekto = Add_Delta_Days($showdate['month'],$showdate['day'],$showdate['year'],6-$dow+$week_start); //if $week_start is 1 we get Sunday week's end

	?>
	<!-- Start Little Calendar -->
	<div id="LittleCalendar-Padding">
	<table id="LittleCalendar" border="0" cellpadding="3" cellspacing="0">
		<!-- Start Calendar Column Titles (Names of the day of the week) -->
		<thead>
		<tr>
			<td align="center" width="16%" nowrap>&nbsp;</td>
			<?php if($week_start == 0){?>
				<td align="center" width="12%" nowrap><?php echo lang('lit_cal_sun'); ?></td>
			<?php } ?>
			<td align="center" width="12%" nowrap><?php echo lang('lit_cal_mon');?></td>
			<td align="center" width="12%" nowrap><?php echo lang('lit_cal_tue');?></td>
			<td align="center" width="12%" nowrap><?php echo lang('lit_cal_wed');?></td>
			<td align="center" width="12%" nowrap><?php echo lang('lit_cal_thu');?></td>
			<td align="center" width="12%" nowrap><?php echo lang('lit_cal_fri');?></td>
			<td align="center" width="12%" nowrap><?php echo lang('lit_cal_sat');?></td>
			<?php if($week_start == 1){?>
				<td align="center" width="12%" nowrap><?php echo lang('lit_cal_sun');?></td>
			<?php } ?>
		</tr>
		</thead>
		<!-- End Calendar Column Titles -->
		
		<!-- Start Calendar Body -->
		<tbody>
		<?php 
	  // print 6 lines for the weeks
	  for ($iweek=1; $iweek<=6; $iweek++) {
	    // first day of the week
	    $weekstart = Add_Delta_Days($monthstart['month'],$monthstart['day'],$monthstart['year'],($iweek-1)*7);
	    $weekstart['timestamp'] = datetime2timestamp($weekstart['year'],$weekstart['month'],$weekstart['day'],12,0,"am");
	    
	    // print the 5th and the 6th week only if the days are still in this month
	    if (($iweek < 5) || ($weekstart['month'] == $month['month'])) {
	      echo "<tr>\n";
	      
	      // output the link to the week
	      echo '<td class="LittleCalendar-Week" nowrap valign="top" align="left">';
	      echo '<a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=week&amp;timebegin='.urlencode($weekstart['timestamp']).'">'.lang('lit_cal_week')."&gt;</a></td>\n";
	      
	      // output event info for every day
	      for ($weekday = 0; $weekday <= 6; $weekday++) {
	        // calculate the appropriate day for the cell of the calendar
	        $iday = Add_Delta_Days($monthstart['month'],$monthstart['day'],$monthstart['year'],($iweek-1)*7+$weekday);
	        //$iday['timebegin'] = datetime2timestamp($iday['year'],$iday['month'],$iday['day'],0,0,"am");
	        //$iday['timeend']   = datetime2timestamp($iday['year'],$iday['month'],$iday['day'],11,59,"pm");
	        
	        //$iday['css'] = datetoclass($iday['month'],$iday['day'],$iday['year']);
	        //$iday['color'] = datetocolor($iday['month'],$iday['day'],$iday['year'],$colorpast,$colortoday,$colorfuture);
	        echo '<td nowrap ';
	        
          if ( $view == "day" || $view == "event" ) { 
    				if ( $iday['day']==$showdate['day'] && $iday['month']==$showdate['month'] && $iday['year']==$showdate['year']) {
  						echo 'class="SelectedDay" ';
						}
					} 
					else if ( $view == "week" ) { 
            $datediff1 = Delta_Days($weekfrom['month'],$weekfrom['day'],$weekfrom['year'],$iday['month'],$iday['day'],$iday['year']);				
            $datediff2 = Delta_Days($iday['month'],$iday['day'],$iday['year'],$weekto['month'],$weekto['day'],$weekto['year']);
						if ( $datediff1 >= 0 && $datediff2 >= 0 ) {
  						echo 'class="SelectedDay" ';
						}
					}
					else if ( $view == "month" ) { 
					  if ($iday['month']==$showdate['month'] && $iday['year']==$showdate['year']) {
  						echo 'class="SelectedDay" ';
						}
					}
					
					echo 'valign="top" align="center">';
					
					echo '<a ';
					if ( $iday['day']==$today['day'] && $iday['month']==$today['month'] && $iday['year']==$today['year']) {
  					$DayLinkClass = "Today";
					}
					else {
						$DayLinkClass = "";
					}
					if ( $iday['month']!=$month['month'] ) {
						$DayLinkClass .= "GrayedOut";
					}
					if (isset($DayLinkClass)) {
						echo 'class="LittleCal-'.$DayLinkClass.'" ';
					}
					// "&timeend=",urlencode(datetime2timestamp($iday['year'],$iday['month'],$iday['day'],11,59,"pm")),
					echo 'href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=day&amp;timebegin=', urlencode(datetime2timestamp($iday['year'],$iday['month'],$iday['day'],12,0,"am")) . $queryStringExtension . '">';
					echo $iday['day'];
					echo '</a>';
	        
					echo "</td>\n";
	      } // end: for ($weekday = 0; $weekday <= 6; $weekday++)
	      echo "</tr>\n";
	    } // end: if (($iweek < 5) || ($weekstart[month] == $month[month])
	  } // end: for ($iweek=1; $iweek<=6; $iweek++)
		?>
		</tbody>
		<!-- End Calendar Body -->
	</table>
	</div>
	<!-- End Little Calendar -->
	<?php
}

/**
 * Outputs the content for the "Month Selector" in the left column.
 */
function displayMonthSelector() {
	global $view, $minus_one_month, $plus_one_month, $enableViewMonth, $month, $queryStringExtension, $timebegin, $showdate;
	?>
	<!-- Start Month Selector -->
	<table id="MonthSelector" width="100%" border="0" cellpadding="3" cellspacing="0">
		<tr>
			<!-- Left Arrow Button -->
			<td align="left" valign="middle" width="17"><div id="LeftArrowButton"><a title="<?php echo lang('previous_month'); ?>" href="<?php
			echo 'main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view='.$view."&timebegin=".urlencode(datetime2timestamp($minus_one_month['year'],$minus_one_month['month'],$minus_one_month['day'],12,0,"am"));
			echo $queryStringExtension;
			?>" onclick="return ChangeCalendar('Left','<?php
			echo "main_littlecalendar.php?view=".$view;
			echo "&littlecal=".urlencode(datetime2timestamp($minus_one_month['year'],$minus_one_month['month'],$minus_one_month['day'],12,0,"am"));
			echo "&timebegin=".urlencode($timebegin);
			echo $queryStringExtension;
			?>');"><b>&laquo;</b></a></div><div id="LeftArrowButtonDisabled" style="color:#999999; display: none;"><b>&laquo;</b></div></td>
			<!-- Date Label -->
			<td align="center" nowrap valign="middle"><b><?php
				  if ( ($view == "month" && $showdate['month'] == $month['month'] && $showdate['year'] == $month['year'] ) || !$enableViewMonth ) {
				    echo above_lit_cal_date_format (Month_to_Text($month['month']), $month['year']);
				  }
					else {
				    echo '<a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=month&amp;timebegin=' . urlencode(datetime2timestamp($month['year'],$month['month'],$month['day'],12,0,"am"));
				    echo $queryStringExtension;
				    echo '">';
				    echo above_lit_cal_date_format( Month_to_Text($month['month']), $month['year'] );
				    echo "</a>";
					}
				?></b></td>
			<!-- Right Arrow Button -->
			<td align="right" valign="middle" width="17"><div id="RightArrowButton"><a title="<?php echo lang('next_month'); ?>" href="<?php
			echo 'main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view='.$view."&timebegin=".urlencode(datetime2timestamp($plus_one_month['year'],$plus_one_month['month'],$plus_one_month['day'],12,0,"am"));
			echo $queryStringExtension;
			?>" onclick="return ChangeCalendar('Right','<?php
			echo "main_littlecalendar.php?view=".$view;
			echo "&littlecal=".urlencode(datetime2timestamp($plus_one_month['year'],$plus_one_month['month'],$plus_one_month['day'],12,0,"am"));
			echo "&timebegin=".urlencode($timebegin);
			echo $queryStringExtension;
			?>');"><b>&raquo;</b></a></div><div id="RightArrowButtonDisabled" style="color:#999999; display: none;"><b>&raquo;</b></div></td>
		</tr>
	</table>
	<!-- End Month Selector -->
	<?php
}

function print_event($event, $linkfeatures=true) {
	global $lang, $day_end_h;
	?>
  <table id="EventTable" width="100%" border="0" cellpadding="6" cellspacing="0">
		<tr>
			<!-- Start Left Column -->
      <td id="EventLeftColumn" valign="top" align="center" nopwrap><b>
				<?php 
					if ($event['wholedayevent']==0) {
						echo timestring($event['timebegin_hour'],$event['timebegin_min'],$event['timebegin_ampm']);
						if ( ! ($event['timeend_hour']==$day_end_h && $event['timeend_min']==59) ) {
						  echo "<br>",lang('to'),"<br>";
						  echo timestring($event['timeend_hour'],$event['timeend_min'],$event['timeend_ampm']);
						}
			    }
					else {
					  echo lang('all_day'),"\n";
					}
				?></b></td>
			
			<!-- Start Right Column -->
      <td id="EventRightColumn" width="100%" valign="top">
      	<div id="EventTitle"><b><?php echo htmlentities($event['title']); ?></b></div>
      	<div id="EventCategory">(<?php echo htmlentities($event['category_name']); ?>)</div>
				<?php 
			  if (!empty($event['description'])) {
					?><p id="EventDescription"><?php echo str_replace("\r", "<br>", make_clickable(htmlentities($event['description']))); ?></p><?php
			  }
			  if (!empty($event['url']) && $event['url'] != "http://") {
					?><div id="EventURL"><a href="<?php echo htmlentities($event['url']),"\">",lang('more_information');?></a></div><?php
			  } // end: if (!empty($event['url'])) {
				?>
				
	      <div id="EventDetailPadding"><table id="EventDetail" border="0" cellpadding="6" cellspacing="0"><?php 
	      	
				  if (!empty($event['location'])) {
						?>
		        <tr> 
		          <td class="EventDetail-Label" align="left" valign="top" nowrap><strong><?php echo lang('location'); ?>:</strong></td>
		          <td><?php echo htmlentities($event['location']); ?></td>
		        </tr>
						<?php
				  } // end: if (!empty($event['location'])) {
				  
				  if (!empty($event['price'])) {
						?>
		        <tr> 
		          <td class="EventDetail-Label" align="left" valign="top" nowrap><strong><?php echo lang('price'); ?>:</strong></td>
		          <td><?php echo htmlentities($event['price']); ?></td>
		        </tr>
						<?php
					} // end: if (!empty($event['price'])) {
					
					if (!empty($event['displayedsponsor'])) {
						?>
		        <tr> 
		          <td class="EventDetail-Label" align="left" valign="top" nowrap><strong><?php echo lang('sponsor'); ?>:</strong></td>
		          <td><?php 
						    if (!empty($event['displayedsponsorurl'])) {
								  echo '<a href="',$event['displayedsponsorurl'],'">';
									echo htmlentities($event['displayedsponsor']);
									echo "</a>";
								}
								else {
								  echo htmlentities($event['displayedsponsor']);
								}
							?></td>
		        </tr>
						<?php
					} // end: if (!empty($event['displayedsponsor'])) {
					
					if (!empty($event['contact_name']) ||
					    !empty($event['contact_email']) ||
							!empty($event['contact_phone']) )
					{
						?>
		        <tr> 
		          <td class="EventDetail-Label" align="left" valign="top" nowrap><strong><?php echo lang('contact'); ?>:</strong></td>
		          <td><?php
								if (!empty($event['contact_name']) )
									{ echo htmlentities($event['contact_name']),"<br>"; }
								if (!empty($event['contact_email']) )
								{ 
								  echo '<img src="images/email.gif" width="20" height="20" alt="',lang('email'),'" align="absmiddle">';
								  echo " <a href=\"mailto:",htmlentities($event['contact_email']),"\">",htmlentities($event['contact_email']),"</a><br>";
								}
								if (!empty($event['contact_phone']) )
								{ 
									echo '<img src="images/phone.gif" width="20" height="20" align="absmiddle"> ';
									echo htmlentities($event['contact_phone']),"<br>";
								} 
							?></td>
		        </tr>
						<?php
					} // end: if (...)
					?>
				</table>
				</div>
				<?php
				if ($linkfeatures) {
					?>
					<div id="iCalendarLink">
							<?php
						  if (!empty($event['id'])) {
								?>						
								<a 
						      href="icalendar.php?eventid=<?php echo $event['id']; ?>"><img 
						      src="images/vcalendar.gif" width="20" height="20" border="0" align="absmiddle"></a>
						    <a href="icalendar.php?eventid=<?php echo $event['id']; ?>"><?php echo lang('copy_event_to_pda'); ?></a>
								<?php
						  } // end: if (!empty($event['id']))
							?>
					</div>
					<?php
				} ?>
			</td>
    </tr>
  </table>
<?php		
} // end: Function print_event

function adminButtons($eventORshowdate, $buttons, $size, $orientation) {
	if (is_array($buttons)) {
	
		if (isset($eventORshowdate['id']) && !isset($eventORshowdate['eventid'])) {
			$eventORshowdate['eventid'] = $eventORshowdate['id'];
		}
		elseif (!isset($eventORshowdate['id']) && isset($eventORshowdate['eventid'])) {
			$eventORshowdate['id'] = $eventORshowdate['eventid'];
		}
		?>
		<div <?php if ($size=="small") { echo 'id="AdminButtons-Small"'; } ?>>
		<table id="AdminButtons" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<?php
				foreach ($buttons as $button) {
					if ($button == "new") {
						$IDExt = '-New';
						$HRef = 'addevent.php?calendarid='.urlencode($_SESSION["CALENDARID"]);
						if (isset($eventORshowdate['year']) && isset($eventORshowdate['month']) && isset($eventORshowdate['day'])) {
							$HRef .= '&timebegin_year=' . $eventORshowdate['year'] . '&timebegin_month=' . $eventORshowdate['month'] . '&timebegin_day=' . $eventORshowdate['day'];
						}
						if ($size == "small") {
							$Label = "New";
						}
						else {					
							$Label = lang('add_new_event');
						}
					}
					elseif ($button == "approve") {
						$IDExt = '-Approve';
						$HRef = 'approval.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&';
						if (!empty($eventORshowdate['repeatid'])) {
							$HRef .= "approveall=1";
						}
						else {
							$HRef .= "approvethis=1";
						}
						$HRef .= '&eventid=' . $eventORshowdate['eventid'];
						$Label = lang('approve');
					}
					elseif ($button == "reject") {
						$IDExt = '-Reject';
						$HRef = 'approval.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&reject=1&eventid=' . $eventORshowdate['eventid'];
						$Label = lang('reject');
					}
					elseif ($button == "edit") {
						$IDExt = '-Edit';
						$HRef = 'changeeinfo.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&eventid=' . $eventORshowdate['eventid'];
						$Label = lang('edit');
					}
					elseif ($button == "update") {
						$IDExt = '-Edit';
						$HRef = 'changeeinfo.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&eventid=' . $eventORshowdate['eventid'];
						$Label = 'Update';
					}
					elseif ($button == "copy") {
						$IDExt = '-Copy';
						// Note: Do not use &copy in the URL. Some browsers will think you are trying to do &copy; which is a copyright symbol.
						$HRef = 'changeeinfo.php?copy=1&calendarid='.urlencode($_SESSION["CALENDARID"]).'&eventid=' . $eventORshowdate['eventid'];
						$Label = lang('copy');
					}
					elseif ($button == "delete") {
						$IDExt = '-Delete';
						$HRef = 'deleteevent.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&check=1&eventid=' . $eventORshowdate['eventid'];
						$Label = lang('delete');
					}
					
					if ($orientation == "vertical") {
						echo '<tr>';
						echo '<td style="padding-bottom: 3px !important;">';
					}
					else {
						echo '<td style="padding-right: 5px !important;">';
					}
					
					echo '<a id="AdminButtons' . $IDExt . '" href="' . $HRef . '">' . $Label . '</a></td>';
					if ($orientation == "vertical") { echo '</tr>'; }
				}
				?>
			</tr>
		</table>
		</div>
		<?php
	}
}

?>