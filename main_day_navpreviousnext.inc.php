<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

$minus_one_day = Add_Delta_Days($showdate['month'], $showdate['day'], $showdate['year'], -1);
$previous_href = 'main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
 '&amp;view=day&amp;timebegin=' . urlencode(datetime2timestamp($minus_one_day['year'],
 $minus_one_day['month'], $minus_one_day['day'], 12, 0, 'am')) . $queryStringExtension;

$plus_one_day = Add_Delta_Days($showdate['month'], $showdate['day'], $showdate['year'], 1);
$next_href = 'main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
 '&amp;view=day&amp;timebegin=' . urlencode(datetime2timestamp($plus_one_day['year'],
 $plus_one_day['month'], $plus_one_day['day'], 12, 0, 'am')) . $queryStringExtension;

echo '
<div><a href="' . $previous_href . '"><b>&laquo;</b> ' . lang('previous_day') . '</a> | <a href="' . $next_href . '">' . lang('next_day') . ' <b>&raquo;</b></a></div>' . "\n";
?>