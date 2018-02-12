<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

$previous_href = 'main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
 '&amp;view=month&amp;timebegin=' . urlencode(datetime2timestamp($minus_one_month['year'],
 $minus_one_month['month'], $minus_one_month['day'], 12, 0, 'am')) . $queryStringExtension;

$next_href = 'main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
 '&amp;view=month&amp;timebegin=' . urlencode(datetime2timestamp($plus_one_month['year'],
 $plus_one_month['month'], $plus_one_month['day'], 12, 0, 'am')) . $queryStringExtension;

echo '
<div><a href="' . $previous_href . '"><b>&laquo;</b> ' . lang('previous_month') . '</a> | <a href="' . $next_href . '">' . lang('next_month') . ' <b>&raquo;</b></a></div>' . "\n";
?>