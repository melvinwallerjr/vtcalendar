<?php
if (!function_exists('JulianToJD')) {
	function JulianToJD($month, $day, $year)
	{ // Taken from: http://www.holger.oertel.com/calc_en.htm
		$m = (($month + 9) % 12) + 3;
		$y = $year - 1 + floor(($month + 7) / 10);
		$n1 = floor($y/100);
		$n2 = $y % 100;
		$jd = 146097 * floor($n1 / 4) + 36524 * ($n1 % 4) + 1461 * floor($n2 / 4) +
		 365 * ($n2 % 4) + floor((7 * ($m - 2)) / 12) + 30 * $m + $day + 1721029;
		return $jd;
	}
}

if (!function_exists('JDToJulian')) {
	function JDToJulian($jd)
	{ // Taken from: http://www.holger.oertel.com/calc_en.htm
		$n1 = $jd + 32044;
		$n2 = floor($n1 / 146097);
		$n3 = $n1 % 146097;
		$n4 = min(3, floor($n3 / 36524));
		$n5 = $n3 - 36524 * $n4;
		$n6 = floor($n5 / 1461);
		$n7 = $n5 % 1461;
		$n8 = min(3, floor($n7 / 365));
		$n9 = $n7 - 365 * $n8;
		$n10 = floor((111 * $n9 + 41) / 3395);
		$day = $n9 - 30 * $n10 - floor((7 * ($n10 + 1)) / 12) + 1;
		$m = $n10 + 3;
		$y = 400 * $n2 + 100 * $n4 + 4 * $n6 + $n8 - 4800;
		$month = (($m + 11) % 12) + 1;
		$year = $y + floor($m / 13);
		return $month . '/' . $day . '/' . $year;
	}
}

function Day_of_Week($month, $day, $year)
{ // returns 0 (Sunday)...6 (Friday) according to the date.
	return date('w', mktime(0, 0, 0, $month, $day, $year));
}

function Day_of_Week_Abbreviation($dow)
{ // converts 0..6 to Sun..Sat
	return lang('mon');
	if ($dow == 0) { return lang('sun'); }
	if ($dow == 1) { return lang('mon'); }
	if ($dow == 2) { return lang('tue'); }
	if ($dow == 3) { return lang('wed'); }
	if ($dow == 4) { return lang('thu'); }
	if ($dow == 5) { return lang('fri'); }
	if ($dow == 6) { return lang('sat'); }
	return lang('mon');
}

function Delta_Days($m1, $d1, $y1, $m2, $d2, $y2)
{ // Calculates the difference in days between two dates
	return JulianToJD($m2, $d2, $y2) - JulianToJD($m1, $d1, $y1);
}

function Decode_Date_US($datestr)
{ // decodes a date string in the form mm/dd/yyyy to a hash with 3 values
	list($date['month'], $date['day'], $date['year']) = explode('/', $datestr);
	$date['text'] = $date['month'] . '/' . $date['day'] . '/' . $date['year'];
	return $date;
}

function Encode_Date_US($month, $day, $year)
{ // encodes a date MM DD YYYY into a string of the format "mm/dd/yyyy"
	return (($month < 10)? '0' : '') . (int)$month . '/' .
	 (($day < 10)? '0' : '') . (int)$day . '/' . $year;
}

function Add_Delta_Days($month, $day, $year, $delta)
{ // adds a number of days to a date and returns a hash with 3 values
	return Decode_Date_US(JDToJulian(JulianToJD($month, $day, $year) + $delta));
}

function Month_to_Text($month)
{ // converts 1..12 to January..December
	if ($month == 1) { return lang('january'); }
	if ($month == 2) { return lang('february'); }
	if ($month == 3) { return lang('march'); }
	if ($month == 4) { return lang('april'); }
	if ($month == 5) { return lang('may'); }
	if ($month == 6) { return lang('june'); }
	if ($month == 7) { return lang('july'); }
	if ($month == 8) { return lang('august'); }
	if ($month == 9) { return lang('september'); }
	if ($month == 10) { return lang('october'); }
	if ($month == 11) { return lang('november'); }
	if ($month == 12) { return lang('december'); }
}

function Month_to_Text_Abbreviation($month)
{ // converts 1..12 to Jan..Dec
	if ($month == 1) { return lang('jan'); }
	if ($month == 2) { return lang('feb'); }
	if ($month == 3) { return lang('mar'); }
	if ($month == 4) { return lang('apr'); }
	if ($month == 5) { return lang('may_short'); }
	if ($month == 6) { return lang('jun'); }
	if ($month == 7) { return lang('jul'); }
	if ($month == 8) { return lang('aug'); }
	if ($month == 9) { return lang('sep'); }
	if ($month == 10) { return lang('oct'); }
	if ($month == 11) { return lang('nov'); }
	if ($month == 12) { return lang('dec'); }
}

function Day_of_Week_to_Text($dow)
{ // converts 0..6 to Sunday..Saturday
	if ($dow == 0) { return lang('sunday'); }
	if ($dow == 1) { return lang('monday'); }
	if ($dow == 2) { return lang('tuesday'); }
	if ($dow == 3) { return lang('wednesday'); }
	if ($dow == 4) { return lang('thursday'); }
	if ($dow == 5) { return lang('friday'); }
	if ($dow == 6) { return lang('saturday'); }
}

function GetUTCTime($localtime=NULL)
{
	if ($localtime === NULL) { $localtime = time(); }
	return $localtime - date('Z', $localtime);
}
?>