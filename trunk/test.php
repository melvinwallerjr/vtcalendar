<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Test</title>
<style type="text/css">
.CalTable {
	border-collapse: collapse;
}
.CalTable td {
	font-family: "Courier New", Courier, mono;
	font-size: 13px;
	border: 1px solid #999999;
}
.CalTable .MonthTitle {
	background-color: #DDDDDD;
}
.CalTable .OtherMonthDays {
	background-color: #EEEEEE;
}
</style>
</head>

<body>

<?php
require_once("languages/en.inc.php");
require_once("functions.inc.php");
require_once("class-vtdate.inc.php");
require_once("class-vtdaterepeater.inc.php");

echo "<pre>\n";

//echo date("c", strtotime("2 month -2 day", mktime(0, 0, 0, 1, 1, 2008)));

//echo vtDateRepeater::_determineDaysForDOWIncrement(0, 1, -2);

echo "</pre>";

echo "<table class='CalTable' border='0' cellpadding='2' cellspacing='0'>\n";
DrawCalendar(2008, 1);
DrawCalendar(2008, 2);
DrawCalendar(2008, 3);
echo "</table>";

function DrawCalendar($year, $month, $hideOtherMonths = true, $noTableTags = true) {
	$dowstart = 0;
	
	// Determine the first and last day of the month
	$firstDay = new vtDate($year, $month, 1);
	$lastDay = new vtDate($firstDay->getYear(), $firstDay->getMonth(), $firstDay->getDaysInMonth());
	
	// Determine the first day displayed on the calendar.
	// This may be part of the last or current month.
	$firstDisplayDay =& $firstDay->getWeekStartDate($dowstart);
	
	// Determine the last day displayed on the calendar.
	// This may be part of the current or next month.
	$lastDisplayDay =& $lastDay->getWeekEndDate($dowstart);
	
	$displayDays = $lastDisplayDay->getDayDiff($firstDisplayDay);
	
	//echo $firstDisplayDay->getDateStamp() . "\n";
	//echo $lastDisplayDay->getDateStamp() . "\n";
	//echo $displayDays . "\n";
	
	if (!$noTableTags)
		echo "<table class='CalTable' border='0' cellpadding='2' cellspacing='0'>\n";
	
	echo '<tr><td align="center" colspan="7" class="MonthTitle">' . $firstDay->format("%F") . '</td></tr>';
	
	// Week Day Names
	echo "<tr>\n";
	for ($i = 0; $i < 7; $i++) {
		echo "<td align='center'>" . vtDate::format("%D", strtotime("+".$i." days", $firstDisplayDay->getEpoch())) . "</td>\n";
	}
	echo "</tr>\n";
	
	$currentDay =& $firstDisplayDay->copy();
	for ($i = 0; $i <= $displayDays; $i++) {
		if ($i % 7 == 0) {
			echo "<tr>";
		}
		
		if ($currentDay->getMonth() != $firstDay->getMonth()) {
			echo "<td align='center' class='OtherMonthDays'>";
		}
		else {
			echo "<td align='center'>";
		}
		
		if ($hideOtherMonths && ($currentDay->getYear() != $year || $currentDay->getMonth() != $month)) {
			echo "&nbsp;";
		}
		else {
			echo $currentDay->format("%j");
		}
		
		echo "</td>";
		
		if ($i != 0 && ($i + 1) % 7 == 0) {
			echo "</tr>\n";
		}
		
		$currentDay->add("1 day");
	}
	
	if (!$noTableTags)
		echo "</table>\n";
}



?><pre><?php

$repeater = new vtDateRepeater("E 20090101 20090201 0 S 1"); //;I 20080101 20090101 E D;I 20070101 20090101 1 S 12");
$date = new vtDate(2008, 1, 1);
$repeater->reset();
//$repeater->_moveToNextDate(0, $date);
echo "New Date: " . $date->format("%c");

?></pre>
</body>
</html>