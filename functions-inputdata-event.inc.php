<?php
function defaultevent(&$event, $sponsorid)
{
	// Set the default date.
	$event['timebegin_year'] = date('Y', NOW);
	$event['timebegin_month'] = 0;
	$event['timebegin_day'] = 0;
	// Set the default begin/end time.
	$event['timebegin_hour'] = 0;
	$event['timebegin_min'] = 0;
	$event['timebegin_ampm'] = 'pm';
	$event['timeend_hour'] = 0;
	$event['timeend_min'] = 0;
	$event['timeend_ampm'] = 'pm';
	// find sponsor name
	$result = DBQuery("
SELECT
	name,
	url
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($sponsorid) . "'
");
	$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	$event['sponsorid'] = $sponsorid;
	$event['title'] = '';
	$event['wholedayevent'] = 0;
	$event['categoryid'] = 0;
	$event['description'] = '';
	$event['location'] = '';
	$event['webmap'] = '';
	$event['price'] = '';
	$event['contact_name'] = '';
	$event['contact_phone'] = '';
	$event['contact_email'] = '';
	$event['displayedsponsor'] = '';
	$event['displayedsponsorurl'] = ''; //$sponsor['url'];
	return 1;
}

function checktime(&$hour, &$min)
{ // checks the validity of the time 1am-12pm or 0:00-23:00
	if (!isset($hour) || !isset($min)) { return false; }
	if (USE_AMPM) { return (($hour > 0 && $hour <= 12) && ($min >= 0 && $min <= 59)); }
	else { return (($hour >= 0 && $hour < 23) && ($min >= 0 && $min <= 59)); }
}

function checkeventdate(&$event, &$repeat)
{
	if (isset($repeat['mode']) && $repeat['mode'] == 0) { // it's a one-time event (no recurrences)
		return (checkdate($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year']));
	}
	else { // it's a recurring event
		return (checkdate($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year']) &&
		 !empty($event['timeend_month']) && !empty($event['timeend_day']) && !empty($event['timeend_year']) &&
		 checkdate($event['timeend_month'], $event['timeend_day'], $event['timeend_year']) &&
		 checkstartenddate($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year'],
		 $event['timeend_month'], $event['timeend_day'], $event['timeend_year']));
	}
}

function checkstartenddate($startdate_month, $startdate_day, $startdate_year,
 $enddate_month, $enddate_day, $enddate_year)
{
	if (strlen($startdate_month) == 1) { $startdate_month = '0' . $startdate_month; }
	if (strlen($startdate_day) == 1) { $startdate_day = '0' . $startdate_day; }
	if (strlen($enddate_month) == 1) { $enddate_month = '0' . $enddate_month; }
	if (strlen($enddate_day) == 1) { $enddate_day = '0' . $enddate_day; }
	$startdate = $startdate_year . $startdate_month . $startdate_day;
	$enddate = $enddate_year . $enddate_month . $enddate_day;
	return $startdate <= $enddate;
}

function checkeventtime(&$event)
{
	// Times are ignored for whole day events.
	if ($event['wholedayevent'] == 1) { return true; }
	if (isset($event['timeend_hour'])) {
		// Fail if the end time is not valid.
		if (!checktime($event['timeend_hour'], $event['timeend_min'])) { return false; }
		// Create two temporary variables to compare times.
		$timebegin = (int)sprintf('%02s%02s', $event['timebegin_hour'] +
		 (($event['timebegin_ampm'] == 'pm' && $event['timebegin_hour'] != 12)? 12 :
		 (($event['timebegin_ampm'] == 'am' && $event['timebegin_hour'] == 12)? (-12) : 0)),
		 $event['timebegin_min']);
		$timeend = (int)sprintf('%02s%02s', $event['timeend_hour'] +
		 (($event['timeend_ampm'] == 'pm' && $event['timeend_hour'] != 12)? 12 :
		 (($event['timeend_ampm'] == 'am' && $event['timeend_hour'] == 12)? (-12) : 0)),
		 $event['timeend_min']);
		// Fail if the beginning time is the same as or after the ending time.
//		echo $timebegin . ' - ' . $timeend; exit;
		if ($timeend === 0) {
			if ($timebegin === 0) { $event['wholedayevent'] = 1; }
			return true;
		}
		if (mb_strtolower($timebegin, 'UTF-8') >= mb_strtolower($timeend, 'UTF-8')) { return false; }
	}
	// Return if the beginning time is valid.
//	echo $timebegin . ' -- ' . $timeend; exit;
	return(checktime($event['timebegin_hour'], $event['timebegin_min']));
}

function checkevent(&$event, &$repeat)
{
	return (!empty($event['title']) && checkeventdate($event, $repeat) &&
	 checkeventtime($event) && $event['categoryid'] >= 1 &&
	 (empty($event['displayedsponsorurl']) || checkURL(urldecode($event['displayedsponsorurl']))) &&
	 ($_SESSION['CALENDAR_ID'] == 'default' || !isset($event['showondefaultcal']) ||
	 $event['showondefaultcal'] == 0 || $event['showincategory'] != 0));
}

function inputrecurrences(&$event, &$repeat, $check)
{ // shows the inputfields for the recurrence information
	$chk = ' checked="checked"';
	$sel = ' selected="selected"';
	if (!isset($repeat['mode'])) { $repeat['mode'] = 0; }
?>
<fieldset><p>
<label for="repeatmode1"><input type="radio" id="repeatmode1" name="repeat[mode]" value="1"<?php echo ($repeat['mode'] == 1)? $chk : ''; ?> /> <?php echo lang('repeat'); ?></label>
<select name="repeat[interval1]" size="1">
<option value="every"<?php echo (isset($repeat['interval1']) && $repeat['interval1'] == 'every')? $sel : ''; ?>><?php echo lang('every', false); ?></option>
<option value="everyother"<?php echo (isset($repeat['interval1']) && $repeat['interval1'] == 'everyother')? $sel : ''; ?>><?php echo lang('every_other', false); ?></option>
<option value="everythird"<?php echo (isset($repeat['interval1']) && $repeat['interval1'] == 'everythird')? $sel : ''; ?>><?php echo lang('every_third', false); ?></option>
<option value="everyfourth"<?php echo (isset($repeat['interval1']) && $repeat['interval1'] == 'everyfourth')? $sel : ''; ?>><?php echo lang('every_fourth', false); ?></option>
</select>
<select name="repeat[frequency1]" size="1">
<option value="day"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'day')? $sel : ''; ?>><?php echo lang('day', false); ?></option>
<option value="week"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'week')? $sel : ''; ?>><?php echo lang('week', false); ?></option>
<option value="month"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'month')? $sel : ''; ?>><?php echo lang('month', false); ?></option>
<option value="year"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'year')? $sel : ''; ?>><?php echo lang('year', false); ?></option>
<option value="sunday"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'sunday')? $sel : ''; ?>><?php echo lang('sun', false); ?></option>
<option value="monday"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'monday')? $sel : ''; ?>><?php echo lang('mon', false); ?></option>
<option value="tuesday"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'tuesday')? $sel : ''; ?>><?php echo lang('tue', false); ?></option>
<option value="wednesday"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'wednesday')? $sel : ''; ?>><?php echo lang('wed', false); ?></option>
<option value="thursday"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'thursday')? $sel : ''; ?>><?php echo lang('thu', false); ?></option>
<option value="friday"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'friday')? $sel : ''; ?>><?php echo lang('fri', false); ?></option>
<option value="saturday"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'saturday')? $sel : ''; ?>><?php echo lang('sat', false); ?></option>
<option value="monwedfri"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'monwedfri')? $sel : ''; ?>><?php echo lang('mon', false) . ', ' . lang('wed', false) . ', ' . lang('fri', false); ?></option>
<option value="tuethu"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'tuethu')? $sel : ''; ?>><?php echo lang('tue', false) . ' &amp; ' . lang('thu', false); ?></option>
<option value="montuewedthufri"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'montuewedthufri')? $sel : ''; ?>><?php echo lang('mon', false) . ' - ' . lang('fri', false); ?></option>
<option value="satsun"<?php echo (isset($repeat['frequency1']) && $repeat['frequency1'] == 'satsun')? $sel : ''; ?>><?php echo lang('sat', false) . ' &amp; ' . lang('sun', false); ?></option>
</select>
</p></fieldset>

<fieldset><p>
<label for="repeatmode2"><input type="radio" id="repeatmode2" name="repeat[mode]" value="2"<?php echo ($repeat['mode'] == 2)? $chk : ''; ?> /> <?php echo lang('repeat_on_the'); ?></label>
<select name="repeat[frequency2modifier1]" size="1">
<option value="first"<?php echo (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1'] == 'first')? $sel : ''; ?>><?php echo lang('first', false); ?></option>
<option value="second"<?php echo (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1'] == 'second')? $sel : ''; ?>><?php echo lang('second', false); ?></option>
<option value="third"<?php echo (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1'] == 'third')? $sel : ''; ?>><?php echo lang('third', false); ?></option>
<option value="fourth"<?php echo (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1'] == 'fourth')? $sel : ''; ?>><?php echo lang('fourth', false); ?></option>
<option value="last"<?php echo (isset($repeat['frequency2modifier1']) && $repeat['frequency2modifier1'] == 'last')? $sel : ''; ?>><?php echo lang('last', false); ?></option>
</select>
<select name="repeat[frequency2modifier2]" size="1">
<option value="sun"<?php echo (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2'] == 'sun')? $sel : ''; ?>><?php echo lang('sun', false); ?></option>
<option value="mon"<?php echo (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2'] == 'mon')? $sel : ''; ?>><?php echo lang('mon', false); ?></option>
<option value="tue"<?php echo (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2'] == 'tue')? $sel : ''; ?>><?php echo lang('tue', false); ?></option>
<option value="wed"<?php echo (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2'] == 'wed')? $sel : ''; ?>><?php echo lang('wed', false); ?></option>
<option value="thu"<?php echo (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2'] == 'thu')? $sel : ''; ?>><?php echo lang('thu', false); ?></option>
<option value="fri"<?php echo (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2'] == 'fri')? $sel : ''; ?>><?php echo lang('fri', false); ?></option>
<option value="sat"<?php echo (isset($repeat['frequency2modifier2']) && $repeat['frequency2modifier2'] == 'sat')? $sel : ''; ?>><?php echo lang('sat', false); ?></option>
</select>
<?php echo lang('of_the_month_every'); ?>
<select name="repeat[interval2]" size="1">
<option value="month"<?php echo (isset($repeat['interval2']) && $repeat['interval2'] == 'month')? $sel : ''; ?>><?php echo lang('month', false); ?></option>
<option value="2months"<?php echo (isset($repeat['interval2']) && $repeat['interval2'] == '2months')? $sel : ''; ?>><?php echo lang('other_month', false); ?></option>
<option value="3months"<?php echo (isset($repeat['interval2']) && $repeat['interval2'] == '3months')? $sel : ''; ?>>3 <?php echo lang('months', false); ?></option>
<option value="4months"<?php echo (isset($repeat['interval2']) && $repeat['interval2'] == '4months')? $sel : ''; ?>>4 <?php echo lang('months', false); ?></option>
<option value="6months"<?php echo (isset($repeat['interval2']) && $repeat['interval2'] == '6months')? $sel : ''; ?>>6 <?php echo lang('months', false); ?></option>
<option value="year"<?php echo (isset($repeat['interval2']) && $repeat['interval2'] == 'year')? $sel : ''; ?>><?php echo lang('year', false); ?></option>
</select>
</p></fieldset>
<?php
	if (isset($check) && $repeat['mode'] > 0) {

		if (!isset($event['timeend_month']) || !isset($event['timeend_day']) ||
		 !isset($event['timeend_year'])) {
			feedback(lang('specify_valid_ending_date'), FEEDBACKNEG);
		}
		elseif (!checkdate($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year']) &&
			!checkdate($event['timeend_month'], $event['timeend_day'], $event['timeend_year'])) {
			feedback(lang('specify_valid_dates'), FEEDBACKNEG);
		}
		elseif (!checkdate($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year'])) {
			feedback(lang('specify_valid_starting_date'), FEEDBACKNEG);
		}
		elseif (!checkdate($event['timeend_month'], $event['timeend_day'], $event['timeend_year'])) {
			feedback(lang('specify_valid_ending_date'), FEEDBACKNEG);
		}
		elseif (!checkstartenddate($event['timebegin_month'], $event['timebegin_day'],
		 $event['timebegin_year'], $event['timeend_month'], $event['timeend_day'], $event['timeend_year'])) {
			feedback(lang('ending_date_after_starting_date'), FEEDBACKNEG);
		}
	}
	echo "\n" . '<fieldset><p>' . "\n" . lang('from') . "\n";
	inputdate($event['timebegin_month'], 'event[timebegin_month]', $event['timebegin_day'],
	 'event[timebegin_day]', $event['timebegin_year'], 'event[timebegin_year]');
	echo "\n" . lang('to') . "\n";
	if (!isset($event['timeend_month']) || !isset($event['timeend_day']) || !isset($event['timeend_year'])) {
		inputdate(0, 'event[timeend_month]', 0, 'event[timeend_day]',
		 $event['timebegin_year'], 'event[timeend_year]');
	}
	else {
		inputdate($event['timeend_month'], 'event[timeend_month]', $event['timeend_day'],
		 'event[timeend_day]', $event['timeend_year'], 'event[timeend_year]');
	}
	echo "\n" . '</p></fieldset>' . "\n";
}

/* print out the event input form and use the provided parameter as preset */
function inputeventdata(&$event, $sponsorid, $inputrequired, $check, $displaydatetime, &$repeat, $copy)
{
	/* now printing the HTML code for the input form */
	$unknownvalue = '???'; /* this is printed when the value of input field is unspecified */
	// the value of the radio box when user chooses recurring event
	$recurring = 10;
	$defaultButtonPressed = (isset($event['defaultdisplayedsponsor']) ||
	 isset($event['defaultdisplayedsponsorurl']) || isset($event['defaultallsponsor']));
	/* read sponsor name from DB
	$result = DBQuery("
SELECT
	name,
	url
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($sponsorid) . "'
");
	$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	*/
	// switch from "recurring event" to "repeat ..."
	if (!isset($repeat['mode'])) { $repeat['mode'] = 0; }
	if ($repeat['mode'] == $recurring) { $repeat['mode'] = 1; }
	if ($displaydatetime) {
	echo '
<div class="FormSectionHeader">
<h3>' . lang('date_and_time_header') . ':</h3>
</div>

<div class="pad">';
		// Do not allow the date/time to be changed if we are logged into the
		// default calendar and the current event is from a different calendar.
		if ($_SESSION['CALENDAR_ID'] == 'default' && isset($event['showondefaultcal']) &&
		 $event['showondefaultcal'] == '1' && (!isset($copy) || $copy != 1)) {
			passeventtimevalues($event, $repeat);
			// Output the basic date/time information.
			echo '<p>' . Day_of_Week_to_Text(Day_of_Week($event['timebegin_month'],
			 $event['timebegin_day'], $event['timebegin_year'])) . ', ' .
			 substr(Month_to_Text($event['timebegin_month']), 0, 3) . ' ' .
			 $event['timebegin_day'] . ', ' . $event['timebegin_year'] . ' -- ';
			if ($event['wholedayevent'] == 0) {
				echo timestring($event['timebegin_hour'], $event['timebegin_min'], $event['timebegin_ampm']);
				if (endingtime_specified($event)) { // event has an explicit ending time
					echo ' - ' . timestring($event['timeend_hour'],
					 $event['timeend_min'], $event['timeend_ampm']);
				}
			}
			else {
				echo lang('all_day');
			}
			// Output additional re-occurring event information.
			if (!empty($event['repeatid'])) {
				echo '<br / >' . "\n" . '<span class="txtInfo">';
				readinrepeat($event['repeatid'], $event, $repeat);
				$repeatdef = repeatinput2repeatdef($event, $repeat);
				printrecurrence($event['timebegin_year'],
					$event['timebegin_month'],
					$event['timebegin_day'],
					$repeatdef);
				echo '</span>';
			}
			echo '</p>' . "\n";
		}
		else {
			// Otherwise, allow the date/time to be edited.
			echo '
<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>
<td><strong>' . lang('date') . ':</strong>' . (($inputrequired)? '<span class="txtWarn">*</span>' : '') . '</td>
<td>';
			if ($inputrequired && $check && $repeat['mode'] == 0 &&
			 !checkeventdate($event, $repeat) && !$defaultButtonPressed) {
				feedback(lang('date_invalid'), FEEDBACKNEG);
			}
			echo '<label for="onetime"><input type="radio" id="onetime" name="repeat[mode]" value="0"';
			if ($repeat['mode'] == 0) { echo ' checked="checked"'; }
			echo ' onclick="this.form.submit()" /> ' . lang('one_time_event') . '</label>';
			if ($repeat['mode'] == 0) {
				if (!isset($event['timebegin_month'])) { $event['timebegin_month'] = 0; }
				if (!isset($event['timebegin_day'])) { $event['timebegin_day'] = 0; }
				if (!isset($event['timebegin_year'])) { $event['timebegin_year'] = 0; }
				inputdate($event['timebegin_month'], 'event[timebegin_month]', $event['timebegin_day'],
				 'event[timebegin_day]', $event['timebegin_year'], 'event[timebegin_year]');
				echo '<br />
<label for="recurringevent"><input type="radio" id="recurringevent" name="repeat[mode]" value="' . $recurring . '" onclick="this.form.submit()" /> ' . lang('recurring_event') . '</label><br />' . "\n";
			}
			elseif ($repeat['mode'] == 1 || $repeat['mode'] == 2) {
				echo '<br />' . "\n";
				inputrecurrences($event, $repeat, $check);
			}
			echo '</td>

</tr><tr>

<td><strong>' .  lang('time') . ':</strong>' . (($inputrequired)? '<span class="txtWarn">*</span>' : '') . '</td>
<td>';
			if ($inputrequired && $check && !$defaultButtonPressed && $event['wholedayevent'] == 0) {
				if (!isset($event['timebegin_hour']) || $event['timebegin_hour'] == 0) {
					feedback(lang('specify_all_day_or_starting_time'), FEEDBACKNEG);
				}
				elseif (!checkeventtime($event)) {
					feedback(lang('warning_ending_time_before_starting_time'), FEEDBACKNEG);
				}
			}
			echo '
<label for="alldayevent"><input type="radio" id="alldayevent" name="event[wholedayevent]" value="1"' . (($event['wholedayevent'] == 1)? ' checked="checked"' : '') . ' /> ' . lang('all_day_event') . '</label><br />
<label for="timedevent"><input type="radio" id="timedevent" name="event[wholedayevent]" value="0"' . (($event['wholedayevent'] == 0)? ' checked="checked"' : '') . ' /> ' . lang('timed_event') . ': ' . lang('from') . '</label>
<select name="event[timebegin_hour]" size="1" onchange="setRadioButton(\'timedevent\',true);">';
			if (!isset($event['timebegin_hour']) || $event['timebegin_hour'] == 0) {
//				echo '
//<option value="0" selected="selected">' . $unknownvalue . '</option>';
				if (USE_AMPM) {
					$event['timebegin_hour'] = 12;
					$event['timebegin_ampm'] = 'am';
				}
				else {
					$event['timebegin_hour'] = 0;
				}
			}
			// print list with hours and select the one read from the DB
			if (USE_AMPM) {
				$start_hour = 1;
				$end_hour = 12;
			}
			else {
				$start_hour = 0;
				$end_hour = 23;
			}
			for ($i=$start_hour; $i <= $end_hour; $i++) {
				echo '
<option value="' . $i . '"' . ((isset($event['timebegin_hour']) && $event['timebegin_hour'] == $i)? ' selected="selected"' : '') . '>' . $i . '</option>';
			}
			echo '</select> <b>:</b> <select name="event[timebegin_min]" size="1" onclick="setRadioButton(\'timedevent\',true);">';
			// print list with minutes and select the one read from the DB
			for ($i=0; $i <= 55; $i+=5) {
				echo '
<option value="' . $i . '"' . ((isset($event['timebegin_min']) && $event['timebegin_min'] == $i)? ' selected="selected"' : '') . '>' . (($i < 10)? '0' : '') . $i . '</option>';
			}
			echo '</select>' . "\n";
			if (USE_AMPM) {
				echo '
<select name="event[timebegin_ampm]" size="1" onclick="setRadioButton(\'timedevent\',true);">
<option value="am"' . ((isset($event['timebegin_ampm']) && $event['timebegin_ampm'] == 'am')? ' selected="selected"' : '') . '>am</option>
<option value="pm"' . ((isset($event['timebegin_ampm']) && $event['timebegin_ampm'] == 'pm')? ' selected="selected"' : '') . '>pm</option>
</select>' . "\n";
			}
			// print list with hours and select the one read from the DB
			if (!endingtime_specified($event)) { $event['timeend_hour'] = 0; }
			if (USE_AMPM) {
				$start_hour = 1;
				$end_hour = 12;
			}
			else {
				$start_hour = 0;
				$end_hour = 23;
			}
			echo lang('to') . '
<select name="event[timeend_hour]" size="1" onclick="setRadioButton(\'timedevent\',true);">
<option value="0"' . ((isset($event['timeend_hour']) && $event['timeend_hour'] == 0)? ' selected="selected"' : '') . '>' . $unknownvalue . '</option>';
			for ($i=$start_hour; $i <= $end_hour; $i++) {
				echo '
<option value="' . $i . '"' . ((isset($event['timeend_hour']) && $event['timeend_hour'] == $i)? ' selected="selected"' : '') . '>' . $i . '</option>';
			}
			echo '
</select>
<b>:</b>
<select name="event[timeend_min]" size="1" onclick="setRadioButton(\'timedevent\',true);">';
			// print list with minutes and select the one read from the DB
			for ($i=0; $i <= 55; $i+=5) {
				echo '
<option value="' . $i . '"' . ((isset($event['timeend_min']) && $event['timeend_min'] == $i)? ' selected="selected"' : '') . '>' . (($i < 10)? '0' : '') . $i . '</option>';
			}
			echo '
</select>';
			if (USE_AMPM) {
				echo '
<select name="event[timeend_ampm]" size="1" onclick="setRadioButton(\'timedevent\',true);">
<option value="am"' . ((isset($event['timeend_ampm']) && $event['timeend_ampm'] == 'am')? ' selected="selected"' : '') . '>am</option>
<option value="pm"' . ((isset($event['timeend_ampm']) && $event['timeend_ampm'] == 'pm')? ' selected="selected"' : '') . '>pm</option>
</select>';
			}
			echo '<br />
<i>' . lang('ending_time_not_required') . '</i></td>
</tr></tbody>
</table>';
		}
		echo '</div>' . "\n";
	}
	echo '
<div class="FormSectionHeader">
<h3>' . lang('basic_event_info_header') . ':</h3>
</div>

<div class="pad"><table border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<td nowrap="nowrap"><label for="eventcategoryid"><strong>' . lang('category') . ':</strong></label>' . (($inputrequired)? ' <span class="txtWarn">*</span>' : '') . '</td>
<td>';
	if ($inputrequired && $check && $event['categoryid'] == 0 && !$defaultButtonPressed) {
		feedback(lang('choose_category'), FEEDBACKNEG);
	}
	// read event categories from DB
	$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	name ASC
");
	// print list with categories and select the one read from the DB
	echo '
<select id="eventcategoryid" name="event[categoryid]" size="1">';
	if ($event['categoryid'] == 0) {
		echo '
<option value="0" selected="selected">' . $unknownvalue . '</option>';
	}
	for ($i=0; $i < $result->numRows(); $i++) {
		$category = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo '
<option value="' . htmlspecialchars($category['id'], ENT_COMPAT, 'UTF-8') . '"' . ((isset($event['categoryid']) && $event['categoryid'] == $category['id'])? ' selected="selected"' : '') . '>' . htmlspecialchars($category['name'], ENT_COMPAT, 'UTF-8') . '</option>';
	}
	echo '
</select><br />
' . lang('category_description') . '</td>

</tr><tr>

<td><label for="eventtitle"><strong>' . lang('title') . ':</strong></label>' . (($inputrequired)? '<span class="txtWarn">*</span>' : '') . '</td>
<td>';
	if ($inputrequired && $check && empty($event['title']) && !$defaultButtonPressed) {
		feedback(lang('choose_title'), FEEDBACKNEG);
	}
	echo '
<input type="text" id="eventtitle" name="event[title]" value="';
	if (isset($event['title'])) {
		//if ($check) { $event['title'] = $event['title']; }
		echo HTMLSpecialChars($event['title']);
	}
	echo '" size="24" maxlength="' . MAXLENGTH_TITLE . '" /><br />
' . lang('title_description') . '</td>

</tr><tr>

<td><label for="Description_Box"><strong>' . lang('description') .':</strong></label></td>
<td>
<textarea id="Description_Box" name="event[description]" rows="10" cols="60" onkeyup="UpdateDescriptionLength()" onchange="if(typeof(tinymce)==\'undefined\'){UpdateDescriptionLength();}" class="tinymce">';
	if (isset($event['description'])) {
		//if ($check) { $event['description'] = $event['description']; }
		echo HTMLSpecialChars($event['description']);
	}
	echo '</textarea><br />
' . str_replace('@@MAXLENGTH_DESCRIPTION@@', MAXLENGTH_DESCRIPTION, lang('description_description')) . '
<script type="text/javascript">/* <![CDATA[ */
function UpdateDescriptionLength()
{
	if (typeof(tinymce) == "undefined" && document.getElementById) {
		var textbox = document.getElementById("Description_Box");
		var current = document.getElementById("Description_CurrentChars");
		if (textbox && current) { current.innerHTML = textbox.value.length; }
	}
}
if (document.getElementById) {
	var container = document.getElementById("Description_CharLine");
	if (typeof(tinymce) == "undefined" && container) { container.style.display = ""; }
}
if (typeof(tinymce) == "undefined") { UpdateDescriptionLength(); }
/* ]]> */</script>
</td>
</tr></tbody>
</table></div>

<div class="FormSectionHeader">
<h3>' . lang('additional_event_info_header') . ':</h3>
</div>

<div class="pad"><table border="0" cellspacing="0" cellpadding="3">
<tbody><tr>

<td nowrap="nowrap"><label for="eventlocation"><strong>' . lang('location') . ':</strong></label></td>
<td><input type="text" id="eventlocation" name="event[location]" value="';
	if (isset($event['location'])) {
		//if ($check) { $event['location'] = $event['location']; }
		echo HTMLSpecialChars($event['location']);
	}
	echo '" size="60" maxlength="' . MAXLENGTH_LOCATION . '" /><br />
' . lang('location_description') . '</td>

</tr><tr>

<td nowrap="nowrap"><label for="eventwebmap"><strong>' . lang('webmap') . ':</strong></label></td>
<td><input type="text" id="eventwebmap" name="event[webmap]" value="';
	if (isset($event['webmap'])) {
		//if ($check) { $event['webmap'] = $event['webmap']; }
		echo HTMLSpecialChars($event['webmap']);
	}
	echo '" size="60" maxlength="' . MAXLENGTH_WEBMAP . '" /><br />
' . lang('webmap_description') . '</td>

</tr><tr>

<td nowrap="nowrap"><label for="eventprice"><strong>' . lang('price') . ':</strong></label></td>
<td><input type="text" id="eventprice" name="event[price]" value="';
	if (isset($event['price'])) {
		//if ($check) { $event['price'] = $event['price']; }
		echo HTMLSpecialChars($event['price']);
	}
	echo '" size="24" maxlength="' . MAXLENGTH_PRICE . '" /><br />
' . lang('price_description') . '</td>

</tr><tr>

<td nowrap="nowrap"><label for="eventcontact_name"><strong>' . lang('contact_name') . ':</strong></label></td>
<td><input type="text" id="eventcontact_name" name="event[contact_name]" value="';
	if (isset($event['contact_name'])) {
		//if ($check) { $event['contact_name'] = $event['contact_name']; }
		echo HTMLSpecialChars($event['contact_name']);
	}
	echo '" size="24" maxlength="' . MAXLENGTH_CONTACT_NAME . '" /><br />
' . lang('contact_name_description') . '</td>

</tr><tr>

<td nowrap="nowrap"><label for="eventcontact_phone"><strong>' . lang('contact_phone') . ':</strong></label></td>
<td><input type="text" id="eventcontact_phone" name="event[contact_phone]" value="';
	if (isset($event['contact_phone'])) {
		//if ($check) { $event['contact_phone'] = $event['contact_phone']; }
		echo HTMLSpecialChars($event['contact_phone']);
	}
	echo '" size="24" maxlength="' . MAXLENGTH_CONTACT_PHONE . '" /><br />
' . lang('contact_phone_description') . '</td>

</tr><tr>

<td><label for="eventcontact_email"><strong>' . lang('contact_email') . ':</strong></label></td>
<td><input type="text" id="eventcontact_email" name="event[contact_email]" value="';
	if (isset($event['contact_email'])) {
		//if ($check) { $event['contact_email'] = $event['contact_email']; }
		echo HTMLSpecialChars(urldecode($event['contact_email']));
	}
	echo '" size="24" maxlength="' . MAXLENGTH_EMAIL . '" /><br />
' . lang('contact_email_description') . '</td>

</tr></tbody>
</table></div>';
	if (!$_SESSION['AUTH_ISCALENDARADMIN']) {
		// Not actually submitted since it has no "name" attribute.
		// The point of this is to allow the "Restore default" buttons to work properly.
		echo '<input type="hidden" id="selectedsponsorid" value="' . $event['sponsorid'] . '" />';
	}
	else {
		echo '
<div class="FormSectionHeader">
<h3>' . lang('event_owner_info_header') . ':</h3>
<p>' . lang('event_owner_info_description') . '</p>
</div>

<div class="pad"><table border="0" cellspacing="0" cellpadding="3">
<tbody><tr>' . "\n";
		if ($_SESSION['CALENDAR_ID'] == 'default' && isset($event['showondefaultcal']) &&
		 $event['showondefaultcal'] == '1' && (!isset($copy) || $copy != 1)) {
			echo '
<td><strong>' . lang('sponsor') . ':</strong></td>
<td><input type="hidden" id="selectedsponsorid" name="event[sponsorid]" value="' . $event['sponsorid'] . '" />
<input type="hidden" name="event[showondefaultcal]" value="' . $event['showondefaultcal'] . '" />
<input type="hidden" name="event[showincategory]" value="' . $event['showincategory'] . '" />
<p>' . htmlspecialchars(getSponsorName($event['sponsorid']), ENT_COMPAT, 'UTF-8') . ' (' . lang('calendar') . ': &quot;' . htmlspecialchars(getSponsorCalendarName($event['sponsorid']), ENT_COMPAT, 'UTF-8') . '&quot;)</p></td>';
		}
		else {
			// read sponsors from DB
			$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	name ASC
");
			// print list with sponsors and select the one read from the DB
			echo '
<td><label for="selectedsponsorid"><strong>' . lang('sponsor') . ':</strong></label></td>
<td><select id="selectedsponsorid" name="event[sponsorid]" size="1">';
			for ($i=0; $i < $result->numRows(); $i++) {
				$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
				echo '
<option value="' . htmlspecialchars($sponsor['id'], ENT_COMPAT, 'UTF-8') . '"' . (($event['sponsorid'] == $sponsor['id'])? ' selected="selected"' : '') . '>' . htmlspecialchars($sponsor['name'], ENT_COMPAT, 'UTF-8') . '</option>';
			}
			echo '
</select></td>';
		}
		echo '

</tr></tbody>
</table></div>';
	}
	echo '
<div class="FormSectionHeader">
<h3>' . lang('event_sponsor_info_header') . ':</h3>
<p>' . lang('event_sponsor_info_description') . '</p>
</div>

<div class="pad"><table border="0" cellspacing="0" cellpadding="3">
<tbody><tr>

<td><label for="defaultsponsornametext"><strong>' . lang('displayed_sponsor_name') . ':</strong></label></td>
<td><input type="text" id="defaultsponsornametext" name="event[displayedsponsor]" value="';
	if (isset($event['displayedsponsor'])) {
		//if ($check) { $event['displayedsponsor'] = $event['displayedsponsor']; }
		echo HTMLSpecialChars($event['displayedsponsor']);
	}
	echo '" size="50" maxlength="' . MAXLENGTH_DISPLAYEDSPONSOR . '" />
<input type="submit" id="defaultsponsornamebutton" name="event[defaultdisplayedsponsor]" value="' . lang('button_restore_default', false) . '" onclick="return SetSponsorDefault(1);" /></td>

</tr><tr>

<td><label for="defaultsponsorurltext"><strong>' . lang('sponsor_page_web_address') . ':</strong></label></td>
<td>';
	if ($check && isset($event['displayedsponsorurl']) &&
	 !checkURL($event['displayedsponsorurl']) && !$defaultButtonPressed) {
		feedback(lang('url_invalid'), FEEDBACKNEG);
	}
	echo '
<input type="text" id="defaultsponsorurltext" name="event[displayedsponsorurl]" value="';
	if (isset($event['displayedsponsorurl'])) {
		//if ($check) { $event['displayedsponsorurl'] = $event['displayedsponsorurl']; }
		echo HTMLSpecialChars($event['displayedsponsorurl']);
	}
	echo '" size="50" maxlength="' . MAXLENGTH_DISPLAYEDSPONSORURL . '" />
<input type="submit" id="defaultsponsorurlbutton" name="event[defaultdisplayedsponsorurl]" value="' . lang('button_restore_default', false) . '" onclick="return SetSponsorDefault(2);" /></td>

</tr></tbody>
</table></div>';
	if ($_SESSION['CALENDAR_ID'] != 'default' && $inputrequired) {
		$defaultcalendarname = getCalendarName('default');
		// read event categories from DB
		$result = DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='default'
ORDER BY
	name ASC
");
		echo '
<div class="FormSectionHeader">
<h3>' . str_replace('DEFAULTCALENDARNAME', $defaultcalendarname, lang('submit_to_default_calendar_header')) . ':</h3>
<p>' . str_replace('DEFAULTCALENDARNAME', $defaultcalendarname, lang('submit_to_default_calendar_description')) . '</p>
</div>

<div class="pad"><table border="0" cellspacing="0" cellpadding="0">
<tbody><tr>

<td><input type="checkbox" id="eventshowondefaultcal" name="event[showondefaultcal]" value="1"' . (((isset($event['showondefaultcal']) && $event['showondefaultcal'] == '1') || isset($event['showondefaultcal']) && $_SESSION['CALENDAR_FORWARD_EVENT_BY_DEFAULT'] == '1')? ' checked="checked"' : '') . ' /></td>
<td><table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>
<td><label for="eventshowondefaultcal">' . lang('submit_to_default_calendar_text') . ':</label></td>
</tr><tr>
<td><select name="event[showincategory]" size="1">';
		// print list with categories and select the one read from the DB
		if (empty($event['showincategory'])) {
			echo '
<option value="0" selected="selected">' . $unknownvalue . '</option>';
		}
		for ($i=0; $i < $result->numRows(); $i++) {
			$category = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo '
<option value="' . htmlspecialchars($category['id'], ENT_COMPAT, 'UTF-8') . '"' . ((!empty($event['showincategory']) && $event['showincategory'] == $category['id'])? ' selected="selected"' : '') . '>' . htmlspecialchars($category['name'], ENT_COMPAT, 'UTF-8') . '</option>';
		}
		echo '
</select></td>

</tr>';
		if ($check && !empty($event['showondefaultcal']) && $event['showondefaultcal'] == 1 &&
		 (empty($event['showincategory']) || $event['showincategory'] == 0) && !$defaultButtonPressed) {
			echo '<tr>' . "\n" . '<td>';
			feedback(lang('choose_category'), FEEDBACKNEG);
			echo '</td>' . "\n" . '</tr>';
		}
		echo '</tbody>
</table></td>

</tr></tbody>
</table></div>';
	}
	echo '
<input type="hidden" name="check" value="1" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">/* <![CDATA[ */
$(document).ready(function() {
	$("textarea.tinymce").tinymce({
		// Location of TinyMCE script
		script_url: "scripts/tiny_mce/tiny_mce.js",

		// Specify current document language
		language: "' . lang('lang') . '",

		// General options
		theme: "advanced",
		plugins: "safari,pagebreak,style,table,advhr,advimage,advlink," +
		 "emotions,iespell,inlinepopups,insertdatetime,media,searchreplace," +
		 "contextmenu,paste,directionality,fullscreen,noneditable,visualchars," +
		 "nonbreaking,xhtmlxtras",

		// Theme options
		theme_advanced_buttons1: "fullscreen,visualaid,|,search,replace,|," +
		 "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,bold,italic,underline," +
		 "strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|," +
		 "bullist,numlist,outdent,indent,|,backcolor,forecolor",
		theme_advanced_buttons2: "formatselect,fontselect,fontsizeselect,attribs," +
		 "styleprops,|,sub,sup,|,charmap,emotions,iespell,media,advhr,hr,|,link," +
		 "unlink,anchor,image,cleanup,removeformat,code",
		theme_advanced_buttons3: "tablecontrols,|,blockquote,cite,abbr,acronym,del,ins,|," +
		 "ltr,rtl,|,visualchars,nonbreaking,|,insertdate,inserttime,|,help",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align: "left",
		theme_advanced_statusbar_location: "bottom",
		theme_advanced_resizing: true,

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url: "lists/link_list.js",
		//external_image_list_url: "lists/image_list.js",
		//media_external_list_url: "lists/media_list.js",

		// Replace values for the template plugin
		//template_replace_values: { username: "Some User", staffid: "991234" }
	});
});
/* ]]> */</script>
';
	return 1;
}
?>