<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files
?>

<td id="CalSideCol" width="5%" style="padding-<?php echo mb_strtolower(COLUMNSIDE, 'UTF-8'); ?>:7px;">
<div id="LittleCalendarContainer"><?php
require('main_littlecalendar.php');
?></div>

<form id="JumpToCalendarSelectorForm" action="main.php" method="get">
<?php
if (isset($categoryid) && $categoryid != 0) {
	echo '
<input type="hidden" name="categoryid" value="' . htmlspecialchars($categoryid, ENT_COMPAT, 'UTF-8') . '" />';
}
if (isset($sponsorid) && $sponsorid != 'all') {
	echo '
<input type="hidden" name="sponsorid" value="' . htmlspecialchars($sponsorid, ENT_COMPAT, 'UTF-8') . '" />';
}
if (isset($keyword) && $keyword != '') {
	echo '
<input type="hidden" name="keyword" value="' . htmlspecialchars($keyword, ENT_COMPAT, 'UTF-8') . '" />';
}
?>
<table id="JumpToCalendarSelector" width="100%" border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<td colspan="2"><label for="calendarid"><strong><?php echo lang('calendars'); ?>:</strong></label></td>
</tr><tr>
<td><input type="hidden" name="view" value="<?php echo htmlspecialchars($view, ENT_COMPAT, 'UTF-8'); ?>" />
<?php
echo '<select id="calendarid" name="calendarid" style="width:100%" onchange="document.forms.JumpToCalendarSelectorForm.submit()">' . getCalendarList('select') . '</select>';
?></td>
<td id="JumpToCalendarSelector-ButtonCell"><input type="submit" id="JumpToCalendarSelector-Button" value="Go" class="buttonGo" /></td>
</tr></tbody>
</table><!-- #JumpToCalendarSelector -->
</form>
<?php if (COMBINED_JUMPTO) { ?>
<script type="text/javascript">/* <![CDATA[ */
if (document.getElementById && document.getElementById("JumpToCalendarSelector-ButtonCell")) {
	document.getElementById("JumpToCalendarSelector-ButtonCell").style.display = "none";
}
/* ]]> */</script>
<?php } ?>

<form id="JumpToDateSelectorForm" action="main.php" method="get" onsubmit="return ValidateJumpToDateSelectorForm();">
<input type="hidden" name="view" value="<?php echo 'month'; //htmlspecialchars($view, ENT_COMPAT, 'UTF-8'); ?>" />
<?php
if (isset($categoryid) && $categoryid != 0) {
	echo '
<input type="hidden" name="categoryid" value="' . htmlspecialchars($categoryid, ENT_COMPAT, 'UTF-8') . '" />';
}
if (isset($sponsorid) && $sponsorid != 'all') {
	echo '
<input type="hidden" name="sponsorid" value="' . htmlspecialchars($sponsorid, ENT_COMPAT, 'UTF-8') . '" />';
}
if (isset($keyword) && $keyword != '') {
	echo '
<input type="hidden" name="keyword" value="' . htmlspecialchars($keyword, ENT_COMPAT, 'UTF-8') . '" />';
}
?>
<fieldset>
<table id="JumpToDateSelector" class="<?php echo (COMBINED_JUMPTO ? 'Combined' : 'Split'); ?>" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<?php if (COMBINED_JUMPTO) { ?>
<td><label for="timebegin"><strong><?php echo lang('jump_to'); ?></strong></label></td>
</tr><tr>
<td id="JumpToDateSelectorCombinedRow"><select id="timebegin" name="timebegin" style="width:100%" onchange="if(ValidateJumpToDateSelectorForm()){document.forms.JumpToDateSelectorForm.submit();}">
<?php
	$class = 'even';
	$currentMonth = strtotime('-3 months', mktime(0, 0, 0, intval(date('n', NOW)), 1, intval(date('Y', NOW))));
	for ($i=0; $i < 4+(12*ALLOWED_YEARS_AHEAD); $i++) {
		$currentMonthAsString = date('Y-m-d', $currentMonth);
		if ($i === 0 || (substr($currentMonthAsString, 5, 2) == '01' && $i != 0)) {
			$class = ($class == 'even')? 'odd' : 'even';
			if ($i !== 0) {
				echo '
</optgroup>';
			}
			echo '
<optgroup label="' . date('Y', $currentMonth) . '" class="' . $class . '">';
		}
		echo '
<option value="' . $currentMonthAsString . ' 00:00:00"' . ((substr($currentMonthAsString, 0, 7) == $month['year'] . '-' . sprintf('%02s', $month['month']))? ' selected="selected"' : '') . '>' . Month_to_Text(date('n', $currentMonth)) . ', ' . date('Y', $currentMonth) . '</option>';
			$currentMonth = strtotime('1 month', $currentMonth);
	}
	echo '
</optgroup>';
?>
</select></td>
<?php } else { ?>
<td colspan="2"><label for="timebegin_month"><strong><?php echo lang('jump_to'); ?></strong></label></td>
</tr><tr>
<td><input type="hidden" name="timebegin_day" value="1" />
<select id="timebegin_month" name="timebegin_month">
<?php
	for ($iMonth=1; $iMonth <= 12; $iMonth++) {
		echo '
<option value="' . $iMonth . '"' . (($iMonth == $month['month'])? ' selected="selected"' : '') . '>' . Month_to_Text_Abbreviation($iMonth) . '</option>';
	}
?>
</select></td>
<td><select name="timebegin_year">
<?php
	$currentyear = date('Y', NOW);
	for ($iYear = 1990; $iYear <= $currentyear+ALLOWED_YEARS_AHEAD; $iYear++) {
		echo '
<option' . (($iYear == $month['year'])? ' selected="selected"' : '') . '>' . $iYear . '</option>';
	}
?>
</select></td>
<?php } ?>
<td id="JumpToDateSelector-ButtonCell"><input type="submit" id="JumpToDateSelector-Button" value="Go" class="buttonGo" /></td>
</tr></tbody>
</table><!-- #JumpToDateSelector -->
</fieldset>
</form>
<?php if (COMBINED_JUMPTO) { ?>
<script type="text/javascript">/* <![CDATA[ */
if (document.getElementById && document.getElementById("JumpToDateSelector-ButtonCell")) {
	document.getElementById("JumpToDateSelector-ButtonCell").style.display = "none";
}
/* ]]> */</script>
<?php } ?>

<table id="TodaysDate" width="100%" border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<td><?php
echo lang('today_is') . '<br />' . "\n";
$showtodaylink = 0;
if (!($view == 'day' && $showdate['year'] == $today['year'] &&
 $showdate['month'] == $today['month'] && $showdate['day'] == $today['day'])) {
	$showtodaylink = 1;
}
if ($showtodaylink) {
	echo '<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=day&amp;timebegin=today">';
}
echo '<b>' . today_is_date_format($today['day'], Day_of_Week_Abbreviation(Day_of_Week($today['month'], $today['day'], $today['year'])), Month_to_Text_Abbreviation($today['month']), $today['year']) . '</b>';
if ($showtodaylink) { echo '</a>'; }
?></td>
</tr></tbody>
</table><!-- #TodaysDate -->

<table id="SubscribeLink" width="100%" border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<td><?php
if ($view!='subscribe') {
	echo'<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=subscribe"><b>' . lang('subscribe_download') . '</b></a>';
}
else {
	echo '<b>' . lang('subscribe_download') . '</b>';
}
?></td>
</tr></tbody>
</table><!-- #SubscribeLink -->

<table id="CategoryFilterLink" width="100%" border="0" cellpadding="3" cellspacing="0">
<tbody><tr>
<td><?php
if ($view != 'filter') {
	echo'<a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=filter&amp;oldview=' . urlencode($view) . '"><b>' . lang('filter_events') . '</b></a>';
}
else {
	echo '<b>' . lang('filter_events') . '</b>';
}
?></td>
</tr></tbody>
</table><!-- #CategoryFilterLink -->

</td><!-- #CalSideCol -->
