<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

$previous_href = 'main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
 '&amp;view=week&amp;timebegin=' . urlencode(datetime2timestamp($minus_one_week['year'],
 $minus_one_week['month'], $minus_one_week['day'], 12, 0, 'am')) . $queryStringExtension;

$next_href = 'main.php?calendarid=' .urlencode($_SESSION['CALENDAR_ID']) .
 '&amp;view=week&amp;timebegin=' . urlencode(datetime2timestamp($plus_one_week['year'],
 $plus_one_week['month'], $plus_one_week['day'], 12, 0, 'am')) . $queryStringExtension;

echo '
<div><a href="' . $previous_href . '"><b>&laquo;</b> ' . lang('previous_week') . '</a> | <a href="' . $next_href . '">' . lang('next_week') . ' <b>&raquo;</b></a></div>' . "\n";
?>