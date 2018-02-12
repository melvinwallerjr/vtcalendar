<?php
require_once('application.inc.php');
require_once('main_globalsettings.inc.php');

displayMonthSelector();
displayLittleCalendar($month, $view, $showdate, $queryStringExtension);

function displayLittleCalendar($month, $view, $showdate, $queryStringExtension)
{
	$today = Decode_Date_US(date('m/d/Y', NOW));
	/*
	$plus_one_month['day'] = 1;
	$plus_one_month['month'] = $month['month'] + 1;
	$plus_one_month['year'] = $month['year'];
	if ($plus_one_month['month'] == 13) {
		$plus_one_month['month'] = 1;
		$plus_one_month['year']++;
	}
	*/

	// date of first Sunday or Monday according to week beginning day in month1
	$month['dow'] = Day_of_Week($month['month'], 1, $month['year']);

	// $week_correction - variable to make one week correction according to week's starting weekday
	if (WEEK_STARTING_DAY == 1 && $month['dow'] == 0) { $week_correction = 7; }
	else { $week_correction = 0; }

	$monthstart = Add_Delta_Days($month['month'], 1, $month['year'],
	 - $month['dow'] + WEEK_STARTING_DAY - $week_correction);

	// when does this particular week start and end?
	$dow = Day_of_Week($showdate['month'], $showdate['day'], $showdate['year']);
	// if WEEK_STARTING_DAY is 1 we get Monday as week's start
	$weekfrom = Add_Delta_Days($showdate['month'], $showdate['day'],
	 $showdate['year'], - $dow + WEEK_STARTING_DAY);
	// if WEEK_STARTING_DAY is 1 we get Sunday week's end
	$weekto = Add_Delta_Days($showdate['month'], $showdate['day'],
	 $showdate['year'], 6 - $dow + WEEK_STARTING_DAY);

	echo '
<div id="LittleCalendar-Padding"><table id="LittleCalendar" border="0" cellspacing="0" cellpadding="3">
<thead><tr>
<th width="16%">&nbsp;</th>';
	if (WEEK_STARTING_DAY == 0) {
		echo'
<th width="12%">' . lang('lit_cal_sun') . '</th>';
	}
	echo '
<th width="12%">' . lang('lit_cal_mon') . '</th>
<th width="12%">' . lang('lit_cal_tue') . '</th>
<th width="12%">' . lang('lit_cal_wed') . '</th>
<th width="12%">' . lang('lit_cal_thu') . '</th>
<th width="12%">' . lang('lit_cal_fri') . '</th>
<th width="12%">' . lang('lit_cal_sat') . '</th>';
	if (WEEK_STARTING_DAY == 1) {
		echo '
<th width="12%">' . lang('lit_cal_sun') . '</th>';
	}
	echo '
</tr></thead>
<tbody>';
	// print 6 lines for the weeks
	for ($iweek=1; $iweek <= 6; $iweek++) {
		// first day of the week
		$weekstart = Add_Delta_Days($monthstart['month'], $monthstart['day'],
		 $monthstart['year'], ($iweek - 1) * 7);
		$weekstart['timestamp'] = datetime2timestamp($weekstart['year'],
		 $weekstart['month'], $weekstart['day'], 12, 0, 'am');
		// print the 5th and the 6th week only if the days are still in this month
		if ($iweek < 5 || $weekstart['month'] == $month['month']) {
			echo '<tr>
<td class="LittleCalendar-Week"><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=week&amp;timebegin=' . urlencode($weekstart['timestamp']) . '">' . lang('lit_cal_week') . '</a></td>';
			// output event info for every day
			for ($weekday=0; $weekday <= 6; $weekday++) {
				// calculate the appropriate day for the cell of the calendar
				$iday = Add_Delta_Days($monthstart['month'], $monthstart['day'],
				 $monthstart['year'], (($iweek - 1) * 7) + $weekday);
				/*
				$iday['timebegin'] = datetime2timestamp($iday['year'], $iday['month'],
				 $iday['day'], 0, 0, 'am');
				$iday['timeend'] = datetime2timestamp($iday['year'], $iday['month'],
				 $iday['day'], 11, 59, 'pm');
				*/
				$TDclass = '';
				if ($view == 'day' || $view == 'event') {
					if ($iday['day'] == $showdate['day'] && $iday['month'] == $showdate['month'] &&
					 $iday['year'] == $showdate['year']) {
						$TDclass = ' class="SelectedDay"';
					}
				}
				elseif ($view == 'week') {
					$datediff1 = Delta_Days($weekfrom['month'], $weekfrom['day'],
					 $weekfrom['year'], $iday['month'], $iday['day'], $iday['year']);
					$datediff2 = Delta_Days($iday['month'], $iday['day'], $iday['year'],
					 $weekto['month'], $weekto['day'], $weekto['year']);
					if ($datediff1 >= 0 && $datediff2 >= 0) { $TDclass = ' class="SelectedDay"'; }
				}
				elseif ($view == 'month') {
					if ($iday['month'] == $showdate['month'] && $iday['year'] == $showdate['year']) {
						$TDclass = ' class="SelectedDay"';
					}
				}
				$DayLinkClass = '';
				if ($iday['day'] == $today['day'] && $iday['month'] == $today['month'] &&
				 $iday['year'] == $today['year']) {
					$DayLinkClass = 'Today';
				}
				if ($iday['month'] != $month['month']) { $DayLinkClass .= 'GrayedOut'; }
				if ($DayLinkClass != '') {
					$DayLinkClass = ' class="LittleCal-' . $DayLinkClass . '"';
				}
				echo '
<td' . $TDclass . '><a' . $DayLinkClass . ' href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=day&amp;timebegin=' . urlencode(datetime2timestamp($iday['year'], $iday['month'], $iday['day'], 12, 0, 'am')) . $queryStringExtension . '">' . $iday['day'] . '</a></td>';
				// "&amp;timeend=", urlencode(datetime2timestamp($iday['year'],
				// $iday['month'], $iday['day'], 11, 59, 'pm')),
			}
			echo '
</tr>';
		}
	}
	echo '</tbody>
</table></div><!-- #LittleCalendar -->';
}

function displayMonthSelector()
{ // Outputs the content for the "Month Selector" in the left column.
	global $view, $minus_one_month, $plus_one_month, $enableViewMonth,
	 $month, $queryStringExtension, $timebegin, $showdate;

	echo '
<table id="MonthSelector" width="100%" border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<td width="17" class="alignLeft"><div id="LeftArrowButton"><a title="' . lang('previous_month', false) . '" href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=' . $view . '&amp;timebegin=' . urlencode(datetime2timestamp($minus_one_month['year'], $minus_one_month['month'], $minus_one_month['day'], 12, 0, 'am')) . $queryStringExtension . '"';
	if ($view != 'month') {
		echo ' onclick="return ChangeCalendar(\'Left\',\'main_littlecalendar.php?view=' . $view . '&amp;littlecal=' . urlencode(datetime2timestamp($minus_one_month['year'], $minus_one_month['month'], $minus_one_month['day'], 12, 0, 'am')) . '&amp;timebegin=' . urlencode($timebegin) . $queryStringExtension . '\');"';
	}
	echo '><b>&laquo;</b></a></div>
<div id="LeftArrowButtonDisabled" class="none"><b>&laquo;</b></div></td>
<td nowrap="nowrap" class="alignCenter"><b>';
	if (($view == 'month' && $showdate['month'] == $month['month'] &&
	 $showdate['year'] == $month['year']) || !$enableViewMonth) {
		echo above_lit_cal_date_format(Month_to_Text_Abbreviation($month['month']), $month['year']);
	}
	else {
		echo '<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=month&amp;timebegin=' . urlencode(datetime2timestamp($month['year'], $month['month'], $month['day'], 12, 0, 'am')) . $queryStringExtension . '">' . above_lit_cal_date_format(Month_to_Text_Abbreviation($month['month']), $month['year']) . '</a>';
	}
	echo '</b></td>
<td width="17" class="alignRight"><div id="RightArrowButton"><a title="' . lang('next_month', false) . '" href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=' . $view . '&amp;timebegin=' . urlencode(datetime2timestamp($plus_one_month['year'], $plus_one_month['month'], $plus_one_month['day'], 12, 0, 'am')) . $queryStringExtension . '"';
	if ($view != 'month') {
		echo ' onclick="return ChangeCalendar(\'Right\',\'main_littlecalendar.php?view=' . $view . '&amp;littlecal=' . urlencode(datetime2timestamp($plus_one_month['year'], $plus_one_month['month'], $plus_one_month['day'], 12, 0, 'am')) . '&amp;timebegin=' . urlencode($timebegin) . $queryStringExtension . '\');"';
	}
	echo '><b>&raquo;</b></a></div>
<div id="RightArrowButtonDisabled" class="none"><b>&raquo;</b></div></td>
</tr></tbody>
</table><!-- #MonthSelector -->';
}
?>